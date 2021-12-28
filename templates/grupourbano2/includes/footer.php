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
      <?php if (!empty($empresa->direccion_web)) { ?>
        <p class="mt-4"><?php echo $empresa->direccion_web ?></p>
      <?php } ?>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWmUapFYTBXV3IJL9ggjT9Z1wppCER55g&callback=initMap"></script>
<script src="assets/js/scripts.js"></script>
<script src="assets/js/flexslider.js"></script>
<script src="assets/js/fancybox.js"></script>

<script>
  function filtrar(form) {
    var submit_form = false;
    if (form == undefined) {
      submit_form = true;
      form = $(".filter_form").first();
    }
    var url = "<?php echo mklink("propiedades") ?>";

    url += "/?";
    var tipo_operacion = $(form).find(".filter_tipo_operacion").val();
    if (!isEmpty(tipo_operacion)) {
      url += "tipo_operacion="+ tipo_operacion;
    }

    var localidad = $(form).find(".filter_localidad").val();
    if (!isEmpty(localidad)) {
      url +="&id_localidad="+localidad + "&";
    }

    var tipo_propiedad = $(form).find(".filter_propiedad").val();
    if(!isEmpty(tipo_propiedad)) {
      url +="tipo_propiedad=" + tipo_propiedad + "&" ;
    }

    var filter_dormitorios = $(form).find(".filter_dormitorios").val();
    if(!isEmpty(filter_dormitorios)) {
      url +="dormitorios=" + filter_dormitorios + "&" ;
    }

    var filter_banios = $(form).find(".filter_banios").val();
    if(!isEmpty(filter_banios)){
      url += "banios=" + filter_banios + "&";
    }

    var filter_minimo = $(form).find(".filter_minimo").val();
    if(!isEmpty(filter_minimo)){
      url += "minimo="+ filter_minimo + "&";
    }
    var filter_maximo = $(form).find(".filter_maximo").val();
    if(!isEmpty(filter_maximo)){
      url += "maximo="+ filter_maximo + "&";
    }
    if ($("#styled-checkbox-1").is(":checked")) {
      url += "apto_credito=" + 1 + "&";
    }
    if ($("#styled-checkbox-2").is(":checked")) {
      url += "acepta_permuta=" + 1 + "&";
    }

    url += "buscador=1";

    /* if ($("#precio_minimo").length > 0) {
      var minimo = $("#precio_minimo").val().replace(".", "");
      $("#precio_minimo_oculto").val(minimo);
      var maximo = $("#precio_maximo").val().replace(".", "");
      $("#precio_maximo_oculto").val(maximo);
    } */
    console.log(url);
    setTimeout(function () {
      location.href=url;
    }, 300);
  }
</script>