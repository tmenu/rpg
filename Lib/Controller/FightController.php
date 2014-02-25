<?php

namespace Lib\Controller;

use Lib\Application;
use Lib\Router;
use Lib\Utils;

use Lib\Perso\CrazyfrogPersonnage as Crazyfrog;
use Lib\Perso\RabivadorPersonnage as Rabivador;

class FightController extends Controller
{
	/**
     * Action : index
     */

	public function indexAction()
	{

		// Récupération des deux objets Personnage et Crazyfrog
		$hero  = unserialize($_SESSION['data']['perso']);
		$enemy = unserialize($_SESSION['data']['frog']);

		// Début du combat, calcul du premier attaquant en fonction de la plus haute vitesse
		if($hero->getRound() == 0 && $enemy->getRound() == 0)
		{
			$_SESSION['messageLog']['speed'] = $this->speedCompareAction($hero, $enemy);
			Utils::redirect( Router::generateUrl('fight.index') );
		}
		
		// Vérification des points de vie des deux combattants
		if($enemy->getHealth() == 0)
		{
			echo "YOU WIN";
		}
		else if($hero->getHealth() == 0)
		{
			echo "YOU LOOSE";
		}
		else
		{
			if($enemy->getRound() == 1)
			{
				$_SESSION['messageLog']['receive'] = $this->attackAction($enemy, $hero);
	
				Utils::redirect( Router::generateUrl('fight.index') );
			}
			else if($hero->getRound() == 1)
			{
				$_SESSION['messageLog']['attack'] = $this->attackAction($hero, $enemy);
				Utils::redirect( Router::generateUrl('fight.index') );
			}
		}

		include __DIR__.'/../View/Fight/index.php';
	}

	/**
     * Action : attack
     */

	public function attackAction($attacker, $opponent)
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
     * Action : defense
     */

	public function defenseAction($attacker, $opponent)
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

	/**
     * Action : speedCompare
     */

	public function speedCompareAction($player, $monster)
	{
		$speedCompare = $player->getSpeed() - $monster->getSpeed();

		if($speedCompare < 0)
		{

			$monster->setRound('1');
			$_SESSION['data']['frog'] = serialize($monster);
			return $monster->getName() . " est le premier à attaquer !";
		}
		else
		{
			$player->setRound('1');
			$_SESSION['data']['perso'] = serialize($player);
			return $player->getName() . " est le premier à attaquer !";
		}


	}
}