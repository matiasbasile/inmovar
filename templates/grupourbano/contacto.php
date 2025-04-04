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
</head>
<body>
  
<?php include("includes/header.php"); ?>

<section class="main-wrapper">
  <div class="container">
    <div class="contact">
      <div class="border-box">
        <div class="box-space">
          <div id="map"></div>
          <div class="section-title"><big>contacto</big></div>
          <?php if (!empty($empresa->texto_contacto)) { ?>
            <?php echo html_entity_decode($empresa->texto_contacto,ENT_QUOTES); ?>
          <?php } ?>
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

  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    tileSize: 512,
    maxZoom: 18,
    zoomOffset: -1,
  }).addTo(mymap);

  var icono = L.icon({
    iconUrl: 'images/map-place.png',
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
