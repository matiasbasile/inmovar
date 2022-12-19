<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("includes/init.php");

$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id, array(
  "id_empresa" => $id_empresa,
  "id_empresa_original" => $empresa->id,
  "buscar_total_visitas"=>1,
));

if (($propiedad === FALSE || !isset($propiedad->nombre) || $propiedad->activo == 0) && !isset($get_params["preview"])) {
  header("HTTP/1.1 302 Moved Temporarily");
  header("Location:".mklink("/"));
  exit();
}

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad"=>$propiedad->id));

// Tomamos los datos de SEO
$seo_title = (!empty($propiedad->seo_title)) ? ($propiedad->seo_title) : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? ($propiedad->seo_description) : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? ($propiedad->seo_keywords) : $empresa->seo_keywords;
$nombre_pagina = $propiedad->tipo_operacion_link;
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">

<head>
<?php include("includes/head.php"); ?>
<?php include "../comun/og.php" ?>

</head>

<body class="bg-gray">
  <?php include("includes/header.php") ?>

  <section class="padding-default vendedores-list">
    <div class="container style-two">
      <div class="row">
        <div class="col-md-9">
          <div class="row">
            <?php if (sizeof($propiedad->images) > 0) { ?>
              <div class="col-md-12 order-lg-2 mb-4 mb-lg-0">
                <div class="img-listing">
                  <div class="row">
                    <div class="col-md-9">
                      <?php $count = 0; ?>
                      <?php foreach ($propiedad->images as $images) { ?>
                        <?php if ($count == 0) { ?>
                          <a href="<?php echo $images ?>" class="fancybox" data-fancybox-group="gallery"><img class="adaptable-img-detail" src="<?php echo $images ?>" alt="img"></a>
                        <?php } else { ?>
                          <a href="<?php echo $images ?>" class="fancybox dn" data-fancybox-group="gallery"><img class="adaptable-img-detail" src="<?php echo $images ?>" alt="img"></a>
                        <?php } ?>
                        <?php $count++; ?>
                      <?php } ?>
                      <a class="view-more-photos"><i class="fa fa-camera" aria-hidden="true"></i> Ver más</a>
                    </div>
                    <div class="col-md-3 mobile-hide">
                      <?php $cantidad = sizeof($propiedad->images); ?>
                      <?php $count = 0; ?>
                      <?php foreach ($propiedad->images as $images) { ?>
                        <?php 
                        if ($count == 2) { ?>
                          <div class="d-block position-relative">
                            <img src="<?php echo $images ?>" class="adaptable-img-detail-2" alt="img">
                            <div class="img-listing-more">
                              <p><a href="<?php echo $images ?>" class="fancybox" data-fancybox-group="gallery">+ <?php echo sizeof($propiedad->images) ?> fotos más <br>para ver</a></p>
                            </div>
                          </div>
                        <?php break;
                        } ?>
                        <div class="d-block mb-4"><a href="<?php echo $images ?>" class="fancybox" data-fancybox-group="gallery"><img class="adaptable-img-detail-2" src="<?php echo $images ?>" alt="img"></a></div>
                        <?php $count++; ?>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>

            <div class="col-md-12">
              <div class="page-heading">
                <div class="row align-items-center">
                  <div class="col-md-8">
                    <?php if ($propiedad->total_visitas != 0) { ?>
                      <h6 class="text-18 m-0 p-0"><img src="assets/images/icon15.png" alt="img" class="mr-2"> <span><?php echo $propiedad->total_visitas ?> personas vieron esta propiedad en los últimos 30 días</span></h6>
                    <?php } ?>
                  </div>
                  <?php if ($propiedad->precio_porcentaje_anterior < 0.00 && $propiedad->publica_precio == 1) { ?>
                    <div class="col-md-4 text-right">
                      <h6 class="text-green text-16 m-0 p-0"><i class="fa fa-long-arrow-down mr-1" aria-hidden="true"></i> <b>Bajo de precio un <?php echo floatval($propiedad->precio_porcentaje_anterior * -1) ?>%</b></h6>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div class="page-heading mt-4">
                <div class="row">
                  <div class="col-md-8">
                    <h2><?php echo $propiedad->nombre; ?></h2>
                    <h6>
                      <b><?php echo $propiedad->direccion_completa ?></b>
                    </h6>
                  </div>
                  <div class="col-md-4 text-right">
                    <h2 class="text-blue m-0 p-0"><?php echo $propiedad->precio ?></h2>
                    <?php if ($propiedad->valor_expensas != 0 && $propiedad->publica_precio == 1) { ?>
                      <p class="color-gray">+ <?php echo " $" . number_format($propiedad->valor_expensas,0,",",".") ?> Expensas</p>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="<?php echo ($propiedad->dormitorios == 0 && $propiedad->banios == 0 && $propiedad->cocheras == 0 && $propiedad->superficie_cubierta == 0 && $propiedad->superficie_semicubierta == 0 && $propiedad->superficie_descubierta == 0 && $propiedad->superficie_total == 0 ? "" : "amenities") ?>">
                <?php if ($propiedad->dormitorios != 0) { ?>
                  <span><img src="assets/images/icon16.png" alt="img" class="mr-2"> <b>Habitaciones:</b> <?php echo $propiedad->dormitorios ?></span>
                <?php } ?>
                <?php if ($propiedad->banios != 0) { ?>
                  <span><img src="assets/images/icon17.png" alt="img" class="mr-2"> <b>Baños:</b><?php echo $propiedad->banios ?></span>
                <?php } ?>
                <?php if ($propiedad->cocheras != 0) { ?>
                  <span><img src="assets/images/icon18.png" alt="img" class="mr-2"> <b>Cochera:</b><?php echo $propiedad->cocheras ?></span>
                <?php } ?>
                <?php if ($propiedad->superficie_cubierta != 0) { ?>
                  <span><img src="assets/images/icon19.png" alt="img" class="mr-2"> <b>Cubierto:</b><?php echo $propiedad->superficie_cubierta ?> m2</span>
                <?php } ?>
                <?php if ($propiedad->superficie_semicubierta != 0) { ?>
                  <span><b>Semicubierto:</b> <?php echo $propiedad->superficie_semicubierta ?> m2</span>
                <?php } ?>
                <?php if ($propiedad->superficie_descubierta != 0) { ?>
                  <span><b>Descubierto:</b> <?php echo $propiedad->superficie_descubierta ?> m2</span>
                <?php } ?>
                <?php if ($propiedad->superficie_total != 0) { ?>
                  <span><b>Total:</b> <?php echo $propiedad->superficie_total ?> m2</span>
                <?php } ?>
              </div>
              <div class="published">
                <div class="row">
                  <div class="col-md-8">
                    <?php
                    $actual = new DateTime();
                    $propiedad_fecha = new DateTime($propiedad->fecha_ingreso);
                    $intvl = $actual->diff($propiedad_fecha);
                    ?>
                    <p><b>Publicado hace <?php echo $intvl->days ?> días</b></p>
                  </div>
                  <div class="col-md-4 text-right">
                    <p><b>Código:</b><?php echo $propiedad->codigo ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="img-list-btns">
            <div class="row">
              <?php if ($propiedad->video) { ?>
                <div class="col-md-4"><a href="<?php echo $propiedad->youtube_embed ?>" data-fancybox-group="gallery2" data-fancybox-type="iframe" class="fancybox btn btn-primary btn-block"><i class="fa fa-video-camera mr-3" aria-hidden="true"></i> recorre la propiedad</a></div>
              <?php } ?>
              <?php if ($propiedad->audio) { ?>
                <div class="col-md-4"><a onclick="repoducir_audio()" class="btn btn-primary btn-block"><i class="fa fa-volume-up mr-3" aria-hidden="true"></i> escucha lo que te contamos</a></div>
                <audio class="audio" hidden>
                  <source src="<?php echo $propiedad->audio ?>" type="audio/mpeg">
                </audio>
              <?php } ?>
              <div class="col-md-4">
                <a href="javascript:void(0)" rel="nofollow" onclick="solicitar_visita()" class="btn btn-primary btn-block">
                  <i class="fa fa-calendar-check-o mr-3" aria-hidden="true"></i> 
                  solicita una visita
                </a>
              </div>
            </div>
          </div>
          <div class="info-details">
            <?php if (!empty($propiedad->texto)) { ?>
              <h4>Descripción de propiedad</h4>
              <?php echo $propiedad->texto ?>
            <?php } ?>
            <?php if (($propiedad->latitud != 0) && ($propiedad->longitud != 0)) { ?>
              <h4>Donde se encuentra</h4>
              <p><?php echo $propiedad->direccion_completa.((!empty($propiedad->direccion_completa)) ? ". " : "").$propiedad->localidad ?></p>
              <div class="map mb-3">
                <div class="tab-cont" id="map"></div>
              </div>
            <?php } ?>
            <h4>Más información</h4>
            <?php if (!($propiedad->ambientes == 0 && $propiedad->dormitorios == 0 && $propiedad->cocheras == 0 && $propiedad->banios == 0)) { ?>
              <h5>ambientes</h5>
              <ul>
                <?php if ($propiedad->ambientes != 0) { ?>
                  <li><?php echo ($propiedad->ambientes == 1) ? "1 Ambiente" : $propiedad->ambientes." ambientes" ?></li>
                <?php } ?>
                <?php if ($propiedad->dormitorios != 0) { ?>
                  <li><?php echo ($propiedad->dormitorios == 1) ? "1 Dormitorio" : $propiedad->dormitorios." dormitorios" ?></li>
                <?php } ?>
                <?php if ($propiedad->cocheras != 0) { ?>
                  <li><?php echo ($propiedad->cocheras == 1) ? "Cochera" : $propiedad->cocheras." cocheras" ?></li>
                <?php } ?>
                <?php if ($propiedad->banios != 0) { ?>
                  <li><?php echo ($propiedad->banios == 1) ? "Baño" : $propiedad->banios." baños" ?></li>
                <?php } ?>
              </ul>
            <?php } ?>
            <?php if (!($propiedad->servicios_aire_acondicionado == 0 && $propiedad->servicios_internet == 0 && $propiedad->servicios_gas == 0 && $propiedad->servicios_cloacas == 0 && $propiedad->servicios_agua_corriente == 0 && $propiedad->servicios_asfalto == 0 && $propiedad->servicios_electricidad == 0 && $propiedad->servicios_telefono == 0 && $propiedad->servicios_cable == 0)) { ?>
              <h5>Servicios</h5>
              <ul>
                <?php echo $propiedad->servicios_aire_acondicionado != 0 ? "<li>Aire Acondicionado</li>" : "" ?>
                <?php echo $propiedad->servicios_internet != 0 ? "<li>WiFi</li>" : "" ?>
                <?php echo $propiedad->servicios_gas != 0 ? "<li>Gas</li>" : "" ?>
                <?php echo $propiedad->servicios_cloacas != 0 ? "<li>Cloacas</li>" : "" ?>
                <?php echo $propiedad->servicios_agua_corriente != 0 ? "<li>Agua corriente</li>" : "" ?>
                <?php echo $propiedad->servicios_asfalto != 0 ? "<li>Asfalto</li>" : "" ?>
                <?php echo $propiedad->servicios_electricidad != 0 ? "<li>Electricidad</li>" : "" ?>
                <?php echo $propiedad->servicios_telefono != 0 ? "<li>Teléfono</li>" : "" ?>
                <?php echo $propiedad->servicios_cable != 0 ? "<li>TV Cable</li>" : "" ?>
              </ul>
            <?php } ?>
            <?php if (!($propiedad->patio == 0 && $propiedad->terraza == 0 && $propiedad->parrilla == 0 && $propiedad->piscina == 0 && $propiedad->gimnasio == 0 && $propiedad->living_comedor == 0 && $propiedad->lavadero == 0 && $propiedad->sala_juegos == 0 && $propiedad->balcon == 0 && $propiedad->ascensor == 0)) { ?>
              <h5>Amenities</h5>
              <ul>
                <?php echo $propiedad->patio != 0 ? "<li>Patio</li>" : "" ?>
                <?php echo $propiedad->terraza != 0 ? "<li>Terraza</li>" : "" ?>
                <?php echo $propiedad->parrilla != 0 ? "<li>Parrilla</li>" : "" ?>
                <?php echo $propiedad->piscina != 0 ? "<li>Piscina</li>" : "" ?>
                <?php echo $propiedad->gimnasio != 0 ? "<li>Gimnasio</li>" : "" ?>
                <?php echo $propiedad->living_comedor != 0 ? "<li>Living comedor</li>" : "" ?>
                <?php echo $propiedad->lavadero != 0 ? "<li>Lavadero</li>" : "" ?>
                <?php echo $propiedad->sala_juegos != 0 ? "<li>Sala de juegos</li>" : "" ?>
                <?php echo $propiedad->balcon != 0 ? "<li>Balcón</li>" : "" ?>
                <?php echo $propiedad->ascensor != 0 ? "<li>Ascensor</li>" : "" ?>
              </ul>
            <?php } ?>
            <h5>adicionales</h5>
            <ul class="no-icon">
              <li>Apto Crédito: <span><?php echo $propiedad->apto_banco == 1 ? "Si" : "No" ?></span></li>
              <li>Acepta Permuta: <span><?php echo $propiedad->acepta_permuta == 1 ? "Si" : "No" ?></span></li>
            </ul>
            <?php if (!($propiedad->servicios_escritura == 0 && $propiedad->servicios_plano_obra == 0 && $propiedad->servicios_reglamento == 0 && $propiedad->servicios_plano_ph == 0 && $propiedad->documentacion_escritura == 0 && $propiedad->documentacion_estado_parcelario == 0 && $propiedad->documentacion_impuesto == 0 && $propiedad->documentacion_coti == 0)) { ?>
              <h4>Documentación de la propiedad</h4>
              <div class="right-sidebar">
                <h5>DOCUMENTACIÓN</h5>
                <div class="row">
                  <div class="col-md-9">
                    <ul>
                      <?php echo $propiedad->servicios_escritura != 0 ? "<li>" . $propiedad->servicios_escritura . " Escritura</li>" : "" ?>
                      <?php echo $propiedad->servicios_plano_obra != 0 ? "<li>" . $propiedad->servicios_plano_obra . " Plano de Obra</li>" : "" ?>
                      <?php echo $propiedad->servicios_reglamento != 0 ? "<li>" . $propiedad->servicios_reglamento . " Reglamento</li>" : "" ?>
                      <?php echo $propiedad->servicios_plano_ph != 0 ? "<li>" . $propiedad->servicios_plano_ph . " Plano PH</li>" : "" ?>
                    </ul>
                  </div>
                  <div class="col-md-3 text-right">
                    <b>Verificado:</b> <span class="badge badge-success"><?php echo $propiedad->servicios_fecha_chequeado != "0000-00-00" ? fecha_es($propiedad->servicios_fecha_chequeado) : "No verificado" ?></span>
                  </div>
                </div>
                <ul class="dot-icon pb-0">
                  <?php if ($propiedad->documentacion_escritura != 0) { ?>
                    <li>Escritura:
                      <span>
                        <?php if ($propiedad->documentacion_escritura == 1) {
                          echo "Compraventa";
                        } elseif ($propiedad->documentacion_escritura == 2) {
                          echo "Donación";
                        } elseif ($propiedad->documentacion_escritura == 3) {
                          echo "Parte Indivisa";
                        } elseif ($propiedad->documentacion_escritura == 4) {
                          echo "Fidelcomiso";
                        } elseif ($propiedad->documentacion_escritura == 5) {
                          echo "Tracto Abreviado";
                        } ?>
                      </span>
                    </li>
                  <?php } ?>
                  <?php if ($propiedad->documentacion_estado_parcelario != 0) { ?>
                    <li>
                      Estado Parcelario:
                      <span>
                        <?php if ($propiedad->documentacion_estado_parcelario == 1) {
                          echo "No lleva";
                        } else {
                          echo "Lleva";
                        }
                        ?>
                      </span>
                    </li>
                  <?php } ?>
                  <?php if ($propiedad->documentacion_impuesto != 0) { ?>
                    <li>Impuesto:
                      <span>
                        <?php if ($propiedad->documentacion_impuesto == 1) {
                          echo "Impuesto Transferencia de Inmuebles";
                        } else {
                          echo "Anticipo de Ganancias";
                        }
                        ?>
                      </span>
                    </li>
                  <?php } ?>
                  <?php if ($propiedad->documentacion_coti != 0) { ?>
                    <li>Coti:
                      <span>
                        <?php if ($propiedad->documentacion_coti == 1) {
                          echo "Corresponde";
                        } else {
                          echo "No Corresponde";
                        } ?>
                      </span>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            <?php } ?>
            <?php if (!($propiedad->plazo_reserva == 0 && $propiedad->plazo_boleto == 0 && $propiedad->plazo_escritura == 0)) { ?>
              <div class="right-sidebar">
                <h5>forma de operación</h5>
                <ul class="dot-icon pb-0">
                  <?php if ($propiedad->plazo_reserva != 0) { ?>
                    <li>Reserva: <span>A los <?php echo $propiedad->plazo_reserva ?> días</span></li>
                  <?php } ?>
                  <?php if ($propiedad->plazo_boleto != 0) { ?>
                    <li>Boleto: <span>A los <?php echo $propiedad->plazo_boleto ?> días</span></li>
                  <?php } ?>
                  <?php if ($propiedad->plazo_escritura != 0) { ?>
                    <li>Escritura: <span>A los <?php echo $propiedad->plazo_escritura ?> días</span></li>
                  <?php } ?>
                </ul>
              </div>
            <?php } ?>
          </div>
        </div>

        <?php 
        // Si no tiene asignado un usuario, tenemos que asignarle aleatoriamente uno
        if (empty($propiedad->id_usuario) || $propiedad->id_empresa != $empresa->id) {
          $usuarios = $usuario_model->get_list(array(
            "activo"=>1,
            "offset"=>99999,
            "recibe_notificaciones"=>1,
            "in_perfiles"=>(($propiedad->id_tipo_operacion == 2) ? "1807" : "106,105"),
          ));
          $rand = array_rand($usuarios);
          $usuario = $usuarios[$rand];
          $propiedad->id_usuario = $usuario->id;
        }
        $usuario = $usuario_model->get($propiedad->id_usuario);
        include("includes/propiedad/sidebar.php"); ?>
        
      </div>
    </div>
  </section>

<!-- Footer -->
<?php include("includes/propiedad/modal.php") ?>
<?php include("includes/footer.php") ?>
<?php include_once("templates/comun/mapa_js.php"); ?>

<!-- Return to Top
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a> -->

<!-- Scripts -->
<script type="text/javascript">
function solicitar_visita() {
  $("#visita-modal").modal();
}

$(document).ready(function() {
  <?php if (!empty($propiedad->latitud) && !empty($propiedad->longitud)) { ?>

    /* if ($("#map").length == 0) return; */
    var mymap = L.map('map').setView([<?php echo $propiedad->latitud ?>, <?php echo $propiedad->longitud ?>], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
    }).addTo(mymap);


    var icono = L.icon({
      iconUrl: 'assets/images/map-place.png',
      iconSize: [60, 60], // size of the icon
      iconAnchor: [30, 30], // point of the icon which will correspond to marker's location
    });

    L.marker([<?php echo $propiedad->latitud ?>, <?php echo $propiedad->longitud ?>], {
      icon: icono
    }).addTo(mymap);

  <?php } ?>
});
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
</script>

<?php 
// Creamos el codigo de seguimiento para registrar la visita
echo $propiedad_model->tracking_code(array(
  "id_propiedad"=>$propiedad->id,
  "id_empresa_compartida"=>$id_empresa,
  "id_empresa"=>$empresa->id,
));
?>

</body>
</html>