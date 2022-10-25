<?php include 'includes/init.php' ?>
<?php

$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : "";
$categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : "";

$orden = 1;
if ($fecha === 'antigua') {
  $orden = 2;
} else {
  $orden = 1;
}

extract($entrada_model->get_variables(array(
  "order" => $orden
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
<html dir="ltr" lang="en-US">

<head>
  <?php include 'includes/head.php' ?>
  <style>
    <?php if (sizeof($vc_listado) == 1) { ?>.mis-inner [class*="col-"]:first-child {
      width: 100% !important;
    }

    <?php } ?>.equipo-mis .fill-btn-solidarias {
      min-width: 120px;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--brand-clr1) !important;
      background-color: var(--brand-clrbg) !important;
    }

    select {
      margin: 0px !important;
      border-bottom: 0 !important;
    }

    .margins {
      position: relative;
      left: -40px;
    }

    .equipo-mis .fill-btn {
      width: 100% !important;
      padding: 10px !important;
    }

    select {
      margin: 0px !important;
      border-bottom: 0 !important;
      margin-left: 20px !important;
    }

    .select-inner {
      width: 50%;
    }

    @media(max-width: 768px) {
      .margins {
        position: static;
      }

      select{margin-left: 0px !important;}


    }
  </style>
</head>

<body>



  <!-- Francesconi Header Equipo -->
  <?php include 'includes/header.php' ?>

  <!-- Equipo Banner -->
  <section class="equipo-banner">
    <div class="container">
      <div class="equipo-content">
        <h1 class="banner-title"><?php echo $vc_listado[0]->categoria ?></h1>
      </div>
    </div>
  </section>

  <!-- Equipo Mis -->
  <section class="equipo-mis">
    <div class="container">
      <div class="mis-content">
        <h2 class="small-title">
          NOVEDADES <span>
            <?php echo $vc_total_resultados ?> Resultados de búsqueda</span>
        </h2>
      </div>

      <!-- https://app.inmovar.com/sandbox/1683/entradas/novedades -->

      <div class="comprar-inner">
        <form method="post" action="<?php echo !$categoria == "" ? mklink("entradas/$categoria") : mklink("entradas/") ?>">
          <div class="row align-items-center">
            <div class="col-lg-5">
              <div class="d-md-flex align-items-center">
                <label for="" style="font-weight: bold;">FILTRAR POR CATEGORÍA:</label>
                <div class="select-inner">
                  <select class="round" name="categoria" id="categoria">
                    <?php $categorias = $entrada_model->get_subcategorias(0) ?>
                    <?php foreach ($categorias as $vc) { ?>
                      <option <?php echo $vc->nombre == $categoria ? "selected" : "" ?> value="<?php echo $vc->nombre ?>"><?php echo $vc->nombre ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="d-md-flex align-items-center">
                <label for="" style="font-weight: bold;">ORDENAR POR:</label>
                <div class="select-inner">
                  <select class="round" name="fecha" id="fecha">
                    <option value="reciente">MÁS NUEVAS A MÁS VIEJAS</option>
                    <option value="antigua">MÁS VIEJAS A MÁS NUEVAS</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-2">
              <div>
                <button type="submit" class="fill-btn">filtrar</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="comprar-info">
        <div class="mis-inner">
          <div class="row">
            <?php foreach ($vc_listado as $p) { ?>
              <div class="col-lg-4 col-md-6">
                <div class="noved-card">
                  <div class="noved-warp">
                    <span>
                      <a href="<?php echo mklink($p->link) ?>">
                        <img src="assets/images/icons/icon-15.png" alt="Icon">
                      </a>
                    </span>
                    <a href="#0" class="fill-btn fill-btn-solidarias"><?php echo $vc->categoria ?></a>
                    <a href="<?php echo mklink($p->link) ?>">
                      <img src="<?php echo $p->path ?>" alt="<?php echo $p->titulo ?>">
                    </a>
                  </div>
                  <div class="noved-inner">
                    <a href="<?php echo mklink($n->link) ?>" class="noved-redirect">
                      <h2 class="noved-redirect"><?php echo $p->titulo ?></h2>
                    </a>
                    <div class="noved-inner">
                      <?php
                      $fecha = str_replace('/', '-', $p->fecha);
                      $mes =  $mes_month[date('n', strtotime($fecha))]
                      ?>
                      <h5><small><?php echo $p->dia; ?></small><?php echo $mes ?> del <?php echo $p->anio; ?></h5>
                      <p>
                        <?php echo $p->plain_text ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="text-center">
        <a href="javascript:void(0);" class="fill-btn">ver más</a>
      </div>
    </div>
  </section>

  <!-- Francesconi Nuster -->
  <?php include 'includes/home/secondary_slider.php' ?>

  <!-- Francesconi Footer -->
  <?php include 'includes/footer.php' ?>

</body>

</html>