<?php
$destacadas = $propiedad_model->destacadas(array(
  "images_limit" => 3,
));
if (sizeof($destacadas)>0) { ?>
  <section class="featured-properties properties">
    <div class="container">
      <div class="section-title">
        <span>ciudad de la plata</span>
        <h2>Propiedades Destacadas</h2>
      </div>
      <div class="row">
        <?php foreach($destacadas as $r) { ?>
          <div class="col-lg-4 col-md-6">
            <?php propiedad_item($r) ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
<?php } ?>  