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

  <?php $entrada = $entrada_model->get(44834) ?>


  <section class="equipo-banner equo">
    <div class="container">
      <div class="equipo-content">
        <h1 class="banner-title">vender</h1>
      </div>
    </div>
  </section>

  <section class="equo-con">
    <div class="container">
      <div class="con-inner pt0">        
        <div class="row g-0">
          <div class="col-lg-6">
            <?php if (!empty($entrada)) { ?>
              <div class="con-warp">
                <img src="<?php echo $entrada->path ?>" alt="Con">
              </div>
            <?php } ?>
          </div>
          <div class="col-lg-6">
            <div class="con-content">
              <div>
                <?php $t = $web_model->get_text("equipo_texto_1", "somos una inmobiliaria joven"); ?>
                <h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $t->id_empresa ?>">
                  <?php echo $t->plain_text ?>
                </h3>
                <h4>francesconi</h4>
                <?php $t = $web_model->get_text("equipo_texto_2", "Más de 10 años trabajando juntos"); ?>
                <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $t->id_empresa ?>">
                  <?php echo $t->plain_text ?>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="con-text">
          <h3><?php echo $entrada->titulo ?></h3>
          <p><?php echo $entrada->plain_text ?></p>
        </div>
      </div>
    </div>
  </section>


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