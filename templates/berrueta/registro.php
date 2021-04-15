<?php
$guardo = 0;
include_once("includes/funciones.php");
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);

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
        <span>Registro</span>
      </div>
      <big>Registro</big>
    </div>
  </div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
  <div class="page">
    <div class="contact">
      <div class="border-box">
        <div class="box-space">
          <div class="title">Registro</div>
          <?php if ($guardo == 0) {
            $texto = $web_model->get_text("registro");?>
            <?php if (!empty($texto->texto)) { ?>
              <p><?php echo html_entity_decode($texto->texto,ENT_QUOTES); ?></p>
            <?php } ?>
          <?php } else {
            $texto = $web_model->get_text("registro_gracias");?>
            <?php if (!empty($texto->texto)) { ?>
              <p><?php echo html_entity_decode($texto->texto,ENT_QUOTES); ?></p>
            <?php } ?>
            <div style="text-align: center;">
              <a href="<?php echo mklink("login/") ?>" class="btn btn-orange">Entrar</a>
            </div>
          <?php } ?>
        </div>
        <?php if ($guardo == 0) { ?>
          <form action="<?php echo mklink("registro/")?>" method="post" onsubmit="return enviar_registro()">
            <div class="info-title">Datos del Usuario</div>
            <div class="box-space">
              <div class="form">
                <div class="row">
                  <div class="col-md-6">
                    <input type="text" id="registro_nombre" name="nombre" placeholder="Nombre y Apellido" />
                  </div>
                  <div class="col-md-6">
                    <input type="email" id="registro_email" name="email" placeholder="Email" />
                  </div>
                  <div class="col-md-6">
                    <input type="tel" id="registro_telefono" name="telefono" placeholder="Tel&eacute;fono" />
                  </div>
                  <div class="col-md-6">
                    <input type="tel" id="registro_celular" name="celular" placeholder="Celular" />
                  </div>
                  <div class="col-md-6">
                    <input type="password" id="registro_password" name="password" placeholder="Contrase&ntilde;a" />
                  </div>
                  <div class="col-md-6">
                    <input type="password" id="registro_password2" placeholder="Repetir contrase&ntilde;a" />
                  </div>
                  <div class="col-md-12">
                    <input type="submit" value="enviar" class="btn btn-orange" />
                  </div>
                </div>
              </div>
            </div>
            
          </form>
        <?php } ?>
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
  if (isEmpty(password)) {
    alert("Por favor ingrese su clave");
    $("#registro_password").focus();
    return false;
  }  
  var password2 = $("#registro_password2").val();
  if (password != password2) {
    alert("Por favor reingrese su clave");
    $("#registro_password2").focus();
    return false;
  }
  
  password = hex_md5(password);
  $("#registro_password").val(password);

  return true;
}
</script>
</body>
</html>
