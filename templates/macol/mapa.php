<?php
include_once 'includes/init.php';
extract($propiedad_model->get_variables([
  'offset' => 9999999,
]));
$nombre_pagina = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
    <?php $pageTitle = $vc_tipo_operacion;
    $pageTitle = ($pageTitle == "Ventas") ? "Comprar" : $pageTitle;
    include 'includes/head.php'; ?>
</head>
<body class="bg-gray">

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Banner -->
    <?php include 'includes/smallBanner.php'; ?>

    <!-- Filter -->
    <?php 
    $buscador_mapa = true;
    include 'includes/listado/filter.php'; ?>

    <div id="mapa" style="height:600px"></div>

    <?php include 'includes/footer.php'; ?>

    <?php
    include_once 'templates/comun/mapa_js.php';
    include_once 'includes/mapa_js.php';
    ?>
</body>
</html>