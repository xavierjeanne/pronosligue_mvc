<?php 

//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';
require_once 'models/UserManager.php';

class Inscription extends Model
{	
	function VerifInscription($pseudo='',$email='',$password='')
    {
        try
        {
        	//ON PREPARE LA REQUETE
            $request = "INSERT INTO users (pseudo,password,email,created_at,updated_at) VALUES (?,?,?,?,?)";
            $created_at=date("Y-m-d H:i:s");
            $updated_at=date("Y-m-d H:i:s");
            $passwordhash = hash('sha256', $password);
            $results = $this->requestExec($request,array(
                        $pseudo,
                        $passwordhash,
                        $email,
                        $created_at,
                        $updated_at
            ));
            if($results->rowCount()==1)
            {
                $req = "SELECT id,admin,step FROM users WHERE pseudo=?";
                $res = $this->requestExec($req,array($pseudo));
                $data = $res->fetch();
                // ON CREER LES VARIABLES DE SESSION
                $_SESSION['pseudo']=$pseudo;
                $_SESSION['id']=$data['id'];
                $_SESSION['admin']=$data['admin'];
                $_SESSION['step']=$data['step'];
                return true;
            }
            else
            {
                return false;   
            }
        }
        catch (PDOException $e)
        {
            //GESTION DES ERREURS
            throw new Exception('Erreur d\' inscription : ' . utf8_encode($e->getMessage()));
        }
    }
}