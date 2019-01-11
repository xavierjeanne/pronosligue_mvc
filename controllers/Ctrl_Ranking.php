<?php 
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE USERMANAGER
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
	//AFFICHAGE DU CLASSEMENT DES MEMBRES PAR POINT
	public function default()
	{
		try
		{
			//AFFICHAGE DE LA VUE RANKING
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