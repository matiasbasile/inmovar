<?php 
include("includes/init.php");
extract($propiedad_model->get_variables());
$page_act = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?php include "includes/head.php" ?>
	<style type="text/css">
		.leaflet-popup-content { overflow: auto !important }
.feature-item { overflow: auto; }
.feature-item .feature-image { text-align: center; margin: 10px; }
.feature-item .tab_list_box_content { text-align: center; }
	</style>
</head>
<body>

	<!-- Header -->
	<?php include "includes/header.php" ?>

	<!-- Page Title -->
	<div class="page-title">
		<div class="container">
			<div class="page">
				<div class="breadcrumb"> <a href="javascript:void(0)"><?php echo (!empty($vc_tipo_operacion))?$vc_tipo_operacion:"Propiedades" ?></a> <span><?php echo $vc_total_resultados ?> Resultados de búsqueda encontrados</span></div>
				<div class="float-right">
					<big>Tus favoritas</big> 
					<a href="<?php echo mklink ("favoritos/")?>"><i class="fas fa-heart"></i> <span><?php echo $cant_favoritos ?></span></a>
				</div>
			</div>
		</div>
	</div>

	<!-- Products Listing -->
	<div class="products-listing">
		<div class="container">
			<div class="row">
				<div class="col-xl-8">
					<div id="mapid" style="min-height: 500px; width: 100%"></div>
				</div>
				<div class="col-xl-4">
					<div class="border-box">
            <?php include "includes/search-filter.php" ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Call To Action -->
  	<?php include "includes/comunicate.php" ?>
	

	<!-- Footer -->
	<?php include "includes/footer.php" ?>

	<!-- Back To Top -->
	<div class="back-to-top"><a href="javascript:void(0);" aria-label="Back to Top">&nbsp;</a></div>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/html5.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	<script src="assets/js/nouislider.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script src="assets/js/scripts.js"></script>

<?php include_once("templates/comun/mapa_js.php"); ?>

<script type="text/javascript">
$(document).ready(function(){

  var mymap = L.map('mapid').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

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
            '<a href=\"<?php echo $p->link_propiedad ?>\">'+
              '<img style="max-width:150px" src=\"<?php echo $path ?>\"/>'+
            '</a>'+
          '</div>'+
          '<div class="tab_list_box_content">'+
            '<h6><a href=\"<?php echo $p->link_propiedad ?>\"><?php echo ($p->nombre) ?></a></h6>'+
            '<p>'+
              '<?php echo $p->calle." ".$p->entre_calles ?>'+
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
		function submit_buscador_propiedades() {
  // Cargamos el offset y el orden en este formulario
  $("#sidebar_orden").val($("#ordenador_orden").val());
  $("#sidebar_offset").val($("#ordenador_offset").val());
  $("#form_propiedades").submit();
}
function onsubmit_buscador_propiedades() { 
	var link = (($("input[name='tipo_busqueda']:checked").val() == "mapa") ? "<?php echo mklink("mapa/")?>" : "<?php echo mklink("propiedades/")?>");
	var tipo_operacion = $("#tipo_operacion").val();
	var localidad = $("#localidad").val();
	var tipo_propiedad = $("#tp").val();
	link = link + tipo_operacion + "/" + localidad + "/<?php echo $vc_params?>";

	$("#form_propiedades").attr("action",link);
	return true;
}
</script>
<script type="text/javascript">
if (jQuery(window).width()>767) { 
  $(document).ready(function(){
    var maximo = 0;
    $(".list-wise .property-details h3").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".list-wise .property-details h3").height(maximo);
  });
}
</script>
</body>
</html>