<?php
include "includes/init.php" ;
$nombre_pagina = "mapa";
$get_params["offset"] = 9999;
extract($propiedad_model->get_variables());
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="loading">

  <div class="home-slider">
    <?php include("includes/header.php") ?>
    <div class="container">
      <div class="breadcrumb-area">
        <?php if (strtolower($vc_tipo_operacion) == "ventas") { ?>
          <h1 class="h1">Propiedades en venta</h1>
        <?php } else if (strtolower($vc_tipo_operacion) == "alquileres") { ?>
          <h1 class="h1">Propiedades en alquiler</h1>
        <?php } else if (strtolower($vc_tipo_operacion) == "emprendimientos") { ?>
          <h1 class="h1">Emprendimientos</h1>
        <?php } ?>
        <ul class="breadcrumbs">
          <li><a href="<?php echo mklink ("/") ?>">Inicio</a></li>
          <li class="active"><?php echo $vc_tipo_operacion ?></li>
        </ul>
      </div>
    </div>
  </div>  

  <!-- MAIN WRAPPER -->
  <div id="map" style="height:500px"></div>
  <?php include("includes/searchbar_home.php"); ?>
  <?php include("includes/footer.php"); ?>
  <?php include_once("templates/comun/mapa_js.php"); ?>

<script>

$(document).ready(function(){

  var mymap = L.map('map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
    }).addTo(mymap);


  <?php $i=0;
  foreach($vc_listado as $p) {
    if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) { ?>
      var contentString<?php echo $i; ?> = '<div>'+
        '<div class="feature-item" style="padding: 0px; display:table">'+
          '<div class="feature-image">'+
            '<a href=\"<?php echo $p->link_propiedad ?>\">'+
              '<img style="width:300px !important" src=\"/admin/<?php echo ((!empty($p->path)) ? $p->path : $empresa->no_imagen) ?>\"/>'+
            '</a>'+
          '</div>'+
          '<div class="list-view-detail">'+
            '<div class="featured-detail">'+
              '<h5><a href=\"<?php echo $p->link_propiedad ?>\"><?php echo ($p->nombre) ?></a></h5>'+
              '<p><?php echo $p->localidad ?></p>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>';

      var marker<?php echo $i; ?> = L.marker([<?php echo $p->latitud ?>,<?php echo $p->longitud ?>]);
      marker<?php echo $i; ?>.addTo(mymap);

      marker<?php echo $i; ?>.bindPopup(contentString<?php echo $i; ?>);

    <?php } ?>
  <?php $i++; } ?>

});
</script>
</body>
</html>