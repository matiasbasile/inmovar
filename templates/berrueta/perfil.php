<?php
if (!isset($_SESSION["id_propietario"]) || empty($_SESSION["id_propietario"])) {
  header("Location: ".mklink("/"));
}
include_once("includes/funciones.php");

$id = isset($_SESSION["id_propietario"]) ? $_SESSION["id_propietario"] : 0;
$guardo = 0;
if (isset($_POST["nombre"])) {
  $nombre = filter_var($_POST["nombre"],FILTER_SANITIZE_STRING);
  $email = filter_var($_POST["email"],FILTER_SANITIZE_STRING);
  $password = filter_var($_POST["password"],FILTER_SANITIZE_STRING);
  $telefono = filter_var($_POST["telefono"],FILTER_SANITIZE_STRING);
  $celular = filter_var($_POST["celular"],FILTER_SANITIZE_STRING);
  $direccion = filter_var($_POST["direccion"],FILTER_SANITIZE_STRING);
  
  $sql = "UPDATE inm_propietarios SET ";
  $sql.= "nombre = '$nombre', email = '$email', telefono = '$telefono', celular = '$celular', direccion = '$direccion' ";
  if (!empty($password)) $sql.= ",password = '$password' ";
  $sql.= "WHERE id = $id AND id_empresa = $empresa->id ";
  mysqli_query($conx,$sql);
  
  $_SESSION["nombre"] = $nombre;
  $_SESSION["email"] = $email;
  $guardo = 1;
}
$q = mysqli_query($conx,"SELECT * FROM inm_propietarios WHERE id = $id AND id_empresa = $empresa->id");
if (mysqli_num_rows($q)<=0) {
  header("Location: ".mklink("/"));
}
$perfil = mysqli_fetch_object($q);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>

<!-- TOP WRAPPER -->
<div class="top-wrapper">
  <?php include("includes/header.php"); ?>
  <div class="page-title">
    <div class="page">
      <div class="breadcrumb"><a href="<?php echo mklink("/") ?>"><img src="images/home-icon3.png" alt="Home" /> Home</a>
      <span>Mis datos</span></div>
      <big>Mis datos</big>
    </div>
  </div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
  <div class="page">
    <div class="row">
      <div class="registered-user">
        <?php include("includes/sidebar_propietario.php"); ?>
        <div class="col-md-9 primary">
          <div class="border-box">
            <div class="info-title">mis datos</div>
            <div class="box-space">
              <form action="<?php echo mklink("perfil/") ?>" method="post" onsubmit="return enviar_registro()">
                <div class="form">
                  <div class="row">
                    <?php if ($guardo == 1) { ?>
                      <div class="mensaje">
                        Los datos han sido guardados correctamente.
                      </div>
                    <?php } ?>                    
                    <div class="col-md-12">
                      <input type="text" id="registro_nombre" value="<?php echo $perfil->nombre ?>" name="nombre" placeholder="Nombre y Apellido" />
                    </div>
                    <div class="col-md-6">
                      <input type="email" id="registro_email" name="email" value="<?php echo $perfil->email ?>" placeholder="Email" />
                    </div>
                    <div class="col-md-6">
                      <input type="tel" id="registro_telefono" name="telefono" value="<?php echo $perfil->telefono ?>" placeholder="Tel&eacute;fono" />
                    </div>
                    <div class="col-md-6">
                      <input type="tel" id="registro_celular" name="celular" value="<?php echo $perfil->celular ?>" placeholder="Celular" />
                    </div>
                    <div class="col-md-6">
                      <input type="tel" id="registro_direccion" name="direccion" value="<?php echo $perfil->direccion ?>" placeholder="Direccion" />
                    </div>
                    <div class="col-md-6">
                      <input type="password" id="registro_password" name="password" placeholder="Escriba aqui para cambiar contrase&ntilde;a" />
                    </div>
                    <div class="col-md-6">
                      <input type="password" id="registro_password2" placeholder="Repetir contrase&ntilde;a" />
                    </div>
                    <div class="col-md-12">
                      <input type="submit" value="guardar" class="btn btn-orange" />
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/consulta_rapida.php"); ?>

<?php include("includes/footer.php"); ?>

<!-- SCRIPT'S --> 
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/map.js"></script> 
<script type="text/javascript" src="js/custom.js"></script> 
<script type="text/javascript">
//MAP SCRIPT
$(document).ready(function(){var b=new google.maps.LatLng(<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>);var c={center:b,zoom:15,mapTypeId:google.maps.MapTypeId.ROADMAP,styles:[{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]},{featureType:"water",elementType:"labels",stylers:[{visibility:"on"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}]};var d=new google.maps.Map(document.getElementById("map"),c);var a=new google.maps.Marker({position:b,map:d,icon:"images/map-place.png"});$(window).resize(function(){var e=d.getCenter();google.maps.event.trigger(d,"resize");d.setCenter(e)})});  
</script>
<script type="text/javascript" src="/admin/resources/js/md5.js"></script>
<script type="text/javascript">
function enviar_registro() {
  
  var nombre = $("#registro_nombre").val();
  if (isEmpty(nombre)) {
    alert("Por favor ingrese su nombre");
    $("#registro_nombre").focus();
    return false;
  }
  
  var email = $("#registro_email").val();
  if (!validateEmail(email)) {
    alert("Por favor ingrese su email");
    $("#registro_email").focus();
    return false;
  }
  
  var telefono = $("#registro_telefono").val();
  if (isEmpty(telefono)) {
    alert("Por favor ingrese su telefono");
    $("#registro_telefono").focus();
    return false;
  }  
  
  var celular = $("#registro_celular").val();
  if (isEmpty(celular)) {
    alert("Por favor ingrese su celular");
    $("#registro_celular").focus();
    return false;
  }
  
  var password = $("#registro_password").val();
  if (!isEmpty(password)) {
    var password2 = $("#registro_password2").val();
    if (password != password2) {
      alert("Por favor reingrese su clave para cambiarla");
      $("#registro_password2").focus();
      return false;
    }
    password = hex_md5(password);
    $("#registro_password").val(password);    
  }

  return true;
}
</script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){

  <?php if (!empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
    }).addTo(mymap);

    var icono = L.icon({
      iconUrl: 'images/map-place.png',
      iconSize:     [60, 60], // size of the icon
      iconAnchor:   [30, 30], // point of the icon which will correspond to marker's location
    });

    <?php
    $posiciones = explode("/",$empresa->posiciones);
    for($i=0;$i<sizeof($posiciones);$i++) { 
      $pos = explode(";",$posiciones[$i]); ?>
      L.marker([<?php echo $pos[0] ?>,<?php echo $pos[1] ?>],{
        icon: icono
      }).addTo(mymap);
    <?php } ?>

  <?php } ?>

});
</script>
</body>
</html>
