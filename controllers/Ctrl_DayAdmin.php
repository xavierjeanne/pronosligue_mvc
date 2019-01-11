<?php
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/TeamManager.php';
require_once 'models/UserManager.php';
require_once 'models/DayManager.php';

class ControllerDayAdmin extends Controller
{
	private $_teammanager;
	private $_usermanager;
	private $_daymanager;
	//CONSTRUCTEUR
	public function __construct()
	{
		$this->teammanager = new TeamManager();
		$this->usermanager = new UserManager();
		$this->daymanager = new DayManager();
	}
	//METHODE POUR AFFICHER LA PAGE PAR DEFAUT
	public function default($args=null)
	{
		//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
		$id=$_SESSION['id'];
		$user = $this->usermanager->getUser($id);
		if (($user->getAdmin())!=1)
		{
			throw new Exception('<p>Vous n\'êtes pas autorisé a accéder à cette page !!! </p><p> <a class="btn btn-dark" role="button" href="index.php?controller=connection&action=connection">Connexion</a></p>');
		}
		else
		{
			try
			{
				$arrayArgs=array('day'=>'','teams'=>'','type'=>'','message'=>'','id'=>'');
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
		         //SI LE TYPE EST VIDE ON VERIFIE L EXISTENCE DES PARAMETRES MESSAGE ET ID POUR LES TRANSMETTRE A LA VUE
		        if(empty($arrayArgs['type']))
		        {
			       	if(!empty($arrayArgs['message']))
			       	{
			       		$message=htmlspecialchars(trim($arrayArgs['message']));
			       	}
			       	else
			       	{
			       		$message='';
			       	}
			        $type='';
			        if(!empty($arrayArgs['id']))
			        {
			        	$day=htmlspecialchars($arrayArgs['id']);
			        }
			        else
			        {
						$day= $this->daymanager->getCurrentDay();
						
			        }
					$matchs =$this->daymanager->getDayScore($day);
					$view = new View("DayAdmin");
					$view->display(array('matchs'=>$matchs,'day'=>$day,'type'=>$type,'message'=>$message));	
		        }
		        else
		        {
		        	if($arrayArgs['type']=='updateMatch')		        	
		        	{
		        		$type=htmlspecialchars(trim($arrayArgs['type']));
		        		$id=htmlspecialchars(trim($arrayArgs['id']));
		        		$match = $this->daymanager->getMatch($id);
		        		$view->display(array('match'=>$match,'type'=>$type));
		        	}
		        	else
		        	{
		        		$type=htmlspecialchars(trim($arrayArgs['type']));
		        		$view->display(array('type'=>$type));
		        	}
		        }
			}
			catch (Exception $e)
			{
				//GESTION DES ERREURS
				$view = new View('Error');
				$view->display(array('messError' => $e->getMessage()));
			}
		}
	}
	//METHODE POUR AJOUTER UNE JOURNEE
	public function addDay($args=null)
	{
		//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
		$id=$_SESSION['id'];
		$user = $this->usermanager->getUser($id);
		if (($user->getAdmin())!=1)
		{
			throw new Exception('<p>Vous n\'êtes pas autorisé a accéder à cette pasge !!! </p><p> <a class="btn btn-dark" role="button" href="connection/connection">Connexion</a></p>');
		}
		else
		{
			$arrayArgs=array('day'=>'','home_team1'=>'','outside_team1'=>'','home_team2'=>'','outside_team2'=>'','home_team3'=>'','outside_team3'=>'','home_team4'=>'','outside_team4'=>'','home_team5'=>'','outside_team5'=>'','home_team6'=>'','outside_team6'=>'','home_team7'=>'','outside_team7'=>'','home_team8'=>'','outside_team8'=>'','home_team9'=>'','outside_team9'=>'','home_team10'=>'','outside_team10'=>'','home_team1'=>'','outside_team1'=>'','deadline1'=>'','heure1'=>'','deadline2'=>'','heure2'=>'','deadline3'=>'','heure3'=>'','deadline4'=>'','heure4'=>'','deadline4'=>'','heure4'=>'','deadline5'=>'','heure5'=>'','deadline6'=>'','heure6'=>'','deadline7'=>'','heure7'=>'','deadline8'=>'','heure8'=>'','deadline9'=>'','heure9'=>'','deadline10'=>'','heure10'=>'','submit'=>'');

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
        		for($i=1;$i<=10;$i++)
        		{
        		$day=htmlspecialchars(trim($arrayArgs['day']));
        		$deadline=htmlspecialchars($arrayArgs['deadline'.$i]);
		        $home_team=htmlspecialchars($arrayArgs['home_team'.$i]);
		  		$heure=htmlspecialchars($arrayArgs['heure'.$i]);
		  		$deadline=$deadline.' '.$heure;
				$outside_team=strtolower(htmlspecialchars(trim($arrayArgs['outside_team'.$i])));
		        $day = new Day(array('day'=>$day,'home_team'=>$home_team,'outside_team'=>$outside_team,'deadline'=>$deadline));
		        $message="Journee bien ajoutée";
		        //AJJOUT DE LA JOURNEE DANS LA BDD ET APPEL DE LA FONCTION DEFAULT
		        $this->daymanager->addDay($day);
        		}
		        $this->default(array('message'=>$message));		       
	        }
	         else
        	{
           	//PREMIER PASSAGE ON REDIRIGE SUR LE FOMULAIRE DE CONNECTION
        	$day= $this->daymanager->getLastDay();
			$teams =$this->teammanager->getTeams('name');
			$view = new View("DayAdmin");
            $view->display(array('type'=>'addDay','teams'=>$teams,'day'=>$day));
        	}
    	}
	}

	//METHODE POUR MODIFIER UNE JOURNEE
	public function UpdateMatch($args=null)
	{
		//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
		$id=$_SESSION['id'];
		$user = $this->usermanager->getUser($id);
		if (($user->getAdmin())!=1)
		{
			throw new Exception('<p>Vous n\'êtes pas autorisé a accéder à cette pasge !!! </p><p><a <a class="btn btn-dark" role="button" href="connection/connection">Connexion</p>');
		}
		else
		{
			$arrayArgs=array('id'=>'','day'=>'','home_team'=>'','outside_team'=>'','deadline'=>'','heure'=>'','submit'=>'');
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
	        $id=htmlspecialchars($arrayArgs['id']);
	         //SI LE FORMULAIRE A BIEN ETE ENVOYE
        	if ($arrayArgs['submit']!='')
        	{
		        //VERIFICATION DES VARIABLES DU FORMULAIRE
		        
				$day=htmlspecialchars(trim($arrayArgs['day']));
		        $home_team=htmlspecialchars(trim($arrayArgs['home_team']));
				$outside_team=htmlspecialchars(trim($arrayArgs['outside_team']));
				$deadline=htmlspecialchars(trim($arrayArgs['deadline']));
				$heure=htmlspecialchars($arrayArgs['heure']);
		  		$deadline=$deadline.' '.$heure;
		        $match = $this->daymanager->getMatch($id);
		        $match->setDay($day);
		        $match->setHome_team($home_team);
		        $match->setOutside_team($outside_team);
		        $match->setDeadline($deadline);
		        $this->daymanager->updateDay($match);
		        $message="Le match  a bien été modifié";
		        $this->default(array('message'=>$message));
		    }
		    else
        	{
           	//PREMIER PASSAGE ON REDIRIGE SUR LE FORMULAIRE 

        	$match= $this->daymanager->getMatch($id);
        	$teams=$this->teammanager->getTeams();
            $view = new View('DayAdmin');
            $view->display(array('type'=>'updateMatch','match'=>$match,'teams'=>$teams));
        	}
    	}
	}
}