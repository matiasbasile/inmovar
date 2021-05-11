<form onsubmit="return enviar_contacto()">
  <input type="hidden" name="id_propiedad" id="contacto_propiedad" value="<?php echo (isset($propiedad) ? $propiedad->id : 0) ?>"/>
  <div class="col-md-6">
    <input type="text" id="contacto_nombre" value="<?php echo isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "" ?>" placeholder="Nombre" />
  </div>
  <div class="col-md-6">
    <input type="tel" id="contacto_telefono" value="<?php echo isset($_SESSION["telefono"]) ? $_SESSION["telefono"] : "" ?>" placeholder="Tel&eacute;fono" />
  </div>
  <?php if (!isset($propiedad)) { ?>
    <div class="col-md-6">
      <input type="email" id="contacto_email" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : "" ?>" placeholder="Email" />
    </div>
    <div class="col-md-6">
      <select id="contacto_asunto">
        <?php $asuntos = explode(";;;",$empresa->asuntos_contacto);
        foreach($asuntos as $a) { ?>
          <option><?php echo $a ?></option>
        <?php } ?>
      </select>
    </div>
  <?php } else { ?>
    <div class="col-md-12">
      <input type="email" id="contacto_email" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : "" ?>" placeholder="Email" />
    </div>  
    <input type="hidden" id="contacto_asunto" value="Consulta de <?php echo ($propiedad->nombre) ?>" />
  <?php } ?>
  <div class="col-md-12">
    <textarea id="contacto_mensaje" placeholder="Consulta"></textarea>
  </div>
  <div class="col-md-12">
    <input type="submit" value="enviar" class="btn btn-orange" />
  </div>
</form>
<script type="text/javascript">
function enviar_contacto() {
    
    var nombre = $("#contacto_nombre").val();
    var email = $("#contacto_email").val();
    var telefono = $("#contacto_telefono").val();
    var mensaje = $("#contacto_mensaje").val();
    var asunto = $("#contacto_asunto").val();
    var id_propiedad = $("#contacto_propiedad").val();
    
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
        "id_origen":<?php echo(isset($id_origen) ? $id_origen : 6); ?>,
        <?php if (isset($id_empresa)) { ?>"id_empresa_relacion":"<?php echo $id_empresa ?>",<?php } ?>
    }
    $.ajax({
        "url":"/admin/consultas/function/enviar/",
        "type":"post",
        "dataType":"json",
        "data":datos,
        "success":function(r){
            if (r.error == 0) {
                alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
                location.reload();
            } else {
                alert("Ocurrio un error al enviar su email. Disculpe las molestias");
                $("#contacto_submit").removeAttr('disabled');
            }
        }
    });
    return false;
}  
</script>
