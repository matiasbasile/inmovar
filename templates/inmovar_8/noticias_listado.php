<?php include "includes/init.php" ?>
<?php 
$offset = 3;
if (isset ($get_params['offset'])) { $offset = $get_params['offset'] ;}
/*-------ORDEN----*/ 
if (isset ($get_params['orden'])) {
 if ($get_params['orden']=='nuevos') { 
   $orden = "A.id DESC" ; }
 elseif ($get_params['orden']=='viejos') {
   $orden = "A.id ASC" ;         } 
 } else {
$orden = "A.id DESC"; } 
$page = 0 ; 
$link_general = "entradas/";
$id_categoria = 0;
$categorias = array();
$titulo_pagina = "informacion";
for($i=1;$i<(sizeof($params));$i++) {
  // Nombre de categoria
  $p = $params[$i];
  $sql = "SELECT * FROM not_categorias WHERE link = '".$p."' AND id_empresa = $empresa->id ";
  $q = mysqli_query($conx,$sql);
  if (mysqli_num_rows($q)>0) {
    $cat = mysqli_fetch_object($q);
    $categorias[] = $cat;
    $id_categoria = $cat->id;
    $id_padre = $cat->id_padre;
    $titulo_cat = $cat->nombre;
    $link_general.= $cat->link.'/' ;
    } else {
      // Si el ultimo parametro es un numero, es porque indica el numero de pagina
      if (is_numeric($p) && ($i == sizeof($params)-1)) {
        $page = (int)$p;
      } else {
        // La categoria no es valida, directamente redireccionamos
        header("Location: /404.php");          
      }
  }
}

$listado_infos = $entrada_model->get_list(array(
  "order_by"=>$orden,
  'from_id_categoria'=>$id_categoria,
  "offset"=>$offset,
  "limit"=>($page * $offset),
));
if (sizeof($listado_infos)==1) { 
$e=$listado_infos[0];
header("location:". mklink($e->link));
}
$total = $entrada_model->get_total_results();
$total_paginas = ceil ($total / $offset);
?>
<!doctype html>
<html lang="en">
<?php include "includes/head.php" ?>
<body>

  <!-- header part start here -->
  <?php include "includes/header.php" ?>

  <!-- header part end here --> 

  <!--Listing Page Start here -->
  <div class="listing_pages2">
    <div class="page_top_bar">
      <div class="container">
        <h3>información</h3>
        <ul>
          <li><?php echo (!empty($titulo_cat))?utf8_encode($titulo_cat):"Todas las publicaciones" ?></li>
        </ul>
      </div>
    </div>
    <div class="listing_wraperes2 pg_spc">
      <div class="container">
        <div class="listing_wraps2">
          <div class="row"> 
            <!-- left listing  part start -->
            <div class="col-lg-9">
              <div class="listing_left_wrap">
                <div class="action_bar">
                  <form id="orden_form">
                    <div class="order_number st_slect"> <span>Ordenar por:</span>
                    <select class="form-control-grey" onchange="enviar_orden()" name="orden">
                        <option <?php echo ($orden == "A.id DESC")?"selected":"" ?> value="nuevos">Más Nuevos</option>
                        <option <?php echo ($orden == "A.id ASC")?"selected":"" ?> value="viejos">Más Viejos</option>
                      </select>
                  </div>
                  <div class="mostra st_slect"> <span>Mostrar</span>
                    <select class="form-control-grey" onchange="enviar_orden()" name="offset">
                      <option <?php echo ($offset == "3")?"selected":"" ?> value="3">3</option>
                      <option <?php echo ($offset == "6")?"selected":"" ?> value="6">6</option>
                      <option <?php echo ($offset == "9")?"selected":"" ?> value="9">9</option>
                      <option <?php echo ($offset == "12")?"selected":"" ?> value="12">12</option>
                    </select>
                  </div> 

                  <?php if ($total_paginas > 0) {  ?>
                    <!-- bottom pagination start -->
                    <div class="listing_pagination  text-right pull-right">
                      <ul>
                        <?php if ($page > 0) { ?>
                          <li class="prev_list"><a href="<?php echo mklink ($link_general.($page-1)."/") ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
                        <?php } ?>
                        <?php for($i=0;$i<$total_paginas;$i++) { ?>
                          <?php if (abs($page-$i)<3) { ?>
                            <?php if ($i == $page) { ?>
                              <li class="active"><a><span><?php echo $i+1 ?></span></a></li>
                            <?php } else { ?>
                              <li class=""><a href="<?php echo mklink ($link_general.$i."/") ?>"><span><?php echo $i+1 ?></span></a></li>
                            <?php } ?>
                          <?php } ?>
                        <?php } ?>
                        <?php if ($page < $total_paginas-1) { ?>
                          <li class="next_list"><a href="<?php echo mklink ($link_general.($page+1)."/") ?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                        <?php } ?>
                      </ul>
                    </div>
                  <?php } ?> 
                  </form>
                 
                          
                </div>

                <!-- list view start here -->
                <div class="list_view_boxes"> 
                  <!-- listing box by row start -->
                  <?php foreach ($listado_infos as $l) {  ?>
                    <div class="list_view_listing">
                      <div class="row">
                        <div class="col-lg-6 col-md-6 pad-r">
                          <div class="list_view_img">
                            <?php if (!empty($l->path)) { ?>
                              <img style="object-fit: cover;width: 100%;height: 280px" src="<?php echo $l->path ?>" alt="<?php echo ($l->titulo); ?>" />
                            <?php } else if (!empty($empresa->no_imagen)) { ?>
                              <img style="object-fit: cover;width: 100%;height: 280px" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($l->titulo); ?>" />
                            <?php } ?>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                          <div class="list_boxes_content">
                            <h3 class="heading_details1"><?php echo $l->titulo ?></h3>
                            <?php if ($l->mostrar_fecha == 1) {  ?><div class="date_time"> <span><i class="fa fa-calendar" aria-hidden="true"></i><?php echo $l->fecha ?></span> <span class="time_span"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo $l->hora ?>hs.</span> </div><?php } ?>
                            <div class="consejo_entry_content">
                            <p><?php  $l->texto = strip_tags($l->texto);echo utf8_encode((substr($l->texto,0,100))); echo (strlen($l->texto)>100)?"...":"" ?></p>
                            </div>
                            <div class="pos_btn1"><a class="btn_orange1" href="<?php echo mklink ($l->link) ?>">ver más</a></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <!-- left listing  part end --> 

            <!-- right sidebar part start -->
            <?php include "includes/sidebar.php" ?>
            <!-- right sidebar part End --> 
          </div>


          <?php if ($total_paginas > 0) {  ?>
            <!-- bottom pagination start -->
            <div class="listing_pagination btm_pagination">
              <ul>
                <?php if ($page > 0) { ?>
                  <li class="prev_list"><a href="<?php echo mklink ($link_general.($page-1)."/") ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
                <?php } ?>
                <?php for($i=0;$i<$total_paginas;$i++) { ?>
                  <?php if (abs($page-$i)<3) { ?>
                    <?php if ($i == $page) { ?>
                      <li class="active"><a><span><?php echo $i+1 ?></span></a></li>
                    <?php } else { ?>
                      <li class=""><a href="<?php echo mklink ($link_general.$i."/") ?>"><span><?php echo $i+1 ?></span></a></li>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
                <?php if ($page < $total_paginas-1) { ?>
                  <li class="next_list"><a href="<?php echo mklink ($link_general.($page+1)."/") ?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                <?php } ?>
              </ul>
            </div>
          <?php } ?>

          <!-- bottom pagination End --> 

        </div>
      </div>
    </div>
  </div>

  <!--Listing Page End here --> 

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
    function enviar_orden() { 
      $("#orden_form").submit();
    }
  </script>
</body>
</html>
