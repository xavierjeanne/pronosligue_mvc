<?php 
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/UserManager.php';
require_once 'models/TeamManager.php';
require_once 'models/DayPointManager.php';

class ControllerProfil extends Controller
{
	private $usermanager;
	private $teammanager;
	private $daypointmanager;

    
    public function __construct() {
        $this->usermanager = new UserManager();
        $this->teammanager = new TeamManager();
        $this->daypointmanager = new DayPointManager();
    }

    public function default()
	{
		// SI L UTILISATEUR N EST PAS CONNECTE ON REVOI UNE ERREUR
		if (!isset($_SESSION['pseudo']))
		{
			throw new Exception('<p>Vous devez vous connecte pour acceder à cette page désolé !!!</p><p> <a class="btn btn-dark" role="button" href="index.php?controller=connection&action=connection">Connexion</a></p>');
		}
		elseif((isset($_SESSION['pseudo'])) and ($_SESSION['step']!=1))
		{
			//ON RECUPERE L ID DE SESSION POUR AFFICHER LA PAGE PROFIL DE L UTILISATEUR
			$id=$_SESSION['id'];
			$user = $this->usermanager->getUser($id);
			$teams = $this->teammanager->getTeams();
			$view = new View("Step");
			$view->display(array('user'=> $user,'teams'=>$teams));
		}
		else
		{
			try
			{
				//ON RECUPERE L ID DE SESSION POUR AFFICHER LA PAGE PROFIL DE L UTILISATEUR
				$id=$_SESSION['id'];

				// ON RECUPERE LES POINTS PAR JOURNEE DU MEMBRE
				$dayspoints = $this->daypointmanager->getAllDayPoints($id);
				$user = $this->usermanager->getUser($id);
				$podium1 = $user->getPodium1();
				$podium2 = $user->getPodium2();
				$podium3 = $user->getPodium3();
				$relegation18 = $user->getRelegation18();
				$relegation19 = $user->getRelegation19();
				$relegation20 = $user->getRelegation20();
				$podium1 = $this->teammanager->getTeam($podium1);
				$podium2 = $this->teammanager->getTeam($podium2);
				$podium3 = $this->teammanager->getTeam($podium3);
				$relegation18 = $this->teammanager->getTeam($relegation18);
				$relegation19 = $this->teammanager->getTeam($relegation19);
				$relegation20 = $this->teammanager->getTeam($relegation20);
				$view = new View("Profil");
				$view->display(array('user'=> $user,'dayspoints'=>$dayspoints,'podium1'=>$podium1,'podium2'=>$podium2,'podium3'=>$podium3,'relegation18'=>$relegation18,'relegation19'=>$relegation19,'relegation20'=>$relegation20));
			}
			catch (Exception $e)
			{
				//GESTION DES ERREURS
				$view = new View('Error');
				$view->display(array('messError' => $e->getMessage()));
			}
		}
	}

	//METHODE POUR METTRE A JOUR LES INFO DU PROFIL
	public function updateProfil($args=null)
	{
		// SI L UTILISATEUR N EST PAS CONNECTE ON REVOI UNE ERREUR
		if (!isset($_SESSION['pseudo']))
		{
			throw new Exception('<p>Vous devez vous connecte pour acceder à cette page désolé !!!</p><p> <a class="btn btn-dark" role="button" href="connection/connection">Connexion</a></p>');
		}
		else
		{
			try
			{
				$arrayArgs=array('pseudo'=>'','email'=>'','password'=>'','avatar'=>'','password_check'=>'','submit'=>'');
		       	// SI LE PARAMETRE EST UN TABLEAU NON VIDE
		        if(is_array($args) && !empty($args))
		       	{
		            // POUR CHAQUE CLEFS ON RECUPERE LA VALEUR
		            foreach($args as $keys => $value)
		            {
		               	//SI LA PROPRIETE DE LA CLASSE EXISTE ON MET A JOUR SA VALEUR
		                if(array_key_exists($keys, $arrayArgs))
		                {
		                    $arrayArgs[$keys] = $value;
		                }
		            }
		        }
				//SI LE FORMULAIRE A BIEN ETE ENVOYE
		        if ($arrayArgs['submit']!='')
		        {
		        	//ON RECUPERE L ID DE SESSION POUR POUVOIR INSTANCIER UN OBJET UTILISATEUR
					$id=$_SESSION['id'];
					$user = $this->usermanager->getUser($id);
		        	//VERIFICATION DES VARIABLES DU FORMULAIRE
					$pseudo=htmlspecialchars(trim($arrayArgs['pseudo']));
					$email=htmlspecialchars(trim($arrayArgs['email']));
					$password=htmlspecialchars(trim($arrayArgs['password']));
					$avatar=htmlspecialchars(trim($arrayArgs['avatar']));
					$password_check=htmlspecialchars(trim($arrayArgs['password_check']));
            		//ON VERIFIE QUE LES DEUX MOTS DE PASSE SONT IDENTIQUES
		            if($password==$password_check)
		            {
						//ON VERIFIE QUE LE PSEUDO OU L EMAIL N EST PAS DEJA PRIS 
		                if(!($this->usermanager->existUser($pseudo,$email,$id)))
		                {
		                	$password = hash('sha256', $password);
		                	$user->setPseudo($pseudo);
		                	$user->setEmail($email);
		                	$user->setPassword($password);
		                	$user->setAvatar($avatar);
		                    //ON ENREGISTRE LES DONNEES DANS LA BASE
		                   	$this->usermanager->updateUser($user);
		                   	$_SESSION['pseudo']=$pseudo;
		                   	$_SESSION['email']=$email;
		                   	//ON RECUPERE L ID DE SESSION POUR POUVOIR INSTANCIER UN OBJET UTILISATEUR
							$id=$_SESSION['id'];
							$user = $this->usermanager->getUser($id);
							$dayspoints = $this->daypointmanager->getAllDayPoints($id);
		                   	$message="le profil à bien été mis a jour";
		                   	$podium1 = $user->getPodium1();
							$podium2 = $user->getPodium2();
							$podium3 = $user->getPodium3();
							$relegation18 = $user->getRelegation18();
							$relegation19 = $user->getRelegation19();
							$relegation20 = $user->getRelegation20();
							$podium1 = $this->teammanager->getTeam($podium1);
							$podium2 = $this->teammanager->getTeam($podium2);
							$podium3 = $this->teammanager->getTeam($podium3);
							$relegation18 = $this->teammanager->getTeam($relegation18);
							$relegation19 = $this->teammanager->getTeam($relegation19);
							$relegation20 = $this->teammanager->getTeam($relegation20);
							$view = new View("Profil");
							$view->display(array('user'=> $user,'dayspoints'=>$dayspoints,'podium1'=>$podium1,'podium2'=>$podium2,'podium3'=>$podium3,'relegation18'=>$relegation18,'relegation19'=>$relegation19,'relegation20'=>$relegation20,'message'=>$message));
		                }
		                else
		                {
		                    $message = "Le pseudo ou l email est déjà pris";
		                    //ON REDIRIGE VERS LE FORMULAIRE DE MISE A JOUR AVEC UNE ERREUR
		                    $view = new View('UpdateProfil');
		                    $view->display(array('message'=>$message,'user'=>$user));
		                }
			        }
			        else
		            {
		                $_SESSION['pseudo_modification']=$pseudo;
		                $_SESSION['email_modification']=$email;
		                $message = "Les deux mot de passes ne sont pas identiques";
		                //ON REDIRIGE VERS LE FORMULAIRE DE MISE A JOUR AVEC DES VARIABLES DE SESSION POUR PREREMPLIR LE FORMUALAIRE
		                $view = new View('UpdateProfil');
		                $view->display(array('message'=>$message));
		            }
		        }
		        //PREMIER PASSAGE DANS LE FORMUALAIRE
		        else
		        {
		        	//ON RECUPERE L ID DE SESSION POUR POUVOIR INSTANCIER UN OBJET UTILISATEUR
					$id=$_SESSION['id'];
					$user = $this->usermanager->getUser($id);
					$teams = $this->teammanager->getTeams();
					//ON TRANSMET CET OBJET AU FORMULAIRE DE MODIFICATION
					$view = new View("UpdateProfil");
					$view->display(array('user'=> $user,'message'=>'','teams'=>$teams));
				}
			}
			catch (Exception $e)
			{

			$view = new View('Error');
			$view->display(array('messError' => $e->getMessage()));
			}
		}
	}
	//METHODE POUR METTRE A JOUR LES CLASSEMENT
	public function podium($args=null)
	{
	
	$arrayArgs=array('podium1'=>'','podium2'=>'','podium3'=>'','relegation18'=>'','relegation19'=>'','relegation20'=>'','user_id'=>'','submit'=>'');

	// SI LE PARAMETRE EST UN TABLEAU NON VIDE
	if(is_array($args) && !empty($args))
	{
	    // POUR CHAQUE CLEFS ON RECUPERE LA VALEUR
	    foreach($args as $keys => $value)
	    {
	    //SI LA PROPRIETE DE LA CLASSE EXISTE ON MET A JOUR SA VALEUR
	        if(array_key_exists($keys, $arrayArgs))
	        {
	            $arrayArgs[$keys] = $value;
	        }
	    }
	}
	//SI LE FORMULAIRE A BIEN ETE ENVOYE
    if ($arrayArgs['submit']!='')
    {
	//NETTOYAGE DES VARIABLES DU FORMULAIRE
		$podium1=htmlspecialchars($arrayArgs['podium1']);
		$podium2=htmlspecialchars($arrayArgs['podium2']);
		$podium3=htmlspecialchars($arrayArgs['podium3']);
		$relegation18=htmlspecialchars($arrayArgs['relegation18']);
		$relegation19=htmlspecialchars($arrayArgs['relegation19']);
		$relegation20=htmlspecialchars($arrayArgs['relegation20']);
		$user_id=htmlspecialchars(trim($arrayArgs['user_id']));
       	if(($podium1==$podium2)OR($podium1==$podium3)OR($podium1==$relegation18)OR($podium1==$relegation19)OR($podium1==$relegation20)OR($podium2==$podium3)OR($podium2==$relegation18)OR($podium2==$relegation19)OR($podium2==$relegation20)OR($podium3==$relegation18)OR($podium3==$relegation19)OR($podium3==$relegation20)OR($relegation18==$relegation19)OR($relegation18==$relegation20)OR($relegation19==$relegation20))
        {
        	$message="vous avez choisit deux fois le même club";
        	$view = new View('Podium');
        	$user = $this->usermanager->getUser($user_id);
        	$teams = $this->teammanager->getTeams();
        	$view->display(array('teams'=>$teams,'user'=>$user,'message'=>$message));
        }	
       	else 
        {
        	$user = $this->usermanager->getUser($user_id);
        	$user->setPodium1($podium1);
		    $user->setPodium2($podium2);
		    $user->setPodium3($podium3);
		    $user->setRelegation18($relegation18);
		    $user->setRelegation19($relegation19);
		    $user->setRelegation20($relegation20);
		    $this->usermanager->updateUser($user);
		    $dayspoints = $this->daypointmanager->getAllDayPoints($user_id);
			$user = $this->usermanager->getUser($user_id);
			$podium1 = $this->teammanager->getTeam($podium1);
            $podium2 = $this->teammanager->getTeam($podium2);
            $podium3 = $this->teammanager->getTeam($podium3);
            $relegation18 = $this->teammanager->getTeam($relegation18);
            $relegation19 = $this->teammanager->getTeam($relegation19);
            $relegation20 = $this->teammanager->getTeam($relegation20);
            $view = new View("Profil");
            $view->display(array('user'=> $user,'dayspoints'=>$dayspoints,'podium1'=>$podium1,'podium2'=>$podium2,'podium3'=>$podium3,'relegation18'=>$relegation18,'relegation19'=>$relegation19,'relegation20'=>$relegation20));
        }     
	}
	else
    {
    //PREMIER PASSAGE DANS LE FORMULAIRE
    	$user_id=$_SESSION['id'];
		$message="";
        $view = new View('Podium');
        $teams = $this->teammanager->getTeams();
        $user = $this->usermanager->getUser($user_id);
        $view->display(array('teams'=>$teams,'user'=>$user,'message'=>$message));
        }
	}
}