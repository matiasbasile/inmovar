<script src="assets/js/leaflet.draw.js?v=2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js"></script>
<script type="text/javascript">
var buscar_ajax = 0;
var markers;
var mymap;
var visibleClusterMarkers = [];

// Variable para almacenar el polígono dibujado
var drawnPolygon = null;

$(document).ready(function() {

  <?php 
  // Si estamos buscando por una localidad que tiene latitud / longitud / zoom
  if (!empty($vc_zoom_localidad) && !empty($vc_lat_localidad) && !empty($vc_lng_localidad)) {
    $lat_centro = $vc_lat_localidad;
    $lng_centro = $vc_lng_localidad;
    $zoom_centro = $vc_zoom_localidad;
  } else {
    $lat_centro = -34.90648870;
    $lng_centro = -57.98993650;
    $zoom_centro = 13;
  }
  ?>

  mymap = L.map('map').setView([<?php echo $lat_centro ?>, <?php echo $lng_centro ?>], <?php echo $zoom_centro ?>);
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    tileSize: 512,
    maxZoom: 18,
    zoomOffset: -1,
  }).addTo(mymap);

  // Crea una capa de superposición semitransparente
  var overlay = L.tileLayer('assets/images/fondo-mapa.png', {
    opacity: 1 // Define la opacidad de la capa
  }).addTo(mymap);

  // Agrega la capa de superposición al mapa
  mymap.addLayer(overlay);  

  // Crear un grupo de marcadores con agrupación dinámica
  markers = L.markerClusterGroup({
    maxClusterRadius: 80, // Establecer la distancia máxima en píxeles para agrupar los marcadores
  }); 

  var icono = L.icon({
    iconUrl: 'assets/images/map-icon.svg',
    iconSize: [32, 45], // size of the icon
    iconAnchor: [16, 16], // point of the icon which will correspond to marker's location
  });

  <?php $i = 0;
  foreach ($vc_listado_2 as $p) {
    if (empty($p->latitud)) continue; ?>

    var contentString<?php echo $i; ?> = '' + 
      '<a target="_blank" href="<?php echo $p->link_propiedad ?>" class="img-block"><span><?php echo $p->precio ?></span><img src="<?php echo $p->imagen ?>"></a>' +
      '<div class="locations-body"><h3><?php echo replaceQuotes($p->nombre) ?></h3><p><?php echo replaceQuotes($p->direccion_completa) ?></p></div>';

    var marker<?php echo $i; ?> = L.marker([<?php echo $p->latitud ?>, <?php echo $p->longitud ?>], {
      icon: icono
    });
    marker<?php echo $i; ?>.bindPopup(contentString<?php echo $i; ?>);

    markers.addLayer(marker<?php echo $i; ?>);

  <?php $i++;
  } ?>

  // Click en el grupo
  markers.on('clusterclick', function(e) {
    // Habilitamos la llave para buscar.
    var latLngBounds = e.layer.getBounds();
    // 10% de la diferencia
    var dif_lat = (Math.abs(latLngBounds._northEast.lat) - Math.abs(latLngBounds._southWest.lat)) * 0.10;
    var dif_lng = (Math.abs(latLngBounds._northEast.lng) - Math.abs(latLngBounds._southWest.lng)) * 0.10;
    // IMPORTANTE: la diferencia no puede dar 0, entonces tomamos el limite minimo
    if (dif_lat == 0) dif_lat = 0.001;
    if (dif_lng == 0) dif_lng = 0.001;
    var ne_lat = (latLngBounds._northEast.lat < 0) ? (latLngBounds._northEast.lat - dif_lat) : (latLngBounds._northEast.lat + dif_lat);
    var ne_lng = (latLngBounds._northEast.lng < 0) ? (latLngBounds._northEast.lng - dif_lng) : (latLngBounds._northEast.lng + dif_lng);
    var sw_lat = (latLngBounds._southWest.lat < 0) ? (latLngBounds._southWest.lat + dif_lat) : (latLngBounds._southWest.lat - dif_lat);
    var sw_lng = (latLngBounds._southWest.lng < 0) ? (latLngBounds._southWest.lng + dif_lng) : (latLngBounds._southWest.lng - dif_lng);
    var salida = new Array();
    salida.push({"lat":(ne_lat),"lng":(ne_lng)});
    salida.push({"lat":(sw_lat),"lng":(ne_lng)});
    salida.push({"lat":(sw_lat),"lng":(sw_lng)});
    salida.push({"lat":(ne_lat),"lng":(sw_lng)});
    salida.push({"lat":(ne_lat),"lng":(ne_lng)});
    var s = JSON.stringify(salida);
    $("#page").val(0);
    $("#filtrar_puntos").val(s);
    filtrar_ajax();
  });

  // Agregar el grupo de marcadores al mapa
  mymap.addLayer(markers);

  <?php 
  // Si la localidad que estamos buscando tiene un zoom definido, entonces no autocentramos
  if (empty($vc_zoom_localidad) && $vc_id_localidad != 0) { ?>
    mymap.fitBounds([
      <?php foreach ($vc_listado_2 as $p) {
        if (isset($p->latitud) && isset($p->longitud) && !empty($p->latitud) && !empty($p->longitud)) {  ?>[<?php echo $p->latitud ?>, <?php echo $p->longitud ?>],
        <?php } ?>
      <?php } ?>
    ]);
  <?php } ?>


  // Crear una capa para el dibujo
  var drawnItems = new L.FeatureGroup();
  mymap.addLayer(drawnItems);


  // Crear el control de dibujo
  window.drawControl = new L.Control.Draw({
    draw: {
      polygon: true,
      polyline: false,
      rectangle: false,
      circle: false,
      circlemarker: false,
      marker: false,
      toolbar: {
        actions: {
          title: "Actions",
          text: "Actions",
        },
        finish: {
          title: "Finish",
          text: "Finish",          
        },
        buttons: {
          polygon: "Poligono",
        }        
      }
    },
    edit: {
      featureGroup: drawnItems,
      remove: true
    }
  });
  mymap.addControl(window.drawControl);

  // Escuchar el evento de dibujo creado
  mymap.on('draw:created', function (e) {
    if (drawnPolygon !== null) {
      mymap.removeLayer(drawnPolygon);
      drawnItems.removeLayer(drawnPolygon);
    }    
    var layer = e.layer;
    drawnItems.addLayer(layer);
    drawnPolygon = layer;
    var polygonPoints = layer.getLatLngs();
    filtrar_poligono(polygonPoints);
    mymap.fitBounds(e.layer.getBounds());
  });

  // Escuchar el evento de edición terminada
  mymap.on('draw:edited', function (e) {
    var layers = e.layers;
    layers.eachLayer(function (layer) {
      // Aquí puedes acceder a los puntos del polígono
      var polygonPoints = layer.getLatLngs();
      filtrar_poligono(polygonPoints);
    });
  });

  // Eliminar el poligono
  mymap.on('draw:deleted', function(e){
    $("#filtrar_puntos").val("");
    filtrar_ajax();    
  });


});

function filtrar_poligono(poligono) {
  var array = poligono[0];
  var salida = new Array();
  for(let i = 0; i < array.length; i++) {
    let a = array[i];
    salida.push(a);
  }
  salida.push(array[0]);
  var s = JSON.stringify(salida);
  $("#page").val(0);
  $("#filtrar_puntos").val(s);
  filtrar_ajax();
}

function dibujar() {
  if (window.drawnPolygon != null) {
    document.querySelector(".leaflet-draw-edit-edit").click();
  } else {
    document.querySelector(".leaflet-draw-draw-polygon").click();
  }
}
function borrar() {
  mymap.removeLayer(drawnPolygon);
  window.drawnPolygon = null;
}
</script>