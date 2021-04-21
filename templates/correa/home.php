<?php include "includes/init.php" ?>
<?php $page_act = "home" ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?php include "includes/head.php" ?>
</head>
<body>

	<?php include "includes/header.php"  ?>

	<!-- Banner Section -->
	<?php $slides = $web_model->get_slider()?>
	<section class="banner">
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<?php $x=0;foreach ($slides as $s) { ?>
					<div class="carousel-item <?php echo ($x==0)?"active":"" ?>" style="background: url(<?php echo $s->path ?>) no-repeat 50% 0; background-size: cover;"></div>
					<?php $x++; } ?>
					<ol class="carousel-indicators">
						<?php $x=0; foreach ($slides as $s) {  ?>
							<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $x ?>" class="<?php echo ($x==0)?"active":"" ?>"></li>
							<?php $x++; }?>
						</ol>
					</div>
				</div>
				<div class="carousel-caption">
					<form onsubmit="filtrar()" id="form_propiedades" >
						<div class="row">
							<div class="col-xl-3 col-md-6">
								<?php $tipos_op = $propiedad_model->get_tipos_operaciones()?>
								<select class="form-control" id="tipo_operacion">
									<option value="todas">Tipo de Operación</option>
									<?php foreach ($tipos_op as $tp) {  ?>
										<option value="<?php echo $tp->link ?>"><?php echo $tp->nombre ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-xl-3 col-md-6">
								<?php $tipos_prop = $propiedad_model->get_tipos_propiedades()?>
								<select class="form-control" id="tp" name="tp">
									<option value="todas">Tipo de Propiedad</option>
									<?php foreach ($tipos_prop as $tp) {  ?>
										<option value="<?php echo $tp->id ?>"><?php echo $tp->nombre ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-xl-4 col-md-6">
								<?php $localidades = $propiedad_model->get_localidades()?>
								<select class="form-control" id="localidad">
									<option value="todas">Localidades</option>
									<?php foreach ($localidades as $tp) {  ?>
										<option value="<?php echo $tp->link ?>"><?php echo $tp->nombre ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-xl-2 col-md-6">
								<button type="submit" class="btn btn-secoundry">Buscar</button>
							</div>
						</div>
					</form>
				</div>
			</section>

			<!-- Product Listing -->
			<section class="product-listing">
				<div class="container">
					<div class="section-title">
						<h1>Propiedades Destacadas</h1>
					</div>
					<div class="row">
						<?php $propiedades = $propiedad_model->get_list(array("destacado"=>1,"offset"=>12))?>
						<?php foreach ($propiedades as $p) {   
							$link_propiedad = (isset($p->pertenece_red) && $p->pertenece_red == 1) ? mklink($p->link)."&em=".$p->id_empresa : mklink($p->link); ?>
							<div class="col-xl-4 col-lg-6 col-md-6">
								<div class="product-list-item">
									<div class="product-img">
										<a href="<?php echo ($p->link_propiedad) ?>"><img class="cover-home" src="<?php echo $p->imagen ?>" alt="Product"></a>
									</div>
									<div class="product-details">
										<h4><?php echo $p->nombre ?></h4>
											<h5>
												<?php echo $p->direccion_completa ?>
												<?php if (!empty($p->localidad)) { ?>
												&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo ($p->localidad); ?>
												<?php } ?>
											</h5>
											<ul>
												<li>
													<strong><?php echo $p->precio ?></strong>
												</li>
											</ul>
											<div class="average-detail">
												<?php if ($p->dormitorios != 0) {  ?><span><img src="assets/images/badroom-icon.png" alt="Badroom Icon"> <?php echo $p->dormitorios  ?></span><?php } ?>
												<?php if ($p->banios != 0) {  ?><span><img src="assets/images/shower-icon.png" alt="Shower Icon"> <?php echo $p->banios ?></span><?php  } ?>
												<?php if ($p->superficie_total != 0) {  ?>	<span><img src="assets/images/sqft-icon.png" alt="SQFT Icon"> <?php echo $p->superficie_total ?> m2</span><?php } ?>
											</div>
											<div class="btns-block">
												<a href="<?php echo ($p->link_propiedad) ?>" class="btn btn-secoundry">Ver Detalles</a>
												<a href="<?php echo ($p->link_propiedad) ?>#contacto_nombre" class="icon-box"></a>
												<a href="#0" onclick="llenar_id(<?php echo $p->id ?>)" data-toggle="modal" data-target="#exampleModalCenter" class="icon-box whatsapp-box"></a>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</section>

				<!-- Footer -->
				<?php include "includes/footer.php" ?>
				<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5><img src="assets/images/whatsapp-icon-2.png" alt="Whatsapp"> enviar whatsapp</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<img src="assets/images/popup-close.png" alt="Close Btn">
								</button>
							</div>
							<div class="modal-body">
								<form onsubmit="enviar_contacto()">
									<div class="form-group">
										<input type="hidden" value="" id="contacto_id_propiedad" name="">
										<input type="name" name="Nombre *" id="contacto_nombre" placeholder="Nombre *" class="form-control">
									</div>
									<div class="form-group">
										<input type="email" name="Email *" id="contacto_email" placeholder="Email *" class="form-control">
									</div>
									<div class="form-group">
										<input type="tel" name="WhatsApp (sin 0 ni 15) *" id="contacto_telefono" placeholder="WhatsApp (sin 0 ni 15) *" class="form-control">
									</div>
									<div class="form-group">
										<textarea id="contacto_mensaje" placeholder="Estoy interesado en “Duplex en venta en Ringuelet Cod: 1234”" class="form-control"></textarea>
									</div>
									<div class="form-group">
										<button type="submit" id="contacto_submit" class="btn">hablar ahora</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- Scripts -->
				<script src="assets/js/jquery.min.js"></script>
				<script src="assets/js/bootstrap.bundle.min.js"></script>
				<script src="assets/js/html5.min.js"></script>
				<script src="assets/js/respond.min.js"></script>
				<script src="assets/js/placeholders.min.js"></script>
				<script src="assets/js/owl.carousel.min.js"></script>
				<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWmUapFYTBXV3IJL9ggjT9Z1wppCER55g&callback=initMap"></script>
				<script src="assets/js/scripts.js"></script>
				<script type="text/javascript">
					function llenar_id(item) { 
						$("#contacto_id_propiedad").val(item);
					} 
				</script>
				<script type="text/javascript">
					function filtrar() { 
						var link = "<?php echo mklink("propiedades/")?>";
						var tipo_operacion = $("#tipo_operacion").val();
						var localidad = $("#localidad").val();
						var tp = $("#tp").val();
						link = link + tipo_operacion + "/" + localidad + "/?tp=" + tp;
						$("#form_propiedades").attr("action",link);
						return true;
					}
				</script>
				<script type="text/javascript">
					$(document).ready(function(){
						var maximo = 0;
						$(".product-details .average-detail").each(function(i,e){
							if ($(e).height() > maximo) maximo = $(e).height();
						});
						maximo = Math.ceil(maximo);
						$(".product-details .average-detail").height(maximo);
					});

					$(document).ready(function(){
						var maximo = 0;
						$(".product-details h4").each(function(i,e){
							if ($(e).height() > maximo) maximo = $(e).height();
						});
						maximo = Math.ceil(maximo);
						$(".product-details h4").height(maximo);
					});

					$(document).ready(function(){
						var maximo = 0;
						$(".product-details h5").each(function(i,e){
							if ($(e).height() > maximo) maximo = $(e).height();
						});
						maximo = Math.ceil(maximo);
						$(".product-details h5").height(maximo);
					});
				</script>
				<script type="text/javascript">
					function enviar_contacto() {

						var nombre = jQuery("#contacto_nombre").val();
						var email = jQuery("#contacto_email").val();
						var mensaje = jQuery("#contacto_mensaje").val();
						var telefono = jQuery("#contacto_telefono").val();
						var id_propiedad = jQuery("#contacto_id_propiedad").val();

						if (isEmpty(nombre) || nombre == "Nombre") {
							alert("Por favor ingrese un nombre");
							jQuery("#contacto_nombre").focus();
							return false;          
						}


						if (isEmpty(telefono) || telefono == "telefono") {
							alert("Por favor ingrese un telefono");
							jQuery("#contacto_telefono").focus();
							return false;          
						}

						if (!validateEmail(email)) {
							alert("Por favor ingrese un email valido");
							jQuery("#contacto_email").focus();
							return false;          
						}
						if (isEmpty(mensaje) || mensaje == "Mensaje") {
							alert("Por favor ingrese un mensaje");
							jQuery("#contacto_mensaje").focus();
							return false;              
						}    
						jQuery("#contacto_submit").attr('disabled', 'disabled');
						var datos = {
							"para":"<?php echo $empresa->email ?>",
							"nombre":nombre,
							"telefono":telefono,
							"email":email,
							"asunto":"Consulta por propiedad",
							"mensaje":mensaje,
							"id_propiedad":id_propiedad,
							"id_empresa":ID_EMPRESA,
						}
						jQuery.ajax({
							"url":"https://app.inmovar.com/admin/consultas/function/enviar/",
							"type":"post",
							"dataType":"json",
							"data":datos,
							"success":function(r){
								if (r.error == 0) {
									alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
									window.location.href = "https://api.whatsapp.com/send?phone=549<?php echo $empresa->telefono ?>&text="+ mensaje;
								} else {
									alert("Ocurrio un error al enviar su email. Disculpe las molestias");
									jQuery("#contacto_submit").removeAttr('disabled');
								}
							}
						});
						return false;
					}
				</script>
				<script type="text/javascript" src="/admin/resources/js/common.js"></script>
				<script type="text/javascript" src="/admin/resources/js/main.js"></script>
				<?php include("templates/comun/clienapp.php") ?>
			</body>
			</html>