<?php
include "includes/init.php"; 
$titulo_pagina = "Inicio";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include "includes/head.php" ?>
</head>
<body class="body home">

  <div class="home-slider">
    <?php include("includes/header.php") ?>
    <div class="container">

      <h1 class="h1">
        <b>BIENVENIDOS A</b><br/>
        SCIPIONI PROPIEDADES
      </h1>

      <div class="search-area-inner">
        <div class="search-contents">
          <form id="form_propiedades" class="buscador-home" onsubmit="return enviar_buscador_propiedades()" method="GET">
            <div class="row">
              <div class="col-md-8">
                <div class="row">
                  <div class="col-sm-4 col-xs-12">
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
                  <div class="col-sm-4 col-xs-12">
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
                  <div class="col-sm-4 col-xs-12">
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
                </div>
              </div>
              <div class="col-md-2 col-xs-6">
                <div class="row">
                  <div class="col-xs-6 pr5">
                    <a id="buscador_listado" class="btn active btn-white"><i class="fa fa-align-justify"></i></a>
                  </div>
                  <div class="col-xs-6 pl5">
                    <a id="buscador_mapa" class="btn btn-white"><i class="fa fa-map-marker"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-md-2 col-xs-6">
                <div class="form-group">
                  <button class="search-button">Buscar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <?php if ($empresa->comp_destacados == 1 && sizeof($propiedades_destacadas)>0) { ?>
    <div class="featured-properties mb50">
      <div class="container">
        <!-- Main title -->
        <div class="main-title">
          <h2>Propiedades Destacadas</h2>
        </div>
        <div class="row">
          <div class="filtr-container">
            <?php foreach ($propiedades_destacadas as $p) {  ?>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12  filtr-item" data-category="1">
                <div class="property">
                  <!-- Property img -->
                  <div class="property-img">
                    <?php /*if ($p->id_tipo_estado == 2 || $p->id_tipo_estado == 3 || $p->id_tipo_estado == 4) { ?>
                      <div class="property-tag button vendido alt featured"><?php echo $p->tipo_estado ?></div>
                    <?php } else { ?>
                      <div class="property-tag button alt featured"><?php echo $p->tipo_operacion ?></div>
                    <?php } ?>
                    <div class="property-tag button sale"><?php echo $p->tipo_inmueble ?></div>
                    */?>
                    <?php if (!empty($p->path)) { ?>
                      <img class="img-responsive" src="/admin/<?php echo $p->path ?>" alt="<?php echo ($p->nombre); ?>" />
                    <?php } else if (!empty($empresa->no_imagen)) { ?>
                      <img class="img-responsive" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                    <?php } else { ?>
                      <img class="img-responsive" src="images/logo.png" alt="<?php echo ($p->nombre); ?>" />
                    <?php } ?>
                    <div class="hover">
                      <a href="<?php echo $p->link_propiedad ?>"><i class="fa fa-plus"></i></a>
                      <a href="/admin/favoritos/agregar/?id=<?php echo $p->id; ?>"><i class="fa fa-heart"></i></a>
                    </div>
                  </div>
                  <!-- Property content -->
                  <div class="property-content">
                    <h3 class="title title-height-igual">
                      <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                    </h3>
                    <h4 class="property-address">
                      <a href="<?php echo mklink ("/") ?>">
                        <i class="fa fa-map-marker"></i><?php echo $p->direccion_completa ?>, <?php echo $p->localidad ?>
                      </a>
                    </h4>
                    <div class="precio_final">
                      <?php echo ($p->precio_final != 0 && $p->publica_precio == 1) ? $p->moneda." ".number_format($p->precio_final,0) : "Consultar"; ?>
                    </div>                      
                    <?php echo ver_caracteristicas($p); ?>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php $sliders2 = $web_model->get_slider(array("clave"=>"slider_2")); 
  if (sizeof($sliders2)>0) { ?>
    <div class="banner mb40">
      <div id="carousel-2" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <?php $i=0; foreach ($sliders2 as $s) { $i++;  ?>
          <div class="item <?php echo ($i == 1) ? "active" : "" ?>">
            <img src="<?php echo $s->path ?>">
            <div class="carousel-caption banner-slider-inner banner-top-align">
              <div class="container">
                <div class="text-center">
                  <?php if (!empty($s->linea_1)) { ?>
                    <h2 data-animation="animated fadeInDown delay-05s">
                      <span><?php echo $s->linea_1 ?></span> 
                      <?php echo (!empty($s->linea_2)) ? "<br/>".$s->linea_2 : "" ?>
                    </h2>
                  <?php } ?>
                  <?php if (!empty($s->linea_3)) { ?>
                    <p><?php echo $s->linea_3 ?></p>
                  <?php } ?>
                  <?php if (!empty($s->link_1)) { ?>
                    <a href="<?php echo $s->link_1 ?>" class="btn" data-animation="animated fadeInUp delay-05s"><?php echo $s->texto_link_1 ?></a>
                  <?php } ?>
                  <?php if (!empty($s->link_2)) { ?>
                  <a href="<?php echo $s->link_2 ?>" class="btn" data-animation="animated fadeInUp delay-05s"><?php echo $s->texto_link_2 ?></a>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
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
          <h2><span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></span></h2>
        </div>
        <div class="row mgn-btm wow">
          <div class="col-sm-4 col-xs-12 wow fadeInLeft delay-04s">
            <div class="content">
              <i class="fa fa-building"></i>
              <?php $t = $web_model->get_text("Asesoramiento-Titulo-1","Ventas")?>
              <h4 data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></h4>
              <?php $t = $web_model->get_text("Asesoramiento-Texto-1","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam")?>
              <p data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></p>
            </div>
          </div>
          <div class="col-sm-4 col-xs-12 wow fadeInLeft delay-04s">
            <div class="content">
              <i class="fa fa-key"></i>
              <?php $t = $web_model->get_text("Asesoramiento-Titulo-2","Alquileres")?>
              <h4 data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></h4>
              <?php $t = $web_model->get_text("Asesoramiento-Texto-2","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam")?>
              <p data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></p>
            </div>
          </div>
          <div class="col-sm-4 col-xs-12 wow fadeInRight delay-04s">
            <div class="content">
              <i class="fa fa-home"></i>
              <?php $t = $web_model->get_text("Asesoramiento-Titulo-4","Tasaciones")?>
              <h4 data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></h4>
              <?php $t = $web_model->get_text("Asesoramiento-Texto-4","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam")?>
              <p data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($empresa->comp_ultimos == 1) { ?>
    <div class="mb50 recently-properties chevron-icon">
      <div class="container">
        <div class="main-title">
          <h2>Últimas Propiedades</h2>
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
                        <?php /*if ($p->id_tipo_estado == 2 || $p->id_tipo_estado == 3 || $p->id_tipo_estado == 4) { ?>
                          <div class="property-tag button vendido alt featured"><?php echo $p->tipo_estado ?></div>
                        <?php } else { ?>
                          <div class="property-tag button alt featured"><?php echo $p->tipo_operacion ?></div>
                        <?php } ?>
                        <div class="property-tag button sale"><?php echo $p->tipo_inmueble ?></div>
                        */ ?>
                        <?php if (!empty($p->path)) { ?>
                          <img class="img-responsive" src="/admin/<?php echo $p->path ?>" alt="<?php echo ($p->nombre); ?>" />
                        <?php } else if (!empty($empresa->no_imagen)) { ?>
                          <img class="img-responsive" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                        <?php } else { ?>
                          <img class="img-responsive" src="images/logo.png" alt="<?php echo ($p->nombre); ?>" />
                        <?php } ?>
                      </a>
                      <div class="property-content">
                        <div class="height-igual">
                          <h3 class="title title-height-igual">
                            <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                          </h3>
                          <h4 class="property-address">
                            <a href="<?php echo $p->link_propiedad ?>">
                              <i class="fa fa-map-marker"></i><?php echo $p->direccion_completa ?>, <?php echo $p->localidad ?>
                            </a>
                          </h4>
                          <div class="precio_final">
                            <?php echo ($p->precio_final != 0 && $p->publica_precio == 1) ? $p->moneda." ".number_format($p->precio_final,0) : "Consultar"; ?>
                          </div>                          
                          <?php echo ver_caracteristicas($p); ?>
                        </div>
                      </div>
                    </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="clearfix"></div>

<?php include "includes/footer.php" ?>
<script type="text/javascript">
function enviar_orden() { 
  $("#orden_form").submit();
}
function enviar_buscador_propiedades() {
  var link = ($("#buscador_mapa").hasClass("active")) ? "<?php echo mklink("mapa/")?>" : "<?php echo mklink("propiedades/")?>";
  var tipo_operacion = $("#buscador_tipo_operacion").val();
  var localidad = $("#buscador_localidad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
$(document).ready(function(){

  $("#buscador_mapa").click(function(){
    $("#buscador_listado").removeClass("active");
    $("#buscador_mapa").addClass("active");
  });
  $("#buscador_listado").click(function(){
    $("#buscador_mapa").removeClass("active");
    $("#buscador_listado").addClass("active");
  });

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
</body>
</html>