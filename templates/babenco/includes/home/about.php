<section class="about-us">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="top-img">
          <?php $t = $web_model->get_text("about-img-1","assets/images/about-top.png"); ?>
          <img class="editable editable-img" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" src="<?php echo $t->plain_text ?>" alt="Img">
        </div>
        <div class="arrow-down">
          <?php $t = $web_model->get_text("about-img-2","assets/images/arrow-down.png"); ?>
          <img class="editable editable-img" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" src="<?php echo $t->plain_text ?>" alt="Img">
        </div>
        <div class="bottom-img">
          <?php $t = $web_model->get_text("about-img-3","assets/images/about-bottom.png"); ?>
          <img class="editable editable-img" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" src="<?php echo $t->plain_text ?>" alt="Img">
        </div>
      </div>
      <div class="col-lg-6">
        <div class="section-title">
          <?php $t = $web_model->get_text("about-subtitle-1","sobre nosotros"); ?>
          <span class="editable" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
            <?php echo $t->plain_text ?>
          </span>
          <?php $t = $web_model->get_text("about-title-1","Experiencia Inmobiliaria <br>Confiable desde 1985"); ?>
          <h2 class="editable" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
            <?php echo $t->plain_text ?>
          </h2>
        </div>

        <?php $t = $web_model->get_text("about-text-1","<p>Nuestra trayectoria de décadas habla por sí misma. Desde 1985, hemos sido el pilar de confianza en el mercado inmobiliario, ofreciendo un servicio excepcional y resultados probados. Nuestro compromiso es hacer realidad tus sueños de hogar.</p>"); ?>
        <p class="editable" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
          <?php echo $t->plain_text ?>
        </p>
        
        <div class="row">
          <div class="col-md-7">
            <?php $t = $web_model->get_text("about-text-2"); ?>
            <div class="editable" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
              <?php echo $t->texto ?>
            </div>
            <a href="<?php echo mklink("web/nosotros/") ?>" class="btn">Ver más</a>
          </div>
          <div class="col-md-5">
            <div class="box-info">
              <span>Contamos</span>
              <?php $t = $web_model->get_text("about-anios","+35"); ?>
              <h6 class="editable" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
                <?php echo $t->plain_text ?>
              </h6>
              <span>Años de <br>Experiencia</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>