<?php
include_once("includes/funciones.php");
$guardo = 0;

if (isset($_POST["nombre"])) {
  $nombre = filter_var($_POST["nombre"],FILTER_SANITIZE_STRING);
  $email = filter_var($_POST["email"],FILTER_SANITIZE_STRING);
  $password = filter_var($_POST["password"],FILTER_SANITIZE_STRING);
  $telefono = filter_var($_POST["telefono"],FILTER_SANITIZE_STRING);
  $celular = filter_var($_POST["celular"],FILTER_SANITIZE_STRING);
  $sql = "INSERT INTO inm_propietarios (id_empresa,nombre,email,password,telefono,celular) VALUES (";
  $sql.= "$empresa->id, '$nombre', '$email', '$password', '$telefono', '$celular') ";
  $r = mysqli_query($conx,$sql);
  $guardo = 1;
  
  // Enviamos el email al usuario
}
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
      <div class="breadcrumb">
        <a href="<?php echo mklink("/") ?>"><img src="images/home-icon3.png" alt="Home" /> Home</a>
        <span>Ingreso</span>
      </div>
      <big>Ingreso</big>
    </div>
  </div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper" style="margin-bottom: 80px">
  <div class="page">
    <div class="contact">
      <div class="border-box">
        <div class="box-space">
          <div class="title">Ingreso</div>
          <p>Para subir una propiedad, es necesario entrar al sistema. Utiliza el formulario siguiente con los datos ingresados en el registro:</p>
        </div>
        <form onsubmit="return enviar()">
          <div class="info-title">Datos de Usuario</div>
          <div class="box-space">
            <div class="form">
              <div class="row">
                <div class="col-md-12">
                  <input type="email" id="email" name="email" placeholder="Email" />
                </div>
                <div class="col-md-12">
                  <input type="password" id="password" name="password" placeholder="Contrase&ntilde;a" />
                </div>
                <div class="col-md-12">
                  <input type="submit" value="entrar" class="btn btn-orange" />
                </div>
              </div>
            </div>
          </div>
        </form>
        <div class="info-title">&iquest;Aun no tienes cuenta?</div>
        <div class="col-md-12" style="margin-top: 10px; text-align: center">
          <a href="<?php echo mklink("registro/")?>" class="btn btn-orange">Registrate</a>
        </div>
      </div>
    </div>
  </div>
</div>

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
jQuery(document).ready(function($) {
	$("#email").focus();
	$(".login_box input[type=text]").keypress(function(e){
		if (e.keyCode == 13) enviar();
	});
});

function enviar() {
  try {
    var email = validate_input("email",IS_EMAIL,"Por favor ingrese un email correcto");
    var password = validate_input("password",IS_EMPTY,"Por favor ingrese su clave de acceso");    
  } catch(e) {
    return false;
  }
  password = hex_md5(password);
  $.ajax({
    url: '/admin/login/check_propietario/',
    type: 'POST',
    dataType: 'json',
    data: {email: email, 'password': password },
    success: function(data, textStatus, xhr) {
      if (data.error == false && data.id_empresa == ID_EMPRESA) {
        location.href="<?php echo mklink("subi-tu-propiedad/")?>";
      } else {
        if (data.mensaje !== undefined) {
          alert(data.mensaje);
        } else {
          alert("Nombre de usuario y/o password incorrectos.");
        }
        $("#email").focus();                
      }
    },
  });
  return false;
}
</script>
</body>
</html>
