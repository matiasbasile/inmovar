<section class="form-box">
  <div class="container">
    <div class="gray-box">
      <div class="title">
        <img src="assets/images/contact-icon.png" alt="Contact Icon">
        <div class="right-info">
          <h4>Estamos aquí para ayudarte</h4>
          <p>¡Escríbenos y descubre cómo podemos hacer realidad tus proyectos!</p>
        </div>
      </div>
      <form onsubmit="return enviar_contacto()">
        <div class="row">
          <div class="col-md-6">
            <input type="text" id="contacto_nombre" placeholder="Nombre" class="form-control">
          </div>
          <div class="col-md-6">
            <input type="email" id="contacto_email" placeholder="Email" class="form-control">
          </div>
          <div class="col-md-6">
            <input type="text" id="contacto_telefono" placeholder="Whatsapp <?php echo ($empresa->id == ID_EMPRESA_LA_PLATA) ? "(sin 0 ni 15)" : "" ?>" class="form-control">
          </div>
          <div class="col-md-6">
            <select id="contacto_asunto" class="form-control">
              <option value="">Elija Asunto</option>
              <?php $asuntos = explode(";;;", $empresa->asuntos_contacto); ?>
              <?php foreach ($asuntos as $a) { ?>
                <option><?php echo $a ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-12">
            <textarea class="form-control" id="contacto_mensaje" placeholder="Escriba su mensaje"></textarea>
          </div>
          <div class="col-md-12">
            <button id="contacto_submit" type="submit" class="btn"><img src="assets/images/whatspp2.png" alt="Whatsapp"> Enviar Mensaje</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>