<?php 
include 'includes/init.php';
$vc_listado = $propiedad_model->favoritos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include("includes/head.php") ?>
</head>
<body>

  <?php include("includes/header.php") ?>

<section class="page-title">
  <div class="container">
    <h1><?php 
      echo ($empresa->id == ID_EMPRESA_LA_PLATA) ? "La Plata" : "Punta del Este";
    ?></h1>
  </div>
</section>

<?php include("includes/propiedad/buscador.php") ?>

<!-- Properties Details  -->
<section class="properties-details">
  <div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="properties">
				<div class="sort">
					<div class="inner-text">
						<h4>Favoritos</h4>
					</div>
				</div>
        
        <div class="row">
          <?php foreach ($vc_listado as $p) { ?>
            <div class="col-lg-4 col-md-6">
              <?php propiedad_item($p); ?>
            </div>
          <?php } ?>
        </div>

			</div>			
		</div>
	</div>
</div>
</section>

<?php include("includes/footer.php") ?>

</body>
</html>