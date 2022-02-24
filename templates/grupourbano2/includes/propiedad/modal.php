<div id="visita-modal" class="modal">
  <div class="modal-body">
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
      <div class="form-group mb-0">
        <button onclick="enviar_visita()" type="button" class="btn contacto_submit btn-secondary btn-block"><i class="fa fa-envelope-o mr-3" aria-hidden="true"></i> enviar por email</button>
      </div>
    </form>
  </div>
</div>
