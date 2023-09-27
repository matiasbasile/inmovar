<div id="soporte" class="we-do">
  <div class="container">
    <div class="section-title">
      <?php $t = $web_model->get_text("nosotros-titulo","lo hacemos por vos!"); ?>
      <h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></h3>
      <?php $t = $web_model->get_text("nosotros-subtitulo","Tenes dudas o no sabes como hacerlo?"); ?>
      <h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></h4>
      <?php $t = $web_model->get_text("nosotros-texto","No te preocupes, crea tu tienda y te llamaremos para ayudarte a configurar \nla misma con los colores, logo e información de tu negocio."); ?>
      <p class="editable mw750" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></p>
    </div>
    <div class="listing-block">
      <div class="col-md-6">
        <div class="service-box" data-aos="fade-right" data-aos-delay="800" data-aos-duration="800">
          <div class="service-icon">
            <img src="images/service-icon5.png" alt="Service-icon">
          </div>
          <?php $t = $web_model->get_text("nosotros-opcion-1-titulo","Podes hacerlo vos mismo desde nuestro panel"); ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="service-title editable"><?php echo ($t->plain_text) ?></div>
          <?php $t = $web_model->get_text("nosotros-opcion-1-texto","Es simple, desde la barra de\n herramientas de diseño solo deberás\n subir el logo, cambiar colores y\n cargar información de contacto y listo! "); ?>
          <p data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><?php echo ($t->plain_text) ?></p>
          <div class="btn-block"><a class="btn btn-blue" href="<?php echo mklink("web/registro/") ?>">comenzá ahora!</a></div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="service-box" data-aos="fade-down" data-aos-delay="1000" data-aos-duration="1000">
          <div class="service-icon">
            <img src="images/service-icon4.png" alt="Service-icon">
          </div>
          <?php $t = $web_model->get_text("nosotros-opcion-2-titulo","o llamarnos para que lo hagamos nosotros"); ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="service-title editable"><?php echo ($t->plain_text) ?></div>
          <?php $t = $web_model->get_text("nosotros-opcion-2-texto","<p>Al contratar un plan podrás solicitar<br> nuestra ayuda <span>SIN CARGO</span><br> para crear tu tienda por vos.</p>"); ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><?php echo $t->texto ?></div>
          <div class="btn-block"><a class="btn btn-aquamarine" href="<?php echo mklink("web/registro/") ?>">solicitar llamado</a></div>
        </div>
      </div>
    </div>
  </div>
</div>