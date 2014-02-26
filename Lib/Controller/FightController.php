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
	
		if (!isset($_SESSION['monster']) || empty($_SESSION['monster'])) {
			Session::setFlashMessage('danger', 'Aucun combat en cours');
			Utils::redirect( Router::generateUrl('map.index') );
		}

		$this->monster = unserialize($_SESSION['monster']);

		$game = unserialize($_SESSION['current_game']);
		$this->character = $game->getCharacter();
	}

	public function __destruct()
	{
		if ($this->character != null) {
			// Sauvegarde personnage
			$game = unserialize($_SESSION['current_game']);
			$game->setCharacter( $this->character );
			$_SESSION['current_game'] = serialize($game);
		}

		if ($this->monster != null) {
			// Sauvegarde monstres
			$_SESSION['monster'] = serialize($this->monster);
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
			$damageDealed  = max(0, $attacker->getStrength() - ($opponent->getResistance() * 1.5)); // force - (resistance * 1.5)
		}
		else {
			// Calcule des dommages standard
			$damageDealed  = max(0, $attacker->getStrength() - $opponent->getResistance());
		}
		
		// Application des dommages
		$opponent->setHealth(max(0, $opponent->getHealth() - $damageDealed));

		// Prochain tour
		$attacker->setRound('0');
		$opponent->setRound('1');

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
     * Action : attack
     */
	public function attackAction()
	{
		$this->attack($this->character, $this->monster);

		Utils::redirect( Router::generateUrl('fight.index') );
	}

	public function continueAction()
	{
		$this->attack($this->monster, $this->character);

		Utils::redirect( Router::generateUrl('fight.index') );
	}

	/**
     * Action : index
     */
	public function indexAction()
	{
		// Début du combat, calcul du premier attaquant en fonction de la plus haute vitesse
		if ($this->character->getRound() == 0 && $this->monster->getRound() == 0)
		{
			$speedCompare = $this->character->getSpeed() - $this->monster->getSpeed();

			// Si monstre plus rapide
			if ($speedCompare < 0) {
				$this->monster->setRound('1');
				$_SESSION['fight_log'] = $this->monster->getName() . " est le premier à attaquer !";
			}
			else {
				$this->character->setRound('1');
				$_SESSION['fight_log'] = "Vous êtes le premier à attaquer !";
			}
		}
		else if (!isset($_SESSION['fight_log']))
		{
			if ($this->character->getRound() == 1) {
				$_SESSION['fight_log'] = 'A vous d\'attaquer !';
			}
			else {
				$_SESSION['fight_log'] = 'A l\'ennemi d\'attaquer !';
			}
		}

		// Ajout des données pour la vue
		$this->setVar('monster', $this->monster);
		$this->setVar('character', $this->character);
		
		// Vérification des points de vie des deux combattants
		if ($this->monster->getHealth() == 0)
		{
			$game = unserialize($_SESSION['current_game']);

			/**
			 * Suppression du monstre de la partie chargée en session
			 */

			$monsters = $game->getMap()->getMonsters(); // Récupération des monstres
			$game->getMap()->setMonsters( array() );    // Suppression de la liste des monstre actuelle

			foreach ($monsters as $monster) {
				// Si ce n'est pas le monstre mort : ajout à la map
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
			$game->getCharacter()->setRound(0);

			// +5 de vie
			$game->getCharacter()->setHealth( min($this->character->getHealth() + 5, $this->character->getHealth_max()) );

			// Sauvegarde
			Manager::getManagerOf('playing_character')->save($game->getCharacter());

			// Sérialisation de la partie
			$_SESSION['current_game'] = serialize($game);

			// Petit msg
			$_SESSION['fight_log'] = "<b>YOU WIN !!!</b>";

			// Fin du combat
			unset($_SESSION['monster']);
			$this->monster = null; // Pour ne pas re-sérializer en session
			unset($_SESSION['character']);
			$this->character = null; // Pour ne pas re-sérializer en session

			// Fin
			$this->setVar('end', true);
		}
		else if ($this->character->getHealth() == 0)
		{
			$_SESSION['fight_log'] = "<b>GAME OVER !!!</b>";

			// Fin
			$this->setVar('end', true);
		}

		// Ajout des infos de comat pour la vue
		$this->setVar('fight_log', $_SESSION['fight_log']);
		unset($_SESSION['fight_log']);

		// Chargement de la vue
		$this->fetch('/Fight/index.php');
	}

	/**
     * Action : defense
     */
	/*public function defense($attacker, $opponent)
	{
		$attacker->setPosture('0');

		$attacker->setRound('0');
		$opponent->setRound('1');

		$heroName  = unserialize($_SESSION['data']['perso']);

		if($attacker->getName() == $heroName->getName())
		{
			$_SESSION['data']['perso'] = serialize($attacker);
			$_SESSION['data']['frog'] = serialize($opponent);
		}
		else
		{
			$_SESSION['data']['frog'] = serialize($attacker);
			$_SESSION['data']['perso'] = serialize($opponent);
		}

		return $attacker->getName() . " défend !";
	}*/
}