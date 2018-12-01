<?php
class HttpRequest {

	//CLASS PERMETTANT DE CREER DES OBJETS POUR LE TRAITEMENT DES REQUETES HTTP

	//TABLEAU CONTENANT LES PARAMETRE DE LA REQUETE
	private $arrayParameters;

	public function __construct($parameters) {
		$this->arrayParameters = $parameters;
	}

	//RENVOI TRUE SI LAE PARAMETRE EXISTE DANS LA REQUETE ET N EST PAS VIDE
	public function existParam($name) 
	{
		return (isset($this->arrayParameters[$name]) && ($this->arrayParameters[$name] != ''));
	}
	
	//RENVOI LA VALEUR DU PARAMETRE
	public function getParam($name) 
	{
		if ($this->existParam($name)) 
		{
			return $this->arrayParameters[$name];
		}
		else
		{
			throw new Exception("Le paramètre $name est absent de la requête HTTP");	
		}
		
	}

	// RENVOI LE TABLEAU DES PARAMETRES
	public function getArrayParams()
	{
		return $this->arrayParameters; 
	}
	
}
