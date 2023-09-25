<?php include "includes/init.php" ?>
<?php 
$orden = "A.fecha DESC";
if (isset ($get_params['orden'])) {
	if ($get_params['orden']=='nuevo') { 
		$orden = "A.id DESC" ; }
		elseif ($get_params['orden']=='viejo') {
			$orden = "A.id ASC" ; }
		} 
		$offset = 24 ;
		$link_cat = "";
		$page = 0 ; 
		$link_general = "entradas/";
		$id_categoria = 0;
		$categorias = array();
		$nombre_pagina = "Información";
		for($i=1;$i<(sizeof($params));$i++) {
// Nombre de categoria
			$p = $params[$i];
			$sql = "SELECT * FROM not_categorias WHERE link = '".$p."' AND id_empresa = $empresa->id ";
			$q = mysqli_query($conx,$sql);
			if (mysqli_num_rows($q)>0) {
				$cat = mysqli_fetch_object($q);
				$categorias[] = $cat;
				$id_categoria = $cat->id;
				$path_cat = $cat->path;
				$cat_link = $cat->link;
				$page_act = $cat->link;
				$id_padre = $cat->id_padre;
				$subcat = $cat->link;
				$nombre_pagina = ($cat->nombre);
				$link_general.= $cat->link.'/' ;
			} else {
// Si el ultimo parametro es un numero, es porque indica el numero de pagina
				if (is_numeric($p) && ($i == sizeof($params)-1)) {
					$page = (int)$p;
				} else {
// La categoria no es valida, directamente redireccionamos
					header("Location: /404.php");          
				}
			}
		}
		if($page_act=="novedades" or $page_act == "tutoriales"){ $page_act="blog";}
		$listado = $entrada_model->get_list(array(
			'from_id_categoria'=>$id_categoria,
			"offset"=>$offset,
			"order_by"=>"A.fecha DESC",
			"limit"=>($page * $offset),
		)) ;

//si hay uno solo redirige
// if (sizeof($listado)==1) { 
// $e=$listado[0];
// header("location:". mklink($e->link));
// }
		$total = $entrada_model->get_total_results();
		$total_paginas = ceil ($total / $offset);
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<?php include "includes/head.php" ?>
		</head>
		<body id="listado">
			<?php include "includes/header2.php" ?>
			<section class="page-title">
				<div class="container">
					<h1><?php echo ($cat_link == "inmobiliarias")?"Inmobiliarias":"Blog" ?></h1>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo mklink ("/") ?>">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page"><?php echo (!empty($nombre_pagina))?$nombre_pagina:"Blog" ?></li>
						</ol>
					</nav>
				</div>
			</section>
			<section class="blog listing">
				<div class="container">
					<div class="title-wrap">
						<div class="section-title">
							<h2><?php echo ($cat_link == "inmobiliarias")?"Inmobiliarias en la red":"Últimas novedades" ?></h2>
							<p class="m0 p0"><?php echo $total?> 
								<?php if ($cat_link == "inmobiliarias") {  ?>
									Inmobiliaria<?php echo (sizeof($listado) > 1)?"s":""?> activas
								<?php } else { ?>
									Noticia<?php echo (sizeof($listado) > 1)?"s":""?> en el blog
								<?php } ?>
							</p>
						</div>
						<?php if ($cat_link != "inmobiliarias") {  ?>
							<div class="blog-filter">
								<select id="orden_entradas" onchange="filtrar()" name="orden" style="height: 30px" class="form-control newer-select">
									<option <?php echo ($orden == "A.id DESC" ) ? "selected" : "" ?> value="nuevo">Ver los más nuevos</option>
									<option <?php echo ($orden == "A.id ASC" ) ? "selected" : "" ?> value="viejo">Ver los más viejos</option>
								</select>
								<?php ?>
								<select style="color: white" id="dynamic_select" class="form-control <?php echo ($id_padre == 0)?"newer":"category" ?>-select">
									<option value="">Categoría</option>
									<?php $cats = $entrada_model->get_subcategorias(1629)?>
									<?php foreach ($cats as $c) {  ?>
										<option value="<?php echo mklink ("entradas/blog/$c->link/") ?>" <?php echo ($c->id == $id_categoria)?"selected":"" ?> ><?php echo ($c->nombre) ?></option>
									<?php } ?>
								</select>
							</div>
						<?php } ?>
					</div>
					<div class="row">
						<?php foreach ($listado as $l) {  ?>	
							<div class="col-lg-4 col-md-6">
								<div class="blog-item">
									<div class="blog-picture">
										<a <?php echo ($cat_link=="inmobiliarias")?'target="_blank"':"" ?> href="<?php echo ($cat_link=="inmobiliarias")?$l->fuente:mklink ($l->link) ?>">
											<img src="<?php echo $l->path ?>" style="object-fit: cover;height: 220px; width: 100%" alt="Blog">
										</a>
										<?php if ($cat_link != "inmobiliarias") {  ?>
											<div class="blog-time">
												<span><?php echo substr($l->fecha,0,2) ?></span>
												<div class="clear"><?php echo get_mes(substr($l->fecha,3,5))." ".substr($l->fecha,6,10) ?></div>
											</div>
										<?php } ?>
									</div>
									<?php if ($cat_link != "inmobiliarias") {  ?>
										<div class="blog-content equal">
											<h3><a href="<?php echo mklink ($l->link) ?>"><?php echo $l->titulo ?></a></h3>
											<div class="blog-category"><i class="fa fa-user"></i> Categoría: <a href="javascript:void(0)"><?php echo $l->categoria ?></a></div>
											<div class="blog-date"><i class="fa fa-calendar"></i> <?php echo $l->fecha ?></div>
											<div class="block"><a href="<?php echo mklink ($l->link) ?>" class="btn">Leer Más</a></div>
										</div>
									<?php } else { ?>
										<div class="blog-content equal" id="inmolist">
											<h3><a href="<?php echo ($l->fuente) ?>" target="_blank"><?php echo $l->titulo ?></a></h3>
											<div class="blog-category"><i class="fa fa-whatsapp"></i> <a href="https://api.whatsapp.com/send?phone=<?php echo $l->subtitulo ?>"><?php echo $l->subtitulo ?></a></div>
											<div class="blog-date"><i class="fa fa-envelope"></i> <?php echo $l->descripcion ?></div>
											<div class="block"><a href="<?php echo ($l->fuente) ?>" target="_blank" class="btn">visitar web</a></div>
										</div>
									<?php } ?>

									
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</section>

			<!-- Navigation -->
			<?php  if ($total_paginas > 1 ) {  ?>
				<nav class="pagination-wrap" aria-label="navigation">
					<ul class="pagination">
						<?php if ($page > 0) {  ?>
							<li class="page-item">
								<a class="page-link" href="<?php echo mklink ($link_general.($page-1)."/") ?>" aria-label="Previous">
									<span><i class="fa fa-chevron-left"></i></span>
								</a>
							</li>
						<?php } ?>
						<?php for($i=0;$i<$total_paginas;$i++) { ?>
							<?php if (abs($page-$i)<3) { ?>
								<?php if ($i == $page) { ?>
									<li class="page-item active"><a class="page-link"><?php echo $i+1 ?></a></li>
								<?php } else { ?>
									<li class="page-item"><a class="page-link" href="<?php echo mklink ($link_general.$i."/") ?>"><?php echo $i+1 ?></a></li>
								<?php } ?>  
							<?php } ?>
						<?php } ?>
						<?php if ($page < $total_paginas-1) { ?>

							<li class="page-item">
								<a class="page-link" href="<?php echo mklink ($link_general.($page+1)."/") ?>" aria-label="Next">
									<span><i class="fa fa-chevron-right"></i></span>
								</a>
							</li>
						<?php } ?>

					</ul>
				</nav>
			<?php } ?>
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
			<script>

				$(function(){
		      // bind change event to select
		      $('#dynamic_select').on('change', function () {
		          var url = $(this).val(); // get selected value
		          if (url) { // require a URL
		              window.location = url; // redirect
		            }
		            return false;
		          });
		    });
		  </script>
		  <script type="text/javascript">
		  	function filtrar() {
		  		var orden = $("#orden_entradas").val();
		  		var url = "<?php echo mklink("entradas/$subcat/"); ?>";
		  		url+="?orden="+orden
		  		location.href=url;  
		  	}
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
						"url":"/sistema/consultas/function/enviar/",
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