<?php include "includes/init.php";
extract($propiedad_model->get_variables(array(
	"offset"=>9,
))); ?>
<!DOCTYPE html>
<html>
<head>
	<?php include "includes/head.php" ?>
</head>
<body id="list">
	<?php include "includes/header.php" ?>
	<section class="listado">
		<div class="container-fluid">
			<div class="row">
				<div class="columna-uno">
					<div class="clearfix"></div>
					<form  id="form_propiedades" onsubmit="enviar_buscador_propiedades()">
						<div class="row mt40 mb40md">
							<div class="col-md-6 pl15">
								<label style="font-size: 14px">Tipo de Propiedad</label>
								<select class="my-select" name="tp">
									<?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades()?>
									<option value="todas">Todas</option>
									<?php foreach ($tipos_propiedades as $t) {  ?>
										<option value="<?php echo $t->id ?>" <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $t->id) ? "selected" : "" ?>><?php echo $t->nombre ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-6">
								<label class="mylabel">Localización</label>
								<select class="my-select" id="localidad">
									<?php $localidades = $propiedad_model->get_localidades()?>
									<option value="todas">Todas</option>
									<?php foreach ($localidades as $t) {  ?>
										<option value="<?php echo $t->link ?>" <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $t->link) ? "selected" : "" ?>><?php echo $t->nombre ?></option>
									<?php } ?>
								</select>
							</div>
							<!-- <div class="col-md-9 inline-icons-search"> -->
								<!-- <div class="my-custom-input-label-box box-one">
									<input <?php echo ($vc_id_tipo_inmueble == "11")?"checked ":"" ?> style="display: none" id="myInput" type="radio" value="11" class="MyCheck" name="tp"/>
									<label for="myInput">Oficina</label>
								</div>
								<div class="my-custom-input-label-box box-two">
									<input <?php echo ($vc_id_tipo_inmueble == "9")?"checked ":"" ?> style="display: none" id="myInput2" type="radio" value="9" class="MyCheck" name="tp"/>
									<label for="myInput2">Local Comercial</label>
								</div> -->
								<!-- <div class="my-custom-input-label-box box-three">
									<input <?php echo ($vc_link_tipo_operacion == "ventas")?"checked ":"" ?> style="display: none" id="myInput3" type="radio" value="ventas" class="MyCheck" id="tipo_operacion"/>
									<label for="myInput3">Venta</label>
								</div>
								<div class="my-custom-input-label-box box-four">
									<input <?php echo ($vc_link_tipo_operacion == "alquileres")?"checked ":"" ?> style="display: none" id="myInput4" type="radio" value="alquileres" class="MyCheck" id="tipo_operacion"/>
									<label for="myInput4">Alquiler</label>
								</div>
								<div class="my-custom-input-label-box box-five">
									<input <?php echo ($vc_link_tipo_operacion == "emprendimientos")?"checked ":"" ?> style="display: none" id="myInput5" type="radio" value="emprendimientos" class="MyCheck" id="tipo_operacion"/>
									<label for="myInput5">Emprendimientos</label>
								</div> -->
								<!-- <div class="my-custom-input-label-box box-six">
									<input <?php echo ($vc_id_tipo_inmueble == "1")?"checked ":"" ?> style="display: none" id="myInput6" type="radio" value="1" class="MyCheck" name="tp"/>
									<label for="myInput6">Casa</label>
								</div> -->
							<!-- </div> -->
						</div>				
						<div class="row">
							<div class="col-md-3 bordered-right">
								<label class="mylabel">Dormitorios</label>
								<select name="dm" class="my-select">
									<?php $dormitorios = $propiedad_model->get_dormitorios()?>
									<option value="">Todos</option>
									<?php foreach ($dormitorios as $t) {  ?>
										<option value="<?php echo $t->dormitorios ?>" <?php echo (isset($vc_dormitorios) && $vc_dormitorios == $t->dormitorios) ? "selected" : "" ?>><?php echo $t->dormitorios ?></option>
									<?php } ?>
								</select>

							</div>
							<div class="col-md-9 inline">
								<div class="wautom bordered-right mt20bath">
									<label class="mylabel">Baños</label><br>
									<select name="bn" class="my-select bath">
										<?php $banios = $propiedad_model->get_banios()?>
										<option value="">Todos</option>
										<?php foreach ($banios as $t) {  ?>
											<option value="<?php echo $t->banios ?>" <?php echo (isset($vc_banios) && $vc_banios == $t->banios) ? "selected" : "" ?>><?php echo $t->banios ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="inline">
									<!-- <div class="wautom mr10 ">
										<label class="mylabel">Moneda</label><br>
										<select name="m" class="my-select moneda">
											<option <?php echo (isset($vc_moneda) && $vc_moneda == "ARS")?"selected":"" ?> value="ARS">$</option>
											<option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">U$D</option>
										</select>
									</div> -->
									<div class="wautom precios-range">
										<label class="mylabel">Rango de Precios</label><br>
										<input  name="vc_minimo" type="" placeholder="min" value="<?php echo (isset($vc_minimo) ? (($vc_minimo == 0)?"":$vc_minimo) : "") ?>" name="" class="input-listado">
									</div>
									<div class="wautom">
										<label class="mylabel"><br></label><br>
										<input  name="vc_maximo" type="" placeholder="max" value="<?php echo (isset($vc_maximo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>" name="" class="input-listado">
									</div>															
								</div>
							<!-- 	<div class="mt40 ml20">
									<input <?php echo (isset($vc_apto_banco) && $vc_apto_banco == "1")?"checked":"" ?> type="checkbox" value="1" name="banco">
									<label>Apto Crédito Bancario</label>
								</div>
								<div class="mt40 ml20">
									<input <?php echo (isset($vc_acepta_permuta) && $vc_acepta_permuta == "1")?"checked":"" ?> type="checkbox" value="1" name="per">
									<label>Acepta Permuta</label>
								</div> -->
								<div class="wautom">
									<button class="btn-yellow specialbtn" type="submit">BUSCAR</button>
								</div>

							</div>
						</div>
						<div class="clearfix"></div>
						<div class="row mb40md">
							<?php if (sizeof($vc_listado) > 0) {  ?>
								<?php foreach ($vc_listado as $p) {  ?>
									<div class="col-md-3 p08">
										<div class="item-grid">
											<div class="image">
												<a href="<?php echo ($p->link_propiedad) ?>">
													<img class="cover" src="/admin/<?php echo $p->path ?>">
												</a>
												<span class="price"><?php echo ($p->precio_final != 0)?$p->precio:"Consultar"?></span>
												<span class="label"><?php echo $p->tipo_operacion?></span>
												<?php if ($p->codigo != 0) { ?>
													<span class="id">COD <?php echo $p->codigo ?></span>
												<?php } ?>
											</div>
											<div class="info">
												<a href="<?php echo ($p->link_propiedad) ?>">
													<h5 class="title"><?php echo $p->nombre ?></h5>
												</a>
												<?php if (!empty($p->direccion_completa)) {  ?><div class="address"><?php echo $p->direccion_completa.". ".$p->localidad?></div><?php } ?>
												<?php if (!empty($p->superficie_total)) {  ?><div class="property-data"><i class="fa fa-home"></i> <?php echo $p->superficie_total ?>m2 Sup. Total.</div><?php } ?>
											</div>
										</div>	
									</div>
								<?php } ?>
							<?php } else {  ?>
								<div class="container">
									<h5>No se encontraron resultados para su búsqueda. </h5>	
								</div>
							<?php } ?>
						</div>
					</form>

					<?php if ($vc_total_paginas > 1) {  ?>
						<div class="listing_pagination text-center">
							<ul>
								<?php if ($vc_page > 0) { ?>
									<li class="prev_list"><a href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
								<?php } ?>
								<?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
									<?php if (abs($vc_page-$i)<2) { ?>
										<?php if ($i == $vc_page) { ?>
											<li class="active"><a><span><?php echo $i+1 ?></span></a></li>
										<?php } else { ?>
											<li class=""><a href="<?php echo mklink ($vc_link.$i."/".$vc_params ) ?>"><span><?php echo $i+1 ?></span></a></li>
										<?php } ?>
									<?php } ?>
								<?php } ?>
								<?php if ($vc_page < $vc_total_paginas-1) { ?>
									<li class="next_list"><a href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params ) ?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
								<?php } ?>
							</ul>
						</div>
					<?php } ?>

				</div>
				<div class="columna-dos">
					<div id="mapa_propiedades" style="height: 100%; min-height: 300px;"></div>
				</div>
			</div>
		</div>
	</section>

	<?php include "includes/footer.php" ?>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
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
<script type="text/javascript">
	$('.MyCheck').on('change', function() {
		$('.MyCheck').not(this).prop('checked', false);
	});
</script>

<?php include_once("templates/comun/mapa_js.php"); ?>

<script type="text/javascript">
	$(document).ready(function(){

		var mymap = L.map('mapa_propiedades').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

		L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
			attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
			tileSize: 512,
			maxZoom: 18,
			zoomOffset: -1,
			id: 'mapbox/streets-v11',
			accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
		}).addTo(mymap);


/*
var icono = L.icon({
iconUrl: "images/map-marker.png",
iconSize:     [44,50], // size of the icon
iconAnchor:   [44,25], // point of the icon which will correspond to marker's location
});
*/

mymap.fitBounds([
	<?php foreach($vc_listado as $p) {
		if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) {  ?>
			[<?php echo $p->latitud ?>,<?php echo $p->longitud ?>],
		<?php } ?>
	<?php } ?>
	]);

<?php $i=0;
foreach($vc_listado as $p) {
	if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) { 
		$path = "images/no-imagen.png";
		if (!empty($p->imagen)) { 
			$path = $p->imagen;
		} else if (!empty($empresa->no_imagen)) {
			$path = "/admin/".$empresa->no_imagen;
		} ?>
		var contentString<?php echo $i; ?> = '<div>'+
		'<div class="feature-item" style="padding: 0px;">'+
		'<div class="feature-image">'+
		'<a href=\"<?php echo ($p->link_propiedad) ?>\">'+
		'<img style="" src=\"<?php echo $path ?>\"/>'+
		'</a>'+
		'</div>'+
		'<div class="tab_list_box_content">'+
		'<h6 class="title-map"><a href=\"<?php echo ($p->link_propiedad) ?>\"><?php echo ($p->nombre) ?></a></h6>'+
		'<p>'+
		'<?php echo $p->direccion_completa.". ".$p->localidad ?>' +
		'</p>'+
		'</div>'+
		'</div>'+
		'</div>';

		var marker<?php echo $i; ?> = L.marker([<?php echo $p->latitud ?>,<?php echo $p->longitud ?>],{
//icon: icono
});
		marker<?php echo $i; ?>.addTo(mymap);

		marker<?php echo $i; ?>.bindPopup(contentString<?php echo $i; ?>);

	<?php } ?>
	<?php $i++; } ?>
});
</script>
<script type="text/javascript">
	function enviar_buscador_propiedades() { 
		var link = "<?php echo mklink("propiedades/")?>";
		var tipo_operacion = $('input[type="radio"]:checked').val();
		var localidad = $("#localidad").val();
		link = link + tipo_operacion + "/" + localidad + "/";
		$("#form_propiedades").attr("action",link);
		return true;
	}
</script>
</body>
</html>