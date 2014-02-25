<?php

namespace Lib\Controller;

use Lib\Application;

abstract class Controller
{
	protected $app;
	protected $vars = array();

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	protected function setVar($name, $value)
	{
		$this->vars[$name] = $value;
	}

	protected function fetch($view)
	{
		extract($this->vars);
		
		ob_start();
		include __DIR__.'/../View'.$view;
		$_CONTENT = ob_get_clean();

		include __DIR__.'/../View/layout.php';
		exit;
	}
}