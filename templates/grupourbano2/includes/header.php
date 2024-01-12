<header class="<?php echo (isset($nombre_pagina) && $nombre_pagina == "home") ? "sticky-header" : "" ?>">
  <div class="container style-two">
    <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand" href="<?php echo mklink("/"); ?> "><img src="assets/images/logo-header.png" alt="Grupo Urbano"></a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item <?php echo ($nombre_pagina == "ventas" ? "active" : "") ?>">
            <a class="nav-link" href="<?php echo mklink("propiedades/ventas/") ?>">Ventas</a>
            <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#0">Request an Offer</a>
              <a class="dropdown-item" href="#0">Sell and Stay</a>
              <a class="dropdown-item" href="#0">How it Works</a>
            </div> -->
          </li>
          <li class="nav-item <?php echo ($nombre_pagina == "ofertas" ? "active" : "") ?>">
            <a class="nav-link" href="<?php echo mklink("ofertas/") ?>">ofertas</a>
          </li>
          <li class="nav-item <?php echo ($nombre_pagina == "alquileres" ? "active" : "") ?>">
            <a class="nav-link" href="<?php echo mklink("propiedades/alquileres/") ?>">alquileres</a>
          </li>
          <li class="nav-item <?php echo ($nombre_pagina == "emprendimientos" ? "active" : "") ?>">
            <a class="nav-link" href="<?php echo mklink("propiedades/emprendimientos/") ?>">emprendimientos</a>
          </li>
          <li class="nav-item <?php echo ($nombre_pagina == "obras" ? "active" : "") ?>">
            <a class="nav-link" href="<?php echo mklink("propiedades/obras/") ?>">obras</a>
          </li>
          <li class="nav-item <?php echo ($nombre_pagina == "licitaciones" ? "active" : "") ?>">
            <a class="nav-link" href="<?php echo mklink("propiedades/licitaciones/") ?>">Licitaciones</a>
          </li>
          <li class="nav-item <?php echo ($nombre_pagina == "nosotros" ? "active" : "") ?>">
            <a class="nav-link" href="<?php echo mklink("web/vendedores") ?>">nosotros</a>
          </li>
        </ul>
        <!-- <a href="#0" class="btn">contacto</a> -->
        <div class="social">
          <?php if (!empty($empresa->facebook)) { ?>
            <a href="<?php echo $empresa->facebook ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          <?php } ?>
          <?php if (!empty($empresa->instagram)) { ?>
            <a href="<?php echo $empresa->instagram ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
          <?php } ?>
          <?php if (!empty($empresa->youtube)) { ?>
            <a href="<?php echo $empresa->youtube ?>"><i class="fa fa-play" aria-hidden="true"></i></a>
          <?php } ?>
        </div>
      </div>
    </nav>
  </div>
</header>