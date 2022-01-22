<?php $marcas = $articulo_model->get_marcas() ?>
<?php if (!empty($marcas)) { ?>
  <section class="sponsars padding-default">
    <div class="container">
      <div class="owl-carousel" data-items="5" data-margin="30" data-loop="false" data-nav="true" data-dots="false">
        <?php foreach ($marcas as $m) {  ?>
          <div class="item">
            <div class="logo-box">
              <img src="<?php echo $m->path ?>">
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
<?php } ?>
