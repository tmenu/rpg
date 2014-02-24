<?php
 
/**
 * Fichier : /Lib/Utils.php
 * Description : 
 * Auteur Thomas Menu
 * Date : 24/02/2014
 */
 
namespace Lib;

class Utils
{
    public static function redirect($url)
    {
        header('Location:'.$url);
        exit;
    }
}