<?php

namespace Lib\Controller;

use Lib\Application;
use Lib\Router;
use Lib\Utils;
use Lib\Manager;
use Lib\Session;

use Lib\Entity\Character;

class FightController extends Controller
{
	protected $character = null;
	protected $monster = null;

	public function __construct(Application $app)
	{
		parent::__construct($app);
	
		if (!isset($_SESSION['current_fight']) || empty($_SESSION['current_fight'])) {
			Session::setFlashMessage('danger', 'Aucun combat en cours');
			Utils::redirect( Router::generateUrl('map.index') );
		}

		// Récupération du combat
		$fight = unserialize($_SESSION['current_fight']);

		$this->monster   = $fight['monster'];
		$this->character = $fight['character'];
	}

	public function __destruct()
	{
		if ($this->character != null) {
			// Sauvegarde personnage
			$fight = unserialize($_SESSION['current_fight']);

			$fight['character'] = $this->character;

			$_SESSION['current_fight'] = serialize($fight);
		}

		if ($this->monster != null) {
			// Sauvegarde monstres
			$fight = unserialize($_SESSION['current_fight']);

			$fight['monster'] = $this->monster;

			$_SESSION['current_fight'] = serialize($fight);
		}
	}

	protected function attack($attacker, $opponent)
	{
		// Si le perso est en défense 
		if ($attacker->getPosture() == Character::DEFENSE) {
			// On le passe en attaque
			$attacker->setPosture(Character::ATTACK);
		}

		// Si le monstre est en défense
		if ($opponent->getPosture() == Character::DEFENSE) {
			// Calcule des dommages minorés
			$damageDealed  = round(max(0, ($attacker->getStrength() / 2) - (($opponent->getResistance() / 4) * 1.5))); // force / 2 - ( (resistance / 4) * 1.5)

		}
		else {
			// Calcule des dommages standard
			$damageDealed  = round(max(0,($attacker->getStrength() / 2) - (($opponent->getResistance() / 4)))); 		// force / 2 - resistance / 4
		}

		// Test d'esquive
		$dodgingPercentage = 100 - ( (1 + $opponent->getSpeed()) / ($attacker->getSpeed() + 1) * 10 );

		if($dodgingPercentage < 50)
			$dodgingPercentage = 50;
		
		$randomNumber = rand(0, 100);

		if (get_class($attacker) == 'Lib\\Entity\\Character') {
			if($randomNumber < $dodgingPercentage)
			{
				// Application des dommages
				$opponent->setHealth(max(0, $opponent->getHealth() - $damageDealed));
				$_SESSION['fight_log'] = 'Vous infligez <b>' . $damageDealed . '</b> de dégât à l\'ennemi';
			}
			else
			{
				$_SESSION['fight_log'] = 'L\'ennemi esquive votre attaque';
			}

			Manager::getManagerOf('playing_character')->save( $attacker );
			Manager::getManagerOf('playing_monster')->save( $opponent );
		}
		else {
			if($randomNumber < $dodgingPercentage)
			{
				// Application des dommages
				$opponent->setHealth(max(0, $opponent->getHealth() - $damageDealed));
				$_SESSION['fight_log'] = 'L\'ennemi vous inflige <b>' . $damageDealed . '</b> de dégât';
			}
			else
			{
				$_SESSION['fight_log'] = 'Vous esquivez l\'attaque';
			}

			Manager::getManagerOf('playing_monster')->save( $attacker );
			Manager::getManagerOf('playing_character')->save( $opponent );
		}

		// Prochain tour
		$attacker->setRound('0');
		$opponent->setRound('1');
	}

	/**
     * Action : attack
     */
	public function attackAction()
	{
		// Si c'est au tour du perso
		if ($this->character->getRound() == 1) {
			$this->attack($this->character, $this->monster);
		}
		else if ($this->monster->getRound() == 1) {
			$this->attack($this->monster, $this->character);
		}

		if (isset($_GET['isAjax'])) {
			$this->indexAction();
		}
		else {
			Utils::redirect( Router::generateUrl('fight.index') );
		}
	}

	protected function defense($attacker, $opponent)
	{
		// Prochain tour pour l'adversaire
		$attacker->setRound('0');
		$opponent->setRound('1');

		$attacker->setPosture(Character::DEFENSE);

		if (get_class($attacker) == 'Lib\\Entity\\Character') {
			Manager::getManagerOf('playing_character')->save( $attacker );
			Manager::getManagerOf('playing_monster')->save( $opponent );

			$_SESSION['fight_log'] = 'Vous infligez <b>' . $damageDealed . '</b> de dégât à l\'ennemi';
		}
		else {
			Manager::getManagerOf('playing_monster')->save( $attacker );
			Manager::getManagerOf('playing_character')->save( $opponent );

			$_SESSION['fight_log'] = 'L\'ennemi vous inflige <b>' . $damageDealed . '</b> de dégât';
		}
	}

	/**
     * Action : defense
     */
	public function defenseAction()
	{
		$this->defense($this->character, $this->monster);

		Utils::redirect( Router::generateUrl('fight.index') );
	}

	/**
     * Action : index
     */
	public function indexAction()
	{
		// Début du combat (round 0 0)
		if ($this->character->getRound() == 0 && $this->monster->getRound() == 0)
		{
			// Détermination du premier attaquant en fonction de la plus haute vitesse
			if ($this->monster->getSpeed() > $this->character->getSpeed())
			{
				$this->monster->setRound('1');
				Manager::getManagerOf('playing_monster')->save($this->monster);

				$_SESSION['fight_log'] = $this->monster->getName() . " est le premier à attaquer !";
			}
			else
			{
				$this->character->setRound('1');
				Manager::getManagerOf('playing_character')->save($this->character);

				$_SESSION['fight_log'] = "Vous êtes le premier à attaquer !";
			}
		}
		else if (!isset($_SESSION['fight_log'])) // Si aucun message (partie venant d'être chargé)
		{
			if ($this->character->getRound() == 1) {
				$_SESSION['fight_log'] = 'A vous d\'attaquer !';
			}
			else if ($this->monster->getRound() == 1){
				$_SESSION['fight_log'] = 'A l\'ennemi d\'attaquer !';
			}
		}

		// Ajout des données pour la vue
		$this->setVar('monster',   clone $this->monster);
		$this->setVar('character', clone $this->character);

		// Si le monstre est mort
		if ($this->monster->getHealth() == 0)
		{
			$game = unserialize($_SESSION['current_game']);

			/**
			 * Suppression du monstre de la partie chargée en session
			 */

			$monsters = $game->getMap()->getMonsters(); // Récupération des monstres
			$game->getMap()->setMonsters( array() );    // Suppression de la liste des monstre actuelle

			// Réaffectation des monstre en ignorant celui qui est mort
			foreach ($monsters as $monster) {
				if ($monster->getId() != $this->monster->getId()) {
					$game->getMap()->addMonster( $monster );
				}
			}

			/**
			 * Supression du monstre de la map de la bdd
			 */
			Manager::getManagerOf('playing_monster')->delete( $this->monster->getId() );
			Manager::getManagerOf('playing_map_monster')->deleteByMonster( $this->monster->getId() );

			/**
			 * Evolution du perso
			 */
			$game->getCharacter()->setRound(0); // Remise a 0

			// +5 de vie (cadeau)
			$game->getCharacter()->setHealth( min($this->character->getHealth() + 5, $this->character->getHealth_max()) );

			// Sauvegarde
			Manager::getManagerOf('playing_character')->save($game->getCharacter());

			// Sérialisation de la partie
			$_SESSION['current_game'] = serialize($game);

			// Petit msg
			$_SESSION['fight_log'] = "<b>YOU WIN !!!</b><br />Vous récupérez 5 de santé";

			// Fin du combat
			unset($_SESSION['current_fight']);
			
			// Pour ne pas re-sérializer en session
			$this->monster = null;
			$this->character = null;       
		}
		else if ($this->character->getHealth() == 0)
		{
			$game = unserialize($_SESSION['current_game']);

			// Si le perso à encore une vie
			if ($this->character->getLife() > 1)
			{
				/**
				 * Reset de la position d'origine sur la map et de la vie du personnage
				 */
				$game->getCharacter()->setHealth( $game->getCharacter()->getHealth_max() );
				$game->getCharacter()->setPosition_x( 0 );
				$game->getCharacter()->setPosition_y( 0 );
				$game->getCharacter()->setDirection( 'DOWN' );
				$game->getCharacter()->setLife( $game->getCharacter()->getLife() - 1 );

				$game->getMap()->setOrigin_x( 0 );
				$game->getMap()->setOrigin_y( 0 );

				// Sauvegarde
				Manager::getManagerOf('playing_character')->save($game->getCharacter());
				Manager::getManagerOf('playing_map')->save($game->getMap());

				/** Reset santé du monstre **/
				$this->monster->setHealth( $this->monster->getHealth_max() );
				Manager::getManagerOf('playing_monster')->save($this->monster);

				// Sérialisation de la partie
				$_SESSION['current_game'] = serialize($game);

				// Petit msg
				$_SESSION['fight_log'] = "<b>GAME OVER !!!</b><br />Vous perdez une vie";

				// Fin du combat
				unset($_SESSION['current_fight']);

				// Pour ne pas re-sérializer en session
				$this->monster = null;
				$this->character = null; 
			}
			else
			{
				// Récupération de la partie à supprimer
				$game = Manager::getManagerOf('game')->select( $game->getId() );

				// Les monstres liés à la map
				$map_monsters = Manager::getManagerOf('playing_map_monster')->selectByMap( $game->getRef_map() );

				/**
				 * Supression de la partie et de toute ces données
				 */
				Manager::getManagerOf('game')->delete( $game->getId() );
				Manager::getManagerOf('playing_character')->delete( $game->getRef_character() );
				Manager::getManagerOf('playing_map')->delete( $game->getRef_map() );

				foreach ($map_monsters as $monster)
				{
					Manager::getManagerOf('playing_map_monster')->delete( $monster->getId() );
					Manager::getManagerOf('playing_monster')->delete( $monster->getRef_monster() );
				}

				// Supprime la mprtie en cours
				unset($_SESSION['current_game']);
				unset($_SESSION['fight']);
				
				// Petit msg
				$_SESSION['fight_log'] = "<b>GAME OVER !!!</b><br />La partie est finie !";

				// Fin du combat
				unset($_SESSION['current_fight']);

				// Pour ne pas re-sérializer en session
				$this->monster = null;
				$this->character = null; 

				$_SESSION['game_over'] = true;
			}
		}

		$this->setVar('fight_log', $_SESSION['fight_log']);
		unset($_SESSION['fight_log']);

		// Chargement de la vue
		if (isset($_GET['isAjax'])) {
			echo json_encode(array(
				'battle' => $this->fetchView('/Fight/index.php')
			));
			return;
		}
		else {
			$this->fetch('/Fight/index.php');
		}
	}
}