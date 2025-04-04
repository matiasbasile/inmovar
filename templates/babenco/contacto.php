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
    <h1>contacto</h1>
  </div>
</section>

<section class="about-us-info">
  <div class="container">
    <?php
    $oficinas_list = $entrada_model->get_list(array(
      "from_link_categoria" => "oficinas"
    ));
    $i = 0;
    foreach($oficinas_list as $oficina) { ?>
      <div class="map-contact <?php echo ($i%2==0)?"":"sec" ?>">
        <div class="map">
          <div id="map<?php echo $i ?>"></div>
        </div>
        <div class="contact-detail">
          <strong><?php echo $oficina->titulo ?></strong>
          <?php echo $oficina->texto ?>
        </div>
      </div>
    <?php $i++; } ?>
  </div>
</section>

<?php include("includes/contacto.php") ?>

<?php include("includes/footer.php") ?>

<?php if (sizeof($oficinas_list)>0) { ?>
  <script type="text/javascript">
    $(document).ready(function(){

      var icono = L.icon({
        iconUrl: 'assets/images/map-icon.png',
      });

      <?php
      $i = 0; 
      foreach($oficinas_list as $oficina) {
        if (empty($oficina->link_externo)) continue;
        $coordenadas = explode(",", $oficina->link_externo);
        if (sizeof($coordenadas) != 2) continue;
        $oficina->latitud = trim($coordenadas[0]);
        $oficina->longitud = trim($coordenadas[1]);
        ?>
        var mymap = L.map('map<?php echo $i ?>').setView([<?php echo $oficina->latitud ?>,<?php echo $oficina->longitud ?>], 15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
          tileSize: 512,
          maxZoom: 18,
          zoomOffset: -1,
        }).addTo(mymap);

        L.marker([<?php echo $oficina->latitud ?>,<?php echo $oficina->longitud ?>],{
          icon: icono
        }).addTo(mymap);
      <?php $i++; } ?>

    });
  </script>
<?php } ?>

</body>
</html>