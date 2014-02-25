<?php

namespace Lib\Controller;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;

class UserController extends Controller
{
	public function accountAction()
	{
		include __DIR__.'/../View/User/account.php';
	}

	public function loginAction()
	{
		include __DIR__.'/../View/User/login.php';
	}

	public function logoutAction()
	{
		
	}

	public function signupAction()
	{
		$manager = Manager::getManagerOf('user');

		var_dump($manager->select(2));

		include __DIR__.'/../View/User/signup.php';
	}
}