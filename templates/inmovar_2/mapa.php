<?php
include "includes/init.php" ;
$nombre_pagina = "listado";
$get_params["offset"] = 12;
extract($propiedad_model->get_variables());
$page_active = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php include "includes/head.php" ?>
</head>
<body>
	<?php include "includes/header.php" ?>
	<!-- Sub banner start -->
	<?php $t = $web_model->get_text("property-banner","images/sub-banner-1.jpg")?>
	<div class="sub-banner editable editable-img" data-id_empresa="<?php echo $empresa->id ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" data-height="279" data-width="1583">
		<div class="overlay">
			<div class="container">
				<div class="breadcrumb-area">
					<h1 class="h1"><?php echo $vc_link_tipo_operacion ?></h1>
				</div>
			</div>
		</div>
	</div>
	<!-- Sub Banner end -->
	<!-- Properties section body start -->
	<div class="properties-section-body content-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-xs-12 col-md-push-4">
          <?php if (!empty($vc_listado)) {  ?>
          <div id="map1" style="height: 650px"></div>
        <?php } else { ?>
          <h3>No se han encontrado resultados para su búsqueda.</h3>
        <?php }?>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 col-md-pull-8">
         <?php include("includes/avanzada.php"); ?>
         <?php include("includes/destacadas.php"); ?>
       </div>
     </div>
   </div>
 </div>
 <!-- Properties section body end -->

 <!-- Footer start -->
 <?php include "includes/footer.php" ?>
 <?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
  $(document).ready(function(){

    var mymap = L.map('map1').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
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
    '<a href=\"<?php echo ($p->link_propiedad) ?>\">'+
    '<img style="" src=\"<?php echo $path ?>\"/>'+
    '</a>'+
    '</div>'+
    '<div class="tab_list_box_content">'+
    '<h6 class="title-map"><a href=\"<?php echo ($p->link_propiedad) ?>\"><?php echo ($p->nombre) ?></a></h6>'+
    '<p>'+
    '<?php echo $p->direccion_completa.". ".$p->localidad ?>' +
    '</p>'+
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
  $('.MyCheck').on('change', function() {
    $('.MyCheck').not(this).prop('checked', false);
  });
</script>
</body>
</html>