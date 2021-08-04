<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("includes/init.php");
$titulo_pagina = "propiedades";
extract($propiedad_model->get_variables());
$titulo_pagina = $vc_link_tipo_operacion;
$cotizacion_dolar = $propiedad_model->get_dolar();

$list_view = ($vc_apto_banco == 1);
?>
<!doctype html>
<html lang="en">
<head>
<?php include "includes/head.php" ?>
</head>
<body>

  <?php include "includes/header.php" ?>

  <div class="listing_page">
    <div class="page_top_bar">
      <div class="container">
        <h3><?php echo (!empty($vc_link_tipo_operacion))?$vc_link_tipo_operacion:"Todas las propiedades" ?></h3>
        <ul>
          <?php if ($vc_total_resultados != 0) {  ?>
          <li><?php echo ($vc_total_resultados == 1) ? "1 Resultado de b&uacute;squeda encontrado." : $vc_total_resultados." Resultados de b&uacute;squeda encontrados."?></li>
        <?php } else { ?>
            <li>No se encontraron resultados para su búsqueda.</li>
        <?php } ?>
        </ul>
      </div>
    </div>
    <div class="listing_wraper pg_spc">
      <div class="container">
        <div class="listing_wrap">
          <div class="row"> 
            <!-- left listing  part start -->
            <div class="col-lg-9">
              <?php if (empty($vc_listado)) { ?>
                <div class="listing_left_wrap">
                  No se encontraron resultados para su b&uacute;squeda.
                </div>
              <?php } else { ?>
                <div class="listing_left_wrap">
                  <div class="action_bar">
                    <div class="list_grid_anchor hidden-xs">
                      <ul>
                        <li> 
                          <a class="<?php echo ($list_view)?"":"active"; ?>" id="grid_list" href="javascript:void(0)"><i class="fa fa-th" aria-hidden="true"></i></a> 
                        </li>
                        <li> 
                          <a class="<?php echo ($list_view)?"active":""; ?>" id="list_list" href="javascript:void(0)"><i class="fa fa-list-ul" aria-hidden="true"></i></a> 
                        </li>
                      </ul>
                    </div>
                    <div class="order_number st_slect hidden-xs"> 
                      <span>Ordenar por:</span>
                      <select class="form-control-grey" onchange="submit_buscador_propiedades()" id="ordenador_orden" name="orden">
                        <option <?php echo ($vc_orden == 2 ) ? "selected" : "" ?> value="barato">Precio menor a mayor</option>
                        <option <?php echo ($vc_orden == 1 ) ? "selected" : "" ?> value="caro">Precio mayor a menor</option>
                      </select>
                    </div>
                    <div class="mostra p0 st_slect hidden-xs">
                      <span>Mostrar</span>
                      <select class="form-control-grey" onchange="submit_buscador_propiedades()" id="ordenador_offset" name="offset">
                        <option <?php echo ($vc_offset == "12")?"selected":"" ?> value="12">12</option>
                        <option <?php echo ($vc_offset == "24")?"selected":"" ?> value="24">24</option>
                        <option <?php echo ($vc_offset == "48")?"selected":"" ?> value="48">48</option>
                      </select>
                    </div>

                    <?php if ($vc_total_paginas > 1) {  ?>
                      <div class="listing_pagination text-right pull-right">
                        <ul>
                          <?php if ($vc_page > 0) { ?>
                            <li class="prev_list"><a href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
                          <?php } ?>
                          <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
                            <?php if (abs($vc_page-$i)<2) { ?>
                              <?php if ($i == $vc_page) { ?>
                                <li class="active"><a><span><?php echo $i+1 ?></span></a></li>
                              <?php } else { ?>
                                <li class=""><a href="<?php echo mklink ($vc_link.$i."/".$vc_params ) ?>"><span><?php echo $i+1 ?></span></a></li>
                              <?php } ?>
                            <?php } ?>
                          <?php } ?>
                          <?php if ($vc_page < $vc_total_paginas-1) { ?>
                            <li class="next_list"><a href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params ) ?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                          <?php } ?>
                        </ul>
                      </div>
                    <?php } ?> 
                  </div>
                  <!-- Grid view view Start  here -->
                  <div style="<?php echo (!$list_view)?"display:block":"display:none"; ?>" class="grid_view" id="grid_view_show">
                    <div class="grd_view_qrap">
                      <div class="row">
                        <?php foreach ($vc_listado as $l) { ?>
                          <div class="col-lg-6 col-md-6">
                            <div class="tab_list_box">
                              <div class="hover_box_div">
                                <?php /*if (!empty($l->video)) {  ?>
                                  <div class="tab_list_box_img gallery_box_img_second">
                                    <?php 
                                    if (strpos($l->video, "https://youtu.be/")>=0) {
                                      $l->video = str_replace("https://youtu.be/", '', $l->video);
                                      $l->video = '<iframe width="100%" height="300" src="https://www.youtube.com/embed/'.$l->video.'?playlist='.$l->video.'&loop=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                    }
                                    echo $l->video ?>
                                  </div>
                                <?php } else { */ ?>
                                  <?php $path = "images/no-imagen.png";
                                  if (!empty($l->imagen)) { 
                                    $path = $l->imagen;
                                  } else if (!empty($empresa->no_imagen)) {
                                    $path = "/admin/".$empresa->no_imagen;
                                  } ?>
                                  <div class="tab_list_box_img gallery_box_img_second ">
                                    <img src="<?php echo $path ?>" alt="<?php echo ($l->nombre);?>">
                                  </div>
                                  <div class="hover_content">
                                    <div class="display-table">
                                      <div class="display-table-cell">
                                        <a class="pluss_icon" href="<?php echo mklink ($l->link) ?>">
                                          <i class="fa fa-plus"></i>
                                        </a>
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
                                <?php //} ?>
                              </div>
                              <div class="tab_list_box_content">
                                <h6><a href="<?php echo $l->link_propiedad ?>"><?php echo $l->nombre ?></a></h6>
                                <p>
                                  <img src="images/locate_icon.png" alt="locate_icon"> <?php echo $l->direccion_completa ?>
                                  <br/><span class="color_span"><?php echo $l->localidad ?></span>
                                </p>
                                <div class="cod_apto">
                                  <h4 class="dollar_rs"> <?php echo $l->precio ?></h4>
                                  <span class="text-right apto_like"> 
                                    <?php if (estaEnFavoritos($l->id)) { ?>
                                      <a class="like_btn active" rel="nofollow" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                      </a>
                                    <?php } else { ?>
                                      <a class="like_btn" rel="nofollow" href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                      </a>
                                    <?php } ?>
                                  </span> 
                                </div>
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
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  
                  <div style="<?php echo ($list_view)?"display:block":"display:none"; ?>" class="list_view" id="list_view_show"> 
                    <?php foreach ($vc_listado as $l) {  ?>
                      <div class="list_view_listing">
                        <div class="row">
                          <div class="col-lg-6 col-md-6 pad-r">
                            <div class="listing_boxes">
                            <div class="list_view_img gallery_box_img_second">
                              <?php if (!empty($l->video)) {  ?>
                                <?php echo $l->video ?>
                              <?php } else { ?>                                
                                <a href="<?php echo $l->link_propiedad ?>" class="">
                                  <?php if (!empty($l->imagen)) { ?>
                                    <img src="<?php echo $l->imagen ?>" alt="<?php echo ($l->nombre);?>">
                                  <?php } else if (!empty($empresa->no_imagen)) { ?>
                                    <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($l->nombre);?>">
                                  <?php } else { ?>
                                    <img src="images/no-imagen.png" alt="<?php echo ($l->nombre);?>">
                                  <?php } ?>
                                </a>
                                <div class="pos_btn"><a class="btn_orange<?php echo ($l->id_tipo_estado != 1)?" reserved":"" ?>" href="javascript:void(0)">
                                  <?php if ($l->id_tipo_estado != "1") { echo $l->tipo_estado; } else {
                                      if ($l->id_tipo_operacion =="1") { echo "en venta";} 
                                      elseif ($l->id_tipo_operacion == "2") { echo "en alquiler";}
                                      elseif ($l->id_tipo_operacion == "4") { echo "emprendimientos";}
                                    }?>
                                  </a>
                                </div>                                
                              <?php } ?>
                            </div>
                            <div class="hover_content1">
                              <div class="display-table">
                                <div class="display-table-cell">
                                  <a class="squ_icon" href="<?php echo mklink ($l->link) ?>"><i class="fa fa-plus-square" aria-hidden="true"></i></a> 
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                          <div class="list_view_details">
                            <h3><a href="<?php echo $l->link_propiedad ?>"><?php echo $l->nombre ?></a></h3>
                            <div class="address_detail1">
                              <p>
                                <img src="images/locate_icon.png" alt="locate_icon"> <?php echo $l->direccion_completa ?>
                                <br/><span class="color_span"> <?php echo $l->localidad ?> </span>
                              </p>
                              <h4 class="dollar_rs"> <?php echo $l->precio ?></h4>
                            </div>
                            <div class="cod_apto">
                              <span class="cod_span"><strong>Cod:</strong> <?php echo $l->codigo ?></span>
                              <span class="text-right apto_like">
                                <?php if ($l->apto_banco == 1) {  ?><a class="apto_home" href="javascript:void(0)"><img src="images/home_apto_icon.png" alt="home_apto_icon"> Apto cr&eacute;dito</a><?php } ?>
                                <?php if (estaEnFavoritos($l->id)) { ?>
                                  <a class="like_btn active" rel="nofollow" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                  </a>
                                <?php } else { ?>
                                  <a class="like_btn" rel="nofollow" href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                  </a>
                                <?php } ?>
                              </span>
                            </div>
                            <div class="list_box_footer">
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
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>

          <?php include "includes/sidebar_prop.php" ?>
        </div>

      </div>

      <?php if ($vc_total_paginas > 1) {  ?>
        <div class="listing_pagination  btm_pagination">
          <ul>
            <?php if ($vc_page > 0) { ?>
              <li class="prev_list"><a href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params) ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
            <?php } ?>
            <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
              <?php if (abs($vc_page-$i)<2) { ?>
                <?php if ($i == $vc_page) { ?>
                  <li class="active"><a><span><?php echo $i+1 ?></span></a></li>
                <?php } else { ?>
                  <li class=""><a href="<?php echo mklink ($vc_link.$i."/".$vc_params) ?>"><span><?php echo $i+1 ?></span></a></li>
                <?php } ?>
              <?php } ?>
            <?php } ?>
            <?php if ($vc_page < $vc_total_paginas-1) { ?>
              <li class="next_list"><a href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params) ?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
            <?php } ?>
          </ul>
        </div>
      <?php } ?>

    </div>
  </div>
</div>

<?php include "includes/footer.php" ?>

<script src="js/jquery-3.2.1.slim.min.js"></script> 
<script src="js/bootstrap.js"></script> 
<script src="js/popper.min.js"></script>
<script type="text/javascript" src="js/price-range.js"></script> 
<script src="js/owl.carousel.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $("#grid_list").click(function(){
    $("#grid_view_show").show();
    $("#list_view_show").hide();
  });
  $("#list_list").click(function(){
    $("#list_view_show").show();
    $("#grid_view_show").hide();
  });
});

$('.list_grid_anchor li a').click( function(){
  if ( $(this).hasClass('active') ) {
    $(this).removeClass('active');
  } else {
    $('.list_grid_anchor li a.active').removeClass('active');
    $(this).addClass('active');    
  }
});
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
  $(".tab_list_box_content p").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".tab_list_box_content p").height(maximo);
  
});
$(document).ready(function(){
  var maximo = 0;
  $(".tab_list_box_content h6").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".tab_list_box_content h6").height(maximo);
  
});
</script>
</body>
</html>
