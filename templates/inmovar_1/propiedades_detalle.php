<?php
date_default_timezone_set("America/Argentina/Buenos_Aires");
$id_origen = 1;
include_once("includes/funciones.php");
include_once("models/Web_Model.php");

$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;

$web_model = new Web_Model($empresa->id, $conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id, $conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id, $conx);
$propiedad = $propiedad_model->get($id, array(
  "buscar_total_visitas" => 1,
  "buscar_relacionados_offset" => 3,
  "id_empresa" => $id_empresa,
  "id_empresa_original" => $empresa->id,
));

if (($propiedad === FALSE || !isset($propiedad->nombre) || $propiedad->activo == 0) && !isset($get_params["preview"])) {
  header("HTTP/1.1 302 Moved Temporarily");
  header("Location:" . mklink("/"));
  exit();
}

$dolar = $web_model->get_cotizacion_dolar();

$precio_maximo = $propiedad_model->get_precio_maximo(array(
  "id_tipo_operacion" => $propiedad->id_tipo_operacion,
));

// Minimo
if (isset($_POST["minimo"])) {
  $_SESSION["minimo"] = filter_var($_POST["minimo"], FILTER_SANITIZE_STRING);
}
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;

// Maximo
if (isset($_POST["maximo"])) {
  $_SESSION["maximo"] = filter_var($_POST["maximo"], FILTER_SANITIZE_STRING);
}
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo;

// Tomamos los datos de SEO
$seo_title = (!empty($propiedad->seo_title)) ? $propiedad->seo_title : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? $propiedad->seo_description : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? $propiedad->seo_keywords : $empresa->seo_keywords;

$cookie_id_cliente = (isset($_COOKIE['idc'])) ? $_COOKIE['idc'] : 0;

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad" => $propiedad->id));

if (sizeof($propiedad->images) == 0 && !empty($propiedad->imagen)) $propiedad->images = array_merge(array($propiedad->imagen), $propiedad->images);
$nombre_pagina = $propiedad->tipo_operacion_link;

if ($propiedad->id_tipo_operacion == 1) $vc_moneda = "USD";
else $vc_moneda = "$";
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
  <?php include("includes/head.php"); ?>
  <?php include "templates/comun/og.php" ?>

  <script>
    const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";
  </script>
  <script>
    const ID_EMPRESA_RELACION = "<?php echo $id_empresa ?>";
  </script>
  <style type="text/css">
    .fluid-width-video-wrapper {
      padding-top: 100% !important
    }

    .chat_user_form_row_4 {
      float: left;
      width: 40%;
    }

    .chat_user_form_row6{
      float: left;
      width: 60%;
    }

  </style>
</head>

<body class="page-sub-page page-property-detail" id="page-top">
  <!-- Wrapper -->
  <div class="wrapper">
    <?php include("includes/header.php"); ?>
    <!-- Page Content -->
    <div id="page-content">
      <!-- Breadcrumb -->
      <div class="container">
        <ol class="breadcrumb">
          <li><a href="<?php echo mklink("/"); ?>">Home</a></li>
          <li><a href="<?php echo mklink("propiedades/$propiedad->tipo_operacion_link/"); ?>"><?php echo $propiedad->tipo_operacion ?></a></li>
          <li><a href="<?php echo mklink("propiedades/$propiedad->tipo_operacion_link/$propiedad->localidad_link/"); ?>"><?php echo $propiedad->localidad ?></a></li>
          <li class="active"><a href="<?php echo $propiedad->link_propiedad ?>"><?php echo $propiedad->nombre ?></a></li>
        </ol>
      </div>
      <!-- end Breadcrumb -->

      <div class="container">
        <div class="row">
          <!-- Property Detail Content -->
          <div class="col-md-9 col-sm-9">
            <section id="property-detail">
              <header class="property-title">
                <h1><?php echo $propiedad->nombre ?></h1>
                <figure class="fs16">
                  <?php if (!empty($propiedad->codigo)) { ?>
                    C&oacute;digo: <?php echo $propiedad->codigo . " | " ?>
                  <?php } ?>
                  <?php echo $propiedad->direccion_completa . " | " . $propiedad->localidad; ?>
                </figure>

                <?php if (isset($propiedad->pertenece_red) && $propiedad->pertenece_red == 1) { ?>
                  <div class="mt10"><span class="tag price">Red Inmovar</span></div>
                <?php } ?>

                <span class="actions">
                  <?php if (estaEnFavoritos($propiedad->id)) { ?>
                    <a class="bookmark" data-bookmark-state="added" href="/admin/favoritos/eliminar/?id=<?php echo $propiedad->id; ?>">
                      <span class="title-add">Guarda Tus Inmuebles Favoritos</span>
                      <span class="title-added">Guardado en Favoritos</span>
                    </a>
                  <?php } else { ?>
                    <a class="bookmark" data-bookmark-state="empty" href="/admin/favoritos/agregar/?id=<?php echo $propiedad->id; ?>">
                      <span class="title-add">Guarda Tus Inmuebles Favoritos</span>
                      <span class="title-added">Guardado en Favoritos</span>
                    </a>
                  <?php } ?>
                </span>
              </header>
              <?php if (sizeof($propiedad->images) > 0) { ?>
                <section id="property-gallery" class="pr">

                  <?php if (sizeof($propiedad->images) == 1) {
                    $image = $propiedad->images[0]; ?>
                    <img class="alto-2" src="<?php echo $image ?>" style="width: 100%" alt="<?php echo $propiedad->nombre ?>" />
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
                        $i = 0;
                        foreach ($propiedad->images as $image) { ?>
                          <div class="item <?php echo ($i == 0) ? "active" : "" ?>">
                            <a href="<?php echo $image ?>" class="image-popup">
                              <img class="alto-2" src="<?php echo $image ?>" alt="<?php echo $propiedad->nombre ?>" />
                            </a>
                          </div>
                        <?php $i++;
                        } ?>
                      </div>
                    </div>
                  <?php } ?>
                </section>
              <?php } ?>
              <div class="row">
                <div class="col-md-4 col-sm-12">
                  <section id="quick-summary" class="clearfix">
                    <header>
                      <h2>Informaci&oacute;n</h2>
                    </header>
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
                      <dd><span class="tag price"><?php echo ($propiedad->precio_final != 0 && $propiedad->publica_precio == 1) ? $propiedad->moneda . " " . number_format($propiedad->precio_final, 0) : "Consultar"; ?></span></dd>
                      <dt>Tipo de propiedad:</dt>
                      <dd><?php echo $propiedad->tipo_inmueble ?></dd>
                      <dt>Estado:</dt>
                      <dd><?php echo $propiedad->tipo_estado ?></dd>

                      <?php
                      // SUPERFICIES
                      if (!empty($propiedad->superficie_cubierta)) { ?>
                        <dt>Sup. Cubierta:</dt>
                        <dd><?php echo $propiedad->superficie_cubierta . " mts<sup>2</sup>"; ?></dd>
                      <?php } ?>
                      <?php if (!empty($propiedad->superficie_semicubierta)) { ?>
                        <dt>Sup. Semicubierta:</dt>
                        <dd><?php echo $propiedad->superficie_semicubierta . " mts<sup>2</sup>"; ?></dd>
                      <?php } ?>
                      <?php if (!empty($propiedad->superficie_descubierta)) { ?>
                        <dt>Sup. Descubierta:</dt>
                        <dd><?php echo $propiedad->superficie_descubierta . " mts<sup>2</sup>"; ?></dd>
                      <?php } ?>
                      <?php if (!empty($propiedad->superficie_total)) { ?>
                        <dt>Sup. Total:</dt>
                        <dd><?php echo $propiedad->superficie_total . " mts<sup>2</sup>"; ?></dd>
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
                        <dd><?php echo (!empty($propiedad->banios)) ? (($propiedad->banios == 1) ? "1 Baño" : $propiedad->banios . " Baños") : "-" ?></dd>
                        <dt>Cocheras:</dt>
                        <dd><?php echo (!empty($propiedad->cocheras)) ? (($propiedad->cocheras == 1) ? "Cochera" : $propiedad->cocheras . " Cocheras") : "Sin cochera" ?></dd>
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
                      <?php if ($propiedad->servicios_aire_acondicionado == 1) { ?>
                        <dt>Aire Acondicionado:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->servicios_uso_comercial == 1) { ?>
                        <dt>Uso Comercial:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->servicios_internet == 1) { ?>
                        <dt>Internet:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->gimnasio == 1) { ?>
                        <dt>Gimnasio:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->parrilla == 1) { ?>
                        <dt>Parrilla:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->piscina == 1) { ?>
                        <dt>Piscina:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->vigilancia == 1) { ?>
                        <dt>Vigilancia:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->sala_juegos == 1) { ?>
                        <dt>Sala de Juegos:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->ascensor == 1) { ?>
                        <dt>Ascensor:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->lavadero == 1) { ?>
                        <dt>Lavadero:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->living_comedor == 1) { ?>
                        <dt>Living Comedor:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->terraza == 1) { ?>
                        <dt>Terraza:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->accesible == 1) { ?>
                        <dt>Accesible:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->balcon == 1) { ?>
                        <dt>Balcon:</dt>
                        <dd>Sí</dd>
                      <?php } ?>
                      <?php if ($propiedad->patio == 1) { ?>
                        <dt>Patio:</dt>
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
                    <div class="property-share">
                      <?php
                      // LANGONE
                      if ($empresa->id == 161) { ?>
                        <div class="whatsapp_cont">
                          <div class="whatsapp_cont_icon">
                            <i class="fa fa-whatsapp"></i>
                          </div>
                          <div class="whatsapp_cont_texto">
                            <span>HABLANOS POR WHATSAPP</span>
                            <?php $tel = preg_replace("/[^0-9]/", "", $empresa->telefono_2); ?>
                            <h3><a href="https://api.whatsapp.com/send?phone=<?php echo $tel ?>"><?php echo $empresa->telefono_2 ?></a></h3>
                          </div>
                        </div>
                      <?php } ?>
                      <div class="share-block">
                        <ul>
                          <li><a class="fb" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()) ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                          <li><a class="twitter" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(html_entity_decode($propiedad->nombre, ENT_QUOTES)) ?>&amp;url=<?php echo urlencode(current_url()) ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                          <li><a class="google" href="https://plus.google.com/share?url=<?php echo current_url() ?>" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                          <li><a class="mail" href="mailto:?subject=<?php echo html_entity_decode($propiedad->nombre, ENT_QUOTES) ?>&body=<?php echo (current_url()) ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                          <li><a class="whatsapp" href="whatsapp://send?text=<?php echo urlencode(current_url()) ?>"><i class="fa fa-whatsapp"></i></a></li>
                        </ul>
                      </div>
                    </div>
                  </section><!-- /#quick-summary -->
                </div><!-- /.col-md-4 -->
                <div class="col-md-8 col-sm-12">
                  <?php if (!empty($propiedad->texto)) { ?>
                    <section id="description">
                      <header>
                        <h2>Descripci&oacute;n</h2>
                      </header>
                      <?php echo ($propiedad->texto); ?>
                    </section>
                  <?php } ?>
                  <?php $caracteristicas = explode(";;;", $propiedad->caracteristicas);
                  if (sizeof($caracteristicas) > 0 && !empty($caracteristicas[0])) { ?>
                    <section id="property-features">
                      <header>
                        <h2>Caracter&iacute;sticas</h2>
                      </header>
                      <ul class="list-unstyled property-features-list">
                        <?php foreach ($caracteristicas as $c) { ?>
                          <li><?php echo ($c); ?></li>
                        <?php } ?>
                      </ul>
                    </section>
                  <?php } ?>
                  <?php if (sizeof($propiedad->planos) > 0) { ?>
                    <section id="floor-plans">
                      <div class="floor-plans">
                        <header>
                          <h2>Planos</h2>
                        </header>
                        <div class="owl-carousel property-carousel">
                          <?php foreach ($propiedad->planos as $p) { ?>
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
                      <header>
                        <h2>Mapa</h2>
                      </header>
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
                      <header>
                        <h2>Video</h2>
                      </header>
                      <div class="video">
                        <?php echo $propiedad->video ?>
                      </div>
                    </section>
                  <?php } ?>

                  <?php if (!empty($propiedad->pint)) {  ?>
                    <section id="video-presentation">
                      <header>
                        <h2>Recorrido 3D</h2>
                      </header>
                      <div class="video">
                        <iframe width="100%" height="500" src="<?php echo $propiedad->pint ?>"></iframe>
                      </div>
                    </section>
                  <?php } ?>

                  <section id="video-presentation">
                    <header>
                      <h2>Consulta por esta propiedad</h2>
                    </header>
                    <?php include("includes/form_contacto.php"); ?>
                  </section>
                </div><!-- /.col-md-8 -->
                <div class="col-md-12 col-sm-12">
                  <?php /*
                <section id="contact-agent">
                  <header><h2>Contact Agent</h2></header>
                  <div class="row">
                    <section class="agent-form">
                      <div class="col-md-7 col-sm-12">
                        <aside class="agent-info clearfix">
                          <figure><a href="agent-detail.html"><img alt="" src="assets/img/agent-01.jpg"></a></figure>
                          <div class="agent-contact-info">
                            <h3>Robert Farley</h3>
                            <p>
                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras et dui vestibulum,
                              bibendum purus sit amet, vulputate mauris. Ut adipiscing gravida tincidunt.
                              Duis euismod placerat rhoncus.
                            </p>
                            <dl>
                              <dt>Phone:</dt>
                              <dd>(123) 456 789</dd>
                              <dt>Mobile:</dt>
                              <dd>888 123 456 789</dd>
                              <dt>Email:</dt>
                              <dd><a href="mailto:#">john.doe@example.com</a></dd>
                              <dt>Skype:</dt>
                              <dd>john.doe</dd>
                            </dl>
                            <hr>
                            <a href="agent-detail.html" class="link-arrow">Full Profile</a>
                          </div>
                        </aside><!-- /.agent-info -->
                      </div><!-- /.col-md-7 -->
                      <div class="col-md-5 col-sm-12">
                        <div class="agent-form">
                          <form role="form" id="form-contact-agent" method="post"  class="clearfix">
                            <div class="form-group">
                              <label for="form-contact-agent-name">Your Name<em>*</em></label>
                              <input type="text" class="form-control" id="form-contact-agent-name" name="form-contact-agent-name" required>
                            </div><!-- /.form-group -->
                            <div class="form-group">
                              <label for="form-contact-agent-email">Your Email<em>*</em></label>
                              <input type="email" class="form-control" id="form-contact-agent-email" name="form-contact-agent-email" required>
                            </div><!-- /.form-group -->
                            <div class="form-group">
                              <label for="form-contact-agent-message">Your Message<em>*</em></label>
                              <textarea class="form-control" id="form-contact-agent-message" rows="2" name="form-contact-agent-message" required></textarea>
                            </div><!-- /.form-group -->
                            <div class="form-group">
                              <button type="submit" class="btn pull-right btn-default" id="form-contact-agent-submit">Send a Message</button>
                            </div><!-- /.form-group -->
                            <div id="form-contact-agent-status"></div>
                          </form><!-- /#form-contact -->
                        </div><!-- /.agent-form -->
                      </div><!-- /.col-md-5 -->
                    </section><!-- /.agent-form -->
                  </div><!-- /.row -->
                </section><!-- /#contact-agent -->
                <hr class="thick">
                */ ?>
                  <?php if (isset($propiedad->relacionados) && sizeof($propiedad->relacionados) > 0) { ?>
                    <section id="similar-properties">
                      <header>
                        <h2 class="no-border">Propiedades Relacionadas</h2>
                      </header>
                      <div class="row">
                        <?php foreach ($propiedad->relacionados as $r) { ?>
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
          <!-- end Property Detail Content -->

          <!-- sidebar -->
          <div class="col-md-3 col-sm-3">
            <section id="sidebar">
              <aside id="edit-search">
                <header>
                  <h3>Buscador</h3>
                </header>
                <?php include("includes/buscador.php"); ?>
              </aside>
              <?php include("includes/destacadas.php"); ?>
            </section><!-- /#sidebar -->
          </div><!-- /.col-md-3 -->
          <!-- end Sidebar -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div>
    <!-- end Page Content -->
    <?php include("includes/footer.php"); ?>
  </div>
  <?php include_once("templates/comun/mapa_js.php"); ?>
  <!--<script type="text/javascript" src="assets/js/infobox.js"></script>-->
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
      $(document).ready(function() {
        mostrar_mapa();
        // <?php if ($propiedad->heading != 0 && $propiedad->pitch != 0) { ?>
        //   mostrar_streetview();
        // <?php } ?> 
      });

      function mostrar_mapa() {

        <?php if (!empty($propiedad->latitud && !empty($propiedad->longitud))) { ?>
          var mymap = L.map('contact-map').setView([<?php echo $propiedad->latitud ?>, <?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);

          L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            tileSize: 512,
            maxZoom: 18,
            zoomOffset: -1,
          }).addTo(mymap);

          var icono = L.icon({
            iconUrl: 'assets/img/marker.png',
            iconSize: [48, 33], // size of the icon
            iconAnchor: [22, 33], // point of the icon which will correspond to marker's location
          });

          L.marker([<?php echo $propiedad->latitud ?>, <?php echo $propiedad->longitud ?>]).addTo(mymap);

        <?php } ?>

      }

      function mostrar_streetview() {
        var b = new google.maps.LatLng(<?php echo $propiedad->latitud ?>, <?php echo $propiedad->longitud ?>);
        var c = {
          center: b,
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var d = new google.maps.Map(document.getElementById("street-view"), c);
        var a = new google.maps.Marker({
          position: b,
          map: d
        });
        $(window).resize(function() {
          var e = d.getCenter();
          google.maps.event.trigger(d, "resize");
          d.setCenter(e)
        })
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
    "id_propiedad" => $propiedad->id,
    "id_empresa_compartida" => $id_empresa,
    "id_empresa" => $empresa->id,
  ));
  ?>
</body>

</html>