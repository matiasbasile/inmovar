<?php 
include("includes/init.php");
$email_registro = isset($get_params["email"]) ? urldecode($get_params["email"]) : "";
$id_plan = isset($get_params["id_plan"]) ? $get_params["id_plan"] :9;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="registro_page">

<div class="header">
  <?php include("includes/header.php"); ?>
</div>

<div class="registro-container">
  <div class="container">
    <div class="section-title"> 
      <h1>Registrate en <?php echo ucfirst($empresa->nombre) ?></h1>
      <p>
        Comenzá a usar <?php echo ucfirst($empresa->nombre) ?> totalmente GRATIS. <br>
        Registrate sin cargo y sin tarjetas de crédito
      </p>
    </div>
    <div class="registro_div">
      <div class="planes-block">
        <form onsubmit="return enviar_registro()" autocomplete="off">
          <div class="row">
            <div class="col-md-12">          
              <input id="registro_nm" autocomplete="off" type="text" placeholder="Tu nombre" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">          
              <input id="registro_sit" autocomplete="off" type="text" placeholder="Nombre de tu inmobiliaria" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">          
              <input id="registro_ml" value="<?php echo $email_registro ?>" autocomplete="new-password" type="text" placeholder="Tu email" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">          
              <input id="registro_tl" autocomplete="off" type="text" placeholder="Tu Whatsapp (telefono completo sin 0 ni 15)" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">          
              <input id="registro_ps" autocomplete="new-password" type="password" placeholder="Contraseña" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="g-recaptcha" data-sitekey="6LeHSTQUAAAAAA5FV121v-M7rnhqdkXZIGmP9N8E"></div>
            </div>
            <div class="col-md-6">
              <button type="submit" id="submit_registro" class="btn mt20 btn-aquamarine">Iniciar Registro</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>

<script type="text/javascript" src="/sistema/resources/js/md5.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
function enviar_registro() {
    
  var nombre = $("#registro_nm").val();
  var sitio = $("#registro_sit").val();
  var email = $("#registro_ml").val();
  var telefono = $("#registro_tl").val();
  var password = $("#registro_ps").val();
  
  if (isEmpty(nombre)) {
    alert("Por favor ingrese un nombre");
    $("#registro_nm").focus();
    return false;
  }
  if (isEmpty(sitio)) {
    alert("Por favor ingrese el nombre de la inmobiliaria.");
    $("#registro_sit").focus();
    return false;
  }

  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#registro_ml").focus();
    return false;
  }

  if (isEmpty(telefono)) {
    alert("Por favor ingrese su telefono.");
    $("#registro_tl").focus();
    return false;
  }
  if (!isTelephone(telefono)) {
    alert("Ingresa tu numero de celular sin 0 y sin 15.");
    $("#registro_tl").focus();
    return false;    
  }

  if (isEmpty(password)) {
    alert("Por favor ingrese un password");
    $("#registro_ps").focus();
    return false;
  }
  $("#submit_registro").text('Enviando...');
  $("#submit_registro").attr('disabled', 'disabled');
  var datos = {
    "nombre":nombre,
    "nombre_inmobiliaria":sitio,
    "telefono":telefono,
    "email":email,
    "password":password,
    "id_plan":"<?php echo $id_plan ?>",
    "casaclick":"<?php echo isset($get_params["cc"]) ? 1 : 0 ?>",
    "g-recaptcha-response":grecaptcha.getResponse(),
  }
  $.ajax({
    "url":"https://www.varcreative.com/sistema/empresas/function/registro_inmovar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        enviar_login(email,password);
      } else {
        if (r.mensaje != undefined) {
          alert(r.mensaje);
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");  
        }
        $("#submit_registro").text('Iniciar Registro');
        $("#submit_registro").removeAttr('disabled');
      }
    }
  });
  return false;
}  

function enviar_login(email,password) {
  password = hex_md5(password);
  $.ajax({
    url: 'https://www.varcreative.com/sistema/login/check/',
    type: 'POST',
    dataType: 'json',
    data: {
      'nombre': email, 
      'password': password 
    },
    success: function(data, textStatus, xhr) {
      if (data.error == false) {
        window.location = "https://www.varcreative.com/sistema/app/";
      } else {
        if (data.mensaje !== undefined) {
          alert(data.mensaje);
        } else {
          alert("Nombre de usuario y/o password incorrectos.");
        }
        $("#nombre").focus();                
      }
    },
  });
}
</script>
</body>
</html>