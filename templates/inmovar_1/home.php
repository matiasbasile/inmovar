<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$nombre_pagina = "home";
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);

include_once("includes/funciones.php");

// Minimo
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;

// Maximo
$precio_maximo = $propiedad_model->get_precio_maximo();
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo;
$tipo_operacion = new stdClass();
$tipo_operacion->id = 0;
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>

<body class="page-homepage navigation-fixed-top page-slider page-slider-search-box" id="page-top" data-spy="scroll" data-target=".navigation" data-offset="90">
<!-- Wrapper -->
<div class="wrapper">

<?php include("includes/header.php"); ?>

<?php 
$slider = $web_model->get_slider(array(
  "clave"=>"slider_1",
  ));
  if (sizeof($slider)>0) { ?>
    <div id="slider">
      <div class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
          <?php 
          $i=0;
          foreach($slider as $r) { ?>
            <div class="item <?php echo ($i==0)?"active":"" ?>" style="background-image: url(<?php echo $r->path ?>); background-position: center center; background-size: cover; background-repeat: no-repeat;">
              <div class="container">
                <div class="overlay">
                  <div class="info">
                    <?php if (!empty($r->linea_1)) { ?>
                      <?php if (!empty($r->link_1)) { ?><a href="<?php echo $r->link_1 ?>"><?php } ?>
                        <div class="tag price"><?php echo $r->linea_1 ?></div>
                      <?php if (!empty($r->link_1)) { ?></a><?php } ?>
                    <?php } ?>
                    <?php if (!empty($r->linea_2)) { ?>
                      <h3><?php echo $r->linea_2 ?></h3>
                    <?php } ?>
                    <?php if (!empty($r->linea_3)) { ?>
                      <figure><?php echo $r->linea_3 ?></figure>
                    <?php } ?>
                  </div>
                  <?php if (!empty($r->link_1)) { ?>
                    <a href="<?php echo $r->link_1 ?>" class="link-arrow">
                      <?php echo $r->texto_link_1 ?>
                    </a>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php $i++; } ?>
        </div>
      </div>
    </div>
  <?php } ?>

  <!-- Search Box -->
  <div class="search-box-wrapper search-box-home">
    <div class="search-box-inner">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-md-offset-9 col-sm-4 col-sm-offset-8">
            <div class="search-box map">
              <?php include("includes/buscador.php"); ?>
            </div><!-- /.search-box.map -->
          </div><!-- /.col-md-3 -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.search-box-inner -->
  </div>
  <!-- end Search Box -->

  <!-- Page Content -->
  <div id="page-content">
    <section id="banner">
      <div class="block has-dark-background background-color-default-darker center text-banner">
        <div class="container">
          <?php $t = $web_model->get_text("home-banner-titulo"); ?>
          <h1 data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable no-bottom-margin no-border"><?php echo $t->plain_text ?></h1>
        </div>
      </div>
    </section><!-- /#banner -->
    <section id="our-services" class="block">
      <div class="container">
        <?php $t = $web_model->get_text("home-servicios-titulo"); ?>
        <header data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable section-title"><h2><?php echo $t->plain_text ?></h2></header>
        <div class="row">
          <div class="col-md-4 col-sm-4">
            <div class="feature-box equal-height">
              <figure class="icon"><i class="fa fa-folder"></i></figure>
              <aside class="description">
                <?php $t = $web_model->get_text("home-servicios-1-titulo"); ?>
                <header><h3 data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></h3></header>
                <?php $t = $web_model->get_text("home-servicios-1-texto"); ?>
                <p data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></p>
                <?php if (!empty($t->link)) { ?>
                  <a href="<?php echo $t->link ?>" class="link-arrow">Ver m&aacute;s</a>
                <?php } ?>
              </aside>
            </div><!-- /.feature-box -->
          </div><!-- /.col-md-4 -->
          <div class="col-md-4 col-sm-4">
            <div class="feature-box equal-height">
              <figure class="icon"><i class="fa fa-folder"></i></figure>
              <aside class="description">
                <?php $t = $web_model->get_text("home-servicios-2-titulo"); ?>
                <header><h3 data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></h3></header>
                <?php $t = $web_model->get_text("home-servicios-2-texto"); ?>
                <p data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></p>
                <?php if (!empty($t->link)) { ?>
                  <a href="<?php echo $t->link ?>" class="link-arrow">Ver m&aacute;s</a>
                <?php } ?>
              </aside>
            </div><!-- /.feature-box -->
          </div><!-- /.col-md-4 -->
          <div class="col-md-4 col-sm-4">
            <div class="feature-box equal-height">
              <figure class="icon"><i class="fa fa-folder"></i></figure>
              <aside class="description">
                <?php $t = $web_model->get_text("home-servicios-3-titulo"); ?>
                <header><h3 data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></h3></header>
                <?php $t = $web_model->get_text("home-servicios-3-texto"); ?>
                <p data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></p>
                <?php if (!empty($t->link)) { ?>
                  <a href="<?php echo $t->link ?>" class="link-arrow">Ver m&aacute;s</a>
                <?php } ?>
              </aside>
            </div><!-- /.feature-box -->
          </div><!-- /.col-md-4 -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </section><!-- /#our-services -->
    <?php if ($empresa->comp_destacados == 1) { 
      $ids_destacadas = array();
      $destacadas = $propiedad_model->destacadas(array(
        "offset"=>4,
        "solo_propias"=>1,
      ));
      if (sizeof($destacadas)>0) { ?>
        <section id="price-drop" class="block">
          <div class="container">
            <header class="section-title">
              <h2>Propiedades Destacadas</h2>
              <a href="<?php echo mklink("propiedades/"); ?>" class="link-arrow">Ver todas</a>
            </header>
            <div class="row">
              <?php 
              if (sizeof($destacadas)>0) { ?>
                <?php foreach($destacadas as $r) { 
                  $ids_destacadas[] = $r->id; ?>
                  <div class="col-md-3 col-sm-6">
                    <div class="property">
                      <a href="<?php echo $r->link_propiedad ?>">
                        <div class="property-image">
                          <?php if ($r->id_tipo_estado == 2) { ?>
                            <figure class="ribbon">Alquilado</figure>
                          <?php } else if ($r->id_tipo_estado == 4) { ?>
                            <figure class="ribbon">Reservado</figure>
                          <?php } else if ($r->id_tipo_estado == 3) { ?>
                            <figure class="ribbon">Vendido</figure>
                          <?php } ?>
                          <?php if (!empty($r->imagen)) { ?>
                            <img class="alto" src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                          <?php } else if (!empty($empresa->no_imagen)) { ?>
                            <img class="alto" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                          <?php } else { ?>
                            <img class="alto" src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
                          <?php } ?>
                        </div>
                        <div class="overlay">
                          <div class="info">
                            <div class="tag price"><?php echo ($r->precio_final != 0 && $r->publica_precio == 1) ? $r->moneda." ".number_format($r->precio_final,0) : "Consultar"; ?></div>
                            <h3><?php echo $r->nombre ?></h3>
                            <figure><?php echo $r->direccion_completa.", ".$r->localidad; ?></figure>
                          </div>
                          <ul class="additional-info">
                            <?php if (!empty($r->superficie_total)) { ?>
                            <li>
                              <header>Superficie:</header>
                              <figure><?php echo $r->superficie_total ?> m<sup>2</sup></figure>
                            </li>
                            <?php } ?>
                            <li>
                              <header>Habitaciones:</header>
                              <figure><?php echo (!empty($r->dormitorios)) ? $r->dormitorios : "-" ?></figure>
                            </li>
                            <li>
                              <header>Ba&ntilde;os:</header>
                              <figure><?php echo (!empty($r->banios)) ? $r->banios : "-" ?></figure>
                            </li>
                            <li>
                              <header>Cocheras:</header>
                              <figure><?php echo (!empty($r->cocheras)) ? $r->cocheras : "-" ?></figure>
                            </li>
                          </ul>
                        </div>
                      </a>
                    </div><!-- /.property -->
                  </div>
                  <?php } ?>
                  <?php } ?>
                </div><!-- /.row-->
              </div><!-- /.container -->
            </section><!-- /#price-drop -->
          <?php } ?>
        <?php } ?>

        <?php if ($empresa->comp_ultimos == 1) { ?>

        <?php $ultimas = $propiedad_model->ultimas(array(
          "offset"=>4,
      //"not_in"=>$ids_destacadas,
          ));
          if (sizeof($ultimas)>0) { ?>
          <section id="new-properties" class="block">
            <div class="container">
              <header class="section-title">
                <h2>&Uacute;ltimas Propiedades</h2>
                <a href="<?php echo mklink("propiedades/"); ?>" class="link-arrow">Ver todas</a>
              </header>
              <div class="row">
                <?php foreach($ultimas as $r) { ?>
                <div class="col-md-3 col-sm-6">
                  <div class="property">
                    <a href="<?php echo $r->link_propiedad ?>">
                      <div class="property-image">
                        <?php if ($r->id_tipo_estado == 2) { ?>
                          <figure class="ribbon">Alquilado</figure>
                        <?php } else if ($r->id_tipo_estado == 4) { ?>
                          <figure class="ribbon">Reservado</figure>
                        <?php } else if ($r->id_tipo_estado == 3) { ?>
                          <figure class="ribbon">Vendido</figure>
                        <?php } ?>                        
                        <?php if (!empty($r->imagen)) { ?>
                          <img class="alto" src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                        <?php } else if (!empty($empresa->no_imagen)) { ?>
                          <img class="alto" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                        <?php } else { ?>
                          <img class="alto" src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
                        <?php } ?>
                      </div>
                      <div class="overlay">
                        <div class="info">
                          <div class="tag price"><?php echo ($r->precio_final != 0 && $r->publica_precio == 1) ? $r->moneda." ".number_format($r->precio_final,0) : "Consultar"; ?></div>
                          <h3><?php echo $r->nombre ?></h3>
                          <figure><?php echo $r->direccion_completa.", ".$r->localidad; ?></figure>
                        </div>
                        <ul class="additional-info">
                          <?php if (!empty($r->superficie_total)) { ?>
                          <li>
                            <header>Superficie:</header>
                            <figure><?php echo $r->superficie_total ?> m<sup>2</sup></figure>
                          </li>
                          <?php } ?>
                          <li>
                            <header>Habitaciones:</header>
                            <figure><?php echo (!empty($r->dormitorios)) ? $r->dormitorios : "-" ?></figure>
                          </li>
                          <li>
                            <header>Ba&ntilde;os:</header>
                            <figure><?php echo (!empty($r->banios)) ? $r->banios : "-" ?></figure>
                          </li>
                          <li>
                            <header>Cocheras:</header>
                            <figure><?php echo (!empty($r->cocheras)) ? $r->cocheras : "-" ?></figure>
                          </li>
                        </ul>
                      </div>
                    </a>
                  </div><!-- /.property -->
                </div>
                <?php } ?>
              </div>
            </div>
          </section>
          <?php } ?>
        <?php } ?>
        
          <?php
          $testimonios = $web_model->get_testimonios();
          if (sizeof($testimonios)>0) { ?>
          <section id="testimonials" class="block">
            <div class="container">
              <header class="section-title"><h2>Testimonios</h2></header>
              <div class="owl-carousel testimonials-carousel">
                <?php foreach($testimonios as $r) { ?>
                <blockquote class="testimonial">
                  <?php if (!empty($r->path)) { ?>
                  <figure>
                    <div class="image">
                      <img alt="<?php echo $r->nombre ?>" src="<?php echo $r->path ?>">
                    </div>
                  </figure>
                  <?php } ?>
                  <aside class="cite">
                    <p><?php echo $r->texto ?></p>
                    <footer><?php echo $r->nombre ?></footer>
                  </aside>
                </blockquote>
                <?php } ?>
              </div><!-- /.testimonials-carousel -->
            </div><!-- /.container -->
          </section>
          <?php } ?>
    <?php /*
    <section id="partners" class="block">
        <div class="container">
            <header class="section-title"><h2>Our Partners</h2></header>
            <div class="logos">
                <div class="logo"><a href=""><img src="assets/img/logo-partner-01.png" alt=""></a></div>
                <div class="logo"><a href=""><img src="assets/img/logo-partner-02.png" alt=""></a></div>
                <div class="logo"><a href=""><img src="assets/img/logo-partner-03.png" alt=""></a></div>
                <div class="logo"><a href=""><img src="assets/img/logo-partner-04.png" alt=""></a></div>
                <div class="logo"><a href=""><img src="assets/img/logo-partner-05.png" alt=""></a></div>
            </div>
        </div><!-- /.container -->
    </section><!-- /#partners -->
    */ ?>
  </div>
  <!-- end Page Content -->
  <?php include("includes/footer.php"); ?>
</div>
<script type="text/javascript" src="assets/js/custom.js?g=<?php echo rand(0,999) ?>"></script>
<div id="overlay"></div>
<script type="text/javascript">
$(window).load(function(){
  initializeOwl(false);
});
</script>
</body>
</html>