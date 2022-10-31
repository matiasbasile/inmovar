<?php $slider = $web_model->get_slider(array("clave"=>"slider_1")) ?>
<?php print_r($slider) ?>
<?php if (!empty($slider)) { ?>
  <section class="francesconi-banner">
    <div class="swiper-container hero-slider">
      <div class="swiper-wrapper">
        <?php foreach ($slider as $s) { ?>
          <div class="swiper-slide" style="<?php echo $s->path ?>">
            <div class="container">
              <div class="banner-content">
                <h1><?php echo $s->linea_1 ?></h1>
                <h2 class="banner-title"><?php echo $s->linea_2 ?></h2>
                <p><?php echo $s->linea_3 ?></p>
                <?php if (!empty($s->link_1) && (!empty($s->texto_link_1))) { ?>
                  <a href="<?php echo $s->link_1 ?>" class="border-btn"><?php echo $s->texto_link_1 ?></a>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="swiper-pagination"></div>
      <div class="banner-arrow-info">
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </div>
  </section>
<?php } ?>