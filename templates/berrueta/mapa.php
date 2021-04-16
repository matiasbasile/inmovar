<?php 
include("includes/init.php");
extract($propiedad_model->get_variables(array(
  "offset"=>9999999
)));

$vc_page_active = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
<style type="text/css">
.search-filter input[type="checkbox"] + label { color: #030303; }
.m0 { margin: 0  }
</style>
</head>
<body id="mapa_page">
<?php include("includes/header.php"); ?>

<?php if (!empty($vc_listado)) {  ?>
<div id="mapa" style="width:100%; height:700px; z-index: 0"></div>
<?php } else { ?>
  <div class="main-wrapper">
    <div class="page">
      <div class="col-md-12" style="min-height: 300px;padding: 30px 0;">
        No se encontraron resultados.   
      </div>
    </div>
  </div>
</div>
<?php }?>
<!-- MAIN WRAPPER -->
<section id="searchbar" class="our-clients">
  <div class="container">
    <div class="row m0">
      <div class="col-md-12 primary">
		      <?php include_once("includes/searchbar.php"); ?>
      </div>
    </div>
  </div>
</section>
<?php include("includes/footer.php"); ?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/tap.js"></script> 
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script> 

<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){

  var mymap = L.map('mapa').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

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
  mymap.fitBounds([
  <?php foreach($vc_listado as $p) {
    if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) {  ?>
      [<?php echo $p->latitud ?>,<?php echo $p->longitud ?>],
    <?php } ?>
  <?php } ?>
  ]);

  <?php $i=0;
  foreach($vc_listado as $p) {
    if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) { ?>
      var contentString<?php echo $i; ?> = '<div class="map_content">'+
        '<div class="feature-item" style="padding: 0px; display:table">'+
          '<div class="feature-image" style="width: 200px; display: table-cell; float:none">'+
            '<a href=\"<?php echo $p->link_propiedad ?>\">'+
              '<img style="max-width:100%" src=\"/admin/<?php echo ((!empty($p->path)) ? $p->path : $empresa->no_imagen) ?>\"/>'+
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
<script type="text/javascript">
$('.tabs ul').each(function(){
  var $active, $content, $links = $(this).find('a');
  $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
  $active.addClass('active');
  $content = $($active[0].hash);
  $links.not($active).each(function () {
    $(this.hash).hide();
  });
  $(this).on('click', 'a', function(e){
    $active.removeClass('active');
    $content.hide();
    $active = $(this);
    $content = $(this.hash);
    $active.addClass('active');
    $content.show();
    e.preventDefault();
  });
});

$(document).ready(function(){
  <?php for($i=0;$i<5;$i++) { ?>
	  $("#show-in-list-<?php echo $i ?>").click(function(){
	    var v = $("#show-in-list-<?php echo $i ?>").prop("checked");
	    $("#show-in-map-<?php echo $i ?>").prop("checked",!v);
	  });
	  $("#show-in-map-<?php echo $i ?>").click(function(){
	    var v = $("#show-in-map-<?php echo $i ?>").prop("checked");
	    $("#show-in-list-<?php echo $i ?>").prop("checked",!v);
	  });
  <?php } ?>
});
</script>
</body>
</html>
