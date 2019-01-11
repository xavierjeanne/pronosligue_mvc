<?php 
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';;
require_once 'models/DayManager.php';
require_once 'models/UserManager.php';
require_once 'models/Score.php';



class ControllerScore extends Controller
{
	
	private $_daymanager;
	private $_usermanager;
	private $_score;
	
	
	
	//CONSTRUCTEUR
	public function __construct()
	{
		
		$this->daymanager = new DayManager();
		$this->usermanager = new UserManager();
		$this->score = new Score();
		
	}
	//PAGE PAR DEFAUT POUR VALIDER LES SCORES
	public function default($args='')
	{
		//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
		$id=$_SESSION['id'];
		$user = $this->usermanager->getUser($id);
		if (($user->getAdmin())!=1)
		{
			throw new Exception('<p>Vous n\'êtes pas autorisé a accéder à cette pasge !!! </p><p> <a class="btn btn-dark" role="button "href="index.php?controller=connection&action=connection">Connexion</p>');
		}
		else
		{
			$arrayArgs=array('home_goal'=>'','outside_goal'=>'','id'=>'','submit'=>'');
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
				$id=htmlspecialchars(trim($arrayArgs['id']));
		        $home_goal=htmlspecialchars(trim($arrayArgs['home_goal']));
				$outside_goal=htmlspecialchars(trim($arrayArgs['outside_goal']));
				//DETERMINATION DU SCORE EN FONCTION DES BUTS
		        if($home_goal==$outside_goal)
		        {
		        	$score=2;
		        }
		        elseif($home_goal<$outside_goal)
		        {
		        	$score=3;
		        }
		        else
		        {
		        	$score=1;
		        }
		        //MIS A JOUR DES SCORES
		        $match = $this->daymanager->getMatch($id);
		        $match->setHome_goal($home_goal);
		        $match->setOutside_goal($outside_goal);
		        $match->setScore($score);
		      	//VALIDATION DES SCORES ET DES PRONOSTICS
		      	$this->daymanager->updateDay($match);
		       	if($this->score->validateScore($match))
		       	{
		        $day = $match->getDay();
		        $type = '';
		        $message="Match bien validée";
		       	$matchs =$this->daymanager->getDayScore($day);
				$view = new View("DayAdmin");
				$view->display(array('matchs'=>$matchs,'day'=>$day,'type'=>$type,'message'=>$message));
		       	}
			}
	        else
        	{
	           	//PREMIER PASSAGE ON REDIRIGE SUR LE FOMULAIRE DE CONNECTION
	        	$id=htmlspecialchars(trim($arrayArgs['id']));	
	        	$match= $this->daymanager->getMatchView($id);
	            $view = new View('Score');
	            $view->display(array('match'=>$match));
        	}
		}
	}
}	