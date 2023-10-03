<?php
include_once 'includes/init.php';
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <?php $pageTitle = 'Contacto';
include 'includes/head.php'; ?>
</head>

<body>

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Banner -->
    <?php include 'includes/smallBanner.php'; ?>

    <!-- Map -->
    <?php if (isset($empresa->latitud) && isset($empresa->longitud)) { ?>
    <section class="map-location pb-0">
        <div class="map mb-3">
            <div class="tab-cont" id="map"></div>
        </div>
    </section>
    <?php } ?>

    <!-- Communicate Us Two -->
    <section class="communicate-us-two">
        <div class="container">
            <div class="section-title">
                <h2>Comunicate con nosotros</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                    and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                    leap into electronic typesetting, remaining essentially unchanged. </p>
            </div>
            <div class="contact-wrap">
                <div class="row">
                    <div class="col-md-4 col-6">
                        <div class="communicate-items">
                            <img src="assets/images/map-logo.png" alt="Location">
                            <h3>DIRECCIÓN</h3>

                            <p><?php echo $empresa->direccion; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="communicate-items">
                            <img src="assets/images/calendar.png" alt="Calendar">
                            <h3>HORARIOS</h3>
                            <p><?php echo $empresa->horario; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="communicate-items">
                            <img src="assets/images/phone.png" alt="Phone">
                            <h3>CONTACTO</h3>
                            <p class="d-flex flex-column">
                                <a href="tel:<?php echo $empresa->telefono; ?>"><?php echo $empresa->telefono; ?></a>
                                <a href="mailto:<?php echo $empresa->email; ?>"><?php echo $empresa->email; ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-wrap form-wrap-two form-wrap-three">
                <div class="section-title">
                    <h2>Envía una consulta</h2>
                </div>
                <form id="contactForm">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input id="contacto_nombre" class="form-control" type="text" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input id="contacto_email" class="form-control" type="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input id="contacto_telefono" class="form-control" type="text"
                                    placeholder="Whatsapp (Cod. área sin 0 ni 15)">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="" id="contacto_asunto" class="form-control">
                                    <option value="">Asunto</option>
                                    <?php $asuntos = explode(';;;', $empresa->asuntos_contacto); ?>
                                    <?php foreach ($asuntos as $a) { ?>
                                    <option><?php echo $a; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <textarea id="contacto_mensaje" placeholder="Mensaje" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="btn-block">
                        <button type="submit" id="contacto_submit" class="btn">enviar consulta</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/script.js"></script>
    <?php

    if (isset($empresa->latitud) && isset($empresa->longitud)) {
        include_once 'templates/comun/mapa_js.php';

        ?>
    <script>
    $(document).ready(function() {
        /* if ($("#map").length == 0) return; */
        var mymap = L.map('map').setView([<?php echo $empresa->latitud; ?>, <?php echo $empresa->longitud; ?>],
            16);

        L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?php echo defined('MAPBOX_KEY') ? MAPBOX_KEY : ''; ?>', {
                attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
                tileSize: 512,
                maxZoom: 18,
                zoomOffset: -1,
                id: 'mapbox/streets-v11',
                accessToken: '<?php echo defined('MAPBOX_KEY') ? MAPBOX_KEY : ''; ?>',
            }).addTo(mymap);


        var icono = L.icon({
            iconUrl: 'assets/images/map-place.png',
            iconSize: [60, 60], // size of the icon
            iconAnchor: [30, 30], // point of the icon which will correspond to marker's location
        });

        L.marker([<?php echo $empresa->latitud; ?>, <?php echo $empresa->longitud; ?>], {
            icon: icono
        }).addTo(mymap);
    });
    </script>
    <?php } ?>
</body>

</html>