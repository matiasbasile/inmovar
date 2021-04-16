<?php 
include("includes/init.php");
$get_params["offset"] = 10;
$vc_listado = $propiedad_model->favoritos();
$vc_page_active = "Favoritos";
?><!DOCTYPE html>
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
      <div class="breadcrumb"><a href="<?php echo mklink("/") ?>"><img src="images/home-icon3.png" alt="Home" /> Home</a>
      <span>Favoritos</span></div>
      <big>Favoritos</big>
    </div>
  </div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
  <div class="page">
    <div class="row">
      <div class="registered-user">
        <div class="col-md-9 primary">
          <div class="border-box">
            <div class="info-title">favoritos</div>
            <div class="box-space">
              <div class="grid-view">
                <div class="row">
                  <?php if (empty($vc_listado)) { ?>
                    A&uacute;n no tienes propiedades agregadas a favoritos.
                  <?php } else { ?>
                    <?php foreach($vc_listado as $r) { ?>
                      <div class="col-md-4">
                        <div class="property-item <?php echo ($r->id_tipo_estado==1)?"sold":"" ?>">
                          <div class="item-picture">
                            <div class="block">
                              <?php if (!empty($r->imagen)) { ?>
                                <img src="<?php echo $r->imagen ?>" alt="<?php echo $r->nombre; ?>" />
                              <?php } else if (!empty($empresa->no_imagen)) { ?>
                                <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo $r->nombre; ?>" />
                              <?php } else { ?>
                                <img src="images/logo.png" alt="<?php echo $r->nombre; ?>" />
                              <?php } ?>
                            </div>
                            <div class="view-more"><a href="<?php echo $r->link_propiedad ?>"></a></div>
                            <div class="property-status">
                              <?php if ($r->id_tipo_estado != 1) { ?>
                                <span class="sold"><?php echo ($r->tipo_estado) ?></span>
                              <?php } else { ?>
                                <span><?php echo ($r->tipo_operacion) ?></span>
                              <?php } ?>
                            </div>
                          </div>
                          <div class="property-detail">
                            <div class="property-name"><?php echo $r->direccion_completa ?></div>
                            <div class="property-location">
                              <div class="pull-left"><?php echo ($r->localidad); ?></div>
                              <?php if (!empty($r->codigo)) { ?>
                                <div class="pull-right">Cod: <span><?php echo ($r->codigo); ?></span></div>
                              <?php } ?>
                            </div>                          
                            <div class="property-facilities">
                              <?php if (!empty($r->dormitorios)) { ?>
                                <div class="facilitie"><img src="images/room-icon.png" alt="Room" /> <?php echo $r->dormitorios ?> Hab</div>
                              <?php } ?>
                              <?php if (!empty($r->banios)) { ?>
                                <div class="facilitie"><img src="images/bathroom-icon.png" alt="Bathroom" /> <?php echo $r->banios ?> Ba&ntilde;os</div>
                              <?php } ?>
                              <?php if (!empty($r->cocheras)) { ?>
                                <div class="facilitie"><img src="images/garage-icon.png" alt="Garage" /> Cochera</div>
                              <?php } ?>
                              <?php if (!empty($r->superficie_total)) { ?>
                                <div class="facilitie"><img src="images/grid-icon.png" alt="Grid" /> <?php echo $r->superficie_total ?></div>
                              <?php } ?>
                            </div>
                            <p><?php echo (strlen($r->descripcion)>50) ? (substr($r->descripcion,0,50))."..." : ($r->descripcion) ?></p>
                            <div class="property-price">
                              <big><?php echo $r->precio ?></big>
                              <?php if (estaEnFavoritos($r->id)) { ?>
                                <a href="/admin/favoritos/eliminar/?id=<?php echo $r->id; ?>" class="favorites-properties active"><span class="tooltip">Borrar de Favoritos</span></a>
                              <?php } else { ?>
                                <a href="/admin/favoritos/agregar/?id=<?php echo $r->id; ?>" class="favorites-properties"><span class="tooltip">Guarda Tus Inmuebles Favoritos</span></a>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 secondary">
          <?php include("includes/sidebar.php"); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/consulta_rapida.php"); ?>

<?php include("includes/footer.php"); ?>

<!-- SCRIPT'S --> 
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/map.js"></script>
<script type="text/javascript" src="js/wNumb.js"></script> 
<script type="text/javascript" src="js/custom.js"></script> 
<script type="text/javascript">
//MAP SCRIPT
$(document).ready(function(){var b=new google.maps.LatLng(<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>);var c={center:b,zoom:15,mapTypeId:google.maps.MapTypeId.ROADMAP,styles:[{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]},{featureType:"water",elementType:"labels",stylers:[{visibility:"on"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}]};var d=new google.maps.Map(document.getElementById("map"),c);var a=new google.maps.Marker({position:b,map:d,icon:"images/map-place.png"});$(window).resize(function(){var e=d.getCenter();google.maps.event.trigger(d,"resize");d.setCenter(e)})});  
</script>
<script type="text/javascript">
$(document).ready(function(){
  $(".pagination a").click(function(e){
    e.preventDefault();
    var url = $(e.currentTarget).attr("href");
    
    var f = document.createElement("form");
    f.setAttribute('method',"post");
    f.setAttribute('action',url);
    
    var i = document.createElement("input");
    i.setAttribute('type',"hidden");
    i.setAttribute('name',"id_tipo_inmueble");
    i.setAttribute('value',$(".filter_tipo_propiedad").first().val());
    f.appendChild(i);
    
    var i = document.createElement("input");
    i.setAttribute('type',"hidden");
    i.setAttribute('name',"banios");
    i.setAttribute('value',$(".filter_banios").first().val());
    f.appendChild(i);  
    
    var i = document.createElement("input");
    i.setAttribute('type',"hidden");
    i.setAttribute('name',"dormitorios");
    i.setAttribute('value',$(".filter_dormitorios").first().val());
    f.appendChild(i);
    
    f.submit();    
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

//UI SLIDER SCRIPT
$('.slider-snap').noUiSlider({
	start: [ <?php echo $minimo ?>, <?php echo $maximo ?> ],
	step: 10,
	connect: true,
	range: {
		'min': 0,
		'max': <?php echo $precio_maximo ?>,
	},
	format: wNumb({
		decimals: 0,
		thousand: '.',
	})    
});
$('.slider-snap').Link('lower').to($('.slider-snap-value-lower'));
$('.slider-snap').Link('upper').to($('.slider-snap-value-upper'));
</script>
</body>
</html>
