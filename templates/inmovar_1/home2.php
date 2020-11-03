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
<link rel="stylesheet" type="text/css" href="assets/css/slider-full.css">
<style type="text/css">

/* Backgorund Images */
 <?php 
$slider = $web_model->get_slider(array(
  "clave"=>"slider_1",
  )); ?>
<?php $x=1;foreach ($slider as $s) { ?>
.slide:<?php echo ($x==1)?"first-child":"nth-child(".$x.")" ?> {
  background: url('<?php echo $s->path ?>') no-repeat
    center top/cover;
}
<?php  $x++; }  ?>


</style>
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
     <div class="slider">
      <?php $x=1;foreach ($slider as $s) {  ?>
        <div class="slide <?php echo ($x==1)?"current":"" ?>">
        </div>
      <?php $x++; } ?>
    </div>
    <?php if (sizeof($slider) > 1) {  ?>
	    <div class="buttons">
	      <button id="prev"><i class="fas fa-arrow-left"></i></button>
	      <button id="next"><i class="fas fa-arrow-right"></i></button>
	    </div>
  	<?php } ?>
  <?php } ?>



  <!-- Search Box -->
  <div class="my-search-box">
    <div class="container text-center">
      <form onsubmit="return filtrar(this)" method="get" role="form" id="form_propiedades">
        <?php $t = $web_model->get_text("titulo-slider","Te ayudamos a vivir mejor") ?>
        <h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h2>
        <div class="col-md-3 p10">
          <?php $tipos_operaciones = $propiedad_model->get_tipos_operaciones()?>
          <select id="tipo_operacion" class="my-select">
            <?php $filter_tipos_operacion = $propiedad_model->get_tipos_operaciones();
            foreach($filter_tipos_operacion as $r) { ?>
              <option <?php echo ($nombre_pagina == $r->link) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
            <?php } ?>
          </select>    
        </div>
        <div class="col-md-3 p10">
          <select class="my-select" name="tp">
            <option value="0">Tipo de Propiedad</option>
            <?php $filter_tipos_propiedades = $propiedad_model->get_tipos_propiedades();
            foreach($filter_tipos_propiedades as $r) { ?>
              <option <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $r->id) ? "selected":"" ?> value="<?php echo $r->id ?>"><?php echo $r->nombre ?></option>
            <?php } ?>
          </select>  
        </div>
        <div class="col-md-4 p10">
          <input class="my-select" style="padding: 9px" type="text" name="cod" placeholder="Buscar por código" name="">
        </div>
        <div class="col-md-2 p10">
          <button type="submit" class="my-select button">BUSCAR</button>
        </div>
      </form>
    </div>  
  </div>
  

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
                            <img class="alto" src="/sistema/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                          <?php } else { ?>
                            <img class="alto" src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
                          <?php } ?>
                        </div>
                        <div class="overlay">
                          <div class="info">
                            <div class="tag price"><?php echo ($r->precio_final != 0 && $r->publica_precio == 1) ? $r->moneda." ".number_format($r->precio_final,0) : "Consultar"; ?></div>
                            <h3><?php echo $r->nombre ?></h3>
                            <figure><?php echo ($r->calle.(($empresa->mostrar_numeros_direccion_listado)?" N&deg; ".$r->altura:"")).", ".$r->localidad; ?></figure>
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
                          <img class="alto" src="/sistema/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                        <?php } else { ?>
                          <img class="alto" src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
                        <?php } ?>
                      </div>
                      <div class="overlay">
                        <div class="info">
                          <div class="tag price"><?php echo ($r->precio_final != 0 && $r->publica_precio == 1) ? $r->moneda." ".number_format($r->precio_final,0) : "Consultar"; ?></div>
                          <h3><?php echo $r->nombre ?></h3>
                          <figure><?php echo ($r->calle.(($empresa->mostrar_numeros_direccion_listado)?" N&deg; ".$r->altura:"")).", ".$r->localidad; ?></figure>
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
<script type="text/javascript">
const slides = document.querySelectorAll('.slide');
const next = document.querySelector('#next');
const prev = document.querySelector('#prev');
const auto = true; // Auto scroll
const intervalTime = 3000;
let slideInterval;

const nextSlide = () => {
  // Get current class
  const current = document.querySelector('.current');
  // Remove current class
  current.classList.remove('current');
  // Check for next slide
  if (current.nextElementSibling) {
    // Add current to next sibling
    current.nextElementSibling.classList.add('current');
  } else {
    // Add current to start
    slides[0].classList.add('current');
  }
  setTimeout(() => current.classList.remove('current'));
};

const prevSlide = () => {
  // Get current class
  const current = document.querySelector('.current');
  // Remove current class
  current.classList.remove('current');
  // Check for prev slide
  if (current.previousElementSibling) {
    // Add current to prev sibling
    current.previousElementSibling.classList.add('current');
  } else {
    // Add current to last
    slides[slides.length - 1].classList.add('current');
  }
  setTimeout(() => current.classList.remove('current'));
};

// Button events
next.addEventListener('click', e => {
  nextSlide();
  if (auto) {
    clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, intervalTime);
  }
});

prev.addEventListener('click', e => {
  prevSlide();
  if (auto) {
    clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, intervalTime);
  }
});

// Auto slide
if (auto) {
  // Run next slide at interval time
  slideInterval = setInterval(nextSlide, intervalTime);
}

</script>
<script>
function filtrar() { 
  var link = "<?php echo mklink("propiedades/")?>";
  var tipo_operacion = $("#tipo_operacion").val();
  link = link + tipo_operacion + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>
</body>
</html>