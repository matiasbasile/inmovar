<?php 
include 'includes/init.php';
include 'includes/inversiones/item.php';
$propiedades = $propiedad_model->get_list(array(
  "link_tipo_operacion"=>"inversiones",
  "orden_default"=>8
));
$total_resultados = $propiedad_model->get_total_results();
?>
<!DOCTYPE html>
<html lang="es" >
<head>
  <?php include 'includes/head.php'; ?>
</head>
<body>

<?php 
$menu_active = "inversiones";
include 'includes/header.php'; ?>

  <section class="small-banner">
    <div class="container">
      <h2>inversiones</h2>
    </div>
  </section>

  <section class="properties listing-details3">
  <div class="container">
    <div class="sort">
      <div class="inner-text">
        <h4>inversiones</h4>
        <p><strong><?php echo $total_resultados ?></strong> Propiedades </p>
      </div>
      <div class="right-text">
        <p>Ordenar por</p>
        <select class="form-select form-control" aria-label="Default select example">
          <option selected>Últimos ingresos</option>
          <option value="1">Últimos ingresos</option>
          <option value="2">Últimos ingresos</option>
          <option value="3">Últimos ingresos</option>
        </select>
      </div>
    </div>
    <div class="investments">
      <div class="row">
        <?php foreach($propiedades as $r) { ?>
          <div class="col-lg-4 col-md-6">
            <?php item_inversiones($r) ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  </section>

  <?php include 'includes/footer.php'; ?>

</body>
</html>