<div id="visita-modal" class="modal">
  <div class="modal-body">
    <form onsubmit="return false">
      <i class="fa fa-times cerrar_modal fs22 fr mt10 cp"></i>
      <h2 class="fs32" id="solicitar-visita">Solicitar una visita</h2>
      <div class="form-group">
        <input id="visita_nombre" type="text" class="form-control" placeholder="Nombre">
      </div>
      <div class="form-group">
        <input id="visita_telefono" type="number" class="form-control" placeholder="WhatsApp (sin 0 ni 15)">
      </div>
      <div class="form-group">
        <input id="visita_email" type="email" class="form-control" placeholder="Email">
      </div>
      <div class="row">
        <div class="col-12">
          <div class="form-group">
            <input id="visita_fecha" type="date" class="form-control" placeholder="Fecha">
          </div>
        </div>
        <div style="display: none;" class="col-6">
          <div class="form-group">
            <input id="visita_hora" type="time" class="form-control" placeholder="Hora">
          </div>
        </div>
      </div>
      <div class="form-group">
        <textarea id="visita_mensaje" class="form-control">Estoy interesado en <?php echo $propiedad->nombre ?> [COD: <?php echo $propiedad->codigo ?>].</textarea>
      </div>
      <div class="form-group mb-0">
        <button onclick="enviar_visita()" type="button" class="btn visita_submit btn-secondary btn-block">enviar</button>
      </div>
    </form>
  </div>
</div>
<script>
function enviar_visita() {
  if (window.enviando == 1) return false;
  var nombre = $("#visita_nombre").val();
  var email = $("#visita_email").val();
  var telefono = $("#visita_telefono").val();
  var fecha = $("#visita_fecha").val();
  var hora = $("#visita_hora").val();
  var mensaje = $("#visita_mensaje").val();

  if (isEmpty(nombre) || nombre == "Nombre") {
    alert("Por favor ingrese un nombre");
    $("#visita_nombre").focus();
    return false;
  }
  if (isEmpty(telefono)) {
    alert("Por favor ingrese un telefono");
    $("#visita_telefono").focus();
    return false;
  }
  if (telefono.length != 10) {
    alert("Por favor ingrese su numero de telefono sin 0 ni 15.");
    $("#visita_telefono").focus();
    return false;    
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#visita_email").focus();
    return false;
  }
  if (isEmpty(fecha)) {
    alert("Por favor ingrese una fecha");
    $("#visita_fecha").focus();
    return false;
  }
  if (isEmpty(hora)) {
    alert("Por favor ingrese una hora");
    $("#visita_hora").focus();
    return false;
  }
  if (isEmpty(mensaje)) {
    alert("Por favor ingrese un mensaje");
    $("#visita_mensaje").focus();
    return false;
  }
  var m = "Interesado en Visita\nFecha: "+moment(fecha).format("DD/MM/YYYY")+" "+hora+"\nMensaje: "+mensaje;
  $(".visita_submit").attr('disabled', 'disabled');
  window.enviando = 1;
  var datos = {
    "nombre": nombre,
    "email": email,
    "asunto":"Interesado en Visita",
    "mensaje": m,
    "telefono": telefono,
    "id_propiedad": "<?php echo (isset($propiedad) ? $propiedad->id : 0) ?>",
    <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?> 
      "id_empresa_relacion": "<?php echo $propiedad->id_empresa ?>",
    <?php } ?> 
    "para": "<?php echo ( (isset($usuario->email) && !empty($usuario->email)) ? $usuario->email : $empresa->email) ?>",
    "id_usuario": "<?php echo (isset($usuario->id) ? $usuario->id : 0) ?>",
    "id_empresa": ID_EMPRESA,
  }
  datos.id_origen = 1;
  $.ajax({
    "url": "/admin/consultas/function/enviar/",
    "type": "post",
    "dataType": "json",
    "data": datos,
    "success": function(r) {
      if (r.error == 0) {
        alert("Su consulta ha sido enviada correctamente. Nos pondremos en contacto a la mayor brevedad!");
        location.reload();
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $(".visita_submit").removeAttr('disabled');
      }
      window.enviando = 0;
    },
    "error":function() {
      $(".visita_submit").removeAttr('disabled');
      window.enviando = 0;
    }
  });
  return false;
}
</script>
