<div class="top-bar">
	<div class="left-block">
		<div class="whatsapp-box">
			<ul>
				<?php if (!empty($empresa->direccion)) {  ?>
					<li>
						<img src="assets/images/map-icon.png" alt="Map">
						<span>
							<a href="javascript:void(0)"><?php echo $empresa->direccion ?></a>
						</span>
					</li>
				<?php } ?>
				<?php if (!empty($empresa->telefono)) {  ?>
					<li>
						<img src="assets/images/whatsapp-icon.png" alt="Whatsapp">
						<span>
							<a href="tel:<?php echo $empresa->telefono ?>"><?php echo $empresa->telefono ?></a>
						</span>
					</li>
				<?php } ?>
				<?php if (!empty($empresa->telefono_2)) {  ?>
					<li>
						<img src="assets/images/call.png" alt="Call Us">
						<span>
							<a href="tel:<?php echo $empresa->telefono_2 ?>"><?php echo $empresa->telefono_2 ?></a>
						</span>
					</li>
				<?php } ?>
			</ul>        
		</div>
	</div>
	<?php if(!empty($empresa->facebook) and (!empty($empresa->instagram))) {  ?>
		<div class="right-block">
			<div class="social">
				<a href="<?php echo $empresa->facebook ?>" target0="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
				<a href="<?php echo $empresa->instagram ?>" target0="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
			</div>
		</div>
	<?php } ?> 
</div>
<header class="<?php echo ($page_act=="home")?"home-header":""?>">  
	<nav class="navbar navbar-expand-lg">
		<a class="navbar-brand" href="<?php echo mklink ("/") ?>"><img src="assets/images/logo.png" alt="Lasa Papelera"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="<?php echo mklink ("web/nosotros/") ?>">Nosotros</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo mklink ("propiedades/ventas/") ?>">Comprar</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo mklink ("propiedades/alquileres/") ?>">Alquilar</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo mklink ("web/vender/") ?>">Vender</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo mklink ("propiedades/emprendimientos/") ?>">Emprendimientos</a>
				</li>
				<li class="nav-item">
					<a class="nav-link btn btn-secoundry" href="<?php echo mklink ("contacto/") ?>">Contacto</a>
				</li>
			</ul>     
		</div>
	</nav>
</header>