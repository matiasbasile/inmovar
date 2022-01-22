<?php  ?>
<footer>
  <div class="footer-top padding-default">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h5>VENTAS Y ALQUILERES</h5>
          <p><a href="#0"><i class="fa fa-phone mr-2" aria-hidden="true"></i> (0221) 427-1544 /45</a></p>
          <p><a href="#0"><i class="fa fa-envelope-o mr-2"></i> info@grupo-urbano.com.ar</a></p>
        </div>
        <div class="col-md-3">
          <h5>ADMINISTRACIÓN </h5>
          <p><i class="fa fa-whatsapp mr-2" aria-hidden="true"></i> +54 (221) 463-7615</p>
          <p><i class="fa fa-envelope-o mr-2"></i> administracion@grupo-urbano.com.ar</p>
        </div>
        <div class="col-md-3">
          <h5>CONSORCIOS</h5>
          <p><i class="fa fa-whatsapp mr-2" aria-hidden="true"></i> +54 (221) 463-7615</p>
          <p><i class="fa fa-whatsapp mr-2" aria-hidden="true"></i> +54 (221) 437-6487 (Urgencias)</p>
          <p><i class="fa fa-envelope-o mr-2"></i> consorcios@grupo-urbano.com.ar</p>
        </div>
        <div class="col-md-3">
          <h5>DESARROLLOS</h5>
          <p><i class="fa fa-whatsapp mr-2" aria-hidden="true"></i> +54 (221) 637-2369</p>
          <p><i class="fa fa-envelope-o mr-2"></i> pablog@grupo-urbano.com.ar</p>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-center padding-default">
    <div class="container">
      <?php if (!empty($empresa->logo)) { ?>
        <img src="<?php echo $empresa->logo ?>" alt="img">
      <?php } else { ?>
        <img src="assets/images/logo-white.png" alt="img">
      <?php } ?>
      <p class="mt-4">Bertoia Col. 7342 <span>|</span> Piñero Col. 7346</p>      
      <div class="social">
        <?php if (!empty($empresa->facebook)) { ?>
          <a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        <?php } ?>
        <?php if (!empty($empresa->youtube)) { ?>
          <a target="_blank" href="<?php echo $empresa->youtube ?>"><i class="fa fa-play" aria-hidden="true"></i></a>
        <?php } ?>
        <?php if (!empty($empresa->instagram)) { ?>
          <a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-3">
          <img src="assets/images/cdu-logo.png" alt="img">
        </div>
        <div class="col-md-6">
          <p><b>&copy; <?php echo $empresa->razon_social ?></b> - Todos Los Derechos Reservados</p>
        </div>
        <div class="col-md-3 text-right">
          <a href="https://www.inmovar.com/" class="mr-3"><img src="assets/images/inmover-logo.png" alt="img"></a>
          <a href="https://www.misticastudio.com/"><img src="assets/images/mistica-logo.png" alt="img"></a>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.flexslider.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/html5.min.js"></script>
<script src="assets/js/respond.min.js"></script>
<script src="assets/js/placeholders.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWmUapFYTBXV3IJL9ggjT9Z1wppCER55g&callback=initMap"></script>-->
<script src="assets/js/scripts.js?v=1"></script>
<script src="assets/js/flexslider.js"></script>
<script src="assets/js/fancybox.js"></script>

<script>
function filtrar(form) {
  var url = "<?php echo mklink("propiedades/") ?>";
  var tipo_operacion = $(form).find(".filter_tipo_operacion").val();
  if (!isEmpty(tipo_operacion)) {
    url+=tipo_operacion+"/";
  }
  var localidad = $(form).find(".filter_localidad").val();
  if (!isEmpty(localidad)) {
    url+=localidad+"/";
  }
  $(form).attr("action",url);
}

function enviar_newsletter() {
  var email = $("#newsletter_email").val();
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido.");
    $("#newsletter_email").focus();
    return false;
  }

  $("#newsletter_submit").attr('disabled', 'disabled');
  var datos = {
    "email": email,
    "mensaje": "Registro a Newsletter",
    "asunto": "Registro a Newsletter",
    "para": "<?php echo $empresa->email ?>",
    "id_empresa": ID_EMPRESA,
    "id_origen": 2,
  }
  $.ajax({
    "url": "https://app.inmovar.com/admin/consultas/function/enviar/",
    "type": "post",
    "dataType": "json",
    "data": datos,
    "success": function(r) {
      if (r.error == 0) {
        alert("Muchas gracias por registrarse a nuestro newsletter!");
        location.reload();
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#newsletter_submit").removeAttr('disabled');
      }
    }
  });
  return false;
}
</script>