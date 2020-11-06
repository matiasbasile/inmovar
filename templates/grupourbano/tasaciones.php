<?php
$nombre_pagina = "contacto";
include_once("models/Propiedad_Model.php");
include_once("includes/funciones.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
$id_origen = 7; // LA CONSULTA VIENE DE TASACIONES
$titulo_pagina = "Tasaciones";
$breadcrumb = array(
  array("titulo"=>"Tasaciones","link"=>"/web/tasaciones/")
);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>
  
<?php include("includes/header.php"); ?>

<section class="main-wrapper">
  <div class="container">
    <div class="contact">
      <div class="border-box">
        <div class="box-space">
          <div class="section-title"><big>Tasaciones</big></div>
          <?php if (!empty($empresa->texto_contacto)) { ?>
            <?php echo html_entity_decode($empresa->texto_contacto,ENT_QUOTES); ?>
          <?php } ?>
        </div>
        <div class="info-title">formulario de consulta</div>
        <div class="box-space">
          <div class="form">
            <div class="row">
              <?php include("includes/form_contacto.php"); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include("includes/footer.php"); ?>
</body>
</html>
