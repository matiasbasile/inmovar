<section id="form-contact">
	<div class="property-full-info">
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
						<select id="contacto_asunto" class="form-control">
							<option value="0">Seleccione el asunto *</option>
							<?php $asuntos = explode(";;;",$empresa->asuntos_contacto);
							foreach($asuntos as $a) { ?>
								<option><?php echo $a ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<textarea class="form-control" id="contacto_mensaje" placeholder="Escriba aquí su mensaje *"></textarea>
					</div>
					<div class="col-md-12">
						<div class="pull-right">
							<input type="submit" id="contacto_submit" value="enviar consulta" class="btn btn-red btn-blue">
						</div>
					</div>
				</div>
			</form>
		</div>                
	</div>
</section>
<!-- Back To Top -->
<div class="back-to-top"><a href="javascript:void(0);" aria-label="Back to Top">&nbsp;</a></div>

<!-- Scripts -->
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
		"url":"https://app.inmovar.com/admin/consultas/function/enviar/",
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