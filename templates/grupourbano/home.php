<?php
include_once("includes/init.php");
$nombre_pagina = "home";
include_once("includes/funciones.php");
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="home">

<!-- REVOLUTION SLIDER -->
<?php
// SLIDER PRINCIPAL
$slider = $web_model->get_slider();
?>
  <section class="revolution-container">
    <div class="revolution">
      <ul class="list-unstyled">
        <?php foreach ($slider as $r){ ?>
          <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
            <img src="<?php echo $r->path ?>" alt="Slide" data-bgfit="cover"  data-bgposition="center center" />
          </li>
        <?php } ?>
      </ul>
    </div>
  </section>

<?php include("includes/header.php"); ?>

<!-- LATEST PROPERTIES -->
<?php
// ULTIMAS PROPIEDADES
$ultimas = $propiedad_model->ultimas(array(
  "offset"=>8,
  "ids_tipo_operacion"=>array(1,2,4),
  "solo_propias"=>1,
));
if (sizeof($ultimas)>0) { ?>
  <section class="latest-properties">
    <div class="container">
      <div class="section-title"><big>&uacute;ltimas propiedades</big><small>agregadas a nuestra web</small></div>
      <div class="row">
        <div class="owl-carousel2">
          <?php foreach($ultimas as $r) {
            $clase = "";
            if ($r->id_tipo_operacion == 1) {
            } else if ($r->id_tipo_operacion == 2) {
              $clase = "for-rent"; // Alquileres
            } else if ($r->id_tipo_operacion == 4) {
              $clase = "for-enterprises"; // Emprendimientos
            } else if ($r->id_tipo_operacion == 5) {
              $clase = "works"; // Obras
            }
            ?>
            <div class="item-space">
              <div class="property-list <?php echo $clase; ?>">
                <div class="item-picture">
                  <div class="block">
                     <?php if (!empty($r->imagen)) { ?>
	                    <img class="alto" src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
	                  <?php } else if (!empty($empresa->no_imagen)) { ?>
	                    <img class="alto" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
	                  <?php } else { ?>
	                    <img class="alto" src="images/no-image-1.jpg" alt="<?php echo ($r->nombre); ?>" />
	                  <?php } ?>
                  </div>
                  <?php if ($r->id_tipo_estado != 1) { ?>
                    <div class="ribbon red"><?php echo ($r->tipo_estado) ?></div>
                  <?php } else { ?>
                    <div class="ribbon"><?php echo ($r->tipo_operacion) ?></div>
                  <?php } ?>
                  <?php if ($r->apto_banco == 1) { ?>
                    <div class="ribbon bottom left"><img style="position: relative; top: -2px" src="images/credito2.png"/> APTO BANCO</div>
                  <?php } ?>
                  <div class="view-more"><a href="<?php echo $r->link_propiedad ?>"></a></div>
                  <div class="property-info">
                    <?php if (!empty($r->dormitorios) || !empty($r->banios) || !empty($r->superficie_total)) { ?>
                      <div class="facilities">
                        <?php if (!empty($r->dormitorios)) { ?>
                          <div class="pull-left"><img src="images/bed-icon1.png" alt="Bed" /> <?php echo $r->dormitorios ?></div>
                        <?php } ?>
                        <?php if (!empty($r->banios)) { ?>
                          <div class="pull-left"><img src="images/shower-icon1.png" alt="Shower" /> <?php echo $r->banios ?></div>
                        <?php } ?>
                        <?php if (!empty($r->superficie_total)) { ?>
                          <div class="pull-left"><?php echo $r->superficie_total ?> m<sup>2</sup></div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                    <div class="property-address"><?php echo ($r->direccion_completa); ?></div>
                    <?php if (!empty($r->descripcion)) { ?>
                      <p><?php echo ((strlen($r->descripcion)>50) ? substr($r->descripcion,0,50)."..." : $r->descripcion); ?></p>
                    <?php } else {
                      $texto = strip_tags(html_entity_decode($r->texto,ENT_QUOTES)); ?>
                      <p><?php echo ((strlen($texto)>50) ? substr($texto,0,50)."..." : $texto); ?></p>                      
                    <?php } ?>
                    <div class="price">
                      <?php echo $r->precio ?>
                    </div>
                  </div>
                </div>
                <div class="info-inner">
                  <div class="property-title"><a href="<?php echo $r->link_propiedad ?>"><?php echo ($r->nombre); ?></a></div>
                  <?php if (!empty($r->subtitulo)) { ?>
                    <p class="property-subtitle"><?php echo $r->subtitulo ?></p>
                  <?php } ?>
                  <div class="property-address"><?php echo ($r->localidad); ?></div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="load-more">
        <div class="load-container">
          <div class="load-link">
            <a href="<?php echo mklink("propiedades/") ?>">m&aacute;s propiedades</a>
            <a href="<?php echo mklink("propiedades/") ?>">ver todas</a>
          </div>
          <a href="<?php echo mklink("propiedades/") ?>" class="arrow-link"></a>
        </div>
      </div>
    </div>
  </section>
<?php } ?>


<?php $marcas = $articulo_model->get_marcas(array("grupo"=>1)) ?>
<section class="bg-marcas">
  <div class="container">
    <div class="row">
      <div class="owl-carouselmarcas">
        <?php foreach ($marcas as $m) {  ?>
          <div class="item text-center">
            <img class="footer-marcas" src="<?php echo $m->path?>">
          </div>
        <?php }   ?>
      </div>
    </div>
  </div>
</section>


<?php
// PROPIEDADES DESTACADAS
$destacadas = $propiedad_model->destacadas(array(
  "ids_tipo_operacion"=>array(1,2,4),
  "solo_propias"=>1,
));
if (sizeof($destacadas)>0) { ?>
  <section class="featured-properties" style="background: #00293e">
    <div class="container">
      <div class="section-title white"><big>propiedades destacadas</big><small>alguna de las mejores propiedades</small></div>
      <div class="row">
        <div class="owl-carousel">
          <?php foreach($destacadas as $r) {
            $clase = "";
            if ($r->id_tipo_operacion == 1) {
            } else if ($r->id_tipo_operacion == 2) {
              $clase = "for-rents"; // Alquileres
            } else if ($r->id_tipo_operacion == 4) {
              $clase = "for-enterprises"; // Emprendimientos
            } else if ($r->id_tipo_operacion == 5) {
              $clase = "works"; // Obras
            }
            ?>
            <div class="item-space">
              <div class="property-list <?php echo $clase; ?>">
                <div class="item-picture">
                  <div class="block">
	                  <?php if (!empty($r->imagen)) { ?>
	                    <img class="alto" src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
	                  <?php } else if (!empty($empresa->no_imagen)) { ?>
	                    <img class="alto" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
	                  <?php } else { ?>
	                    <img class="alto" src="images/no-image-1.jpg" alt="<?php echo ($r->nombre); ?>" />
	                  <?php } ?>
                  </div>
                  <?php if ($r->id_tipo_estado != 1) { ?>
                    <div class="ribbon red"><?php echo ($r->tipo_estado) ?></div>
                  <?php } else { ?>
                    <div class="ribbon"><?php echo ($r->tipo_operacion) ?></div>
                  <?php } ?>
                  <?php if ($r->apto_banco == 1) { ?>
                    <div class="ribbon bottom"><img style="position: relative; top: -2px" src="images/credito2.png"/> APTO BANCO</div>
                  <?php } ?>
                  <div class="blue-overlay"><a href="<?php echo $r->link_propiedad ?>"></a></div>
                </div>
                <div class="property-info">
                  <div class="info-inner">
                    <div class="property-title"><a href="<?php echo $r->link_propiedad ?>"><?php echo ($r->nombre); ?></a></div>
                    <?php if (!empty($r->subtitulo)) { ?>
                      <p class="property-subtitle"><?php echo $r->subtitulo ?></p>
                    <?php } ?>
                    <div class="property-address">
                      <?php echo ($r->direccion_completa." | ".$r->localidad); ?>
                    </div>
                    <?php if (!empty($r->descripcion)) { ?>
                      <p><?php echo ((strlen($r->descripcion)>80) ? substr($r->descripcion,0,80)."..." : $r->descripcion); ?></p>
                    <?php } else {
                      $texto = strip_tags(html_entity_decode($r->texto,ENT_QUOTES)); ?>
                      <p><?php echo ((strlen($texto)>80) ? substr($texto,0,80)."..." : $texto); ?></p>
                    <?php } ?>
                  </div>
                  <?php if (!empty($r->dormitorios) || !empty($r->banios) || !empty($r->superficie_total) || $r->precio_final != 0) { ?>
                    <div class="facilities">
                      <?php if (!empty($r->dormitorios)) { ?>
                        <div class="pull-left"><img src="images/bed-icon1.png" alt="Bed" /> <?php echo $r->dormitorios ?></div>
                      <?php } ?>
                      <?php if (!empty($r->banios)) { ?>
                        <div class="pull-left"><img src="images/shower-icon1.png" alt="Shower" /> <?php echo $r->banios ?></div>
                      <?php } ?>
                      <?php if (!empty($r->superficie_total)) { ?>
                        <div class="pull-left"><?php echo $r->superficie_total ?> m<sup>2</sup></div>
                      <?php } ?>
                      <div class="price">
                        <?php echo $r->precio ?>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>
<?php } ?>

<section class="services">
  <div class="container">
    <div class="row">
      <?php $list = $entrada_model->get_list(array("from_link_categoria"=>"home"))?>
      <?php foreach ($list as $l) {  ?>
        <div class="col-md-4">
          <div class="service-item">
            <?php if (!empty($r->path_2)) { ?>
              <div class="item-picture">
                <div class="block"><img src="/admin/<?php echo $r->path_2 ?>" alt="<?php echo ($r->titulo_es); ?>" /></div>
                <div class="black-overlay"><a href="<?php echo mklink($r->link); ?>"></a></div>
              </div>
            <?php } ?>
            <div class="service-info">
              <div class="service-name"><a href="<?php echo mklink($r->link); ?>"><?php echo ($r->titulo_es); ?></a></div>
              <p><?php echo ($r->breve_es); ?></p>
            </div>
          </div>
        </div>
      <?php } ?>
      
      <div class="col-md-4">
        <div class="service-item">
          <div class="item-picture" style="align-self: center;">
            <div class="block">
              <?php $t = $web_model->get_text("service-1-img-","images/firma.jpg")?>
              <img class="editable editable-img cover-avisos" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" src="<?php echo $t->plain_text ?>" alt="Nuestros avisos" />
            </div>
            <div class="black-overlay"><a href="<?php echo mklink("entrada/requisitos-para-alquilar-32729") ?>"></a></div>
          </div>
          <div class="service-info" style="align-self: center;">
            <div class="service-name">
              <div class="property-title">
                <?php $t = $web_model->get_text("service-1-txt","REQUISITOS<br> PARA ALQUILAR")?>
                <a class="editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" href="<?php echo mklink("entrada/requisitos-para-alquilar-32729") ?>"><?php echo $t->plain_text ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-item">
          <div class="item-picture" style="align-self: center;">
            <div class="block">
              <?php $t = $web_model->get_text("service-2-img-","images/avisos.jpg")?>
              <img class="editable editable-img cover-avisos" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" src="<?php echo $t->plain_text ?>" alt="Nuestros avisos" />
            </div>
            <div class="black-overlay"><a href="<?php echo mklink("entradas/avisos/") ?>"></a></div>
          </div>
          <div class="service-info" style="align-self: center;">
            <div class="service-name">
              <div class="property-title">
                <?php $t = $web_model->get_text("service-2-txt","NUESTROS AVISOS")?>
                <a class="editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" href="<?php echo mklink("entradas/avisos/") ?>"><?php echo $t->plain_text ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-item">
          <div class="item-picture" style="align-self: center;">
            <div class="block">
              <?php $t = $web_model->get_text("service-3-img-","images/novedades.jpg")?>
              <img class="editable editable-img cover-avisos" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" src="<?php echo $t->plain_text ?>" alt="Nuestros avisos" />
            </div>
            <div class="black-overlay"><a href="<?php echo mklink("entradas/novedades/") ?>"></a></div>
          </div>
          <div class="service-info" style="align-self: center;">
            <div class="service-name">
              <div class="property-title">
                <?php $t = $web_model->get_text("service-3-txt","ÚLTIMAS<br>NOVEDADES")?>
                <a class="editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" href="<?php echo mklink("entradas/novedades/") ?>"><?php echo $t->plain_text ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>

      
    </div>
  </div>
</section>

<!-- <section class="our-works" style="padding-bottom: 0px">
  <div class="container">
    <div class="section-title"><big>calcula tu cr&eacute;dito</big><small>Cr&eacute;ditos hipotecarios UVA</small></div>
    <div class="row store-items">
      <div class="col-md-4 col-xs-6 animation-fadeInQuick" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick" data-element-offset="-100">
        <a href="http://www.hipotecario.com.ar/" target="_blank" class="store-item">
          <div class="store-item-icon">
            <img src="images/BancoHipotecario.jpg" alt="Banco Hipotecario" width="160" height="91">
          </div>
          <div class="store-item-info clearfix">
            <strong>Banco Hipotecario</strong><br>
          </div>
        </a>
      </div>
      <div class="col-md-4 col-xs-6 animation-fadeInQuick" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick" data-element-offset="-100">
        <a href="https://www.bna.com.ar/Simulador/SubInterna/SimuladorPrestamosCreditosUVA?subInterna=SimuladorPrestamosCreditosUVA" target="_blank" class="store-item">
          <div class="store-item-icon">
            <img src="images/nacion.jpg" alt="Banco Nacion" width="160" height="91">
          </div>
          <div class="store-item-info clearfix">
            <strong>Banco Naci&oacute;n</strong><br>
          </div>
        </a>
      </div>
      <div class="col-md-4 col-xs-6 animation-fadeInQuick" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick" data-element-offset="-100">
        <a href="http://www.bancociudad.com.ar/" target="_blank" class="store-item">
        <div class="store-item-icon">
          <img src="images/BancoCiudad.jpg" alt="Banco Ciudad" width="160" height="91">
        </div>
        <div class="store-item-info clearfix">
          <strong>Banco Ciudad</strong><br>
        </div>
          </a>
      </div>
      <div class="col-md-4 col-xs-6 animation-fadeInQuick" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick" data-element-offset="-100">
        <a href="https://www.bancoprovincia.com.ar/" target="_blank" class="store-item">
          <div class="store-item-icon">
            <img src="images/BancoProvincia.jpg" alt="Banco Provincia" width="160" height="91">
          </div>
          <div class="store-item-info clearfix">
            <strong>Banco Provincia</strong><br>
          </div>
        </a>
      </div>
      <div class="col-md-4 col-xs-6 animation-fadeInQuick" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick" data-element-offset="-100">
        <a href="http://www.bancogalicia.com/" target="_blank" class="store-item">
          <div class="store-item-icon">
            <img src="images/BancoGalicia.jpg" alt="Banco Galicia" width="160" height="91">
          </div>
          <div class="store-item-info clearfix">
            <strong>Banco Galicia</strong><br>
          </div>
        </a>
      </div>
      <div class="col-md-4 col-xs-6 animation-fadeInQuick" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick" data-element-offset="-100">
        <a href="https://www.santanderrio.com.ar/" target="_blank" class="store-item">
          <div class="store-item-icon">
            <img src="images/BancoSantander.jpg" alt="Banco Santander Rio" width="160" height="91">
          </div>
          <div class="store-item-info clearfix">
            <strong>Banco Santander Rio</strong><br>
          </div>
        </a>
      </div>
    </div>
  </div>
</section> -->

<?php
$obras_destacadas = $propiedad_model->get_list(array(
  "offset"=>3,
  "destacado"=>1,
  "id_tipo_operacion"=>5,
  "solo_propias"=>1,
));

$obras_normales = $propiedad_model->get_list(array(
  "offset"=>((sizeof($obras_destacadas)>0) ? 2 : 4),
  "destacado"=>0,
  "id_tipo_operacion"=>5,
  "solo_propias"=>1,
));

if (!empty($obras_destacadas) || !empty($obras_normales)) { ?>
  <section class="our-works">
    <div class="container">
      <div class="section-title"><big>nuestras obras</big><small>Desarrollos Inmobiliarios</small></div>
      <div class="row">
        <?php foreach($obras_normales as $r) { ?>
          <div class="col-md-3">
            <div class="property-list">
              <div class="item-picture">
                <div class="block">
                  <?php if (!empty($r->imagen)) { ?>
                    <img class="thumb-image" src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                  <?php } else if (!empty($empresa->no_imagen)) { ?>
                    <img class="thumb-image" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                  <?php } else { ?>
                    <img class="thumb-image" src="images/no-image-1.jpg" alt="<?php echo ($r->nombre); ?>" />
                  <?php } ?>
                </div>
              </div>
              <div class="property-info">
                <div class="info-inner">
                  <div class="price">
                    <?php echo ($r->precio == 0)?"Consultar":$r->precio ?>
                  </div>                
                  <div class="property-title"><a href="<?php echo $r->link_propiedad ?>"><?php echo ($r->nombre); ?></a></div>
                  <div class="property-address"><?php echo ($r->direccion_completa); ?></div>
                  <?php if (!empty($r->descripcion)) { ?>
                    <p><?php echo ((strlen($r->descripcion)>80) ? (substr($r->descripcion,0,80))."..." : ($r->descripcion)); ?></p>
                  <?php } else {
                    $texto = (strip_tags(html_entity_decode($r->texto,ENT_QUOTES))); ?>
                    <p><?php echo ((strlen($texto)>80) ? substr($texto,0,80)."..." : $texto); ?></p>                  
                  <?php } ?>
                </div>
                <div class="facilities">
                  <?php if (!empty($r->dormitorios)) { ?>
                    <div class="pull-left beadroom"><?php echo $r->dormitorios ?></div>
                  <?php } ?>
                  <?php if (!empty($r->banios)) { ?>
                    <div class="pull-left shower"><?php echo $r->banios ?></div>
                  <?php } ?>
                  <?php if (!empty($r->superficie_total)) { ?>
                    <div class="pull-left"><?php echo $r->superficie_total ?> m<sup>2</sup></div>
                  <?php } ?>
                  <div class="view-more"><a href="<?php echo $r->link_propiedad; ?>"></a></div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        <?php if (!empty($obras_destacadas)) { ?>
          <div class="col-md-6">
            <div class="flexslider">
              <ul class="slides">
                <?php foreach($obras_destacadas as $r) { ?>
                  <li>
                    <div class="property-list half-list">
                      <div class="item-picture">
                        <div class="block">
                           <?php if (!empty($r->imagen)) { ?>
		                    <img class="thumb-image" src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
		                  <?php } else if (!empty($empresa->no_imagen)) { ?>
		                    <img class="thumb-image" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
		                  <?php } else { ?>
		                    <img class="thumb-image" src="images/no-image-1.jpg" alt="<?php echo ($r->nombre); ?>" />
		                  <?php } ?>
                        </div>
                      </div>
                      <div class="property-info">
                        <div class="price">
                          <?php echo ($r->localidad) ?>
                        </div>
                        <div class="info-inner">
                          <div class="property-title"><a href="<?php echo $r->link_propiedad ?>"><?php echo ($r->nombre); ?></a></div>
                          <div class="property-address"><?php echo ($r->direccion_completa); ?></div>
                          <?php if (!empty($r->descripcion)) { ?>
                            <p><?php echo ((strlen($r->descripcion)>80) ? substr($r->descripcion,0,80)."..." : $r->descripcion); ?></p>
                          <?php } else {
                            $texto = strip_tags(html_entity_decode($r->texto,ENT_QUOTES)); ?>
                            <p><?php echo ((strlen($texto)>80) ? substr($texto,0,80)."..." : $texto); ?></p>                            
                          <?php } ?>
                        </div>
                        <div class="facilities">
                          <?php if (!empty($r->dormitorios)) { ?>
                            <div class="pull-left beadroom"><?php echo $r->dormitorios ?></div>
                          <?php } ?>
                          <?php if (!empty($r->banios)) { ?>
                            <div class="pull-left shower"><?php echo $r->banios ?></div>
                          <?php } ?>
                          <?php if (!empty($r->superficie_total)) { ?>
                            <div class="pull-left"><?php echo $r->superficie_total ?> m<sup>2</sup></div>
                          <?php } ?>
                          <div class="view-more"><a href="<?php echo $r->link_propiedad ?>"></a></div>
                        </div>
                      </div>
                    </div>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="load-more">
        <div class="load-container">
          <div class="load-link">
            <a href="<?php echo mklink("propiedades/obras/") ?>">m&aacute;s propiedades</a>
            <a href="<?php echo mklink("propiedades/obras/") ?>">ver todas</a>
          </div>
          <a href="<?php echo mklink("propiedades/obras/") ?>" class="arrow-link"></a> </div>
      </div>
    </div>
  </section>
<?php } ?>

<?php include("includes/footer.php"); ?>

<!-- SCRIPT'S --> 
<script type="text/javascript" src="js/flexslider.js"></script> 
<script type="text/javascript" src="js/revolution.js"></script> 
<script type="text/javascript" src="js/tap.js"></script> 
<script type="text/javascript">
//FLEXSLIDER SCRIPT
$(window).load(function(){
  $('.flexslider').flexslider({
    animation: "slide",
    start: function(slider){
    $('body').removeClass('loading');
    }
  });
});
</script> 
<script type="text/javascript">
//REVOLUTION SLIDER SCRIPT
jQuery('.revolution').revolution({
	delay: 9000,
	startwidth: 1170,
	startheight: 650,
	hideThumbs: 10,
	fullWidth: "on",
	fullScreen: "on",
	navigationType: "bullet",
	navigationArrows: "solo",
	navigationStyle: "round",
	navigationHAlign: "center",
	navigationVAlign: "bottom",
	navigationHOffset: 30,
	navigationVOffset: 30,
	soloArrowLeftHalign: "left",
	soloArrowLeftValign: "center",
	soloArrowLeftHOffset: 20,
	soloArrowLeftVOffset: 0,
	soloArrowRightHalign: "right",
	soloArrowRightValign: "center",
	soloArrowRightHOffset: 20,
	soloArrowRightVOffset: 0,
	touchenabled: "on"
});

//TABS SCRIPT
 $('.tabs .tab-buttons').each(function(){
    var $active, $content, $links = $(this).find('a');
    $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
    $active.addClass('active');
    $content = $($active[0].hash);
    $links.not($active).each(function () {
      $(this.hash).hide();
    });
    $(this).on('click', 'a', function(e){
      $active.removeClass('active');
      $content.hide();
      $active = $(this);
      $content = $(this.hash).show();
      $active.addClass('active');
      $content.show();
      e.preventDefault();
    });
});

//OWL CAROUSEL(2) SCRIPT
jQuery(document).ready(function ($) {
"use strict";
$(".owl-carousel2").owlCarousel({
      items : 4,
      itemsDesktop : [1279,2],
      itemsDesktopSmall : [979,2],
      itemsMobile : [639,1],
    });
});

//OWL CAROUSEL(2) SCRIPT
jQuery(document).ready(function ($) {
"use strict";
$(".owl-carouselmarcas").owlCarousel({
      items : 5,
      itemsDesktop : [1279,2],
      itemsDesktopSmall : [979,2],
      itemsMobile : [639,1],
    });
});

$(document).ready(function(){
  var maximo = 0;
  $(".our-works .info-inner").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".our-works .info-inner").height(maximo);

  maximo = 0;
  $(".latest-properties .info-inner").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".latest-properties .info-inner").height(maximo);
});

</script>
<script type="text/javascript">
 if (jQuery(window).width()>767) { 

  $(document).ready(function(){
    var maximo = 0;
    $(".alto-foot").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".alto-foot").height(maximo);
  });
}
</script>
</body>
</html>