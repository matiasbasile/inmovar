<?php include 'includes/init.php' ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
  <?php include 'includes/head.php' ?>
</head>

<body>

  <!-- Francesconi Header Equipo -->
  <?php include 'includes/headerequipo.php' ?>

  <!-- Equipo Banner Equo -->
  <section class="equipo-banner equo">
    <div class="container">
      <div class="equipo-content">
        <h1 class="banner-title">equipo</h1>
      </div>
    </div>
  </section>

  <!-- Equo Con -->
  <?php $usuarios = $usuario_model->get_list(array(
    "aparece_web" => 1,
    "order_by" => 1
  )) ?>
  <?php $categoria = $entrada_model->get_categorias(1680) ?>
  <section class="equo-con">
    <div class="container">
      <div class="equo-con-title">
        <h2 class="color-title">conoce a nuestro</h2>
        <h3 class="small-title">equipo</h3>
      </div>
      <div class="con-inner">
        <div class="row g-0">
          <div class="col-lg-6">
            <div class="con-warp">
              <img src="<?php echo "/admin/" . $categoria[0]->path ?>" alt="Con">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="con-content">
              <div>
                <h3>somos una inmobiliaria joven</h3>
                <h4>francesconi</h4>
                <p>Más de 10 años trabajando juntos</p>
              </div>
            </div>
          </div>
        </div>
        <div class="con-text">
          <h3>Lorem Ipsum is simply dummy text of the printing and typesetting.</h3>
          <p>
            <?php echo $categoria[0]->texto ?>
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Fran Section -->
  <?php if (!empty($usuarios)) { ?>
    <section class="fran-section">
      <div class="container">
        <div class="row">
          <?php foreach ($usuarios as $e) { ?>
            <div class="col-xl-3 col-md-6">
              <div class="fran-card">
                <img src="<?php echo $e->path ?>" alt="Fran">
                <div class="fran-content">
                  <h3><?php echo $e->titulo ?></h3>
                  <p><?php echo $e->cargo ?></p>
                  <div class="fran-socials">
                    <ul>
                      <?php if (!empty($e->telefono)) { ?>
                        <li><a href="tel:<?php echo $e->telefono ?>"><img src="assets/images/icons/icon-20.png" alt="Icon"><?php echo "+" . $e->telefono ?></a></li>
                      <?php } ?>
                      <?php if (!empty($e->email)) { ?>
                        <li><a href="mailto:<?php echo $e->email ?>"><img src="assets/images/icons/icon-21.png" alt="Icon"><span><?php echo $e->email ?></span></a></li>
                      <?php } ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </section>
  <?php } ?>

  <!-- Ros Section -->
  <section class="ros-section">
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
        </div>
      </div>
    </form>
  </section>

  <!-- Francesconi Nuster -->

  <?php include 'includes/home/secondary_slider.php' ?>

  <!-- Francesconi Footer -->
  <?php include 'includes/footer.php' ?>

</body>

</html>