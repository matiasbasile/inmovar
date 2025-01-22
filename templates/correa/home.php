<?php include "includes/init.php" ?>
<?php $page_act = "home" ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?php include "includes/head.php" ?>
</head>
<body>

	<?php include "includes/header.php"  ?>

	<!-- Banner Section -->
	<?php $slides = $web_model->get_slider()?>
	<section class="banner">
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<?php $x=0;foreach ($slides as $s) { ?>
					<div class="carousel-item <?php echo ($x==0)?"active":"" ?>" style="background: url(<?php echo $s->path ?>) no-repeat 50% 0; background-size: cover;"></div>
					<?php $x++; } ?>
					<ol class="carousel-indicators">
						<?php $x=0; foreach ($slides as $s) {  ?>
							<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $x ?>" class="<?php echo ($x==0)?"active":"" ?>"></li>
							<?php $x++; }?>
						</ol>
					</div>
				</div>
				<div class="carousel-caption">
					<form onsubmit="filtrar()" id="form_propiedades" >
						<div class="row">
							<div class="col-xl-3 col-md-6">
								<?php $tipos_op = $propiedad_model->get_tipos_operaciones()?>
								<select class="form-control" id="tipo_operacion">
									<option value="todas">Tipo de Operación</option>
									<?php foreach ($tipos_op as $tp) {  ?>
										<option value="<?php echo $tp->link ?>"><?php echo $tp->nombre ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-xl-3 col-md-6">
								<?php $tipos_prop = $propiedad_model->get_tipos_propiedades()?>
								<select class="form-control" id="tp" name="tp">
									<option value="todas">Tipo de Propiedad</option>
									<?php foreach ($tipos_prop as $tp) {  ?>
										<option value="<?php echo $tp->id ?>"><?php echo $tp->nombre ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-xl-4 col-md-6">
								<?php $localidades = $propiedad_model->get_localidades()?>
								<select class="form-control" id="localidad">
									<option value="todas">Localidades</option>
									<?php foreach ($localidades as $tp) {  ?>
										<option value="<?php echo $tp->link ?>"><?php echo $tp->nombre ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-xl-2 col-md-6">
								<button type="submit" class="btn btn-secoundry">Buscar</button>
							</div>
						</div>
					</form>
				</div>
			</section>

			<!-- Product Listing -->
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
							<?php } ?>
						</div>
					</div>
				</section>

<!-- Footer -->
<?php include "includes/footer.php" ?>

</body>
</html>