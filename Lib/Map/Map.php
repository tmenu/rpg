<?php

namespace Lib\Map;

use Lib\Perso\Personnage;

abstract class Map
{
	protected $width;
	protected $height;

	protected $map = array();
	protected $monster = array();

	CONST WALL   = 0x01;
	CONST GROUND = 0x02;
	CONST ENTRY  = 0x04;
	CONST OUT    = 0x08;

	public function getHeight() { 
		return $this->height;
	}

	public function getWidth() { 
		return $this->width;
	}

	public function getMap() {
		return $this->map;
	}

	public function addMonster(Personnage $monster) {
		$this->monster[] = $monster;

		return $this;
	}

	public function getMonsters() {
		return $this->monster;
	}
}