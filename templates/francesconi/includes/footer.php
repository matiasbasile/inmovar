<footer class="francesconi-footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="footer-content">
          <h5>alquileres</h5>
          <p>¿Estas alquilando o queres alquilar? Comunicate para que te ayudemos</p>
          <a href="#0" class="border-btn"><img src="assets/images/icons/icon-7.png" alt="Icon">+54 (221) 546-0441</a>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="footer-content">
          <h5>ventas</h5>
          <p>¿Estas alquilando o queres alquilar? Comunicate para que te ayudemos</p>
          <a href="#0" class="border-btn"><img src="assets/images/icons/icon-7.png" alt="Icon">+54 (221) 546-0441</a>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="footer-content">
          <h5>administración</h5>
          <p>¿Estas alquilando o queres alquilar? Comunicate para que te ayudemos</p>
          <a href="#0" class="border-btn"><img src="assets/images/icons/icon-7.png" alt="Icon">+54 (221) 546-0441</a>
        </div>
      </div>
    </div>
    <div class="footer-inner">
      <div class="row">
        <div class="col-lg-3">
          <a href="<?php echo mklink("/") ?>" class="header-logo"><img src="assets/images/header-logo.png" alt="Logo"></a>
        </div>
        <div class="col-lg-3">
          <div class="footer-link">
            <h5>dirección</h5>
            <?php if (!empty($empresa->ciudad) && (!empty($empresa->direccion))) { ?>
              <p><?php echo $empresa->direccion ?> - <?php echo $empresa->ciudad ?></p>
            <?php } ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="footer-link">
            <h5>dirección</h5>
            <?php if (!empty($empresa->ciudad) && (!empty($empresa->direccion))) { ?>
              <p><?php echo $empresa->direccion ?> - <?php echo $empresa->ciudad ?></p>
            <?php } ?>
          </div>
        </div>
        <div class="col-lg-3">
          <ul>
            <?php if (!empty($empresa->facebook)) { ?>
              <li><a href="<?php echo $empresa->facebook ?>" target="_blank"><img src="assets/images/icons/facebook.png" alt="Facebook"></a></li>
            <?php } ?>
            <?php if (!empty($empresa->instagram)) { ?>
              <li><a href="<?php echo $empresa->instagram ?>" target="_blank"><img src="assets/images/icons/insta.png" alt="Instagram"></a></li>
            <?php } ?>
            <?php if (!empty($empresa->youtube)) { ?>
              <li><a href="<?php echo $empresa->youtube ?>" target="_blank"><img src="assets/images/icons/play.png" alt="Play"></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright">
    <div class="container">
      <div class="copyright-inner">
        <p>© <?php echo date('Y') ?> Inmobiliaria Francesconi. <span>Todos Los Derechos Reservados</span></p>
      </div>
      <div class="copyright-socials">
        <a href="https://www.inmovar.com/" target="_blank"><img src="assets/images/copyright-1.png" alt="Copyright"></a>
        <a href="https://misticastudio.com/" target="_blank"><img src="assets/images/copyright-2.png" alt="Copyright"></a>
      </div>
    </div>
  </div>
</footer>
<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/swiper-bundle.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="/admin/resources/js/moment.min.js"></script>

<script>
  function enviar_contacto() {
    var nombre = $("#contacto_nombre").val();
    var email = $("#contacto_email").val();
    var telefono = $("#contacto_telefono").val();
    var asunto = $("#contacto_asunto option:selected").val();
    var mensaje = $("#contacto_mensaje").val();
    // var tipo_propiedad = $("#contacto_tipo_propiedad option:selected").text();
    // var dormitorios = $("#contacto_dormitorios").val();
    // var banios = $("#contacto_banios").val();
    // var localidad = $("#contacto_localidad").val();

    if (isEmpty(nombre)) {
      alert("Por favor ingrese un nombre");
      $("#contacto_nombre").focus();
      return false;
    }
    if (!validateEmail(email)) {
      alert("Por favor ingrese un email valido");
      $("#contacto_email").focus();
      return false;
    }
    if (isEmpty(telefono)) {
      alert("Por favor ingrese un telefono");
      $("#contacto_telefono").focus();
      return false;
    }
    if (isEmpty(asunto)) {
      alert("Por favor seleccione una opción");
      $("#contacto_asunto").focus();
      return false;
    }
    if (isEmpty(mensaje)) {
      alert("Por favor ingrese un mensaje");
      $("#contacto_mensaje").focus();
      return false;
    }
    $("#contacto_submit").attr('disabled', 'disabled');
    var datos = {
      "para": "<?php echo $empresa->email ?>",
      "nombre": nombre,
      "email": email,
      "telefono": telefono,
      "asunto": asunto,
      "mensaje": mensaje,
      "id_empresa": ID_EMPRESA,
      "id_origen": 1,
    }
    enviando = 1;
    $.ajax({
      "url": "https://app.inmovar.com/admin/consultas/function/enviar/",
      "type": "post",
      "dataType": "json",
      "data": datos,
      "success": function(r) {
        if (r.error == 0) {
          alert("Muchas gracias por enviar tu consulta. Nos comunicaremos a la mayor brevedad posible.");
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");
          $("#contacto_submit").removeAttr('disabled');
        }
      }
    });
    return false;
  }
</script>

<script>
  function order_solo() {
    var orden = $("#form_buscador select[name=orden]").val();
    var base = "<?php echo current_url(FALSE, TRUE) ?>";
    base += (base.substr(-1) == "/") ? "" : "/";
    base += "?orden=" + orden;
    if ($("#styled-checkbox-1").is(":checked")) base += "&banco=1";
    if ($("#styled-checkbox-2").is(":checked")) base += "&per=1";
    location.href = base;
  }

  function cambiar_checkboxes(e) {
    var form = $(e).parents("form");
    $(form).submit();
  }
</script>

<?php include("templates/comun/clienapp.php") ?>