<?php 
include 'includes/init.php';

$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : "";
$categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : "";
$orden = 1;
if ($fecha === 'antigua') {
  $orden = 2;
} else {
  $orden = 1;
}

extract($entrada_model->get_variables(array(
  "order" => $orden,
  "offset" => 6,
)));

$mes_month = array(
  1 => 'Enero',
  2 => 'Febrero',
  3 => 'Marzo',
  4 => 'Abril',
  5 => 'Mayo',
  6 => 'Junio',
  7 => 'Julio',
  8 => 'Agosto',
  9 => 'Septiembre',
  10 => 'Octubre',
  11 => 'Noviembre',
  12 => 'Diciembre',
);

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

      <?php $cat_link = strtolower($categoria) ?>
      <div class="comprar-inner">
        <form id="filter-form" method="post" action="<?php echo mklink("entradas/$cat_link") ?>">
          <div class="row align-items-center">
            <div class="col-lg-5">
              <div class="d-md-flex align-items-center">
                <label for="" style="font-weight: bold;">FILTRAR POR CATEGORÍA:</label>
                <div class="select-inner">
                  <select class="round" name="categoria" id="categoria">
                    <?php $categorias = $entrada_model->get_subcategorias(0) ?>
                    <?php $aux = array() ?>
                    <?php
                    foreach ($categorias as $cat) {
                      if ($cat->nombre != "Sobre mi" && $cat->nombre != "Equipo") {
                        array_push($aux, $cat->nombre);
                      }
                    }
                    ?>

                    <?php foreach ($aux as $vc) { ?>
                      <option <?php echo (strtolower($vc) == strtolower($categoria)) ? "selected" : "" ?> value="<?php echo strtolower($vc) ?>"><?php echo strtolower($vc) ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="d-md-flex align-items-center mt-md-0 mt-4">
                <label for="" style="font-weight: bold;">ORDENAR POR:</label>
                <div class="select-inner">
                  <select class="round" name="fecha" id="fecha">
                    <option value="reciente" <?php echo ($fecha == "reciente") ? "selected" : "" ?>>MÁS NUEVAS A MÁS VIEJAS</option>
                    <option value="antigua" <?php echo ($fecha == "antigua") ? "selected" : "" ?>>MÁS VIEJAS A MÁS NUEVAS</option>
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