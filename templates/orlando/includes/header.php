<header class="header-default">
  <?php /*
  <div class="top-bar">
    <div class="container">
        <div class="top-bar-left left">
          <ul class="top-bar-item right social-icons">
            <?php if (!empty($empresa->facebook)) { ?><li><a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fa fa-facebook"></i></a></li><?php } ?>
            <?php if (!empty($empresa->twitter)) { ?><li><a target="_blank" href="<?php echo $empresa->twitter ?>"><i class="fa fa-twitter"></i></a></li><?php } ?>
            <?php if (!empty($empresa->youtube)) {  ?><li><a target="_blank" href="<?php echo $empresa->youtube ?>"><i class="fa fa-youtube"></i></a></li><?php } ?>
            <?php if (!empty($empresa->instagram)) {  ?><li><a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fa fa-instagram"></i></a></li><?php } ?>
          </ul>
          <div class="clear"></div>
        </div>
    </div>
  </div>
  */ ?>
  <div class="container">
    <div class="navbar-header">
      <div class="header-details">
        <div class="right clear">
          <a target="_blank" rel="nofollow" href="https://app.inmovar.com/admin/"><i class="fa fa-lock"></i> Entrar</a>
        </div>
        <div class="oh clear">
          <?php if (!empty($empresa->telefono)) { ?>
            <div class="header-item header-phone left">
              <table>
                <tr>
                  <td><i class="fa fa-phone"></i></td>
                  <td class="header-item-text">
                    Llamanos<br/>
                    <span><?php echo $empresa->telefono ?></span>
                  </td>
                </tr>
              </table>
            </div>
          <?php } ?>
          <div class="header-item header-phone left">
            <table>
              <tr>
                <td><i class="fa fa-envelope"></i></td>
                <td class="header-item-text">
                  Dejanos tu mensaje<br/>
                  <span><?php echo $empresa->email ?></span>
                </td>
              </tr>
            </table>
          </div>
          <?php if (!empty($empresa->facebook)) {  ?>
            <div class="header-item header-phone left">
              <table>
                <tr>
                  <td><a class="redes" target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fa fa-facebook"></i></a></td>
                </tr>
              </table>
            </div>
          <?php } ?>
          <?php if (!empty($empresa->instagram)) {  ?>
            <div class="header-item header-phone left">
              <table>
                <tr>
                  <td><a class="redes" target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fa fa-instagram"></i></a></td>
                </tr>
              </table>
            </div>
          <?php } ?>
          <div class="clear"></div>
        </div>
      </div>

      <a class="navbar-brand" href="<?php echo mklink ("/") ?>"><img src="/admin/<?php echo $empresa->logo_1 ?>" width=250 alt="Homely" /></a>

      <!-- nav toggle -->
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

    </div>

    <!-- main menu -->
    <div class="navbar-collapse collapse">
      <div class="main-menu-wrap">
        <div class="container-fixed">

        <div class="member-actions right">
          <a href="<?php echo mklink ("contacto/") ?>" class="button small alt button-icon"><i class="fa fa-plus"></i>Contacto</a>
        </div>
        <ul class="nav navbar-nav right">
          <li <?php echo ($page_active == "inicio")?'class="current-menu-item"' :'' ?>>
            <a href="<?php echo mklink ("/") ?>">Inicio</a>
          </li>
          <li <?php echo ($page_active == "alquileres")?'class="current-menu-item"' :'' ?>>
            <a href="<?php echo mklink ("propiedades/alquileres/") ?>">Alquileres</a>
          </li>
          <li <?php echo ($page_active == "ventas")?'class="current-menu-item"' :'' ?>>
            <a href="<?php echo mklink ("propiedades/ventas/") ?>">Ventas</a>
          </li>
          <?php /*
          <li <?php echo ($page_active == "emprendimientos")?'class="current-menu-item"' :'' ?>>
            <a href="<?php echo mklink ("propiedades/emprendimientos/") ?>">Emprendimientos</a>
          </li>
          
          <li <?php echo ($page_active == "alquileres-temporarios")?'class="current-menu-item"' :'' ?>>
            <a href="<?php echo mklink ("propiedades/alquileres-temporarios/") ?>">Alquileres Temporarios</a>
          </li>
          */ ?>
          
          <?php $cats = $entrada_model->get_subcategorias(0,array("activo"=>1)) ?>
          <?php foreach($cats as $c) { ?>
            <?php $entradas = $entrada_model->get_list(array("id_categoria"=>$c->id)); ?>
            <?php if (sizeof($entradas)>0) { ?>
              <?php 
              // Si tenemos exactamente una entrada, no ponemos submenu sino que lo hacemos en el mismo menu general
              if (sizeof($entradas) == 1) { 
                $r = $entradas[0]; ?>
                <li class="<?php echo ($page_active == $c->link)?'current-menu-item' :'' ?>">
                  <a href="<?php echo mklink ($r->link) ?>"><?php echo $r->titulo ?></a>
                </li>
              <?php } else { ?>
                <li class="menu-item-has-children <?php echo ($page_active == $c->link)?'current-menu-item' :'' ?>">
                  <a href="<?php echo mklink ("/") ?>"><?php echo ($c->nombre) ?></a>
                  <ul class="sub-menu">
                    <?php foreach ($entradas as $r) {  ?>
                      <li><a href="<?php echo mklink ($r->link) ?>"><?php echo $r->titulo ?></a></li>
                    <?php } ?>
                  </ul>
                </li>
              <?php } ?>
            <?php } ?>
          <?php } ?>
        </ul>
        <div class="clear"></div>
      </div>
      </div><!-- end main menu wrap -->
    </div><!-- end navbar collaspe -->
  </div><!-- end container -->
</header>