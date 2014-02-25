<?php
require('./Lib/autoload.php');

use Lib\Router;

session_start();

if (isset($_GET['resses'])) {
	$_SESSION = array(
		'auth' => false
	);

	\Lib\Utils::redirect( \Lib\Router::generateUrl('map.index') );
}

$application = new Lib\Application();
$application->run();