<section class="francesconi-oport">
  <div class="container">
    <div class="oport-inner">
      <h2 class="sub-title">oportunidades</h2>
      <?php $t = $web_model->get_text("que_es_oportunidad", "Qué es una Propiedad en Oportunidad?") ?>
      <p class="editable" data-id_empresa='<?php echo $t->id_empresa ?>' data-clave='<?php echo $t->clave ?>' data-id='<?php echo $t->id ?>'><?php echo $t->plain_text ?></p>
      <div class="oport-info">
        <?php $t = $web_model->get_text("oportunidad", "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.") ?>
        <p class="editable" data-id_empresa='<?php echo $t->id_empresa ?>' data-clave='<?php echo $t->clave ?>' data-id='<?php echo $t->id ?>'><?php echo $t->plain_text ?></p>
        <a href="<?php echo mklink("oportunidades/") ?>" class="border-btn">ver oportunidades</a>
      </div>
    </div>
  </div>
</section>