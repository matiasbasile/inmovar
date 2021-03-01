<?php include "includes/init.php" ?>
<!DOCTYPE html>
<html>
<head>
	<?php include "includes/head.php" ?>
</head>
<body>
	<?php include "includes/header.php" ?>
	<?php $slides = $web_model->get_slider() ?>
	<?php foreach ($slides as $s) {  ?>
		<section id="home">	
			<div class="jumbotron paral paralsec" style='background-image: url("<?php echo $s->path ?>");'>
				<div class="container">
					<div class="display-3">
						<h1><?php echo $s->linea_1 ?></h1>
						<div class="text-center">
							<div class="row iconos-slider-home">
								<div class="inline-icons-search">
									<div class="col-md-3"></div>
									<?php $emp = $propiedad_model->get_list(array("ids_tipo_operacion"=>5))?>
									<div class="col-md-<?php echo (sizeof($emp) > 0)?"2":"3" ?> icon-home border-right">
										<input type="radio" checked value="todas" style="display: none" name="" class="MyCheck">
										<div class="my-custom-input-label-box box-four">
											<input style="display: none" id="myInput" type="radio" value="ventas" class="MyCheck" id="tipo_operacion" />
											<label for="myInput">Ventas</label>
										</div>
									</div>
									<div class="col-md-<?php echo (sizeof($emp) > 0)?"2":"3" ?> icon-home <?php echo (sizeof($emp) > 0)?"border-right":"" ?>">
										<div class="my-custom-input-label-box box-five">
											<input style="display: none" id="myInput2" type="radio" value="alquileres" class="MyCheck" id="tipo_operacion" />
											<label for="myInput2">Alquileres</label>
										</div>
									</div>
									<?php if (sizeof($emp) > 0) {  ?>
										<div class="col-md-2 icon-home">
											<div class="my-custom-input-label-box box-three">
												<input style="display: none" id="myInput3" type="radio" value="emprendimientos" class="MyCheck" id="tipo_operacion" />
												<label for="myInput3">Emprendimientos</label>
											</div>
										</div>
									<?php } ?>
									<div class="col-md-3"></div>
								</div>

								<div class="home-form">
									<div class="row form-inputs">
										<div class="col-xs-12 col-md-5">
											<label>Elije una ciudad</label>
											<?php $localidades = $propiedad_model->get_localidades(); ?>
											<select class="my-select" id="localidad">
												<option value="todas">Todas</option>
												<?php foreach ($localidades as $t) {  ?>
													<option value="<?php echo $t->link ?>" <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $t->link) ? "selected" : "" ?>><?php echo $t->nombre ?></option>
												<?php } ?>
											</select>	
										</div>
										<div class="col-xs-12 col-md-5">
											<label>Elije una propiedad</label>
											<select class="my-select" id="tp">
												<?php $tipos_propiedad = $propiedad_model->get_tipos_propiedades()?>
												<option value="">Todas</option>
												<?php foreach ($tipos_propiedad as $t) {  ?>
													<option value="<?php echo $t->id ?>" <?php echo (isset($vc_link_tipo_inmueble) && $vc_link_tipo_inmueble == $t->link) ? "selected" : "" ?>><?php echo $t->nombre ?></option>
												<?php } ?>
											</select>	
										</div>
										<div class="col-xs-12 col-md-2">
											<button onclick="onsubmit_buscador_propiedades()" class="btn-yellow">BUSCAR</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</section>
	<?php } ?>

	<section class="sec-pad flexed-property">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center sec-title">
					<?php $t = $web_model->get_text("sec-title-1","Propiedades")?>
					<h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
						<?php echo $t->plain_text?>
					</h2>
					<?php $t = $web_model->get_text("sec-text-1","Peugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent")?>
					<p class="editable mb40" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
						<?php echo $t->plain_text?>
					</p>
				</div>
				<?php $propiedades = $propiedad_model->get_list(array("offset"=>6,"destacado"=>1))?>
				<?php if (!empty($propiedades)) {  ?>
					<div class="clearfix" id="overlay">
						<div class="row">
								<div class="clearfix">
									<div class="row">
										<?php $x=1; foreach ($propiedades as $p) {  ?>
											<?php if ($x < 5) {  ?>
												<div class="home-styled col-md-4 col-xs-12">
												<div class="item-grid m0">
													<div class="image">
														<a href="<?php echo mklink ($p->link) ?>">
															<img class="cover" src="/admin/<?php echo $p->path ?>">
														</a>
														<span class="price"><?php echo ($p->precio_final != 0)?$p->precio:"Consultar"?></span>
														<span class="label"><?php echo $p->tipo_operacion ?></span>
														<span class="id"><?php echo $p->tipo_inmueble ?><br><?php echo $p->direccion_completa." ".$p->localidad?></span>
													</div>
												</div>	
											</div>
										<?php } ?>
										<?php $x++; } ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</section>


			<section class="sec-pad back-grey">
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center sec-title">
							<?php $t = $web_model->get_text("sec-title-2","Propiedades Destacadass")?>
							<h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<?php echo $t->plain_text?>
							</h2>
							<?php $t = $web_model->get_text("sec-text-2","Peugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent")?>
							<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<?php echo $t->plain_text?>
							</p>
						</div>
					</div>
					<div class="row text-center">
						<div class="col-md-4 choose">
							<div><img src="img/home-process-img-1.png"></div>
							<?php $t = $web_model->get_text("choose-1","Choose")?>
							<h5 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<?php echo $t->plain_text ?>
							</h5>
							<?php $t = $web_model->get_text("choose-1","Feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent")?>
							<div class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<?php echo $t->plain_text ?>
							</div>
						</div>
						<div class="col-md-4 choose">
							<div><img src="img/home-process-img-2.png"></div>
							<?php $t = $web_model->get_text("choose-2","Choose")?>
							<h5 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<?php echo $t->plain_text ?>
							</h5>
							<?php $t = $web_model->get_text("choose-2","Feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent")?>
							<div class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<?php echo $t->plain_text ?>
							</div>
						</div>
						<div class="col-md-4 choose">
							<div><img src="img/home-process-img-3.png"></div>
							<?php $t = $web_model->get_text("choose-3","Choose")?>
							<h5 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<?php echo $t->plain_text ?>
							</h5>
							<?php $t = $web_model->get_text("choose-3","Feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent")?>
							<div class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<?php echo $t->plain_text ?>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="sec-pad">
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center sec-title">
							<?php $t = $web_model->get_text("sec-title-3","Últimas Propiedades")?>
							<h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<?php echo $t->plain_text?>
							</h2>
							<?php $t = $web_model->get_text("sec-text-3","Peugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent")?>
							<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<?php echo $t->plain_text?>
							</p>
						</div>
					</div>
					<div class="row mt30" id="ultimas">
						<?php $propiedades = $propiedad_model->get_list(array("offset"=>8))?>
						<?php foreach ($propiedades as $p) {  ?>
							<div class="col-md-3 col-xs-12 item-grid">
								<div class="image">
									<a href="<?php echo mklink ($p->link) ?>">
										<img class="cover" src="/admin/<?php echo $p->path ?>">
									</a>
									<span class="price"><?php echo ($p->precio_final != 0)?$p->precio:"Consultar"?></span>
									<span class="label"><?php echo $p->tipo_operacion ?></span>
									<span class="id">COD <?php echo $p->codigo ?></span>
								</div>
								<div class="info">
									<a href="<?php echo mklink ($p->link) ?>">
										<h5 class="title"><?php echo $p->nombre ?></h5>
									</a>
									<?php if (!empty($p->direccion_completa)) {  ?><div class="address"><?php echo $p->direccion_completa.". ".$p->localidad?></div><?php } ?>
									<?php if (!empty($p->superficie_total)) {  ?><div class="property-data"><i class="fa fa-home"></i> <?php echo $p->superficie_total ?>m2 Sup. Total.</div><?php } ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</section>
		<!-- <section class="jumbotron paral paralsec" style='background-image: url("img/home-parallax-2.png");'>
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center sec-title">
						<?php $t = $web_model->get_text("sec-title-4","Propiedades Destacadass")?>
						<h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
							<?php echo $t->plain_text?>
						</h2>
						<?php $t = $web_model->get_text("sec-text-4","Peugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent")?>
						<p class="editable black" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
							<?php echo $t->plain_text?>
						</p>
					</div>
				</div>
				<div class="row testimonials">
					<div class="owl-carousel owl-theme">
						<div class="item">
							<div><img src="img/h1-testimonials-4.png"></div>
							<div class="text">"Lorem ipsum dolor sit amet, atqui sanctus delectus in duo. Purto fuisset sed esto dislexe trompus tateim..."</div>
						</div>
					</div>
				</div>	
			</div>
		</section> -->
		<?php include "includes/footer.php" ?>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/owl.carousel.min.js"></script>
		<script type="text/javascript">
			$('.owl-carousel').owlCarousel({
				loop:true,
				margin:10,
				nav:true,
				responsive:{
					0:{
						items:1
					},
					600:{
						items:2
					},
					1000:{
						items:2
					}
				}
			})

// ===== Scroll to Top ==== 
$(window).scroll(function() {
if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
$('#return-to-top').fadeIn(200);    // Fade in the arrow
} else {
$('#return-to-top').fadeOut(200);   // Else fade out the arrow
}
});
$('#return-to-top').click(function() {      // When arrow is clicked
	$('body,html').animate({
scrollTop : 0                       // Scroll to top of body
}, 500);
});
</script>
<script type="text/javascript">
	$('.MyCheck').on('change', function() {
		$('.MyCheck').not(this).prop('checked', false);
	});
</script>
<script type="text/javascript">
	/* Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu / bar icon */
	function myFunction() {
		var x = document.getElementById("myLinks");
		if (x.style.display === "block") {
			x.style.display = "none";
		} else {
			x.style.display = "block";
		}
	}

	function onsubmit_buscador_propiedades() { 
		var link = "<?php echo mklink("propiedades/")?>";
		var tipo_operacion = $('input[type="radio"]:checked').val();
		var localidad = $("#localidad").val();
		var tp = $('#tp').val();
		link = link + tipo_operacion + "/" + localidad + "/?tp="+ tp;
		location.href = link;
	}
</script>

</body>
</html>