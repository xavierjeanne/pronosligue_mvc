<?php 
//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';
require_once 'models/User.php';
require_once 'models/TeamManager.php';



class UserManager extends Model
{
	//METHODE POUR AFFICHER LA LISTE DES UTILISATEURS
	public function getUsers()
	{
		$this->rangeUsers();
		$users = [];
		//PREPARATION DE LA REQUETE, ON AFFICHE LA LISTE DES MEMBRES CLASSEES PAR POINT
		$request = "SELECT * FROM users ORDER BY total_point DESC,total_bonus DESC, bonus10 DESC, bonus9 DESC, bonus8 DESC, bonus7 DESC";
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
		//SI UN ID A ETE TRANSMIS C EST DONC UN UPDATE D UN PROFIL EXISTANT 
		//ON EXECUTE LA RECHERCHE EN EXCLAUNT CET ENREGSITREMENT
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
		$request = "SELECT 1 + count(*) as ranking FROM users";
		$results = $this->requestExec($request);
		$data = $results->fetch();
		$ranking = $data['ranking'];
		$ranking_before = $data['ranking'];
		$requestbis = "INSERT INTO users (pseudo,avatar,password,email,ranking,ranking_before) VALUES (?,?,?,?,?,?)";
		$resultsbis = $this->requestExec($requestbis,array(
						$user->getPseudo(),
						$user->getAvatar(),
						$user->getPassword(),
						$user->getEmail(),
						$ranking,
						$ranking_before
			));
	}
	// //METHODE POUR METTRE A JOUR UN UTILISATEUR
	public function updateUser(User $user)
	{
		$request = "UPDATE users SET pseudo=?,avatar=?,total_point=?,total_bonus=?,point=?,bonus7=?,bonus8=?,bonus9=?,bonus10=?,podium1=?,podium2=?,podium3=?,relegation18=?,relegation19=?,relegation20=?,step=?,password=?,email=?,admin=?,stake=?,ranking=?,ranking_before=? WHERE id = ? ";
		$results = $this->requestExec($request,array(
						$user->getPseudo(),
						$user->getAvatar(),
						$user->getTotal_point(),
						$user->getTotal_bonus(),
						$user->getPoint(),
						$user->getBonus7(),
						$user->getBonus8(),
						$user->getBonus9(),
						$user->getBonus10(),
						$user->getPodium1(),
						$user->getPodium2(),
						$user->getPodium3(),
						$user->getRelegation18(),
						$user->getRelegation19(),
						$user->getRelegation20(),
						$user->getStep(),
						$user->getPassword(),
						$user->getEmail(),
						$user->getAdmin(),
						$user->getStake(),
						$user->getRanking(),
						$user->getRanking_before(),
						$user->getId()
			));
		$this->rangeUsers();
	}
	// METHODE POUR CLASSER LES EQUIPES
	public function rangeUsers()
	{
		$this->bonusUsers();
		$request = "SELECT * FROM users ORDER BY total_point DESC ,total_bonus DESC,bonus10 DESC,bonus9 DESC,bonus8 DESC, bonus7 DESC";
		$results = $this->requestExec($request);
		$i=1;
		while($data = $results->fetch())
		{
			$user = new User($data);
			$ranking=$i;
			$ranking_before=$user->getRanking();
			$requestbis ="UPDATE users SET total_point=total_bonus + point,ranking=?,ranking_before=? WHERE id = ?";
			$resultsbis = $this->requestExec($requestbis,array(
							$ranking,
							$ranking_before,
							$user->getId()
			));
			$i++;
		}

	}
	//METHODE POUR ATTRIBUER LES BONUS
	public function bonusUsers()
	{
		$teammanager = new Teammanager();
		$teams = $teammanager->rangeTeams();
		//PREPARATION DE LA REQUETE, ON AFFICHE LA LISTE DES MEMBRES CLASSEES PAR POINT
		$request = "SELECT * FROM users";
		//ON APPELLE LA METHODE REQUETE DU MODELE
		$results = $this->requestExec($request);
		while($data = $results->fetch())
		{
			$user = new User($data);
			$total_bonus=0;
			$total_bonus_podium = 0;
			$total_bonus_relegation = 0;
			if((($user->getPodium1()==$teams[0])AND($user->getPodium2()!=$teams[1])AND($user->getPodium3()!=$teams[2]))OR(($user->getPodium1()!=$teams[0])AND($user->getPodium2()==$teams[1])AND($user->getPodium3()!=$teams[2]))OR(($user->getPodium1()!=$teams[0])AND($user->getPodium2()!=$teams[1])AND($user->getPodium3()==$teams[2])))
			{
				$total_bonus_podium = 1;
			}
			elseif((($user->getPodium1()==$teams[0])AND($user->getPodium2()==$teams[1])AND($user->getPodium3()!=$teams[2]))OR(($user->getPodium1()==$teams[0])AND($user->getPodium2()!=$teams[1])AND($user->getPodium3()==$teams[2]))OR(($user->getPodium1()!=$teams[0])AND($user->getPodium2()==$teams[1])AND($user->getPodium3()==$teams[2])))
			{
				$total_bonus_podium = 3;
			}
			elseif(($user->getPodium1()==$teams[0])AND($user->getPodium2()==$teams[1])AND($user->getPodium3()==$teams[2]))
			{
				$total_bonus_podium = 5;
			}
			if((($user->getRelegation18()==$teams[3])AND($user->getRelegation19()!=$teams[4])AND($user->getRelegation20()!=$teams[5]))OR(($user->getRelegation18()!=$teams[3])AND($user->getRelegation19()==$teams[4])AND($user->getRelegation20()!=$teams[5]))OR(($user->getRelegation18()!=$teams[3])AND($user->getRelegation19()!=$teams[4])AND($user->getRelegation20()==$teams[5])))
			{
				$total_bonus_relegation = 1;
			}
			elseif((($user->getRelegation18()==$teams[3])AND($user->getRelegation19()==$teams[4])AND($user->getRelegation20()!=$teams[5]))OR(($user->getRelegation18()==$teams[3])AND($user->getRelegation19()!=$teams[4])AND($user->getRelegation20()==$teams[5]))OR(($user->getRelegation18()!=$teams[3])AND($user->getRelegation19()==$teams[4])AND($user->getRelegation20()==$teams[5])))
			{
				$total_bonus_relegation = 3;
			}
			elseif(($user->getRelegation18()==$teams[3])AND($user->getRelegation19()==$teams[4])AND($user->getRelegation20()==$teams[5]))
			{
				$total_bonus_relegation = 5;
			}
			$total_bonus = $total_bonus_podium + $total_bonus_relegation;
			$requestbis ="UPDATE users SET total_bonus=? WHERE id = ?";
			$resultsbis = $this->requestExec($requestbis,array(
							$total_bonus,
							$user->getId()
			));
		}

	}
	//METHODE POUR EFFACER UN UTILISATEUR
	 public function delete(User $user)
  	{
  		$request = "DELETE FROM users WHERE id = ?";
    	//ON APPELLE LA METHODE REQUETE DU MODELE
		$results = $this->requestExec($request,array($user->getId()));
  	}
}
	