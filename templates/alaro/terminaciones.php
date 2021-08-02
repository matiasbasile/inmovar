<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("includes/funciones.php");
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
$header_cat = "";
$entradas = $entrada_model->get_list(array(
  "categoria"=>"terminaciones",
));
$nombre_pagina = "terminaciones";
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="loading">
<?php include("includes/header.php"); ?>
<!-- RED BOX TITLE -->
<div class="red-box-title">
  <div class="container">
    <ul>
      <li>terminaciones</li>
    </ul>
  </div>
</div>
<div class="gallery-page">
  <?php foreach($entradas as $r) { 
    $entrada = $entrada_model->get($r->id); ?>
    <div class="gallery-title">
      <div class="container"><?php echo $entrada->titulo ?></div>
    </div>
    <?php foreach($entrada->images as $img) { ?>
      <div class="col-md-3">
        <div class="project-list"> <img src="<?php echo $img ?>" alt="Gallery">
          <div class="about-project">
            <div class="small-list">
              <div class="overlay-info">
                <div class="center-content">
                  <div class="align-center"> <a class="fancybox" href="<?php echo $img ?>" data-fancybox-group="gallery"></a> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  <?php } ?>
</div>
<?php include("includes/footer.php"); ?>
<script type="text/javascript" src="js/fancybox.js"></script> 
<script type="text/javascript">
$('.fancybox').fancybox();
</script>
</body>
</html>