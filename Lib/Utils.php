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

    /**
     * Get a value in $_POST by a key
     *
     * @param string $key The key of the data (like "key.foo.bar" for $_POST['key']['foo']['bar'])
     * @param array $array = array() Array where do the search instead of $_POST if given
     *
     * @return string The value
     */
	static public function postValue($keys, $array = array())
	{
		// Si pas de tableau en argument : utilisation du tableau POST
		if (empty($array)) { 
			$array = $_POST; 
		}

		// Recherche position premier "."
		$end = (strpos($keys, '.') !== false) ? strpos($keys, '.') : strlen($keys);
		// Extraction première clé
		$key = substr($keys, 0, $end);

		// Si la clé existe
		if (isset($array[ $key ]))
		{
			// Si elle contient un array
			if (is_array($array[ $key ]))
			{
				// Extraction clés suivantes
				$keys = substr(strstr($keys, '.'), 1);

				// Test suivant
				return Utils::postValue($keys, $array[ $key ]);
			}
			else
			{
				// Sinon renvoi de la valeur finale
				return $array[ $key ];
			}
		}
	}

	/**
     * Generate random string
     *
     * @param int $length = 10 Lenght of the string to generate
     *
     * @return string Generated string
     */
    static public function generateString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = '';

        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $random_string;
    }

    /**
     * Generate hash of a string
     *
     * @param string $string Le string to hash
     * @param string $salt = '' Salt to include in hash
     *
     * @return string String hashed
     */
    static public function hashString($string, $salt = '')
    {
        for ($i = 0; $i < 50000; $i++) {
            $string = hash('sha512', $string.$salt);
        }

        return $string;
    }
}