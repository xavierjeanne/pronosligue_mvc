<?php 

//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';

class Connection extends Model
{	
	function getConnection($pseudo='', $password='')
    {
        try
        {
        	//VERIFICATION SI LE PSEUDO EXISTE 
            $request = "SELECT id,admin,pseudo,password,step FROM users WHERE pseudo=?";
            $results=$this->requestExec($request,array($pseudo));
            if($results->rowCount()==1)
            {   
                $data = $results->fetch();  
                //ON CRYPTE LE MOT DE PASSE
                $passwordhash = hash('sha256', $password);
                //ON VERIFIE SI LE MOT DE PASSE CORRESPOND A CELUI ENREGISTRE
                if($data['password']==$passwordhash)
                {
                    // ON CREER LES VARIABLES DE SESSION
                    $_SESSION['pseudo']=$data['pseudo'];
                    $_SESSION['id']=$data['id'];
                    $_SESSION['admin']=$data['admin'];
                    $_SESSION['step']=$data['step'];
                    return true;
                }
                else
                {
                    // SI LE MOT DE PASSE NE CORRESPOND PAS ON RENOVIE UN MESSAGE ET UNE VARIABLE DE SESSION POUR PREREMPLIR LE FORMULAIRE DE CONNEXION
                    $_SESSION['pseudo_connection'] = $pseudo;
                    $message = "Le mot de passe ne correspond pas avec le pseudo";
                    $view = new View('Connection');
                    $view->display(array('message'=>$message));   
                }
            }
            else
            {
                    $message = "Le pseudo n existe pas dans la base";
                    //ON REDIRIGE VERS LE FORMULAIRE DE CONNEXIO? AVEC UN MESSAGE
                    $view = new View('Connection');
                    $view->display(array('message'=>$message));   
            }   
        }
        catch (PDOException $e)
        {
            //GESTION DES ERREURS
            throw new Exception('Erreur d\' authentification : ' . utf8_encode($e->getMessage()));
        }
    }
}