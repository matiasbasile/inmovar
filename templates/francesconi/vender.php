<?php include 'includes/init.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php' ?>
  <style>
    .equo-con-title {
      padding: 50px 30px 30px 30px;
      ;
    }
  </style>
</head>

<body>
  <?php include 'includes/header.php' ?>

  <section class="equipo-banner equo">
    <div class="container">
      <div class="equipo-content">
        <h1 class="banner-title">vender</h1>
      </div>
    </div>
  </section>

  <?php $entrada = $entrada_model->get(44834) ?>

  <div class="container">
    <?php if (!empty($entrada)) { ?>
      <div>
        <img src="<?php echo $entrada->path ?>" alt="img-venta">
      </div>
    <?php } ?>
  </div>

  <?php if (!empty($entrada)) { ?>
    <div class="container" id="contacto-container">
      <h4 class="text-uppercase text-center contacto-title"><?php echo $entrada->titulo ?></h4>
      <p class="contacto-descripcion">
        <?php echo $entrada->plain_text ?>
      </p>
    </div>
  <?php } ?>
  <section class="ros-section ">
    <form onsubmit="return enviar_contacto()">
      <div class="container">
        <div class="ros-content">
          <h3 class="color-title" style="color: #f23881;">CONOCE A NUESTRO EQUIPO</h3>
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
                  <option value="australia">asunto</option>
                  <?php $asuntos = explode(";;;", $empresa->asuntos_contacto); ?>
                  <?php foreach ($asuntos as $a) { ?>
                    <option><?php echo $a ?></option>
                  <?php } ?>
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
        </div>
      </div>
    </form>
  </section>

  <?php include 'includes/footer.php' ?>

</body>

</html>