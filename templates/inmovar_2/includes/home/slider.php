<?php if ($empresa->id == 1502) {
  $slider = $web_model->get_slider(array(
    "clave" => "slider_1",
  ));
  if (sizeof($slider) > 0) { ?>
    <div id="slider" class="nivoSlider">
      <?php foreach ($slider as $s) {  ?>
        <a href="<?php echo (!empty($s->link_1)) ? $s->link_1 : "javascript:void(0)" ?>"><img src="<?php echo $s->path ?>" data-thumb="<?php echo $s->path ?>" alt="" /> </a>
      <?php } ?>
    </div>
  <?php } ?>
<?php } else { ?>
  <div class="banner">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <?php $i = 0;
        foreach ($sliders as $s) {
          $i++;  ?>
          <div class="item <?php echo ($i == 1) ? "active" : "" ?> <?php echo (!empty($s->linea_1) ? "sombreado" : "") ?>">
            <img src="<?php echo $s->path ?>">
            <div class="carousel-caption banner-slider-inner banner-top-align">
              <div class="text-center<?php //echo ($i%2==0) ? "center" : "left" 
                                      ?>">
                <?php if (!empty($s->linea_1)) { ?>
                  <h1 data-animation="animated fadeInDown delay-05s">
                    <span><?php echo $s->linea_1 ?></span>
                    <?php echo (!empty($s->linea_2)) ? "<br/>" . $s->linea_2 : "" ?>
                  </h1>
                <?php } ?>
                <?php if (!empty($s->linea_3)) { ?>
                  <p><?php echo $s->linea_3 ?></p>
                <?php } ?>
                <?php if (!empty($s->link_1)) { ?>
                  <a href="<?php echo $s->link_1 ?>" class="btn button-md button-theme" data-animation="animated fadeInUp delay-05s"><?php echo $s->texto_link_1 ?></a>
                <?php } ?>
                <?php if (!empty($s->link_2)) { ?>
                  <a href="<?php echo $s->link_2 ?>" class="btn button-md border-button-theme" data-animation="animated fadeInUp delay-05s"><?php echo $s->texto_link_2 ?></a>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <!-- Controls -->
      <a class="left carousel-control dn" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="slider-mover-left" aria-hidden="true">
          <i class="fa fa-angle-left"></i>
        </span>
        <span class="sr-only">Anterior</span>
      </a>
      <a class="right carousel-control dn" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="slider-mover-right" aria-hidden="true">
          <i class="fa fa-angle-right"></i>
        </span>
        <span class="sr-only">Siguiente</span>
      </a>
    </div>
  </div>
<?php } ?>
