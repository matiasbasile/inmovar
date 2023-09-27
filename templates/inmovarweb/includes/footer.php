<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-2 col-md-12 text-center">
        <div class="logo"><a href="<?php echo mklink("/") ?>"><img src="images/logo.png" alt="Logo"><?php echo $empresa->nombre ?></a></div>
      </div>
      <div class="col-lg-5 col-md-5">
        <h5>Información</h5>
        <ul class="quick-links">
          <li><a href="<?php echo mklink("/") ?>">Inicio</a></li>
          <?php $secciones = $entrada_model->get_list(array(
            "categoria"=>"secciones"
          )); 
          foreach($secciones as $r) { ?>
            <li><a href="<?php echo mklink($r->link) ?>"><?php echo $r->titulo?></a></li>
          <?php } ?>
          <li><a href="<?php echo mklink("web/precios/") ?>">Precios</a></li>
        </ul>
        <ul class="quick-links">
          <li><a target="_blank" href="https://www.varcreative.com/sistema/">Acceso Clientes</a></li>
          <li><a href="<?php echo mklink("web/registro/") ?>">Registro</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-4">
        <h5>Contacto</h5>
        <div class="contact-info">
          <span>Teléfono <a href="tel:+54 (221) 453.5654">+54 (221) 453.5654</a></span>
          <span>Email <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a></span>
        </div>
      </div>
      <div class="col-lg-2 col-md-3">
        <div class="socials">
          <ul>
            <?php if (!empty($empresa->facebook)){ ?>
              <li><a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fab fa-facebook-f"></i></a></li>
            <?php } ?>
            <?php if (!empty($empresa->youtube)){ ?>
              <li><a target="_blank" href="<?php echo $empresa->youtube ?>"><i class="fab fa-youtube"></i></a></li>
            <?php } ?>
            <?php if (!empty($empresa->instagram)){ ?>
              <li><a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fab fa-instagram"></i></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Copyright -->
<div class="copyright">
  <div class="container">
    <div class="pull-left"><span><?php echo ucfirst($empresa->nombre)." ".date("Y")?> <small>Todos Los Derechos Reservados.</small> <small><a class="aquamarine-color" href="#0">Términos y condiciones</a></small> <i>I</i> <small><a class="blue-color" href="#0">Políticas de privacidad</a></small></span></div>
    <div class="pull-right"><span><small>Desarrollado por <a class="white-color" target="_blank" href="https://www.varcreative.com/">Varcreative</a> <img src="images/varcreative-logo.png" alt="Varcreative"></small></span></div>
  </div>
</div>

<!-- Preloader -->
<div id="loading">
  <div id="loading-center">
    <div id="loading-center-absolute">
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
    </div>
  </div> 
</div>

<!-- Scripts --> 
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script type="text/javascript" src="js/plugins.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script type="text/javascript" src="/sistema/resources/js/common.js"></script>