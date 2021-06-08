<?php
$cant_favoritos = 0;
if (isset($_SESSION["favoritos"])) {
  $arr = explode(",",$_SESSION["favoritos"]);
  $cant_favoritos = sizeof($arr)-1;
}
?>
<div class="navigation">
  <div class="container">
    <header class="navbar" id="top" role="banner">
      <div class="navbar-header">
        <?php /*
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        */ ?>
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
      <?php /*
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
      */ ?>
    </header>
  </div>
</div>