<?php
$obras = $propiedad_model->get_list(array("id_tipo_operacion" => 5, "limit" => 0, "offset" => 4, "destacado" => 1));
if (!empty($obras)) { ?>
  <section class="padding-default works">
    <div class="container text-center">
      <?php $t = $web_model->get_text("text15", "Especial Obras en Construcción"); ?>
      <h2 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h2>

      <?php $t = $web_model->get_text("text16", "Disfrutá de la seguridad y privacidad de vivir en un barrio cerrado y/o controlado."); ?>
      <h5 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h5>
    </div>
    <div class="row m-0 mt-5 pad-lr-50">
      <?php foreach ($obras as $countri) { ?>
        <div class="col-md-3 work-list">
          <div class="img-block">
            <a href="<?php echo mklink($countri->link) ?>" class="stretched-link">
              <img class="adaptable-img" src="<?php echo $countri->imagen; ?>">
            </a>
            <div class="work-tags"><?php echo $countri->tipo_inmueble ?></div>
            <div class="work-price"><?php echo $countri->precio ?></div>
          </div>
          <div class="work-info">
            <h6>
              <?php echo ($countri->dormitorios != 0 ? "<span>" . $countri->dormitorios . " Hab </span>" : "") ?>
              <?php echo ($countri->cocheras != 0 ? "<span>" . $countri->cocheras . " Cochera </span>" : "") ?>
              <?php echo ($countri->superficie_total != 0 ? "<span>" . $countri->superficie_total . " m2 </span>" : "") ?>
            </h6>
            <p><?php echo $countri->direccion_completa ?></p>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="d-md-block mt-5 text-center">
      <a href="<?php echo mklink("propiedades/obras/") ?>" class="btn btn-outline-secondary">ver todos <i class="fa fa-chevron-right ml-3"></i></a>
    </div>
  </section>
<?php } ?>
