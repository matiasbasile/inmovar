<?php 
  include_once("models/Propiedad_Model.php");
  $propiedad_model = new Propiedad_Model($empresa->id,$conx);
  include_once("models/Web_Model.php");
  $web_model = new Web_Model($empresa->id,$conx);
  include_once("models/Entrada_Model.php");
  $entrada_model = new Entrada_Model($empresa->id,$conx);
  include_once("models/Articulo_Model.php");
  $articulo_model = new Articulo_Model($empresa->id,$conx);
  $empresa->telefono_f = preg_replace("/[^0-9]/", "", $empresa->telefono);
?>