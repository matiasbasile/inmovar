<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("includes/init.php");
$titulo_pagina = "mapa";
extract($propiedad_model->get_variables(array(
  "offset"=>99999
)));
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
          <li><?php echo ($vc_total_resultados == 1) ? "1 Resultado de b&uacute;squeda encontrado." : $vc_total_resultados." Resultados de b&uacute;squeda encontrados."?></li>
        </ul>
      </div>
    </div>
    <div class="listing_wraper pg_spc">
      <div class="container">
        <div class="listing_wrap">
          <div class="row"> 
            <div class="col-lg-9">
              <?php if (sizeof($vc_listado)> 0) {  ?>
                <div id="mapa_propiedades"></div>
              <?php } else { ?>
                <div>No se encontraron resultados para su búsqueda.</div>
              <?php } ?>
            </div>
            <?php include "includes/sidebar_prop.php" ?>
          </div>
        </div>
      </div>

    </div>
  </div>

<?php include "includes/footer.php" ?>

<script src="js/jquery-3.2.1.slim.min.js"></script> 
<script src="js/bootstrap.js"></script> 
<script src="js/popper.min.js"></script>
<script type="text/javascript" src="js/price-range.js"></script> 
<script src="js/owl.carousel.js"></script>

<?php include_once("templates/comun/mapa_js.php"); ?>

<script type="text/javascript">
$(document).ready(function(){

  var mymap = L.map('mapa_propiedades').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
      '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
      'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox.streets'
  }).addTo(mymap);

  var icono = L.icon({
    iconUrl: "images/map-marker.png",
    iconSize:     [44,50], // size of the icon
    iconAnchor:   [44,25], // point of the icon which will correspond to marker's location
  });

    mymap.fitBounds([
    <?php foreach($vc_listado as $p) {
      if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) {  ?>
        [<?php echo $p->latitud ?>,<?php echo $p->longitud ?>],
      <?php } ?>
    <?php } ?>
  ]);

  <?php $i=0;
  foreach($vc_listado as $p) {
    if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) { 
      $path = "images/no-imagen.png";
      if (!empty($p->imagen)) { 
        $path = $p->imagen;
      } else if (!empty($empresa->no_imagen)) {
        $path = "/admin/".$empresa->no_imagen;
      } ?>
      var contentString<?php echo $i; ?> = '<div id="content">'+
        '<div class="feature-item" style="padding: 0px;">'+
          '<div class="feature-image">'+
            '<a href=\"<?php echo mklink($p->link) ?>\">'+
              '<img style="max-width:100%" src=\"<?php echo $path ?>\"/>'+
            '</a>'+
          '</div>'+
          '<div class="tab_list_box_content">'+
            '<h6><a href=\"<?php echo mklink($p->link) ?>\"><?php echo ($p->nombre) ?></a></h6>'+
            '<p>'+
              '<img src="images/locate_icon.png" alt="locate_icon">'+
              '<?php echo $p->calle." ".$p->entre_calles ?>'+
              '<br><span class="color_span"><?php echo $p->localidad ?></span>'+
            '</p>'+
            '<h6 class="price_dollar"><?php echo $p->precio ?></h6>'+
          '</div>'+
        '</div>'+
      '</div>';
    
      var marker<?php echo $i; ?> = L.marker([<?php echo $p->latitud ?>,<?php echo $p->longitud ?>],{
        icon: icono
      });
      marker<?php echo $i; ?>.addTo(mymap);

      marker<?php echo $i; ?>.bindPopup(contentString<?php echo $i; ?>);

    <?php } ?>
  <?php $i++; } ?>

   

});
 

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
  
  // Cuando cambiamos algun campo
  $(".submit_onchange").change(function(e){
    $(e.currentTarget).parents("form").submit();
  });

});

function enviar_orden() {
  $("#sidebar_orden").val("#ordenador_orden");
  $("#sidebar_offset").val("#ordenador_offset");
  $("#form_propiedades").submit();
}
</script>
</body>
</html>
