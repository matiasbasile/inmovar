<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "includes/init.php";

$nombre_pagina = "favoritos";
$productos = $propiedad_model->favoritos();
$titulo_pagina = "Favoritos";

$sql = "SELECT IF(MAX(precio_final) IS NULL,0,MAX(precio_final)) AS maximo FROM inm_propiedades WHERE id_empresa = $empresa->id ";
$q_maximo = mysqli_query($conx,$sql);
$maximo = mysqli_fetch_object($q_maximo);
$precio_maximo = ($maximo->maximo == 0) ? 2000000 : (ceil($maximo->maximo/100)*100);

// Minimo
if (isset($_POST["minimo"])) { $_SESSION["minimo"] = filter_var($_POST["minimo"],FILTER_SANITIZE_STRING); }
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;

// Maximo
if (isset($_POST["maximo"])) { $_SESSION["maximo"] = filter_var($_POST["maximo"],FILTER_SANITIZE_STRING); }
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo; 
?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/head.php" ?>
</head>

<body>

<!-- header part start here -->
  <?php include "includes/header.php" ?>
<!--Listing Page Start here -->
<div class="listing_page">
  <div class="page_top_bar">
    <div class="container">
      <h3>Propiedades Favoritas</h3>
      <ul>
        <li><?php echo (sizeof($productos))." propiedad/es favorita/s"?></li>
      </ul>
    </div>
  </div>
  <div class="listing_wraper pg_spc">
    <div class="container">
      <div class="listing_wrap">
        <div class="row"> 
          <!-- left listing  part start -->
          <div class="col-lg-9">
            <div class="listing_left_wrap">
              
              <!-- Grid view view Start  here -->
              <div class="grid_view" id="grid_view_show">
                <div class="grd_view_qrap">
                  <div class="row">
                    <?php foreach ($productos as $l) {   ?>                        
                      <div class="col-lg-6 col-md-6">
                        <div class="tab_list_box">
                          <div class="hover_box_div">
                            <div class="tab_list_box_img">
                              <?php if (!empty($l->imagen)) { ?>
                                <img src="<?php echo $l->imagen ?>" alt="<?php echo ($l->nombre);?>">
                              <?php } else if (!empty($empresa->no_imagen)) { ?>
                                <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($l->nombre);?>">
                              <?php } else { ?>
                                <img src="images/no-imagen.png" alt="<?php echo ($l->nombre);?>">
                              <?php } ?>
                            </div>
                            <div class="hover_content">
                              <div class="display-table">
                                <div class="display-table-cell">
                                  <a class="pluss_icon" href="<?php echo mklink ($l->link) ?>"><img src="images/plus_icon.png" alt="plus_icon"></a>
                                  <a class="likes_icon" href="javascript:void(0)"><i class="fa fa-heart" aria-hidden="true"></i></a> </div>
                              </div>
                            </div>
                          </div>
                          <div class="tab_list_box_content">
                            <h6><a href="<?php echo mklink($l->link) ?>"><?php echo $l->nombre ?></a></h6>
                            <p>
                              <img src="images/locate_icon.png" alt="locate_icon"> <?php echo $l->direccion_completa ?>
                              <br/><span class="color_span"><?php echo $l->localidad ?></span>
                            </p>
                            <div class="cod_apto">
                              <h4 class="dollar_rs"> <?php echo $l->precio ?></h4>
                              <span class="text-right apto_like"> <a class="like_btn" href="javascript:void(0)"><i class="fa fa-heart" aria-hidden="true"></i></a> </span> </div>
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
                    <?php } ?>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <!-- left listing  part end --> 
          
          <!-- right sidebar part start -->
          <?php include "includes/sidebar_prop.php" ?>
          </div>
          <!-- right sidebar part End --> 
        </div>

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
<script type="text/javascript">
    function enviar_orden() { 
      $("#orden_form").submit();

    }
  </script>
<script type="text/javascript">

function enviar_buscador_propiedades() { 
  var link = "<?php echo mklink("propiedades/")?>";
  var tipo_operacion = $("#tipo_operacion").val();
  var localidad = $("#localidad").val();
  var tipo_propiedad = $("#tp").val();
  link = link + tipo_operacion + "/" + localidad + "/<?php echo $s_params?>";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>


</body>
</html>
