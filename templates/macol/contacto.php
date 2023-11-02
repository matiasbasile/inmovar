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

    <?php include 'includes/contacto.php'; ?>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <?php
    if (isset($empresa->latitud) && isset($empresa->longitud)) {
        include_once 'templates/comun/mapa_js.php'; ?>
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