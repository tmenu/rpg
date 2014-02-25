<?php

namespace Lib\Controller;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;
use Lib\Entity\Initial_character;

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
		$manager = Manager::getManagerOf('initial_character');
		$entity = new Initial_character();

		$entity->setHealthMax(100);
		$entity->setHealth(100);
		$entity->setDirection('DOWN');
		$entity->setStrength(100);
		$entity->setResistance(100);
		$entity->setSpeed(100);
		$entity->setRound(0);
		$entity->setPosture(1);
		$entity->setName('GUERRIER');
		$entity->setPosition_x(0);
		$entity->setPosition_y(1);
		$entity->setRef('GUERRIER');


		var_dump($manager->delete(13));

		include __DIR__.'/../View/User/signup.php';
	}
}