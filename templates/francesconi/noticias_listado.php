<?php 
include 'includes/init.php';
extract($entrada_model->get_variables(array(
  "offset" => 6,
)));
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">

<head>
  <?php include 'includes/head.php' ?>
</head>

<body class="noticias">

  <!-- Francesconi Header Equipo -->
  <?php include 'includes/header.php' ?>

  <!-- Equipo Banner -->
  <section class="equipo-banner">
    <div class="container">
      <div class="equipo-content">
        <h1 class="banner-title">novedades</h1>
      </div>
    </div>
  </section>

  <!-- Equipo Mis -->
  <section class="equipo-mis">
    <div class="container">
      <div class="mis-content">
        <h2 class="small-title">
          novedades <span>
            <?php echo $vc_total_resultados ?> Resultados de búsqueda</span>
        </h2>
      </div>

      <div class="comprar-inner">
        <form id="filter-form" method="get" action="<?php echo mklink("entradas/") ?>">
          <div class="row align-items-center">
            <div class="col-lg-5">
              <div class="d-md-flex align-items-center">
                <label for="" style="font-weight: bold;">FILTRAR POR CATEGORÍA:</label>
                <div class="select-inner">
                  <select class="round" name="cat" id="categoria">
                    <?php $categorias = $entrada_model->get_subcategorias(0,array("not_in"=>"1679,1680")) ?>
                    <?php foreach ($categorias as $cat) { ?>
                      <option <?php echo ($cat->id == $vc_id_categoria) ? "selected" : "" ?> value="<?php echo $cat->id ?>"><?php echo strtolower($cat->nombre) ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="d-md-flex align-items-center mt-md-0 mt-4">
                <label for="" style="font-weight: bold;">ORDENAR POR:</label>
                <div class="select-inner">
                  <select class="round" name="order" id="fecha">
                    <option value="0" <?php echo ($vc_order == 0) ? "selected" : "" ?>>MÁS NUEVAS A MÁS VIEJAS</option>
                    <option value="3" <?php echo ($vc_order == 3) ? "selected" : "" ?>>MÁS VIEJAS A MÁS NUEVAS</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-2">
              <div>
                <button type="submit" id="filtrar-btn" class="fill-btn">filtrar</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="comprar-info">
        <div class="mis-inner">
          <div class="row propiedades">
            <?php foreach ($vc_listado as $p) { ?>
              <div class="col-lg-4 col-md-6">
                <div class="noved-card">
                  <a href="<?php echo mklink($p->link) ?>" class="noved-warp">
                    <span>
                      <img src="assets/images/icons/icon-15.png" alt="Icon">
                    </span>
                    <b class="fill-btn btn-categoria"><?php echo $p->categoria ?></b>
                    <img src="<?php echo $p->path ?>" alt="Noved">
                  </a>
                  <div class="noved-inner">
                    <a href="<?php echo mklink($p->link) ?>" class="noved-redirect">
                      <h3><?php echo $p->titulo ?></h3>
                    </a>
                    <?php
                    $fecha = str_replace('/', '-', $p->fecha);
                    $mes =  get_mes(date('m', strtotime($fecha)));
                    ?>
                    <h5><small><?php echo $p->dia; ?></small><?php echo $mes ?> del <?php echo $p->anio; ?></h5>
                    <p><?php echo $p->plain_text ?></p>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="text-center <?php echo $vc_total_resultados <= 6 ? "d-none" : "" ?>">
        <button onclick="cargar()" id="cargarMas" class="fill-btn">ver más</button>
      </div>
    </div>
  </section>

  <!-- Francesconi Nuster -->
  <?php include 'includes/home/secondary_slider.php' ?>

  <!-- Francesconi Footer -->
  <?php include 'includes/footer.php' ?>

  <?php include 'includes/cargar_mas_entradas_js.php' ?>

  <script>
    $('#filter-form').submit(function(e) {
      var link = '<?php echo mklink("entradas/") ?>';
      link += $("#categoria").val().toLowerCase();
      $('#filter-form').attr('action', link);
    });
  </script>

</body>

</html>