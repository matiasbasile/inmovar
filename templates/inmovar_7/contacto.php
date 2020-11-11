<?php include ("includes/init.php");?>
<?php $page_act = "contacto" ?>
<!DOCTYPE html>
<html>
<head>
<?php include ("includes/head.php");?>
</head>
<body>

<?php include ("includes/header.php");?>

<main id="ts-main">

  <div class="ts-bokeh-background"><canvas id="ts-canvas"></canvas></div>    

  <section id="page-title">
    <div class="container">
      <div class="ts-title">
        <h1>Contacto</h1>
      </div>
    </div>
  </section>
  <section id="map-address">
    <div class="container mb-5">
      <div class="ts-contact-map ts-map ts-shadow__sm position-relative">
        <address class="position-absolute ts-bottom__0 ts-left__0 text-white m-3 p-4 ts-z-index__2" data-bg-color="rgba(0,0,0,.8)">
          <?php 
          echo $empresa->direccion."<br/>";
          if (!empty($empresa->ciudad)) echo $empresa->ciudad."<br/>";
          if (!empty($empresa->codigo_postal)) echo "CP: ".$empresa->codigo_postal;
          ?>
        </address>
        <div id="ts-map-simple" class="h-100 ts-z-index__1"
          data-ts-map-leaflet-provider="https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png"
          data-ts-map-zoom="<?php echo $empresa->zoom?>"
          data-ts-map-center-latitude="<?php echo $empresa->latitud?>"
          data-ts-map-center-longitude="<?php echo $empresa->longitud?>"
          data-ts-map-scroll-wheel="1"
          data-ts-map-controls="0">
        </div>
      </div>
    </div>
  </section>
  <section id="contact-form">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h3>Contactate</h3>
          <div class="ts-box">
            <?php $t = $web_model->get_text("inmovar_7_p_contacto","Find a Nice Place To Live")?>
            <p class="editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" ><?php echo $t->plain_text?></p>
            <figure class="ts-center__vertical">
              <?php if (!empty($empresa->telefono)){?>
                <i class="fa fa-phone ts-opacity__50 mr-3 mb-0 h4 font-weight-bold"></i>
                <dl class="mb-0">
                  <dt>Teléfono</dt>
                  <dd class="ts-opacity__50"><?php echo $empresa->telefono;?></dd>
                </dl>
              <?php }?>
            </figure>
            <figure class="ts-center__vertical">
              <i class="fa fa-envelope ts-opacity__50 mr-3 mb-0 h4 font-weight-bold"></i>
              <dl class="mb-0">
                <dt>Email</dt>
                <dd class="ts-opacity__50">
                  <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email;?></a>
                </dd>
              </dl>
            </figure>
          </div>
        </div>
        <div class="col-md-8">
          <h3>Formulario de Contacto</h3>
          <?php include("includes/form_contacto.php"); ?>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include ("includes/footer.php");?>

</body>
</html>