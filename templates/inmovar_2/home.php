<?php
include "includes/init.php"; 
$titulo_pagina = "Inicio";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include "includes/head.php" ?>
<link rel="stylesheet" type="text/css" href="css/nivoslider.css">
</head>
<body>

  <?php include "includes/header.php" ?>

  <?php include "includes/home/slider.php" ?>

  <?php include "includes/home/buscador.php" ?>
  
  <?php include("includes/home/destacadas.php") ?>

  <?php include("includes/home/banners.php") ?>

  <?php include("includes/home/ultimas.php") ?>

  <div class="clearfix"></div>

  <?php include "includes/footer.php" ?>
  
<script type="text/javascript">
  function enviar_orden() { 
    $("#orden_form").submit();
  }
  function enviar_buscador_propiedades() {
    var link = "<?php echo mklink("propiedades/") ?>";
    var tipo_operacion = $("#tipo_operacion").val();
    var localidad = $("#localidad").val();
    link = link + tipo_operacion + "/" + localidad + "/";
    $("#form_propiedades").attr("action",link);
    return true;
  }
</script>
<script type="text/javascript">
  $(document).ready(function(){
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
<script type="text/javascript" src="js/nivoslider.js"></script>
    <script type="text/javascript">
  $(document).ready(function() {
    $('#slider').nivoSlider({
      effect: 'random',
      slices: 15,
      boxCols: 8,
      boxRows: 4,
      animSpeed: 500,
      pauseTime: 3000,
      startSlide: 0,
      directionNav: true,
      controlNav: false,
      controlNavThumbs: false,
      pauseOnHover: true,
      manualAdvance: false,
      prevText: '<i class="fa fa-chevron-left"></i>',
      nextText: '<i class="fa fa-chevron-right"></i>',
      randomStart: false,
      afterLoad: function(){
      }
    });
  });
  </script>
</body>
</html>