<?php
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
?>