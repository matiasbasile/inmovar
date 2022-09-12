<?php include 'includes/init.php' ?>
<?php

extract($entrada_model->get_variables());

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

    <?php } ?>
    
    
    .equipo-mis .fill-btn {
      min-width: 120px;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--brand-clr1);
      background-color: var(--brand-clrbg);
    }
  </style>
</head>

<body>



  <!-- Francesconi Header Equipo -->
  <?php include 'includes/headerequipo.php' ?>

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
    <form id="form_buscador" onsubmit="return filtrar(this)" method="get">
      <div class="container">
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
                      <a href="#0" class="fill-btn">solidarias</a>
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
        <a href="#0" class="fill-btn">ver más</a>
      </div>
    </form>
  </section>

  <!-- Francesconi Nuster -->
  <?php include 'includes/home/secondary_slider.php' ?>

  <!-- Francesconi Footer -->
  <?php include 'includes/footer.php' ?>

</body>

</html>