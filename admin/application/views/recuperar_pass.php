<!DOCTYPE html>
<html>
<head>
<title>Inmovar</title>
<base href="<?php echo current_url(); ?>"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/admin/resources/css/common.css">
<link rel="stylesheet" href="/admin/resources/css/login.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="login-page">
  <div class="top-div">
    <div class="header">
      <div class="row">
        <div class="col-lg-5 col-xs-12 logo">
          <img src="/admin/resources/images/logo-login.png" alt="Inmovar">
        </div>
        <div class="col-lg-7 col-xs-12">
          <div class="linea-2">
            <div class="dtc">
              <span>¿Todavía no tenes cuenta en Inmovar?</span>          
            </div>
            <div class="dtc vat">
              <a href="login/registro/" class="button-registrate">REGISTRATE GRATIS</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-top">
      <h1>Recuperar Contraseña</h1>
    </div>
  </div>
  <div class="bot-div">
    <div class="form-bot container">
      <form onsubmit="return enviar()">
        <label for="email">Correo electrónico</label><br>
        <input type="text" id="email" placeholder="Ingresa tu email"><br>
        <input type="submit" class="button-submit" value="Enviar Contraseña"><br>
      </form>
      <a href="/admin/">Volver a iniciar sesión</a>
    </div>
  </div>

<script type="text/javascript" src="/admin/resources/js/jquery.js"></script>
<script type="text/javascript" src="/admin/resources/js/underscore.js"></script>
<script type="text/javascript" src="/admin/resources/js/backbone.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>
<script type="text/javascript" src="/admin/resources/js/md5.js"></script>
<script type="text/javascript" src="/admin/resources/js/libs/bootstrap.min.js"></script>
<script type="text/javascript" src="/admin/resources/js/common.js"></script>

<script type="text/javascript">
jQuery(document).ready(function($) {
  $("#nombre").focus();
  $(".input").keypress(function(e){
    if (e.keyCode == 13) enviar();
  });
});

function enviar() {
  var email = "";
  try {
    email = validate_input("email",IS_EMPTY,"Por favor ingrese su email");  
  } catch(e) {
    return false;
  }
  $.ajax({
    "url": '/admin/usuarios/function/recuperar_pass/',
    "type": 'POST',
    "dataType": 'json',
    "data": {
      "email": email,
    },
    success: function(data) {
      alert(data.mensaje);
      location.reload();
    },
  });
  return false;
}
</script>

</body>
</html>