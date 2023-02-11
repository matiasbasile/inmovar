<?php include 'includes/init.php' ?>
<?php

if (!isset($config_grupo)) $config_grupo = array();
$config_grupo["orden_default"] = 8;

// Si tiene el flag de ofertas
if (isset($buscar_ofertas)) {
  $config_grupo["solo_propias"] = 1;
  $config_grupo["es_oferta"] = 1;
}

extract($propiedad_model->get_variables($config_grupo));
if (isset($get_params["test"])) echo $propiedad_model->get_sql();
$nombre_pagina = $vc_link_tipo_operacion;

?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
  <?php include 'includes/head.php' ?>
</head>

<body>

  <!-- Francesconi Header Equipo -->
  <?php include 'includes/header.php' ?>

  <!-- Equipo Banner -->
  <section class="equipo-banner">
    <div class="container">
      <div class="equipo-content">
        <h1 class="banner-title"><?php echo $vc_nombre_operacion ?></h1>
      </div>
    </div>
  </section>

  <!-- Equipo Mis -->
  <section class="equipo-mis">
    <div class="container">
      <div class="mis-content">
        <h2 class="small-title">
          PROPIEDADES EN <?php echo $vc_nombre_operacion ?> <span>
          <?php echo $vc_total_resultados ?> Resultados de búsqueda</span>
        </h2>
      </div>
      
      <?php include 'includes/propiedad/filtros.php' ?>
      
      <div class="comprar-info">
        <div class="mis-inner">
          <div class="row propiedades">
            <?php foreach ($vc_listado as $p) { ?>
              <?php item($p); ?>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php echo $vc_total_paginas ?>
      <div class="text-center <?php echo ($vc_total_paginas == 1) ? 'd-none' : '' ?>">
        <a onclick="cargar()" id="cargarMas" class="fill-btn">ver más propiedades</a>
      </div>
    </div>
  </section>

  <?php include 'includes/home/secondary_slider.php' ?>

  <?php include 'includes/footer.php' ?>

  <?php include 'includes/cargar_mas_js.php' ?>

</body>
</html>