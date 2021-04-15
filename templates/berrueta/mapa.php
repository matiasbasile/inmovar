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
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/tap.js"></script> 
<script type="text/javascript" src="js/custom.js"></script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){

  var mymap = L.map('mapa').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
      '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
      'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox.streets'
  }).addTo(mymap);

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
            <?php if(!empty($p->link)) { ?>'<a href=\"<?php echo mklink($p->link) ?>\">'+<?php } ?>
            '<h4 style="font-size:20px;font-weight:bold;color:#e15616"><?php echo ($p->nombre) ?></h4>'+
            '<p style="margin:0px;font-size:16px;color:#999"><?php echo ($p->calle." | ".$p->localidad) ?></p>'+
            <?php if(!empty($p->link)) { ?>'</a>'+<?php } ?>
            <?php if(!empty($p->link)) { ?>'<a href=\"<?php echo mklink($p->link) ?>\">'+<?php } ?>
            '<img width=\"200\" src=\"/admin/<?php echo $p->path ?>\"/>'+
            <?php if(!empty($p->link)) { ?>'</a>'+<?php } ?>
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
