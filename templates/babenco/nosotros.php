<?php include 'includes/init.php' ?>
<!DOCTYPE html>
<html lang="es" >
<head>
  <?php include("includes/head.php") ?>
</head>
<body>
  <?php include("includes/header.php") ?>

<section class="page-title">
  <div class="container">
    <h1>nosotros</h1>
  </div>
</section>

<!-- About Us Info -->
<section class="about-us-info">
  <div class="container">
    <div class="img-block">
      <img src="assets/images/about-us-info.jpg" alt="About Img">
    </div>
    <div class="border-info-section">
      <div class="section-title">
        <span>sobre nosotros</span>
        <h2>Experiencia Inmobiliaria Confiable desde 1985</h2>
      </div>
      <p><b>Babenco Negocios Inmobiliarios</b> cuenta con más de 35 años de experiencia en La Plata, destacándose por su profesionalismo y confianza. Ofrecemos asesoramiento integral en compra, venta y alquiler de propiedades, adaptándonos a las necesidades de cada cliente con transparencia y dedicación. Recientemente, hemos expandido nuestras operaciones a Punta del Este, brindando oportunidades únicas en este prestigioso destino. Nuestro equipo de profesionales capacitados está comprometido con la excelencia y el uso de las últimas tecnologías para garantizar el mejor servicio. En Babenco Negocios Inmobiliarios, valoramos las relaciones duraderas y la satisfacción de nuestros clientes. Confía en nosotros para hacer realidad tus sueños inmobiliarios.</p>
    </div>
    <div class="map-contact">
      <div class="map">
        <div id="map"></div>
      </div>
      <div class="contact-detail">
        <strong>oficina La Plata</strong>
        <p><span><img src="assets/images/office.png" alt="Office"> Dirección:</span> <a href="#0">8 Esq. 59 Nro. 1285  I  CP: 1900  I  La Plata</a></p>
        <p><span><img src="assets/images/clock.png" alt="Office"> Horarios:</span>  <a href="#0">Lunes a Viernes de 9 a 19hs  I  Sábados de 9 a 13hs.</a></p>
        <p><span><img src="assets/images/call.png" alt="Office"> Teléfonos:</span>  <a href="#0">(0221) 482-7872  I  424-1881  I  482-8672</a></p>
      </div>
    </div>
    <div class="map-contact sec">
      <div class="map">
        <div id="map1"></div>
      </div>
      <div class="contact-detail">
        <strong>oficina punta del este</strong>
        <p><span><img src="assets/images/office.png" alt="Office"> Dirección:</span> <a href="#0">8 Esq. 59 Nro. 1285  I  CP: 1900  I  La Plata</a></p>
        <p><span><img src="assets/images/clock.png" alt="Office"> Horarios:</span> <a href="#0">Lunes a Viernes de 9 a 19hs  I  Sábados de 9 a 13hs.</a></p>
        <p><span><img src="assets/images/call.png" alt="Office"> Teléfonos:</span> <a href="#0">(0221) 482-7872  I  424-1881  I  482-8672</a></p>
      </div>
    </div>
  </div>
</section>

<?php include("includes/contacto.php") ?>

<?php include("includes/footer.php") ?>

<script type="text/javascript">
  $(document).ready(function(){

    var mymap = L.map('map').setView([-34.9185733,-57.9561478], 15);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoidmNtYXBib3gxNCIsImEiOiJjbHVzZGpndTAwMXBmMnZwZHVzaHpwdnBkIn0.MNg411Qzoi2JfvKRn6qe2A', {
      attribution: '',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoidmNtYXBib3gxNCIsImEiOiJjbHVzZGpndTAwMXBmMnZwZHVzaHpwdnBkIn0.MNg411Qzoi2JfvKRn6qe2A',
    }).addTo(mymap);

    var icono = L.icon({
     iconUrl: 'assets/images/map-icon.png',
    });

    L.marker([-34.9185733,-57.9561478],{
     icon: icono
   }).addTo(mymap);

    var mymap = L.map('map1').setView([-34.9185733,-57.9561478], 15);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoidmNtYXBib3gxNCIsImEiOiJjbHVzZGpndTAwMXBmMnZwZHVzaHpwdnBkIn0.MNg411Qzoi2JfvKRn6qe2A', {
      attribution: '',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoidmNtYXBib3gxNCIsImEiOiJjbHVzZGpndTAwMXBmMnZwZHVzaHpwdnBkIn0.MNg411Qzoi2JfvKRn6qe2A',
    }).addTo(mymap);

    var icono = L.icon({
     iconUrl: 'assets/images/map-icon.png',
    });

    L.marker([-34.9185733,-57.9561478],{
     icon: icono
   }).addTo(mymap);
  });
</script>
</body>
</html>
</body>
</html>