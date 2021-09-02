<?php include ("includes/init.php");?>
<?php $page_act = "home" ?>
<!DOCTYPE html>
<html>
<head>
  <?php include ("includes/head.php");?>
</head>
<body>

<?php include ("includes/header.php");?>

<?php $slider = $web_model->get_slider(array("offset"=>"1")); 
if (sizeof($slider)>0) { ?>
  <section id="ts-hero" class="text-center mb-0">
    <?php $ss = $slider[0]; ?>
    <div class="ts-full-screen ts-center__both <?php echo (!empty($ss->linea_1) ? "sombreado" : "") ?>" style="background-image: url(<?php echo $slider[0]->path;?>); background-size: cover;">
      <div class="container py-2 py-sm-5 pr">
        <?php if (!empty($ss->linea_1)) { ?>
          <h1 class="mb-2 text-white slider-h1">
            <?php echo $ss->linea_1 ?>
          </h1>
        <?php } ?>
        <?php if (!empty($ss->linea_2)) { ?>
          <h4 class="text-white">
            <?php echo $ss->linea_2 ?>
          </h4>
        <?php } ?>
        
        <?php include "includes/buscador.php" ?>
      </div>
    </div>

  </section>
<?php } ?>

<main id="ts-main">

  <?php 
  $destacadas = $propiedad_model->destacadas(array("offset" => "3"));
  if (sizeof($destacadas)>0) { ?>
    <section id="featured-properties" class="ts-block pt-5">
      <div class="container">

        <!--Title-->
        <div class="ts-title text-center">
          <h2>Propiedades Destacadas</h2>
        </div>

        <div class="row">
          <?php foreach ($destacadas as $p) { ?>
          <div class="col-sm-6 col-lg-4">

            <div class="card ts-item ts-card ts-item__lg">

              <!--Ribbon-->
              <div class="ts-ribbon">
                <i class="fa fa-thumbs-up"></i>
              </div>

              <!--Card Image-->
              <a href="<?php echo mklink("$p->link")?>" class="card-img ts-item__image" data-bg-image="<?php echo $p->imagen;?>">
                <div class="ts-item__info-badge">
                  <?php echo $p->precio;?>
                </div>
                <figure class="ts-item__info">
                  <h4><?php echo $p->nombre;?></h4>
                  <aside>
                    <i class="fa fa-map-marker mr-2"></i>
                      <?php echo ($p->direccion_completa) ?>
                  </aside>
                </figure>
              </a>

              <!--Card Body-->
              <div class="card-body">
                <div class="ts-description-lists">
                  <dl>
                    <dt>Sup.</dt>
                    <dd><?php echo (!empty($p->superficie)) ? $p->superficie : "-" ?></dd>
                  </dl>
                  <dl>
                    <dt>Dormitorios</dt>
                    <dd><?php echo (!empty($p->dormitorios)) ? $p->dormitorios : "-" ?></dd>
                  </dl>
                  <dl>
                    <dt>Baños</dt>
                    <dd><?php echo (!empty($p->banios)) ? $p->banios : "-" ?></dd>
                  </dl>
                </div>
              </div>

              <a href="<?php echo mklink("$p->link")?>" class="card-footer">
                <span class="ts-btn-arrow">Ver más</span>
              </a>
            </div>
          </div>
          <?php } ?>

        </div>
        <div class="text-center mt-3">
          <a href="<?php echo mklink("propiedades/")?>" class="btn btn-outline-dark ts-btn-border-muted">Ver todas las propiedades</a>
        </div>

      </div>
    </section>
  <?php } ?>

  <!-- FEATURES
  =============================================================================================================-->
  <section class="ts-block bg-white">
    <div class="container py-4">
      <div class="row">

        <!--Feature-->
        <div class="col-sm-6 col-md-3">
          <div class="ts-feature">

            <figure class="ts-feature__icon p-2">
              <span class="ts-circle">
                <i class="fa fa-check"></i>
              </span>
              <img src="assets/img/icon-house.png" alt="">
            </figure>
            <?php $t = $web_model->get_text("inmovar_7_h4_1","Find a Nice Place To Live")?>
            <h4 class="editable" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" >
              <?php echo $t->plain_text ?>
            </h4>
            <?php $t = $web_model->get_text("inmovar_7_p_1","Find a Nice Place To Live")?>
            <p class="editable" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" ><?php echo $t->plain_text?></p>

          </div>
        </div>

        <!--Feature-->
        <div class="col-sm-6 col-md-3">
          <div class="ts-feature">

            <figure class="ts-feature__icon p-2">
              <span class="ts-circle">
                <i class="fa fa-check"></i>
              </span>
              <img src="assets/img/icon-pin.png" alt="">
            </figure>

            <?php $t = $web_model->get_text("inmovar_7_h4_2","Find a Nice Place To Live")?>
            <h4 class="editable" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" >
              <?php echo $t->plain_text ?>
            </h4>
            <?php $t = $web_model->get_text("inmovar_7_p_2","Find a Nice Place To Live")?>
            <p class="editable" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" ><?php echo $t->plain_text?></p>

          </div>
        </div>

        <!--Feature-->
        <div class="col-sm-6 col-md-3">
          <div class="ts-feature">

            <figure class="ts-feature__icon p-2">
              <span class="ts-circle">
                <i class="fa fa-check"></i>
              </span>
              <img src="assets/img/icon-agent.png" alt="">
            </figure>

            <?php $t = $web_model->get_text("inmovar_7_h4_3","Find a Nice Place To Live")?>
            <h4 class="editable" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" >
              <?php echo $t->plain_text ?>
            </h4>
            <?php $t = $web_model->get_text("inmovar_7_p_3","Find a Nice Place To Live")?>
            <p class="editable" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" ><?php echo $t->plain_text?></p>

          </div>
        </div>

        <!--Feature-->
        <div class="col-sm-6 col-md-3">
          <div class="ts-feature">

            <figure class="ts-feature__icon p-2">
              <span class="ts-circle">
                <i class="fa fa-check"></i>
              </span>
              <img src="assets/img/icon-calculator.png" alt="">
            </figure>

            <?php $t = $web_model->get_text("inmovar_7_h4_4","Find a Nice Place To Live")?>
            <h4 class="editable" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" >
              <?php echo $t->plain_text ?>
            </h4>
            <?php $t = $web_model->get_text("inmovar_7_p_4","Find a Nice Place To Live")?>
            <p class="editable" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" ><?php echo $t->plain_text?></p>

          </div>
        </div>

      </div>
      <!--end row-->
    </div>
    <!--end container-->
  </section>
  
  <?php $ultimas = $propiedad_model->ultimas(array("offset"=>4));
  if (sizeof($ultimas)>0) { ?>
    <section id="latest-listings" class="ts-block">
      <div class="container">
        <div class="ts-title">
          <h2>Ultimas Propiedades</h2>
        </div>
        <div class="row">
          <?php foreach ($ultimas as $p) { ?>
            <div class="col-sm-6 col-lg-3">
              <div class="card ts-item ts-card">
                <?php if ($p->destacado==1){?>
                  <div class="ts-ribbon">
                    <i class="fa fa-thumbs-up"></i>
                  </div>
                <?php }?>
                <a href="<?php echo mklink ("$p->link");?>" class="card-img ts-item__image" data-bg-image="<?php echo $p->imagen;?>">
                  <div class="ts-item__info-badge">
                    <?php echo $p->precio;?>
                  </div>
                  <figure class="ts-item__info">
                    <h4><?php echo $p->nombre;?></h4>
                    <aside>
                      <i class="fa fa-map-marker mr-2"></i>
                      <?php echo ($p->direccion_completa) ?>
                    </aside>
                  </figure>
                </a>
                <div class="card-body">
                  <div class="ts-description-lists">
                    <dl>
                      <dt>Sup.</dt>
                      <dd><?php echo (!empty($p->superficie)) ? $p->superficie : "-" ?></dd>
                    </dl>
                    <dl>
                      <dt>Dormitorios</dt>
                      <dd><?php echo (!empty($p->dormitorios)) ? $p->dormitorios : "-" ?></dd>
                    </dl>
                    <dl>
                      <dt>Baños</dt>
                      <dd><?php echo (!empty($p->banios)) ? $p->banios : "-" ?></dd>
                    </dl>
                  </div>
                </div>
                <a href="<?php echo mklink("$p->link");?>" class="card-footer">
                  <span class="ts-btn-arrow">Ver más</span>
                </a>
              </div>
            </div>
          <?php } ?>
        </div>
        <!--end row-->
      </div>
      <!--end container-->
    </section>
  <?php } ?>


  <!--ITEM CAROUSEL
  =============================================================================================================-->
  <?php /* 
  <section id="submit-banner" class="ts-block">
    <div class="container">

      <div class="ts-block-inside text-center ts-separate-bg-element text-white" data-bg-image-opacity=".4" data-bg-image="assets/img/bg-chair.jpg" data-bg-color="#000">
        <figure class="h1 font-weight-light mb-2">Have Some Property For Sale?</figure>
        <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
        <a href="submit.html" class="btn btn-light">Submit Your Own</a>
      </div>

    </div>
  </section>
  <section id="partners" class="ts-block pt-4 pb-0">
    <div class="container">

      <!--Logos-->
      <div class="d-block d-md-flex justify-content-between align-items-center text-center ts-partners py-3">

        <a href="#">
          <img src="assets/img/logo-01.png" alt="">
        </a>

        <a href="#">
          <img src="assets/img/logo-02.png" alt="">
        </a>

        <a href="#">
          <img src="assets/img/logo-03.png" alt="">
        </a>

        <a href="#">
          <img src="assets/img/logo-04.png" alt="">
        </a>

        <a href="#">
          <img src="assets/img/logo-05.png" alt="">
        </a>

      </div>
    </div>
  </section>
  */?>
</main>
<?php include ("includes/footer.php");?>
</body>