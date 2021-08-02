<?php
include_once("includes/funciones.php");
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
$nombre_pagina = "contacto";
$header_cat = "";
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="loading">
<?php include("includes/header.php"); ?>

<div class="page-title">
  <div class="container">
    <div class="title-caption">contacto</div>
  </div>
</div>

<!--CONTACT PAGE INFO-->
<div class="contact-page-info">
  <div class="family-tradition">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="center-text">
            <h2>Ingrese su consulta</h2>
            <p>Complete el formulario de con sus datos y consulta y nos contactaremos<br>
              a la brevedad. Muchas gracias!</p>
          </div>
        </div>
        <div class="col-md-8">
          <div id="map_canvas"></div>
          <div class="block">
            <div class="contact-info">
              <div class="pull-left mr15"><img src="images/map-img2.png" alt="Map" /></div>
              <div class="right-info">
                <h5>Dirección</h5>
                <a href="javascript:void(0)"><?php echo $empresa->direccion." ".$empresa->ciudad ?></a><br/>
                <a class="rojo" href="tel:<?php echo $empresa->telefono ?>"><?php echo $empresa->telefono ?></a>
              </div>
            </div>
            <div class="contact-info">
              <div class="pull-left mr15"><img src="images/mail-img.png" alt="Email" /></div>
              <div class="right-info">
                <h5>Email</h5>
                <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a> 
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <form onsubmit="return enviar_contacto()">
            <label>Nombre <span>*</span></label>
            <input id="contacto_nombre" type="text" placeholder="Ingrese su nombre" />
            <label>Email <span>*</span></label>
            <input id="contacto_email" type="text" placeholder="Ingrese su email" />
            <label>Teléfono <span>*</span></label>
            <input id="contacto_telefono" type="tel" placeholder="Ingrese su nº de teléfono" />
            <label>Consulta <span>*</span></label>
            <textarea id="contacto_mensaje" placeholder="Ingrese su consulta"></textarea>
            <div class="block">
              <input id="contacto_submit" class="btn btn-red" type="submit" value="enviar" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php"); ?>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){

  <?php if (!empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('map_canvas').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
    }).addTo(mymap);

    var icono = L.icon({
      iconUrl: 'images/map-place.png',
      iconSize:     [48, 33], // size of the icon
      iconAnchor:   [22, 33], // point of the icon which will correspond to marker's location
    });

    <?php
    $posiciones = explode("/",$empresa->posiciones);
    for($i=0;$i<sizeof($posiciones);$i++) { 
      $pos = explode(";",$posiciones[$i]); ?>
      L.marker([<?php echo $pos[0] ?>,<?php echo $pos[1] ?>],{
        icon: icono
      }).addTo(mymap);
    <?php } ?>

  <?php } ?>
});
function enviar_contacto() {
    
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var asunto = "Contacto";
  var id_origen = 6;
  
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
    "id_empresa":ID_EMPRESA,
    "id_origen": ((id_origen != 0) ? id_origen : ((id_propiedad != 0)?1:6)),
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