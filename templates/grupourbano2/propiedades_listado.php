<?php
include_once("includes/init.php");
if (!isset($config_grupo)) $config_grupo = array();
$config_grupo["orden_default"] = 8;
$propiedades = extract($propiedad_model->get_variables($config_grupo));
if (isset($get_params["test"])) echo $propiedad_model->get_sql();
$nombre_pagina = $vc_link_tipo_operacion;
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">

<head>
  <?php include("includes/head.php"); ?>
</head>

<body class="bg-gray">

<?php include("includes/header.php"); ?>

<section class="padding-default">
  <div class="container style-two">
    <div class="page-heading">
      <?php if ($vc_tipo_operacion == 1) { ?>
        <h2>Propiedades en Venta</h2>
        <h6>Se encontraron <b><?php echo $vc_total_resultados ?></b> propiedades</h6>
      <?php } else if ($vc_tipo_operacion == 2) { ?>
        <h2>Propiedades en Alquiler</h2>
        <h6>Se encontraron <b><?php echo $vc_total_resultados ?></b> propiedades</h6>
      <?php } else if ($vc_tipo_operacion == 4) { ?>
        <h2>Emprendimientos</h2>
        <h6>Se encontraron <b><?php echo $vc_total_resultados ?></b> emprendimientos</h6>
      <?php } else if ($vc_tipo_operacion == 5) { ?>
        <h2>Obras</h2>
        <h6>Se encontraron <b><?php echo $vc_total_resultados ?></b> obras</h6>
      <?php } else { ?>
        <h2>Propiedades</h2>
        <h6>Se encontraron <b><?php echo $vc_total_resultados ?></b> propiedades</h6>
      <?php } ?>
    </div>

    <?php include("includes/propiedad/buscador.php"); ?>

    <div class="neighborhoods shadow-none style-two">
      <div class="row m-0 my-5 propiedades">
        <?php $cont = 0; ?>
        <?php 
        foreach ($vc_listado as $r) { 
          item($r);
        } ?>
      </div>
    </div>
    <div class="d-block mt-5">
      <a onclick="cargar()" id="cargarMas" class="btn btn-primary btn-block btn-lg">ver más propiedades para tu búsqueda</a>
    </div>
  </div>
</section>

<?php include("includes/footer.php") ?>

<script>
window.enviando = 0;
window.page = 0;
window.marca = true;

function cargar() {
  if (window.enviando == 1) return;
  var search = window.location.search;
  search = search.slice(1);
  search = search.split("&");
  var data = {};
  search.forEach(element => {
    var nuevoArray = element.split("=");
    data[nuevoArray[0]] = nuevoArray[1];
  });

  window.page++;
  window.enviando = 1;
  data['id_empresa'] = ID_EMPRESA;
  data['page'] = window.page;
  data['order'] = "<?php echo $vc_orden ?>";
  data['offset'] = 12;
  data['id_localidad'] = "<?php echo $vc_id_localidad ?>";
  data['tipo_operacion'] = "<?php echo $vc_link_tipo_operacion ?>";
  $("#cargarMas").text("buscando...");
  $.ajax({
    "url": "<?php echo mklink("web/get_list/") ?>",
    "type": "get",
    "data": data,
    "dataType": "html",
    "success": function(r) {
      var propiedades = document.querySelector(".propiedades");
      if (isEmpty(r)) {
        $("#cargarMas").hide();
      } else {
        propiedades.innerHTML += r;
        $("#cargarMas").text("ver más propiedades para tu búsqueda");
      }
      window.enviando = 0;
    },
    "error":function() {
      window.enviando = 0;
    }
  });
}
</script>
</body>

</html>