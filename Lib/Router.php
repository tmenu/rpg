<?php
 
/**
 * Fichier : /Lib/Router.php
 * Description : Routage des URL vers les Applications, controlleurs et actions correspondants
 * Auteur Thomas Menu
 * Date : 08/12/2013
 */
 
namespace Lib;

class Router
{
    public static $routes = array(); // Tableau des routes

    /**
     * Constructeur du router
     * @param void
     * @return void
     */
    /*public function __construct()
    {
        // Récupération des routes
        self::$routes = json_decode(file_get_contents(realpath(__DIR__.'/../config/routes.json')), true);
    }*/

    /**
     * Recherche d'une route à partir d'une URL
     * @param string L'URL à rechercher
     * @return obj Route : route correspondante
     */
    public static function matchRoute($uri)
    {
        if (empty(self::$routes)) {
            // Récupération des routes
            self::$routes = json_decode(file_get_contents(realpath(__DIR__.'/../config/routes.json')), true);
        }

        // Parcours des diffèrentes routes
        foreach (self::$routes as $key => $route)
        {
            // Si c'est une commentaire : on ignore
            if ($key == '_comment') {
                continue;
            }

            // Création du mask de la regex
            $regex = '#^' . $route['regex'] . '(\?.)*$#';

            // S'il y a des paramètres
            if (isset($route['params']) && !empty($route['params']))
            {
                // Mise en place des mask pour les paramètres
                foreach ($route['params'] as $key => $value) {
                    $regex = str_replace($key, $value, $regex);
                }
            }

            // Si la route correspond : on la renvoi avec ses paramètres
            if (preg_match($regex, $uri, $params))
            {
                $route['data'] = array();

                // S'il y a des paramètres
                if (isset($route['params']) && !empty($route['params']))
                {
                    $i = 1;
                    foreach ($route['params'] as $key => $value) {
                        $route['data'][substr($key, 1)] = $params[$i++];
                    }
                }

                // Renvois de la route correspondante avec ses paramètres
                return $route;
            }
        }

        // Erreur 404 : aucune route trouvé
        return false;
    }

    /**
     * Generate an URL with a given route name
     *
     * @param string $rout_name The name of the route you would generate
     * @param array $params = array() The params for the URL
     *
     * @return string $url The generated URL
     */
    public static function generateUrl($route_name, array $params = array())
    {
        if (empty(self::$routes)) {
            // Récupération des routes
            self::$routes = json_decode(file_get_contents(realpath(__DIR__.'/../config/routes.json')), true);
        }
        
        // Si la route demandée n'existe pas
        if (!self::$routes[$route_name]) {
            throw new Exception('Route '. $route_name . ' doesn\'t exists !');
        }

        // Génération de l'URL
        $route = self::$routes[$route_name];

        $url = $route['regex'];

        // Mise en place des paramètres fournit
        if (isset($route['params'])) {
            $i = 0;
            foreach ($route['params'] as $key => $regex) {
                $url = str_replace('('.$key.')', $params[$i++], $url);
            }
        }

        return $url;
    }
}