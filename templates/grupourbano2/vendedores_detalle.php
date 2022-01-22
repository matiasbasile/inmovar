<?php
include_once("includes/init.php");
$nombre_pagina = "nosotros";
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="bg-gray">
<?php include("includes/header.php") ?>

<!-- lising -->
<?php if (isset($_GET["id_usuario"]) && !empty($_GET["id_usuario"])) { ?>
  <?php $usuario = $usuario_model->get($_GET["id_usuario"]); ?>
  <?php $listado = $propiedad_model->get_list(array("id_usuario" => $_GET["id_usuario"])); ?>
<?php } ?>
<section class="padding-default vendedores-list">
  <div class="container style-two">
    <div class="row">
      <div class="col-md-9">
        <div class="page-heading">
          <?php $nombre = explode(" ", $usuario->nombre) ?>
          <h2>Propiedades de <?php echo $nombre[0] ?></h2>
          <h6>Se encontraron <b><?php echo sizeof($listado) ?></b> propiedades</h6>
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
          <div class="row m-0 my-5">
            <?php foreach ($listado  as $propiedad) { ?>
              <div class="col-md-6 p-0 neighborhoods-list">
                <a href="<?php echo mklink($propiedad->link) ?>">
                  <div class="img-block">
                    <img src="<?php echo '/admin/' . $propiedad->path ?> " alt="img">
                    <div class="neighborhoods-top">
                      <?php if (!empty($propiedad->direccion_completa)) { ?>
                        <p><?php echo $propiedad->direccion_completa ?></p>
                      <?php } ?>
                      <?php if ($propiedad->publica_precio == 1) { ?>
                        <h4><?php echo $propiedad->moneda; ?> <?php echo $propiedad->precio_final; ?></h4>
                      <?php } else { ?>
                        <h4>Consultar</h4>
                      <?php } ?>
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
          </div>
        </div>
        <div class="page-heading">
          <h2>Buscá más en Grupo Urbano</h2>
          <h6>Realizá una búsqueda en más de <b>10.000</b> propiedades a la venta</h6>
        </div>
        <div class="form-block mt-5">
          <a href="#0" class="btn btn-primary btn-block mb-3 form-toggle style-two">AJUSTAR BÚSQUEDA</a>
          <form class="form-responsive" onsubmit="return filtrar(this)" method="get">
            <select class="form-control filter_tipo_operacion">
              <option value="0">Operación</option>
              <?php $tipo_operaciones = $propiedad_model->get_tipos_operaciones(); ?>
              <?php foreach ($tipo_operaciones as $operaciones) { ?>
                <option value="<?php echo $operaciones->id ?>"><?php echo $operaciones->nombre ?></option>
              <?php } ?>
            </select>
            <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
            <select class="form-control filter_propiedad">
              <option value="0">Propiedad</option>
              <?php foreach ($tipo_propiedades as $tipo) { ?>
                <option value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
              <?php } ?>
            </select>
            <select class="form-control filter_localidad">
              <option value="0">Localidad</option>
              <?php $localidades = $propiedad_model->get_localidades(); ?>
              <?php foreach ($localidades as $localidad) { ?>
                <option value="<?php echo $localidad->id ?>"><?php echo $localidad->nombre ?></option>
              <?php } ?>
            </select>
            <button type="submit" class="btn btn-primary">BUSCAR</button>
          </form>
        </div>
      </div>
      <div class="col-md-3">
        <?php if ($usuario->aparece_web != 0) { ?>
          <div class="right-sidebar">
            <?php if (!empty($usuario->path)) { ?>
              <div class="sidebar-img">
                <img src="<?php echo $usuario->path ?>" alt="img">
                <div class="sidebar-logo"><img src="assets/images/logo-icon.jpg" alt="img"></div>
              </div>
            <?php } ?>
            <?php if (!empty($usuario->nombre)) { ?>
              <h2><?php echo $usuario->nombre ?></h2>
            <?php } ?>
            <?php if (!empty($usuario->cargo)) { ?>
              <h5><?php echo $usuario->cargo ?></h5>
            <?php } ?>
            <div class="social">
              <?php if (!empty($usuario->facebook)) { ?>
                <a href="<?php echo $usuario->facebook ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
              <?php } ?>
              <?php if (!empty($usuario->instagram)) { ?>
                <a href="<?php echo $usuario->instagram ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
              <?php } ?>
            </div>
            <?php $nombre = explode(" ", $usuario->nombre) ?>
            <a href="tel:<?php echo $usuario->telefono ?>" class="btn btn-primary btn-block"><i class="fa fa-phone mr-3" aria-hidden="true"></i> llamá a <?php echo $nombre[0] ?></a>
          </div>
        <?php } ?>

        <div class="right-sidebar">
          <div class="sidebar-arrow"><img src="assets/images/sidebar-arrow.png" alt="img"></div>
          <h2>comunicate ahora</h2>
          <h5 class="mb-3">por estas propiedades</h5>
          <form onsubmit="enviar_contacto()">
            <div class="form-group">
              <input type="email" class="form-control" placeholder="Nombre">
            </div>
            <div class="form-group">
              <input type="email" class="form-control" placeholder="WhatsApp (sin 0 ni 15)">
            </div>
            <div class="form-group">
              <input type="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
              <textarea class="form-control" placeholder="Escribir mensaje"></textarea>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success btn-block"><i class="fa fa-whatsapp mr-3" aria-hidden="true"></i> enviar por whatsapp</button>
            </div>
            <div class="form-group mb-0">
              <button type="submit" class="btn btn-secondary btn-block"><i class="fa fa-envelope-o mr-3" aria-hidden="true"></i> enviar por email</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include("includes/footer.php") ?>

<script>
  function enviar_contacto() {
    if (enviando == 1) return;
    var nombre = $("#contacto_nombre").val();
    var email = $("#contacto_email").val();
    var telefono = $("#contacto_telefono").val();
    var mensaje = $("#contacto_mensaje").val();
    var para = $("#contacto_para").val();
    var id_propiedad = $("#contacto_propiedad").val();
    var id_usuario = $("#contacto_id_usuario").val();
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