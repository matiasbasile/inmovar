<header>
  <div class="row justify-content-between align-items-center">
    <div class="col-lg-2 col-6">
      <a class="logo" href="<?php echo mklink ("/") ?>"><img src="assets/images/logo.png" alt="Logo"></a>
    </div>
    <div class="col-lg-10 col-6">
      <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item <?php echo ($page_act == "ventas")?"active":"" ?>">
              <a class="nav-link" href="<?php echo mklink ("propiedades/ventas/") ?>">Comprar</a>
            </li>
            <li class="nav-item <?php echo ($page_act == "alquileres")?"active":"" ?>">
              <a class="nav-link" href="<?php echo mklink ("propiedades/alquileres/") ?>">Alquilar</a>
            </li>
            <li class="nav-item <?php echo ($page_act == "emprendimientos")?"active":"" ?>">
              <a class="nav-link" href="<?php echo mklink ("propiedades/emprendimientos/") ?>">Emprendimientos</a>
            </li>
            <li class="nav-item <?php echo ($page_act == "consorcio")?"active":"" ?>">
              <a class="nav-link" href="<?php echo mklink ("web/administracion/") ?>">Administración de Consorcio</a>
            </li>
            <li class="nav-item <?php echo ($page_act == "contacto")?"active":"" ?>">
              <a class="nav-link" href="<?php echo mklink ("contacto/") ?>">Contacto</a>
            </li>
          </ul>
          <div class="socials">
            <div class="phone-number">
              <a href="tel:<?php echo $empresa->telefono ?>"><img src="assets/images/phone-icon.png" alt="Phone Icon"><?php echo $empresa->telefono ?></a>
            </div>
            <ul>
              <?php if(!empty($empresa->facebook)) { ?><li><a taraget="_blank" href="<?php echo $empresa->facebook ?>"><i class="fab fa-facebook-f"></i></a></li><?php } ?>
              <?php if(!empty($empresa->instagram)) { ?><li><a taraget="_blank" href="<?php echo $empresa->instagram ?>"><i class="fab fa-instagram"></i></a></li><?php } ?>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
</header>