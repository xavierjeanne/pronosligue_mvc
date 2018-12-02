<?php 
//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';
require_once 'models/User.php';

class UserManager extends Model
{
	//METHODE POUR AFFICHER LA LISTE DES UTILISATEURS
	public function getUsers()
	{
		$users = [];
		//PREPARATION DE LA REQUETE
		$request = "SELECT * FROM users ORDER BY pseudo DESC";
		//ON APPELLE LA METHODE REQUETE DU MODELE
		$results = $this->requestExec($request);
		while($data = $results->fetch())
		{
			$users[] = new User($data);
		}
		return $users;
	}

	//METHODE POUR AFFICHER UN UTILISATEUR
	public function getUser($id="") 
	{

	  	$request = "SELECT * FROM users WHERE id=?";
	  	$results = $this->requestExec($request,array($id));
	  	//ON ACCEDE A LA PREMIERE LIGNE DE RESULTAT
	  	if ($results->rowCount() == 1)
	  	{
	    	$data = $results->fetch(); 
	    	//ON RENVOIE UN OBJET UTILISATEUR
	    	return new User($data);
	  	}
	  	else
	  	{
	  		throw new Exception("Aucun utilisateur n'a été trouvé");
	  	}
	}
	//METHODE POUR CONNAITRE L UNICITE D UN UTILISATEUR PAR RAPPORT A SON PSEUDO OU A SON EMAIL
	public function existUser($pseudo="",$email="")
	{
		$request = "SELECT * FROM users WHERE pseudo=? OR email=?";
		$results = $this->requestExec($request,array($pseudo,$email));
		//ON VERIFIE SI UN UTILISATEUR EXISTE DEJA 
	  	if ($results->rowCount() == 1)
	  	{
	    	return true;
	  	}
	  	else
	  	{
	  		return false;
	  	}
	}
	//METHODE POUR AJOUTER UN UTILISATEUR
	public function addUser($pseudo="",$password="",$email="")
	{
		$request = "INSERT INTO users (pseudo,password,email,created_at,updated_at) VALUES (?,?,?,?,?)";
		$created_at=date("Y-m-d H:i:s");
		$updated_at=date("Y-m-d H:i:s");
		$results = $this->requestExec($request,array(
						$pseudo,
						$password,
						$email,
						$created_at,
						$updated_at
			));
	}
	
}
	