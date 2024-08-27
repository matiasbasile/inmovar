<?php 
include("includes/init.php");
extract($propiedad_model->get_variables(array(
  "offset"=>9999999
)));
$vc_page_active = $vc_link_tipo_operacion;
?><!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include("includes/head.php"); ?>
</head>
<body>
<?php include("includes/header.php"); ?>

<div class="page-title">
  <div class="container">
    <div class="pull-left">
      <h2><?php echo (!empty($vc_link_tipo_operacion)) ? $vc_link_tipo_operacion : "propiedades" ?></h2>
    </div>
    <div class="breadcrumb">
      <ul>
        <li><a href="<?php echo mklink ("/") ?>">Inicio</a><span>|</span></li>
        <li><?php echo (!empty($vc_link_tipo_operacion)) ? $vc_link_tipo_operacion : "propiedades" ?></li>
      </ul>
    </div>
  </div>
</div>

<div id="map" style="height:650px"></div>

<?php include("includes/footer.php"); ?>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){

  var mymap = L.map('map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
    }).addTo(mymap);


  var icono = L.icon({
    iconUrl: 'images/gps.png',
    iconSize:     [37, 68], // size of the icon
    iconAnchor:   [19, 68], // point of the icon which will correspond to marker's location
  });

  <?php $i=0;
  foreach($vc_listado as $p) {
    if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) { ?>
      var contentString<?php echo $i; ?> = '<div class="map_content">'+
        '<div class="feature-item" style="padding: 0px; display:table">'+
          '<div class="feature-image" style="width: 200px; display: table-cell; float:none">'+
            '<a href=\"<?php echo $p->link_propiedad ?>\">'+
              '<img style="max-width:100%" src=\"<?php echo ((!empty($p->imagen)) ? $p->imagen : $empresa->no_imagen) ?>\"/>'+
            '</a>'+
          '</div>'+
          '<div class="list-view-detail" style="width: 200px; float:none; vertical-align:top; display:table-cell">'+
            '<div class="featured-detail">'+
              '<h5><a href=\"<?php echo $p->link_propiedad ?>\"><?php echo ($p->nombre) ?></a></h5>'+
              '<p><?php echo $p->direccion_completa ?> <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->localidad ?></a></p>'+
            '</div>'+
          '</div>'+
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