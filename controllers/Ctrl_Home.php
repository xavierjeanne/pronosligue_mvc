<?php
require_once 'framework/Controller.php';
require_once 'models/UserManager.php';
class ControllerHome extends Controller
{

	private $_usermanager;
	//CONSTRUCTEUR
	public function __construct()
	{
		$this->usermanager = new UserManager();
	}
	//GENERER LA VUE DE L ACCUEIL
	public function home()
	{
		
		try
		{
			//ON RECUPERE LA LISTE DES UTILISATEURS
			$users = $this->usermanager->getUsers();
			//ON GENERE LA VUE EN LUI TRANSMETTANT L ACTION ET LES DONNEES
			$view = new View("Home");
			$view->display(array('users'=> $users));
			
		}
		catch (Exception $e)
		{

			$view = new View('Error');
			$view->display(array('messError' => $e->getMessage()));
		}

	}
	//GENERER LA VUE D AFFICHAGE D UN UTILISATEUR
	public function display($args=null)
	{
		try
		{
			$arrayArgs=array('id'=>'');
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
			$view = new View("Home");
			$view->display(array('user'=> $user));
		}
		catch (Exception $e)
		{

			$view = new View('Error');
			$view->display(array('messError' => $e->getMessage()));
		}
	}
	//TRAITEMENT DU FORMULAIRE
	public function add($args=null) 
	{
		try
		{
			$arrayArgs=array('pseudo'=>'','email'=>'','password'=>'');
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
			//VERIFICATION DES VARIABLES DU FORMULAIRE
			$pseudo=htmlspecialchars(trim($arrayArgs['pseudo']));
			$email=htmlspecialchars(trim($arrayArgs['email']));
			$password=htmlspecialchars(trim($arrayArgs['password']));
			$this->usermanager->addUser($pseudo,$password,$email);
			$this->home();
		}
		catch (Exception $e)
		{

			$view = new View('Error');
			$view->display(array('messError' => $e->getMessage()));
		}
	    
  	}
  	public function default()
  	{
  		echo "page par defaut";
  	}
}