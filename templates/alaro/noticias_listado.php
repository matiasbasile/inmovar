<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("includes/funciones.php");
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);

// -----------------------------------

// PARAMETROS DE BUSQUEDA
$header_cat = "";
$page = 0;
$anio = 0;
$mes = 0;

// Order
if (isset($_POST["order"])) { $_SESSION["order"] = filter_var($_POST["order"],FILTER_SANITIZE_STRING); }
$order = isset($_SESSION["order"]) ? $_SESSION["order"] : 0;

// Offset
if (isset($_POST["offset"])) { $_SESSION["offset"] = filter_var($_POST["offset"],FILTER_SANITIZE_STRING); }
$offset = isset($_SESSION["offset"]) ? $_SESSION["offset"] : 10;

// Filter
if (isset($_POST["filter"])) { $_SESSION["filter"] = filter_var($_POST["filter"],FILTER_SANITIZE_STRING); }
$filter = isset($_SESSION["filter"]) ? $_SESSION["filter"] : "";

// -----------------------------------

// FORMATOS DE URL:
// noticias/categoria/anio/mes/pagina/
// noticias/categoria/anio/mes/
// noticias/categoria/pagina/
// noticias/categoria/
// noticias/pagina/
// noticias/

$id_categoria = 0;
$categorias = array();
$titulo_pagina = "";
$nombre_pagina = "";

if (sizeof($params) > 1) {
  $pos1 = $params[1];
  if (is_numeric($pos1)) {
    // Numero de pagina
    $page = (int)$pos1;
  } else {
    // Nombre de categoria
    $sql = "SELECT * FROM not_categorias WHERE link = '".$pos1."' AND id_empresa = $empresa->id ";
    $q = mysqli_query($conx,$sql);
    if (mysqli_num_rows($q)>0) {
      $cat = mysqli_fetch_object($q);
      $cat->nombre = ($cat->nombre);
      $categorias[] = $cat;
      $id_categoria = $cat->id;
      $titulo_pagina = $cat->nombre;
      $nombre_pagina = $cat->link;
    } else {
      // La categoria no es valida, directamente redireccionamos
      header("Location: /404.php");
    }
  }
}

if (sizeof($params) > 2) {
  $pos2 = $params[2];
  if (sizeof($params)>3) {
    $anio = (int)$pos2;
    $mes = (int)$params[3];
    if (sizeof($params)>4) $page = (int)$params[4];
  } else {
    $page = (int)$pos2;
  }
}

for($i=1;$i<(sizeof($params));$i++) {
  $link_categoria = $params[$i];
}

$config = array();
$config["id_categoria"] = $id_categoria;
$config["mes"] = $mes;
$config["anio"] = $anio;
$config["limit"] = ($page * $offset);
$config["offset"] = $offset;
$listado = $entrada_model->get_list($config);
$total = $entrada_model->get_total_results();

// Mostramos siempre la primera
if (sizeof($listado)<=0) {
  header("Location: /404.php");
} else {
  $entrada = $listado[0];
  header("Location: ".mklink($entrada->link));
}
?>