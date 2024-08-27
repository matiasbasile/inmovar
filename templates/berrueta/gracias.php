<?php
include_once("includes/init.php");
$nombre_pagina = "home";
$tipo_operacion = new stdClass();
$vc_id_tipo_operacion = 2;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include("includes/head.php"); ?>
</head>
<body class="loading home">

<!-- TOP WRAPPER -->
<div class="top-wrapper" style="position: relative;">
  <?php include("includes/header.php"); ?>
</div>

<?php include("templates/comun/gracias.php"); ?>


<?php include("includes/footer.php"); ?>

<!-- SCRIPT'S --> 
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/revolution.js"></script> 
<script type="text/javascript" src="js/tap.js"></script> 
<script type="text/javascript" src="js/flexslider.js"></script> 
<script type="text/javascript" src="js/custom.js"></script> 
<script type="text/javascript">
//REVOLUTION SLIDER SCRIPT
jQuery('.revolution').revolution({
	delay: 9000,
	startwidth: 1170,
	startheight: 650,
	hideThumbs: 10,
	fullWidth: "on",
	fullScreen: "on",
	navigationType: "bullet",
	navigationArrows: "solo",
	navigationStyle: "round",
	navigationHAlign: "center",
	navigationVAlign: "bottom",
	navigationHOffset: 30,
	navigationVOffset: 30,
	soloArrowLeftHalign: "left",
	soloArrowLeftValign: "center",
	soloArrowLeftHOffset: 20,
	soloArrowLeftVOffset: 0,
	soloArrowRightHalign: "right",
	soloArrowRightValign: "center",
	soloArrowRightHOffset: 20,
	soloArrowRightVOffset: 0,
	touchenabled: "on"
});
</script> 
<script type="text/javascript">
//FLEXSLIDE SCRIPT
$(window).load(function(){
  $('.flexslider').flexslider({
    animation: "fade",
    start: function(slider){
      $('body').removeClass('loading');
    }
  });
});
</script> 
<script type="text/javascript">
//TABS SCRIPT
$('.tabs_search ul').each(function(){
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
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){

  <?php if (!empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

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
