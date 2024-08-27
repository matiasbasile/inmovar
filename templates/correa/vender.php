<?php include "includes/init.php"  ?>
<?php $entrada = $entrada_model->get(44790) ?>
<?php $page_act = "vender" ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "includes/head.php"  ?>
</head>
<body>


<?php include "includes/header.php"  ?>

<!-- Page Title -->
<section class="page-title">
  <div class="container">
    <h1><?php echo $entrada->titulo ?></h1>
  </div>
</section>

<!-- Who We Are -->
<section class="who-we-are">
  <div class="container">
    <div class="inner-wrap">
      <img src="<?php echo $entrada->path ?>">
      <div class="section-title">
        <h2><?php echo $entrada->titulo ?></h2>
        <p><?php echo $entrada->texto ?></p>
      </div>
      <div class="form-wrap">
        <div class="section-title">
          <h2>envía una consulta</h2>
        </div>
        <form onsubmit="return enviar_contacto()">
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
                  <select id="contacto_encontro" name="encontro" class="form-control">
                    <option value="No respondió.">¿Cómo nos encontró?</option>
                    <option value="Ya soy cliente">Ya soy cliente</option>
                    <option value="Por un amigo o conocido">Por un amigo o conocido</option>
                    <option value="Por una red social">Por una red social</option>
                    <option value="Por portales inmobiliarios (mercadolibre, zonaprop, etc.)">Por portales inmobiliarios (mercadolibre, zonaprop, etc.)</option>
                    <option value="Por una búsqueda en internet ">Por una búsqueda en internet  </option>
                    <option value="Por un cartel en la calle">Por un cartel en la calle</option>
                    <option value="Por publicación en el diario">Por publicación en el diario</option>
                    <option value="Otros">Otros</option>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <textarea class="form-control" id="contacto_mensaje" placeholder="Escriba aquí su mensaje"></textarea>
                </div>
              </div>
              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-secoundry" id="contacto_submit">Enviar ahora</button>
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
<script src="assets/js/respond.min.js"></script>
<script src="assets/js/placeholders.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWmUapFYTBXV3IJL9ggjT9Z1wppCER55g&callback=initMap"></script>
<script src="assets/js/scripts.js"></script>
<?php if (isset($empresa->latitud) && isset($empresa->longitud) && $empresa->latitud != 0 && $empresa->longitud != 0) { ?>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
  mostrar_mapa(); 
});
function mostrar_mapa() {

  <?php if (!empty($empresa->latitud && !empty($empresa->longitud))) { ?>
    var mymap = L.map('map1').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], <?php echo $empresa->zoom ?>);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
    }).addTo(mymap);

    L.marker([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>]).addTo(mymap);

  <?php } ?>
}
</script>
<?php } ?>
<script type="text/javascript">
  function enviar_contacto() {

    var nombre = $("#contacto_nombre").val();
    var email = $("#contacto_email").val();
    var mensaje = $("#contacto_mensaje").val();
    var asunto = $("#contacto_asunto").val();
    var telefono = $("#contacto_telefono").val();
    var encontro = $("#contacto_encontro").val();

    if (isEmpty(nombre) || nombre == "Nombre") {
      alert("Por favor ingrese un nombre");
      $("#contacto_nombre").focus();
      return false;          
    }

    if (isEmpty(telefono) || telefono == "telefono") {
      alert("Por favor ingrese un telefono");
      $("#contacto_telefono").focus();
      return false;          
    }

    if (!validateEmail(email)) {
      alert("Por favor ingrese un email valido");
      $("#contacto_email").focus();
      return false;          
    }
    if (isEmpty(mensaje) || mensaje == "Mensaje") {
      alert("Por favor ingrese un mensaje");
      $("#contacto_mensaje").focus();
      return false;              
    }    
    var mensaje = "Nos encontró: "+ encontro + ". "+ mensaje;

    $("#contacto_submit").attr('disabled', 'disabled');
    var datos = {
      "para":"<?php echo $empresa->email ?>",
      "nombre":nombre,
      "telefono":telefono,
      "email":email,
      "mensaje":mensaje,
      "asunto":asunto,
      "id_empresa":ID_EMPRESA,
    }
    $.ajax({
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
          $("#contacto_submit").removeAttr('disabled');
        }
      }
    });
    return false;
  }
</script>
</body>
</html>