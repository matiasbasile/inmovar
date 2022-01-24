<?php 
// Si no tiene asignado un usuario, tenemos que asignarle aleatoriamente uno
if (empty($propiedad->id_usuario)) {
  $usuarios = $usuario_model->get_list(array(
    "activo"=>1,
    "offset"=>99999,
    "aparece_web"=>1,
  ));
  $rand = array_rand($usuarios);
  $usuario = $usuarios[$rand];
  $propiedad->id_usuario = $usuario->id;
}
?>
<div class="col-md-3">
  <?php $usuario = $usuario_model->get($propiedad->id_usuario); ?>
  <?php if ($usuario->aparece_web != 0) { ?>
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
      <a href="tel:<?php echo $usuario->telefono ?>" class="btn btn-primary btn-block"><i class="fa fa-phone mr-3" aria-hidden="true"></i> llamá a <?php echo $nombre[0] ?></a>
    </div>
  <?php } ?>
  <div class="right-sidebar">
    <input type="hidden" name="para" id="contacto_para" value="<?php echo (isset($contacto_para) ? $contacto_para : $empresa->email) ?>" />
    <input type="hidden" name="id_usuario" id="contacto_id_usuario" value="<?php echo (isset($id_usuario) ? $id_usuario : 0) ?>" />
    <input type="hidden" name="id_propiedad" id="contacto_propiedad" value="<?php echo (isset($propiedad) ? $propiedad->id : 0) ?>" />
    <div class="sidebar-arrow"><img src="assets/images/sidebar-arrow.png" alt="img"></div>
    <h2>comunicate ahora</h2>
    <h5 class="mb-3">por esta propiedad</h5>
    <form onsubmit="enviar_contacto()">
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
        <textarea id="contacto_mensaje" class="form-control" value="Estoy interesado en <?php echo $propiedad->nombre ?> [COD: <?php echo $propiedad->codigo ?>]."></textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-whatsapp mr-3" aria-hidden="true"></i> enviar por whatsapp</button>
      </div>
      <div class="form-group mb-0">
        <button type="submit" class="btn btn-secondary btn-block"><i class="fa fa-envelope-o mr-3" aria-hidden="true"></i> enviar por email</button>
      </div>
    </form>
  </div>
  <div class="d-block">
    <a href="javascript:void(0)" rel="nofollow" onClick="history.go(-1); return false;" class="btn btn-outline-secondary btn-block style-two"><i class="fa fa-undo mr-3" aria-hidden="true"></i> regresar a los resultados</a>
  </div>
</div>
<script>
window.enviando = 0;
function enviar_contacto() {
  if (window.enviando == 1) return;
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
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
    "nombre": nombre,
    "email": email,
    "mensaje": mensaje,
    "telefono": telefono,
    "para": para,
    "id_propiedad": id_propiedad,
    <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?> 
      "id_empresa_relacion": "<?php echo $propiedad->id_empresa ?>",
    <?php } ?> 
    "id_usuario": id_usuario,
    "id_empresa": ID_EMPRESA,
    "id_origen": <?php echo (isset($id_origen) ? $id_origen : 1); ?>,
  }
  window.enviando = 1;
  $.ajax({
    "url": "/admin/consultas/function/enviar/",
    "type": "post",
    "dataType": "json",
    "data": datos,
    "success": function(r) {
      if (r.error == 0) {
        window.location.href = "<?php echo mklink("web/gracias/") ?>";
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
      }
      window.enviando = 0;
    },
    "error":function() {
      window.enviando = 0;
    }
  });
  return false;
}
</script>