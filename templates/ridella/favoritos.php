<?php 
include("includes/init.php");
$get_params["offset"] = 10;
$vc_listado = $propiedad_model->favoritos();
$vc_page_active = "Favoritos";
?><!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>
<?php include "includes/header.php" ?>
<!-- Page Title -->
<div class="page-title">
  <div class="container">
    <div class="pull-left">
      <h2>Propiedades Favoritas</h2>
    </div>
    <div class="breadcrumb">
      <ul>
        <li><a href="<?php echo mklink ("/") ?>">Inicio</a><span>|</span></li>
        <li>Propiedades favoritas</li>
      </ul>
    </div>
  </div>
</div>

<!-- Properties Listing Block -->
<div class="properties-listing-block">
  <div class="container">
    <div class="row">

      <?php include "includes/sidebar.php" ?>

      <div class="col-md-9 col-md-pull-3">
        <div class="listings">
          <div class="tab-content">
           <div id="grid" class="tab-pane fade in active">
            <div class="row">
              <?php foreach ($vc_listado as $l) { ?>
                <div class="col-md-6 mb30">
                  <div class="property-list">
                    <div class="image-block">
                      <?php if (!empty($l->path)) { ?>
                        <img src="/admin/<?php echo $l->path ?>" alt="<?php echo ($l->nombre);?>">
                      <?php } else if (!empty($empresa->no_imagen)) { ?>
                        <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($l->nombre);?>">
                      <?php } else { ?>
                        <img src="images/no-imagen.png" alt="<?php echo ($l->nombre);?>">
                      <?php } ?>
                      <div class="overlay">
                        <div class="table-container">
                          <div class="align-container">
                            <div class="user-action">
                              <a href="<?php echo $l->link_propiedad ?>"><i class="fas fa-plus"></i></a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php if (!empty($l->tipo_operacion)) {  ?>
                        <div class="on-sale">
                          <?php if (strtolower($l->tipo_operacion) == "ventas") echo "venta";
                          else if (strtolower($l->tipo_operacion) == "alquileres") echo "alquiler";
                          else echo $l->tipo_operacion; ?>
                        </div>
                      <?php } ?>
                    </div>
                    <div class="property-description">
                      <a href="<?php echo $l->link_propiedad ?>"><h5><?php echo $l->nombre ?></h5></a>
                      <div class="block">
                        <div class="pull-left">
                          <span><?php echo ($l->localidad).". ".$l->direccion_completa ?></span>
                        </div>
                        <div class="pull-right">
                          <span>Cod:</span>
                          <small><?php echo $l->codigo ?></small>
                        </div>
                      </div>
                      <div class="faclities-block">
                        <ul>
                          <div class="block">
                          <li><img src="images/hab.png"><?php echo (empty($l->dormitorios)) ? "-" : $l->dormitorios ?> Hab</li>
                          <li><img src="images/bathrooms.png" title="Baño"><?php echo (empty($l->banios)) ? "-" : $l->banios ?> Bañ.</li>
                           <li><img src="images/garage.png" title="Cochera/s"><?php echo (empty($l->cocheras)) ? "-" : $l->cocheras ?> Coch.</li>
                           <?php if (!empty($l->superficie_total)) { ?> <li><img src="images/grid.png"><?php echo $l->superficie_total ?> m2</li><?php } ?>
                          </div>
                        </ul>
                      </div>
                      <div class="grid-alto-txt">
                        <?php 
                        $l->texto = strip_tags($l->texto);
                        echo substr($l->texto,0,140); echo (strlen($l->texto) > 140) ? "..." : "" ?>
                      </div>
                      <div class="price-block">
                        <div class="pull-left">
                          <span><?php echo $l->precio ?></span>
                        </div>
                        <div class="pull-right">
                          <div class="wishlist">
                            <?php if (!empty($l->pint)) { ?>
                              <a href="javascript:void(0);"><img src="images/360.png">
                                <div class="tooltip-info">
                                  Recorrido 360°
                                </div>
                              </a>
                            <?php } ?>
                            <?php if ($l->apto_banco == 1) {  ?>
                              <a href="javascript:void(0);"><img src="images/icon.png">
                                <div class="tooltip-info">
                                  Apta Crédito Bancario
                                </div>
                              </a>
                            <?php } ?>

                            <?php if (estaEnFavoritos($l->id)) { ?>
                              <a class="active" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                <img src="images/wish-list.png">
                                <div class="tooltip-info">
                                  Borrar de Favoritos
                                </div>
                              </a>
                            <?php } else { ?>
                              <a href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                <img src="images/wish-list.png">
                                <div class="tooltip-info">
                                  Guarda Tus Inmuebles Favoritos
                                </div>
                              </a>
                            <?php } ?>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>            
            </div>
           </div>
           <div id="list" class="tab-pane fade in">
            <div class="row">
              <?php foreach ($vc_listado as $l) { ?>
                <div class="col-md-12 mb40">
                  <div class="full-list">
                    <div class="property-list">
                      <div class="image-block">
                        <?php if (!empty($l->path)) { ?>
                          <img  style="height: 260px" src="/admin/<?php echo $l->path ?>" alt="<?php echo ($l->nombre);?>">
                        <?php } else if (!empty($empresa->no_imagen)) { ?>
                          <img style="height: 260px"  src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($l->nombre);?>">
                        <?php } else { ?>
                          <img  style="height: 260px" src="images/no-imagen.png" alt="<?php echo ($l->nombre);?>">
                        <?php } ?>
                        <div class="overlay">
                          <div class="table-container">
                            <div class="align-container">
                              <div class="user-action">
                                <a href="<?php echo $l->link_propiedad ?>"><i class="fas fa-plus"></i></a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php if (!empty($l->tipo_operacion)) {  ?>
                          <div class="on-sale">
                            <?php if (strtolower($l->tipo_operacion) == "ventas") echo "venta";
                            else if (strtolower($l->tipo_operacion) == "alquileres") echo "alquiler";
                            else echo $l->tipo_operacion; ?>
                          </div>
                        <?php } ?>
                      </div>
                      <div class="property-description" style="height: 260px">
                        <a href="<?php echo $l->link_propiedad ?>"><h5><?php echo $l->nombre ?></h5></a>
                        <div class="block">
                          <div class="pull-left">
                            <span><?php echo ($l->localidad).". ".$l->direccion_completa ?></span>
                          </div>
                          <div class="pull-right">
                            <span>Cod:</span>
                            <small><?php echo $l->codigo ?></small>
                          </div>
                        </div>
                        <div class="faclities-block height-list">
                          <ul>
                             <li><img src="images/hab.png"><?php echo (empty($l->dormitorios)) ? "-" : $l->dormitorios ?> Hab</li>
                             <li><img src="images/bathrooms.png" title="Baño"><?php echo (empty($l->banios)) ? "-" : $l->banios ?> Bañ.</li>
                             <li><img src="images/garage.png" title="Cochera/s"><?php echo (empty($l->cocheras)) ? "-" : $l->cocheras ?> Coch.</li>
                             <?php if (!empty($l->superficie_total)) { ?> <li><img src="images/grid.png"><?php echo $l->superficie_total ?> m2</li><?php } ?>
                          </ul>
                        </div>
                        <div class="height-texto">
                          <?php 
                          $l->texto = strip_tags($l->texto);
                          echo substr($l->texto,0,60); echo (strlen($l->texto) > 60) ? "..." : "" ?>
                        </div>                       
                        <div class="price-block">
                          <div class="pull-left">
                            <span><?php echo $l->precio ?></span>
                          </div>
                          <div class="pull-right">
                            <div class="wishlist">
                              <?php if (!empty($l->pint)) { ?>
                                <a href="javascript:void(0);"><img src="images/360.png">
                                  <div class="tooltip-info">
                                    Recorrido 360°
                                  </div>
                                </a>
                              <?php } ?>
                              <?php if ($l->apto_banco == 1) {  ?>
                                <a href="javascript:void(0);"><img src="images/icon.png">
                                  <div class="tooltip-info">
                                    Apta Crédito Bancario
                                  </div>
                                </a>
                              <?php } ?>

                              <?php if (estaEnFavoritos($l->id)) { ?>
                                <a class="active" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                  <img src="images/wish-list.png">
                                  <div class="tooltip-info">
                                    Borrar de Favoritos
                                  </div>
                                </a>
                              <?php } else { ?>
                                <a href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                  <img src="images/wish-list.png">
                                  <div class="tooltip-info">
                                    Guarda Tus Inmuebles Favoritos
                                  </div>
                                </a>
                              <?php } ?>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
           </div>
         </div>
      </div>
      <?php } else { ?>
        <div class="filter-block">
          <h3>No hay propiedades guardadas en favoritos.</h3>
        </div>
      <?php } ?>
    </div>
    
  </div>
</div>
</div>

<!-- Footer -->
<?php include "includes/footer.php" ?>
<script type="text/javascript">
$(window).load(function(){
  var maximo = 0;
  $(".texto-height").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".texto-height").height(maximo);

  /*
  $('.slider-snap').noUiSlider({
    start: [ <?php echo $minimo ?>, <?php echo $maximo ?> ],
    step: 10,
    connect: true,
    range: {
      'min': 0,
      'max': <?php echo $precio_maximo ?>,
    }
  });
  $('.slider-snap').Link('lower').to($('.slider-snap-value-lower'));
  $('.slider-snap').Link('upper').to($('.slider-snap-value-upper'));
  */

});
</script>

<script type="text/javascript">
function enviar_orden() { 
  $("#orden_form").submit();
}
function enviar_orden_abajo() { 
  $("#orden_form_abajo").submit();
}
function enviar_buscador_propiedades() {
  var link = "<?php echo mklink("propiedades/")?>";
  if ($("#map-view").is(":checked")) {
    link = "<?php echo mklink("mapa/")?>";
  }
  var tipo_operacion = $("#tipo_operacion").val();
  var localidad = $("#localidad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  var minimo = $("#precio_minimo").val().replace(".","");
  $("#precio_minimo_oculto").val(minimo);
  var maximo = $("#precio_maximo").val().replace(".","");
  $("#precio_maximo_oculto").val(maximo);

  /*
  if ($('.slider-snap').length > 0) {
    var precios = $('.slider-snap').val();
    $("#filter_minimo").val(precios[0]);
    $("#filter_maximo").val(precios[1]);
  } 
  */ 

  $("#form_propiedades").attr("action",link);
  return true;
}
</script>
</body>
</html> 