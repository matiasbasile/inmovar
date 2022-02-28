<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("includes/init.php");
$link_tipo_operacion = isset($_GET["tipo_operacion"]) ? $_GET["tipo_operacion"] : "";
$id_localidad = isset($_GET["id_localidad"]) ? intval($_GET["id_localidad"]) : 0;
$vc_ids_tipo_operacion = isset($_GET["vc_ids_tipo_operacion"]) ? ($_GET["vc_ids_tipo_operacion"]) : "";
$vc_in_ids_localidades = isset($_GET["vc_in_ids_localidades"]) ? ($_GET["vc_in_ids_localidades"]) : "";
$vc_in_ids_tipo_inmueble = isset($_GET["vc_in_ids_tipo_inmueble"]) ? ($_GET["vc_in_ids_tipo_inmueble"]) : "";
$vc_in_dormitorios = isset($_GET["vc_in_dormitorios"]) ? ($_GET["vc_in_dormitorios"]) : "";
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 0;
$order = isset($_GET["order"]) ? intval($_GET["order"]) : 8;
$offset = isset($_GET["offset"]) ? intval($_GET["offset"]) : 12;
extract($propiedad_model->get_variables(array(
  "id_localidad"=>$id_localidad,
  "link_tipo_operacion"=>$link_tipo_operacion,
  "no_analizar_url"=>1,
  "page"=>$page,
  "order"=>$order,
  "offset"=>$offset,
  "ids_tipo_operacion"=>$vc_ids_tipo_operacion,
  "in_ids_localidades"=>$vc_in_ids_localidades,
  "in_ids_tipo_inmueble"=>$vc_in_ids_tipo_inmueble,
  "in_dormitorios"=>$vc_in_dormitorios,
)));
foreach ($vc_listado as $propiedad) { 
  item($propiedad);
}
?>