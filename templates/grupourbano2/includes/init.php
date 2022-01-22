<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
include_once("models/Articulo_Model.php");
$articulo_model = new Articulo_Model($empresa->id,$conx);
include_once("models/Usuario_Model.php");
$usuario_model = new Usuario_Model($empresa->id,$conx);

include_once("funciones.php");
include_once("propiedad/item.php");
?>