<?php include("includes/init.php"); ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>

<?php include("includes/header.php"); ?>

<!-- Top Banner -->
<div class="top-banner">
  <div class="container">
    <div class="banner-content">
      <?php $t = $web_model->get_text("home-titulo","Todo en un solo lugar!") ?>
      <h1 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></h1>
      <?php $t = $web_model->get_text("home-subtitulo","Creá tu página web y comenzá a vender de manera simple y rápida,<br> utilizando una plataforma de venta completa para tu negocio.") ?>
      <div class="sub-title editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></div>
      <div class="btn-block">
        <?php $t = $web_model->get_text("home-boton","Creá tu tienda ahora") ?>
        <a class="btn btn-aquamarine editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" href="<?php echo mklink("web/registro/") ?>"><i class="fa fa-play-circle" aria-hidden="true"></i> <?php echo ($t->plain_text) ?></a>
      </div>
      <?php $t = $web_model->get_text("home-prueba-gratis","Prueba gratís 14 días!") ?>
      <div class="trial-info editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?> <img src="images/grinning.png" alt="Grinning"></div>
    </div>
    <div class="left-img" data-aos="fade-up" data-aos-delay="500" data-aos-duration="500">
      <?php $t = $web_model->get_text("home-imagen-1","images/product-img.png") ?>
      <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $tt->plain_text ?>">
    </div>
    <div class="device-img">
      <div class="video-block">
        <img src="images/screen-main.jpg" alt="Inmovar Dashboard">
        <?php /*
        <div class="play-btn">
          <div class="table-container">
            <div class="align-container">
              <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal"><i class="fa fa-play" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
        */ ?>
      </div>
    </div>
    <div class="right-top-img" data-aos="fade-up" data-aos-delay="1000" data-aos-duration="1000">
      <?php $t = $web_model->get_text("home-imagen-2","images/product-img2.png") ?>
      <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $tt->plain_text ?>">
    </div>
    <div class="right-bottom-img" data-aos="fade-up" data-aos-delay="1300" data-aos-duration="1300">
      <?php $t = $web_model->get_text("home-imagen-3","images/product-img3.png") ?>
      <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $tt->plain_text ?>">
    </div>
  </div>
</div>

<!-- Services Block -->
<div id="caracteristicas" class="services-block">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-12">
        <div class="service-box" data-aos="fade-right" data-aos-delay="800" data-aos-duration="800">
          <?php $tt = $web_model->get_text("home-caracteristica-titulo-1","Tienda web") ?>
          <div class="service-icon">
            <?php $t = $web_model->get_text("home-caracteristica-imagen-1","images/service-icon1.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $tt->plain_text ?>">
          </div>
          <div data-clave="<?php echo $tt->clave ?>" data-id="<?php echo $tt->id ?>" class="editable service-title"><?php echo ($tt->plain_text) ?></div>
          <?php $t = $web_model->get_text("home-caracteristica-subtitulo-1","Sitio web responsive en minutos \nlisto para vender!") ?>
          <p data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo ($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-lg-4 col-md-12">
        <div class="service-box" data-aos="fade-down" data-aos-delay="1000" data-aos-duration="1000">
          <?php $tt = $web_model->get_text("home-caracteristica-titulo-2","Gestión y facturación electrónica") ?>
          <div class="service-icon">
            <?php $t = $web_model->get_text("home-caracteristica-imagen-2","images/service-icon2.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $tt->plain_text ?>">
          </div>
          <div data-clave="<?php echo $tt->clave ?>" data-id="<?php echo $tt->id ?>" class="editable service-title"><?php echo ($tt->plain_text) ?></div>
          <?php $t = $web_model->get_text("home-caracteristica-subtitulo-2","Sitio web responsive en minutos \nlisto para vender!") ?>
          <p data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo ($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-lg-4 col-md-12">
        <div class="service-box" data-aos="fade-left" data-aos-delay="1300" data-aos-duration="1300">
          <?php $tt = $web_model->get_text("home-caracteristica-titulo-3","Sincronización con\n Mercado Libre") ?>
          <div class="service-icon">
            <?php $t = $web_model->get_text("home-caracteristica-imagen-3","images/service-icon3.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $tt->plain_text ?>">
          </div>
          <div data-clave="<?php echo $tt->clave ?>" data-id="<?php echo $tt->id ?>" class="editable service-title"><?php echo ($tt->plain_text) ?></div>
          <?php $t = $web_model->get_text("home-caracteristica-subtitulo-3","Sitio web responsive en minutos \nlisto para vender!") ?>
          <p data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo ($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-lg-4 col-md-12">
        <div class="service-box" data-aos="fade-right" data-aos-delay="800" data-aos-duration="800">
          <?php $tt = $web_model->get_text("home-caracteristica-titulo-4","Sincronización con\n Mercado Libre") ?>
          <div class="service-icon">
            <?php $t = $web_model->get_text("home-caracteristica-imagen-4","images/service-icon111.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $tt->plain_text ?>">
          </div>
          <div data-clave="<?php echo $tt->clave ?>" data-id="<?php echo $tt->id ?>" class="editable service-title"><?php echo ($tt->plain_text) ?></div>
          <?php $t = $web_model->get_text("home-caracteristica-subtitulo-4","Sitio web responsive en minutos \nlisto para vender!") ?>
          <p data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo ($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-lg-4 col-md-12">
        <div class="service-box" data-aos="fade-down" data-aos-delay="1000" data-aos-duration="1000">
          <?php $tt = $web_model->get_text("home-caracteristica-titulo-5","Sincronización con\n Mercado Libre") ?>
          <div class="service-icon">
            <?php $t = $web_model->get_text("home-caracteristica-imagen-5","images/service-icon112.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $tt->plain_text ?>">
          </div>
          <div data-clave="<?php echo $tt->clave ?>" data-id="<?php echo $tt->id ?>" class="editable service-title"><?php echo ($tt->plain_text) ?></div>
          <?php $t = $web_model->get_text("home-caracteristica-subtitulo-5","Sitio web responsive en minutos \nlisto para vender!") ?>
          <p data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo ($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-lg-4 col-md-12">
        <div class="service-box" data-aos="fade-left" data-aos-delay="1300" data-aos-duration="1300">
          <?php $tt = $web_model->get_text("home-caracteristica-titulo-6","Sincronización con\n Mercado Libre") ?>
          <div class="service-icon">
            <?php $t = $web_model->get_text("home-caracteristica-imagen-6","images/service-icon113.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $tt->plain_text ?>">
          </div>
          <div data-clave="<?php echo $tt->clave ?>" data-id="<?php echo $tt->id ?>" class="editable service-title"><?php echo ($tt->plain_text) ?></div>
          <?php $t = $web_model->get_text("home-caracteristica-subtitulo-6","Sitio web responsive en minutos \nlisto para vender!") ?>
          <p data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo ($t->plain_text) ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="features-block">
  <div class="features-listing">
    <div class="col-lg-5 col-md-12">
      <div class="feature-info">
        <?php $t = $web_model->get_text("seccion-1-subtitulo","tienda web") ?>
        <span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></span>
        <?php $t = $web_model->get_text("seccion-1-titulo","Fácil, rápido y en solo un click!") ?>
        <h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></h2>
        <?php $t = $web_model->get_text("seccion-1-texto","Una tienda online, todos los canales de venta Vendé más con una plataforma de ecommerce completa e intuitiva.") ?>
        <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></p>
        <?php /*<a href="<?php echo $t->link ?>"><i class="fa fa-play" aria-hidden="true"></i> leer más</a>*/?>
      </div>
    </div>
    <div class="col-lg-7 col-md-12">
      <div class="screenshot-block" data-aos="fade-left" data-aos-delay="800" data-aos-duration="1000">
        <?php $t = $web_model->get_text("seccion-1-imagen","images/products-screenshot.png") ?>
        <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
      </div>
    </div>
  </div>
</div>

<div class="features-block alternative">
  <div class="features-listing">    
    <div class="col-lg-7 col-md-12 order-lg-1 order-md-2 order-2">
      <div class="screenshot-block" data-aos="fade-right" data-aos-delay="800" data-aos-duration="1000">
        <?php $t = $web_model->get_text("seccion-2-imagen","images/features-screenshot.png") ?>
        <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
      </div>
    </div>
    <div class="col-lg-5 col-md-12 order-lg-2 order-md-1 order-1">
      <div class="feature-info">
        <?php $t = $web_model->get_text("seccion-2-subtitulo","gestión en la nube") ?>
        <span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></span>
        <?php $t = $web_model->get_text("seccion-2-titulo","Gestión y \nfacturación.") ?>
        <h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></h2>
        <?php $t = $web_model->get_text("seccion-2-texto","Accedé a un sitio web responsive fácilmente editable para que puedas configurar colores y logo de tu negocio.") ?>
        <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></p>
        <?php /*<a href="<?php echo $t->link ?>"><i class="fa fa-play" aria-hidden="true"></i> leer más</a>*/?>
      </div>
    </div>
  </div>
</div>

<?php include("includes/trial.php"); ?>

<div class="features-block pd-less">
  <div class="features-listing">
    <div class="col-lg-5 col-md-12">
      <div class="feature-info">
        <?php $t = $web_model->get_text("seccion-3-subtitulo","potencia tus ventas") ?>
        <span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></span>
        <?php $t = $web_model->get_text("seccion-3-titulo","Sincronización\n con Mercado Libre") ?>
        <h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></h2>
        <?php $t = $web_model->get_text("seccion-3-texto","Accedé a un sitio web responsive fácilmente editable para que puedas configurar colores y logo de tu negocio.") ?>
        <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></p>
        <?php /*<a href="<?php echo $t->link ?>"><i class="fa fa-play" aria-hidden="true"></i> leer más</a>*/?>
      </div>
    </div>
    <div class="col-lg-7 col-md-12">
      <div class="screenshot-block" data-aos="fade-left" data-aos-delay="800" data-aos-duration="1000">
        <?php $t = $web_model->get_text("seccion-2-imagen","images/dashboard-screenshot.png") ?>
        <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
      </div>
    </div>
  </div>
</div>

<!-- Success Stories -->
<?php include("includes/casos.php"); ?>

<!-- We Do For You -->
<?php include("includes/nosotros.php"); ?>

<?php include("includes/faq.php") ?>

<!-- Footer -->
<?php include("includes/footer.php"); ?>


<style type="text/css">
#modal_close { background-color: black; border-radius: 100%; padding: 3px; line-height: 26px; width: 32px; text-align: center; opacity: 1; position: absolute; right: 10px; top: 10px; font-size: 18px; z-index: 999; color: white; } 
</style>

<!-- Vido Popup -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <button id="modal_close" onclick="cerrar_modal()" type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
      <div class="modal-body">
        <img src="images/screen-main.jpg" width="100%" alt="Inmovar Dashboard">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(window).load(function(){
  /*
  setTimeout(function(){
    $("#myModal").modal('show');
  },5000);
  */
});
function cerrar_modal() {
  $('#myModal').modal('hide');
}
</script>

</html> 