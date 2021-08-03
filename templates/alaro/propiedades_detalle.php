<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
date_default_timezone_set("America/Argentina/Buenos_Aires");
$id_origen = 1;
include_once("includes/funciones.php");
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
$propiedad = $propiedad_model->get($id,array(
  "buscar_total_visitas"=>1,
));
if ($propiedad->id_tipo_operacion == 1 || $propiedad->id_tipo_operacion == 2) { 
	include "includes_nuevo/detalle_nuevo.php"; 
	?>
<?php } else {
	include "includes_viejos/detalle_viejo.php" ;
} ?>