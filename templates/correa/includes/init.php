<?php 
include "models/Web_Model.php";
$web_model = new Web_Model ($empresa->id,$conx) ; 
include "models/Entrada_Model.php";
$entrada_model = new Entrada_Model ($empresa->id,$conx) ; 
include "models/Propiedad_Model.php";
$propiedad_model = new Propiedad_Model ($empresa->id,$conx) ; 

$tiene_emprendimientos = $propiedad_model->get_list(array(
  "id_tipo_operacion"=>4,
  "solo_propias" => 1,
  "solo_contar" => 1,
));

$modales = array();
?>