<?php include 'includes/init.php' ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
  <?php include 'includes/head.php' ?>
</head>

<body>

  <?php
  $propiedades = $propiedad_model->get($id, array(
    "id_empresa_original" => $empresa->id,
    "buscar_total_visitas" => 1,
  ));

  $propiedad = $propiedad_model->get($propiedades->id);
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
  ?>

  <?php include 'includes/header.php' ?>

  <?php if (sizeof($propiedad->images) > 0) { ?>
    <section class="map-section magnific-gallery">
      <div class="swiper-container map-slider">
        <div class="swiper-wrapper">
          <?php foreach ($propiedad->images as $img) { ?>
            <div class="swiper-slide">
              <a href="<?php echo $img ?>"><img src="<?php echo $img ?>" alt="Gallery"></a>
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
            <li><?php echo $propiedad->superficie_total ?> m2</li>
            <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-16.png" alt="Icon"><?php echo $propiedad->dormitorios ?></a></li>
            <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-17.png" alt="Icon"><?php echo $propiedad->banios ?></a></li>
            <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-18.png" alt="Icon"><?php echo $propiedad->cocheras ?></a></li>
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
      <div class="description-content">
        <h4>DESCRIPCIÓN</h4>
        <?php echo $propiedad->texto ?>
      </div>
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
            <a href="javascript:void(0);"><?php echo $propiedad->servicios_electricidad == 1 ? 'Electricidad' : '' ?> <?php echo $propiedad->servicios_agua_corriente == 1 ? 'Agua Corriente' : '' ?> <?php echo $propiedad->servicios_cloacas == 1 ? 'Cloacas' : '' ?> <?php echo $propiedad->servicios_aire_acondicionado == 1 ? 'Aire' : '' ?></a>
          </li>
          <li><a href="javascript:void(0);"><?php echo $propiedad->gimnasio == 1 ? 'Gimnasio' : '' ?> <?php echo $propiedad->parrilla == 1 ? 'Parrilla' : '' ?> <?php echo $propiedad->piscina == 1 ? 'Piscina' : '' ?> <?php echo $propiedad->vigilancia == 1 ? 'vigilancia' : '' ?></a></li>
          <li><a href="javascript:void(0);"><?php echo $propiedad->sala_juegos == 1 ? 'Sala de Juegos' : '' ?> <?php echo $propiedad->lavadero == 1 ? 'Lavadero' : '' ?> <?php echo $propiedad->living_comedor == 1 ? 'Living Comedor' : '' ?> <?php echo $propiedad->terraza == 1 ? 'Terraza' : '' ?></a></li>
          <li><a href="javascript:void(0);"><?php echo $propiedad->accesible == 1 ? 'Accesible' : '' ?> <?php echo $propiedad->balcon == 1 ? 'Balcón' : '' ?> <?php echo $propiedad->patio == 1 ? 'Patio' : '' ?></a></li>
        </ul>
      </div>
      <div class="description-content second">
        <h4>SUPERFICIES</h4>
        <ul>
          <li><a href="javascript:void(0);">Cubierta <span><?php echo $propiedad->superficie_cubierta ?></span></a></li>
          <li><a href="javascript:void(0);">Descubierta <span><?php echo $propiedad->superficie_descubierta ?></span></a></li>
          <li><a href="javascript:void(0);">Semicubierta <span><?php echo $propiedad->superficie_semicubierta ?></span></a></li>
          <li><a href="javascript:void(0);">Total <span><?php echo $propiedad->superficie_total ?></span></a></li>
        </ul>
      </div>
      <div class="description-content second-1">
        <h4>AMBIENTES</h4>
        <ul>
          <li><a href="javascript:void(0);">Dormitorio <?php echo $propiedad->dormitorios ?> <br>Living Comedor <?php echo $propiedad->living_comedor ?></a></li>
          <li><a href="javascript:void(0);">Baño <?php echo $propiedad->banios ?> <br>Cochera <?php echo $propiedad->cocheras ?></a></li>
          <li><a href="javascript:void(0);">Patio <?php echo $propiedad->patio ?> <br>Balcón <?php echo $propiedad->balcon ?></a></li>
          <li><a href="javascript:void(0);">Terraza <?php echo $propiedad->terraza ?></a></li>
        </ul>
      </div>
      <div class="description-content second">
        <h4>ADICIONALES</h4>
        <ul>
          <li><a href="javascript:void(0);">Apto Crédito <span><?php echo $propiedad->apto_banco == 0 ? 'No' : 'Sí' ?></span></a></li>
          <li><a href="javascript:void(0);">Permuta <span><?php echo $propiedad->acepta_permuta == 0 ? 'No' : 'Sí' ?></span></a></li>
          <li><a href="javascript:void(0);">Expensas <span>$<?php echo $propiedad->valor_expensas ?></span></a></li>
        </ul>
      </div>
      <div class="description-content second-3">
        <h4>reporte</h4>
        <ul>
          <li><a href="javascript:void(0);" class="lite"><img src="assets/images/icons/icon-22.png">Bajo de precio un 4.76%</a></li>
          <li>
            <?php
            $actual = new DateTime();
            $propiedad_fecha = new DateTime($propiedad->fecha_ingreso);
            $intvl = $actual->diff($propiedad_fecha);
            ?>
            <a href="javascript:void(0);">Publicado hace <span><?php echo $intvl->days ?></span> días</a>
          </li>
          <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-23.png"><span><?php echo $propiedad->total_visitas ?></span> personas vieron esta propiedad en los últimos 30 días</a></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Ros Section -->
  <section class="ros-section map">
    <form onsubmit="return enviar_contacto()">
      <div class="container">
        <div class="ros-content">
          <h3 class="color-title">Fernando francesconi</h3>
          <h4 class="small-title">nosotros</h4>
        </div>
        <div class="ros-inner">
          <div class="row">
            <div class="col-lg-6">
              <input type="text" name="Nombre" id="contacto_nombre" placeholder="Nombre *">
            </div>
            <div class="col-lg-6">
              <input type="email" name="Email" id="contacto_email" placeholder="Email">
            </div>
            <div class="col-lg-6">
              <input type="text" name="Telefono" id="contacto_telefono" placeholder="Whatsapp (sin 0 ni 15) *">
            </div>
            <div class="col-lg-6">
              <div class="select-inner">
                <select id="country" class="round" id="contacto_asunto" name="venta">
                  <option value="australia">venta</option>
                  <option value="canada">venta</option>
                  <option value="usa">venta</option>
                </select>
              </div>
            </div>
            <div class="col-lg-12">
              <textarea id="contacto_mensaje" name="Nombre">Mensaje</textarea>
            </div>
          </div>
        </div>
        <div class="fill-btn-inner">
          <button id="contacto_submit" class="fill-btn">enviar consulta</button>
          <a href="https://wa.me/<?php echo str_replace(' ', '', $usuario->telefono) ?>" target="_blank" class="fill-btn light"><img src="assets/images/icons/icon-7.png" alt="Icon">enviar whatsapp</a>
        </div>
      </div>
    </form>
  </section>

  <!-- Francesconi Footer -->
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

</body>

</html>