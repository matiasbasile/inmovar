<?php
$obras = $propiedad_model->get_list(array(
  "id_tipo_operacion" => 5, 
  "limit" => 0, 
  "offset" => 4, 
  "destacado" => 1,
  "solo_propias" => 1,
));
if (!empty($obras)) { ?>
  <section class="padding-default works">
    <div class="container text-center">
      <?php $t = $web_model->get_text("text15", "Obras y Desarrollos Propios"); ?>
      <h2 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h2>

      <?php $t = $web_model->get_text("text16", "Conocé nuestros proyectos destacados en obra y construcción."); ?>
      <h5 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h5>
    </div>
    <div class="row m-0 mt-5 pad-lr-50">
      <?php foreach ($obras as $countri) { ?>
        <div class="col-md-3 work-list">
          <div class="img-block">
            <a href="<?php echo mklink($countri->link) ?>" class="stretched-link">
              <img class="adaptable-img-2" src="<?php echo $countri->imagen; ?>">
            </a>
          </div>
          <div class="work-info">
            <h6><?php echo $countri->nombre ?></h6>
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
