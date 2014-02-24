<?php

namespace Lib;

session_start();

use Lib\Controller as Controller;

class Application
{
	protected $map;

	CONST WALL   = 0x01;
	CONST GROUND = 0x02;
	CONST ENTRY  = 0x04;
	CONST OUT    = 0x08;

	CONST PERSO  = 0x16;

	public function __construct()
	{
		$this->map = array(
			array(self::ENTRY | self::GROUND | self::PERSO,  self::WALL,  self::GROUND, self::GROUND, self::GROUND, self::WALL),
			array(self::GROUND, self::WALL,   self::GROUND, self::WALL,   self::GROUND, self::WALL),
			array(self::GROUND, self::GROUND, self::GROUND, self::WALL,   self::GROUND, self::WALL),
			array(self::GROUND, self::WALL,   self::WALL,   self::WALL,   self::GROUND, self::GROUND),
			array(self::GROUND, self::GROUND, self::GROUND, self::WALL,   self::WALL,   self::GROUND),
			array(self::WALL,   self::WALL,   self::GROUND, self::WALL,   self::GROUND, self::OUT | self::GROUND),
		);
	}

	public function run()
	{
		if (!isset($_GET['controller'])) {
			$_GET['controller'] = 'map';
		}

		if (!isset($_GET['action'])) {
			$_GET['action'] = 'index';
		}

		switch ($_GET['controller'])
		{
			case 'map':

				$map_controller = new Controller\MapController($this);

				$method_action = ucfirst(mb_strtolower($_GET['action'])) . 'Action';

				if (!method_exists($map_controller, $method_action)) {
					throw new \Exception('Method "' . $method_action . '" doesn\'t exists');
				}

				$map_controller->$method_action();

			break;

			case 'fight':

				$fight_controller = new Controller\FightController($this);

				$method_action = ucfirst(mb_strtolower($_GET['action'])) . 'Action';

				if (!method_exists($fight_controller, $method_action)) {
					throw new \Exception('Method "' . $method_action . '" doesn\'t exists');
				}

				$fight_controller->$method_action();

			break;

			default:
				echo '404';
		}
	}

	public function getMap() {
		return $this->map;
	}
}