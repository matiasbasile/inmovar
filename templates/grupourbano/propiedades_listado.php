<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("includes/init.php");
include_once("includes/funciones.php");
$propiedades = extract($propiedad_model->get_variables(array()));
$nombre_pagina = $vc_link_tipo_operacion;
$tipos_op = $propiedad_model->get_tipos_operaciones();
$id_tipo_operacion = $vc_id_tipo_operacion;
if (isset($get_params["view"])) { $view = $get_params["view"] ; }
if (isset($get_params["per"])) { if($get_params["per"] = 1) { $nombre_pagina = "permutas" ;}  }
function filter() {
  global $vc_offset, $view, $vc_total_paginas, $vc_link, $vc_page, $id_tipo_operacion, $vc_orden, $vc_params; ?>
  <div class="filter">
    <?php if ($id_tipo_operacion <= 2) { ?>
      <ul class="tab-buttons">
        <li><a class="grid-view <?php echo(($view != 0)?"active":"") ?>" onclick="change_view(this)" href="javascript:void(0)"></a></li>
        <li><a class="list-view <?php echo(($view == 0)?"active":"") ?>" onclick="change_view(this)" href="javascript:void(0)"></a></li>
      </ul>
    <?php } ?>
    <div class="sort-by">
      <label for="sort-by">Ordenar por:</label>
      <select id="sort-by" name="orden" onchange="filtrar()">
        <option <?php echo($vc_orden == 0)?"selected":"" ?> value="0">Recientes</option>
        <option <?php echo($vc_orden == 1)?"selected":"" ?> value="1">Precio Mayor a Menor</option>
        <option <?php echo($vc_orden == 2)?"selected":"" ?> value="2">Precio Menor a Mayor</option>
      </select>
    </div>
    <?php
    if ($vc_total_paginas > 1) { ?>
      <div class="pagination">
        <?php if ($vc_page > 0) { ?>
            <a class="prev" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"></a>
        <?php } ?>
        <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
            <?php if (abs($vc_page-$i)<2) { ?>
              <a class="<?php echo ($i==$vc_page) ? "active" : ""?>" href="<?php echo mklink($vc_link.$i."/".$vc_params) ?>"><?php echo ($i+1); ?></a>
            <?php } ?>
        <?php } ?>
        <?php if ($vc_page < ($vc_total_paginas-1)) { ?>
            <a class="next" href="<?php echo mklink($vc_link.($vc_page+1)."/".$vc_params) ?>"></a>
        <?php } ?>
      </div>
    <?php } ?>
    <div class="present">
      <label for="show">Mostrar:</label>
      <select id="show" name="offset" onchange="filtrar()">
        <option <?php echo($vc_offset==5)?"selected":"" ?> value="5">5</option>
        <option <?php echo($vc_offset==10)?"selected":"" ?> value="10">10</option>
        <option <?php echo($vc_offset==20)?"selected":"" ?> value="20">20</option>
        <option <?php echo($vc_offset==50)?"selected":"" ?> value="50">50</option>
      </select>
    </div>    
  </div>
<?php } ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>

<?php include("includes/header.php"); ?>

<!-- MAIN WRAPPER -->
<section class="main-wrapper">
  <div class="container">
    <div class="row">
      <div class="<?php echo ($id_tipo_operacion <= 2) ? "col-md-9" : ""; ?>  primary">
        <?php if (sizeof($vc_listado)>0) { ?>
          <?php if ($id_tipo_operacion <= 2) { ?>
            <div class="tabs">
              <?php filter(); ?>
              <div class="tab-content grid-view <?php echo(($view == 0)?"dn":"") ?>" id="grid-view">
                <div class="row">
                  <?php foreach($vc_listado as $r) { 
                    $link_propiedad = (isset($r->pertenece_red) && $r->pertenece_red == 1) ? mklink($r->link)."&em=".$r->id_empresa : mklink($r->link); ?>
                    <div class="col-md-6">
                      <div class="property-item <?php echo ($r->id_tipo_operacion == 2)?"for-rent":"" ?>">
                        <div class="item-picture">
                          <div class="block">
                            <?php if (!empty($r->path)) { ?>
                              <img class="thumb-image" src="/admin/<?php echo $r->path ?>" alt="<?php echo ($r->nombre) ?>" />
                            <?php } else { ?>
                              <img class="thumb-image" src="images/no-image-1.jpg" alt="<?php echo ($r->nombre) ?>" />
                            <?php } ?>
                          </div>
                          <a class="view-more" href="<?php echo $r->link_propiedad ?>"><span></span></a>
                          <?php if ($r->id_tipo_estado != 1) { ?>
                            <div class="ribbon red"><?php echo ($r->tipo_estado) ?></div>
                          <?php } else { ?>
                            <div class="ribbon"><?php echo ($r->tipo_operacion) ?></div>
                          <?php } ?>
                        </div>
                        <div class="property-detail">
                          <div class="property-name"><a href="<?php echo $r->link_propiedad ?>"><?php echo ($r->nombre); ?></a></div>
                          <div class="property-location">
                            <div class="pull-left">
                              <?php echo ($r->calle); ?>
                              <?php if (!empty($r->localidad)) { ?>
                              &nbsp;&nbsp;|&nbsp;&nbsp;<?php echo ($r->localidad); ?>
                              <?php } ?>
                              </div>
                            <?php if (!empty($r->codigo)) { ?>
                              <div class="pull-right">Cod: <span><?php echo $r->codigo ?></span></div>
                            <?php } ?>
                          </div>
                          <?php if($r->dormitorios != 0 || $r->banios != 0 || $r->cocheras != 0 || $r->superficie_total != 0) { ?>
                            <div class="property-facilities">
                              <div class="block">
                                <?php if (!empty($r->dormitorios)) { ?>
                                  <div class="facilitie"><img src="images/room-icon.png" alt="Room" /> <?php echo $r->dormitorios ?> Hab</div>
                                <?php } ?>
                                <?php if (!empty($r->banios)) { ?>
                                  <div class="facilitie"><img src="images/shower-icon3.png" alt="Shower" /> <?php echo $r->banios ?> Ba&ntilde;os</div>
                                <?php } ?>
                              </div>
                              <div class="block">
                                <?php if (!empty($r->cocheras)) { ?>
                                  <div class="facilitie"><img src="images/garage-icon.png" alt="Garage" /> <?php echo $r->cocheras ?> Cochera</div>
                                <?php } ?>
                                <?php if (!empty($r->superficie_total)) { ?>
                                  <div class="facilitie"><img src="images/grid-icon.png" alt="Grid" /> <?php echo $r->superficie_total ?> m<sup>2</sup></div>
                                <?php } ?>
                              </div>
                            </div>
                          <?php } ?>
                          <?php if (!empty($r->descripcion)) { ?>
                            <p><?php echo ((strlen($r->descripcion)>100) ? substr($r->descripcion,0,100)."..." : $r->descripcion); ?></p>
                          <?php } else {
                            $texto = strip_tags(html_entity_decode($r->texto,ENT_QUOTES)); ?>
                            <p><?php echo ((strlen($texto)>100) ? substr($texto,0,100)."..." : $texto); ?></p>                            
                          <?php } ?>
                          <div class="property-price">
                            <big>
                              <?php echo $r->precio ?>
                            </big>
                            <?php if (estaEnFavoritos($r->id)) { ?>
                              <a href="/admin/favoritos/eliminar/?id=<?php echo $r->id; ?>" class="favorites-properties active"><span class="tooltip">Borrar de Favoritos</span></a>
                            <?php } else { ?>
                              <a href="/admin/favoritos/agregar/?id=<?php echo $r->id; ?>" class="favorites-properties"><span class="tooltip">Guarda Tus Inmuebles Favoritos</span></a>
                            <?php } ?>

                            <?php if ($r->acepta_permuta == 1) { ?>
                              <span class="apto_banco">
                                Acepta Permuta
                              </span>
                            <?php } ?>
                            <?php if ($r->apto_banco == 1) { ?>
                              <span class="apto_banco">
                                Apto cr&eacute;dito
                              </span>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div class="tab-content <?php echo(($view != 0)?"dn":"") ?>" id="list-view">
                <?php foreach($vc_listado as $r) {
                  $link_propiedad = (isset($r->pertenece_red) && $r->pertenece_red == 1) ? mklink($r->link)."&em=".$r->id_empresa : mklink($r->link); ?>
                  <div class="property-item <?php echo ($r->id_tipo_operacion == 2)?"for-rent":"" ?>">
                    <div class="item-picture">
                      <div class="block">
                        <?php if (!empty($r->path)) { ?>
                          <img class="thumb-image" src="/admin/<?php echo $r->path ?>" alt="<?php echo ($r->nombre) ?>" />
                        <?php } else { ?>
                          <img class="thumb-image" src="images/no-image-1.jpg" alt="<?php echo ($r->nombre) ?>" />
                        <?php } ?>
                      </div>
                      <a class="view-more" href="<?php echo $r->link_propiedad ?>"><span></span></a>
                      <?php if ($r->id_tipo_estado != 1) { ?>
                        <div class="ribbon red"><?php echo ($r->tipo_estado) ?></div>
                      <?php } else { ?>
                        <div class="ribbon"><?php echo ($r->tipo_operacion) ?></div>
                      <?php } ?>
                    </div>
                    <div class="property-detail">
                      <div class="property-name"><a href="<?php echo $r->link_propiedad ?>"><?php echo ($r->nombre); ?></a></div>
                      <div class="property-location">
                        <div class="pull-left"><?php echo ($r->calle); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo ($r->localidad); ?></div>
                        <?php if (!empty($r->codigo)) { ?>
                          <div class="pull-right">Cod: <span><?php echo $r->codigo ?></span></div>
                        <?php } ?>
                      </div>
                      <?php if($r->dormitorios != 0 || $r->banios != 0 || $r->cocheras != 0 || $r->superficie_total != 0) { ?>
                        <div class="property-facilities">
                          <?php if (!empty($r->dormitorios)) { ?>
                            <div class="facilitie"><img src="images/room-icon.png" alt="Room" /> <?php echo $r->dormitorios ?> Hab</div>
                          <?php } ?>
                          <?php if (!empty($r->banios)) { ?>
                            <div class="facilitie"><img src="images/shower-icon3.png" alt="Shower" /> <?php echo $r->banios ?> Ba&ntilde;os</div>
                          <?php } ?>
                          <?php if (!empty($r->cocheras)) { ?>
                            <div class="facilitie"><img src="images/garage-icon.png" alt="Garage" /> <?php echo $r->cocheras ?> Cochera</div>
                          <?php } ?>
                          <?php if (!empty($r->superficie_total)) { ?>
                            <div class="facilitie"><img src="images/grid-icon.png" alt="Grid" /> <?php echo $r->superficie_total ?> m<sup>2</sup></div>
                          <?php } ?>
                        </div>
                      <?php } ?>
                      <?php if (!empty($r->descripcion)) { ?>
                        <p class="property-description"><?php echo ((strlen($r->descripcion)>100) ? substr($r->descripcion,0,100)."..." : $r->descripcion); ?></p>
                      <?php } else {
                        $texto = strip_tags(html_entity_decode($r->texto,ENT_QUOTES)); ?>
                        <p class="property-description"><?php echo ((strlen($texto)>100) ? substr($texto,0,100)."..." : $texto); ?></p>                        
                      <?php } ?>
                      <div class="property-price">
                        <big>
                          <?php echo $r->precio ?>
                        </big>
                        <?php if (estaEnFavoritos($r->id)) { ?>
                          <a href="/admin/favoritos/eliminar/?id=<?php echo $r->id; ?>" class="favorites-properties active"><span class="tooltip">Borrar de Favoritos</span></a>
                        <?php } else { ?>
                          <a href="/admin/favoritos/agregar/?id=<?php echo $r->id; ?>" class="favorites-properties"><span class="tooltip">Guarda Tus Inmuebles Favoritos</span></a>
                        <?php } ?>
                        <?php if ($r->acepta_permuta == 1) { ?>
                          <span class="apto_banco">Acepta Permuta</span>
                        <?php } ?>
                        <?php if ($r->apto_banco == 1) { ?>
                          <span class="apto_banco">Apto cr&eacute;dito</span>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
            <?php filter(); ?>
          <?php } else if ($id_tipo_operacion == 4) { ?>
            <div class="tabs">
              <div class="filter">
                <div class="sort-by">
                  <label for="orden_emprendimientos">Ordenar por:</label>
                  <select id="orden_emprendimientos" name="orden" onchange="filtrar_emprendimientos()">
                    <option <?php echo (!isset($vc_orden))?"selected":"" ?> <?php echo($vc_orden == 0)?"selected":"" ?> value="0">Recientes</option>
                    <option <?php echo($vc_orden == 1)?"selected":"" ?> value="1">Precio Mayor a Menor</option>
                    <option <?php echo($vc_orden == 2)?"selected":"" ?> value="2">Precio Menor a Mayor</option>
                  </select>
                </div>
                <?php
                if ($vc_total_paginas > 1) { ?>
                  <div class="pagination">
                    <?php if ($vc_page > 0) { ?>
                        <a class="prev" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"></a>
                    <?php } ?>
                    <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
                        <?php if (abs($vc_page-$i)<2) { ?>
                          <a class="<?php echo ($i==$vc_page) ? "active" : ""?>" href="<?php echo mklink($vc_link.$i."/".$vc_params) ?>"><?php echo ($i+1); ?></a>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($vc_page < ($vc_total_paginas-1)) { ?>
                        <a class="next" href="<?php echo mklink($vc_link.($vc_page+1)."/".$vc_params) ?>"></a>
                    <?php } ?>
                  </div>
                <?php } ?>
                <div class="present">
                  <label for="offset_emprendimientos">Mostrar:</label>
                  <select id="offset_emprendimientos" name="offset" onchange="filtrar_emprendimientos()">
                    <option <?php echo($vc_offset==5)?"selected":"" ?> value="5">5</option>
                    <option <?php echo($vc_offset==10)?"selected":"" ?> value="10">10</option>
                    <option <?php echo($vc_offset==20)?"selected":"" ?> value="20">20</option>
                    <option <?php echo($vc_offset==50)?"selected":"" ?> value="50">50</option>
                  </select>
                </div>    
              </div>
              <?php foreach($vc_listado as $r) {
                $link_propiedad = (isset($r->pertenece_red) && $r->pertenece_red == 1) ? mklink($r->link)."&em=".$r->id_empresa : mklink($r->link); ?>
                <div class="col-md-4">
                  <div class="property-list for-enterprises">
                    <div class="item-picture">
                      <div class="block">
                        <?php if (!empty($r->path)) { ?>
                          <img class="thumb-image" src="/admin/<?php echo $r->path ?>" alt="<?php echo ($r->nombre) ?>" />
                        <?php } else { ?>
                          <img class="thumb-image" src="images/no-image-1.jpg" alt="<?php echo ($r->nombre) ?>" />
                        <?php } ?>
                      </div>
                      <div class="ribbon">emprendimientos</div>
                      <div class="blue-overlay"><a href="<?php echo $r->link_propiedad; ?>"></a></div>
                    </div>
                    <div class="property-info">
                      <div class="info-inner">
                        <div class="property-title"><a href="<?php echo $r->link_propiedad ?>"><?php echo ($r->nombre); ?></a></div>
                      </div>
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
                          <?php echo ($r->precio != 0)?$r->precio : "Consultar" ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          <?php } else if ($id_tipo_operacion == 5) { ?>
            <div class="tabs">
              <div class="filter">
                <div class="sort-by">
                  <label for="orden_obras">Ordenar por:</label>
                  <select id="orden_obras" name="orden" onchange="filtrar_obras()">
                    <option <?php echo (!isset($vc_orden))?"selected":"" ?> <?php echo($vc_orden == 0)?"selected":"" ?> value="0">Recientes</option>
                    <option <?php echo($vc_orden == 1)?"selected":"" ?> value="1">Precio Mayor a Menor</option>
                    <option <?php echo($vc_orden == 2)?"selected":"" ?> value="2">Precio Menor a Mayor</option>
                  </select>
                </div>
                <?php
                if ($vc_total_paginas > 1) { ?>
                  <div class="pagination">
                    <?php if ($vc_page > 0) { ?>
                        <a class="prev" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"></a>
                    <?php } ?>
                    <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
                        <?php if (abs($vc_page-$i)<2) { ?>
                          <a class="<?php echo ($i==$vc_page) ? "active" : ""?>" href="<?php echo mklink($vc_link.$i."/".$vc_params) ?>"><?php echo ($i+1); ?></a>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($vc_page < ($vc_total_paginas-1)) { ?>
                        <a class="next" href="<?php echo mklink($vc_link.($vc_page+1)."/".$vc_params) ?>"></a>
                    <?php } ?>
                  </div>
                <?php } ?>
                <div class="present">
                  <label for="offset_obras">Mostrar:</label>
                  <select id="offset_obras" name="offset" onchange="filtrar_obras()">
                    <option <?php echo($vc_offset==5)?"selected":"" ?> value="5">5</option>
                    <option <?php echo($vc_offset==10)?"selected":"" ?> value="10">10</option>
                    <option <?php echo($vc_offset==20)?"selected":"" ?> value="20">20</option>
                    <option <?php echo($vc_offset==50)?"selected":"" ?> value="50">50</option>
                  </select>
                </div>    
              </div>
              <div class="row">
                <?php foreach($vc_listado as $r) {
                  $link_propiedad = (isset($r->pertenece_red) && $r->pertenece_red == 1) ? mklink($r->link)."&em=".$r->id_empresa : mklink($r->link); ?>
                  <div class="col-md-6">
                    <div class="work-list">
                      <div class="item-picture">
                        <div class="block">
                          <?php if (!empty($r->path)) { ?>
                            <img class="thumb-image" src="/admin/<?php echo $r->path ?>" alt="<?php echo ($r->nombre) ?>" />
                          <?php } else { ?>
                            <img class="thumb-image" src="images/no-image-2.jpg" alt="<?php echo ($r->nombre) ?>" />
                          <?php } ?>
                        </div>
                        <div><a class="view-more" href="<?php echo $r->link_propiedad ?>"><span></span></a></div>
                      </div>
                      <div class="work-info">
                        <div class="table-container">
                          <div class="align-container">
                            <div class="ribbon">obras</div>
                            <h4><a href="<?php echo $r->link_propiedad ?>"><?php echo ($r->nombre); ?></a></h4>
                            <div class="work-price">
                              <?php echo ($r->localidad); ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          No se encontraron resultados.
        <?php } ?>
      </div>
      <?php if ($id_tipo_operacion <= 2) { ?>
        <div class="col-md-3 secondary">
          <?php include("includes/filter.php"); ?>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<?php include("includes/footer.php"); ?>
<script type="text/javascript" src="js/nouislider.js"></script>
<script type="text/javascript">

function change_view(e) {
  $(".list-view").removeClass("active");
  $(".grid-view").removeClass("active");
  $(e).addClass("active");
  filtrar();
}


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
  // Alquileres y ventas
  var maximo = 0;
  $(".grid-view .property-detail").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".grid-view .property-detail").height(maximo);
  
  // Emprendimientos
  var maximo = 0;
  $(".for-enterprises .info-inner").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".for-enterprises .info-inner").height(maximo);
  
  /*
  var maximo = 0;
  $(".item-picture .block img").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".item-picture .block img").height(maximo);
  */
  
  // Obras
  var maximo = 0;
  $(".work-list .item-picture img").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".work-list .item-picture img").height(maximo);
  
});

function cambiar_moneda_precio_minimo() {
  var v = $("#moneda_precio_minimo").val();
  $("#moneda_precio_maximo").val(v);
}
function cambiar_moneda_precio_maximo() {
  var v = $("#moneda_precio_maximo").val();
  $("#moneda_precio_minimo").val(v);
}

function filtrar_emprendimientos() {
  // Cargamos el offset y el orden en este formulario
  var orden = $("#orden_emprendimientos").val();
  var offset = $("#offset_emprendimientos").val();
  var url = "<?php echo mklink ("propiedades/emprendimientos/?orden=") ?>" + orden + "&offset=" + offset;
  location.href = url ;
} 

function filtrar_obras() {
  // Cargamos el offset y el orden en este formulario
  var orden = $("#orden_obras").val();
  var offset = $("#offset_obras").val();
  var url = "<?php echo mklink ("propiedades/obras/?orden=") ?>" + orden + "&offset=" + offset;
  location.href = url ;
} 
</script>
</body>
</html>
