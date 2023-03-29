<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("includes/init.php");
$nombre_pagina = "mapa";
extract($propiedad_model->get_variables(array(
  "offset"=>99999
)));
?>
<!doctype html>
<html lang="en">
<head>
<?php include "includes/head.php" ?>
<style type="text/css">
#mapa_propiedades { float: left; width: 100%; height: 420px;}
.leaflet-popup-content { overflow: auto !important }
.feature-item { overflow: auto; }
.feature-item .feature-image { text-align: center; margin: 10px; }
.feature-item .tab_list_box_content { text-align: center; }
</style>
</head>
<body>

<div class="wrapper">
  <?php include("includes/header.php"); ?>
  <!-- Page Content -->
  <div id="page-content">
    <!-- Breadcrumb -->
    <div class="container">
      <ol class="breadcrumb">
        <li><a href="<?php echo mklink("/"); ?>">Inicio</a></li>
        <li class="active"><?php echo $vc_tipo_operacion; ?></li>
      </ol>
    </div>
    <!-- end Breadcrumb -->

    <div class="container">
      <div class="row">
        <!-- Results -->
        <div class="col-md-9 col-sm-9">
          <section id="results">
            <header><h1><?php echo $vc_tipo_operacion; ?></h1></header>
            <section id="search-filter">
              <figure>
                <h3><i class="fa fa-search"></i>Resultados de b&uacute;squeda:</h3>
                <span class="search-count"><?php echo $vc_total_resultados; ?></span>
              </figure>
            </section>
            <section id="properties" class="display-lines">
              <div id="mapa_propiedades"></div>
            </section>
          </section>
        </div>

        <!-- sidebar -->
        <div class="col-md-3 col-sm-3">
          <section id="sidebar">
            <aside id="edit-search">
              <header><h3>Buscador</h3></header>
              <?php include("includes/buscador.php"); ?>
            </aside>
          </section>
        </div>

      </div>
    </div>
  </div>

  <?php include("includes/footer.php"); ?>
</div>

<script type="text/javascript" src="assets/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/smoothscroll.js"></script>
<script type="text/javascript" src="assets/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="assets/js/retina-1.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="assets/js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="assets/js/tmpl.js"></script>
<script type="text/javascript" src="assets/js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="assets/js/draggable-0.1.js"></script>
<script type="text/javascript" src="assets/js/jquery.slider.js"></script>
<script type="text/javascript" src="assets/js/custom.js"></script>
<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>

<?php include_once("templates/comun/mapa_js.php"); ?>

<script type="text/javascript">
$(document).ready(function(){

  var mymap = L.map('mapa_propiedades').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: '<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>',
    }).addTo(mymap);


  /*
  var icono = L.icon({
    iconUrl: "images/map-marker.png",
    iconSize:     [44,50], // size of the icon
    iconAnchor:   [44,25], // point of the icon which will correspond to marker's location
  });
  */

  mymap.fitBounds([
    <?php foreach($vc_listado as $p) {
      if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) {  ?>
        [<?php echo $p->latitud ?>,<?php echo $p->longitud ?>],
      <?php } ?>
    <?php } ?>
  ]);

  <?php $i=0;
  foreach($vc_listado as $p) {
    if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) { 
      $path = "images/no-imagen.png";
      if (!empty($p->imagen)) { 
        $path = $p->imagen;
      } else if (!empty($empresa->no_imagen)) {
        $path = "/admin/".$empresa->no_imagen;
      } ?>
      var contentString<?php echo $i; ?> = '<div>'+
        '<div class="feature-item" style="padding: 0px;">'+
          '<div class="feature-image">'+
            '<a href=\"<?php echo $p->link_propiedad ?>\">'+
              '<img style="max-width:150px" src=\"<?php echo $path ?>\"/>'+
            '</a>'+
          '</div>'+
          '<div class="tab_list_box_content">'+
            '<h6><a href=\"<?php echo $p->link_propiedad ?>\"><?php echo ($p->nombre) ?></a></h6>'+
            '<p>'+
              '<?php echo $p->direccion_completa ?>'+
              '<br><span class="color_span"><?php echo $p->localidad ?></span>'+
            '</p>'+
            '<h6 class="price_dollar"><?php echo $p->precio ?></h6>'+
          '</div>'+
        '</div>'+
      '</div>';
    
      var marker<?php echo $i; ?> = L.marker([<?php echo $p->latitud ?>,<?php echo $p->longitud ?>],{
        //icon: icono
      });
      marker<?php echo $i; ?>.addTo(mymap);

      marker<?php echo $i; ?>.bindPopup(contentString<?php echo $i; ?>);

    <?php } ?>
  <?php $i++; } ?>
});
</script>
<script type="text/javascript">
function enviar_buscador_propiedades() { 
  var link = "<?php echo mklink("mapa/")?>";
  var tipo_operacion = $("#tipo_operacion").val();
  var localidad = $("#localidad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>
</body>
</html>
