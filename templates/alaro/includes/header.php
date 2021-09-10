<?php if (!empty($empresa->gtm_body)) { echo html_entity_decode($empresa->gtm_body,ENT_QUOTES); } ?>

<header class="<?php echo (isset($header_style) ? $header_style : "") ?>">
  <div class="logo">
    <a href="<?php echo mklink("/"); ?>">
      <?php if ($nombre_pagina == "alquileres") {  ?>
        <img src="images/reyes.png" alt="Logo" />
      <?php } else { ?>
        <img src="<?php echo (isset($header_style) && !empty($header_style))?"images/logo1.png":"images/logo1.png" ?>" alt="Logo" />
      <?php } ?>
    </a>
  </div>
  <a href="javascript:void(0);" onClick="$('.header-right').slideToggle();" class="toggle-menu"><span></span> <span></span> <span></span></a>
  <div class="header-right">
    <nav>
      <ul>
        <li class="<?php echo($nombre_pagina=="proximos-proyectos" || $nombre_pagina=="proyectos-en-construccion")?"active":"" ?>">
          <a href="<?php echo mklink("propiedades/proximos-proyectos/"); ?>">Edificios en desarrollo</a> 
        <!--   <?php $proximos = $propiedad_model->get_list(array(
            "offset"=>8,
            "ids_tipo_operacion"=>array(6),
          ));
          if ((sizeof($proximos)>0) && $header_cat != "listado_new") { ?>
            <div class="top-carousel">
              <div class="container">
                <div class="products"> 
                  <?php foreach($proximos as $r) { ?>
                    <div class="feature-item">
                      <div class="feature-image"> 
                        <a href="<?php echo mklink($r->link); ?>">
                          <?php if (file_exists("/home/ubuntu/inmovar".$r->thumbnail)) { ?>
                            <img class="image-thumb-header" src="<?php echo $r->thumbnail ?>" alt="<?php echo $r->nombre ?>" />
                          <?php } else { ?>
                            <img class="image-thumb-header" src="/admin/<?php echo $r->path ?>" alt="<?php echo $r->nombre ?>" />
                          <?php } ?>
                        </a>
                        <div class="about-product"> 
                          <a href="<?php echo mklink($r->link); ?>">
                            <p><?php echo $r->calle ?><br>
                            <?php echo $r->localidad ?></p>
                          </a> 
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?> -->
        </li>
        
        <li class="<?php echo($nombre_pagina=="ventas")?"active":"" ?>">
          <a href="<?php echo mklink("propiedades/ventas/"); ?>">Venta de terminados</a>
        </li>
        <li class="<?php echo($nombre_pagina=="alquileres")?"active":"" ?>">
          <a href="<?php echo mklink("propiedades/alquileres/"); ?>">alquileres</a>
        </li>
        <li class="<?php echo($nombre_pagina=="proyectos-finalizados")?"active":"" ?>">
          <a href="<?php echo mklink("propiedades/proyectos-finalizados/"); ?>">Proyectos finalizados</a>
        </li>
        <!-- <li class="<?php echo($nombre_pagina=="alaro-residencias")?"active":"" ?>">
          <a href="<?php echo mklink("entradas/alaro-residencias/"); ?>">residencias</a>
        </li>
        <li class="<?php echo($nombre_pagina=="terminaciones")?"active":"" ?>">
          <a href="<?php echo mklink("web/terminaciones/"); ?>">terminaciones</a>
        </li>
        <li class="<?php echo($nombre_pagina=="quienes-somos")?"active":"" ?>">
          <a href="<?php echo mklink("entradas/quienes-somos/"); ?>">Nosotros</a>
        </li>
        <li class="<?php echo($nombre_pagina=="contacto")?"active":"" ?>">
          <a href="<?php echo mklink("contacto/"); ?>">Contacto</a>
        </li> -->
      </ul>
    </nav>
    <div class="header-social">
      <ul>
        <?php if (!empty($empresa->facebook)) { ?>
          <li><a href="<?php echo $empresa->facebook ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
        <?php } ?>
        <?php if (!empty($empresa->youtube)) { ?>
          <li><a href="<?php echo $empresa->youtube ?>" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
        <?php } ?>
        <?php if (!empty($empresa->instagram)) { ?>
          <li><a href="<?php echo $empresa->instagram ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</header>