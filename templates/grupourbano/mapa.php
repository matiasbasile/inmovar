<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("includes/init.php");
include_once("includes/funciones.php");
$nombre_pagina = "mapa";

$propiedades = extract($propiedad_model->get_variables(array(
  "offset"=>9999999
)));
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
<style type="text/css">
.search-filter input[type="checkbox"] + label { color: #030303; }
</style>
</head>
<body id="mapa_page">
<?php include("includes/header.php"); ?>

<div id="mapa" style="width:100%; height:700px"></div>
<!-- MAIN WRAPPER -->
<section id="searchbar" class="our-clients">
  <div class="container">
    <div class="row">
      <div class="col-md-12 primary">
        <div class="row">
		<?php include_once("includes/searchbar.php"); ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include("includes/footer.php"); ?>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){

  
  var mymap = L.map('mapa').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);
  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>', {
    attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
    tileSize: 512,
    maxZoom: 18,
    zoomOffset: -1,
    id: 'mapbox/streets-v11',
    accessToken: '<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>',
  }).addTo(mymap);


mymap.fitBounds([
  <?php foreach($vc_listado as $p) {
    if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) {  ?>
      [<?php echo $p->latitud ?>,<?php echo $p->longitud ?>],
    <?php } ?>
  <?php } ?>
  ]);

  var icono = L.icon({
    iconUrl: 'images/map-place.png',
    iconSize:     [60, 60], // size of the icon
    iconAnchor:   [30, 30], // point of the icon which will correspond to marker's location
  });

  <?php $i=0;
  foreach($vc_listado as $p) {
    if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) { ?>
      var contentString<?php echo $i; ?> = '<div id="content">'+
        '<div style="padding: 0px;">'+
            <?php if(!empty($p->link_propiedad)) { ?>'<a href=\"<?php echo $p->link_propiedad ?>\">'+<?php } ?>
            '<h4 style="font-size:20px;margin:5px 0px"><?php echo ($p->nombre) ?></h4>'+
            '<p style="font-size:16px;color:#222;margin:0px;"><?php echo ($p->direccion_completa." | ".$p->localidad) ?></p>'+
            <?php if(!empty($p->link_propiedad)) { ?>'</a>'+<?php } ?>
            <?php if(!empty($p->link_propiedad)) { ?>'<a href=\"<?php echo $p->link_propiedad ?>\">'+<?php } ?>
            '<img width=\"200\" src=\"<?php echo $p->imagen ?>\"/>'+
            <?php if(!empty($p->link_propiedad)) { ?>'</a>'+<?php } ?>
        '</div>'+
        '</div>';

      var marker<?php echo $i; ?> = L.marker([<?php echo $p->latitud ?>,<?php echo $p->longitud ?>],{
        icon: icono
      });
      marker<?php echo $i; ?>.addTo(mymap);

      marker<?php echo $i; ?>.bindPopup(contentString<?php echo $i; ?>);

    <?php } ?>
  <?php $i++; } ?>

});
</script>
</body>
</html>