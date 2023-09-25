<header>
	<div class="container">
		<?php if (!empty($empresa->logo_1)) {  ?>
			<a href="<?php echo mklink ("/") ?>" class="logo">
				<img src="/admin/<?php echo $empresa->logo_1 ?>" alt="Logo">
			</a>
		<?php } ?>
		<nav class="navbar navbar-expand-xl">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item <?php echo ($page_act=="home")?"active":"" ?>">
						<a class="nav-link" href="<?php echo mklink ("/") ?>#about-us">Sobre Inmovar</a>
					</li>
					<li class="nav-item <?php echo ($page_act=="")?"active":"" ?>">
						<a class="nav-link" href="<?php echo mklink ("/") ?>#sales-solutions">Soluciones </a>
					</li>
					<li class="nav-item <?php echo ($page_act=="")?"active":"" ?>">
						<a class="nav-link" href="<?php echo mklink ("/") ?>#prices">Precios</a>
					</li>
					<li class="nav-item <?php echo ($page_act=="inmobiliarias")?"active":"" ?>">
						<a class="nav-link" href="<?php echo mklink ("entradas/inmobiliarias/") ?>">Inmobiliarias</a>
					</li>
					<li class="nav-item <?php echo ($page_act=="blog")?"active":"" ?>">
						<a class="nav-link" href="<?php echo mklink ("entradas/blog/") ?>">Blog</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" target="_blank" href="https://app.inmovar.com/admin/">Ingresar</a>
					</li>
					<li>
						<a class="btn btn-white" target="_blank" href="https://app.inmovar.com/admin/login/registro/">Registrate Gratis</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</header>