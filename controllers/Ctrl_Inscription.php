<?php
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/Inscription.php';
require_once 'models/UserManager.php';
require_once 'models/TeamManager.php';

class ControllerInscription extends Controller
{
    private $inscripiton;
    private $usermanager;
	private $teammanager;

    
    public function __construct() {
        
        $this->inscription = new Inscription();
        $this->usermanager = new UserManager();
        $this->teammanager = new TeamManager();
    }

    // METHODE POUR L 'INSCRIPTION DES MEMBRES
    function default($args=null)
    {
        $arrayArgs=array('pseudo'=>'','email'=>'','avatar'=>'','password'=>'','password_check'=>'','submit'=>'');
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
            $email=htmlspecialchars(trim($arrayArgs['email']));
            $avatar=htmlspecialchars(trim($arrayArgs['avatar'])); 
            $password=htmlspecialchars(trim($arrayArgs['password']));
			$password_check=htmlspecialchars(trim($arrayArgs['password_check']));
            //ON VERIFIE QUE LES DEUX MOTS DE PASSE SONT IDENTIQUES
            if($password==$password_check)
            {
                //ON VERIFIE QUE LE PSEUDO OU L EMAIL N EST PAS DEJA PRIS
                if(!($this->usermanager->existUser($pseudo,$email)))
                {
                     //ON ENREGISTRE LES DONNEES DANS LA BASE
                    if($this->inscription->makeInscription($pseudo,$avatar,$password,$email))
                    {
                        $id=$_SESSION['id'];
                        $user = $this->usermanager->getUser($id);
                        $teams = $this->teammanager->getTeams();
                        //ON REDIRIGE VERS LA PAGE ETAPE
                        $view = new View("Step");
                        $view->display(array('user'=> $user,'teams'=>$teams)); 
                    }
                    else
                    {
                        //ON ENREGISTRE DES VARIABLES DE SESSIONS CONTENANT LE PSEUDO ET L EMAIL D INSCRIPTION 
                        // POUR PREREMPLIR LE FORMUALAIRE
                        $_SESSION['pseudo_inscription']=$pseudo;
                        $_SESSION['email_inscription']=$email;
                        $message = "Probleme lors de l'inscription merci de recommencer";
                        //ON REDIRIGE VERS LE FORMULAIRE D INSCRIPTION AVEC UNE ERREUR
                        $teams = $this->teammanager->getTeams('name');
                        $view = new View('Inscription');
                        $view->display(array('message'=>$message,'teams'=>$teams));
                    }
                }
                else
                {
                    $message = "Le pseudo ou l email est déjà pris";
                    //ON REDIRIGE VERS LE FORMULAIRE D INSCRIPTION AVEC UNE ERREUR
                    $teams = $this->teammanager->getTeams('name');
                    $view = new View('Inscription');
                    $view->display(array('message'=>$message,'teams'=>$teams));
                }
            }
			else
            {
                 //ON ENREGISTRE DES VARIABLES DE SESSIONS CONTENANT LE PSEUDO ET L EMAIL D INSCRIPTION 
                // POUR PREREMPLIR LE FORMUALAIRE
                $_SESSION['pseudo_inscription']=$pseudo;
                $_SESSION['email_inscription']=$email;
                $message = "Les deux mot de passe ne sont pas identiques";
                //ON REDIRIGE VERS LE FORMULAIRE D INSCRIPTION AVEC UN MESSAGE
                $teams = $this->teammanager->getTeams('name');
                $view = new View('Inscription');
                $view->display(array('message'=>$message,'teams'=>$teams));
            }
        }
        else
        {
           	//PREMIER PASSAGE ON REDIRIGE SUR LE FOMULAIRE D INSCRIPTION
            $teams = $this->teammanager->getTeams('name');
            $view = new View('Inscription');
            $view->display(array('message'=>'','teams'=>$teams));
        }
    }
}