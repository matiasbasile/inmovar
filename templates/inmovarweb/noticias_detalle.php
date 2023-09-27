<?php 
include("includes/init.php");
$id = $get_params["id"];
$entrada = $entrada_model->get($id);
if ($entrada === FALSE) header("Location: /");
$suf = $entrada->id_empresa."-".$entrada->id;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>

<div class="sub1-page">

<?php include("includes/header.php"); ?>

<!-- Top Banner -->
<div class="top-banner sub1-banner">
  <div class="container">
    <div class="banner-content">
      <?php $t = $web_model->get_text("pagina-titulo-$suf","Todo en un solo lugar!") ?>
      <h1 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h1>
      <?php $t = $web_model->get_text("pagina-subtitulo-$suf","Creá tu página web y comenzá a vender de manera simple y rápida,\n utilizando una plataforma de venta completa para tu negocio.") ?>      
      <div class="sub-title editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></div>
      <div class="btn-block">
        <?php $t = $web_model->get_text("pagina-boton-$suf","Creá tu tienda ahora") ?>
        <a class="btn btn-aquamarine editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" target="_blank" href="<?php echo mklink("web/registro/") ?>"><i class="fa fa-play-circle" aria-hidden="true"></i> <?php echo nl2br($t->plain_text) ?></a>
      </div>
      <?php $t = $web_model->get_text("pagina-prueba-$suf","Prueba gratís 14 días!") ?>
      <div class="trial-info editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text)?> <img src="images/grinning.png" alt="Grinning"></div>
    </div>
    <div class="left-img" data-aos="fade-up" data-aos-delay="500" data-aos-duration="500">
      <?php $t = $web_model->get_text("pagina-titulo-imagen-1-$suf","images/mobile-product-screen.png") ?>
      <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
    </div>
    <div class="dashboard-screen">
      <?php $t = $web_model->get_text("pagina-titulo-imagen-2-$suf","images/dashboard-screenshot1.png") ?>
      <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
    </div>
    <div class="right-bottom-img" data-aos="fade-up" data-aos-delay="1300" data-aos-duration="1300">
      <?php $t = $web_model->get_text("pagina-titulo-imagen-3-$suf","images/product-img4.png") ?>
      <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
    </div>
  </div>
</div>

<!-- Features Block -->
<div class="enterprise-block">
  <div class="features-block">
    <div class="features-listing">
      <div class="col-xl-6 col-lg-12">
        <div class="feature-info">
          <?php $t = $web_model->get_text("bloque-1-subtitulo-$suf","creá tu tienda online en minutos.") ?>
          <span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></span>
          <?php $t = $web_model->get_text("bloque-1-titulo-$suf","¿Tenés un emprendimiento y necesitas ordenarte?") ?>
          <h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h2>
          <?php $t = $web_model->get_text("bloque-1-texto-$suf","Creá tu tienda online y cargá tus productos desde tu computadora o tu celular. Configurá tu dominio propio y aplicá un diseño que refleje la imagen de tu marca con certificado SSL 100% gratis.") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
          <div class="row">
            <div class="col-md-6">
              <div class="info-list">
                <?php $t = $web_model->get_text("bloque-1-col1-texto1-$suf","Tus productos organizados con precio visible") ?>
                <h6 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h6>
                <?php $t = $web_model->get_text("bloque-1-col1-texto2-$suf","Tienda Nube ofrece una tienda online pensada para optimizar todos los pasos de la compra. Tus clientes podrán ver las fotos de los productos, descripciones y precios, y agregarlos al carrito de compras.") ?>
                <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-list">
                <?php $t = $web_model->get_text("bloque-1-col2-texto1-$suf","En cualquier tamaño de pantalla") ?>
                <h6 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h6>
                <?php $t = $web_model->get_text("bloque-1-col2-texto2-$suf","Tu sitio tiene que estar disponible en cualquier dispositivo. Nuestros diseños están pensados para atender a las necesidades de tus clientes y para ser visualizados en celulares, tablets y computadoras.") ?>
                <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-6 col-lg-12">
        <div class="screenshot-block" data-aos="fade-left" data-aos-delay="800" data-aos-duration="1000">
          <?php $t = $web_model->get_text("bloque-1-imagen-$suf","images/img1.png") ?>
          <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/trial.php") ?>

<!-- Features Block -->
<div class="enterprise-block take-business-product">
  <div class="features-block">
    <div class="features-listing">
    <div class="col-xl-7 col-lg-12">
      <div class="screenshot-block" data-aos="fade-left" data-aos-delay="800" data-aos-duration="1000">
        <?php $t = $web_model->get_text("bloque-2-imagen-$suf","images/girl-img.png") ?>
        <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
      </div>
    </div>
    <div class="col-xl-5 col-lg-12">
      <div class="feature-info">
        <?php $t = $web_model->get_text("bloque-2-subtitulo-$suf","creá tu tienda online en minutos.") ?>
        <span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></span>
        <?php $t = $web_model->get_text("bloque-2-titulo-$suf","Llevá tu negocio y tus productos a internet<") ?>
        <h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h2>
        <?php $t = $web_model->get_text("bloque-2-texto-$suf","Creá tu tienda online y cargá tus productos desde tu computadora o tu celular. Configurá tu dominio propio y aplicá un diseño que refleje la imagen de tu marca con certificado SSL 100% gratis.") ?>
        <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
        <div class="row">
          <div class="col-md-6">
            <div class="info-list">
              <?php $t = $web_model->get_text("bloque-2-col1-texto1-$suf","Tus productos organizados con precio visible") ?>
              <h6 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h6>
              <?php $t = $web_model->get_text("bloque-2-col1-texto2-$suf","Tienda Nube ofrece una tienda online pensada para optimizar todos los pasos de la compra. Tus clientes podrán ver las fotos de los productos, descripciones y precios, y agregarlos al carrito de compras.") ?>
              <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-list">
              <?php $t = $web_model->get_text("bloque-2-col2-texto1-$suf","En cualquier tamaño de pantalla") ?>
              <h6 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h6>
              <?php $t = $web_model->get_text("bloque-2-col2-texto2-$suf","Tu sitio tiene que estar disponible en cualquier dispositivo. Nuestros diseños están pensados para atender a las necesidades de tus clientes y para ser visualizados en celulares, tablets y computadoras.") ?>
              <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>

<!-- Services Block -->
<div class="services-block">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="section-title">
          <?php $t = $web_model->get_text("caracteristicas-titulo-$suf","diseñado para simplificar la administración diaria de tu negocio") ?>
          <h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h3>
          <?php $t = $web_model->get_text("caracteristicas-subtitulo-$suf","Funcionalidades que hacen la diferencia") ?>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h4>
        </div>  
      </div>
      <div class="col-xl-4 col-lg-12">
        <div class="service-box" data-aos="fade-right" data-aos-delay="800" data-aos-duration="800">
          <div class="service-icon">
            <?php $t = $web_model->get_text("caracteristicas-1-titulo-$suf","images/service-icon6.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
          </div>
          <?php $t = $web_model->get_text("caracteristicas-1-titulo-$suf","Ventas") ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="service-title editable"><?php echo nl2br($t->plain_text) ?></div>
          <?php $t = $web_model->get_text("caracteristicas-1-texto-$suf","Gestioná tus ventas pendientes, cobradas y vencidas. Facturá desde el sistema. Importa tus ordenes de MercadoLibre automáticamente.") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-xl-4 col-lg-12">
        <div class="service-box" data-aos="fade-down" data-aos-delay="1000" data-aos-duration="1000">
          <div class="service-icon">
            <?php $t = $web_model->get_text("caracteristicas-2-titulo-$suf","images/service-icon7.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
          </div>
          <?php $t = $web_model->get_text("caracteristicas-2-titulo-$suf","Compras") ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="service-title editable"><?php echo nl2br($t->plain_text) ?></div>
          <?php $t = $web_model->get_text("caracteristicas-2-texto-$suf","Gestioná las compras a tus proveedores y controlá su estado. Segmentalas en categorías creadas a medida.") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-xl-4 col-lg-12">
        <div class="service-box" data-aos="fade-left" data-aos-delay="1300" data-aos-duration="1300">
          <div class="service-icon">
            <?php $t = $web_model->get_text("caracteristicas-3-titulo-$suf","images/service-icon8.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
          </div>
          <?php $t = $web_model->get_text("caracteristicas-3-titulo-$suf","Stock") ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="service-title editable"><?php echo nl2br($t->plain_text) ?></div>
          <?php $t = $web_model->get_text("caracteristicas-3-texto-$suf","100% dinámico, se actualiza al comprar o vender productos. Llevá tu inventario segmentado por categorías.") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-xl-4 col-lg-12">
        <div class="service-box" data-aos="fade-right" data-aos-delay="800" data-aos-duration="800">
          <div class="service-icon">
            <?php $t = $web_model->get_text("caracteristicas-4-titulo-$suf","images/service-icon9.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
          </div>
          <?php $t = $web_model->get_text("caracteristicas-4-titulo-$suf","Cobranzas") ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="service-title editable"><?php echo nl2br($t->plain_text) ?></div>
          <?php $t = $web_model->get_text("caracteristicas-4-texto-$suf","Cobrá tus ventas utilizando cuentas de efectivo, bancos, tarjetas y cheques. Realizá un seguimiento de tus cuentas a cobrar.") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-xl-4 col-lg-12">
        <div class="service-box" data-aos="fade-down" data-aos-delay="1000" data-aos-duration="1000">
          <div class="service-icon">
            <?php $t = $web_model->get_text("caracteristicas-5-titulo-$suf","images/service-icon10.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
          </div>
          <?php $t = $web_model->get_text("caracteristicas-5-titulo-$suf","Pagos") ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="service-title editable"><?php echo nl2br($t->plain_text) ?></div>
          <?php $t = $web_model->get_text("caracteristicas-5-texto-$suf","Gestioná el pago de tus compras con cuentas de efectivo, bancos, tarjetas, cheques de terceros y/o propios.") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-xl-4 col-lg-12">
        <div class="service-box" data-aos="fade-left" data-aos-delay="1300" data-aos-duration="1300">
          <div class="service-icon">
            <?php $t = $web_model->get_text("caracteristicas-6-titulo-$suf","images/service-icon2.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
          </div>
          <?php $t = $web_model->get_text("caracteristicas-6-titulo-$suf","Informes") ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="service-title editable"><?php echo nl2br($t->plain_text) ?></div>
          <?php $t = $web_model->get_text("caracteristicas-6-texto-$suf","Conocé el detalle de ventas por cliente y/o producto. Reporte de cuentas a cobrar y a pagar. Conocé el estado actual de tu empresa.") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-xl-4 col-lg-12">
        <div class="service-box" data-aos="fade-right" data-aos-delay="800" data-aos-duration="800">
          <div class="service-icon">
            <?php $t = $web_model->get_text("caracteristicas-7-titulo-$suf","images/service-icon11.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
          </div>
          <?php $t = $web_model->get_text("caracteristicas-7-titulo-$suf","Gestión de productos") ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="service-title editable"><?php echo nl2br($t->plain_text) ?></div>
          <?php $t = $web_model->get_text("caracteristicas-7-texto-$suf","Administrá tus productos en cuestión de minutos. Utilizá la carga masiva para hacer modificaciones o crear nuevos productos.") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-xl-4 col-lg-12">
        <div class="service-box" data-aos="fade-down" data-aos-delay="1000" data-aos-duration="1000">
          <div class="service-icon">
            <?php $t = $web_model->get_text("caracteristicas-8-titulo-$suf","images/service-icon12.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
          </div>
          <?php $t = $web_model->get_text("caracteristicas-8-titulo-$suf","Medios de pago") ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="service-title editable"><?php echo nl2br($t->plain_text) ?></div>
          <?php $t = $web_model->get_text("caracteristicas-8-texto-$suf","Variados medios de pago integrados a tu tienda online: Mercado Pago, PayU, Todo Pago y PayPal a través de un checkout transparente.") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
        </div>
      </div>
      <div class="col-xl-4 col-lg-12">
        <div class="service-box" data-aos="fade-left" data-aos-delay="1300" data-aos-duration="1300">
          <div class="service-icon">
            <?php $t = $web_model->get_text("caracteristicas-9-titulo-$suf","images/service-icon13.png") ?>
            <img data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable editable-img" src="<?php echo $t->plain_text ?>" alt="<?php echo $empresa->nombre ?>">
          </div>
          <?php $t = $web_model->get_text("caracteristicas-9-titulo-$suf","Medios de envío") ?>
          <div data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="service-title editable"><?php echo nl2br($t->plain_text) ?></div>
          <?php $t = $web_model->get_text("caracteristicas-9-texto-$suf","Enviá a la Argentina y a todo el mundo con OCA, Correo Argentino o la empresa de tu preferencia, o configurá retiro por el local.") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Success Stories -->
<?php include("includes/casos.php"); ?>

<!-- We Do For You -->
<?php include("includes/nosotros.php"); ?>

<!-- Footer -->
<?php include("includes/footer.php"); ?>
</div>
</html> 