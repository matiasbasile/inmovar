<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("includes/init.php");
include_once("includes/funciones.php");
$propiedades = extract($propiedad_model->get_variables(array()));
if (isset($get_params["test"])) echo $propiedad_model->get_sql();
$nombre_pagina = $vc_link_tipo_operacion;
$tipos_op = $propiedad_model->get_tipos_operaciones();
$id_tipo_operacion = $vc_id_tipo_operacion;
if (isset($get_params["view"])) {
  $view = $get_params["view"];
}
if (isset($get_params["per"])) {
  if ($get_params["per"] = 1) {
    $nombre_pagina = "permutas";
  }
}
function filter()
{
  global $vc_offset, $view, $vc_total_paginas, $vc_link, $vc_page, $id_tipo_operacion, $vc_orden, $vc_params; ?>
  <div class="filter">
    <?php if ($id_tipo_operacion <= 2) { ?>
      <ul class="tab-buttons">
        <li><a class="grid-view <?php echo (($view != 0) ? "active" : "") ?>" onclick="change_view(this)" href="javascript:void(0)"></a></li>
        <li><a class="list-view <?php echo (($view == 0) ? "active" : "") ?>" onclick="change_view(this)" href="javascript:void(0)"></a></li>
      </ul>
    <?php } ?>
    <div class="sort-by">
      <label for="sort-by">Ordenar por:</label>
      <select id="sort-by" name="orden" onchange="filtrar()">
        <option <?php echo ($vc_orden == 2) ? "selected" : "" ?> value="2">Precio Menor a Mayor</option>
        <option <?php echo ($vc_orden == 1) ? "selected" : "" ?> value="1">Precio Mayor a Menor</option>
      </select>
    </div>
    <?php
    if ($vc_total_paginas > 1) { ?>
      <div class="pagination">
        <?php if ($vc_page > 0) { ?>
          <a class="prev" href="<?php echo mklink($vc_link . ($vc_page - 1) . "/" . $vc_params) ?>"></a>
        <?php } ?>
        <?php for ($i = 0; $i < $vc_total_paginas; $i++) { ?>
          <?php if (abs($vc_page - $i) < 2) { ?>
            <a class="<?php echo ($i == $vc_page) ? "active" : "" ?>" href="<?php echo mklink($vc_link . $i . "/" . $vc_params) ?>"><?php echo ($i + 1); ?></a>
          <?php } ?>
        <?php } ?>
        <?php if ($vc_page < ($vc_total_paginas - 1)) { ?>
          <a class="next" href="<?php echo mklink($vc_link . ($vc_page + 1) . "/" . $vc_params) ?>"></a>
        <?php } ?>
      </div>
    <?php } ?>
    <div class="present">
      <label for="show">Mostrar:</label>
      <select id="show" name="offset" onchange="filtrar()">
        <option <?php echo ($vc_offset == 12) ? "selected" : "" ?> value="12">12</option>
        <option <?php echo ($vc_offset == 24) ? "selected" : "" ?> value="24">24</option>
        <option <?php echo ($vc_offset == 48) ? "selected" : "" ?> value="48">48</option>
      </select>
    </div>
  </div>
<?php } ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
  <?php include("includes/head.php"); ?>
</head>

<body class="bg-gray">
  <?php include("includes/header.php");
  if (isset($_GET["buscador"]) && !empty($_GET["buscador"])) {
    $listado = $propiedad_model->get_list(array("id_tipo_operacion" => $_GET["tipo_operacion"], "id_localidad" => $_GET["id_localidad"], "id_tipo_inmueble" => $_GET["tipo_propiedad"]));
  } else if (isset($_GET["all"]) && !empty($_GET["all"])) {
    $listado = $propiedad_model->get_list(array("offset"=>20));
  } else {
    if (isset($_GET["id_localidad"]) && !empty($_GET["id_localidad"])) {
      $listado = $propiedad_model->get_list(array("id_localidad" => $_GET["id_localidad"]));
    } else if (isset($_GET["id_tipo_operacion"]) && !empty($_GET["id_tipo_operacion"])) {
      $listado = $propiedad_model->get_list(array("id_tipo_operacion" => $_GET["id_tipo_operacion"]));
    }
  } ?>
  <!-- lising -->
  <section class="padding-default">
    <div class="container style-two">
      <div class="page-heading">
        <?php if (isset($_GET["id_tipo_operacion"]) && !empty($_GET["id_tipo_operacion"]) && $_GET["id_tipo_operacion"] == 1) { ?>
          <h2>Departamentos en Venta</h2>
          <h6>Se encontraron <b><?php echo sizeof($listado) ?></b> departamentos</h6>
        <?php } else if (isset($_GET["id_tipo_operacion"]) && !empty($_GET["id_tipo_operacion"]) && $_GET["id_tipo_operacion"] == 2) { ?>
          <h2>Departamentos en Alquiler</h2>
          <h6>Se encontraron <b><?php echo sizeof($listado) ?></b> departamentos</h6>
        <?php } else if (isset($_GET["id_tipo_operacion"]) && !empty($_GET["id_tipo_operacion"]) && $_GET["id_tipo_operacion"] == 4) { ?>
          <h2>Emprendimientos</h2>
          <h6>Se encontraron <b><?php echo sizeof($listado) ?></b> emprendimientos</h6>
        <?php } else if (isset($_GET["id_tipo_operacion"]) && !empty($_GET["id_tipo_operacion"]) && $_GET["id_tipo_operacion"] == 5) { ?>
          <h2>Obras</h2>
          <h6>Se encontraron <b><?php echo sizeof($listado) ?></b> obras</h6>
        <?php } ?>
        <?php if (isset($_GET["id_localidad"]) && !empty($_GET["id_localidad"])) { ?>
          <h2>Propiedades</h2>
          <h6>Se encontraron <b><?php echo sizeof($listado) ?></b> propiedades</h6>
        <?php } ?>
        <?php if (isset($_GET["all"]) && !empty($_GET["all"])) { ?>
          <h2>Propiedades</h2>
          <h6>Se encontraron <b><?php echo sizeof($listado) ?></b> propiedades</h6>
        <?php } ?>
      </div>
      <a href="#0" class="btn btn-primary btn-block mb-3 form-toggle style-two mt-5">AJUSTAR BÚSQUEDA</a>
      <div class="form-responsive mt-5">
        <div class="form-block">
          <form>
            <select class="form-control">
              <option>DEPARTAMENTOS</option>
            </select>
            <select class="form-control">
              <option>EN LA PLATA</option>
            </select>
            <select class="form-control">
              <option>dormitorios</option>
            </select>
            <select class="form-control">
              <option>baños</option>
            </select>
            <select class="form-control">
              <option>precio</option>
            </select>
            <button type="submit" class="btn btn-primary">BUSCAR</button>
          </form>
        </div>
        <div class="page-heading mt-5">
          <div class="row justify-content-between">
            <div class="col-md-7">
              <select class="form-control form-primary">
                <option>propiedades destacadas</option>
              </select>
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-map-marker mr-2" aria-hidden="true"></i> Ver en mapa</button>
            </div>
            <div class="col-md-5 text-right">
              <div class="custom-check">
                <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
                <label for="styled-checkbox-1">Apto Crédito</label>
              </div>
              <div class="custom-check">
                <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="value2" checked>
                <label for="styled-checkbox-2">Acepta Permuta</label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="neighborhoods shadow-none style-two">
        <div class="row m-0 my-5">
          <?php foreach ($listado as $propiedad) { ?>
            <div class="col-md-4 p-0 neighborhoods-list">
              <a href="<?php echo mklink($propiedad->link) ?>">
                <div class="img-block">
                  <img src="<?php echo '/admin/' . $propiedad->path ?> " alt="img">
                  <div class="neighborhoods-top">
                    <?php if (!empty($propiedad->calle)) { ?>
                      <p><?php echo $propiedad->calle . ", " . ($propiedad->localidad != "" ? $propiedad->localidad : "") ?></p>
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
          <!-- <div class="col-md-4 p-0 neighborhoods-list">
            <div class="img-block">
              <img src="assets/images/img05.jpg" alt="img">
              <div class="neighborhoods-top">
                <p>22 1805, e/69 y 70. La Plata</p>
                <h4>U$S 140.000</h4>
              </div>
              <div class="neighborhoods-bottom">
                <div class="neighborhoods-info">
                  <h6>2 Hab.</h6>
                  <img src="assets/images/icon11.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>2 Baños</h6>
                  <img src="assets/images/icon12.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>1 Auto</h6>
                  <img src="assets/images/icon13.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>813 m2</h6>
                  <img src="assets/images/icon14.png" alt="img">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 p-0 neighborhoods-list">
            <div class="img-block">
              <img src="assets/images/img06.jpg" alt="img">
              <div class="neighborhoods-top">
                <p>22 1805, e/69 y 70. La Plata</p>
                <h4>U$S 140.000</h4>
              </div>
              <div class="neighborhoods-bottom">
                <div class="neighborhoods-info">
                  <h6>2 Hab.</h6>
                  <img src="assets/images/icon11.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>2 Baños</h6>
                  <img src="assets/images/icon12.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>1 Auto</h6>
                  <img src="assets/images/icon13.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>813 m2</h6>
                  <img src="assets/images/icon14.png" alt="img">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 p-0 neighborhoods-list">
            <div class="img-block">
              <img src="assets/images/img07.jpg" alt="img">
              <div class="neighborhoods-top">
                <p>22 1805, e/69 y 70. La Plata</p>
                <h4>U$S 140.000</h4>
              </div>
              <div class="neighborhoods-bottom">
                <div class="neighborhoods-info">
                  <h6>2 Hab.</h6>
                  <img src="assets/images/icon11.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>2 Baños</h6>
                  <img src="assets/images/icon12.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>1 Auto</h6>
                  <img src="assets/images/icon13.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>813 m2</h6>
                  <img src="assets/images/icon14.png" alt="img">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 p-0 neighborhoods-list">
            <div class="img-block">
              <img src="assets/images/img08.jpg" alt="img">
              <div class="neighborhoods-top">
                <p>22 1805, e/69 y 70. La Plata</p>
                <h4>U$S 140.000</h4>
              </div>
              <div class="neighborhoods-bottom">
                <div class="neighborhoods-info">
                  <h6>2 Hab.</h6>
                  <img src="assets/images/icon11.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>2 Baños</h6>
                  <img src="assets/images/icon12.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>1 Auto</h6>
                  <img src="assets/images/icon13.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>813 m2</h6>
                  <img src="assets/images/icon14.png" alt="img">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 p-0 neighborhoods-list">
            <div class="img-block">
              <img src="assets/images/img09.jpg" alt="img">
              <div class="neighborhoods-top">
                <p>22 1805, e/69 y 70. La Plata</p>
                <h4>U$S 140.000</h4>
              </div>
              <div class="neighborhoods-bottom">
                <div class="neighborhoods-info">
                  <h6>2 Hab.</h6>
                  <img src="assets/images/icon11.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>2 Baños</h6>
                  <img src="assets/images/icon12.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>1 Auto</h6>
                  <img src="assets/images/icon13.png" alt="img">
                </div>
                <div class="neighborhoods-info">
                  <h6>813 m2</h6>
                  <img src="assets/images/icon14.png" alt="img">
                </div>
              </div>
            </div>
          </div> -->
        </div>
      </div>
      <div class="d-block mt-5">
        <a href="#0" class="btn btn-primary btn-block btn-lg">ver más propiedades para tu búsqueda</a>
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
</body>

</html>