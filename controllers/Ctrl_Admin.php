<?php 
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/UserManager.php';

class ControllerAdmin extends Controller
{
	private $_usermanager;
	//CONSTRUCTEUR
	public function __construct()
	{
		$this->usermanager = new UserManager();
	}
	public function default()
	{
		//ON RECUPERE LE SESSION ID POUR CREER UN OBJET USER ET VERIFIER LES DROITE
		$id=$_SESSION['id'];
		$user = $this->usermanager->getUser($id);
		if (($user->getAdmin())!=1)
		{
			//ON VERIFIE SI L UTILISATEUR EST CONNECTE ET SI IL A LES DROITS ADMIN
			throw new Exception('<p>Vous n\'êtes pas autorisé a accéder à cette pasge !!! </p><p><a class="btn btn-dark" role="button" href="index.php?controller=connection&action=connection">Connexion</a></p>');
		}
		else
		{
			try
			{
				//AFFICHAGE DE LA PAGE ADMIN
				$view = new View("Admin");
				$view->display(array('message'=>''));
			}
			catch (Exception $e)
			{
				//GESTION DES ERREURS
				$view = new View('Error');
				$view->display(array('messError' => $e->getMessage()));
			}
		}
	}
}