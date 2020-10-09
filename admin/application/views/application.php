<?php
header('Content-Type: text/html; charset=UTF-8');
if ( extension_loaded( 'zlib' ) ) { ob_start(); }
ob_start('slib_compress_html');
function lang($languages=array()) {
  $l = (isset($_SESSION["lang"]) ? $_SESSION["lang"] : "es");
  return isset($languages[$l]) ? $languages[$l] : "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="/admin/resources/fonts/product-sans/stylesheet.css" type="text/css" />
<link rel="shortcut icon" href="resources/images/favicon.ico" type="image/x-icon">
<title><?php echo (isset($empresa)) ? (((isset($volver_superadmin) && $volver_superadmin == 1) ? $empresa->id." - " : "").$empresa->nombre) : ""; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<base href="<?php echo $base_url; ?>"/>
<style type="text/css">
:root {
  --c1: #1d36c2;          <?php // Color principal (AZUL) ?>
  --c1_alpha: #1d36c275;  <?php // Sombra de color principal ?>
  --c2: #0dd384;          <?php // Color secundario (VERDE) ?>
}
</style>

<?php if(!empty($css_files)) { ?>
  <?php foreach($css_files as $file) { ?>
    <link rel="stylesheet" href="<?php echo $file ?>"/>
  <?php } ?>
<?php } else { ?>
  <link rel="stylesheet" href="resources/css/min.css"/>
<?php } ?>  
<link rel="stylesheet" href="resources/css/font-awesome.min.css" type="text/css" />
</head>
<body>
<script type="text/javascript">
var inicio = '<?php echo $inicio; ?>';
const PERFIL = '<?php echo $perfil; ?>';
const IDIOMA = '<?php echo $idioma; ?>';
const ID_USUARIO = "<?php echo $id_usuario; ?>";
const ID_SUCURSAL = "<?php echo $id_sucursal; ?>";
const ID_VENDEDOR = "<?php echo $id_vendedor; ?>";
const NOMBRE_USUARIO = "<?php echo $nombre_usuario; ?>";
const PATH_USUARIO = "<?php echo $path_usuario; ?>";
const EMAIL_USUARIO = "<?php echo $email; ?>";
const SOLO_USUARIO = "<?php echo $solo_usuario; // Solo ve lo que creo el propio usuario ?>"; 
const USUARIO_PPAL = "<?php echo $usuario_ppal; // Indica si es el usuario principal de la cuenta ?>"; 
const ESTADO = <?php echo $estado; ?>;
const LOCAL = "<?php echo $local; ?>";
const OCULTAR_NOTIFICACIONES = "<?php echo $ocultar_notificaciones; ?>";
const VOLVER_SUPERADMIN = "<?php echo $volver_superadmin; ?>";
const USUARIO_HORA_DESDE = "<?php echo $usuario_hora_desde ?>";
const ID_EMPRESA_FACTURACION = "<?php echo $id_empresa_facturacion ?>";
const MENSAJE_CUENTA_NIVEL = "<?php echo $mensaje_cuenta_nivel ?>";
const LATITUD = "<?php echo $latitud ?>";
const LONGITUD = "<?php echo $longitud ?>";

<?php
// Dominio por defecto
if(!empty($empresa->dominios)) {
  $dominio = $empresa->dominios[0]; 
  if (substr($dominio, -1) != "/") $dominio.="/";
} else {
  $dominio = ($empresa->id_web_template != 0 && isset($empresa->dominio_varcreative)) ? $empresa->dominio_varcreative : "";
}
echo "const DOMINIO = '$dominio';";

// Pasamos todos los atributos del objeto $empresa como constantes de javascript
foreach($empresa as $key => $value) {
  if (!is_array($value)) {
    $value = nl2br($value);
    $value = str_replace("\n","",$value);
    echo "const ".strtoupper($key)." = '$value';\r\n";
  }
  else if ($key == "config") {
    foreach($value as $kkey => $v) {
      $v = nl2br($v);
      $v = str_replace("\n","",$v);
      if (!empty($kkey)) echo "const ".strtoupper($kkey)." = '$v';\r\n";
    }
  }
}
?>
const API_KEY_GOOGLE_MAPS = "AIzaSyAXpROdHVy8YYxLeemEyR1hVDCRTL_4UdE";
</script>
<?php
include_once "application/views/templates/blocks/single_upload.php";

// Cargamos los templates de acuerdo al proyecto
if ($empresa->id_proyecto > 0) {
  foreach($permisos as $p) {
    if ($p->id_modulo != 0 && file_exists("application/views/templates/".((!empty($p->dir))?$p->dir."/":"")."$p->nombre.php"))
      include_once "application/views/templates/".((!empty($p->dir))?$p->dir."/":"")."$p->nombre.php";
  }
} else {
  // Superadmin o vendedores
  if (file_exists("application/views/templates/planes.php")) include_once ("application/views/templates/planes.php");
  if (file_exists("application/views/templates/proyectos.php")) include_once ("application/views/templates/proyectos.php");
  if (file_exists("application/views/templates/monedas.php")) include_once ("application/views/templates/monedas.php");
  if (file_exists("application/views/templates/inm/tipos_inmueble.php")) include_once ("application/views/templates/inm/tipos_inmueble.php");
  if (file_exists("application/views/templates/inm/tipos_operacion.php")) include_once ("application/views/templates/inm/tipos_operacion.php");
  if (file_exists("application/views/templates/inm/tipos_estado.php")) include_once ("application/views/templates/inm/tipos_estado.php");
  if (file_exists("application/views/templates/versiones_db.php")) include_once ("application/views/templates/versiones_db.php");
  if (file_exists("application/views/templates/web/web_templates.php")) include_once ("application/views/templates/web/web_templates.php");
  if (file_exists("application/views/templates/web/web_textos.php")) include_once ("application/views/templates/web/web_textos.php");
}

// Estos modulos se cargan siempre
if (file_exists("application/views/templates/blocks/image_editor.php")) include_once ("application/views/templates/blocks/image_editor.php");
if (file_exists("application/views/templates/blocks/image_gallery.php")) include_once ("application/views/templates/blocks/image_gallery.php");
if (file_exists("application/views/templates/blocks/image_upload.php")) include_once ("application/views/templates/blocks/image_upload.php");
if (file_exists("application/views/templates/empresas.php")) include_once ("application/views/templates/empresas.php");
if (file_exists("application/views/templates/importacion.php")) include_once ("application/views/templates/importacion.php");
if (file_exists("application/views/templates/monedas.php")) include_once ("application/views/templates/monedas.php");
if (file_exists("application/views/templates/usuarios.php")) include_once ("application/views/templates/usuarios.php");
if (file_exists("application/views/templates/perfiles.php")) include_once ("application/views/templates/perfiles.php");
if (file_exists("application/views/templates/basic_search.php")) include_once ("application/views/templates/basic_search.php");
if (file_exists("application/views/templates/datepicker.php")) include_once ("application/views/templates/datepicker.php");
if (file_exists("application/views/templates/importar.php")) include_once ("application/views/templates/importar.php");
if (file_exists("application/views/templates/inicio.php")) include_once ("application/views/templates/inicio.php");
if (file_exists("application/views/templates/pagination.php")) include_once ("application/views/templates/pagination.php");
if (file_exists("application/views/templates/ayuda.php")) include_once ("application/views/templates/ayuda.php");
if (file_exists("application/views/templates/wait.php")) include_once ("application/views/templates/wait.php");
if (file_exists("application/views/templates/localidades.php")) include_once ("application/views/templates/localidades.php");
if (file_exists("application/views/templates/provincias.php")) include_once ("application/views/templates/provincias.php");
if (file_exists("application/views/templates/crm/emails_templates.php")) include_once ("application/views/templates/crm/emails_templates.php");
if (file_exists("application/views/templates/crm/consultas.php")) include_once ("application/views/templates/crm/consultas.php");
if (file_exists("application/views/templates/crm/contactos.php")) include_once ("application/views/templates/crm/contactos.php");
if (file_exists("application/views/templates/crm/eventos.php")) include_once ("application/views/templates/crm/eventos.php");
if (file_exists("application/views/templates/crm/tareas.php")) include_once ("application/views/templates/crm/tareas.php");
if (file_exists("application/views/templates/crm/origenes.php")) include_once ("application/views/templates/crm/origenes.php");
if (file_exists("application/views/templates/not/entradas.php")) include_once ("application/views/templates/not/entradas.php");
if (file_exists("application/views/templates/clientes.php")) include_once ("application/views/templates/clientes.php");
if (file_exists("application/views/templates/crm/contactos.php")) include_once ("application/views/templates/crm/contactos.php");
if (file_exists("application/views/templates/web/web_textos.php")) include_once ("application/views/templates/web/web_textos.php");
if (file_exists("application/views/templates/web/web_configuracion.php")) include_once ("application/views/templates/web/web_configuracion.php");
if (file_exists("application/views/templates/config/mi_cuenta.php")) include_once ("application/views/templates/config/mi_cuenta.php");
if (file_exists("application/views/templates/inm/dashboard.php")) include_once ("application/views/templates/inm/dashboard.php");
if (file_exists("application/views/templates/clientes.php")) include_once ("application/views/templates/clientes.php");
if (file_exists("application/views/templates/inm/tipos_inmueble.php")) include_once ("application/views/templates/inm/tipos_inmueble.php");
if (file_exists("application/views/templates/inm/tipos_operacion.php")) include_once ("application/views/templates/inm/tipos_operacion.php");
if (file_exists("application/views/templates/inm/tipos_estado.php")) include_once ("application/views/templates/inm/tipos_estado.php");
if (file_exists("application/views/templates/inm/propiedades.php")) include_once ("application/views/templates/inm/propiedades.php");
if (file_exists("application/views/templates/inm/permisos_red.php")) include_once ("application/views/templates/inm/permisos_red.php");
?>
<!-- Modulo de Permisos -->
<script type="text/javascript">

// Tipos de permisos por modulo
const NO_PERMITIDO = 0;
const PERMISO_LECTURA = 1;
const PERMISO_MODIFICACION = 2;
const PERMISO_CONFIGURACION = 3;

var ControlPermiso = function() {
  <?php 
  // Imprimimos el array de permisos que tenemos guardado en la session de usuario
  echo "var permisos = ".json_encode($permisos).";"; 
  ?>  

  this.get = function(nombre_modulo) {
    for(var i=0;i<permisos.length;i++) {
      var p = permisos[i];
      if (p.nombre == nombre_modulo) return p;
    }
    return {
      "clase":"",
      "title":"",
    };
  };

  // Chequeamos si el estado de los permisos de un determinado modulo
  this.check = function (nombre_modulo) {
    if (PERFIL == -1) return PERMISO_CONFIGURACION;

    // Excepciones
    if (nombre_modulo == "soporte") return 3;
    else if (nombre_modulo == "tutoriales") return 3;

    var i = 0;
    // Recorremos los permisos que tiene el usuario
    for(i=0;i<permisos.length;i++) {
      var p = permisos[i];
      // Encontramos el permiso para ese modulo
      if (p.nombre == nombre_modulo) {
        var perm = parseInt(p.permiso);
        switch(perm) {
          case 1: return PERMISO_LECTURA; break;
          case 2: return PERMISO_MODIFICACION; break;
          case 3: return PERMISO_CONFIGURACION; break;
          default: return NO_PERMITIDO; break;
        }
      }
    }
    return NO_PERMITIDO;
  };
}
var control = new ControlPermiso();
</script>

<?php if(!empty($js_files)) {
  $rand = "?p=".$version_js;
  foreach($js_files as $file) {
    echo "<script type='text/javascript' src='".$file.$rand."'></script>\n";
  }  
  foreach($permisos as $p) {
    if ($p->id_modulo != 0 && file_exists("application/views/templates/".((!empty($p->dir))?$p->dir."/":"").$p->nombre.".php"))
      echo "<script type='text/javascript' src='application/javascript/modules/".((!empty($p->dir))?$p->dir."/":"").$p->nombre.".js".$rand."'></script>\n";
  }
} ?>

<?php /* <script type="text/javascript" src="resources/js/common.js"></script> */ ?>
<script type="text/javascript" src="resources/js/libs/ckeditor_4.6/ckeditor.js"></script>

<script type="text/javascript">
var ajax_request = 0;
function waitingMsg() {
  if (ajax_request > 0) $("#waitingMsg").show();
  else $("#waitingMsg").hide();
}
$(document).ready(function(){

  // HANDLERS GLOBALES
  $(document).ajaxSend(function(){
    ajax_request++; waitingMsg();
  });
  $(document).ajaxSuccess(function(){
    if (ajax_request > 0) ajax_request--; waitingMsg();
  });
  $(document).ajaxError(function(event,request,settings,thrownError){
    show(thrownError);
    if (ajax_request > 0) ajax_request--; waitingMsg();
  });
  
  // En Superadmin, se buscan empresas
  if (PERFIL == -1 && ID_USUARIO == 0) {
    var input = $("#buscar_general");
    $(input).customcomplete({
      "url":"/admin/empresas/function/get_by_descripcion/",
      "form":null, // No quiero que se creen nuevos productos
      "width":400,
      "disableNumber":false,
      "offsetTop":15,
      "onSelect":function(item){
        location.href="app/#empresa/"+item.value;
        $("#buscar_general").val(item.label);
      }
    });
  }
    
});

/**
 * Muestra en un panel de dialogo el texto pasado por parametro
 */
function show(info) {
    //if (CONFIGURACION_SONIDO == 1) document.getElementById('audio').play();
    alert(info);
}

var monedas = <?php echo json_encode($monedas); ?>;
var tipos_inmueble = <?php echo json_encode($tipos_inmueble); ?>;
var tipos_operacion = <?php echo json_encode($tipos_operacion); ?>;
var tipos_estado = <?php echo json_encode($tipos_estado); ?>;
var origenes = <?php echo json_encode($origenes); ?>;
var planes = <?php echo json_encode($planes); ?>;
var idiomas = <?php echo json_encode($idiomas); ?>;
var modulos = <?php echo json_encode($modulos); ?>;
var localidades = <?php echo json_encode($localidades); ?>;
var paises = <?php echo json_encode($paises); ?>;
var provincias = <?php echo json_encode($provincias); ?>;
var proyectos = <?php echo json_encode($proyectos); ?>;
var consultas_tipos = <?php echo json_encode($consultas_tipos); ?>;
var categorias_noticias = <?php echo json_encode($categorias_noticias); ?>;
var categorias_videos = <?php echo json_encode($categorias_videos); ?>;
var asuntos = <?php echo json_encode($asuntos); ?>;

// Usuarios del sistema
var usuarios = new app.collections.Usuarios(<?php echo json_encode($usuarios); ?>);
var usuarios_array = <?php echo json_encode($usuarios); ?>;

// Activamos las notificaciones
<?php if ($empresa->id_proyecto > 0) { ?>

var socket;
$(document).ready(function(){
  //if (OCULTAR_NOTIFICACIONES == 0) init();
  if (ID_PROYECTO == 10) init();
});
function init() {
  var host = "ws://<?php echo str_replace("http://","",current_url(TRUE)); ?>:9000/?id_empresa="+ID_EMPRESA;
  try {
    socket = new WebSocket(host);
    console.log('WebSocket - status '+socket.readyState);
    socket.onopen = function(msg) { 
      console.log("Welcome - status "+this.readyState); 
    };
    socket.onmessage = function(msg) { 
      var data = msg.data;
      // Si enviamos un comando especifico para ejecutar
      if (data.indexOf("COMANDO:") != -1) {
        var comando = data.replace("COMANDO:","");
        eval(comando);
      } else {
        // Es un mensaje comun
        $.toaster({
          "message":data,
          "title":"Atenci&oacute;n",
          "settings": {
            'timeout':0, // Que no desaparezcan solas
          }
        });
      }
    };
    socket.onclose = function(msg) { 
      console.log("Disconnected - status "+this.readyState); 
    };
  }
  catch(ex){ 
    console.log(ex); 
  }
}
function quit(){
  if (socket != null) {
    socket.close();
    socket=null;
  }
}

// PUSH NOTIFICATION
const applicationServerPublicKey = 'BG4hDy_0netdNoxxKir3Z6hGS-5HY5EZgRfXbIpsvfWM78Bc-cZzwyW5UqnNAWnSdF8tcYalaBcHRiYaqByWjnA';
let isSubscribed = false;
let swRegistration = null;

/*
if ( ((MEGASHOP == 1 || ID_EMPRESA == 421) && LOCAL == 0) || ((ID_EMPRESA == 571 || ID_EMPRESA == 1275) && PERFIL == 661) ) {
  if ('serviceWorker' in navigator && 'PushManager' in window) {
    navigator.serviceWorker.register('sw.js')
    .then(function(swReg) {
      swRegistration = swReg;
      initialiseUI();
    })
    .catch(function(error) {
      console.error('Service Worker Error', error);
    });
  } else {
    console.warn('Push messaging is not supported');
  }
}

function initialiseUI() {
  // Set the initial subscription value
  swRegistration.pushManager.getSubscription()
  .then(function(subscription) {
    isSubscribed = !(subscription === null);

    if (isSubscribed) {
      console.log('User IS subscribed.');
    } else {
      console.log('User is NOT subscribed.');
      subscribeUser();
    }
  });
}

function subscribeUser() {
  const applicationServerKey = urlB64ToUint8Array(applicationServerPublicKey);
  swRegistration.pushManager.subscribe({
    userVisibleOnly: true,
    applicationServerKey: applicationServerKey
  })
  .then(function(subscription) {
    console.log('User is subscribed:', subscription);
    updateSubscriptionOnServer(subscription);
    isSubscribed = true;
  })
  .catch(function(err) {
    console.log('Failed to subscribe the user: ', err);
  });
}

function updateSubscriptionOnServer(subscription) {
  var data = "data="+JSON.stringify(subscription)+"&id_empresa="+ID_EMPRESA;
  if (ID_EMPRESA == 571 || ID_EMPRESA == 1275) data += "&id_usuario="+ID_USUARIO;
  $.ajax({
    "url":"notificaciones/function/guardar/",
    "dataType":"json",
    "type":"post",
    "data":data,
    "success":function() {
      console.log("Se guardo la suscripcion");
    },
    "error":function() {
      console.log("Error al guardar la suscripcion");
    },
  });
}
*/

<?php } // Fin Proyecto > 0 ?>

window.onload = function () {  
  document.onkeydown = function (e) {  
    return (e.which || e.keyCode) != 116;  
  };  
}  
</script>
  <div class="app-header navbar">
    <div class="collapse navbar-collapse box-shadow bg-white-only">
      
      <ul class="nav navbar-nav navbar-right">     

        <?php if ($perfil != -1) { ?>
          <li class="dropdown">
            <a href="app/#soporte" class="clear"><span class="material-icons">headset_mic</span> <span class="fs14">Soporte</span></a>
          </li>

          <li class="dropdown">
            <a href="app/#tutoriales" class="clear"><span class="material-icons">help_outline</span> <span class="fs14">Tutoriales</span></a>
          </li>

          <li class="dropdown pr">
            <a onclick="workspace.mostrar_notificaciones()" href="javascript:void(0)" class="clear">
              <span id="notification_news" class="material-icons">notifications_none</span>
              <span class="fs14">Novedades</span>
            </a>
            <?php if ($total_notificaciones > 0) { ?>
              <span class="notification_quantity"><?php echo $total_notificaciones ?></span>
            <?php } else { ?>
              <span class="notification_quantity" style="display: none"></span>
            <?php } ?>
          </li>
          <div id="notification_panel" class="dropdown-menu w-xl animated fadeInRight">
            <div class="panel bg-white">
              <div class="panel-heading b-light bg-light">
                <strong>Notificaciones</strong>
                <!--<a href="javascript:void(0)" onclick="workspace.limpiar_notificaciones()" title="Limpiar" class="pull-right"><i class="glyphicon glyphicon-trash"></i></a>-->
                <a href="javascript:void(0)" onclick="workspace.mostrar_notificaciones()" class="pull-right">
                  <span class="material-icons fs18">close</span>
                </a>
              </div>
              <div class="list-group"></div>
            </div>
          </div>          
        <?php } ?>
        
        <li class="dropdown">
          <a href class="dropdown-toggle clear" style="margin-right: 15px;" data-toggle="dropdown">
            <span class="material-icons">sentiment_satisfied_alt</span>
            <span class="fs14">
              <?php echo lang(array("es"=>"Mi cuenta","en"=>"My account")); ?>
            </span>
          </a>
          <ul class="dropdown-menu animated fadeInRight w menu-perfil">
            <?php if (isset($volver_superadmin) && $volver_superadmin == 1) { ?>
              <li>
                <a href="javascript:void(0)" onclick="workspace.volver_superadmin()">Volver al Superadmin</a>
              </li>
            <?php } ?>          
            <?php
            if (!empty($dominio)) { ?>
              <li>
                <a href="<?php echo (strpos($dominio, "http:") !== FALSE) ? $dominio : "http://".$dominio; ?>" target="_blank">
                  <?php echo lang(array("es"=>"Ver mi web","en"=>"View Website")); ?>
                </a>
              </li>
            <?php } ?>
            <?php if ($perfil != -1) { ?>
              <li>
                <a href="app/#usuarios/<?php echo $id_usuario; ?>">
                  <?php echo lang(array("es"=>"Perfil","en"=>"Profile")); ?>
                </a>
              </li>
              <li class="divider"></li>
            <?php } ?>
            <li>
              <a href="login/logout/">
                <?php echo lang(array("es"=>"Salir","en"=>"Exit")); ?>
              </a>
            </li>
          </ul>
        </li>
      </ul>
  
    </div>
  </div>

  <div class="app app-aside-fixed app-aside-folded">
    
    <?php include("menu.php"); ?>
    
    <div class="app-content">
      <div id="top_container"></div>
    </div>
    
    <div id="waitingMsg">Por favor espere...</div>
        
    </div>

  <?php if (!empty($mensaje_cuenta) && $mensaje_cuenta_nivel == 1) { ?>
    <div class="bottom-message">
      <div class="message">
        <?php echo $mensaje_cuenta ?>
      </div>
    </div>
  <?php } else if (!empty($mensaje_cuenta) && $mensaje_cuenta_nivel == 2) { ?>
    <div class="full-message">
      <div class="full-message-text">
        <span><?php echo $mensaje_cuenta ?></span>
      </div>
    </div>
  <?php } ?>
</div>

</body>
</html>
<?php
ob_end_flush();
function slib_compress_html( $buffer ) {
  $replace = array(
    "#<!--.*?-->#s" => "",      // strip comments
    "#>\s+<#"       => ">\n<",  // strip excess whitespace
    "#\n\s+<#"      => "\n<"    // strip excess whitespace
  );
  $search = array_keys( $replace );
  $html = preg_replace( $search, $replace, $buffer );
  return trim( $html );
}
?>