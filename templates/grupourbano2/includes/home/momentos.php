<section class="group-bertoia padding-default d-block">
  <div class="container">
    <?php $t = $web_model->get_text("text11", "Buscá Según Tu Momento"); ?>
    <h2 class="text-center editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h2>

    <?php $t = $web_model->get_text("text12", "Queres mudarte con tu familia a una nueva casa, estas por empezar a construir y necesitas un terreno o<br class='d-md-block d-none'> búscas comprar un departamento para estudiar? Tenemos las mejores opciones para ofrecerte:"); ?>
    <h5 class="text-center editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h5>
  </div>
  <div class="row m-0 mt-5">
    <?php $categorias = $web_model->get_main_categories(array("offset" => 8, "limit" => 0));
    foreach ($categorias as $cat) {
      $categori = $web_model->get_categoria($cat->id); ?>
      <div class="col-md-3 p-0 search-moment-list">
        <div class="search-moment">
          <span class="moment-icon" style="background:url(<?php echo $categori->path ?>)no-repeat 50% 0"></span>
          <a href="<?php echo mklink($categori->external_link) ?>" class="btn btn-outline-primary stretched-link"><?php echo $categori->nombre ?></a>
        </div>
      </div>
    <?php } ?>
  </div>
</section>
