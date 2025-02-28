<?php 
$slider = $web_model->get_slider(array(
  "clave"=>"slider_1",
)); 
if (sizeof($slider)>0) { ?>
  <div class="owl-carousel owl-theme" data-outoplay="true" data-nav="false" data-dots="true">
    <?php foreach($slider as $s) { ?>
      <div class="item">
        <img src="<?php echo $s->path ?>" alt="img">
      </div>
    <?php } ?>
  </div>
<?php } ?>