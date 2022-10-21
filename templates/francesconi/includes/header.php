<?php $clase_header = (isset($clase_header) ? $clase_header : "equipo"); ?>
<header class="francesconi-header <?php echo $clase_header ?>">
  <a href="<?php echo mklink("/") ?>" class="logo">
    <?php if ($clase_header == "") { ?>
      <img src="assets/images/header-logo.png" alt="Logo">
    <?php } else { ?>
      <img src="assets/images/header-logo-2.png" alt="Logo">
    <?php } ?>
  </a>
  <nav>
    <ul>
      <li class="dropdown"><a href="<?php echo mklink("propiedades/alquileres") ?>">ALQUILAR <img src="assets/images/icons/down-arrow.png" alt="Arrow"></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo mklink("propiedades/alquileres/?tp=1") ?>" class="dropdown-item">casas</a></li>
          <li><a href="<?php echo mklink("propiedades/alquileres/?tp=2") ?>" class="dropdown-item">departamentos</a></li>
          <li><a href="<?php echo mklink("propiedades/alquileres/?tp=7") ?>" class="dropdown-item">terrenos</a></li>
          <li><a href="<?php echo mklink("propiedades/alquileres/?tp=9") ?>" class="dropdown-item">locales</a></li>
        </ul>
      </li>
      <li class="dropdown"><a href="<?php echo mklink("propiedades/ventas") ?>">COMPRAR <img src="assets/images/icons/down-arrow.png" alt="Arrow"></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo mklink("propiedades/ventas/?tp=1") ?>" class="dropdown-item">casas</a></li>
          <li><a href="<?php echo mklink("propiedades/ventas/?tp=2") ?>" class="dropdown-item">departamentos</a></li>
          <li><a href="<?php echo mklink("propiedades/ventas/?tp=7") ?>" class="dropdown-item">terrenos</a></li>
          <li><a href="<?php echo mklink("propiedades/ventas/?tp=9") ?>" class="dropdown-item">locales</a></li>
        </ul>
      </li>
      <li><a href="<?php echo mklink("propiedades/oportunidades") ?>"></a>OPORTUNIDADES</li>
      <li><a href="<?php echo mklink("propiedades/permutas") ?>"></a>PERMUTAS</li>
      <li><a href="javascript:void(0);">VENDER </a></li>
      <li><a href="<?php echo mklink("web/equipo") ?>">Equipo </a></li>
    </ul>
    <a href="javascript:void(0);" class="toggle-icon"><span></span></a>
  </nav>
</header>
<div class="toggle-menu">
  <div>
    <a href="javascript:void(0);" class="menu-close">
      <img src="assets/images/icons/menu-close.png" alt="Menu">
    </a>
    <a href="#0" class="toggle-logo"><img src="assets/images/header-logo.png" alt="Logo"></a>
    <ul>
      <li><a href="<?php echo mklink("/") ?>"><img src="assets/images/icons/icon-8.png" alt="Right Arrow"> inicio</a></li>
      <li><a href="<?php echo mklink("propiedades/novedades") ?>"><img src="assets/images/icons/icon-8.png" alt="Right Arrow"> NOVEDADES</a></li>
      <li><a href="<?php echo mklink("web/contacto") ?>"><img src="assets/images/icons/icon-8.png" alt="Right Arrow"> CONTACTO</a></li>
    </ul>
    <div class="menu-inner">
      <ul>
        <li><a href="#0"><span>ventas</span>+54 (221) 546-0441</a></li>
        <li><a href="#0"><span>alquileres</span>+54 (221) 546-0441</a></li>
        <li><a href="#0"><span>administración</span>+54 (221) 546-0441</a></li>
      </ul>
    </div>
    <div class="small-menu">
      <?php if (!empty($empresa->ciudad) && (!empty($empresa->direccion))) { ?>
        <a href="javascript:void(0);" class="active">dirección <span><?php echo $empresa->direccion ?> - <?php echo $empresa->ciudad ?></span></a>
      <?php } ?>
      <?php if (!empty($empresa->horario)) { ?>
        <a href="javascript:void(0);" class="active">horario <span><?php echo $empresa->horario ?></span></a>
      <?php } ?>
    </div>
    <div class="social-media">
      <?php if (!empty($empresa->facebook)) { ?>
        <a href="<?php echo $empresa->facebook ?>" target="_blank"><img src="assets/images/icons/facebook.png" alt="Facebook"></a>
      <?php } ?>
      <?php if (!empty($empresa->instagram)) { ?>
        <a href="<?php echo $empresa->instagram ?>" target="_blank"><img src="assets/images/icons/insta.png" alt="Instagram"></a>
      <?php } ?>
      <?php if (!empty($empresa->youtube)) { ?>
        <a href="<?php echo $empres->youtube ?>" target="_blank"><img src="assets/images/icons/play.png" alt="Playstore"></a>
      <?php } ?>
    </div>
  </div>
</div>