<div class="contact-details mb30">
  <div class="main-title-2">
    <h4><span>Contáctanos</span></h4>
  </div>
  <div class="media">
    <div class="media-left">
      <i class="fa fa-map-marker"></i>
    </div>
    <div class="media-body">
      <h4>Dirección</h4>
      <p><?php echo ($empresa->direccion) ?></p>
    </div>
  </div>
  <div class="media">
    <div class="media-left">
      <i class="fa fa-phone"></i>
    </div>
    <div class="media-body">
      <h4>Teléfonos</h4>
      <p>
        <a href="tel:0477-0477-8556-552"><?php echo $empresa->telefono ?></a>
      </p>
      <p>
        <a href="tel:+55-417-634-7071"><?php echo $empresa->telefono_2 ?></a>
      </p>
    </div>
  </div>
  <div class="media mrg-btm-0">
    <div class="media-left">
      <i class="fa fa-envelope"></i>
    </div>
    <div class="media-body">
      <h4>Coreo electrónico</h4>
      <p>
        <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a>
      </p>
    </div>
  </div>
</div>

<?php if (!empty($empresa->facebook) || !empty($empresa->twitter) || !empty($empresa->linkedin) || !empty($empresa->google_plus) || !empty($empresa->instagram)) { ?>
  <div class="social-media sidebar-widget clearfix">
    <!-- Main Title 2 -->
    <div class="main-title-2">
      <h4>Redes <span>Sociales</span></h4>
    </div>
    <ul class="social-list clearfix">
      <?php if (!empty($empresa->facebook)) { ?>
        <li><a class="facebook" href="<?php echo $empresa->facebook ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
      <?php } ?>
      <?php if (!empty($empresa->twitter)) { ?>
        <li><a class="twitter" href="<?php echo $empresa->twitter ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
      <?php } ?>
      <?php if (!empty($empresa->linkedin)) { ?>
        <li><a class="linkedin" href="<?php echo $empresa->linkedin ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
      <?php } ?>
      <?php if (!empty($empresa->google_plus)) { ?>
        <li><a class="google" href="<?php echo $empresa->google_plus ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
      <?php } ?>
      <?php if (!empty($empresa->instagram)) { ?>
        <li><a class="instagram" href="<?php echo $empresa->instagram ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
      <?php } ?>
    </ul>
  </div>
<?php } ?>