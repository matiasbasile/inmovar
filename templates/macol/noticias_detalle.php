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

      <div class="contact-wrap">
        <?php if (!empty($entrada->path)) { ?>
          <img class="w100p" src="<?php echo $entrada->path ?>" />
        <?php } ?>
        <?php echo $entrada->texto ?>
      </div>
    </div>
  </section>

  <section class="communicate-us-two">
    <div class="container">
      <?php include 'includes/contacto.php'; ?>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

</body>

</html>