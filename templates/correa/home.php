<?php include "includes/init.php" ?>
<?php $page_act = "home" ?>
<!DOCTYPE html>
<html dir="ltr" lang="es-AR">
<head>
	<?php include "includes/head.php" ?>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<?php include "includes/home/slider.php"; ?>

	<section class="product-listing">
		<div class="container">
			<div class="section-title">
				<h1>Propiedades Destacadas</h1>
			</div>
			<div class="row">
				<?php $propiedades = $propiedad_model->get_list(array("destacado"=>1,"offset"=>12))?>
				<?php foreach ($propiedades as $p) {   
					$link_propiedad = (isset($p->pertenece_red) && $p->pertenece_red == 1) ? mklink($p->link)."&em=".$p->id_empresa : mklink($p->link); ?>
					<div class="col-xl-4 col-lg-6 col-md-6">
						<div class="product-list-item">
							<div class="product-img">
								<a href="<?php echo ($p->link_propiedad) ?>"><img class="cover-home" src="<?php echo $p->imagen ?>" alt="Product"></a>
							</div>
							<div class="product-details">
								<h4><?php echo $p->nombre ?></h4>
									<h5>
										<?php echo $p->direccion_completa ?>
										<?php if (!empty($p->localidad)) { ?>
										&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo ($p->localidad); ?>
										<?php } ?>
									</h5>
									<ul>
										<li>
											<strong><?php echo $p->precio ?></strong>
										</li>
									</ul>
									<div class="average-detail">
										<?php if ($p->dormitorios != 0) {  ?><span><img src="assets/images/badroom-icon.png" alt="Badroom Icon"> <?php echo $p->dormitorios  ?></span><?php } ?>
										<?php if ($p->banios != 0) {  ?><span><img src="assets/images/shower-icon.png" alt="Shower Icon"> <?php echo $p->banios ?></span><?php  } ?>
										<?php if ($p->superficie_total != 0) {  ?>	<span><img src="assets/images/sqft-icon.png" alt="SQFT Icon"> <?php echo $p->superficie_total ?> m2</span><?php } ?>
									</div>
									<div class="btns-block">
										<a href="<?php echo ($p->link_propiedad) ?>" class="btn btn-secoundry">Ver Detalles</a>
										<a href="<?php echo ($p->link_propiedad) ?>#contacto_nombre" class="icon-box"></a>
										<a href="#0" onclick="llenar_id(<?php echo $p->id ?>)" data-toggle="modal" data-target="#exampleModalCenter" class="icon-box whatsapp-box"></a>
									</div>
								</div>
							</div>
						</div>
						<?php $modales[] = $p; ?>
					<?php } ?>
				</div>
			</div>
		</section>

<!-- Footer -->
<?php include "includes/footer.php" ?>

</body>
</html>