<?php 
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/UserManager.php';

class ControllerProfil extends Controller
{
	private $usermanager;

    
    public function __construct() {
        $this->usermanager = new UserManager();
    }

    public function profil($args=null)
	{
		if (!isset($_SESSION['pseudo']))
		{
			// On en génère un message d'erreur
			throw new Exception('Vous devez vous connecte pour acceder à cette page désolé !!!<br /><a href="home/home">Connexion</a>');
		}
		else
		{
			try
			{
				$arrayArgs=array('id'=>$_SESSION['id']);
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
				$user = $this->usermanager->getUser($arrayArgs['id']);
				$view = new View("Profil");
				$view->display(array('user'=> $user));
			}
			catch (Exception $e)
			{

				$view = new View('Error');
				$view->display(array('messError' => $e->getMessage()));
			}
		}
	}
	public function default()
  	{
  		echo "page profil";
  	}
}