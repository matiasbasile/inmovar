<?php
include_once("includes/init.php");
$nombre_pagina = "detalle";
$id_origen = 1;
$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;

$propiedad = $propiedad_model->get($id,array(
  "buscar_total_visitas"=>1,
  "buscar_relacionados_offset"=>3,
  "id_empresa"=>$id_empresa,
  "id_empresa_original"=>$empresa->id,
));

if ($propiedad->activo == 0 && !isset($get_params["preview"])) {
  header("Location: ".mklink("/"));
  exit();
}

$precio_maximo = $propiedad_model->get_precio_maximo(array(
  "id_tipo_operacion"=>$propiedad->id_tipo_operacion,
));

// Minimo
if (isset($_POST["minimo"])) { $_SESSION["minimo"] = filter_var($_POST["minimo"],FILTER_SANITIZE_STRING); }
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;

// Maximo
if (isset($_POST["maximo"])) { $_SESSION["maximo"] = filter_var($_POST["maximo"],FILTER_SANITIZE_STRING); }
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo;

// Tomamos los datos de SEO
$seo_title = (!empty($propiedad->seo_title)) ? $propiedad->seo_title : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? $propiedad->seo_description : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? $propiedad->seo_keywords : $empresa->seo_keywords;

$cookie_id_cliente = (isset($_COOKIE['idc'])) ? $_COOKIE['idc'] : 0;

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad"=>$propiedad->id));

if (sizeof($propiedad->images)==0 && !empty($propiedad->imagen)) $propiedad->images = array_merge(array($propiedad->imagen),$propiedad->images);
$nombre_pagina = $propiedad->tipo_operacion_link;

if ($propiedad->id_tipo_operacion == 1) $vc_moneda = "USD";
else $vc_moneda = "$";
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo $propiedad->nombre; ?>" />
<meta property="og:description" content="<?php echo str_replace("\n","",(strip_tags(html_entity_decode($propiedad->texto,ENT_QUOTES)))); ?>" />
<meta property="og:image" content="<?php echo $propiedad->imagen ?>"/>
</head>
<body>

<!-- TOP WRAPPER -->
<div class="top-wrapper">
  <?php include("includes/header.php"); ?>
  <div class="page-title">
    <div class="page">
      <div class="breadcrumb">
        <a href="<?php echo mklink("/") ?>"><img src="images/home-icon3.png" alt="Home" /> Home</a>
        <?php if (!empty($propiedad->id_tipo_operacion)) { ?>
          <a href="<?php echo mklink("propiedades/".$propiedad->tipo_operacion_link."/") ?>"><?php echo $propiedad->tipo_operacion ?></a>
          <?php if (!empty($propiedad->id_localidad)) { ?>
            <a href="<?php echo mklink("propiedades/".$propiedad->tipo_operacion_link."/".$propiedad->localidad_link."/") ?>"><?php echo ($propiedad->localidad) ?></a>
          <?php } ?>
        <?php } ?>
      </div>
      <big><?php echo ($propiedad->tipo_operacion); ?></big>
    </div>
  </div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
  <div class="page">
    <div class="row">
      <div class="col-md-9 primary">
        <div class="property-full-info">
          <?php if (!empty($propiedad->images)) { ?>
            <?php $foto = $propiedad->images[0]; ?>
            <div id="gallery-slider">
              <div id="gallery-picture">
                <img src="<?php echo $foto ?>" alt="" />
              </div>
              <div id="hidden-thumbs">
                <?php foreach($propiedad->images as $f) { ?>
                  <img src="<?php echo $f ?>" alt="" />
                <?php } ?>
              </div>
              <div class="thumbnails">
                <a href="javascript:void(0);" id="gallery-nav" class="prev-button"></a>
                <a href="javascript:void(0);" id="gallery-nav" class="next-button"></a>
                <div id="thumbcon"></div>
              </div>
            </div>
          <?php } else if (!empty($propiedad->imagen)) { ?>
            <div>
              <img style="width: 100%; margin-bottom: 30px; " src="<?php echo $propiedad->imagen ?>" alt="" />
            </div>
          <?php } ?>
          <div class="property-name">
            <div class="property-price">
              <big>
                <?php echo $propiedad->precio ?>
              </big>
            </div>
            <?php echo $propiedad->nombre; ?>
          </div>
          <div class="border-box">
            <div class="box-space">
              <div class="property-location">
                <div class="pull-left"><?php echo $propiedad->direccion_completa." | ".$propiedad->localidad ?></div>
                <?php if ($propiedad->activo == 1) { ?>
                  <div class="pull-right">
                    <?php if (!empty($propiedad->codigo)) { ?>
                      <small>Cod: <span><?php echo $propiedad->codigo ?></span></small>
                    <?php } ?>
                    <small>
                      <?php if (estaEnFavoritos($propiedad->id)) { ?>
                        <a href="/admin/favoritos/eliminar/?id=<?php echo $propiedad->id; ?>" class="favorites-properties active"><span class="tooltip">Borrar de Favoritos</span></a>
                      <?php } else { ?>
                        <a href="/admin/favoritos/agregar/?id=<?php echo $propiedad->id; ?>" class="favorites-properties"><span class="tooltip">Guarda Tus Inmuebles Favoritos</span></a>
                      <?php } ?>
                    </small>
                    <small><span class="st_sharethis_large"></span></small>
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="property-facilities">
              <?php if (!empty($propiedad->dormitorios)) { ?>
                <div class="facilitie"><img src="images/room-icon.png" alt="Room" /> <?php echo $propiedad->dormitorios ?> Hab</div>
              <?php } ?>
              <?php if (!empty($propiedad->banios)) { ?>
                <div class="facilitie"><img src="images/bathroom-icon.png" alt="Bathroom" /> <?php echo $propiedad->banios ?> Ba&ntilde;os</div>
              <?php } ?>
              <?php if (!empty($propiedad->cocheras)) { ?>
                <div class="facilitie"><img src="images/garage-icon.png" alt="Garage" /> Cochera</div>
              <?php } ?>
              <?php if (!empty($propiedad->superficie_total)) { ?>
                <div class="facilitie"><img src="images/grid-icon.png" alt="Grid" /> <?php echo $propiedad->superficie_total ?></div>
              <?php } ?>
            </div>
            <?php if (!empty($propiedad->texto)) { ?>
              <div class="box-space">
                <?php echo nl2br(html_entity_decode($propiedad->texto,ENT_QUOTES)); ?>
              </div>
            <?php } ?>
            <?php $caracteristicas = explode(";;;",$propiedad->caracteristicas);
            if (sizeof($caracteristicas)>0 && !empty($caracteristicas[0])) { ?>
              <div class="info-title">Caracter&iacute;sticas Generales</div>
              <div class="box-space">
                <div class="available-facilities">
                  <ul>
                    <?php foreach($caracteristicas as $c) { ?>
                      <li><?php echo ($c); ?></li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            <?php } ?>
            <?php if (!empty($propiedad->video)) { ?>
              <div class="info-title">Video</div>
              <div class="box-space video">
                <?php echo $propiedad->video; ?>
              </div>
            <?php } ?>
            <?php if ($propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
              <div class="info-title">Ubicaci&oacute;n en mapa</div>
              <div class="box-space">
                <div id="map"></div>
              </div>
            <?php } ?>
            <?php if ($propiedad->activo == 0) { ?>
              <div class="info-title">la propiedad ya no se encuentra disponible</div>
            <?php } else { ?>
              <div class="info-title">formulario de consulta</div>
              <div class="box-space">
                <div class="form">
                  <div class="row">
                    <?php include("includes/form_contacto.php"); ?>
                  </div>
                </div>
              </div>
              <div class="info-title">ficha de propiedad</div>
              <div class="box-space">
                <div class="helpful-links">
                  <a target="_blank" href="/admin/propiedades/function/ficha/<?php echo $propiedad->hash ?>"><img src="images/pdf-icon.png" alt="Download PDF" /> descargar pdf</a> 
                  <a href="javascript:void(0)" onclick="enviar_ficha_email()"><img src="images/email-icon2.png" alt="Send by Email" /> enviar por email</a> 
                  <a target="_blank" href="/admin/propiedades/function/ficha/<?php echo $propiedad->hash ?>"><img src="images/printer-icon.png" alt="Print Property" /> imprimir propiedad</a> 
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <?php
        // Propiedades relacionadas o similares
        
        // A las propiedades relacionadas especificamente a mano, las debemos juntar por las
        // similares que coinciden en ciudad, tipo de operacion y tipo de inmueble
        
        if (!empty($propiedad->relacionados)) { ?>
          <div class="grid-view">
            <div class="row">
              <?php foreach($propiedad->relacionados as $r) { ?>
                <div class="col-md-4">
                  <div class="property-item">
                    <div class="item-picture">
                      <div class="block">
                        <?php if (!empty($r->imagen)) { ?>
                          <img src="<?php echo $r->imagen ?>" alt="<?php echo $r->nombre; ?>" />
                        <?php } else if (!empty($empresa->no_imagen)) { ?>
                          <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo $r->nombre; ?>" />
                        <?php } else { ?>
                          <img src="images/logo.png" alt="<?php echo $r->nombre; ?>" />
                        <?php } ?>
                      </div>
                      <div class="view-more"><a href="<?php echo $r->link_propiedad ?>"></a></div>
                      <div class="property-status">
                        <?php if ($r->id_tipo_estado != 1) { ?>
                          <span><?php echo ($r->tipo_estado) ?></span>
                        <?php } else { ?>
                          <span><?php echo ($r->tipo_operacion) ?></span>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="property-detail">
                      <div class="property-name">
                        <a href="<?php echo $r->link_propiedad ?>"><?php echo $r->direccion_completa ?></a>
                      </div>
                      <div class="property-location">
                        <div class="pull-left"><?php echo ($r->localidad) ?></div>
                        <?php if (!empty($r->codigo)) { ?>
                          <div class="pull-right">Cod: <span><?php echo ($r->codigo)?></span></div>
                        <?php } ?>
                      </div>
                      <div class="property-facilities">
                        <?php if (!empty($r->dormitorios)) { ?>
                          <div class="facilitie"><img src="images/room-icon.png" alt="Room" /> <?php echo $r->dormitorios ?> Hab</div>
                        <?php } ?>
                        <?php if (!empty($r->banios)) { ?>
                          <div class="facilitie"><img src="images/bathroom-icon.png" alt="Bathroom" /> <?php echo $r->banios ?> Ba&ntilde;os</div>
                        <?php } ?>
                        <?php if (!empty($r->cocheras)) { ?>
                          <div class="facilitie"><img src="images/garage-icon.png" alt="Garage" /> Cochera</div>
                        <?php } ?>
                        <?php if (!empty($r->superficie_total)) { ?>
                          <div class="facilitie"><img src="images/grid-icon.png" alt="Grid" /> <?php echo $r->superficie_total ?></div>
                        <?php } ?>
                      </div>
                      <?php if (!empty($r->descripcion)) { ?>
                        <p class="property-description"><?php echo (strlen($r->descripcion)>50) ? substr(($r->descripcion),0,50)."..." : ($r->descripcion) ?></p>
                      <?php } ?>
                      <div class="property-price">
                        <big><?php echo ($r->precio_final != 0) ? $r->moneda." ".number_format($r->precio_final,0) : "A consultar"; ?></big>
                        <?php if (estaEnFavoritos($r->id)) { ?>
                          <a href="/admin/favoritos/eliminar/?id=<?php echo $r->id; ?>" class="favorites-properties active"><span class="tooltip">Borrar de Favoritos</span></a>
                        <?php } else { ?>
                          <a href="/admin/favoritos/agregar/?id=<?php echo $r->id; ?>" class="favorites-properties"><span class="tooltip">Guarda Tus Inmuebles Favoritos</span></a>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="col-md-3 secondary">
        <?php include("includes/sidebar.php"); ?>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>

<!-- SCRIPT'S --> 
<script type="text/javascript" src="js/jquery.min.js"></script> 
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript" src="js/wNumb.js"></script> 
<script type="text/javascript" src="js/nouislider.js"></script> 
<?php if (sizeof($propiedad->images)>0) { ?>
  <script type="text/javascript" src="js/galleryslider.js"></script> 
<?php } ?>
<script type="text/javascript" src="js/custom.js"></script>
<?php if ($propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
<script type="text/javascript">

  var mymap = L.map('map').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);

  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
    tileSize: 512,
    maxZoom: 18,
    zoomOffset: -1,
    id: 'mapbox/streets-v11',
    accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
  }).addTo(mymap);


  var icono = L.icon({
    iconUrl: 'images/map-place.png',
    iconSize:     [60, 60], // size of the icon
    iconAnchor:   [30, 30], // point of the icon which will correspond to marker's location
  });

  L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>],{
    icon: icono
  }).addTo(mymap);

</script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){

  var maximo = 0;
  $(".property-item").each(function(i,e){
    if ($(e).height()>maximo) maximo = $(e).height();
  });
  $(".property-item").height(maximo);

  $(".pagination a").click(function(e){
    e.preventDefault();
    var url = $(e.currentTarget).attr("href");
    
    var f = document.createElement("form");
    f.setAttribute('method',"post");
    f.setAttribute('action',url);
    
    var i = document.createElement("input");
    i.setAttribute('type',"hidden");
    i.setAttribute('name',"id_tipo_inmueble");
    i.setAttribute('value',$(".filter_tipo_propiedad").first().val());
    f.appendChild(i);
    
    var i = document.createElement("input");
    i.setAttribute('type',"hidden");
    i.setAttribute('name',"banios");
    i.setAttribute('value',$(".filter_banios").first().val());
    f.appendChild(i);  
    
    var i = document.createElement("input");
    i.setAttribute('type',"hidden");
    i.setAttribute('name',"dormitorios");
    i.setAttribute('value',$(".filter_dormitorios").first().val());
    f.appendChild(i);
    
    f.submit();    
  });
});

$(document).ready(function(){
  <?php for($i=0;$i<5;$i++) { ?>
	  $("#show-in-list-<?php echo $i ?>").click(function(){
	    var v = $("#show-in-list-<?php echo $i ?>").prop("checked");
	    $("#show-in-map-<?php echo $i ?>").prop("checked",!v);
	  });
	  $("#show-in-map-<?php echo $i ?>").click(function(){
	    var v = $("#show-in-map-<?php echo $i ?>").prop("checked");
	    $("#show-in-list-<?php echo $i ?>").prop("checked",!v);
	  });
  <?php } ?>
});


//UI SLIDER SCRIPT
$('.slider-snap').noUiSlider({
	start: [ <?php echo $minimo ?>, <?php echo $maximo ?> ],
	step: 10,
	connect: true,
	range: {
		'min': 0,
		'max': <?php echo $precio_maximo ?>,
	},
  format: wNumb({
		decimals: 0,
		thousand: '.',
	})
});
$('.slider-snap').Link('lower').to($('.slider-snap-value-lower'));
$('.slider-snap').Link('upper').to($('.slider-snap-value-upper'));

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
        "nombre":"<?php echo $propiedad->nombre ?>",
        "tipo":3
      }],
      "asunto":"<?php echo $propiedad->nombre ?>",
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
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "94d2174e-398d-4a49-b5ce-0b6a19a58759", onhover: false, doNotHash: true, doNotCopy: false, hashAddressBar: false});</script>

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