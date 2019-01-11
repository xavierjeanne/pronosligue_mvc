<?php
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/TeamManager.php';
require_once 'models/UserManager.php';

class ControllerTeamAdmin extends Controller
{
	private $_teammanager;
	private $_usermanager;
	//CONSTRUCTEUR
	public function __construct()
	{
		$this->teammanager = new TeamManager();
		$this->usermanager = new UserManager();
	}
	//METHODE POUR AFFICHER LA PAGE PAR DEFAUT
	public function default($args=null)
	{
		//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
		$id=$_SESSION['id'];
		$user = $this->usermanager->getUser($id);
		if (($user->getAdmin())!=1)
		{
			throw new Exception('<p>Vous n\'êtes pas autorisé a accéder à cette pasge !!! </p><p><a class="btn btn-dark " role="button" href="index.php?controller=connection&action=connection">Connexion</a></p>');
		}
		else
		{
			try
			{
				$arrayArgs=array('team'=>'','teams'=>'','type'=>'','message'=>'','id'=>'');
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
					$teams= $this->teammanager->getTeams('name');
					$view = new View("TeamAdmin");
					$view->display(array('teams'=>$teams,'type'=>$type,'message'=>$message));	
		        }
		        else
		        {
		        	if($arrayArgs['type']=='update')
		        	{
		        		$type=htmlspecialchars(trim($arrayArgs['type']));
		        		$id=htmlspecialchars(trim($arrayArgs['id']));
		        		$team = $this->teammanager->getTeam($id);
		        		$view->display(array('team'=>$team,'type'=>$type));
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

	//METHODE POUR AJOUTER UNE EQUIPE
	public function addTeam($args=null)
	{
		//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
		$id=$_SESSION['id'];
		$user = $this->usermanager->getUser($id);
		if (($user->getAdmin())!=1)
		{
			throw new Exception('<p>Vous n\'êtes pas autorisé a accéder à cette pasge !!! </p><p><a class="btn btn-dark" role="button" href="connection/connection">Connexion</a></p>');
		}
		else
		{
			$arrayArgs=array('name'=>'','alias'=>'','town'=>'','submit'=>'');
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
			$name=htmlspecialchars(trim($arrayArgs['name']));
	        $alias=strtoupper(htmlspecialchars(trim($arrayArgs['alias'])));
			$town=strtolower(htmlspecialchars(trim($arrayArgs['town'])));
			$flag="assets/img/flag/$town.png";
			$jersey="assets/img/jersey/$town.png";
	        $team = new Team(array('name'=>$name,'alias'=>$alias,'flag'=>$flag,'jersey'=>$jersey));
	        $message="L'équipe a bien été ajoutée";
	        $this->teammanager->addTeam($team);
	        $this->default(array('message'=>$message));	
	        }
	         else
        	{
           	//PREMIER PASSAGE ON REDIRIGE SUR LE FOMULAIRE DE CONNECTION
        	$teams= $this->teammanager->getTeams();
            $view = new View('TeamAdmin');
            $view->display(array('type'=>'addTeam'));
        	}
    	}
	}
	//METHODE POUR MODIFIER UNE EQUIPE
	public function UpdateTeam($args=null)
	{
		//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
		$id=$_SESSION['id'];
		$user = $this->usermanager->getUser($id);
		if (($user->getAdmin())!=1)
		{
			throw new Exception('<p>Vous n\'êtes pas autorisé a accéder à cette pasge !!! </p><p><a class="btn btn-dark" role="button" href="connection/connection">Connexion</a></p>');
		}
		else
		{
			$arrayArgs=array('id'=>'','name'=>'','alias'=>'','town'=>'','day'=>'','point'=>'','won'=>'','drawn'=>'','lost'=>'','goal_for'=>'','goal_against'=>'','id'=>'','submit'=>'');
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
		        //NETTOYAGE DES VARIABLES DU FORMULAIRE ET MISE A JOUR DE L E¨QUIPE
		        
				$name=htmlspecialchars(trim($arrayArgs['name']));
		        $alias=strtoupper(htmlspecialchars(trim($arrayArgs['alias'])));
				$town=strtolower(htmlspecialchars(trim($arrayArgs['town'])));
				$day=htmlspecialchars(trim($arrayArgs['day']));
				$point=htmlspecialchars(trim($arrayArgs['point']));
				$won=htmlspecialchars(trim($arrayArgs['won']));
				$drawn=htmlspecialchars(trim($arrayArgs['drawn']));
				$lost=htmlspecialchars(trim($arrayArgs['lost']));
				$goal_for=htmlspecialchars(trim($arrayArgs['goal_for']));
				$goal_against=htmlspecialchars(trim($arrayArgs['goal_against']));
				$flag="assets/img/flag/$town.png";
				$jersey="assets/img/jersey/$town.png";
		        $team = $this->teammanager->getTeam($id);
		        $team->setName($name);
		        $team->setAlias($alias);
		        $team->setFlag($flag);
		        $team->setDay($day);
		        $team->setPoint($point);
		        $team->setWon($won);
		        $team->setDrawn($drawn);
		        $team->setLost($lost);
		        $team->setGoal_for($goal_for);
		        $team->setGoal_against($goal_against);
		        $team->setJersey($jersey);
		        $team->setGoal_difference($goal_for - $goal_against);
		        $this->teammanager->updateTeam($team);
		        $message="L'équipe a bien été modifié";
		        $this->default(array('message'=>$message));
		    }
		    else
        	{
           	//PREMIER PASSAGE ON REDIRIGE SUR LE FOMULAIRE 
        	$team= $this->teammanager->getTeam($id);
            $view = new View('TeamAdmin');
            $view->display(array('type'=>'updateTeam','team'=>$team));
        	}
    	}
	}
}