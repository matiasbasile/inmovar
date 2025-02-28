<?php include "includes/init.php";
$get_params["offset"] = 6;
$vc_filter = (isset($get_params["filter"])) ? $get_params["filter"] : "";
extract($entrada_model->get_variables()); 
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <?php include 'includes/head.php' ?>
</head>

<body>

  <?php 
  $menu_active = "lacomu";
  include 'includes/header.php' ?>

  <section class="small-banner">
    <div class="container">
      <h2>novedades</h2>
    </div>
  </section>  

  <section class="last-news">

    <?php if (!empty($vc_listado)) { ?>
      <div class="container">
        <div class="section-title">
          <h2>novedades</h2>
        </div>
        <div class="row">
          <?php foreach ($vc_listado as $ult) { ?>
            <?php item_entrada($ult) ?>
          <?php } ?>
        </div>
      </div>
    <?php } ?>

  </section>

  <?php include 'includes/footer.php' ?>

</body>

</html>