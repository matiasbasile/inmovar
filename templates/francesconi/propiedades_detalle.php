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
<html dir="ltr" lang="en-US">

<head>
  <?php include 'includes/head.php' ?>
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?php echo ($propiedad->nombre); ?>" />
  <meta property="og:description" content="<?php echo str_replace("\n", "", (strip_tags(html_entity_decode($propiedad->texto, ENT_QUOTES)))); ?>" />
  <meta property="og:image" content="<?php echo $propiedad->imagen_full ?>" />
</head>

<body>

  <?php include 'includes/header.php' ?>

  <?php if (sizeof($propiedad->images) > 0) { ?>
    <section class="map-section magnific-gallery">
      <div class="swiper-container map-slider">
        <div class="swiper-wrapper">
          <?php foreach ($propiedad->images as $img) { ?>
            <div class="swiper-slide">
              <a class="fancybox" data-fancybox="gallery" href="<?php echo $img ?>"><img src="<?php echo $img ?>" class="noved_img" alt="Gallery"></a>
            </div>
          <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev swiper-button-white"></div>
        <div class="swiper-button-next swiper-button-white"></div>
      </div>
    </section>
  <?php } ?>

  <!-- Map Ruta -->
  <section class="map-ruta">
    <div class="container">
      <div class="noved-inner">
        <h2 class="color-title"><?php echo $propiedad->precio ?></h2>
        <h3 class="small-title">
          <?php echo $propiedad->direccion_completa ?>
          <span><?php echo $propiedad->nombre ?></span>
        </h3>
        <div class="mis-link">
          <ul>
            <?php if ($propiedad->superficie_total != 0) { ?>
              <li><?php echo $propiedad->superficie_total ?> m2</li>
            <?php } ?>
            <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-16.png" alt="Icon"><?php echo ($propiedad->dormitorios != 0) ? $propiedad->dormitorios : "-" ?></a></li>
            <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-17.png" alt="Icon"><?php echo ($propiedad->banios != 0) ? $propiedad->banios : "-" ?></a></li>
            <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-18.png" alt="Icon"><?php echo ($propiedad->cocheras != 0) ? $propiedad->cocheras : "-" ?></a></li>
          </ul>
        </div>
      </div>
      <div class="map-inner">
        <div class="row">
          <div class="col-lg-4">
            <?php if (!empty($propiedad->id_usuario)) { ?>
              <div class="map-info">
                <img src="<?php echo $usuario->path ?>" style="height: 79px; width: 79px; border-radius: 100%;" alt="Map">
                <div class="map-content">
                  <p>Vendedor asignado</p>
                  <span><?php echo $usuario->nombre ?></span>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="col-lg-4">
            <?php if (!empty($propiedad->id_usuario)) { ?>
              <div class="map-btn">
                <a href="https://wa.me/<?php echo str_replace(' ', '', $usuario->telefono) ?>" target="_blank" class="fill-btn"><img src="assets/images/icons/icon-7.png" alt="Icon">hablar ahora</a>
              </div>
            <?php } ?>
          </div>
          <div class="col-lg-4">
            <div class="map-link">
              <p>Código: <span><?php echo $propiedad->codigo ?></span></p>
            </div>
          </div>
        </div>
      </div>
      <?php if (!empty($propiedad->texto)) { ?>
        <div class="description-content">
          <h4>DESCRIPCIÓN</h4>
          <?php echo $propiedad->texto ?>
        </div>
      <?php } ?>
      <div class="description-content frist">
        <h4>ubicación</h4>
        <p><?php echo $propiedad->direccion_completa ?></p>
      </div>
    </div>
  </section>

  <!-- Map Location -->
  <section class="map-location">
    <div class="map mb-3">
      <div class="tab-cont" id="map"></div>
    </div>
  </section>

  <!-- Map Services -->
  <section class="map-services">
    <div class="container">
      <div class="description-content">
        <h4>SERVICIOS</h4>
        <ul>
          <li>
            <a href="javascript:void(0);">
              <?php echo ($propiedad->servicios_electricidad == 1) ? 'Electricidad<br/>' : '' ?>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <?php echo $propiedad->servicios_agua_corriente == 1 ? 'Agua Corriente' : '' ?>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <?php echo $propiedad->servicios_asfalto == 1 ? 'Asfalto' : '' ?>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <?php echo $propiedad->servicios_gas == 1 ? 'Gas Natural' : '' ?>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <?php echo $propiedad->servicios_cloacas == 1 ? 'Cloacas' : '' ?>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <?php echo $propiedad->servicios_aire_acondicionado == 1 ? 'Aire Acondicionado' : '' ?>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <?php echo $propiedad->servicios_cable == 1 ? 'TV Cable' : '' ?>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <?php echo $propiedad->servicios_telefono == 1 ? 'Teléfono' : '' ?>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <?php echo $propiedad->servicios_internet == 1 ? 'WiFi' : '' ?>
            </a>
          </li>
        </ul>
      </div>

      <?php if ($propiedad->superficie_total != 0) { ?>
        <div class="description-content second">
          <h4>SUPERFICIES</h4>
          <ul>
            <li>
              <a href="javascript:void(0);">
                Cubierta
                <span><?php echo ($propiedad->superficie_cubierta != 0) ? $propiedad->superficie_cubierta : " " ?></span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                Descubierta
                <span><?php echo ($propiedad->superficie_descubierta != 0) ? $propiedad->superficie_descubierta : " " ?></span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                Semicubierta
                <span><?php echo ($propiedad->superficie_semicubierta != 0) ? $propiedad->superficie_semicubierta : " " ?></span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                Total
                <span><?php echo ($propiedad->superficie_total != 0) ? $propiedad->superficie_total : " " ?></span>
              </a>
            </li>
          </ul>
        </div>
      <?php } ?>
      <?php print_r($propiedad) ?>
      <div class="description-content second-1">
        <h4>AMBIENTES</h4>
        <ul>
          <li>
            <a href="javascript:void(0);">
              <?php echo $propiedad->dormitorios ?  "Dormitorios <br>" : "" ?>
              <?php echo ($propiedad->living_comedor == 1)  ? "Living Comedor <br>" : " " ?>
              <?php echo ($propiedad->gimnasio == 1)  ? "Gimnasio <br>" : " " ?>
              <?php echo ($propiedad->vigilancia == 1)  ? "Vigilancia <br>" : " " ?>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <?php echo ($propiedad->banios == 1)  ? "Baño <br>" : " " ?>
              <?php echo ($propiedad->accesible == 1)  ? "Baño Accesible <br>" : " " ?>
              <?php echo ($propiedad->cocheras == 1)  ? "Cocheras <br>" : " " ?>
              <?php echo ($propiedad->piscina == 1)  ? "Piscina <br>" : " " ?>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <?php echo ($propiedad->patio == 1)  ? "Patio <br>" : " " ?>
              <?php echo ($propiedad->balcon == 1)  ? "Balcón <br>" : " " ?>
              <?php echo ($propiedad->parrilla == 1)  ? "Parrilla <br>" : " " ?>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <?php echo ($propiedad->terraza == 1)  ? "Terraza <br>" : " " ?>
              <?php echo ($propiedad->lavadero == 1)  ? "Lavadero" : " " ?>
              <?php echo ($propiedad->sala_juegos == 1)  ? "Sala de Juegos" : " " ?>
            </a>
          </li>
        </ul>
      </div>
      <div class="description-content second">
        <h4>ADICIONALES</h4>
        <ul>
          <li>
            <a href="javascript:void(0);">
              Apto Crédito <span><?php echo $propiedad->apto_banco == 0 ? 'No' : 'Sí' ?></span>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              Permuta <span><?php echo $propiedad->acepta_permuta == 0 ? 'No' : 'Sí' ?></span>
            </a>
          </li>
          <?php if ($propiedad->valor_expensas != 0) { ?>
            <li><a href="javascript:void(0);">Expensas <span>$<?php echo $propiedad->valor_expensas ?></span></a></li>
          <?php } else { ?>
            <li><a href="javascript:void(0);">Expensas <span>$<?php echo " " ?></span></a></li>
          <?php } ?>
        </ul>
      </div>
      <div class="description-content second-3">
        <h4>reporte</h4>
        <ul>
          <?php if ($propiedad->precio_porcentaje_anterior < 0.00 && $propiedad->publica_precio == 1) { ?>
            <li>
              <a href="javascript:void(0);" class="lite">
                <img src="assets/images/icons/icon-22.png">
                Bajo de precio un <?php echo floatval($propiedad->precio_porcentaje_anterior * -1) ?>%
              </a>
            </li>
          <?php } ?>
          <li>
            <?php
            $actual = new DateTime();
            $propiedad_fecha = new DateTime($propiedad->fecha_ingreso);
            $intvl = $actual->diff($propiedad_fecha);
            ?>
            <a href="javascript:void(0);">Publicado hace <span><?php echo $intvl->days ?></span> días</a>
          </li>

          <?php if ($propiedad->total_visitas > 0) { ?>
            <li>
              <a href="javascript:void(0);">
                <img src="assets/images/icons/icon-23.png">
                <span><?php echo $propiedad->total_visitas ?></span>
                personas vieron esta propiedad en los últimos 30 días
              </a>
            </li>
          <?php } ?>

        </ul>
      </div>
    </div>
  </section>

  <?php
  $contacto_whatsapp = preg_replace("/[^0-9]/", "", $usuario->telefono);
  include 'includes/contacto.php'; ?>

  <?php include 'includes/footer.php' ?>

  <?php include_once("templates/comun/mapa_js.php"); ?>

  <script>
    $(document).ready(function() {
      <?php if (!empty($propiedad->latitud) && !empty($propiedad->longitud)) { ?>

        /* if ($("#map").length == 0) return; */
        var mymap = L.map('map').setView([<?php echo $propiedad->latitud ?>, <?php echo $propiedad->longitud ?>], 16);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
          attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
          tileSize: 512,
          maxZoom: 18,
          zoomOffset: -1,
          id: 'mapbox/streets-v11',
          accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
        }).addTo(mymap);


        var icono = L.icon({
          iconUrl: 'assets/images/map-place.png',
          iconSize: [60, 60], // size of the icon
          iconAnchor: [30, 30], // point of the icon which will correspond to marker's location
        });

        L.marker([<?php echo $propiedad->latitud ?>, <?php echo $propiedad->longitud ?>], {
          icon: icono
        }).addTo(mymap);

      <?php } ?>
    });
  </script>

  <?php
  // Creamos el codigo de seguimiento para registrar la visita
  echo $propiedad_model->tracking_code(array(
    "id_propiedad" => $propiedad->id,
    "id_empresa_compartida" => $id_empresa,
    "id_empresa" => $empresa->id,
  ));
  ?>

  <script type="text/javascript">
    $(".fancybox").fancybox();

    let services = document.querySelector(".description-content");
    let ul = document.querySelector("ul");
    if (ul.children.length === 0) {
      services.style.display = "none";
    }
  </script>

</body>

</html>