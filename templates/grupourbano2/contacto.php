<?php
include_once("includes/init.php");
$nombre_pagina = "contacto";
include_once("includes/funciones.php");
$id_origen = 6; // LA CONSULTA VIENE DEL FORM DE CONTACTO
$id_usuario = 0;

if (isset($_POST["id_usuario"])) {
  $id_usuario = filter_var($_POST["id_usuario"],FILTER_SANITIZE_STRING);
  $q = mysqli_query($conx,"SELECT * FROM com_usuarios WHERE id = $id_usuario");
  if (mysqli_num_rows($q)>0) {
     $usuario = mysqli_fetch_object($q);
     $contacto_para = $usuario->email;
	 $id_origen = 8; // LA CONSULTA VIENE DE STAFF
  } 
}

$titulo_pagina = "Contacto";
$breadcrumb = array(
  array("titulo"=>"Contacto","link"=>"/contacto/")
);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
<link rel="stylesheet" type="text/css" href="assets/css/gu1.css?v=3">
</head>
<body class="bg-gray">
  
<?php include("includes/header.php"); ?>

<section class="main-wrapper oh">
  <div class="container">
    <div class="contact">
      <div class="border-box">
        <div class="box-space">
          <div id="map"></div>
        </div>
        <div class="info-title">formulario de consulta</div>
        <div class="box-space">
          <div class="form">
            <div class="row">
              <?php include("includes/form_contacto.php"); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include("includes/footer.php"); ?>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
    //OWL CAROUSEL(2) SCRIPT
jQuery(document).ready(function ($) {
"use strict";
$(".owl-carouselmarcas").owlCarousel({
      items : 5,
      itemsDesktop : [1279,2],
      itemsDesktopSmall : [979,2],
      itemsMobile : [639,1],
    });
});
//MAP SCRIPT
$(document).ready(function(){

  var mymap = L.map('map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], <?php echo $empresa->zoom ?>);

  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
    tileSize: 512,
    maxZoom: 18,
    zoomOffset: -1,
    id: 'mapbox/streets-v11',
    accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
  }).addTo(mymap);


  var icono = L.icon({
    iconUrl: 'assets/images/map-place.png',
    iconSize:     [60, 60], // size of the icon
    iconAnchor:   [30, 30], // point of the icon which will correspond to marker's location
  });

  L.marker([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>],{
    icon: icono
  }).addTo(mymap);

});  
</script>

</body>
</html>
