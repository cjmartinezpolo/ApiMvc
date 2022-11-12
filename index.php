<?php


include_once("./controllers/". $_GET['controller'] . "_controller.php");

$objController = "Controller" . ucfirst($_GET['controller']) ;

$controllador = new $objController();

$fun =  ucfirst($_GET['action']);

print_r($controllador->$fun());