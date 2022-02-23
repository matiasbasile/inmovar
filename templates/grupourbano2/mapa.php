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

    <?php include("includes/propiedad/buscador.php"); ?>
    
    <div id="mapa" style="width:100%; height:700px"></div>
  </div>
</section>

<?php include("includes/footer.php") ?>

<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function() {

  var mymap = L.map('mapa').setView([<?php echo $empresa->latitud ?>, <?php echo $empresa->longitud ?>], 15);
  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
    tileSize: 512,
    maxZoom: 18,
    zoomOffset: -1,
    id: 'mapbox/streets-v11',
    accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
  }).addTo(mymap);


  mymap.fitBounds([
    <?php foreach ($vc_listado as $p) {
      if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) {  ?>[<?php echo $p->latitud ?>, <?php echo $p->longitud ?>],
      <?php } ?>
    <?php } ?>
  ]);

  /*var icono = L.icon({
    iconUrl: 'images/map-place.png',
    iconSize: [60, 60], // size of the icon
    iconAnchor: [30, 30], // point of the icon which will correspond to marker's location
  });*/

  <?php $i = 0;
  foreach ($vc_listado as $p) {
    if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) { ?>
      var contentString<?php echo $i; ?> = '<div id="content">' +
        '<div style="padding: 0px;">' +
        <?php if (!empty($p->link_propiedad)) { ?> '<a href=\"<?php echo $p->link_propiedad ?>\">' + <?php } ?> '<h4 style="font-size:20px;margin:5px 0px"><?php echo ($p->nombre) ?></h4>' +
        '<p style="font-size:16px;color:#222;margin:0px;"><?php echo ($p->direccion_completa . " | " . $p->localidad) ?></p>' +
        <?php if (!empty($p->link_propiedad)) { ?> '</a>' + <?php } ?>
      <?php if (!empty($p->link_propiedad)) { ?> '<a href=\"<?php echo $p->link_propiedad ?>\">' + <?php } ?> '<img width=\"200\" src=\"<?php echo $p->imagen ?>\"/>' +
        <?php if (!empty($p->link_propiedad)) { ?> '</a>' + <?php } ?> '</div>' +
        '</div>';

        var marker<?php echo $i; ?> = L.marker([<?php echo $p->latitud ?>, <?php echo $p->longitud ?>], {
          //icon: icono
        });
        marker<?php echo $i; ?>.addTo(mymap);

        marker<?php echo $i; ?>.bindPopup(contentString<?php echo $i; ?>);

      <?php } ?>
    <?php $i++;
  } ?>

});
</script>
</body>

</html>