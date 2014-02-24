<?php

namespace Lib\Controller;

use Lib\Application;
use Lib\Router;
use Lib\Utils;

use Lib\Map\Map;
use Lib\Map\DefaultMap;

use Lib\Perso\GuillaumePersonnage as Guillaume;

class MapController extends Controller
{
	protected $map;

	public function __construct(Application $app)
	{
		parent::__construct($app);

		// Récupération des données
		if (isset($_SESSION['data']) && !empty($_SESSION['data'])) {
			$this->perso = unserialize($_SESSION['data']['perso']);
			$this->map   = unserialize($_SESSION['data']['map']);
		}
		else {
			$this->perso = new Guillaume();
			$this->map   = new DefaultMap();
		}
	}

	public function __destruct()
	{
		$_SESSION['data'] = array(
			'perso' => serialize($this->perso),
			'map'   => serialize($this->map)
		);
	}

	public function indexAction()
	{
		$perso = $this->perso;
		$map   = $this->map;

		//var_dump($map);

		include __DIR__.'/../View/Map/index.php';
	}

	public function moveUpAction()
	{
		$this->perso->setDirection('up');

		$position = $this->perso->getPosition();

		$y = $position['y'] - 1;

		// Si on reste sur la map
		if ($y >= 0) {
			$map = $this->map->getMap();

			// Si on peut aller sur la case
			if ($map[ $y ][ $position['x'] ] & Map::GROUND) {
				$position['y'] = $y;
				$this->perso->setPosition($position);
			}
		}

		Utils::redirect( Router::generateUrl('map.index') );
	}

	public function moveDownAction()
	{
		$this->perso->setDirection('down');

		$position = $this->perso->getPosition();

		$y = $position['y'] + 1;

		// Si on reste sur la map
		if ($y < $this->map->getHeight()) {
			$map = $this->map->getMap();

			// Si on peut aller sur la case
			if ($map[ $y ][ $position['x'] ] & Map::GROUND) {
				$position['y'] = $y;
				$this->perso->setPosition($position);
			}
		}

		Utils::redirect( Router::generateUrl('map.index') );
	}

	public function moveLeftAction()
	{
		$this->perso->setDirection('left');

		$position = $this->perso->getPosition();

		$x = $position['x'] - 1;

		// Si on reste sur la map
		if ($x >= 0) {
			$map = $this->map->getMap();

			// Si on peut aller sur la case
			if ($map[ $position['y'] ][ $x ] & Map::GROUND) {
				$position['x'] = $x;
				$this->perso->setPosition($position);
			}
		}

		Utils::redirect( Router::generateUrl('map.index') );
	}

	public function moveRightAction()
	{
		$this->perso->setDirection('right');

		$position = $this->perso->getPosition();

		$x = $position['x'] + 1;

		// Si on reste sur la map
		if ($x >= 0) {
			$map = $this->map->getMap();

			// Si on peut aller sur la case
			if ($map[ $position['y'] ][ $x ] & Map::GROUND) {
				$position['x'] = $x;
				$this->perso->setPosition($position);
			}
		}

		Utils::redirect( Router::generateUrl('map.index') );
	}
}