<?php
require_once 'framework/Controller.php';
require_once 'models/UserManager.php';
require_once 'models/DayManager.php';

class ControllerHome extends Controller
{

	private $_usermanager;
	private $_daymanager;
	//CONSTRUCTEUR
	public function __construct()
	{
		$this->usermanager = new UserManager();
		$this->daymanager = new DayManager();
		
	}
	//GENERER LA VUE DE L ACCUEIL
	public function default($args=null)
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
		    //ON DETERMINE LE NUMERO DE LA JOURNEE A AFFICHER
		    if(!empty($arrayArgs['id']))
			{
				//ON RECUPERE LE NUMERO DE LA DERNIERE JOURNEE ENREGISTRE POUR EMPECHER UN AFFICHAGE VIDE
				$limite=($this->daymanager->getLastDay())-1;
				if(($arrayArgs['id'])>$limite)
				{
					$day=$limite;
				}
				else{
			   		$day=htmlspecialchars($arrayArgs['id']);	
				}
			}
			else
			{
				if(!empty($this->daymanager->getCurrentDay()))
				{
					$day=$this->daymanager->getCurrentDay();
				}
				else
				{
					$day=$this->daymanager->getLastDay();
				}
			}
			$matchs = $this->daymanager->getDay($day);
			//ON GENERE LA VUE EN LUI TRANSMETTANT L ACTION ET LES DONNEES
			$view = new View("Home");
			$view->display(array('matchs'=> $matchs,'day'=>$day));
			
		}
		catch (Exception $e)
		{

			$view = new View('Error');
			$view->display(array('messError' => $e->getMessage()));
		}

	}
}