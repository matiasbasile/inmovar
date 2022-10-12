<section class="ros-section <?php echo (isset($habilitar_whatsapp)) ? "map" : "" ?>">
  <form onsubmit="return enviar_contacto()">
    <div class="container">
      <div class="ros-content">
        <h3 class="color-title">Fernando francesconi</h3>
        <h4 class="small-title">nosotros</h4>
      </div>
      <div class="ros-inner">
        <div class="row">
          <div class="col-lg-6">
            <input type="text" id="contacto_nombre" name="Nombre" placeholder="Nombre *">
          </div>
          <div class="col-lg-6">
            <input type="text" id="contacto_email" name="Email" placeholder="Email">
          </div>
          <div class="col-lg-6">
            <input type="text" id="contacto_telefono" name="Telefono" placeholder="Whatsapp (sin 0 ni 15) *">
          </div>
          <div class="col-lg-6">
            <div class="select-inner">
              <select id="contacto_asunto" class="round" name="venta">
                <option value="australia">venta</option>
                <option value="canada">venta</option>
                <option value="usa">venta</option>
              </select>
            </div>
          </div>
          <div class="col-lg-12">
            <textarea id="contacto_mensaje">Mensaje</textarea>
          </div>
        </div>
      </div>
      <div class="fill-btn-inner">
        <button id="contacto_submit" class="fill-btn">enviar consulta</button>
        <?php if (isset($habilitar_whatsapp)) { ?>
          <a href="https://wa.me/<?php echo str_replace(' ', '', $usuario->telefono) ?>" target="_blank" class="fill-btn light"><img src="assets/images/icons/icon-7.png" alt="Icon">enviar whatsapp</a>
        <?php } ?>
      </div>
    </div>
  </form>
</section>