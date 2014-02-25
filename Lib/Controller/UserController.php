<?php

namespace Lib\Controller;

use Lib\Router;
use Lib\Utils;

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
		include __DIR__.'/../View/User/signup.php';
	}
}