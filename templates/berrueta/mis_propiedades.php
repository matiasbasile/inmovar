<?php
if (!isset($_SESSION["id_propietario"]) || empty($_SESSION["id_propietario"])) {
  header("Location: ".mklink("/"));
}
include_once("includes/funciones.php");
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
$productos = $propiedad_model->mis_propiedades(
  $_SESSION["id_propietario"],
  array(
    "activo"=>-1 // Se manda null para que no tome el valor del parametro
  )
);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>

<!-- TOP WRAPPER -->
<div class="top-wrapper">
  <?php include("includes/header.php"); ?>
  <div class="page-title">
    <div class="page">
      <div class="breadcrumb"><a href="<?php echo mklink("/") ?>"><img src="images/home-icon3.png" alt="Home" /> Home</a>
      <span>Mis Propiedades</span></div>
      <big>Mis Propiedades</big>
    </div>
  </div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
  <div class="page">
    <div class="row">
      <div class="registered-user">
        <?php include("includes/sidebar_propietario.php"); ?>
        <div class="col-md-9 primary">
          <div class="border-box">
            <div class="info-title">mis Propiedades</div>
            <div class="box-space">
              <div class="list-view">
                <?php if (sizeof($productos)>0) { ?>
                  <?php foreach($productos as $r) { ?>
                    <div class="property-item <?php echo ($r->id_tipo_estado==1)?"sold":"" ?>">
                      <?php if (!empty($r->path)) { ?>
                        <div class="item-picture">
                          <div class="block"><img src="/admin/<?php echo $r->path ?>" alt="<?php echo ($r->calle." ".$r->altura." ".$r->piso." ".$r->numero); ?>" /></div>
                          <div class="view-more"><a href="<?php echo mklink($r->link)?>"></a></div>
                          <div class="property-status">
                            <span>vendido</span>
                          </div>
                        </div>
                      <?php } ?>
                      <div class="property-detail">
                        <div class="property-name"><?php echo ($r->calle." ".$r->altura." ".$r->piso." ".$r->numero); ?></div>
                        <div class="property-location">
                          <div class="pull-left"><?php echo ($r->localidad); ?></div>
                          <?php if (!empty($r->codigo)) { ?>
                            <div class="pull-right">Cod: <span><?php echo ($r->codigo); ?></span></div>
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
                        <p><?php echo (strlen($r->descripcion)>50) ? substr($r->descripcion,0,50)."..." : $r->descripcion ?></p>
                        <div class="property-price">
                          <big><?php echo ($r->publica_precio) ? $r->moneda." ".number_format($r->precio_final,2) : "A consultar"; ?></big>
                          <?php if (estaEnFavoritos($r->id)) { ?>
                            <a href="/admin/favoritos/eliminar/?id=<?php echo $r->id; ?>" class="favorites-properties active"><span class="tooltip">Borrar de Favoritos</span></a>
                          <?php } else { ?>
                            <a href="/admin/favoritos/agregar/?id=<?php echo $r->id; ?>" class="favorites-properties"><span class="tooltip">Guarda Tus Inmuebles Favoritos</span></a>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                <?php } else { ?>
                  No tiene propiedades subidas.
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/consulta_rapida.php"); ?>

<?php include("includes/footer.php"); ?>

<!-- SCRIPT'S --> 
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/map.js"></script> 
<script type="text/javascript" src="js/custom.js"></script> 
<script type="text/javascript">
//MAP SCRIPT
$(document).ready(function(){var b=new google.maps.LatLng(<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>);var c={center:b,zoom:15,mapTypeId:google.maps.MapTypeId.ROADMAP,styles:[{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]},{featureType:"water",elementType:"labels",stylers:[{visibility:"on"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}]};var d=new google.maps.Map(document.getElementById("map"),c);var a=new google.maps.Marker({position:b,map:d,icon:"images/map-place.png"});$(window).resize(function(){var e=d.getCenter();google.maps.event.trigger(d,"resize");d.setCenter(e)})});  
</script>
</body>
</html>
