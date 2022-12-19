<?php include "includes/init.php";
$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id,array(
	"buscar_total_visitas"=>1,
	"buscar_relacionados_offset"=>8,
	"id_empresa"=>$id_empresa,
	"id_empresa_original"=>$empresa->id,
)); 

if (($propiedad === FALSE || !isset($propiedad->nombre) || $propiedad->activo == 0) && !isset($get_params["preview"])) {
  header("HTTP/1.1 302 Moved Temporarily");
  header("Location:".mklink("/"));
  exit();
}

$page_act = $propiedad->tipo_operacion_link;
// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad"=>$propiedad->id));
?> 
<!DOCTYPE html>
<html>
<head>
<?php include "includes/head.php" ?>
<?php include "../comun/og.php" ?>
<script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
<script>const ID_EMPRESA_RELACION = "<?php echo $id_empresa ?>";</script>
</head>
<body>
	<?php include "includes/header.php" ?>
	<section class="top-img">
		<div class="owl-carousel owl-theme">
			<?php $x=1;foreach ($propiedad->images as $img) {  ?>
				<div class="item" style="
				<?php if ($x==1)  { ?> width: 800px; <?php } ?>
				<?php if ($x==2)  { ?> width: 260px; <?php } ?>
				<?php if ($x==3)  { ?> width: 500px; <?php } ?>
				<?php if ($x==4)  { ?> width: 320px; <?php } ?>
				">
				<a class="fancybox" data-fancybox="gallery" href="<?php echo $img ?>">
					<img class="cover-height" src="<?php echo $img ?>">
				</a>
			</div>
			<?php if ($x==4){ $x=1; } else { $x++; }  } ?>
		</div>
	</section>
	<section class="supra-details">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-xs-12 box-full">
					<div class="price">
						<?php echo ($propiedad->precio_final !=0)?$propiedad->precio:"Consultar" ?>
			            <?php if ($propiedad->precio_porcentaje_anterior < 0.00 && $propiedad->publica_precio == 1) { ?>
			              <span class="dib" style="color: #0dd384;">(<img src="img/arrow_down.png" alt="Home" /> <?= floatval($propiedad->precio_porcentaje_anterior*-1) ?>%)</span>
			            <?php } ?>							
					</div>
					<div class="box-icon">
						<img src="img/icon-size-large.png">
						<div class="little-title">Sup. Total<br><span class="negritas"><?php echo (!empty($propiedad->superficie_total))?$propiedad->superficie_total:"-" ?>m2</span></div>
					</div>
					<div class="box-icon">
						<img src="img/icon-structure-large.png">
						<div class="little-title">Dormitorios<br><span class="negritas"><?php echo (!empty($propiedad->dormitorios))?$propiedad->dormitorios:"-" ?></span></div>
					</div>
					<div class="box-icon">
						<img src="img/icon-accommodation-large.png">
						<div class="little-title">Ambientes<br><span class="negritas"><?php echo (!empty($propiedad->ambientes))?$propiedad->ambientes:"-" ?></span></div>
					</div>
					<div class="box-icon">
						<img src="img/icon-bathrooms.png">
						<div class="little-title">Baños<br><span class="negritas"><?php echo (!empty($propiedad->banios))?$propiedad->banios:"-" ?></span></div>
					</div>
					<div class="button-top"><button onclick="document.getElementById('contacto_nombre').focus();" class="btn-yellow">CONSULTAR PROPIEDAD</button></div>
				</div>			
			</div>		
		</div>	
	</section>
	<section class="description">
		<div class="container">
			<div class="row">
				<div class="col-md-9 padding-movil">
					<div class="row big-title">
						<div class="nombre pull-left">
							<h2><?php echo $propiedad->nombre ?></h2>
							<h5><?php echo $propiedad->direccion_completa.", ".$propiedad->localidad ?></h5>
						</div>
						<div class="pull-right-reserve">
							<span class="labeled"><?php echo $propiedad->tipo_estado ?></span>
							<div class="font-size-11 pt20">CÓDIGO <span class="negritas"><?php echo $propiedad->codigo?></span></div>

						</div>	
					</div>
					<div class="clearfix"></div>
					<div class="row ptb35 border-bottom-services">
						<div class="col-md-3 p0"><h5 class="leyend-char">Descripción</h5></div>
						<div class="col-md-9">
							<?php echo $propiedad->texto ?>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row ptb35 border-bottom-services">
						<div class="col-md-3 p0"><h5 class="leyend-char">Detalles</h5></div>
						<div class="col-md-9">
							<div class="row">
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-arrows-alt-v"></i> Sup. Cubierta</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (!empty($propiedad->superficie_cubierta))?$propiedad->superficie_cubierta." m2":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-long-arrow-alt-down"></i> Sup. Descubierta</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (!empty($propiedad->superficie_descubierta))?$propiedad->superficie_descubierta." m2":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-expand-arrows-alt"></i> Sup. Semicubierta</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (!empty($propiedad->superficie_semicubierta))?$propiedad->superficie_semicubierta." m2":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-arrows-alt"></i> Sup. Total</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (!empty($propiedad->superficieto_total))?$propiedad->superficieto_total." m2":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-pencil-ruler"></i> Metros Frente</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (!empty($propiedad->metros_frente))?$propiedad->metros_frente." m2":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-pencil-ruler"></i> Metros Fondo</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (!empty($propiedad->metros_fondo))?$propiedad->metros_fondo." m2":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Tiene Patio</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->patio == "1"))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Tiene Balcón</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->balcon == "1"))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row ptb35 border-bottom-services">
						<div class="col-md-3 p0"><h5 class="leyend-char">Servicios</h5></div>
						<div class="col-md-9">
							<div class="row">
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Cloacas</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->servicios_cloacas == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Agua Corriente</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->servicios_agua_corriente == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Electricidad</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->servicios_electricidad == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Asfalto</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->servicios_asfalto == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Gas</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->servicios_gas == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Teléfono</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->servicios_telefono == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Cable</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->servicios_cable == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Aire Acondicionado</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->servicios_aire_acondicionado == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Uso Comercial</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->servicios_uso_comercial == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Internet</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->servicios_internet == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Gimnasio</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->gimnasio == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Parrilla</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->parrilla == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Piscina</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->piscina == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Vigilancia</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->vigilancia == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Sala de Juegos</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->sala_juegos == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Ascensor</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->ascensor == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Lavadero</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->lavadero == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Living Comedor</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->living_comedor == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Terraza</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->terraza == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Accesible</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->accesible == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Balcon</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->balcon == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> Patio</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (($propiedad->patio == 1))?"Sí":"-" ?>
										</div>										
									</div>
								</div>
								<div class="col-md-6 char-font">
									<div class="row">
										<div class="list-title col-md-7 col-xs-6"><i class="fa fa-warehouse"></i> Cocheras</div>
										<div class="pl50 negritas-low col-md-5 col-xs-6">
											<?php echo (!empty($propiedad->cocheras))?$propiedad->cocheras:"-" ?>
										</div>										
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- <?php $caracteristicas = explode(";;;",$propiedad->caracteristicas);?>
					<?php if (!empty($caracteristicas)) { ?>
						<div class="clearfix"></div>
						<div class="row ptb35 border-bottom-services">
							<div class="col-md-3 p0"><h5 class="leyend-char">Características</h5></div>
							<div class="col-md-9">
								<div class="row">
									<?php foreach ($caracteristicas as $c) {  ?>
										<div class="col-md-6 char-font">
											<div class="row">
												<div class="list-title col-md-7 col-xs-6"><i class="fa fa-check"></i> <?php echo $c ?></div>
												<div class="pl50 negritas-low col-md-5 col-xs-6">
													Sí
												</div>										
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?> -->
					<?php if ($propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
						<div class="clearfix"></div>
						<div class="row ptb35 border-bottom-services">
							<div class="col-md-3 p0"><h5 class="leyend-char">Ubicación</h5></div>
							<div class="col-md-9">
								<div id="mapid" style="height: 300px"></div>
							</div>
						</div>
					<?php } ?>
					<?php if (!empty($propiedad->video)) {  ?>
						<div class="clearfix"></div>
						<div class="row ptb35 border-bottom-services">
							<div class="col-md-3 p0"><h5 class="leyend-char">Video</h5></div>
							<div class="col-md-9 video">
								<?php echo $propiedad->video?>
							</div>
						</div>
					<?php } ?>
					<div class="clearfix"></div>
					<div class="row ptb35" id="relacionados">
						<?php if (isset($propiedad->relacionados) && sizeof($propiedad->relacionados)>0) { ?>
							<?php foreach ($propiedad->relacionados as $p) {  ?>
								<div class="col-md-3 col-xs-12 item-grid">
									<div class="image">
										<a href="<?php echo ($p->link_propiedad) ?>">
											<img class="cover" src="<?php echo $p->imagen ?>">
										</a>
										<span class="price"><?php echo ($p->precio_final != 0)?$p->precio:"Consultar"?></span>
										<!-- <span class="label"><?php echo $p->tipo_operacion?></span> -->
										<span class="id">COD <?php echo $p->codigo ?></span>
									</div>
									<div class="info">
										<a href="<?php echo ($p->link_propiedad) ?>">
											<h5 class="title"><?php echo $p->nombre ?></h5>
										</a>
										<?php if (!empty($p->direccion_completa)) {  ?><div class="address"><?php echo $p->direccion_completa.". ".$p->localidad?></div><?php } ?>
										<?php if (!empty($p->superficie_total)) {  ?><div class="property-data"><i class="fa fa-home"></i> <?php echo $p->superficie_total ?>m2 Sup. Total.</div><?php } ?>
									</div>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>	
				<div class="col-md-3 ptb35">
					<div class="sidebar">
						<form onsubmit="return enviar_contacto()">
							<h5>Consultar Propiedad</h5>
							<div style="padding: 27px 14px 17px">
								<input id="contacto_nombre" type="" placeholder="Nombre Completo" name="">
								<input id="contacto_telefono" type="text" placeholder="Teléfono" name="">
								<input id="contacto_email" type="text" placeholder="Email" name="">
								<textarea id="contacto_mensaje" type="text" placeholder="Mensaje" name=""></textarea>
								<button type="submit" class="btn-yellow">CONSULTAR</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php include "includes/footer.php" ?>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/owl.carousel.min.js"></script>
	<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
	<script src="js/jquery.fancybox.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script> -->
	<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
	<?php if ($propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
		<script type="text/javascript">
			var mymap = L.map('mapid').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);
	    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
	      tileSize: 512,
	      maxZoom: 18,
	      zoomOffset: -1,
	      id: 'mapbox/streets-v11',
	      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
	    }).addTo(mymap);

			var greenIcon = L.icon({
				iconUrl: 'img/pin.png',
iconSize:     [43, 60], // size of the icon
iconAnchor:   [22, 60], // point of the icon which will correspond to marker's location
});
			L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], {icon: greenIcon}).addTo(mymap);
		</script>
	<?php } ?>

	<script type="text/javascript">
		$('.owl-carousel').owlCarousel({
			margin:5,
			loop:true,
			dots:false,
			autoWidth:true,
			items:4
		})
		$('[data-fancybox="gallery"]').fancybox({
// Options will go here
});

</script>
<script type="text/javascript">
	var enviando = 0;
	function enviar_contacto() {
		if (enviando == 1) return;
		var nombre = $("#contacto_nombre").val();
		var email = $("#contacto_email").val();
		var telefono = $("#contacto_telefono").val();
		var mensaje = $("#contacto_mensaje").val();
		var id_propiedad = $("#contacto_id_propiedad").val();
		var id_origen = <?php echo (isset($id_origen) ? $id_origen : 0) ?>;

		if (isEmpty(nombre) || nombre == "Nombre") {
			alert("Por favor ingrese un nombre");
			$("#contacto_nombre").focus();
			return false;      
		}
		if (!validateEmail(email)) {
			alert("Por favor ingrese un email valido");
			$("#contacto_email").focus();
			return false;      
		}
		if (isEmpty(telefono) || telefono == "Telefono") {
			alert("Por favor ingrese un telefono");
			$("#contacto_telefono").focus();
			return false;      
		}
		if (isEmpty(mensaje) || mensaje == "Mensaje") {
			alert("Por favor ingrese un mensaje");
			$("#contacto_mensaje").focus();
			return false;        
		}  

		$("#contacto_submit").attr('disabled', 'disabled');
		var datos = {
			"para":"<?php echo $empresa->email ?>",
			"nombre":nombre,
			"email":email,
			"mensaje":mensaje,
			"telefono":telefono,
			"asunto":"Contacto para <?php echo $propiedad->nombre ?> (Cod: <?php echo $propiedad->codigo ?>)",
			"id_propiedad":id_propiedad,
			"id_empresa":ID_EMPRESA,
			<?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?>
				"id_empresa_relacion":"<?php echo $propiedad->id_empresa ?>",
			<?php } ?>
			"id_origen": ((id_origen != 0) ? id_origen : ((id_propiedad != 0)?1:6)),
		}
		enviando = 1;
		$.ajax({
			"url":"https://app.inmovar.com/admin/consultas/function/enviar/",
			"type":"post",
			"dataType":"json",
			"data":datos,
			"success":function(r){
				if (r.error == 0) {
			        window.location.href ='<?php echo mklink ("web/gracias/") ?>';
				} else {
					alert("Ocurrio un error al enviar su email. Disculpe las molestias");
					$("#contacto_submit").removeAttr('disabled');
					enviando = 0;
				}
			}
		});
		return false;
	}  
</script>
<script type="text/javascript">
// ===== Scroll to Top ==== 
$(window).scroll(function() {
if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
$('#return-to-top').fadeIn(200);    // Fade in the arrow
} else {
$('#return-to-top').fadeOut(200);   // Else fade out the arrow
}
});
$('#return-to-top').click(function() {      // When arrow is clicked
	$('body,html').animate({
scrollTop : 0                       // Scroll to top of body
}, 500);
});
</script>

<script type="text/javascript">
	/* Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu / bar icon */
	function myFunction() {
		var x = document.getElementById("myLinks");
		if (x.style.display === "block") {
			x.style.display = "none";
		} else {
			x.style.display = "block";
		}
	}

</script>
<?php 
// Creamos el codigo de seguimiento para registrar la visita
echo $propiedad_model->tracking_code(array(
  "id_propiedad"=>$propiedad->id,
  "id_empresa_compartida"=>$id_empresa,
  "id_empresa"=>$empresa->id,
));
?>
</body>
</html>