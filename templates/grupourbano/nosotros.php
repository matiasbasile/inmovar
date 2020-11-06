<?php
include_once("includes/init.php");
include_once("includes/funciones.php");

$nombre_pagina = "Nosotros";
$breadcrumb = array(
  array("titulo"=>"Nosotros","link"=>"/web/nosotros/")
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
<section class="main-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-9 primary">
        <div class="section-title left"><big>Nosotros</big></div>
        <div class="row">
          <?php
          $sql = "SELECT * FROM com_usuarios WHERE id_empresa = 45 AND activo = 1 ORDER BY cast(dni as unsigned) ASC, id ASC ";
          $q = mysqli_query($conx,$sql);
          while(($r=mysqli_fetch_object($q))!==NULL) { ?>
            <div class="col-md-6">
              <div class="member-list">
                <div class="item-picture">
                  <div class="block"><img src="/admin/<?php echo $r->path; ?>" alt="<?php echo ($r->nombre." ".$r->apellido); ?>" /></div>
                </div>
                <input type="hidden" id="password_<?php echo $r->id ?>" value="<?php echo $r->password ?>"/>
                <input type="hidden" id="archivo_<?php echo $r->id ?>" value="<?php echo $r->archivo ?>"/>
                <div class="member-info">
                  <div class="member-name"><?php echo ($r->nombre); ?></div>
                  <?php if (!empty($r->titulo)) { ?>
                    <div class="member-designation"><?php echo ($r->titulo); ?></div>
                  <?php } ?>
                  <?php if (!empty($r->cargo)) { ?>
                    <div class="member-division"><?php echo ($r->cargo); ?></div>
                  <?php } ?>
                  <ul>
                    <?php if (!empty($r->telefono)) { ?>
                      <li><a href="tel:<?php echo ($r->telefono); ?>"><?php echo ($r->telefono); ?></a></li>
                    <?php } ?>
                    <?php if (!empty($r->celular)) { ?>
                      <li><a href="tel:<?php echo ($r->celular); ?>"><?php echo ($r->celular); ?></a></li>
                    <?php } ?>
                    <?php if (!empty($r->email)) { ?>
                      <li><a href="mailto:<?php echo ($r->email); ?>"><?php echo ($r->email); ?></a></li>
                    <?php } ?>
                  </ul>
                  <div class="two-button">
                    <a href="http://www.grupo-urbano.com.ar/admin/" target="_blank" class="btn btn-blue-border">entrar</a>
                    <a href="javascript:void(0)" onclick="comunicate(<?php echo $r->id ?>)" class="btn btn-black-border">comunicate</a>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-md-3 secondary">
        <div class="border-box">
          <?php include("includes/sidebar.php"); ?>
        </div>
      </div>
    </div>
  </div>
</section>

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
