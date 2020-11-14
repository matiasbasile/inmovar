<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "includes/init.php";
$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id,array(
  "buscar_relacionados_offset"=>2,
  "id_empresa"=>$id_empresa,
  "id_empresa_original"=>$empresa->id,
));
if ($propiedad->id_tipo_operacion == 1) { $link_tipo_operacion = "ventas"; }
elseif ($propiedad->id_tipo_operacion == 2){ $link_tipo_operacion = "alquileres" ;} 
elseif ($propiedad->id_tipo_operacion == 4){ $link_tipo_operacion = "emprendimientos" ;} 

$cotizacion_dolar = $propiedad_model->get_dolar();

$id_tipo_inmueble = $propiedad->id_tipo_inmueble ;
$link_localidad = $propiedad->localidad_link ;
$tipos_propiedades  = $propiedad_model->get_tipos_propiedades();
$localidades = $propiedad_model->get_localidades();
$dormitorios = $propiedad->dormitorios;
$banios = $propiedad->banios;

$dolar = $web_model->get_cotizacion_dolar();

$precio_maximo = $propiedad_model->get_precio_maximo(array(
  "id_tipo_operacion"=>$propiedad->id_tipo_operacion,
));

// Minimo
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;

// Maximo
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo;

$imagen_ppal = "";
if (!empty($propiedad->path)) $imagen_ppal = current_url(TRUE)."/admin/".$propiedad->path;
else if (!empty($empresa->no_imagen)) $imagen_ppal = current_url(TRUE)."/admin/".$empresa->no_imagen;
else $imagen_ppal = current_url(TRUE)."/templates/".$empresa->template_path."/images/no-imagen-png"; 

array_unshift($propiedad->images, $imagen_ppal);

// Tomamos los datos de SEO
$seo_title = (!empty($propiedad->seo_title)) ? $propiedad->seo_title : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? $propiedad->seo_description : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? $propiedad->seo_keywords : $empresa->seo_keywords;

$cookie_id_cliente = (isset($_COOKIE['idc'])) ? $_COOKIE['idc'] : 0;

if (!isset($_COOKIE[$propiedad->id])) {
  // Sumamos la visita a la propiedad
  $propiedad_model->add_visit($propiedad->id,$cookie_id_cliente);
  setcookie($propiedad->id,"1",time()+60*60*24*30,"/");
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include "includes/head.php" ?>
<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo str_replace("&amp;quot;",'&quot;',htmlentities($propiedad->nombre,ENT_QUOTES)); ?>" />
<meta property="og:description" content="<?php echo $propiedad->direccion_completa ?>" />
<?php if (!empty($imagen_ppal)) { ?>
  <meta property="og:image" content="<?php echo $imagen_ppal ?>"/>
  <meta property="og:image:width" content="800"/>
  <meta property="og:image:height" content="600"/>
<?php } ?>
</head>
<body class="propiedad_detalle">
<?php include "includes/header.php" ?>

<div class="page-title">
  <div class="container">
    <div class="pull-left">
      <h2><?php echo $propiedad->tipo_operacion ?></h2>
    </div>
    <div class="breadcrumb">
      <ul>
        <li><a href="<?php echo mklink ("/") ?>">Inicio</a><span>|</span></li>
        <li><?php echo $propiedad->tipo_operacion ?></li>
      </ul>
    </div>
  </div>
</div>

<!-- Properties Listing Block -->
<div class="properties-listing-block">
  <div class="container">
    <div class="row">

      <?php include "includes/sidebar.php" ?>
      
      <div class="col-md-9 col-md-pull-3">
        <div class="property-full-info">

          <?php if (!empty($propiedad->pint)) { ?>
            <iframe width="100%" height="500" class="mb40" src="<?php echo $propiedad->pint ?>"></iframe>
          <?php } else { ?>
            <div class="center-gallery">
              <?php if (sizeof($propiedad->images) > 1) {  ?>
                <div id="slider" class="flexslider">
                  <ul class="slides <?php echo (sizeof($propiedad->images) < 2) ? "mb30" : "" ?>">
                    <?php foreach ($propiedad->images as $p) {  ?>
                      <li>
                        <a href="<?php echo $p ?>" class="fancybox" data-fancybox-group="gallery" title="<?php echo $propiedad->nombre ?>">
                          <img src="<?php echo $p ?>" />
                        </a>
                      </li>
                    <?php } ?>
                  </ul>
                </div>
                <div id="carousel" class="flexslider mb30">
                  <ul class="slides">
                    <?php foreach ($propiedad->images as $p) {  ?>
                      <li>
                        <img src="<?php echo $p ?>" />
                      </li>
                    <?php } ?>
                  </ul>
                </div>
              <?php } else { ?>
                <div class="mb30">
                  <?php if (!empty($propiedad->path)) { ?>
                    <img  style="width: 100%" src="/admin/<?php echo $propiedad->path ?>" alt="<?php echo ($propiedad->nombre);?>">
                  <?php } else if (!empty($empresa->no_imagen)) { ?>
                    <img style="width: 100%"  src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($propiedad->nombre);?>">
                  <?php } else { ?>
                    <img  style="width: 100%" src="images/no-imagen.png" alt="<?php echo ($propiedad->nombre);?>">
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
          
          <div class="property-name"><?php echo (!empty($propiedad->nombre))?$propiedad->nombre : "" ?></div>
          <div class="property-price">
            <big>
              <span><?php echo $propiedad->precio ?></span>
            </big>
          </div>

          <div class="border-box">
            <div class="box-space property-main-title">
              <div class="property-location">
                <div class="pull-left"><?php echo ((!empty($propiedad->localidad))?$propiedad->localidad.", ":"").$propiedad->direccion_completa ?></div>
                <div class="pull-right">
                  <small>Cod: <span><?php echo $propiedad->codigo ?></span></small>
                  <div class="wishlist">
                    <?php if ($propiedad->apto_banco == 1) {  ?>
                      <a href="javascript:void(0);"><img src="images/icon.png">
                        <div class="tooltip-info">
                          Apta Crédito Bancario
                        </div>
                      </a>
                    <?php } ?>
                    <?php if (estaEnFavoritos($propiedad->id)) { ?>
                      <a class="active" href="/admin/favoritos/eliminar/?id=<?php echo $propiedad->id; ?>">
                        <img src="images/wish-list.png">
                        <div class="tooltip-info">
                          Borrar de Favoritos
                        </div>
                      </a>
                    <?php } else { ?>
                      <a href="/admin/favoritos/agregar/?id=<?php echo $propiedad->id; ?>">
                        <img src="images/wish-list.png">
                        <div class="tooltip-info">
                          Guarda Tus Inmuebles Favoritos
                        </div>
                      </a>
                    <?php } ?>

                  </div>
                </div>
              </div>
            </div>
            <div class="faclities-block">
              <ul>
                <?php if (!empty($propiedad->dormitorios)) { ?><li><img src="images/hab.png"><?php echo $propiedad->dormitorios ?> Hab.</li><?php } ?>
                <?php if (!empty($propiedad->banios)) { ?><li><img src="images/bathrooms.png"><?php echo $propiedad->banios ?> Baño/s</li><?php } ?>
                <?php if (!empty($propiedad->cocheras)) { ?><li><img src="images/garage.png"><?php echo $propiedad->cocheras ?> Cochera/s</li><?php } ?>
                <?php if (!empty($propiedad->superficie_total)) { ?> 
                  <li>
                    <img src="images/grid.png">
                    <?php if (!empty($propiedad->superficie_cubierta)) { ?> 
                      Cubiertos: <?php echo $propiedad->superficie_cubierta ?> m2
                      <?php if (!empty($propiedad->superficie_descubierta)) { ?>
                        | Descubiertos: <?php echo $propiedad->superficie_descubierta ?> m2
                      <?php } ?>
                      <?php if (!empty($propiedad->superficie_semicubierta)) { ?>
                        | Semicubiertos: <?php echo $propiedad->superficie_semicubierta ?> m2
                      <?php } ?>
                    <?php } else { ?>
                      <?php echo $propiedad->superficie_total ?> m2
                    <?php } ?>
                  </li>
                <?php } ?>
              </ul>
            </div>
            <div class="box-space description">
              <?php echo (!empty($propiedad->texto)) ? $propiedad->texto : "" ?>
            </div>
            <?php if (!empty($propiedad->caracteristicas)) {  ?>
            <div class="info-title">Características Generales</div>
            <div class="box-space">
              <div class="available-facilities">
                <ul>
                  <?php $array = explode(";;;",utf8_decode(html_entity_decode($propiedad->caracteristicas,ENT_QUOTES))); ?>
                  <?php foreach ($array as $a) { ?>
                    <li><?php echo $a ?></li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <?php } ?>

            <?php if (!empty($propiedad->pint)) { ?>
              <div class="info-title">Galeria de Imagenes</div>
              <div class="box-space">
                <div class="center-gallery">
                  <?php if (sizeof($propiedad->images) > 1) {  ?>
                    <div id="slider" class="flexslider">
                      <ul class="slides <?php echo (sizeof($propiedad->images) < 2) ? "mb30" : "" ?>">
                        <?php foreach ($propiedad->images as $p) {  ?>
                          <li>
                            <a href="<?php echo $p ?>" class="fancybox" data-fancybox-group="gallery" title="<?php echo $propiedad->nombre ?>">
                              <img src="<?php echo $p ?>" />
                            </a>
                          </li>
                        <?php } ?>
                      </ul>
                    </div>
                    <div id="carousel" class="flexslider mb30">
                      <ul class="slides">
                        <?php foreach ($propiedad->images as $p) {  ?>
                          <li>
                            <img src="<?php echo $p ?>" />
                          </li>
                        <?php } ?>
                      </ul>
                    </div>
                  <?php } else { ?>
                    <div class="mb30">
                      <?php if (!empty($propiedad->path)) { ?>
                        <img  style="width: 100%" src="/admin/<?php echo $propiedad->path ?>" alt="<?php echo ($propiedad->nombre);?>">
                      <?php } else if (!empty($empresa->no_imagen)) { ?>
                        <img style="width: 100%"  src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($propiedad->nombre);?>">
                      <?php } else { ?>
                        <img  style="width: 100%" src="images/no-imagen.png" alt="<?php echo ($propiedad->nombre);?>">
                      <?php } ?>
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>

            <?php if (!empty($propiedad->localidad)) {  ?>
              <div class="info-title">Ubicación en mapa</div>
              <?php if (($propiedad->latitud != 0) && ($propiedad->longitud != 0)) { ?>
                <div class="box-space">
                  <div id="map" style="width:100%;height:350px;filter: grayscale(100%);-webkit-filter: grayscale(100%);"></div>
                  <?php if (!empty($propiedad->heading)) { ?>
                    <div style="display: none" id="street"></div>
                  <?php } ?>
                  <div class="map-buttons">
                    <a href="javascript:void(0)" class="active" data-action="map">MAPA</a>
                    <a href="javascript:void(0)" class="<?php echo (empty($propiedad->heading) ? "inactive":"") ?>" data-action="street">STREET VIEW</a>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
            <div class="info-title">formulario de consulta</div>
            <div class="box-space">
              <div class="form">
                <form onsubmit="return enviar_contacto()">
                 <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" id="contacto_propiedad" value="<?php echo $propiedad->id ?>" >
                    <input class="form-control" id="contacto_nombre" type="text" placeholder="Nombre *" />
                  </div>
                  <div class="col-md-6">
                    <input class="form-control" id="contacto_telefono" type="tel" placeholder="Teléfono *" />
                  </div>
                  <div class="col-md-12">
                    <input class="form-control"  id="contacto_email" type="email" placeholder="Email *" />
                  </div>
                  <div class="col-md-12">
                    <textarea class="form-control" id="contacto_mensaje" placeholder="Consulta *"></textarea>
                  </div>
                  <div class="col-md-12">
                    <button type="submit" id="contacto_submit" class="btn btn-red">consultar</button>
                  </div>
                 </div>
                </form>
              </div>
            </div>
            <div class="info-title">ficha de propiedad</div>
            <div class="box-space">
              <div class="helpful-links">
                <div class="pull-left"> 
                  <a target="_blank" href="<?php echo $propiedad->link_ficha ?>"><img src="images/pdf-icon.png" alt="Download PDF" /> descargar  ficha pdf</a>
                </div>
                <div class="pull-right pt10" style="font-size: 22px">
                    <div class="td-default-sharing">
                      <a class="td-social-sharing-buttons td-social-facebook" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()) ?>" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;"><i class="td-icon-facebook fab fa-facebook-f"></i></a>
                      <a class="td-social-sharing-buttons td-social-twitter" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(html_entity_decode($propiedad->nombre,ENT_QUOTES)) ?>&amp;url=<?php echo urlencode(current_url()) ?>"><i class="td-icon-twitter fab fa-twitter"></i></a>
                      <a class="td-social-sharing-buttons td-social-email" href="mailto:?subject=<?php echo html_entity_decode($propiedad->nombre,ENT_QUOTES) ?>&body=<?php echo(current_url()) ?>"><i class="td-icon-email fa fa-envelope"></i></a>
                      <a class="td-social-sharing-buttons td-social-telegram" target="_blank" href="https://telegram.me/share/url?url=<?php echo urlencode(current_url()) ?>"><i class="td-icon-telegram fa fa-paper-plane"></i></a>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <?php if (sizeof($propiedad->relacionados) > 1) {  ?>
            <div class="border-title">propiedades similares</div>
            <div class="listings">
              <div class="row">
                
                  <?php foreach ($propiedad->relacionados as $p) { ?>
                    <div class="col-md-6">
                      <div class="property-list">
                        <div class="image-block">
                          <img src="/admin/<?php echo $p->path ?>">
                          <div class="overlay">
                            <div class="table-container">
                              <div class="align-container">
                                <div class="user-action">
                                  <a href="<?php echo $p->link_propiedad ?>"><i class="fas fa-plus"></i></a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php if (!empty($p->tipo_operacion)) {  ?>
                            <div class="on-sale">
                              <?php if (strtolower($p->tipo_operacion) == "ventas") echo "venta";
                              else if (strtolower($p->tipo_operacion) == "alquileres") echo "alquiler";
                              else echo $p->tipo_operacion; ?>
                            </div>
                          <?php } ?>
                        </div>
                        <div class="property-description">
                          <a href="<?php echo $p->link_propiedad ?>"><h5><?php echo $p->nombre ?></h5></a>
                          <div class="block">
                            <div class="pull-left">
                              <span><?php echo (!empty($p->localidad)) ? $p->localidad.", ".$p->direccion_completa : "" ?></span>
                            </div>
                            <div class="pull-right">
                              <span>Cod:</span>
                              <small><?php echo $p->codigo ?></small>
                            </div>
                          </div>
                          <div class="faclities-block height-rel-fac">
                            <ul>
                              <div class="block">
                                <li><img src="images/hab.png"><?php echo (empty($p->dormitorios)) ? "-" : $p->dormitorios ?> Hab</li>
                                <li><img src="images/bathrooms.png" title="Baño"><?php echo (empty($p->banios)) ? "-" : $p->banios ?> Bañ.</li>
                                 <li><img src="images/garage.png" title="Cochera/s"><?php echo (empty($p->cocheras)) ? "-" : $p->cocheras ?> Coch.</li>
                                 <?php if (!empty($p->superficie_total)) { ?> <li><img src="images/grid.png"><?php echo $p->superficie_total ?> m2</li><?php } ?>
                              </div>
                            </ul>
                          </div>
                          <div class="height-rel">
                            <?php 
                            $p->texto = strip_tags($p->texto);
                            echo substr($p->texto,0,75); echo (strlen($p->texto) > 75) ? "..." : "" ?>
                          </div>
                          <div class="price-block">
                            <div class="pull-left">
                              <span><?php echo $p->precio ?></span>
                            </div>
                            <div class="pull-right">
                              <div class="wishlist">
                                <?php if ($p->apto_banco == 1) {  ?>
                                  <a href="javascript:void(0);"><img src="images/icon.png">
                                    <div class="tooltip-info">
                                      Apta Crédito Bancario
                                    </div>
                                  </a>
                                <?php } ?>
                                <a href="javascript:void(0)"><img src="images/wish-list.png">
                                  <div class="tooltip-info">
                                    Guarda Tus Inmuebles Favoritos
                                  </div>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php  } ?>
              </div>
            </div>
          <?php } ?>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Footer -->
<?php include "includes/footer.php" ?>
<script type="text/javascript" src="js/fancybox.js"></script> 

<script type="text/javascript"> 

//FANCYBOX SCRIPT
$(function() {
 $(".fancybox").fancybox({
  transitionIn : 'fade',
  transitionOut: 'fade',
  openEffect   : 'fade',
  closeEffect  : 'fade',
  nextEffect   : 'fade',
  prevEffect   : 'fade',
  scrolling: "yes",
  helpers      : {
    overlay      :  {
        locked       : true,
        closeClick   : true,
    },
  }
  });
});

var enviando = 0;
function enviar_contacto() {
  if (enviando == 1) return;
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var mensaje = $("#contacto_mensaje").val();
  var telefono = $("#contacto_telefono").val();
  var id_propiedad = $("#contacto_propiedad").val();
  var id_origen = <?php echo (isset($id_origen) ? $id_origen : 0) ?>;
  
  if (isEmpty(nombre) || nombre == "Nombre") {
    alert("Por favor ingrese un nombre");
    $("#contacto_nombre").focus();
    return false;          
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_email").focus();
    return false;          
  }
  if (isEmpty(mensaje) || mensaje == "Mensaje") {
    alert("Por favor ingrese un mensaje");
    $("#contacto_mensaje").focus();
    return false;              
  }    
  
  $("#contacto_submit").attr('disabled', 'disabled');
  var datos = {
    "para":"<?php echo $empresa->email ?>",
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "asunto":"<?php echo $propiedad->nombre ?>",
    "telefono":telefono,
    "id_propiedad":id_propiedad,
    "id_empresa":ID_EMPRESA,
    <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?>
      "id_empresa_relacion":"<?php echo $propiedad->id_empresa ?>",
    <?php } ?>
    "id_origen": ((id_origen != 0) ? id_origen : ((id_propiedad != 0)?1:6)),
  }
  enviando = 1;
  $.ajax({
    "url":"/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
        location.reload();
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
        enviando = 0;
      }
    }
  });
  return false;
}
</script>
<script type="text/javascript">
  $(document).ready(function(){
  var maximo = 0;
  $(".height-rel-fac").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".height-rel-fac").height(maximo);
});
</script>
<script type="text/javascript">
  $(document).ready(function(){
  var maximo = 0;
  $(".height-rel").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".height-rel").height(maximo);
});

<?php if (isset($propiedad->latitud) && isset($propiedad->longitud) && $propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
//MAP SCRIPT
$(document).ready(function(){

  $(".map-buttons a").click(function(e){
    var action = $(e.currentTarget).data("action");
    $(".map-buttons a").removeClass("active");
    if (action == "map") {
      $("#street").hide();
      $("#map").show();
    } else {
      cargar_street();
      $("#map").hide();
      $("#street").show();
    }
    $(e.currentTarget).addClass('active');
    $(window).trigger('resize');
  });

  var mymap = L.map('map').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);

  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
      '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
      'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox.streets'
  }).addTo(mymap);

  var icono = L.icon({
    iconUrl: 'images/map-marker.png',
    iconSize:     [44, 50], // size of the icon
    iconAnchor:   [22, 50], // point of the icon which will correspond to marker's location
  });

  L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>],{
    icon: icono
  }).addTo(mymap);

});

function cargar_street() {
  <?php if(!empty($propiedad->heading) && !empty($propiedad->pitch)) { ?>
    var b=new google.maps.LatLng(<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>);
    var map = new google.maps.Map(document.getElementById('street'), {
      center: b,
      zoom: 14
    });
    var panorama = new google.maps.StreetViewPanorama(
    document.getElementById('street'), {
      position: b,
      pov: {
        heading: <?php echo $propiedad->heading ?>,
        pitch: <?php echo $propiedad->pitch ?>
      }
    });
    map.setStreetView(panorama);
    $(window).resize(function(){
      google.maps.event.trigger(map,"resize");
    });
  <?php } ?>
}
<?php } ?>
</script>
<script type="text/javascript">
  $(window).load(function() {
    // The slider being synced must be initialized first
    $('#carousel').flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      itemWidth: 160,
      itemMargin: 5,
      asNavFor: '#slider'
    });
   
    $('#slider').flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      sync: "#carousel"
    });
    
    /*
    $('.slider-snap').noUiSlider({
      start: [ <?php echo $minimo ?>, <?php echo $maximo ?> ],
      step: 10,
      connect: true,
      range: {
        'min': 0,
        'max': <?php echo $precio_maximo ?>,
      }
    });
    $('.slider-snap').Link('lower').to($('.slider-snap-value-lower'));
    $('.slider-snap').Link('upper').to($('.slider-snap-value-upper'));
    */
  });
</script>
<script type="text/javascript">
 function enviar_buscador_propiedades() { 
  var link = "<?php echo mklink("propiedades/")?>";
  var tipo_operacion = $("#tipo_operacion").val();
  var localidad = $("#localidad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>
</body>
</html> 