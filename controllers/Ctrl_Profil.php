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

    public function default()
	{
		if (!isset($_SESSION['pseudo']))
		{
			// SI L UTILISATEUR N EST PAS CONNECTE ON REVOI UNE ERREUR
			throw new Exception('Vous devez vous connecte pour acceder à cette page désolé !!!<br /><a href="home/home">Connexion</a>');
		}
		else
		{
			try
			{
				//ON RECUPERE L ID DE SESSION POUR AFFICHER LA PAGE PROFIL DE L UTILISATEUR
				$id=$_SESSION['id'];
				$user = $this->usermanager->getUser($id);
				$view = new View("Profil");
				$view->display(array('user'=> $user));
			}
			catch (Exception $e)
			{
				//GESTION DES ERREURS
				$view = new View('Error');
				$view->display(array('messError' => $e->getMessage()));
			}
		}
	}
	//METHODE POUR METTRE A JOUR LES INFO DU PROFIL
	public function updateProfil($args=null)
	{
		if (!isset($_SESSION['pseudo']))
		{
			// SI L UTILISATEUR N EST PAS CONNECTE ON REVOI UNE ERREUR
			throw new Exception('Vous devez vous connecte pour acceder à cette page désolé !!!<br /><a href="home/home">Connexion</a>');
		}
		else
		{
			try
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
		        	//ON RECUPERE L ID DE SESSION POUR POUVOIR INSTANCIER UN OBJET UTILISATEUR
					$id=$_SESSION['id'];
					$user = $this->usermanager->getUser($id);
		        	//VERIFICATION DES VARIABLES DU FORMULAIRE
					$pseudo=htmlspecialchars(trim($arrayArgs['pseudo']));
					$email=htmlspecialchars(trim($arrayArgs['email']));
					$password=htmlspecialchars(trim($arrayArgs['password']));
					$password_check=htmlspecialchars(trim($arrayArgs['password_check']));
            		//ON VERIFIE QUE LES DEUX MOTS DE PASSE SONT IDENTIQUES
		            if($password==$password_check)
		            {
						//ON VERIFIE QUE LE PSEUDO OU L EMAIL N EST PAS DEJA PRIS
		                if(!($this->usermanager->existUser($pseudo,$email,$id)))
		                {
		                	$user->setPseudo($pseudo);
		                	$user->setEmail($email);
		                	$user->setPassword($password);
		                    //ON ENREGISTRE LES DONNEES DANS LA BASE
		                   	$this->usermanager->updateUser($user);
		                   	$_SESSION['pseudo']=$pseudo;
		                   	$_SESSION['email']=$email;
		                   	//ON RECUPERE L ID DE SESSION POUR POUVOIR INSTANCIER UN OBJET UTILISATEUR
							$id=$_SESSION['id'];
							$user = $this->usermanager->getUser($id);
		                   	$message="le profil à bien été mis a jour";
		                   	$view = new View('Profil');
		                    $view->display(array('user'=>$user,'message'=>$message));
		                }
		                else
		                {
		                    $error = "Le pseudo ou l email est déjà pris";
		                    //ON REDIRIGE VERS LE FORMULAIRE D INSCRIPTION AVEC UNE ERREUR
		                    $view = new View('UpdateProfil');
		                    $view->display(array('error'=>$error,'user'=>$user));
		                }
			        }
			        else
		            {
		                $_SESSION['pseudo_modification']=$pseudo;
		                $_SESSION['email_modification']=$email;
		                $error = "Les deux mot de passes ne sont pas identiques";
		                //ON REDIRIGE VERS LE FORMULAIRE DE CONNECTION
		                $view = new View('UpdateProfil');
		                $view->display(array('error'=>$error));
		            }
		        }
		        else
		        {
		        	//ON RECUPERE L ID DE SESSION POUR POUVOIR INSTANCIER UN OBJET UTILISATEUR
					$id=$_SESSION['id'];
					$user = $this->usermanager->getUser($id);
					//ON TRANSMET CET OBJET AU FORMULAIRE DE MODIFICATION
					$view = new View("UpdateProfil");
					$view->display(array('user'=> $user,'error'=>''));
				}
			}
			catch (Exception $e)
			{

			$view = new View('Error');
			$view->display(array('messError' => $e->getMessage()));
			}
		}
	}
	
}