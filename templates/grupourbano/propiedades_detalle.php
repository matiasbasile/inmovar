<?php
$nombre_pagina = "detalle";
include_once("includes/init.php");
include_once("includes/funciones.php");
$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id,array(
  "id_empresa"=>$id_empresa,
  "id_empresa_original"=>$empresa->id,
));

// Tomamos los datos de SEO
$seo_title = (!empty($propiedad->seo_title)) ? ($propiedad->seo_title) : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? ($propiedad->seo_description) : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? ($propiedad->seo_keywords) : $empresa->seo_keywords;

$nombre_pagina = $propiedad->tipo_operacion_link;
$breadcrumb = array(
  array("titulo"=>$propiedad->tipo_operacion,"link"=>"propiedades/".$propiedad->tipo_operacion_link."/"),
  array("titulo"=>$propiedad->localidad,"link"=>"propiedades/".$propiedad->tipo_operacion_link."/".$propiedad->localidad_link."/"),
  array("titulo"=>$propiedad->nombre,"link"=>$propiedad->link),
);

$precio_maximo = $propiedad_model->get_precio_maximo(array(
  "id_tipo_operacion"=>($propiedad->id_tipo_operacion != 5) ? $propiedad->id_tipo_operacion : 0
));

// Minimo
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;

// Maximo
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo ($propiedad->nombre); ?>" />
<meta property="og:description" content="<?php echo str_replace("\n","",(strip_tags(html_entity_decode($propiedad->texto,ENT_QUOTES)))); ?>" />
<meta property="og:image" content="<?php echo current_url(TRUE); ?>/admin/<?php echo $propiedad->path; ?>"/>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

</head>
<body>

<?php include("includes/header.php"); ?>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-9 primary">
        <div class="property-full-info">

          

          <?php if (!empty($propiedad->images)) { ?>
            <?php $foto = $propiedad->images[0]; ?>
            <div id="gallery-slider">
              <div id="gallery-picture">
                <img src="<?php echo $foto ?>" class="contain-detail" alt="" />
              </div>
              <div id="hidden-thumbs">
                <?php foreach($propiedad->images as $f) { ?>
                  <img src="<?php echo $f ?>" class="cover-detail" alt="" />
                <?php } ?>
              </div>
              <div class="thumbnails">
                <a href="javascript:void(0);" id="gallery-nav" class="prev-button"></a>
                <a href="javascript:void(0);" id="gallery-nav" class="next-button"></a>
                <div id="thumbcon"></div>
              </div>
            </div>
          <?php } ?>

          <?php if (!empty($propiedad->video) || !empty($propiedad->audio)) { ?>
            <div class="row">
              <?php if (!empty($propiedad->video)) { ?>
                <div class="col-md-6">
                  <a data-fancybox="gallery" href="<?php echo $propiedad->video ?>" class="btn-video">
                    <span class="dt">
                      <span class="dtc vat">
                        <img class="img" src="images/video.png" alt="Video"/>
                      </span>
                      <span class="dtc vat">
                        <h4>RECORRIDO EN VIDEO</h4>
                        <h5><img src="images/play1.png" alt="Video"/> Para ver el video click ac&aacute;</h5>
                      </span>
                    </span>
                  </a>
                </div>
              <?php } ?>
              <?php if (!empty($propiedad->audio)) { ?>
                <div class="col-md-6">
                  <audio id="audio" style="display: none" controls><source src="/admin/<?php echo $propiedad->audio ?>" /></audio>
                  <a onclick="toggleAudio()" href="javascript:void(0);" class="btn-video">
                    <span class="dt">
                      <span class="dtc vat">
                        <img class="img" src="images/audio.png" alt="Video"/>
                      </span>
                      <span class="dtc vat">
                        <h4>INFORMACI&Oacute;N EN AUDIO</h4>
                        <h5><img src="images/play1.png" alt="Video"/> Para escuchar el audio click ac&aacute;</h5>
                      </span>
                    </span>
                  </a>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-md-12">
              <div class="property-name"><?php echo ($propiedad->nombre); ?></div>
              <div class="property-price">
                <big>
                  <?php echo $propiedad->precio ?>
                </big>
              </div>
              <br>
              <!-- <?php if (!empty($propiedad->subtitulo)) { ?>
                <div class="property-name"><?php echo ($propiedad->subtitulo); ?></div>
              <?php } ?> -->   
            </div>
          </div>
        

          <div class="border-box">
            <div class="box-space" style="border-bottom:1px solid #e6e6e6; padding-bottom: 15px; margin-bottom: 15px">
              <div class="property-location">
                <div class="pull-left"><?php echo ($propiedad->calle." | ".$propiedad->localidad); ?></div>
                <div class="pull-right">
                  <?php if (!empty($propiedad->codigo)) { ?>
                    <small>Cod: <span><?php echo ($propiedad->codigo); ?></span></small>
                  <?php } ?>
                  <?php if (estaEnFavoritos($propiedad->id)) { ?>
                    <small><a href="/admin/favoritos/eliminar/?id=<?php echo $propiedad->id; ?>" class="favorites-properties active"><span class="tooltip">Borrar de Favoritos</span></a></small>
                  <?php } else { ?>
                    <small><a href="/admin/favoritos/agregar/?id=<?php echo $propiedad->id; ?>" class="favorites-properties"><span class="tooltip">Guarda Tus Inmuebles Favoritos</span></a></small>
                  <?php } ?>
                  <small><span class="st_sharethis_large"></span></small>
                </div>
              </div>
            </div>
            <div class="property-facilities">
              <?php if (!empty($propiedad->dormitorios)) { ?>
                <div class="facilitie"><img src="images/room-icon.png" alt="Room" /> <?php echo $propiedad->dormitorios ?> Hab</div>
              <?php } ?>
              <?php if (!empty($propiedad->banios)) { ?>
                <div class="facilitie"><img src="images/shower-icon3.png" alt="Shower" /> <?php echo $propiedad->banios ?> Ba&ntilde;os</div>
              <?php } ?>
              <?php if (!empty($propiedad->cocheras)) { ?>
                <div class="facilitie"><img src="images/garage-icon.png" alt="Garage" /> <?php echo $propiedad->cocheras ?> Cochera</div>
              <?php } ?>
              <?php if (!empty($propiedad->superficie_total)) { ?>
                <div class="facilitie"><img src="images/grid-icon.png" alt="Grid" /> <?php echo $propiedad->superficie_total ?> m<sup>2</sup></div>
              <?php } ?>
              <?php if ($propiedad->apto_banco == 1) { ?>
                <span class="apto_banco">Apto cr&eacute;dito bancario</span>
              <?php } ?>
              <?php if ($propiedad->acepta_permuta == 1) { ?>
                <span class="apto_banco">Acepta permuta</span>
              <?php } ?>
            </div>
            <?php if (!empty($propiedad->texto)) { ?>
              <div class="box-space">
                <p><?php echo (html_entity_decode($propiedad->texto,ENT_QUOTES)); ?></p>
              </div>
            <?php } ?>
            <?php $caracteristicas = explode(";;;",$propiedad->caracteristicas);
            if (!empty($caracteristicas) && !empty($caracteristicas[0])) { ?>
              <div class="info-title">Caracter&iacute;sticas Generales</div>
              <div class="box-space">
                <div class="available-facilities">
                  <ul>
                    <?php foreach($caracteristicas as $c) { ?>
                      <li><?php echo ($c); ?></li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            <?php } ?>
            <div class="info-title">Ubicaci&oacute;n en mapa</div>
            <?php if (($propiedad->latitud != 0) && ($propiedad->longitud != 0)) { ?>
              <div class="box-space tab-parent">
                <div class="tab-cont" id="map"></div>
                <?php if (!empty($propiedad->heading)) { ?>
                  <div class="tab-cont" id="street"></div>
                <?php } ?>
                <div class="map-buttons">
                  <a href="javascript:void(0)" class="link active" data-action="map">MAPA</a>
                  <a href="javascript:void(0)" class="link <?php echo (empty($propiedad->heading) ? "inactive":"") ?>" data-action="street">STREET VIEW</a>
                </div>
              </div>
            <?php } ?>
            <div class="tab-parent">
              <div class="info-title">FORMULARIO DE CONSULTA</div>
              <div class="box-space">
                <div class="form">
                  <div class="tab-cont row" id="form-contacto">
                    <?php include("includes/form_contacto.php"); ?>
                  </div>
                  <div class="tab-cont row" style="display: none" id="form-contacto-2">
                    <?php include("includes/form_contacto_2.php"); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="info-title">ficha de propiedad</div>
            <div class="box-space">
              <div class="helpful-links"> 
                <a target="_blank" href="<?php echo $propiedad->link_ficha ?>"><img src="images/pdf-icon2.png" alt="Download PDF" /> descargar pdf</a> 
                <a href="javascript:void(0)" onclick="enviar_ficha_email()"><img src="images/email-icon2.png" alt="Send by Email" /> enviar por email</a> 
                <a target="_blank" href="<?php echo $propiedad->link_ficha ?>"><img src="images/printer-icon.png" alt="Print Property" /> imprimir propiedad</a> 
              </div>
            </div>
          </div>
        </div>
        
        <?php
        // Propiedades relacionadas o similares
        
        // A las propiedades relacionadas especificamente a mano, las debemos juntar por las
        // similares que coinciden en ciudad, tipo de operacion y tipo de inmueble
        
        if (!empty($propiedad->relacionados)) { ?>
          <div class="block">
            <div class="section-title"><big>propiedades similares</big></div>
            <div class="owl-carousel2 similares">
              <?php foreach($propiedad->relacionados as $r) {
                $link_propiedad = (isset($r->pertenece_red) && $r->pertenece_red == 1) ? mklink($r->link)."&em=".$r->id_empresa : mklink($r->link); ?>
                <div class="property-item">
                  <div class="item-picture">
                    <div class="block">
                      <?php if (!empty($r->path)) { ?>
                        <img class="thumb-image" src="/admin/<?php echo $r->path ?>" alt="<?php echo ($r->nombre) ?>" />
                      <?php } else { ?>
                        <img class="thumb-image" src="images/no-image-1.jpg" alt="<?php echo ($r->nombre) ?>" />
                      <?php } ?>
                    </div>
                    <div class="view-more"><a href="<?php echo $r->link_propiedad ?>"></a></div>
                    <div class="ribbon"><?php echo ($r->tipo_operacion) ?></div>
                  </div>
                  <div class="property-detail">
                    <div class="property-name"><?php echo ($r->calle) ?></div>
                    <div class="property-location">
                      <div class="pull-left"><?php echo ($r->localidad) ?></div>
                      <?php if (!empty($r->codigo)) { ?>
                        <div class="pull-right">Cod: <span><?php echo ($r->codigo) ?></span></div>
                      <?php } ?>
                    </div>
                    <div class="property-facilities">
                      <div class="block">
                        <?php if (!empty($r->dormitorios)) { ?>
                          <div class="facilitie"><img src="images/room-icon.png" alt="Room" /> <?php echo $r->dormitorios ?> Hab</div>
                        <?php } ?>
                        <?php if (!empty($r->banios)) { ?>
                          <div class="facilitie"><img src="images/shower-icon3.png" alt="Shower" /> <?php echo $r->banios ?> Ba&ntilde;os</div>
                        <?php } ?>
                      </div>
                      <div class="block">
                        <?php if (!empty($r->cocheras)) { ?>
                          <div class="facilitie"><img src="images/garage-icon.png" alt="Garage" /> <?php echo $r->cocheras ?> Cochera</div>
                        <?php } ?>
                        <?php if (!empty($r->superficie_total)) { ?>
                          <div class="facilitie"><img src="images/grid-icon.png" alt="Grid" /> <?php echo $r->superficie_total ?> m<sup>2</sup></div>
                        <?php } ?>
                      </div>
                    </div>
                    <?php if (!empty($r->descripcion)) { ?>
                      <p><?php echo ((strlen($r->descripcion)>80) ? substr($r->descripcion,0,80)."..." : $r->descripcion); ?></p>
                    <?php } ?>
                    <div class="property-price">
                      <?php echo $propiedad->precio ?>
                      <?php if (estaEnFavoritos($r->id)) { ?>
                        <a href="/admin/favoritos/eliminar/?id=<?php echo $r->id; ?>" class="favorites-properties active"><span class="tooltip">Borrar de Favoritos</span></a>
                      <?php } else { ?>
                        <a href="/admin/favoritos/agregar/?id=<?php echo $r->id; ?>" class="favorites-properties"><span class="tooltip">Guarda Tus Inmuebles Favoritos</span></a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="col-md-3 secondary">
        <?php include("includes/filter.php"); ?>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php"); ?>

<?php if (!empty($propiedad->audio)) { ?>
<script type="text/javascript">
function toggleAudio() {
  var vid = document.getElementById("audio"); 
  if ($("#audio").hasClass("active")) {
    vid.pause();
    $("#audio").removeClass("active")
  } else {
    vid.play();
    $("#audio").addClass("active")    
  }
}
</script>
<?php } ?>
<script type="text/javascript">
 if (jQuery(window).width()>767) { 

  $(document).ready(function(){
    var maximo = 0;
    $("div.facilities").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $("div.facilities").height(maximo);
  });
}
</script>

<script type="text/javascript" src="js/nouislider.js"></script>
<?php include_once("templates/comun/mapa_js.php"); ?>

<script type="text/javascript">
// //SLIDER SNAP SCRIPT
// $('.slider-snap').noUiSlider({
// 	start: [ <?php echo $minimo ?>, <?php echo $maximo ?> ],
// 	step: 10,
// 	connect: true,
// 	range: {
// 		'min': 0,
// 		'max': <?php echo $precio_maximo ?>,
// 	}
// });
// $('.slider-snap').Link('lower').to($('.slider-snap-value-lower'));
// $('.slider-snap').Link('upper').to($('.slider-snap-value-upper'));

//OWL CAROUSEL(2) SCRIPT
jQuery(window).load(function ($) {
"use strict";

  var maximo = 0;
  $(".similares .property-detail").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  $(".similares .property-detail").height(maximo);
  
});

function enviar_ficha_email() {
  var email = prompt("Escriba su email: ");
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido.");
  } else {
    var datos = {
      "texto":"Ficha de Propiedad",
      "email_to":email,
      "email_from":"<?php echo $empresa->email ?>",
      "id_empresa":ID_EMPRESA,
      "adjuntos":[{
        "id_objeto":"<?php echo $propiedad->id ?>",
        "nombre":"<?php echo ($propiedad->nombre) ?>",
        "tipo":3
      }],
      "asunto":"<?php echo ($propiedad->nombre) ?>",
    };
    $.ajax({
      "url":"/admin/emails/0",
      "type":"PUT",
      "dataType":"json",
      "data":JSON.stringify(datos),
      "success":function(res) {
        if (res.error == 0) {
          alert("Hemos enviado la ficha de la propiedad a '"+email+"'. Muchas gracias.");
        } else {
          alert("Ha ocurrido un error al enviar el email. Disculpe las molestias.");
        }
      }
    });
  }
}

</script>
<script type="text/javascript" src="js/galleryslider.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  <?php if (!empty($propiedad->latitud) && !empty($propiedad->longitud)) { ?>

    var mymap = L.map('map').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], 16);

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

    L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>],{
      icon: icono
    }).addTo(mymap);

  <?php } ?>
});
</script>
<script type="text/javascript" src="js/buttons.js"></script>
<!-- <script type="text/javascript">stLight.options({publisher: "94d2174e-398d-4a49-b5ce-0b6a19a58759", onhover: false, doNotHash: true, doNotCopy: false, hashAddressBar: false});</script> -->
<script type="text/javascript">
  //OWL CAROUSEL(2) SCRIPT
jQuery(document).ready(function ($) {
"use strict";
    $(".owl-carouselmarcas").owlCarousel({
      items : 5,
      itemsDesktop : [1279,2],
      itemsDesktopSmall : [979,2],
      itemsMobile : [639,1],
    });

    $(".map-buttons .link").click(function(e){
      var action = $(e.currentTarget).data("action");
      $(e.currentTarget).parents(".tab-parent").find(".link").removeClass("active");
      $(e.currentTarget).parents(".tab-parent").find(".tab-cont").hide();
      $("#"+action).show();
      $(e.currentTarget).addClass('active');
      $(window).trigger('resize');
    });

    $(".owl-carousel2").owlCarousel({
        items : 2,
        itemsDesktop : [1279,2],
        itemsDesktopSmall : [979,2],
        itemsMobile : [639,1],
      });
});
</script>
</body>
</html>