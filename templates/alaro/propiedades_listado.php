<?php
include_once("includes/funciones.php");
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);

// -----------------------------------

// FORMATOS DE URL:
// propiedades/tipo_operacion/(localidad)/(pagina)/
$header_cat = "";
$nombre_pagina = "";
$titulo_pagina = "";
$tipo_operacion = new stdClass();
$tipo_operacion->id = 0;
$id_localidad = 0;
$localidad = "";
$breadcrumb = array();
$link = mklink("propiedades/");

// Tipo de Operacion: VENTA, ALQUILER, etc.
if (isset($params[1])) {
  
  // Si el parametro es numero, es un numero de pagina
  if (is_numeric($params[1])) {
    $page = (int)$params[1];
  } else {
    $q = mysqli_query($conx,"SELECT * FROM inm_tipos_operacion WHERE link = '".$params[1]."' LIMIT 0,1 ");
    if (mysqli_num_rows($q)>0) {
      $tipo_operacion = mysqli_fetch_object($q);
      $nombre_pagina = $tipo_operacion->link;
      $titulo_pagina = $tipo_operacion->nombre;
      $l = "$tipo_operacion->link/";
      $link.= $l;
      $breadcrumb[] = array(
        "titulo"=>$tipo_operacion->nombre,
        "link"=>$l
      );
    }
  }
}
if ($nombre_pagina == "ventas" || $nombre_pagina == "alquileres" || $nombre_pagina == "proyectos-finalizados" || $nombre_pagina == "proyectos-a-estrenar" || $nombre_pagina == "proyectos-en-construccion" || $nombre_pagina == "proximos-proyectos") { 
  include "includes_nuevo/listado_nuevo.php" ;
} else  {
  include "includes_viejos/listado_viejo.php" ;
} ?>