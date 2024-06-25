<?php 
include 'includes/init.php';

if (!isset($config_grupo)) $config_grupo = array();
$config_grupo["orden_default"] = 8;
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

<div class="container">
  <?php include("includes/propiedad/buscador.php") ?>
</div>

<!-- Properties Details  -->
<section class="properties-details">
  <div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="properties">
				<div class="sort">
					<div class="inner-text">
						<h4>Propiedades en <?php echo $vc_nombre_operacion ?></h4>
						<p>Se encontraron <strong><?php echo $vc_total_resultados ?></strong> propiedades</p>
					</div>
					<div class="right-text">
						<p>Ordenar por:</p>
            <select name="orden" class="form-select form-control">
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
        
        <div class="row">
          <?php foreach ($vc_listado as $p) { ?>
            <div class="col-lg-4 col-md-6">
              <?php propiedad_item($p); ?>
            </div>
          <?php } ?>
        </div>

        <?php if ($vc_total_paginas > 1) { ?>
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <?php if ($vc_page > 0) { ?>
                <li class="page-item">
                  <a class="prev" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"></a>
                </li>
              <?php } ?>
              <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
                <?php if (abs($vc_page-$i)<2) { ?>
                  <li class="page-item <?php echo ($i==$vc_page) ? "active" : ""?>">
                    <a href="<?php echo mklink($vc_link.$i."/".$vc_params) ?>"><?php echo ($i+1); ?></a>
                  </li>
                <?php } ?>
              <?php } ?>
              <?php if ($vc_page < ($vc_total_paginas-1)) { ?>
                <li class="page-item">
                  <a class="next" href="<?php echo mklink($vc_link.($vc_page+1)."/".$vc_params) ?>"></a>
                </li>
              <?php } ?>
            </ul>
          </nav>
        <?php } ?>
			</div>			
		</div>
	</div>
</div>
</section>

<?php include("includes/footer.php") ?>

</body>
</html>