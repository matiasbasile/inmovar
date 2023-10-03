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
    <?php include 'includes/head.php'; ?>
</head>

<body class="bg-gray">

    <?php include 'includes/header.php'; ?>

    <section class="equipo-banner">
        <div class="container">
            <div class="equipo-content">
                <h1 class="banner-title"><?php echo $vc_nombre_operacion; ?></h1>
            </div>
        </div>
    </section>

    <section class="pb0">
        <div class="container">
            <div class="mis-content">
                <h2 class="small-title">
                    Propiedades en <?php echo $vc_nombre_operacion; ?>: <span>
                        <?php echo $vc_total_resultados; ?></span>
                </h2>
                <h4>Resultados de búsqueda</h4>
            </div>
            <?php
    $buscador_mapa = true;
include 'includes/listado/filter.php'; ?>
        </div>
        <div id="mapa" class="mt40 mb40 mx-auto" style="width:90%; height:500px"></div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWmUapFYTBXV3IJL9ggjT9Z1wppCER55g&callback=initMap"> -->
    <?php
    include_once 'templates/comun/mapa_js.php';
include_once 'includes/mapa_js.php';
?>

    </script>
    <!-- <script src="assets/js/fancybox.umd.js"></script> -->
    <script src="assets/js/script.js"></script>
</body>

</html>