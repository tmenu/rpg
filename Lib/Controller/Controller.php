<?php

namespace Lib\Controller;

use Lib\Application;

abstract class Controller
{
	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}
}