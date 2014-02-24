<?php

namespace Lib;

session_start();

if (isset($_GET['resses'])) {
	$_SESSION = array();
}

use Lib\Controller as Controller;
use Lib\Router;

class Application
{
	public function run()
	{
		// Recherche route
		if (false !== ($route = Router::matchRoute( $_SERVER['REQUEST_URI'] )))
		{
			// Instanciation
			$class = '\\Lib\\Controller\\' . $route['controller'] . 'Controller';

			$controller = new $class($this);

			// Execution
			$method = ucfirst(mb_strtolower($route['action'])) . 'Action';

			if (!method_exists($controller, $method)) {
				throw new \Exception('Method "' . $method . '" doesn\'t exists');
			}

			$controller->$method();

			return;
		}
		
		die('404');
	}
}