<?php

namespace Lib\Perso;

class GuillaumePersonnage extends Personnage
{
	public function __construct()
	{
		$this->setName('Guillaume');

		$this->setHealth('77.2');
		$this->setStrength('10');
		$this->setResistance('5');
		$this->setSpeed('5');
		$this->setPosture('1');
		$this->setRound('0');

		$this->setRef('mage01');

		$this->setPosition(array(
			'x' => 0,
			'y' => 0
		));
		
		$this->setDirection('down');
	}
}