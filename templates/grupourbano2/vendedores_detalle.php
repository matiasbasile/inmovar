<?php
include_once("includes/init.php");
$nombre_pagina = "Nosotros";
include_once("includes/funciones.php");
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
  <?php include("includes/head.php"); ?>

</head>

<body class="bg-gray">
  <?php include("includes/header.php") ?>

  <!-- lising -->
  <?php if (isset($_GET["id_usuario"]) && !empty($_GET["id_usuario"])) { ?>
    <?php $usuario = $usuario_model->get($_GET["id_usuario"]); ?>
    <?php $listado = $propiedad_model->get_list(array("id_usuario" => $_GET["id_usuario"])); ?>
  <?php } ?>
  <section class="padding-default vendedores-list">
    <div class="container style-two">
      <div class="row">
        <div class="col-md-9">
          <div class="page-heading">
            <?php $nombre = explode(" ", $usuario->nombre) ?>
            <h2>Propiedades de <?php echo $nombre[0] ?></h2>
            <h6>Se encontraron <b><?php echo sizeof($listado) ?></b> propiedades</h6>
          </div>
          <div class="mt-4">
            <div class="row">
              <div class="col-md-8">
                <p class="mt-1 text-18">Ordenar propiedades por:</p>
                <select class="form-control form-primary">
                  <option>propiedades destacadas</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-map-marker mr-2" aria-hidden="true"></i> Ver en mapa</button>
              </div>
            </div>
          </div>
          <div class="neighborhoods shadow-none style-two">
            <div class="row m-0 my-5">
              <?php foreach ($listado  as $propiedad) { ?>
                <div class="col-md-6 p-0 neighborhoods-list">
                  <a href="<?php echo mklink($propiedad->link) ?>">
                    <div class="img-block">
                      <img src="<?php echo '/admin/' . $propiedad->path ?> " alt="img">
                      <div class="neighborhoods-top">
                        <?php if (!empty($propiedad->direccion_completa)) { ?>
                          <p><?php echo $propiedad->direccion_completa ?></p>
                        <?php } ?>
                        <?php if ($propiedad->publica_precio == 1) { ?>
                          <h4><?php echo $propiedad->moneda; ?> <?php echo $propiedad->precio_final; ?></h4>
                        <?php } else { ?>
                          <h4>Consultar</h4>
                        <?php } ?>
                      </div>
                      <div class="neighborhoods-bottom">
                        <?php if ($propiedad->ambientes != 0) { ?>
                          <div class="neighborhoods-info">
                            <h6><?php echo $propiedad->ambientes ?> Hab.</h6>
                            <img src="assets/images/icon11.png" alt="img">
                          </div>
                        <?php } ?>
                        <?php if ($propiedad->ambientes != 0) { ?>
                          <div class="neighborhoods-info">
                            <h6><?php echo $propiedad->ambientes ?> Baños</h6>
                            <img src="assets/images/icon12.png" alt="img">
                          </div>
                        <?php } ?>
                        <?php if ($propiedad->cocheras != 0) { ?>
                          <div class="neighborhoods-info">
                            <h6><?php echo $propiedad->cocheras ?> Auto</h6>
                            <img src="assets/images/icon13.png" alt="img">
                          </div>
                        <?php } ?>
                        <?php if ($propiedad->superficie_total != 0) { ?>
                          <div class="neighborhoods-info">
                            <h6><?php echo $propiedad->superficie_total ?> m2</h6>
                            <img src="assets/images/icon14.png" alt="img">
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </a>
                </div>
              <?php } ?>
              <!-- <div class="col-md-6 p-0 neighborhoods-list">
                <div class="img-block">
                  <img src="assets/images/img05.jpg" alt="img">
                  <div class="neighborhoods-top">
                    <p>22 1805, e/69 y 70. La Plata</p>
                    <h4>U$S 140.000</h4>
                  </div>
                  <div class="neighborhoods-bottom">
                    <div class="neighborhoods-info">
                      <h6>2 Hab.</h6>
                      <img src="assets/images/icon11.png" alt="img">
                    </div>
                    <div class="neighborhoods-info">
                      <h6>2 Baños</h6>
                      <img src="assets/images/icon12.png" alt="img">
                    </div>
                    <div class="neighborhoods-info">
                      <h6>1 Auto</h6>
                      <img src="assets/images/icon13.png" alt="img">
                    </div>
                    <div class="neighborhoods-info">
                      <h6>813 m2</h6>
                      <img src="assets/images/icon14.png" alt="img">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 p-0 neighborhoods-list">
                <div class="img-block">
                  <img src="assets/images/img06.jpg" alt="img">
                  <div class="neighborhoods-top">
                    <p>22 1805, e/69 y 70. La Plata</p>
                    <h4>U$S 140.000</h4>
                  </div>
                  <div class="neighborhoods-bottom">
                    <div class="neighborhoods-info">
                      <h6>2 Hab.</h6>
                      <img src="assets/images/icon11.png" alt="img">
                    </div>
                    <div class="neighborhoods-info">
                      <h6>2 Baños</h6>
                      <img src="assets/images/icon12.png" alt="img">
                    </div>
                    <div class="neighborhoods-info">
                      <h6>1 Auto</h6>
                      <img src="assets/images/icon13.png" alt="img">
                    </div>
                    <div class="neighborhoods-info">
                      <h6>813 m2</h6>
                      <img src="assets/images/icon14.png" alt="img">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 p-0 neighborhoods-list">
                <div class="img-block">
                  <img src="assets/images/img07.jpg" alt="img">
                  <div class="neighborhoods-top">
                    <p>22 1805, e/69 y 70. La Plata</p>
                    <h4>U$S 140.000</h4>
                  </div>
                  <div class="neighborhoods-bottom">
                    <div class="neighborhoods-info">
                      <h6>2 Hab.</h6>
                      <img src="assets/images/icon11.png" alt="img">
                    </div>
                    <div class="neighborhoods-info">
                      <h6>2 Baños</h6>
                      <img src="assets/images/icon12.png" alt="img">
                    </div>
                    <div class="neighborhoods-info">
                      <h6>1 Auto</h6>
                      <img src="assets/images/icon13.png" alt="img">
                    </div>
                    <div class="neighborhoods-info">
                      <h6>813 m2</h6>
                      <img src="assets/images/icon14.png" alt="img">
                    </div>
                  </div>
                </div>
              </div> -->
            </div>
          </div>
          <div class="page-heading">
            <h2>Buscá más en Grupo Urbano</h2>
            <h6>Realizá una búsqueda en más de <b>10.000</b> propiedades a la venta</h6>
          </div>
          <div class="form-block mt-5">
            <a href="#0" class="btn btn-primary btn-block mb-3 form-toggle style-two">AJUSTAR BÚSQUEDA</a>
            <form class="form-responsive">
              <select class="form-control">
                <option>En Venta</option>
              </select>
              <select class="form-control">
                <option>DEPARTAMENTO</option>
              </select>
              <select class="form-control">
                <option>EN LA PLATA</option>
              </select>
              <button type="submit" class="btn btn-primary">BUSCAR</button>
            </form>
          </div>
        </div>
        <div class="col-md-3">
          <!--    <div class="right-sidebar">
            <div class="sidebar-img">
              <img src="assets/images/user01.jpg" alt="img">
              <div class="sidebar-logo"><img src="assets/images/logo-icon.jpg" alt="img"></div>
            </div>
            <h2>Patricia garcia</h2>
            <h5>ventas</h5>
            <div class="stars-rating">
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <p>(45 Comentarios)</p>
            </div>
            <div class="social">
              <a href="#0"><i class="fa fa-facebook" aria-hidden="true"></i></a>
              <a href="#0"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            </div>
            <a href="#0" class="btn btn-primary btn-block"><i class="fa fa-phone mr-3" aria-hidden="true"></i> llamá a patricia</a>
          </div> -->
          <?php if ($usuario->aparece_web != 0) { ?>
            <div class="right-sidebar">
              <?php if (!empty($usuario->path)) { ?>
                <div class="sidebar-img">
                  <img src="<?php echo $usuario->path ?>" alt="img">
                  <div class="sidebar-logo"><img src="assets/images/logo-icon.jpg" alt="img"></div>
                </div>
              <?php } ?>
              <?php if (!empty($usuario->nombre)) { ?>
                <h2><?php echo $usuario->nombre ?></h2>
              <?php } ?>
              <?php if (!empty($usuario->cargo)) { ?>
                <h5><?php echo $usuario->cargo ?></h5>
              <?php } ?>
              <!-- <div class="stars-rating">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <p>(45 Comentarios)</p>
                </div> -->
              <div class="social">
                <?php if (!empty($usuario->facebook)) { ?>
                  <a href="<?php echo $usuario->facebook ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <?php } ?>
                <?php if (!empty($usuario->instagram)) { ?>
                  <a href="<?php echo $usuario->instagram ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <?php } ?>
              </div>
              <?php $nombre = explode(" ", $usuario->nombre) ?>
              <a href="tel:<?php echo $usuario->telefono ?>" class="btn btn-primary btn-block"><i class="fa fa-phone mr-3" aria-hidden="true"></i> llamá a <?php echo $nombre[0] ?></a>
            </div>
          <?php } ?>

          <div class="right-sidebar">
            <div class="sidebar-arrow"><img src="assets/images/sidebar-arrow.png" alt="img"></div>
            <h2>comunicate ahora</h2>
            <h5 class="mb-3">por estas propiedades</h5>
            <form>
              <div class="form-group">
                <input type="email" class="form-control" placeholder="Nombre">
              </div>
              <div class="form-group">
                <input type="email" class="form-control" placeholder="WhatsApp (sin 0 ni 15)">
              </div>
              <div class="form-group">
                <input type="email" class="form-control" placeholder="Email">
              </div>
              <div class="form-group">
                <textarea class="form-control" placeholder="Escribir mensaje"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-whatsapp mr-3" aria-hidden="true"></i> enviar por whatsapp</button>
              </div>
              <div class="form-group mb-0">
                <button type="submit" class="btn btn-secondary btn-block"><i class="fa fa-envelope-o mr-3" aria-hidden="true"></i> enviar por email</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include("includes/footer.php") ?>

  <!-- Return to Top -->
  <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- Scripts -->
 
</body>

</html>