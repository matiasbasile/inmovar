<?php
include_once("includes/init.php");
$nombre_pagina = "nosotros";
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">

<head>
  <?php include("includes/head.php"); ?>

</head>

<body class="bg-gray">
  <?php include("includes/header.php") ?>

  <!-- lising -->
  <?php 
  $usuario = $usuario_model->get_list(array(
    "offset"=>999999,
    "order_by"=>"A.dni ASC",
  )); ?>
  <section class="padding-default">
    <div class="container style-two">
      <div class="page-heading">
        <h2>Nosotros</h2>
        <!-- <h6>Se encontraron <b><?php echo sizeof($usuario) ?></b> departamentos</h6> -->
      </div>
      <div class="our-team mt-5">
        <div class="row">
          <?php foreach ($usuario as $user) { ?>
            <?php if ($user->aparece_web != 0) { ?>
              <div class="col-md-6">
                <div class="team-list">
                  <div class="team-member-img"><img src="<?php echo $user->path ?>" alt="img"></div>
                  <div class="team-member-info">
                    <h3><?php echo $user->nombre ?></h3>
                    <?php if (!empty($user->titulo)) { ?>
                      <p><?php echo $user->titulo ?></p>
                    <?php } ?>
                    <?php if (!empty($user->cargo)) { ?>
                      <h6><span><?php echo $user->cargo ?></span></h6>
                    <?php } ?>
                    <div class="member-info">
                      <?php if (!empty($user->telefono)){ ?>
                      <div class="row py-3">
                        <div class="col-md-3"><b>Fijo</b></div>
                        <div class="col-md-9 text-right">
                          <p><a href="tel:+<?php echo $user->telefono ?>"><?php echo $user->telefono ?></a></p>
                        </div>
                      </div>
                      <?php } ?>
                      <?php if (!empty($user->celular)) { ?>
                        <div class="row border-top py-3">
                          <div class="col-md-3"><b>Móvil</b></div>
                          <div class="col-md-9 text-right">
                            <p><a href="tel:+<?php echo $user->celular ?>"><?php echo $user->celular ?></a></p>
                          </div>
                        </div>
                      <?php } ?>
                      <?php if (!empty($user->email)) { ?>
                        <div class="row border-top py-3">
                          <div class="col-md-3"><b>Email</b></div>
                          <div class="col-md-9 text-right">
                            <p><a href="mailto:<?php echo $user->email ?>"><?php echo $user->email ?></a></p>
                          </div>
                        </div>
                      <?php } ?>
                      <div class="row pt-3">
                        <div class="col-md-6">
                          <div class="social">
                            <?php if (!empty($user->celular)) { ?>
                              <a href="https://api.whatsapp.com/send?phone=<?php echo $user->celular ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                            <?php } ?>
                            <?php if (!empty($user->facebook)){ ?>
                              <a target="_blank" href="<?php echo $user->facebook ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <?php } ?>
                            <?php if (!empty($user->instagram)){ ?>
                              <a target="_blank" href="<?php echo $user->instagram ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="col-md-6 text-right"><a href="<?php echo mklink("web/vendedor/?id=".$user->id) ?>" class="btn btn-outline-primary">ver propiedades</a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
          <!--   <div class="col-md-6">
            <div class="team-list">
              <div class="team-member-img"><img src="assets/images/team02.jpg" alt="img"></div>
              <div class="team-member-info">
                <h3>PABLO PIÑERO</h3>
                <p>Martillero y Corredor Público Nacional</p>
                <h6><span>Col. 7342</span> - <span>Libro. XIII</span> - <span>Folio. 167</span></h6>
                <div class="member-info">
                  <div class="row py-3">
                    <div class="col-md-3"><b>Fijo</b></div>
                    <div class="col-md-9 text-right">
                      <p>0221 - 4271544 / 427-1545 Interno 307</p>
                    </div>
                  </div>
                  <div class="row border-top py-3">
                    <div class="col-md-3"><b>Móvil</b></div>
                    <div class="col-md-9 text-right">
                      <p>+54 (221) 123.5673</p>
                    </div>
                  </div>
                  <div class="row border-top py-3">
                    <div class="col-md-3"><b>Email</b></div>
                    <div class="col-md-9 text-right">
                      <p>leonel@grupo-urbano.com.ar</p>
                    </div>
                  </div>
                  <div class="row pt-3">
                    <div class="col-md-6">
                      <div class="social">
                        <a href="#0"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                        <a href="#0"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#0"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                      </div>
                    </div>
                    <div class="col-md-6 text-right"><a href="#0" class="btn btn-outline-primary">ver propiedades</a></div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="team-list">
              <div class="team-member-img"><img src="assets/images/team03.jpg" alt="img"></div>
              <div class="team-member-info">
                <h3>GLADYS CUETO</h3>
                <p>División Ventas - Alquileres</p>
                <div class="member-info">
                  <div class="row py-3">
                    <div class="col-md-3"><b>Fijo</b></div>
                    <div class="col-md-9 text-right">
                      <p>0221 - 4271544 / 427-1545 Interno 307</p>
                    </div>
                  </div>
                  <div class="row border-top py-3">
                    <div class="col-md-3"><b>Móvil</b></div>
                    <div class="col-md-9 text-right">
                      <p>+54 (221) 123.5673</p>
                    </div>
                  </div>
                  <div class="row border-top py-3">
                    <div class="col-md-3"><b>Email</b></div>
                    <div class="col-md-9 text-right">
                      <p>leonel@grupo-urbano.com.ar</p>
                    </div>
                  </div>
                  <div class="row pt-3">
                    <div class="col-md-6">
                      <div class="social">
                        <a href="#0"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                        <a href="#0"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#0"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                      </div>
                    </div>
                    <div class="col-md-6 text-right"><a href="#0" class="btn btn-outline-primary">ver propiedades</a></div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="team-list">
              <div class="team-member-img"><img src="assets/images/team04.jpg" alt="img"></div>
              <div class="team-member-info">
                <h3>LEONARDO CEJAS</h3>
                <p>División Ventas</p>
                <div class="member-info">
                  <div class="row py-3">
                    <div class="col-md-3"><b>Fijo</b></div>
                    <div class="col-md-9 text-right">
                      <p>0221 - 4271544 / 427-1545 Interno 307</p>
                    </div>
                  </div>
                  <div class="row border-top py-3">
                    <div class="col-md-3"><b>Móvil</b></div>
                    <div class="col-md-9 text-right">
                      <p>+54 (221) 123.5673</p>
                    </div>
                  </div>
                  <div class="row border-top py-3">
                    <div class="col-md-3"><b>Email</b></div>
                    <div class="col-md-9 text-right">
                      <p>leonel@grupo-urbano.com.ar</p>
                    </div>
                  </div>
                  <div class="row pt-3">
                    <div class="col-md-6">
                      <div class="social">
                        <a href="#0"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                        <a href="#0"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#0"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                      </div>
                    </div>
                    <div class="col-md-6 text-right"><a href="#0" class="btn btn-outline-primary">ver propiedades</a></div>
                  </div>
                </div>

              </div>
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </section>

  <?php include("includes/footer.php") ?>
 
</body>
</html>