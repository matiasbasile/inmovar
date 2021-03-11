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
      <h1>Registro</h1>
    </div>
  </div>
  <div class="bot-div mb40">
    <div class="form-bot container">
      <form onsubmit="return enviar_registro()" autocomplete="off">
        <label for="registro_nm">Tu nombre</label><br>
        <input id="registro_nm" autocomplete="off" type="text" placeholder="Ej: Juan Perez" /><br>

        <label for="registro_nm">Nombre de tu inmobiliaria</label><br>
        <input id="registro_sit" autocomplete="off" type="text" placeholder="Ej: Inmobiliaria Perez" /><br>

        <label for="registro_tl">Teléfono/Whatsapp</label><br>
        <input id="registro_tl" autocomplete="off" type="text" placeholder="Sin 0 ni 15. Ej: 221 1234567" /><br>

        <label for="registro_ml">Correo electrónico</label><br>
        <input id="registro_ml" autocomplete="new-password" value="<?php echo (isset($email) ? $email : "") ?>" type="text" placeholder="Ej: juan@inmobiliariaperez.com" /><br>

        <label for="registro_ps">Contraseña</label><br>
        <input id="registro_ps" autocomplete="new-password" type="password" placeholder="Contraseña" /><br>

        <input type="submit" id="submit_registro" class="button-submit" value="Enviar Registro"><br>

        <input type="checkbox" id="aceptar_terminos" />
        <label for="aceptar_terminos">Acepto los <a target="_blank" href="https://www.inmovar.com/entrada/terminos-y-condiciones-41238">términos y condiciones</a></label>

        <div class="g-recaptcha" data-sitekey="6LeHSTQUAAAAAA5FV121v-M7rnhqdkXZIGmP9N8E"></div>

      </form>
      <a href="/admin/">Ya tengo un usuario</a>
    </div>
  </div>

<script type="text/javascript" src="/admin/resources/js/jquery.js"></script>
<script type="text/javascript" src="/admin/resources/js/underscore.js"></script>
<script type="text/javascript" src="/admin/resources/js/backbone.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>
<script type="text/javascript" src="/admin/resources/js/md5.js"></script>
<script type="text/javascript" src="/admin/resources/js/libs/bootstrap.min.js"></script>
<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
window.flag = 0;
function enviar_registro() {
  if (window.flag != 0) return;
  var nombre = $("#registro_nm").val();
  var sitio = $("#registro_sit").val();
  var email = $("#registro_ml").val();
  var telefono = $("#registro_tl").val();
  var password = $("#registro_ps").val();
  var id_plan = 3;
  
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

  if (!$("#aceptar_terminos").is(":checked")) {
    alert("Por favor acepte los terminos y condiciones");
    return false;
  }  

  window.flag = 1;
  $("#submit_registro").text('Enviando...');
  $("#submit_registro").attr('disabled', 'disabled');
  var datos = {
    "nombre":nombre,
    "nombre_inmobiliaria":sitio,
    "telefono":telefono,
    "email":email,
    "password":password,
    "id_plan":id_plan,
    "g-recaptcha-response":grecaptcha.getResponse(),
  }
  $.ajax({
    "url":"/admin/empresas/function/registro_inmovar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      window.flag = 0;
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
    },
    "error":function() {
      window.flag = 0;
    }
  });
  return false;
}  

function enviar_login(email,password) {
  password = hex_md5(password);
  $.ajax({
    url: '/admin/login/check/',
    type: 'POST',
    dataType: 'json',
    data: {
      'nombre': email, 
      'password': password 
    },
    success: function(data, textStatus, xhr) {
      if (data.error == false) {
        window.location = "/admin/app/";
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