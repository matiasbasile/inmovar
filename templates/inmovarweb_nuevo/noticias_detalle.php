<?php include "includes/init.php" ?>
<?php $entrada = $entrada_model->get($id)?>
<?php $page_act == $entrada->categoria_link; ?>
<!DOCTYPE html>
<html>
<head>
	<?php include "includes/head.php" ?>
</head>
<body id="listado">
	<?php include "includes/header2.php" ?>
	<section class="page-title">
		<div class="container">
			<h1>Novedades</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo mklink ("/") ?>">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">Blog</li>
				</ol>
			</nav>
		</div>
	</section>
	<section class="blog listing margin-desktop-80-top">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-6">
					<div class="section-title">
						<div class="blog-date"><i class="fa fa-calendar"></i> <?php echo fecha_full($entrada->fecha) ?></div>
					</div>
					<?php array_unshift($entrada->images,$entrada->path) ?>
					<?php if (sizeof($entrada->images) > 1) {  ?>
						<div class="owl-carousel pt20 pb20" data-items="1" data-margin="0" data-loop="true" data-nav="true" data-dots="true" data-autoplay="true">
							<?php foreach ($entrada->images as $i) {  ?>
								<div class="item">
									<img src="<?php echo $i ?>" class="contain-detail" alt="blog-detail">
								</div>
							<?php } ?>
						</div>
					<?php } else {  ?>
						<?php if (!empty($entrada->path)) {  ?>
							<div class="pt20 pb20">
								<img src="<?php echo $entrada->path ?>" class="contain-detail">
							</div>
						<?php } ?>
					<?php } ?>
					<div class="section-title">
	          <h5>Categoría: <?php echo $entrada->categoria ?></h5>
	          <div class="section-heading">
	            <h2><?php echo $entrada->titulo ?></h2>
	          </div>
	        </div>
					<div class="mt40 mb40"><?php echo $entrada->texto ?></div>
					<div class="blog-detail pt30 pb50">
						<div class="btn-block">
		          <a href="javascript:history.back()" class="btn gray-dark-btn">volver</a>
		          <div class="socials">
		            <ul>
		              <li><a class="whtsup" target="_blank" href="whatsapp://send?text=<?php echo urlencode(current_url()) ?>" data-toggle="tooltip" data-placement="bottom" title="Compartir en WhatsApp"><i class="fa fa-whatsapp"></i></a></li>
		              <li><a class="fb" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()) ?>" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" data-toggle="tooltip" data-placement="bottom" title="Compartir en Facebook"><i class="fa fa-facebook"></i> </a></li>
		              <li><a class="email" href="mailto:?subject=<?php echo html_entity_decode($entrada->titulo,ENT_QUOTES) ?>&body=<?php echo(current_url()) ?>" data-toggle="tooltip" data-placement="bottom" title="Compartir en Email"><i class="fa fa-envelope"></i></a></li>
		            </ul>
		          </div>
		        </div>	
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<aside>
						<div class="aside-item">
							<h3>Más Información</h3>
							<ul>
								<?php $info = $entrada_model->get_list(array("categoria"=>"informacion"))?>
								<?php foreach ($info as $i) { ?>
									<li class="<?php echo ($i->id == $entrada->id)?"active":"" ?>">
										<a href="<?php echo mklink ($i->link) ?>"><span><?php echo $i->titulo ?></span></a>
									</li>
								<?php } ?>
							</ul>
						</div>
						<div class="aside-item recent-blog">
							<span class="item-subtitle">Los Más Vistos</span>
							<h3>Blog Informativo</h3>
							<?php $blog = $entrada_model->get_list(array("from_id_categoria"=>1629)) ?>
							<?php foreach ($blog as $l) {  ?>
								<div class="recent-item">
									<a href="<?php echo mklink ($l->link) ?>" class="item-image">
										<img src="<?php echo $l->path ?>" style="object-fit: cover;height: 83px; width: 100%" alt="Image">
									</a>
									<div class="recent-item-info">
										<div class="blog-date"><i class="fa fa-calendar"></i> <?php echo ($l->fecha) ?></div>
										<a href="<?php echo mklink ($l->link) ?>" class="recent-blog-title"><?php echo $l->titulo ?></a>
										<a href="<?php echo mklink ($l->link) ?>" class="text-link">Leer Más</a>
									</div>
								</div>
							<?php } ?>
							<div class="text-center">
								<a href="<?php echo mklink ("entradas/blog/") ?>" class="btn">ver todo</a>
							</div>
						</div>
					</aside>
				</div>
			</div>
		</div>
	</section>
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
					<h5>Prueba gratis 15 días</h5>
					<form onsubmit="return enviar_newsletter()">
						<input class="form-control" id="newsletter_email" type="email" name="Escribe tu email para acceder" placeholder="Escribe tu email para acceder">
						<input class="btn btn-tile" id="newsletter_submit" type="submit" value="">
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php include "includes/footer.php" ?>

	<script src="assets/js/jquery.min.js"></script>		
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/html5.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
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
						"para":"<?php echo $empresa->email ?>",
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
								alert("Muchas gracias por registrarse a nuestro newsletter!");
								location.reload();
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
		$('.owl-carousel').owlCarousel({
			slideTransition: 'linear',
			loop:true,
			center: true,
			margin:10,
			responsiveClass:true,
			dots : true,
			navText : ['',''],
			nav:true,
			autoplay: true,
			responsive:{
				0:{
					items:1,
				},
				400:{
					items:1,
				},
				600:{
					items:1,
				},
				1000:{
					items:1,
				},
				1920 : {
					items: 1
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
				"para":"<?php echo $empresa->email ?>",
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
						alert("Muchas gracias por registrarse a nuestro newsletter!");
						location.reload();
					} else {
						alert("Ocurrio un error al enviar su email. Disculpe las molestias");
						$("#newsletter_submit").removeAttr('disabled');
					}
				}
			});  
			return false;
		}  
	</script>
</body>
</html>