<div class="modal fade modal-whatsapp" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5><img src="assets/images/whatsapp-icon-2.png" alt="Whatsapp"> enviar whatsapp</h5>
        <button onclick="cerrarModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <img src="assets/images/popup-close.png" alt="Close Btn">
        </button>
      </div>
      <div class="modal-body">
        <form id="contacto-flotante" onsubmit="return enviarModal()">
          <input type="hidden" id="actionModal" value="whatsapp"/>
          <input type="hidden" id="id_propiedad" value="0"/>
          <div class="form-group">
            <input type="text" name="nombre" placeholder="Nombre *" class="form-control contacto_nombre">
          </div>
          <div class="form-group">
            <input type="email" name="email" placeholder="Email *" class="form-control contacto_email">
          </div>
          <div class="form-group">
            <input type="tel" name="telefono" placeholder="WhatsApp <?php echo ($empresa->id == ID_EMPRESA_LA_PLATA) ? "(sin 0 ni 15)" : "" ?> *" class="form-control contacto_telefono">
          </div>
          <div class="form-group">
            <?php 
            $texto = "";
            if (isset($propiedad)) {
              $texto = "Estoy interesado en “".$propiedad->nombre." Cod: ".$propiedad->codigo."”";
            } ?>
            <textarea name="mensaje" class="form-control contacto_mensaje"><?php echo $texto ?></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn contacto_submit">enviar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
function abrirModal(action, mensaje = "", id_propiedad = 0) {
  $("#actionModal").val(action);
  $("#id_propiedad").val(id_propiedad);
  if (!isEmpty(mensaje)) $(".modal-whatsapp .contacto_mensaje").val(mensaje);
  $(".modal-whatsapp").modal("show");
}
function cerrarModal() {
  $(".modal-whatsapp").modal("hide");
}
function enviarModal() {
  var action = $("#actionModal").val();
  if (action == "whatsapp") {
    return enviar_whatsapp("contacto-flotante");
  } else if (action == "telefono") {
    return enviar_telefono("contacto-flotante");
  } else if (action == "email") {
    return enviar_email("contacto-flotante");
  }
  return false;
}
</script>