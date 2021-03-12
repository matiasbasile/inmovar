<?php 
include("includes/init.php");
extract($propiedad_model->get_variables());
$page_act = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?php include "includes/head.php" ?>
</head>
<body>

	<!-- Header -->
	<?php include "includes/header.php" ?>

	<!-- Page Title -->
	<div class="page-title">
		<div class="container">
			<div class="page">
				<div class="breadcrumb"> <a href="javascript:void(0)"><?php echo (!empty($vc_tipo_operacion))?$vc_tipo_operacion:"Propiedades" ?></a> <span><?php echo sizeof($vc_listado) ?> Resultados de búsqueda encontrados</span></div>
				<div class="float-right">
					<big>Tus favoritas</big> 
					<a href="<?php echo mklink ("favoritos/")?>"><i class="fas fa-heart"></i> <span><?php echo $cant_favoritos ?></span></a>
				</div>
			</div>
		</div>
	</div>

	<!-- Products Listing -->
	<div class="products-listing">
		<div class="container">
			<div class="row">
				<div class="col-xl-8">
					<div class="filter-box">
						<ul class="nav nav-tabs">
							<li><a class="active" data-toggle="tab" href="#grid"><i class="fas fa-th"></i></a></li>
							<li><a data-toggle="tab" href="#list"><i class="fas fa-list"></i></a></li>
						</ul>
						<div class="select-box">
							<span>Ordenar por:</span>
							<select class="form-control" onchange="submit_buscador_propiedades()" id="ordenador_orden" name="orden">
								<option <?php echo ($vc_orden == 4 ) ? "selected" : "" ?> value="destacados">Destacados</option>
								<option <?php echo ($vc_orden == -1 ) ? "selected" : "" ?> value="nuevo">Ver los más nuevos</option>
								<option <?php echo ($vc_orden == 2 ) ? "selected" : "" ?> value="barato">Precio menor a mayor</option>
								<option <?php echo ($vc_orden == 1 ) ? "selected" : "" ?> value="caro">Precio mayor a menor</option>
							</select>
						</div>
						<div class="select-box">
							<span>Mostrar:</span>
							<select class="form-control small" onchange="submit_buscador_propiedades()" id="ordenador_offset" name="offset">
								<option <?php echo ($vc_offset == "24")?"selected":"" ?> value="24">24</option>
								<option <?php echo ($vc_offset == "36")?"selected":"" ?> value="36">36</option>
							</select>
						</div>
						<?php if ($vc_total_paginas > 1) {  ?>
							<nav aria-label="Page navigation">
								<ul class="pagination">
									<?php if ($vc_page > 0) { ?>
										<li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"><i class="fas fa-chevron-left"></i></a></li>
									<?php } ?>
									<?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
										<?php if (abs($vc_page-$i)<2) { ?>
											<?php if ($i == $vc_page) { ?>
												<li class="page-item"><a class="page-link active" href="javascript:void(0)"><?php echo $i+1 ?></a></li>
											<?php } else { ?>
												<li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.$i."/".$vc_params ) ?>"><?php echo $i+1 ?></a></li>
											<?php } ?>
										<?php } ?>
									<?php } ?>
									<?php if ($vc_page < $vc_total_paginas-1) { ?>
										<li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params ) ?>"><i class="fas fa-chevron-right"></i></a></li>
									<?php } ?>
								</ul>
							</nav>
						<?php } ?>
					</div>
					<div class="tab-content">
						<div id="grid" class="tab-pane fade in active list-wise">
							<div class="row">
								<?php if (!empty($vc_listado)) {  ?>
									<?php foreach ($vc_listado as $p) {  ?>
										<div class="col-lg-6">
											<div class="property-box">
												<div class="property-img">
													<div class="owl-carousel" data-items="1" data-margin="0" data-items-lg="1" data-loop="true" data-nav="false" data-dots="true">
														<?php $prop = $propiedad_model->get($p->id)?>
														<?php if (!empty($prop->images)) {  ?>
															<?php $x=0;foreach ($prop->images as $i) { 
																if ($x<5) {   ?>
																<div class="item">
																	<img class="cover-recientes" src="<?php echo $i ?>" alt="Property Img">
																	<div class="rollover">
																		<a href="<?php echo ($prop->link_propiedad) ?>" class="add"></a>
																		<?php if (estaEnFavoritos($prop->id)) { ?>
																			<a class="heart" data-bookmark-state="added" href="/admin/favoritos/eliminar/?id=<?php echo $prop->id; ?>">
																			</a>
																		<?php } else { ?>
																			<a class="heart" data-bookmark-state="empty" href="/admin/favoritos/agregar/?id=<?php echo $prop->id; ?>">
																			</a>
																		<?php } ?>
																	</div>
																</div>
															<?php $x++;} ?>
															<?php }  ?>
														<?php } else { ?>
															<div class="item">
																<img class="cover-recientes" src="/admin/<?php echo $p->path ?>" alt="Property Img">
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
														<?php }?>
													</div>
												</div>
												<div class="property-details">
													<div class="property-top">
														<h3><?php echo $p->nombre ?></h3>
													</div>
													<div class="property-middle">
														<ul>
																<li><img src="assets/images/home.png" alt="Home"> <?php echo (!empty($p->superficie_total))?$p->superficie_total:"-" ?> mts2</li>
																<li><img src="assets/images/beds.png" alt="Beds"> <?php echo (!empty($p->dormitorios))?$p->dormitorios:"-" ?></li>
																<li><img src="assets/images/parking.png" alt="Parking"> <?php echo (!empty($p->cocheras))?$p->cocheras:"-" ?></li>
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
								<?php } else {  ?>
									<div class="col-lg-12">
										<h3>No se encontraron resultados para su búsqueda.</h3>
									</div>
								<?php } ?>
							</div>
						</div>
						<div id="list" class="tab-pane fade in list-wise">
							<div class="row">
								<?php if (!empty($vc_listado)) {  ?>
									<?php foreach ($vc_listado as $p) {  ?>     
										<div class="col-md-12">
											<div class="property-box">
												<div class="property-img" style="min-height: 202px">
													<img class="cover-list" src="/admin/<?php echo $p->path ?>" alt="Property Img">
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
													<div class="property-top" style="min-height: 202px">
														<h3><?php echo $p->nombre ?></h3>
														<p><?php echo substr($p->texto,0,150); echo (strlen($p->texto) > 150)?"...":"" ?></p>
													</div>
													<div class="property-middle">
														<ul>
															<?php if ($p->superficie_total != 0) {  ?>
																<li><img src="assets/images/home.png" alt="Home"> <?php echo $p->superficie_total ?> mts2</li>
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
														<a class="btn btn-red" href="<?php echo mklink ($p->link) ?>">ver más</a>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php if ($vc_total_paginas > 1) {  ?>
						<nav aria-label="Page navigation">
							<ul class="pagination">
								<?php if ($vc_page > 0) { ?>
									<li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"><i class="fas fa-chevron-left"></i></a></li>
								<?php } ?>
								<?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
									<?php if (abs($vc_page-$i)<2) { ?>
										<?php if ($i == $vc_page) { ?>
											<li class="page-item"><a class="page-link active" href="javascript:void(0)"><?php echo $i+1 ?></a></li>
										<?php } else { ?>
											<li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.$i."/".$vc_params ) ?>"><?php echo $i+1 ?></a></li>
										<?php } ?>
									<?php } ?>
								<?php } ?>
								<?php if ($vc_page < $vc_total_paginas-1) { ?>
									<li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params ) ?>"><i class="fas fa-chevron-right"></i></a></li>
								<?php } ?>
							</ul>
						</nav>
					<?php } ?>
				</div>
				<div class="col-xl-4">
					<div class="border-box">
						<?php include "includes/search-filter.php" ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Call To Action -->
	<?php include "includes/comunicate.php" ?>

	<!-- Footer -->
	<?php include "includes/footer.php" ?>

	<!-- Back To Top -->
	<div class="back-to-top"><a href="javascript:void(0);" aria-label="Back to Top">&nbsp;</a></div>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/html5.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	<script src="assets/js/nouislider.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script src="assets/js/scripts.js"></script>
	<script type="text/javascript">
		function submit_buscador_propiedades() {
  // Cargamos el offset y el orden en este formulario
  $("#sidebar_orden").val($("#ordenador_orden").val());
  $("#sidebar_offset").val($("#ordenador_offset").val());
  $("#form_propiedades").submit();
}
function onsubmit_buscador_propiedades() { 
	var link = (($("input[name='tipo_busqueda']:checked").val() == "mapa") ? "<?php echo mklink("mapa/")?>" : "<?php echo mklink("propiedades/")?>");
	var tipo_operacion = $("#tipo_operacion").val();
	var localidad = $("#localidad").val();
	var tipo_propiedad = $("#tp").val();
	link = link + tipo_operacion + "/" + localidad + "/<?php echo $vc_params?>";

	$("#form_propiedades").attr("action",link);
	return true;
}
</script>
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

</body>
</html>