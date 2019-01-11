<?php 
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/TeamManager.php';

class ControllerLeague extends Controller
{
	private $_teammanager;
	//CONSTRUCTEUR
	public function __construct()
	{
		$this->teammanager = new TeamManager();
	}
	//AFFICHAGE DU CLASSEMENT DE LIGUE 1
	public function default()
	{
		try
		{
			$view = new View("League");
			$teams = $this->teammanager->getTeams();
			$view->display(array('teams'=>$teams));
		}
		catch (Exception $e)
		{
			//GESTION DES ERREURS
			$view = new View('Error');
			$view->display(array('messError' => $e->getMessage()));
		}
	}
}