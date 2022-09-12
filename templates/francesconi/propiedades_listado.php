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
  <?php include 'includes/headerequipo.php' ?>

  <!-- Equipo Banner -->
  <section class="equipo-banner">
    <div class="container">
      <div class="equipo-content">
        <?php if ($vc_listado[0]->id_tipo_operacion == 1) { ?>
          <h1 class="banner-title">comprar</h1>
        <?php } else { ?>
          <h1 class="banner-title">alquilar</h1>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- Equipo Mis -->
  <section class="equipo-mis">
    <form id="form_buscador" onsubmit="return filtrar(this)" method="get">
      <div class="container">
        <div class="mis-content">
          <h2 class="small-title">PROPIEDADES EN <?php echo $vc_listado[0]->tipo_operacion ?> <span><?php echo $vc_total_resultados ?> Resultados de búsqueda</span></h2>
        </div>
        <?php include 'includes/propiedad/filtros.php' ?>
        <div class="comprar-info">
          <div class="row align-items-center">
            <div class="col-lg-4">
              <?php
              // Si estoy en un link especial de grupo urbano, llamamos a otra funcion
              if (isset($config_grupo)) {
                $funcion = "order_solo()";
              } else {
                $funcion = "cambiar_checkboxes(this)";
              }
              ?>
              <div class="select-inner">
                <select onchange="<?php echo $funcion ?>" id="country" class="round" name="precio de menor a mayor">
                  <option <?php echo ($vc_orden == 2) ? "selected" : "" ?>>precio de menor a mayor</option>
                  <option <?php echo ($vc_orden == 1) ? "selected" : "" ?>>precio de mayor a menor</option>
                </select>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="check-inner">
                <div class="check-form">
                  <div class="custom-control custom-checkbox custom-checkbox-green">
                    <input onchange="<?php echo $funcion ?>" type="checkbox" class="custom-control-input custom-control-input-green" id="customCheck1" <?php echo ($vc_listado[0]->apto_banco == 1) ? "checked" : "" ?> name="banco" value="1">
                    <label class="custom-control-label" for="customCheck1">Apto Crédito</label>
                  </div>
                </div>
                <div class="check-form">
                  <div class="custom-control custom-checkbox custom-checkbox-green">
                    <input onchange="<?php echo $funcion ?>" type="checkbox" class="custom-control-input custom-control-input-green" id="customCheck2" <?php echo ($vc_listado[0]->acepta_permuta == 1) ?> name="per" value="1">
                    <label class="custom-control-label" for="customCheck2">Acepta Permuta</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="comprar-btns">
                <a href="#0" class="border-btn">ver en mapa</a>
                <button type="submit" class="fill-btn">buscar</button>
              </div>
            </div>
          </div>
          <div class="mis-inner">
            <div class="row">
              <?php foreach ($vc_listado as $p) { ?>
                <div class="col-lg-4 col-md-6">
                  <div class="noved-card">
                    <div class="noved-warp">
                      <span>
                        <a href="<?php echo $p->link_propiedad ?>">
                          <img src="assets/images/icons/icon-15.png" alt="Icon">
                        </a>
                      </span>
                      <a href="#0" class="fill-btn">solidarias</a>
                      <a href="<?php echo $p->link_propiedad ?>">
                        <img src="<?php echo $p->imagen ?>" alt="<?php echo $p->nombre ?>">
                      </a>
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
    </form>
  </section>

  <!-- Francesconi Nuster -->
  <?php include 'includes/home/secondary_slider.php' ?>

  <!-- Francesconi Footer -->
  <?php include 'includes/footer.php' ?>

</body>

</html>