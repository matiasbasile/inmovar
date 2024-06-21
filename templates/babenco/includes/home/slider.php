<?php 
$slider = $web_model->get_slider();
if (sizeof($slider)>0) { ?>
  <div class="owl-carousel owl-theme" data-outoplay="true" data-nav="true" data-dots="true">
    <?php foreach($slider as $s) { ?>
      <div class="item">
        <img src="<?php echo $s->path ?>" alt="img">
        <div class="banner-caption">
          <div class="container">
            <h1>
              <?php echo $s->linea_1 ?>
              <?php if (!empty($s->linea_2)) { ?>
                <br><?php echo $s->linea_2 ?>
              <?php } ?>
            </h1>
            <?php if (!empty($s->linea_3)) { ?>
              <p>
                <?php echo $s->linea_3 ?>
                <?php if (!empty($s->linea_4)) { ?>
                  <br><?php echo $s->linea_4 ?>
                <?php } ?>
              </p>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
<?php } ?>