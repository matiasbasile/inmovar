<?php
include "includes/init.php" ;
$get_params["offset"] = 12;
extract($propiedad_model->get_variables());
$nombre_pagina = "listado";
$titulo_pagina = $vc_link_tipo_operacion;
$page_active = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>
<?php include "includes/header.php" ?>
    <!-- Sub banner start -->
    <?php $t = $web_model->get_text("property-banner","images/sub-banner-1.jpg")?>
    <div class="sub-banner editable editable-img" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" data-height="279" data-width="1583">
      <div class="overlay">
        <div class="container">
          <div class="breadcrumb-area">
            <h1 class="h1"><?php echo $vc_link_tipo_operacion ?></h1>
          </div>
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
                      <a href="javascript:void(0);" data-view="lista" onclick="grid_or_list(this);" class="change-view-btn <?php echo ($vc_view==0)?"active-view-btn":"" ?>"><i class="fa fa-th-list"></i></a>
                      <a href="javascript:void(0);" data-view="grid"  onclick="grid_or_list(this);" class="change-view-btn <?php echo ($vc_view==1)?"active-view-btn":"" ?>"><i class="fa fa-th-large"></i></a>
                      <a href="<?php echo mklink ("mapa/".(empty($vc_link_tipo_operacion)?"todas":$vc_link_tipo_operacion)."/".(empty($link_localidad)?"todas":$link_localidad)."/?".(empty($link_tipo_inmueble)?"":$link_tipo_inmueble)."view=2") ?>"class="change-view-btn"><i class="fa fa-map-marker"></i></a>
                    </div>
                  </h4>
                </div>
                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-6 cod-pad">
                  <div class="sorting-options">
                    <form action="<?php echo current_url() ?>" method="GET" id="orden_form" >
                      <select onchange="enviar_orden()" name="orden" class="sorting">
                        <option <?php echo ($vc_orden == 2) ? "selected" : "" ?> value="2">Precio menor a mayor</option>
                        <option <?php echo ($vc_orden == 1) ? "selected" : "" ?> value="1">Precio mayor a menor nuevos</option>
                        <option <?php echo ($vc_orden == 5) ? "selected" : "" ?> value="5">&Uacute;ltimos</option>
                      </select>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="<?php echo ($vc_view==1)?"hide":"" ?>" id="lista">
              <div class="clearfix"></div>
              <!-- Property start -->
              <?php if (sizeof($vc_listado) > 0) {  ?>
                <?php foreach ($vc_listado as $p) {  ?>
                  <div class="property clearfix wow fadeInUp delay-03s">
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 col-pad">
                      <a href="<?php echo $p->link_propiedad ?>" class="property-img height">
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
                          <img class="img-responsive cover-list" src="<?php echo $p->imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                        <?php } else if (!empty($empresa->no_imagen)) { ?>
                          <img class="img-responsive cover-list" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                        <?php } else { ?>
                          <img class="img-responsive cover-list" src="images/logo.png" alt="<?php echo ($p->nombre); ?>" />
                        <?php } ?>
                      </a>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 property-content ">
                      <!-- title -->
                      <h2 class="title">
                        <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                      </h2>
                      <?php echo ver_direccion($p); ?>
                      <?php echo ver_caracteristicas($p); ?>
                      <!-- Property footer -->
                      <?php /*
                      <div class="property-footer">
                        <span class="left"><i class="fa fa-calendar-o icon"></i> <?php echo $p->fecha_publicacion ?></span>
                        
                        <span class="right">
                          <a href="javascript:void(0);"><i class="fa fa-heart-o icon"></i></a>
                          <a href="javascript:void(0);"><i class="fa fa-share-alt"></i></a>
                        </span>
                      </div>
                      */ ?>
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

            <div class="<?php echo ($vc_view==0)?"hide":"" ?>" id="grid">
              <div class="row">
                <?php foreach ($vc_listado as $p) {  ?>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
                          <div class="property-main-image">
                            <?php if (!empty($p->imagen)) { ?>
                              <img class="img-responsive cover-list" src="<?php echo $p->imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                            <?php } else if (!empty($empresa->no_imagen)) { ?>
                              <img class="img-responsive cover-list" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                            <?php } else { ?>
                              <img class="img-responsive cover-list" src="images/logo.png" alt="<?php echo ($p->nombre); ?>" />
                            <?php } ?>
                          </div>
                        </a>
                        <!-- Property content -->
                        <div class="property-content">
                          <div class="height-igual">
                            <!-- title -->
                            <h1 class="title">
                              <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                            </h1>
                            <?php echo ver_direccion($p); ?>
                            <?php echo ver_caracteristicas($p); ?>
                          </div>
                          <!-- Property footer -->
                          <?php /*
                          <div class="property-footer">
                            <span class="left"><i class="fa fa-calendar-o icon"></i> <?php echo $p->fecha_publicacion ?></span>
                            <span class="right">
                              <a href="javascript:void(0);"><i class="fa fa-heart-o icon"></i></a>
                              <a href="javascript:void(0);"><i class="fa fa-share-alt"></i></a>
                            </span>
                          </div>
                          */ ?>
                        </div>
                      </div>
                      <!-- Property end -->
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
            <?php include("includes/destacadas.php"); ?>
          </div>
        </div>
      </div>
    </div>
    <!-- Properties section body end -->

<!-- Footer start -->
<?php include "includes/footer.php" ?>
<script type="text/javascript">
$(document).ready(function(){
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
<script type="text/javascript">
  $('.MyCheck').on('change', function() {
    $('.MyCheck').not(this).prop('checked', false);
  });
</script>
</body>
</html>