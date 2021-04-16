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

  <?php
  $sql = "SELECT * FROM web_slider WHERE id_empresa = $empresa->id ORDER BY orden ASC";
  $q = mysqli_query($conx,$sql);
  if (mysqli_num_rows($q)>0) { ?>
    <div class="revolution-container">
      <div class="revolution">
        <ul class="list-unstyled">
          <?php while(($r=mysqli_fetch_object($q))!==NULL) { ?>
            <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
              <img src="/admin/<?php echo $r->path ?>" alt="slidebg1" data-bgfit="cover" data-bgposition="center center" />
              <div class="tp-caption skewfromrightshort customout"
              data-x="20"
              data-y="220"
              data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
              data-speed="500"
              data-start="300"
              data-easing="Power4.easeOut"
              data-endspeed="500"
              data-endeasing="Power4.easeIn"
              data-captionhidden="on"
              style="z-index:4">
              <h3><?php echo ($r->linea_1) ?></h3>
            </div>
            <div class="tp-caption skewfromrightshort customout"
            data-x="20"
            data-y="260"
            data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
            data-speed="600"
            data-start="500"
            data-easing="Power4.easeOut"
            data-endspeed="500"
            data-endeasing="Power4.easeIn"
            data-captionhidden="on"
            style="z-index:4">
            <h1><?php echo ($r->linea_2) ?></h1>
          </div>
          <div class="tp-caption skewfromrightshort customout"
          data-x="20"
          data-y="320"
          data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
          data-speed="550"
          data-start="700"
          data-easing="Power4.easeOut"
          data-endspeed="500"
          data-endeasing="Power4.easeIn"
          data-captionhidden="on"
          style="z-index:4">
          <h4>
            <?php echo ($r->linea_3) ?>
            <?php if (!empty($r->linea_4)) { ?><br/><?php echo ($r->linea_4) ?><?php } ?>
          </h4>
        </div>
        <div class="tp-caption skewfromrightshort customout"
        data-x="20"
        data-y="410"
        data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
        data-speed="550"
        data-start="700"
        data-easing="Power4.easeOut"
        data-endspeed="500"
        data-endeasing="Power4.easeIn"
        data-captionhidden="on"
        style="z-index:4">
        <div class="block">
          <?php if (!empty($r->texto_link_1)) { ?>
            <a href="<?php echo $r->link_1 ?>" class="btn btn-orange-border"><?php echo ($r->texto_link_1) ?></a>
          <?php } ?>
          <?php if (!empty($r->texto_link_2)) { ?>
            <a href="<?php echo $r->link_2 ?>" class="btn btn-white-border"><?php echo ($r->texto_link_2) ?></a>
          <?php } ?>
        </div>
      </div>
    </li>
  <?php } ?>
</ul>
</div>
</div>
<?php } ?>

<!-- TOP WRAPPER -->
<div class="top-wrapper">
  <?php include("includes/header.php"); ?>
</div>

<?php include("includes/searchbar.php"); ?>

<?php
// PROPIEDADES DESTACADAS
$destacadas = $propiedad_model->destacadas(array(
  "offset"=>6,
  "solo_propias"=>1,
));

// ULTIMAS PROPIEDADES
$ultimas = $propiedad_model->ultimas(array(
  "offset"=>(empty($destacadas)) ? 8 : 4,
  "solo_propias"=>1,
));
?>
<!-- LATEST PROPERTIES -->
<div class="latest-properties">
  <div class="page">
    <div class="row">
      <?php if (!empty($destacadas)) { ?>
        <div class="col-md-6">
          <div class="flexslider">
            <ul class="slides">
              <?php foreach($destacadas as $r) { 
              $link_propiedad = (isset($r->pertenece_red) && $r->pertenece_red == 1) ? mklink($r->link)."&em=".$r->id_empresa : mklink($r->link); ?>
                <li>
                  <div class="propertie-list">
                    <div class="block">
                      <?php if (!empty($r->imagen)) { ?>
                        <img src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                      <?php } else if (!empty($empresa->no_imagen)) { ?>
                        <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                      <?php } else { ?>
                        <img src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
                      <?php } ?>
                    </div>
                    <div class="property-info">
                      <div class="info-row">
                        <div class="info-container">
                          <div class="property-status">
                            <span><?php echo $r->tipo_operacion ?></span>
                            <span>propiedad destacada</span>
                          </div>
                          <p>
                            <i><a href="<?php echo $r->link_propiedad ?>"><img src="images/plus-icon.png" alt="Read More" /></a></i>
                            <?php echo ($r->nombre); ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      <?php } ?>
      <div class="<?php echo (empty($destacadas)) ? "col-md-12" : "col-md-6"; ?>">
        <div class="row">
          <?php foreach($ultimas as $r) { 
            $link_propiedad = (isset($r->pertenece_red) && $r->pertenece_red == 1) ? mklink($r->link)."&em=".$r->id_empresa : mklink($r->link); ?>
            <div class="col-md-6">
              <div class="propertie-list ultimas">
                <div class="block">
                  <?php if (!empty($r->imagen)) { ?>
                    <img src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                  <?php } else if (!empty($empresa->no_imagen)) { ?>
                    <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                  <?php } else { ?>
                    <img src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
                  <?php } ?>
                </div>
                <div class="property-info">
                  <div class="info-row">
                    <div class="info-container">
                      <div class="property-status">
                        <span><?php echo $r->tipo_operacion ?></span>
                      </div>
                      <p>
                        <i><a href="<?php echo $r->link_propiedad ?>"><img src="images/plus-icon.png" alt="Read More" /></a></i>
                        <?php echo ($r->nombre); ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="double-border"></div>
  </div>
</div>

<!-- OUR REAL ESTATE -->
<div class="our-real-estate">
  <div class="page">
    <div class="title">sobre nuestra inmobiliaria</div>
    <?php
    $texto = $web_model->get_text("sobre_nosotros");
    echo html_entity_decode($texto->texto,ENT_QUOTES); ?>
    <div class="real-estates"> <a href="<?php echo mklink("propiedades/ventas/") ?>"> <i><img src="images/home-icon.png" alt="Sale" /></i> <big>venta</big> <small>Propiedades en Venta en <br>
    La Plata</small> </a> <a href="<?php echo mklink("propiedades/alquileres/") ?>"> <i><img src="images/key-icon.png" alt="Rental" /></i> <big>alquiler</big> <small>Alquiler de inmuebles <br>
    en La Plata</small> </a> <a href="<?php echo mklink("propiedades/emprendimientos/") ?>"> <i><img src="images/home-icon2.png" alt="Sale" /></i> <big>emprendimientos</big> <small>Emprendimientos <br>
    en La Plata</small> </a> </div>
  </div>
</div>

<?php include("includes/consulta_rapida.php"); ?>

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
  <?php if (!empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

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

    <?php
    $posiciones = explode("/",$empresa->posiciones);
    for($i=0;$i<sizeof($posiciones);$i++) { 
      $pos = explode(";",$posiciones[$i]); ?>
      L.marker([<?php echo $pos[0] ?>,<?php echo $pos[1] ?>],{
        icon: icono
      }).addTo(mymap);
    <?php } ?>

  <?php } ?>
</script>

</body>
</html>
