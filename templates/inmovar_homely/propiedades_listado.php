<?php 
include("includes/init.php");
$get_params["offset"] = 12;
extract($propiedad_model->get_variables());
$page_active = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include "includes/head.php" ?>
  </head>
<body>
<?php include "includes/header.php" ?>

<section class="subheader subheader-listing-sidebar">
  <div class="container">
    <h1><?php echo (!empty($vc_tipo_operacion))?$vc_tipo_operacion : "Propiedades" ?></h1>
    <div class="breadcrumb right"><a href="<?php echo mklink ("/") ?>"> Inicio</a> <i class="fa fa-angle-right"></i>
      <a href="<?php echo (!empty($vc_tipo_operacion)) ? mklink ("propiedades/$vc_link_tipo_operacion/") : mklink ("propiedades/") ?>" class="current"><?php echo (!empty($vc_tipo_operacion))?$vc_tipo_operacion : "Propiedades" ?></a></div>
    <div class="clear"></div>
  </div>
</section>

<section class="module">
  <div class="container">
  
  <div class="row">
    <div class="col-lg-8 col-md-8">
    
      <div class="property-listing-header">
        <?php if (isset($vc_total_resultados)) { ?>
          <span class="property-count left">
            <?php if ($vc_total_resultados == 0) { ?>
              No se encontraron resultados para su búsqueda.
            <?php } else { ?>
              <?php echo $vc_total_resultados ?> resultados.
            <?php } ?>
          </span>
        <?php } ?>
        <form method="get" class="right">
          <select onchange="submit_buscador_propiedades()" id="ordenador_orden" name="orden" class="ht-field listing-sort__field">
            <option value="barato" <?php echo ($vc_orden == 2)?"selected":""  ?> >Precio (Menor a mayor)</option>
            <option value="caro" <?php echo ($vc_orden == 1)?"selected":""  ?> >Precio (Mayor a menor)</option>
            <option value="destacadas" <?php echo ($vc_orden == 4)?"selected":""  ?> >Destacadas</option>
          </select>
        </form>
        <div class="clear"></div>
      </div><!-- end property listing header -->
      
      <div class="row propiedades">
        
      <?php foreach ($vc_listado as $p) {  ?>
        <?php item($p); ?>
      <?php } ?>
        
      </div><!-- end row -->
      <!-- end row -->
    <?php if ($empresa->id != 1555) { ?>
      <?php if ($vc_total_paginas > 1) {  ?>
        

        <div class="pagination">
          <div class="center">
            <ul>
              <?php if ($vc_page > 0) { ?>
                <li><a href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>" class="button small grey"><i class="fa fa-angle-left"></i></a></li>
              <?php } ?>
              <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
                <?php if (abs($vc_page-$i)<3) { ?>
                  <?php if ($i == $vc_page) { ?>
                    <li class="current"><a class="button small grey"><?php echo $i+1 ?></a></li>
                  <?php } else { ?>
                    <li><a href="<?php echo mklink ($vc_link.$i."/".$vc_params ) ?>" class="button small grey"><?php echo $i+1 ?></a></li>
                  <?php } ?>
                <?php } ?>
              <?php } ?>
              <?php if ($vc_page < $vc_total_paginas-1) { ?>
                <li><a href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params ) ?>" class="button small grey"><i class="fa fa-angle-right"></i></a></li>
              <?php } ?>
            </ul>
          </div>
          <div class="clear"></div>
        </div>
      <?php } ?><!-- pagination -->
    <?php } else { ?>
      <div class="d-block mt-5">
        <a onclick="cargar()" id="cargarMas" class="btn btn-primary btn-block btn-lg button alt w100p">Ver más propiedades para tu búsqueda</a>
      </div>
    <?php } ?> 
    
    </div><!-- end listing -->
    <div class="col-lg-4 col-md-4 sidebar">
      <?php include "includes/sidebar.php" ?>
    </div>
    <!-- end sidebar -->
  </div><!-- end row -->
  </div><!-- end container -->
</section>

<!-- JavaScript file links -->
<?php include "includes/footer.php"?>
<?php include "includes/scripts.php"?>
<?php if ($empresa->id == 1555) include("includes/cargar_mas_js.php"); ?>
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
  var tp = $("#tp").val();
  link = link + tipo_operacion + "/" + localidad + "/<?php echo $vc_params?>";
  var minimo = $("#precio_minimo").val().replace(".","");
  $("#precio_minimo_oculto").val(minimo);
  var maximo = $("#precio_maximo").val().replace(".","");
  $("#precio_maximo_oculto").val(maximo);
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>
<script type="text/javascript">
  $(document).ready(function(){
  var maximo = 0;
  $(".property-content").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".property-content").height(maximo);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script>
$(document).ready(function(){
  if ($("#precio_minimo").length > 0) {
    new AutoNumeric('#precio_minimo', { 
      'decimalPlaces':0,
      'decimalCharacter':',',
      'digitGroupSeparator':'.',
    });
  }
  if ($("#precio_maximo").length > 0) {
    new AutoNumeric('#precio_maximo', { 
      'decimalPlaces':0,
      'decimalCharacter':',',
      'digitGroupSeparator':'.',
    });
  }
})
</script>


</body>
</html>