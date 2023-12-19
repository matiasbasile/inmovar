<?php 
include_once 'includes/init.php';

if (!isset($config_grupo)) {
  $config_grupo = [];
}
$config_grupo['orden_default'] = 8;

// Si tiene el flag de ofertas
if (isset($buscar_ofertas)) {
  $config_grupo['solo_propias'] = 1;
  $config_grupo['es_oferta'] = 1;
}

extract($propiedad_model->get_variables($config_grupo));
if (isset($get_params['test'])) {
  echo $propiedad_model->get_sql();
}
$nombre_pagina = $vc_link_tipo_operacion;

if (isset($get_params['tp']) && ($get_params['tp'] == '27' || $get_params['tp'] == '4')) {
  $vc_nombre_operacion = 'Barrios Cerrados';
}

if (!$vc_nombre_operacion) {
  header('Location: /');
}

?>
<!DOCTYPE html>
<html dir="ltr" lang="es">

<head>
  <?php $pageTitle = $vc_tipo_operacion;
  $pageTitle = ($pageTitle == "Ventas") ? "Comprar" : $pageTitle;
  include 'includes/head.php'; ?>
</head>

<body>

  <!-- Header -->
  <?php include 'includes/header.php'; ?>

  <!-- Banner -->
  <?php include 'includes/smallBanner.php'; ?>

  <!-- Filter -->
  <?php include 'includes/listado/filter.php'; ?>

  <!-- For Sale -->
  <section class="for-sale for-sale-two">
    <div class="container">
      <div class="section-title">
        <div>
          <h2>Propiedades <span>en <?php echo $vc_nombre_operacion; ?></span></h2>
          <p>Se encontraron <span><?php echo $vc_total_resultados; ?></span> propiedades</p>
        </div>
        <div class="order-filter">
          <div class="form-group">
            <label for="ordenSelect">ordenar por:</label>
            <select onchange="sortList()" id="ordenSelect" name="sort" class="form-control">
              <?php echo $vc_orden; ?>
              <option value="destacado" <?php echo ($vc_orden == 4) ? 'selected' : ''; ?>>
                Destacadas
              </option>
              <option value="barato" <?php echo ($vc_orden == 2) ? 'selected' : ''; ?>>Menor a
                mayor
              </option>
              <option value="caro" <?php echo ($vc_orden == 1) ? 'selected' : ''; ?>>
                Mayor a
                menor
              </option>
            </select>
          </div>
          <a href="javascript:void(0)" onclick="buscar_mapa()" class="btn btn-left-icon">ver mapa</a>
        </div>
      </div>
      <div class="row g-4">
        <?php foreach ($vc_listado as $p) { ?>
          <?php item($p); ?>
        <?php } ?>
      </div>
      <?php if ($vc_total_paginas > 1) { ?>
        <nav aria-label="...">
          <ul class="pagination">
            <?php if ($vc_page > 0) { ?>
              <li class="page-item  ">
                <a class="page-link" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"><img src="assets/images/slider-arrow-left.png" alt="Arrow"></a>
              </li>
            <?php } ?>
            <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
              <?php if (abs($vc_page-$i)<3) { ?>
                <?php if ($i == $vc_page) { ?>
                  <li class="page-item active"><a href="javascript:void(0)" rel="nofollow" class="page-link"><?php echo $i+1 ?></a></li>
                <?php } else { ?>
                  <li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.$i."/".$vc_params ) ?>"><?php echo $i+1 ?></a></li>
                <?php } ?>
              <?php } ?>
            <?php } ?>
            <?php if ($vc_page < $vc_total_paginas-1) { ?>
              <li class="page-item">
                <a class="page-link" href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params ) ?>"><img src="assets/images/slider-arrow-right.png" alt="Arrow"></a>
              </li>
            <?php } ?>
          </ul>
        </nav>
      <?php } ?>
    </div>
  </section>

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>

  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWmUapFYTBXV3IJL9ggjT9Z1wppCER55g&callback=initMap">
  </script>
  <script>
  function sortList() {
    var sort = document.querySelector("#ordenSelect").value
    $("#ordenFilter").val(sort);
    $("#form_buscador").submit();
  }
  </script>
  <script src="assets/js/script.js"></script>
</body>

</html>