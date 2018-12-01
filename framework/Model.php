<?php
require_once 'Configuration.php';

abstract class Model
{
	private $_pdo;

	
	//METHODE POUR LA CONNEXION A LA BASE DE DONNEES
	private function getConnex()
	{
		// ON VERIFIE SI IL N Y PAS DEJA DE CONNEXION
		if ($this->_pdo == null) 
		{
			//PARAMETRE DE LA CONNEXION RECUPERE GRACE A LA CLASSE CONFIGURATION
			$host = Configuration::getParam('host');	
			$dbname = Configuration::getParam('dbname');
			$user = Configuration::getParam('user');			
			$password = Configuration::getParam('password');;			

			try
			{
				$this->_pdo = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=UTF8', $user,$password);
			}
			catch (PDOException $e)
			{
				//GESTION DES ERREURS
				throw new Exception('Erreur PDO : ' . utf8_encode($e->getMessage()), $e->getCode());
			}
		}
		// ON RETOURNE LA CONNEXION
		return $this->_pdo;
	}

	//METHODE POUR EXECUTER DES REQUETES

	public function requestExec($request, $args = null)
	{
		//ON RECUPERE OU CREE UNE CONNEXION
		$pdo = $this->getConnex();

		// SI IL N Y A PAS DE PARAMETRE ON EXECUTE UNE REQUETE SIMPLE
		if ($args == null) 
		{
			$results=$pdo->query($request);
		}
		else 
		{
			//SINON ON PREPARE LA REQUETE ET ON L EXECUTE AVEC LES PARAMETRES
			$results = $pdo->prepare($request);

			
			$results->execute($args);
		}
		// ON RETOURNE LE RESULTAT DE LA REQUETE
		return $results;
	}
}
