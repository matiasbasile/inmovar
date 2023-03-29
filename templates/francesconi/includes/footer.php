<footer class="francesconi-footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="footer-content">
          <h5>alquileres</h5>
          <p>¿Estas alquilando o queres alquilar? Comunicate para que te ayudemos</p>
          <?php if(!empty($empresa->whatsapp)) { ?>
           <a href="https://wa.me/<?php echo convertString($empresa->whatsapp) ?>" class="border-btn" target="_blank" ><img src="assets/images/icons/icon-7.png" alt="Icon"><?php echo $empresa->whatsapp ?></a>
          <?php } ?>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="footer-content">
          <h5>ventas</h5>
          <p>¿Estas alquilando o queres alquilar? Comunicate para que te ayudemos</p>
          <?php if(!empty($empresa->telefono_web)) { ?>
           <a href="https://wa.me/<?php echo convertString($empresa->telefono_web) ?>" class="border-btn" target="_blank"><img src="assets/images/icons/icon-7.png" alt="Icon"><?php echo $empresa->telefono_web ?></a>
          <?php } ?>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="footer-content">
          <h5>administración</h5>
          <p>¿Estas alquilando o queres alquilar? Comunicate para que te ayudemos</p>
          <?php if(!empty($empresa->telefono_2)) { ?>
           <a href="https://wa.me/<?php echo convertString($empresa->telefono_2) ?>" class="border-btn" target="_blank"><img src="assets/images/icons/icon-7.png" alt="Icon"><?php echo $empresa->telefono_2 ?></a>
          <?php } ?>
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
            <h5>horarios</h5>
            <?php if (!empty($empresa->horario)) { ?>
              <p><?php echo $empresa->horario ?></p>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="assets/js/swiper-bundle.min.js"></script>
<script src="assets/js/script.js?v=1"></script>
<script src="/admin/resources/js/moment.min.js"></script>
<?php include_once("templates/comun/mapa_js.php"); ?>

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
  //MAP SCRIPT
  $(document).ready(function() {

    if ($("#map1").length > 0) {
      var mymap = L.map('map1').setView([<?php echo $empresa->latitud ?>, <?php echo $empresa->longitud ?>], <?php echo $empresa->zoom ?>);

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>', {
        attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
        tileSize: 512,
        maxZoom: 18,
        zoomOffset: -1,
        id: 'mapbox/streets-v11',
        accessToken: '<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>',
      }).addTo(mymap);


      var icono = L.icon({
        iconUrl: 'assets/images/pin-map.png',
        iconSize: [25, 25], // size of the icon
        iconAnchor: [30, 30], // point of the icon which will correspond to marker's location
      });

      L.marker([<?php echo $empresa->latitud ?>, <?php echo $empresa->longitud ?>], {
        icon: icono
      }).addTo(mymap);
    }

  });
</script>

<script>
  function buscar_mapa() {
    $("#form_buscador").find(".base_url").val("<?php echo mklink("mapa/") ?>");
    $("#form_buscador").submit();
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

  function enviar_filtrar() {
    $("#form_buscador").submit();
  }

  function filtrar() {
    var form = $("#form_buscador");
    var url = $(form).find(".base_url").val();
    var tipo_operacion = $(form).find(".filter_tipo_operacion").val();
    url += tipo_operacion + "/";
    var localidad = $(form).find(".filter_localidad").val();
    if (!isEmpty(localidad)) {
      url += localidad + "/";
    }
    var minimo = $("#filter_rango_precios option:selected").data("min");
    var maximo = $("#filter_rango_precios option:selected").data("max");
    $("#filter_minimo").val(minimo);
    $("#filter_maximo").val(maximo);
    $(form).attr("action", url);
    return true;
  }
</script>

<!-- <script>
  var maximo = 0;
  $(".noved_img").each(function(i, e) {
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".noved_img").height(maximo);
</script> -->

<script>
  let img = document.querySelectorAll(".noved_img");
  for (let i = 0; i < img.length; i++) {
    if(img[i].height > 302){
      img[i].style.objectFit = "cover";
      img[i].style.height = 301;
      img[i].style.width = "100%";
    }
  }
</script>


<?php include("templates/comun/clienapp.php") ?>