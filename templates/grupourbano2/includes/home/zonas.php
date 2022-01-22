<section class="search-zone">
  <div class="row m-0">
    <div class="col-md-12 text-center">
      <?php $t = $web_model->get_text("text9", "Buscá por Zona"); ?>
      <h2 class="d-block editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h2>

      <?php $t = $web_model->get_text("text10", "Estas son algunas de las zonas más destacadas en La Plata"); ?>
      <h5 class="mb-4 editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h5>
    </div>
    <div class="col-md-3 p-0">
      <div class="img-block">
        <?php $t = $web_model->get_text("zona-1-img", "assets/images/zone01.jpg"); ?>
        <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
        <div class="zone-info">
          <?php $t = $web_model->get_text("zona-1-link", "La Plata"); ?>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h4>
          <a href="<?php echo $t->link ?>" class="btn btn-white">Ver Propiedades</a>
        </div>
      </div>
    </div>
    <div class="col-md-3 p-0">
      <div class="img-block">
        <?php $t = $web_model->get_text("zona-2-img", "assets/images/zone02.jpg"); ?>
        <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
        <div class="zone-info">
          <?php $t = $web_model->get_text("zona-2-link", "Gonnet"); ?>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>"><?php echo $t->plain_text ?></h4>
          <a href="<?php echo $t->link ?>" class="btn btn-white">Ver Propiedades</a>
        </div>
      </div>
    </div>
    <div class="col-md-3 p-0">
      <div class="img-block">
        <?php $t = $web_model->get_text("zona-3-img", "assets/images/zone03.jpg"); ?>
        <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
        <div class="zone-info">
          <?php $t = $web_model->get_text("zona-3-link", "City Bell"); ?>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h4>
          <a href="<?php echo $t->link ?>" class="btn btn-white">Ver Propiedades</a>
        </div>
      </div>
    </div>
    <div class="col-md-3 p-0">
      <div class="img-block">
        <?php $t = $web_model->get_text("zona-4-img", "assets/images/zone04.jpg"); ?>
        <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
        <div class="zone-info">
          <?php $t = $web_model->get_text("zona-4-link", "Costa Atlántica"); ?>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h4>
          <a href="<?php echo $t->link ?>" class="btn btn-white">Ver Propiedades</a>
        </div>
      </div>
    </div>
  </div>
</section>