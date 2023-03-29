<?php
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("includes/funciones.php");
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>

<!-- TOP WRAPPER -->
<div class="top-wrapper">
  <?php include("includes/header.php"); ?>
  <div class="page-title">
    <div class="page">
      <div class="breadcrumb"><a href="<?php echo mklink("/"); ?>"><img src="images/home-icon3.png" alt="Home" /> Home</a> <span>Contacto</span></div>
      <big>Contacto</big> </div>
  </div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
  <div class="page">
    <div class="contact">
      <div class="border-box">
        <div class="box-space">
          <div class="double-border">
            <div id="map"></div>
          </div>
          <div class="title">contacto</div>
          <?php
          $texto = $web_model->get_text("contacto1","Ante cualquier consulta no dude en comunicarse mediante el siguiente formulario de contacto o bien hacerlo por Whatsapp directamente en la página web. Responderemos a la brevedad. Muchas gracias."); ?>
          <p class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $texto->id ?>" data-clave="<?php echo $texto->clave ?>"><?php echo html_entity_decode($texto->texto,ENT_QUOTES); ?></p>
        </div>
        <div class="info-title">formulario de consulta</div>
        <div class="box-space">
          <div class="form">
            <div class="row">
              <?php
              $id_origen = 6;
              include("includes/form_contacto.php"); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>

<!-- SCRIPT'S --> 
<script type="text/javascript" src="js/jquery.min.js"></script> 
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript">
$(document).ready(function(){

  <?php if (!empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: '<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>',
    }).addTo(mymap);


    var icono = L.icon({
      iconUrl: 'images/map-place.png',
      iconSize:     [60, 60], // size of the icon
      iconAnchor:   [30, 30], // point of the icon which will correspond to marker's location
    });

    <?php
    $posiciones = explode("/",$empresa->posiciones);
    for($i=0;$i<sizeof($posiciones);$i++) { 
      $pos = explode(";",$posiciones[$i]); ?>
      L.marker([<?php echo $pos[0] ?>,<?php echo $pos[1] ?>],{
        icon: icono
      }).addTo(mymap);
    <?php } ?>

  <?php } ?>

});
</script>
</body>
</html>
