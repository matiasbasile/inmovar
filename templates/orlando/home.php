<?php include "includes/init.php" ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?php include "includes/head.php" ?>
</head>
<body>

	<!-- Header -->
	<?php include "includes/header.php" ?>

	<!-- Top Banner -->
	<?php $slide = $web_model->get_slider()?>
	<div class="top-banner">
		<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<?php $x=1; foreach ($slide as $s) { ?>
					<div class="carousel-item <?php echo ($x==1)?"active":""?>">
						<img class="d-block w-100" src="<?php echo $s->path ?>" alt="First slide">
						<div class="slider-caption">
							<div class="container">
								<h1><?php echo $s->linea_1 ?> <br><?php echo $s->linea_2?> </h1>
								<ul class="nav nav-tabs">
									<li><a class="ventas active" data-toggle="tab" href="#ventas">Ventas</a></li>
									<li><a class="alquileres" data-toggle="tab" href="#alquiler">Alquiler</a></li>
									<li><a class="emprendimientos" data-toggle="tab" href="#emprendimientos">Emprendimientos</a></li>
								</ul>
								<div class="tab-content">
									<div id="ventas" class="tab-pane fade in active">
										<form id="form_propiedades" onsubmit="enviar_buscador_propiedades()">
											<input type="hidden" id="tipo_operacion" value="ventas" name="">
											<div class="row">
												<div class="col-md-4 bg-white">
													<?php $localidades = $propiedad_model->get_localidades(); ?>
													<select class="form-control" id="localidad">
														<option value="todas">Localidades</option>
														<?php foreach ($localidades as $t) {  ?>
															<option value="<?php echo $t->link ?>"><?php echo $t->nombre ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col-md-5 bg-white">
													<?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
													<select class="form-control" name="tp">
														<option value="0">Tipos propiedades</option>
														<?php foreach ($tipos_propiedades as $t) {  ?>
															<option value="<?php echo $t->id ?>"><?php echo $t->nombre ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col-md-3">
													<button type="submit" class="btn btn-red">Buscar</button>
												</div>
											</div>
											<div class="radiobuttons">
												<div class="rdio rdio-primary radio-inline"> 
													<input name="tipo_busqueda"checked value="lista" id="radio1" type="radio">
													<label for="radio1">Vista en lista</label>
												</div>
												<div class="rdio rdio-primary radio-inline">
													<input name="tipo_busqueda" value="mapa" id="radio2" type="radio">
													<label for="radio2">Vista en mapa</label>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php $x++; } ?>
				</div>
			</div>  
		</div>


		<!-- Featured Properties -->
		<?php $destacados = $propiedad_model->get_list(array("destacado"=>1,"solo_propias"=>1))?>
		<?php if (!empty($destacados)) {  ?>
			<div class="featured-properties" id="destacados">
				<div class="container">
					<h2 class="section-title">propiedades destacadas</h2>
					<div id="carouselExampleControls1" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
							<?php $x=1;foreach ($destacados as $d) {  ?>
								<div class="carousel-item <?php echo ($x==1)?"active":"" ?>">
									<div class="property-box">
										<div class="property-img">
											<span><img src="assets/images/logo2.png" alt="Logo"> <?php echo $d->tipo_operacion ?></span>
											<img class="cover-destacado" src="<?php echo $d->imagen ?>" alt="Property Img">
										</div>
										<div class="property-details" style="min-height: 402px">
											<div class="property-top">
												<h3><?php echo $d->nombre ?></h3>
												<p><?php echo substr(strip_tags($d->texto),0,200);echo (strlen($d->texto)>200)?"...":"" ?>	</p>
											</div>
											<div class="property-middle-top">
												<h3 class="direccion-completa"><?php echo $d->direccion_completa ?></h3>
												</div>
											<div class="property-middle">
												<ul>
													<li><img src="assets/images/home.png" alt="Home"> <?php echo (!empty($d->superficie_total))?$d->superficie_total." ":"-" ?> </li>
													<li><img src="assets/images/beds.png" alt="Beds"> <?php echo (!empty($d->dormitorios))?$d->dormitorios:"-" ?></li>
													<li><img src="assets/images/washroom.png" alt="Washroom"> <?php echo (!empty($d->banios))?$d->banios:"-" ?></li>
													<li><img src="assets/images/parking.png" alt="Parking"> <?php echo (!empty($d->cocheras))?$d->cocheras:"-" ?></li>
												</ul>
											</div>
											<div class="property-bottom">
												<span><?php echo $d->precio ?></span>
												<a class="btn btn-red" href="<?php echo ($d->link_propiedad) ?>">ver más <img src="assets/images/play.png" alt="Play"></a>
											</div>
										</div>
									</div>
								</div>
								<?php $x++; } ?>
							</div>  
							<div class="owl-nav">
								<a class="carousel-control-prev owl-next" href="#carouselExampleControls1" role="button" data-slide="prev">
								</a>
								<a class="carousel-control-next owl-prev" href="#carouselExampleControls1" role="button" data-slide="next">
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php }   ?>

			<!-- Our Services -->
			<?php $t = $web_model->get_text("slider_dos!","assets/images/services-bg.jpg")?>
			<div class="our-services editable editable-img" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" style="background: url(<?php echo $t->plain_text?>) no-repeat  0 0;background-size: cover" data-width="1600" data-height="480">
				<div class="container">
					<div class="row">
						<div class="col-lg-4">
							<div class="service-item">
								<span class="icon-box"></span>
								<?php $tit = $web_model->get_text("ventasssss-tit","Ventas")?>
								<h4 onclick="window.location.href='<?php echo $tit->link ?>'"  class="editable pointer" data-id="<?php echo $tit->id ?>" data-clave="<?php echo $tit->clave ?>">
									<?php echo $tit->plain_text ?>
								</h4>
								<?php $t = $web_model->get_text("ventas-text","Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's")?>
								<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
									<?php echo $t->plain_text ?>
								</p>
								<div onclick="window.location.href='<?php echo $tit->link ?>'" class="stretched-link play-icon pointer-rel"></div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="service-item alquileres">
								<span class="icon-box"></span>
								<?php $tit = $web_model->get_text("alqui-tit","Alquileres")?>
								<h4 onclick="window.location.href='<?php echo $tit->link ?>'" class="editable pointer" data-id="<?php echo $tit->id ?>" data-clave="<?php echo $tit->clave ?>">
									<?php echo $tit->plain_text ?>
								</h4>
								<?php $t = $web_model->get_text("alqui-text","Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's")?>
								<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
									<?php echo $t->plain_text ?>
								</p>
								<div onclick="window.location.href='<?php echo $tit->link ?>'" class="stretched-link play-icon pointer-rel"></div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="service-item emprendimientos">
								<span class="icon-box"></span>
								<?php $tit = $web_model->get_text("empre-tit","Emprendimientos")?>
								<h4 class="editable pointer" onclick="window.location.href='<?php echo $tit->link ?>'"  data-id="<?php echo $tit->id ?>" data-clave="<?php echo $tit->clave ?>">
									<?php echo $tit->plain_text ?>
								</h4>
								<?php $t = $web_model->get_text("empr-text","Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's")?>
								<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
									<?php echo $t->plain_text ?>
								</p>
								<div onclick="window.location.href='<?php echo $tit->link ?>'" class="stretched-link play-icon pointer-rel	"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Featured Properties -->
			<?php $propiedades = $propiedad_model->get_list(array("offset"=>6))?>
			<?php if (!empty($propiedades)) {  ?>
				<div class="featured-properties list-wise">
					<div class="container">
						<h2 class="section-title">agregadas recientemente</h2>
						<div class="owl-carousel" data-items="3" data-margin="32" data-loop="true" data-nav="true" data-dots="false">
							<?php foreach ($propiedades as $p) {  ?>
								<div class="item">
									<div class="property-box">
										<div class="property-img">
											<img class="cover-recientes" src="<?php echo $p->imagen ?>" alt="Property Img">
											<div class="rollover">
												<a href="<?php echo ($p->link_propiedad) ?>" class="add"></a>
												<?php if (estaEnFavoritos($p->id)) { ?>
													<a class="heart" data-bookmark-state="added" href="/admin/favoritos/eliminar/?id=<?php echo $p->id; ?>">
													</a>
												<?php } else { ?>
													<a class="heart" data-bookmark-state="empty" href="/admin/favoritos/agregar/?id=<?php echo $p->id; ?>">
													</a>
												<?php } ?>
											</div>
										</div>
										<div class="property-details">
											<div class="property-top">
												<h3><?php echo $p->nombre ?></h3>
											</div>
											<div class="property-middle-top">
												<h3 class="direccion-completa"><?php echo $p->direccion_completa ?></h3>
											</div>
											<div class="property-middle">
												<ul>
													<?php if ($p->superficie_total != 0) {  ?>
														<li><img src="assets/images/home.png" alt="Home"> <?php echo $p->superficie_total ?> </li>
													<?php } ?>
													<?php if (!empty($p->dormitorios)) {  ?>
														<li><img src="assets/images/beds.png" alt="Beds"> <?php echo $p->dormitorios ?></li>
													<?php } ?>
													<?php if (!empty($p->cocheras)) {  ?>
														<li><img src="assets/images/parking.png" alt="Parking"> <?php echo $p->cocheras ?></li>
													<?php } ?>
												</ul>
											</div>
											<div class="property-bottom">
												<span><?php echo $p->precio ?></span>
												<a class="btn btn-red" href="<?php echo ($p->link_propiedad) ?>">ver más</a>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>

			<!-- Call To Action -->
			<?php include "includes/comunicate.php" ?>

			<!-- Featured Cities -->
			<div class="featured-cities text-center">
				<div class="container">
					<?php $t = $web_model->get_text("ciudades-titt","Ciudades Destacadas")?>
					<h2 class="section-title" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
						<?php echo $t->plain_text ?>
					</h2>
					<?php $t = $web_model->get_text("ciudades-text","Conocé las propiedades de cada ciudad que tenemos para ofrecerte")?>
					<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
						<?php echo $t->plain_text ?>
					</p>
					<div class="row">
						<div class="col-lg-4 col-md-6">
							<?php $t = $web_model->get_text("img-1-path","assets/images/property-img7.png")?>
							<div class="featured-list-item editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<img src="<?php echo $t->plain_text ?>" alt="Property Img">
								<div class="rollover">
									<?php $t = $web_model->get_text("img-1-texto-1","La Plata")?>
									<div onclick="window.location.href='<?php echo $t->link ?>'" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable stretched-link onclick"><?php echo $t->plain_text ?></div>
									<span onclick="window.location.href='<?php echo $t->link ?>'" class="onclick-span">Ver Más</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<?php $t = $web_model->get_text("img-2-path","assets/images/property-img8.png")?>
							<div class="featured-list-item editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<img src="<?php echo $t->plain_text ?>" alt="Property Img">
								<div class="rollover">
									<?php $t = $web_model->get_text("img-2-texto-2","City Bell")?>
									<div onclick="window.location.href='<?php echo $t->link ?>'" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable stretched-link onclick"><?php echo $t->plain_text ?></div>
									<span onclick="window.location.href='<?php echo $t->link ?>'" class="onclick-span">Ver Más</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<?php $t = $web_model->get_text("img-3-path","assets/images/property-img9.png")?>
							<div class="featured-list-item editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<img src="<?php echo $t->plain_text ?>" alt="Property Img">
								<div class="rollover">
									<?php $t = $web_model->get_text("img-3-texto-3","Villa Elisa")?>
									<div onclick="window.location.href='<?php echo $t->link ?>'" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable stretched-link onclick"><?php echo $t->plain_text ?></div>
									<span onclick="window.location.href='<?php echo $t->link ?>'" class="onclick-span">Ver Más</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<?php $t = $web_model->get_text("img-4-path","assets/images/property-img10.png")?>
							<div class="featured-list-item editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<img src="<?php echo $t->plain_text ?>" alt="Property Img">
								<div class="rollover">
									<?php $t = $web_model->get_text("img-4-texto-4","Pinamar")?>
									<div onclick="window.location.href='<?php echo $t->link ?>'" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable stretched-link onclick"><?php echo $t->plain_text ?></div>
									<span class="onclick-span" onclick="window.location.href='<?php echo $t->link ?>'">Ver Más</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<?php $t = $web_model->get_text("img-5-path","assets/images/property-img11.png")?>
							<div class="featured-list-item editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<img src="<?php echo $t->plain_text ?>" alt="Property Img">
								<div class="rollover">
									<?php $t = $web_model->get_text("img-5-texto-5","Hudson")?>
									<div onclick="window.location.href='<?php echo $t->link ?>'" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable stretched-link onclick"><?php echo $t->plain_text ?></div>
									<span onclick="window.location.href='<?php echo $t->link ?>'" class="onclick-span">Ver Más</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<?php $t = $web_model->get_text("img-6-path","assets/images/property-img12.png")?>
							<div class="featured-list-item editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<img src="<?php echo $t->plain_text ?>" alt="Property Img">
								<div class="rollover">
									<?php $t = $web_model->get_text("img-6-texto-6","Mar Del Plata")?>
									<div onclick="window.location.href='<?php echo $t->link ?>'" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable stretched-link onclick"><?php echo $t->plain_text ?></div>
									<span class="onclick-span" onclick="window.location.href='<?php echo $t->link ?>'">Ver Más</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Latest News -->
<!-- <div class="latest-news list-wise">
  <div class="container">
    <h2 class="section-title">últimas noticias</h2>
    <div class="owl-carousel" data-items="3"  data-margin="32" data-loop="true" data-nav="true" data-dots="false">
      <div class="item">
        <div class="property-box">
            <div class="property-img">
              <img src="assets/images/property-img4.png" alt="Property Img">
            </div>
            <div class="property-details">
              <div class="property-top">
                <h3>Título de Noticia 1</h3>
              </div>
              <div class="property-middle">
                <ul>
                  <li><img src="assets/images/calendar-icon.png" alt="Calendar"> 10/10/2018</li>
                  <li><img src="assets/images/clock-icon.png" alt="Clock"> 20:45 Hs.</li>
                </ul>
              </div>
              <div class="property-bottom">
                <a class="btn btn-red" href="#0"><img src="assets/images/btn-arrow.png" alt="Arrow"></a>
              </div>
            </div>
          </div>
      </div>
      <div class="item">
        <div class="property-box">
            <div class="property-img">
              <img src="assets/images/property-img5.png" alt="Property Img">
            </div>
            <div class="property-details">
              <div class="property-top">
                <h3>Título de Noticia 1</h3>
              </div>
              <div class="property-middle">
                <ul>
                  <li><img src="assets/images/calendar-icon.png" alt="Calendar"> 10/10/2018</li>
                  <li><img src="assets/images/clock-icon.png" alt="Clock"> 20:45 Hs.</li>
                </ul>
              </div>
              <div class="property-bottom">
                <a class="btn btn-red" href="#0"><img src="assets/images/btn-arrow.png" alt="Arrow"></a>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div> -->

<!-- Footer -->
<?php include "includes/footer.php" ?>

<!-- Back To Top -->
<div class="back-to-top"><a href="javascript:void(0);" aria-label="Back to Top">&nbsp;</a></div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/html5.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="assets/js/scripts.js"></script>
<script type="text/javascript">
	if (jQuery(window).width()>767) { 
		$(document).ready(function(){
			var maximo = 0;
			$(".list-wise .property-details h3").each(function(i,e){
				if ($(e).height() > maximo) maximo = $(e).height();
			});
			maximo = Math.ceil(maximo);
			$(".list-wise .property-details h3").height(maximo);
		});
	}
</script>
<script type="text/javascript">
	function enviar_buscador_propiedades() { 
		if ($(".emprendimientos").hasClass('active'))  {
			filtro = "emprendimientos";
		}
		if ($(".ventas").hasClass('active'))  {
			filtro = "ventas";
		}
		if ($(".alquileres").hasClass('active'))  {
			filtro = "alquileres";
		}


		var link = "";
		if ($("input[type=radio]:checked").val() == "lista") {
			link = "<?php echo mklink("propiedades/")?>";
		} else {
			link = "<?php echo mklink("mapa/")?>";
		}
		var localidad = $("#localidad").val();
		link = link + filtro + "/" + localidad + "/";
		$("#form_propiedades").attr("action",link);
		return true;
	}
</script>
</body>
</html>