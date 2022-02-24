<?php
include_once("includes/init.php");
$nombre_pagina = "contacto";
include_once("includes/funciones.php");
$id_origen = 6; // LA CONSULTA VIENE DEL FORM DE CONTACTO
$id_usuario = 0;

if (isset($_POST["id_usuario"])) {
  $id_usuario = filter_var($_POST["id_usuario"],FILTER_SANITIZE_STRING);
  $q = mysqli_query($conx,"SELECT * FROM com_usuarios WHERE id = $id_usuario");
  if (mysqli_num_rows($q)>0) {
     $usuario = mysqli_fetch_object($q);
     $contacto_para = $usuario->email;
	 $id_origen = 8; // LA CONSULTA VIENE DE STAFF
  } 
}

$titulo_pagina = "Contacto";
$breadcrumb = array(
  array("titulo"=>"Contacto","link"=>"/contacto/")
);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body id="contacto_page" class="bg-gray">
  
<?php include("includes/header.php"); ?>

<section class="main-wrapper oh">
  <div class="container style-two">
    <div class="page-heading">
      <h2>formulario de consulta</h2>
    </div>
    <div class="form">
      <div class="row">
        <?php include("includes/form_contacto.php"); ?>
      </div>
    </div>
  </div>
</section>
<?php include("includes/footer.php"); ?>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
    //OWL CAROUSEL(2) SCRIPT
jQuery(document).ready(function ($) {
"use strict";
$(".owl-carouselmarcas").owlCarousel({
      items : 5,
      itemsDesktop : [1279,2],
      itemsDesktopSmall : [979,2],
      itemsMobile : [639,1],
    });
});
</script>

</body>
</html>
