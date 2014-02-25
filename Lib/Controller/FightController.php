<?php

namespace Lib\Controller;

use Lib\Application;
use Lib\Router;
use Lib\Utils;

use Lib\Perso\CrazyfrogPersonnage as Crazyfrog;
use Lib\Perso\RabivadorPersonnage as Rabivador;

class FightController extends Controller
{
	protected $perso;
	protected $monster;

	public function __construct(Application $app)
	{
		parent::__construct($app);
	
		if (!isset($_SESSION['data']['monster'])) {
			Utils::redirect( Router::generateUrl('map.index') );
		}

		// Récupération des deux objets Personnage et Crazyfrog
		if (isset($_SESSION['data']) && !empty($_SESSION['data'])) {
			$this->perso   = unserialize($_SESSION['data']['perso']);
			$this->monster = unserialize($_SESSION['data']['monster']);
		}
		else {
			$this->perso   = new Guillaume();
			$this->monster = new Crazyfrog();
		}
	}

	public function __destruct()
	{
		// Sauvegarde des données
		$_SESSION['data'] = array(
			'perso'   => serialize($this->perso),
			'monster' => serialize($this->monster)
		);
	}

	/**
     * Action : speedCompare
     */
	protected function speedCompare($player, $monster)
	{
		$speedCompare = $player->getSpeed() - $monster->getSpeed();

		if ($speedCompare < 0)
		{
			$monster->setRound('1');
			return $monster->getName() . " est le premier à attaquer !";
		}
		else
		{
			$player->setRound('1');
			return $player->getName() . " est le premier à attaquer !";
		}
	}

	/**
     * Action : attack
     */
	protected function attack($attacker, $opponent)
	{
		if($attacker->getPosture() == 0)
		{
			$attacker->setPosture('1');
		}

		if($opponent->getPosture() == 0)
		{
			$damageDealed  = $attacker->getStrength() - $opponent->getResistance() * 1.5;
		}
		else
		{
			$damageDealed  = $attacker->getStrength() - $opponent->getResistance();
		}

		if($damageDealed < 0)
		{
			$damageDealed = 0;
		}
		
		$remainingLife = $opponent->getHealth() - $damageDealed;

		if($remainingLife < 0)
		{
			$remainingLife = 0;
		}

		$opponent->setHealth($remainingLife);

		$messageLog = $attacker->getName() . " inflige " . $damageDealed . " points de dégats !";

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

		return $messageLog;
		
	}

	/**
     * Action : index
     */
	public function indexAction()
	{
		// Début du combat, calcul du premier attaquant en fonction de la plus haute vitesse
		if ($this->perso->getRound() == 0 && $this->monster->getRound() == 0)
		{
			$_SESSION['messageLog']['speed'] = $this->speedCompare($this->perso, $this->monster);
			Utils::redirect( Router::generateUrl('fight.index') );
		}
		
		// Vérification des points de vie des deux combattants
		if ($this->monster->getHealth() == 0)
		{
			//echo "YOU WIN";
		}
		else if ($this->perso->getHealth() == 0)
		{
			//echo "YOU LOOSE";
		}
		else
		{
			if ($this->monster->getRound() == 1)
			{
				$_SESSION['messageLog']['receive'] = $this->attack($this->monster, $this->perso);
	
				Utils::redirect( Router::generateUrl('fight.index') );
			}
			else if ($this->perso->getRound() == 1)
			{
				$_SESSION['messageLog']['attack'] = $this->attack($this->perso, $this->monster);
				Utils::redirect( Router::generateUrl('fight.index') );
			}
		}

		$perso   = $this->perso;
		$monster = $this->monster;

		include __DIR__.'/../View/Fight/index.php';
	}

	/**
     * Action : defense
     */
	public function defense($attacker, $opponent)
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
	}
}