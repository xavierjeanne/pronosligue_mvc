<?php 
//ON INCLUT LE CONTROLLER PRINCIPAL ET LA CLASSE CONNEXION
require_once 'framework/Controller.php';;
require_once 'models/DayManager.php';
require_once 'models/BetManager.php';


class ControllerResult extends Controller
{
	
	
	private $_daymanager;
	private $_betmanager;
	
	//CONSTRUCTEUR
	public function __construct()
	{
		
		$this->daymanager = new DayManager();
		$this->betmanager = new Betmanager();
		

	}
	//PAGE PAR DEFAUT
	public function default($args='')
	{
		try
		{
			$arrayArgs=array('id'=>'');
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
		        // ON DETERMINE LE NUMERO DE LA JOURNEE
		    if(!empty($arrayArgs['id']))
			{
			    $day=htmlspecialchars($arrayArgs['id']);
			}
			else
			{
			$day= $this->daymanager->getCurrentDay();	
			}
			$matchs = $this->daymanager->getDay($day);
			$bets = $this->betmanager->getBetsDay($day);
			$count_bets = $this->betmanager->countBetsDay($day);
			$view = new View("Result");
			$view->display(array('matchs'=>$matchs,'day'=>$day,'count_bets'=>$count_bets,'bets'=>$bets));	
		}
		catch (Exception $e)
		{
			//GESTION DES ERREURS
			$view = new View('Error');
			$view->display(array('messError' => $e->getMessage()));
		}
	}
}