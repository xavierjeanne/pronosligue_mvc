<?php
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/Connection.php';
require_once 'models/UserManager.php';

class ControllerConnection extends Controller
{
	private $connection;
	private $usermanager;
    
    public function __construct() {
        
        $this->connection = new Connection();
        $this->usermanager = new UserManager();
    }

    // METHODE DE CONNEXION ON RECUPERE LE NOM LE MOT DE PASSSE ET LE BOUTON DE VALIDATION
    function connection($args=null)
    {
        $arrayArgs=array('pseudo'=>'','password'=>'','submit'=>'');
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
            //ON REDIRIGE VERS LA PAGE PROFIL
            $view = new View('Profil');
            $view->display(array('user'=>$user));
            }
        }
        else
        {
           	//PREMIER PASSAGE ON REDIRIGE SUR LE FOMULAIRE DE CONNECTION
            $view = new View('Connection');
            $view->display(array('error'=>''));



        }
    }

    //METHODE POUR LA DECONNEXION
    function deconnection($args=null)
    {
        try
        {
            //ON SUPPRIME LES VARIABLES DE SESSIONS
            session_unset ();

           //ON RECUPERE LA LISTE DES UTILISATEURS
            $users = $this->usermanager->getUsers();
            //ON GENERE LA VUE EN LUI TRANSMETTANT L ACTION ET LES DONNEES
            $view = new View("Home");
            $view->display(array('users'=> $users));
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
