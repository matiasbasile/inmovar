<footer>
	<div class="container">
		<div class="row align-item-center">
			<div class="col-md-3">
				<h6>Información</h6>
				<div class="whatsapp-box">
					<ul>
						<?php if (!empty($empresa->direccion)) {  ?>
							<li>
								<img src="assets/images/map-icon.png" alt="Map">
								<span>
									<a href="javascript:void(0)"><?php echo $empresa->direccion ?><br><?php echo $empresa->ciudad ?></a>
								</span>
							</li>
						<?php } ?>
						<?php if (!empty($empresa->telefono)) {  ?>
							<li>
								<img src="assets/images/call.png" alt="Call Us">
								<span>
									<a href="tel:<?php echo $empresa->telefono ?>"><?php echo $empresa->telefono ?></a>
								</span>
							</li>
						<?php } ?>
						<?php if (!empty($empresa->telefono_2)) {  ?>
							<li>
								<img src="assets/images/whatsapp-icon.png" alt="Whatsapp">
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
					<li><a href="<?php echo mklink ("web/nosotros/") ?>">NOSOTROS</a></li>
					<li><a href="<?php echo mklink ("web/vender/") ?>">VENDER</a></li>
					<li><a href="<?php echo mklink ("propiedades/ventas/") ?>">COMPRAR</a></li>
					<li><a href="<?php echo mklink ("propiedades/emprendimientos/") ?>">EMPRENDIMIENTOS</a></li>
					<li><a href="<?php echo mklink ("propiedades/alquileres/") ?>">ALQUILAR</a></li>
					<li><a href="<?php echo mklink ("contacto/") ?>">CONTACTO</a></li>
				</ul>
			</div>
			<div class="col-md-4">
				<h6>Suscribe al Newsletter</h6>
				<form onsubmit="return enviar_newsletter()">
					<input type="email" name="Escribe tu email" id="newsletter_email" placeholder="Escribe tu email" class="form-control">
					<button id="newsletter_submit" type="submit" class="btn btn-secoundry">Enviar</button>
				</form>        
				<?php if(!empty($empresa->facebook) and (!empty($empresa->instagram))) {  ?>
					<div class="social">
						<span>Seguinos:</span>
							<a href="<?php echo $empresa->facebook ?>" target0="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
							<a href="<?php echo $empresa->instagram ?>" target0="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
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
				<span><a href="javascript:void(0)" class="logo"><img src="assets/images/footer-logo.png" alt="Logo"></a><small>Negocios Inmobiliarios</small></span>
			</div>
			<div class="col-xl-4 text-right">
				<span> <a href="http://www.misticastudio.com"><img src="assets/images/mistica.png" alt="Mistica Logo"></a></span>
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
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
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