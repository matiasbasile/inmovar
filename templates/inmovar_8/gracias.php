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
  <!-- Contact Us Page Start here -->

<div class="container">
  <div class="thankyou text-center">
    <h1>Gracias!</h1>
    <p>Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad! </p>

  </div>
</div>


 <!-- Contact Us Page End here -->







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

L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
  //  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery Â© <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1IjoiaGVuaWRlZXBhayIsImEiOiJjajIwNmUyMWEwMmh0MzJxbXk1eXA5a3VkIn0.aTDa_ljZ8zNilegJ0T2zkA'
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
