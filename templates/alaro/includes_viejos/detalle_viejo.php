<?php $header_cat = "";
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
$direccion = ($propiedad->calle.(($empresa->mostrar_numeros_direccion_listado)?" N&deg; ".$propiedad->altura:""));

$nombre_pagina = $propiedad->tipo_operacion_link;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <meta charset="utf-8">
  <?php include("head.php"); ?>
  <meta property="og:url" content="<?php echo current_url(); ?>" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="<?php echo $propiedad->nombre; ?>" />
  <meta property="og:description" content="<?php echo $direccion; ?>" />
  <meta property="og:image" content="<?php echo current_url(TRUE)."/admin/".((!empty($propiedad->path)) ? $propiedad->path : $empresa->no_imagen); ?>"/>
  <?php echo $propiedad->codigo_seguimiento; ?>
  <style type="text/css">
    .barra-izq { position: relative; right: -40px }
    .icono-finish { width: 20% }
    .product-detail-page .video iframe { width: 100% !important; height: 485px !important; }
    .primer, .segundo, .tercer, .cuarto, .quinto { padding: 0; margin: 0; }
    .segundo { position: relative;right: 20px }
    .tercer { position: relative;right: 40px }
    .cuarto { position: relative;right: 60px }
    .quinto { position: relative;right: 80px }
  </style>
</head>
<body class="loading" id="old-detail">
  <?php 
  $header_style = ($propiedad->id_tipo_operacion == 8) ? "" : "style2 style3";
  include("header.php"); ?>

  <?php if ($propiedad->id_tipo_operacion == 8) { ?>
    <div class="red-box-title">
      <div class="container">
        <ul>
          <li>Proyectos finalizados</li>
        </ul>
      </div>
    </div>
    <div class="gallery-page">
      <div class="gallery-title">
        <div class="container"><?php echo $propiedad->nombre ?></div>
      </div>
      <?php if (sizeof($propiedad->images)>0) { ?>

        <?php // Puede tener videos
        if (isset($propiedad->videos) && sizeof($propiedad->videos)>0) { ?>
          <?php foreach($propiedad->videos as $video) { ?>
            <div class="col-md-3">
              <div class="project-list"> 
                <img class="cover" src="<?php echo $video->path ?>" alt="Gallery">
                <div class="about-project">
                  <div class="small-list">
                    <div class="overlay-info">
                      <div class="center-content">
                        <div class="align-center"> <a class="fancybox" href="<?php echo $video->video ?>" data-fancybox-group="gallery"></a> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
        <?php foreach($propiedad->images as $img) { ?>
          <div class="col-md-3">
            <div class="project-list"> <img class="cover" src="<?php echo $img ?>" alt="Gallery">
              <div class="about-project">
                <div class="small-list">
                  <div class="overlay-info">
                    <div class="center-content">
                      <div class="align-center"> <a class="fancybox" href="<?php echo $img ?>" data-fancybox-group="gallery"></a> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php } else { ?>
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <div class="feature-item bn">
            <div class="project-list"> 
              <img src="/admin/<?php echo $propiedad->path ?>" alt="<?php echo $propiedad->nombre ?>" />
            </div>
            <div class="block text-center">
              <div class="proy-finalizado"> 
                <h2><?php echo $propiedad->nombre ?></h2>
                <p><?php echo $propiedad->calle ?> - <?php echo $propiedad->localidad ?></p>
              </div>
              <a class="btn btn-red mb60" href="javascript:history.back()">volver</a>
            </div>
          </div>
        </div>
        <div class="col-md-4"></div>
      <?php } ?>
    </div>

  <?php } else { ?>

    <!-- PRODUCT DETAIL BANNER -->
    <div class="banner-blog" <?php echo (!empty($propiedad->custom_6)) ? "style='background-image:url(/admin/$propiedad->custom_6)' ":"" ?>>
      <div class="banner-caption">
        <div class="center-content">
          <div class="align-center">
            <h2><?php echo $propiedad->nombre ?></h2>
            <h4><?php echo $direccion." - ".$propiedad->localidad ?></h4>
          </div>
        </div>
      </div>
    </div>
    <div class="product-detail-page">
      <!-- BUILT YOUR DREAM -->
      <div class="built-your-dream">
        <div class="container">
          <div class="center-text" style="padding-bottom: 45px;">
            <h2>Creciendo Juntos</h2>
            <?php if (!empty($propiedad->custom_1)) { ?>
              <p><?php echo $propiedad->custom_1 ?></p>
            <?php } ?>
          </div>
          <div class="row">
            <div class="col-md-5">
              <div class="white-box">
                <?php if (!empty($propiedad->custom_5)) { ?>
                  <div class="box-logo">
                    <img src="/admin/<?php echo $propiedad->custom_5 ?>" alt="Logo" />
                  </div>
                <?php } ?>
            <?php /* if (!empty($propiedad->custom_2)) { ?>
              <div class="border-box-info">
                <h6>Fecha de inicio</h6>
                <p><?php echo $propiedad->custom_2 ?></p>
              </div>
            <?php } */ ?>
            <?php $caracteristicas = explode(";;;",$propiedad->caracteristicas);
            if (sizeof($caracteristicas)>0 && !empty($caracteristicas[0])) { ?>
              <div class="border-box-info">
                <h6>Características del edificio</h6>
                <ul>
                  <?php $k=0; foreach($caracteristicas as $c) { ?>
                    <li>
                      <?php echo ($c); ?>
                      <?php echo ($k<sizeof($caracteristicas)-1) ? "&nbsp;|&nbsp;":"" ?>
                    </li>
                    <?php $k++; } ?>
                  </ul>
                </div>
              <?php } ?>
              <?php if (!empty($propiedad->custom_3)) { ?>
                <div class="border-box-info">
                  <h6>Tipo de departamentos</h6>
                  <p><?php echo $propiedad->custom_3 ?></p>
                </div>
              <?php } ?>
              <?php if (!empty($propiedad->custom_4)) { ?>
                <div class="border-box-info">
                  <h6>Tipo de financiamiento</h6>
                  <p><?php echo $propiedad->custom_4 ?></p>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="col-md-7">
            <div class="general-information">
              <?php if (!empty($propiedad->texto)) { ?>
                <h4>información general</h4>
                <?php echo $propiedad->texto; ?>
              <?php } ?>
              <div class="block" style="margin-bottom: 10px;">
                <?php if (!empty($propiedad->archivo)) { ?>
                  <div class="pull-left">
                    <a class="btn btn-red" target="_blank" href="/admin/<?php echo $propiedad->archivo ?>">descargar brochure</a>
                  </div>
                <?php } ?>
                <div class="pull-left">
                  <a onclick="ir_contacto()" class="btn btn-black" href="javascript:void(0)">consultar proyecto</a>
                </div>
              </div>
              <!-- <div class="block clearfix">
                <div class="pull-right">
                  <span>Compartir</span>
                  <span class='st_sharethis_large' displayText='ShareThis'></span>
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <div class="general-information">
        	<div class="text-center  mb30 mt30">
                <h4 style="font-size: 30px">AVANCE DE OBRA</h4>
        	</div>
        </div>
        <div class="row mt50 mb30 barra-izq">
        	
          <div class="col-md-2 icono-finish primer">
            <img src="images/inicio-activo.png">
          </div>
          <div class="col-md-2 icono-finish segundo">
            <?php if ($propiedad->custom_8 == "Tareas" || $propiedad->custom_8 == "Estructura" || $propiedad->custom_8 == "Albañilería" || $propiedad->custom_8 == "Terminaciones") { ?>
              <img src="images/tareas-activo.png">
            <?php } else {  ?>
              <img src="images/tareas-desactivo.png">
            <?php } ?>
          </div>
          <div class="col-md-2 icono-finish tercer">
            <?php if ($propiedad->custom_8 == "Estructura" || $propiedad->custom_8 == "Albañilería" || $propiedad->custom_8 == "Terminaciones") { ?>
              <img src="images/estruc-activo.png">
            <?php } else {  ?>
              <img src="images/estruc-desactivo.png">
            <?php } ?>
          </div>
          <div class="col-md-2 icono-finish cuarto">
            <?php if ($propiedad->custom_8 == "Albañilería" || $propiedad->custom_8 == "Terminaciones") { ?>
              <img src="images/alba-activo.png">
            <?php } else {  ?>
              <img src="images/alba-desactivo.png">
            <?php } ?>
          </div>
          <div class="col-md-2 icono-finish quinto">
            <?php if ($propiedad->custom_8 == "Terminaciones") { ?>
              <img src="images/termi-activo.png">
            <?php } else {  ?>
              <img src="images/termi-desactivo.png">
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <!--PHOTO-GALLERY-->
    <?php if (sizeof($propiedad->images)>0) { ?>
      <div class="photo-gallery">

        <div class="center-text">
          <h2>galería de fotos</h2>
        </div>

        <div class="images-grid images-grid-demo">
          <?php 
          $i=0;
          foreach($propiedad->images as $img) {
            $img = (strpos($img, "?") !== FALSE) ? substr($img, 0, strpos($img, "?")) : $img;
            list($width, $height, $type, $attr) = getimagesize("/home/ubuntu/inmovar".$img); ?>
            <div class="image-wrapper" data-width="<?php echo $width ?>" data-height="<?php echo $height ?>">
              <img data-i="<?php echo $i ?>" class="image-thumb" src="<?php echo $img ?>"/>
            </div>
            <?php $i++; } ?>
          </div>

          <div style="display: none">
            <?php 
            $i=0;
            foreach($propiedad->images as $img) { ?>
              <a id="fancybox_oculto_<?php echo $i ?>" class="fancybox2" href="<?php echo $img ?>" data-fancybox-group="gallery2">
                <img src="<?php echo $img ?>"/>
              </a>
              <?php $i++; } ?>
            </div>

          </div>
        <?php } ?>

        <div class="our-plans">
          <?php if (sizeof($propiedad->departamentos)>0) { 

            $departamentos = array();
            foreach($propiedad->departamentos as $depto) {
              if (!isset($departamentos[$depto->piso])) $departamentos[$depto->piso] = array();
              $departamentos[$depto->piso][] = $depto;
            }
            ?>
            <div class="center-text">
              <h2>planos y características</h2>
              <p>Conocé diferentes vistas y plantas</p>
            </div>
            <div class="screenshot-section">
              <div class="col-md-6">
                <div class="left-box">
                  <div class="border-title">Imágenes de Planos y Vistas</div>
                  <div class="scroll-box content mCustomScrollbar">
                    <div class="category">
                      <div class="accordion">
                        <?php $j=0; foreach($departamentos as $piso => $deptos) { ?>
                          <div class="accordion-item">
                            <div class="accordion-title">
                              <a class="<?php echo ($j==0)?"active":"" ?>" href="#accordion-item-<?php echo $j ?>"><?php echo ($piso) ?></a></div>
                              <div class="accordion-content <?php echo ($j==0)?"open":"" ?>" id="accordion-item-<?php echo $j ?>">
                                <ul>
                                  <?php foreach($deptos as $dp) { ?>
                                    <li><a onclick="mostrar_slider(<?php echo $dp->id ?>)" href="javascript:void(0)"><?php echo ($dp->nombre) ?></a></li>
                                  <?php } ?>
                                </ul>
                              </div>
                            </div>
                            <?php $j++; } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php foreach($propiedad->departamentos as $depto) { ?>
                    <div style="display: none;" id="departamentos_slider_<?php echo $depto->id ?>" class="flexslider departamentos_slider">
                      <ul class="slides">
                        <?php foreach($depto->images_dptos as $img) { ?>
                          <li>
                            <div class="col-md-6"> 
                              <img src="/admin/<?php echo $img ?>" alt="Plot Map" />
                              <?php if ($depto->disponible == 1) { ?>
                                <div class="sticker">DISPONIBLE</div>
                              <?php } else { ?>
                                <div class="sticker vendido">VENDIDO</div>
                              <?php } ?>
                            </div>
                          </li>
                        <?php } ?>
                      </ul>
                    </div>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>  

            <!--PHOTO-GALLERY-->
  <?php /*if (sizeof($propiedad->images)>0) { ?>
    <div class="photo-gallery">
      <div class="center-text">
        <h2>galería de fotos</h2>
      </div>
      <div class="gallery-blog">
        <section class="swiper-container fadeslides keyboard horizontal-slider center" data-autoplay="true">
          <div class="swiper-wrapper">
            <?php foreach($propiedad->images as $img) { ?>
              <div class="swiper-slide col-md-6" style="background:url(<?php echo $img ?>) no-repeat 50% 50%; background-size:cover;"> </div>
            <?php } ?>
          </div>
          <div class="container">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </section>
      </div>
    </div>
  <?php }*/ ?>

  <?php 
  $propiedad->video = trim($propiedad->video);
  if (!empty($propiedad->video)) { ?>
    <div class="video-section">
      <div class="center-text">
        <h2>Video</h2>
      </div>
      <div class="video">
        <?php echo $propiedad->video ?>
      </div>
    </div>
  <?php } ?>

  <div class="our-plans <?php echo (empty($propiedad->video) ? "pt0" : "") ?>">
    <!--PROJECT LOCATION-->
    <div class="project-location row" style="clear: both;">
      <div class="col-md-4">
        <div id="map_canvas"></div>
      </div>
      <div id="texto_ubicacion" class="col-md-4">
        <div class="location-info">
          <div class="center-content">
            <div class="align-center">
              <h4>ubicación  de proyecto</h4>
              <p><?php echo nl2br(($propiedad->descripcion_ubicacion)) ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <?php if (sizeof($propiedad->planos)>0) { ?>
          <div id="flex_barrio">
            <ul class="slides">
              <?php foreach($propiedad->planos as $img) { ?>
                <li><img src="<?php echo $img ?>" alt="Location" /></li>
              <?php } ?>
            </ul>
          </div>
        <?php } ?>
      </div>
    </div>
    <!--CONSULT SECTION-->
    <div id="form_contacto" class="consult-section">
      <div class="container">
        <h3>CONSULTAR</h3>
        <form onsubmit="return enviar_contacto()">
          <div class="row">
            <div class="col-md-4">
              <input id="contacto_nombre" class="form-control-2" type="text" placeholder="NOMBRE Y APELLIDO *" />
            </div>
            <div class="col-md-4">
              <input id="contacto_email" class="form-control-2" type="email" placeholder="EMAIL *" />
            </div>
            <div class="col-md-4">
              <input id="contacto_telefono" class="form-control-2" type="tel" placeholder="TEL&Eacute;FONO *" />
            </div>
            <div class="col-md-12">
              <textarea style="height: 80px;" id="contacto_mensaje" class="form-control-2" placeholder="CONSULTA *"></textarea>
            </div>
            <div class="col-md-12 text-center">
              <input class="btn btn-black" style="padding-left: 40px; padding-right: 40px;" id="contacto_submit" type="submit" value="ENVIAR" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php } ?>

<?php include("footer.php"); ?>
<script src="js/customscroll.js" type="text/javascript"></script> 
<script type="text/javascript" src="js/fancybox.js"></script> 
<script type="text/javascript" src="js/jquery.imagesGrid.js"></script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script>
  $(document).ready(function(){

  // https://www.jqueryscript.net/gallery/Responsive-Justified-Image-Grid-Plugin.html
  var alto = ($(window).width() > 900) ? 350 : 250;
  $(".images-grid-demo").imagesGrid({
    rowHeight: alto
  });

  // Tenemos oculto el fancybox porque no funciona con la libreria imagesGrid
  $('.fancybox2').fancybox();
  $('.image-thumb').click(function(e){
    var i = $(e.currentTarget).data("i");
    $("#fancybox_oculto_"+i).trigger("click");
  });

  <?php if ($propiedad->id_tipo_operacion == 8) { ?>
    $('.fancybox').fancybox();
  <?php } else { ?>
    mostrar_mapa(); 
  <?php } ?>
  $(".accordion-content a").first().trigger("click");

});

  $(window).load(function(){
    var maximo = 0;
    $(".gallery-page .col-md-3 img").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    if (maximo > 300) maximo = 380;
    maximo = Math.ceil(maximo);
    $(".gallery-page .col-md-3 img").height(maximo);
  });

//FLEXSLIDER SCRIPT
(function($){
  $(window).load(function(){
    $('#flex_barrio').flexslider({
      animation: "slide",
      animationLoop: true,
      start: function(slider){
        $('body').removeClass('loading');
        var m = $("#flex_barrio").outerHeight();
        $(".project-location #map_canvas").height(m);
        $("#texto_ubicacion").height(m);
      }
    });
  });
})(jQuery);

function mostrar_slider(id) {
  $(".departamentos_slider").hide();
  $("#departamentos_slider_"+id).show();
}

  //lvsy swiper slider script
  var swipermw = $('.swiper-container.mousewheel').length ? true : false;
  var swiperkb = $('.swiper-container.keyboard').length ? true : false;
  var swipercentered = $('.swiper-container.center').length ? true : false;
  var swiperautoplay = $('.swiper-container').data('autoplay');
  var swiperinterval = $('.swiper-container').data('interval'),
  swiperinterval = swiperinterval ? swiperinterval : 7000;
  swiperautoplay = swiperautoplay ? swiperinterval : false;
  
  var swipermw = $('.swiper-container.mousewheel').length ? true : false;
  var swiperkb = $('.swiper-container.keyboard').length ? true : false;
  var swipercentered = $('.swiper-container.center').length ? true : false;
  var swiperautoplay = $('.swiper-container').data('autoplay');
  var swiperinterval = $('.swiper-container').data('interval'),
  swiperinterval = swiperinterval ? swiperinterval : 7000;
  swiperautoplay = swiperautoplay ? swiperinterval : false;

  var swiperHorizontal = $('.horizontal-slider').swiper({
    autoplayDisableOnInteraction: false,
    effect: 'slide',
    loop: true,
    watchSlidesProgress: true,
    autoplay: 5000,
    simulateTouch: false,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    mousewheelControl: swipermw,
    keyboardControl: swiperkb,
    slidesPerView: 'auto',
    loopedSlides: 5,
    noSwipingClass: 'noswipe',
    centeredSlides: swipercentered,
  }); 

  function mostrar_mapa() {
    <?php if (!empty($propiedad->latitud && !empty($propiedad->longitud))) { ?>

     $(document).ready(function(){
      var mymap = L.map('map_canvas').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], 16);
      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
        tileSize: 512,
        maxZoom: 18,
        zoomOffset: -1,
        id: 'mapbox/streets-v11',
        accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
      }).addTo(mymap);
      L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>]).addTo(mymap);
    });

   <?php } ?>
 }


//sewl vertical scroll script
if (screen.width <= 767) {
  $(window).load(function(){
    $('.scroll-box').mCustomScrollbar({
      axis: 'y',
      scrollInertia: 200,
      autoHideScrollbar: true,
      autoDraggerLength: true,
      advanced: {
        updateOnContentResize: true
      }
    });    });
}
</script>
<script type="text/javascript">
  function enviar_contacto() {
    
    var nombre = $("#contacto_nombre").val();
    var email = $("#contacto_email").val();
    var telefono = $("#contacto_telefono").val();
    var mensaje = $("#contacto_mensaje").val();
    var asunto = "<?php echo html_entity_decode($propiedad->nombre,ENT_QUOTES) ?>";
    var id_origen = 1;
    var id_propiedad = "<?php echo $propiedad->id ?>";
    
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
    if (isEmpty(telefono) || telefono == "Telefono") {
      alert("Por favor ingrese un telefono");
      $("#contacto_telefono").focus();
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
      "telefono":telefono,
      "asunto":asunto,
      "id_empresa":ID_EMPRESA,
      "id_propiedad":id_propiedad,
      "id_origen": ((id_origen != 0) ? id_origen : ((id_propiedad != 0)?1:6)),
    }
    $.ajax({
      "url":"/admin/consultas/function/enviar/",
      "type":"post",
      "dataType":"json",
      "data":datos,
      "success":function(r){
        if (r.error == 0) {
          window.location.href = "<?php echo mklink ("web/gracias/") ?>";
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");
          $("#contacto_submit").removeAttr('disabled');
        }
      }
    });
    return false;
  }  

  function ir_contacto() {
    $('html,body').animate({
      scrollTop: $("#form_contacto").offset().top},
      'slow');  
  }
</script>
<!--
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "7a43d77b-8229-4660-ac51-4e8b0acdb57d", doNotHash: true, doNotCopy: true, hashAddressBar: false});</script>
-->
</body>
</html>
