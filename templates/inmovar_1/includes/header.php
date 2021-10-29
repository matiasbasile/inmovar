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
        <!--
        <div class="actions">
          <a href="create-agency.html" class="promoted">Create Agency</a>
          <a href="create-account.html" class="promoted"><strong>Register</strong></a>
          <a href="sign-in.html">Sign In</a>
        </div>
        -->
        <div class="language-bar">
          <a href="<?php echo mklink("favoritos/"); ?>">
            <?php if ($cant_favoritos>0) { ?>
              <i class="fa fa-heart"></i>
            <?php } else { ?>
              <i class="fa fa-heart-o"></i>
            <?php } ?>
            <span>(<?php echo $cant_favoritos ?>)</span>
            <span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span>
          </a>
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
          <li class="<?php echo ($nombre_pagina=="home")?"active":"" ?>">
            <a href="<?php echo mklink("/"); ?>">Inicio</a>
          </li>
          <li class="<?php echo ($nombre_pagina=="ventas")?"active":"" ?>">
            <a href="<?php echo mklink("propiedades/ventas/"); ?>">Ventas</a>
          </li>
          <li class="<?php echo ($nombre_pagina=="alquileres")?"active":"" ?>">
            <a href="<?php echo mklink("propiedades/alquileres/"); ?>">Alquileres</a>
          </li>
          
          <?php $emprendimientos = $propiedad_model->get_list(array(
            "solo_propias"=>1,
            "id_tipo_operacion"=>4
          )); 
          if (sizeof($emprendimientos)>0) { ?>
            <li class="<?php echo ($nombre_pagina=="emprendimientos")?"active":"" ?>">
              <a href="<?php echo mklink("propiedades/emprendimientos/"); ?>">Emprendimientos</a>
            </li>
          <?php } ?>

          <?php
          $cat_entradas = $web_model->get_categorias(0);
          if (sizeof($cat_entradas)>0) {
            foreach($cat_entradas as $r) { 
              $entradas = $entrada_model->get_list(array(
                "offset"=>9999,
                "id_categoria"=>$r->id,
              ));
              if (sizeof($entradas)>0) { ?>
                <li class="<?php echo ($nombre_pagina==$r->nombre)?"active":"" ?> has-child">
                  <a href="<?php echo mklink("entradas/$r->link/") ?>"><?php echo ($r->nombre)?></a>
                  <ul class="child-navigation">
                    <?php foreach($entradas as $ent) { ?>
                      <li><a href="<?php echo mklink($ent->link); ?>"><?php echo ($ent->titulo) ?></a></li>
                    <?php } ?>
                  </ul>
                </li>
              <?php } else { ?>
                <li class="<?php echo ($nombre_pagina==$r->nombre)?"active":"" ?>">
                  <a href="<?php echo mklink("entradas/$r->link/") ?>"><?php echo ($r->nombre)?></a>
                </li>
              <?php } ?>
            <?php } ?>
          <?php } ?>
          <li class="<?php echo ($nombre_pagina=="contacto")?"active":"" ?>">
            <a href="<?php echo mklink("contacto/"); ?>">Contacto</a>
          </li>
        </ul>
      </nav><!-- /.navbar collapse-->
      <?php /*
      <div class="add-your-property">
        <a href="submit.html" class="btn btn-default"><i class="fa fa-plus"></i><span class="text">Add Your Property</span></a>
      </div>
      */ ?>
    </header><!-- /.navbar -->
  </div><!-- /.container -->
</div>