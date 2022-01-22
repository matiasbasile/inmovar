<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("includes/init.php");
$ids_tipo_operacion = isset($get_params["ids_tipo_operacion"]) ? intval($get_params["ids_tipo_operacion"]) : 0;
$id_localidad = isset($get_params["id_localidad"]) ? intval($get_params["id_localidad"]) : 0;
extract($propiedad_model->get_variables(array(
  "id_localidad"=>$id_localidad,
  "ids_tipo_operacion"=>$ids_tipo_operacion,
  "no_analizar_url"=>1,
)));
foreach ($vc_listado as $propiedad) { 
  item($propiedad);
}
?>