<?php
include_once("admin/application/helpers/fecha_helper.php");
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id, $conx);
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id, $conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id, $conx);

// PARA QUE FUNCIONE EL BUSCADOR, SETEAMOS EL MAXIMO Y EL MINIMO
$sql = "SELECT IF(MAX(precio_final) IS NULL,0,MAX(precio_final)) AS maximo FROM inm_propiedades WHERE id_empresa = $empresa->id ";
$q_maximo = mysqli_query($conx, $sql);
$r_maximo = mysqli_fetch_object($q_maximo);
$precio_maximo = ($r_maximo->maximo == 0) ? 2000000 : (ceil($r_maximo->maximo / 100) * 100);
// Minimo
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;
// Maximo
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo;

$page = 0;

$entrada = $entrada_model->get($id, array(
  "buscar_relacionados" => 0, // Se relaciona por etiquetas
));
$entrada->mostrar_relacionados = 1;

// Tomamos los datos de SEO
$seo_title = (!empty($entrada->seo_title)) ? ($entrada->seo_title) : $empresa->seo_title;
$seo_description = (!empty($entrada->seo_description)) ? ($entrada->seo_description) : $empresa->seo_description;
$seo_keywords = (!empty($entrada->seo_keywords)) ? ($entrada->seo_keywords) : $empresa->seo_keywords;

// Buscamos la categoria padre de todas y formamos el array
$link = mklink("entradas/");
$breadcrumb = $entrada_model->get_categorias($entrada->id_categoria, array(
  "link" => $link
));

$categoria = new stdClass();
$categoria->id = $entrada->id_categoria;
$categoria->nombre = $entrada->categoria;
$categoria->link = $entrada->categoria_link;

$nombre_pagina = $entrada->categoria_link;

$entrada->mostrar_categoria = 1;
$entrada->mostrar_relacionados = 1;
$entrada->mostrar_fecha = 1;
$entrada->mostrar_me_gusta = 1;
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
  <?php include("includes/head.php"); ?>
</head>

<body class="page-sub-page page-legal" id="page-top">
  <!-- Wrapper -->
  <div class="wrapper">
    <?php include("includes/header.php"); ?>
    <div id="page-content">
      <!-- Breadcrumb -->
      <div class="container">
        <ol class="breadcrumb">
          <li><a href="<?php echo mklink("/"); ?>">Inicio</a></li>
          <li class="active"><?php echo $entrada->titulo ?></li>
        </ol>
      </div>
      <!-- end Breadcrumb -->

      <div class="container">
        <div class="row">
          <!-- Content -->
          <div class="col-md-9 col-sm-9">
            <section id="content">
              <header>
                <h1><?php echo $entrada->titulo ?></h1>
              </header>


              <?php if (sizeof($entrada->images) > 0) { ?>
                <section id="property-gallery" class="pr">
                  <?php if (sizeof($entrada->images) == 1) {
                    $image = $entrada->images[0]; ?>
                    <img class="alto-2" src="<?php echo $image ?>" style="width: 100%" alt="<?php echo $entrada->titulo ?>" />
                  <?php } else { ?>
                    <div id="property-carousel" class="property-carousel carousel slide" data-ride="carousel">
                      <a id="prev" class="carousel-control" href="#property-carousel" data-slide="prev"></a>
                      <a id="next" class="carousel-control" href="#property-carousel" data-slide="next"></a>
                      <div class="carousel-inner">
                        <?php
                        $i = 0;
                        foreach ($entrada->images as $image) { ?>
                          <div class="item <?php echo ($i == 0) ? "active" : "" ?>">
                            <a href="<?php echo $image ?>" class="image-popup">
                              <img class="alto-2" src="<?php echo $image ?>" alt="<?php echo $entrada->titulo ?>" />
                            </a>
                          </div>
                        <?php $i++;
                        } ?>
                      </div>
                    </div>
                  <?php } ?>
                </section>
              <?php } ?>

              <section id="legal">
                <?php echo $entrada->texto; ?>
              </section>
              <?php if ($entrada->habilitar_contacto == 1) { ?>
                <section>
                  <header>
                    <h1>Formulario de Contacto</h1>
                  </header>
                  <?php
                  $asunto_defecto = $entrada->titulo;
                  include("includes/form_contacto.php"); ?>
                </section>
              <?php } ?>
            </section><!-- /#agent-detail -->
          </div><!-- /.col-md-9 -->
          <!-- end Content -->

          <!-- sidebar -->
          <div class="col-md-3 col-sm-3">
            <section id="sidebar">
              <aside id="edit-search">
                <header>
                  <h3>Buscador</h3>
                </header>
                <?php include("includes/buscador.php"); ?>
              </aside><!-- /#edit-search -->
              <?php include("includes/destacadas.php"); ?>
            </section><!-- /#sidebar -->
          </div><!-- /.col-md-3 -->
          <!-- end Sidebar -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div>
    <?php include("includes/footer.php"); ?>
  </div>

  <script type="text/javascript" src="assets/js/jquery-2.1.0.min.js"></script>
  <script type="text/javascript" src="assets/js/jquery-migrate-1.2.1.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/smoothscroll.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap-select.min.js"></script>
  <script type="text/javascript" src="assets/js/retina-1.1.0.min.js"></script>
  <script type="text/javascript" src="assets/js/jshashtable-2.1_src.js"></script>
  <script type="text/javascript" src="assets/js/jquery.numberformatter-1.2.3.js"></script>
  <script type="text/javascript" src="assets/js/tmpl.js"></script>
  <script type="text/javascript" src="assets/js/jquery.dependClass-0.1.js"></script>
  <script type="text/javascript" src="assets/js/draggable-0.1.js"></script>
  <script type="text/javascript" src="assets/js/jquery.slider.js"></script>
  <script type="text/javascript" src="assets/js/custom.js"></script>
  <script type="text/javascript" src="/admin/resources/js/common.js"></script>
  <script type="text/javascript" src="/admin/resources/js/main.js"></script>

  <!--[if gt IE 8]>
<script type="text/javascript" src="assets/js/ie.js"></script>
<![endif]-->

</body>

</html>