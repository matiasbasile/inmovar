<?php include 'includes/init.php';
$entrada = $entrada_model->get($id); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php' ?>
</head>

<body>

  <?php include 'includes/header.php' ?>

  <section class="equipo-banner equo">
    <div class="container">
      <div class="equipo-content">
        <h1 class="banner-title">novedades</h1>
      </div>
    </div>
  </section>

  <section class="equo-con">
    <div class="container">    
      <div class="equo-con-title">
        <h2 class="color-title"><?php echo fecha_full($entrada->fecha) ?></h2>
        <h3 class="small-title"><?php echo $entrada->titulo ?></h3>
      </div>
    </div>
  </section> 

  <?php if (sizeof($entrada->images) > 0) { ?>
    <section class="map-section magnific-gallery mt30">
      <div class="swiper-container map-slider">
        <div class="swiper-wrapper">
          <?php foreach ($entrada->images as $img) { ?>
            <div class="swiper-slide">
              <a class="fancybox" data-fancybox="gallery" href="<?php echo $img ?>"><img src="<?php echo $img ?>" class="noved_img" alt="Gallery"></a>
            </div>
          <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev swiper-button-white"></div>
        <div class="swiper-button-next swiper-button-white"></div>
      </div>
    </section>
  <?php } else { ?>
    <div class="container mt30">
      <div class="mb-5 text-center">
        <img src="<?php echo $entrada->path ?>" alt="img-venta">
      </div>
    </div>
  <?php } ?>

  <?php if (!empty($entrada)) { ?>
    <div class="container" id="contacto-container">
      <?php if (!empty($entrada->subtitulo)) { ?>
        <h4 class="text-uppercase text-center contacto-title"><?php echo $entrada->subtitulo ?></h4>
      <?php } ?>
      <div class="contacto-descripcion mb-5">
        <?php echo $entrada->plain_text ?>
      </div>
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

  <script>
    $(".fancybox").fancybox();
  </script>

</body>

</html>