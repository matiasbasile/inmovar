<?php include "includes/init.php";
$propiedad = $propiedad_model->get($id);
extract($propiedad_model->get_variables());
$page_active = $propiedad->tipo_operacion_link;

$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id,array(
"id_empresa"=>$id_empresa,
"id_empresa_original"=>$empresa->id,
"buscar_total_visitas"=>1,
"buscar_relacionados"=>1,
"buscar_relacionados_offset"=>6,
));
if ($propiedad === FALSE || !isset($propiedad->nombre)) header("Location:404.php");
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
$seo_title = (!empty($propiedad->seo_title)) ? $propiedad->seo_title : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? $propiedad->seo_description : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? $propiedad->seo_keywords : $empresa->seo_keywords;

$cookie_id_cliente = (isset($_COOKIE['idc'])) ? $_COOKIE['idc'] : 0;
$cookie_hide_lightbox = (isset($_COOKIE['hide_lightbox'])) ? $_COOKIE['hide_lightbox'] : 0;

if (!isset($_COOKIE[$propiedad->id])) {
// Sumamos la visita a la propiedad
$propiedad_model->add_visit($propiedad->id,$cookie_id_cliente);
setcookie($propiedad->id,"1",time()+60*60*24*30,"/");
}
if (!empty($propiedad->imagen)) $propiedad->images = array_merge(array($propiedad->imagen),$propiedad->images);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include "includes/head.php" ?>
<script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
</head>
<body>
<?php include "includes/header.php" ?>

<section class="subheader">
  <div class="container">
    <h1><?php echo $propiedad->tipo_operacion ?></h1>
    <div class="breadcrumb right"><a href="<?php echo mklink ("/") ?>">Inicio</a> <i class="fa fa-angle-right"></i> <a href="<?php echo mklink ("propiedades/$propiedad->tipo_operacion_link/")?>"><?php echo$propiedad->tipo_operacion ?></a> <i class="fa fa-angle-right"></i> <a class="current"><?php echo $propiedad->nombre ?></a></div>
    <div class="clear"></div>
  </div>
</section>
<section class="module">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8">
        <div class="property-single-item property-main">
          <div class="property-header">
            <div class="property-title">
              <h4><?php echo $propiedad->nombre ?></h4>
              <div class="property-price-single right">
                <?php echo $propiedad->precio ?>
                <!-- <span>Per Month</span> -->
              </div>
              <p class="property-address">Código: <?php echo $propiedad->codigo ?><br><i class="fa fa-map-marker icon"></i><?php echo $propiedad->direccion_completa." - ".$propiedad->localidad?></p>
              <div class="clear"></div>
            </div>
            <div class="property-single-tags">
              <?php if ($propiedad->destacado == "1") {  ?><div class="property-tag button alt featured">Destacado</div><?php }  ?>
              <div class="property-tag button status">
                <?php echo ($propiedad->tipo_operacion_link == "alquileres")?"En alquiler":"" ?>
                <?php echo ($propiedad->tipo_operacion_link == "ventas")?"En venta":"" ?>
                <?php echo ($propiedad->tipo_operacion_link == "alquileres-temporarios")?"Alquileres Temporarios":"" ?>
              </div>
              <div class="property-type right">Tipo de propiedad: <a><?php echo $propiedad->tipo_inmueble ?></a></div>
            </div>
          </div>

          <table class="property-details-single">
            <tr>
              <?php if (!empty($propiedad->banios)) {  ?><td><i class="fa fa-tint"></i> <span><?php echo $propiedad->banios ?></span> Baño<?php echo (sizeof($propiedad->banios) > 1)?"s":"" ?></td><?php } ?>
              <?php if (!empty($propiedad->dormitorios)) {  ?><td><i class="fa fa-bed"></i> <span><?php echo $propiedad->dormitorios?></span> Dorm</td><?php } ?>
              <?php if (!empty($propiedad->superficie_total)) {  ?><td><i class="fa fa-expand"></i> <span><?php echo $propiedad->superficie_total ?></span> Sup Total</td><?php } ?>
              <?php if (!empty($propiedad->cocheras)) {  ?><td><i class="fa fa-car"></i> <span><?php echo $propiedad->cocheras ?></span> Cocheras</td><?php } ?>
            </tr>
          </table>

          <?php if (sizeof($propiedad->images) > 1) {  ?>
            <div class="property-gallery">
              <div class="slider-nav slider-nav-property-gallery">
                <span class="slider-prev"><i class="fa fa-angle-left"></i></span>
                <span class="slider-next"><i class="fa fa-angle-right"></i></span>
              </div>
              <div class="slide-counter"></div>
              <div class="slider slider-property-gallery">
                <?php foreach ($propiedad->images as $img) {  ?>
                  <div class="slide"><img class="detail-img" src="<?php echo $img ?>" alt="" /></div>
                <?php } ?>
              </div>
              <div class="slider property-gallery-pager">
                <?php foreach ($propiedad->images as $img) {  ?>
                  <a class="property-gallery-thumb"><img class="detail-img-thumb" src="<?php echo $img ?>" alt="" /></a>
                <?php } ?>
              </div>
            </div>

          <?php } else {  ?>
            <a class="blog-post-img">
              <div class="img-fade"></div>
              <img src="<?php echo $propiedad->imagen ?>" alt="" />
            </a>
          <?php } ?>

        </div><!-- end property title and gallery -->

        <div class="widget property-single-item property-description content">
          <h4>
            <span>Descripción</span><hr class="divisorline">
            <div class="divider-fade"></div>
          </h4>
          <p><?php echo $propiedad->texto ?></p>
        </div><!-- end description -->



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
        </div>


        <!-- end amenities -->

        <div class="widget property-single-item property-location">
          <h4>
            <span>Ubicación</span><hr class="divisorline">
            <div class="divider-fade"></div>
          </h4>
          <div style="height: 350px" id="mapid"></div>
        </div><!-- end location -->

        <!-- end related properties -->

      </div><!-- end col -->

      <div class="col-lg-4 col-md-4 sidebar">
        <?php include "includes/sidebar.php" ?>
        
      </div><!-- end sidebar -->
  
</div><!-- end row -->

</div><!-- end container -->
</section>

<?php include "includes/footer.php" ?>
<?php include "includes/scripts.php" ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
<!-- <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script> -->
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>


<?php if ($propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
<script type="text/javascript">
  var mymap = L.map('mapid').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: '<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>',
    }).addTo(mymap);

  var greenIcon = L.icon({
    iconUrl: 'images/pin.png',
  iconSize:     [46, 64], // size of the icon
  shadowSize:   [46, 64], // size of the shadow
  iconAnchor:   [46, 32], // point of the icon which will correspond to marker's location
});
  L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], {icon: greenIcon}).addTo(mymap);
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
  link = link + tipo_operacion + "/" + localidad + "/<?php echo $vc_params?>";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>
</body>
</html>