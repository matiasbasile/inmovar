<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("includes/init.php");
include_once("includes/funciones.php");
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
    <a href="javascript:void(0)" rel="nofollow" class="btn btn-primary btn-block mb-3 form-toggle style-two mt-5">AJUSTAR BÚSQUEDA</a>
    <div class="form-responsive mt-5">
      <div class="form-block">
        <form onsubmit="return filtrar(this)" method="get">
          <select class="form-control filter_propiedad">
            <option value="0">DEPARTAMENTOS</option>
            <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
            <?php foreach ($tipo_propiedades as $tipo) { ?>
              <option <?php echo ($vc_id_tipo_inmueble == $tipo->id)?"selected":"" ?> value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
            <?php } ?>
          </select>
          <select class="form-control filter_localidad">
            <option value="0">Localidad</option>
            <?php $localidades = $propiedad_model->get_localidades(); ?>
            <?php foreach ($localidades as $localidad) { ?>
              <option <?php echo ($localidad->link == $vc_link_localidad)?"selected":"" ?> value="<?php echo $localidad->id ?>"><?php echo $localidad->nombre ?></option>
            <?php } ?>
          </select>
          <select class="form-control filter_dormitorios">
            <option value="0">dormitorios</option>
            <?php $dormitorios = $propiedad_model->get_dormitorios(); ?>
            <?php foreach ($dormitorios as $dormitorio) { ?>
              <option <?php echo ($vc_dormitorios == $dormitorio->dormitorios)?"selected":"" ?> value="<?php echo $dormitorio->dormitorios; ?>"><?php echo $dormitorio->dormitorios ?></option>
            <?php } ?>
          </select>
          <select class="form-control filter_banios">
            <option value="0">baños</option>
            <?php $banios = $propiedad_model->get_banios(); ?>
            <?php foreach ($banios as $banio) { ?>
              <option <?php echo ($vc_banios == $banio->banios)?"selected":"" ?> value="<?php echo $banio->banios; ?>"><?php echo $banio->banios ?></option>
            <?php } ?>
          </select>
          <div class="inputs-with">
            <input class="form-control filter_minimo" type="number" value="<?php echo $vc_minimo ?>" min="0" placeholder="Precio Minimo">
          </div>
          <div class="inputs-with">
            <input class="form-control filter_maximo" type="number" value="<?php echo $vc_maximo ?>" min="0" placeholder="Precio Maximo">
          </div>
          <button type="submit" class="btn btn-primary">BUSCAR</button>
        </form>
      </div>
      <div class="page-heading mt-5">
        <div class="row justify-content-between">
          <div class="col-md-7">
            <select class="form-control form-primary">
              <option>propiedades destacadas</option>
            </select>
            <a href="<?php echo mklink("web/mapa") ?>" class="btn btn-primary btn-sm"><i class="fa fa-map-marker mr-2" aria-hidden="true"></i> Ver en mapa</a>
          </div>
          <div class="col-md-5 text-right">
            <div class="custom-check">
              <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
              <label for="styled-checkbox-1">Apto Crédito</label>
            </div>
            <div class="custom-check">
              <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="value2">
              <label for="styled-checkbox-2">Acepta Permuta</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="neighborhoods shadow-none style-two">
      <div class="row m-0 my-5 propiedades">
        <?php $cont = 0; ?>
        <?php foreach ($vc_listado as $destacado) { ?>
          <?php if ($destacado->destacado == 1) { ?>
            <div class="col-md-4 p-0 neighborhoods-list">
              <a href="<?php echo $destacado->link_propiedad ?>">
                <div class="img-block">
                  <img src="<?php echo $destacado->imagen ?> " alt="img">
                  <div class="neighborhoods-top">
                    <p><?php echo $destacado->direccion_completa ?></p>
                    <h4><?php echo $destacado->precio ?></h4>
                  </div>
                  <div class="neighborhoods-bottom">
                    <?php if ($destacado->ambientes != 0) { ?>
                      <div class="neighborhoods-info">
                        <h6><?php echo $destacado->ambientes ?> Hab.</h6>
                        <img src="assets/images/icon11.png" alt="img">
                      </div>
                    <?php } ?>
                    <?php if ($destacado->ambientes != 0) { ?>
                      <div class="neighborhoods-info">
                        <h6><?php echo $destacado->ambientes ?> Baños</h6>
                        <img src="assets/images/icon12.png" alt="img">
                      </div>
                    <?php } ?>
                    <?php if ($destacado->cocheras != 0) { ?>
                      <div class="neighborhoods-info">
                        <h6><?php echo $destacado->cocheras ?> Auto</h6>
                        <img src="assets/images/icon13.png" alt="img">
                      </div>
                    <?php } ?>
                    <?php if ($destacado->superficie_total != 0) { ?>
                      <div class="neighborhoods-info">
                        <h6><?php echo $destacado->superficie_total ?> m2</h6>
                        <img src="assets/images/icon14.png" alt="img">
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </a>
            </div>
            <?php $cont++ ?>
          <?php } ?>
        <?php } ?>
        <?php foreach ($vc_listado as $propiedad) { ?>
          <?php if ($propiedad->destacado == 0) { ?>
            <div class="col-md-4 p-0 neighborhoods-list">
              <a href="<?php echo $propiedad->link_propiedad ?>">
                <div class="img-block">
                  <img src="<?php echo $propiedad->imagen ?> " alt="img">
                  <div class="neighborhoods-top">
                    <p><?php echo $propiedad->direccion_completa ?></p>
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
        <?php } ?>
      </div>
    </div>
    <div class="d-block mt-5">
      <a onclick="cargar()" class="btn btn-primary btn-block btn-lg">ver más propiedades para tu búsqueda</a>
    </div>
  </div>
</section>

<!-- Footer -->
<?php include("includes/footer.php") ?>
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/html5.min.js"></script>
<script src="assets/js/respond.min.js"></script>
<script src="assets/js/placeholders.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWmUapFYTBXV3IJL9ggjT9Z1wppCER55g&callback=initMap"></script>
<script src="assets/js/scripts.js"></script>
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