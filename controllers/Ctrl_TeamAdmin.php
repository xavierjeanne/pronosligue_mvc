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
		$id=$_SESSION['id'];
		$user = $this->usermanager->getUser($id);
		if (($user->getAdmin())!=1)
		{
			//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
			throw new Exception("Vous n'êtes pas autorisé a accéder à cette pasge !!! <br /><a href=\"home/home\">Connexion</a>");
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
					$teams= $this->teammanager->getTeams();
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
		$id=$_SESSION['id'];
		$user = $this->usermanager->getUser($id);
		if (($user->getAdmin())!=1)
		{
			//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
			throw new Exception("Vous n'êtes pas autorisé a accéder à cette pasge !!! <br /><a href=\"home/home\">Connexion</a>");
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
	        //VERIFICATION DES VARIABLES DU FORMULAIRE
			$name=htmlspecialchars(trim($arrayArgs['name']));
	        $alias=strtoupper(htmlspecialchars(trim($arrayArgs['alias'])));
			$town=strtolower(htmlspecialchars(trim($arrayArgs['town'])));
			$flag="assets/img/flag/$town";
			$jersey="assets/img/jersey/$town";
	        $team = new Team(array('name'=>$name,'alias'=>$alias,'flag'=>$flag,'jersey'=>$jersey));
	        $message="Equipe bien ajoutée";
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
		$id=$_SESSION['id'];
		$user = $this->usermanager->getUser($id);
		if (($user->getAdmin())!=1)
		{
			//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
			throw new Exception("Vous n'êtes pas autorisé a accéder à cette pasge !!! <br /><a href=\"home/home\">Connexion</a>");
		}
		else
		{
			$arrayArgs=array('id'=>'','name'=>'','alias'=>'','town'=>'','id'=>'','submit'=>'');
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
		        
				$name=htmlspecialchars(trim($arrayArgs['name']));
		        $alias=strtoupper(htmlspecialchars(trim($arrayArgs['alias'])));
				$town=strtolower(htmlspecialchars(trim($arrayArgs['town'])));
				$flag="assets/img/flag/$town";
				$jersey="assets/img/jersey/$town";
		        $team = $this->teammanager->getTeam($id);
		        $team->setName($name);
		        $team->setAlias($alias);
		        $team->setFlag($flag);
		        $team->setJersey($jersey);
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