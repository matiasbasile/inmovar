<?php 
include("includes/init.php"); 
$seo_title = $empresa->nombre." | Planes y precios";
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php") ?>
</head>
<body>

<div class="sub2-page pagina-precios">

<?php include("includes/header.php") ?>

<!-- Top Banner -->
<div class="top-banner">
	<div class="container">
		<div class="banner-content">
			<?php $t = $web_model->get_text("precios-titulo","Crea tu tienda más rápido que en cualquier otro lugar"); ?>
			<h1 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h1>
			<?php $t = $web_model->get_text("precios-subtitulo","¡Elija el plan adecuado para su negocio, o \npruébelo gratis y regístrese más tarde!"); ?>
			<div class="sub-title editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></div>
			<div class="btn-block">
				<?php $t = $web_model->get_text("precios-boton","Creá tu tienda ahora"); ?>
				<a class="btn btn-aquamarine editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" href="<?php echo mklink("web/registro/") ?>"><i class="fa fa-play-circle" aria-hidden="true"></i> <?php echo nl2br($t->plain_text) ?></a>
			</div>
		</div>
	</div>
</div>

<!-- Services Block -->
<div class="services-block">
	<div class="container">
		<div class="row">
			<div class="col-xl-4 col-lg-12">
				<div class="service-box">
					<?php $plan_1 = $web_model->get_text("plan_1","Tienda Web") ?>
					<div class="service-icon">
						<?php $t = $web_model->get_text("plan_1-imagen","images/inicial.png") ?>
						<img class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="<?php echo $plan_1->plain_text ?>">
					</div>
					<div data-id="<?php echo $plan_1->id ?>" data-clave="<?php echo $plan_1->clave ?>" class="service-title editable"><?php echo $plan_1->plain_text ?></div>
					<div class="price-block">
						<?php $t = $web_model->get_text("plan_1-precio","499") ?>
						<span><small class="dollar-sign">$</small> <big class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></big><small>/mes</small></span>
					</div>
					<?php $t = $web_model->get_text("plan_1-caracteristicas","<ul><li>Tienda online</li></ul>") ?>
					<div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="services-lising editable">
						<?php echo $t->texto ?>
					</div>
					<div class="btn-block">
						<a class="btn btn-aquamarine" href="<?php echo mklink("web/registro/?id_plan=9") ?>">comenzar</a>
					</div>
					<div class="charge-commission">
						<center>
							<div class="pull-left"><img src="images/sunglasses.png" alt="Sunglasses"></div>
							<div class="right-info">Prueba Gratis 15 días</div>
						</center>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-12">
				<div class="service-box highlited-box">
					<?php $plan_2 = $web_model->get_text("plan_2","Mercado Libre") ?>
					<div class="service-icon">
						<?php $t = $web_model->get_text("plan_2-imagen","images/avanzado.png") ?>
						<img class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="<?php echo $plan_2->plain_text ?>">
					</div>
					<div data-id="<?php echo $plan_2->id ?>" data-clave="<?php echo $plan_2->clave ?>" class="service-title editable"><?php echo $plan_2->plain_text ?></div>
					<div class="price-block">
						<?php $t = $web_model->get_text("plan_2-precio","999") ?>
						<span><small class="dollar-sign">$</small> <big class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></big><small>/mes</small></span>
					</div>
					<?php $t = $web_model->get_text("plan_2-caracteristicas","<ul><li>Tienda online</li></ul>") ?>
					<div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="services-lising editable">
						<?php echo $t->texto ?>
					</div>
					<div class="btn-block">
						<a class="btn btn-aquamarine" href="<?php echo mklink("web/registro/?id_plan=13") ?>">comenzar</a>
					</div>
					<div class="charge-commission">
						<center>
							<div class="pull-left"><img src="images/sunglasses.png" alt="Sunglasses"></div>
							<div class="right-info">Prueba Gratis 15 días</div>
						</center>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-12">
				<div class="service-box">
					<?php $plan_3 = $web_model->get_text("plan_3","Gestión y Facturación") ?>
					<div class="service-icon">
						<?php $t = $web_model->get_text("plan_3-imagen","images/premium.png") ?>
						<img class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="<?php echo $plan_3->plain_text ?>">
					</div>
					<div data-id="<?php echo $plan_3->id ?>" data-clave="<?php echo $plan_3->clave ?>" class="service-title editable"><?php echo $plan_3->plain_text ?></div>
					<div class="price-block">
						<?php $t = $web_model->get_text("plan_3-precio","1999") ?>
						<span><big class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></big></span>
					</div>
					<?php $t = $web_model->get_text("plan_3-caracteristicas","<ul><li>Tienda online</li></ul>") ?>
					<div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="services-lising editable">
						<?php echo $t->texto ?>
					</div>
					<div class="btn-block">
						<a class="btn btn-aquamarine" href="<?php echo mklink("web/registro/?id_plan=14") ?>">comenzar</a>
					</div>
					<div class="charge-commission">
						<center>
							<div class="pull-left"><img src="images/sunglasses.png" alt="Sunglasses"></div>
							<div class="right-info">Prueba Gratis 15 días</div>
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Choose Plan -->
<div class="choose-plan">
	<div class="container">
		<div class="section-title">
			<?php $t = $web_model->get_text("prueba-inmovar-titulo","Prueba Shopvar full version por 14 días, sin compromiso") ?>
			<h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h3>
			<?php $t = $web_model->get_text("prueba-inmovar-subtitulo","Configura tu tienda y elige tu plan mas tarde") ?>
			<h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h4>
		</div>
		<div class="plan-box">
			<div class="table-responsive">
				<?php $precios = $entrada_model->get_list(array(
					"categoria"=>"precios"
				));
				if (sizeof($precios)>0) {
					$precio = $precios[0]; 
					echo $precio->texto; ?>
				<?php } ?>
			</div>
		</div>
		<div class="suggestion-about-plan">
			<div class="row align-items-center">
				<div class="col-md-5 order-lg-1 order-md-1 order-2">
					<img src="images/suggestion-left.png" alt="Suggestion Left">
				</div>
				<div class="col-md-7 order-lg-2 order-md-2 order-1">
					<?php $t = $web_model->get_text("ayuda-plan-titulo","No estas seguro que plan elegir?"); ?>
					<h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h4>
					<p>Llama al <a href="tel:+54 221 4535654">+54 221 4535654</a> o habla por <span><a target="_blank" href="https://web.whatsapp.com/send?phone=5492215021999">WhatsApp</a></span> con unos de<br> nuestros asesores para ayudarte a comenzar!</p>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Trial Section -->
<div class="trial-section">
	<div class="container">
		<div class="banner-content">
			<?php $t = $web_model->get_text("trial2-titulo","Unite a ellos!"); ?>
			<h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text)?></h3>
			<?php $t = $web_model->get_text("trial2-subtitulo","Tienda online, software de comercio electrónico, un centro de\n comercialización y soporte 24/7, todo en uno!"); ?>
			<div class="sub-title editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text)?></div>
			<div class="btn-block">
				<a class="btn btn-aquamarine" href="<?php echo mklink("web/registro/") ?>"><i class="fa fa-play-circle" aria-hidden="true"></i> Comenzá ahora</a>
			</div>
			<?php $t = $web_model->get_text("trial2-tarjeta","Sin tarjeta de crédito.\n Cancela en cualquier momento!"); ?>
			<div class="trial-info editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text)?> <img src="images/thumb-up.png" alt="Thumb Up"></div>
		</div>
		<div class="text-box-info" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1300">
			<div class="table-container">
				<div class="align-container">
					<?php $t = $web_model->get_text("trial2-ej1-titulo","Hemos tenido resultados increíbles usando Shopvar. Este año vamos a terminar haciendo más volumen en nuestro sitio Shopvar que en nuestra tienda de ladrillo y mortero."); ?>
					<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text)?></p>
					<?php $t = $web_model->get_text("trial2-ej1-link","LiliAlessandra.com"); ?>
					<a class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" href="javascript:void(0)" target="_blank"><?php echo $t->plain_text ?></a>
				</div>
			</div>
		</div>
		<div class="text-box-info box2" data-aos="fade-up" data-aos-delay="1800" data-aos-duration="1500">
			<div class="table-container">
				<div class="align-container">
					<?php $t = $web_model->get_text("trial2-ej2-titulo","Hemos tenido resultados increíbles usando Shopvar. Este año vamos a terminar haciendo más volumen en nuestro sitio Shopvar que en nuestra tienda de ladrillo y mortero."); ?>
					<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text)?></p>
					<?php $t = $web_model->get_text("trial2-ej2-link","LiliAlessandra.com"); ?>
					<a class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" href="javascript:void(0)" target="_blank"><?php echo $t->plain_text ?></a>
				</div>
			</div>
		</div>
		<div class="logo-box" data-aos="fade-up" data-aos-delay="2200" data-aos-duration="1800">
			<div class="table-container">
				<div class="align-container">
					<img src="images/box-logo1.png" alt="Box Logo">
				</div>
			</div>
		</div>
		<div class="logo-box box2" data-aos="fade-up" data-aos-delay="2600" data-aos-duration="1800">
			<div class="table-container">
				<div class="align-container">
					<img src="images/box-logo2.png" alt="Box Logo">
				</div>
			</div>
		</div>
		<div class="logo-box box2 top-right" data-aos="fade-up" data-aos-delay="2900" data-aos-duration="1800">
			<div class="table-container">
				<div class="align-container">
					<img src="images/box-logo3.png" alt="Box Logo">
				</div>
			</div>
		</div>
		<div class="logo-box right-bottom" data-aos="fade-up" data-aos-delay="3000" data-aos-duration="1800">
			<div class="table-container">
				<div class="align-container">
					<img src="images/box-logo4.png" alt="Box Logo">
				</div>
			</div>
		</div>
	</div>
</div>

<?php include("includes/faq.php") ?>

<?php include("includes/footer.php") ?>
</div>
</html> 