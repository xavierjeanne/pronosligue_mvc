<?php
require_once 'framework/HttpRequest.php';
require_once 'view/View.php';

abstract class Controller 
{
	//CLASSE QUI VA TRAITER L ACTION A EFFECTUE
	private $action;
	protected $HttpRequest;

	// DEFINIT LA REQUETE ENTRANTE
	public function setRequest(HttpRequest $httpRequest) 
	{
		$this->httpRequest = $httpRequest;
	}

	// EXECUTE L ACTION A EFFECTUE
	public function executeAction($action) 
	{
		if (method_exists($this, $action)) 
		{
			$this->action = $action;
			$arrayHttpRequest = $this->httpRequest->getArrayParams();
			$arrayParameters = array_diff_key($arrayHttpRequest, array('action'=>null, 'controller'=>null));
			$this->{$this->action}($arrayParameters);
		}
		else 
		{
			$classController = get_class($this);
			throw new Exception("Action '$action' non définie dans la classe $classController");
		}
	}
	
	// METHODE ABSTRAITE CORRESPONDANT A LA PAGE PAR DEFAUT OBLIGEANT LES CLASSES DERIVEES A L IMPLEMENTER
	public abstract function default();
	
	// // GENERE LA VUE ASSOCIEE AU CONTROLLEUR COURRANT
	// protected function generateView($dataView = array()) 
	// {
	// 	// DETERMINE LE NOM DU FICHIER DE LA VUE A PARTIR DU NOM DU CONTROLLEUR
	// 	$classController = get_class($this);
	// 	$controller = str_replace("Controller", "", $classController);
	
	// 	// INSTANCIATION ET GENERATION DE LA VUE
	// 	$view = new View($this->action, $controller);
	// 	$view->display($dataView);
	// }
}

