<?php
include_once("includes/init.php");
if (!isset($config_grupo)) $config_grupo = array();
$config_grupo["orden_default"] = 8; 

// Si tiene el flag de ofertas
if (isset($buscar_ofertas)) $config_grupo["es_oferta"] = 1;

$propiedades = extract($propiedad_model->get_variables($config_grupo));
if (isset($get_params["test"])) echo $propiedad_model->get_sql();
$nombre_pagina = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">

<head>
  <?php include("includes/head.php"); ?>
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

    <?php include("includes/propiedad/buscador.php"); ?>

    <div class="neighborhoods shadow-none style-two">
      <div class="row m-0 my-5 propiedades">
        <?php $cont = 0; ?>
        <?php 
        foreach ($vc_listado as $r) { 
          item($r);
        } ?>
      </div>
    </div>
    <div class="d-block mt-5">
      <a onclick="cargar()" id="cargarMas" class="btn btn-primary btn-block btn-lg">ver más propiedades para tu búsqueda</a>
    </div>
  </div>
</section>

<?php 
include("includes/footer.php");
include("includes/cargar_mas_js.php"); ?>
</body>

</html>