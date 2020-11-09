<form onsubmit="return enviar_contacto_2()">
  <input type="hidden" name="para" id="contacto_2_para" value="<?php echo (isset($contacto_2_para) ? $contacto_2_para : $empresa->email) ?>"/>
  <input type="hidden" name="id_usuario" id="contacto_2_id_usuario" value="<?php echo (isset($id_usuario) ? $id_usuario : 0) ?>"/>
  <input type="hidden" name="id_propiedad" id="contacto_2_propiedad" value="<?php echo (isset($propiedad) ? $propiedad->id : 0) ?>"/>
  <input type="hidden" id="contacto_2_asunto" value="<?php echo "Consulta Socio: ".($propiedad->nombre)." Cod:[".$propiedad->codigo."]" ?>" />
  <div class="col-md-12">
    <h5>Datos de la inmobiliaria</h5>
  </div>
  <div class="col-md-6">
    <input type="text" id="contacto_2_nombre" placeholder="Nombre *" />
  </div>
  <div class="col-md-6">
    <input type="tel" id="contacto_2_telefono" placeholder="Tel&eacute;fono *" />
  </div>
  <div class="col-md-12">
    <input type="email" id="contacto_2_email" placeholder="Email *" />
  </div>
  <div class="col-md-12">
    <h5>Datos del interesado</h5>
  </div>
  <div class="col-md-6">
    <input type="text" id="contacto_2_nombre_interesado" value="<?php echo isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "" ?>" placeholder="Nombre" />
  </div>
  <div class="col-md-6">
    <input type="tel" id="contacto_2_telefono_interesado" value="<?php echo isset($_SESSION["telefono"]) ? $_SESSION["telefono"] : "" ?>" placeholder="Tel&eacute;fono" />
  </div>
  <div class="col-md-12">
    <input type="email" id="contacto_2_email_interesado" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : "" ?>" placeholder="Email" />
  </div>
  <div class="col-md-12">
    <textarea id="contacto_2_mensaje" placeholder="Consulta *"></textarea>
  </div>
  <div class="col-md-12">
    <input type="submit" id="contacto_2_submit" value="enviar" class="btn btn-blue" />
  </div>
</form>
<script type="text/javascript">
var enviando = 0;
function enviar_contacto_2() {
  if (enviando == 1) return;
  var nombre = $("#contacto_2_nombre").val();
  var email = $("#contacto_2_email").val();
  var telefono = $("#contacto_2_telefono").val();
  var nombre_interesado = $("#contacto_2_nombre_interesado").val();
  var email_interesado = $("#contacto_2_email_interesado").val();
  var telefono_interesado = $("#contacto_2_telefono_interesado").val();
  var mensaje = $("#contacto_2_mensaje").val();
  var asunto = $("#contacto_2_asunto").val();
  var para = $("#contacto_2_para").val();
  var id_propiedad = $("#contacto_2_propiedad").val();
  var id_usuario = $("#contacto_2_id_usuario").val();
  if (isEmpty(para)) para = "<?php echo $empresa->email ?>";
  
  if (isEmpty(nombre) || nombre == "Nombre") {
    alert("Por favor ingrese un nombre");
    $("#contacto_2_nombre").focus();
    return false;          
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_2_email").focus();
    return false;          
  }
  if (isEmpty(telefono) || telefono == "Telefono") {
    alert("Por favor ingrese un telefono");
    $("#contacto_2_telefono").focus();
    return false;          
  }
  if (isEmpty(mensaje) || mensaje == "Mensaje") {
    alert("Por favor ingrese un mensaje");
    $("#contacto_2_mensaje").focus();
    return false;              
  }

  var m = "";
  m += "Datos de la inmobiliaria: \n";
  m += "Nombre: "+nombre+"\n";
  m += "Email: "+email+"\n";
  m += "Telefono: "+telefono+"\n";
  m += "Datos del interesado: \n";
  m += "Nombre: "+nombre_interesado+"\n";
  m += "Email: "+email_interesado+"\n";
  m += "Telefono: "+telefono_interesado+"\n";
  m += "Mensaje: \n"+mensaje+"\n";
    
  $("#contacto_2_submit").attr('disabled', 'disabled');
  var datos = {
    "nombre":nombre,
    "email":email,
    "mensaje":m,
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
    "url":"/sistema/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
        location.reload();
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_2_submit").removeAttr('disabled');
        enviando = 0;
      }
    }
  });
  return false;
}
</script>