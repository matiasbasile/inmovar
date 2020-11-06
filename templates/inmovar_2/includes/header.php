<?php $categorias_paginas = $entrada_model->get_subcategorias(0); ?>
<!-- Main header start -->
<header class="main-header">
  <div class="container">
    <nav class="navbar navbar-default">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navigation" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="<?php echo mklink ("/") ?>" class="logo1">
          <img src="/admin/<?php echo $empresa->logo_1 ?>" alt="logo">
        </a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="navbar-collapse collapse" role="navigation" aria-expanded="true" id="app-navigation">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown <?php echo ($titulo_pagina == "Inicio") ? "active" : "" ?>">
            <a href="<?php echo mklink ("/") ?>">
              Inicio
            </a>
          </li>
          <li class="dropdown <?php echo ($titulo_pagina == "Ventas") ? "active" : "" ?>">
            <a href="<?php echo mklink ("propiedades/ventas/")?>">
              Ventas
            </a>
          </li>
          <li class="dropdown <?php echo ($titulo_pagina == "Alquileres") ? "active" : "" ?>">
            <a href="<?php echo mklink ("propiedades/alquileres/")?>">
              Alquileres
            </a>
          </li>
          <?php if ($empresa->id == 612) { ?>
            <li class="dropdown <?php echo ($titulo_pagina == "Alquileres Temporarios") ? "active" : "" ?>">
              <a href="<?php echo mklink ("propiedades/alquileres-temporarios/")?>">
                Alquileres Temporarios
              </a>
            </li>
          <?php } ?>
          <?php if (sizeof($categorias_paginas)>0) { ?>
            <li class="dropdown <?php echo ($titulo_pagina == "Páginas") ? "active" : "" ?>">
              <a tabindex="0" data-toggle="dropdown" data-submenu="" aria-expanded="false">
                Informaci&oacute;n <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <?php foreach ($categorias_paginas as $c) { 
                  $entradas = $entrada_model->get_list(array(
                    "id_categoria"=>$c->id
                  ));
                  if (sizeof($entradas)>0) {
                    foreach($entradas as $e) { ?>
                      <li class="dropdown-submenu">
                        <a href="<?php echo mklink($e->link) ?>"><?php echo ($e->titulo) ?></a>
                      </li>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
          <li class="dropdown <?php echo ($titulo_pagina == "Contacto") ? "active" : "" ?>">
            <a href="<?php echo mklink ("contacto/") ?>">
              Contacto
            </a>
          </li>
        </ul>
        <?php /*
        <ul class="nav navbar-nav navbar-right rightside-navbar">
          <li>
            <a href="javascript:void(0);" class="button">
              Compartir mi propiedad
            </a>
          </li>
        </ul>
        */ ?>
      </div>
      <!-- /.navbar-collapse -->
      <!-- /.container -->
    </nav>
  </div>
</header>
<!-- Main header end -->