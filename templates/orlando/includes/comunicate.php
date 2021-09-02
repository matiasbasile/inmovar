<div class="call-to-action mb-2">
  <div class="container">
    <div class="row">
      <div class="col-lg-9 tenes">
        <img src="assets/images/logo4.png" alt="Logo">
        <div class="right-content">
          <?php $t = $web_model->get_text("sloga-tit","Tenes una propiedad para vender o alquilar?")?>
          <h3 class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
            <?php echo $t->plain_text ?>
          </h3>
          <?php $t = $web_model->get_text("sloga-txt","Trae tu propiedad a Prado Inmobiliaria para que lo gestionemos por vos!")?>
          <p class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
            <?php echo $t->plain_text ?>
          </p>
        </div>
      </div>
      <div class="col-lg-3 text-center">
        <img src="assets/images/home-icon.png" alt="Home Icon">
        <a href="<?php echo mklink ("contacto/")?>"><h4> comunicate</h4></a>
      </div>
    </div>
  </div>
</div>