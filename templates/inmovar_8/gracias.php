<?php include "includes/init.php" ?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/head.php" ?>
</head>

<body>
  
<!-- header part start here -->

<?php include "includes/header.php" ?>

<!-- header part end here --> 

<?php include "templates/comun/gracias.php" ?>

<!-- Footer Part Start here -->
<?php include "includes/footer.php" ?>

<!-- Footer Part End here --> 


<!-- JavaScript
  ================================================== --> 
  <script src="js/jquery-3.2.1.slim.min.js"></script> 
  <script src="js/bootstrap.js"></script> 
  <script src="js/popper.min.js"></script> 
  <script src="js/owl.carousel.js"></script>
  
  
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
<!-- <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script> -->
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>


<script type="text/javascript">

var mymap = L.map('mapid').setView([-34.9204529,-57.9881899], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: '<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>',
    }).addTo(mymap);


var greenIcon = L.icon({
    iconUrl: 'images/marker.png',
    

    iconSize:     [101, 112], // size of the icon
      shadowSize:   [101, 112], // size of the shadow
      iconAnchor:   [-40, 103], // point of the icon which will correspond to marker's location
   // shadowAnchor: [4, 62],  // the same for the shadow
   //  popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

// L.marker([-34.5999926,-58.4069746]).addTo(mymap)
  //  .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
  //  .openPopup();

L.marker([-34.9204529,-57.9881899], {icon: greenIcon}).addTo(mymap);
</script>

  
  
  
</body>
</html>
