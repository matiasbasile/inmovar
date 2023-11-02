<?php
include 'includes/init.php';

$id_empresa = isset($get_params['em']) ? $get_params['em'] : $empresa->id;
$propiedad = $propiedad_model->get($id, [
  'id_empresa' => $id_empresa,
  'id_empresa_original' => $empresa->id,
  'buscar_total_visitas' => 1,
]);

if (($propiedad === false || !isset($propiedad->nombre) || $propiedad->activo == 0) && !isset($get_params['preview'])) {
  header('HTTP/1.1 302 Moved Temporarily');
  header('Location:'.mklink('/'));
  exit;
}

if (empty($propiedad->id_usuario) || $propiedad->id_empresa != $empresa->id) {
  $usuarios = $usuario_model->get_list([
    'activo' => 1,
    'offset' => 99999,
    'recibe_notificaciones' => 1,
  ]);
  $rand = array_rand($usuarios);
  $usuario = $usuarios[$rand];
  $propiedad->id_usuario = $usuario->id;
}
$usuario = $usuario_model->get($propiedad->id_usuario);
$contacto_whatsapp = preg_replace('/[^0-9]/', '', $usuario->telefono);

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(['id_propiedad' => $propiedad->id]);

// Tomamos los datos de SEO
$seo_title = (!empty($propiedad->seo_title)) ? ($propiedad->seo_title) : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? ($propiedad->seo_description) : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? ($propiedad->seo_keywords) : $empresa->seo_keywords;
$nombre_pagina = $propiedad->tipo_operacion_link;
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
<?php include 'includes/head.php'; ?>
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo $propiedad->nombre; ?>" />
<meta property="og:description"
  content="<?php echo str_replace("\n", '', strip_tags(html_entity_decode($propiedad->texto, ENT_QUOTES))); ?>" />
<meta property="og:image"
  content="<?php echo current_url().((!empty($propiedad->_full)) ? $propiedad->imagen_full : $empresa->no_imagen); ?>" />
<body>
<?php

$ambientes = array();
if ($propiedad->dormitorios == 1) $servicios[] = "Dormitorios";
if ($propiedad->living_comedor == 1) $servicios[] = "Living Comedor";
if ($propiedad->gimnasio == 1) $servicios[] = "Gimnasio";
if ($propiedad->vigilancia == 1) $servicios[] = "Vigilancia";
if ($propiedad->accesible == 1) $servicios[] = "Baño Accesible";
if ($propiedad->cocheras == 1) $servicios[] = ($propiedad->cocheras > 1) ? $propiedad->cocheras." Cocheras" : "Cochera";
if ($propiedad->piscina == 1) $servicios[] = "Piscina";
if ($propiedad->patio == 1) $servicios[] = "Patio";
if ($propiedad->balcon == 1) $servicios[] = "Balcón";
if ($propiedad->parrilla == 1) $servicios[] = "Parrilla";
if ($propiedad->terraza == 1) $servicios[] = "Terraza";
if ($propiedad->lavadero == 1) $servicios[] = "Lavadero";
if ($propiedad->sala_juegos == 1) $servicios[] = "Sala de Juegos";

$servicios = array();
if ($propiedad->servicios_electricidad == 1) $servicios[] = "Electricidad";
if ($propiedad->servicios_agua_corriente == 1) $servicios[] = "Agua Corriente";
if ($propiedad->servicios_asfalto == 1) $servicios[] = "Asfalto";
if ($propiedad->servicios_gas == 1) $servicios[] = "Gas Natural";
if ($propiedad->servicios_cloacas == 1) $servicios[] = "Cloacas";
if ($propiedad->servicios_aire_acondicionado == 1) $servicios[] = "Aire Acondicionado";
if ($propiedad->servicios_cable == 1) $servicios[] = "TV Cable";
if ($propiedad->servicios_telefono == 1) $servicios[] = "Teléfono";
if ($propiedad->servicios_internet == 1) $servicios[] = "WiFi";
?>

  <!-- Header -->
  <?php include 'includes/header.php'; ?>

  <!-- Banner -->
  <section class="duplex">
    <div class="container">
      <div class="section-title">
        <div>
          <h2><?php echo $propiedad->nombre; ?></h2>
          <p><?php echo $propiedad->direccion_completa; ?><span> <?php echo $propiedad->localidad; ?></span>
          </p>
        </div>
        <div>
          <div class="pricing">
            <?php if ($propiedad->precio_porcentaje_anterior < 0.00 && $propiedad->publica_precio == 1) { ?>
              <a href="javascript:void(0)"> 
                <img src="assets/images/down-arrow-green.png" alt="Arrow"> Bajo de precio un
                <?php echo floatval($propiedad->precio_porcentaje_anterior * -1); ?>%
              </a>
            <?php } ?>
            <h2><?php echo $propiedad->precio; ?></h2>
          </div>
          <div class="card-footer">
            <span><?php echo $propiedad->superficie_total; ?> m2</span>
            <ul>
              <li><img src="assets/images/bed.png" alt="Bed"><?php echo $propiedad->dormitorios; ?></li>
              <li><img src="assets/images/wash.png" alt="Wash"><?php echo $propiedad->banios; ?></li>
              <li><img src="assets/images/car.png" alt="Car"><?php echo $propiedad->cocheras; ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Duplex Slider -->

  <?php if (sizeof($propiedad->images) > 0) { ?>
    <section class="duplex-slider photo-gallery">
      <div class="owl-carousel" id="galería" data-items="3" data-items-xl="3" data-items-lg="3" data-items-md="3"
        data-items-sm="3" data-margin="3" data-nav="true" data-dots="false">
        <?php foreach ($propiedad->images as $img) { ?>
        <div class="item">
          <a data-fancybox="gallery" href="<?php echo $img; ?>">
            <img src="<?php echo $img; ?>" alt="Duplex">
          </a>
        </div>
        <?php } ?>
      </div>
      <!-- <div class="gallery-link">
        <a data-fancybox="gallery" href="assets/images/duplex-slide1.png"><img src="assets/images/camera.png"
            alt="Camera"></a>
        <a href="#video"><img src="assets/images/video.png" alt="Video"></a>
      </div> -->
    </section>
  <?php } ?>

  <section class="description-list">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="description-wrapper">
            <div class="description">
              <?php if (!empty($propiedad->texto)) { ?>
                <h2>Descripción</h2>
                <p><?php echo $propiedad->texto; ?></p>
              <?php } ?>
              <span>Código: <span class="p"><?php echo $propiedad->codigo; ?></span></span>
            </div>
            <div class="service-wrap">
              <h2>servicios</h2>
              <ul>
                <?php foreach ($servicios as $v) { ?>
                  <li>
                    <img src="assets/images/check.png" alt="Check">
                    <a href="javascript:void(0);"><?php echo $v ?></a>
                  </li>
                <?php } ?>
              </ul>
            </div>
            <div class="service-wrap">
              <h2>superficies</h2>
              <ul>
                <li>
                  <p href="javascript:void(0);">
                    Cubierta
                    <span><?php echo ($propiedad->superficie_cubierta != 0) ? $propiedad->superficie_cubierta : ' '; ?></span>
                  </p>
                </li>
                <li>
                  <p href="javascript:void(0);">
                    Descubierta
                    <span><?php echo ($propiedad->superficie_descubierta != 0) ? $propiedad->superficie_descubierta : ' '; ?></span>
                  </p>
                </li>
                <li>
                  <p href="javascript:void(0);">
                    Semicubierta
                    <span><?php echo ($propiedad->superficie_semicubierta != 0) ? $propiedad->superficie_semicubierta : ' '; ?></span>
                  </p>
                </li>
                <li>
                  <p href="javascript:void(0);">
                    Total
                    <span><?php echo ($propiedad->superficie_total != 0) ? $propiedad->superficie_total : ' '; ?></span>
                  </p>
                </li>
              </ul>
            </div>
            <div class="service-wrap">
              <h2>ambientes</h2>
              <ul>
                <?php foreach ($ambientes as $v) { ?>
                  <li>
                    <img src="assets/images/check.png" alt="Check">
                    <a href="javascript:void(0);"><?php echo $v ?></a>
                  </li>
                <?php } ?>
              </ul>
            </div>
            <div class="service-wrap">
              <h2>adicionales</h2>
              <ul>
                <li>
                  <a href="javascript:void(0);">
                    Apto Crédito
                    <span><?php echo ($propiedad->apto_banco == 0) ? 'No' : 'Sí'; ?></span>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0);">
                    Permuta
                    <span><?php echo ($propiedad->acepta_permuta == 0) ? 'No' : 'Sí'; ?></span>
                  </a>
                </li>
                <?php if ($propiedad->valor_expensas != 0) { ?>
                  <li>
                    <a href="javascript:void(0);">Expensas
                      <span>$<?php echo $propiedad->valor_expensas; ?></span>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </div>
            <div class="service-wrap">
              <h2>ubicación en mapa</h2>
              <section class="map-location">
                <div class="map mb-3">
                  <div class="tab-cont" id="map"></div>
                </div>
              </section>
            </div>
            <?php if (!empty($propiedad->video)) { ?>
              <div class="service-wrap" id="video">
                <h2>video</h2>
                <div class="video-wrap">
                  <img src="<?php echo $propiedad->imagen; ?>" alt="<?php echo $propiedad->nombre; ?>"
                    style="width:100%;">
                  <a href="#0" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"
                    class="play-btn"><img src="assets/images/youtube-icon.png" alt="Youtube"></a>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-wrap form-wrap-two form-wrap-three">
            <div class="section-title">
              <h2>enviar consulta</h2>
            </div>
            <form id="sellContactForm">
              <div class="form-group">
                <input id="contacto_nombre" class="form-control" type="text" placeholder="Nombre *">
              </div>
              <div class="form-group">
                <input id="contacto_email" class="form-control" type="email" placeholder="Email *">
              </div>
              <div class="form-group">
                <input id="contacto_telefono" class="form-control" type="text"
                  placeholder="WhatsApp (sin 0 ni 15) *">
              </div>
              <div class="form-group">
                <textarea id="contacto_mensaje"
                  placeholder="Estoy interesado en “<?php echo $propiedad->nombre; ?>”"
                  class="form-control"></textarea>
              </div>
              <div class="btn-block">
                <button type="submit" id="contacto_submit" class="btn">enviar email</button>
                <?php if (!empty($contacto_whatsapp)) { ?>
                  <a href="https://wa.me/<?php echo $contacto_whatsapp; ?>" target="_blank"
                    class="btn btn-icon btn-green"><img src="assets/images/whatsapp2.png"
                    alt="Whatsapp">enviar whatsapp
                  </a>
                <?php } ?>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>


</body>

</html>