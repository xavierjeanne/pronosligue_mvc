<?php 
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/BetManager.php';
require_once 'models/DayManager.php';
require_once 'models/DayPointManager.php';
require_once 'models/UserManager.php';

class ControllerBet extends Controller
{
	private $_betmanager;
	private $_usermanager;
	private $_daymanager;
	private $_daypointmanager;
	//CONSTRUCTEUR
	public function __construct()
	{
		$this->usermanager = new UserManager();
		$this->betmanager = new BetManager();
		$this->daymanager = new DayManager();
		$this->daypointmanager = new DayPointManager();
	}
	//PAGE PAR DEFAUT
	public function default($args=null)
	{
		//ON VERIFIE SI L UTILISATEUR EST CONNECTE
		if(!isset($_SESSION['pseudo']))
		{
			throw new Exception('<p>Vous devez vous connecter pour accéder au pronostic !!!</p><p> <a class="btn btn-dark" role="button" href="index.php?controller=connection&action=connection">Connexion</a></p>');
		}
		elseif((isset($_SESSION['pseudo'])) and ($_SESSION['step']!=1))
		{
			//ON RECUPERE L ID DE SESSION POUR AFFICHER LA PAGE PROFIL DE L UTILISATEUR
			$id=$_SESSION['id'];
			$user = $this->usermanager->getUser($id);
			$view = new View("Step");
			$view->display(array('user'=> $user));
		}
		else
		{
			try
			{
				$arrayArgs=array('match_id'=>'','message'=>'','user_id'=>'','bet'=>'','score'=>'','id'=>'','type'=>'');
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
			        //CREATION D OBJET DAY ET MATCHS POUR LES TRANSMETTRE A LA VUE
			       	$bets = $this->betmanager->getBets($day,$_SESSION['id']);
					$matchs =$this->daymanager->getDay($day);
					$view = new View("Bet");
					$view->display(array('matchs'=>$matchs,'bets'=>$bets,'day'=>$day,'message'=>$message));	
		        }
		        else
		        {
		        	//SI LE TYPE EST UPDATEBET ON REDIRIGE VERS LA VUE AVEC LES PARAMETRES MIS A JOUR
		        	if($arrayArgs['type']=='updateBet')		        	
		        	{
		        		$type=htmlspecialchars(trim($arrayArgs['type']));
		        		$day=htmlspecialchars(trim($arrayArgs['day']));
		        		$matchs = $this->daymanager->getDay($day);
		        		$bets = $this->betmanager->getBets($day,$user_id);
		        		$view->display(array('matchs'=>$matchs,'day'=>$day,'bets'=>$bet,'type'=>$type));
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
	public function addBet($args=null)
	{
		if(!isset($_SESSION['pseudo']))
		{
			//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
			throw new Exception('<p>Vous devez vous connecter pour accéder au pronostic !!! </p><p><a <a class="btn btn-dark" role="button" href="connection/connection">Connexion</a></p>');
		}
		else
		{
			$arrayArgs=array('match_id1'=>'','bet1'=>'','match_id2'=>'','bet2'=>'','match_id3'=>'','bet3'=>'','match_id4'=>'','bet4'=>'','match_id5'=>'','bet5'=>'','match_id6'=>'','bet6'=>'','match_id7'=>'','bet7'=>'','match_id8'=>'','bet8'=>'','match_id9'=>'','bet9'=>'','match_id10'=>'','bet10'=>'','match_id1'=>'','bet1'=>'','user_id'=>'','id'=>'','score'=>'','submit'=>'');

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
        		for($i=1;$i<=10;$i++)
        		{
        		$day=htmlspecialchars($arrayArgs['id']);
		        $match_id=htmlspecialchars($arrayArgs['match_id'.$i]);
				$bet=htmlspecialchars(trim($arrayArgs['bet'.$i]));
				$user_id=htmlspecialchars(trim($arrayArgs['user_id']));
		        $bet = new Bet(array('match_id'=>$match_id,'user_id'=>$user_id,'bet'=>$bet));
		        $message="Pronostics bien ajoutée";
		        //AJOUT DU PRONOSTIC DANS LA BASE DE DONNEES
		        $this->betmanager->addBet($bet);
        		}
        		//ON CREER AUSSI UNE LIGNE DANS DAYPOINT UNE FOIS QUE LES PRONOS ONT ETE ENREGISTRE
		        $daypoint = new DayPoint(array('user_id'=>$user_id,'day'=>$day,'day_point'=>0));
		       	$this->daypointmanager->addDayPoint($daypoint);
		       	//ON RENVOIE VERS LA LA METHODE DEFAUT DE LA CLASSE AVEC LES PARAMETRES MIS A JOUR
		        $this->default(array('message'=>$message,'id'=>$day));		       
	        }
	        else
        	{
        		//PREMIER PASSAGE DANS LE FORMULAIRE
			    $day=htmlspecialchars(trim($arrayArgs['id']));
			    $matchs = $this->daymanager->getDay($day);
			    $view= new View('Bet');
			    $view->display(array('matchs'=>$matchs,'day'=>$day,'type'=>'addBet'));
        	}
    	}
	}
	//METHODE POUR MODIFIER LES PRONOSTICS
	public function updateBet($args=null)
	{
		if(!isset($_SESSION['pseudo']))
		{
			//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
			throw new Exception('<p>Vous devez vous connecter pour accéder au pronostic !!! </p><p><a <a class="btn btn-dark" role="button" href="connection/connection">Connexion</a></p>');
		}
		else
		{
			$arrayArgs=array('match_id1'=>'','bet1'=>'','match_id2'=>'','bet2'=>'','match_id3'=>'','bet3'=>'','match_id4'=>'','bet4'=>'','match_id5'=>'','bet5'=>'','match_id6'=>'','bet6'=>'','match_id7'=>'','bet7'=>'','match_id8'=>'','bet8'=>'','match_id9'=>'','bet9'=>'','match_id10'=>'','bet10'=>'','match_id1'=>'','bet1'=>'','user_id'=>'','id'=>'','score'=>'','submit'=>'');

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
	        $day=htmlspecialchars($arrayArgs['id']);
	           //SI LE FORMULAIRE A BIEN ETE ENVOYE
        	if ($arrayArgs['submit']!='')
        	{
	        //VERIFICATION DES VARIABLES DU FORMULAIRE
        		for($i=1;$i<=10;$i++)
        		{
		        $match_id=htmlspecialchars($arrayArgs['match_id'.$i]);
				$bet=htmlspecialchars(trim($arrayArgs['bet'.$i]));
				$user_id=htmlspecialchars(trim($arrayArgs['user_id']));
		        $bet_match = $this->betmanager->getBet($user_id,$match_id);
		        $bet_match->setBet($bet);
		        $message="Pronostics bien modifié";
		        //MODIFICATION DES PRONOS
		        $this->betmanager->updateBet($bet_match);
        		}
		        $this->default(array('message'=>$message,'id'=>$day));		       
	        }
	         else
        	{
        		//PREMIER PASSAGE DANS LE FORMULAIRE
	        	$bets = $this->betmanager->getBetsForm($day,$_SESSION['id']);
			    $day=htmlspecialchars(trim($arrayArgs['id']));
			    $matchs = $this->daymanager->getDay($day);
			    $view= new View('Bet');
			    $view->display(array('matchs'=>$matchs,'bets'=>$bets,'day'=>$day,'type'=>'updateBet'));
        	}
        }
	}
}