<?php

namespace Lib\Controller;

use Lib\Perso\CrazyfrogPersonnage as Crazyfrog;
use Lib\Perso\RabivadorPersonnage as Rabivador;

class FightController extends Controller
{
	public function indexAction()
	{
		echo '123';
		$perso = new Crazyfrog();
	}

	public function attackAction()
	{
		
	}
}