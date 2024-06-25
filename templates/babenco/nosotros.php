<?php include 'includes/init.php' ?>
<!DOCTYPE html>
<html lang="es" >
<head>
  <?php include("includes/head.php") ?>
</head>
<body>
  <?php include("includes/header.php") ?>

<section class="page-title">
  <div class="container">
    <h1>nosotros</h1>
  </div>
</section>

<!-- About Us Info -->
<section class="about-us-info">
  <div class="container">

    <?php 
    $sobre_nosotros_list = $entrada_model->get_list(array(
      "from_link_categoria" => "sobre-nosotros"
    ));
    if (sizeof($sobre_nosotros_list)>0) {
      $sobre_nosotros = $sobre_nosotros_list[0]; ?>
      <div class="img-block">
        <img src="<?php echo $sobre_nosotros->path ?>" alt="<?php echo $sobre_nosotros->titulo ?>">
      </div>
      <div class="border-info-section">
        <div class="section-title">
          <span><?php echo $sobre_nosotros->categoria ?></span>
          <h2><?php echo $sobre_nosotros->titulo ?></h2>
        </div>
        <?php echo $sobre_nosotros->texto ?>
      </div>
    <?php } ?>

  </div>
</section>

<?php include("includes/footer.php") ?>

</body>
</html>