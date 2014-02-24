<?php

function loadClass($class)
{
	$path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';

	if (!file_exists($path)) {
		throw new Exception('File "' . $path . '" doesn\'t exists !');
	}

	require $path;
}

spl_autoload_register('loadClass');