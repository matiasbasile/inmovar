<?php
$nombre_pagina = "favoritos";
include_once("includes/funciones.php");
include_once("includes/init.php");
$favoritos = $propiedad_model->favoritos();
$titulo_pagina = "Favoritos";

$sql = "SELECT IF(MAX(precio_final) IS NULL,0,MAX(precio_final)) AS maximo FROM inm_propiedades WHERE 1=1 ";
$q_maximo = mysqli_query($conx,$sql);
$maximo = mysqli_fetch_object($q_maximo);
$precio_maximo = (ceil($maximo->maximo/100)*100);

// Minimo
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;

// Maximo
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>

<?php include("includes/header.php"); ?>

<!-- MAIN WRAPPER -->
<section class="main-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-9 primary">
        <?php if (sizeof($favoritos)>0) { ?>
          <div class="tabs">
            <div class="tab-content" id="list-view">
              <?php foreach($favoritos as $r) { ?>
                <div class="property-item">
                  <div class="item-picture">
                    <div class="block">
                      <?php if (!empty($r->path)) { ?>
                        <img class="cover" src="/admin/<?php echo $r->path ?>" alt="<?php echo ($r->nombre) ?>" />
                      <?php } else { ?>
                        <img class="cover" src="images/no-image-1.jpg" alt="<?php echo ($r->nombre) ?>" />
                      <?php } ?>
                    </div>
                    <a class="view-more" href="/<?php echo $r->link ?>"><span></span></a>
                    <?php if ($r->id_tipo_estado != 1) { ?>
                      <div class="ribbon red"><?php echo ($r->tipo_estado) ?></div>
                    <?php } else { ?>
                      <div class="ribbon"><?php echo ($r->tipo_operacion) ?></div>
                    <?php } ?>
                  </div>
                  <div class="property-detail">
                    <div class="property-name"><a href="/<?php echo $r->link ?>"><?php echo ($r->nombre); ?></a></div>
                    <div class="property-location">
                      <div class="pull-left"><?php echo ($r->direccion_completa); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo ($r->localidad); ?></div>
                      <?php if (!empty($r->codigo)) { ?>
                        <div class="pull-right">Cod: <span><?php echo $r->codigo ?></span></div>
                      <?php } ?>
                    </div>
                    <?php if($r->dormitorios != 0 || $r->banios != 0 || $r->cocheras != 0 || $r->superficie_total != 0) { ?>
                      <div class="property-facilities">
                        <?php if (!empty($r->dormitorios)) { ?>
                          <div class="facilitie"><img src="images/room-icon.png" alt="Room" /> <?php echo $r->dormitorios ?> Hab</div>
                        <?php } ?>
                        <?php if (!empty($r->banios)) { ?>
                          <div class="facilitie"><img src="images/shower-icon3.png" alt="Shower" /> <?php echo $r->banios ?> Ba&ntilde;os</div>
                        <?php } ?>
                        <?php if (!empty($r->cocheras)) { ?>
                          <div class="facilitie"><img src="images/garage-icon.png" alt="Garage" /> <?php echo $r->cocheras ?> Cochera</div>
                        <?php } ?>
                        <?php if (!empty($r->superficie_total)) { ?>
                          <div class="facilitie"><img src="images/grid-icon.png" alt="Grid" /> <?php echo $r->superficie_total ?> m<sup>2</sup></div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                    <?php if (!empty($r->descripcion)) { ?>
                      <p class="property-description"><?php echo ((strlen($r->descripcion)>100) ? substr($r->descripcion,0,100)."..." : $r->descripcion); ?></p>
                    <?php } else {
                      $texto = strip_tags(html_entity_decode($r->texto,ENT_QUOTES)); ?>
                      <p class="property-description"><?php echo ((strlen($texto)>100) ? substr($texto,0,100)."..." : $texto); ?></p>                        
                    <?php } ?>
                    <div class="property-price">
                      <big>
                        <?php if (!empty($r->precio_final)) { ?>
                          <?php echo $r->moneda ?> <?php echo number_format($r->precio_final) ?>
                        <?php } else { ?>
                          Consultar
                        <?php } ?>
                      </big>
                      <?php if (estaEnFavoritos($r->id)) { ?>
                        <a href="/admin/favoritos/eliminar/?id=<?php echo $r->id; ?>" class="favorites-properties active"><span class="tooltip">Borrar de Favoritos</span></a>
                      <?php } else { ?>
                        <a href="/admin/favoritos/agregar/?id=<?php echo $r->id; ?>" class="favorites-properties"><span class="tooltip">Guarda Tus Inmuebles Favoritos</span></a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        <?php } else { ?>
          No tienes favoritos guardados.
        <?php } ?>
      </div>
      <div class="col-md-3 secondary">
        <?php include("includes/filter.php"); ?>
      </div>      
    </div>
  </div>
</section>

<?php include("includes/footer.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
  // Alquileres y ventas
  var maximo = 0;
  $(".grid-view .property-detail").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".grid-view .property-detail").height(maximo);
  
  // Emprendimientos
  var maximo = 0;
  $(".for-enterprises .info-inner").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".for-enterprises .info-inner").height(maximo);
  
  var maximo = 0;
  $(".item-picture .block img").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".item-picture .block img").height(maximo);
  
  // Obras
  var maximo = 0;
  $(".work-list .item-picture img").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".work-list .item-picture img").height(maximo);
  
});
</script>
<script type="text/javascript" src="js/nouislider.js"></script>
<script type="text/javascript">
//SLIDER SNAP SCRIPT
$('.slider-snap').noUiSlider({
	start: [ <?php echo $minimo ?>, <?php echo $maximo ?> ],
	step: 10,
	connect: true,
	range: {
		'min': 0,
		'max': <?php echo $precio_maximo ?>,
	}
});
$('.slider-snap').Link('lower').to($('.slider-snap-value-lower'));
$('.slider-snap').Link('upper').to($('.slider-snap-value-upper'));  
</script>
</body>
</html>