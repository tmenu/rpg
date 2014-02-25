<?php

namespace Lib;

use Lib\Controller as Controller;
use Lib\Router;

class Application
{
	public function run()
	{
		// Recherche route
		if (false !== ($route = Router::matchRoute( $_SERVER['REQUEST_URI'] )))
		{
			// Affectation des données au tableau GET
			$_GET = array_merge($_GET, $route['data']);

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