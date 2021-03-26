<?php include "includes/init.php" ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?php include "includes/head.php" ?>
</head>
<body >

	<!-- Header -->
	<?php include "includes/header.php" ?>

	<!-- Top Banner -->
	<div style="height: 500px" id="mapid"></div>
	<section id="contacto">
		<div class="container">
			<div class="footer-middle">
				<div class="row">
					<div class="col-xl-3 col-lg-3"></div>
					<div class="col-xl-3 col-lg-3">
						<?php $t = $web_model->get_text("tit1","LA PLATA")?>
						<h6 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave?>">
							<?php echo $t->plain_text ?>
						</h6>
						<ul>
							<li>
								<a href="javascript:void(0)">
									<?php echo $empresa->direccion ?>
								</a>
							</li>
							<li>
								<?php $t = $web_model->get_text("text-2","(221) 424 0322")?>
								<a href="tel:<?php echo $t->plain_text ?>" class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave?>">
									<?php echo $t->plain_text ?>
								</a>
							</li>
						</ul>
					</div>
					<!-- <div class="col-xl-3 col-lg-3">
						<?php $t = $web_model->get_text("box2-tit1","BUENOS AIRES")?>
						<h6 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave?>">
							<?php echo $t->plain_text ?>
						</h6>
						<ul>
							<li>
								<?php $t = $web_model->get_text("box2-text-1","Av. Las Heras y Ugarteche")?>
								<a href="javascript:void(0)" class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave?>">
									<?php echo $t->plain_text ?>
								</a>
							</li>
							<li>
								<?php $t = $web_model->get_text("box2-text-2","(221) 424 0322")?>
								<a href="tel:<?php echo $t->plain_text ?>" class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave?>">
									<?php echo $t->plain_text ?>
								</a>
							</li>
						</ul>
					</div> -->
					<!-- <div class="col-xl-3 col-lg-3">
						<?php $t = $web_model->get_text("box3tit1","MAR DEL PLATA")?>
						<h6 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave?>">
							<?php echo $t->plain_text ?>
						</h6>
						<ul>
							<li>
								<?php $t = $web_model->get_text("box3text-1","O'Higgins y Buenos Aires")?>
								<a href="javascript:void(0)" class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave?>">
									<?php echo $t->plain_text ?>
								</a>
							</li>
							<li>
								<?php $t = $web_model->get_text("box3text-2","(221) 424 0322")?>
								<a href="tel:<?php echo $t->plain_text ?>" class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave?>">
									<?php echo $t->plain_text ?>
								</a>
							</li>
						</ul>
					</div> -->
					<div class="col-xl-3 col-lg-3">
						<?php $t = $web_model->get_text("box4tit1","VIAS DE COMUNICACIÓN")?>
						<h6 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave?>">
							<?php echo $t->plain_text ?>
						</h6>
						<ul>
							<li>
								<a href="mailto:<?php echo $empresa->email ?>">
									<?php echo $empresa->email ?>
								</a>
							</li>
							<li>
								<?php $t = $web_model->get_text("box4text-2","www.orlandobienesraices.com.ar")?>
								<a href="javascript:void(0)" class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave?>">
									<?php echo $t->plain_text ?>
								</a>
							</li>
						</ul>
					</div>
					<div class="col-xl-3 col-lg-3"></div>
					
				</div>
			</div>
		</div>
	</section>

	<section class="container" id="form-contact">
		<div class="row">
			<div class="col-md-12">
				<div class="property-full-info">
					<div class="box-space mb50">
						<h2 class="section-title text-center">Enviar consulta</h2>
						<div class="form">
							<form onsubmit="return enviar_contacto()">
								<div class="row">
									<div class="col-md-6">
										<input class="form-control" id="contacto_nombre" type="text" placeholder="Nombre *">
									</div>
									<div class="col-md-6">
										<input class="form-control" id="contacto_telefono" type="tel" placeholder="Teléfono *">
									</div>
									<div class="col-md-6">
										<input class="form-control" id="contacto_email" type="email" placeholder="Email *">
									</div>
									<div class="col-md-6">
										<select class="form-control" style="height: 100%">
											<option>Asunto</option>
											<?php $asuntos = explode(";;;",$empresa->asuntos_contacto);
											foreach($asuntos as $a) { ?>
												<option><?php echo $a ?></option>
											<?php } ?>
										</select>
									</select>
								</div>
								<div class="col-md-12">
									<textarea class="form-control" id="contacto_mensaje" placeholder="Escriba aquí su mensaje*"></textarea>
								</div>
								<div class="col-md-12">
									<div class="pull-right">
										<input type="submit" id="contacto_submit" value="enviar consulta" class="btn btn-red">
									</div>
								</div>
							</div>                
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Footer -->
<?php include "includes/footer.php" ?>


<!-- Back To Top -->
<div class="back-to-top"><a href="javascript:void(0);" aria-label="Back to Top">&nbsp;</a></div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/html5.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="assets/js/scripts.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
<?php if (!empty($empresa->latitud) && !empty($empresa->longitud)) { ?>
	<script type="text/javascript">
		$(document).ready(function(){

			var mymap = L.map('mapid').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

	    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
	      tileSize: 512,
	      maxZoom: 18,
	      zoomOffset: -1,
	      id: 'mapbox/streets-v11',
	      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
	    }).addTo(mymap);


			var icono = L.icon({
				iconUrl: 'assets/images/map-logo.png',
		      iconSize:     [101, 112], // size of the icon
		      iconAnchor:   [50, 112], // point of the icon which will correspond to marker's location
		    });

			L.marker([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>],{
				icon: icono
			}).addTo(mymap);
		});
	</script>
<?php } ?>
<script type="text/javascript">
	function enviar_contacto() {

		var nombre = $("#contacto_nombre").val();
		var email = $("#contacto_email").val();
		var mensaje = $("#contacto_mensaje").val();
		var asunto = $("#contacto_asunto").val();
		var telefono = $("#contacto_telefono").val();
		var para = "<?php echo $empresa->email ?>";

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
		if (isEmpty(mensaje) || mensaje == "Mensaje") {
			alert("Por favor ingrese un mensaje");
			$("#contacto_mensaje").focus();
			return false;              
		}    

		$("#contacto_submit").attr('disabled', 'disabled');
		var datos = {
			"para":para,
			"nombre":nombre,
			"email":email,
			"mensaje":mensaje,
			"asunto":"CONTACTO POR: "+asunto,
			"telefono":telefono,
			"id_empresa":ID_EMPRESA,
			"bcc":"basile.matias99@gmail.com",
		}
		$.ajax({
			"url":"/admin/consultas/function/enviar/",
			"type":"post",
			"dataType":"json",
			"data":datos,
			"success":function(r){
				if (r.error == 0) {
					alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
				} else {
					alert("Ocurrio un error al enviar su email. Disculpe las molestias");
					$("#contacto_submit").removeAttr('disabled');
				}
			}
		});
		return false;
	}
</script>
</body>
</html>