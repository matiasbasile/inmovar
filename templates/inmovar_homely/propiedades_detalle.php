<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "includes/init.php";

$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id,array(
  "id_empresa"=>$id_empresa,
  "id_empresa_original"=>$empresa->id,
  "buscar_total_visitas"=>1,
  "buscar_relacionados"=>1,
  "buscar_relacionados_offset"=>6,
));
if (($propiedad === FALSE || !isset($propiedad->nombre) || $propiedad->activo == 0) && !isset($get_params["preview"])) {
  header("HTTP/1.1 302 Moved Temporarily");
  header("Location:".mklink("/"));
  exit();
}

$page_active = $propiedad->tipo_operacion_link;
$titulo_pagina = $propiedad->tipo_operacion_link;

// Llenamos los parametros por defecto
$vc_link_tipo_operacion = $propiedad->tipo_operacion_link;
$vc_link_localidad = $propiedad->localidad_link;
$vc_id_tipo_inmueble = $propiedad->id_tipo_inmueble;
$vc_precio_maximo = $propiedad_model->get_precio_maximo(array(
  "id_tipo_operacion"=>$propiedad->id_tipo_operacion,
));
$vc_maximo = $vc_precio_maximo;

// Tomamos los datos de SEO
$seo_title = ((!empty($propiedad->seo_title)) ? $propiedad->seo_title : ucwords(strtolower($propiedad->nombre)))." | ".(!empty($empresa->seo_title) ? $empresa->seo_title : $empresa->nombre);
$seo_description = (!empty($propiedad->seo_description)) ? $propiedad->seo_description : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? $propiedad->seo_keywords : $empresa->seo_keywords;

$cookie_id_cliente = 0; //(isset($_COOKIE['idc'])) ? $_COOKIE['idc'] : 0;
$cookie_hide_lightbox = 0; //(isset($_COOKIE['hide_lightbox'])) ? $_COOKIE['hide_lightbox'] : 0;

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad"=>$propiedad->id));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include "includes/head.php" ?>
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css">
<script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
<script>const ID_EMPRESA_RELACION = "<?php echo $id_empresa ?>";</script>
</head>
<body>
  <?php include "includes/header.php" ?>


<section class="subheader subheader-slider property-single-item">
  <div class="property-gallery full-width">
    <div class="slider-wrap">
    
      <div class="property-header property-header-slider">
        <div class="container">
          <div class="property-title">
            <div class="property-price-single right"><?php echo $propiedad->precio ?></div>
            <h1><?php echo ucwords(strtolower($propiedad->nombre)) ?></h1>
            <p class="property-address"><i class="fa fa-map-marker icon"></i><?php echo $propiedad->direccion_completa.". ".$propiedad->localidad ?></p>
            <div>
              C&oacute;digo: <?php echo $propiedad->codigo ?>
            </div>
          </div>
          <div class="property-single-tags">
            <?php if ($propiedad->nuevo == 1) { ?>
              <div class="property-tag button alt featured">Nueva</div>
            <?php } ?>
            <div class="property-tag button status">
              <?php echo ($propiedad->tipo_operacion_link == "alquileres")?"Alquilamos":"" ?>
              <?php echo ($propiedad->tipo_operacion_link == "ventas")?"Vendemos":"" ?>
              <?php echo ($propiedad->tipo_operacion_link == "alquileres-temporarios")?"Alquilamos":"" ?>
            </div>
            <div class="property-tag button right"><?php echo $propiedad->tipo_inmueble ?></a></div>
          </div>
        </div>
      </div>

      <div class="slider-property-gallery">
        <img src="<?php echo $propiedad->imagen ?>" alt="<?php echo $propiedad->nombre ?>"/>
      </div>

      <div class="container">
        <div class="owl-carousel property-gallery-pager">
          <?php foreach ($propiedad->images as $img) {  ?>
            <div class="item">
              <a data-fancybox="gallery" href="<?php echo $img ?>" class="property-gallery-thumb">
                <div class="marca_agua">
                  <img src="<?php echo $img ?>" alt="" />
                </div>
              </a>
            </div>
          <?php } ?>
        </div>
      </div>
      
    </div><!-- end slider wrap -->
  </div><!-- end property gallery -->
</section>
<?php exit(); ?>
<section class="module no-padding-top">
  <div class="container">
  
  <div class="row">
    <div class="col-lg-8 col-md-8">
    
      <div class="property-single-item property-details">
        <table class="property-details-single">
          <tr>
            <td><i class="fa fa-bed"></i> <span><?php echo (empty($propiedad->dormitorios)) ? "-" : $propiedad->dormitorios ?></span> Dorm</td>
            <td><i class="fa fa-tint"></i> <span><?php echo (empty($propiedad->banios)) ? "-" : $propiedad->banios ?></span> baño<?php echo ($propiedad->banios > 1)?'s':''?></td>
            <td><i class="fa fa-expand"></i> <span><?php echo (empty($propiedad->superficie_total)) ? "-" : $propiedad->superficie_total ?></span> m<sup>2</sup></td>
            <td><i class="fa fa-car"></i> <span><?php echo (empty($propiedad->cocheras)) ? "-" : $propiedad->cocheras ?></span> Cocheras</td>
          </tr>
        </table>
      </div>

      <div class="widget property-single-item property-description content">
        <h4>
          <span><?php echo ucwords(strtolower($propiedad->nombre)) ?></span><hr class="divisorline">
          <div class="divider-fade"></div>
        </h4>
        <p><?php echo $propiedad->texto ?></p>
        <div class="oh">
          <a class="button fl mr10 mb10" target="_blank" href="<?php echo $propiedad->link_ficha ?>">Ver ficha en PDF</a>

          <div class="share-block">
            <ul>
              <li><a class="fb" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()) ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
              <li><a class="twitter" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(html_entity_decode($propiedad->nombre,ENT_QUOTES)) ?>&amp;url=<?php echo urlencode(current_url()) ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
              <li><a class="google" href="https://plus.google.com/share?url=<?php echo current_url() ?>" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
              <li><a class="mail" href="mailto:?subject=<?php echo html_entity_decode($propiedad->nombre,ENT_QUOTES) ?>&body=<?php echo(current_url()) ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
              <li><a class="whatsapp" href="whatsapp://send?text=<?php echo urlencode(current_url()) ?>"><i class="fa fa-whatsapp"></i></a></li>
            </ul>
          </div>

        </div>
      </div><!-- end description -->

      <?php if (!empty($propiedad->video)) { ?>
        <div class="widget property-single-item property-video">
          <h4>
            <span>Video</span><hr class="divisorline">
            <div class="divider-fade"></div>
          </h4>
          <?php echo $propiedad->video ?>
        </div>
      <?php } ?>

      <?php $array = explode (";;;",$propiedad->caracteristicas) ?>
        <div class="widget property-single-item property-amenities">
          <h4>
            <span>Características</span><hr class="divisorline">
            <div class="divider-fade"></div>
          </h4>
          <ul class="amenities-list">
            <?phP if (!empty($propiedad->caracteristicas)) {  ?>
              <?php foreach($array as $a) { ?>
                <li><i class="fa fa-check icon"></i><?php echo $a ?></li>
              <?php } ?>
            <?php } ?>
            <?php if ($propiedad->id_tipo_inmueble != 5 && $propiedad->id_tipo_inmueble != 6 && $propiedad->id_tipo_inmueble != 7 && $propiedad->id_tipo_inmueble != 13 && $propiedad->id_tipo_inmueble != 9 && $propiedad->id_tipo_inmueble != 10) { ?>

              <?php if (!empty($propiedad->ambientes)) { ?>
                <li>
                  <i class="fa fa-home"></i><?php echo $propiedad->ambientes ?> Ambientes
                </li>
              <?php } ?>

              <li>
                <i class="fa fa-bed"></i><?php echo (!empty($propiedad->dormitorios)) ? $propiedad->dormitorios : "-" ?> Dormitorios
              </li>
              <?php if (!empty($propiedad->banios)) {  ?>
                <li>
                  <i class="fa fa-bath"></i><?php echo (!empty($propiedad->banios)) ? (($propiedad->banios == 1)?"1 Baño":$propiedad->banios." Baños") : "-" ?>
                </li>
              <?php } ?>
              <li>
                <i class="fa fa-car"></i><?php echo (!empty($propiedad->cocheras)) ? (($propiedad->cocheras == 1)?"Cochera":$propiedad->cocheras." Cocheras") : "Sin cochera" ?>
              </li>
            <?php } ?>

            <?php if ($propiedad->servicios_cloacas == 1) { ?>
              <li>
                <i class="fa fa-bath"></i>Cloacas
              </li>
            <?php } ?>
            <?php if ($propiedad->servicios_agua_corriente == 1) { ?>
              <li>
                <i class="fa fa-tint"></i>Agua Corriente
              </li>
            <?php } ?>
            <?php if ($propiedad->servicios_electricidad == 1) { ?>
              <li>
                <i class="fa fa-bolt"></i>Electricidad
              </li>
            <?php } ?>
            <?php if ($propiedad->servicios_asfalto == 1) { ?>
              <li>
                <i class="fa fa-truck"></i>Asfalto
              </li>
            <?php } ?>
            <?php if ($propiedad->servicios_gas == 1) { ?>
              <li>
                <i class="fa fa-fire"></i>Gas Natural
              </li>
            <?php } ?>
            <?php if ($propiedad->servicios_telefono == 1) { ?>
              <li>
                <i class="fa fa-phone"></i>Teléfono
              </li>
            <?php } ?>
            <?php if ($propiedad->servicios_cable == 1) { ?>
              <li>
                <i class="fa fa-television"></i>TV Cable
              </li>
            <?php } ?>
            <?php if ($propiedad->servicios_aire_acondicionado == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Aire Acondicionado
              </li>
            <?php } ?>
            <?php if ($propiedad->servicios_uso_comercial == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Uso Comercial
              </li>
            <?php } ?>
            <?php if ($propiedad->servicios_internet == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Internet
              </li>
            <?php } ?>
            <?php if ($propiedad->gimnasio == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Gimnasio
              </li>
            <?php } ?>
            <?php if ($propiedad->parrilla == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Parrilla
              </li>
            <?php } ?>
            <?php if ($propiedad->piscina == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Piscina
              </li>
            <?php } ?>
            <?php if ($propiedad->vigilancia == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Vigilancia
              </li>
            <?php } ?>
            <?php if ($propiedad->sala_juegos == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Sala de Juegos
              </li>
            <?php } ?>
            <?php if ($propiedad->ascensor == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Ascensor
              </li>
            <?php } ?>
            <?php if ($propiedad->lavadero == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Lavadero
              </li>
            <?php } ?>
            <?php if ($propiedad->living_comedor == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Living Comedor
              </li>
            <?php } ?>
            <?php if ($propiedad->terraza == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Terraza
              </li>
            <?php } ?>
            <?php if ($propiedad->accesible == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Accesible
              </li>
            <?php } ?>
            <?php if ($propiedad->balcon == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Balcon
              </li>
            <?php } ?>
            <?php if ($propiedad->patio == 1) { ?>
              <li>
                <i class="fa fa-check"></i>Patio
              </li>
            <?php } ?>
            <?php if ($propiedad->apto_banco == 1) {  ?>
              <li>
                <i class="fa fa-bank"></i>Apto crédito bancario
              </li>
            <?php } ?>

            <?php if ($propiedad->acepta_permuta == 1) {  ?>
              <li>
                <i class="fa fa-exchange"></i>Posibilidad de permuta
              </li>
            <?php } ?>
            <?php if (!empty($propiedad->superficie_cubierta)) { ?>
              <li>
                <i class="fa fa-star-o"></i><?php echo "Sup. Cubierta: ".$propiedad->superficie_cubierta." mts<sup>2</sup>"; ?>
              </li>
            <?php } ?>
            <?php if (!empty($propiedad->superficie_semicubierta)) { ?>
              <li>
                <i class="fa fa-star-half-empty"></i><?php echo "Sup. Semicubierta: ".$propiedad->superficie_semicubierta." mts<sup>2</sup>"; ?>
              </li>
            <?php } ?>
            <?php if (!empty($propiedad->superficie_descubierta)) { ?>
              <li>
                <i class="fa fa-star"></i><?php echo "Sup. Descubierta: ".$propiedad->superficie_descubierta." mts<sup>2</sup>"; ?>
              </li>
            <?php } ?>
            <?php if (!empty($propiedad->superficie_total)) { ?>
              <li>
                <i class="fa fa-star"></i><?php echo "Sup. Total: ".$propiedad->superficie_total." mts<sup>2</sup>"; ?>
              </li>
            <?php } ?>
            <?php if ($propiedad->mts_frente != 0) { ?>
              <li>
                <i class="fa fa-arrows-h"></i>
                Frente: <?php echo str_replace(".00", "", $propiedad->mts_frente) ?> Mts.
              </li>
            <?php } ?>
            <?php if ($propiedad->mts_fondo != 0) { ?>
              <li>
                <i class="fa fa-arrows-v"></i>
                Fondo: <?php echo str_replace(".00", "", $propiedad->mts_fondo) ?> Mts.
              </li>
            <?php } ?>
          </ul>
        </div><!-- end amenities -->
    <?php if ($propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
      <div class="widget property-single-item property-location">
        <h4>
          <span>Ubicación</span><hr class="divisorline">
          <div class="divider-fade"></div>
        </h4>
        <div style="height: 350px" id="mapid"></div>
      </div><!-- end location -->
    <?php }?>
      <!-- end agent -->

      <div class="widget property-single-item property-location comment-form">
        <h4><span>Consultar por propiedad</span></h4><hr class="divisorline">
        <?php include("includes/form_contacto.php"); ?>
      </div>
    </div><!-- end col -->
    
    <div class="col-lg-4 col-md-4 sidebar">
      <?php include "includes/sidebar.php" ?>

      <?php if (sizeof($propiedad->relacionados)>0) { ?>
        <div class="widget widget-sidebar sidebar-properties">
          <div class="widget-content box">          
            <h4 class="mb0"><span class="mb0">Propiedades Relacionadas</span></h4><hr class="divisorline">
            <div class="propiedades_relacionadas owl-carousel">
              <?php foreach ($propiedad->relacionados as $d) {  ?> 
                <div class="item">
                  <div class="property">
                    <a href="<?php echo $d->link_propiedad ?>" class="property-img">
                      <div class="img-fade"></div>
                      <div class="property-tag button alt featured"><?php echo $d->tipo_operacion ?></div>
                      <div class="property-tag button alt featured left"><?php echo $d->tipo_estado ?></div>  
                      <div class="property-tag button status"><?php echo $d->tipo_inmueble ?></div>
                      <div class="property-price"><?php echo $d->precio ?></div>
                      <div class="property-color-bar"></div>
                      <div>
                        <img src="<?php echo $d->imagen ?>" class="mi-img-responsive" />
                      </div>
                    </a>
                    <a href="<?php echo $d->link_propiedad ?>" class="property-content">
                      <div class="property-title">
                        <h4><?php echo ucwords(strtolower($d->nombre)) ?></h4>
                        <p class="property-address"><i class="fa fa-map-marker icon"></i><?php echo $d->direccion_completa.". ".$d->localidad?></p>
                      </div>
                      <table class="property-details">
                        <tr>
                          <td><i class="fa fa-bed"></i> <?php echo (empty($d->dormitorios)) ? "-" : $d->dormitorios?> Dorm</td>
                          <td><i class="fa fa-shower"></i> <?php echo (empty($d->banios)) ? "-" : $d->banios ?> Baño<?php echo ($d->banios > 1)?"s":""?></td>
                          <td><i class="fa fa-expand"></i> <?php echo (empty($d->superficie_total)) ? "-" : $d->superficie_total ?> m<sup>2</sup></td>
                        </tr>
                      </table>
                    </a>
                  </div>
                </div>
              <?php } ?>
            </div>   
          </div>     
        </div>
      <?php } ?>

    </div>
    
  </div><!-- end row -->

  </div><!-- end container -->
</section>

<?php include "includes/footer.php" ?>
<?php include "includes/scripts.php" ?>
<script type="text/javascript">

<?php if (sizeof($propiedad->relacionados)>0) { ?>
$(document).ready(function(){
  $('.propiedades_relacionadas').owlCarousel({
    items: 1,
    autoplay: true,
    dots: false,
  });  
});
<?php } ?>
</script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript" src="js/jquery.fancybox.min.js"></script>

<?php if ($propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
<script type="text/javascript">

   var mymap = L.map('mapid').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
    }).addTo(mymap);


    var icono = L.icon({
     iconUrl: 'images/pin.png',
  iconSize:     [46, 64], // size of the icon
  shadowSize:   [46, 64], // size of the shadow
  iconAnchor:   [46, 32], // point of the icon which will correspond to marker's location
    });
  L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], {icon: icono}).addTo(mymap);

   
</script>
<?php } ?>
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
  var tipo_propiedad = $("#tipo_propiedad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>

<?php 
/*
// Creamos el codigo de seguimiento para registrar la visita
echo $propiedad_model->tracking_code(array(
  "id_propiedad"=>$propiedad->id,
  "id_empresa_compartida"=>$id_empresa,
  "id_empresa"=>$empresa->id,
));
*/
?>
</body>
</html>