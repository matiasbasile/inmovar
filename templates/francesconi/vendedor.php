<?php
include 'includes/init.php';
$id_usuario = (isset($_GET["id"]) && !empty($_GET["id"])) ? intval($_GET["id"]) : 0;
$usuario = $usuario_model->get($id_usuario);

extract($propiedad_model->get_variables(array(
  "id_usuario" => $id_usuario,
  "no_analizar_url" => 1,
  "orden_default" => 8,
)));
if (isset($get_params["test"])) echo $propiedad_model->get_sql();
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">

<head>
  <?php include 'includes/head.php' ?>
  <style>
    .sobre-warp {
      height: 177px;
      width: 177px;
      border-radius: 50%;
    }

    .mis-inner [class*="col-"]:first-child {
      width: auto;
    }

    <?php if ($vc_total_resultados == 1) { ?>.noved_img {
      height: auto;
    }

    <?php } ?>
  </style>
</head>

<body>

  <!-- Francesconi Header Equipo -->

  <?php include 'includes/header.php' ?>

  <!-- Equipo Banner -->
  <section class="equipo-banner">
    <div class="container">
      <div class="equipo-content">
        <h1 class="banner-title">equipo</h1>
      </div>
    </div>
  </section>

  <!-- Equipo Sobre -->
  <section class="equipo-sobre">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="sobre-warp">
            <?php if (!empty($usuario->path)) { ?>
              <img src="<?php echo $usuario->path ?>" alt="Fran">
            <?php } ?>

            <div class="sobre-content">
              <h3><?php echo $usuario->nombre ?></h3>
              <?php if (!empty($usuario->cargo)) { ?>
                <p><?php echo $usuario->cargo ?></p>
              <?php } ?>
              <ul>
                <?php if (!empty($usuario->facebook)) { ?>
                  <li><a target="_blank" href="<?php echo $usuario->facebook ?>"><img src="assets/images/icons/facebook.png" alt="Facebook"></a></li>
                <?php } ?>
                <?php if (!empty($usuario->instagram)) { ?>
                  <li><a target="_blank" href="<?php echo $usuario->instagram ?>"><img src="assets/images/icons/insta.png" alt="Instagram"></a></li>
                <?php } ?>
                <?php if (!empty($usuario->linkedin)) { ?>
                  <li><a target="_blank" href="<?php echo $usuario->linkedin ?>"><img src="assets/images/icons/play.png" alt="Play"></a></li>
                <?php } ?>
                <?php if (!empty($usuario->telefono)) { ?>
                  <li><a target="_blank" href="https://wa.me/<?php echo $usuario->telefono ?>"><img src="assets/images/icons/icon-20.png" alt="Play"></a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="sobre-text">
            <h5>sobre mí</h5>
            <p><?php echo $usuario->titulo ?></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Equipo Mis -->
  <section class="equipo-mis">
    <div class="container">
      <div class="mis-content">
        <h2 class="small-title">mis propiedades <span><?php echo $vc_total_resultados ?> propiedades</span></h2>
      </div>
      <div class="mis-inner">
        <div class="row">
          <?php foreach ($vc_listado  as $propiedad) {
            item($propiedad);
          } ?>
        </div>

        <?php if ($vc_total_resultados > $vc_offset) { ?>
          <div class="d-block mt-5 mb40">
            <a onclick="cargar()" id="cargarMas" class="btn btn-primary btn-block btn-lg">ver más propiedades para tu búsqueda</a>
          </div>
        <?php } ?>

      </div>
    </div>
  </section>

  <?php include 'includes/footer.php' ?>
  <?php include("includes/cargar_mas_js.php"); ?>

</body>

</html>