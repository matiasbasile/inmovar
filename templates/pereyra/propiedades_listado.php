<?php 
include("includes/init.php");
$get_params["offset"] = 6;
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
    <h1>Comprar Propiedades</h1>
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
        <select class="form-control precios-select">
          <option data-max="0" data-min="0">Precios</option>
          <option <?php echo ($vc_maximo == "25000" && $vc_minimo == "0")?"selected":"" ?> data-max="25000" data-min="0">Hasta 25.000</option>
          <option <?php echo ($vc_maximo == "50000" && $vc_minimo == "25000")?"selected":"" ?> data-max="50000" data-min="25000">25.000 a 50.000</option>
          <option <?php echo ($vc_maximo == "75000" && $vc_minimo == "50000")?"selected":"" ?> data-max="75000" data-min="50000">50.000 a 75.000</option>
          <option <?php echo ($vc_maximo == "100000" && $vc_minimo == "75000")?"selected":"" ?> data-max="100000" data-min="75000">75.000 a 100.000</option>
          <option <?php echo ($vc_maximo == "150000" && $vc_minimo == "100000")?"selected":"" ?> data-max="150000" data-min="100000">100.000 a 150.000</option>
          <option <?php echo ($vc_maximo == "" && $vc_minimo == "150000")?"selected":"" ?> data-max="" data-min="150000">Más de 150.000</option>
        </select>
      </div>
      <a href="<?php echo mklink ("propiedades/$vc_link_tipo_operacion/") ?>" class="btn btn-red">Limpiar Filtros</a>
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
    <div class="row">
      <?php foreach($vc_listado as $p) {  ?>
        <div class="col-xl-4 col-md-6">
          <div class="list-item">
            <div class="img-block"><a href="<?php echo ($p->link_propiedad) ?>">
              <img src="/admin/<?php echo $p->path ?>" alt="Property Img"></a>
            </div>
            <div class="overlay-block">
              <div class="top-item">
                <div class="tag <?php echo ($p->id_tipo_operacion == 4)?"dark-blue":($p->id_tipo_operacion ==2)?"light-blue":"" ?>">
                  <?php echo ($p->id_tipo_operacion == 1)?"En Venta":"" ?>
                  <?php echo ($p->id_tipo_operacion == 2)?"En Alquiler":"" ?>
                  <?php echo ($p->id_tipo_operacion == 4)?"Emprendimientos":"" ?>
                </div>
                <big><?php echo ($p->precio == 0 )?"Consultar":$p->precio ?></big>
              </div>
              <div class="bottom-item">
                <h3><?php echo $p->nombre ?></h3>
                <span><?php echo $p->direccion_completa ?></span>
                <ul>
                  <li>Habitaciones: <small><?php echo ($p->dormitorios != "0")?$p->dormitorios:"-" ?></small></li>
                  <li>Baños: <small><?php echo ($p->banios != "0")?$p->banios:"-" ?></small></li>
                  <li>Metros: <small><?php echo ($p->superficie_total != "0")?$p->superficie_total:"-" ?></small></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>


      <?php if ($vc_total_paginas > 1) {  ?>
        <div class="col-md-12 text-center mt-5">
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <?php if ($vc_page > 0) { ?>
                <li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"><i class="fa fa-chevron-left"></i></a></li>
              <?php } ?>
              <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
                <?php if (abs($vc_page-$i)<2) { ?>
                  <?php if ($i == $vc_page) { ?>
                    <li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $i+1 ?></a></li>
                  <?php } else { ?>
                    <li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.$i."/".$vc_params ) ?>"><?php echo $i+1 ?></a></li>
                  <?php } ?>
                <?php } ?>
              <?php } ?>
              <?php if ($vc_page < $vc_total_paginas-1) { ?>
                <li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params ) ?>"><i class="fa fa-chevron-right"></i></a></li>
              <?php } ?>
            </ul>
          </nav>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

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
  $('.precios-select').change(function(){
    var min = $(this).find(':selected').data('min');
    var max = $(this).find(':selected').data('max');
    $('#vc_minimo').val(min);
    $('#vc_maximo').val(max);
    enviar_buscador_propiedades()
  });
 
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
</script>
<script type="text/javascript">
if (jQuery(window).width()>767) { 
  $(document).ready(function(){
    var maximo = 0;
    $(".bottom-item").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".bottom-item").height(maximo);
  });
}
</script>
</body>
</html>