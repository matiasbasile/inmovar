<?php
include 'includes/init.php';

$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id, array(
  "id_empresa" => $id_empresa,
  "id_empresa_original" => $empresa->id,
  "buscar_total_visitas" => 1,
));

if (($propiedad === FALSE || !isset($propiedad->nombre) || $propiedad->activo == 0) && !isset($get_params["preview"])) {
  header("HTTP/1.1 302 Moved Temporarily");
  header("Location:" . mklink("/"));
  exit();
}

if (empty($propiedad->id_usuario) || $propiedad->id_empresa != $empresa->id) {
  $usuarios = $usuario_model->get_list(array(
    "activo" => 1,
    "offset" => 99999,
    "recibe_notificaciones" => 1,
  ));
  $rand = array_rand($usuarios);
  $usuario = $usuarios[$rand];
  $propiedad->id_usuario = $usuario->id;
}
$usuario = $usuario_model->get($propiedad->id_usuario);

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad" => $propiedad->id));

// Tomamos los datos de SEO
$seo_title = (!empty($propiedad->seo_title)) ? ($propiedad->seo_title) : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? ($propiedad->seo_description) : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? ($propiedad->seo_keywords) : $empresa->seo_keywords;
$nombre_pagina = $propiedad->tipo_operacion_link;
?>
<!DOCTYPE html>
<html lang="es" >
<head>
  <?php include("includes/head.php") ?>
  <?php include "templates/comun/og.php" ?>
</head>
<body>

  <?php include("includes/header.php") ?>

<!-- Page Title  -->
<section class="page-title">
  <div class="container">
    <h1>La Plata</h1>
  </div>
</section>
<!-- Premises Sale -->
<section class="premises-sale">
  <div class="container">
    <div class="row">
      <div class="col-xl-8">
        <div class="section-title">
          <h3><?php echo $propiedad->nombre ?></h3>
          <small><?php echo $propiedad->direccion_completa ?></small>
        </div>
        <div class="aminities">
          <ul>
            <li><img src="assets/images/featureicon1.png" alt="icon"><b><?php echo (!empty($propiedad->dormitorios) ? $propiedad->dormitorios : "-") ?></b></li>

            <li><img src="assets/images/featureicon2.png" alt="icon"><b><?php echo (!empty($propiedad->banios) ? $propiedad->banios : "-") ?></b></li>

            <li><img src="assets/images/featureicon3.png" alt="icon"><b><?php echo (!empty($propiedad->cocheras)) ? $propiedad->cocheras : "-" ?></b></li>
            
            <li><img src="assets/images/featureicon4.png" alt="icon">Cub.: <b><?php echo (!empty($propiedad->superficie_cubierta) ? $propiedad->superficie_cubierta : "-") ?> m2</b></li>
            
            <?php if (!empty($propiedad->superficie_semicubierta)) { ?>
              <li class="semi">Semi: <b><?php echo $propiedad->superficie_semicubierta ?> m2</b></li>
            <?php } ?>

            <?php if (!empty($propiedad->superficie_total)) { ?>
              <li class="semi">Total: <b><?php echo $propiedad->superficie_total ?> m2</b></li>
            <?php } ?>

          </ul>
        </div>
        <div class="slider">
          <p>Código: <strong><?php echo $propiedad->codigo ?></strong></p>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a href="javascript:void(0)" onclick="abrir_galeria()" class="nav-link active">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                  <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                  <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                </svg>
              </a>
            </li>
            <?php if (!empty($propiedad->video)) { ?>
              <li class="nav-item" role="presentation">
                <a href="javascript:void(0)" rel="nofollow" onclick="moverA('video-box')" class="nav-link">  
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-video-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2V5z"/>
                  </svg>
                </a>
              </li>
            <?php } ?>
            <?php if (!empty($propiedad->pint)) { ?>
              <li class="nav-item" role="presentation">
                <a href="javascript:void(0)" rel="nofollow" onclick="moverA('pint-box')" class="nav-link" style="padding-left: 15px; padding-right: 15px;">  
                  <img src="assets/images/360.png" width="37" height="25" />
                </a>
              </li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active">  
              <div class="owl-carousel owl-theme" data-outoplay="true" data-items="1" data-nav="true" data-dots="false">
                <?php foreach ($propiedad->images as $img) { ?>
                  <div class="item">
                    <a href="javascript:void(0)" data-fancybox="gallery" data-src="<?php echo $img ?>">
                      <img src="<?php echo $img ?>" alt="img">
                    </a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="expenses-info <?php echo ($propiedad->valor_expensas == 0) ? "sin-expensas" : "con-expensas" ?>">
          <div class="expenses">
            <div class="doller">
              <img src="assets/images/home.png" alt="Home">
            </div>
            <div class="right-title">
              <?php if ($propiedad->precio_porcentaje_anterior < 0.00 && $propiedad->publica_precio == 1) { ?>
                <span><img src="assets/images/down-arrow.svg" alt="Arrow"> Bajo de precio un <?php echo floatval($propiedad->precio_porcentaje_anterior * -1) ?>%</span>
              <?php } ?>
              <h5><?php echo $propiedad->precio ?></h5>
              <?php if ($propiedad->valor_expensas != 0 && $propiedad->publica_precio == 1) { ?>
                <small>+ <?php echo "$" . number_format($propiedad->valor_expensas,0,",",".") ?> Expensas</small>
              <?php } ?>
            </div>
          </div>
          <div class="play-btn">
            <img src="assets/images/right-arrow.svg" alt="Arrow">
          </div>
        </div>

        <?php if (!empty($propiedad->texto)) { ?>
          <div class="section-title">
            <h3>Descripción</h3>
          </div>
          <div class="title">
            <p><?php echo $propiedad->texto ?></p>
          </div>
        <?php } ?>

        <div class="section-title">
          <h3>Dónde se encuentra</h3>
        </div>
        <div class="title">
          <p><?php echo $propiedad->direccion_completa ?></p>
        </div>

        <?php if (!empty($propiedad->latitud)) { ?>
          <div class="map-block">
            <div id="map"></div>
          </div>
        <?php } ?>

        <div class="section-title">
          <h3>Más información</h3>
        </div>

        <h4>Características</h4>

        <div class="row">
          <div class="col-md-4 col-6">
            <div class="listing">
              <ul>
                
                <li>Código: <span><?php echo $propiedad->codigo ?></span></li>

                <li>Tipo: <span><?php echo $propiedad->tipo_inmueble ?></span></li>
                
                <?php if ($propiedad->dormitorios != 0) { ?>
                  <li>Dormitorios: <span><?php echo $propiedad->dormitorios ?></span></li>
                <?php } ?>

                <?php if ($propiedad->ambientes != 0) { ?>
                  <li>Ambientes: <span><?php echo $propiedad->ambientes ?></span></li>
                <?php } ?>

              </ul>
            </div>
          </div> 
          <div class="col-md-4 col-6">
            <div class="listing">
              <ul>

                <li>Antigüedad: <span>A estrenar</span></li>

                <?php if ($propiedad->banios != 0) { ?>
                  <li>Baños: <span><?php echo $propiedad->banios ?></span></li>
                <?php } ?>

                <?php if ($propiedad->cocheras != 0) { ?>
                  <li>Cocheras: <span><?php echo $propiedad->cocheras ?></span></li>
                <?php } ?>

                <li>Estado: <span> Muy Bueno</span></li>

              </ul>
            </div>
          </div>
          <div class="col-md-4 col-6">
            <div class="listing">
              <ul>
                <?php if ($propiedad->superficie_cubierta != 0) { ?>
                  <li>Sup. Cubierta: <span><?php echo $propiedad->superficie_cubierta ?> m2</span></li>
                <?php } ?>            
                <?php if ($propiedad->superficie_semicubierta != 0) { ?>
                  <li>Sup. Semicubierta: <span><?php echo $propiedad->superficie_semicubierta ?> m2</span></li>
                <?php } ?>
                <?php if ($propiedad->superficie_descubierta != 0) { ?>
                  <li>Sup. Descubierta: <span><?php echo $propiedad->superficie_descubierta ?> m2</span></li>
                <?php } ?>
                <?php if ($propiedad->superficie_total != 0) { ?>
                  <li>Sup. Total: <span><?php echo $propiedad->superficie_total ?> m2</span></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>

        <?php 
        $servicios = array();
        if ($propiedad->servicios_aire_acondicionado != 0) $servicios[] = "<li>Aire Acondicionado</li>";
        if ($propiedad->servicios_internet != 0) $servicios[] = "<li>WiFi</li>";
        if ($propiedad->servicios_gas != 0) $servicios[] = "<li>Gas</li>";
        if ($propiedad->servicios_cloacas != 0) $servicios[] = "<li>Cloacas</li>";
        if ($propiedad->servicios_agua_corriente != 0) $servicios[] = "<li>Agua corriente</li>";
        if ($propiedad->servicios_asfalto != 0) $servicios[] = "<li>Asfalto</li>";
        if ($propiedad->servicios_electricidad != 0) $servicios[] = "<li>Electricidad</li>";
        if ($propiedad->servicios_telefono != 0) $servicios[] = "<li>Teléfono</li>";
        if ($propiedad->servicios_cable != 0) $servicios[] = "<li>TV Cable</li>";

        if (sizeof($servicios)>0) { ?>
          <div class="checklist">
            <h4>Servicios</h4>
            <ul>
              <?php foreach($servicios as $s) echo $s; ?>
            </ul>
          </div>
        <?php } ?>

        <?php 
        $ambientes = array();
        if ($propiedad->patio != 0) $ambientes[] = "<li>Patio</li>";
        if ($propiedad->terraza != 0) $ambientes[] = "<li>Terraza</li>";
        if ($propiedad->living_comedor != 0) $ambientes[] = "<li>Living comedor</li>";
        if ($propiedad->lavadero != 0) $ambientes[] = "<li>Lavadero</li>";
        if ($propiedad->balcon != 0) $ambientes[] = "<li>Balcón</li>";
        if (sizeof($ambientes)>0) { ?>
          <div class="checklist">
            <h4>Ambientes</h4>
            <ul>
              <?php foreach($ambientes as $s) echo $s; ?>
            </ul>
          </div>
        <?php } ?>

        <?php 
        $comodidades = array();
        if ($propiedad->parrilla != 0) $comodidades[] = "<li>Parrilla</li>";
        if ($propiedad->piscina != 0) $comodidades[] = "<li>Piscina</li>";
        if ($propiedad->gimnasio != 0) $comodidades[] = "<li>Gimnasio</li>";
        if ($propiedad->ascensor != 0) $comodidades[] = "<li>Ascensor</li>";
        if ($propiedad->sala_juegos != 0) $comodidades[] = "<li>Sala de juegos</li>";
        if (sizeof($comodidades)>0) { ?>
          <div class="checklist">
            <h4>Comodidades</h4>
            <ul>
              <?php foreach($comodidades as $s) echo $s; ?>
            </ul>
          </div>
        <?php } ?>

        <div class="adicionales">
          <h4>Adicionales</h4>
          <div class="row">
            <div class="col-md-4 col-6">
              <div class="listing">
                <ul>
                  <li>Acepta Permuta: <small><?php echo $propiedad->acepta_permuta == 1 ? "Si" : "No" ?></small></li>
                </ul>
              </div>
            </div> 
            <div class="col-md-4 col-6">
              <div class="listing">
                <ul>
                  <li>Apto Crédito: <small><?php echo $propiedad->apto_banco == 1 ? "Si" : "No" ?></small></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <?php if (isset($propiedad->video_original) && !empty($propiedad->video_original)) { ?>
          <div class="section-title pt-4">
            <h3>Video</h3>
          </div>
          <div class="video-box" id="video-box">
            <div class="video-block">
              <iframe src="<?php echo $propiedad->video_original ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
          </div>
        <?php } ?>

        <?php if ($propiedad->pint) { ?>
          <div class="section-title pt-4">
            <h3>Recorrido virtual</h3>
          </div>
          <div class="video-box" id="pint-box">
            <div class="video-block">
              <iframe src="<?php echo $propiedad->pint ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
          </div>
        <?php } ?>  
    
      </div>
      <div class="col-xl-4">
        <div class="expenses-info <?php echo ($propiedad->valor_expensas == 0) ? "sin-expensas" : "con-expensas" ?>">
          <div class="expenses">
            <div class="doller">
              <h6>$</h6>
            </div>
            <div class="right-title">
              <?php if ($propiedad->precio_porcentaje_anterior < 0.00 && $propiedad->publica_precio == 1) { ?>
                <span><img src="assets/images/down-arrow.svg" alt="Arrow"> Bajo de precio un <?php echo floatval($propiedad->precio_porcentaje_anterior * -1) ?>%</span>
              <?php } ?>
              <h5><?php echo $propiedad->precio ?></h5>
              <?php if ($propiedad->valor_expensas != 0 && $propiedad->publica_precio == 1) { ?>
                <small>+ <?php echo "$" . number_format($propiedad->valor_expensas,0,",",".") ?> Expensas</small>
              <?php } ?>
            </div>
          </div>
          <div class="play-btn">
            <img src="assets/images/right-arrow.svg" alt="Arrow">
          </div>
        </div>
        

        <div class="gray-box">
          <div class="title">
            <img src="assets/images/contact-icon.png" alt="Contact Icon">
            <div class="right-info">
              <h4>Comunicate ahora</h4>
              <p>Por esta propiedad</p>
            </div>
          </div>
          <form id='form_whatsapp_sidebar' onsubmit="return false">
            <input type="text" class="form-control contacto_nombre" placeholder="Nombre">
            <input type="email" class="form-control contacto_email" placeholder="Email">
            <input type="number" class="form-control contacto_telefono" placeholder="Whatsapp (sin 0 ni 15)">
            <textarea class="form-control contacto_mensaje">Estoy interesado en <?php echo $propiedad->nombre ?> [COD: <?php echo $propiedad->codigo ?>]</textarea>
            <button onclick="enviar_whatsapp('form_whatsapp_sidebar')" type="submit" class="btn btn-green contacto_submit">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
              </svg> Enviar Whatsapp
            </button>
          </form>
        </div>
    </div>
  </div>
</section>

<?php include("includes/footer.php") ?>

<?php include 'includes/propiedad/modal.php' ?>

<?php include_once("templates/comun/mapa_js.php"); ?>

<script>
$(document).ready(function() {
  <?php if (!empty($propiedad->latitud) && !empty($propiedad->longitud)) { ?>

    /* if ($("#map").length == 0) return; */
    var mymap = L.map('map').setView([<?php echo $propiedad->latitud ?>, <?php echo $propiedad->longitud ?>], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: '<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>',
    }).addTo(mymap);


    var icono = L.icon({
      iconUrl: 'assets/images/map-icon.svg',
      iconSize: [32, 45], // size of the icon
      iconAnchor: [16, 16], // point of the icon which will correspond to marker's location
    });

    L.marker([<?php echo $propiedad->latitud ?>, <?php echo $propiedad->longitud ?>], {
      icon: icono
    }).addTo(mymap);

  <?php } ?>
});
</script>
<script>
// ==============================
// GALERIA DE FOTOS
  
Fancybox.bind('[data-fancybox="gallery"]', {}); 

function abrir_galeria() {
  $(".owl-carousel .item:first a").trigger("click")
}

function moverA(id) {
  $('html, body').animate({
    scrollTop: $("#"+id).offset().top
  }, 500);    
}
</script>

<?php 
// Creamos el codigo de seguimiento para registrar la visita
echo $propiedad_model->tracking_code(array(
  "id_propiedad"=>$propiedad->id,
  "id_empresa_compartida"=>$empresa->id,
  "id_empresa"=>$empresa->id,
));
?>
</body>
</html>