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
include "listado_nuevo.php" ;
} else  { 

// De esa manera cuando paginamos pasamos los mismos parametros
// sin guardar nada en la session
$gets = "";
if(sizeof($get_params)>0) {
  $gets.="?";
  foreach($get_params as $key => $value) {
    $gets.=$key."=".$value."&";
  }
}

$config = array();
$config["limit"] = 0;
$config["offset"] = 999999;
$config["order_by"] = "A.fecha_publicacion DESC, A.id DESC ";
$config["buscar_etiquetas"] = 1;

if ($tipo_operacion->id == 8) {
  $config["id_tipo_operacion"] = 8;
  $finalizados = $propiedad_model->get_list($config);
} else {
  $config["id_tipo_operacion"] = 6;
  $en_construccion_result = $propiedad_model->get_list($config);
  $config["id_tipo_operacion"] = 7;
  $proximos_result = $propiedad_model->get_list($config);  
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="loading">
<?php include("includes/header.php"); ?>
<!-- RED BOX TITLE -->
<div class="red-box-title">
  <div class="container">
    <ul>
      <li>Proyectos En Curso</li>
    </ul>
  </div>
</div>
<div class="project-category-list">
  <?php if ($tipo_operacion->id != 8) { ?>
    <div class="list-tabs">
      <div class="container">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#projects-under-construction">Proyectos en Construcción</a></li>
          <li><a data-toggle="tab" href="#next-projects">Proyectos a Estrenar</a></li>
        </ul>
      </div>
    </div>
    <div class="container">
      <div class="tab-content">
        <div id="projects-under-construction" class="tab-pane fade in active">
          <div class="row">
            <?php foreach($en_construccion_result as $r) { ?>
              <div class="col-md-3">
                <div class="feature-item">
                  <?php mostrar_etiqueta($r) ?>
                  <div class="feature-image"> <a href="<?php echo mklink($r->link); ?>"><img src="/admin/<?php echo $r->path ?>" alt="<?php echo $r->nombre ?>" /></a>
                    <div class="overlay-info">
                      <div class="center-content">
                        <div class="align-center"> <a href="<?php echo mklink($r->link); ?>"></a> </div>
                      </div>
                    </div>
                    <div class="about-product"> <a href="<?php echo mklink($r->link); ?>"><?php echo $r->nombre ?>
                      <p><?php echo $r->calle ?><br>
                        <?php echo $r->localidad ?></p>
                      </a> </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div id="next-projects" class="tab-pane fade">
          <div class="row">
            <?php foreach($proximos_result as $r) { ?>
              <div class="col-md-3">
                <div class="feature-item">
                  <?php mostrar_etiqueta($r) ?>
                  <div class="feature-image"> <a href="<?php echo mklink($r->link); ?>"><img src="/admin/<?php echo $r->path ?>" alt="<?php echo $r->nombre ?>" /></a>
                    <div class="overlay-info">
                      <div class="center-content">
                        <div class="align-center"> <a href="<?php echo mklink($r->link); ?>"></a> </div>
                      </div>
                    </div>
                    <div class="about-product"> <a href="<?php echo mklink($r->link); ?>"><?php echo $r->nombre ?>
                      <p><?php echo $r->calle ?><br>
                        <?php echo $r->localidad ?></p>
                      </a> </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  <?php } else { ?>
    <div class="container">
      <div class="tab-content">
        <div id="projects-under-construction" class="tab-pane active">
          <div class="row">
            <?php foreach($finalizados as $r) { ?>
              <div class="col-md-3">
                <div class="feature-item">
                  <?php mostrar_etiqueta($r) ?>
                  <div class="feature-image"> <a href="<?php echo mklink($r->link); ?>"><img src="/admin/<?php echo $r->path ?>" alt="<?php echo $r->nombre ?>" /></a>
                    <div class="overlay-info">
                      <div class="center-content">
                        <div class="align-center"> <a href="<?php echo mklink($r->link); ?>"></a> </div>
                      </div>
                    </div>
                    <div class="about-product"> <a href="<?php echo mklink($r->link); ?>"><?php echo $r->nombre ?>
                      <p><?php echo $r->calle ?><br>
                        <?php echo $r->localidad ?></p>
                      </a> </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
</div>
<?php include("includes/footer.php"); ?>
</body>
</html>
<?php } ?>