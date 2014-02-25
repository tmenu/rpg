<?php

namespace Lib\Controller;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;
use Lib\Session;

use Lib\Entity\User;
use Lib\Entity\Game;
//use Lib\Entity\Character;
//use Lib\Entity\Map;
use Lib\Entity\Map_monster;

class UserController extends Controller
{
	public function testAction()
	{
		
	}

	protected function newGame($character_id)
	{
		/**
		 * Récupération des données initiales
		 */

		// Le personnage
		$character = Manager::getManagerOf('initial_character')->select( $character_id );

		// La map
		$map = Manager::getManagerOf('initial_map')->select(1);

		// Les monstres liés à la map
		$map_monsters = Manager::getManagerOf('initial_map_monster')->selectByMap( $map->getId() );

		foreach ($map_monsters as $map_monster)
		{
			$monsters[] = Manager::getManagerOf('initial_monster')->select( $map_monster->getRef_monster() );
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
		foreach ($monsters as $monster)
		{
			$monster->setId(null);
			$monster = Manager::getManagerOf('playing_monster')->save( $monster );

			// Création de la liaison monstre/map
			$map_monster = new Map_monster();

			$map_monster->setRef_map( $map->getId() );
			$map_monster->setref_monster( $monster->getId() );
			$map_monster->setPosition_x( $monster->getPosition_x() );
			$map_monster->setPosition_y( $monster->getPosition_y() );

			Manager::getManagerOf('playing_map_monster')->save( $map_monster );
		}

		// Enregistrement de la partie
		$game = new Game();

		$game->setRef_user( $_SESSION['user_id'] );
		$game->setRef_map( $map->getId() );
		$game->setRef_character( $character->getId() );

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

			// Si aucune erreurs : création de la partie
			if (empty($form_errors))
			{
				$this->newGame( (int)$_POST['perso'] );

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
			Utils::redirect( Router::generateurl('home') );
		}

		$_SESSION = array();
		Session::setAuth(false);

		Session::setFlashMessage('success', 'Vous êtes maintenant déconnecté');
		Utils::redirect( Router::generateurl('home') );
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

		// Le personnage
		$character = Manager::getManagerOf('playing_character')->select( $game->getRef_character() );

		// La map
		$map = Manager::getManagerOf('playing_map')->select( $game->getRef_map() );

		// Les monstres liés à la map
		$map_monsters = Manager::getManagerOf('playing_map_monster')->selectByMap( $map->getId() );

		/**
		 * Supression de la partie et de toute ces données
		 */
		Manager::getManagerOf('game')->delete( $game->getId() );
		Manager::getManagerOf('playing_character')->delete( $character->getId() );
		Manager::getManagerOf('playing_map')->delete( $game->getRef_map() );

		foreach ($map_monsters as $monster)
		{
			Manager::getManagerOf('playing_map_monster')->delete( $monster->getId() );
			Manager::getManagerOf('playing_monster')->delete( $monster->getRef_monster() );
		}

		Session::setFlashMessage('success', 'La partie à bien été supprimée');
		Utils::redirect( Router::generateurl('user.account') );
	}
}