<?php $destacadas = $propiedad_model->destacadas(array("offset" => 6)); ?>

<?php if (!empty($destacadas)) { ?>
  <section class="featured-properties">
    <div class="container">
      <div class="section-title">
        <h2>PROPIEDADES DESTACADAS</h2>
      </div>
      <div class="row">
        <?php foreach ($destacadas as $des) { ?>
          <?php item_destacada($des) ?>
        <?php } ?>
      </div>
    </div>
  </section>
<?php } ?>