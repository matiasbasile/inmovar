<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("includes/init.php");
include_once("includes/funciones.php");
/* extract($propiedad_model->get_variables(array())); */

$id_localidad = isset($_POST['id_localidad']) ? $_POST["id_localidad"] : "";
$tipo_operacion = isset($_POST["ids_tipo_operacion"]) ? $_POST["ids_tipo_operacion"] : "";
$tipo_propiedad = isset($_POST["tp"]) ? $_POST["tp"] : "";
$dormitorios = isset($_POST["dm"]) ? $_POST["dm"] : "";
$limit = isset($_POST["limit"]) ? $_POST["limit"] : "";
$offset = isset($_POST["offset"]) ? $_POST["offset"] : "";
$acepta_permuta = isset($_POST["per"]) ? $_POST["per"] : "";
$maximo = isset($_POST["vc_maximo"]) ? $_POST["vc_maximo"] : "";
$minimo = isset($_POST["vc_minimo"]) ? $_POST["vc_minimo"] : "";
$banios = isset($_POST["bn"]) ? $_POST["bn"] : "";
$apto_credito = isset($_POST["banco"]) ? $_POST["banco"] : "";


$propiedades = $propiedad_model->get_list(
  array(
    'limit' => $limit,
    'offset' => $offset,
    'id_localidad' => $id_localidad,
    'id_tipo_operacion' => $tipo_operacion,
    'id_tipo_inmueble' => $tipo_propiedad,
    'dormitorios' => $dormitorios,
    'acepta_permuta' => $acepta_permuta,
    'maximo' => $maximo,
    'minimo' => $minimo,
    'banios' => $banios,
    'apto_banco' => $apto_credito,
  )
);

?>
<?php foreach ($propiedades as $propiedad) { ?>
  <div class="col-md-4 p-0 neighborhoods-list">
    <a href="<?php echo $propiedad->link_propiedad ?>">
      <div class="img-block">
        <img src="<?php echo $propiedad->imagen ?> " alt="img">
        <div class="neighborhoods-top">
          <?php if (!empty($propiedad->calle)) { ?>
            <p><?php echo $propiedad->calle . ", " . ($propiedad->localidad != "" ? $propiedad->localidad : "") ?></p>
          <?php } ?>
          <h4><?php echo $propiedad->precio ?></h4>
        </div>
        <div class="neighborhoods-bottom">
          <?php if ($propiedad->ambientes != 0) { ?>
            <div class="neighborhoods-info">
              <h6><?php echo $propiedad->ambientes ?> Hab.</h6>
              <img src="assets/images/icon11.png" alt="img">
            </div>
          <?php } ?>
          <?php if ($propiedad->ambientes != 0) { ?>
            <div class="neighborhoods-info">
              <h6><?php echo $propiedad->ambientes ?> Baños</h6>
              <img src="assets/images/icon12.png" alt="img">
            </div>
          <?php } ?>
          <?php if ($propiedad->cocheras != 0) { ?>
            <div class="neighborhoods-info">
              <h6><?php echo $propiedad->cocheras ?> Auto</h6>
              <img src="assets/images/icon13.png" alt="img">
            </div>
          <?php } ?>
          <?php if ($propiedad->superficie_total != 0) { ?>
            <div class="neighborhoods-info">
              <h6><?php echo $propiedad->superficie_total ?> m2</h6>
              <img src="assets/images/icon14.png" alt="img">
            </div>
          <?php } ?>
        </div>
      </div>
    </a>
  </div>
<?php } ?>