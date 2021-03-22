<?php 
include "includes/init.php"; 
$titulo_pagina = "Contacto"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include "includes/head.php" ?>
</head>
<body>
<?php include "includes/header.php" ?>

  <?php $t = $web_model->get_text("contacto-banner","images/sub-banner-1.jpg")?>
  <div class="sub-banner editable editable-img" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" data-height="279" data-width="1583">
    <div class="overlay">
      <div class="container">
        <div class="breadcrumb-area">
          <h1 class="h1"><?php echo $titulo_pagina ?></h1>
        </div>
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
          <!-- Contact details start -->
          <div class="contact-details mb30">
            <div class="main-title-2">
              <h1><span>Contáctanos</span></h1>
            </div>
            <?php if (!empty($empresa->direccion)) {  ?>
              <div class="media">
                <div class="media-left">
                  <i class="fa fa-map-marker"></i>
                </div>
                <div class="media-body">
                  <h4>Dirección</h4>
                  <p><?php echo $empresa->direccion ?></p>
                </div>
              </div>
            <?php } ?>
            <div class="media">
              <div class="media-left">
                <i class="fa fa-phone"></i>
              </div>
              <?php if (!empty($empresa->telefono)) {  ?>
                <div class="media-body">
                  <h4>Teléfonos</h4>
                  <p>
                    <a href="tel:<?php echo $empresa->telefono ?>"><?php echo $empresa->telefono ?></a>
                  </p>
                  <?php if (!empty($empresa->telefono_2)) {  ?>
                    <p>
                      <a href="tel:<?php echo $empresa->telefono_2 ?>"><?php echo $empresa->telefono_2 ?></a>
                    </p>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
            <div class="media mrg-btm-0">
              <div class="media-left">
                <i class="fa fa-envelope"></i>
              </div>
              <div class="media-body">
                <h4>Coreo electrónico</h4>
                <p>
                  <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a>
                </p>
              </div>
            </div>
          </div>

          <?php if (!empty($empresa->facebook) || !empty($empresa->twitter) || !empty($empresa->linkedin) || !empty($empresa->google_plus) || !empty($empresa->instagram)) { ?>
            <div class="social-media sidebar-widget clearfix">
              <!-- Main Title 2 -->
              <div class="main-title-2">
                <h1>Redes <span>Sociales</span></h1>
              </div>
              <ul class="social-list clearfix">
                <?php if (!empty($empresa->facebook)) { ?>
                  <li><a class="facebook" href="<?php echo $empresa->facebook ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <?php } ?>
                <?php if (!empty($empresa->twitter)) { ?>
                  <li><a class="twitter" href="<?php echo $empresa->twitter ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <?php } ?>
                <?php if (!empty($empresa->linkedin)) { ?>
                  <li><a class="linkedin" href="<?php echo $empresa->linkedin ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                <?php } ?>
                <?php if (!empty($empresa->google_plus)) { ?>
                  <li><a class="google" href="<?php echo $empresa->google_plus ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                <?php } ?>
                <?php if (!empty($empresa->instagram)) { ?>
                  <li><a class="instagram" href="<?php echo $empresa->instagram ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                <?php } ?>
              </ul>
            </div>
          <?php } ?>
            
          <!-- Contact details end -->
        </div>
      </div>
    </div>
  </div>

<?php include "includes/footer.php" ?>
<?php include_once("templates/comun/mapa_js.php"); ?>
<?php if (!empty($empresa->posiciones) && !empty($empresa->latitud && !empty($empresa->longitud))) { ?>
  <script type="text/javascript">
   $(document).ready(function(){
    var mymap = L.map('googleMap').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
    }).addTo(mymap);


    var icono = L.icon({
     iconUrl: 'images/map-marker.png',
      iconSize:     [44, 50], // size of the icon
      iconAnchor:   [22, 50], // point of the icon which will correspond to marker's location
    });

    L.marker([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>],{
     icon: icono
   }).addTo(mymap);
  });
  </script>
<?php } ?>
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
    "url":"/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
        location.reload();
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