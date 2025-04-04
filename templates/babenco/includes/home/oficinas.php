<section class="property-types">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <?php $t = $web_model->get_text("home-sucursal-1-img","assets/images/property1.png"); ?>
        <div class="img-box editable editable-img" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
          <img src="<?php echo $t->plain_text ?>" alt="Property Img">
          <div class="overley-box">
            <?php $t = $web_model->get_text("home-sucursal-1-text","Oficina en La Plata"); ?>
            <h2 class="img-box editable" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
              <?php echo $t->plain_text ?>
            </h2>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <?php $t = $web_model->get_text("home-sucursal-2-img","assets/images/property2.png"); ?>
        <div class="img-box editable editable-img" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
          <img src="<?php echo $t->plain_text ?>" alt="Property Img">
          <div class="overley-box">
            <?php $t = $web_model->get_text("home-sucursal-2-text","Oficina en Punta del Este"); ?>
            <h2 class="img-box editable" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
              <?php echo $t->plain_text ?>
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>