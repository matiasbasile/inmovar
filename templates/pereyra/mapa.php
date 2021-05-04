<?php 
include("includes/init.php");
$get_params["offset"] = 99999999;
if (!empty($get_params["orden"])) { 
$vc_orden = $get_params["orden"] ;} else { 
$vc_orden ="";}
$vc_link_tipo_operacion = "todas";
extract($propiedad_model->get_variables());
$page_act = $vc_link_tipo_operacion;
$localidades = $propiedad_model->get_localidades();
foreach($localidades as $l) { 
 if ($l->link == $vc_link_localidad) { 
  $vc_nombre_localidad = $l->nombre;
  $vc_link_localidad = $l->link;
 }
}
$tipos_propiedades = $propiedad_model->get_tipos_propiedades();
foreach($tipos_propiedades as $l) { 
 if ($l->id == $vc_id_tipo_inmueble) { 
  $vc_nombre_tipo_propiedad = $l->nombre;
 }
}
$vc_banios = isset($get_params["bn"]) ? $get_params["bn"] : 0;
$vc_dormitorios= isset($get_params["dm"]) ? $get_params["dm"] : 0;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>

<!-- Header -->
<?php include "includes/header.php" ?>


<!-- Page Title -->
<section class="page-title">
  <div class="container">
    <h1> <?php echo ($vc_link_tipo_operacion == "alquileres")?"Alquilar Propiedades":"" ?>
          <?php echo ($vc_link_tipo_operacion == "ventas")?"Comprar Propiedades":"" ?>
          <?php echo ($vc_link_tipo_operacion == "emprendimientos")?"Emprendimientos":"" ?></h1>
  </div>
</section>
<!-- Filter Box -->
<section class="filter-box">
  <div class="container">
    <form id="form_propiedades">
      <input type="hidden" id="vc_minimo" value="<?php echo (!empty($vc_minimo))?"$vc_minimo":"" ?>" name="vc_minimo">
      <input type="hidden" id="vc_maximo" value="<?php echo (!empty($vc_maximo))?"$vc_maximo":"" ?>" name="vc_maximo">
      <input type="hidden" id="tipo_operacion" value="<?php echo (!empty($vc_link_tipo_operacion))?$vc_link_tipo_operacion:"todas" ?>" name="">
      <div class="selectbox">
        <select class="form-control" onchange="enviar_buscador_propiedades()" ID="localidad"> 
          <option value="todas">Localidades</option>
          <?php foreach ($localidades as $l) {  ?>
            <option value="<?php echo $l->link  ?>" <?php echo ($l->link == $vc_link_localidad)?"selected":"" ?> ><?php echo $l->nombre ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="selectbox">
        <select class="form-control" onchange="enviar_buscador_propiedades()" name="tp">
          <option value="todas">Tipo de Propiedad</option>
          <?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades()?>
          <?php foreach ($tipos_propiedades as $l) {  ?>
            <option value="<?php echo $l->id ?>" <?php echo ($l->id == $vc_id_tipo_inmueble)?"selected":"" ?> ><?php echo $l->nombre ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="selectbox">
        <select onchange="enviar_buscador_propiedades()" name="dm" class="form-control">
          <option value="">Dormitorios</option> 
          <?php $dormitorios = $propiedad_model->get_dormitorios()?>
          <?php foreach ($dormitorios as $l) { 
            if ($l->dormitorios != 0) {   ?>
            <option value="<?php echo $l->dormitorios?>" <?php echo ($vc_dormitorios == $l->dormitorios)?"selected":""?> ><?php echo $l->dormitorios  ?></option>
            <?php } ?>
          <?php } ?>
        </select>
      </div>
      <div class="selectbox smallbox">
        <select class="form-control" name="bn" onchange="enviar_buscador_propiedades()">
          <option value="">Baños</option>
          <?php $banios = $propiedad_model->get_banios()?>
          <?php foreach ($banios as $l) {
            if ($l->banios != 0 && $l->banios < 5) {   ?>
            <option value="<?php echo $l->banios?>"<?php echo ($vc_banios == $l->banios)?"selected":""?> ><?php echo $l->banios  ?></option>
            <?php } ?>
          <?php } ?>
        </select>
      </div>
      <div class="selectbox smallbox">
        <!-- <select class="form-control">
          <option>Precios</option>
            <option <?php echo ($vc_maximo == "25000" && $vc_minimo == "0")?"selected":"" ?> onchange="change_price('0','25000')">Hasta 25.000</option>
            <option <?php echo ($vc_maximo == "50000" && $vc_minimo == "25000")?"selected":"" ?> onchange="change_price('25000','50000')">25.000 a 50.000</option>
            <option <?php echo ($vc_maximo == "75000" && $vc_minimo == "50000")?"selected":"" ?> onchange="change_price('50000','75000')">50.000 a 75.000</option>
            <option <?php echo ($vc_maximo == "100000" && $vc_minimo == "75000")?"selected":"" ?> onchange="change_price('75000','100000')">75.000 a 100.000</option>
            <option <?php echo ($vc_maximo == "150000" && $vc_minimo == "100000")?"selected":"" ?> onchange="change_price('100000','150000')">100.000 a 150.000</option>
            <option <?php echo ($vc_maximo == "" && $vc_minimo == "150000")?"selected":"" ?> onchange="change_price('150000','')">Más de 150.000</option>
        </select> -->
      </div>
      <a href="<?php echo mklink ("mapa/$vc_link_tipo_operacion/") ?>" class="btn btn-red">Limpiar Filtros</a>
    </form>
  </div>
</section>

<!-- Recently Added -->
<section class="featured-properties recently-added pt-5">
  <div class="container">
    <div class="section-title">
      <div class="float-left">
        <h2>
          <?php echo ($vc_link_tipo_operacion == "alquileres")?"PROPIEDADES EN ALQUILER":"" ?>
          <?php echo ($vc_link_tipo_operacion == "ventas")?"PROPIEDADES EN VENTA":"" ?>
          <?php echo ($vc_link_tipo_operacion == "emprendimientos")?"EMPRENDIMIENTOS":"" ?>
        </h2>
        <?php if ($vc_total_resultados > 0) {  ?>
          <span>Se encontraron <?php echo $vc_total_resultados ?> propiedades</span>
        <?php } else { ?>
          <span>No se encontraron resultados.</span>
        <?php }?>
      </div>
      <div class="float-right">
        <span>ordenar por:</span>
        <form id="orden_form">
          <select class="form-control" onchange="enviar_orden()" name="orden"> 
            <option <?php echo ($vc_orden == -1 ) ? "selected" : "" ?> value="nuevo">Más nuevos</option>
            <option <?php echo ($vc_orden == 2 ) ? "selected" : "" ?> value="barato">Precio menor a mayor</option>
            <option <?php echo ($vc_orden == 1 ) ? "selected" : "" ?> value="caro">Precio mayor a menor</option>
            <option <?php echo ($vc_orden == 4 ) ? "selected" : "" ?> value="destacados">Destacados</option>
          </select>  
        </form>
        <a href="<?php echo mklink ("mapa/$vc_link_tipo_operacion/") ?>" class="btn"><img src="assets/images/map-white.png" alt="Map Icon"> Vista Mapa</a>
      </div>
    </div>
  </div>
</section>
<?php if ($vc_total_resultados > 0) {  ?>

<div id="map" style="min-height: 460px"></div>
<?php } ?>

<!-- Footer -->
<?php include "includes/footer.php" ?>


<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/html5.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="assets/js/scripts.js"></script>

<script type="text/javascript">
  function change_price (min,max) { 
    $('#vc_minimo').val(min);
    $('#vc_maximo').val(max);
    enviar_buscador_propiedades()
  }
  function enviar_orden() { 
    $("#orden_form").submit();
  }
  function enviar_buscador_propiedades() { 
    var link = "<?php echo mklink("mapa/")?>";
    var tipo_operacion = $("#tipo_operacion").val();
    var localidad = $("#localidad").val();
    link = link + tipo_operacion + "/" + localidad + "/";
    $("#form_propiedades").attr("action",link);
    $("#form_propiedades").submit();
    return true;
  }
</script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){

  var mymap = L.map('map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 15);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
    }).addTo(mymap);


  var icono = L.icon({
    iconUrl: 'assets/images/map-logo.png',
    iconSize:     [34, 49], // size of the icon
    iconAnchor:   [17, 49], // point of the icon which will correspond to marker's location
  });

    mymap.fitBounds([
    <?php foreach($vc_listado as $p) {
      if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) {  ?>
        [<?php echo $p->latitud ?>,<?php echo $p->longitud ?>],
      <?php } ?>
    <?php } ?>
  ]);

  <?php $i=0;
  foreach($vc_listado as $p) {
    if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) { 
      $path = "images/no-imagen.png";
      if (!empty($p->imagen)) { 
        $path = $p->imagen;
      } else if (!empty($empresa->no_imagen)) {
        $path = "/admin/".$empresa->no_imagen;
      } ?>
      var contentString<?php echo $i; ?> = '<div id="content">'+
        '<div class="feature-item" style="padding: 0px;">'+
          '<div class="feature-image">'+
            '<a href=\"<?php echo mklink($p->link) ?>\">'+
              '<img style="max-width:100%" src=\"<?php echo $path ?>\"/>'+
            '</a>'+
          '</div>'+
          '<div class="tab_list_box_content">'+
            '<h6><a href=\"<?php echo mklink($p->link) ?>\"><?php echo ($p->nombre) ?></a></h6>'+
            '<p>'+
              '<img src="images/locate_icon.png" alt="locate_icon">'+
              '<?php echo $p->direccion_completa ?>'+
              '<br><span class="color_span"><?php echo $p->localidad ?></span>'+
            '</p>'+
            '<h6 class="price_dollar"><?php echo $p->precio ?></h6>'+
          '</div>'+
        '</div>'+
      '</div>';
    
      var marker<?php echo $i; ?> = L.marker([<?php echo $p->latitud ?>,<?php echo $p->longitud ?>],{
        icon: icono
      });
      marker<?php echo $i; ?>.addTo(mymap);

      marker<?php echo $i; ?>.bindPopup(contentString<?php echo $i; ?>);

    <?php } ?>
  <?php $i++; } ?>

   

});
</script>
</body>
</html>