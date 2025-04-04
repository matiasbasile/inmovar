<?php
date_default_timezone_set("America/Argentina/Buenos_Aires");
$id_origen = 1;
include_once("includes/funciones.php");
include_once("models/Web_Model.php");

$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;

$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
$propiedad = $propiedad_model->get($id,array(
  "buscar_total_visitas"=>1,
  "buscar_relacionados_offset"=>3,
  "id_empresa"=>$id_empresa,
  "id_empresa_original"=>$empresa->id,
));
if ($propiedad === FALSE || !isset($propiedad->nombre)) header("Location:".mklink("/"));

$dolar = $web_model->get_cotizacion_dolar();

$precio_maximo = $propiedad_model->get_precio_maximo(array(
  "id_tipo_operacion"=>$propiedad->id_tipo_operacion,
));

if (isset($_SESSION["vc_minimo"])) $vc_minimo = $_SESSION["vc_minimo"];
if (isset($_SESSION["vc_maximo"])) $vc_maximo = $_SESSION["vc_maximo"];
if (isset($_SESSION["vc_link_localidad"])) $vc_link_localidad = $_SESSION["vc_link_localidad"];
if (isset($_SESSION["vc_link_tipo_operacion"])) $vc_link_tipo_operacion = $_SESSION["vc_link_tipo_operacion"];
if (isset($_SESSION["vc_id_tipo_inmueble"])) $vc_id_tipo_inmueble = $_SESSION["vc_id_tipo_inmueble"];
if (isset($_SESSION["vc_dormitorios"])) $vc_dormitorios = $_SESSION["vc_dormitorios"];
if (isset($_SESSION["vc_moneda"])) $vc_moneda = $_SESSION["vc_moneda"];
if (isset($_SESSION["vc_banios"])) $vc_banios = $_SESSION["vc_banios"];
if (isset($_SESSION["vc_cocheras"])) $vc_cocheras = $_SESSION["vc_cocheras"];

// Tomamos los datos de SEO
$seo_title = (!empty($propiedad->seo_title)) ? $propiedad->seo_title : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? $propiedad->seo_description : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? $propiedad->seo_keywords : $empresa->seo_keywords;

$cookie_id_cliente = (isset($_COOKIE['idc'])) ? $_COOKIE['idc'] : 0;

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad"=>$propiedad->id));

if (sizeof($propiedad->images)==0 && !empty($propiedad->imagen)) $propiedad->images = array_merge(array($propiedad->imagen),$propiedad->images);
$nombre_pagina = $propiedad->tipo_operacion_link;

if ($propiedad->id_tipo_operacion == 1) $vc_moneda = "USD";
else $vc_moneda = "$";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php include("includes/head.php"); ?>
<?php include "templates/comun/og.php" ?>
<script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
<script>const ID_EMPRESA_RELACION = "<?php echo $id_empresa ?>";</script>
<style type="text/css">
  .fluid-width-video-wrapper { padding-top: 100% !important }
</style>
</head>
<body class="page-sub-page page-search-results page-property-detail" id="page-top">
<div class="wrapper">

  <?php include("includes/header.php"); ?>

  <div id="page-content">
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-sm-9">
          <section id="property-detail">
            <header class="property-title mt30">
              <h1><?php echo $propiedad->nombre ?></h1>
              <figure class="fs16">
                <?php if (!empty($propiedad->codigo)) { ?>
                  C&oacute;digo: <?php echo $propiedad->codigo. " | " ?>
                <?php } ?>
                <?php echo $propiedad->direccion_completa." | ".$propiedad->localidad; ?>
              </figure>
            </header>
            <?php if (sizeof($propiedad->images) > 0) { ?>
              <section id="property-gallery" class="pr">

                <?php if (sizeof($propiedad->images)==1) { 
                  $image = $propiedad->images[0]; ?>
                  <img class="alto-2" src="<?php echo $image ?>" style="width: 100%" alt="<?php echo $propiedad->nombre ?>"/>
                <?php } else { ?>
                <div id="property-carousel" class="property-carousel carousel slide" data-ride="carousel">

                  <?php if ($propiedad->id_tipo_estado == 2) { ?>
                    <figure class="ribbon">Alquilado</figure>
                  <?php } else if ($propiedad->id_tipo_estado == 4) { ?>
                    <figure class="ribbon">Reservado</figure>
                  <?php } else if ($propiedad->id_tipo_estado == 3) { ?>
                    <figure class="ribbon">Vendido</figure>
                  <?php } ?>
                  
                  <a id="prev" class="carousel-control" href="#property-carousel" data-slide="prev"></a>
                  <a id="next" class="carousel-control" href="#property-carousel" data-slide="next"></a>

                  <div class="carousel-inner">
                    <?php 
                    $i=0;
                    foreach($propiedad->images as $image) { ?>
                      <div class="item <?php echo ($i==0)?"active":"" ?>">
                        <a href="<?php echo $image ?>" class="image-popup">
                          <img class="alto-2" src="<?php echo $image ?>" alt="<?php echo $propiedad->nombre ?>"/>
                        </a>
                      </div>
                    <?php $i++; } ?>
                  </div>
                </div>
                <?php } ?>
              </section>
            <?php } ?>
            <div class="row">
              <div class="col-md-4 col-sm-12">
                <section id="quick-summary" class="clearfix">
                  <header><h2>Informaci&oacute;n</h2></header>
                  <dl>
                    <?php if (!empty($propiedad->codigo)) { ?>
                      <dt>C&oacute;digo</dt>
                      <dd><?php echo $propiedad->codigo ?></dd>
                    <?php } ?>
                    <dt>Direcci&oacute;n</dt>
                    <dd><?php echo $propiedad->direccion_completa; ?></dd>
                    <?php if (!empty($propiedad->localidad)) { ?>
                      <dt>Localidad</dt>
                      <dd><?php echo $propiedad->localidad ?></dd>
                    <?php } ?>
                    <dt>Precio</dt>
                    <dd><span class="tag price"><?php echo ($propiedad->precio_final != 0 && $propiedad->publica_precio == 1) ? $propiedad->moneda." ".number_format($propiedad->precio_final,0) : "Consultar"; ?></span></dd>
                    <dt>Tipo de propiedad:</dt>
                    <dd><?php echo $propiedad->tipo_inmueble ?></dd>
                    <dt>Estado:</dt>
                    <dd><?php echo $propiedad->tipo_estado ?></dd>

                    <?php 
                    // SUPERFICIES
                    if (!empty($propiedad->superficie_cubierta)) { ?>
                      <dt>Sup. Cubierta:</dt>
                      <dd><?php echo $propiedad->superficie_cubierta." mts<sup>2</sup>"; ?></dd>
                    <?php } ?>
                    <?php if (!empty($propiedad->superficie_semicubierta)) { ?>
                      <dt>Sup. Semicubierta:</dt>
                      <dd><?php echo $propiedad->superficie_semicubierta." mts<sup>2</sup>"; ?></dd>
                    <?php } ?>
                    <?php if (!empty($propiedad->superficie_descubierta)) { ?>
                      <dt>Sup. Descubierta:</dt>
                      <dd><?php echo $propiedad->superficie_descubierta." mts<sup>2</sup>"; ?></dd>
                    <?php } ?>
                    <?php if (!empty($propiedad->superficie_total)) { ?>
                      <dt>Sup. Total:</dt>
                      <dd><?php echo $propiedad->superficie_total." mts<sup>2</sup>"; ?></dd>
                    <?php } ?>

                    <?php 
                    // MEDIDAS DEL TERRENO
                    if ($propiedad->mts_frente != 0) { ?>
                      <dt>Mts. Frente:</dt>
                      <dd><?php echo str_replace(".00", "", $propiedad->mts_frente) ?> Mts.</dd>
                    <?php } ?>
                    <?php if ($propiedad->mts_frente != 0) { ?>
                      <dt>Mts. Fondo:</dt>
                      <dd><?php echo str_replace(".00", "", $propiedad->mts_fondo) ?> Mts.</dd>
                    <?php } ?>

                    <?php 
                    // AMBIENTES
                    if ($propiedad->id_tipo_inmueble != 5 && $propiedad->id_tipo_inmueble != 6 && $propiedad->id_tipo_inmueble != 7 && $propiedad->id_tipo_inmueble != 13 && $propiedad->id_tipo_inmueble != 9 && $propiedad->id_tipo_inmueble != 10) { ?>
                      <?php if (!empty($propiedad->ambientes)) { ?>
                        <dt>Ambientes:</dt>
                        <dd><?php echo $propiedad->ambientes ?></dd>
                      <?php } ?>
                      <dt>Dormitorios:</dt>
                      <dd><?php echo (!empty($propiedad->dormitorios)) ? $propiedad->dormitorios : "-" ?></dd>
                      <dt>Baños:</dt>
                      <dd><?php echo (!empty($propiedad->banios)) ? (($propiedad->banios == 1)?"1 Baño":$propiedad->banios." Baños") : "-" ?></dd>
                      <dt>Cocheras:</dt>
                      <dd><?php echo (!empty($propiedad->cocheras)) ? (($propiedad->cocheras == 1)?"Cochera":$propiedad->cocheras." Cocheras") : "Sin cochera" ?></dd>
                    <?php } ?>

                    <?php if ($propiedad->servicios_cloacas == 1) { ?>
                      <dt>Cloacas:</dt>
                      <dd>Sí</dd>
                    <?php } ?>
                    <?php if ($propiedad->servicios_agua_corriente == 1) { ?>
                      <dt>Agua Corriente:</dt>
                      <dd>Sí</dd>
                    <?php } ?>
                    <?php if ($propiedad->servicios_electricidad == 1) { ?>
                      <dt>Electricidad:</dt>
                      <dd>Sí</dd>
                    <?php } ?>
                    <?php if ($propiedad->servicios_asfalto == 1) { ?>
                      <dt>Asfalto:</dt>
                      <dd>Sí</dd>
                    <?php } ?>
                    <?php if ($propiedad->servicios_gas == 1) { ?>
                      <dt>Gas Natural:</dt>
                      <dd>Sí</dd>
                    <?php } ?>
                    <?php if ($propiedad->servicios_telefono == 1) { ?>
                      <dt>Teléfono:</dt>
                      <dd>Sí</dd>
                    <?php } ?>
                    <?php if ($propiedad->servicios_cable == 1) { ?>
                      <dt>TV Cable:</dt>
                      <dd>Sí</dd>
                    <?php } ?>
                    <?php if ($propiedad->apto_banco == 1) {  ?>
                      <dt>Apto para crédito bancario</dt>
                      <dd>&nbsp;</dd>
                    <?php } ?>
                    <?php if ($propiedad->acepta_permuta == 1) {  ?>
                      <dt>Posibilidad de permuta</dt>
                      <dd>&nbsp;</dd>
                    <?php } ?>
                  </dl>
                </section><!-- /#quick-summary -->
              </div><!-- /.col-md-4 -->
              <div class="col-md-8 col-sm-12">
                <?php if (!empty($propiedad->texto)) { ?>
                  <section id="description">
                    <header><h2>Descripci&oacute;n</h2></header>
                    <?php echo ($propiedad->texto); ?>
                  </section>
                <?php } ?>
                <?php $caracteristicas = explode(";;;",$propiedad->caracteristicas);
                if (sizeof($caracteristicas)>0 && !empty($caracteristicas[0])) { ?>
                  <section id="property-features">
                    <header><h2>Caracter&iacute;sticas</h2></header>
                    <ul class="list-unstyled property-features-list">
                      <?php foreach($caracteristicas as $c) { ?>
                        <li><?php echo ($c); ?></li>
                      <?php } ?>
                    </ul>
                  </section>
                <?php } ?>
                <?php if (sizeof($propiedad->planos)>0) { ?>
                  <section id="floor-plans">
                    <div class="floor-plans">
                      <header><h2>Planos</h2></header>
                      <div class="owl-carousel property-carousel">
                        <?php foreach($propiedad->planos as $p) { ?>
                        <div class="property-slide">
                          <a href="<?php echo $p ?>" class="image-popup">
                          <img alt="" src="<?php echo $p ?>">
                          </a>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </section>
                <?php } ?>
                <?php if ($propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
                  <section id="property-map">
                    <header><h2>Mapa</h2></header>
                    <div class="property-detail-map-wrapper">
                      <div id="contact-map"></div>
                    </div>
                  </section>
                <?php } ?>
               <!--  <?php if ($propiedad->heading != 0 && $propiedad->pitch != 0) { ?>
                  <section>
                    <header><h2>Vista de calle</h2></header>
                    <div class="property-detail-map-wrapper">
                      <div style="height: 300px; width: 100%" id="street-view"></div>
                    </div>
                  </section>
                <?php } ?> -->
                <?php if (!empty($propiedad->video)) { ?>
                  <section id="video-presentation">
                    <header><h2>Video</h2></header>
                    <div class="video">
                      <?php echo $propiedad->video ?>
                    </div>
                  </section>
                <?php } ?>
                <section id="contacto-section">
                  <header><h2>Consulta por esta propiedad</h2></header>
                  <?php include("includes/form_contacto_flotante.php"); ?>
                </section>
              </div><!-- /.col-md-8 -->
              <div class="col-md-12 col-sm-12">
                <?php if (isset($propiedad->relacionados) && sizeof($propiedad->relacionados)>0) { ?>
                  <section id="similar-properties">
                    <header><h2 class="no-border">Propiedades Relacionadas</h2></header>
                    <div class="row">
                      <?php foreach($propiedad->relacionados as $r) { ?>
                        <div class="col-md-4 col-sm-6">
                          <div class="property">
                            <a href="<?php echo $r->link_propiedad ?>">
                              <div class="property-image">
                                <?php if (!empty($r->imagen)) { ?>
                                  <img class="alto" src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                                <?php } else if (!empty($empresa->no_imagen)) { ?>
                                  <img class="alto" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                                <?php } else { ?>
                                  <img class="alto" src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
                                <?php } ?>
                              </div>
                              <div class="overlay">
                                <div class="info">
                                  <div class="tag price"><?php echo $r->precio ?></div>
                                  <h3><?php echo $r->nombre ?></h3>
                                  <figure><?php echo $r->localidad ?></figure>
                                </div>
                                <ul class="additional-info">
                                  <?php if (!empty($r->superficie_total)) { ?>
                                    <li>
                                      <header>Superficie:</header>
                                      <figure><?php echo $r->superficie_total ?> m<sup>2</sup></figure>
                                    </li>
                                  <?php } ?>
                                  <li>
                                    <header>Habitaciones:</header>
                                    <figure><?php echo (!empty($r->dormitorios)) ? $r->dormitorios : "-" ?></figure>
                                  </li>
                                  <li>
                                    <header>Ba&ntilde;os:</header>
                                    <figure><?php echo (!empty($r->banios)) ? $r->banios : "-" ?></figure>
                                  </li>
                                  <li>
                                    <header>Cocheras:</header>
                                    <figure><?php echo (!empty($r->cocheras)) ? $r->cocheras : "-" ?></figure>
                                  </li>
                                </ul>
                              </div>
                            </a>
                          </div><!-- /.property -->
                        </div>
                      <?php } ?>
                    </div><!-- /.row-->
                  </section><!-- /#similar-properties -->
                <?php } ?>
              </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
          </section><!-- /#property-detail -->
        </div><!-- /.col-md-9 -->

        <div class="col-md-3 col-sm-3">
          <section id="sidebar">
            <?php include("includes/buscador.php"); ?>
          </section>
        </div>
        
      </div>
    </div>
  </div>
  <?php include("includes/footer.php"); ?>
</div>

<div class="operaciones-flotante">
  <div class="row">
    <div class="col-xs-3 pr5">
      <button onclick="window.history.back()" class="button"><i class="fa fa-arrow-left"></i></button>
    </div>
    <div class="col-xs-3 pl5 pr5">
      <button onclick="ver_whatsapp()" class="button btn-whatsapp"><i class="fa fa-whatsapp"></i></button>
    </div>
    <div class="col-xs-6 pl5">
      <button onclick="ver_consultar()" class="button active">Consultar</button>
    </div>
  </div>
</div>

<?php include_once("templates/comun/mapa_js.php"); ?>

<script type="text/javascript" src="assets/js/jquery.raty.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.fitvids.js"></script>
<!--[if gt IE 8]>
<script type="text/javascript" src="assets/js/ie.js"></script>
<![endif]-->
<script type="text/javascript" src="assets/js/custom.js"></script>
<script>
<?php if (isset($propiedad->latitud) && isset($propiedad->longitud) && $propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
//MAP SCRIPT
$(document).ready(function(){
  mostrar_mapa();
  // <?php if ($propiedad->heading != 0 && $propiedad->pitch != 0) { ?>
  //   mostrar_streetview();
  // <?php } ?> 
});
function mostrar_mapa() {

  <?php if (!empty($propiedad->latitud && !empty($propiedad->longitud))) { ?>
    var mymap = L.map('contact-map').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
    }).addTo(mymap);

    var icono = L.icon({
      iconUrl: 'assets/img/marker.png',
      iconSize:     [48, 33], // size of the icon
      iconAnchor:   [22, 33], // point of the icon which will correspond to marker's location
    });

    L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>]).addTo(mymap);

  <?php } ?>

}
function mostrar_streetview() {
  var b=new google.maps.LatLng(<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>);
  var c={center:b,zoom:15,mapTypeId:google.maps.MapTypeId.ROADMAP};
  var d=new google.maps.Map(document.getElementById("street-view"),c);
  var a=new google.maps.Marker({position:b,map:d});
  $(window).resize(function(){var e=d.getCenter();google.maps.event.trigger(d,"resize");d.setCenter(e)})
  var panorama = d.getStreetView();
  panorama.setPosition(b);
  panorama.setPov({
    "heading": parseFloat(<?php echo $propiedad->heading; ?>),
    "pitch": parseFloat(<?php echo $propiedad->pitch ?>),
  });
  panorama.setVisible(true);
}
<?php } ?>

</script>
<?php 
// Creamos el codigo de seguimiento para registrar la visita
echo $propiedad_model->tracking_code(array(
  "id_propiedad"=>$propiedad->id,
  "id_empresa_compartida"=>$id_empresa,
  "id_empresa"=>$empresa->id,
));
?>
</body>
</html>