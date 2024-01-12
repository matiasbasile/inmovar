<footer>

  <?php if (isset($nombre_pagina) && $nombre_pagina == "home") { ?>
    <div class="footer-top padding-default">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <h5>VENTAS Y ALQUILERES</h5>
            <p><a rel="nofollow" href="tel:5492214271544"><i class="fa fa-phone mr-2" aria-hidden="true"></i> (0221) 427-1544 /45</a></p>
            <p><a rel="nofollow" href="mailto:info@grupo-urbano.com.ar"><i class="fa fa-envelope-o mr-2"></i> info@grupo-urbano.com.ar</a></p>
          </div>
          <div class="col-md-3">
            <h5>ADMINISTRACIÓN </h5>
            <p><a rel="nofollow" href="https://wa.me/5492214637615"><i class="fa fa-whatsapp mr-2" aria-hidden="true"></i> +54 (221) 463-7615</a></p>
            <p><a rel="nofollow" href="mailto:administracion@grupo-urbano.com.ar"><i class="fa fa-envelope-o mr-2"></i> administracion@grupo-urbano.com.ar</a></p>
          </div>
          <div class="col-md-3">
            <h5>CONSORCIOS</h5>
            <p><a rel="nofollow" href="https://wa.me/5492214637615"><i class="fa fa-whatsapp mr-2" aria-hidden="true"></i> +54 (221) 463-7615</a></p>
            <p><a rel="nofollow" href="https://wa.me/5492214376487"><i class="fa fa-whatsapp mr-2" aria-hidden="true"></i> +54 (221) 437-6487 (Urgencias)</a></p>
            <p><a rel="nofollow" href="mailto:consorcios@grupo-urbano.com.ar"><i class="fa fa-envelope-o mr-2"></i> consorcios@grupo-urbano.com.ar</a></p>
          </div>
          <div class="col-md-3">
            <h5>DESARROLLOS</h5>
            <p><a rel="nofollow" href="https://wa.me/5492216372369"><i class="fa fa-whatsapp mr-2" aria-hidden="true"></i> +54 (221) 637-2369</a></p>
            <p><a rel="nofollow" href="mailto:pablog@grupo-urbano.com.ar"><i class="fa fa-envelope-o mr-2"></i> pablog@grupo-urbano.com.ar</a></p>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="footer-center padding-default">
    <div class="container">
      <img src="assets/images/logo-footer.png" alt="img">
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
          <a target="_blank" href="https://www.inmovar.com/" class="mr-3"><img src="assets/images/inmover-logo.png" alt="img"></a>
          <a target="_blank" href="https://www.misticastudio.com/"><img src="assets/images/mistica-logo.png" alt="img"></a>
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
<script src="/admin/resources/js/moment.min.js"></script>

<script>
  $(document).ready(function() {
    $(".cerrar_modal").click(function() {
      $(".modal").modal("hide")
    });

    $(".tag_buscador").click(function(e) {
      var id = $(e.currentTarget).data("field");
      if (id == "styled-checkbox-1") {
        $("#styled-checkbox-1").prop("checked", false);
      } else if (id == "styled-checkbox-2") {
        $("#styled-checkbox-2").prop("checked", false);
      } else {
        $("#" + id).val(0);
      }
      $("#form_buscador").submit();
    })

  });

  function buscar_mapa(form) {
    $(form).parents("form").first().find(".base_url").val("<?php echo mklink("mapa/") ?>");
    $(form).parents("form").first().submit();
  }

  function buscar_listado(form) {
    $(form).parents("form").first().find(".base_url").val("<?php echo mklink("propiedades/") ?>");
    $(form).parents("form").first().submit();
  }

  function cambiar_checkboxes(e) {
    var form = $(e).parents("form");
    $(form).submit();
  }

  function order_solo() {
    var orden = $("#form_buscador select[name=orden]").val();
    var base = "<?php echo current_url(FALSE, TRUE) ?>";
    base += (base.substr(-1) == "/") ? "" : "/";
    base += "?orden=" + orden;
    if ($("#styled-checkbox-1").is(":checked")) base += "&banco=1";
    if ($("#styled-checkbox-2").is(":checked")) base += "&per=1";
    location.href = base;
  }

  function filtrar(form) {
    var url = $(form).find(".base_url").val();
    var tipo_operacion = $(form).find(".filter_tipo_operacion").val();
    if (!isEmpty(tipo_operacion)) {
      url += tipo_operacion + "/";
    } else {
      alert("Seleccione un tipo de operación.");
      return false;
    }
    var localidad = $(form).find(".filter_localidad").val();
    if (!isEmpty(localidad)) {
      url += localidad + "/";
    }

    var minimo = $("#filter_rango_precios option:selected").data("min");
    var maximo = $("#filter_rango_precios option:selected").data("max");
    $("#filter_minimo").val(minimo);
    $("#filter_maximo").val(maximo);

    $(form).attr("action", url);
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


<script>
  $(document).ready(function() {
    $("body").tooltip({
      selector: '[data-toggle=tooltip]'
    });
  });
</script>


<?php include("templates/comun/clienapp.php") ?>