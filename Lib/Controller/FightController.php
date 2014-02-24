<?php

namespace Lib\Controller;

use Lib\Perso\CrazyfrogPersonnage as Crazyfrog;
use Lib\Perso\RabivadorPersonnage as Rabivador;

class FightController extends Controller
{
	/**
     * Action : index
     */

	public function indexAction()
	{

		$rabbit = new Rabivador();
		$rabbit->setHealth('20');
		$rabbit->setStrength('10');
		$rabbit->setResistance('9');
		$rabbit->setSpeed('5');
		$rabbit->setPosture('1');
		$rabbit->setName('Rabivador');
		$rabbit->setRound('0');

		$ludo = new Crazyfrog();
		$ludo->setHealth('15');
		$ludo->setStrength('8');
		$ludo->setResistance('5');
		$ludo->setSpeed('6');
		$ludo->setPosture('1');
		$ludo->setName('Faiblo Ludo');
		$ludo->setRound('0');

		if($rabbit->getRound() == 0 && $ludo->getRound() == 0)
		{
			$_SESSION['messageLog'] = $this->speedCompareAction($rabbit, $ludo);
		}
		else if($ludo->getRound() == 1)
		{
			$_SESSION['messageLog'] = $this->attackAction($ludo, $rabbit);
		}
		else
		{
			$_SESSION['messageLog'] = $this->attackAction($rabbit, $ludo);
		}
		include __DIR__.'/../View/Fight/index.php';
	}

	/**
     * Action : attack
     */

	public function attackAction($attacker, $defender)
	{
		if($attacker->getPosture() == 0)
		{
			$attacker->setPosture('1');
		}

		if($defender->getPosture() == 0)
		{
			$damageDealed  = $attacker->getStrength() - $defender->getResistance() * 1.5;
		}
		else
		{
			$damageDealed  = $attacker->getStrength() - $defender->getResistance();
		}

		if($damageDealed < 0)
		{
			$damageDealed = 0;
		}
		
		$remainingLife = $defender->getHealth() - $damageDealed;

		$defender->setHealth($remainingLife);

		$messageLog = $attacker->getName() . " inflige" . $damageDealed . " points de dégats !";

		$attacker->setRound('0');
		$defender->setRound('1');

		$_SESSION['messageLog'] = $messageLog;
		
	}

	/**
     * Action : defense
     */

	public function defenseAction($attacker)
	{
		$attacker->setPosture('0');

		$attacker->setRound('0');
		$defender->setRound('1');
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
			return $monster->getName() . " est le premier à attaquer !";
		}
		else
		{
			$player->setRound('1');
			return $player->getName() . " est le premier à attaquer !";
		}
	}
}