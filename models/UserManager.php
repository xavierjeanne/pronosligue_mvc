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
		$request = "SELECT * FROM users ORDER BY total_point DESC";
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
	public function existUser($pseudo="",$email="",$id="")
	{
		//SI UN ID A ETE TRANSMIS ON EXCUTE LA RECHERCHE EN EXCLAUNT CET ENREGSITREMENT
		if(isset($id) AND !empty($id))
		{
			$request = "SELECT id FROM users WHERE (pseudo=? OR email=?) AND (id!=?)";
			$results = $this->requestExec($request,array($pseudo,$email,$id));
		}
		else
		{
			$request = "SELECT id FROM users WHERE pseudo=? OR email=?";
			$results = $this->requestExec($request,array($pseudo,$email));
		}
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
	public function addUser(User $user)
	{
		$request = "INSERT INTO users (pseudo,password,email,created_at,updated_at) VALUES (?,?,?,?,?)";
		$created_at=date("Y-m-d H:i:s");
		$updated_at=date("Y-m-d H:i:s");
		$results = $this->requestExec($request,array(
						$user->getPseudo(),
						$user->getPassword(),
						$user->getEmail(),
						$created_at,
						$updated_at
			));
	}
	// //METHODE POUR METTRE A JOUR UN UTILISATEUR
	public function updateUser(User $user)
	{
		$request = "UPDATE users SET pseudo=?,avatar=?,notification=?,total_point=?,total_day_point=?,bonus_10=?,bonus_9=?,bonus_8=?,bonus_7=?,podium_1=?,podium_2=?,podium_3=?,relegable_18=?,relegable_19=?,relegable_20=?,ranking=?,ranking_before=?,step=?,password=?,email=?,admin=?,created_at=?,updated_at=? WHERE id = ? ";
		$updated_at=date("Y-m-d H:i:s");
		$results = $this->requestExec($request,array(
						$user->getPseudo(),
						$user->getAvatar(),
						$user->getNotification(),
						$user->getTotal_point(),
						$user->getTotal_day_point(),
						$user->getBonus_10(),
						$user->getBonus_9(),
						$user->getBonus_8(),
						$user->getBonus_7(),
						$user->getPodium_1(),
						$user->getPodium_2(),
						$user->getPodium_3(),
						$user->getRelegable_18(),
						$user->getRelegable_19(),
						$user->getRelegable_20(),
						$user->getRanking(),
						$user->getRanking_before(),
						$user->getStep(),
						$user->getPassword(),
						$user->getEmail(),
						$user->getAdmin(),
						$user->getCreated_at(),
						$updated_at,
						$user->getId()
			));
	}
	//METHODE POUR EFFACER UN UTILISATEUR
	 public function delete(User $user)
  	{
  		$request = "DELETE FROM users WHERE id = ?";
    	//ON APPELLE LA METHODE REQUETE DU MODELE
		$results = $this->requestExec($request,array($user->getId()));
  	}
}
	