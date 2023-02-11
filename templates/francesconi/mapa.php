<?php
include_once("includes/init.php");
extract($propiedad_model->get_variables(array(
  "offset" => 9999999
)));
$nombre_pagina = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">

<head>
  <?php include("includes/head.php"); ?>
</head>

<body class="bg-gray">

<?php include("includes/header.php"); ?>

<section class="equipo-banner">
  <div class="container">
    <div class="equipo-content">
      <h1 class="banner-title"><?php echo $vc_nombre_operacion ?></h1>
    </div>
  </div>
</section>

<section class="pb0">
  <div class="container">  
    <div class="mis-content">
      <h2 class="small-title">
        PROPIEDADES EN <?php echo $vc_nombre_operacion ?> <span>
        <?php echo $vc_total_resultados ?> Resultados de búsqueda</span>
      </h2>
    </div>
    <?php 
    $buscador_mapa = true;
    include 'includes/propiedad/filtros.php'; ?>
  </div>
  <div id="mapa" class="mt40" style="width:100%; height:700px"></div>
</section>

<?php include("includes/footer.php") ?>

<?php 
include_once("templates/comun/mapa_js.php"); 
include_once("includes/mapa_js.php");
?>
</body>

</html>