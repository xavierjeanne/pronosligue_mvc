<?php
//ON DEMARRE UNE SESSION
session_start();
//ON INSTANCIE LE ROUTER POUR REDIRIGER VERS LE BON CONTROLLEUR
include 'framework/Router.php';

$router = new Router();
$router->routerRequest();
