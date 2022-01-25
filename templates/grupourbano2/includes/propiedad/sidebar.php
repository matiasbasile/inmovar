<div class="col-md-3">
  <?php if ($usuario->recibe_notificaciones != 0) { ?>
    <div class="right-sidebar">
      <?php if (!empty($usuario->path)) { ?>
        <div class="sidebar-img">
          <img src="<?php echo $usuario->path ?>" alt="img">
          <div class="sidebar-logo"><img src="assets/images/logo-icon.jpg" alt="img"></div>
        </div>
      <?php } ?>
      <?php if (!empty($usuario->nombre)) { ?>
        <h2><?php echo $usuario->nombre ?></h2>
      <?php } ?>
      <?php if (!empty($usuario->cargo)) { ?>
        <h5><?php echo $usuario->cargo ?></h5>
      <?php } ?>
      <!-- <div class="stars-rating">
        <i class="fa fa-star" aria-hidden="true"></i>
        <i class="fa fa-star" aria-hidden="true"></i>
        <i class="fa fa-star" aria-hidden="true"></i>
        <i class="fa fa-star" aria-hidden="true"></i>
        <i class="fa fa-star" aria-hidden="true"></i>
        <p>(45 Comentarios)</p>
      </div> -->
      <div class="social">
        <?php if (!empty($usuario->facebook)) { ?>
          <a href="<?php echo $usuario->facebook ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        <?php } ?>
        <?php if (!empty($usuario->instagram)) { ?>
          <a href="<?php echo $usuario->instagram ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        <?php } ?>
      </div>
      <?php $nombre = explode(" ", $usuario->nombre) ?>
      <?php if (!empty($usuario->celular_f)) { ?>
        <a href="tel:<?php echo $usuario->celular_f ?>" class="btn btn-primary btn-block"><i class="fa fa-phone mr-3" aria-hidden="true"></i> llamá a <?php echo $nombre[0] ?></a>
      <?php } ?>
    </div>
  <?php } ?>
  <div class="right-sidebar">
    <div class="sidebar-arrow"><img src="assets/images/sidebar-arrow.png" alt="img"></div>
    <h2>comunicate ahora</h2>
    <h5 class="mb-3">por esta propiedad</h5>
    <form onsubmit="return false">
      <div class="form-group">
        <input id="contacto_nombre" type="text" class="form-control" placeholder="Nombre">
      </div>
      <div class="form-group">
        <input id="contacto_telefono" type="number" class="form-control" placeholder="WhatsApp (sin 0 ni 15)">
      </div>
      <div class="form-group">
        <input id="contacto_email" type="email" class="form-control" placeholder="Email">
      </div>
      <div class="form-group">
        <textarea id="contacto_mensaje" class="form-control">Estoy interesado en <?php echo $propiedad->nombre ?> [COD: <?php echo $propiedad->codigo ?>].</textarea>
      </div>
      <?php if (!empty($usuario->celular_f)) { ?>
        <div class="form-group">
          <button onclick="enviar_whatsapp()" type="button" class="btn contacto_submit btn-success btn-block"><i class="fa fa-whatsapp mr-3" aria-hidden="true"></i> enviar por whatsapp</button>
        </div>
      <?php } ?>
      <div class="form-group mb-0">
        <button onclick="enviar_email()" type="button" class="btn contacto_submit btn-secondary btn-block"><i class="fa fa-envelope-o mr-3" aria-hidden="true"></i> enviar por email</button>
      </div>
    </form>
  </div>
  <div class="d-block">
    <a href="javascript:void(0)" rel="nofollow" onClick="history.go(-1); return false;" class="btn btn-outline-secondary btn-block style-two"><i class="fa fa-undo mr-3" aria-hidden="true"></i> regresar a los resultados</a>
  </div>
</div>
<script>
window.enviando = 0;
function validar() {
  if (window.enviando == 1) throw false;
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();

  if (isEmpty(nombre) || nombre == "Nombre") {
    alert("Por favor ingrese un nombre");
    $("#contacto_nombre").focus();
    throw false;
  }
  if (isEmpty(telefono)) {
    alert("Por favor ingrese un telefono");
    $("#contacto_telefono").focus();
    throw false;
  }
  if (telefono.length != 10) {
    alert("Por favor ingrese su numero de telefono sin 0 ni 15.");
    $("#contacto_telefono").focus();
    throw false;    
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_email").focus();
    throw false;
  }
  if (isEmpty(mensaje)) {
    alert("Por favor ingrese un mensaje");
    $("#contacto_mensaje").focus();
    throw false;
  }

  $(".contacto_submit").attr('disabled', 'disabled');
  window.enviando = 1;
  var datos = {
    "nombre": nombre,
    "email": email,
    "mensaje": mensaje,
    "telefono": telefono,
    "id_propiedad": "<?php echo (isset($propiedad) ? $propiedad->id : 0) ?>",
    <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?> 
      "id_empresa_relacion": "<?php echo $propiedad->id_empresa ?>",
    <?php } ?> 
    "para": "<?php echo ( (isset($usuario->email) && !empty($usuario->email)) ? $usuario->email : $empresa->email) ?>",
    "id_usuario": "<?php echo (isset($usuario->id) ? $usuario->id : 0) ?>",
    "id_empresa": ID_EMPRESA,
  }
  return datos;
}

function enviar_whatsapp() {
  try {
    var datos = validar();
    datos.id_origen = 27;
    $.ajax({
      "url": "/admin/consultas/function/enviar/",
      "type": "post",
      "dataType": "json",
      "data": datos,
      "success": function(r) {
        if (r.error == 0) {
          var url = "https://wa.me/"+<?php echo $usuario->celular_f ?>;
          url+= "?text="+encodeURIComponent(datos.mensaje);
          var open = window.open(url,"_blank");
          if (open == null || typeof(open)=='undefined') {
            // Si se bloqueo el popup, se redirecciona
            location.href = url;
          }
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");
          $(".contacto_submit").removeAttr('disabled');
        }
        window.enviando = 0;
      },
      "error":function() {
        $(".contacto_submit").removeAttr('disabled');
        window.enviando = 0;
      }
    });
  } catch(e) {
    $(".contacto_submit").removeAttr('disabled');
    console.log(e);
  }
}

function enviar_email() {
  try {
    var datos = validar();
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
          $(".contacto_submit").removeAttr('disabled');
        }
        window.enviando = 0;
      },
      "error":function() {
        $(".contacto_submit").removeAttr('disabled');
        window.enviando = 0;
      }
    });
  } catch(e) {
    $(".contacto_submit").removeAttr('disabled');
    console.log(e);
  }
}
</script>