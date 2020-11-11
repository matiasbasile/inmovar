<div class="ts-box">
  <form id="form-contact" method="post" class="clearfix ts-form ts-form-email" onsubmit="return enviar_contacto()">
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="form-group">
          <label for="form-contact-name">Nombre</label>
          <input type="text" class="form-control" id="contacto_nombre" name="name" placeholder="Tu nombre">
        </div>
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="form-group">
          <label for="form-contact-email">Telefono</label>
          <input type="text" class="form-control" id="contacto_telefono" name="tel" placeholder="Tu telefono">
        </div>
      </div>
      <div class="col-md-12 col-sm-12">
        <div class="form-group">
          <label for="form-contact-email">Email</label>
          <input type="email" class="form-control" id="contacto_email" name="email" placeholder="Tu email">
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="form-contact-message">Mensaje</label>
      <textarea class="form-control" id="contacto_mensaje" rows="5" name="message" placeholder="Tu mensaje"></textarea>
    </div>
    <div class="form-group clearfix">
      <button type="submit" class="btn btn-primary float-right" id="form-contact-submit">
        Enviar formulario
      </button>
    </div>
    <div class="form-contact-status"></div>
  </form>
</div>
<script type="text/javascript">
function enviar_contacto() {
    
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  
  if (isEmpty(nombre)) {
    alert("Por favor ingrese su nombre");
    $("#contacto_nombre").focus();
    return false;          
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_email").focus();
    return false;          
  }
  if (isEmpty(telefono)) {
    alert("Por favor ingrese su telefono");
    $("#contacto_telefono").focus();
    return false;          
  }
  if (isEmpty(mensaje)) {
    alert("Por favor ingrese su mensaje");
    $("#contacto_mensaje").focus();
    return false;              
  }    
  var datos = {
    "para":"<?php echo (isset($para)) ? $para : $empresa->email ?>",
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "asunto":"<?php echo (isset($contacto_asunto) ? $contacto_asunto : "Contacto desde web") ?>",
    "id_propiedad":"<?php echo (isset($contacto_id_propiedad) ? $contacto_id_propiedad : 0) ?>",
    "id_empresa":ID_EMPRESA,
    "bcc":"<?php echo $empresa->bcc_email ?>",
  }
  $.ajax({
    "url":"/sistema/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
        location.reload();
      } else {
        alert("Ocurrio un error al enviar su mensaje. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
      }
    }
  });
  return false;
}  
</script>