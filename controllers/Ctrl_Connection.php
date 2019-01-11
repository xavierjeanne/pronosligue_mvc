<?php
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/Connection.php';
require_once 'models/UserManager.php';
require_once 'models/DayManager.php';
require_once 'models/DayPointManager.php';


class ControllerConnection extends Controller
{
	private $connection;
    private $usermanager;
    private $daymanager;
    private $daypointmanager;
	
    
    public function __construct() {
        
        $this->connection = new Connection();
        $this->usermanager = new UserManager();
        $this->teammanager = new TeamManager();
        $this->daymanager = new DayManager();
        $this->daypointmanager = new DayPointManager();
        
    }

    // METHODE DE CONNEXION ON RECUPERE LE NOM LE MOT DE PASSSE ET LE BOUTON DE VALIDATION
    function connection($args=null)
    {
        $arrayArgs=array('pseudo'=>'','password'=>'','avatar'=>'','submit'=>'');
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
        	//VERIFICATION DES VARIABLES DU FORMULAIRE
			$pseudo=htmlspecialchars(trim($arrayArgs['pseudo']));
			$password=htmlspecialchars(trim($arrayArgs['password']));
			//ON VERIFIE QUE LES PSEUDO ET MOT DE PASSE CORRESPONDENT
            if($this->connection->getConnection($pseudo,$password))
            {
            $id=$_SESSION['id'];
            $user = $this->usermanager->getUser($id);
            $teams = $this->teammanager->getTeams();
            $dayspoints = $this->daypointmanager->getAllDayPoints($id);
            //ON REDIRIGE VERS LA PAGE PROFIL
                if($_SESSION['step']!=1)
                {
                    $view = new View("Step");
                    $view->display(array('user'=> $user,'teams'=>$teams)); 
                }
                else
                {
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
            }
        }
        else
        {
           	//PREMIER PASSAGE ON REDIRIGE SUR LE FOMULAIRE DE CONNECTION

            $view = new View('Connection');
            $view->display(array('message'=>''));



        }
    }

    //METHODE POUR LA DECONNEXION
    function deconnection()
    {
        try
        {
            //ON SUPPRIME LES VARIABLES DE SESSIONS
            session_unset ();
            //ON RECUPERE LE NUMERO DE LA JOURNEE EN COURS 
            if(!empty($this->daymanager->getCurrentDay()))
            {
                    $day=$this->daymanager->getCurrentDay();
            }
            else
            {
                    $day=$this->daymanager->getLastDay();
            }
            $matchs = $this->daymanager->getDay($day);
            //ON GENERE LA VUE HOME AVEC LES PARAMTERE 
            $view = new View("Home");
            $view->display(array('matchs'=> $matchs,'day'=>$day));
        }
        catch (Exception $e)
        {
            $view = new View('error');
            $view->display(array('messError' => $e->getMessage()));
        }
    }
    public function default()
    {
    }
}
