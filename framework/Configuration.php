<?php

class Configuration 
{
	//CLASS STATIC QUI PERMET DE DEFINIR LES PARAMETRES DE CONNEXION A LA BASE DE DONNEES
	private static $_parameters;

	//METHODE QUI RETOURNE SOUS FORME DE TABLEAU LES PARAMETRES CONTENU DANS UN FICHIER INI
	private static function getConfig() 
	{
		// SI LE TABELAU D N EXISTE PAS
		if (self::$_parameters == null) 
		{
			//ON DEFINIT LE CHEMIN  DU FICHIER DE PROD
			$file_path = "config/prod.ini";

			//SI LE FICHIER DE PROD N EXISTE PAS ON CHARGE CEUX DE DEV
			if (!file_exists($file_path)) 
			{
				// ON DEFINIT LE CHEMIN DU FICHIER DE DEV
				$file_path = "config/dev.ini";
			}
			if (!file_exists($file_path)) 
			{
				throw new Exception("Aucun fichier de configuration trouvé");
			}
			else 
			{
				//ON AFFECTE LE TABLEAU DE VARIABLE DU FICHIER INI A LA VARAIBLE PARAMETRE
				self::$_parameters = parse_ini_file($file_path);
			}
		}
		return self::$_parameters;
	}

	//METHODE QUI RENVOIE LA VALEUR D UN PARAMETRE DE CONFIGURATION
	public static function getParam($name, $value=null) 
	{
		// ON VERIFIE QUE L INDICE  EXISTE ET ON RENVOIE SA VALEUR
		if (isset(self::getConfig()[$name])) 
		{
			$value = self::getConfig()[$name];
		}
		else 
		{
			$value = $value;
		}
		return $value;
	}
}
