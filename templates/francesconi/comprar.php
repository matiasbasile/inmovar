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
  <?php $propiedades = $propiedad_model->get_list(array(
    "order_by" => 1,

  )) ?>
  <?php print_r($propiedades) ?>
  <section class="equipo-banner">
    <div class="container">
      <div class="equipo-content">
        <h1 class="banner-title">comprar</h1>
      </div>
    </div>
  </section>

  <!-- Equipo Mis -->
  <section class="equipo-mis">
    <div class="container">
      <div class="mis-content">
        <h2 class="small-title">PROPIEDADES EN VENTA <span>200 Resultados de búsqueda</span></h2>
      </div>
      <div class="comprar-inner">
        <div class="row">
          <div class="col-lg-2">
            <div class="select-inner">
              <select id="country" class="round" name="venta">
                <option value="australia">venta</option>
                <option value="canada">venta</option>
                <option value="usa">venta</option>
              </select>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="select-inner">
              <select id="country" class="round" name="tipo de propiedad">
                <option value="australia">tipo de propiedad</option>
                <option value="canada">tipo de propiedad</option>
                <option value="usa">tipo de propiedad</option>
              </select>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="select-inner">
              <select id="country" class="round" name="habitaciones">
                <option value="australia">habitaciones</option>
                <option value="canada">habitaciones</option>
                <option value="usa">habitaciones</option>
              </select>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="select-inner">
              <select id="country" class="round" name="baños">
                <option value="australia">baños</option>
                <option value="canada">baños</option>
                <option value="usa">baños</option>
              </select>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="select-inner">
              <select id="country" class="round" name="precio">
                <option value="australia">precio</option>
                <option value="canada">precio</option>
                <option value="usa">precio</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="comprar-info">
        <div class="row align-items-center">
          <div class="col-lg-4">
            <div class="select-inner">
              <select id="country" class="round" name="precio de menor a mayor">
                <option value="australia">precio de menor a mayor</option>
                <option value="canada">precio de menor a mayor</option>
                <option value="usa">precio de menor a mayor</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="check-inner">
              <div class="check-form">
                <div class="custom-control custom-checkbox custom-checkbox-green">
                  <input type="checkbox" class="custom-control-input custom-control-input-green" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1">Apto Crédito</label>
                </div>
              </div>
              <div class="check-form">
                <div class="custom-control custom-checkbox custom-checkbox-green">
                  <input type="checkbox" class="custom-control-input custom-control-input-green" id="customCheck2">
                  <label class="custom-control-label" for="customCheck2">Apto Crédito</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="comprar-btns">
              <a href="#0" class="border-btn">ver en mapa</a>
              <a href="#0" class="fill-btn">buscar</a>
            </div>
          </div>
        </div>
        <div class="mis-inner">
          <div class="row">
            <?php foreach ($propiedades as $p) { ?>
              <div class="col-lg-4 col-md-6">
                <div class="noved-card">
                  <div class="noved-warp">
                    <span><img src="assets/images/icons/icon-15.png" alt="Icon"></span>
                    <a href="#0" class="fill-btn">solidarias</a>
                    <img src="assets/images/mis-1.png" alt="Noved">
                  </div>
                  <div class="noved-inner">
                    <h2 class="color-title"><?php echo $p->precio ?></h2>
                    <p><?php echo $p->nombre ?></p>
                    <h5><?php echo $p->direccion_completa ?></h5>
                    <div class="mis-link">
                      <ul>
                        <li><?php echo $p->superficie_total ?> m2</li>
                        <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-16.png" alt="Icon"><?php echo $p->dormitorios ?></a></li>
                        <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-17.png" alt="Icon"><?php echo $p->banios ?></a></li>
                        <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-18.png" alt="Icon"><?php echo $p->cocheras ?></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <a href="#0" class="fill-btn">ver más propiedades</a>
    </div>
  </section>

  <!-- Francesconi Nuster -->
  <?php include 'includes/home/secondary_slider.php' ?>

  <!-- Francesconi Footer -->
  <?php include 'includes/footer.php' ?>

</body>

</html>