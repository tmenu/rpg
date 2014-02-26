<?php

namespace Lib;

class Manager
{
	CONST DSN      = 'mysql:dbname=rpg;host=10.10.80.36';
	CONST USER     = 'rpg';
	CONST PASSWORD = 'rpg2511';

	protected static $pdo      = null;
	protected static $managers = array();

	public static function getPdo()
	{
		if (empty(self::$pdo)) {
			try {
			    self::$pdo = new \PDO(self::DSN, self::USER, self::PASSWORD);
			} catch (PDOException $e) {
			    die('Connexion échouée : ' . $e->getMessage());
			}

			self::$pdo->query('SET NAMES UTF8');
		}

		return self::$pdo;
	}

	public static function getManagerOf($entity)
	{
		if (!isset(self::$managers[$entity])) {
			$class = '\\Lib\\Model\\' . ucfirst(mb_strtolower($entity)) . 'Model';

			self::$managers[$entity] = new $class( self::getPdo() );
		}

		return self::$managers[$entity];
	}
}