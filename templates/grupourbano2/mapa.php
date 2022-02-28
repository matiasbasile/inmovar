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
  <style type="text/css">
    .search-filter input[type="checkbox"]+label {
      color: #030303;
    }
  </style>
</head>

<body class="bg-gray">

<?php include("includes/header.php"); ?>

<section class="padding-default">
  <div class="container style-two">
    <div class="page-heading">
      <?php if ($vc_tipo_operacion == 1) { ?>
        <h2>Propiedades en Venta</h2>
        <h6>Se encontraron <b><?php echo $vc_total_resultados ?></b> propiedades</h6>
      <?php } else if ($vc_tipo_operacion == 2) { ?>
        <h2>Propiedades en Alquiler</h2>
        <h6>Se encontraron <b><?php echo $vc_total_resultados ?></b> propiedades</h6>
      <?php } else if ($vc_tipo_operacion == 4) { ?>
        <h2>Emprendimientos</h2>
        <h6>Se encontraron <b><?php echo $vc_total_resultados ?></b> emprendimientos</h6>
      <?php } else if ($vc_tipo_operacion == 5) { ?>
        <h2>Obras</h2>
        <h6>Se encontraron <b><?php echo $vc_total_resultados ?></b> obras</h6>
      <?php } else { ?>
        <h2>Propiedades</h2>
        <h6>Se encontraron <b><?php echo $vc_total_resultados ?></b> propiedades</h6>
      <?php } ?>
    </div>

    <?php 
    $buscador_mapa = true;
    include("includes/propiedad/buscador.php"); ?>

    <div id="mapa" style="width:100%; height:700px"></div>
  </div>
</section>

<?php include("includes/footer.php") ?>

<?php 
include_once("templates/comun/mapa_js.php"); 
include_once("includes/mapa_js.php");
?>
</body>

</html>