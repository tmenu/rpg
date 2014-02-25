<?php

namespace Lib\Controller;

use Lib\Application;
use Lib\Router;
use Lib\Utils;

use Lib\Map\Map;
use Lib\Map\DefaultMap;
use Lib\Map\SecondMap;

use Lib\Perso\GuillaumePersonnage as Guillaume;
use Lib\Perso\CrazyfrogPersonnage as Crazyfrog;

class MapController extends Controller
{
	protected $map;
	protected $perso;

	public function __construct(Application $app)
	{
		parent::__construct($app);

		// S'il existe un monstre
		if (isset($_SESSION['data']['monster'])) {
			Utils::redirect( Router::generateUrl('fight.index') );
		}

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
		// Sauvegarde des données
		$_SESSION['data']['perso'] = serialize($this->perso);
		$_SESSION['data']['map']   = serialize($this->map);
	}

	public function indexAction()
	{
		$perso = $this->perso;
		$map   = $this->map;

		include __DIR__.'/../View/Map/index.php';
	}

	protected function checkMonster()
	{
		$position = $this->perso->getPosition();
		$monsters = $this->map->getMonsters();

		foreach ($monsters as $monster)
		{
			if ($position['x'] == $monster->getPosition()['x'] && $position['y'] == $monster->getPosition()['y'])
			{
				$_SESSION['data']['monster'] = serialize($monster);
				Utils::redirect( Router::generateUrl('fight.index') );
				break;
			}
		}
	}

	public function moveUpAction()
	{
		$this->perso->setDirection('up'); // Chargement de direction du perso

		// Lecture des données de la map
		$size    = $this->map->getSize();
		$origin  = $this->map->getOrigin();
		$visible = $this->map->getVisible();

		$position = $this->perso->getPosition(); // Lecture position actuelle du perso

		// Si on reste sur la map
		if (--$position['y'] >= 0)
		{
			// Si on peut aller sur la case
			if (Map::GROUND & $this->map->getMap()[ $position['y'] ][ $position['x'] ])
			{
				$this->perso->setPosition($position);

				// Si on sort de l'affichage
				if ($position['y'] < $origin['y'] + 1)
				{
					// Incrémentation pour afficher le reste de la map
					$this->map->setOrigin(array(
						'x' => $origin['x'],
						'y' => max(0, $origin['y'] - 1)
					));
				}
			}
		}

		$this->checkMonster();

		Utils::redirect( Router::generateUrl('map.index') );
	}

	public function moveDownAction()
	{
		$this->perso->setDirection('down'); // Chargement de direction du perso

		// Lecture des données de la map
		$size    = $this->map->getSize();
		$origin  = $this->map->getOrigin();
		$visible = $this->map->getVisible();

		$position = $this->perso->getPosition(); // Lecture position actuelle du perso

		// Si on reste sur la map
		if (++$position['y'] < $size['height'])
		{
			// Si on peut aller sur la case
			if (Map::GROUND & $this->map->getMap()[ $position['y'] ][ $position['x'] ])
			{
				$this->perso->setPosition($position);
				var_dump($position);
				var_dump($size);
				// Si on sort de l'affichage
				if (($position['y'] - $origin['y'] + 1) >= $visible['y'] && ($position['y'] + 1) < $size['height'])
				{
					// Incrémentation pour afficher le reste de la map
					$this->map->setOrigin(array(
						'x' => $origin['x'],
						'y' => min($visible['y'], $origin['y'] + 1)
					));
				}
			}
		}

		$this->checkMonster();

		Utils::redirect( Router::generateUrl('map.index') );
	}

	public function moveLeftAction()
	{
		$this->perso->setDirection('left'); // Chargement de direction du perso

		// Lecture des données de la map
		$size    = $this->map->getSize();
		$origin  = $this->map->getOrigin();
		$visible = $this->map->getVisible();

		$position = $this->perso->getPosition(); // Lecture position actuelle du perso

		// Si on reste sur la map
		if (--$position['x'] >= 0)
		{
			// Si on peut aller sur la case
			if (Map::GROUND & $this->map->getMap()[ $position['y'] ][ $position['x'] ])
			{
				$this->perso->setPosition($position);

				// Si on sort de l'affichage
				if ($position['x'] < $origin['x'] + 1)
				{
					// Incrémentation pour afficher le reste de la map
					$this->map->setOrigin(array(
						'x' => max(0, $origin['x'] - 1),
						'y' => $origin['y']
					));
				}
			}
		}

		$this->checkMonster();

		Utils::redirect( Router::generateUrl('map.index') );
	}

	public function moveRightAction()
	{
		$this->perso->setDirection('right'); // Chargement de direction du perso

		// Lecture des données de la map
		$size    = $this->map->getSize();
		$origin  = $this->map->getOrigin();
		$visible = $this->map->getVisible();

		$position = $this->perso->getPosition(); // Lecture position actuelle du perso

		// Si on reste sur la map
		if (++$position['x'] < $this->map->getSize()['width'])
		{
			// Si on peut aller sur la case
			if (Map::GROUND & $this->map->getMap()[ $position['y'] ][ $position['x'] ])
			{
				$this->perso->setPosition($position);

				// Si on sort de l'affichage
				if (($position['x'] - $origin['x'] + 1) > $visible['x'])
				{
					// Incrémentation pour afficher le reste de la map
					$this->map->setOrigin(array(
						'x' => min($visible['x'], $origin['x'] + 1),
						'y' => $origin['y']
					));
				}
			}
		}

		$this->checkMonster();

		Utils::redirect( Router::generateUrl('map.index') );
	}
}