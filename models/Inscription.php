<?php 

//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';
require_once 'models/UserManager.php';

class Inscription extends Model
{	
	function makeInscription($pseudo='',$avatar='',$password='',$email='')
    {
        try
        {
        	//ON HASH LE MOT DE PASSE
            $password = hash('sha256', $password);
            //ON CREER UN OBJET UTILISATEUR
            $user= new User(array('pseudo' => $pseudo,'avatar'=>$avatar,'password' => $password,'email' => $email));
            //ON APPELLE LA METHODE AJOUTER  SUR CET UTILISATEUR
            $usermanager= new UserManager();
            $usermanager->addUser($user);
            $req = "SELECT id,admin,step FROM users WHERE pseudo=?";
            $res = $this->requestExec($req,array($pseudo));
            $data = $res->fetch();
            // ON CREER LES VARIABLES DE SESSION
            $_SESSION['pseudo']=$pseudo;
            $_SESSION['id']=$data['id'];
            $_SESSION['admin']=$data['admin'];
            $_SESSION['step']=$data['step'];
            //ON RENVOI TRUE SI TOUT C EST BIEN PASSE
            return true;
        }
        catch (PDOException $e)
        {
            //GESTION DES ERREURS
            throw new Exception('Erreur d\' inscription : ' . utf8_encode($e->getMessage()));
        }
    }
}