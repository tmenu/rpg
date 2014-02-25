<?php

namespace Lib\Map;

use Lib\Perso\Personnage;

abstract class Map
{
	// Taille de la plateforme
	protected $size = array(
		'width'  => 6,
		'height' => 6
	);

	// Dimensions visible
	protected $visible = array(
		'x' => 6,
		'y' => 6
	);

	// Position du coin supérieur gauche
	protected $origin = array(
		'x' => 0,
		'y' => 0
	);

	protected $map     = array();  // Données de la map
	protected $monsters = array(); // Monstre sur la map

	// Type de cases
	CONST WALL   = 0x01; // Mur : accés impossible
	CONST GROUND = 0x02; // Sol : accès possible
	CONST ENTRY  = 0x04; // Entrée de la map
	CONST OUT    = 0x08; // Sortie de la map


	public function getSize() { 
		return $this->size;
	}

	public function setSize(array $size) { 
		$this->size = $size;

		return $this;
	}

	public function getOrigin() { 
		return $this->origin;
	}

	public function setOrigin(array $origin) { 
		$this->origin = $origin;

		return $this;
	}

	public function getVisible() { 
		return $this->visible;
	}

	public function setVisible(array $visible) { 
		$this->visible = $visible;

		return $this;
	}

	public function getMap() {
		return $this->map;
	}

	public function setMap(array $map) { 
		$this->map = $map;

		return $this;
	}

	public function getMonsters() {
		return $this->monsters;
	}

	public function setMonsters(array $monsters) { 
		$this->monsters = $monsters;

		return $this;
	}

	public function addMonster(Personnage $monster) {
		$this->monsters[] = $monster;

		return $this;
	}
}