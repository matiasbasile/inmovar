<?php 
$asunto = $propiedad->nombre." [Cod: ".$propiedad->codigo."]";
$telefono_propiedad = empty($propiedad->usuario_celular) ? $propiedad->usuario_celular : preg_replace("/[^0-9]/", "", $empresa->whatsapp);
?>
<form id="form_flotante" onsubmit="return enviar_contacto_flotante()" class="form-search">
  <input type="hidden" name="id_propiedad" id="contacto_flotante_propiedad" value="<?php echo (isset($propiedad) ? $propiedad->id : 0) ?>"/>
  <input type="hidden" id="contacto_flotante_whatsapp" value="0"/>
  <header>
    <h3>
      <span class="titulo"></span>
      <i onclick="cerrar()" class="cerrar_filtros fa fa-times"></i>
    </h3>
  </header>
  <div class="form-group">
    <label for="contacto_flotante_nombre">Nombre<em>*</em></label>
    <input class="form-control" type="text" id="contacto_flotante_nombre" value="<?php echo isset($_COOKIE["vc_nombre"]) ? $_COOKIE["vc_nombre"] : "" ?>" placeholder="Nombre" />
  </div>
  <div class="form-group">
    <label for="contacto_flotante_telefono">Tel&eacute;fono<em>*</em></label>
    <input class="form-control" type="number" id="contacto_flotante_telefono" value="<?php echo isset($_COOKIE["vc_telefono"]) ? $_COOKIE["vc_telefono"] : "" ?>" placeholder="Tel&eacute;fono (sin 0 ni 15)" />
  </div>
  <div class="form-group">
    <label for="contacto_flotante_email">Email<em>*</em></label>
    <input class="form-control" type="email" id="contacto_flotante_email" value="<?php echo isset($_COOKIE["vc_email"]) ? $_COOKIE["vc_email"] : "" ?>" placeholder="Email" />
  </div>
  <div class="form-group">
    <label for="contacto_flotante_mensaje">Mensaje<em>*</em></label>
    <textarea class="form-control" id="contacto_flotante_mensaje" placeholder="Consulta">Hola! estoy interesado en <?php echo $asunto ?></textarea>
  </div>
  <div id="contacto_solo_boton" class="form-group">
    <button type="submit" id="contacto_flotante_submit" class="btn btn-buscar btn-default">Enviar</button>
  </div>
  <div id="contacto_dos_botones" class="row">
    <div class="col-xs-6">
      <div class="form-group">
        <a href="javascript:void(0)" rel="nofollow" onclick="enviar_whatsapp()" class="btn btn-whatsapp btn-default">Enviar Whatsapp</a>
      </div>
    </div>
    <div class="col-xs-6">
      <div class="form-group">
        <a href="javascript:void(0)" rel="nofollow" onclick="enviar_email()" class="btn btn-buscar btn-default">Enviar Email</a>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">

function enviar_whatsapp() {
  $("#contacto_flotante_whatsapp").val(1);
  $("#form_flotante").submit();
}

function enviar_email() {
  $("#contacto_flotante_whatsapp").val(0);
  $("#form_flotante").submit();
}

function ver_whatsapp() {
  $("#contacto_flotante_whatsapp").val(1);
  <?php if (!empty($cookie_id_cliente)) { ?>
    enviar_contacto_cliente();
  <?php } else { ?>
    $("#form_flotante .titulo").html("Enviar Whatsapp");
    $("#form_flotante").addClass("active");
  <?php } ?>
}
function ver_consultar() {
  $("#contacto_flotante_whatsapp").val(0);
  <?php if (!empty($cookie_id_cliente)) { ?>
    enviar_contacto_cliente();
  <?php } else { ?>
    $("#form_flotante .titulo").html("Enviar Email");
    $("#form_flotante").addClass("active");
  <?php } ?>
}
function cerrar() {
  $("#form_flotante").removeClass("active");
}

window.enviando = 0;
function enviar_contacto_flotante() {
  if (enviando == 1) return false;
  var nombre = $("#contacto_flotante_nombre").val();
  var email = $("#contacto_flotante_email").val();
  var telefono = $("#contacto_flotante_telefono").val();
  var mensaje = $("#contacto_flotante_mensaje").val();
  var asunto = $("#contacto_flotante_asunto").val();
  var id_propiedad = $("#contacto_flotante_propiedad").val();
  var es_whatsapp = $("#contacto_flotante_whatsapp").val();
  
  if (isEmpty(nombre)) {
    alert("Por favor ingrese un nombre");
    $("#contacto_flotante_nombre").focus();
    return false;      
  }
  if (isEmpty(telefono)) {
    alert("Por favor ingrese un telefono");
    $("#contacto_flotante_telefono").focus();
    return false;      
  }
  if (!isTelephone(telefono)) {
    alert("Por favor ingrese un telefono valido (sin 0 ni 15)");
    $("#contacto_flotante_telefono").focus();
    return false;    
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_flotante_email").focus();
    return false;      
  }

  var datos = {
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "asunto":"Consulta en <?php echo $asunto ?>",
    "id_propiedad":id_propiedad,
    "id_empresa":ID_EMPRESA,
    <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?>
      "id_empresa_relacion":"<?php echo $propiedad->id_empresa ?>",
    <?php } ?>
    "id_origen": ((es_whatsapp == 1) ? 30 : 1),
  }
  do_enviar(datos);
  return false;
}

function enviar_contacto_cliente() {
  var id_propiedad = $("#contacto_flotante_propiedad").val();
  var es_whatsapp = $("#contacto_flotante_whatsapp").val();
  var datos = {
    "id_cliente":"<?php echo $cookie_id_cliente ?>",
    "asunto":"Consulta en <?php echo $asunto ?>",
    "id_propiedad":id_propiedad,
    "id_empresa":ID_EMPRESA,
    <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?>
      "id_empresa_relacion":"<?php echo $propiedad->id_empresa ?>",
    <?php } ?>
    "id_origen": ((es_whatsapp == 1) ? 30 : 1),
  }
  do_enviar(datos);
  return false;
}

function do_enviar(datos) {
  window.enviando = 1;
  $("#contacto_flotante_submit").attr('disabled', 'disabled');

  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        if (datos.id_origen == 30) {

          var telefono_usuario = "<?php echo $telefono_propiedad ?>";
          if (telefono_usuario.indexOf("549") == -1) telefono_usuario = "549"+telefono_usuario;

          var tpl = "Hola! estoy interesado en la propiedad <?php echo $asunto ?>\n\n";
          tpl += "Nombre y Apellido: *"+r.nombre+"*\n\n";
          tpl += "Telefono: *"+((r.telefono.indexOf("549") == -1)?"549":"")+r.telefono+"*\n\n";
          tpl += "Email: *"+r.email+"*\n\n";
          
          var url = "https://wa.me/"+telefono_usuario;
          url+= "?text="+encodeURIComponent(tpl);  
          var open = window.open(url,"_blank");
          if (open == null || typeof(open)=='undefined') location.href = url;
          else location.reload();
          
        } else {
          alert("Tu consulta por esta propiedad ha sido enviada. Pronto nos estaremos comunicando. ¡Muchas gracias!");
          location.reload();
        }
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_flotante_submit").removeAttr('disabled');
        window.enviando = 0;
      }
    }
  });
}
</script>