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
	}
}