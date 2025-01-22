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
					
					<?php if ($tiene_emprendimientos) { ?>
						<li><a href="<?php echo mklink ("propiedades/emprendimientos/") ?>">EMPRENDIMIENTOS</a></li>
					<?php } ?>
					
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

<?php foreach($modales as $modal) { ?>
	<div class="modal fade" id="exampleModalCenter_<?php echo $modal->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5><img src="assets/images/whatsapp-icon-2.png" alt="Whatsapp"> enviar whatsapp</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<img src="assets/images/popup-close.png" alt="Close Btn">
					</button>
				</div>
				<div class="modal-body">
					<form onsubmit="return false">
						<div class="form-group">
							<input type="hidden" value="<?php echo $modal->id ?>" class="id_propiedad" name="">
							<input type="hidden" value="Contacto por: <?php echo $modal->nombre ?>. Cod: <?php echo $modal->codigo ?>" class="asunto">
							<input type="name" name="Nombre *" placeholder="Nombre *" class="form-control nombre">
						</div>
						<div class="form-group">
							<input type="email" name="Email *" placeholder="Email *" class="form-control email">
						</div>
						<div class="form-group">
							<input type="tel" name="WhatsApp (sin 0 ni 15) *" placeholder="WhatsApp (sin 0 ni 15) *" class="form-control telefono">
						</div>
						<div class="form-group">
							<textarea class="form-control mensaje">Estoy interesado en <?php echo $modal->nombre ?> Cod: <?php echo $modal->codigo ?></textarea>
						</div>
						<div class="form-group">
							<button onclick="enviar_contacto_whatsapp('exampleModalCenter_<?php echo $modal->id ?>')" class="btn submit">hablar ahora</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/html5.min.js"></script>
<script src="assets/js/respond.min.js"></script>
<script src="assets/js/placeholders.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/scripts.js"></script>

<script type="text/javascript">

	function change_localidad (link,nombre) { 
		$('#localidad').val(link);
		enviar_buscador_propiedades()
	}
	function change_tp (link,nombre) { 
		$('#tp').val(link);
		enviar_buscador_propiedades()
	}
	function change_bn (link,nombre) { 
		$('#bn').val(link);
		enviar_buscador_propiedades()
	}
	function change_dm (dm) { 
		$('#dm').val(dm);
		enviar_buscador_propiedades()
	}
  function change_price (min,max) { 
    $('#vc_minimo').val(min);
    $('#vc_maximo').val(max);
    enviar_buscador_propiedades()
  }
   function change_permuta () { 
    $('#per').val(1);
    enviar_buscador_propiedades()
  }
   function change_banco () { 
    $('#banco').val(1);
    enviar_buscador_propiedades()
  }

  function enviar_orden() { 
    $("#orden_form").submit();
  }
  function enviar_buscador_propiedades() { 
    var link = "<?php echo mklink("propiedades/")?>";
    var tipo_operacion = $("#tipo_operacion").val();
    var localidad = $("#localidad").val();
    link = link + tipo_operacion + "/" + localidad + "/";
    $("#form_propiedades").attr("action",link);
    $("#form_propiedades").submit();
    return true;
  }

	function filtrar() { 
		var link = "<?php echo mklink("propiedades/")?>";
		var tipo_operacion = $("#tipo_operacion").val();
		var localidad = $("#localidad").val();
		var tp = $("#tp").val();
		link = link + tipo_operacion + "/" + localidad + "/?tp=" + tp;
		$("#form_propiedades").attr("action",link);
		return true;
	}

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


<script type="text/javascript">
  function enviar_contacto_whatsapp(form) {

    var nombre = jQuery("#"+form+" .nombre").val();
    var email = jQuery("#"+form+" .email").val();
    var mensaje = jQuery("#"+form+" .mensaje").val();
    var telefono = jQuery("#"+form+" .telefono").val();
    var id_propiedad = jQuery("#"+form+" .id_propiedad").val();
    var asunto = jQuery("#"+form+" .asunto").val();

    if (isEmpty(nombre) || nombre == "Nombre") {
      alert("Por favor ingrese un nombre");
      jQuery("#"+form+" .nombre").focus();
      return false;          
    }

    if (isEmpty(telefono) || telefono == "telefono") {
      alert("Por favor ingrese un telefono");
      jQuery("#"+form+" .telefono").focus();
      return false;          
    }

    if (!validateEmail(email)) {
      alert("Por favor ingrese un email valido");
      jQuery("#"+form+" .email").focus();
      return false;          
    }
    if (isEmpty(mensaje) || mensaje == "Mensaje") {
      alert("Por favor ingrese un mensaje");
      jQuery("#"+form+" .mensaje").focus();
      return false;              
    }    
    
    jQuery("#"+form+" .submit").attr('disabled', 'disabled');
    var datos = {
      "para":"<?php echo $empresa->email ?>",
      "nombre":nombre,
      "telefono":telefono,
      "email":email,
      "asunto":asunto,
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
          jQuery("#"+form+" .submit").removeAttr('disabled');
        }
      }
    });
    return false;
  }
</script>

<script type="text/javascript">
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
  $(document).ready(function(){
    var maximo = 0;
    $(".product-details .average-detail").each(function(i,e){
     if ($(e).height() > maximo) maximo = $(e).height();
   });
    maximo = Math.ceil(maximo);
    $(".product-details .average-detail").height(maximo);
  });
</script>

<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>

<?php include("templates/comun/clienapp.php") ?>