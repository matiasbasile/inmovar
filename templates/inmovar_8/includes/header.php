<?php
$cant_favoritos = 0;
if (isset($_SESSION["favoritos"])) {
  $arr = explode(",",$_SESSION["favoritos"]);
  $cant_favoritos = sizeof($arr)-1;
}
?>
<header class="menacho_header">
  <div class="container-fluid">
    <div class="main-header">
      <div class="row flex-center">
        <div class="col-lg-3 col-sm-6">
          <div class="menacho_logo p0">
            <a href="<?php echo mklink ("/") ?>"><img style="max-width: 220px" src="<?php echo '/admin/'.$empresa->logo_1 ?>" alt="logo"></a>
          </div>
        </div>
        <div class="col-lg-9 col-sm-6">
          <div class="menacho_navbar">
            <div class="main_nav">
              <nav class="navbar navbar-expand-lg"> 
                <!-- <a class="navbar-brand" href="#">Navbar</a> -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menachonavbars" aria-controls="menachonavbars" aria-expanded="false" aria-label="Toggle navigation"> <i class="fa fa-bars" aria-hidden="true"></i> </button>
                <div class="collapse navbar-collapse" id="menachonavbars">
                  <div class="logo_closebtn">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menachonavbars" aria-controls="menachonavbars" aria-expanded="false" aria-label="Toggle navigation"> <i class="fa fa-times" aria-hidden="true"></i> </button>
                    <div class="inner_mobile_logo">
                      <a href="<?php echo mklink ("/") ?>"><img src="<?php echo '/admin/'.$empresa->logo_1 ?>" alt="logo"></a>
                    </div>
                  </div>
                  <ul class="navbar-nav">

                    <?php $categorias_informacion = $entrada_model->get_subcategorias(186)?>
                    <?php if (!empty($categorias_informacion)) {  ?>
                      <li class="nav-item dropdown"> <a class=" dropdown-toggle <?php echo ($titulo_pagina == "informacion")?"active":"" ?>" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Informacion</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown09">
                          <ul class="sub-menu-ul">
                            <?php foreach ($categorias_informacion as $cat) {  ?>
                              <li class="dropdown-submenu">
                                <a href="<?php echo mklink ("entradas/$cat->link/") ?>"><?php echo utf8_encode($cat->nombre) ?></a>
                                <?php /*$listado_catsmenu = $entrada_model->get_list(array("offset"=>3,"from_id_categoria"=>$cat->id ))?>
                                  <ul class="dropdown-menu">
                                    <?php foreach ($listado_catsmenu as $l) {  ?><li><a href="<?php echo mklink ($l->link) ?>"><?php echo $l->titulo ?></a></li><?php } ?>
                                  </ul>
                                  */ ?>
                              </li>
                            <?php } ?>
                          </ul>
                        </div>
                      </li>
                    <?php } ?>

                    <li class="nav-item"> <a class="<?php echo $titulo_pagina == "ventas"?"active":"" ?>" href="<?php echo mklink ("propiedades/ventas/") ?>"> VENTAS </a> </li>

                    <?php if ($tiene_alquileres == 1) { ?>
                      <li class="nav-item"> <a class="<?php echo $titulo_pagina == "alquileres"?"active":"" ?>" href="<?php echo mklink ("propiedades/alquileres/") ?>"> ALQUILERES</a> </li>
                    <?php } ?>

                    <?php if ($tiene_alquileres_temporarios == 1) { ?>
                      <li class="nav-item"> <a class="<?php echo $titulo_pagina == "alquileres-temporarios"?"active":"" ?>" href="<?php echo mklink ("propiedades/alquileres-temporarios/") ?>"> ALQUILERES TEMPORARIOS</a> </li>
                    <?php } ?>

                    <?php if ($tiene_emprendimientos == 1) { ?>
                      <li class="nav-item"> <a class="<?php echo $titulo_pagina == "emprendimientos"?"active":"" ?>" href="<?php echo mklink ("propiedades/emprendimientos/") ?>"> EMPRENDIMIENTOS</a> </li>
                    <?php } ?>

                    <?php if (isset($sobre_nosotros) && $sobre_nosotros != null) { ?>
                      <li class="nav-item"> <a class="<?php echo $titulo_pagina == "sobre_nosotros"?"active":"" ?>" href="<?php echo mklink ($sobre_nosotros->link) ?>"> SOBRE NOSOTROS</a> </li>
                    <?php } ?>
                    
                    <li class="nav-item"> <a class="<?php echo $titulo_pagina == "contacto"?"active":"" ?>" href="<?php echo mklink ("contacto/") ?>"> contacto</a> </li>
                  </ul>
                </div>
              </nav>
            </div>
            <div class="social_header">
              <ul>
                <?php if (!empty($empresa->facebook)) { ?>
                  <li> 
                    <a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                  </li>
                <?php } ?>
                <?php if (!empty($empresa->instagram)) { ?>
                  <li>
                    <a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                  </li>
                <?php } ?>
                <li> 
                  <a href="<?php echo mklink("favoritos/"); ?>" class="<?php echo ($cant_favoritos > 0)?"active":"" ?>">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    <?php if ($cant_favoritos > 0) { ?>
                      <span class="count"><?php echo $cant_favoritos; ?></span>
                    <?php } ?>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>