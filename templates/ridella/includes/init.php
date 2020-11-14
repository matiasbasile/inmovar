<?php 
include "models/Web_Model.php";
$web_model = new Web_Model ($empresa->id,$conx) ; 
include "models/Propiedad_Model.php";
$propiedad_model = new Propiedad_Model ($empresa->id,$conx) ; 
include "models/Entrada_Model.php";
$entrada_model = new Entrada_Model ($empresa->id,$conx) ; 

function estaEnFavoritos($id) {
  if (!isset($_SESSION["favoritos"])) return false;
  $favoritos = explode(",",$_SESSION["favoritos"]);
  foreach($favoritos as $f) {
    if ($f == $id) return true;
  }
  return false;
}
?>