<?php
$cant_favoritos = 0;
if (isset($_SESSION["favoritos"])) {
  $arr = explode(",",$_SESSION["favoritos"]);
  $cant_favoritos = sizeof($arr)-1;
}
$categorias_paginas = $entrada_model->get_subcategorias(0); ?>
<header class="main-header">
  <div class="container">
    <a href="<?php echo mklink ("/") ?>" class="logo1">
      <img src="images/logo.png" alt="Scipioni Propiedades">
    </a>        
    <nav class="navbar navbar-default">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navigation" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class="navbar-collapse collapse" role="navigation" aria-expanded="true" id="app-navigation">
        <ul class="nav navbar-nav navbar-right">
          <li class="hidden-xs">
            <a href="<?php echo mklink ("/") ?>"><i class="fa fs20 fa-home"></i></a>
          </li>
          <li>
            <a href="<?php echo mklink ("entrada/sobre-nosotros-1699/") ?>">Nosotros</a>
          </li>
          <li>
            <a href="<?php echo mklink ("propiedades/ventas/")?>">Ventas</a>
          </li>
          <li>
            <a href="<?php echo mklink ("propiedades/alquileres/")?>">Alquileres</a>
          </li>
          <li>
            <a href="<?php echo mklink ("contacto/") ?>">Contacto</a>
          </li>
          <?php if (!empty($empresa->facebook)) { ?>
            <li class="red"><a class="pl10 pr5" href="<?php echo $empresa->facebook ?>" target="_blank"><i class="fa fs20 fa-facebook"></i></a></li>
          <?php } ?>
          <?php if (!empty($empresa->twitter)) { ?>
            <li class="red"><a class="pl10 pr5" href="<?php echo $empresa->twitter ?>" target="_blank"><i class="fa fs20 fa-twitter"></i></a></li>
          <?php } ?>
          <?php if (!empty($empresa->linkedin)) { ?>
            <li class="red"><a class="pl10 pr5" href="<?php echo $empresa->linkedin ?>" target="_blank"><i class="fa fs20 fa-linkedin"></i></a></li>
          <?php } ?>
          <?php if (!empty($empresa->google_plus)) { ?>
            <li class="red"><a class="pl10 pr5" href="<?php echo $empresa->google_plus ?>" target="_blank"><i class="fa fs20 fa-google-plus"></i></a></li>
          <?php } ?>
          <?php if (!empty($empresa->instagram)) { ?>
            <li class="red"><a class="pl10 pr5" href="<?php echo $empresa->instagram ?>" target="_blank"><i class="fa fs20 fa-instagram"></i></a></li>
          <?php } ?>
          <li class="favoritos">
            <a href="<?php echo mklink("favoritos/") ?>" class="<?php echo ($cant_favoritos > 0)?"active":"" ?>">
              <i class="fa fs20 fa-heart"></i>
              <?php if ($cant_favoritos > 0) { ?>
                <span><?php echo $cant_favoritos; ?></span>
              <?php } ?>
            </a>
          </li>          

        </ul>
      </div>
    </nav>
  </div>
</header>