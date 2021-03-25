<?php include "includes/init.php" ?>
<?php $page_act = "contacto"  ?>
<!DOCTYPE html>
<html>
<head>
  <?php include "includes/head.php" ?>
</head>
<body>
  <?php include "includes/header.php" ?>
  <section>
    <div id="MapId" style="height: 440px;"></div>
  </section>
  <section class="sec-pad">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-xs-12">
          <div class="col-md-12 text-left sec-title contact-title">
            <?php $t = $web_model->get_text("sec-title-contacto","Contacto")?>
            <h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
              <?php echo $t->plain_text?>
            </h2>
            <?php $t = $web_model->get_text("sec-text-contacto","Dejanos tu mensaje y te responderemos a la brevedad")?>
            <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
              <?php echo $t->plain_text?>
            </p>
            <div>
              <form class="contacto" onsubmit="return enviar_contacto()">
                <div class="form-group">
                  <label>Nombre*</label>
                  <input type="" name="" id="contacto_nombre">
                </div>
                <div class="form-group">
                  <label>Email*</label>
                  <input type="" name="" id="contacto_email">
                </div>
                <div class="form-group">
                  <label>Teléfono*</label>
                  <input type="" name="" id="contacto_telefono">
                </div>
                <div class="form-group">
                  <label>Mensaje*</label>
                  <textarea id="contacto_mensaje" rows="5"></textarea>
                </div>
                <div>
                  <button type="submit" id="contacto_submit" class="btn-yellow w200">ENVIAR</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xs-12 contact-right">
          <div class="col-md-12 text-left sec-title contact-title">
            <?php $t = $web_model->get_text("sec-title-contacto2","Sobre Nosotros")?>
            <h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
              <?php echo $t->plain_text?>
            </h2>
            <?php $t = $web_model->get_text("sec-text-contacto2","Hendrerit in vulputate velit esse molestie consequat.")?>
            <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
              <?php echo $t->plain_text?>
            </p>
            <div>
            <?php $t = $web_model->get_text("sec-text-more-contacto2","Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent.<br><br>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.")?>
              <p class="editable mt40" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text?></p>
              <div class="border-div"></div>
              <div class="contact-title">
                <ul>
                  <li><a><i class="fa fa-map-marker"></i> <?php echo $empresa->direccion." ".$empresa->ciudad  ?></a></li>
                  <li><a href="teL:<?php echo $empresa->telefono_num ?>"><i class="fa fa-phone"></i> <?php echo $empresa->telefono ?></a></li>
                  <li><a href="mailto:<?php echo $empresa->email ?>"><i class="fa fa-envelope"></i> <?php echo $empresa->email ?></a></li>
                </ul>
                <p>Seguinos en las redes</p>
                <div>
                  <ul class="iconos-en-contacto">
                    <?php if (!empty($empresa->facebook)) {  ?>
                      <li><a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fab fa-facebook"></i></a></li>
                    <?php } ?>
                    <?php if (!empty($empresa->twitter)) {  ?>
                      <li><a target="_blank" href="<?php echo $empresa->twitter ?>"><i class="fab fa-twitter"></i></a></li>
                    <?php } ?>
                    <?php if (!empty($empresa->instagram)) {  ?>
                      <li><a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fab fa-instagram"></i></a></li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include "includes/footer.php" ?>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/owl.carousel.min.js"></script>
  <script type="text/javascript">
// ===== Scroll to Top ==== 
$(window).scroll(function() {
if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
$('#return-to-top').fadeIn(200);    // Fade in the arrow
} else {
$('#return-to-top').fadeOut(200);   // Else fade out the arrow
}
});
$('#return-to-top').click(function() {      // When arrow is clicked
  $('body,html').animate({
scrollTop : 0                       // Scroll to top of body
}, 500);
});
</script>

<script type="text/javascript">
  /* Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu / bar icon */
  function myFunction() {
    var x = document.getElementById("myLinks");
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }

</script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
  $(document).ready(function(){
    <?php if (!empty($empresa->posiciones) && !empty($empresa->latitud && !empty($empresa->longitud))) { ?>

      var mymap = L.map('MapId').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
        tileSize: 512,
        maxZoom: 18,
        zoomOffset: -1,
        id: 'mapbox/streets-v11',
        accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
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
    "asunto":"Contacto desde Web",
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