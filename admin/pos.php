<?php

require_once("config/db.php");
require_once ("config/conexion.php");
include("libraries/inventory.php");

$debug= false;
if($debug){
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
}



include "view/pos/pos-add.php";//Include file with the view

ob_start();

// si quieres que se muestre las consultas SQL debes decomentar la siguiente linea
// Core::$debug_sql = true;

?>