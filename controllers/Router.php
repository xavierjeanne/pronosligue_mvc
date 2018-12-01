<?php
require_once 'framework/HttpRequest.php';
require_once 'view/View.php';
//CLASSE QUI VA TRAITER LES REQUETES ET REDIRIGER VERS LE BON CONTROLEUR
class Router 
{

  //TRAITER LA REQUETE ENTRANTE
  public function routerRequest() 
  {
    try 
    {
      // FUSION DES PARAMETRES GET ET POST DANS UN TABLEAU POUR CREER L OBJET HTTPREQUEST
      $httpRequest = new HttpRequest(array_merge($_GET, $_POST));

      //CREATION DU CONTROLLEUR EN FONCTION DU PARAMETRE  DE HTTPREQUEST
      $controller = $this->createController($httpRequest);

      $action = $this->createAction($httpRequest);
      $controller->executeAction($action);

    }
    catch (Exception $e) {
      $this->getError($e);
    }
  }
  //CREATION DU CONTROLLEUR APPROPRIE EN FONCTION DE LA REQUETE RECUE
  private function createController(HttpRequest $httpRequest)
  {
      //CONTROLLEUR PAR DEFAUT
      $controller = "home";
      if ($httpRequest->existParam('controller')) 
      {
        $controller = $httpRequest->getParam('controller');
      }

      // CREATION DU NOM DU FICHIER DU CONTROLLEUR
      $fileController = "controllers/Ctrl_" . $controller . ".php";
      // PREMIERE LETTRE EN MAJUSCULE
      $controller = ucfirst($controller);
      $classController = "Controller" . $controller;
      
      // SI LE FICHIER DE LA CLASSE CONTROLLEUR EXISTE
      if (file_exists($fileController)) 
      {
        // ON INSTANCIE LA CLASSE CONTROLLEUR ADAPTEE A LA REQUETE HTTP
        require($fileController);
        $controller = new $classController();
        $controller->setRequest($httpRequest);
        return $controller;
      }
      else
      {
        throw new Exception("Fichier '$fileController' introuvable");  
      }
    }

    // DETERMINE L ACTION A EXECUTER EN FONTION DE LA REQUETE HTTP RECUE
    private function createAction(HttpRequest $httpRequest) 
    {
      // Action par defaut
      $action = "home";  
      if ($httpRequest->existParam('action')) 
      {
        $action = $httpRequest->getParam('action');
      }
      return $action;
    }
    // GERE UNE ERREUR D EXECUTION
  private function getError(Exception $exception) {
    $view = new View('Error');
    $view->display(array('msgErreur' => $exception->getMessage()));
  }
}

