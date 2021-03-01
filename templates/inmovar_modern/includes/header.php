<header>
	<div class="wrapper-black d-none d-sm-block background-c2">
		<div class="vertical-align-container">
			<div class="pull-left">
				<?php if (!empty($empresa->logo_1)) {  ?>
					<a href="<?php echo mklink ("/") ?>"><img src="/admin/<?php echo $empresa->logo_1 ?>"></a>
				<?php } ?>
				<ul class="nav-pages">
					<li><a class="<?php echo ($page_act == "home")?"active":"" ?>" href="<?php echo mklink ("/") ?>">Home</a></li>
					<li><a class="<?php echo ($page_act == "ventas")?"active":"" ?>" href="<?php echo mklink ("propiedades/ventas/") ?>">Ventas</a></li>
					<li><a class="<?php echo ($page_act == "alquileres")?"active":"" ?>" href="<?php echo mklink ("propiedades/alquileres/") ?>">Alquileres</a></li>
					<li><a class="<?php echo ($page_act == "emprendimientos")?"active":"" ?>" href="<?php echo mklink ("propiedades/emprendimientos/") ?>">Emprendimientos</a></li>
					<li><a class="<?php echo ($page_act == "obras")?"active":"" ?>" href="<?php echo mklink ("propiedades/obras/") ?>">Obras</a></li>
					<li><a class="<?php echo ($page_act == "contacto")?"active":"" ?>" href="<?php echo mklink ("contacto/") ?>">Contacto</a></li>
				</ul>
			</div>
			<div class="pull-right me1">
				<div class="social-list">
					<?php if (!empty($empresa->facebook)) {  ?>
						<a href="<?php echo $empresa->facebook ?>">
							<i class="fab fa-facebook"></i>
						</a>
					<?php } ?>
					<?php if (!empty($empresa->instagram)) {  ?>
						<a href="<?php echo $empresa->instagram ?>">
							<i class="fab fa-instagram"></i>
						</a>
					<?php } ?>
					<?php if (!empty($empresa->twitter)) {  ?>
						<a href="<?php echo $empresa->twitter ?>">
							<i class="fab fa-twitter"></i>
						</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="d-block d-sm-none mobile-menu">
		<!-- Top Navigation Menu -->
		<div class="topnav">
		  <?php if (!empty($empresa->logo)) { ?>
		  	<a href="<?php echo mklink ("/") ?>" class="active"><img src="/admin/<?php echo $empresa->logo ?>" style="width: 180px"></a>
		  <?php } ?>
		  <!-- Navigation links (hidden by default) -->
		  <div id="myLinks">
		   	<a href="<?php echo mklink ("/") ?>">Home</a>
				<a href="<?php echo mklink ("propiedades/ventas/") ?>">Ventas</a>
				<a href="<?php echo mklink ("propiedades/alquileres/") ?>">Alquileres</a>
				<a href="<?php echo mklink ("propiedades/emprendimientos/") ?>">Emprendimientos</a>
				<a href="<?php echo mklink ("propiedades/obras/") ?>">Obras</a>
				<a href="<?php echo mklink ("contacto/") ?>">Contacto</a>
		  </div>
		  <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
		  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
		    <i class="fa fa-bars"></i>
		  </a>
		</div>
	</div>
</header>