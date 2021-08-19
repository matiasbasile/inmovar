<?php 
include "models/Web_Model.php";
$web_model = new Web_Model ($empresa->id,$conx) ; 
include "models/Entrada_Model.php";
$entrada_model = new Entrada_Model ($empresa->id,$conx) ; 
include "models/Propiedad_Model.php";
$propiedad_model = new Propiedad_Model ($empresa->id,$conx) ; 
include_once("admin/application/helpers/fecha_helper.php");
?>