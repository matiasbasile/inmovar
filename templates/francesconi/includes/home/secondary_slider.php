<?php $slider2 = $web_model->get_slider(array("clave" => "slider_2")) ?>
<?php if (!empty($slider2)) { ?>
  <section class="francesconi-nuster">
    <div class="container">
      <h3 class="sub-title">nuestra comunidad</h3>
      <div class="swiper-container nuestra-slider">
        <div class="swiper-wrapper">
          <?php foreach ($slider2 as $s) { ?>
            <div class="swiper-slide">
              <div class="nuster-inner">
                <a href="javascript:void(0);"><img src="<?php echo $s->path ?>" alt="Icon"></a>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>
<?php } ?>