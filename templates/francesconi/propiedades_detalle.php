<?php include 'includes/init.php' ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
  <?php include 'includes/head.php' ?>
</head>

<body>

  <!-- Francesconi Header Equipo -->
  <?php include 'includes/header.php' ?>

  <!-- Map Section -->
  <?php
  $propiedades = $propiedad_model->get($id, array(
    "id_empresa_original" => $empresa->id,
    "buscar_total_visitas" => 1,
  ));

  $propiedad = $propiedad_model->get($propiedades->id);
  print_r($propiedad);
  ?>
  <section class="map-section magnific-gallery">
    <div class="swiper-container map-slider">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <a href="assets/images/map-img-1.png"><img src="assets/images/map-img-1.png" alt="Gallery"></a>
        </div>
        <div class="swiper-slide">
          <a href="assets/images/map-img-2.png"><img src="assets/images/map-img-2.png" alt="Gallery"></a>
        </div>
        <div class="swiper-slide">
          <a href="assets/images/map-img-3.png"><img src="assets/images/map-img-3.png" alt="Gallery"></a>
        </div>
        <div class="swiper-slide">
          <a href="assets/images/map-img-1.png"><img src="assets/images/map-img-1.png" alt="Gallery"></a>
        </div>
        <div class="swiper-slide">
          <a href="assets/images/map-img-2.png"><img src="assets/images/map-img-2.png" alt="Gallery"></a>
        </div>
        <div class="swiper-slide">
          <a href="assets/images/map-img-3.png"><img src="assets/images/map-img-3.png" alt="Gallery"></a>
        </div>
      </div>
      <div class="swiper-pagination"></div>
      <!-- If we need navigation buttons -->
      <div class="swiper-button-prev swiper-button-white"></div>
      <div class="swiper-button-next swiper-button-white"></div>
    </div>
  </section>

  <!-- Map Ruta -->
  <section class="map-ruta">
    <div class="container">
      <div class="noved-inner">
        <h2 class="color-title"><?php echo $propiedad->precio ?></h2>
        <h3 class="small-title"><?php echo $propiedad->direccion ?> <span><?php echo $propiedad->nombre ?></span></h3>
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
            <div class="map-info">
              <img src="assets/images/map-img-4.png" alt="Map">
              <div class="map-content">
                <p>Vendedor asignado</p>
                <span>Juan Pedro Martinez</span>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="map-btn">
              <a href="#0" class="fill-btn"><img src="assets/images/icons/icon-7.png" alt="Icon">hablar ahora</a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="map-link">
              <p>Código: <span>7346-2293</span></p>
            </div>
          </div>
        </div>
      </div>
      <div class="description-content">
        <h4>DESCRIPCIÓN</h4>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
      </div>
      <div class="description-content frist">
        <h4>ubicación</h4>
        <p>Ruta 11 y 655 FINCAS LA SOÑADA</p>
      </div>
    </div>
  </section>

  <!-- Map Location -->
  <section class="map-location">
    <iframe data-aos="fade-up" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2822.7806761080233!2d-93.29138368446431!3d44.96844997909819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x52b32b6ee2c87c91%3A0xc20dff2748d2bd92!2sWalker+Art+Center!5e0!3m2!1sen!2sus!4v1514524647889" frameborder="0" style="border:0" allowfullscreen></iframe>
  </section>

  <!-- Map Services -->
  <section class="map-services">
    <div class="container">
      <div class="description-content">
        <h4>SERVICIOS</h4>
        <ul>
          <li><a href="#0">Electricidad Agua Corriente Cloacas Aire</a></li>
          <li><a href="#0">Gimnasio Parrilla PiscinaVigilancia</a></li>
          <li><a href="#0">Sala de Juegos Lavadero Living Comedor Terraza</a></li>
          <li><a href="#0">Accesible Balcon Patio</a></li>
        </ul>
      </div>
      <div class="description-content second">
        <h4>SUPERFICIES</h4>
        <ul>
          <li><a href="#0">Cubierta <span>285</span></a></li>
          <li><a href="#0">Descubierta <span>0</span></a></li>
          <li><a href="#0">Semicubierta <span>0</span></a></li>
          <li><a href="#0">Total <span>285</span></a></li>
        </ul>
      </div>
      <div class="description-content second">
        <h4>SUPERFICIES</h4>
        <ul>
          <li><a href="#0">Cubierta <span>285</span></a></li>
          <li><a href="#0">Descubierta <span>0</span></a></li>
          <li><a href="#0">Semicubierta <span>0</span></a></li>
          <li><a href="#0">Total <span>285</span></a></li>
        </ul>
      </div>
      <div class="description-content second-1">
        <h4>AMBIENTES</h4>
        <ul>
          <li><a href="#0">Dormitorio <br>Living Comedor</a></li>
          <li><a href="#0">Baño <br>Cochera</a></li>
          <li><a href="#0">Patio <br>Balcón</a></li>
          <li><a href="#0">Terraza</a></li>
        </ul>
      </div>
      <div class="description-content second">
        <h4>ADICIONALES</h4>
        <ul>
          <li><a href="#0">Apto Crédito <span>No</span></a></li>
          <li><a href="#0">Permuta <span>No</span></a></li>
          <li><a href="#0">Expensas <span>$3.500</span></a></li>
        </ul>
      </div>
      <div class="description-content second-3">
        <h4>reporte</h4>
        <ul>
          <li><a href="#0" class="lite"><img src="assets/images/icons/icon-22.png">Bajo de precio un 4.76%</a></li>
          <li><a href="#0">Publicado hace <span>115</span> días</a></li>
          <li><a href="#0"><img src="assets/images/icons/icon-23.png"><span>137</span>personas vieron esta propiedad en los últimos 30 días</a></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Ros Section -->
  <section class="ros-section map">
    <div class="container">
      <div class="ros-content">
        <h3 class="color-title">Fernando francesconi</h3>
        <h4 class="small-title">nosotros</h4>
      </div>
      <div class="ros-inner">
        <div class="row">
          <div class="col-lg-6">
            <input type="texe" name="Nombre" placeholder="Nombre *">
          </div>
          <div class="col-lg-6">
            <input type="texe" name="Nombre" placeholder="Email">
          </div>
          <div class="col-lg-6">
            <input type="texe" name="Nombre" placeholder="Whatsapp (sin 0 ni 15) *">
          </div>
          <div class="col-lg-6">
            <div class="select-inner">
              <select id="country" class="round" name="venta">
                <option value="australia">venta</option>
                <option value="canada">venta</option>
                <option value="usa">venta</option>
              </select>
            </div>
          </div>
          <div class="col-lg-12">
            <textarea type="texe" name="Nombre">Mensaje</textarea>
          </div>
        </div>
      </div>
      <div class="fill-btn-inner">
        <a href="#0" class="fill-btn">enviar consulta</a>
        <a href="#0" class="fill-btn light"><img src="assets/images/icons/icon-7.png" alt="Icon">enviar whatsapp</a>
      </div>
    </div>
  </section>

  <!-- Francesconi Footer -->
  <?php include 'includes/footer.php' ?>

</body>

</html>