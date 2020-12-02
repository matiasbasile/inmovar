<?php
include "includes/init.php" ;
$nombre_pagina = "listado";
$get_params["offset"] = 12;
extract($propiedad_model->get_variables());
$page_active = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>

  <div class="home-slider">
    <?php include("includes/header.php") ?>
    <div class="container">
      <div class="breadcrumb-area">
        <?php if (strtolower($vc_tipo_operacion) == "ventas") { ?>
          <h1 class="h1">Propiedades en venta</h1>
        <?php } else if (strtolower($vc_tipo_operacion) == "alquileres") { ?>
          <h1 class="h1">Propiedades en alquiler</h1>
        <?php } else if (strtolower($vc_tipo_operacion) == "emprendimientos") { ?>
          <h1 class="h1">Emprendimientos</h1>
        <?php } ?>
        <ul class="breadcrumbs">
          <li><a href="<?php echo mklink ("/") ?>">Inicio</a></li>
          <li class="active"><?php echo $vc_tipo_operacion ?></li>
        </ul>
      </div>
    </div>
  </div>

    <!-- Sub Banner end -->
    <!-- Properties section body start -->
    <div class="properties-section-body content-area">
      <div class="container">
        <div class="row">

          <div class="col-lg-8 col-md-8 col-xs-12 col-md-push-4">
            <div class="option-bar">
              <div class="row">
                <div class="col-lg-6 col-md-5 col-sm-5 col-xs-6">
                  <h4>
                    <div class="top-view">
                      <a href="javascript:void(0);" data-view="lista" onclick="grid_or_list(this);" class="change-view-btn <?php echo ($vc_view==1)?"active-view-btn":"" ?>"><i class="fa fa-th-list"></i></a>
                      <a href="javascript:void(0);" data-view="grid"  onclick="grid_or_list(this);" class="change-view-btn <?php echo ($vc_view==0)?"active-view-btn":"" ?>"><i class="fa fa-th-large"></i></a>
                    </div>
                  </h4>
                </div>
                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-6 cod-pad">
                  <div class="sorting-options">
                    <form action="<?php echo current_url() ?>" method="GET" id="orden_form" >
                      <select onchange="enviar_orden()" name="orden" class="sorting">
                        <option <?php echo ($vc_orden == 4) ? "selected" : "" ?> value="4">Destacados</option>
                        <option <?php echo ($vc_orden == 5) ? "selected" : "" ?> value="5">&Uacute;ltimos</option>
                        <option <?php echo ($vc_orden == 2) ? "selected" : "" ?> value="2">Precio menor a mayor</option>
                        <option <?php echo ($vc_orden == 1) ? "selected" : "" ?> value="1">Precio mayor a menor nuevos</option>
                      </select>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="<?php echo ($vc_view==0)?"hide":"" ?>" id="lista">
              <div class="clearfix"></div>
              <?php if (sizeof($vc_listado) > 0) {  ?>
                <?php foreach ($vc_listado as $p) {  ?>
                  <div class="property clearfix wow fadeInUp delay-03s">
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 col-pad">
                      <div class="property-img height">
                        <?php if ($p->id_tipo_estado >= 2) { ?>
                          <div class="property-tag button vendido alt featured"><?php echo $p->tipo_estado ?></div>
                        <?php } ?>
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
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 property-content ">
                      <h2 class="title">
                        <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                      </h2>
                      <div class="precio_final">
                        <?php echo ($p->precio_final != 0 && $p->publica_precio == 1) ? $p->moneda." ".number_format($p->precio_final,0) : "Consultar"; ?>
                      </div>                      
                      <?php echo ver_direccion($p); ?>
                      <?php echo ver_caracteristicas($p); ?>
                    </div>
                  </div>
                <?php }?> 
              <?php } else {  ?>
                <div class="container">
                  <h3>
                    No se encontraron resultados para su búsqueda.
                  </h3>
                </div>
              <?php } ?>
            </div>

            <div class="<?php echo ($vc_view==1)?"hide":"" ?>" id="grid">
              <div class="row">
                <?php foreach ($vc_listado as $p) {  ?>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="property">
                      <div class="property-img">
                        <?php if ($p->id_tipo_estado >= 2) { ?>
                          <div class="property-tag button vendido alt featured"><?php echo $p->tipo_estado ?></div>
                        <?php } ?>                        
                        <div class="property-main-image">
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
                      </div>
                      <div class="property-content">
                        <div class="height-igual">
                          <h2 class="title">
                            <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                          </h2>
                          <div class="precio_final">
                            <?php echo ($p->precio_final != 0 && $p->publica_precio == 1) ? $p->moneda." ".number_format($p->precio_final,0) : "Consultar"; ?>
                          </div>                            
                          <?php echo ver_direccion($p); ?>
                          <?php echo ver_caracteristicas($p); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>

            <?php if ($vc_total_paginas > 1) { ?>
              <nav aria-label="Page navigation">
                <ul class="pagination">
                  <?php if ($vc_page > 0) { ?>
                    <li>
                      <a href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>" aria-label="Previous">
                        <span aria-hidden="true">Anterior</span>
                      </a>
                    </li>
                  <?php } ?>
                    <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
                     <?php if (abs($vc_page-$i)<3) { ?>
                       <?php if ($i == $vc_page) { ?>
                        <li class="active"><a><?php echo $i+1 ?></a></li>
                       <?php } else { ?>
                       <li ><a href="<?php echo mklink ($vc_link.$i."/".$vc_params ) ?>"><?php echo $i+1 ?></a></li>
                       <?php } ?>
                     <?php } ?>
                    <?php } ?>
                   <?php if ($vc_page < $vc_total_paginas-1) { ?>
                    <li><a href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params ) ?>">Siguiente</a></li>
                  <?php } ?>
                </ul>
              </nav>
            <?php } ?>

          </div>
          <div class="col-lg-4 col-md-4 col-xs-12 col-md-pull-8">
            <?php include("includes/avanzada.php"); ?>

            <?php if (strtolower($vc_tipo_operacion) == "alquileres") { ?>
              <div class="links-listado">
                <a href="<?php echo mklink("entrada/preguntas-frecuentes-26721/") ?>" class="media">
                  <div class="media-left">
                    <img src="images/scipioni1.png" alt="Preguntas Frecuentes"/>
                  </div>
                  <div class="media-body">
                    <h4>PREGUNTAS FRECUENTES</h4>
                  </div>
                </a>
                <a href="<?php echo mklink("entrada/requisitos-de-alquiler-26722/") ?>" class="media">
                  <div class="media-left">
                    <img src="images/scipioni2.png" alt="Requisitos de Alquiler"/>
                  </div>
                  <div class="media-body">
                    <h4>REQUISITOS DE ALQUILER</h4>
                  </div>
                </a>
                <a href="<?php echo mklink("entrada/informacion-importante-26723/") ?>" class="media">
                  <div class="media-left">
                    <img src="images/scipioni3.png" alt="Información Importante"/>
                  </div>
                  <div class="media-body">
                    <h4>INFORMACIÓN IMPORTANTE</h4>
                  </div>
                </a>
                <a href="<?php echo mklink("entrada/informacion-sobre-ventas-26720/") ?>" class="media">
                  <div class="media-left">
                    <img src="images/scipioni4.png" alt="Información sobre ventas"/>
                  </div>
                  <div class="media-body">
                    <h4>INFORMACIÓN <br/>SOBRE VENTAS</h4>
                  </div>
                </a>
              </div>
            <?php } else if (strtolower($vc_tipo_operacion) == "ventas") { 
              if (sizeof($propiedades_destacadas)>0) { ?>
                <div class="social-media sidebar-widget clearfix mb0">
                  <div class="main-title-2 mb0">
                    <h4>Propiedades Destacadas</h4>
                  </div>
                </div>                
                <div class="featured-properties mb50">
                  <div class="owl-carousel">
                    <?php foreach ($propiedades_destacadas as $p) {  ?>
                      <div class="item">
                        <div class="property">
                          <div class="property-img">
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
              <?php } ?>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
    <!-- Properties section body end -->

<!-- Footer start -->
<?php include "includes/footer.php" ?>
<script type="text/javascript">
$(document).ready(function(){

  $('.owl-carousel').owlCarousel({
    loop:true,
    margin:0,
    nav:false,
    items: 1,
    autoplay: true,
  });

  var maximo = 0;
  $(".property .property-content").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  $(".property .property-content").height(maximo);
});
function enviar_orden() { 
  $("#orden_form").submit();
}
function grid_or_list(d) { 
  $(".active-view-btn").removeClass("active-view-btn");
  $(d).addClass('active-view-btn');
  var view = $(d).data("view");
  if (view == "grid") { 
    $("#lista").addClass("hide");
    $("#grid").removeClass("hide");
    $("#view_hidden").val("1");
  } else {
    $("#grid").addClass("hide");
    $("#lista").removeClass("hide");
    $("#view_hidden").val("0");
  }
}
</script>
</body>
</html>