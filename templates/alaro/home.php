<?PHP include "includes_nuevo/init.php";
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); ?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?PHP include "includes_nuevo/head.php" ?>
</head>
<body class="loading">

	<!-- HEADER -->
	<?PHP include "includes_nuevo/header.php" ?>


	<!-- swiper container, fadeslides, keyboard -->
	<?php $slides = $web_model->get_slider(array("clave"=>"slider_1"))?>
	<section class="swiper-container fadeslides keyboard" data-autoplay="true">
		<div class="swiper-wrapper">
			<?php foreach ($slides as $s) {  ?>
				<div class="swiper-slide" style="background: url(<?php echo $s->path ?>); background-size: cover">
					<div class="heading-wrap">
						<div class="table-container">
							<div class="align-container">
								<div class="container">
									<div class="slide-caption">
										<div class="sub-heading"><?php echo $s->linea_1 ?></div>
										<div class="heading"><?php echo $s->linea_2 ?></div>
										<p><?php echo $s->linea_3 ?></p>
										<?php if (!empty($s->link_1)) {  ?>
											<div class="clearfix">
												<a class="btn btn-black" href="<?php echo $s->link_1 ?>"><?php echo $s->texto_link_1 ?></a>
												<?php if (!empty($s->link_2)) {  ?><a class="btn btn-red" href="<?php echo $s->link_2 ?>"><?php echo $s->texto_link_2 ?></a><?php } ?>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
  <!--	<div class="swiper-button-prev"></div>
  	<div class="swiper-button-next"></div> -->
  	<div class="swiper-pagination"></div>
  </section>

  <!-- ON GOING PROJECTS-->
  <div class="ongoing-projects">
  	<div class="container">
  		<div class="title-wrap">
  			<div class="section-title">
  				<?php $t = $web_model->get_text("primer-bloque-subtit","Edificios en Desarrollo")?>
  				<span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  					<?php echo $t->plain_text ?>
  				</span>
  				<?php $t = $web_model->get_text("primer-bloque-tit","Edificios en construcción")?>
  				<h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  					<?php echo $t->plain_text ?>
  				</h2>
  				<?php $t = $web_model->get_text("primer-bloque-txt","Lorem Ipsum is simply dummy text of the printing and typesetting industry has  industry been the industry's.")?>
  				<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  					<?php echo $t->plain_text ?>
  				</p>
  			</div>
				<?php $t = $web_model->get_text("primer-bloque-link","ver todos")?>
  			<a class="btn btn-red editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" href="<?php echo $t->link ?>"><?php echo $t->plain_text ?><img src="assets_nuevo/images/btn-arrow.png" alt="Arrow"></a>
  		</div>
  	</div>
  	<div class="on-going" id="on-going"> 
  		<?php 
  		  $config["id_tipo_operacion"] = 6;
				$en_construccion_result = $propiedad_model->get_list($config);
				foreach($en_construccion_result as $p) { 
			?>
				<div class="feature-item">
	  			<div class="feature-image"> <a class="principal" href="<?php echo mklink ($p->link) ?>"><img src="/sistema/<?php echo $p->path?>" alt="Product" /></a>
	  				<?php if (!empty($p->etiquetas)) {  ?>
		  				<div class="label-text"><?php foreach ($p->etiquetas as $etiq) { echo $etiq->nombre ; } ?></div>
		  			<?php } ?>
	  				<div class="overlay-info">
	  					<div class="center-content">
	  						<div class="align-center">
	  							<div class="center-title">
	  								<h3><?php echo $p->nombre ?></h3>
	  								<span><?php echo $p->calle ?><br>
                        <?php echo $p->localidad ?></span>
	  							</div>
	  							<div class="btn-block"><a href="<?php echo mklink ($p->link) ?>"><img src="assets_nuevo/images/plus-icon.png"><span>ver proyecto</span></a></div>
	  						</div>
	  					</div>
	  				</div>
	  			</div>
	  		</div>
	  	<?php } ?>
  	</div>
  </div>

  <div class="counter-section">
  	<div class="container">
  		<div class="row">
  			<div class="col-md-2">
  				<div class="item">
  					<img src="assets_nuevo/images/icon01.png" alt="icon">
  					<?php $t = $web_model->get_text("counter1","28")?>
  					<span class="counter editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>"><?php echo $t->plain_text ?></span>
  					<?php $t = $web_model->get_text("counter1text","Edificios <br>Terminados")?>
  					<span class="counter-title editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  						<?php  echo $t->plain_text ?>
  					</span>
  				</div>
  			</div>
  			<div class="col-md-2">
  				<div class="item">
  					<img src="assets_nuevo/images/icon02.png" alt="icon">
  					<?php $t = $web_model->get_text("counter2","11")?>
  					<span class="counter editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>"><?php echo $t->plain_text ?></span>
  					<?php $t = $web_model->get_text("counter2text","Edificios en Desarrollo")?>
  					<span class="counter-title editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  						<?php  echo $t->plain_text ?>
  					</span>
  				</div>
  			</div>
  			<div class="col-md-2">
  				<div class="item">
  					<img src="assets_nuevo/images/icon03.png" alt="icon">
  					<?php $t = $web_model->get_text("counter3","62000")?>
  					<span class="counter editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>"><?php echo $t->plain_text ?></span>
  					<?php $t = $web_model->get_text("counter3text","Metros Cuadrados Construidos")?>
  					<span class="counter-title editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  						<?php  echo $t->plain_text ?>
  					</span>
  				</div>
  			</div>
  			<div class="col-md-2">
  				<div class="item">
  					<img src="assets_nuevo/images/icono4.png" alt="icon">
  					<?php $t = $web_model->get_text("counter4","750")?>
  					<span class="counter editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>"><?php echo $t->plain_text ?></span>
  					<?php $t = $web_model->get_text("counter4text","Departamentos Entregados")?>
  					<span class="counter-title editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  						<?php  echo $t->plain_text ?>
  					</span>
  				</div>
  			</div>
  			<div class="col-md-2">
  				<div class="item">
  					<img src="assets_nuevo/images/icono5.png" alt="icon">
  					<?php $t = $web_model->get_text("counter5","70")?>
  					<span class="counter editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>"><?php echo $t->plain_text ?></span>
  					<?php $t = $web_model->get_text("counter5text","Casas <br>Terminadas")?>
  					<span class="counter-title editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  						<?php  echo $t->plain_text ?>
  					</span>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>

  <?php $destacados = $propiedad_model->get_list(array())?>
	 <?php if (!empty($destacados)) { ?>
    <div class="featured-departments">
	  	<div class="container">
	  		<div class="title-wrap style-two">
	  			<div class="section-title">
	  				<?php $t = $web_model->get_text("terminados-sub","Venta de terminados")?>
	  				<span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
	  					<?php echo $t->plain_text ?>
	  				</span>
	  				<?php $t = $web_model->get_text("terminados-tit","Departamentos destacados")?>
	  				<h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
	  					<?php echo $t->plain_text ?>
	  				</h2>
	  				<?php $t = $web_model->get_text("terminados-txt","Lorem Ipsum is simply dummy text of the printing and typesetting industry has <br>industry been the industry's.")?>
	  				<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
	  					<?php echo $t->plain_text ?>
	  				</p>
	  				<div class="gray-title">Destacados</div>
	  			</div>
	  		</div>
	  		<div class="row" id="destacados">
	  			<?php foreach ($destacados as $d) {  ?>
		  			<div class="col-md-4">
		  				<div class="feature-item">
		  					<div class="feature-image">
		  						<a href="<?php echo mklink ($d->link) ?>"><img src="/sistema/<?php echo $d->path ?>" alt="Product" /></a>
		  						<div class="label-text">ventas</div>
		  					</div>
		  					<div class="feature-info">
		  						<h3><?php echo $d->nombre ?></h3>
		  						<h4><?php echo ($d->precio_final !=0)?$d->moneda." ".$d->precio_final:"Consultar" ?></h4>
		  						<ul class="facilities">
		  							<?php if ($d->dormitorios != "0") {  ?><li><img src="assets_nuevo/images/icon06.png" alt="Icon"> <?php echo $d->dormitorios ?></li><?php } ?>
		  							<?php if ($d->banios != "0") {  ?><li><img src="assets_nuevo/images/icon07.png" alt="Icon"> <?php echo $d->banios?></li><?php } ?>
                    <?php if ($d->superficie_total != "0") {  ?><li><img src="assets_nuevo/images/icon08.png" alt="Icon"> <?php echo $d->superficie_total ?></li><?php } ?>
		  						</ul>
		  					</div>
		  					<div class="btn-block">
		  						<a class="btn btn-border" href="<?php echo mklink ($d->link) ?>">Más Información</a>
		  						<a class="btn btn-border email" href="<?php echo mklink ($d->link) ?>#contacto_nombre"><img src="assets_nuevo/images/email-icon.png" alt="Email"></a>
		  						<a class="btn btn-border whatsup" href="javascript:void(0)" onclick="llenar_id(<?php echo $p->id ?>)" data-toggle="modal" data-target="#exampleModalCenter"><img src="assets_nuevo/images/whatsup-icon.png" alt="Whatsup"></a>
		  					</div>
		  				</div>
		  			</div>
		  		<?php } ?>
	  		</div>
	  	</div>
	  </div>
  <?php } ?>
  <div class="alaro-buildings">
  	<div class="container">
  		<div class="title-wrap style-two">
  			<div class="section-title">
  				<?php $t = $web_model->get_text("seccion-edificios-sub","alaró edificios")?>
  				<span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  					<?php echo $t->plain_text ?>
  				</span>
  				<?php $t = $web_model->get_text("seccion-edificios-tit","¿Por qué confiar en nosotros?")?>
  				<h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  					<?php echo $t->plain_text ?>
  				</h2>
  				<?php $t = $web_model->get_text("seccion-edificios-txt","Somos una empresa dedicada al desarrollo de soluciones inmobiliarias sustentables <br>y de alta calidad, comprometidos con el futuro de las ciudades.")?>
  				<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  					<?php echo $t->plain_text ?>
  				</p>
  				<div class="gray-title">Nosotros</div>
  			</div>
  		</div>
  		<div class="row justify-content-center">
  			<div class="col-md-4">
  				<div class="item">
  					<div class="icon-wrap">
  						<span class="item-icon"></span>
  						<span class="check-icon"></span>
  					</div>
  					<?php $t = $web_model->get_text("confiar-1","Proyectos <br>Funcionales")?>
  					<h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  						<?php echo $t->plain_text ?>
						</h3>
  					<?php $t = $web_model->get_text("confiar-1-txt","Lorem Ipsum is simply dummy <br>text of the printing and typesetting.")?>
  					<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  						<?php echo $t->plain_text ?>
						</p>
  				</div>
  			</div>
  			<div class="col-md-4">
  				<div class="item">
  					<div class="icon-wrap">
  						<span class="item-icon"></span>
  						<span class="check-icon"></span>
  					</div>
  					<?php $t = $web_model->get_text("confiar-2","Modernas<br>Terminaciones")?>
  					<h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  						<?php echo $t->plain_text ?>
						</h3>
  					<?php $t = $web_model->get_text("confiar-2-txt","Lorem Ipsum is simply dummy <br>text of the printing and typesetting.")?>
  					<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  						<?php echo $t->plain_text ?>
						</p>
  				</div>
  			</div>
  			<div class="col-md-4">
  				<div class="item">
  					<div class="icon-wrap">
  						<span class="item-icon"></span>
  						<span class="check-icon"></span>
  					</div>
						<?php $t = $web_model->get_text("confiar-3","Equipo<br>Multidisciplinario")?>
  					<h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  						<?php echo $t->plain_text ?>
						</h3>
  					<?php $t = $web_model->get_text("confiar-3-txt","Lorem Ipsum is simply dummy <br>text of the printing and typesetting.")?>
  					<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
  						<?php echo $t->plain_text ?>
						</p>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>

	<?php $testimonios = $entrada_model->get_list(array("from_id_categoria"=>1633));?>
	<?php if (!empty($testimonios)) {  ?>
	  <div class="testimonial">
	  	<div class="container">
	  		<div class="title-wrap">
	  			<div class="section-title">
	  				<span>Testimonios</span>
	  				<h2>Que dicen nuestros clientes</h2>
	  				<p>Algunos testimonios registrados en Google de clientes satisfechos <br>por comprar en Alaró una propiedad.</p>
	  			</div>
	  		</div>
	  		<div class="slider-wrap"> 
	  			<?php foreach ($testimonios as $t) {  ?>
		  			<div class="item testimonio-igual">
		  				<div class="image-wrap">
		  					<span class="author-image">
		  						<img src="<?php echo $t->path ?>" alt="Image">
		  					</span>
		  					<img src="assets_nuevo/images/google.png" alt="Google">
		  				</div>
		  				<div class="item-content">
		  					<img class="quote-icon" src="assets_nuevo/images/quote-icon.png" alt="Quote Icon">
		  					<h3><?php echo $t->titulo ?></h3>
		  					<div class="reviews"><img src="assets_nuevo/images/review.png" alt="Review"></div>
		  					<p><?php echo $t->texto ?></p>
		  				</div>
		  			</div>
		  		<?php } ?>
	  		</div>
	  	</div>
	  </div>
	 <?php } ?>

  <!--FOOTER-->
  <div class="footer">
  	<div class="container">
  		<div class="row">
  			<div class="col-md-3">
  				<a href="<?php echo mklink ("/") ?>"><img src="assets_nuevo/images/logo2.png" alt="logo"></a>
  				<?php if (!empty($empresa->facebook) || !empty($empresa->instagram) || !empty($empresa->youtube)) {  ?>
						<ul class="socials">
							<?php if (!empty($empresa->facebook)) {  ?>
								<li><a href="<?php echo $empresa->facebook ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<?php } ?>
									<?php if (!empty($empresa->instagram)) {  ?>
								<li><a href="<?php echo $empresa->instagram ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							<?php } ?>
									<?php if (!empty($empresa->youtube)) {  ?>
								<li><a href="<?php echo $empresa->youtube ?>" target="_blank"><i class="fa fa-play" aria-hidden="true"></i></a></li>
							<?php } ?>
						</ul>
					<?php } ?>
  			</div>
  			<div class="col-md-3">
  				<h4>Accesos Rápidos</h4>
  				<ul class="menu">
  					<li>
  						<a href="<?php echo mklink ("/") ?>">Inicio</a>
  					</li>
  					<li>
  						<?php $nos = $entrada_model->get(1695)?>
  						<a href="<?php echo mklink ($nos->link) ?>">Nosotros</a>
  					</li>
  					<li>
  						<a href="<?php echo mklink ("web/terminaciones/") ?>">Terminaciones</a>
  					</li>
  					<li>
  						<a href="<?php echo mklink ("contacto/") ?>">Contacto</a>
  					</li>
  				</ul>
  			</div>
  			<div class="col-md-3">
  				<h4>Proyectos</h4>
  				<ul class="menu">
  					<li>
  						<a href="<?php echo mklink ("propiedades/proximos-proyectos/") ?>">Edificios en Desarrollo</a>
  					</li>
  					<li>
  						<a href="<?php echo mklink ("propiedades/ventas/") ?>">Venta de Terminados</a>
  					</li>
  					<li>
  						<a href="<?php echo mklink ("propiedades/alquileres/") ?>">Alquileres</a>
  					</li>
  					<li>
  						<a href="<?php echo mklink ("propiedades/proyectos-finalizados/") ?>">Proyectos Finalizados</a>
  					</li>
  				</ul>
  			</div>
  			<div class="col-md-3">
  				<h4>Contacto</h4>
  				<ul class="contact-info">
  					<?php if (!empty($empresa->direccion)) {  ?><li><a href="javascript:void(0)"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $empresa->direccion." ".$empresa->ciudad ?></a></li><?php } ?>
  					<?php if (!empty($empresa->telefono)) {  ?><li><a href="tel:<?php echo $empresa->telefono ?>"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $empresa->telefono ?></a></li><?php } ?>
  				</ul>
  			</div>
  		</div>
  	</div>
  </div>

  <!-- COPYRIGHT -->
  <div class="copyright">
  	<div class="container">
  		<div class="row">
  			<div class="col-md-6">
  				<p><span>Edificios Alaró.</span> Todos los Derechos Reservados.</p>
  			</div>
  			<div class="col-md-6">
  				<p><a href="www.misticastudio.com" target="_blank"><img src="assets_nuevo/images/mistica-logo.png" alt="Mistica Logo" /></a></p>
  			</div>
  		</div>
  	</div>
  </div>

  <div class="back-top"><a href="javascript:void(0);"><i class="fa fa-chevron-up" aria-hidden="true"></i></a></div>

  <!-- SCRIPT'S --> 
  <script type="text/javascript" src="assets_nuevo/js/jquery.min.js"></script> 
  <script type="text/javascript">
          $(window).load(function(){
            var maximo = 0;
            $(".feature-info h3").each(function(i,e){
              if ($(e).height() > maximo) maximo = $(e).height();
            });
            maximo = Math.ceil(maximo);
            $(".feature-info h3").height(maximo);
          });
        </script>
  <script type="text/javascript" src="assets_nuevo/js/owl.carousel.js"></script> 
  <script type="text/javascript" src="assets_nuevo/js/swiper.js"></script> 
  <script type="text/javascript" src="js/bootstrap.min.js"></script> 
  <script type="text/javascript" src="assets_nuevo/js/counterup.min.js"></script>
  <script type="text/javascript" src="assets_nuevo/js/jquery.waypoints.js"></script> 
  <script>

  	$('html').click(function(e) {
  		$('html').removeClass('sidebar-open');
  	});
  	$('.toggle-menu,.slide-popup').click(function(e) {
  		event.stopPropagation();
  	});
  	$('.toggle-menu').click(function() {
  		$('html').addClass('sidebar-open');
  	});

  	jQuery('.counter').counterUp ({
  		delay: 3,
  		time: 1000
  	});

  // swiper slider script
  var swipermw = $('.swiper-container.mousewheel').length ? true : false;
  var swiperkb = $('.swiper-container.keyboard').length ? true : false;
  var swipercentered = $('.swiper-container.center').length ? true : false;
  var swiperautoplay = $('.swiper-container').data('autoplay');
  var swiperinterval = $('.swiper-container').data('interval'),
  swiperinterval = swiperinterval ? swiperinterval : 7000;
  swiperautoplay = swiperautoplay ? swiperinterval : false;

  // swiper fadeslides script
  var autoplay = 5000;
  var swiper = new Swiper('.fadeslides', {
  	autoplayDisableOnInteraction: false,
  	effect: 'fade',
  	speed: 800,
  	loop: true,
  	paginationClickable: true,
  	watchSlidesProgress: true,
  	autoplay: autoplay,
  	simulateTouch: false,
  	nextButton: '.swiper-button-next',
  	prevButton: '.swiper-button-prev',
  	pagination: '.swiper-pagination',
  	mousewheelControl: swipermw,
  	keyboardControl: swiperkb,
  });
  
  /*OWL CAROUSEL SCRIPT*/  
  jQuery(document).ready(function ($) {
  	"use strict";
  	$(".on-going").owlCarousel({
  		items : 4,
  		itemsDesktop : [1199,4],
  		itemsDesktopSmall : [979,3],
  		itemsMobile : [767,1],
  		pagination: true,
  		navigation: true	
  	});
  });

  jQuery(document).ready(function ($) {
  	"use strict";
  	$(".slider-wrap").owlCarousel({
  		items : 2,
  		itemsDesktop : [1199,2],
  		itemsDesktopSmall : [991,1],
  		itemsMobile : [767,1],
  		pagination: true,
  		navigation: true	
  	});
  });

  //BACK TO TOP SCRIPT
  jQuery(".back-top").hide();
  jQuery(function () {
  	jQuery(window).scroll(function () {
  		if (jQuery(this).scrollTop() > 150) {
  			jQuery('.back-top').fadeIn();
  		} else {
  			jQuery('.back-top').fadeOut();
  		}
  	});
  	jQuery('.back-top a').click(function () {
  		jQuery('body,html').animate({
  			scrollTop: 0
  		}, 350);
  		return false;
  	});
  });

  //map script

   function llenar_id(item) { 
      $("#contacto_id_propiedad").val(item);
    } 
</script>
<script type="text/javascript">
          function enviar_contacto() {

            var nombre = jQuery("#contacto_nombre").val();
            var email = jQuery("#contacto_email").val();
            var mensaje = jQuery("#contacto_mensaje").val();
            var telefono = jQuery("#contacto_telefono").val();
            var id_propiedad = jQuery("#contacto_id_propiedad").val();

            if (isEmpty(nombre) || nombre == "Nombre") {
              alert("Por favor ingrese un nombre");
              jQuery("#contacto_nombre").focus();
              return false;          
            }


            if (isEmpty(telefono) || telefono == "telefono") {
              alert("Por favor ingrese un telefono");
              jQuery("#contacto_telefono").focus();
              return false;          
            }

            if (!validateEmail(email)) {
              alert("Por favor ingrese un email valido");
              jQuery("#contacto_email").focus();
              return false;          
            }
            if (isEmpty(mensaje) || mensaje == "Mensaje") {
              alert("Por favor ingrese un mensaje");
              jQuery("#contacto_mensaje").focus();
              return false;              
            }    
            jQuery("#contacto_submit").attr('disabled', 'disabled');
            var datos = {
              "para":"<?php echo $empresa->email ?>",
              "nombre":nombre,
              "telefono":telefono,
              "email":email,
              "asunto":"Consulta por propiedad",
              "mensaje":mensaje,
              "id_propiedad":id_propiedad,
              "id_empresa":ID_EMPRESA,
            }
            jQuery.ajax({
              "url":"/sistema/consultas/function/enviar/",
              "type":"post",
              "dataType":"json",
              "data":datos,
              "success":function(r){
                if (r.error == 0) {
                  alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
                <?php if ($nombre_pagina == "alquileres") {  ?>
                  window.location.href = "https://api.whatsapp.com/send?phone=542216822274&text="+ mensaje;
                <?php } else {  ?>
                  window.location.href = "https://api.whatsapp.com/send?phone=5492216519750&text="+ mensaje;
                <?php } ?>
                } else {
                  alert("Ocurrio un error al enviar su email. Disculpe las molestias");
                  jQuery("#contacto_submit").removeAttr('disabled');
                }
              }
            });
            return false;
          }
        </script>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5><img src="images/whatsapp-icon-2.png" alt="Whatsapp"> enviar whatsapp</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <img src="images/popup-close.png" alt="Close Btn">
        </button>
      </div>
      <div class="modal-body">
        <form onsubmit="return enviar_contacto()">
          <div class="form-group">
            <input type="hidden" value="" id="contacto_id_propiedad" name="">
            <input type="name" name="Nombre *" id="contacto_nombre" placeholder="Nombre *" class="form-control">
          </div>
          <div class="form-group">
            <input type="email" name="Email *" id="contacto_email" placeholder="Email *" class="form-control">
          </div>
          <div class="form-group">
            <input type="tel" name="WhatsApp (sin 0 ni 15) *" id="contacto_telefono" placeholder="WhatsApp (sin 0 ni 15) *" class="form-control">
          </div>
          <div class="form-group">
            <textarea id="contacto_mensaje" placeholder="Estoy interesado en “Duplex en venta en Ringuelet Cod: 1234”" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <button type="submit" id="contacto_submit" class="btn">hablar ahora</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
  <?php if (isset($empresa->latitud) && isset($empresa->longitud) && $empresa->latitud != 0 && $empresa->longitud != 0) { ?>
    <?php include_once("templates/comun/mapa_js.php"); ?>
    <script type="text/javascript">
     $(document).ready(function(){

      var mymap = L.map('map_canvas').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
        tileSize: 512,
        maxZoom: 18,
        zoomOffset: -1,
        id: 'mapbox/streets-v11',
        accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
      }).addTo(mymap);


      var icono = L.icon({
       iconUrl: 'assets_nuevo/images/map-place.png',
        iconSize:     [29, 39], // size of the icon
        iconAnchor:   [14, 39], // point of the icon which will correspond to marker's location
      });

      L.marker([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>],{
       icon: icono
     }).addTo(mymap);
    });
  </script>
<?php } ?>
<script type="text/javascript">
  $(document).ready(function(){
    var maximo = 0;
    $(".testimonio-igual").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".testimonio-igual").height(maximo);
  });

</script>
</body>
</html>