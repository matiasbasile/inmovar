<?php 
include "includes/init.php";
$preview = isset($get_params["preview"]) ? filter_var($get_params["preview"],FILTER_SANITIZE_STRING) : 0;

$entrada = $entrada_model->get($id,array(
  "activo"=>(($preview == 1)?-1:1),
));

?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>
  <?php include "includes/header.php" ?>
<!-- Page Title -->
<div class="page-title">
  <div class="container">
    <div class="pull-left">
      <h2><?php echo $entrada->titulo ?></h2>
    </div>
    <div class="breadcrumb">
      <ul>
        <li><a href="<?php echo mklink ("/") ?>">Inicio</a><span>|</span></li>
        <li><?php echo $entrada->titulo ?></li>
      </ul>
    </div>
  </div>
</div>

<!-- About Us -->
<div class="about-us">
  <div class="container">
    <img src="<?php echo $entrada->path ?>">
    <div class="border-title"><?php echo $entrada->titulo ?></div>
    <?php echo $entrada->texto ?>
    <div class="communicate-section">
      <div class="border-title">comunicate</div>
      <form onsubmit="return enviar_contacto()">
        <div class="row">
          <div class="col-md-6">
            <input class="form-control" id="contacto_nombre" type="text" name="Nombre" placeholder="Nombre">
          </div>
          <div class="col-md-6">
            <input class="form-control" id="contacto_telefono" type="tel" name="Teléfono" placeholder="Teléfono">
          </div>
          <div class="col-md-6">
            <input class="form-control" id="contacto_email" type="email" name="Email" placeholder="Email">
          </div>
          <div class="col-md-6">
            <select id="contacto_asunto">
              <option value="Asunto sin especificar">Asunto</option>
              <option value="Ventas">Ventas</option>
              <option value="Alquileres">Alquileres</option>
              <option value="Tasaciones">Tasaciones</option>
            </select>
          </div>
          <div class="col-md-12">
            <textarea class="form-control" id="contacto_mensaje" placeholder="Mensaje"></textarea>
          </div>
          <div class="col-md-12">
            <input class="btn btn-red" id="contacto_submit" type="submit" value="enviar mensaje">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include "includes/footer.php" ?>
<script type="text/javascript"> function enviar_contacto() {
    
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var asunto = $("#contacto_asunto").val();
  var id_origen = <?php echo (isset($id_origen) ? $id_origen : 0) ?>;
  
  if (isEmpty(nombre) || nombre == "Nombre") {
      alert("Por favor ingrese un nombre");
      $("#contacto_nombre").focus();
      return false;          
  }
  if (!validateEmail(email)) {
      alert("Por favor ingrese un email valido");
      $("#contacto_email").focus();
      return false;          
  }
  if (isEmpty(telefono) || telefono == "Telefono") {
      alert("Por favor ingrese un telefono");
      $("#contacto_telefono").focus();
      return false;          
  }
  if (isEmpty(mensaje) || mensaje == "Mensaje") {
      alert("Por favor ingrese un mensaje");
      $("#contacto_mensaje").focus();
      return false;              
  }    
  
  $("#contacto_submit").attr('disabled', 'disabled');
  var datos = {
    "para":"<?php echo $empresa->email ?>",
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "asunto":asunto,
    "id_empresa":ID_EMPRESA,
    "id_origen": ((id_origen != 0) ? id_origen : "Contacto"),
  }
  $.ajax({
    "url":"/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
        location.reload();
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
      }
    }
  });
  return false;
}
</script>
</html> 