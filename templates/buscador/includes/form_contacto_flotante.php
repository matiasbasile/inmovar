<form id="form_flotante" onsubmit="return enviar_contacto_flotante()" class="form-search">
  <input type="hidden" name="id_propiedad" id="contacto_flotante_propiedad" value="<?php echo (isset($propiedad) ? $propiedad->id : 0) ?>"/>
  <header>
    <h3>
      <span class="titulo"></span>
      <i onclick="cerrar_filtros()" class="cerrar_filtros fa fa-times"></i>
    </h3>
  </header>
  <div class="form-group">
    <label for="contacto_flotante_nombre">Nombre<em>*</em></label>
    <input class="form-control" type="text" id="contacto_flotante_nombre" value="<?php echo isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "" ?>" placeholder="Nombre" />
  </div>
  <div class="form-group">
    <label for="contacto_flotante_telefono">Tel&eacute;fono<em>*</em></label>
    <input class="form-control" type="tel" id="contacto_flotante_telefono" value="<?php echo isset($_SESSION["telefono"]) ? $_SESSION["telefono"] : "" ?>" placeholder="Tel&eacute;fono" />
  </div>
  <div class="form-group">
    <label for="contacto_flotante_email">Email<em>*</em></label>
    <input class="form-control" type="email" id="contacto_flotante_email" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : "" ?>" placeholder="Email" />
  </div>
  <div class="form-group">
    <label for="contacto_flotante_mensaje">Mensaje<em>*</em></label>
    <textarea class="form-control" id="contacto_flotante_mensaje" placeholder="Consulta"></textarea>
  </div>
  <div class="form-group">
    <button type="submit" id="contacto_flotante_submit" class="btn btn-buscar btn-default">Enviar</button>
  </div>
</form>
<script type="text/javascript">
function ver_whatsapp() {
  $("#form_flotante").addClass("active");
}
function ver_consultar() {
  $("#form_flotante").addClass("active");
}

var enviando = 0;
function enviar_contacto_flotante() {
  if (enviando == 1) return;
  var nombre = $("#contacto_flotante_nombre").val();
  var email = $("#contacto_flotante_email").val();
  var telefono = $("#contacto_flotante_telefono").val();
  var mensaje = $("#contacto_flotante_mensaje").val();
  var asunto = $("#contacto_flotante_asunto").val();
  var id_propiedad = $("#contacto_flotante_propiedad").val();
  var id_origen = <?php echo (isset($id_origen) ? $id_origen : 0) ?>;
  
  if (isEmpty(nombre) || nombre == "Nombre") {
    alert("Por favor ingrese un nombre");
    $("#contacto_flotante_nombre").focus();
    return false;      
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_flotante_email").focus();
    return false;      
  }
  if (isEmpty(telefono) || telefono == "Telefono") {
    alert("Por favor ingrese un telefono");
    $("#contacto_flotante_telefono").focus();
    return false;      
  }
  
  $("#contacto_flotante_submit").attr('disabled', 'disabled');
  var datos = {
    "para":"<?php echo $empresa->email ?>",
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "asunto":asunto,
    "id_propiedad":id_propiedad,
    "id_empresa":ID_EMPRESA,
    <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?>
      "id_empresa_relacion":"<?php echo $propiedad->id_empresa ?>",
    <?php } ?>
    "id_origen": ((id_origen != 0) ? id_origen : ((id_propiedad != 0)?1:6)),
  }
  enviando = 1;
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
        $("#contacto_flotante_submit").removeAttr('disabled');
        enviando = 0;
      }
    }
  });
  return false;
}  
</script>