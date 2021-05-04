<?php
include_once("includes/init.php");
$page_act = "contacto";
?>  
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>

  <!-- Header -->
  <?php include "includes/header.php" ?>
  <section class="page-title">
    <div class="container">
      <h1>           Contacto      </h1>
    </div>
  </section>


  <section class="featured-properties pt-5">
    <div class="container">
      <div class="section-title">
        <div id="mapid" style="height: 350px; margin: 60px 0"></div>
        <div class="text-center">
          <h2>
            Contacto
          </h2>
          <p>Completa el siguiente formulario y nos comunicaremos a la brevedad.</p>
          <form onsubmit="return enviar_contacto()" class="my-form-contact">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" name="Nombre *" class="form-control" id="contacto_nombre" placeholder="Nombre *">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="email" name="Email  *" class="form-control" id="contacto_email" placeholder="Email  *">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" name="Whatsapp (Cod. área sin 0 ni 15)" class="form-control" id="contacto_telefono" placeholder="Whatsapp (Cod. área sin 0 ni 15)">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <select id="contacto_asunto" name="asunto" class="form-control">
                    <option value="Contacto desde web">Asunto</option>
                    <?php $asuntos = explode(";;;",$empresa->asuntos_contacto);
                    foreach($asuntos as $a) { ?>
                      <option><?php echo $a ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <textarea class="form-control" id="contacto_mensaje" placeholder="Escriba aquí su mensaje"></textarea>
                </div>
              </div>
              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-red" id="contacto_submit">Enviar ahora</button>
              </div>
            </div>
          </form>
        </div>
        
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include "includes/footer.php" ?>


  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/html5.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  <script src="assets/js/scripts.js"></script>
  <script type="text/javascript">
    function enviar_contacto() {
      var nombre = jQuery("#contacto_nombre").val();
      var email = jQuery("#contacto_email").val();
      var mensaje = jQuery("#contacto_mensaje").val();
      var telefono = jQuery("#contacto_telefono").val();

      if (isEmpty(nombre) || nombre == "Nombre") {
        alert("Por favor ingrese un nombre");
        jQuery("#contacto_nombre").focus();
        return false;          
      }


      if (isEmpty(telefono) || telefono == "telefono") {
        alert("Por favor ingrese un telefono");
        jQuery("#contacto_telefono").focus();
        return false;          
      }

      if (!validateEmail(email)) {
        alert("Por favor ingrese un email valido");
        jQuery("#contacto_email").focus();
        return false;          
      }
      if (isEmpty(mensaje) || mensaje == "Mensaje") {
        alert("Por favor ingrese un mensaje");
        jQuery("#contacto_mensaje").focus();
        return false;              
      }    

      jQuery("#contacto_submit").attr('disabled', 'disabled');
      var datos = {
        "para":"<?php echo $empresa->email ?>",
        "nombre":nombre,
        "telefono":telefono,
        "email":email,
        "asunto":"Contacto desde web",
        "mensaje":mensaje,
        "id_empresa":ID_EMPRESA,
      }
      jQuery.ajax({
        "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
        "type":"post",
        "dataType":"json",
        "data":datos,
        "success":function(r){
          if (r.error == 0) {
            alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
            location.reload();
          } else {
            alert("Ocurrio un error al enviar su email. Disculpe las molestias");
            jQuery("#contacto_submit").removeAttr('disabled');
          }
        }
      });
      return false;
    }
  </script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
     $(document).ready(function(){

      var mymap = L.map('mapid').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
        tileSize: 512,
        maxZoom: 18,
        zoomOffset: -1,
        id: 'mapbox/streets-v11',
        accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
      }).addTo(mymap);


      var icono = L.icon({
       iconUrl: 'assets/images/map-logo.png',
        iconSize:     [34, 49], // size of the icon
        iconAnchor:   [17, 49], // point of the icon which will correspond to marker's location
      });

      L.marker([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>],{
       icon: icono
     }).addTo(mymap);
    });
  </script>
</body>
</html>