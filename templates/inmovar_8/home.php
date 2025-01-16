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

  <?php include "includes/header.php" ?>

  <?php include "includes/home/slider.php" ?>

  <?php include "includes/home/boxes.php" ?>

  <?php include "includes/home/nosotros.php" ?>

  <?php include "includes/home/destacados.php" ?>

  <?php include "includes/home/emprendimientos.php" ?>

  <?php include "includes/home/informacion.php" ?>

  <?php include "includes/footer.php" ?>

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
