<?php 
include("includes/init.php");
$get_params["offset"] = 12;
extract($propiedad_model->get_variables());
$page_active = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html lang="en">
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
          </select>
        </form>
        <div class="clear"></div>
      </div><!-- end property listing header -->
      
      <div class="row">
        
      <?php foreach ($vc_listado as $p) {  ?>
        <div class="col-lg-6 col-md-6">
            <div class="property shadow-hover">
              <a href="<?php echo $p->link_propiedad ?>" class="property-img">
                <div class="img-fade"></div>
                <div class="property-tag button alt featured"><?php echo $p->tipo_operacion?></div>
                <div class="property-tag button alt featured left"><?php echo $p->tipo_estado ?></div>  
                <div class="property-tag button status"><?php echo $p->tipo_inmueble ?></div>
                <div class="property-price"><?php echo $p->precio ?></div>
                <div class="property-color-bar"></div>
                <div class="">
                  <?php if (!empty($p->imagen)) { ?>
                    <img src="<?php echo $p->imagen ?>" class="mi-img-responsive" alt="<?php echo ($p->nombre); ?>" />
                  <?php } else if (!empty($empresa->no_imagen)) { ?>
                    <img src="/admin/<?php echo $empresa->no_imagen ?>" class="mi-img-responsive" alt="<?php echo ($p->nombre); ?>" />
                  <?php } else { ?>
                    <img src="images/logo.png" alt="<?php echo ($p->nombre); ?>" />
                  <?php } ?>
                </div>
              </a>
              <div class="property-content">
                <div class="property-title">
                <h4><a href="<?php echo $p->link_propiedad ?>"><?php echo ucwords(strtolower($p->nombre)) ?></a></h4>
                  <p class="property-address"><i class="fa fa-map-marker icon"></i><?php echo $p->direccion_completa.". ".$p->localidad ?> <br> Código: <?php echo $p->codigo ?></p>
                </div>
                <table class="property-details">
                  <tr>
                    <td><i class="fa fa-bed"></i> <?php echo empty($p->dormitorios) ? "-" : $p->dormitorios?> Dorm</td>
                    <td><i class="fa fa-shower"></i> <?php echo (empty($p->banios)) ? "-" : $p->banios ?> Baño<?php echo ($p->banios > 1)?"s":""?></td>
                    <td><i class="fa fa-expand"></i> <?php echo (empty($p->superficie_total)) ? "-" : $p->superficie_total ?> m<sup>2</sup></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        <?php } ?>
        
      </div><!-- end row -->
      <!-- end row -->
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