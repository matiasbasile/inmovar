<?php include 'includes/init.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php' ?>
</head>

<body>

  <?php 
  $menu_active = "home";
  include 'includes/header.php' ?>

  <section class="top-banner">

    <?php include 'includes/home/slider.php' ?>
  
    <div class="banner-caption">

      <div class="container">

        <?php if (sizeof($slider)>0) { ?>
          <?php $s = $slider[0]; ?>
          <?php if (!empty($s->linea_1)) { ?>
            <h1><?php echo $s->linea_1 ?></h1>
          <?php } ?>
          <?php if (!empty($s->linea_2)) { ?>
            <h2><?php echo $s->linea_2 ?></h2>
          <?php } ?>
        <?php } ?>
                
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item active" role="presentation">
            <button class="nav-link" id="Comprar-tab" data-bs-toggle="tab" data-bs-target="#Comprar" type="button" role="tab" aria-controls="Comprar" aria-selected="true">Comprar</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="Alquilar-tab" data-bs-toggle="tab" data-bs-target="#Alquilar" type="button" role="tab" aria-controls="Alquilar" aria-selected="false">Alquilar</button>
          </li>
          <li class="nav-item" role="presentation">
            <a href="<?php echo mklink("propiedades/") ?>" class="nav-link" role="tab" aria-controls="Emprendimientos" aria-selected="false">Emprendimientos</a>
          </li>
          <li class="nav-item" role="presentation">
            <a href="<?php echo mklink("web/vender/") ?>" class="nav-link" role="tab" aria-controls="Vender" aria-selected="false">Vender</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

            <form id="form_buscador" onsubmit="return filtrar(this)" method="get">
              
              <input type="hidden" class="base_url" value="<?php echo mklink("propiedades/") ?>" />
              <input class="filter_tipo_operacion" type="hidden" value="ventas" />

              <input type="hidden" id="localidad_link_hidden" />
              <input type="hidden" id="localidad_id_hidden" />
              <input type="search" class="form-control localidad-select filter_localidad" id="filter_localidad" placeholder="Ingresá ubicación">

              <select id="filter_propiedad" class="form-select form-control filter_propiedad" name="tp">
                <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
                <?php foreach ($tipo_propiedades as $tipo) { ?>
                  <option value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
                <?php } ?>
              </select>

              <button type="submit" class="btn">Buscar</button>
            </form>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/home/destacadas.php' ?>

  <?php include 'includes/home/accesos.php' ?>

  <?php include 'includes/home/ultimas_noticias.php' ?>

  <?php include 'includes/footer.php' ?>

</body>

</html>