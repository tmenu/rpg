<?php

namespace Lib\Controller;

use Lib\Application;
use Lib\Router;
use Lib\Utils;
use Lib\Manager;
use Lib\Session;

use Lib\Entity\Map;

class MapController extends Controller
{
	protected $game;

	public function __construct(Application $app)
	{
		parent::__construct($app);

		// Si pas identifié
		if (Session::isAuth() == false) {
			Session::setFlashMessage('danger', 'Vous devez être connecté pour jouer');
			Utils::redirect( Router::generateurl('user.login') );
		}

		// S'il n'y a pas de partie chargé
		if (!isset($_SESSION['current_game']) || false == ($this->game = Manager::getManagerOf('game')->select($_SESSION['current_game']))) {
			Session::setFlashMessage('danger', 'Aucune partie n\'est chargée actuellement');
			Utils::redirect( Router::generateurl('user.account') );
		}

		// S'il y a un combat
		if (isset($_SESSION['monster'])) {
			Utils::redirect( Router::generateurl('fight.index') );
		}

		// Récupération des données sur la partie

		// Le personnage
		$character = Manager::getManagerOf('playing_character')->select( $this->game->getRef_character() );
		$this->game->setCharacter( $character );

		// La map
		$map = Manager::getManagerOf('playing_map')->select( $this->game->getRef_map() );
		$this->game->setMap( $map );

		// Les monstres liés à la map
		$map_monsters = Manager::getManagerOf('playing_map_monster')->selectByMap( $map->getId() );

		foreach ($map_monsters as $map_monster)
		{
			$monster = Manager::getManagerOf('playing_monster')->select( $map_monster->getRef_monster() );
			$this->game->getMap()->addMonster( $monster );
		}
	}

	public function __destruct()
	{

	}

	public function indexAction()
	{
		$this->setVar('game', $this->game);

		$this->fetch('/Map/index.php');
	}

	protected function checkMonster()
	{
		$position = array(
			'x' => $this->game->getCharacter()->getPosition_x(),
			'y' => $this->game->getCharacter()->getPosition_y()
		);
		$monsters = $this->game->getMap()->getMonsters();

		foreach ($monsters as $monster)
		{
			if ($position['x'] == $monster->getPosition_x() && $position['y'] == $monster->getPosition_y())
			{
				$_SESSION['monster'] = serialize($monster);
				Utils::redirect( Router::generateUrl('fight.index') );
				break;
			}
		}
	}

	public function moveUpAction()
	{
		$this->game->getCharacter()->setDirection('up'); // Chargement de direction du perso

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
		$this->game->getCharacter()->setDirection('down'); // Chargement de direction du perso

		// Lecture des données de la map
		$size = array(
			'height' => $this->game->getMap()->getSize_height(),
			'width'  => $this->game->getmap()->getSize_width()
		);
		$origin = array(
			'x' => $this->game->getMap()->getOrigin_x(),
			'y' => $this->game->getmap()->getOrigin_y()
		);
		$visible = array(
			'x' => $this->game->getMap()->getVisible_x(),
			'y' => $this->game->getmap()->getVisible_y()
		);

		$position = array(
			'x' => $this->game->getCharacter()->getPosition_x(),
			'y' => $this->game->getCharacter()->getPosition_y()
		);

		// Si on reste sur la map
		if (++$position['y'] < $size['height'])
		{
			// Si on peut aller sur la case
			if (Map::GROUND & $this->game->getMap()->getMap()[ $position['y'] ][ $position['x'] ])
			{
				$this->game->getCharacter()->setPosition_x($position['x']);
				$this->game->getCharacter()->setPosition_y($position['y']);

				$character = Manager::getManagerOf('playing_character')->save( $this->game->getCharacter() );
				
				// Si on sort de l'affichage
				if (($position['y'] - $origin['y'] + 1) >= $visible['y'] && ($position['y'] + 1) < $size['height'])
				{
					// Incrémentation pour afficher le reste de la map
					$this->game->getMap()->setOrigin(array(
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
		$this->game->getCharacter()->setDirection('left'); // Chargement de direction du perso

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
		$this->game->getCharacter()->setDirection('right'); // Chargement de direction du perso

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