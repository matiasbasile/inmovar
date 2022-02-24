<?php
include_once("includes/init.php");
$nombre_pagina = "contacto";
include_once("includes/funciones.php");
$id_origen = 6; // LA CONSULTA VIENE DEL FORM DE CONTACTO
$id_usuario = 0;

if (isset($_POST["id_usuario"])) {
  $id_usuario = filter_var($_POST["id_usuario"],FILTER_SANITIZE_STRING);
  $q = mysqli_query($conx,"SELECT * FROM com_usuarios WHERE id = $id_usuario");
  if (mysqli_num_rows($q)>0) {
     $usuario = mysqli_fetch_object($q);
     $contacto_para = $usuario->email;
	 $id_origen = 8; // LA CONSULTA VIENE DE STAFF
  } 
}

$titulo_pagina = "Contacto";
$breadcrumb = array(
  array("titulo"=>"Contacto","link"=>"/contacto/")
);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body id="contacto_page" class="bg-gray">
  
<?php include("includes/header.php"); ?>

<div class="container">
  <form onsubmit="return enviar_contacto()" class="form">
    <div class="page-heading">
      <h2>Datos de Contacto</h2>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="label-control" for="contacto_nombre">Nombre *</label>
          <input type="text" id="contacto_nombre" class="form-control" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="label-control" for="contacto_apellido">Apellido *</label>
          <input type="text" id="contacto_apellido" class="form-control" />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="label-control" for="contacto_email">Email *</label>
          <input type="email" id="contacto_email" class="form-control" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="label-control" for="contacto_telefono">Teléfono *</label>
          <input type="tel" id="contacto_telefono" class="form-control" />
        </div>
      </div>
    </div>

    <div class="page-heading mt30">
      <h2>Datos de Propiedad</h2>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="label-control" for="contacto_localidad">Localidad *</label>
          <input type="tel" id="contacto_localidad" class="form-control" />
        </div>
      </div>      
      <div class="col-md-6">
        <div class="form-group">
          <label class="label-control" for="contacto_tipo_propiedad">Tipo de Propiedad</label>
          <select class="form-control" id="contacto_tipo_propiedad">
            <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(array("mostrar_todos"=>1)); ?>
            <?php foreach ($tipo_propiedades as $tipo) { ?>
              <option value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="label-control" for="contacto_dormitorios">Dormitorios</label>
          <select class="form-control" id="contacto_dormitorios">
            <option>-</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>Más de 7</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="label-control" for="contacto_banios">Baños</label>
          <select class="form-control" id="contacto_banios">
            <option>-</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>Más de 7</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label class="label-control" for="contacto_mensaje">Comentarios *</label>
          <textarea id="contacto_mensaje" class="form-control"></textarea>
        </div>
      </div>
      <div class="col-md-12 tac mt40">
        <input type="submit" id="contacto_submit" value="enviar" class="btn btn-primary btn-block" />
      </div>
    </div>

  </form>
</div>
<?php include("includes/footer.php"); ?>

<script type="text/javascript">
    //OWL CAROUSEL(2) SCRIPT
jQuery(document).ready(function ($) {
"use strict";
$(".owl-carouselmarcas").owlCarousel({
      items : 5,
      itemsDesktop : [1279,2],
      itemsDesktopSmall : [979,2],
      itemsMobile : [639,1],
    });
});

var enviando = 0;
function enviar_contacto() {
  if (enviando == 1) return;
  var nombre = $("#contacto_nombre").val();
  var apellido = $("#contacto_apellido").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var asunto = $("#contacto_asunto").val();
  var tipo_propiedad = $("#contacto_tipo_propiedad").val();
  var dormitorios = $("#contacto_dormitorios").val();
  var banios = $("#contacto_banios").val();
  var localidad = $("#contacto_localidad").val();
  
  if (isEmpty(nombre)) {
    alert("Por favor ingrese un nombre");
    $("#contacto_nombre").focus();
    return false;          
  }
  if (isEmpty(apellido)) {
    alert("Por favor ingrese un apellido");
    $("#contacto_apellido").focus();
    return false;          
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_email").focus();
    return false;          
  }
  if (isEmpty(telefono)) {
    alert("Por favor ingrese un telefono");
    $("#contacto_telefono").focus();
    return false;          
  }
  if (isEmpty(localidad)) {
    alert("Por favor ingrese una localidad");
    $("#contacto_localidad").focus();
    return false;
  }
  if (isEmpty(mensaje)) {
    alert("Por favor ingrese un mensaje");
    $("#contacto_mensaje").focus();
    return false;              
  }
  var v = "Localidad: "+localidad+"\nTipo: "+tipo_propiedad+"\nDormitorios: "+dormitorios+"\nBaños: "+banios+"\nMensaje: "+mensaje;
  $("#contacto_submit").attr('disabled', 'disabled');
  var datos = {
    "para":"<?php echo $empresa->email ?>",
    "nombre":nombre+" "+apellido,
    "email":email,
    "mensaje":v,
    "telefono":telefono,
    "asunto":"Quiero Vender",
    "id_empresa":ID_EMPRESA,
    "id_origen":1,
  }
  enviando = 1;
  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        window.location.href = "<?php echo mklink ("web/gracias/") ?>";
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
        enviando = 0;
      }
    }
  });
  return false;
}
</script>

</body>
</html>
