<?php $destacadas = $propiedad_model->destacadas(array(
  "offset" => 6,
  "in_ids_operaciones" => "1,2,3",
)); ?>

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
      <div class="tac">
        <a href="<?php echo mklink("propiedades/") ?>" class="btn pl30 pr30 mt20 mb20">Ver todas las propiedades</a>
      </div>
    </div>
  </section>
<?php } ?>