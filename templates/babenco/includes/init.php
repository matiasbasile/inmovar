<?php
define("ID_EMPRESA_LA_PLATA", 1749);
define("ID_EMPRESA_URUGUAY", 1756);
define("URL_LA_PLATA", "https://www.babencopropiedades.com.ar/");
define("URL_URUGUAY", "https://app.inmovar.com/sandbox/1756/");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function estaEnFavoritos($id) {
  if (!isset($_SESSION["favoritos"])) return false;
  $favoritos = explode(",",$_SESSION["favoritos"]);
  foreach($favoritos as $f) {
    if ($f == $id) return true;
  }
  return false;
}

function cantidadFavoritos() {
  if (!isset($_SESSION["favoritos"])) return 0;
  $favoritos = explode(",",$_SESSION["favoritos"]);
  return sizeof($favoritos);  
}

include  "models/Web_Model.php";
$web_model = new Web_Model ($empresa->id,$conx); 
include  "models/Entrada_Model.php";
$entrada_model = new Entrada_Model ($empresa->id,$conx); 
include  "models/Propiedad_Model.php";
$propiedad_model = new Propiedad_Model ($empresa->id,$conx); 
include  "models/Usuario_Model.php";
$usuario_model = new Usuario_Model ($empresa->id,$conx); 
include_once("admin/application/helpers/fecha_helper.php");
$conservar = '0-9'; // juego de caracteres a conservar
$regex = sprintf('~[^%s]++~i', $conservar); // case insensitive
$empresa->telefono_num = preg_replace($regex, '', $empresa->telefono);
$empresa->telefono_num_2 = preg_replace($regex, '', $empresa->telefono_2);

$empresa->whatsapp_formateado = preg_replace($regex, '', $empresa->whatsapp);

include_once("propiedad/item.php");
?>