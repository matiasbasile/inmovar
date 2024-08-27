<?php 
include "includes/init.php"; 
$titulo_pagina = "Contacto"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include "includes/head.php" ?>
</head>
<body>

  <div class="home-slider">
    <?php include("includes/header.php") ?>
    <div class="container">
      <div class="breadcrumb-area">
        <h1 class="h1"><?php echo $titulo_pagina ?></h1>
        <ul class="breadcrumbs">
          <li><a href="<?php echo mklink ("/") ?>">Inicio</a></li>
          <li class="active">Contacto</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="contact-body content-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">

          <div id="googleMap" style="width:100%; height:300px; margin-bottom: 50px; filter: grayscale(100%);-webkit-filter: grayscale(100%);"></div>

          <!-- Contact form start -->
          <div class="contact-form">
            <div class="main-title-2">
              <h1>Dejanos tu <span>mensaje</span></h1>
            </div>
            <form onsubmit="return enviar_contacto();">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group fullname">
                    <input type="text" id="contacto_nombre" name="full-name" class="input-text" placeholder="Nombre">
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group enter-email">
                    <input type="email" id="contacto_email" name="email" class="input-text" placeholder="Email">
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group subject">
                    <input type="text" id="contacto_asunto" name="subject" class="input-text" placeholder="Asunto">
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group number">
                    <input type="text" id="contacto_telefono" name="phone" class="input-text" placeholder="Teléfono">
                  </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix">
                  <div class="form-group message">
                    <textarea class="input-text" id="contacto_mensaje" name="message" placeholder="Escriba aquí su mensaje..."></textarea>
                  </div>
                </div>
                <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group send-btn">
                    <button type="submit" id="contacto_submit" class="button-md button-theme">Enviar mensaje</button>
                  </div>
                </div>
              </div>
            </form>     
          </div>
          <!-- Contact form end -->
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <?php include("includes/sidebar_contacto.php") ?>
        </div>
      </div>
    </div>
  </div>

<?php include "includes/footer.php" ?>
<?php include_once("templates/comun/mapa_js.php"); ?>
  
<script type="text/javascript">
$(document).ready(function(){
  <?php if (!empty($empresa->posiciones) && !empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('googleMap').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
    }).addTo(mymap);


    <?php
    $posiciones = explode("/",$empresa->posiciones);
    for($i=0;$i<sizeof($posiciones);$i++) { 
      $pos = explode(";",$posiciones[$i]); ?>
      L.marker([<?php echo $pos[0] ?>,<?php echo $pos[1] ?>]).addTo(mymap);
    <?php } ?>

  <?php } ?>
});
</script>
<script type="text/javascript"> function enviar_contacto() {
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var asunto = $("#contacto_asunto").val();
  var id_articulo = $("#contacto_articulo").val();
  var id_origen = <?php echo (isset($id_origen) ? $id_origen : 0) ?>;
  
  if (isEmpty(nombre) || nombre == "Nombre") {
      alert("Por favor ingrese un nombre");
      $("#contacto_nombre").focus();
      return false;          
  }
  if (!validateEmail(email)) {
      alert("Por favor ingrese un email valido");
      $("#contacto_email").focus();
      return false;          
  }
  if (isEmpty(telefono) || telefono == "Telefono") {
      alert("Por favor ingrese un telefono");
      $("#contacto_telefono").focus();
      return false;          
  }
  if (isEmpty(mensaje) || mensaje == "Mensaje") {
      alert("Por favor ingrese un mensaje");
      $("#contacto_mensaje").focus();
      return false;              
  }    
  
  $("#contacto_submit").attr('disabled', 'disabled');
  var datos = {
    "para":"<?php echo $empresa->email ?>",
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "asunto":asunto,
    "id_articulo":id_articulo,
    "id_empresa":ID_EMPRESA,
    "id_origen": ((id_origen != 0) ? id_origen : ((id_articulo != 0)?1:6)),
  }
  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        window.location.href ='<?php echo mklink ("web/gracias/") ?>';
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
      }
    }
  });
  return false;
}
</script>
</body>
</html>