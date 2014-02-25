<?php

/**
 * Fichier : /Library/ApplicationComponent/Session.php
 * Description : Gestion de la session utilisateur
 * Auteur Thomas Menu
 * Date : 08/12/2013
 */

namespace Lib;

class Session
{
	public static function isAuth()
	{
		return $_SESSION['auth'];
	}

	public static function setAuth($bool)
	{
		$_SESSION['auth'] = $bool;
	}

	/**
	 * Méthode : setFlashMessage()
	 * Description : Définit un message flash qui sera affiché sur la prochaine page
	 * @param string : Le type de message (danger, success, warning, info)
	 * @param string : Le message
	 * @return void
	 */
	public static function setFlashMessage($type, $message)
	{
		$_SESSION['flash_messages'][] = array(
			'type' => $type, 
			'message' => $message
		);
	}

	/**
	 * Méthode : getFlashMessage()
	 * Description : Récupère les messages flash
	 * @param void
	 * @return array La liste des messages flash
	 */
	public static function getFlashMessage()
	{
		if (!isset($_SESSION['flash_messages'])) {
			return false;
		}

		$tmp = $_SESSION['flash_messages'];
		unset($_SESSION['flash_messages']);

		return $tmp;
	}
}