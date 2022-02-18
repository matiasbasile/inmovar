<form onsubmit="return enviar_contacto()">
  <input type="hidden" name="para" id="contacto_para" value="<?php echo (isset($contacto_para) ? $contacto_para : $empresa->email) ?>"/>
  <input type="hidden" name="id_usuario" id="contacto_id_usuario" value="<?php echo (isset($id_usuario) ? $id_usuario : 0) ?>"/>
  <input type="hidden" name="id_propiedad" id="contacto_propiedad" value="<?php echo (isset($propiedad) ? $propiedad->id : 0) ?>"/>
  <div class="col-md-6">
    <input type="text" id="contacto_nombre" value="<?php echo isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "" ?>" placeholder="Nombre" />
  </div>
  <div class="col-md-6">
    <input type="tel" id="contacto_telefono" value="<?php echo isset($_SESSION["telefono"]) ? $_SESSION["telefono"] : "" ?>" placeholder="Tel&eacute;fono" />
  </div>
  <?php if (isset($propiedad)) { ?>
    <div class="col-md-12">
      <input type="email" id="contacto_email" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : "" ?>" placeholder="Email" />
    </div>
    <input type="hidden" id="contacto_asunto" value="<?php echo ($propiedad->nombre)." Cod:[".$propiedad->codigo."]" ?>" />
  <?php } else { ?>
    <div class="col-md-6">
      <input type="email" id="contacto_email" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : "" ?>" placeholder="Email" />
    </div>
    <div class="col-md-6">
      <select id="contacto_asunto">
        <?php $asuntos = explode(";;;",$empresa->asuntos_contacto);
        foreach($asuntos as $a) { ?>
          <option value="<?php echo $a ?>"><?php echo $a ?></option>
        <?php } ?>
      </select>
    </div>
  <?php } ?>
  <div class="col-md-12">
    <textarea id="contacto_mensaje" placeholder="Consulta"></textarea>
  </div>
  <div class="col-md-12">
    <input type="submit" id="contacto_submit" value="enviar" class="btn btn-blue" />
  </div>
</form>
<script type="text/javascript">
var enviando = 0;
function enviar_contacto() {
  if (enviando == 1) return;
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var asunto = $("#contacto_asunto").val();
  var para = $("#contacto_para").val();
  var id_propiedad = $("#contacto_propiedad").val();
  var id_usuario = $("#contacto_id_usuario").val();
  if (isEmpty(para)) para = "<?php echo $empresa->email ?>";
  
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
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "asunto":asunto,
    "para":para,
    "id_propiedad":id_propiedad,
    <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?>
      "id_empresa_relacion":"<?php echo $propiedad->id_empresa ?>",
    <?php } ?>
    "id_usuario":id_usuario,
    "id_empresa":ID_EMPRESA,
    "id_origen":<?php echo(isset($id_origen) ? $id_origen : 1); ?>,
  }
  enviando = 1;
  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        window.location.href = "<?php echo mklink ("web/gracias/") ?>";
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
        enviando = 0;
      }
    }
  });
  return false;
}
</script>