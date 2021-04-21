<?php 
include "includes/init.php";
$vc_view = 0;
$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id,array(
  "buscar_total_visitas"=>1,
  "buscar_relacionados_offset"=>4,
  "id_empresa"=>$id_empresa,
));
if ($propiedad === FALSE || !isset($propiedad->nombre)) header("Location:".mklink("/"));
if (!empty($titulo_pagina)) { $titulo_pagina = $propiedad->nombre; }
$nombre_pagina = "detalle";
$mostro_video = 0;
if (!empty($propiedad->path)) $propiedad->images = array_merge(array($propiedad->imagen),$propiedad->images);

if ($propiedad->id_tipo_operacion == 1) $vc_moneda = "USD";
else $vc_moneda = "$";
$vc_tipo_operacion = $propiedad->tipo_operacion_link;

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad"=>$propiedad->id));

$vc_precio_maximo = $propiedad_model->get_precio_maximo(array(
  "id_tipo_operacion"=>$propiedad->id_tipo_operacion,
));
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include "includes/head.php" ?>
<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $propiedad->nombre; ?>" />
<meta property="og:description" content="<?php echo str_replace("\n", "", substr(strip_tags($propiedad->texto),0,300).((strlen($propiedad->texto) > 300) ? "..." : ""));?>" />
<?php 
$imagen_ppal = "";
if (empty($propiedad->path) && !empty($propiedad->video)) { 
  preg_match('/src="([^"]+)"/', $propiedad->video, $match);
  if (sizeof($match)>0) {
    $src_iframe = $match[1];
    $id_video = str_replace("https://www.youtube.com/embed/", "", $src_iframe);
    $imagen_ppal = "https://img.youtube.com/vi/$id_video/0.jpg";
  }
} else {
  $imagen_ppal = current_url(TRUE)."/admin/".$propiedad->path;
} 
if (empty($imagen_ppal)) $imagen_ppal = current_url(TRUE)."/admin/".$empresa->no_imagen;
?>
<meta property="og:image" content="<?php echo $imagen_ppal; ?>"/>
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css"/>
<script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
</head>
<body class="detalle">
  <?php include "includes/header.php" ?>
  <?php $t = $web_model->get_text("property-banner","images/sub-banner-1.jpg")?>
  <div class="sub-banner editable editable-img" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" data-height="279" data-width="1583">
    <div class="overlay">
      <div class="container">
        <div class="breadcrumb-area">
          <h2 class="h1"><?php echo $propiedad->tipo_operacion ?></h2>
        </div>
      </div>
    </div>
  </div>

  <div class="properties-details-page content-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
          <!-- Header -->
          <div class="heading-properties clearfix sidebar-widget">
            <h1 class="h3"><?php echo $propiedad->nombre ?></h1>
            <div class="oh pt5">
              <div class="pull-left">
                <?php if (!empty($propiedad->direccion_completa) || !empty($propiedad->localidad)) { ?>
                  <p>
                    <i class="fa fa-map-marker"></i><?php echo ((!empty($propiedad->direccion_completa)) ? $propiedad->direccion_completa.", " : "").(!empty($propiedad->localidad) ? " ".$propiedad->localidad : "")?>
                  </p>
                <?php } ?>
              </div>
              <div class="pull-right">
                <h3 class="mt10">
                  <span>
                    <?php echo $propiedad->precio ?>
                  </span>
                </h3>
              </div>
            </div>
            <p class="fs14">
              Código: <b><?php echo $propiedad->codigo ?></b>
            </p>
          </div>
          <!-- Properties details section start -->
          <div class="sidebar-widget mrg-btm-40">
            <!-- Properties detail slider start -->
            <div class="properties-detail-slider simple-slider mrg-btm-40 ">
              <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                <div class="carousel-outer">
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                    <?php if (!empty($propiedad->images)) {  ?>
                      <?php $i=0; 
                      foreach ($propiedad->images as $img) { $i++; ?>
                        <div class="item <?php echo ($i==1) ? "active" : "" ?>">
                          <a class="pr oh" data-fancybox="gallery" href="<?php echo $img ?>">
                            <img src="<?php echo $img ?>" class="thumb-preview" alt="<?php echo $propiedad->nombre ?>">
                            <?php if ($propiedad->id_tipo_estado >= 2) { ?>
                              <div class="property-tag button vendido alt featured"><?php echo $propiedad->tipo_estado ?></div>
                            <?php } ?>
                          </a>
                        </div>
                        <a class="left carousel-control" href="#carousel-custom" role="button" data-slide="prev">
                          <span class="slider-mover-left no-bg" aria-hidden="true">
                            <i class="fa fa-angle-left"></i>
                          </span>
                          <span class="sr-only">Siguiente</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-custom" role="button" data-slide="next">
                          <span class="slider-mover-right no-bg" aria-hidden="true">
                            <i class="fa fa-angle-right"></i>
                          </span>
                          <span class="sr-only">Anterior</span>
                        </a>
                      <?php } ?>
                    <?php } else if (!empty($propiedad->imagen)) { ?>
                      <div class="item active">
                        <a data-fancybox="gallery" href="<?php echo $propiedad->imagen ?>">
                          <img src="<?php echo $propiedad->imagen ?>" class="thumb-preview">
                        </a>
                      </div>
                    <?php } else if (empty($propiedad->imagen) && !empty($propiedad->video)) { ?>
                      <?php $mostro_video = 1; echo $propiedad->video ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>

            <?php if (!empty($propiedad->texto)) { ?>
              <div class="properties-description mrg-btm-40 ">
                <div class="main-title-2">
                  <h1><span>Descripción</span></h1>
                </div>
                <?php echo $propiedad->texto ?>              
              </div>
            <?php } ?>

            <div class="properties-condition mrg-btm-20 ">
              <div class="main-title-2">
                <h1><span>Más detalles</span></h1>
              </div>
              <div class="row">

                <?php if (!empty($propiedad->superficie_cubierta)) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-star-o"></i><?php echo "Sup. Cubierta: ".$propiedad->superficie_cubierta." mts<sup>2</sup>"; ?>
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if (!empty($propiedad->superficie_semicubierta)) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-star-half-empty"></i><?php echo "Sup. Semicubierta: ".$propiedad->superficie_semicubierta." mts<sup>2</sup>"; ?>
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if (!empty($propiedad->superficie_descubierta)) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-star"></i><?php echo "Sup. Descubierta: ".$propiedad->superficie_descubierta." mts<sup>2</sup>"; ?>
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if (!empty($propiedad->superficie_total)) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-star"></i><?php echo "Sup. Total: ".$propiedad->superficie_total." mts<sup>2</sup>"; ?>
                      </li>
                    </ul>
                  </div>
                <?php } ?>

                <?php if (!empty($propiedad->caracteristicas)) {  ?>
                  <?php $array = explode (";;;",$propiedad->caracteristicas) ?>
                  <?php foreach($array as $a) { ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <ul class="condition">
                        <li>
                          <i class="fa fa-check"></i><?php echo $a ?>
                        </li>
                      </ul>
                    </div>
                  <?php } ?>
                <?php } ?>

                <?php if ($propiedad->mts_frente != 0) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-arrows-h"></i>
                        Frente: <?php echo str_replace(".00", "", $propiedad->mts_frente) ?> Mts.
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->mts_fondo != 0) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-arrows-v"></i>
                        Fondo: <?php echo str_replace(".00", "", $propiedad->mts_fondo) ?> Mts.
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->id_tipo_inmueble != 5 && $propiedad->id_tipo_inmueble != 6 && $propiedad->id_tipo_inmueble != 7 && $propiedad->id_tipo_inmueble != 13 && $propiedad->id_tipo_inmueble != 9 && $propiedad->id_tipo_inmueble != 10) { ?>
                  
                  <?php if (!empty($propiedad->ambientes)) { ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <ul class="condition">
                        <li>
                          <i class="fa fa-home"></i><?php echo $propiedad->ambientes ?> Ambientes
                        </li>
                      </ul>
                    </div>
                  <?php } ?>

                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-bed"></i><?php echo (!empty($propiedad->dormitorios)) ? $propiedad->dormitorios : "-" ?> Dormitorios
                      </li>
                    </ul>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-bath"></i><?php echo (!empty($propiedad->banios)) ? (($propiedad->banios == 1)?"1 Baño":$propiedad->banios." Baños") : "-" ?>
                      </li>
                    </ul>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-car"></i><?php echo (!empty($propiedad->cocheras)) ? (($propiedad->cocheras == 1)?"Cochera":$propiedad->cocheras." Cocheras") : "Sin cochera" ?>
                      </li>
                    </ul>
                  </div>
                <?php } ?>

                <?php if ($propiedad->servicios_cloacas == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-bath"></i>Cloacas
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_agua_corriente == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-tint"></i>Agua Corriente
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_electricidad == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-bolt"></i>Electricidad
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_asfalto == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-truck"></i>Asfalto
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_gas == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-fire"></i>Gas Natural
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_telefono == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-phone"></i>Teléfono
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_cable == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-television"></i>TV Cable
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                
                <?php if ($propiedad->apto_banco == 1) {  ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-bank"></i>Apto para crédito bancario
                      </li>
                    </ul>
                  </div>
                <?php } ?>

                <?php if ($propiedad->acepta_permuta == 1) {  ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-exchange"></i>Posibilidad de permuta
                      </li>
                    </ul>
                  </div>
                <?php } ?>

              </div>
            </div>
            <!-- Properties condition end -->
          </div>
          <!-- Properties details section end -->

          <!-- Location start -->
          <?php if(!empty($propiedad->latitud)) { ?>
            <div class="location sidebar-widget">
              <div class="map">
                <div class="main-title-2 mb10">
                  <h1><span>Ubicación</span></h1>
                </div>
                <div class="heading-properties mb20">
                  <p>
                    <i class="fa fa-map-marker"></i><?php echo $propiedad->direccion_completa.", ".$propiedad->localidad?>
                  </p>
                </div>
                <div id="googleMap" style="width:100%;height:320px;"></div>
              </div>
            </div>
          <?php } ?>

          <div class="sidebar-widget contact-form agent-widget">
            <div class="main-title-2">
              <h1><span>Consultá</span> por esta propiedad</h1>
            </div>
            <form onsubmit="return enviar_contacto();">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <input type="text" id="contacto_nombre" name="nombre" class="input-text" placeholder="Nombre">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group enter-email">
                    <input type="email" id="contacto_email" name="email" class="input-text" placeholder="Email">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group number">
                    <input type="text" id="contacto_telefono" name="phone" class="input-text"  placeholder="Teléfono">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group message">
                    <textarea class="input-text" id="contacto_mensaje" name="message" placeholder="Mensaje"></textarea>
                  </div>
                </div>
                <div class="col-lg-12">
                  <button type="submit" id="contacto_submit" class="button-md button-theme btn-block">Enviar consulta</button>
                </div>
              </div>
            </form>
          </div>
          
          <?php if (!empty($propiedad->video) && $mostro_video == 0) {  ?>
            <div class="inside-properties sidebar-widget">
              <div class="main-title-2">
                <h1><span>Video</span></h1>
              </div>
              <?php echo $propiedad->video ?>
            </div>
          <?php } ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <!-- Sidebar start -->
          <div class="sidebar right">
            
            <?php include("includes/avanzada.php"); ?>

            <div class="social-media sidebar-widget clearfix">
              <!-- Main Title 2 -->
              <div class="main-title-2">
                <h1><span>Compartir</span> Propiedad</h1>
              </div>
              <!-- Social list -->
              <ul class="social-list">
                <li><a class="facebook" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()) ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a class="twitter" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(html_entity_decode($propiedad->nombre,ENT_QUOTES)) ?>&amp;url=<?php echo urlencode(current_url()) ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a class="google" href="https://plus.google.com/share?url=<?php echo current_url() ?>" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                <li><a class="mail" href="mailto:?subject=<?php echo html_entity_decode($propiedad->nombre,ENT_QUOTES) ?>&body=<?php echo(current_url()) ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                <li><a class="whatsapp" href="whatsapp://send?text=<?php echo urlencode(current_url()) ?>"><i class="fa fa-whatsapp"></i></a></li>
              </ul>
            </div>
            
            <?php include("includes/destacadas.php"); ?>
            
          </div>
          <!-- Sidebar end -->
        </div>

        <div class="col-xs-12">
          <div class="clearfix sidebar-widget">
            <?php if (!empty($propiedad->relacionados)) { ?>
              <div class="main-title-2">
                <h1><span>Propiedades</span> Relacionadas</h1>
              </div>
              <div class="row">
                <div class="recently-properties clearfix">
                  <?php foreach ($propiedad->relacionados as $p) { ?>
                  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- Property start -->
                      <div class="property">
                      <!-- Property img -->
                      <a href="<?php echo $p->link_propiedad ?>" class="property-img">
                        <?php if ($p->id_tipo_estado >= 2) { ?>
                          <div class="property-tag button vendido alt featured"><?php echo $p->tipo_estado ?></div>
                        <?php } else { ?>
                          <div class="property-tag button alt featured"><?php echo $p->tipo_operacion ?></div>
                        <?php } ?>
                        <div class="property-tag button sale"><?php echo $p->tipo_inmueble ?></div>
                        <div class="property-price">
                          <?php echo $p->precio ?>
                        </div>
                        <?php if (!empty($p->imagen)) { ?>
                          <img class="img-responsive" src="<?php echo $p->imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                        <?php } else if (!empty($empresa->no_imagen)) { ?>
                          <img class="img-responsive" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                        <?php } else { ?>
                          <img class="img-responsive" src="images/logo.png" alt="<?php echo ($p->nombre); ?>" />
                        <?php } ?>
                      </a>
                      <!-- Property content -->
                      <div class="property-content">
                        <div class="height-igual">
                          <!-- title -->
                          <h1 class="title">
                            <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                          </h1>
                          <?php echo ver_direccion($p); ?>
                          <?php echo ver_caracteristicas($p); ?>
                        </div>
                        <!-- Property footer -->
                        <?php /*
                        <div class="property-footer">
                          <span class="left"><i class="fa fa-calendar-o icon"></i> <?php echo $p->fecha_publicacion ?></span>
                          <span class="right">
                            <a href="javascript:void(0);"><i class="fa fa-heart-o icon"></i></a>
                            <a href="javascript:void(0);"><i class="fa fa-share-alt"></i></a>
                          </span>
                        </div>
                        */ ?>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- Properties details page end -->
  <!-- Footer start -->
<?php include "includes/footer.php" ?>
<script type="text/javascript" src="js/jquery.fancybox.min.js"></script>

<script>
$(document).ready(function(){
  <?php if (!empty($propiedad->latitud && !empty($propiedad->longitud))) { ?>
    var mymap = L.map('googleMap').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
    }).addTo(mymap);


    var icono = L.icon({
      iconUrl: 'images/map-marker.png',
      iconSize:     [48, 33], // size of the icon
      iconAnchor:   [22, 33], // point of the icon which will correspond to marker's location
    });

    L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>]).addTo(mymap);

  <?php } ?>
});
</script>
<script type="text/javascript">
function enviar_orden() { 
  $("#orden_form").submit();
}
function enviar_buscador_propiedades() {
  var link = "<?php echo mklink("propiedades/")?>";
  var tipo_operacion = $("#buscador_tipo_operacion").val();
  var localidad = $("#buscador_localidad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
function enviar_contacto() {
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var id_propiedad = "<?php echo $propiedad->id ?>";
  
  if (isEmpty(nombre)) {
    alert("Por favor ingrese un nombre");
    $("#contacto_nombre").focus();
    return false;          
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_email").focus();
    return false;          
  }
  if (isEmpty(telefono)) {
    alert("Por favor ingrese un telefono");
    $("#contacto_telefono").focus();
    return false;          
  }
  if (isEmpty(mensaje)) {
    alert("Por favor ingrese un mensaje");
    $("#contacto_mensaje").focus();
    return false;              
  }    
  
  $("#contacto_submit").attr('disabled', 'disabled');
  var datos = {
    "para":"<?php echo $empresa->email ?>",
    "bcc":"<?php echo $empresa->bcc_email ?>",
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "id_propiedad":id_propiedad,
    "id_empresa":ID_EMPRESA,
    "id_origen": 9,
  }
  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
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