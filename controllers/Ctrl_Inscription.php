<?php
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/Inscription.php';
require_once 'models/UserManager.php';

class ControllerInscription extends Controller
{
    private $inscripiton;
	private $usermanager;

    
    public function __construct() {
        
        $this->inscription = new Inscription();
        $this->usermanager = new UserManager();
    }

    // METHODE POUR INSCRIPTION DES MEMBRES
    function default($args=null)
    {
        $arrayArgs=array('pseudo'=>'','email'=>'','password'=>'','password_check'=>'','submit'=>'');
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
            $password=htmlspecialchars(trim($arrayArgs['password']));
			$password_check=htmlspecialchars(trim($arrayArgs['password_check']));
            //ON VERIFIE QUE LES DEUX MOTS DE PASSE SONT IDENTIQUES
            if($password==$password_check)
            {
                //ON VERIFIE QUE LE PSEUDO OU L EMAIL N EST PAS DEJA PRIS
                if(!($this->usermanager->existUser($pseudo,$email)))
                {
                     //ON ENREGISTRE LES DONNEES DANS LA BASE
                    if($this->inscription->makeInscription($pseudo,$email,$password))
                    {
                        $id=$_SESSION['id'];
                        $user = $this->usermanager->getUser($id);
                        //ON REDIRIGE VERS LA PAGE PROFIL
                        $view = new View('Profil');
                        $view->display(array('user'=>$user));
                    }
                    else
                    {
                        $_SESSION['pseudo_inscription']=$pseudo;
                        $_SESSION['email_inscription']=$email;
                        $error = "Probleme lors de l'inscription merci de recommencer";
                        //ON REDIRIGE VERS LE FORMULAIRE D INSCRIPTION AVEC UNE ERREUR
                        $view = new View('Inscription');
                        $view->display(array('error'=>$error));
                    }
                }
                else
                {
                    $error = "Le pseudo ou l email est déjà pris";
                    //ON REDIRIGE VERS LE FORMULAIRE D INSCRIPTION AVEC UNE ERREUR
                    $view = new View('Inscription');
                    $view->display(array('error'=>$error));
                }
            }
			else
            {
                $_SESSION['pseudo_inscription']=$pseudo;
                $_SESSION['email_inscription']=$email;
                $error = "Les deux mot de passe ne sont pas identiques";
                //ON REDIRIGE VERS LE FORMULAIRE DE CONNECTION
                $view = new View('Inscription');
                $view->display(array('error'=>$error));
            }
        }
        else
        {
           	//PREMIER PASSAGE ON REDIRIGE SUR LE FOMULAIRE DE CONNECTION
            $view = new View('Inscription');
            $view->display(array('error'=>''));
        }
    }
}