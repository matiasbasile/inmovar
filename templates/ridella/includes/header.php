<?php
$localidades = $propiedad_model->get_localidades(array(
  "id_departamento"=>(isset($vc_id_departamento) ? $vc_id_departamento : 0),
));
$departamentos = $propiedad_model->get_departamentos();
$tipos_propiedades = $propiedad_model->get_tipos_propiedades();
?>
<!-- Secondary Header -->
<div class="secondary-header">
  <div class="container">
    <div class="contact-info">
      <ul>
        <?php if (!empty($empresa->telefono)) {  ?><li><i class="fas fa-mobile-alt"></i><a href="tel:<?php echo $empresa->telefono ?>"><?php echo $empresa->telefono ?></a></li><?php } ?>
         <?php if (!empty($empresa->email)) { ?><li><i class="fas fa-envelope"></i><a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a></li><?php } ?>
      </ul>
    </div>
    <div class="pull-right">
      <div class="socials">
        <ul>
          <?php if (!empty($empresa->facebook)) {  ?><li><a target="_BLANK" href="<?php echo $empresa->facebook ?>"><i class="fab fa-facebook-f"></i></a></li><?php } ?>
          <?php if (!empty($empresa->instagram)) {  ?><li><a target="_BLANK" href="<?php echo $empresa->instagram ?>"><i class="fab fa-instagram"></i></a></li><?php } ?>
         <li><a href="javascript:void(0);"><i class="fa fa-heart"></i></a></li>
        </ul>
      </div>
      <div class="btn-right">
        <a class="btn btn-red" href="<?php echo mklink ("contacto/") ?>">contacto</a>
      </div>
    </div>
  </div>
</div>

<!-- Header -->
<header>
  <div class="container">
    <div class="logo">
      <a href="<?php echo mklink ("/") ?>"><img src="/admin/<?php echo $empresa->logo_1 ?>"></a>
    </div>
    <a href="javascript:void(0);" onClick="$('header nav').slideToggle();" class="toggle-menu"><span></span> <span></span> <span></span></a>
    <nav>
      <ul>
        <li><a href="<?php echo mklink ("/") ?>" class="home"><i class="fas fa-home"></i></a></li>
        <li><a href="<?php echo mklink ("propiedades/ventas/") ?>">ventas</a></li>
        <li><a href="<?php echo mklink ("propiedades/alquileres/") ?>">alquileres</a></li>
        <li><a href="<?php echo mklink ("propiedades/ventas/todas/?tp=7") ?>">Lotes</a>
        <li><a href="<?php echo mklink("propiedades/ventas/punta-del-este/"); ?>">punta del este</a></li>
        <li><a href="<?php echo mklink("propiedades/ventas/miami/"); ?>">Miami</a></li>
        <li><a href="javascript:void(0);" class="search"><i class="fas fa-search"></i></a>
          <div class="search-box">
            <div role="form" class="wpcf7">
              <div class="screen-reader-response"></div>
              <form action="<?php echo mklink ("propiedades/") ?>" method="get" class="wpcf7-form" enctype="multipart/form-data" novalidate>
                <p>
                  <span class="wpcf7-form-control-wrap name">
                    <input class="form-control" name="filter" value="<?php echo (isset($vc_filter) ? $vc_filter : "") ?>" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" type="text" id="seach" placeholder="Qué buscás?">
                  </span>
                </p>
              </form>
            </div>
         </div>
        </li>
      </ul>
      <div class="socials">
        <ul>
          <?php if (!empty($empresa->facebook)) {  ?><li><a target="_BLANK" href="<?php echo $empresa->facebook ?>"><i class="fa fa-facebook"></i></a></li><?php } ?>
          <?php if (!empty($empresa->twitter)) {  ?><li><a target="_BLANK" href="<?php echo $empresa->twitter ?>"><i class="fa fa-twitter"></i></a></li><?php } ?>
         <li><a href="javascript:void(0);"><i class="fa fa-heart"></i></a></li>
        </ul>
      </div>
    </nav>    
  </div>
</header>