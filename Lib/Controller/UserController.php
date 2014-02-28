<?php

namespace Lib\Controller;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;
use Lib\Session;

use Lib\Entity\User;
use Lib\Entity\Game;
use Lib\Entity\Map_monster;
use Lib\Entity\Map_item;

class UserController extends Controller
{
	protected function newGame($character_id, $map_id)
	{
		/**
		 * Récupération des données initiales
		 */

		// Le personnage
		$character = Manager::getManagerOf('initial_character')->select( $character_id );

		// La map
		$map = Manager::getManagerOf('initial_map')->select( $map_id );

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

		// Les objets liés à la map
		$map_items = Manager::getManagerOf('initial_map_item')->selectByMap( $map->getId() );

		foreach ($map_items as $map_item)
		{
			$item = Manager::getManagerOf('initial_item')->select( $map_item->getRef_item() );
			$item->setPosition_x( $map_item->getPosition_x() );
			$item->setPosition_y( $map_item->getPosition_y() );

			$map->addItem( $item );
		}

		/**
		 * Création d'une nouvelle partie
		 */
		
		// Le personnage
		$character->setId(null);
		$character = Manager::getManagerOf('playing_character')->save( $character );

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

		// Les objets liés à la map
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

		// Enregistrement de la partie
		$game = new Game();

		$game->setRef_user( $_SESSION['user_id'] );
		$game->setRef_map( $map->getId() );
		$game->setRef_character( $character->getId() );
		$game->setRef_initial_map( $map_id );
		$game->setRef_initial_character( $character_id );

		Manager::getManagerOf('game')->save( $game );
	}

	public function accountAction()
	{
		if (Session::isAuth() == false) {
			Session::setFlashMessage('danger', 'Vous devez être connecté pour accéder à cette page');
			Utils::redirect( Router::generateurl('user.login') );
		}

		// Si le formulaire de nouvelle partie
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submit'] == 'new_game')
		{
			// Validation
			$form_errors = array();

			if (!isset($_POST['perso'])) {
				$form_errors['perso'] = 'Obligatoire';
			}
			else if (false == Manager::getManagerOf('initial_character')->select( $_POST['perso'] )) {
				$form_errors['perso'] = 'Invalide';
			}

			if (!isset($_POST['map'])) {
				$form_errors['map'] = 'Obligatoire';
			}
			else if (false == Manager::getManagerOf('initial_map')->select( $_POST['map'] )) {
				$form_errors['map'] = 'Invalide';
			}

			// Si aucune erreurs : création de la partie
			if (empty($form_errors))
			{
				$this->newGame( (int)$_POST['perso'], (int)$_POST['map'] );

				Session::setFlashMessage('success', 'Votre nouvelle partie à bien été créée');
				$_POST = array();
			}

			$this->setVar('form_errors', $form_errors);
		}

		// Récupération des parties en cours
		$games_list = Manager::getManagerOf('game')->selectByUser( $_SESSION['user_id'] );

		// Remplissage des paties
		foreach ($games_list as $key => $game)
		{
			// Le perso
			$character = Manager::getManagerOf('playing_character')->select( $game->getRef_character() );
			$game->setCharacter( $character );

			// La map
			$map = Manager::getManagerOf('playing_map')->select( $game->getRef_map() );
			$game->setMap( $map );

			// Les monstres
			$map_monsters = Manager::getManagerOf('playing_map_monster')->selectByMap( $map->getId() );

			foreach ($map_monsters as $map_monster)
			{
				$monster = Manager::getManagerOf('playing_monster')->select( $map_monster->getRef_monster() );

				$game->getMap()->addMonster( $monster );
			}

			// Affectation partie aec données
			$games_list[ $key ] = $game;
		}

		// Affectation de la liste des parties à la vue
		$this->setVar('games_list', $games_list);

		// Recupération de la liste des personnages
		$characters_list = Manager::getManagerOf('initial_character')->selectAll();
		$this->setVar('characters_list', $characters_list);

		// Recupération de la liste des maps
		$maps_list = Manager::getManagerOf('initial_map')->selectAll();
		$this->setVar('maps_list', $maps_list);

		// Chargement de la vue
		$this->fetch('/User/account.php');
	}

	public function loginAction()
	{
		if (Session::isAuth()) {
			Session::setFlashMessage('danger', 'Vous êtes déjà connecté');
			Utils::redirect( Router::generateurl('home') );
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			// Validations
			$form_errors = array();

			if (empty($_POST['username'])) {
				$form_errors['username'] = 'Obligatoire';
			}

			if (empty($_POST['password'])) {
				$form_errors['password'] = 'Obligatoire';
			}

			// S'il n'y a aucune erreurs
			if (empty($form_errors))
			{
				// Test des données
				if (false != ($user = Manager::getManagerOf('user')->getByUsername( $_POST['username'] )))
				{
					$hashed_password = Utils::hashString($_POST['password'], $user->getSalt());

					if ($hashed_password != $user->getPassword())
					{
						Session::setFlashMessage('danger', 'Nom d\'utilisateur et/ou mot de passe incorrect');
					}
					else
					{
						Session::setAuth(true);
						$_SESSION['user_id'] = $user->getId();

						Session::setFlashMessage('success', 'Vous êtes maintenant connecté');
						Utils::redirect( Router::generateUrl('user.account') );
					}
				}
				else
				{
					Session::setFlashMessage('danger', 'Nom d\'utilisateur et/ou mot de passe incorrect');
				}
			}
			else
			{
				$this->setVar('form_errors', $form_errors);
			}
		}

		$this->fetch('/User/login.php');
	}

	public function logoutAction()
	{
		if (Session::isAuth() == false) {
			Session::setFlashMessage('danger', 'Vous devez être connecté pour vous déconnecter');
			Utils::redirect( Router::generateurl('user.login') );
		}

		$_SESSION = array();
		Session::setAuth(false);

		Session::setFlashMessage('success', 'Vous êtes maintenant déconnecté');
		Utils::redirect( Router::generateurl('user.login') );
	}

	public function signupAction()
	{
		if (Session::isAuth()) {
			Session::setFlashMessage('danger', 'Vous êtes déjà connecté');
			Utils::redirect( Router::generateurl('home') );
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			// Validations
			$form_errors = array();

			if (empty($_POST['username'])) {
				$form_errors['username'] = 'Obligatoire';
			}
			else if (Manager::getManagerOf('user')->getByUsername( $_POST['username'] ) != false) {
				$form_errors['username'] = 'Déjà utilisé';
			}

			if (empty($_POST['password'])) {
				$form_errors['password'] = 'Obligatoire';
			}

			if (empty($_POST['confirm_password'])) {
				$form_errors['confirm_password'] = 'Obligatoire';
			}
			else if ($_POST['password'] != $_POST['confirm_password']) {
				$form_errors['confirm_password'] = 'Les deux mot de passes doivent être identiques';
			}

			if (empty($_POST['email'])) {
				$form_errors['email'] = 'Obligatoire';
			}
			else if (!preg_match('#^[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]+\.[a-zA-Z]{2,4}$#', $_POST['email'])) {
				$form_errors['email'] = 'Invalide';
			}

			if (!isset($_POST['perso'])) {
				$form_errors['perso'] = 'Obligatoire';
			}
			else if (false == Manager::getManagerOf('initial_character')->select( $_POST['perso'] )) {
				$form_errors['perso'] = 'Invalide';
			}

			// S'il n'y a aucune erreurs
			if (empty($form_errors))
			{
				// Création du user
				$user = new User();

				$user->setUsername( $_POST['username'] );
				$user->setPassword( Utils::hashString($_POST['password'], $user->getSalt()) );
				$user->setEmail( $_POST['email'] );

				// Enregistrement
				$user = Manager::getManagerOf('user')->save( $user );

				Session::setAuth(true);
				$_SESSION['user_id'] = $user->getId();

				$this->newGame( (int)$_POST['perso'] );

				Session::setFlashMessage('success', 'Inscription réussi avec succès');
				Utils::redirect( Router::generateUrl('user.account') );
			}
			else
			{
				$this->setVar('form_errors', $form_errors);
			}
		}

		// Recupération de la liste des personnages
		$characters_list = Manager::getManagerOf('initial_character')->selectAll();
		$this->setVar('characters_list', $characters_list);

		$this->fetch('/User/signup.php');
	}

	public function cancelGameAction()
	{
		if (Session::isAuth() == false) {
			Session::setFlashMessage('danger', 'Vous devez être connecté pour accéder à cette page');
			Utils::redirect( Router::generateurl('user.login') );
		}

		// Récupération de la partie à supprimer
		$game = Manager::getManagerOf('game')->select( $_GET['id_game'] );

		// Les monstres liés à la map
		$map_monsters = Manager::getManagerOf('playing_map_monster')->selectByMap( $game->getRef_map() );

		// Les objets liés à la map
		$map_items = Manager::getManagerOf('playing_map_item')->selectByMap( $game->getRef_map() );

		/**
		 * Supression de la partie et de toute ces données
		 */
		Manager::getManagerOf('game')->delete( $game->getId() );
		Manager::getManagerOf('playing_character')->delete( $game->getRef_character() );
		Manager::getManagerOf('playing_map')->delete( $game->getRef_map() );

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

		// Si il y a une partie en cours
		if (isset($_SESSION['current_game']))
		{
			$game = unserialize($_SESSION['current_game']);

			// Si la partie en cours est celle que l'on supprime
			if ($game->getId() == $_GET['id_game'])
			{
				// Supprime la martie en cours
				unset($_SESSION['current_game']);

				// S'il y a un combat en cours
				if (isset($_SESSION['fight'])) {
					unset($_SESSION['fight']); // Supprime le combat en cours (qui correspond à la partie supprimée)
				}
			}
		}

		Session::setFlashMessage('success', 'La partie à bien été supprimée');
		Utils::redirect( Router::generateurl('user.account') );
	}

	public function loadGameAction()
	{
		if (false == ($game = Manager::getManagerOf('game')->select($_GET['id_game']))) {
			Session::setFlashMessage('danger', 'La partie à charger est introuvable');
			Utils::redirect( Router::generateurl('user.account') );
		}

		// Récupération des données sur la partie

		// Le personnage
		$character = Manager::getManagerOf('playing_character')->select( $game->getRef_character() );
		$game->setCharacter( $character );

		// La map
		$map = Manager::getManagerOf('playing_map')->select( $game->getRef_map() );
		$game->setMap( $map );

		// Les monstres liés à la map
		$map_monsters = Manager::getManagerOf('playing_map_monster')->selectByMap( $map->getId() );

		foreach ($map_monsters as $map_monster)
		{
			$monster = Manager::getManagerOf('playing_monster')->select( $map_monster->getRef_monster() );
			$game->getMap()->addMonster( $monster );
		}

		// Les monstres liés à la map
		$map_items = Manager::getManagerOf('playing_map_item')->selectByMap( $map->getId() );

		foreach ($map_items as $map_item)
		{
			$item = Manager::getManagerOf('playing_item')->select( $map_item->getRef_item() );
			$game->getMap()->addItem( $item );
		}

		$_SESSION['current_game'] = serialize($game);

		/**
		 * Test si combat en cours
		 */
		$character = $game->getCharacter();
		$monsters = $game->getMap()->getMonsters();

		unset($_SESSION['current_fight']); // Reset éventuelle combat en cours

		foreach ($monsters as $monster)
		{
			if ($character->getPosition_x() == $monster->getPosition_x() && $character->getPosition_y() == $monster->getPosition_y())
			{
				$_SESSION['current_fight'] = serialize(array(
					'monster'   => $monster,
					'character' => $character
				));
			}
		}

		Session::setFlashMessage('success', 'La partie à bien été chargée');
		Utils::redirect( Router::generateurl('map.index') );
	}
}