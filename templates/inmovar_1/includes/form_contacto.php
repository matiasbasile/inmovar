<form class="clearfix" onsubmit="return enviar_contacto()">
  <div class="row">
    <input type="hidden" name="id_propiedad" id="contacto_propiedad" value="<?php echo (isset($propiedad) ? $propiedad->id : 0) ?>"/>
    <?php if(!isset($propiedad)) { ?>
      <div class="col-md-6">
      <div class="form-group">
        <label for="contacto_nombre">Nombre<em>*</em></label>
        <input class="form-control" type="text" id="contacto_nombre" value="<?php echo isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "" ?>" placeholder="Nombre" />
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label for="contacto_email">Email<em>*</em></label>
        <input class="form-control" type="email" id="contacto_email" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : "" ?>" placeholder="Email" />
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label for="contacto_telefono">Tel&eacute;fono<em>*</em></label>
        <input class="form-control" type="tel" id="contacto_telefono" value="<?php echo isset($_SESSION["telefono"]) ? $_SESSION["telefono"] : "" ?>" placeholder="Tel&eacute;fono" />
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label for="contacto_asunto">Asunto</label>
        <select class="form-control" id="contacto_asunto">
          <?php $asuntos = explode(";;;",$empresa->asuntos_contacto);
          foreach($asuntos as $a) { ?>
            <option <?php echo (isset($asunto_defecto) && $asunto_defecto == $a)?"selected":"" ?> value="<?php echo $a ?>"><?php echo $a ?></option>
          <?php } ?>
        </select>
      </div>
      </div>    
    <?php } else { ?>
      <input type="hidden" id="contacto_asunto" value="<?php echo $propiedad->nombre ?>"/>
      <div class="col-md-6">
      <div class="form-group">
        <label for="contacto_nombre">Nombre<em>*</em></label>
        <input class="form-control" type="text" id="contacto_nombre" value="<?php echo isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "" ?>" placeholder="Nombre" />
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label for="contacto_telefono">Tel&eacute;fono<em>*</em></label>
        <div class="chat_user_form_row">
        <div class="chat_user_form_row_4">
          <?php include 'prefijo_localidades.php' ?>
        </div>
        <div class="chat_user_form_row_6">
          <input type="text" id="contacto_telefono" value="<?php echo isset($_SESSION["telefono"]) ? $_SESSION["telefono"] : "" ?>"" class="chat_user_form_input chat_user_form_2_celular" placeholder="Teléfono">
        </div>
      </div>
        <input class="form-control" type="tel" id="contacto_telefono" value="<?php echo isset($_SESSION["telefono"]) ? $_SESSION["telefono"] : "" ?>" placeholder="Tel&eacute;fono" />
      </div>
      </div>
      <div class="col-md-12">
      <div class="form-group">
        <label for="contacto_email">Email<em>*</em></label>
        <input class="form-control" type="email" id="contacto_email" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : "" ?>" placeholder="Email" />
      </div>
      </div>
    <?php } ?>
    <div class="col-md-12">
      <div class="form-group">
        <label for="contacto_mensaje">Mensaje<em>*</em></label>
        <textarea class="form-control" id="contacto_mensaje" placeholder="Consulta"><?php echo (isset($get_params["m"]) ? urldecode($get_params["m"]) : "") ?></textarea>
      </div>
    </div>
    <div class="col-md-12">
      <button type="submit" id="contacto_submit" class="btn pull-right btn-default">Enviar</button>
    </div>
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
  var id_propiedad = $("#contacto_propiedad").val();
  var id_origen = <?php echo (isset($id_origen) ? $id_origen : 0) ?>;
  
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
