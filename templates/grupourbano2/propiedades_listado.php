<?php
include_once("includes/init.php");
$propiedades = extract($propiedad_model->get_variables());
if (isset($get_params["test"])) echo $propiedad_model->get_sql();

$tipos_op = $propiedad_model->get_tipos_operaciones();
if (isset($get_params["view"])) {
  $view = $get_params["view"];
}
if (isset($get_params["per"])) {
  if ($get_params["per"] = 1) {
    $nombre_pagina = "permutas";
  }
} ?>
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
      <a onclick="cargar()" class="btn btn-primary btn-block btn-lg">ver más propiedades para tu búsqueda</a>
    </div>
  </div>
</section>

<?php include("includes/footer.php") ?>

<script>
window.limit = 12;
window.marca = true;

function cargar() {
  var search = window.location.search;
  search = search.slice(1);
  search = search.split("&");
  var data = {};
  search.forEach(element => {
    var nuevoArray = element.split("=");
    data[nuevoArray[0]] = nuevoArray[1];
  });

  window.limit += 12;
  data['id_empresa'] = ID_EMPRESA;
  data['limit'] = window.limit;
  data['offset'] = 12;
  console.log(data);
  $.ajax({
    "url": "<?php echo mklink("web/get_list/") ?>",
    "type": "post",
    "data": data,
    "dataType": "html",
    "success": function(r) {
      console.log(r);
      var propiedades = document.querySelector(".propiedades");
      
      propiedades.innerHTML += r;
    }
  });
}
</script>
</body>

</html>