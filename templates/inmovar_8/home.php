<?php include "includes/init.php" ?>
<?php $titulo_pagina = "inicio";?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/head.php" ?>
  <style type="text/css">
    .carousel-item:after { 
    content: ' ';
    display: block;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    z-index: -1;
    height: 100%;
    background: #0000002e  }
  </style>
</head>
<body>
<!-- header part start here -->
  <?php include "includes/header.php" ?>

<?php $slides = $web_model->get_slider();
if (sizeof($slides)>0) { ?>
<div class="home_slider">
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <ol class="carousel-indicators">
      <?php $x=0; foreach ($slides as $s) { ?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $x ?>" class="<?php echo ($x==0)?"active":"" ?>"></li>
      <?php $x++; } ?>
    </ol>
    <div class="carousel-inner">      
      <?php $x=0; foreach ($slides as $s) {  ?>
        <div class="carousel-item <?php echo ($x==0)?"active":"" ?>" style="background-image: url(<?php echo $s->path ?>);z-index: -1">
          <div class="container">
            <div class="srch-main-wrap">
              <div class="home-banner-srch">
                <div class="display-table">
                  <div class="carousel-caption-table-cell text-center vat">
                    <div class="main_banner_srch">
                      <div class="slider_heading_para">
                        <h1 style="z-index: 99"><?php echo $s->linea_1.(!empty($s->linea_2)?"<br/>".$s->linea_2:"") ?></h1>
                        <?php if (!empty($s->linea_3)) { ?>
                          <p><?php echo $s->linea_3 ?></p>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php $x++; } ?>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Anterior</span> </a> <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Siguiente</span> </a> </div>
    <div class="container">
      <div class="srch-main-wrap">
        <div class="home-banner-srch">
          <div class="display-table">
            <div class="carousel-caption-table-cell text-center">
              <div class="main_banner_srch">
                <div class="banner_input_boxes">
                  <div class="row">
                    <div class="col-lg-10 col-md-9">
                      <div class="on_input">
                        <div class="row margin_row">
                          <div class="col-lg-3 col-md-3 border-left">
                            <?php $tipos_operaciones = $propiedad_model->get_tipos_operaciones(); ?>
                            <select id="tipo_operacion">
                              <option value="todas">Tipos Operaciones</option>
                              <?php foreach ($tipos_operaciones as $t) {  ?>
                                <option value="<?php echo $t->link ?>"><?php echo $t->nombre ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-lg-4 col-md-4 border-left">
                             <?php $localidades = $propiedad_model->get_localidades(); ?>
                            <select id="localidad">
                              <option value="todas">Localidades</option>
                              <?php foreach ($localidades as $t) {  ?>
                                <option value="<?php echo $t->link ?>"><?php echo $t->nombre ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-lg-5 col-md-5 border-left">
                            <?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
                            <select id="tp">
                              <option value="0">Tipos propiedades</option>
                              <?php foreach ($tipos_propiedades as $t) {  ?>
                                <option value="<?php echo $t->id ?>"><?php echo $t->nombre ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-3 pad-left">
                      <div class="sub_btn">
                        <form id="form_propiedades">
                          <input type="hidden" name="tp" id="tp_hidden" value="0">
                          <input type="submit" onclick="enviar_buscador_propiedades()" class="btn1" value="Buscar">
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="banner_check_box">
                    <div class="checkbox_div">
                      <label class="label_r">
                        <input type="radio" value="lista" checked="checked" name="radio">
                        <span class="checkmark"></span> Mostrar en lista 
                      </label>
                    </div>
                    <div class="checkbox_div">
                      <label class="label_r">
                        <input type="radio" value="mapa" name="radio">
                        <span class="checkmark"></span> Mostrar en mapa 
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<!-- Home Slider Part End here --> 

<!-- Home Second Section Part Start here -->
<div class="boxes_section">
  <div class="container">
    <div class="boxes_wraper">
      <div class="row">
        <div class="col-lg-4 col-md-4">
          <div class="box_div_wrap">
            <div class="box_wrap_img">
              <div class="img_hover"><img src="images/box_img1.png" alt="box_img1"></div>
            </div>
            <div class="box_wrap_content">
              <?php $t = $web_model->get_text("box1titv2","Ventas")?>
              <h5 class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h5>
              <?php $t = $web_model->get_text("box1txtv2","Encontra la propiedad <br> que estas buscando al <br> mejor precio.")?>
              <p class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
              <?php $t = $web_model->get_text("box1btnv2","Ver Propiedades") ?>
              <a class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" href="<?php echo (!empty($t->link))?$t->link:"javascript:void(0)" ?>"><?php echo $t->plain_text ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="box_div_wrap">
            <div class="box_wrap_img">
              <div class="img_hover"><img src="images/box_img2.png" alt="box_img2"></div>
            </div>
            <div class="box_wrap_content">
              <?php $t = $web_model->get_text("box2tit","Alquileres")?>
              <h5 class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h5>
              <?php $t = $web_model->get_text("box2txt","Encontra la propiedad <br> que estas buscando al <br> mejor precio.")?>
              <p class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
              <?php $t = $web_model->get_text("box2btnv2","Ver Propiedades") ?>
              <a class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" href="<?php echo (!empty($t->link))?$t->link:"javascript:void(0)" ?>"><?php echo $t->plain_text ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="box_div_wrap">
            <div class="box_wrap_img">
              <div class="img_hover"><img src="images/box_img3.png" alt="box_img3"></div>
            </div>
            <div class="box_wrap_content">
              <?php $t = $web_model->get_text("box3tit","Emprendimientos")?>
              <h5 class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h5>
              <?php $t = $web_model->get_text("box3txt","Encontra la propiedad <br> que estas buscando al <br> mejor precio.")?>
              <p class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
              <?php $t = $web_model->get_text("box3btnv2","Ver Propiedades") ?>
              <a class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" href="<?php echo (!empty($t->link))?$t->link:"javascript:void(0)" ?>"><?php echo $t->plain_text ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Home Second Section Part End here --> 

<!-- Home Second Section Part End here --> 

<!-- ab part Start here -->
<div class="nostros_part">
  <div class="container">
    <div class="nostros_wrap p0 pt30">
      <div class="row">
        <?php $nosotros = $entrada_model->get_list(array("categoria"=>"empresa","offset"=>1)) ?>
        <?php foreach ($nosotros as $l) {  ?>
          <div class="col-lg-6 col-md-6">
            <div class="nostros_content display-table">
              <div class="display-table-cell">
                <h2 class="heading2"><?php echo $l->titulo ?></h2>
                <p><?php echo utf8_encode($l->descripcion) ?></p>
                <a href="<?php echo mklink ("entradas/empresa/")  ?>" class="btn2">leer más</a> </div>
            </div>
          </div>
        <div class="col-lg-6 col-md-6">
          <div class="nostros_img"> <img src="<?php echo $l->path ?>" alt="demo_img3"> </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<!-- ab part End here --> 

<?php $emprendimientos_listado = $propiedad_model->get_list(array("destacado"=>"1","tipo_operacion"=>"emprendimientos","offset"=>9))?>

<!-- Tab Slider part start here -->
<div class="tab_slider_section">
  <div class="container heading_container">
    <h2 class="heading2 margin_heading text-center">Propiedades Destacadas</h2>
  </div>
  <div class="slider_tab_bar">
    <div class="container">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"> <a class="active" id="ventra-tab" data-toggle="tab" href="#ventra" role="tab" aria-controls="ventra" aria-selected="true"> <span><i class="fa fa-angle-down" aria-hidden="true"></i></span> En Venta</a> </li>
        <?php if (sizeof($alquileres_listado)>0) { ?>
          <li class="nav-item"> <a id="alquile-tab" data-toggle="tab" href="#alquile" role="tab" aria-controls="alquile" aria-selected="false"> <span><i class="fa fa-angle-down" aria-hidden="true"></i></span> En Alquiler</a> </li>
        <?php } ?>
        <?php if (sizeof($emprendimientos_listado)>0) { ?>
          <li class="nav-item"> <a id="emprendimientos-tab" data-toggle="tab" href="#emprendimientos" role="tab" aria-controls="emprendimientos" aria-selected="false"> <span><i class="fa fa-angle-down" aria-hidden="true"></i></span> Emprendimientos</a> </li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="listing_boxes mb30">
    <div class="container">
      <div class="tab-content" id="myTabContent">
        <?php $ventas_listado = $propiedad_model->get_list(array("destacado"=>"1","tipo_operacion"=>"ventas","offset"=>9))?>
        <div class="tab-pane fade ajustar show active" id="ventra" role="tabpanel" aria-labelledby="ventra-tab">
          <div class="listing_boxes_wrap">
            <div class="enventa_list">
              <div class="row">
                <?php foreach ($ventas_listado as $l) {  ?>
                  <div class="col-md-4">
                   <div class="tab_slider_st mb20">
                    <div class="tab_list_box">
                      <div class="hover_box_div">
                        <?php 
                        $path = "images/no-imagen.png";
                        if (!empty($l->imagen)) { 
                          $path = $l->imagen;
                        } else if (!empty($empresa->no_imagen)) {
                          $path = "/admin/".$empresa->no_imagen;
                        } ?>
                        <div class="tab_list_box_img gallery_box_img_second">
                          <img src="<?php echo $path ?>" alt="<?php echo ($l->nombre);?>">
                        </div>
                        <div class="hover_content">
                          <div class="display-table">
                            <div class="display-table-cell"> 
                              <a class="pluss_icon" href="<?php echo $l->link_propiedad ?>"><i class="fa fa-plus" aria-hidden="true"></i></a> 

                              <?php if (estaEnFavoritos($l->id)) { ?>
                                <a class="likes_icon active" rel="nofollow" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                  <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </a>
                              <?php } else { ?>
                                <a class="likes_icon" rel="nofollow" href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                  <i class="fa fa-heart" aria-hidden="true"></i>
                                </a>
                              <?php } ?>

                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab_list_box_content">
                        <h6><a href="<?php echo $l->link_propiedad ?>"><?php echo $l->nombre ?></a></h6>
                        <p>
                          <img src="images/locate_icon.png" alt="locate_icon"> <?php echo $l->direccion_completa ?>
                          <br/><span class="color_span"><?php echo $l->localidad ?></span>
                        </p>
                        <h6 class="price_dollar"><?php echo $l->precio ?></h6>
                      </div>
                      <div class="tab_list_box_footer">
                        <ul>
                          <li>
                            <p><img src="images/mts_icon.png" alt="mts_icon">
                              <span class="color_span"><?php echo (!empty($l->superficie_total)) ? $l->superficie_total : "-" ?></span> Mts2
                            </p>
                          </li>
                          <li>
                            <p><img src="images/hab_icon.png" alt="has_icon"> <span class="color_span"><?php echo (!empty($l->dormitorios)) ? $l->dormitorios : "-" ?></span> Hab</p>
                          </li>
                          <li>
                            <p><img src="images/banos_icon.png" alt="mts_icon"> <span class="color_span"><?php echo (!empty($l->banios)) ? $l->banios : "-" ?></span> Baños</p>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
        <?php $alquileres_listado = $propiedad_model->get_list(array("destacado"=>"1","tipo_operacion"=>"alquileres","offset"=>9))?>
        <?php if (sizeof($alquileres_listado)>0) { ?>
          <div class="tab-pane fade ajustar" id="alquile" role="tabpanel" aria-labelledby="alquile-tab">
            <div class="listing_boxes_wrap">
              <div class="enventa_list">
                <div class="row">
                  <?php foreach ($alquileres_listado as $l) {  ?>
                    <div class="col-md-4">
                      <div class="tab_slider_st mb20">
                      <div class="tab_list_box">
                        <div class="hover_box_div">
                          <?php 
                          $path = "images/no-imagen.png";
                          if (!empty($l->imagen)) { 
                            $path = $l->imagen;
                          } else if (!empty($empresa->no_imagen)) {
                            $path = "/admin/".$empresa->no_imagen;
                          } ?>
                          <div class="tab_list_box_img gallery_box_img_second">
                            <img src="<?php echo $path ?>" alt="<?php echo ($l->nombre);?>">
                          </div>
                          <div class="hover_content">
                            <div class="display-table">
                              <div class="display-table-cell"> 
                                <a class="pluss_icon" href="<?php echo $l->link_propiedad ?>"><i class="fa fa-plus" aria-hidden="true"></i></a> 
                                <?php if (estaEnFavoritos($l->id)) { ?>
                                  <a class="likes_icon active" rel="nofollow" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </a>
                                <?php } else { ?>
                                  <a class="likes_icon" rel="nofollow" href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                  </a>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab_list_box_content">
                          <h6><a href="<?php echo $l->link_propiedad ?>"><?php echo $l->nombre ?></a></h6>
                          <?php if(!empty($l->localidad)) {  ?>
                            <p>
                              <img src="images/locate_icon.png" alt="locate_icon"> <?php echo $l->direccion_completa ?>
                              <br/><span class="color_span"><?php echo $l->localidad ?></span>
                            </p>
                          <?php } ?>
                          <h6 class="price_dollar"><?php echo $l->precio ?></h6>
                        </div>
                        <div class="tab_list_box_footer">
                          <ul>
                            <li>
                            <p><img src="images/mts_icon.png" alt="mts_icon">
                              <span class="color_span"><?php echo (!empty($l->superficie_total)) ? $l->superficie_total : "-" ?></span> Mts2</p>
                            </li>
                            <li>
                              <p><img src="images/hab_icon.png" alt="has_icon"> <span class="color_span"><?php echo (!empty($l->dormitorios)) ? $l->dormitorios : "-" ?></span> Hab</p>
                            </li>
                            <li>
                              <p><img src="images/banos_icon.png" alt="mts_icon"> <span class="color_span"><?php echo (!empty($l->banios)) ? $l->banios : "-" ?></span> Baños</p>
                            </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php }?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        
        <?php if (sizeof($emprendimientos_listado)>0) { ?>
          <div class="tab-pane fade" id="emprendimientos" role="tabpanel" aria-labelledby="emprendimientos-tab">
            <div class="listing_boxes_wrap">
              <div class="enventa_list">
                <div class="<?php echo (sizeof($emprendimientos_listado)>3) ? "owl-carousel owl-theme home_owl_slider" : "row" ?>">
                  <?php foreach ($emprendimientos_listado as $l) {  ?>
                   <div class="<?php echo (sizeof($emprendimientos_listado)>3) ? "item" : "col-md-4" ?>">
                     <div class="tab_slider_st mb20">
                      <div class="tab_list_box">
                        <div class="hover_box_div">
                          <?php 
                          $path = "images/no-imagen.png";
                          if (!empty($l->imagen)) { 
                            $path = $l->imagen;
                          } else if (!empty($empresa->no_imagen)) {
                            $path = "/admin/".$empresa->no_imagen;
                          } ?>
                          <div class="tab_list_box_img gallery_box_img_second">
                            <img src="<?php echo $path ?>" alt="<?php echo ($l->nombre);?>">
                          </div>
                          <div class="hover_content">
                            <div class="display-table">
                              <div class="display-table-cell"> 
                                <a class="pluss_icon" href="<?php echo mklink ($l->link) ?>"><i class="fa fa-plus" aria-hidden="true"></i></a> 
                                <?php if (estaEnFavoritos($l->id)) { ?>
                                  <a class="likes_icon active" rel="nofollow" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </a>
                                <?php } else { ?>
                                  <a class="likes_icon" rel="nofollow" href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                  </a>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab_list_box_content">
                          <h6><a href="<?php echo $l->link_propiedad ?>"><?php echo $l->nombre ?></a></h6>
                          <p>
                            <img src="images/locate_icon.png" alt="locate_icon"><?php echo $l->direccion_completa ?>
                            <br/><span class="color_span"><?php echo $l->localidad ?></span>
                          </p>
                          <h6 class="price_dollar">$<?php echo $l->precio ?></h6>
                        </div>
                        <div class="tab_list_box_footer">
                          <ul>
                            <li>
                            <p><img src="images/mts_icon.png" alt="mts_icon">
                              <span class="color_span"><?php echo (!empty($l->superficie_total)) ? $l->superficie_total : "-" ?></span> Mts2</p>
                            </li>
                            <li>
                              <p><img src="images/hab_icon.png" alt="has_icon"> <span class="color_span"><?php echo (!empty($l->dormitorios)) ? $l->dormitorios : "-" ?></span> Hab</p>
                            </li>
                            <li>
                              <p><img src="images/banos_icon.png" alt="mts_icon"> <span class="color_span"><?php echo (!empty($l->banios)) ? $l->banios : "-" ?></span> Baños</p>
                            </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php }?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<!-- Tab Slider part End here --> 

<?php $emprendimientos = $propiedad_model->get_list(array(
  "tipos_operaciones"=>"emprendimientos",
  "offset"=>2,
  "tiene_etiqueta_link"=>"emprendimiento", // Tiene que estar marcado con una ETIQUETA
));
if (sizeof($emprendimientos)>0) { ?>
  <div class="empredimi_section">
    <div class="container">
      <div class="empredimi_wraper">
        <h2 class="white_heading text-center margin_heading">Emprendimientos</h2>
        <div class="row">
          <?php if (sizeof($emprendimientos) == 1) { ?>
            <?php foreach ($emprendimientos as $l) {  ?>
              <div class="col-md-6" style="margin: 0 auto;">
                <div class="emprendimientos_box"> 
                  <?php if (!empty($l->imagen)) { ?>
                    <img src="<?php echo $l->imagen ?>" alt="<?php echo ($l->nombre);?>">
                  <?php } else if (!empty($empresa->no_imagen)) { ?>
                    <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($l->nombre);?>">
                  <?php } else { ?>
                    <img src="images/no-imagen.png" alt="<?php echo ($l->nombre);?>">
                  <?php } ?>
                  <div class="empr_box_content">
                    <h5><a href="<?php echo $l->link_propiedad?>"><?php echo $l->nombre ?></a></h5>
                    <div class="anchor_btn_div"> <a class="anchor_btn" href="<?php echo mklink ($l->link) ?>">Ver Proyecto <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } else { ?>
            <?php foreach ($emprendimientos as $l) {  ?>
              <div class="col-lg-6 col-md-6">
                <div class="emprendimientos_box"> 

                  <?php if (!empty($l->imagen)) { ?>
                    <img src="<?php echo $l->imagen ?>" alt="<?php echo ($l->nombre);?>">
                  <?php } else if (!empty($empresa->no_imagen)) { ?>
                    <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($l->nombre);?>">
                  <?php } else { ?>
                    <img src="images/no-imagen.png" alt="<?php echo ($l->nombre);?>">
                  <?php } ?>

                  <div class="empr_box_content">
                    <h5><a href="<?php echo $l->link_propiedad?>"><?php echo $l->nombre ?></a></h5>
                    <div class="anchor_btn_div"> <a class="anchor_btn" href="<?php echo mklink ($l->link) ?>">Ver Proyecto <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php $categorias_informacion = $entrada_model->get_subcategorias(186)?>  
<?php if (!empty($categorias_informacion)) {  ?>
<!-- Information part Start here -->
  <div class="info_section">
    <div class="container">
      <div class="info_wrap">
        <h2 class="heading2 margin_heading text-center">Información</h2>
        <div class="row">
          <?php $x=1;foreach ($categorias_informacion as $c) { if ($x<=6) {   ?>
            <div class="col-lg-4 col-md-6">
              <div class="info_img_box"> <a href="<?php echo mklink ("entradas/$c->link/") ?>">
                <div class="info_img_wrap"> <img src="/admin/<?php echo $c->path ?>"> </div>
                <div class="info_content_wrap">
                  <p>información</p>
                  <h5><?php echo utf8_encode($c->nombre)?></h5>
                </div>
                </a> </div>
            </div>
          <?php } $x++;    } ?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<!-- Information part End here --> 

<!-- Footer Part Start here -->
<?php include "includes/footer.php" ?>

<!-- Footer Part End here --> 

<!-- JavaScript
  ================================================== --> 
<script src="js/jquery-3.2.1.slim.min.js"></script> 
<script src="js/bootstrap.js"></script> 
<script src="js/popper.min.js"></script> 
<script src="js/owl.carousel.js"></script> 

<script type="text/javascript">
  $('.home_owl_slider').owlCarousel({
    loop:true,
    margin:32,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
         768:{
            items:2
        },
        1000:{
            items:3
        }
    }
})


</script>


<script type="text/javascript">
$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
  if (!$(this).next().hasClass('show')) {
    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
  }
  var $subMenu = $(this).next(".dropdown-menu");
  $subMenu.toggleClass('show');


  $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
    $('.dropdown-submenu .show').removeClass("show");
  });


  return false;
});

$(document).ready(function(){
    $('.sub-menu-ul .dropdown-toggle').on('click',function(){
          if($(this).hasClass('menu_show')){
            $(this).removeClass('menu_show');
          }else{
            $(this).addClass('menu_show');
          }
       });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  var maximo = 0;
  $(".ajustar .tab_list_box_content p").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".ajustar .tab_list_box_content p").height(maximo);
  
});
$(document).ready(function(){
  var maximo = 0;
  $(".ajustar .tab_list_box_content h6").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".ajustar .tab_list_box_content h6").height(maximo);
  
});
</script>
<script type="text/javascript">
function enviar_buscador_propiedades() { 
  var link = "";
  if ($("input[name=radio]:checked").val() == "lista") {
    link = "<?php echo mklink("propiedades/")?>";
  } else {
    link = "<?php echo mklink("mapa/")?>";
  }
  var tipo_operacion = $("#tipo_operacion").val();
  var localidad = $("#localidad").val();
  var tipo_propiedad = $("#tp").val();
  $("#tp_hidden").val(tipo_propiedad);
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>
</body>
</html>
