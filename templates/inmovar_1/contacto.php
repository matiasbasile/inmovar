<?php
include_once("includes/funciones.php");
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
$nombre_pagina = "contacto";

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

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="page-sub-page page-contact" id="page-top">
<div class="wrapper">
  <?php include("includes/header.php"); ?>
  <div id="page-content">
    <!-- Breadcrumb -->
    <div class="container">
      <ol class="breadcrumb">
        <li><a href="<?php echo mklink("contacto/"); ?>">Inicio</a></li>
        <li class="active">Contacto</li>
      </ol>
    </div>
    <!-- end Breadcrumb -->

    <div class="container">
      <div class="row">
        <!-- Contact -->
        <div class="col-md-9 col-sm-9">
          <section id="agent-detail">
            <header><h1>Contacto</h1></header>
            <section id="contact-information">
              <div class="row">
                <div class="col-md-4 col-sm-5">
                  <section id="address">
                    <header><h3>Ubicaci&oacute;n</h3></header>
                    <address>
                      <strong><?php echo $empresa->nombre ?></strong><br>
                      <?php echo ($empresa->direccion) ?><br>
                      <?php echo ($empresa->localidad) ?>
                    </address>
                    <?php if (!empty($empresa->telefono)) { ?>
                      <?php echo $empresa->telefono ?><br>
                    <?php } ?>
                    <?php if (!empty($empresa->telefono_2)) { ?>
                      <?php echo $empresa->telefono_2 ?><br>
                    <?php } ?>
                    <?php if (!empty($empresa->email)) { ?>
                      <a href="mailto:<?php echo $empresa->email ?>">
                        <?php echo $empresa->email ?>
                      </a>
                    <?php } ?>
                  </section><!-- /#address -->

                  <?php if (!empty($empresa->horario)) { ?>
                    <section>
                      <header><h3>Horarios de Atención</h3></header>
                      <?php echo $empresa->horario ?><br>
                    </section>
                  <?php } ?>                    

                  <?php if (!empty($empresa->facebook) || !empty($empresa->twitter) || !empty($empresa->instagram) || !empty($empresa->linkedin)) { ?>
                    <section id="social">
                      <header><h3>Redes Sociales</h3></header>
                      <div class="agent-social">
                        <?php if (!empty($empresa->facebook)) { ?>
                          <a target="_blank" href="<?php echo $empresa->facebook ?>" class="fa fa-facebook btn btn-grey-dark"></a>
                        <?php } ?>
                        <?php if (!empty($empresa->twitter)) { ?>
                          <a target="_blank" href="<?php echo $empresa->twitter ?>" class="fa fa-twitter btn btn-grey-dark"></a>
                        <?php } ?>
                        <?php if (!empty($empresa->instagram)) { ?>
                          <a target="_blank" href="<?php echo $empresa->instagram ?>" class="fa fa-instagram btn btn-grey-dark"></a>
                        <?php } ?>
                        <?php if (!empty($empresa->linkedin)) { ?>
                          <a target="_blank" href="<?php echo $empresa->linkedin ?>" class="fa fa-linkedin btn btn-grey-dark"></a>
                        <?php } ?>
                      </div>
                    </section>
                  <?php } ?>
                  
                </div><!-- /.col-md-4 -->
                <div class="col-md-8 col-sm-7">
                  <header><h3>Donde estamos</h3></header>
                  <div id="contact-map"></div>
                </div><!-- /.col-md-8 -->
              </div><!-- /.row -->
            </section><!-- /#agent-info -->
            <hr class="thick">
            <section id="form">
              <header><h3>Formulario de contacto</h3></header>
              <?php include("includes/form_contacto.php"); ?>
            </section>
          </section>
        </div>

        <!-- sidebar -->
        <div class="col-md-3 col-sm-3">
          <section id="sidebar">
            <aside id="edit-search">
              <header><h3>Buscador</h3></header>
              <?php include("includes/buscador.php"); ?>
            </aside>
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
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript" src="assets/js/markerwithlabel_packed.js"></script>
<script type="text/javascript" src="assets/js/infobox.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/smoothscroll.js"></script>
<script type="text/javascript" src="assets/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/js/retina-1.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="assets/js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="assets/js/tmpl.js"></script>
<script type="text/javascript" src="assets/js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="assets/js/draggable-0.1.js"></script>
<script type="text/javascript" src="assets/js/jquery.slider.js"></script>

<script type="text/javascript" src="assets/js/custom-map.js"></script>
<script type="text/javascript" src="assets/js/custom.js"></script>
<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>
<!--[if gt IE 8]>
<script type="text/javascript" src="assets/js/ie.js"></script>
<![endif]-->
<script type="text/javascript">
$(document).ready(function(){
  <?php if (!empty($empresa->posiciones) && !empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('contact-map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
    }).addTo(mymap);

    <?php
    $posiciones = explode("/",$empresa->posiciones);
    for($i=0;$i<sizeof($posiciones);$i++) { 
      $pos = explode(";",$posiciones[$i]); ?>
      L.marker([<?php echo $pos[0] ?>,<?php echo $pos[1] ?>]).addTo(mymap);
    <?php } ?>

  <?php } ?>
});
</script>
</body>
</html>