<footer class="sec-pad myfooter"> 
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-xs-12 box logo-section">
				<?php if (!empty($empresa->logo)) {  ?>
					<img src="/admin/<?php echo $empresa->logo ?>" style="width: 200px">
				<?php } ?>
				<?php $t = $web_model->get_text("leyenda-footer","Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore")?>
				<div class="text-footer-logo editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
					<?php echo $t->plain_text ?>
				</div>
				<br>
				<?php $t = $web_model->get_text("vermasbtn","Ver más")?>
				<a class="editable btn-footer-link" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" href="<?php echo $t->link ?>"><?php echo $t->plain_text ?> <i class="fa fa-chevron-right"></i></a>
			</div>
			<div class="col-md-4 col-xs-12 box">
				<div class="title-footer">Contacto</div>
				<ul class="socials-footer">
					<li><a><i class="fa fa-map-marker"></i>  <?php echo $empresa->direccion." ".$empresa->ciudad ?></a></li>
					<li><a href="tel:<?php echo $empresa->telefono ?>"><i class="fa fa-phone"></i>  <?php echo $empresa->telefono ?></a></li>
					<li><a href="mailto:<?php echo $empresa->email ?>"><i class="fa fa-envelope"></i>  <?php echo $empresa->email ?></a></li>
				</ul>
				<br>
				<a class="btn-footer-link" href="<?php echo mklink ("contacto/") ?>">Contacto <i class="fa fa-chevron-right font-size-12"></i></a>
			</div>
			<div class="col-md-4 col-xs-12 box">
				<form onsubmit="return enviar_newsletter()">
					<div class="title-footer">Newsletter</div>
					<span class="inputs">
						<input class="newsletter" id="newsletter_email" type="" placeholder="Escriba tu correo" name="">
						<input class="submit btn-yellow" id="newsletter_submit" type="submit" value="ENVIAR">
					</span>	
				</form>
					<?php if (!empty($empresa->facebook)) {  ?>
					<div class="text">Seguinos en las redes:</div>
						<ul class="socials-icons">
							<?php if (!empty($empresa->twitter)) {  ?>
								<li><a target="_blank" href="<?php echo $empresa->twitter ?>"><i class="fab fa-twitter"></i> </a></li>
							<?php } ?>
							<?php if (!empty($empresa->facebook)) {  ?>
								<li><a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fab fa-facebook"></i> </a></li>
							<?php } ?>
							<?php if (!empty($empresa->instagram)) {  ?>
								<li><a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fab fa-instagram"></i> </a></li>
							<?php } ?>
						</ul>
					<?php } ?>
				</div>				
		</div>
	</div>
</footer>
<section class="copyright" style="">
<div class="container">
	<div class="row">
			<div class="col-md-6">
				<div class="leyenda-copyright pull-left">
					 Copyright © <?php echo date("Y")?>. Todos los derechos reservados
				</div>
			</div>
			<div class="col-md-6">
				<div class="leyenda-copyright pull-right">
					Tu Inmobiliaria Online! <img src="img/varcreative-logo.png"> <span>Inmovar</span>
				</div>
			</div>
	</div>	
</div>
</section>
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
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

<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script>
$(document).ready(function(){
  if ($("#precio_minimo").length > 0) {
    new AutoNumeric('#precio_minimo', { 
      'decimalPlaces':0,
      'decimalCharacter':',',
      'digitGroupSeparator':'.',
    });
  }
  if ($("#precio_maximo").length > 0) {
    new AutoNumeric('#precio_maximo', { 
      'decimalPlaces':0,
      'decimalCharacter':',',
      'digitGroupSeparator':'.',
    });
  }
})
</script>
<?php include("templates/comun/clienapp.php") ?>