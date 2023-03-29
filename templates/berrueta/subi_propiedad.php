<?php
if (!isset($_SESSION["id_propietario"]) || empty($_SESSION["id_propietario"])) {
  header("Location: ".mklink("/"));
}
include_once("includes/funciones.php");

$guardo = 0;
if (isset($_POST["calle"])) {
  include("./admin/resources/php/file_helper.php");
  $nombre = "REVISION Propiedad de ".$_SESSION["nombre"];
  $id_propietario = $_SESSION["id_propietario"];
  $id_empresa = $empresa->id;
  $id_tipo_inmueble = filter_var($_POST["id_tipo_inmueble"],FILTER_SANITIZE_STRING);
  $id_tipo_operacion = filter_var($_POST["id_tipo_operacion"],FILTER_SANITIZE_STRING);
  $fecha_ingreso = date("Y-m-d");
  $activo = 0;
  $id_localidad = filter_var($_POST["id_localidad"],FILTER_SANITIZE_STRING);
  $breve = filter_var($_POST["descripcion"],FILTER_SANITIZE_STRING);
  $calle = filter_var($_POST["calle"],FILTER_SANITIZE_STRING);
  $altura = filter_var($_POST["altura"],FILTER_SANITIZE_STRING);
  $piso = filter_var($_POST["piso"],FILTER_SANITIZE_STRING);
  $numero = filter_var($_POST["numero"],FILTER_SANITIZE_STRING);
  $ambientes = filter_var($_POST["ambientes"],FILTER_SANITIZE_STRING);
  $dormitorios = filter_var($_POST["dormitorios"],FILTER_SANITIZE_STRING);
  $cocheras = filter_var($_POST["cocheras"],FILTER_SANITIZE_STRING);
  $banios = filter_var($_POST["banios"],FILTER_SANITIZE_STRING);
  $superficie_cubierta = filter_var($_POST["superficie_cubierta"],FILTER_SANITIZE_STRING);
  $superficie_descubierta = filter_var($_POST["superficie_descubierta"],FILTER_SANITIZE_STRING);
  $observaciones = filter_var($_POST["observaciones"],FILTER_SANITIZE_STRING);
  
  $path = "";
  if (!empty($_FILES["path"]["name"])) {
    $path = "uploads/$empresa->id/propiedades/".filename($_FILES["path"]["name"],"",1);
    @move_uploaded_file($_FILES["path"]["tmp_name"],"./admin/$path");
  }  
  
  $sql = "INSERT INTO inm_propiedades (";
  $sql.= " nombre, id_propietario, id_empresa, id_tipo_inmueble, id_tipo_operacion, fecha_ingreso, activo, ";
  $sql.= " breve, calle, altura, piso, numero, ambientes, dormitorios, cocheras, banios, ";
  $sql.= " superficie_cubierta, superficie_descubierta, observaciones, path, id_localidad, ";
  $sql.= " relacionados_tipo, relacionados_cantidad, moneda ";
  $sql.= ") VALUES (";
  $sql.= " '$nombre', '$id_propietario', '$id_empresa', '$id_tipo_inmueble', '$id_tipo_operacion', '$fecha_ingreso', '$activo', ";
  $sql.= " '$breve', '$calle', '$altura', '$piso', '$numero', '$ambientes', '$dormitorios', '$cocheras', '$banios', ";
  $sql.= " '$superficie_cubierta', '$superficie_descubierta', '$observaciones', '$path', '$id_localidad', ";
  $sql.= " 'U',3,'$' ";
  $sql.= ")";
  $q = mysqli_query($conx,$sql);
  
  $insert_id = mysqli_insert_id($conx);
  
  // Guardamos las imagenes
  if (!empty($_FILES["path_multiple"]["name"])) {
    for($i=0;$i<sizeof($_FILES["path_multiple"]["name"]);$i++) {
      $path = "uploads/$empresa->id/propiedades/".filename($_FILES["path_multiple"]["name"][$i],"",1);
      @move_uploaded_file($_FILES["path_multiple"]["tmp_name"][$i],"./admin/$path");
      $sql = "INSERT INTO inm_propiedades_images (id_empresa,id_propiedad,path,orden) VALUES (";
      $sql.= "$id_empresa, $insert_id, '$path',$i )";
      mysqli_query($conx,$sql);
    }
  }
  $guardo = 1;
  
  $body = "";
  if (!empty($nombre)) $body.= "Nombre: $nombre <br/>";
  $headers = "From: $empresa->email\r\n";
  $headers.= "MIME-Version: 1.0\r\n";
  $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  @mail($empresa->email,"Aviso de Nueva Propiedad",$body,$headers);
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
      <div class="breadcrumb"><a href="<?php echo mklink("/") ?>"><img src="images/home-icon3.png" alt="Home" /> Home</a>
      <span>Sub&iacute; tu Propiedad</span></div>
      <big>Sub&iacute; tu Propiedad</big>
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
          <form onsubmit="return enviar_propiedad()" action="<?php echo mklink("subi-tu-propiedad/") ?>" method="post" enctype="multipart/form-data">
            <div class="border-box">
              <div class="info-title">datos del inmueble</div>
              <div class="box-space">
                <div class="form">
                  <div class="row">
                    <?php if ($guardo == 1) { ?>
                      <div class="mensaje">
                        La propiedad ha sido enviada correctamente. En breve nos comunicaremos con Ud.
                      </div>
                    <?php } ?>
                    <div class="col-md-6">
                      <input type="text" name="calle" id="calle" placeholder="Calle" />
                    </div>
                    <div class="col-md-6">
                      <input type="number" name="altura" id="altura" placeholder="Altura" />
                    </div>
                    <div class="col-md-6">
                      <input type="text" name="piso" placeholder="Piso" />
                    </div>
                    <div class="col-md-6">
                      <input type="text" name="numero" placeholder="Numero / Letra" />
                    </div>                
                    <div class="col-md-6">
                      <select id="provincia">
                        <option value="0">Provincia</option>
                        <?php
                        $q = mysqli_query($conx,"SELECT * FROM com_provincias ORDER BY nombre ASC");
                        while(($r=mysqli_fetch_object($q))!==NULL) { ?>
                          <option value="<?php echo $r->id ?>"><?php echo ($r->nombre)?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <select id="localidad" name="id_localidad">
                        <option value="0">Localidad</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <select name="id_tipo_operacion" id="tipo_operacion">
                        <option value="0">Tipo de Operacion</option>
                        <?php
                        $q = mysqli_query($conx,"SELECT * FROM inm_tipos_operacion ORDER BY orden ASC");
                        while(($r=mysqli_fetch_object($q))!==NULL) { ?>
                          <option value="<?php echo $r->id ?>"><?php echo ($r->nombre)?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <select name="id_tipo_inmueble" id="tipo_inmueble">
                        <option value="0">Tipo de Inmueble</option>
                        <?php
                        $q = mysqli_query($conx,"SELECT * FROM inm_tipos_inmueble ORDER BY orden ASC");
                        while(($r=mysqli_fetch_object($q))!==NULL) { ?>
                          <option value="<?php echo $r->id ?>"><?php echo ($r->nombre)?></option>
                        <?php } ?>
                      </select>
                    </div>
                    
                    <div class="col-md-6">
                      <input type="number" name="ambientes" min="0" id="ambientes" placeholder="N&uacute;mero de Ambientes" />
                    </div>
                    <div class="col-md-6">
                      <input type="number" name="dormitorios" min="0" id="dormitorios" placeholder="Cant. de Dormitorios" />
                    </div>
                    <div class="col-md-6">
                      <input type="number" name="cocheras" min="0" id="cocheras" placeholder="Cant. de Cocheras" />
                    </div>
                    <div class="col-md-6">
                      <input type="number" name="banios" min="0" id="banios" placeholder="Cant. de Ba&ntilde;os" />
                    </div>
                    <div class="col-md-6">
                      <input type="number" name="superficie_cubierta" min="0" id="superficie_cubierta" placeholder="Superficie Cubierta" />
                    </div>
                    <div class="col-md-6">
                      <input type="number" name="superficie_descubierta" min="0" id="superficie_descubierta" placeholder="Superficie Descubierta" />
                    </div>                    
                    
                    <div class="col-md-12">
                      <textarea name="descripcion" id="descripcion" placeholder="Describe brevemente de la propiedad"></textarea>
                    </div>
                    
                    <div class="col-md-12">
                      <textarea name="observaciones" placeholder="Observaciones para la inmobiliaria (lo que escribas aqui no se mostrar&aacute; p&uacute;blicamente)"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="info-title">fotos</div>
              <div class="box-space">
                <div class="form">
                  <div class="row">
                    <div class="col-md-12">
                      <label>Foto Principal: </label>
                      <input type="file" name="path"/>
                    </div>
                    <div class="col-md-12">
                      <label>Fotos Adicionales: </label>
                      <input type="file" multiple name="path_multiple[]"/>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12" style="padding-top: 40px;">
                      <input type="submit" value="enviar" class="btn btn-orange"/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
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
<script type="text/javascript">
$(document).ready(function(){
  $("#provincia").change(function(e){
    var id = $(e.currentTarget).val();
    $.ajax({
      "url":"/admin/localidades/function/get_by_provincia/"+id+"/",
      "dataType":"json",
      "success":function(r) {
        $("#localidad").empty();
        $("#localidad").append("<option value='0'>Localidad</option>");
        for(var i=0;i<r.results.length;i++) {
          var o = r.results[i];
          $("#localidad").append("<option value='"+o.id+"'>"+o.nombre+"</option>");
        }
      }
    })
  });
});
  
function enviar_propiedad() {
  
  var calle = $("#calle").val();
  if (isEmpty(calle)) {
    alert("Por favor ingrese una calle");
    $("#calle").focus();
    return false;
  }
  
  var altura = $("#altura").val();
  if (isEmpty(altura)) {
    alert("Por favor ingrese una altura");
    $("#altura").focus();
    return false;
  }
  
  var localidad = $("#localidad").val();
  if (localidad == 0) {
    alert("Por favor ingrese la localidad");
    $("#localidad").focus();
    return false;
  }  
  
  var tipo_operacion = $("#tipo_operacion").val();
  if (tipo_operacion == 0) {
    alert("Por favor ingrese el tipo de operacion");
    $("#tipo_operacion").focus();
    return false;
  }

  var tipo_inmueble = $("#tipo_inmueble").val();
  if (tipo_inmueble == 0) {
    alert("Por favor ingrese el tipo de inmueble");
    $("#tipo_inmueble").focus();
    return false;
  }
  
  var ambientes = $("#ambientes").val();
  if (isEmpty(ambientes)) {
    alert("Por favor ingrese algun valor.");
    $("#ambientes").focus();
    return false;
  }
  var dormitorios = $("#dormitorios").val();
  if (isEmpty(dormitorios)) {
    alert("Por favor ingrese algun valor.");
    $("#dormitorios").focus();
    return false;
  }
  var cocheras = $("#cocheras").val();
  if (isEmpty(cocheras)) {
    alert("Por favor ingrese algun valor.");
    $("#cocheras").focus();
    return false;
  }
  var banios = $("#banios").val();
  if (isEmpty(banios)) {
    alert("Por favor ingrese algun valor.");
    $("#banios").focus();
    return false;
  }
  var superficie_cubierta = $("#superficie_cubierta").val();
  if (isEmpty(superficie_cubierta)) {
    alert("Por favor ingrese algun valor.");
    $("#superficie_cubierta").focus();
    return false;
  }
  var superficie_descubierta = $("#superficie_descubierta").val();
  if (isEmpty(superficie_descubierta)) {
    alert("Por favor ingrese algun valor.");
    $("#superficie_descubierta").focus();
    return false;
  }
  var descripcion = $("#descripcion").val();
  if (isEmpty(descripcion)) {
    alert("Por favor ingrese algun valor.");
    $("#descripcion").focus();
    return false;
  }

  return true;
}
</script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){

  <?php if (!empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: '<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>',
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
