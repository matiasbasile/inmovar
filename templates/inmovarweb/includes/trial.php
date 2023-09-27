<!-- Trial Section -->
<div class="trial-section">
  <div class="container">
    <div class="banner-content">
      <?php $t = $web_model->get_text("trial-titulo","Prueba 14 días gratis.") ?>
      <h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></h3>
      <?php $t = $web_model->get_text("trial-subtitulo","Todo lo que necesitas para comenzar a vender online.") ?>
      <div class="sub-title editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></div>
      <div class="btn-block">
        <a class="btn btn-aquamarine" href="<?php echo mklink("web/registro/") ?>"><i class="fa fa-play-circle" aria-hidden="true"></i> Registrate</a>
      </div>
      <?php $t = $web_model->get_text("trial-info","Sin tarjeta de crédito.\n Cancela en cualquier monento!") ?>
      <div class="trial-info editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?> <img src="images/thumb-up.png" alt="Thumb Up"></div>
    </div>
  </div>
</div>
