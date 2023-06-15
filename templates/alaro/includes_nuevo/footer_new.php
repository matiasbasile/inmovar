<footer>
	<div class="container">
		<div class="row align-item-center">
			<div class="col-md-3">
				<h6>Información</h6>
				<div class="whatsapp-box">
					<ul>
						<?php if (!empty($empresa->direccion)) {  ?>
							<li>
								<img src="images/map-icon.png" alt="Map">
								<span>
									<a href="javascript:void(0)"><?php echo $empresa->direccion ?><br><?php echo $empresa->ciudad ?></a>
								</span>
							</li>
						<?php } ?>
						<?php if (!empty($empresa->telefono)) {  ?>
							<li>
								<img src="images/call.png" alt="Call Us">
								<span>
									<a href="tel:<?php echo $empresa->telefono ?>"><?php echo $empresa->telefono ?></a>
								</span>
							</li>
						<?php } ?>
						<?php if (!empty($empresa->telefono_2)) {  ?>
							<li>
								<img src="images/whatsapp-icon.png" alt="Whatsapp">
								<span>
									<a href="tel:<?php echo $empresa->telefono_2 ?>"><?php echo $empresa->telefono_2 ?></a>
								</span>
							</li>
						<?php } ?>
					</ul>        
				</div>
			</div>
			<div class="col-md-5">
				<h6>Accesos Rápidos</h6>
				<ul class="quick-links">
					<li>
						<a class="capitalize" href="<?php echo mklink("/"); ?>">Inicio</a>
					</li>
					<li class="<?php echo($nombre_pagina=="proximos-proyectos")?"active":"" ?>">
						<a class="capitalize" href="<?php echo mklink("propiedades/proximos-proyectos/"); ?>">Edificios en desarrollo</a>
					</li>
					<?php $nos = $entrada_model->get(1695)?>
					<li>
						<a class="capitalize" href="<?php echo mklink($nos->link); ?>">Nosotros</a>
					</li>
					<li class="<?php echo($nombre_pagina=="ventas")?"active":"" ?>">
			          <a  class="capitalize" href="<?php echo mklink("propiedades/ventas/"); ?>">Venta de terminados</a>
			        </li>
					<li class="<?php echo($nombre_pagina=="terminaciones")?"active":"" ?>">
						<a class="capitalize" href="<?php echo mklink("web/terminaciones/"); ?>">terminaciones</a>
					</li>
					<li class="<?php echo($nombre_pagina=="alquileres")?"active":"" ?>">
			          <a class="capitalize" href="<?php echo mklink("propiedades/alquileres/"); ?>">alquileres</a>
			        </li>
					<li class="<?php echo($nombre_pagina=="contacto")?"active":"" ?>">
						<a class="capitalize" href="<?php echo mklink("contacto/"); ?>">Contacto</a>
					</li>
					<li class="<?php echo($nombre_pagina=="proyectos-finalizados")?"active":"" ?>">
						<a class="capitalize" href="<?php echo mklink("propiedades/proyectos-finalizados/"); ?>">proyectos finalizados</a>
					</li>
					
			         
					<!-- <li class="<?php echo($nombre_pagina=="alaro-residencias")?"active":"" ?>">
						<a class="capitalize" href="<?php echo mklink("entradas/alaro-residencias/"); ?>">alaró residencias</a>
					</li> -->
					<!-- <li class="<?php echo($nombre_pagina=="quienes-somos")?"active":"" ?>">
						<a class="capitalize" href="<?php echo mklink("entradas/quienes-somos/"); ?>">Quienes Somos</a>
					</li> -->
					
				</ul>
			</div>
			<div class="col-md-4">
				<h6>Suscribite al Newsletter</h6>
				<form onsubmit="return enviar_newsletter()">
					<input type="email" name="Escribe tu email" id="newsletter_email" placeholder="Escribe tu email" class="form-control">
					<button id="newsletter_submit" type="submit" class="btn btn-secoundry">Enviar</button>
				</form>        
				<?php if(!empty($empresa->facebook) and (!empty($empresa->instagram))) {  ?>
					<div class="social">
						<span>Seguinos:</span>
						<a href="<?php echo $empresa->facebook ?>" target0="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						<a href="<?php echo $empresa->instagram ?>" target0="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
						<a href="<?php echo $empresa->youtube ?>" target0="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</footer>

<!-- Copyright -->
<div class="copyright">
	<div class="container">
		<div class="row">
			<div class="col-xl-8">
				<span><a href="<?php echo mklink ("/") ?>" class="logo"><img src="images/logo1.png" width="150" alt="Logo"></a></span>
			</div>
			<div class="col-xl-4 text-right">
				<span> <a href="https://www.misticastudio.com"><img class="mt20" src="images/mistica.png" alt="Mistica Logo"></a></span>
			</div>
		</div>
	</div>
</div>



<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<!-- Modal -->

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
			"url":"/admin/consultas/function/enviar/",
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
<?php include("templates/comun/clienapp.php") ?>