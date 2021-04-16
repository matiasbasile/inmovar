<?php
include_once("includes/funciones.php");

$sql = "SELECT * ";
$sql.= "FROM web_paginas WHERE id = '$id' AND id_empresa = $empresa->id AND activo = 1 LIMIT 0,1";
$q = mysqli_query($conx,$sql);
if (mysqli_num_rows($q)<=0) {
	echo "Pagina incorrecta"; exit();
}
$pagina = mysqli_fetch_object($q);

// SEO
if (!empty($pagina->seo_title)) $seo_title = $pagina->seo_title;
if (!empty($pagina->seo_keywords)) $seo_keywords = $pagina->seo_keywords;
if (!empty($pagina->seo_description)) $seo_description = $pagina->seo_description;
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
      <div class="breadcrumb">
        <a href="<?php echo mklink("/") ?>"><img src="images/home-icon3.png" alt="Home" /> Home</a>
        <span><?php echo ($pagina->titulo_es); ?></span>
      </div>
      <big><?php echo ($pagina->titulo_es); ?></big>
    </div>
  </div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
  <div class="page">
    <div class="border-box">
      <div class="box-space">
        <?php if (!empty($pagina->path)) { ?>
          <div class="double-border">
            <div class="block-picture">
              <img src="/admin/<?php echo $pagina->path ?>" alt="<?php echo ($pagina->titulo_es); ?>" />
            </div>
          </div>
        <?php } ?>
        <div class="title"><?php echo ($pagina->titulo_es); ?></div>
        <?php echo html_entity_decode($pagina->texto_es,ENT_QUOTES); ?>
      </div>
    </div>
    <?php include("includes/links.php"); ?>
  </div>
</div>

<?php include("includes/consulta_rapida.php"); ?>

<?php include("includes/footer.php"); ?>

<!-- SCRIPT'S --> 
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/custom.js"></script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){

  <?php if (!empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
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
