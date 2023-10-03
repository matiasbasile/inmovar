<?php $novedades = $propiedad_model->get_list([
  'offset' => 6,
]); ?>
<?php if (!empty($novedades)) { ?>
<section class="feature">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($novedades as $p) { ?>
            <?php item($p); ?>
            <?php } ?>
        </div>
    </div>
</section>
<?php } ?>