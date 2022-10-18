<form onsubmit="return enviar_contacto()">
  <input type="hidden" id="contacto_id_propiedad" value="<?php echo (isset($propiedad->id) ? $propiedad->id : 0) ?>">
  <?php
  $titulo = "Contacto por propiedad";
  if (isset($propiedad->nombre)) {
    $titulo = $propiedad->nombre;
    $titulo = str_replace("'", "", $titulo);
    $titulo = str_replace('"', "", $titulo);
    $titulo = "Consulta por propiedad: " . $titulo . " (Codigo: " . $propiedad->codigo . ")";
  } ?>
  <input type="hidden" id="contacto_asunto" value="<?php echo (isset($asunto) ? $asunto : $titulo) ?>">
  <div class="form-block">
    <label>Nombre Completo *</label>
    <input type="text" id="contacto_nombre" placeholder="Nombre Completo" name="name">
  </div>
  <div class="form-block">
    <label>Email *</label>
    <input type="text" id="contacto_email" placeholder="Correo electrónico" name="email">
  </div>
  <div class="form-block">
    <label>Whatsapp *</label>
    <div class="chat_user_form_row">
      <div class="chat_user_form_row_4">
        <?php include 'prefijo_localidades.php' ?>
      </div>
      <div class="chat_user_form_row_6">
        <input type="text" id="contacto_telefono" value="<?php echo isset($_SESSION["telefono"]) ? $_SESSION["telefono"] : "" ?>"" class=" chat_user_form_input chat_user_form_2_celular" placeholder="Teléfono">
      </div>
    </div>
    <!-- <input type="text" id="contacto_telefono" placeholder="Número sin 0 ni 15" name="email"> -->
  </div>
  <div class="form-block">
    <label>Mensaje *</label>
    <textarea id="contacto_mensaje" placeholder="Tu mensaje..." name="message"></textarea>
  </div>
  <div class="form-block">
    <input id="contacto_submit" type="submit" value="Enviar">
  </div>
</form>
<script type="text/javascript">
  function enviar_contacto() {

    var nombre = $("#contacto_nombre").val();
    var email = $("#contacto_email").val();
    var telefono = $("#contacto_telefono").val();
    var fax = $("#contacto_fax").val()
    var mensaje = $("#contacto_mensaje").val();
    var id_propiedad = $("#contacto_id_propiedad").val();
    var asunto = $("#contacto_asunto").val();

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
    if (!isTelephone(telefono)) {
      alert("Por favor controle el numero de telefono. Debe ingresarlo completo con la caracteristica sin 0 ni 15.");
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
      "para": "<?php echo $empresa->email ?>",
      "nombre": nombre,
      "email": email,
      "mensaje": mensaje,
      "telefono": telefono,
      "asunto": asunto,
      "id_propiedad": id_propiedad,
      "id_empresa": ID_EMPRESA,
      "id_empresa_relacion": "<?php echo (isset($id_empresa)) ? $id_empresa : $empresa->id ?>",
      "id_origen": <?php echo (isset($id_origen) ? $id_origen : 6); ?>,
      "bcc": "basile.matias99@gmail.com",
    }
    $.ajax({
      "url": "https://app.inmovar.com/admin/consultas/function/enviar/",
      "type": "post",
      "dataType": "json",
      "data": datos,
      "success": function(r) {
        if (r.error == 0) {
          window.location.href = '<?php echo mklink("web/gracias/") ?>';
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");
          $("#contacto_submit").removeAttr('disabled');
        }
      }
    });
    return false;
  }
</script>