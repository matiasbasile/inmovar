<?php
include_once("includes/init.php");
$nombre_pagina = "home";
include_once("includes/funciones.php");
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">

<head>

  <head>
    <?php include("includes/head.php"); ?>
  </head>

<body>

  <?php include("includes/header.php"); ?>

  <!-- Banner Section -->
  <?php
  // SLIDER PRINCIPAL
  $slider = $web_model->get_slider();
  ?>
  <section class="banner">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <?php $c = 0; ?>
        <?php foreach ($slider as $r) { ?>
          <div class="carousel-item <?php echo ($c == 0 ? "active" : "") ?>" style="background: url(<?php echo $r->path ?>) no-repeat 50% 0; background-size: cover;"></div>
          <?php $c++; ?>
        <?php } ?>
        <ol class="carousel-indicators">
          <?php $c = 0; ?>
          <?php foreach ($slider as $i) { ?>
            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $c ?>" class="<?php echo ($c == 0 ? "active" : "") ?>"></li>
            <?php $c++; ?>
          <?php } ?>
        </ol>
      </div>
    </div>
    <div class="carousel-caption">
      <div class="container">
        <form onsubmit="return filtrar(this)" method="get">
          <select class="form-control filter_tipo_operacion">
            <option value="0">Operación</option>
            <?php $tipo_operaciones = $propiedad_model->get_tipos_operaciones(); ?>
            <?php foreach ($tipo_operaciones as $operaciones) { ?>
              <option value="<?php echo $operaciones->id ?>"><?php echo $operaciones->nombre ?></option>
            <?php } ?>
          </select>
          <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
          <select class="form-control filter_propiedad">
            <option value="0">Propiedad</option>
            <?php foreach ($tipo_propiedades as $tipo) { ?>
              <option value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
            <?php } ?>
          </select>
          <select class="form-control filter_localidad">
            <option value="0">Localidad</option>
            <?php $localidades = $propiedad_model->get_localidades(); ?>
            <?php foreach ($localidades as $localidad) { ?>
              <option value="<?php echo $localidad->id ?>"><?php echo $localidad->nombre ?></option>
            <?php } ?>
          </select>
          <button type="submit" class="btn btn-primary">BUSCAR</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Group Bertoia -->
  <section class="group-bertoia padding-default">
    <div class="container">
      <?php $t = $web_model->get_text("text1", "Grupo Urbano Bertoia Piñero"); ?>
      <h2 class="text-center editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?> </h2>
      <?php $t = $web_model->get_text("text2", "Somos la mejor opción para comprar o vender tu propiedad"); ?>
      <h5 class="text-center editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?> </h5>
      <div class="media mt-5">
        <?php $t = $web_model->get_text("icon-1-img", "assets/images/icon01.png"); ?>
        <img class="mr-4 editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
        <div class="media-body">
          <?php $t = $web_model->get_text("text3", "Quiero Comprar"); ?>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h4>

          <?php $t = $web_model->get_text("text4", "Te ofrecemos la cartera de propiedades más grande de la ciudad para que puedas elegir entre más de 10 mil propiedades en venta en zona."); ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></p>

          <?php $t = $web_model->get_text("text5", "comenzar"); ?>
          <a href="#0" class="btn btn-outline-primary editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?> <i class="fa fa-chevron-right ml-3"></i></a>
        </div>
      </div>
      <div class="media mt-5">
        <?php $t = $web_model->get_text("icon-2-img", "assets/images/icon02.png"); ?>
        <img class="mr-4 editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
        <div class="media-body">
          <?php $t = $web_model->get_text("text6", "Quiero Vender"); ?>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h4>

          <?php $t = $web_model->get_text("text7", "Te ayudamos a vender tu propiedad más rápido generando contenido de calidad y promocionando en los portales y redes más populares."); ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></p>

          <?php $t = $web_model->get_text("text8", "comenzar"); ?>
          <a href="#0" class="btn btn-outline-primary editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?> <i class="fa fa-chevron-right ml-3"></i></a>
        </div>
      </div>
    </div>
  </section>

  <!-- Search by Zone -->
  <section class="search-zone">
    <div class="row m-0">
      <div class="col-md-12 text-center">
        <?php $t = $web_model->get_text("text9", "Buscá por Zona"); ?>
        <h2 class="d-block editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h2>

        <?php $t = $web_model->get_text("text10", "Estas son algunas de las zonas más destacadas en La Plata"); ?>
        <h5 class="mb-4 editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h5>
      </div>
      <div class="col-md-3 p-0">
        <div class="img-block">
          <?php $t = $web_model->get_text("zona-1-img", "assets/images/zone01.jpg"); ?>
          <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
          <div class="zone-info">
            <?php $t = $web_model->get_text("zona-1-link", "La Plata"); ?>
            <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h4>
            <a href="<?php echo $t->link ?>" class="btn btn-white">Ver Propiedades</a>
          </div>
        </div>
      </div>
      <div class="col-md-3 p-0">
        <div class="img-block">
          <?php $t = $web_model->get_text("zona-2-img", "assets/images/zone02.jpg"); ?>
          <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
          <div class="zone-info">
            <?php $t = $web_model->get_text("zona-2-link", "Gonnet"); ?>
            <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>"><?php echo $t->plain_text ?></h4>
            <a href="<?php echo $t->link ?>" class="btn btn-white">Ver Propiedades</a>
          </div>
        </div>
      </div>
      <div class="col-md-3 p-0">
        <div class="img-block">
          <?php $t = $web_model->get_text("zona-3-img", "assets/images/zone03.jpg"); ?>
          <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
          <div class="zone-info">
            <?php $t = $web_model->get_text("zona-3-link", "City Bell"); ?>
            <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h4>
            <a href="<?php echo $t->link ?>" class="btn btn-white">Ver Propiedades</a>
          </div>
        </div>
      </div>
      <div class="col-md-3 p-0">
        <div class="img-block">
          <?php $t = $web_model->get_text("zona-4-img", "assets/images/zone04.jpg"); ?>
          <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
          <div class="zone-info">
            <?php $t = $web_model->get_text("zona-4-link", "Costa Atlántica"); ?>
            <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h4>
            <a href="<?php echo $t->link ?>" class="btn btn-white">Ver Propiedades</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Search According -->
  <section class="group-bertoia padding-default d-block">
    <div class="container">
      <?php $t = $web_model->get_text("text11", "Buscá Según Tu Momento"); ?>
      <h2 class="text-center editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h2>

      <?php $t = $web_model->get_text("text12", "Queres mudarte con tu familia a una nueva casa, estas por empezar a construir y necesitas un terreno o<br class='d-md-block d-none'> búscas comprar un departamento para estudiar? Tenemos las mejores opciones para ofrecerte:"); ?>
      <h5 class="text-center editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h5>
    </div>
    <div class="row m-0 mt-5">
      <?php $categorias = $web_model->get_main_categories(array("offset" => 8, "limit" => 0));
      foreach ($categorias as $cat) {
        $categori = $web_model->get_categoria($cat->id); ?>
        <div class="col-md-3 p-0 search-moment-list">
          <div class="search-moment">
            <span class="moment-icon" style="background:url(<?php echo $categori->path ?>)no-repeat 50% 0"></span>
            <a href="<?php echo $categori->external_link ?>" class="btn btn-outline-primary stretched-link"><?php echo $categori->nombre ?></a>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- Neighborhoods -->
  <?php $countries_destacadas = $propiedad_model->get_list(array("id_tipo_inmueble" => 4, "offset" => 3, "limit" => 0, "destacado" =>  1)); ?>
  <?php if (!empty($countries_destacadas)) { ?>
    <section class="neighborhoods padding-default">
      <div class="container text-center">
        <?php $t = $web_model->get_text("text13", "Especial Countries y Barrios Cerrados"); ?>
        <h2 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h2>

        <?php $t = $web_model->get_text("text14", "Disfrutá de la seguridad y privacidad de vivir en un barrio cerrado y/o controlado."); ?>
        <h5 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h5>
      </div>
      <div class="row m-0 mt-5 pad-lr-50">
        <?php foreach ($countries_destacadas as $destacadas) { ?>
          <div class="col-md-4 p-0 neighborhoods-list">
            <a href="<?php echo mklink($destacadas->link) ?>">
              <div class="img-block">
                <img src="<?php echo $destacadas->imagen ?> " alt="img">
                <div class="neighborhoods-top">
                  <?php if (!empty($destacadas->direccion_completa)) { ?>
                    <p><?php echo $destacadas->direccion_completa ?></p>
                  <?php } ?>
                  <h4><?php echo $destacadas->precio ?></h4>
                </div>
                <div class="neighborhoods-bottom">
                  <?php if ($destacadas->ambientes != 0) { ?>
                    <div class="neighborhoods-info">
                      <h6><?php echo $destacadas->ambientes ?> Hab.</h6>
                      <img src="assets/images/icon11.png" alt="img">
                    </div>
                  <?php } ?>
                  <?php if ($destacadas->ambientes != 0) { ?>
                    <div class="neighborhoods-info">
                      <h6><?php echo $destacadas->ambientes ?> Baños</h6>
                      <img src="assets/images/icon12.png" alt="img">
                    </div>
                  <?php } ?>
                  <?php if ($destacadas->cocheras != 0) { ?>
                    <div class="neighborhoods-info">
                      <h6><?php echo $destacadas->cocheras ?> Auto</h6>
                      <img src="assets/images/icon13.png" alt="img">
                    </div>
                  <?php } ?>
                  <?php if ($destacadas->superficie_total != 0) { ?>
                    <div class="neighborhoods-info">
                      <h6><?php echo $destacadas->superficie_total ?> m2</h6>
                      <img src="assets/images/icon14.png" alt="img">
                    </div>
                  <?php } ?>
                </div>
              </div>
            </a>
          </div>
        <?php } ?>
      </div>
      <div class="d-md-block mt-5 text-center">
        <a href="<?php echo mklink("propiedades/ventas/?tp=4") ?>" class="btn btn-outline-secondary">ver todos <i class="fa fa-chevron-right ml-3"></i></a>
      </div>
    </section>
  <?php } ?>

  <?php
  $obras = $propiedad_model->get_list(array("id_tipo_operacion" => 5, "limit" => 0, "offset" => 4, "destacado" => 1));
  ?>
  <!-- Work -->
  <?php if (!empty($obras)) { ?>
    <section class="padding-default works">
      <div class="container text-center">
        <?php $t = $web_model->get_text("text15", "Especial Obras en Construcción"); ?>
        <h2 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h2>

        <?php $t = $web_model->get_text("text16", "Disfrutá de la seguridad y privacidad de vivir en un barrio cerrado y/o controlado."); ?>
        <h5 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h5>
      </div>
      <div class="row m-0 mt-5 pad-lr-50">
        <?php foreach ($obras as $countri) { ?>
          <div class="col-md-3 work-list">
            <div class="img-block">
              <a href="<?php echo mklink($countri->link) ?>" class="stretched-link"><img src="<?php echo $countri->imagen; ?>"></a>
              <div class="work-tags"><?php echo $countri->tipo_inmueble ?></div>
              <div class="work-price"><?php echo $countri->precio ?></div>
            </div>
            <div class="work-info">
              <h6>
                <?php echo ($countri->dormitorios != 0 ? "<span>" . $countri->dormitorios . " Hab </span>" : "") ?>
                <?php echo ($countri->cocheras != 0 ? "<span>" . $countri->cocheras . " Cochera </span>" : "") ?>
                <?php echo ($countri->superficie_total != 0 ? "<span>" . $countri->superficie_total . " m2 </span>" : "") ?>
              </h6>
              <p><?php echo $countri->direccion_completa ?></p>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="d-md-block mt-5 text-center">
        <a href="<?php echo mklink("propiedades/obras/") ?>" class="btn btn-outline-secondary">ver todos <i class="fa fa-chevron-right ml-3"></i></a>
      </div>
    </section>
  <?php } ?>

  <!-- Sponsars -->
  <?php $marcas = $articulo_model->get_marcas(array("grupo" => 1)) ?>
  <?php if (!empty($marcas)) { ?>
    <section class="sponsars padding-default">
      <div class="container">
        <div class="owl-carousel" data-items="5" data-margin="30" data-loop="false" data-nav="true" data-dots="false">
          <?php foreach ($marcas as $m) {  ?>
            <div class="item">
              <div class="logo-box">
                <img src="<?php echo $m->path ?>">
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </section>
  <?php } ?>

  <!-- Footer -->
  <?php include("includes/footer.php"); ?>
</body>

</html>