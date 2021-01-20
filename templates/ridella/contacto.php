<?php include "includes/init.php" ?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>
<?php include "includes/header.php" ?>
<!-- Page Title -->
<div class="page-title">
  <div class="container">
    <div class="pull-left">
      <h2>contacto</h2>
    </div>
    <div class="breadcrumb">
      <ul>
        <li><a href="<?php echo mklink ("/") ?>">Inicio</a><span>|</span></li>
        <li>contacto</li>
      </ul>
    </div>
  </div>
</div>

<!-- Map -->

<div id="map">
  <div id="googleMap" style="margin-bottom: 50px; width:100%;height:350px;filter: grayscale(100%);-webkit-filter: grayscale(100%);"></div>
</div>

<!-- About Us -->
<div class="communicate-section">
  <div class="container">
  <div class="border-title">contacto</div>
  <center class="mb30">
  <?php $t = $web_model->get_text("textoContacto","Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make.")?>
  <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
    <?php echo $t->plain_text ?>
  </p>
  </center>
  <form class="contact-form" onsubmit="return enviar_contacto()">
    <div class="row">
      <div class="col-md-6">
        <input class="form-control" id="contacto_nombre" type="text" name="Nombre" placeholder="Nombre">
      </div>
      <div class="col-md-6">
        <input class="form-control" id="contacto_telefono" type="tel" name="Teléfono" placeholder="Teléfono">
      </div>
      <div class="col-md-6">
        <input class="form-control" id="contacto_email" type="email" name="Email" placeholder="Email">
      </div>
      <div class="col-md-6">
        <select id="contacto_asunto">
          <option value="Asunto sin especificar">Asunto</option>
          <option value="Ventas">Ventas</option>
          <option value="Alquileres">Alquileres</option>
          <option value="Tasaciones">Tasaciones</option>
        </select>
      </div>
      <div class="col-md-12">
        <textarea class="form-control" id="contacto_mensaje" placeholder="Mensaje"></textarea>
      </div>
      <div class="col-md-12">
        <input class="btn btn-red" id="contacto_submit" type="submit" value="enviar mensaje">
      </div>
    </div>
  </form>
</div>
</div>
<!-- Footer -->
<?php include "includes/footer.php" ?>
<script type="text/javascript"> function enviar_contacto() {
    
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var asunto = $("#contacto_asunto").val();
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
    "id_empresa":ID_EMPRESA,
    "id_origen": ((id_origen != 0) ? id_origen : "Contacto"),
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

<?php if (!empty($empresa->latitud) && !empty($empresa->longitud)) { ?>
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

</body>
</html> 