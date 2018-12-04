<?php 
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/UserManager.php';

class ControllerRanking extends Controller
{
	private $_usermanager;
	//CONSTRUCTEUR
	public function __construct()
	{
		$this->usermanager = new UserManager();
	}
	public function default()
	{
		try
		{
			$view = new View("Ranking");
			$users = $this->usermanager->getUsers();
			$view->display(array('users'=>$users));
		}
		catch (Exception $e)
		{
			//GESTION DES ERREURS
			$view = new View('Error');
			$view->display(array('messError' => $e->getMessage()));
		}
	}
}