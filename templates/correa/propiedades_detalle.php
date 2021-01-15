<?php 
include "includes/init.php";
$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id,array(
  "id_empresa"=>$id_empresa,
  "id_empresa_original"=>$empresa->id,
));

// Tomamos los datos de SEO
$seo_title = (!empty($propiedad->seo_title)) ? ($propiedad->seo_title) : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? ($propiedad->seo_description) : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? ($propiedad->seo_keywords) : $empresa->seo_keywords;

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad"=>$propiedad->id));

?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include "includes/head.php" ?>
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo ($propiedad->nombre); ?>" />
<meta property="og:description" content="<?php echo str_replace("\n","",(strip_tags(html_entity_decode($propiedad->texto,ENT_QUOTES)))); ?>" />
<meta property="og:image" content="<?php echo current_url(TRUE); ?>/admin/<?php echo $propiedad->path; ?>"/>
<script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
</head>
<body>

<?php include "includes/header.php" ?>

<!-- Page Title -->
<section class="page-title">
  <div class="container">
    <h1>
    	<?php echo ($propiedad->id_tipo_operacion == 1)?"Comprar propiedad":"" ?>
  		<?php echo ($propiedad->id_tipo_operacion == 2)?"Alquilar propiedad":"" ?>
  		<?php echo ($propiedad->id_tipo_operacion == 4)?"Emprendimientos":"" ?>
    	</h1>
  </div>
</section>

<!-- Product Details -->
<section class="product-detail mb30">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">        
      	<?php if (!empty($propiedad->images)) {  ?>
	        <div class="banner">
	          <div class="slider">
	            <?php foreach ($propiedad->images as $i) { ?>
	              <div class="item">
	                <img class="contain-detail" src="<?php echo $i ?>" alt="slide1">
	              </div>
	            <?php } ?>
	          </div>
	          <div class="slider-nav">
	            <?php foreach ($propiedad->images as $i) { ?>
	              <div class="item">
	                <img src="<?php echo $i ?>" alt="slide1">
	              </div>
	            <?php } ?>
	          </div>
	        </div>
	      <?php } else { ?>
	      	<div class="banner">
	      		<img src="/admin/<?php echo $propiedad->path ?>" class="contain-detail">
	      	</div>
        <?php } ?>
        <div class="detail-top">
          <ul>
            <li>
              <div class="about-product">
                <span><img src="assets/images/badroom-icon.png" alt="Badroom"> <?php echo $propiedad->dormitorios ?> Habitaciones</span>
                <span><img src="assets/images/shower-icon.png" alt="Shower"> <?php echo $propiedad->banios ?> Baños</span>
                <span><img src="assets/images/sqft-icon.png" alt="Sqft"> <?php echo $propiedad->superficie_total ?> Totales</span>
              </div>
              <h2><?php echo $propiedad->nombre ?></h2>              
            </li>
            <li class="price-block">
              <span><?php echo $propiedad->direccion_completa ?></span>
              <big><?php echo $propiedad->precio ?></big>
            </li>
          </ul>
        </div>
        <div class="border-box-info">
          <div class="row">
            <div class="col-md-12">
              <h4>Descripción</h4>
            </div>
          </div>
          <p><?php echo $propiedad->texto ?></p>
        </div>
        <div class="border-box-info">
          <div class="row">
            <div class="col-md-12">
              <h4>servicios</h4>
            </div>
          </div>
          <ul>
            <?php if (!empty($propiedad->servicios_electricidad)) {  ?><li>Electricidad</li><?php } ?>
            <?php if (!empty($propiedad->servicios_gas)) {  ?><li>Gas</li><?php } ?>
            <?php if (!empty($propiedad->servicios_agua)) {  ?><li>Agua</li><?php } ?>
            <?php if (!empty($propiedad->servicios_cloacas)) {  ?><li>Cloacas</li><?php } ?>
        		<?php $caracteristicas = explode(";;;",$propiedad->caracteristicas); ?>
        		<?php foreach ($caracteristicas as $c) {  ?>
        			<li><?php echo $c ?></li>
        		<?php } ?>
          </ul>
        </div>
        <div class="border-box-info">
          <div class="row">
            <div class="col-md-12">
              <h4>superficies</h4>
            </div>
            <div class="col-md-3">
              <span>Cubierta:</span>
              <strong><?php echo $propiedad->superficie_cubierta ?></strong>
            </div>
            <div class="col-md-3">
              <span>Descubierta</span>
              <strong><?php echo $propiedad->superficie_descubierta ?></strong>
            </div>
            <div class="col-md-3">
              <span>Semicubierta</span>
              <strong><?php echo $propiedad->superficie_semicubierta ?></strong>
            </div>
            <div class="col-md-3">
              <span>Total</span>
              <strong><?php echo $propiedad->superficie_total ?></strong>
            </div>
          </div>
        </div>
        <div class="border-box-info">
          <div class="row">
            <div class="col-md-12">
              <h4>ambientes</h4>
            </div>
          </div>
          <ul>
           
            <?php if ($propiedad->dormitorios > 0) {  ?>
          		<LI>Dormitorio</LI>
         		<?php } ?>
            <?php if ($propiedad->banios > 0) {  ?>
          		<LI>Baño</LI>
         		<?php } ?>
            <?php if ($propiedad->cocheras > 0) {  ?>
          		<LI>Cochera</LI>
         		<?php } ?>
         		<?php if ($propiedad->patio == 1) {  ?>
          		<LI>Patio</LI>
         		<?php } ?>
         		 <?php if ($propiedad->balcon == 1) {  ?>
          		<LI>Balcón</LI>
         		<?php } ?>
          </ul>
        </div>
        <div class="border-box-info">
          <div class="row">
            <div class="col-md-12">
              <h4>adicionales</h4>
            </div>
            <div class="col-md-3">
              <span>Apto Crédito:</span>
              <strong><?php echo ($propiedad->apto_banco == 1)?"Sí":"No" ?></strong>
            </div>
            <div class="col-md-3">
              <span>Acepta Permuta:</span>
              <strong><?php echo ($propiedad->acepta_permuta == 1)?"Sí":"No" ?></strong>
            </div>
          </div>
        </div>
        <div class="map-block">
          <h4>ubicación en mapa</h4>
          <div id="map1"></div>
        </div>
      </div>
      <div class="col-lg-4 pl-5">
        <div class="sidebar-box">
          <h2>enviar consulta</h2>
          <div class="sidebar-border-box">
            <form onsubmit="return enviar_contacto()">
              <div class="form-group">
                <input class="form-control" id="contacto_nombre" type="text" name="Nombre *" placeholder="Nombre *">
              </div>
              <div class="form-group">
                <input class="form-control" id="contacto_email" type="email" name="Email *" placeholder="Email *">
              </div>
              <div class="form-group">
                <input class="form-control" id="contacto_telefono" type="tel" name="WhatsApp (sin 0 ni 15) *" placeholder="WhatsApp (sin 0 ni 15) *">
              </div>
              <div class="form-group">
                <textarea class="form-control" id="contacto_mensaje" placeholder="Estoy interesado en “Duplex en venta en Ringuelet Cod: 1234”"></textarea>
              </div>
              <button id="contacto_submit" type="submit" class="btn btn-secoundry">Enviar por Email</button>
              <a class="btn btn-whatsup" href="javascript:void(0)" onclick="return enviar_contacto_whatsapp()"><img src="assets/images/whatsapp2.png" alt="Whatsapp Icon" width="24"> enviar whatsapp</a>
            </form>
          </div>
          <div class="social">
            <span>Compartir:</span>
            <a href="#0"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#0"><i class="fa fa-whatsapp"></i></a>
            <a href="#0"><i class="fa fa-link"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Product Listing -->
<?php if (!empty($propiedad->relacionados)) {  ?>
	<section class="product-listing">
	  <div class="container">
	    <div class="section-title">
	      <h2>propiedades similares</h2>
	    </div>
	    <div class="owl-carousel" data-items="3" data-items-lg="2" data-margin="35" data-loop="true" data-nav="true" data-dots="true">
	      <?php foreach ($propiedad->relacionados as $p) { ?>
	        <div class="item">
	          <div class="product-list-item">
	            <div class="product-img">
	              <img class="cover-home" src="/admin/<?php echo $p->path ?>" alt="Product">
	            </div>
	            <div class="product-details">
	              <h4><?php echo $p->nombre ?></h4>
	              <h5><?php echo $p->direccion_completa ?></h5>
	              <ul>
	                <li>
	                  <strong><?php echo $p->precio ?></strong>
	                </li>
	              </ul>
	              <div class="average-detail">
	                <span><img src="assets/images/badroom-icon.png" alt="Badroom Icon"> <?php echo $p->dormitorios  ?></span>
	                <span><img src="assets/images/shower-icon.png" alt="Shower Icon"> <?php echo $p->banios ?></span>
	                <span><img src="assets/images/sqft-icon.png" alt="SQFT Icon"> <?php echo $p->superficie_total ?></span>
	              </div>
	              <div class="btns-block">
	                <a href="<?php echo mklink ($p->link) ?>" class="btn btn-secoundry">Ver Detalles</a>
	                <a href="#0" class="icon-box"></a>
	                <a href="#0" data-toggle="modal" data-target="#exampleModalCenter"  class="icon-box whatsapp-box"></a>
	              </div>
	            </div>
	          </div>
	        </div>
	      <?php } ?>
	    </div>    
	  </div>
	</section>
<?php } ?>

<!-- Footer -->
<?php include "includes/footer.php" ?>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/html5.min.js"></script>
<script src="assets/js/respond.min.js"></script>
<script src="assets/js/placeholders.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/scripts.js"></script>
<script type="text/javascript"></script>
<script type="text/javascript">
function enviar_contacto() {
  var nombre = jQuery("#contacto_nombre").val();
  var email = jQuery("#contacto_email").val();
  var mensaje = jQuery("#contacto_mensaje").val();
  var telefono = jQuery("#contacto_telefono").val();

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
    "asunto":"Consulta por: <?php echo $propiedad->nombre ?>",
    "mensaje":mensaje,
    "id_propiedad":"<?php echo $propiedad->id ?>",
    "id_empresa":ID_EMPRESA,
  }
  jQuery.ajax({
    "url":"/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
        location.reload();
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
function enviar_contacto_whatsapp() {
  var nombre = jQuery("#contacto_nombre").val();
  var email = jQuery("#contacto_email").val();
  var mensaje = jQuery("#contacto_mensaje").val();
  var telefono = jQuery("#contacto_telefono").val();

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
    "asunto":"Consulta por: <?php echo $propiedad->nombre ?>",
    "mensaje":mensaje,
    "id_propiedad":"<?php echo $propiedad->id ?>",
    "id_empresa":ID_EMPRESA,
  }
  jQuery.ajax({
    "url":"/admin/consultas/function/enviar/",
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
<?php if (isset($propiedad->latitud) && isset($propiedad->longitud) && $propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
  mostrar_mapa(); 
});
function mostrar_mapa() {

  <?php if (!empty($propiedad->latitud && !empty($propiedad->longitud))) { ?>
    var mymap = L.map('map1').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      maxZoom: 18,
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      id: 'mapbox.streets'
    }).addTo(mymap);
    L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>]).addTo(mymap);

  <?php } ?>
}
</script>
<?php } ?>
<script type="text/javascript">
	 $('.slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    asNavFor: '.slider-nav'
  });
  $('.slider-nav').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.slider',
    dots: true,
    arrows: true,
    centerMode: false,
    focusOnSelect: true
  });
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