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
            $request = "SELECT id,admin,pseudo,step,password FROM users WHERE pseudo=?";
            $results=$this->requestExec($request,array($pseudo));
            if($results->rowCount()==1)
            {   
                $data = $results->fetch();  
                //ON CRYPTE LE MOT DE PASSE
                $passwordhash = hash('sha256', $password);
                //ON VERIFIE SI LE MOT DE PASSE CORRESPOND
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
                    $_SESSION['pseudo_connection'] = $pseudo;
                    $error = "Le mot de passe ne correspond pas avec le pseudo";
                    //ON REDIRIGE VERS LE FORMULAIRE D INSCRIPTION AVEC UNE ERREUR
                    $view = new View('Connection');
                    $view->display(array('error'=>$error));   
                }
            }
            else
            {
                    $error = "Le pseudo n existe pas dans la base";
                    //ON REDIRIGE VERS LE FORMULAIRE D INSCRIPTION AVEC UNE ERREUR
                    $view = new View('Connection');
                    $view->display(array('error'=>$error));   
            }   
        }
        catch (PDOException $e)
        {
            //GESTION DES ERREURS
            throw new Exception('Erreur d\' authentification : ' . utf8_encode($e->getMessage()));
        }
    }
}