<?php 
include 'includes/init.php';

if (!isset($config_grupo)) $config_grupo = array();
$config_grupo["orden_default"] = -1;
$config_grupo["images_limit"] = 3;

// Si tiene el flag de ofertas
if (isset($buscar_ofertas)) {
  $config_grupo["solo_propias"] = 1;
  $config_grupo["es_oferta"] = 1;
}

extract($propiedad_model->get_variables($config_grupo));
if (isset($get_params["test"])) echo $propiedad_model->get_sql();
$nombre_pagina = $vc_link_tipo_operacion;

if (isset($get_params["tp"]) && ($get_params["tp"] == "27" || $get_params["tp"] == "4")) $vc_nombre_operacion = "Barrios Cerrados";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include("includes/head.php") ?>
</head>
<body>

  <?php include("includes/header.php") ?>

<section class="page-title">
  <div class="container">
    <h1><?php 
      echo ($empresa->id == ID_EMPRESA_LA_PLATA) ? "La Plata" : "Punta del Este";
    ?></h1>
  </div>
</section>

<section>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php include("includes/propiedad/buscador.php") ?>
      </div>
    </div>
  </div>
</section>

<!-- Properties Details  -->
<section class="properties-details">
  <div class="container">
    <div class="properties">
      <div class="sort">
        <div class="inner-text">
          <h4>Propiedades en <?php echo $vc_nombre_operacion ?></h4>
          <p>Se encontraron <strong><?php echo $vc_total_resultados ?></strong> propiedades</p>
        </div>
        <div class="right-text">
          <p>Ordenar por:</p>
          <select onchange="ordenar()" id="orden" class="form-select form-control">
            <option value="-1" <?php echo ($vc_orden == -1 ) ? "selected" : "" ?>>Ver los más nuevos</option>
            <option value="8" <?php echo ($vc_orden == 8) ? "selected" : "" ?>>Propiedades Destacadas</option>
            <option value="2" <?php echo ($vc_orden == 2) ? "selected" : "" ?>>precio de menor a mayor</option>
            <option value="1" <?php echo ($vc_orden == 1) ? "selected" : "" ?>>precio de mayor a menor</option>
          </select>
          <div class="location">
            <a href="javascript:void(0)" onclick="buscar_mapa()" class="green"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
              <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
            </svg>Mapa</a>
          </div>
        </div>
      </div>
    </div>      
  </div>
</section>

<div id="mapa" style="width:100%; height:700px; margin-bottom: 30px;"></div>

<?php include("includes/footer.php") ?>
<?php include("includes/mapa_js.php"); ?>
</body>
</html>