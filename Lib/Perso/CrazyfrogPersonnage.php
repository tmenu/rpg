<?php

namespace Lib\Perso;

class CrazyfrogPersonnage extends Personnage
{
	public function __construct()
	{
		$this->setRef('rabivador');
		$this->setHealth('15');
		$this->setStrength('9');
		$this->setResistance('5');
		$this->setSpeed('6');
		$this->setPosture('1');
		$this->setName('Faiblo Ludo');
		$this->setRound('0');
	}
}