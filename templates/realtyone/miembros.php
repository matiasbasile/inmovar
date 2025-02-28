<?php include "includes/init.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <?php include 'includes/head.php' ?>
</head>

<body>

  <?php 
  $menu_active = "miembros";
  include 'includes/header.php' ?>

  <section class="small-banner">
    <div class="container">
      <h2>Miembros</h2>
    </div>
  </section>  

  <?php $empresas = $web_model->get_empresas(); ?>

  <section class="miembros last-news pt0">
    <section class="properties listing-details3 pb15">
      <div class="container">
        <div class="sort">
          <div class="inner-text">
            <h4>miembros</h4>
            <p><strong><?php echo sizeof($empresas) ?></strong> Miembros </p>
          </div>
          <!--
          <div class="right-text">
            <p>Ordenar por</p>
            <select class="form-select form-control" aria-label="Default select example">
              <option selected="">Últimos ingresos</option>
              <option value="1">Últimos ingresos</option>
              <option value="2">Últimos ingresos</option>
              <option value="3">Últimos ingresos</option>
            </select>
          </div>
          -->
        </div>
      </div>
    </section>

    <?php if (sizeof($empresas) > 0) { ?>
      <div class="container">
        <div class="row">
          <?php foreach ($empresas as $e) { ?>
            <?php item_miembros($e) ?>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
  </section>


  <?php include 'includes/footer.php' ?>

</body>

</html>