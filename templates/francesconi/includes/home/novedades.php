<?php $novedades = $entrada_model->get_list(array(
  "from_link_categoria" => "novedades",
  "offset" => 3,
  "order_by" => 1
));
?>
<?php
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
<?php if (!empty($novedades)) { ?>
  <section class="francesconi-noved">
    <div class="container">
      <div class="noved-content">
        <h2 class="color-title">conocé nuestras últimas</h2>
        <h3 class="small-title">novedades</h3>
      </div>
      <div class="row">
        <?php foreach ($novedades as $n) { ?>
          <div class="col-lg-4 col-sm-6">
            <div class="noved-card">
              <div class="noved-warp">
                <span>
                  <a href="<?php echo mklink($n->link) ?>">
                    <img src="assets/images/icons/icon-15.png" alt="Icon">
                  </a>
                </span>
                <a href="#0" class="fill-btn">solidarias</a>
                <a href="<?php echo mklink($n->link) ?>">
                  <img src="<?php echo $n->path ?>" alt="Noved">
                </a>
              </div>
              <div class="noved-inner">
                <a href="<?php echo mklink($n->link) ?>" class="noved-redirect">
                  <h3><?php echo $n->titulo ?></h3>
                </a>
                <?php
                $fecha = str_replace('/', '-', $n->fecha);
                $mes =  $mes_month[date('n', strtotime($fecha))]
                ?>
                <h5><small><?php echo $n->dia; ?></small><?php echo $mes ?> del <?php echo $n->anio; ?></h5>
                <p>
                  <?php echo $n->plain_text ?></p>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <a href="#0" class="border-btn">ver todas</a>
    </div>
  </section>
<?php } ?>