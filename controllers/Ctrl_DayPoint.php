<?php 
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';
require_once 'models/DayPointManager.php';
require_once 'models/DayManager.php';

class ControllerDayPoint extends Controller
{
	
	private $_daypointmanager;
	private $_daymanager;
	//CONSTRUCTEUR
	public function __construct()
	{
		$this->daypointmanager = new DayPointManager();
		$this->daymanager = new DayManager();
	}
	//PAGE PAR DEFAUT
	public function default($args=null)
	{
		try
		{
			$arrayArgs=array('user_id'=>'','id'=>'','day_point'=>'');
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
		    //ON DETERMINE LE NUMERO DE LA JOURNEE
		    if(!empty($arrayArgs['id']))
			{
			    $day=htmlspecialchars($arrayArgs['id']);
			}
			else
			{
			$day= $this->daymanager->getCurrentDay();	
			}
			$dayPoints = $this->daypointmanager->getDayPoints($day);
			$view = new View("DayPoint");
			$view->display(array('day'=>$day,'dayPoints'=>$dayPoints));	
		}
		catch (Exception $e)
		{
			//GESTION DES ERREURS
			$view = new View('Error');
			$view->display(array('messError' => $e->getMessage()));
		}
	}
}