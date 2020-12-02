<?php
include_once("includes/funciones.php");
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);

$nombre_pagina = "favoritos";

// PARA QUE FUNCIONE EL BUSCADOR, SETEAMOS EL MAXIMO Y EL MINIMO
$sql = "SELECT IF(MAX(precio_final) IS NULL,0,MAX(precio_final)) AS maximo FROM inm_propiedades WHERE id_empresa = $empresa->id ";
$q_maximo = mysqli_query($conx,$sql);
$r_maximo = mysqli_fetch_object($q_maximo);
$precio_maximo = ($r_maximo->maximo == 0) ? 2000000 : (ceil($r_maximo->maximo/100)*100);
// Minimo
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;
// Maximo
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo;

$productos = $propiedad_model->favoritos();
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="page-sub-page page-listing-lines page-search-results" id="page-top">
<!-- Wrapper -->
<div class="wrapper">
  <?php include("includes/header.php"); ?>
  <!-- Page Content -->
  <div id="page-content">
    <!-- Breadcrumb -->
    <div class="container">
      <ol class="breadcrumb">
        <li><a href="<?php echo mklink("/"); ?>">Inicio</a></li>
        <li class="active">Favoritos</li>
      </ol>
    </div>
    <!-- end Breadcrumb -->

    <div class="container">
      <div class="row">
        <!-- Results -->
        <div class="col-md-9 col-sm-9">
          <section id="results">
            <header><h1>Favoritos</h1></header>
            <section id="properties" class="display-lines">
              <?php if (sizeof($productos)==0) { ?>
                No tienes ninguna propiedad agregada en favoritos.
              <?php } ?>
              <?php foreach($productos as $r) { ?>
                <div class="property">
                  <?php if ($r->nuevo == 1) { ?>
                    <figure class="tag status">Nuevo</figure>
                  <?php } ?>
                  <div class="property-image">
                    <?php if ($r->id_tipo_estado == 2) { ?>
                      <figure class="ribbon">Alquilado</figure>
                    <?php } else if ($r->id_tipo_estado == 4) { ?>
                      <figure class="ribbon">Reservado</figure>
                    <?php } else if ($r->id_tipo_estado == 3) { ?>
                      <figure class="ribbon">Vendido</figure>
                    <?php } ?>
                    <a href="<?php echo $r->link_propiedad ?>">
                      <?php if (!empty($r->imagen)) { ?>
                        <img src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                      <?php } else if (!empty($empresa->no_imagen)) { ?>
                        <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                      <?php } else { ?>
                        <img src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
                      <?php } ?>
                    </a>
                  </div>
                  <div class="info">
                    <header>
                      <a href="<?php echo $r->link_propiedad ?>"><h3><?php echo $r->nombre ?></h3></a>
                      <figure>
                        <?php echo $r->direccion_completa.", "; ?>
                        <?php echo $r->localidad ?>
                      </figure>
                    </header>
                    <div class="tag price"><?php echo ($r->precio_final != 0 && $r->publica_precio == 1) ? $r->moneda." ".number_format($r->precio_final,0) : "Consultar"; ?></div>
                    <aside>
                      <p><?php echo substr($r->plain_text,0,140)."..."; ?></p>
                      <dl>
                        <?php if (!empty($r->superficie_total)) { ?>
                          <dt>Superficie:</dt>
                          <dd><?php echo $r->superficie_total ?> m<sup>2</sup></dd>
                        <?php } ?>
                        <dt>Habitaciones:</dt>
                          <dd><?php echo (!empty($r->dormitorios)) ? $r->dormitorios : "-" ?></dd>
                        <dt>Ba&ntilde;o:</dt>
                          <dd><?php echo (!empty($r->banios)) ? $r->banios : "-" ?></dd>
                        <dt>Garage:</dt>
                          <dd><?php echo (!empty($r->cocheras)) ? $r->cocheras : "-" ?></dd>
                      </dl>
                    </aside>
                    <a href="<?php echo $r->link_propiedad ?>" class="link-arrow">Ver m&aacute;s</a>
                  </div>
                </div>
              <?php } ?>
            </section>
          </section>
        </div>

        <!-- sidebar -->
        <div class="col-md-3 col-sm-3">
          <section id="sidebar">
            <aside id="edit-search">
              <header><h3>Buscador</h3></header>
              <?php include("includes/buscador.php"); ?>
            </aside><!-- /#edit-search -->
            <?php include("includes/destacadas.php"); ?>
          </section><!-- /#sidebar -->
        </div><!-- /.col-md-3 -->
        <!-- end Sidebar -->
      </div><!-- /.row -->
    </div><!-- /.container -->
  </div>
  <!-- end Page Content -->
  <!-- Page Footer -->
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