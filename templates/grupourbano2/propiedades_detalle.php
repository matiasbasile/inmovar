<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("includes/init.php");
include_once("includes/funciones.php");
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">

<head>
  <?php include("includes/head.php"); ?>
</head>

<body class="bg-gray">
  <?php include("includes/header.php") ?>
  <!-- lising -->
  <?php $detalle = $propiedad_model->get($id); ?>
  <?php var_dump($detalle); echo "asdad";?>
  <section class="padding-default vendedores-list">
    <div class="container style-two">
      <div class="row">
        <div class="col-md-9">
          <div class="row">
            <?php if (isset($detalle)) { ?>
              <?php if (sizeof($detalle->images) > 0) { ?>
                <div class="col-md-12 order-lg-2 mb-4 mb-lg-0">
                  <div class="img-listing">
                    <div class="row">
                      <div class="col-md-9">
                        <?php $count = 0; ?>
                        <?php foreach ($detalle->images as $images) { ?>
                          <?php if ($count == 0) { ?>
                            <a href="<?php echo $images ?>" class="fancybox" data-fancybox-group="gallery"><img src="<?php echo $images ?>" alt="img"></a>
                          <?php } else { ?>
                            <a href="<?php echo $images ?>" class="fancybox dn" data-fancybox-group="gallery"><img src="<?php echo $images ?>" alt="img"></a>
                          <?php } ?>
                          <?php $count++; ?>
                        <?php } ?>
                        <a href="assets/images/img10.jpg" data-fancybox-group="gallery" class="fancybox view-more-photos"><i class="fa fa-camera" aria-hidden="true"></i> See Photos</a>
                      </div>
                      <div class="col-md-3 mobile-hide">
                        <?php $cantidad = sizeof($detalle->images); ?>
                        <?php $count = 0; ?>
                        <?php foreach ($detalle->images as $images) { ?>
                          <div class="d-block mb-4"><a href="<?php echo $images ?>" class="fancybox" data-fancybox-group="gallery"><img src="<?php echo $images ?>" alt="img"></a></div>
                          <?php if ($count == 1) { ?>
                            <div class="d-block position-relative">
                              <img src="<?php echo $images ?>" alt="img">
                              <div class="img-listing-more">
                                <p><a href="<?php echo $images ?>" class="fancybox" data-fancybox-group="gallery">+ <?php echo sizeof($detalle->images) ?> fotos más <br>para ver</a></p>
                              </div>
                            </div>
                          <?php break;
                          } ?>
                          <?php $count++; ?>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>

            <div class="col-md-12">
              <div class="page-heading">
                <div class="row align-items-center">
                  <div class="col-md-8">
                    <?php if ($detalle->total_visitas != 0) { ?>
                      <h6 class="text-18 m-0 p-0"><img src="assets/images/icon15.png" alt="img" class="mr-2"> <span><?php echo $detalle->total_visitas ?> personas vieron esta propiedad en los últimos 30 días</span></h6>
                    <?php } ?>
                  </div>
                  <?php if ($detalle->precio_porcentaje_anterior < 0.00 && $detalle->publica_precio == 1) { ?>
                    <div class="col-md-4 text-right">
                      <h6 class="text-green text-16 m-0 p-0"><i class="fa fa-long-arrow-down mr-1" aria-hidden="true"></i> <b>Bajo de precio un <?php floatval($propiedad->precio_porcentaje_anterior * -1) ?>%%</b></h6>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div class="page-heading mt-4">
                <div class="row">
                  <div class="col-md-8">
                    <h2><?php echo $detalle->nombre; ?></h2>
                    <h6>
                      <b><?php echo $detalle->calle ?></b>
                      <?php echo ($detalle->piso != "" ? ", " . $detalle->piso : ""); ?>
                      <?php echo ($detalle->numero != "" ? $detalle->numero : ""); ?>
                      <?php echo (!empty($detalle->localidad) ? ", " . $detalle->localidad : "")  ?>
                    </h6>
                  </div>
                  <div class="col-md-4 text-right">
                    <?php if (!empty($detalle->publica_precio)) { ?>
                      <h2 class="text-blue m-0 p-0"><?php echo $detalle->moneda . " " . $detalle->precio_final ?></h2>
                    <?php } else { ?>
                      <h2 class="text-blue m-0 p-0">Consultar</h2>
                    <?php } ?>
                    <?php if ($detalle->valor_expensas != 0) { ?>
                      <p class="color-gray">+ <?php echo $detalle->moneda . " " . $detalle->valor_expensas ?> Expensas</p>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="<?php ($detalle->ambientes == 0 && $detalle->banios == 0 && $detalle->cocheras == 0 && $detalle->superficie_cubierta == 0 && $detalle->superficie_semicubierta == 0 && $detalle->superficie_descubierta == 0 && $detalle->superficie_total == 0 ? "" : "amenities") ?>">
                <?php if ($detalle->ambientes != 0) { ?>
                  <span><img src="assets/images/icon16.png" alt="img" class="mr-2"> <b>Habitaciones:</b> <?php echo $detalle->ambientes ?></span>
                <?php } ?>
                <?php if ($detalle->banios != 0) { ?>
                  <span><img src="assets/images/icon17.png" alt="img" class="mr-2"> <b>Baños:</b><?php echo $detalle->banios ?></span>
                <?php } ?>
                <?php if ($detalle->cocheras != 0) { ?>
                  <span><img src="assets/images/icon18.png" alt="img" class="mr-2"> <b>Cochera:</b><?php echo $detalle->cocheras ?></span>
                <?php } ?>
                <?php if ($detalle->superficie_cubierta != 0) { ?>
                  <span><img src="assets/images/icon19.png" alt="img" class="mr-2"> <b>Cubierto:</b><?php echo $detalle->superficie_cubierta ?> m2</span>
                <?php } ?>
                <?php if ($detalle->superficie_semicubierta != 0) { ?>
                  <span><b>Semicubierto:</b> <?php echo $detalle->superficie_semicubierta ?> m2</span>
                <?php } ?>
                <?php if ($detalle->superficie_descubierta != 0) { ?>
                  <span><b>Descubierto:</b> <?php echo $detalle->superficie_descubierta ?> m2</span>
                <?php } ?>
                <?php if ($detalle->superficie_total != 0) { ?>
                  <span><b>Total:</b> <?php echo $detalle->superficie_total ?> m2</span>
                <?php } ?>
              </div>
              <div class="published">
                <div class="row">
                  <div class="col-md-8">
                    <?php
                    $actual = new DateTime();
                    $detalle_fecha = new DateTime($detalle->fecha_ingreso);
                    $intvl = $actual->diff($detalle_fecha);

                    ?>
                    <p><b>Publicado hace <?php echo $intvl->days ?> días</b></p>
                  </div>
                  <div class="col-md-4 text-right">
                    <p><b>Código:</b><?php echo $detalle->codigo ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="img-list-btns">
            <div class="row">
              <?php if ($detalle->video) { ?>
                <div class="col-md-4"><a href="<?php echo $detalle->video ?>" class="btn btn-primary btn-block"><i class="fa fa-video-camera mr-3" aria-hidden="true"></i> recorre la propiedad</a></div>
              <?php } ?>
              <?php if ($detalle->audio) { ?>
                <div class="col-md-4"><a onclick="repoducir_audio()" class="btn btn-primary btn-block"><i class="fa fa-volume-up mr-3" aria-hidden="true"></i> escucha lo que te contamos</a></div>
                <audio class="audio" hidden>
                  <source src="<?php echo $detalle->audio ?>" type="audio/mpeg">
                </audio>
              <?php } ?>
              <div class="col-md-4"><a href="#0" class="btn btn-primary btn-block"><i class="fa fa-calendar-check-o mr-3" aria-hidden="true"></i> solicita una visita</a></div>
            </div>
          </div>
          <div class="info-details">
            <?php if (!empty($detalle->descripcion)) { ?>
              <h4>Descripción de propiedad</h4>
              <?php echo $detalle->descripcion ?>
            <?php } ?>
            <?php if (!empty($detalle->descripcion_ubicacion)) { ?>
              <h4>Donde se encuentra</h4>
              <p><?php echo $detalle->descripcion_ubicacion ?></p>
              <div class="map mb-3"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10386.271346626505!2d-57.97525530191794!3d-34.919735337758624!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95a2e62dd769b9d7%3A0x8e5a62b28764b5ef!2sCatedral%20de%20La%20Plata!5e0!3m2!1sen!2sin!4v1637730397287!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe></div>
            <?php } ?>
            <h4>Más información</h4>
            <?php if ($detalle->ambientes == 0 && $detalle->dormitorios == 0 && $detalle->cocheras == 0 && $detalle->banios == 0) {
            } else { ?>
              <h5>ambientes</h5>
              <ul>
                <?php if ($detalle->ambientes != 0) { ?>
                  <li> <?php echo $detalle->ambientes ?> Ambientes</li>
                <?php } ?>
                <?php if ($detalle->dormitorios != 0) { ?>
                  <li><?php echo $detalle->dormitorios ?> Dormitorios</li>
                <?php } ?>
                <?php if ($detalle->cocheras != 0) { ?>
                  <li><?php echo $detalle->cocheras != 0 ?> Cochera</li>
                <?php } ?>
                <?php if ($detalle->banios != 0) { ?>
                  <li><?php echo $detalle->banios != 0 ?> Baños</li>
                <?php } ?>
              </ul>
            <?php } ?>
            <?php if ($detalle->servicios_aire_acondicionado == 0 && $detalle->servicios_internet == 0 && $detalle->servicios_gas == 0 && $detalle->servicios_cloacas == 0 && $detalle->servicios_agua_corriente == 0 && $detalle->servicios_asfalto == 0 && $detalle->servicios_electricidad == 0 && $detalle->servicios_telefono == 0 && $detalle->servicios_cable == 0) {
            } else { ?>
              <h5>Servicios</h5>
              <ul>
                <?php echo $detalle->servicios_aire_acondicionado != 0 ? "<li>" . $detalle->servicios_aire_acondicionado . " Aire Acondicionado</li>" : "" ?>
                <?php echo $detalle->servicios_internet != 0 ? "<li>" . $detalle->servicios_internet . " WiFi</li>" : "" ?>
                <?php echo $detalle->servicios_gas != 0 ? "<li>" . $detalle->servicios_gas . " Gas</li>" : "" ?>
                <?php echo $detalle->servicios_cloacas != 0 ? "<li>" . $detalle->servicios_cloacas . " Cloacas</li>" : "" ?>
                <?php echo $detalle->servicios_agua_corriente != 0 ? "<li>" . $detalle->servicios_agua_corriente . " Agua corriente</li>" : "" ?>
                <?php echo $detalle->servicios_asfalto != 0 ? "<li>" . $detalle->servicios_asfalto . " Asfalto</li>" : "" ?>
                <?php echo $detalle->servicios_electricidad != 0 ? "<li>" . $detalle->servicios_electricidad . " Electricidad</li>" : "" ?>
                <?php echo $detalle->servicios_telefono != 0 ? "<li>" . $detalle->servicios_telefono . " Telefono</li>" : "" ?>
                <?php echo $detalle->servicios_cable != 0 ? "<li>" . $detalle->servicios_cable . " Cable</li>" : "" ?>
              </ul>
            <?php } ?>
            <?php if (
              $detalle->patio == 0 && $detalle->terraza == 0 && $detalle->parrilla == 0 && $detalle->piscina == 0 && $detalle->gimnasio == 0 && $detalle->living_comedor == 0 && $detalle->lavadero == 0 && $detalle->sala_juegos == 0 && $detalle->balcon == 0 && $detalle->ascensor == 0
            ) {
            } else { ?>
              <h5>Amenities</h5>
              <ul>
                <?php echo $detalle->patio != 0 ? "<li>" . $detalle->patio . " Patio</li>" : "" ?>
                <?php echo $detalle->terraza != 0 ? "<li>" . $detalle->terraza . " Terraza</li>" : "" ?>
                <?php echo $detalle->parrilla != 0 ? "<li>" . $detalle->parrilla . " Parrilla</li>" : "" ?>
                <?php echo $detalle->piscina != 0 ? "<li>" . $detalle->piscina . " Piscina</li>" : "" ?>
                <?php echo $detalle->gimnasio != 0 ? "<li>" . $detalle->gimnasio . " Gimnasio</li>" : "" ?>
                <?php echo $detalle->living_comedor != 0 ? "<li>" . $detalle->living_comedor . " Living comedor</li>" : "" ?>
                <?php echo $detalle->lavadero != 0 ? "<li>" . $detalle->lavadero . " Lavadero</li>" : "" ?>
                <?php echo $detalle->sala_juegos != 0 ? "<li>" . $detalle->sala_juegos . " Sala de juegos</li>" : "" ?>
                <?php echo $detalle->balcon != 0 ? "<li>" . $detalle->balcon . " Balcon</li>" : "" ?>
                <?php echo $detalle->ascensor != 0 ? "<li>" . $detalle->ascensor . " Ascensor</li>" : "" ?>
              </ul>
            <?php } ?>
            <h5>adicionales</h5>
            <ul class="no-icon">
              <li>Apto Crédito: <span><?php echo $detalle->apto_banco == 1 ? "Si" : "No" ?></span></li>
              <li>Acepta Permuta: <span><?php echo $detalle->acepta_permuta == 1 ? "Si" : "No" ?></span></li>
            </ul>

            <h4>Documentación de la propiedad</h4>
            <div class="right-sidebar">
              <h5>DOCUMENTACIÓN</h5>
              <div class="row">
                <div class="col-md-9">
                  <ul>
                    <?php echo $detalle->servicios_escritura != 0 ? "<li>" . $detalle->servicios_escritura . " Escritura</li>" : "" ?>
                    <?php echo $detalle->servicios_plano_obra != 0 ? "<li>" . $detalle->servicios_plano_obra . " Plano de Obra</li>" : "" ?>
                    <?php echo $detalle->servicios_reglamento != 0 ? "<li>" . $detalle->servicios_reglamento . " Reglamento</li>" : "" ?>
                    <?php echo $detalle->servicios_plano_ph != 0 ? "<li>" . $detalle->servicios_plano_ph . " Plano PH</li>" : "" ?>
                  </ul>
                </div>
                <div class="col-md-3 text-right">
                  <b>Verificado:</b> <span class="badge badge-success"><?php echo $detalle->servicios_fecha_chequeado != "0000-00-00" ? $detalle->servicios_fecha_chequeado : "No verificado" ?></span>
                </div>
              </div>
              <ul class="dot-icon pb-0">
                <?php if ($detalle->documentacion_escritura != 0) { ?>
                  <li>Escritura:
                    <span>
                      <?php if ($detalle->documentacion_escritura == 1) {
                        echo "Compraventa";
                      } elseif ($detalle->documentacion_escritura == 2) {
                        echo "Donación";
                      } elseif ($detalle->documentacion_escritura == 3) {
                        echo "Parte Indivisa";
                      } else {
                        echo "Fidelcomiso";
                      } ?>
                    </span>
                  </li>
                <?php } ?>
                <?php if ($detalle->documentacion_estado_parcelario != 0) { ?>
                  <li>
                    Estado Parcelario:
                    <span>
                      <?php if ($detalle->documentacion_estado_parcelario == 1) {
                        echo "No lleva";
                      } else {
                        echo "Lleva";
                      }
                      ?>
                    </span>
                  </li>
                <?php } ?>
                <?php if ($detalle->documentacion_impuesto != 0) { ?>
                  <li>Impuesto:
                    <span>
                      <?php if ($detalle->documentacion_impuesto == 1) {
                        echo "Impuesto Transferencia de Inmuebles";
                      } else {
                        echo "Anticipo de Ganancias";
                      }
                      ?>
                    </span>
                  </li>
                <?php } ?>
                <?php if ($detalle->documentacion_coti != 0) { ?>
                  <li>Coti:
                    <span>
                      <?php if ($detalle->documentacion_coti == 1) {
                        echo "Corresponde";
                      } else {
                        echo "No Corresponde";
                      } ?>
                    </span>
                  </li>
                <?php } ?>
              </ul>
            </div>
            <?php if ($detalle->plazo_reserva == 0 && $detalle->plazo_boleto == 0 && $detalle->plazo_escritura == 0) {
            } else { ?>
              <div class="right-sidebar">
                <h5>forma de operación</h5>
                <ul class="dot-icon pb-0">
                  <?php if ($detalle->plazo_reserva != 0) { ?>
                    <li>Reserva: <span>A los <?php echo $detalle->plazo_reserva ?> días</span></li>
                  <?php } ?>
                  <?php if ($detalle->plazo_boleto != 0) { ?>
                    <li>Boleto: <span>A los <?php echo $detalle->plazo_boleto ?> días</span></li>
                  <?php } ?>
                  <?php if ($detalle->plazo_escritura != 0) { ?>
                    <li>Escritura: <span>A los <?php echo $detalle->plazo_escritura ?> días</span></li>
                  <?php } ?>
                </ul>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-3">
          <?php if ($detalle->id_usuario != 0) { ?>
            <?php $usuario = $usuario_model->get($detalle->id_usuario); ?>
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
          <?php } ?>
          <div class="right-sidebar">
            <input type="hidden" name="para" id="contacto_para" value="<?php echo (isset($contacto_para) ? $contacto_para : $empresa->email) ?>" />
            <input type="hidden" name="id_usuario" id="contacto_id_usuario" value="<?php echo (isset($id_usuario) ? $id_usuario : 0) ?>" />
            <input type="hidden" name="id_propiedad" id="contacto_propiedad" value="<?php echo (isset($detalle) ? $detalle->id : 0) ?>" />
            <div class="sidebar-arrow"><img src="assets/images/sidebar-arrow.png" alt="img"></div>
            <h2>comunicate ahora</h2>
            <h5 class="mb-3">por estas propiedades</h5>
            <form onsubmit="enviar_contacto()">
              <div class="form-group">
                <input id="contacto_nombre" type="text" class="form-control" placeholder="Nombre">
              </div>
              <div class="form-group">
                <input id="contacto_telefono" type="number" class="form-control" placeholder="WhatsApp (sin 0 ni 15)">
              </div>
              <div class="form-group">
                <input id="contacto_email" type="email" class="form-control" placeholder="Email">
              </div>
              <div class="form-group">
                <textarea id="contacto_mensaje" class="form-control" placeholder="Estoy interesado en Departamento en Venta en La Plata en 60 e/ 20 y 21, Piso 1 Depto 5, La Plata"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-whatsapp mr-3" aria-hidden="true"></i> enviar por whatsapp</button>
              </div>
              <div class="form-group mb-0">
                <button type="submit" class="btn btn-secondary btn-block"><i class="fa fa-envelope-o mr-3" aria-hidden="true"></i> enviar por email</button>
              </div>
            </form>
          </div>
          <div class="d-block">
            <a href="" onClick="history.go(-1); return false;" class="btn btn-outline-secondary btn-block style-two"><i class="fa fa-undo mr-3" aria-hidden="true"></i> regresar a los resultados</a>
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
  <script type="text/javascript">
    //FANCYBOX SCRIPT
    $(function() {
      $(".fancybox").fancybox({
        transitionIn: 'fade',
        transitionOut: 'fade',
        openEffect: 'fade',
        closeEffect: 'fade',
        nextEffect: 'fade',
        prevEffect: 'fade',
        helpers: {
          overlay: {
            locked: false,
            closeClick: false
          },
        }
      });
    });

    function enviar_contacto() {
      if (enviando == 1) return;
      var nombre = $("#contacto_nombre").val();
      var email = $("#contacto_email").val();
      var telefono = $("#contacto_telefono").val();
      var mensaje = $("#contacto_mensaje").val();
      var para = $("#contacto_para").val();
      var id_propiedad = $("#contacto_propiedad").val();
      var id_usuario = $("#contacto_id_usuario").val();
      if (isEmpty(para)) para = "<?php echo $empresa->email ?>";

      if (isEmpty(nombre) || nombre == "Nombre") {
        alert("Por favor ingrese un nombre");
        $("#contacto_nombre").focus();
        return false;
      }
      if (!validateEmail(email)) {
        alert("Por favor ingrese un email valido");
        $("#contacto_email").focus();
        return false;
      }
      if (isEmpty(telefono) || telefono == "Telefono") {
        alert("Por favor ingrese un telefono");
        $("#contacto_telefono").focus();
        return false;
      }
      if (isEmpty(mensaje) || mensaje == "Mensaje") {
        alert("Por favor ingrese un mensaje");
        $("#contacto_mensaje").focus();
        return false;
      }

      $("#contacto_submit").attr('disabled', 'disabled');
      var datos = {
        "nombre": nombre,
        "email": email,
        "mensaje": mensaje,
        "telefono": telefono,
        "para": para,
        "id_propiedad": id_propiedad,
        <?php if (isset($detalle) && $detalle->id_empresa != $empresa->id) { ?> "id_empresa_relacion": "<?php echo $detalle->id_empresa ?>",
        <?php } ?> "id_usuario": id_usuario,
        "id_empresa": ID_EMPRESA,
        "id_origen": <?php echo (isset($id_origen) ? $id_origen : 1); ?>,
      }
      enviando = 1;
      $.ajax({
        "url": "https://app.inmovar.com/admin/consultas/function/enviar/",
        "type": "post",
        "dataType": "json",
        "data": datos,
        "success": function(r) {
          if (r.error == 0) {
            window.location.href = "<?php echo mklink("web/gracias/") ?>";
          } else {
            alert("Ocurrio un error al enviar su email. Disculpe las molestias");
            $("#contacto_submit").removeAttr('disabled');
            enviando = 0;
          }
        }
      });
      return false;
    }
  </script>
</body>

</html>