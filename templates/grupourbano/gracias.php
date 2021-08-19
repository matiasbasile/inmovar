<?php
include_once("includes/init.php");
include_once("includes/funciones.php");

$nombre_pagina = "Gracias";
$breadcrumb = array(
  array("titulo"=>"Gracias","link"=>"/web/gracias/")
);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>
<?php include("includes/header.php"); ?>

<!-- MAIN WRAPPER -->
<?php include("templates/comun/gracias.php"); ?>


<?php include("includes/footer.php"); ?>
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

function login_usuario(id) {
  var pass = $("#password_"+id).val();
  var clave = prompt("Ingrese su clave: ");
  var clave = hex_md5(clave);
  if (clave == pass) {
    var archivo = $("#archivo_"+id).val();
    if (!isEmpty(archivo)) window.open("/admin/"+archivo,"_blank");
  } else {
    alert("Clave incorrecta");
  }
}
function comunicate(id) {
  var f = document.createElement("form");
  f.setAttribute('method',"post");
  f.setAttribute('action',"/contacto/");
  var i = document.createElement("input");
  i.setAttribute('type',"hidden");
  i.setAttribute('name',"id_usuario");
  i.setAttribute('value',id);
  f.appendChild(i);
  $(f).css("display","none");
  document.body.appendChild(f);
  $(f).submit();
}
$(document).ready(function(){
  var maximo = 0;
  $(".member-info").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  $(".member-info").height(maximo);
});
</script>
</body>
</html>
