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
            <?php item_entrada($n) ?>
          </div>
        <?php } ?>
      </div>
      <a href="<?php echo mklink("entradas/novedades")  ?>" class="border-btn">ver todas</a>
    </div>
  </section>
<?php } ?>