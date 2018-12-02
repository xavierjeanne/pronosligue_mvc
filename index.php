<?php
//ON DEMARRE UNE SESSION
session_start();

//ON INSTANCIE LE ROUTER POUR REDIRIGER VERS LE BON CONTROLLEUR
require 'controllers/Router.php';
$router = new Router();
$router->routerRequest();
