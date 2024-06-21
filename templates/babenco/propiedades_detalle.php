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
      <h3>Local en Venta en La Plata</h3>
      <small>Diag. 73 N° 2157 e/ 46 y 47, 2° F</small>
    </div>
    <div class="aminities">
      <ul>
        <li><img src="assets/images/featureicon1.png" alt="icon"><b>2</b></li>
        <li><img src="assets/images/featureicon2.png" alt="icon"><b>1</b></li>
        <li><img src="assets/images/featureicon3.png" alt="icon"><b>1</b></li>
        <li><img src="assets/images/featureicon4.png" alt="icon">Cub: <b>40 m2</b></li>
        <li class="semi">Semi: <b>20 m2</b></li>
        <li class="semi">Total: <b>60 m2</b></li>
      </ul>
    </div>
    <div class="slider">
      <p>Código: <strong>8342-4346</strong></p>
      <ul class="nav nav-tabs">
        <li class="nav-item" role="presentation">
          <a href="assets/images/premises-sale-slider-img.jpg" class="nav-link active" data-fancybox="gallery"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
            <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
            <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
          </svg></a>
        </li>
        <li class="nav-item" role="presentation">
          <a href="#video-box" class="nav-link">  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-video-fill" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2V5z"/>
          </svg></a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active">  
          <div class="owl-carousel owl-theme" data-outoplay="true" data-items="1" data-nav="true" data-dots="false">
          <div class="item">
            <a href="#0" data-fancybox="gallery" data-src="assets/images/premises-sale-slider-img.jpg">
              <img src="assets/images/premises-sale-slider-img.jpg" alt="img">
            </a>
          </div>
          <div class="item">
            <a href="#0" data-fancybox="gallery" data-src="assets/images/premises-sale-slider-img.jpg">
              <img src="assets/images/premises-sale-slider-img.jpg" alt="img">
            </a>
          </div>
        </div></div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="owl-carousel owl-theme" data-outoplay="true" data-items="1" data-nav="true" data-dots="false">
            <div class="item">
              <video controls autoplay muted>
                <source src="assets/images/44624728_business-people-at-a-coffee-break_by_blackboxguild_preview.mp4" type="video/mp4">
              </video>
            </div>
            <div class="item">
              <video controls autoplay muted>
                <source src="assets/images/44712963_business-people-create-new-strategy-_by_megafilm_preview(1).mp4" type="video/mp4">
              </video>
            </div>
            <div class="item">
              <video controls autoplay muted>
                <source src="assets/images/44877477_teamwork-of-business-people-in-office_by_megafilm_preview.mp4" type="video/mp4">
              </video>
            </div>
            <div class="item">
              <video controls autoplay muted>
                <source src="assets/images/44965396_group-of-business-people-working-in-office_by_zoranzeremski_preview.mp4" type="video/mp4">
              </video>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="expenses-info">
      <div class="expenses">
        <div class="doller">
          <h6>$</h6>
        </div>
        <div class="right-title">
          <span><img src="assets/images/down-arrow.svg" alt="Arrow"> Bajo de precio un 11.33%</span>
          <h5>U$S 42.000</h5>
          <small>+ $2.500 Expensas</small>
        </div>
      </div>
      <div class="play-btn">
        <img src="assets/images/right-arrow.svg" alt="Arrow">
      </div>
    </div>
    <div class="section-title">
      <h3>Descripción</h3>
    </div>
    <div class="title">
      <p>Diagonal 73 e/ 46 y 47. Se encuentra emplazado a 2 cuadras de Avenida 44 y a 3 cuadras de Plaza Azcuenaga. Se encuentra ubicado en el segundo piso al contrafrente. Posee living con balcón, puerta balcón con rejas, cocina separada con muebles bajo y sobre mesada, conexión para lavarropa y doble mesada, ventilación natural y calefón marca "Tartaglia", dormitorio con tiro balanceado.</p>
    </div>
    <div class="section-title">
      <h3>Donde se encuentra</h3>
    </div>
    <div class="title">
      <p>65 e/ 26 y 27 Piso 1 Depto. C. La Plata</p>
    </div>
    <div class="map-block">
      <div id="map"></div>
    </div>
    <div class="section-title">
      <h3>Más información</h3>
    </div>
    <h4>características</h4>
    <div class="row">
      <div class="col-md-4">
        <div class="listing">
          <ul>
            <li>Sup. Total: <span>41 m2 </span></li>
            <li>Código: <span>PAP1613669</span></li>
            <li>Tipo: <span>Departamento</span></li>
            <li>Dormitorios: <span>1</span></li>
          </ul>
        </div>
      </div> 
      <div class="col-md-4">
        <div class="listing">
          <ul>
            <li>Antigüedad: <span>A estrenar</span></li>
            <li>Baños: <span>1</span></li>
            <li>Sup. Cubierta: <span>38 m2</span></li>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="listing">
          <ul>
            <li>Estado: <span> Muy Bueno</span></li>
            <li>Sup. Semicubierta: <span>3 m2</span></li>
            <li>Ambientes: <span>2</span></li>
          </ul>
      </div>
    </div>
      </div>
      <div class="checklist">
        <h4>servicios</h4>
         <ul>
           <li>Agua Corriente</li>
           <li>Desagüe Cloacal</li>
           <li>Gas Natural</li>
           <li>Luz</li>
           <li>Pavimento</li>
           <li>Alumbrado público</li>
         </ul>
      </div>
      <div class="checklist">
        <h4>ambientes</h4>
         <ul>
           <li>Balcón</li>
           <li>Living comedor</li>
         </ul>
      </div>
      <div class="checklist comodi">
        <h4>Comodidades</h4>
         <ul>
           <li>Calefón</li>
           <li>Estufas TB</li>
           <li>Alumbrado Público</li>
         </ul>
      </div>
      <h4>adicionales</h4>
        <div class="row">
          <div class="col-sm-4">
            <div class="listing">
              <ul>
                <li>Acepta Permuta: <small>Sí </small></li>
              </ul>
            </div>
          </div> 
          <div class="col-sm-4">
            <div class="listing">
              <ul>
                <li>Apto Crédito: <small>No</small></li>
              </ul>
            </div>
          </div>
          </div>
          <div class="section-title pt-4">
            <h3>video</h3>
          </div>
          <div class="video-box" id="video-box">
            <div class="video-block">
              <iframe src="https://www.youtube.com/embed/FJ3Nlxj09pM?start=4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            <p><span>Nota importante:</span>Toda la información y medidas provistas son aproximadas y deberán ratificarse con la documentación pertinente y no compromete contractualmente a nuestra empresa. </p>
          </div>
        </div>
        <div class="col-xl-4">
        <div class="expenses-info">
          <div class="expenses">
            <div class="doller">
              <img src="assets/images/home.png" alt="Home">
            </div>
            <div class="right-title">
              <span>Bajo de precio un 11.33% <img src="assets/images/down-arrow.svg" alt="Arrow"></span>
              <h5>U$S 42.000</h5>
              <small>+ $2.500 Expensas</small>
            </div>
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
          <form>
            <div class="row">
              <div class="col-md-12">
                <input type="text" name="Nombre" placeholder="Nombre" class="form-control">
              </div>
              <div class="col-md-12">
                <input type="email" name="Email" placeholder="Email" class="form-control">
              </div>
              <div class="col-md-12">
                <input type="text" name="Whatsapp (sin 0 ni 15)" placeholder="Whatsapp (sin 0 ni 15)" class="form-control">
              </div>
              <div class="col-md-12">
                <textarea class="form-control" placeholder="Estoy interesado en Local en Venta en La Plata [COD: 8342-4346]"></textarea>
              </div>
              <div class="col-md-12">
                <button type="submit" class="btn"><svg fill="#000000" width="800px" height="800px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M11.42 9.49c-.19-.09-1.1-.54-1.27-.61s-.29-.09-.42.1-.48.6-.59.73-.21.14-.4 0a5.13 5.13 0 0 1-1.49-.92 5.25 5.25 0 0 1-1-1.29c-.11-.18 0-.28.08-.38s.18-.21.28-.32a1.39 1.39 0 0 0 .18-.31.38.38 0 0 0 0-.33c0-.09-.42-1-.58-1.37s-.3-.32-.41-.32h-.4a.72.72 0 0 0-.5.23 2.1 2.1 0 0 0-.65 1.55A3.59 3.59 0 0 0 5 8.2 8.32 8.32 0 0 0 8.19 11c.44.19.78.3 1.05.39a2.53 2.53 0 0 0 1.17.07 1.93 1.93 0 0 0 1.26-.88 1.67 1.67 0 0 0 .11-.88c-.05-.07-.17-.12-.36-.21z"></path><path d="M13.29 2.68A7.36 7.36 0 0 0 8 .5a7.44 7.44 0 0 0-6.41 11.15l-1 3.85 3.94-1a7.4 7.4 0 0 0 3.55.9H8a7.44 7.44 0 0 0 5.29-12.72zM8 14.12a6.12 6.12 0 0 1-3.15-.87l-.22-.13-2.34.61.62-2.28-.14-.23a6.18 6.18 0 0 1 9.6-7.65 6.12 6.12 0 0 1 1.81 4.37A6.19 6.19 0 0 1 8 14.12z"></path></svg> Enviar Whatsapp</button>
              </div>
            </div>
          </form>
        </div>
    </div>
  </div>
</section>

<?php include("includes/footer.php") ?>

<script type="text/javascript">
  // Fancybox Config
$('[data-fancybox="gallery"]').fancybox({
});
</script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script> <script type="text/javascript">
     $(document).ready(function(){

      var mymap = L.map('map').setView([-34.9185733,-57.9561478], 15);

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoidmNtYXBib3gxNCIsImEiOiJjbHVzZGpndTAwMXBmMnZwZHVzaHpwdnBkIn0.MNg411Qzoi2JfvKRn6qe2A', {
        attribution: '',
        tileSize: 512,
        maxZoom: 18,
        zoomOffset: -1,
        id: 'mapbox/streets-v11',
        accessToken: 'pk.eyJ1IjoidmNtYXBib3gxNCIsImEiOiJjbHVzZGpndTAwMXBmMnZwZHVzaHpwdnBkIn0.MNg411Qzoi2JfvKRn6qe2A',
      }).addTo(mymap);

      var icono = L.icon({
       iconUrl: 'assets/images/map-icon.png',
      });

      L.marker([-34.9185733,-57.9561478],{
       icon: icono
     }).addTo(mymap);
    });
  </script>
</body>
</html>