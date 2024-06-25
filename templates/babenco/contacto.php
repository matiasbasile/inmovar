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
    <h1>contacto</h1>
  </div>
</section>

<?php
$oficinas_list = $entrada_model->get_list(array(
  "from_link_categoria" => "oficinas"
));
$i = 0;
foreach($oficinas_list as $oficina) { ?>
  <div class="map-contact <?php echo ($i%2==0)?"":"sec" ?>">
    <div class="map">
      <div id="map<?php echo $i ?>"></div>
    </div>
    <div class="contact-detail">
      <strong><?php echo $oficina->titulo ?></strong>
      <?php echo $oficina->texto ?>
    </div>
  </div>
<?php $i++; } ?>

<?php include("includes/contacto.php") ?>

<?php include("includes/footer.php") ?>

</body>
</html>