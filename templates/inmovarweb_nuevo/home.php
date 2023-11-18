<?php include "includes/init.php" ?>
<?php $page_act = "home"; ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?php include "includes/head.php" ?>
</head>
<body>

	<!-- Header -->
	<?php include "includes/header.php" ?>
	

	<!-- Top Banner -->
	<div class="top-banner">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<?php $t = $web_model->get_text("somos-la-red","Somos la Red de Profesionales más grande de la ciudad") ?>
					<h1 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
						<?php echo $t->plain_text ?>
					</h1>
					<?php $t = $web_model->get_text("en-inmovar","En Inmovar podrás acceder a la cartera de propiedades de tu ciudad con colegas matriculados que te ayudarán a vender mas rápido.") ?>
					<h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
						<?php echo $t->plain_text ?>
					</h2>
					<div class="bottom-info">
						<a target="_blank" href="https://app.inmovar.com/admin/login/registro/" class="btn btn-tile">unite ahora</a>
						<div class="right-side-info">
							<?php $t = $web_model->get_text("acced","Accede a miles de propiedades") ?>
							<span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<?php echo $t->plain_text ?>
							</span>
							<?php $t = $web_model->get_text("inmoenred","Ver inmobiliarias en la red") ?>
							<small class="editable ver-inmos" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
								<a href="<?php echo mklink ("entradas/inmobiliarias/") ?>"><?php echo $t->plain_text ?></a>
							</small>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<img src="assets/images/banner-graphics.png" alt="Graphics">
				</div>
				<?php $logos = $entrada_model->get_list(array("from_link_categoria"=>"logos"))?>	
				<?php if (!empty($logos)) {  ?>
					<div class="col-md-12">
						<div class="logos-block">
							<div class="owl-carousel owl-arrow" data-items="5" data-margin="10" data-nav="false" data-dots="false" data-loop="false">
								<?php foreach ($logos as $l) { ?>
									<?php $images = $entrada_model->get($l->id)?>
									<?php foreach ($images->images as $i) {  ?>
										<div class="item">
											<a target="_blank" href="https://app.inmovar.com/admin/login/registro/"><img src="<?php echo $i ?>" alt="Logo"></a>
										</div>
									<?php } ?>
								<?php } ?>
							</div> 
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<!-- Boxes Info -->
	<div class="boxes-info">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="box">
						<div class="icon-block"></div>
						<div class="content-right">
							<h2>Sos un martillero</h2>
							<p>Si estas recibido, si trabajas de forma independiente o estas empezando a ejercer la profesión podrás sumarte a la venta de todas las propiedades compartidas en la Red Inmovar.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="box">
						<div class="icon-block"></div>
						<div class="content-right">
							<h2>Sos una inmobiliaria</h2>
							<p>Si sos una Inmobiliaria consolidada podrás acceder a una red de colegas matriculados que te ayudarán a vender más rápido tus propiedades compartidas en la Red Inmovar.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- About Us -->
	<div class="about-us" id="about-us">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<img src="assets/images/about-us-graphics.png" alt="Graphics">
				</div>
				<div class="col-lg-6">
					<div class="section-title">
						<span>¿Qué es Inmovar?</span>
						<h3>Somos una plataforma Inmobiliaria de trabajo colaborativo.</h3>
					</div>
					<h4>Te ayudamos a optimizar los resultados de tu inmobiliara trabajando de manera colaborativa y compartiendo propiedades entre colegas. </h4>
					<ul class="bullet-list">
						<li>Arma una Red con las Propiedades e Inmobiliarias que elijas para comenzar a compartir.</li>
						<li>Logra mayor exposición de tus propiedades.</li>
						<li>Mejora los tiempos de venta, ya no estas vendiendo solo!</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="counter-section">
		<div class="container">
			<div class="row text-center">
				<div class="col-md-3">
					<div class="counter-block">
						<?php $t = $web_model->get_text("counter-img","assets/images/propiedades.png") ?>
						<img src="<?php echo $t->plain_text ?>" class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
						<h3><?php $t = $web_model->get_text("counter-number","6500") ?>
							+<span class="editable counter count-number" data-to="<?php echo $t->plain_text ?>" data-speed="1500" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?>
							</span>	
						</h3>
						<?php $t = $web_model->get_text("counter-txt","Propiedades") ?>
						<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
							<?php echo $t->plain_text ?>
						</p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="counter-block">
						<?php $t = $web_model->get_text("2counter-img","assets/images/inmobiliarias.png") ?>
						<img src="<?php echo $t->plain_text ?>" class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
						<h3>+<?php $t = $web_model->get_text("2counter-number","50") ?><span class="editable counter count-number" data-to="<?php echo $t->plain_text ?>" data-speed="1500" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?>
							</span>
						</h3>
							
						<?php $t = $web_model->get_text("2counter-txt","Inmobiliarias") ?>
						<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
							<?php echo $t->plain_text ?>
						</p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="counter-block">
						<?php $t = $web_model->get_text("3counter-img","assets/images/estadisticas.png") ?>
						<img src="<?php echo $t->plain_text ?>" class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
						<?php $t = $web_model->get_text("3counter-number","25550") ?>
						<h3 class="editable counter count-number" data-to="<?php echo $t->plain_text ?>" data-speed="1500" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
							<?php echo $t->plain_text ?>
						</h3>
						<?php $t = $web_model->get_text("3counter-txt","Visitas<br>Mensuales") ?>
						<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
							<?php echo $t->plain_text ?>
						</p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="counter-block">
						<?php $t = $web_model->get_text("4counter-img","assets/images/consultas.png") ?>
						<img src="<?php echo $t->plain_text ?>" class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
						<?php $t = $web_model->get_text("4counter-number","1250") ?>
						<h3 class="editable counter count-number" data-to="<?php echo $t->plain_text ?>" data-speed="1500" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
							<?php echo $t->plain_text ?>
						</h3>
						<?php $t = $web_model->get_text("4counter-txt","Consultas<br>Registradas") ?>
						<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
							<?php echo $t->plain_text ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Sales Solutions -->
	<div class="sales-solutions" id="sales-solutions">
		<div class="container">
			<div class="section-title">
				<h3>Soluciones de venta para tu negocio</h3>
				<p>Somos una plataforma inmobiliaria que ofrecemos funcionalidades para que tu inmobiliaria pueda mejorar sus ventas.</p>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="box">
						<div class="icon-block"></div>
						<div class="content-right">
							<h3>Red de inmobiliarias</h3>
							<p>Formá parte de la Red Inmovar y difundí las propiedades que quieras en las Webs de otros colegas que elijas.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="box gestion">
						<div class="icon-block"></div>
						<div class="content-right">
							<h3>Gestión de clientes (CRM)</h3>
							<p>Registrá todas las consultas que llegan a tu inmobiliaria y configurá alertas, recordatorios, tareas y mucho más.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="box sitio">
						<div class="icon-block"></div>
						<div class="content-right">
							<h3>Sitio web inmobiliario</h3>
							<p>Te damos una página web con un diseño moderno y atractivo acorde a la imagen de tu marca.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="box portales">
						<div class="icon-block"></div>
						<div class="content-right">
							<h3>Difusión en portales</h3>
							<p>Ahorrá tiempo y difundí tus propiedades en diferentes portales como MercadoLibre, OLX, Argenprop e Inmobusqueda.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Subscribe -->
	<div class="subscribe">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-4">
					<h4>Sumate ahora!</h4>
					<p>Registra tu email y accedé a un demo para poder probar todas las funcionalidades de Inmovar.</p>
				</div>
				<div class="col-lg-4 text-center">
					<img src="assets/images/subscribe-graphic.png" alt="Subscribe Graphic">
				</div>
				<div class="col-lg-4">
					<h5>Accede sin cargo</h5>
					<form onsubmit="return enviar_newsletter()">
						<input class="form-control" id="newsletter_email" type="email" name="Escribe tu email para acceder" placeholder="Escribe tu email para acceder">
						<input class="btn btn-tile" id="newsletter_submit" type="submit" value="">
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Price Plans -->
	<div class="price-plans" id="prices">
		<div class="container">
			<div class="section-title">
				<h3>Planes de Precio</h3>
			</div>
			<?php /*
			<div class="custom-control custom-switch">
				<span>Pago Mensual</span>
				<input type="checkbox" class="custom-control-input" id="customSwitches">
				<label class="custom-control-label" for="customSwitches"></label>
				<span>Pago Anual <small>20% OFF!</small></span>
			</div>*/ ?>
			<div class="membership-box">
				<div class="row">
					<div class="col-lg-4">
						<h5>Red Inmovar</h5>
						<div class="tag">Difundí todas tus propiedades!</div>
						<span>$ <b>4999</b>/mes</span>
						<small>Más de 10.000 propiedades</small>
						<small>Más de 100 inmobiliarias</small>
						<h6>Incluye</h6>
						<ul class="bullet-list">
							<li>Acceso a la <small>Red Inmovar</small></li>
							<li>API para Integrar Propiedades</li>
							<li>Gestión Consultas (CRM)</li>
							<li>Difusión en Portales</li>
							<li>Soporte</li>
						</ul>
						<a class="btn btn-tile" href="https://app.inmovar.com/admin/login/registro/" target="_blank">Prueba gratis 15 dias</a>
					</div>
					<div class="col-lg-4 blue">
						<h5>Martillero</h5>
						<!-- <div class="tag">20% OFF por 3 meses!</div> -->
						<span>$ <b>9999</b>/mes</span>
						<!-- <strike>$<b>3499</b>/mes</strike> -->
						<small>15 días de prueba gratis</small>
						<h6>Incluye</h6>
						<ul class="bullet-list">
							<li>Web Propia hasta <small>50 Propiedades</small></li>
							<li>Acceso a la <small>Red Inmovar</small></li>
							<li>API para Integrar Propiedades</li>
							<li>Gestión de Consultas (CRM)</li>
							<li>Difusión en Portales</li>
							<li>Soporte</li>
						</ul>
						<a class="btn btn-blue" href="https://app.inmovar.com/admin/login/registro/" target="_blank">prueba gratis 15 días</a>
					</div>
					<div class="col-lg-4 light-blue">
						<h5>Inmobiliaria</h5>
						<!-- <div class="tag">20% OFF por 3 meses!</div> -->
						<span>$ <b>16999</b>/mes</span>
						<!-- <strike>$<b>6999</b>/mes</strike> -->
						<small>15 días de prueba gratis</small>
						<h6>Incluye</h6>
						<ul class="bullet-list">
							<li>Web Propia hasta <small>250 propiedades</small></li>
							<li>Acceso a la <small>Red Inmovar</small></li>
							<li>API para Integrar Propiedades</li>
							<li>Gestión de Consultas (CRM)</li>
							<li>Difusión en Portales</li>
							<li>Sistema de Alquileres (demo)</li>
							<li>Soporte</li>
						</ul>
						<a class="btn btn-tile" href="https://app.inmovar.com/admin/login/registro/" target="_blank">prueba gratis 15 días</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Frequent Questions -->
	<div class="frequent-questions">
		<div class="container">
			<div class="section-title">
				<h3>Preguntas Frecuentes</h3>
			</div>
			<div id="accordion">
				<?php $faq = $entrada_model->get_list(array("categoria"=>"preguntas-frecuentes")) ?>
				<?php $x=1;foreach ($faq as $l) {  ?>
					<div class="card">
						<div class="card-header" id="heading<?php echo $l->id ?>">
							<h5 class="mb-0">
								<button class="btn btn-link <?php echo ($x==1)?"":"collapsed" ?>" data-toggle="collapse" data-target="#collapse<?php echo $l->id ?>" aria-expanded="<?php echo ($x==1)?"true":"false" ?>" aria-controls="collapse<?php echo $l->id ?>">
									<?php echo $l->titulo ?>
								</button>
							</h5>
						</div>
						<div id="collapse<?php echo $l->id ?>" class="collapse <?php echo ($x==1)?"show":"" ?>" aria-labelledby="heading<?php echo $l->id ?>" data-parent="#accordion">
							<div class="card-body">
								<?php echo $l->texto ?>
							</div>
						</div>
					</div>
					<?php $x++; } ?>
				</div>
			</div>
		</div>

<!-- Footer -->
<?php include "includes/footer.php" ?>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/counterup.js"></script>
<script src="assets/js/waypoints.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/html5.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script type="text/javascript">
	$('.owl-carousel').owlCarousel({
		slideTransition: 'linear',
		loop:true,
		center: true,
		margin:10,
		responsiveClass:true,
		dots : false,
		navText : ['' , ''],
		nav:false,
		autoplay: true,
		autoplaySpeed: 1500,
		autoplayHoverPause:true,
		fluidSpeed: true,
		smartSpeed: 5000,
		autoplayTimeout: 1500,
		responsive:{
			0:{
				items:2,
			},
			400:{
				items:2,
			},
			600:{
				items:5,
			},
			1000:{
				items:6,
			},
			1920 : {
				items: 5
			}
		}
	}); 
	$(".navbar-expand-xl .navbar-nav .nav-link").on('click', function(event) {

// Make sure this.hash has a value before overriding default behavior
if (this.hash !== "") {
  // Prevent default anchor click behavior
  event.preventDefault();

  // Store hash
  var hash = this.hash;

  // Using jQuery's animate() method to add smooth page scroll
  // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
  $('html, body').animate({
  	scrollTop: $(hash).offset().top
  }, 800, function(){

    // Add hash (#) to URL when done scrolling (default click behavior)
    window.location.hash = hash;
  });
} // End if
});
	$(".navbar-expand-xl .navbar-nav .nav-link").click(function(){
		$(".navbar-collapse").toggleClass("show");
	});
</script>
<script type="text/javascript">
function enviar_newsletter() {
	var email = $("#newsletter_email").val();
	if (!validateEmail(email)) {
		alert("Por favor ingrese un email valido.");
		$("#newsletter_email").focus();
		return false;
	}
	$("#newsletter_submit").attr('disabled', 'disabled');
	var datos = {
		"email":email,
		"mensaje":"Registro a Newsletter",
		"asunto":"Registro a Newsletter",
		"para":"misticastudio@gmail.com",
		"bcc":"basile.matias99@gmail.com",
		"id_empresa":ID_EMPRESA,
		"id_origen":2,
	}
	$.ajax({
		"url":"/admin/consultas/function/enviar/",
		"type":"post",
		"dataType":"json",
		"data":datos,
		"success":function(r){
			if (r.error == 0) {
				location.href = "https://app.inmovar.com/admin/login/registro/?email="+email;
			} else {
				alert("Ocurrio un error al enviar su email. Disculpe las molestias");
				$("#newsletter_submit").removeAttr('disabled');
			}
		}
	});  
	return false;
}  
</script>
<script type="text/javascript">
	(function ($) {
	$.fn.countTo = function (options) {
		options = options || {};
		
		return $(this).each(function () {
			// set options for current element
			var settings = $.extend({}, $.fn.countTo.defaults, {
				from:            $(this).data('from'),
				to:              $(this).data('to'),
				speed:           $(this).data('speed'),
				refreshInterval: $(this).data('refresh-interval'),
				decimals:        $(this).data('decimals')
			}, options);
			
			// how many times to update the value, and how much to increment the value on each update
			var loops = Math.ceil(settings.speed / settings.refreshInterval),
				increment = (settings.to - settings.from) / loops;
			
			// references & variables that will change with each update
			var self = this,
				$self = $(this),
				loopCount = 0,
				value = settings.from,
				data = $self.data('countTo') || {};
			
			$self.data('countTo', data);
			
			// if an existing interval can be found, clear it first
			if (data.interval) {
				clearInterval(data.interval);
			}
			data.interval = setInterval(updateTimer, settings.refreshInterval);
			
			// initialize the element with the starting value
			render(value);
			
			function updateTimer() {
				value += increment;
				loopCount++;
				
				render(value);
				
				if (typeof(settings.onUpdate) == 'function') {
					settings.onUpdate.call(self, value);
				}
				
				if (loopCount >= loops) {
					// remove the interval
					$self.removeData('countTo');
					clearInterval(data.interval);
					value = settings.to;
					
					if (typeof(settings.onComplete) == 'function') {
						settings.onComplete.call(self, value);
					}
				}
			}
			
			function render(value) {
				var formattedValue = settings.formatter.call(self, value, settings);
				$self.html(formattedValue);
			}
		});
	};
	
	$.fn.countTo.defaults = {
		from: 0,               // the number the element should start at
		to: 0,                 // the number the element should end at
		speed: 1000,           // how long it should take to count between the target numbers
		refreshInterval: 100,  // how often the element should be updated
		decimals: 0,           // the number of decimal places to show
		formatter: formatter,  // handler for formatting the value before rendering
		onUpdate: null,        // callback method for every time the element is updated
		onComplete: null       // callback method for when the element finishes updating
	};
	
	function formatter(value, settings) {
		return value.toFixed(settings.decimals);
	}
}(jQuery));

jQuery(function ($) {
  // custom formatting example
  $('.count-number').data('countToOptions', {
	formatter: function (value, options) {
	  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
	}
  });
  
  // start all the timers
  $('.counter').each(count);  
  
  function count(options) {
	var $this = $(this);
	options = $.extend({}, options || {}, $this.data('countToOptions') || {});
	$this.countTo(options);
  }
});


</script>
<script type="text/javascript">
 if (jQuery(window).width()>767) { 

  $(document).ready(function(){
    var maximo = 0;
    $(".membership-box .bullet-list").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".membership-box .bullet-list").height(maximo);
  });
}
</script>
<script type="text/javascript">
	jQuery(".count-number").text().replace(",","") ;
</script>
</body>
</html>