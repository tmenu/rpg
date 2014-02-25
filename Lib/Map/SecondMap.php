<?php

namespace Lib\Map;

use Lib\Map\Map;

use Lib\Perso\RabivadorPersonnage as Rabivador;
use Lib\Perso\CrazyfrogPersonnage as Crazyfrog;

class SecondMap extends Map
{
	public function __construct()
	{
		$this->setSize( array('width' => 12, 'height' => 12) );

		// Création de la map
		$this->setMap(array(
			array(self::GROUND, self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::GROUND, self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::GROUND, self::GROUND), 
			array(self::GROUND, self::GROUND, self::WALL,   self::GROUND, self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::WALL,   self::WALL,   self::WALL,   self::GROUND), 
			array(self::GROUND, self::GROUND, self::WALL,   self::GROUND, self::WALL,   self::WALL,   self::WALL,   self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::GROUND), 
			array(self::WALL,   self::GROUND, self::WALL,   self::GROUND, self::GROUND, self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::WALL,   self::WALL,   self::WALL), 
			array(self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::WALL,   self::WALL,   self::GROUND, self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::GROUND), 
			array(self::GROUND, self::GROUND, self::GROUND, self::GROUND, self::WALL,   self::WALL,   self::GROUND, self::WALL,   self::WALL,   self::GROUND, self::WALL,   self::WALL), 
			array(self::GROUND, self::WALL,   self::WALL,   self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::GROUND, self::WALL,   self::WALL,   self::GROUND, self::WALL), 
			array(self::GROUND, self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::WALL,   self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::GROUND, self::GROUND), 
			array(self::GROUND, self::WALL,   self::GROUND, self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::GROUND, self::WALL,   self::WALL,   self::GROUND, self::GROUND), 
			array(self::GROUND, self::WALL,   self::GROUND, self::WALL,   self::GROUND, self::WALL,   self::WALL,   self::WALL,   self::WALL,   self::WALL,   self::WALL,   self::GROUND), 
			array(self::GROUND, self::WALL,   self::GROUND, self::WALL,   self::GROUND, self::WALL,   self::GROUND, self::GROUND, self::WALL,   self::WALL,   self::GROUND, self::GROUND), 
			array(self::GROUND, self::GROUND, self::GROUND, self::WALL,   self::GROUND, self::WALL,   self::WALL,   self::GROUND, self::GROUND, self::GROUND, self::GROUND, self::GROUND) 
		));

		// Création des monstres

		/*$monster = new Rabivador();
		$monster->setPosition(array('x' => 2, 'y' => 2));
		$monster->setDirection('left');
		$this->addMonster($monster);

		$monster = new Crazyfrog();
		$monster->setPosition(array('x' => 4, 'y' => 3));
		$monster->setDirection('up');
		$this->addMonster($monster);*/
	}
}