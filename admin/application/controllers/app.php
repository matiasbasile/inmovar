<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends CI_Controller {

  function __construct() {
    parent::__construct();
  }
  
  function index() {

    ini_set('memory_limit', '-1');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    if (!isset($_SESSION["perfil"])) redirect("/");
    $this->load->helper('url');

    $this->load->model('Permiso_Model');
    $this->load->model('Empresa_Model');
    $this->load->model('Proyecto_Model');
    $this->load->model('Usuario_Model');
    $this->load->helper("fecha_helper");
    
    $tipos_estado = array();
    $tipos_inmueble = array();
    $tipos_operacion = array();
    $categorias_noticias = array();
    $origenes = array();
    $articulos = array();
    $planes = array();
    $proyectos = array();
    $usuarios = array();
    $asuntos = array();
    $localidades = array();
    $paises = array();
    $provincias = array();
    $consultas_tipos = array();
    $total_notificaciones = 0;

    $q = $this->db->query("SELECT * FROM com_idiomas ORDER BY id ASC");
    $idiomas = $q->result();
    $mensaje_cuenta = "";

    // Coordenadas por defecto
    $latitud = -34.6156625;
    $longitud = -58.5033598;


    $usuario = new stdClass();
    $usuario->id = 0;
    $usuario->path = "";
    $usuario->id_sucursal = 0;
    $usuario->language = "es";
    $usuario->hora_desde = "00:00:00";
    $usuario->solo_usuario = 0;
    $usuario->horarios = array();
    $mensaje_cuenta_nivel = 0;
    
    // Debemos cargar el usuario con todo su perfil
    $perfil = $_SESSION["perfil"];
    // Si el perfil es -1, es porque es SUPERADMIN
    
    if ($perfil == -1) {
      $inicio = "";
      $empresa = new stdClass();
      $empresa->id = 0;
      $empresa->id_empresa = 0;
      $empresa->id_proyecto = 0;
      $empresa->proyecto = "VarCreative";
      $empresa->nombre = (isset($_SESSION["nombre_usuario"]) ? $_SESSION["nombre_usuario"] : "Varcreative");
      $empresa->configuracion_menu_iconos = 1;
      $empresa->configuracion_menu = 1;
      $empresa->configuracion_sonido = 0;
      $empresa->config = array();
      $empresa->id_web_template = 0;
      $empresa->servidor_local = "";
      $empresa->administrar_pagos = 0;

      // Si tenemos DEBUG = 1, entonces tomamos los archivos directamente
      // Sino, usamos su version comprimida y compilada
      $q = $this->db->query("SELECT * FROM com_configuracion WHERE id = 1");
      $configuracion = $q->row();
      $js_files = array();
      $css_files = array();
      if ($configuracion->debug == 1) {
        $css_files = $this->css_files();
        $js_files = $this->js_files($empresa->id_proyecto);
      }
      
      $proyectos = $this->Proyecto_Model->activos();

      $usuarios = $this->Usuario_Model->buscar(array(
        "admin"=>1,
        "offset"=>9999,
      ));

      $this->load->model('Modulo_Model');
      $modulos = $this->Modulo_Model->get_all();

      $perfil_row = new stdClass();
      $perfil_row->solo_usuario = 0;
      $perfil_row->principal = 1;
      $usuario->ocultar_notificaciones = 1;

      $q = $this->db->query("SELECT * FROM planes ORDER BY nombre ASC");
      $planes = $q->result();
      
    } else {
      // Obtenemos la pantalla que se debe mostrar al inicio
      $inicio = "";
      $modulos = array();
      
      // Obtenemos la empresa que se esta viendo
      $id_empresa = $_SESSION["id_empresa"];
      $empresa = $this->Empresa_Model->get($id_empresa);
      $empresa->id_empresa = $empresa->id;
      $_SESSION["id_empresa"] = $empresa->id;
      $_SESSION["cuit"] = str_replace("-","",$empresa->cuit);

      // Controlamos el estado de la cuenta
      $fecha_vencimiento = new DateTime($empresa->fecha_suspension);
      $fecha_vencimiento->modify("-5 days");
      if ($empresa->administrar_pagos == 1 && $empresa->fecha_suspension < date("Y-m-d")) {
        $mensaje_cuenta = '<div>Su cuenta ha sido suspendida. Por favor regularice su situaci&oacute;n para seguir utilizando el servicio: </div><div><a href="app/#mi_cuenta" class="btn btn-lg btn-danger m-l">Pagar</a></div>';
        $mensaje_cuenta_nivel = 2;
      } else if ($empresa->administrar_pagos == 1 &&  $fecha_vencimiento->format("Y-m-d") < date("Y-m-d")) {
        $mensaje_cuenta = 'Su cuenta se encuentra vencida. Por favor regularice su situaci&oacute;n: <a href="app/#mi_cuenta" class="btn btn-danger m-l">Pagar</a>';
        $mensaje_cuenta_nivel = 1;
      }

      // Coordenadas especiales
      if (isset($empresa->config["posiciones"]) && !empty($empresa->config["posiciones"])) {
        // Tomamos la primera posicion seteada en la configuracion web
        $pos = explode("/",$empresa->config["posiciones"]);
        $coord = explode(";",$pos[0]);
        if (sizeof($coord)==2) {
          $latitud = $coord[0];
          $longitud = $coord[1];
        }      
      }

      // Si tenemos DEBUG = 1, entonces tomamos los archivos directamente
      // Sino, usamos su version comprimida y compilada
      $q = $this->db->query("SELECT * FROM com_configuracion WHERE id = 1");
      $configuracion = $q->row();
      $js_files = array();
      $css_files = array();
      if ($configuracion->debug == 1) {
        $css_files = $this->css_files();
        $js_files = $this->js_files($empresa->id_proyecto);
      }

      if (!empty($_SESSION["id"])) {
        $id_usuario = $_SESSION["id"];
        $usuario = $this->Usuario_Model->get($id_usuario);
      }

      // Esto se cachea para ahorrar consultas ajax:
      // -------------------------------------------
      
      if (file_exists("application/models/categoria_entrada_model.php")) {
        $this->load->Model("Categoria_Entrada_Model");
        $categorias_noticias = $this->Categoria_Entrada_Model->get_arbol();
      }
        
      $q = $this->db->query("SELECT * FROM inm_tipos_inmueble ORDER BY orden ASC");
      $tipos_inmueble = $q->result();

      // Primero consultamos si no existen algunos registros especificos de la empresa      
      $q = $this->db->query("SELECT * FROM inm_tipos_operacion WHERE id_empresa = $id_empresa ORDER BY orden ASC");
      if ($q->num_rows() == 0) {
        // Sino, tomamos los valores por defecto (id_empresa = 0)
        $q = $this->db->query("SELECT * FROM inm_tipos_operacion WHERE id_empresa = 0 ORDER BY orden ASC");
      }
      $tipos_operacion = $q->result();

      $q = $this->db->query("SELECT * FROM crm_asuntos WHERE id_empresa = 0 OR id_empresa = $id_empresa ORDER BY orden ASC");
      $asuntos = $q->result();
      
      $q = $this->db->query("SELECT * FROM inm_tipos_estado ORDER BY orden ASC");
      $tipos_estado = $q->result();

      $q = $this->db->query("SELECT * FROM crm_consultas_tipos WHERE id_empresa = $id_empresa ORDER BY orden ASC");
      $consultas_tipos = $q->result();

      $q = $this->db->query("SELECT * FROM crm_origenes ORDER BY orden ASC");
      $origenes = $q->result();      
      
      $usuarios = $this->Usuario_Model->buscar(array(
        "offset"=>999999,
      ));

      $this->load->model("Pais_Model");
      $paises = $this->Pais_Model->get_select();

      $this->load->model("Provincia_Model");
      $provincias = $this->Provincia_Model->get_all(0,99999);

      $this->load->model('Localidad_Model');
      $localidades = $this->Localidad_Model->utilizadas(array(
        "id_empresa"=>$empresa->id,
        "id_proyecto"=>$empresa->id_proyecto,
      ));

      // Perfil de usuario
      if (file_exists("application/models/perfil_model.php")) {
        $this->load->model("Perfil_Model");
        $perfil_row = $this->Perfil_Model->get($perfil);
      }

      $this->load->model("Notificacion_Model");
      $notif = $this->Notificacion_Model->buscar();
      $total_notificaciones = $notif["total"];
    }

    $q = $this->db->query("SELECT * FROM com_monedas ORDER BY id ASC");
    $monedas = $q->result();

    $_SESSION["estado"] = 1;
    
    // ID_EMPRESA que realiza la factura
    // Si existe el parametro dinamico id_empresa_facturacion, lo tomamos
    if (isset($empresa->config["id_empresa_facturacion"])) {
      $id_empresa_facturacion = $empresa->config["id_empresa_facturacion"];
      unset($empresa->config["id_empresa_facturacion"]);
    } else {
      $id_empresa_facturacion = 936;
    }

    $categorias_videos = array(
      array(
        "link"=>"propiedades",
        "nombre"=>"Propiedades",
      ),
      array(
        "link"=>"oportunidades",
        "nombre"=>"Oportunidades",
      ),
      array(
        "link"=>"red_inmovar",
        "nombre"=>"Red Inmovar",
      ),
      array(
        "link"=>"sitio_web",
        "nombre"=>"Sitio Web",
      ),
      array(
        "link"=>"estadisticas",
        "nombre"=>"Estadísticas",
      ),
      array(
        "link"=>"configuracion",
        "nombre"=>"Configuración",
      ),
    );

    // Este array tiene las variables que son utilizadas por la vista
    $data = array(
      "base_url"=>$this->config->item("base_url"),
      "db"=>$this->db,

      // Datos del usuario
      "id_usuario" => $_SESSION["id"],
      "idioma" => (empty($usuario->language) ? "es" : $usuario->language),
      "path_usuario" => $usuario->path,
      "id_sucursal" => (isset($usuario->id_sucursal)) ? $usuario->id_sucursal : 0,
      "id_vendedor" => (isset($usuario->id_vendedor)) ? $usuario->id_vendedor : 0,
      "usuario_hora_desde" => (isset($usuario->hora_desde)) ? $usuario->hora_desde : "00:00:00",
      "horarios"=>$usuario->horarios,
      "perfil" => $perfil,
      "solo_usuario"=> max($perfil_row->solo_usuario, $usuario->solo_usuario), // De los dos posibles valores tomamos el mayor
      "usuario_ppal"=> $perfil_row->principal,
      "ocultar_notificaciones"=> $usuario->ocultar_notificaciones,
      "mensaje_cuenta"=>$mensaje_cuenta,
      "mensaje_cuenta_nivel"=>$mensaje_cuenta_nivel,
      "id_empresa_facturacion"=>$id_empresa_facturacion,
      "total_notificaciones"=>$total_notificaciones,

      // Datos de permisos
      "permisos" => $this->Permiso_Model->get_permisos(array(
        "id_perfil"=>$perfil,
        "id_proyecto"=>$empresa->id_proyecto,
        "lang"=>$usuario->language,
      )),
      "modulos"=>$modulos,
      "nombre_usuario" => $_SESSION["nombre_usuario"],
      "email" => $_SESSION["email"],
      "empresa" => $empresa,
      "tiempo_notificaciones"=>$configuracion->tiempo_notificaciones,
      "version_js"=>((isset($configuracion->version_js) && !empty($configuracion->version_js) && $configuracion->debug == 1) ? $configuracion->version_js : 0),
      "local"=>$configuracion->local,
      "inicio" => $inicio,
      "js_files" => $js_files,  // Si se tiene que usar la version cacheada, se envia []
      "css_files" => $css_files,
      "estado" => ($_SESSION["estado"] == 1 ? 1 : 0),
      "volver_superadmin" => ((isset($_SESSION["volver_superadmin"]) && $_SESSION["volver_superadmin"] == 1) ? 1 : 0),
      "proyectos" => $proyectos,

      // Arrays utilizados para cachear y ahorrar AJAX requests
      "consultas_tipos" => $consultas_tipos,
      "paises" => $paises,
      "provincias" => $provincias,
      "usuarios" => $usuarios,
      "idiomas" => $idiomas,
      "origenes" => $origenes,
      "monedas" => $monedas,
      "planes" => $planes,
      "localidades" => $localidades,
      "latitud" => $latitud,
      "longitud" => $longitud,
      "categorias_videos" => $categorias_videos,
      
      "tipos_estado" => $tipos_estado,
      "tipos_inmueble" => $tipos_inmueble,
      "tipos_operacion" => $tipos_operacion,
      "asuntos" => $asuntos,
      
      "categorias_noticias" => $categorias_noticias,
    );
    
    $this->load->view('application',$data);
  }

  function sincronizar() {
    header('Access-Control-Allow-Origin: *');
    set_time_limit(0);
    ob_flush();
    $version = ($this->input->post("version") !== FALSE) ? $this->input->post("version") : "1";
    $id_empresa = ($this->input->post("id_empresa") !== FALSE) ? $this->input->post("id_empresa") : -1; // Con esto indicamos que tenemos que buscar la empresa
    $dispositivo_string = $this->input->post("dispositivo");
    $id_vendedor = $this->input->post("id_vendedor");
    $id_sucursal = 0;
    $lista_precios = 0;

    if (!empty($dispositivo_string) && $dispositivo_string != "0") {
      $this->load->model("Dispositivo_Model");
      $dispositivo = $this->Dispositivo_Model->get_by_dispositivo($dispositivo_string);
      if ($dispositivo === FALSE) {
        echo json_encode(array(
          "error"=>1,
          "mensaje"=>"Error: Dispositivo no encontrado.",
        ));
        return;
      }
      $id_empresa = $dispositivo->id_empresa;
    } elseif (!empty($id_vendedor)) {
      $id_vendedor = (int) $id_vendedor;
      $this->load->model("Vendedor_Model");  
      $vendedor = $this->Vendedor_Model->get($id_vendedor,array(
        "id_empresa"=>$id_empresa,
      ));
      file_put_contents("log_sincronizar_app.txt", date("Y-m-d H:i:s")." Vendedor: $vendedor->nombre ID_EMPRESA: $id_empresa \n", FILE_APPEND);
      if ($vendedor === FALSE) {
        echo json_encode(array(
          "error"=>1,
          "mensaje"=>"Error: Vendedor no encontrador",
        ));
        return;        
      }
      $id_empresa = $vendedor->id_empresa;
      $lista_precios = $vendedor->lista_defecto;
      $id_sucursal = $vendedor->id_sucursal; // Ponemos que tome la sucursal del vendedor
    } else {
      file_put_contents("log_sincronizar_app.txt", "ENTRO NINGUNO DE LOS DOS \n", FILE_APPEND);
    }
    $this->load->model("Articulo_Model");
    $this->load->model("Cliente_Model");
    $this->load->model("Empresa_Model");
    $salida = "";
    $salida.= $this->Articulo_Model->sincronizar_app(array(
      "id_empresa"=>$id_empresa,
      "version"=>$version,
      "id_sucursal"=>$id_sucursal,
      "lista_precios"=>$lista_precios,
    ));

    // Si los vendedores de la empresa comparten clientes
    // TODO: Hacer esto dinamico despues
    $comparte_clientes = (($id_empresa == 972) ? 0 : 1);
    $conf_clientes = array(
      "id_empresa"=>$id_empresa,
      "version"=>$version,
    );
    if ($comparte_clientes == 0) {
      $conf_clientes["id_vendedor"] = $id_vendedor;
    }
    $salida.= $this->Cliente_Model->sincronizar_app($conf_clientes);

    // OPCIONES ESPECIFICAS DESDE LA VERSION 3
    if ($version >= 3) {

      // Vendedores empresas
      $sep = ";;;";

      // SI ES DON YEYO
      $ids_don_yeyo = $this->Empresa_Model->get_ids_empresas_por_vendedor($this->Empresa_Model->get_id_vendedor_don_yeyo());
      if (in_array($id_empresa, $ids_don_yeyo)) {
        // Recorremos los IDS
        foreach($ids_don_yeyo as $id_don_yeyo) {
          if ($id_don_yeyo == 980) continue;
          $emp_don_yeyo = $this->Empresa_Model->get_min($id_don_yeyo);
          // Y formamos la salida
          $salida.= "empresas".$sep.$id_don_yeyo.$sep.$emp_don_yeyo->nombre."\n";
        }
      } else {
        $this->load->model("Empresa_Model");
        $empresa = $this->Empresa_Model->get_min($id_empresa);
        $salida.= "empresas".$sep.$empresa->id.$sep.$empresa->nombre."\n";
      }

      // Mandamos todas las facturas que se marcaron como enviadas por el REPARTIDOR
      // para que en el listado de pedidos del vendedor aparezca un doble CHECK
      $desde = new DateTime("-1 month");
      $desde_f = $desde->format("Y-m-d");
      $sql = "SELECT * FROM facturas ";
      $sql.= "WHERE id_empresa = $id_empresa ";
      $sql.= "AND fecha >= '$desde_f' ";  // Tomamos un mes para atras, para no enviar todas juntas
      $sql.= "AND coordinar_envio >= 1 ";  // Solamente las marcadas que se entregaron
      $sql.= "AND id_vendedor = $id_vendedor "; // Y solamente por ese vendedor
      $q = $this->db->query($sql);
      foreach($q->result() as $r) {
        if ($version <= 4) {
          $salida.= "facturas".$sep.$r->numero_referencia.$sep.$r->id_vendedor.$sep.$r->id_empresa."\n";
        } else if ($version >= 5) {
          $r->observaciones = str_replace("\n", "", $r->observaciones);
          $salida.= "facturas".$sep.$r->coordinar_envio.$sep.$r->observaciones.$sep.$r->numero_referencia.$sep.$r->id_vendedor.$sep.$r->id_empresa."\n";
        }
      }

      if ($version >= 4) {
        $sql = "SELECT * FROM lista_precios_configuracion WHERE id_empresa = $id_empresa ";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
          $c = $q->row();
          $lista_1 = $c->lista_1_nombre;
          $lista_2 = $c->lista_2_nombre;
          $lista_3 = $c->lista_3_nombre;
          $lista_4 = $c->lista_4_nombre;
          $lista_5 = $c->lista_5_nombre;
          $lista_6 = $c->lista_6_nombre;
        } else {
          $lista_1 = "Lista 1";
          $lista_2 = "Lista 2";
          $lista_3 = "Lista 3";
          $lista_4 = "Lista 4";
          $lista_5 = "Lista 5";
          $lista_6 = "Lista 6";
        }
        // Tabla de configuracion
        $salida.= "configuracion".$sep."1".$sep.$vendedor->limite_descuento.$sep.$lista_1.$sep.$lista_2.$sep.$lista_3.$sep.$lista_4.$sep.$lista_5.$sep.$lista_6."\n";
      }

      // Tabla de descuentos de articulos
      if ($version >= 8) {
        if ($id_empresa == 972) {
          // Los productos de BASILE tienen todos un descuento por monto fijo a partir de determinadas cantidades
          $sql = "SELECT * FROM articulos WHERE id_empresa = $id_empresa AND lista_precios > 0 ";
          $q = $this->db->query($sql);
          $ii = 0;
          foreach($q->result() as $row) {
            $salida.= "articulos_descuentos".$sep.$ii.$sep.$row->id.$sep."100".$sep."300".$sep."0".$sep."10"."\n";
            $ii++;
            $salida.= "articulos_descuentos".$sep.$ii.$sep.$row->id.$sep."301".$sep."99999".$sep."0".$sep."15"."\n";
            $ii++;
          }
        }
      }
    }

    file_put_contents("app_sincronizar.txt", $salida);

    echo $salida;
    flush();
  }
    
  function check_supervisor() {
    $codigo = trim($this->input->post("codigo"));
    $id_empresa = trim($this->input->post("id_empresa"));
    $sql = "SELECT * FROM empresas WHERE id = $id_empresa AND supervisor = '$codigo'";
    $q = $this->db->query($sql);
    if ($q->num_rows()>0) {
      echo json_encode(array("error"=>0));
    } else {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"ERROR: Codigo incorrecto."
      ));
    }        
  }
  
  function get_info_inmovar_dashboard() {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $desde = new DateTime("-1 month");
    $hasta = new DateTime();
    $datos = array();
    
    $this->load->model("Propiedad_Model");
    $datos["total_propiedades"] = $this->Propiedad_Model->count_all();
    $datos["mas_visitadas"] = $this->Propiedad_Model->buscar(array(
      "offset"=>3
    ))["results"];
    
    // Ultimas consultas
    $this->load->model("Consulta_Model");
    $consultas = $this->Consulta_Model->buscar(array(
      "tipo"=>1,
      "offset"=>3
    ));
    $datos["consultas"] = $consultas["results"];
    $datos["total_consultas"] = $this->Consulta_Model->count_all();

    $datos["total_visitas"] = 1589;
    $datos["visitas_sitio_web"] = round($datos["total_visitas"] * 0.58,0);
    $datos["visitas_red"] = $datos["total_visitas"] - $datos["visitas_sitio_web"];

    // TODO: HARDCODEADO
    $datos["consultas_sitio_web"] = round($datos["total_consultas"] * 0.41,0);
    $datos["consultas_red"] = $datos["total_consultas"] - $datos["consultas_sitio_web"];

    echo json_encode($datos);
  }

  function calcular_visitas($datos = array()) {
    try {
      $fecha_desde = $datos["desde"];
      $fecha_hasta = $datos["hasta"];
      $view_id = $datos["view_id"];
    
      set_include_path(get_include_path().PATH_SEPARATOR.APPPATH.'libraries/Google/');
      require APPPATH.'libraries/Google/Client.php';
      require APPPATH.'libraries/Google/Service/Analytics.php';
      
      $client_id = '785533219608-9f9ncmps76g85amiipji77k48r9kul3q.apps.googleusercontent.com'; //Client ID
      $service_account_name = '785533219608-9f9ncmps76g85amiipji77k48r9kul3q@developer.gserviceaccount.com'; //Email Address 
      $key_file_location = APPPATH.'libraries/Google/key.p12';
      
      $client = new Google_Client();
      $client->setApplicationName("Client_Library_Examples");
      $service = new Google_Service_Analytics($client);
      
      if (isset($_SESSION['service_token'])) {
        $client->setAccessToken($_SESSION['service_token']);
      }
      $key = file_get_contents($key_file_location);
      $cred = new Google_Auth_AssertionCredentials(
        $service_account_name,
        array('https://www.googleapis.com/auth/analytics.readonly'),
        $key
      );
      $client->setAssertionCredentials($cred);
      if($client->getAuth()->isAccessTokenExpired()) {
        $client->getAuth()->refreshTokenWithAssertion($cred);
      }
      $_SESSION['service_token'] = $client->getAccessToken();
      
      $view_id = "ga:".$view_id;
      
      // SESIONES
      $results = $service->data_ga->get($view_id,$fecha_desde,$fecha_hasta,'ga:sessions');
      if (count($results->getRows()) > 0) {
        $rows = $results->getRows();
        $datos["total_sesiones"] = $rows[0][0];
      }
      
    } catch(Exception $e) {
      $datos["exception"] = $e->getMessage();
    }  
    return $datos;
  }

  private function js_files($id_proyecto = 0) {
    
    // Librerias comunes a todos los proyectos
    $array = array(    
      //"resources/js/jquery.min.js",
      "resources/js/jquery-2.2.4.min.js",
      "resources/js/application.js", // TODO: Reemplazar esto
      "resources/js/jquery/ui/jquery-ui.min.js",
      "resources/js/common.js",
      "resources/js/backbone.paginator.js",
      "resources/js/jquery.dynatree.min.js",
      "resources/js/jquery.simplemodal.js",
      "resources/js/jquery-fieldselection.js",
      "resources/js/jquery.maskedinput.js",
      "resources/js/html5-file-upload/js/jquery.filedrop.js",
      "resources/js/jquery.scrollTo-1.4.3.1-min.js",
      "resources/js/jquery.ajaxq-0.0.1.js",
      "resources/js/libs/bootstrap.min.js",
      "resources/js/libs/screenfull.min.js",
      "resources/js/jquery/jquery.tablednd.0.6.min.js",
      "resources/js/jquery/highcharts.js",
      "resources/js/jquery/chosen/chosen.jquery.min.js",
      "resources/js/jquery/touchspin/jquery.bootstrap-touchspin.min.js",
      "resources/js/jquery/select2/select2.full.min.js",
      "resources/js/jquery/select2/i18n/es.js",
      "resources/js/app/map/load-google-maps.js",
      "resources/js/moment.min.js",
      "resources/js/libs/fancytree/jquery.fancytree.min.js",
      "resources/js/cropper.min.js",
      "resources/js/cropper-main.js",
      "resources/js/jspdf.min.js",
      "resources/js/html2canvas.min.js",
      "resources/js/jquery-ui-timepicker-addon.js",
      "resources/js/jquery.countTo.js",
      "resources/js/libs/colorpicker/js/bootstrap-colorpicker.min.js",
      "resources/js/libs/camanjs/caman.full.min.js",
      "resources/js/jquery/nestable/jquery.nestable.js",
      "resources/js/fullcalendar.min.js",
      "resources/js/jquery/jquery-ui-multiselect/src/jquery.multiselect.min.js",
      "resources/js/jquery/jquery-ui-multiselect/src/jquery.multiselect.filter.min.js",
      "resources/js/jquery/jquery-ui-multiselect/i18n/jquery.multiselect.es.js",
      "resources/js/jquery/jquery-ui-multiselect/i18n/jquery.multiselect.filter.es.js",
      "resources/js/scheduler.min.js",
      "resources/js/fullcalendar-locale/es.js",
      "resources/js/jquery.cookie.js",
      "resources/js/jquery/jquery.toaster.js",
      "resources/js/jquery/contextmenu/jquery.contextMenu.min.js",

      "resources/js/jquery/upload/js/jquery.iframe-transport.js",
      "resources/js/jquery/upload/js/jquery.fileupload.js",
      "resources/js/owl.carousel.min.js",
      "resources/js/jquery.flexslider.js",
      "resources/js/daterangepicker.js",
      
      // PUNTO DE ENTRADA A LA APLICACION
      "application/javascript/main.js",
    );
    
    // Cargamos todos los MIXINS (estan en todos los proyectos)
    foreach (glob("application/javascript/mixins/*.js") as $filename){
      $array[] = $filename;
    }
    
    // Estos modulos estan en TODOS los proyectos
    $array[] = 'application/javascript/modules/inicio.js';
    $array[] = 'application/javascript/modules/image_editor.js';
    $array[] = 'application/javascript/modules/image_gallery.js';
    $array[] = 'application/javascript/modules/image_upload.js';
    $array[] = 'application/javascript/modules/empresas.js';
    $array[] = 'application/javascript/modules/importacion.js';
    $array[] = 'application/javascript/modules/notificaciones.js';
    $array[] = 'application/javascript/modules/monedas.js';
    $array[] = 'application/javascript/modules/provincias.js';
    $array[] = 'application/javascript/modules/localidades.js';
    $array[] = 'application/javascript/modules/crm/emails_templates.js';
    $array[] = 'application/javascript/modules/crm/consultas.js';
    $array[] = 'application/javascript/modules/crm/contactos.js';
    $array[] = 'application/javascript/modules/crm/eventos.js';
    $array[] = 'application/javascript/modules/crm/tareas.js';
    $array[] = 'application/javascript/modules/crm/origenes.js';
    $array[] = 'application/javascript/modules/not/entradas.js';
    $array[] = 'application/javascript/modules/web/web_textos.js';
    $array[] = 'application/javascript/modules/clientes.js';
    $array[] = 'application/javascript/modules/crm/contactos.js';
    $array[] = 'application/javascript/modules/usuarios.js';
    $array[] = 'application/javascript/modules/perfiles.js';
    $array[] = 'application/javascript/modules/web/web_configuracion.js';
    $array[] = 'application/javascript/modules/config/mi_cuenta.js';
    $array[] = 'application/javascript/modules/inm/propiedades.js';
    $array[] = 'application/javascript/modules/inm/permisos_red.js';
    $array[] = 'application/javascript/modules/inm/dashboard.js';
    $array[] = 'application/javascript/modules/inm/tipos_operacion.js';
    $array[] = 'application/javascript/modules/inm/tipos_inmueble.js';
    $array[] = 'application/javascript/modules/inm/tipos_estado.js';
    $array[] = 'application/javascript/modules/clientes.js';

    if ($id_proyecto == 0) {
      
      $array[] = 'application/javascript/modules/monedas.js';
      $array[] = 'application/javascript/modules/planes.js';
      $array[] = 'application/javascript/modules/proyectos.js';
      $array[] = 'application/javascript/modules/inm/tipos_operacion.js';
      $array[] = 'application/javascript/modules/inm/tipos_inmueble.js';
      $array[] = 'application/javascript/modules/inm/tipos_estado.js';
      $array[] = 'application/javascript/modules/versiones_db.js';
      $array[] = 'application/javascript/modules/web/web_templates.js';
      $array[] = 'application/javascript/modules/web/web_textos.js';
    }    
    
    return $array;
  }
  

  // Obtiene los ultimos IDS de las tablas
  // Sirve para actualizar una caja restaurada y que despues cuando se suban las ventas
  // no se generen conflictos con los IDS
  function get_max_ids() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $id_empresa = $this->input->get("id_empresa");
    $punto_venta = $this->input->get("punto_venta");

    $sql = "SELECT * FROM puntos_venta WHERE id_empresa = $id_empresa AND numero = $punto_venta ";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"No se encuentra el punto de venta."
      ));
      exit();
    }
    $pv = $q->row();
    $id_punto_venta = $pv->id;

    $salida = array();
    $tablas = array("facturas", "facturas_items", "caja_diaria", "cupones_tarjetas");
    foreach($tablas as $t) {
      $sql = "SELECT IF(MAX(id) IS NULL,0,MAX(id)) AS id FROM $t WHERE id_punto_venta = $id_punto_venta AND id_empresa = $id_empresa ";
      $q = $this->db->query($sql);
      $r = $q->row();
      $salida[] = array(
        "tabla"=>$t,
        "ultimo"=>$r->id,
      );
    }
    echo json_encode(array(
      "error"=>0,
      "datos"=>$salida,
    ));
  }
  
  /**
   * COMPRIME TODOS LOS ARCHIVOS CSS EN UN UNICO ARCHIVO "resources/css/min.css"
   */
  function compress_css() {
    
    set_time_limit(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $path =  APPPATH.'libraries';
    require_once $path . '/minify/src/Minify.php';
    require_once $path . '/minify/src/CSS.php';
    $minifier = new CSS();
    $array = $this->css_files();
    foreach($array as $a) {
      $minifier->add($a);
    }
    file_put_contents("resources/css/min.css",$minifier->minify());
    echo "TERMINO";      
  }
  
  /**
   * ARRAY CON LOS ARCHIVOS CSS QUE SE DEBEN INCLUIR EN EL PROYECTO
   */
  private function css_files() {
    $array = array(    
      "resources/css/common.css",
      "resources/css/bootstrap.css",
      "resources/css/animate.css",
      "resources/css/simple-line-icons.css",
      //"resources/css/font.css",
      "resources/fonts/lato/lato.css",
      "resources/css/app.css?v=11",
      "resources/js/jquery/ui/jquery-ui.min.css",
      "resources/css/tablednd.css",
      "resources/css/footable/footable.core.css",
      "resources/css/loader.css",
      "resources/js/jquery/chosen/chosen.css",
      "resources/js/jquery/select2/select2.css",
      "resources/js/libs/fancytree/skin-win7/ui.fancytree.min.css",
      "resources/js/jquery/touchspin/jquery.bootstrap-touchspin.css",
      "resources/css/sortable.css",
      "resources/css/cropper.min.css",
      "resources/css/cropper.css",
      "resources/css/jquery-ui-timepicker-addon.css",
      "resources/js/libs/colorpicker/css/bootstrap-colorpicker.min.css",
      "resources/js/jquery/nestable/nestable.css",
      //"resources/js/jquery/fullcalendar/fullcalendar.css",
      "resources/css/fullcalendar.min.css",
      "resources/css/scheduler.min.css",
      "resources/js/jquery/jquery-ui-multiselect/jquery.multiselect.css",
      "resources/js/jquery/jquery-ui-multiselect/jquery.multiselect.filter.css",
      "resources/js/jquery/upload/css/jquery.fileupload.css",
      "resources/js/jquery/contextmenu/jquery.contextMenu.min.css",
      "resources/css/owl.carousel.min.css",
      "resources/css/flexslider.css",
      "resources/css/daterangepicker.css",
    );
    return $array;
  }

  // Esta funcion es llamada periodicamente para mantener viva la session
  function refresh_session() {
    @session_start();
    echo json_encode(array("error"=>0));
  }
  
}