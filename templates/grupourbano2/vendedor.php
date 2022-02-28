<?php
include_once("includes/init.php");
$tipo_busqueda = isset($get_params["tipo_busqueda"]) ? $get_params["tipo_busqueda"] : "listado";
if (isset($_GET["id"]) && !empty($_GET["id"])) {
  $id_usuario = intval($_GET["id"]);
  $usuario = $usuario_model->get($id_usuario);
  extract($propiedad_model->get_variables(array(
    "id_usuario" => $id_usuario,
    "no_analizar_url" => 1,
  )));
  if (isset($get_params["test"])) echo $propiedad_model->get_sql();
}
$nombre_pagina = "nosotros";
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="bg-gray">
<?php include("includes/header.php") ?>

<section class="padding-default vendedores-list">
  <div class="container style-two">
    <div class="row">
      <div class="col-md-9">
        <div class="page-heading">
          <?php $nombre = explode(" ", $usuario->nombre) ?>
          <h2>Propiedades de <?php echo $nombre[0] ?></h2>
          <h6>Se encontraron <b><?php echo $vc_total_resultados ?></b> propiedades</h6>
        </div>
        <div class="mt-4">
          <div class="row">
            <div class="col-md-8">
              <p class="mt-1 text-18">Ordenar propiedades por:</p>
              <select class="form-control form-primary">
                <option>propiedades destacadas</option>
              </select>
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-map-marker mr-2" aria-hidden="true"></i> Ver en mapa</button>
            </div>
          </div>
        </div>
        <div class="neighborhoods shadow-none style-two">
          
          <?php 
          if ($tipo_busqueda == "listado") { ?>
            <div class="row m-0 my-5 propiedades">
              <?php foreach ($vc_listado  as $propiedad) { 
                item($propiedad,array(
                  "clase"=>"col-md-6 p-0 neighborhoods-list",
                ));
              } ?>
            </div>
            <div class="d-block mt-5 mb40">
              <a onclick="cargar()" id="cargarMas" class="btn btn-primary btn-block btn-lg">ver más propiedades para tu búsqueda</a>
            </div>
          <?php } else { ?>
            <div id="mapa" style="width:100%; height:700px"></div>
          <?php } ?>
          
        </div>
        <div class="page-heading">
          <h2>Buscá más en Grupo Urbano</h2>
          <h6>Realizá una búsqueda en más de <b>10.000</b> propiedades a la venta</h6>
        </div>
        <div class="form-block mt-5">
          <a href="javascript:void(0)" rel="nofollow" class="btn btn-primary btn-block mb-3 form-toggle style-two">AJUSTAR BÚSQUEDA</a>
          <form class="form" onsubmit="return filtrar(this)" method="get">
            <input type="hidden" class="base_url" value="<?php echo mklink("propiedades/") ?>" />
            <input type="hidden" name="tipo_busqueda" value="<?php echo $tipo_busqueda ?>" />
            <select class="form-control filter_tipo_operacion">
              <option value="0">Operación</option>
              <?php $tipo_operaciones = $propiedad_model->get_tipos_operaciones(); ?>
              <?php foreach ($tipo_operaciones as $operaciones) { ?>
                <option value="<?php echo $operaciones->link ?>"><?php echo $operaciones->nombre ?></option>
              <?php } ?>
            </select>
            <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
            <select class="form-control filter_propiedad" name="tp">
              <option value="0">Propiedad</option>
              <?php foreach ($tipo_propiedades as $tipo) { ?>
                <option value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
              <?php } ?>
            </select>
            <select class="form-control filter_localidad">
              <option value="0">Localidad</option>
              <?php $localidades = $propiedad_model->get_localidades(); ?>
              <?php foreach ($localidades as $localidad) { ?>
                <option value="<?php echo $localidad->link ?>"><?php echo $localidad->nombre ?></option>
              <?php } ?>
            </select>
            <button type="submit" class="btn btn-primary">BUSCAR</button>
          </form>
        </div>
      </div>

      <?php 
      $mensaje_placeholder = "Escribir mensaje a ".$usuario->nombre;
      include("includes/propiedad/sidebar.php"); ?>

    </div>
  </div>
</section>

<?php 
include("includes/footer.php");
include_once("templates/comun/mapa_js.php"); 
include_once("includes/mapa_js.php");
include_once("includes/cargar_mas_js.php");
?>

<script>
function enviar_contacto() {
  if (enviando == 1) return;
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var para = $("#contacto_para").val();
  var id_propiedad = $("#contacto_propiedad").val();
  var id_usuario = "<?php echo $usuario->id ?>";
  if (isEmpty(para)) para = "<?php echo $empresa->email ?>";

  if (isEmpty(nombre) || nombre == "Nombre") {
    alert("Por favor ingrese un nombre");
    $("#contacto_nombre").focus();
    return false;
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_email").focus();
    return false;
  }
  if (isEmpty(telefono) || telefono == "Telefono") {
    alert("Por favor ingrese un telefono");
    $("#contacto_telefono").focus();
    return false;
  }
  if (isEmpty(mensaje) || mensaje == "Mensaje") {
    alert("Por favor ingrese un mensaje");
    $("#contacto_mensaje").focus();
    return false;
  }

  $("#contacto_submit").attr('disabled', 'disabled');
  var datos = {
    "nombre": nombre,
    "email": email,
    "mensaje": mensaje,
    "telefono": telefono,
    "para": para,
    "id_propiedad": id_propiedad,
    <?php if (isset($detalle) && $detalle->id_empresa != $empresa->id) { ?> "id_empresa_relacion": "<?php echo $detalle->id_empresa ?>",
    <?php } ?> "id_usuario": id_usuario,
    "id_empresa": ID_EMPRESA,
    "id_origen": <?php echo (isset($id_origen) ? $id_origen : 1); ?>,
  }
  enviando = 1;
  $.ajax({
    "url": "https://app.inmovar.com/admin/consultas/function/enviar/",
    "type": "post",
    "dataType": "json",
    "data": datos,
    "success": function(r) {
      if (r.error == 0) {
        window.location.href = "<?php echo mklink("web/gracias/") ?>";
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
        enviando = 0;
      }
    }
  });
  return false;
}
</script>
</body>
</html>