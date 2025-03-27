<?php 
include 'includes/init.php';
$config2 = array(
  "orden_default"=>8,
  "buscar_listado_completo"=>1, // Para usarlo en los mapas que traiga todo completo
);
if (isset($buscar_solo_emprendimientos)) {
  // Buscamos solo los emprendimientos
  $menu_active = "emprendimientos";
  $config2["ids_tipo_operacion"] = "4";
} else {
  // Estamos buscando el resto de propiedades
  $menu_active = "propiedades";
  $config2["ids_tipo_operacion"] = "1,2,3";
}

extract($propiedad_model->get_variables($config2));
if (isset($get_params["test"])) echo $propiedad_model->get_sql();
?>
<!DOCTYPE html>
<html lang="es" >
<head>
  <?php include 'includes/head.php' ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css" />  
  <link rel="stylesheet" type="text/css" href="assets/css/modal-whatsapp.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<?php include 'includes/listado/filtros.php' ?>

<?php if ($vc_view == 1) { ?>
  <?php include 'includes/listado/lista.php' ?>
<?php } else { ?>
  <?php include 'includes/listado/mapa.php' ?>
<?php } ?>

<?php include 'includes/footer.php' ?>
<?php include 'includes/propiedad/modal.php' ?>

<?php
include_once("templates/comun/mapa_js.php"); 
include_once("includes/listado/mapa_js.php");
?>

</body>
</html>