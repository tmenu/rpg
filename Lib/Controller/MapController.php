<?php

namespace Lib\Controller;

use Lib\Application;
use Lib\Router;
use Lib\Utils;
use Lib\Manager;
use Lib\Session;

use Lib\Entity\Map;
use Lib\Entity\Map_monster;

class MapController extends Controller
{
	protected $game = null;

	public function __construct(Application $app)
	{
		parent::__construct($app);

		// Si pas identifié
		if (Session::isAuth() == false) {
			Session::setFlashMessage('danger', 'Vous devez être connecté pour jouer');
			Utils::redirect( Router::generateurl('user.login') );
		}

		// S'il n'y a pas de partie chargé
		if (!isset($_SESSION['current_game']) || empty($_SESSION['current_game'])) {
			Session::setFlashMessage('danger', 'Aucune partie n\'est chargée actuellement');
			Utils::redirect( Router::generateurl('user.account') );
		}

		$this->game = unserialize($_SESSION['current_game']);

		// S'il y a un combat
		if (isset($_SESSION['monster'])) {
			Utils::redirect( Router::generateurl('fight.index') );
		}
		
	}

	public function __destruct()
	{
		if ($this->game != null) {
			$_SESSION['current_game'] = serialize($this->game);
		}
	}

	public function indexAction()
	{
		$this->checkMonster();
		$this->checkEndLevel();

		$this->setVar('game', $this->game);

		$this->fetch('/Map/index.php');
	}

	protected function checkMonster()
	{
		$character = $this->game->getCharacter();
		$monsters = $this->game->getMap()->getMonsters();

		foreach ($monsters as $monster)
		{
			if ($character->getPosition_x() == $monster->getPosition_x() && $character->getPosition_y() == $monster->getPosition_y())
			{
				$_SESSION['current_fight'] = serialize(array(
					'monster' => $monster,
					'character' => $character
				));

				if (isset($_GET['isAjax'])) {
					echo json_encode(array(
						'fight' => true
					));
					exit;
				}
				else {
					Utils::redirect( Router::generateUrl('fight.index') );
				}
			}
		}
	}

	protected function checkEndLevel()
	{
		$character = $this->game->getCharacter();
		$map = $this->game->getMap()->getMap();

		// Si la case actuelle est la sortie
		if (Map::OUT & $map[ $character->getPosition_y() ][ $character->getPosition_x() ])
		{
			/**
			 * Supression de l'ancienne map
			 */

			// Les monstres liés à la map
			$map_monsters = Manager::getManagerOf('playing_map_monster')->selectByMap( $this->game->getRef_map() );

			foreach ($map_monsters as $monster)
			{
				Manager::getManagerOf('playing_monster')->delete( $monster->getRef_monster() );
				Manager::getManagerOf('playing_map_monster')->delete( $monster->getId() );
			}

			Manager::getManagerOf('playing_map')->delete( $this->game->getRef_map() );

			/**
			 * Ajout de la nouvelle map
			 */

			// Récupération des données initiales

			// La map
			$map = Manager::getManagerOf('initial_map')->selectLevelUp( $this->game->getRef_initial_map() );
			
			// Les monstres liés à la map
			$map_monsters = Manager::getManagerOf('initial_map_monster')->selectByMap( $map->getId() );

			foreach ($map_monsters as $map_monster)
			{
				$monster = Manager::getManagerOf('initial_monster')->select( $map_monster->getRef_monster() );
				$monster->setPosition_x( $map_monster->getPosition_x() );
				$monster->setPosition_y( $map_monster->getPosition_y() );
				$monster->setDirection( $map_monster->getDirection());

				$map->addMonster( $monster );
			}

			// Enregistrement de la nouvelle map

			$this->game->setRef_initial_map( $map->getId() );

			// La map
			$map->setId(null);
			$map = Manager::getManagerOf('playing_map')->save( $map );

			// Les monstres liés à la map
			foreach ($map->getMonsters() as $monster)
			{
				$monster->setId(null);
				$monster = Manager::getManagerOf('playing_monster')->save( $monster );

				// Création de la liaison monstre/map
				$map_monster = new Map_monster();

				$map_monster->setRef_map( $map->getId() );
				$map_monster->setref_monster( $monster->getId() );
				$map_monster->setPosition_x( $monster->getPosition_x() );
				$map_monster->setPosition_y( $monster->getPosition_y() );
				$map_monster->setDirection( $monster->getDirection());

				Manager::getManagerOf('playing_map_monster')->save( $map_monster );
			}

			// Affectation de la map
			$this->game->setRef_map( $map->getId() );
			$this->game->setMap( $map );

			// Repositionnement du perso
			$this->game->getCharacter()->setPosition_x( 0 );
			$this->game->getCharacter()->setPosition_y( 0 );
			$this->game->getCharacter()->setDirection('DOWN');
			
			Manager::getManagerOf('game')->save( $this->game );

			Session::setFlashMessage('success', 'Bravo ! Vous venez de passer au niveau suivant.');

			if (isset($_GET['isAjax'])) {
				echo json_encode(array(
					'lvlup' => true
				));
				exit;
			}
			else {
				Utils::redirect( Router::generateUrl('map.index') );
			}
		}
	}

	public function moveUpAction()
	{
		$this->game->getCharacter()->setDirection('up'); // Chargement de direction du perso

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

		// Lecture position du perso
		$position = array(
			'x' => $this->game->getCharacter()->getPosition_x(),
			'y' => $this->game->getCharacter()->getPosition_y()
		);

		// Si on reste sur la map
		if (--$position['y'] >= 0)
		{
			// Si on peut aller sur la case
			if (Map::GROUND & $this->game->getMap()->getMap()[ $position['y'] ][ $position['x'] ])
			{
				$this->game->getCharacter()->setPosition_x($position['x']);
				$this->game->getCharacter()->setPosition_y($position['y']);

				// Si on sort de l'affichage
				if ($position['y'] < $origin['y'] + 1 && $origin['y'] != 0)
				{
					// Incrémentation pour afficher le reste de la map
					$this->game->getMap()->setOrigin_x($origin['x']);
					$this->game->getMap()->setOrigin_y(max(0, $origin['y'] - 1));

					Manager::getManagerOf('playing_map')->save( $this->game->getMap() );
				}
			}
		}

		$character = Manager::getManagerOf('playing_character')->save( $this->game->getCharacter() );

		$this->checkMonster();
		$this->checkEndLevel();

		if (isset($_GET['isAjax']))
		{
			$this->setVar('game', $this->game);
			echo json_encode(array(
				'map' => $this->fetchView('/Map/map.php')
			));
		}
		else {
			Utils::redirect( Router::generateUrl('map.index') );
		}
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

		// Lecture position du perso
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

				// Si on sort de l'affichage
				if (($position['y'] - $origin['y'] + 1) >= $visible['y'] && ($position['y'] + 1) < $size['height'])
				{
					// Incrémentation pour afficher le reste de la map
					$this->game->getMap()->setOrigin_x($origin['x']);
					$this->game->getMap()->setOrigin_y(min($visible['y'], $origin['y'] + 1));

					Manager::getManagerOf('playing_map')->save( $this->game->getMap() );
				}
			}
		}

		$character = Manager::getManagerOf('playing_character')->save( $this->game->getCharacter() );

		$this->checkMonster();
		$this->checkEndLevel();

		if (isset($_GET['isAjax']))
		{
			$this->setVar('game', $this->game);
			echo json_encode(array(
				'map' => $this->fetchView('/Map/map.php')
			));
		}
		else {
			Utils::redirect( Router::generateUrl('map.index') );
		}
	}

	public function moveLeftAction()
	{
		$this->game->getCharacter()->setDirection('left'); // Chargement de direction du perso

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

		// Lecture position du perso
		$position = array(
			'x' => $this->game->getCharacter()->getPosition_x(),
			'y' => $this->game->getCharacter()->getPosition_y()
		);

		// Si on reste sur la map
		if (--$position['x'] >= 0)
		{
			// Si on peut aller sur la case
			if (Map::GROUND & $this->game->getMap()->getMap()[ $position['y'] ][ $position['x'] ])
			{
				$this->game->getCharacter()->setPosition_x($position['x']);
				$this->game->getCharacter()->setPosition_y($position['y']);

				// Si on sort de l'affichage
				if ($position['x'] < $origin['x'] + 1 && $origin['x'] != 0)
				{
					// Incrémentation pour afficher le reste de la map
					$this->game->getMap()->setOrigin_x(max(0, $origin['x'] - 1));
					$this->game->getMap()->setOrigin_y($origin['y']);

					Manager::getManagerOf('playing_map')->save( $this->game->getMap() );
				}
			}
		}

		$character = Manager::getManagerOf('playing_character')->save( $this->game->getCharacter() );

		$this->checkMonster();
		$this->checkEndLevel();

		if (isset($_GET['isAjax']))
		{
			$this->setVar('game', $this->game);
			echo json_encode(array(
				'map' => $this->fetchView('/Map/map.php')
			));
		}
		else {
			Utils::redirect( Router::generateUrl('map.index') );
		}
	}

	public function moveRightAction()
	{
		$this->game->getCharacter()->setDirection('right'); // Chargement de direction du perso

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

		// Lecture position du perso
		$position = array(
			'x' => $this->game->getCharacter()->getPosition_x(),
			'y' => $this->game->getCharacter()->getPosition_y()
		);

		// Si on reste sur la map
		if (++$position['x'] < $size['width'])
		{
			// Si on peut aller sur la case
			if (Map::GROUND & $this->game->getMap()->getMap()[ $position['y'] ][ $position['x'] ])
			{
				$this->game->getCharacter()->setPosition_x($position['x']);
				$this->game->getCharacter()->setPosition_y($position['y']);

				// Si on sort de l'affichage
				if (($position['x'] - $origin['x'] + 1) >= $visible['x'] && ($position['x'] + 1) < $size['width'])
				{
					// Incrémentation pour afficher le reste de la map
					$this->game->getMap()->setOrigin_x(min($visible['x'], $origin['x'] + 1));
					$this->game->getMap()->setOrigin_y($origin['y']);

					Manager::getManagerOf('playing_map')->save( $this->game->getMap() );
				}
			}
		}

		$character = Manager::getManagerOf('playing_character')->save( $this->game->getCharacter() );

		$this->checkMonster();
		$this->checkEndLevel();

		if (isset($_GET['isAjax']))
		{
			$this->setVar('game', $this->game);
			echo json_encode(array(
				'map' => $this->fetchView('/Map/map.php')
			));
		}
		else {
			Utils::redirect( Router::generateUrl('map.index') );
		}
	}
}