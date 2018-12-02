<?php 

//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';

class Connection extends Model
{	
	function getConnection($pseudo='', $password='')
    {
        try
        {
        	//REQUETE DE VERIFICATION 
            $request = "SELECT id,admin,step FROM users WHERE pseudo=? and password=?";

            //ON CRYPTE LE MOT DE PASSE
            $passwordhash = hash('sha256', $password);

            //ON EXECUTE LA REQUETE
            $results=$this->requestExec($request,array($pseudo, $passwordhash));

            // SI L UTILISATEUR ET LE MOT DE PASSE EST VALIDE
            if($results->rowCount()==1)
            {
            	$data = $results->fetch();
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
            throw new Exception('Erreur d\' authentification : ' . utf8_encode($e->getMessage()));
        }
    }
}