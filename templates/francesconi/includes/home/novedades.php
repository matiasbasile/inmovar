<?php $novedades = $entrada_model->get_list(array(
  "from_link_categoria" => "novedades",
  "offset" => 3,
  "order_by" => 1
)); 
?>
<?php print_r($novedades) ?>
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
                <span><img src="assets/images/icons/icon-15.png" alt="Icon"></span>
                <a href="#0" class="fill-btn">solidarias</a>
                <img src="<?php echo $n->path ?>" alt="Noved">
              </div>
              <div class="noved-inner">
                <h3><?php echo $n->titulo ?></h3>
                <h5><?php echo $n->fecha ?></h5>
                <?php 
                  $orderdate = explode('/', $n->fecha);
                  $month = $orderdate[0];
                  $day   = $orderdate[1];
                  $year  = $orderdate[2];
                  echo $day . $month . $year;                  
                ?>
                <h5></h5>
                <!-- <h5><small>02</small>Junio del 2022</h5> -->
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