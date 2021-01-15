<?php include "includes/init.php" ?>
<?php $propiedad = $propiedad_model->get($id,array(
	"buscar_total_visitas"=>1,
	"buscar_relacionados_offset"=>3,
	"id_empresa"=>$id_empresa,
	"id_empresa_original"=>$empresa->id,
)); 
$page_act = $propiedad->tipo_operacion_link;

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
<style type="text/css">
.cover-detail { height: 230px !important; object-fit: cover }
.contain-detail { height: 500px !important; object-fit: contain }
.w100p { width: 100% !important }
.youtube iframe { width: 100%; height: 600px }
@media screen and (max-width: 1449px) { .youtube iframe { width: 100%; height: 300px } }
</style>
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo ($propiedad->nombre); ?>" />
<meta property="og:description" content="<?php echo str_replace("\n","",(strip_tags(html_entity_decode($propiedad->texto,ENT_QUOTES)))); ?>" />
<meta property="og:image" content="<?php echo current_url(TRUE); ?>/admin/<?php echo $propiedad->path; ?>"/>
<script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
</head>
<body>

  <!-- Header -->
  <?php include "includes/header.php" ?>

  <!-- Page Title -->
  <div class="page-title">
    <div class="container">
      <div class="page">
        <div class="breadcrumb"> <a href="<?php echo mklink ("propiedades/$propiedad->tipo_operacion_link/") ?>"><?php echo $propiedad->tipo_operacion ?></a></div>
        <div class="float-right">
          <big>Tus favoritas</big> 
          <a href="<?php echo mklink ("favoritos/")?>"><i class="fas fa-heart"></i> <span><?php echo $cant_favoritos ?></span></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Products Listing -->
  <div class="products-listing">
    <div class="container">
      <div class="row">
        <div class="col-xl-8">
          <div class="property-full-info">
            <div class="top-detail">
              <div class="code">
                <b>Cod:</b><?php echo $propiedad->codigo ?>
              </div>
              <h2><?php echo $propiedad->nombre ?></h2>
              <div class="price-info">
                <b><?php echo $propiedad->precio ?></b>
              </div>
              <div class="location-box">
                <span><img src="assets/images/location-icon2.png" alt="Location"> <?php echo $propiedad->direccion_completa ?> | <strong><?php echo $propiedad->localidad ?></strong></span>
              </div>
              <div class="property-middle">
                <ul>
                  <?php if ($propiedad->superficie_total != 0) {  ?>
                    <li><img src="assets/images/home.png" alt="Home"> <?php echo $propiedad->superficie_total ?> mts2</li>
                  <?php } ?>
                  <?php if (!empty($propiedad->dormitorios)) {  ?>
                    <li><img src="assets/images/beds.png" alt="Beds"> <?php echo $propiedad->dormitorios ?></li>
                  <?php } ?>
                  <?php if (!empty($propiedad->banios)) {  ?>
                    <li><img src="assets/images/washroom.png" alt="Washroom"> <?php echo $propiedad->banios ?></li>
                  <?php } ?>
                  <?php if (!empty($propiedad->cocheras)) {  ?>
                    <li><img src="assets/images/parking.png" alt="Parking"> <?php echo $propiedad->cocheras ?></li>
                  <?php } ?>
                </ul>
                <?php if ($propiedad->apto_banco == 1)  {  ?><span><img src="assets/images/home-price.png" alt="Home Price"> Apto crédito</span><?php } ?>
              </div>
            </div>
            <div class="border-box ">
              <div class="box-space rincon-gallery">
                <div class="row">
                  <?php if (!empty($propiedad->images)) {  ?>
                    <?php $x=1; foreach ($propiedad->images as $i) {  ?>
                      <div class="col-lg-4 col-md-6 col-6 <?php echo ($x>6)?"d-none":"" ?>">
                        <div class="gallery-item">
                          <div class="rincon-image">
                            <img class="cover-detail" src="<?php echo $i ?>" alt="Gallery">
                              <?php if ($x==6){?>
                                <div class="gallery-info">
                              <?php } ?>
                                  <div class="rincon-popup <?php echo ($x!=6)?"d-none":""?>">
                                    <a href="<?php echo $i ?>">
                                      Ver <?php echo ((sizeof($propiedad->images) == 6))?"todas":(sizeof($propiedad->images)-6)." fotos más"?>
                                    </a>
                                  </div>
                              <?php if ($x==6){?>
                                </div>
                              <?php } ?>
                          </div>
                        </div>
                      </div>
                    <?php $x++; } ?>
                  <?php } else { ?>
                    <div class="col-lg-12">
                      <div class="gallery-item">
                        <div class="rincon-image">
                          <img class="contain-detail" src="/admin/<?php echo $propiedad->path?>">
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <div class="info-title">Información general</div>
                <div><?php echo $propiedad->texto ?></div>
              </div>
              <?php if (!empty($propiedad->caracteristicas)) {  ?>
                <?php $caracteristicas = explode(";;;",$propiedad->caracteristicas);?>
                <div class="box-space">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="info-title">Características</div>                    
                    </div>
                    <div class="col-md-9">
                      <div class="available-facilities">
                        <ul>
                          <?php foreach ($caracteristicas as $c) {  ?>
                            <li><?php echo $c ?></li>
                          <?php } ?>
                        	<?php if ($propiedad->servicios_gas == 1) {  ?>
                          	<li>Gas</li>
                          <?php } ?>
                        	<?php if ($propiedad->servicios_cloacas == 1) {  ?>
                          	<li>Cloacas</li>
                          <?php } ?>
                          <?php if ($propiedad->servicios_agua_corriente == 1) {  ?>
                          	<li>Agua Corriente</li>
                          <?php } ?>
                          <?php if ($propiedad->servicios_asfalto == 1) {  ?>
                          	<li>Asfalto</li>
                          <?php } ?>
                          <?php if ($propiedad->servicios_electricidad == 1) {  ?>
                          	<li>Electricidad</li>
                          <?php } ?>
                          <?php if ($propiedad->servicios_cable == 1) {  ?>
                          	<li>Cable</li>
                          <?php } ?>
                          <?php if ($propiedad->servicios_telefono == 1) {  ?>
                          	<li>Teléfono</li>
                          <?php } ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>            
              <div class="box-space">
                <div class="row">
                  <div class="col-md-3">
                    <div class="info-title">Ubicación</div>                    
                  </div>
                  <div class="col-md-9">
                    <div class="available-facilities">
                      <ul>
                        <li><?php echo $propiedad->direccion_completa ?></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div id="map1"></div>
              </div>
              <?php if (!empty($propiedad->video)) {  ?>
                <div class="box-space">
                  <div class="info-title">Video</div>
                  <div class="youtube"><?php echo $propiedad->video ?></div>
                </div>
              <?php } ?>
              <div class="box-space">
                <div class="info-title">Consulta por esta propiedad</div>
                <div class="form">
                  <form onsubmit="return enviar_contacto()">
                    <div class="row">
                      <div class="col-md-6">
                        <input class="form-control" id="contacto_nombre" type="text" placeholder="Nombre *" />
                      </div>
                      <div class="col-md-6">
                        <input class="form-control" id="contacto_telefono" type="tel" placeholder="Teléfono *" />
                      </div>
                      <div class="col-md-12">
                        <input class="form-control" id="contacto_email" type="email" placeholder="Email *" />
                      </div>
                      <div class="col-md-12">
                        <textarea class="form-control" id="contacto_mensaje" placeholder="Estoy interesado en esta propiedad *"></textarea>
                      </div>
                      <div class="col-md-12">
                        <div class="pull-right">
                          <input type="submit" id="contacto_submit" value="consultar" class="btn btn-red" />
                        </div>
                      </div>
                    </div>                
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
        <div class="border-box visit border-bottom-0">
          <div class="search-filter">
            <div class="form-title">Solicitar visita</div>
            <div class="box-space">
              <form>
                <div class="row">
                  <div class="col-md-6">
                    <input class="form-control date" id="visita_dia" type="date" placeholder="22/04/2016">
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" id="visita_hora">
                      <option class="mañana">Mañana</option>
                      <option class="tarde">Tarde</option>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <input data-toggle="modal" data-target="#exampleModal" class="btn btn-red w100p"  value="Solicita una visita">
                  </div>
                </div>
              </form>
              <div class="heart-btn">
                <?php if (estaEnFavoritos($propiedad->id)) { ?>
                  <a data-bookmark-state="added" href="/admin/favoritos/eliminar/?id=<?php echo $propiedad->id; ?>">
                    Eliminar de lista de favoritos
                  </a>
                <?php } else { ?>
                  <a data-bookmark-state="empty" href="/admin/favoritos/agregar/?id=<?php echo $propiedad->id; ?>">
                    Guardar en lista de favoritos
                  </a>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>        
        <!-- <div class="box-bottom-links mb-4">
          <ul>
            <li><a href="javascript:void(0)" onclick="enviar_ficha_email()"><img src="assets/images/email-icon.png" alt="Email"> Email</a></li>
            <li><a href="<?php echo $propiedad->link_ficha ?>"><img src="assets/images/pdf.png" alt="PDF"> Ficha PDF</a></li>
            <li><a target="_blank" href="<?php echo $propiedad->link_ficha ?>"><img src="assets/images/doc.png" alt="Doc"> Imprimir</a></li>
          </ul>
        </div> -->
        <div class="border-box">
          <?php include "includes/search-filter.php" ?>
        </div>
      </div>
      </div>
    </div>
  </div>



<!-- Featured Properties -->
<?php if (isset($propiedad->relacionados) && sizeof($propiedad->relacionados)>0) { ?>
	<div class="featured-properties list-wise pt-0">
	  <div class="container">
	    <h2 class="section-title">propiedades similares</h2>
	    <div class="owl-carousel" data-items="3" data-margin="32" data-loop="true" data-nav="true" data-dots="false">
				<?php foreach ($propiedad->relacionados as $p) {  ?>
		      <div class="item">
		        <div class="property-box">
		          <div class="property-img">
		            <img class="cover-recientes" src="/admin/<?php echo $p->path ?>" alt="Property Img">
		            <div class="rollover">
		              <a href="<?php echo mklink ($p->link) ?>" class="add"></a>
		               <?php if (estaEnFavoritos($p->id)) { ?>
                    <a class="heart" data-bookmark-state="added" href="/admin/favoritos/eliminar/?id=<?php echo $p->id; ?>">
                    </a>
                   <?php } else { ?>
                    <a class="heart" data-bookmark-state="empty" href="/admin/favoritos/agregar/?id=<?php echo $p->id; ?>">
                    </a>
                  <?php } ?>
		            </div>
		          </div>
		          <div class="property-details">
		            <div class="property-top">
		              <h3><?php echo $p->nombre ?></h3>
		            </div>
		            <div class="property-middle">
		              <ul>
	                  <?php if ($p->superficie_total != 0) {  ?>
	                  	<li><img src="assets/images/home.png" alt="Home"> <?php echo $p->superficie_total ?> mts2</li>
	                  <?php } ?>
	                  <?php if (!empty($p->dormitorios)) {  ?>
	                  	<li><img src="assets/images/beds.png" alt="Beds"> <?php echo $p->dormitorios ?></li>
	                  <?php } ?>
	                  <?php if (!empty($p->cocheras)) {  ?>
	                  	<li><img src="assets/images/parking.png" alt="Parking"> <?php echo $p->cocheras ?></li>
	                  <?php } ?>
	                </ul>
		            </div>
		            <div class="property-bottom">
		              <span><?php echo $p->precio ?></span>
		              <a class="btn btn-red" href="<?php echo mklink ($p->link) ?>">ver más</a>
		            </div>
		          </div>
		        </div>
		      </div>
		    <?php } ?>
	    </div>
	  </div>
	</div>
<?php } ?>


  <!-- Call To Action -->
  <?php include "includes/comunicate.php" ?>
  

  <!-- Footer -->
  <?php include "includes/footer.php" ?>

  <!-- Back To Top -->
  <div class="back-to-top"><a href="javascript:void(0);" aria-label="Back to Top">&nbsp;</a></div>

  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/html5.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="assets/js/nouislider.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
  <?php if ($propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
    <script type="text/javascript">
     <?php if (!empty($propiedad->latitud && !empty($propiedad->longitud))) { ?>
    var mymap = L.map('map1').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      maxZoom: 18,
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      id: 'mapbox.streets'
    }).addTo(mymap);

    var icono = L.icon({
    iconUrl: 'assets/images/map-logo.png',
    iconSize:     [101, 112], // size of the icon
    shadowSize:   [151, 142], // size of the shadow
    iconAnchor:   [50, 12], // point of the icon which will correspond to marker's location
    });

    L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>]).addTo(mymap);

  <?php } ?>
    </script>
  <?php } ?>
  <script src="assets/js/magnific-popup-min.js"></script>
  <script src="assets/js/scripts.js"></script>
  <script type="text/javascript">
  //Magnific Popup Script
  $('.rincon-popup').magnificPopup ({
    delegate: 'a',
    type: 'image',
    closeOnContentClick: false,
    closeBtnInside: false,
    removalDelay: 100,
    mainClass: 'mfp-fade mfp-img-mobile',
    closeMarkup:'<div class="mfp-close" title="%title%"></div>',
    image: {
      verticalFit: true,
      titleSrc: function(item) {
        return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">image source</a>';
      }
    },
    gallery: {
      enabled: true,
      arrowMarkup:'<div title="%title%" class="mfp-arrow mfp-arrow-%dir%"></div>',
    },
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
		var id_propiedad = <?php echo $propiedad->id ?>;
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
					$("#contacto_submit").removeAttr('disabled');
					enviando = 0;
				}
			}
		});
		return false;
	}  
</script>
<script type="text/javascript">
    function submit_buscador_propiedades() {
  // Cargamos el offset y el orden en este formulario
  $("#sidebar_orden").val($("#ordenador_orden").val());
  $("#sidebar_offset").val($("#ordenador_offset").val());
  $("#form_propiedades").submit();
}
function onsubmit_buscador_propiedades() { 
  var link = (($("input[name='tipo_busqueda']:checked").val() == "mapa") ? "<?php echo mklink("mapa/")?>" : "<?php echo mklink("propiedades/")?>");
  var tipo_operacion = $("#tipo_operacion").val();
  var localidad = $("#localidad").val();
  var tipo_propiedad = $("#tp").val();
  link = link + tipo_operacion + "/" + localidad + "/<?php echo $vc_params?>";

  $("#form_propiedades").attr("action",link);
  return true;
}


function enviar_ficha_email() {
  var email = prompt("Escriba su email: ");
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido.");
  } else {
    var datos = {
      "texto":"Ficha de Propiedad",
      "email_to":email,
      "email_from":"<?php echo $empresa->email ?>",
      "id_empresa":ID_EMPRESA,
      "adjuntos":[{
        "id_objeto":"<?php echo $propiedad->id ?>",
        "nombre":"<?php echo ($propiedad->nombre) ?>",
        "tipo":3
      }],
      "asunto":"<?php echo ($propiedad->nombre) ?>",
    };
    $.ajax({
      "url":"/admin/emails/0",
      "type":"PUT",
      "dataType":"json",
      "data":JSON.stringify(datos),
      "success":function(res) {
        if (res.error == 0) {
          alert("Hemos enviado la ficha de la propiedad a '"+email+"'. Muchas gracias.");
        } else {
          alert("Ha ocurrido un error al enviar el email. Disculpe las molestias.");
        }
      }
    });
  }
}
</script> 
<script type="text/javascript">
  $('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitar una visita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="visita_nombre"  class="col-form-label">Nombre:</label>
              <input type="text" id="visita_nombre" class="form-control">
            </div>
            <div class="form-group">
              <label for="visita_telefono" class="col-form-label">Teléfono:</label>
              <input type="text" id="visita_telefono"  class="form-control">
            </div>
            <div class="form-group">
              <label for="visita_email"  class="col-form-label">Email:</label>
              <input type="text" id="visita_email" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
          <button type="button" onclick="return enviar_contacto_visita()" class="btn btn-red" id="visita_submit">Solicitar visita</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  var enviando = 0;
  function enviar_contacto_visita() {
    if (enviando == 1) return;
    var nombre = $("#visita_nombre").val();
    var email = $("#visita_email").val();
    var telefono = $("#visita_telefono").val();
    var dia = $("#visita_dia").val();
    var hora = $("#visita_hora").val();
    var id_propiedad = <?php echo $propiedad->id ?>;
    var id_origen = <?php echo (isset($id_origen) ? $id_origen : 0) ?>;

    if (isEmpty(nombre) || nombre == "Nombre") {
      alert("Por favor ingrese un nombre");
      $("#visita_nombre").focus();
      return false;      
    }
    if (!validateEmail(email)) {
      alert("Por favor ingrese un email valido");
      $("#visita_email").focus();
      return false;      
    }
    if (isEmpty(telefono) || telefono == "Telefono") {
      alert("Por favor ingrese un telefono");
      $("#visita_telefono").focus();
      return false;      
    }

    $("#visita_submit").attr('disabled', 'disabled');
    var datos = {
      "para":"<?php echo $empresa->email ?>",
      "nombre":nombre,
      "email":email,
      "telefono":telefono,
      "mensaje":dia + " por la " + hora,
      "asunto":"Visita para <?php echo $propiedad->nombre ?> (Cod: <?php echo $propiedad->codigo ?>)",
      "id_propiedad":id_propiedad,
      "id_empresa":ID_EMPRESA,
      <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?>
        "id_empresa_relacion":"<?php echo $propiedad->id_empresa ?>",
      <?php } ?>
      "id_origen": ((id_origen != 0) ? id_origen : ((id_propiedad != 0)?1:6)),
    }
    enviando = 1;
    $.ajax({
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
          $("#visita_submit").removeAttr('disabled');
          enviando = 0;
        }
      }
    });
    return false;
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