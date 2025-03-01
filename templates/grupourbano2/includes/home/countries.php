<?php $countries_destacadas = $propiedad_model->get_list(array("offset" => 12, "limit" => 0, "destacado" =>  1)); ?>
<?php if (!empty($countries_destacadas)) { ?>
  <section class="neighborhoods padding-default">
    <div class="container text-center">
      <?php $t = $web_model->get_text("text13_2", "Especial Countries y Barrios Cerrados"); ?>
      <h2 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h2>

      <?php $t = $web_model->get_text("text14_2", "Disfrutá de la seguridad y privacidad de vivir en un barrio cerrado y/o controlado."); ?>
      <h5 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h5>
    </div>
    <div class="row m-0 mt-5 pad-lr-50">
      <?php 
      foreach ($countries_destacadas as $destacadas) { 
        item($destacadas);
      } ?>
    </div>
    <div class="d-md-block mt-5 text-center">
      <a href="<?php echo mklink("propiedades/ventas/?tp=4") ?>" class="btn btn-outline-secondary">ver todos <i class="fa fa-chevron-right ml-3"></i></a>
    </div>
  </section>
<?php } ?>