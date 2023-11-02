<?php 
include_once 'includes/init.php'; 
$entrada = $entrada_model->get($id);
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
  <?php include 'includes/head.php'; ?>
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <section class="small-banner">
    <div class="container">
      <h1><?php echo $entrada->categoria ?></h1>
    </div>
  </section>

  <section class="communicate-us-two">
    <div class="container">
      <div class="section-title">
        <h2><?php echo $entrada->titulo ?></h2>
        <p><?php echo $entrada->subtitulo ?></p>
      </div>
    </div>
  </section>

  <section class="communicate-us" style="padding-top:40px;">
    <div class="row gy-5 gx-0 align-items-center">
      <div class="form-wrap form-wrap-two">
        <form id="contactForm">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <input id="contacto_nombre" class="form-control" type="text"
                  placeholder="Nombre completo">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <input id="contacto_telefono" class="form-control" type="text"
                  placeholder="Whatsapp (sin 0 ni 15)">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <input id="contacto_email" class="form-control" type="email" placeholder="Email">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <select id="contacto_asunto" class="form-control">
                  <option value="">Elija asunto</option>
                  <?php $asuntos = explode(';;;', $empresa->asuntos_contacto); ?>
                  <?php foreach ($asuntos as $a) { ?>
                  <option><?php echo $a; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <textarea id="contacto_mensaje" placeholder="Escriba sus comentarios"
                  class="form-control"></textarea>
              </div>
            </div>
          </div>
          <button id="contacto_submit" class="btn">enviar consulta</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>

  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWmUapFYTBXV3IJL9ggjT9Z1wppCER55g&callback=initMap">
  </script>
  <script src="assets/js/script.js"></script>
</body>

</html>