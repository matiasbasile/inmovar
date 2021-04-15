<?php
$cant_favoritos = 0;
if (isset($_SESSION["favoritos"])) {
  $arr = explode(",",$_SESSION["favoritos"]);
  $cant_favoritos = sizeof($arr)-1;
}
?>
<div class="header">
  <div class="page">
    <div class="logo"><a href="<?php echo mklink("/") ?>"><img src="images/logo.png" alt="Diego Berrueta" /></a></div>
    <a href="javascript:void(0);" onClick="$('.menu').slideToggle();" class="toggle-button"><span></span> <span></span> <span></span></a>
    <div class="header-content">
      <div class="social">
        <?php if (!empty($empresa->twitter)) { ?><a href="<?php echo $empresa->twitter; ?>"><img src="images/twitter.png" alt="Twitter" /></a><?php } ?>
        <?php if (!empty($empresa->facebook)) { ?><a href="<?php echo $empresa->facebook; ?>"><img src="images/facebook.png" alt="Facebook" /></a><?php } ?>
        <a href="<?php echo mklink("favoritos/"); ?>" class="favorite <?php echo ($cant_favoritos > 0)?"active":"" ?>">
          <?php if ($cant_favoritos > 0) { ?>
            <span><?php echo $cant_favoritos; ?></span>
          <?php } ?>
        </a>
      </div>
      <div class="menu">
        <ul>
          <li><a href="<?php echo mklink("/") ?>">Inicio</a></li>
          <li><a href="<?php echo mklink("propiedades/ventas/") ?>">Ventas</a></li>
          <li><a href="<?php echo mklink("propiedades/alquileres/") ?>">Alquileres</a></li>
          <li><a href="<?php echo mklink("propiedades/emprendimientos/") ?>">Emprendimientos</a></li>
          <li><a href="<?php echo mklink("contacto/") ?>">Contacto</a></li>
        </ul>
        <div class="account-link">
            <?php
            $q = mysqli_query($conx,"SELECT * FROM web_paginas WHERE id_empresa = $empresa->id AND UPPER(titulo_es) = 'TASACIONES' LIMIT 0,1 ");
            if (mysqli_num_rows($q)>0) {
              $r = mysqli_fetch_object($q); ?>
              <a href="<?php echo mklink($r->link); ?>" class="btn btn-white"><?php echo ($r->titulo_es); ?></a>
            <?php } ?>
            <?php
            if (!isset($_SESSION["id_propietario"])) { ?>
              <a href="<?php echo mklink("login/")?>" class="btn btn-orange">SUB&Iacute; TU PROPIEDAD</a>
            <?php } else { ?>
              <div class="user-name" id="user-dropdown">
                <a href="javascript:void(0);" id="toggle-dropdown">
                  <img src="images/user-icon.png" alt="User" /> <?php echo (isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "Usuario"); ?>
                </a>
                <div class="profile-menu" id="profile-menu">
                  <ul>
                    <li><a href="<?php echo mklink("subi-tu-propiedad/") ?>">sub&iacute; tu propiedad <img src="images/home-icon4.png" alt="My Properties" /></a></li>
                    <li><a href="<?php echo mklink("mis-propiedades/") ?>">mis propiedades <img src="images/home-icon4.png" alt="My Properties" /></a></li>
                    <li><a href="<?php echo mklink("perfil/") ?>">mis datos <img src="images/location-icon3.png" alt="My Data" /></a></li>
                    <li><a href="/logout/">cerrar sesi&oacute;n</a></li>
                  </ul>
                </div>
              </div>
            <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
