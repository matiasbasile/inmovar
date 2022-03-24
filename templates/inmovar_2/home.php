<?php
include "includes/init.php"; 
$titulo_pagina = "Inicio";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include "includes/head.php" ?>
<link rel="stylesheet" type="text/css" href="css/nivoslider.css">
</head>
<body>
    <?php include "includes/header.php" ?>
    <!-- Banner start -->
    
    <?php if ($empresa->id == 1502) { 
      $slider = $web_model->get_slider(array(
        "clave"=>"slider_1",
        ));
        if (sizeof($slider)>0) { ?>
           <div id="slider" class="nivoSlider"> 
            <?php foreach ($slider as $s) {  ?>
              <a href="<?php echo (!empty($s->link_1))?$s->link_1:"javascript:void(0)"?>"><img src="<?php echo $s->path ?>" data-thumb="<?php echo $s->path ?>" alt="" /> </a>
            <?php } ?>
           </div>
        <?php } ?>
    <?php } else { ?>
      <div class="banner">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <?php $i=0; foreach ($sliders as $s) { $i++;  ?>
            <div class="item <?php echo ($i == 1) ? "active" : "" ?> <?php echo (!empty($s->linea_1) ? "sombreado" : "") ?>">
              <img src="<?php echo $s->path ?>">
              <div class="carousel-caption banner-slider-inner banner-top-align">
                <div class="text-center<?php //echo ($i%2==0) ? "center" : "left" ?>">
                  <?php if (!empty($s->linea_1)) { ?>
                    <h1 data-animation="animated fadeInDown delay-05s">
                      <span><?php echo $s->linea_1 ?></span> 
                      <?php echo (!empty($s->linea_2)) ? "<br/>".$s->linea_2 : "" ?>
                    </h1>
                  <?php } ?>
                  <?php if (!empty($s->linea_3)) { ?>
                    <p><?php echo $s->linea_3 ?></p>
                  <?php } ?>
                  <?php if (!empty($s->link_1)) { ?>
                    <a href="<?php echo $s->link_1 ?>" class="btn button-md button-theme" data-animation="animated fadeInUp delay-05s"><?php echo $s->texto_link_1 ?></a>
                  <?php } ?>
                  <?php if (!empty($s->link_2)) { ?>
                  <a href="<?php echo $s->link_2 ?>" class="btn button-md border-button-theme" data-animation="animated fadeInUp delay-05s"><?php echo $s->texto_link_2 ?></a>
                  <?php } ?>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="slider-mover-left" aria-hidden="true">
              <i class="fa fa-angle-left"></i>
            </span>
            <span class="sr-only">Anterior</span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="slider-mover-right" aria-hidden="true">
              <i class="fa fa-angle-right"></i>
            </span>
            <span class="sr-only">Siguiente</span>
          </a>
        </div>
      </div>
    <?php } ?>
    <!-- Banner end -->
    <div class="search-area mb50">
      <div class="container">
        <div class="search-area-inner">
          <div class="search-contents ">

            <form id="form_propiedades" class="buscador-home" onsubmit="return enviar_buscador_propiedades()" method="GET">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Tipo de Operación</label>
                        <select id="tipo_operacion" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar" >
                          <?php $tipos_operaciones = $propiedad_model->get_tipos_operaciones() ?>
                          <option value="todas">Todas</option>
                          <?php foreach ($tipos_operaciones as $tp) { ?>
                            <option value="<?php echo $tp->link ?>"><?php echo $tp->nombre ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Localidad</label>
                        <select id="localidad" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
                          <?php $localidades = $propiedad_model->get_localidades() ?>
                          <option value="todas">Todas</option>
                          <?php foreach ($localidades as $l) { ?>
                            <option value="<?php echo $l->link ?>"><?php echo $l->nombre ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Tipo de Propiedad</label>
                        <select id="tp" name="tp" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
                          <?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades() ?>
                          <option value="">Todas</option>
                          <?php foreach ($tipos_propiedades as $tp) { ?>
                            <option value="<?php echo $tp->id ?>" ><?php echo $tp->nombre ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Direcci&oacute;n</label>
                        <input type="text" class="form-control" name="calle"/>
                      </div>
                    </div>                                    
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Dormitorios</label>
                        <select name="dm" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
                          <?php $dormitorios = $propiedad_model->get_dormitorios() ?>
                          <option value="">-</option>
                          <option value="99">Monoambiente</option>
                          <?php foreach ($dormitorios as $dm) { ?>
                            <?php if ($dm->dormitorios != 0) {  ?>
                              <option value="<?php echo $dm->dormitorios ?>"><?php echo $dm->dormitorios ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                      </div>
                    </div>                                    
                    <div class="col-md-3">
                      <div class="form-group mb10">
                        <label>Código</label>
                        <input type="text" class="form-control mb5" name="cod"/>
                      </div>
                      <div class="mb10 cb w100p oh">
                        <input id="apto_banco" class="border fl" type="checkbox" <?php echo (!empty($vc_apto_banco))?"checked":"" ?> name="banco" value="1">
                        <label class="fl" for="apto_banco">Apto Crédito</label>
                      </div>                    
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <button class="search-button">Buscar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>            
            <!--
            <form id="form_propiedades" class="buscador-home" onsubmit="return enviar_buscador_propiedades()" method="GET">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <label>Tipo de operación</label>
                    <select id="buscador_tipo_operacion" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
                      <option value="todos">Todos</option>
                      <?php foreach ($tipos_operaciones as $tipos) {  ?>
                      <option <?php echo (isset($tipo_operacion) && $tipo_operacion == $tipos->link)?"selected":"" ?>   value="<?php echo $tipos->link ?>"><?php echo $tipos->nombre ?></option>
                      <?php } ?>
                    </select>
                  </div>  
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <label>Localidades</label>
                    <select id="buscador_localidad" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
                      <option value="todos">Todas</option>
                      <?php foreach ($localidades as $l) {  ?>
                      <option <?php echo (isset($link_localidad) && $link_localidad == $l->link)?"selected":"" ?> value="<?php echo $l->link ?>"><?php echo $l->nombre ?></option>
                      <?php } ?>
                    </select>
                  </div> 
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <label>Tipo de propiedad</label>
                    <select id="buscador_tipo_propiedad" class="selectpicker search-fields" name="tp" data-live-search="true" data-live-search-placeholder="Buscar" >
                      <option value="0">Todos</option>
                      <?php foreach ($tipos_propiedades as $tipos) { ?>
                      <option <?php echo (isset($tipo_inmueble) && $tipo_inmueble == $tipos->id) ? "selected":"" ?>  value="<?php echo $tipos->id ?>"><?php echo $tipos->nombre ?></option>
                      <?php } ?>
                    </select>
                  </div>  
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <button class="search-button">Buscar</button>
                  </div>
                </div>
              </div>
            </form>
            -->
          </div>
        </div>
      </div>
    </div>


    <?php if ($empresa->comp_destacados == 1 && sizeof($propiedades_destacadas)>0) { ?>
      <div class="featured-properties mb50">
        <div class="container">
          <!-- Main title -->
          <div class="main-title">
            <h2 class="main-title-h2">Propiedades<span> Destacadas</span></h2>
          </div>
          <div class="row">
            <div class="filtr-container">
              <?php foreach ($propiedades_destacadas as $p) {  ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12  filtr-item" data-category="1">
                  <div class="property">
                    <!-- Property img -->
                    <a href="<?php echo $p->link_propiedad ?>" class="property-img">
                      <?php if ($p->id_tipo_estado >= 2) { ?>
                        <div class="property-tag button vendido alt featured"><?php echo $p->tipo_estado ?></div>
                      <?php } else { ?>
                        <div class="property-tag button alt featured"><?php echo $p->tipo_operacion ?></div>
                      <?php } ?>
                      <div class="property-tag button sale"><?php echo $p->tipo_inmueble ?></div>
                      <div class="property-price">
                        <?php echo $p->precio ?>
                      </div>
                      <?php if (!empty($p->imagen)) { ?>
                        <img class="img-responsive" src="<?php echo $p->imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                      <?php } else if (!empty($empresa->no_imagen)) { ?>
                        <img class="img-responsive" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                      <?php } else { ?>
                        <img class="img-responsive" src="images/logo.png" alt="<?php echo ($p->nombre); ?>" />
                      <?php } ?>
                    </a>
                    <!-- Property content -->
                    <div class="property-content">
                      <!-- title -->
                      <h1 class="title title-height-igual">
                        <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                      </h1>
                      <!-- Property address -->
                      <h3 class="property-address">
                        <a href="<?php echo mklink ("/") ?>">
                          <i class="fa fa-map-marker"></i><?php echo $p->direccion_completa ?>, <?php echo $p->localidad ?>
                        </a>
                      </h3>
                      <?php echo ver_caracteristicas($p); ?>
                      <?php /*
                      <div class="property-footer">
                        <span class="left"><i class="fa fa-calendar-o icon"></i> <?php echo $p->fecha_publicacion ?></span>
                      </div>
                      */ ?>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

    <?php if ($empresa->comp_banners == 1) { ?>
      <div class="mb50 our-service">
        <div class="container">
          <!-- Main title -->
          <div class="main-title">
            <?php $t = $web_model->get_text("Asesoramiento-Titulo-General","Nuestros Servicios")?>
            <h2 class="main-title-h2"><span class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></span></h2>
          </div>
          <div class="row mgn-btm wow">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInLeft delay-04s">
              <div class="content">
                <i class="fa fa-building"></i>
                <?php $t = $web_model->get_text("Asesoramiento-Titulo-1","Ventas")?>
                <h4 data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></h4>
                <?php $t = $web_model->get_text("Asesoramiento-Texto-1","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam")?>
                <p data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></p>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInLeft delay-04s">
              <div class="content">
                <i class="fa fa-key"></i>
                <?php $t = $web_model->get_text("Asesoramiento-Titulo-2","Alquileres")?>
                <h4 data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></h4>
                <?php $t = $web_model->get_text("Asesoramiento-Texto-2","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam")?>
                <p data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></p>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInRight delay-04s">
              <div class="content">
                <i class="fa fa-handshake-o"></i>
                
                <?php $t = $web_model->get_text("Asesoramiento-Titulo-3","Obras")?>
                <h4 data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></h4>
                <?php $t = $web_model->get_text("Asesoramiento-Texto-3","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam")?>
                <p data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></p>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInRight delay-04s">
              <div class="content">
                <i class="fa fa-home"></i>
                <?php $t = $web_model->get_text("Asesoramiento-Titulo-4","Tasaciones")?>
                <h4 data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></h4>
                <?php $t = $web_model->get_text("Asesoramiento-Texto-4","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam")?>
                <p data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

    <?php if ($empresa->comp_ultimos == 1) { ?>
      <div class="mb50 recently-properties chevron-icon">
        <div class="container">
          <!-- Main title -->
          <div class="main-title">
            <h2 class="main-title-h2"><span>Últimas</span> Propiedades</h2>
          </div>
          <div class="row">
            <div class="carousel our-partners slide" id="ourPartners2">
              <div  id="owl-demo" class="carousel-inner owl-carousel owl-them">
                <?php foreach ($listado_full as $p) { ?>
                <div class="item active">
                  <!-- Property start -->
                    <div class="property">
                      <!-- Property img -->
                      <a href="<?php echo $p->link_propiedad ?>" class="property-img">
                        <?php if ($p->id_tipo_estado >= 2) { ?>
                          <div class="property-tag button vendido alt featured"><?php echo $p->tipo_estado ?></div>
                        <?php } else { ?>
                          <div class="property-tag button alt featured"><?php echo $p->tipo_operacion ?></div>
                        <?php } ?>
                        <div class="property-tag button sale"><?php echo $p->tipo_inmueble ?></div>
                        <div class="property-price">
                          <?php echo $p->precio ?>
                        </div>
                        <?php if (!empty($p->imagen)) { ?>
                          <img class="img-responsive" src="<?php echo $p->imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                        <?php } else if (!empty($empresa->no_imagen)) { ?>
                          <img class="img-responsive" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                        <?php } else { ?>
                          <img class="img-responsive" src="images/logo.png" alt="<?php echo ($p->nombre); ?>" />
                        <?php } ?>
                      </a>
                      <div class="property-content">
                        <div class="height-igual">
                          <!-- title -->
                          <h1 class="title title-height-igual">
                            <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                          </h1>
                          <!-- Property address -->
                          <h3 class="property-address">
                            <a href="<?php echo $p->link_propiedad ?>">
                              <i class="fa fa-map-marker"></i><?php echo $p->direccion_completa ?>, <?php echo $p->localidad ?>
                            </a>
                          </h3>
                          <?php echo ver_caracteristicas($p); ?>
                        </div>
                        <?php /*
                        <div class="property-footer">
                          <span class="left"><i class="fa fa-calendar-o icon"></i> <?php echo $p->fecha_publicacion ?></span>
                        </div>
                        */ ?>
                      </div>
                    </div>
                  <!-- Property end -->
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

    <div class="clearfix"></div>

    <?php /*
    <div class="mb50 agent-section chevron-icon">
      <div class="container">
        <!-- Main title -->
        <div class="main-title">
          <h1><span>Our</span> Agent</h1>
        </div>
        <div class="row">
          <div class="carousel our-partners slide" id="ourPartners3">
            <div class="col-lg-12 mrg-btm-30">
              <a class="right carousel-control" href="#ourPartners3" data-slide="prev"><i class="fa fa-chevron-left icon-prev"></i></a>
              <a class="right carousel-control" href="#ourPartners3" data-slide="next"><i class="fa fa-chevron-right icon-next"></i></a>
            </div>
            <div class="carousel-inner">
              <div class="item active">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <!-- Agent box start -->
                  <div class="agent-box">
                    <!-- Agent img -->
                    <a href="properties-details.html" class="agent-img">
                      <img src="img/team/team-1.jpg" alt="team-1" class="img-responsive">
                    </a>
                    <!-- Agent content -->
                    <div class="agent-content">
                      <!-- title -->
                      <h1 class="title">
                        <a href="agent-single.html">John Antony</a>
                      </h1>
                      <!-- Contact -->
                      <div class="contact">
                        <p>
                          <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                        </p>
                        <p>
                          <a href="tel:+554XX-634-7071"><i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                        </p>
                        <p>
                          <a href="#"><i class="fa fa-skype"></i>sales.thenest</a>
                        </p>
                      </div>
                      <!-- Social list -->
                      <ul class="social-list clearfix">
                        <li>
                          <a href="#" class="facebook">
                            <i class="fa fa-facebook"></i>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="twitter">
                            <i class="fa fa-twitter"></i>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="linkedin">
                            <i class="fa fa-linkedin"></i>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="google">
                            <i class="fa fa-google-plus"></i>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="rss">
                            <i class="fa fa-rss"></i>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <!-- Agent box end -->
                </div>
              </div>
              <div class="item">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <!-- Agent box end -->
                  <div class="agent-box">
                    <!-- Agent img -->
                    <a href="properties-details.html" class="agent-img">
                      <img src="img/team/team-2.jpg" alt="team-2" class="img-responsive">
                    </a>
                    <!-- Agent content -->
                    <div class="agent-content">
                      <!-- title -->
                      <h1 class="title">
                        <a href="agent-single.html">Karen Paran</a>
                      </h1>
                      <!-- Contact -->
                      <div class="contact">
                        <p>
                          <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                        </p>
                        <p>
                          <a href="tel:+554XX-634-7071"><i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                        </p>
                        <p>
                          <a href="#"><i class="fa fa-skype"></i>sales.thenest</a>
                        </p>
                      </div>
                      <!-- Sociallist -->
                      <ul class="social-list clearfix">
                        <li>
                          <a href="#" class="facebook">
                            <i class="fa fa-facebook"></i>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="twitter">
                            <i class="fa fa-twitter"></i>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="linkedin">
                            <i class="fa fa-linkedin"></i>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="google">
                            <i class="fa fa-google-plus"></i>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="rss">
                            <i class="fa fa-rss"></i>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <!-- Agent box end -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Agent section end -->

    <!-- Testimonial section start-->
    <div class="testimonial-section testimonial-2 testimonial-3 hide">
      <div class="testimonial-section-inner">
        <div class="container">
          <div class="main-title">

          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="testimonials">
                <div id="carouse3-example-generic" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <div class="item content clearfix active">
                      <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                          <div class="avatar">
                            <img src="img/avatar/avatar-1.jpg" alt="avatar-1" class="img-responsive">
                          </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                          <div class="testimonials-info">
                            <div class="text">
                              <sup>
                                <i class="fa fa-quote-left"></i>
                              </sup>
                              Aliquam dictum elit vitae mauris facilisis, at dictum urna dignissim. Donec vel lectus vel felis lacinia luctus vitae iaculis arcu. Mauris mattis, massa eu porta ultricies.
                              <sub>
                                <i class="fa fa-quote-right"></i>
                              </sub>
                            </div>
                            <div class="author-name">
                              John Antony
                            </div>
                            <ul class="rating">
                              <li>
                                <i class="fa fa-star"></i>
                              </li>
                              <li>
                                <i class="fa fa-star"></i>
                              </li>
                              <li>
                                <i class="fa fa-star"></i>
                              </li>
                              <li>
                                <i class="fa fa-star"></i>
                              </li>
                              <li>
                                <i class="fa fa-star-half-full"></i>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Controls -->
                  <a class="left carousel-control" href="#carouse3-example-generic" role="button" data-slide="prev">
                    <span class="slider-mover-left" aria-hidden="true">
                      <i class="fa fa-angle-left"></i>
                    </span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#carouse3-example-generic" role="button" data-slide="next">
                   <span class="slider-mover-right" aria-hidden="true">
                    <i class="fa fa-angle-right"></i>
                  </span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Testimonial section end -->
  */ ?>
<div class="clearfix"></div>
<?php include "includes/footer.php" ?>
<script type="text/javascript">
  function enviar_orden() { 
    $("#orden_form").submit();
  }
  function enviar_buscador_propiedades() {
    var link = "<?php echo mklink("propiedades/") ?>";
    var tipo_operacion = $("#tipo_operacion").val();
    var localidad = $("#localidad").val();
    link = link + tipo_operacion + "/" + localidad + "/";
    $("#form_propiedades").attr("action",link);
    return true;
  }
</script>
<script type="text/javascript">
  $(document).ready(function(){
    var maximo = 0;
    $(".height-igual").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".height-igual").height(maximo);
  });
  $(document).ready(function(){
    var maximo = 0;
    $(".height-igual .property-address").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".height-igual .property-address").height(maximo);
  });
  $(document).ready(function(){
    var maximo = 0;
    $(".title-height-igual").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".title-height-igual").height(maximo);
  });
</script>
<script type="text/javascript">
  $('.owl-carousel').owlCarousel({
  loop:true,
  margin:10,
  responsiveClass:true,
  responsive:{
    0:{
      items:1,
      nav:false
    },
    600:{
      items:3,
      nav:false
    },
    1000:{
      items:4,
      nav:false,
      loop:true
    }
  }
})
</script>
<script type="text/javascript" src="js/nivoslider.js"></script>
    <script type="text/javascript">
  $(document).ready(function() {
    $('#slider').nivoSlider({
      effect: 'random',
      slices: 15,
      boxCols: 8,
      boxRows: 4,
      animSpeed: 500,
      pauseTime: 3000,
      startSlide: 0,
      directionNav: true,
      controlNav: false,
      controlNavThumbs: false,
      pauseOnHover: true,
      manualAdvance: false,
      prevText: '<i class="fa fa-chevron-left"></i>',
      nextText: '<i class="fa fa-chevron-right"></i>',
      randomStart: false,
      afterLoad: function(){
      }
    });
  });
  </script>
</body>
</html>