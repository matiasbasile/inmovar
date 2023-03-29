<?php include "includes/init.php" ?>
<?php $page_act = "contacto"  ?>
<!DOCTYPE html>
<html>
<head>
  <?php include "includes/head.php" ?>
</head>
<body>
  <?php include "includes/header.php" ?>
  
  <?php include "templates/comun/gracias.php" ?>

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

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>', {
        attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
        tileSize: 512,
        maxZoom: 18,
        zoomOffset: -1,
        id: 'mapbox/streets-v11',
        accessToken: '<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>',
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