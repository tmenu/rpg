<?php

namespace Lib\Perso;

class GuillaumePersonnage extends Personnage
{
	public function __construct()
	{
		$this->type = 'mage01';

		$this->position = array(
			'x' => 0,
			'y' => 0
		);
		
		$this->direction = 'down';

		// STATS
		$this->setHealth('20');
		$this->setStrength('10');
		$this->setResistance('8');
		$this->setSpeed('6');
		$this->setPosture('1');
		$this->setName('Guillaume');
		$this->setRound('0');
	}
}