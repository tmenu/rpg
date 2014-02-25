<?php

namespace Lib\Controller;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;
use Lib\Session;

use Lib\Entity\User;
use Lib\Entity\Initial_character;

class UserController extends Controller
{
	public function accountAction()
	{
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
						$_SESSION['user'] = serialize($user);

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

			// S'il n'y a aucune erreurs
			if (empty($form_errors))
			{
				$user = new User();

				$user->setUsername( $_POST['username'] );
				$user->setPassword( Utils::hashString($_POST['password'], $user->getSalt()) );
				$user->setEmail( $_POST['email'] );

				Manager::getManagerOf('user')->save( $user );

				//
				//
				// 	CREER PREMIERE PARTIE
				//
				//

				Session::setFlashMessage('success', 'Inscription réussi avec succès');
				Utils::redirect( Router::generateUrl('user.login') );
			}
			else
			{
				$this->setVar('form_errors', $form_errors);
			}
		}

		$this->fetch('/User/signup.php');
	}
}