<?php

namespace Lib\Controller;

use Lib\Perso\CrazyfrogPersonnage as Crazyfrog;
use Lib\Perso\RabivadorPersonnage as Rabivador;

class FightController extends Controller
{
	public function indexAction()
	{
		$rabbit = new Rabivador();
		$rabbit->setHealth('20');
		$rabbit->setStrength('10');
		$rabbit->setResistance('9');
		$rabbit->setSpeed('5');
		$rabbit->setPosture('1');

		$ludo = new Crazyfrog();
		$ludo->setHealth('15');
		$ludo->setStrength('8');
		$ludo->setResistance('5');
		$ludo->setSpeed('2');
		$ludo->setPosture('1');

		$defense = $this->defenseAction($ludo);

		echo "Ludo défend<br />";

		$attack = $this->attackAction($rabbit, $ludo);

		echo "Rabbit fait " . $attack['damageDealed'] . " points de dégats <br />";
		echo "Il reste " . $attack['remainingLife'] . " points de vie à Ludo<br />";

		$attack =$this->attackAction($ludo, $rabbit);

		echo "Ludo fait " . $attack['damageDealed'] . " points de dégats <br />";
		echo "Il reste " . $attack['remainingLife'] . " points de vie à Rabbit";
	}

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

		return array('damageDealed' => $damageDealed, 'remainingLife' => $remainingLife);
	}

	public function defenseAction($attacker)
	{
		$attacker->setPosture('0');
	}
}