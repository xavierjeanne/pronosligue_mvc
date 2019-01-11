<?php 
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/UserManager.php';
require_once 'models/TeamManager.php';
require_once 'models/DayPointManager.php';

class ControllerStep extends Controller
{
	private $usermanager;
	private $teammanager;
	private $daymanager;
    
    public function __construct() {
        $this->usermanager = new UserManager();
        $this->teammanager = new TeamManager();
        $this->daypointmanager = new DayPointManager();
    }

    public function default($args='')
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
        			$view = new View('Step');
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
		            $user->setStep(1);
		            $this->usermanager->updateUser($user);
		            $_SESSION['step']=1;
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
			   	$message="";
        		$view = new View('Step');
        		$teams = $this->teammanager->getTeams();
        		$user = $this->usermanager->getUser($user_id);
        		$view->display(array('teams'=>$teams,'user'=>$user,'message'=>$message));
        	}
	}
}