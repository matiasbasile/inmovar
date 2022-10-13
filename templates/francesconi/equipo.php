<?php include 'includes/init.php' ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
  <?php include 'includes/head.php' ?>
</head>

<body>

  <?php include 'includes/header.php'; ?>

  <section class="equipo-banner equo">
    <div class="container">
      <div class="equipo-content">
        <h1 class="banner-title">equipo</h1>
      </div>
    </div>
  </section>

  <section class="equo-con">
    <div class="container">
      <div class="equo-con-title">
        <h2 class="color-title">conoce a nuestro</h2>
        <h3 class="small-title">equipo</h3>
      </div>
      <div class="con-inner">
        <div class="row g-0">
          <div class="col-lg-6">
            <div class="con-warp">
              <?php $t = $web_model->get_text("equipo_imagen"); ?>
              <img class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $t->id_empresa ?>" src="<?php echo $t->plain_text ?>" alt="Con">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="con-content">
              <div>
                <?php $t = $web_model->get_text("equipo_texto_1","somos una inmobiliaria joven"); ?>
                <h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $t->id_empresa ?>">
                  <?php echo $t->plain_text ?>
                </h3>
                <h4>francesconi</h4>
                <?php $t = $web_model->get_text("equipo_texto_2","Más de 10 años trabajando juntos"); ?>
                <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $t->id_empresa ?>">
                  <?php echo $t->plain_text ?>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="con-text">
          <?php $t = $web_model->get_text("equipo_texto_3"); ?>
          <h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $t->id_empresa ?>">
            <?php echo $t->plain_text ?>
          </h3>
          <?php $t = $web_model->get_text("equipo_texto_4"); ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $t->id_empresa ?>">
            <?php echo $t->plain_text ?>
          </p>
        </div>
      </div>
    </div>
  </section>

  <?php 
  $usuarios = $usuario_model->get_list(array(
    "aparece_web" => 1,
    "order_by" => 1
  ));
  if (!empty($usuarios)) { ?>
    <section class="fran-section">
      <div class="container">
        <div class="row">
          <?php foreach ($usuarios as $e) { ?>
            <div class="col-xl-3 col-md-6">
              <div class="fran-card">
                <?php if (!empty($e->path)) { ?>
                  <a href="<?php echo mklink("web/vendedor/")."?id=".$e->id ?>">
                    <img src="<?php echo $e->path ?>" alt="Fran">
                  </a>
                <?php } ?>
                <div class="fran-content">
                  <h3><a href="<?php echo mklink("web/vendedor/")."?id=".$e->id ?>"><?php echo $e->nombre ?></a></h3>
                  <?php if (!empty($e->cargo)) { ?>
                    <p><?php echo $e->cargo ?></p>
                  <?php } ?>
                  <div class="fran-socials">
                    <ul>
                      <?php if (!empty($e->celular)) { ?>
                        <li><a href="https://wa.me/<?php echo $e->celular_f ?>"><img src="assets/images/icons/icon-20.png" alt="Icon"><?php echo "+" . $e->celular ?></a></li>
                      <?php } ?>
                      <?php if (!empty($e->email)) { ?>
                        <li><a href="mailto:<?php echo $e->email ?>"><img src="assets/images/icons/icon-21.png" alt="Icon"><span><?php echo $e->email ?></span></a></li>
                      <?php } ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </section>
  <?php } ?>

  <?php include 'includes/contacto.php' ?>

  <?php include 'includes/home/secondary_slider.php' ?>

  <?php include 'includes/footer.php' ?>

</body>

</html>