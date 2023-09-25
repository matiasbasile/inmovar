<header class="d-block d-sm-none">
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
						<a class="nav-link" href="<?php echo mklink ("/") ?>#sales-solutions">Soluciones</a>
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

<div class="d-none d-sm-block second-header">
	<div class="container mt40 mb40">
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="pull-left">
					<?php if (!empty($empresa->logo)) {  ?>
						<a href="<?php echo mklink ("/") ?>" class="logo">
							<img src="/admin/<?php echo $empresa->logo ?>" alt="Logo">
						</a>
					<?php } ?>
				</div>
				<div class="pull-right">
					<a class="btn btn-link" href="https://app.inmovar.com/admin/">Ingresar</a>
					<a href="https://app.inmovar.com/admin/login/registro/" class="btn btn-tile br50">REGISTRATE GRATIS</a>
				</div>		
			</div>
		</div>
	</div>
	<div class="my-header-2">
		<div class="container">
			<ul style="display: inline-flex;">
				<li class="nav-item <?php echo ($page_act=="home")?"active":"" ?>">
					<a class="nav-link" href="<?php echo mklink ("/") ?>#about-us">Sobre Inmovar</a>
				</li>
				<li class="nav-item <?php echo ($page_act=="")?"active":"" ?>">
					<a class="nav-link" href="<?php echo mklink ("/") ?>#sales-solutions">Soluciones</a>
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
			</ul>
			<div class="pull-right">
				<ul class="socials-links">
					<?php if (!empty($empresa->facebook)) {  ?><li class="fb"><a href="<?php echo $empresa->facebook ?>" target="_blank"></a></li><?php } ?>
					<?php if (!empty($empresa->instagram)) {  ?>
						<li class="insta"><a href="<?php echo $empresa->instagram ?>" target="_blank"></a></li>
					<?php } ?>
				</ul>
				
			</div>
		</div>
	</div>
</div>