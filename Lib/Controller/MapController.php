<?php

namespace Lib\Controller;

use Lib\Application;
use Lib\Router;
use Lib\Utils;
use Lib\Manager;
use Lib\Session;

use Lib\Entity\Map;
use Lib\Entity\Map_monster;
use Lib\Entity\Map_item;

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
		if (isset($_SESSION['current_fight'])) {
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
		$this->checkItem();
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

	protected function checkItem()
	{
		$character = $this->game->getCharacter();
		$items = $this->game->getMap()->getItems();

		foreach ($items as $item)
		{
			if ($character->getPosition_x() == $item->getPosition_x() && $character->getPosition_y() == $item->getPosition_y())
			{
				// Augmentation santé
				$character->setHealth_max($character->getHealth_max() + $item->getHealth_max());

				// Augmentation santé max
				$health = min($character->getHealth_max(), $character->getHealth() + $item->getHealth());
				$character->setHealth($health);

				// Augmentation force
				$character->setStrength($character->getStrength() + $item->getStrength());

				// Augmentation resistance
				$character->setResistance($character->getResistance() + $item->getResistance());

				// Augmentation vitesse
				$character->setSpeed($character->getSpeed() + $item->getSpeed());

				Manager::getManagerOf('playing_character')->save($character);

				/**
				 * Suppression de l'objet de la partie chargée en session
				 */

				$_items = $this->game->getMap()->getItems(); // Récupération des monstres
				$this->game->getMap()->setItems( array() );    // Suppression de la liste des monstre actuelle

				// Réaffectation des objets en ignorant celui qui est mort
				foreach ($_items as $_item) {
					if ($_item->getId() != $item->getId()) {
						$this->game->getMap()->addItem( $_item );
					}
				}

				/**
				 * Supression de l'objet de la map de la bdd
				 */
				
				Manager::getManagerOf('playing_item')->delete( $item->getId() );
				Manager::getManagerOf('playing_map_item')->deleteByItem( $item->getId() );

				Session::setFlashMessage('success', 'Vous venez de trouver l\'objet "<b>' . $item->getName() . '</b>"');

				if (isset($_GET['isAjax'])) {
					echo json_encode(array(
						'item' => true
					));
					exit;
				}
				else {
					Utils::redirect( Router::generateUrl('map.index') );
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
			// La map
			$map = Manager::getManagerOf('initial_map')->selectLevelUp( $this->game->getRef_initial_map() );

			if ($map != false)
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


				// Les items liés à la map
				$map_items = Manager::getManagerOf('playing_map_item')->selectByMap( $this->game->getRef_map() );

				foreach ($map_items as $item)
				{
					Manager::getManagerOf('playing_item')->delete( $item->getRef_item() );
					Manager::getManagerOf('playing_map_item')->delete( $item->getId() );
				}

				Manager::getManagerOf('playing_map')->delete( $this->game->getRef_map() );

				/**
				 * Ajout de la nouvelle map
				 */

				// Récupération des données initiales
				
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

				// Les items liés à la map
				$map_items = Manager::getManagerOf('initial_map_item')->selectByMap( $map->getId() );

				foreach ($map_items as $map_item)
				{
					$item = Manager::getManagerOf('initial_item')->select( $map_item->getRef_item() );
					$item->setPosition_x( $map_item->getPosition_x() );
					$item->setPosition_y( $map_item->getPosition_y() );

					$map->addItem( $item );
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
					$map_monster->setRef_monster( $monster->getId() );
					$map_monster->setPosition_x( $monster->getPosition_x() );
					$map_monster->setPosition_y( $monster->getPosition_y() );
					$map_monster->setDirection( $monster->getDirection());

					Manager::getManagerOf('playing_map_monster')->save( $map_monster );
				}

				// Les items liés à la map
				foreach ($map->getItems() as $item)
				{
					$item->setId(null);
					$item = Manager::getManagerOf('playing_item')->save( $item );

					// Création de la liaison monstre/map
					$map_item = new Map_item();

					$map_item->setRef_map( $map->getId() );
					$map_item->setRef_item( $item->getId() );
					$map_item->setPosition_x( $item->getPosition_x() );
					$map_item->setPosition_y( $item->getPosition_y() );

					Manager::getManagerOf('playing_map_item')->save( $map_item );
				}

				// Affectation de la map
				$this->game->setRef_map( $map->getId() );
				$this->game->setMap( $map );

				// Repositionnement du perso
				$this->game->getCharacter()->setPosition_x( 0 );
				$this->game->getCharacter()->setPosition_y( 0 );
				$this->game->getCharacter()->setDirection('DOWN');

				// Evolution

				// SAnté max
				$health_max = $this->game->getCharacter()->getHealth_max() * 1.1;
				$this->game->getCharacter()->setHealth_max( ceil($health_max) );

				// SAnté
				$health = $this->game->getCharacter()->getHealth() * 1.1;
				$this->game->getCharacter()->setHealth( min($this->game->getCharacter()->getHealth(), $health) );

				// Force
				$strength = $this->game->getCharacter()->getStrength() * 1.1;
				$this->game->getCharacter()->setStrength( ceil($strength) );

				// Résistance
				$resistance = $this->game->getCharacter()->getResistance() * 1.1;
				$this->game->getCharacter()->setResistance( ceil($resistance) );

				// Vitesse
				$speed = $this->game->getCharacter()->getSpeed() * 1.1;
				$this->game->getCharacter()->setSpeed( ceil($speed) );

				// +1 vie
				$this->game->getCharacter()->setLife( $this->game->getCharacter()->getLife() + 1 );

				Manager::getManagerOf('playing_character')->save( $this->game->getCharacter() );

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
			else
			{
				// Les monstres liés à la map
				$map_monsters = Manager::getManagerOf('playing_map_monster')->selectByMap( $this->game->getRef_map() );

				// Les objets liés à la map
				$map_items = Manager::getManagerOf('playing_map_item')->selectByMap( $this->game->getRef_map() );

				/**
				 * Supression de la partie et de toute ces données
				 */
				Manager::getManagerOf('game')->delete( $this->game->getId() );
				Manager::getManagerOf('playing_character')->delete( $this->game->getRef_character() );
				Manager::getManagerOf('playing_map')->delete( $this->game->getRef_map() );

				foreach ($map_monsters as $monster)
				{
					Manager::getManagerOf('playing_map_monster')->delete( $monster->getId() );
					Manager::getManagerOf('playing_monster')->delete( $monster->getRef_monster() );
				}

				foreach ($map_items as $item)
				{
					Manager::getManagerOf('playing_map_item')->delete( $item->getId() );
					Manager::getManagerOf('playing_item')->delete( $item->getRef_item() );
				}

				
				// Supprime la martie en cours
				unset($_SESSION['current_game']);
				unset($_SESSION['current_fight']);

				Session::setFlashMessage('success', 'Vous avez gagnez !!! <b>BRAVO !!!!!!</b>');
				
				if (isset($_GET['isAjax'])) {
					echo json_encode(array(
						'end' => true
					));
					exit;
				}
				else {
					Utils::redirect( Router::generateurl('user.account') );
				}
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
		$this->checkItem();
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
		$this->checkItem();
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
		$this->checkItem();
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
		$this->checkItem();
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