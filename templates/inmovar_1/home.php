<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$nombre_pagina = "home";
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);

include_once("includes/funciones.php");

// Minimo
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;

// Maximo
$precio_maximo = $propiedad_model->get_precio_maximo();
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo;
$tipo_operacion = new stdClass();
$tipo_operacion->id = 0;
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="page-homepage navigation-fixed-top page-slider page-slider-search-box" id="page-top" data-spy="scroll" data-target=".navigation" data-offset="90">
<div class="wrapper">

  <?php include("includes/header.php"); ?>

  <?php include("includes/home/slider.php"); ?>

  <div class="search-box-wrapper search-box-home">
    <div class="search-box-inner">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-md-offset-9 col-sm-4 col-sm-offset-8">
            <div class="search-box map">
              <?php include("includes/buscador.php"); ?>
            </div><!-- /.search-box.map -->
          </div><!-- /.col-md-3 -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.search-box-inner -->
  </div>

  <div id="page-content">

    <?php include("includes/home/banners.php"); ?>

    <?php include("includes/home/destacadas.php"); ?>

    <?php include("includes/home/ultimas.php"); ?>

    <?php include("includes/home/testimonios.php"); ?>

  </div>
  <?php include("includes/footer.php"); ?>
</div>
<script type="text/javascript" src="assets/js/custom.js?g=<?php echo rand(0,999) ?>"></script>
<div id="overlay"></div>
<script type="text/javascript">
$(window).load(function(){
  initializeOwl(false);
});
</script>
</body>
</html>