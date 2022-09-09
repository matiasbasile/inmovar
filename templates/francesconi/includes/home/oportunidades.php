<?php $oportunidad = $web_model->get_text("oportunidad", "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.") ?>
<section class="francesconi-oport">
  <div class="container">
    <div class="oport-inner">
      <h2 class="sub-title">oportunidades</h2>
      <p>Qué es una Propiedad en Oportunidad?</p>
      <div class="oport-info">
        <p class="editable" data-id_empresa='<?php echo $oportunidad->id_empresa ?>' data-clave='<?php echo $oportunidad->clave ?>' data-id='<?php echo $oportunidad->id ?>'><?php echo $oportunidad->plain_text ?></p>
        <a href="javascript:void(0);" class="border-btn">ver oportunidades</a>
      </div>
    </div>
  </div>
</section>