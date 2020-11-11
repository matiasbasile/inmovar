<div class="ts-page-wrapper ts-homepage" id="page-top">
  <header id="ts-header" class="fixed-top">
    <nav id="ts-secondary-navigation" class="navbar p-0">
      <div class="container justify-content-end justify-content-sm-between">
        <div class="navbar-nav d-none d-sm-block">
          <?php if (!empty($empresa->telefono)) { ?>
            <span class="mr-4">
              <i class="fa fa-phone-square mr-1"></i>
              <?php echo $empresa->telefono;?>
            </span>
          <?php } ?>
          <a href="mailto:<?php echo $empresa->email ?>">
            <i class="fa fa-envelope mr-1"></i>
            <?php echo $empresa->email ?></a>
          </a>
        </div>
        <div class="navbar-nav flex-row" id="socialshead">
          <?php if (!empty($empresa->facebook)){ ?>
            <a href="<?php echo $empresa->facebook?>" class="nav-link">
              <i class="fab fa-facebook-f"></i>
            </a>
          <?php } ?>
          <?php if (!empty($empresa->twitter)){ ?>
            <a href="<?php echo $empresa->twitter?>" class="nav-link">
              <i class="fab fa-twitter"></i>
            </a>
          <?php } ?>
          <?php if (!empty($empresa->instagram)){ ?>
            <a href="<?php echo $empresa->instagram?>" class="nav-link">
              <i class="fab fa-instagram"></i>
            </a>
          <?php } ?>
          <?php if (!empty($empresa->youtube)){ ?>
            <a href="<?php echo $empresa->youtube?>" class="nav-link">
              <i class="fab fa-youtube"></i>
            </a>
          <?php } ?>
        </div>
      </div>
    </nav>
    <nav id="ts-primary-navigation" class="navbar navbar-expand-md navbar-light">
      <div class="container">
        <a class="navbar-brand" href="<?php echo mklink("/");?>">
          <img src="<?php echo "/sistema/".$empresa->logo_1;?>" class="logo" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPrimary" aria-controls="navbarPrimary" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarPrimary">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?php echo ($page_act=="home")?"active":"" ?>" href="<?php echo mklink("/");?>">
                Inicio
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($page_act=="ventas")?"active":"" ?>" href="<?php echo mklink ("propiedades/ventas/");?>">Ventas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($page_act=="alquileres")?"active":"" ?>" href="<?php echo mklink ("propiedades/alquileres/");?>">Alquileres</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($page_act=="emprendimientos")?"active":"" ?>" href="<?php echo mklink ("propiedades/emprendimientos/");?>">Emprendimientos</a>
            </li>
            <li class="nav-item ts-has-child">
              <a class="nav-link <?php echo ($page_act=="informacion")?"active":"" ?>">Información</a>
              <ul class="ts-child">
                <li class="nav-item">
                  <a href="<?php echo mklink ("entrada/sobre-nosotros-1699/")?>" class="nav-link">Tasaciones</a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo mklink ("entrada/tasaciones-1700/")?>" class="nav-link">Sobre Nosotros</a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link mr-2 <?php echo ($page_act=="contacto")?"active":"" ?>" href="<?php echo mklink("web/contacto");?>">Contacto</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</div>