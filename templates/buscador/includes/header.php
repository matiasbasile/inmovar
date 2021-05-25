<?php
$cant_favoritos = 0;
if (isset($_SESSION["favoritos"])) {
  $arr = explode(",",$_SESSION["favoritos"]);
  $cant_favoritos = sizeof($arr)-1;
}
?>
<div class="navigation">
  <div class="secondary-navigation">
    <div class="container">
      <div class="contact">
        <?php if (!empty($empresa->telefono)) { ?>
          <figure><strong>Tel&eacute;fono:</strong><?php echo $empresa->telefono ?></figure>
        <?php } ?>
        <figure>
          <strong>Email:</strong>
          <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a>
        </figure>
      </div>
      <div class="user-area">
        <div class="language-bar">
          <?php if (!empty($empresa->facebook)) { ?>
            <a target="_blank" href="<?php echo $empresa->facebook ?>" class="fa fa-facebook"></a>
          <?php } ?>
          <?php if (!empty($empresa->twitter)) { ?>
            <a target="_blank" href="<?php echo $empresa->twitter ?>" class="fa fa-twitter"></a>
          <?php } ?>
          <?php if (!empty($empresa->instagram)) { ?>
            <a target="_blank" href="<?php echo $empresa->instagram ?>" class="fa fa-instagram"></a>
          <?php } ?>
          <?php if (!empty($empresa->linkedin)) { ?>
            <a target="_blank" href="<?php echo $empresa->linkedin ?>" class="fa fa-linkedin"></a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <header class="navbar" id="top" role="banner">
      <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-brand nav" id="brand">
          <a href="<?php echo mklink("/"); ?>">
            <?php if (empty($empresa->logo_1)) { ?>
              <?php echo ($empresa->nombre); ?>
            <?php } else { ?>
              <img src="/admin/<?php echo $empresa->logo_1 ?>" alt="<?php echo ($empresa->nombre); ?>" />
            <?php } ?>
          </a>
        </div>
      </div>
      <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
        <ul class="nav navbar-nav">
          <li class="<?php echo ($nombre_pagina=="ventas")?"active":"" ?>">
            <a href="<?php echo mklink("propiedades/ventas/"); ?>">Ventas</a>
          </li>
          <li class="<?php echo ($nombre_pagina=="alquileres")?"active":"" ?>">
            <a href="<?php echo mklink("propiedades/alquileres/"); ?>">Alquileres</a>
          </li>
          <li class="<?php echo ($nombre_pagina=="emprendimientos")?"active":"" ?>">
            <a href="<?php echo mklink("propiedades/emprendimientos/"); ?>">Emprendimientos</a>
          </li>
        </ul>
      </nav>
    </header>
  </div>
</div>