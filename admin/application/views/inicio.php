<!DOCTYPE html>
<html translate="no" lang="es">
<head>
<title><?php echo PROJECT_NAME ?></title>
<base href="<?php echo current_url(); ?>"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/admin/resources/css/common.css">
<link rel="stylesheet" href="/admin/resources/css/login.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#<?php echo COLOR_1 ?>">
<style type="text/css">
:root {
  --c1: #<?php echo COLOR_1 ?>;          <?php // Color principal (AZUL) ?>
  --c1_alpha: #<?php echo COLOR_1 ?>75;  <?php // Sombra de color principal ?>
  --c2: #<?php echo COLOR_2 ?>;          <?php // Color secundario (VERDE) ?>
}
</style>
<meta name="MobileOptimized" content="width">
<meta name="HandheldFriendly" content="true">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="shortcut icon" href="resources/images/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" href="resources/images/propiedades.png">
<link rel="apple-touch-startup-image" href="resources/images/propiedades.png">
<link rel="manifest" href="https://app.inmovar.com/admin/application/views/manifest.json">
<?php if (!empty(CSS_LOGIN)) { ?>
  <link rel="stylesheet" href="<?php echo CSS_LOGIN ?>">
<?php } ?>
</head>
<body class="login-page">
  <div class="top-div">
    <div class="header">
      <div class="row">
        <div class="col-lg-5 col-xs-12 logo">
          <img src="<?php echo LOGO_LOGIN ?>" alt="<?php echo PROJECT_NAME ?>">
        </div>
        <div class="col-lg-7 col-xs-12">
          <?php if (PROJECT_NAME == "Inmovar") { ?>
            <div class="linea-2">
              <div class="dtc">
                <span>¿Todavía no tenes cuenta en <?php echo PROJECT_NAME ?>?</span>          
              </div>
              <div class="dtc vat">
                <a href="login/registro/" class="button-registrate">REGISTRATE GRATIS</a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="form-top">
      <h1>Iniciar sesión</h1>
    </div>
  </div>
  <div class="bot-div">
    <div class="form-bot container">
      <form onsubmit="return enviar()">
        <label for="email">Correo electrónico</label><br>
        <input type="text" id="email" value="<?php echo isset($_GET["email"]) ? $_GET["email"] : "" ?>" placeholder="Ingresa tu email"><br>

        <label for="password">Contraseña</label><br>
        <input type="password" id="password" placeholder="Ingresa tu contraseña"><br>

        <input type="submit" class="button-submit" value="Ingresar a <?php echo PROJECT_NAME ?>"><br>

        <input type="checkbox" id="aceptar_terminos" />
        <label for="aceptar_terminos">Acepto los <a target="_blank" href="https://www.inmovar.com/entrada/terminos-y-condiciones-41238">términos y condiciones</a></label>
      </form>
      <a href="login/recuperar/">¿Olvidaste tu contraseña?</a>
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

if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('sw_app.js')
    .then(reg => console.log('Registro de SW exitoso', reg))
    .catch(err => console.warn('Error al tratar de registrar el sw', err))
}


jQuery(document).ready(function($) {
  $("#nombre").focus();
  $(".input").keypress(function(e){
    if (e.keyCode == 13) enviar();
  });
});
var flag = 0;
function enviar() {
  try {
    var email = validate_input("email",IS_EMPTY,"Por favor ingresa tu email.");
    var password = validate_input("password",IS_EMPTY,"Por favor ingresa tu clave.");
    password = unescape(password); // Problema con passwords que contenian $
    password = hex_md5(password);    
  } catch(e) {
    return false;
  }

  if (!$("#aceptar_terminos").is(":checked")) {
    alert("Por favor acepte los terminos y condiciones");
    return false;
  }

  if (flag == 1) return;
  flag = 1;
  $.ajax({
    url: '/admin/login/check',
    type: 'POST',
    dataType: 'json',
    data: {nombre: email, 'password': password },
    success: function(data, textStatus, xhr) {
      flag = 0;
      if (data.error == false) {
        window.location = "/admin/app/";
      } else {
        if (data.mensaje !== undefined) {
          alert(data.mensaje);
        } else {
          alert("Error al enviar los datos.");
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