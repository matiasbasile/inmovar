<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Consultas extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Consulta_Model', 'modelo');
  }

  function get_consulta() {
    $id = parent::get_post("id", 0);
    $id_empresa = parent::get_post("id_empresa", parent::get_empresa());
    $output = $this->modelo->get($id);
    echo json_encode($output);
  }

  function get_calendar() {

    $fecha_desde = $this->input->get("start");
    $fecha_hasta = $this->input->get("end");
    $salida = array();
    $id_origen = parent::get_get("id_origen",0);
    $id_usuario = parent::get_get("id_usuario",-1);
    $id_empresa = parent::get_get("id_empresa",parent::get_empresa());

    $sql = "SELECT CC.*, ";
    $sql.= "IF (P.calle is NULL, '', P.calle) as propiedad_calle, ";
    $sql.= "IF (P.altura is NULL, '', P.altura) as propiedad_altura, ";
    $sql.= "IF (U.nombre is NULL, 'Sin Asignar', U.nombre) as usuario_nombre ";
    $sql.= "FROM crm_consultas CC ";
    $sql.= "LEFT JOIN inm_propiedades P ON (P.id = CC.id_referencia AND P.id_empresa = CC.id_empresa) ";
    $sql.= "LEFT JOIN com_usuarios U ON (U.id = CC.id_usuario AND U.id_empresa = CC.id_empresa) ";
    $sql.= "LEFT JOIN clientes C ON (CC.id_contacto = C.id AND CC.id_empresa = C.id_empresa) ";
    $sql.= "WHERE CC.fecha >= '$fecha_desde' ";
    $sql.= "AND '$fecha_hasta' >= CC.fecha ";
    if ($id_origen != 0) $sql.= "AND CC.id_origen = '$id_origen'" ;
    if ($id_empresa != 0) $sql.= "AND CC.id_empresa = '$id_empresa'" ;
    if ($id_usuario > -1) $sql.= "AND C.id_usuario = '$id_usuario'" ;

    $query = $this->db->query($sql);

    foreach($query->result() as $m) {
      //$m->title = $m->titulo;
      $m->allDay = true;
      $m->start = $m->fecha;
      //$m->end = $m->fecha;
      $m->resourceId = $m->id;

      if ($id_origen == 41) $m->title = $m->usuario_nombre." - Visita a ".$m->propiedad_calle." ".$m->propiedad_altura;

      $m->backgroundColor = "#1d36c2";
      $m->borderColor = "#1d36c2";


      $salida[] = $m;
    }

    echo json_encode($salida);

  }


  function actualizar_tipo_cliente() {
    $id_empresa = parent::get_post("id_empresa", parent::get_empresa());
    $id_cliente = parent::get_post("id_cliente", 0);
    $tipo = parent::get_post("tipo", 0);
    if (empty($tipo) || empty($id_cliente)) {
      echo json_encode(array("error"=>1));
    } else {
      $sql = "UPDATE clientes SET tipo = '$tipo' WHERE id_empresa = '$id_empresa' AND id = '$id_cliente' ";
      $this->db->query($sql);
      echo json_encode(array("error"=>0));
    }
  }

  function verdos() {
    $salida = array();
    $id_empresa = parent::get_get("id_empresa", parent::get_empresa());
    //Primero sacamos todos los tipos de consulta
    $sql = "SELECT * FROM crm_consultas_tipos WHERE id_empresa = $id_empresa ORDER BY orden ASC";
    $q = $this->db->query($sql);
    foreach ($q->result() as $c) {
      $res = $this->modelo->buscar(array(
        "id_empresa"=>$id_empresa,
        "tipo"=>$c->id,
        "offset"=>999,
      ));

      $c->items = $res;
      $salida[] = $c; 
    }
    echo json_encode(array(
      "results"=>$salida,
      "total"=>sizeof($salida),
    ));
  }

  // Esta funcion llena el campo id_usuario de la tabla clientes
  // con el id_usuario de la ultima consulta
  function pasar_usuarios($id_empresa) {
    $sql = "SELECT DISTINCT id_contacto, id_usuario FROM crm_consultas ";
    $sql.= "WHERE id_empresa = $id_empresa AND id_usuario != 0 ";
    $sql.= "ORDER BY fecha DESC ";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
      $sql = "UPDATE clientes SET id_usuario = $r->id_usuario ";
      $sql.= "WHERE id_empresa = $id_empresa ";
      $sql.= "AND id = $r->id_contacto ";
      $this->db->query($sql);
    }
    echo "TERMINO";
  }

  // Este proceso se ejecuta cada tantos minutos:
  // - Analiza el correo de "respuestas.varcreative@gmail.com"
  // - Procesa todos los correos no leidos y los transforma a consultas
  function procesar() {

    date_default_timezone_set("America/Argentina/Buenos_Aires");
    set_time_limit(0);    

    // A traves de un archivo, controlamos que no se ejecuten dos veces el mismo proceso
    /*
    $filename = "consultas_email.txt";
    if (file_exists($filename) === FALSE) file_put_contents($filename, "");
    $file = fopen($filename, "r+");
    if (flock($file, LOCK_EX | LOCK_NB) === FALSE) {  // Intenta adquirir un bloqueo exclusivo
      // Si falla es porque el proceso sigue activo
      exit();
    }
    */

    $id_empresa = 45;
    $connection = imap_open('{c1040339.ferozo.com:993/imap/ssl}INBOX', 'info@grupo-urbano.com.ar', 'Leonel235') or die('Cannot connect to Gmail: ' . imap_last_error());
    $emailData = imap_search($connection, 'ALL');
    //$emailData = imap_search($connection, 'ALL'); //Toma emails no leidos !!!!CAMBIAR ALL POR UNSEEN
    if (empty($emailData)) return;

    foreach ($emailData as $emailIdent) { //Leer emails
      $i=0;
      $overview = imap_fetch_overview($connection, $emailIdent, 0);
      $structure = imap_fetchstructure($connection, $emailIdent);
      $message = imap_fetchbody($connection, $emailIdent, '1');
      if($structure->encoding == 3) {
        $message = imap_base64($message);
      } else if($structure->encoding == 4) {
        $message = imap_qprint($message);
      }
      //$messageExcerpt = substr($message, 0, 300); Por si se quiere mostrar X caracteres

      // Datos de los usuarios
      $text = $message;//trim(quoted_printable_decode($message)); 
      $to = $overview[$i]->to;
      $fecha = date("Y-m-d H:i:s", strtotime($overview[$i]->date));
      $titulo = $overview[$i]->subject;
      $from = $overview[$i]->from;
      if (strstr($from, "<")) {
        //Si el mail no tiene nombre de usuario quito las <, si no lo muestro tal como es
        $from = strstr($from, "<");
        $from=str_replace("<", "", $from);
        $from=str_replace(">", "", $from);
      }
      if ($from != "noresponder@eldia.com") continue;

      // ANALISIS DE VIVIENDAS EL DIA
      $this->load->model("Consulta_Model");
      $this->load->model("Diario_El_Dia_Model");
      $this->load->model("Propiedad_Model");

      $consulta = @$this->Diario_El_Dia_Model->parse_email($text);
      if (isset($consulta->codigo_propiedad)) {

        // Buscamos la propiedad por el codigo
        $propiedad = $this->Propiedad_Model->get_by_codigo($consulta->codigo_propiedad,array(
          "id_empresa"=>$id_empresa
        ));
        $consulta->tipo = 0; // Recibido
        $consulta->id_contacto = 0;
        $consulta->message_id = $overview[$i]->message_id;
        $consulta->id_empresa = $id_empresa;
        $consulta->asunto = "Contacto desde Diario El Dia";
        $consulta->id_origen = 40; // Diario El DIA
        $consulta->fecha = $fecha;

        $msg = "Nombre: $consulta->nombre\n";
        $msg.= "Email: $consulta->email\n";
        $msg.= "Telefono: $consulta->telefono\n";
        $msg.= "Código Propiedad: $consulta->codigo_propiedad\n";
        $msg.= "Dirección: $consulta->direccion_propiedad\n";
        $consulta->texto = $msg;
        if (isset($consulta->mensaje)) $consulta->texto .= "Mensaje: ".$consulta->mensaje;

        if (!empty($propiedad)) {
          $consulta->id_usuario = $propiedad->id_usuario;
          $consulta->id_referencia = $propiedad->id;
        } else {
          echo "No se encuentra propiedad con codigo: $consulta->codigo_propiedad <br/>";
        }
        print_r($consulta)."<br/><br/>";
        $this->Consulta_Model->insert($consulta);
      }
    }
    echo "TERMINO";
  }


  // USADO EN CRM/CONSULTAS
  function editar_usuario_asignado() {

    $id_empresa = parent::get_empresa();
    $ids = parent::get_post("ids");
    $ids = explode(",", $ids);
    $id_contacto = parent::get_post("id_contacto");
    // Usuario que realizo la operacion
    $id_usuario = parent::get_post("id_usuario");
    // Nuevo usuario asignado al cliente
    $id_usuario_asignado = parent::get_post("id_usuario_asignado");

    $bcc_array = array("basile.matias99@gmail.com");
    require_once APPPATH.'libraries/Mandrill/Mandrill.php';

    $this->load->model("Empresa_Model");
    $this->load->model("Email_Template_Model");
    $this->load->model("Usuario_Model");
    $this->load->model("Consulta_Model");
    $template = $this->Email_Template_Model->get_by_key("asignacion-usuario",936);
    $empresa = $this->Empresa_Model->get_min($id_empresa);

    // Primero obtenemos el usuario nuevo
    $usuario_asignado = $this->Usuario_Model->get($id_usuario_asignado,array(
      "id_empresa"=>$id_empresa,
    ));
    if ($usuario_asignado === FALSE) {
      echo json_encode(array("error"=>1,"mensaje"=>"No existe el usuario solicitado"));
      exit();
    }

    $usuario = $this->Usuario_Model->get($id_usuario,array(
      "id_empresa"=>$id_empresa,
    ));

    foreach($ids as $id) {

      // Actualizamos el id_usuario de la tabla clientes
      $sql = "UPDATE clientes SET id_usuario = '$id_usuario_asignado' WHERE id_empresa = $id_empresa AND id = $id_contacto ";
      $q = $this->db->query($sql);

      // Movemos todas las consultas del contacto hacia el nuevo usuario
      $sql = "UPDATE crm_consultas SET id_usuario = '$id_usuario_asignado' WHERE id_empresa = $id_empresa AND id_contacto = $id_contacto ";
      $q = $this->db->query($sql);

      // Creamos un nuevo movimiento en el historial de ese cliente
      if ($id_usuario_asignado != $id_usuario) {
        // Otro asigno
        $texto = $usuario->nombre." ha asignado a ".$usuario_asignado->nombre." para atender la consulta.";  
      } else {
        // Me asigne yo mismo
        $texto = $usuario->nombre." se asigno la consulta.";
      }
      
      $sql = "INSERT INTO crm_consultas (id_contacto,id_empresa,fecha,asunto,texto,id_usuario,tipo,id_origen) VALUES (";
      $sql.= " $id_contacto,$id_empresa,NOW(),'Asignacion de usuario','$texto',$id_usuario,0,32) ";
      $this->db->query($sql);

      $web_conf = $this->Empresa_Model->get_web_conf($id_empresa);
      if ($web_conf->crm_notificar_asignaciones_usuarios == 1 && $id_usuario != $id_usuario_asignado)  {

        $consulta = $this->Consulta_Model->get($id,array(
          "id_empresa"=>$id_empresa,
        ));

        $asunto = ($usuario->nombre)." te asigno un nuevo contacto!";
        $texto = $template->texto;
        $texto = str_replace("{{nombre}}", ($usuario_asignado->nombre), $texto);
        $cuerpo = "<b>Cliente: </b> ".$consulta->nombre." <br/>";
        $cuerpo.= "<b>Email: </b> ".$consulta->email." <br/>";
        $cuerpo.= "<b>Telefono: </b> ".$consulta->telefono." <br/>";
        //$cuerpo.= "<b>ID Consulta: </b> #".$consulta->id." <br/>";
        $texto = str_replace("{{cuerpo}}", $cuerpo, $texto);

        mandrill_send(array(
          "to"=>$usuario_asignado->email,
          "from"=>"no-reply@varcreative.com",
          "from_name"=>$empresa->nombre,
          "subject"=>$asunto,
          "body"=>$texto,
          //"bcc"=>$bcc_array,
        ));
      }
    }

    echo json_encode(array("error"=>0));
  }  

  // Registra cuando el usuario hace click en el email de carrito abandonado
  // Se le envia un email al administrador avisando
  function aviso_carrito_abandonado($id_empresa,$id_cliente) {
    header('Access-Control-Allow-Origin: *');

    $this->load->model("Empresa_Model");
    $this->load->model("Cliente_Model");

    $empresa = $this->Empresa_Model->get($id_empresa);
    $cliente = $this->Cliente_Model->get($id_cliente,$id_empresa);

    $fecha = date("Y-m-d H:i:s");
    $asunto = "Interesado en productos";
    $texto = "$cliente->nombre ha vuelto a abrir el carrito luego de hacer click en el email.";
    $consulta = array(
      "id_empresa"=>$id_empresa,
      "fecha"=>$fecha,
      "asunto"=>$asunto,
      "texto"=>$texto,
      "id_contacto"=>$id_cliente,
      "id_origen"=>21, // EMAIL AUTOMATICO
    );
    $this->modelo->insert($consulta);

    $bcc_array = array("basile.matias99@gmail.com");
    require_once APPPATH.'libraries/Mandrill/Mandrill.php';
    mandrill_send(array(
      "to"=>$empresa->email,
      "from"=>"no-reply@varcreative.com",
      "from_name"=>$empresa->nombre,
      "subject"=>$asunto,
      "body"=>$texto,
      "reply_to"=>$email,
      "bcc"=>$bcc_array,
    ));
    header("Location: http://www.grupoanacleto.com.ar/carrito/");
  }

  // Utilizado en ARGENCASH / crm / consultas.js / guardar_tarea()
  function guardar_tarea() {
    $id_empresa = parent::get_empresa();
    $id_contacto = parent::get_post("id_contacto",0);
    $fecha = parent::get_post("fecha",date("Y-m-d"));
    $fecha_visto = parent::get_post("fecha_visto",date("Y-m-d H:i:s"));
    $hora = parent::get_post("hora",date("H:i:s"));
    $asunto = parent::get_post("asunto","");
    $texto = parent::get_post("texto","");
    $id_origen = parent::get_post("id_origen",0);
    $id_usuario = parent::get_post("id_usuario",0);
    $tipo = parent::get_post("tipo",0);
    $id_asunto = parent::get_post("id_asunto",0);
    $estado = parent::get_post("estado",0);
    $sql = "INSERT INTO crm_consultas ( ";
    $sql.= " id_contacto,id_empresa,fecha,asunto, ";
    $sql.= " texto,id_origen,id_usuario,tipo,id_asunto,estado,fecha_visto ";
    $sql.= ") VALUES (";
    $sql.= " '$id_contacto','$id_empresa','$fecha $hora','$asunto', ";
    $sql.= " '$texto','$id_origen','$id_usuario','$tipo','$id_asunto','$estado','$fecha_visto' ";
    $sql.= ")";
    file_put_contents("consulta_insertar.txt", date("Y-m-d H:i:s")." - ".$sql."\n", FILE_APPEND);
    $this->db->query($sql);
    echo json_encode(array(
      "error"=>0,
    ));
  }
  
  function ver() {
    $tipo = parent::get_get("tipo",0);
    $limit = $this->input->get("limit");
    $offset = $this->input->get("offset");
    $filter = $this->input->get("filter");
    $order_by = $this->input->get("order_by");
    $order = $this->input->get("order");
    $id_origen = $this->input->get("id_origen");
    $id_usuario = ($this->input->get("id_usuario") === FALSE) ? 0 : $this->input->get("id_usuario");
    $vencidas = ($this->input->get("vencidas") === FALSE) ? 0 : $this->input->get("vencidas");
    $id_origenes = $this->input->get("id_origenes");
    if (!empty($order_by) && !empty($order)) $order = $order_by." ".$order;
    else $order = "";
    
    $conf = array(
      "filter"=>$filter,
      "limit"=>$limit,
      "offset"=>$offset,
      "order"=>$order,
      "id_origen"=>$id_origen,
      "id_usuario"=>$id_usuario,
      "vencidas"=>$vencidas,
      "id_origenes"=>$id_origenes,
      "tipo"=>$tipo,
    );
    $r = $this->modelo->buscar($conf);
    echo json_encode($r);    
  }
  
  function enviar() {

    header('Access-Control-Allow-Origin: *');
    $this->load->model("Cliente_Model");
    $this->load->model("Email_Template_Model");

    $nombre = ($this->input->post("nombre") === FALSE) ? "" : htmlentities($this->input->post("nombre"),ENT_QUOTES);
    $apellido = ($this->input->post("apellido") === FALSE) ? "" : htmlentities($this->input->post("apellido"),ENT_QUOTES);
    if ($apellido !== FALSE) $nombre = $nombre." ".$apellido;
    $nombre = trim(ucwords(strtolower($nombre)));
    $email = ($this->input->post("email") === FALSE) ? "" : htmlentities($this->input->post("email"),ENT_QUOTES);
    $mensaje = ($this->input->post("mensaje") === FALSE) ? "" : htmlentities($this->input->post("mensaje"),ENT_QUOTES);
    $asunto = ($this->input->post("asunto") === FALSE) ? "" : htmlentities($this->input->post("asunto"),ENT_QUOTES);
    $subtitulo = ($this->input->post("subtitulo") === FALSE) ? "" : htmlentities($this->input->post("subtitulo"),ENT_QUOTES);

    $telefono = ($this->input->post("telefono") === FALSE) ? "" : htmlentities($this->input->post("telefono"),ENT_QUOTES);
    $celular = ($this->input->post("celular") === FALSE) ? "" : htmlentities($this->input->post("celular"),ENT_QUOTES);
    $prefijo = ($this->input->post("prefijo") === FALSE) ? "549" : htmlentities($this->input->post("prefijo"),ENT_QUOTES);

    $direccion = $this->input->post("direccion");
    if ($direccion === FALSE) $direccion = "";
    $ciudad = $this->input->post("ciudad");
    if ($ciudad === FALSE) $ciudad = "";
    $id_localidad = $this->input->post("id_localidad");
    if ($id_localidad === FALSE) $id_localidad = 0;
    $id_propiedad = $this->input->post("id_propiedad");
    if ($id_propiedad === FALSE) $id_propiedad = 0;
    $id_viaje = $this->input->post("id_viaje");
    if ($id_viaje === FALSE) $id_viaje = 0;
    $id_auto = $this->input->post("id_auto");
    if ($id_auto === FALSE) $id_auto = 0;
    $id_articulo = $this->input->post("id_articulo");
    if ($id_articulo === FALSE) $id_articulo = 0;
    $id_entrada = $this->input->post("id_entrada");
    if ($id_entrada === FALSE) $id_entrada = 0;
    $id_origen = $this->input->post("id_origen");
    if ($id_origen === FALSE) $id_origen = 9;
    $id_usuario = $this->input->post("id_usuario");
    if ($id_usuario === FALSE) $id_usuario = 0;
    $no_actualizar_fecha = $this->input->post("no_actualizar_fecha");
    if ($no_actualizar_fecha === FALSE) $no_actualizar_fecha = 0;
    $para = $this->input->post("para");
    if ($para === FALSE) $para = "";
    $bcc = $this->input->post("bcc");
    if ($bcc === FALSE) $bcc = "";
    $custom = $this->input->post("custom");
    if ($custom === FALSE) $custom = "";
    $testing = $this->input->post("testing");
    if ($testing === FALSE) $testing = 0;
    // Template enviado al mismo cliente
    $template = $this->input->post("template");
    if ($template === FALSE) $template = "";

    // Se envia el cliente como parametro, no se envian los datos de contacto
    // esto se usa por ejemplo cuando lo tenemos guardado con una cookie
    $id_cliente = parent::get_post("id_cliente",0);

    // Este es un parametro especial que se usa para el CHAT
    // Como en el registro antes de enviar un whatsapp no se pide email,
    // mandamos este parametro para que busque y enlace el contacto por el telefono
    // ya que el telefono es obligatorio
    $buscar_telefono = parent::get_post("buscar_telefono",0);

    // En caso de tener que crear una nueva entrada 
    $crear_entrada = parent::get_post("crear_entrada",0);
    $entrada_titulo = parent::get_post("entrada_titulo","");
    $entrada_subtitulo = parent::get_post("entrada_subtitulo","");
    $entrada_id_categoria = parent::get_post("entrada_id_categoria",0);
    $entrada_ids_etiquetas = parent::get_post("entrada_ids_etiquetas",0);
    $entrada_id_pais = parent::get_post("entrada_id_pais",0);
    $entrada_activo = parent::get_post("entrada_activo",0);
    $entrada_base_link = parent::get_post("entrada_base_link","");
    $entrada_direccion = parent::get_post("entrada_direccion","");
    $entrada_localidad = parent::get_post("entrada_localidad","");
    $entrada_custom_1 = parent::get_post("entrada_custom_1","");
    $entrada_custom_2 = parent::get_post("entrada_custom_2","");
    $entrada_custom_3 = parent::get_post("entrada_custom_3","");
    $entrada_custom_4 = parent::get_post("entrada_custom_4","");
    $entrada_custom_5 = parent::get_post("entrada_custom_5","");
    $entrada_custom_6 = parent::get_post("entrada_custom_6","");
    $entrada_custom_7 = parent::get_post("entrada_custom_7","");
    $entrada_custom_8 = parent::get_post("entrada_custom_8","");
    $entrada_custom_9 = parent::get_post("entrada_custom_9","");
    $entrada_custom_10 = parent::get_post("entrada_custom_10","");
    $entrada_fecha = parent::get_post("entrada_fecha",date("Y-m-d H:i:s"));

    $link_ficha_propiedad = parent::get_post("link_ficha_propiedad","");
    $pagina = parent::get_post("pagina","");

    // 1 = Contacto por defecto
    $tipo = ($this->input->post("tipo") !== FALSE) ? ((int) $this->input->post("tipo")) : 1;
    // 1 = Manda solo el campo mensaje
    $solo_mensaje = ($this->input->post("solo_mensaje") !== FALSE) ? ((int) $this->input->post("solo_mensaje")) : 0;

    // Si estamos usando reCAPTCHA
    $captcha = $this->input->post("g-recaptcha-response");
    if ($captcha !== FALSE) {
      require APPPATH.'libraries/recaptchalib.php';
      $site_key = "6LeHSTQUAAAAAA5FV121v-M7rnhqdkXZIGmP9N8E";
      $secret = "6LeHSTQUAAAAACG9dCyy6hv24tlRYL8TKtxe4O54";
      $reCaptcha = new ReCaptcha($secret);
      $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $captcha
      );
      if ($resp == null || !isset($resp->success) || $resp->success === FALSE) {
        $salida = array(
          "mensaje"=>"El codigo de validacion es incorrecto.",
          "error"=>1,
        );
        echo json_encode($salida);
        exit();
      }
    }

    // Si no esta definida la empresa, tiene que estar si o si el parametro DOMINIO
    $id_empresa = $this->input->post("id_empresa");
    if ($id_empresa === FALSE) {

      $dominio = $this->input->post("dominio");
      if ($dominio === FALSE) {
        echo json_encode(array(
          "error"=>1,
          "mensaje"=>"Falta el parametro DOMINIO",
        ));
        return;
      }
      // Buscamos la empresa por el dominio que fue enviado por parametro
      $this->load->model("Empresa_Model");
      $empresa = $this->Empresa_Model->get_empresa_by_dominio($dominio);
      if ($empresa === FALSE) {
        echo json_encode(array(
          "error"=>1,
          "mensaje"=>"No existe la cuenta de empresa con dominio $dominio.",
        ));
        return;
      }
      $empresa->nombre = ucwords(strtolower($empresa->nombre));

      // TODO: Controlar que la empresa esta al dia con los pagos
      // TODO: Controlar que la empresa tiene habilitado el CHATBOT

      // Parametros especificos del CHAT
      $id_empresa = $empresa->id;
      $asunto = "Contacto desde chat";
      $testing = 1; // Por ahora el chat esta a prueba
      $para = $empresa->email;
      $bcc = $empresa->bcc_email;

    } else {

      // Si es una web nuestra, los emails son obligatorios
      /*
      if (empty($email)) {
        echo json_encode(array(
          "error"=>1,
          "mensaje"=>"Por favor ingrese un email."
        ));
        return;
      } 
      */ 
      $asunto = (empty($asunto)) ? "Contacto" : $asunto;
    }

    // En el caso de estar consultando por una propiedad de la red
    $id_empresa_relacion = parent::get_post("id_empresa_relacion",$id_empresa);

    // Si la empresa no esta definida, es porque es para el Administrador
    if (empty($id_empresa) || $id_empresa == 0) {
     
      $body = "";
      if (!empty($nombre)) $body.= "Nombre: $nombre <br/>";
      if (!empty($asunto)) $body.= "Asunto: $asunto <br/>";
      if (!empty($email)) $body.= "Email: $email <br/>";
      if (!empty($telefono)) $body.= "Telefono: $telefono <br/>";
      if (!empty($mensaje)) $body.= "Comentarios: $mensaje <br/>";
      $headers = "From: $email\r\n";
      $headers.= "MIME-Version: 1.0\r\n";
      $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      $to = "soporte@varcreative.com,basile.matias99@gmail.com";
      @mail($to,$asunto,$body,$headers);
    
    } else {
   
      if (!isset($empresa)) {
        $this->load->model("Empresa_Model");
        $empresa = $this->Empresa_Model->get($id_empresa);        
      }
      if (empty($bcc) && isset($empresa->bcc_email)) $bcc = $empresa->bcc_email;

      if (isset($para) && empty($para)) $para = $empresa->email;
      if (!is_array($para)) $para = explode(",", $para);
      
      // Buscamos por el parametro id_cliente
      $contacto = FALSE;
      if (!empty($id_cliente)) $contacto = $this->Cliente_Model->get($id_cliente,$id_empresa);

      // Si no se encontro anteriormente un contacto
      if ($contacto === FALSE) {
        if ($buscar_telefono == 0) {
          // Si se paso un email, buscamos el contacto para saber si existe
          $contacto = (!empty($email)) ? $this->Cliente_Model->get_by_email($email,$id_empresa) : FALSE;
        } else {
          // Sino, buscamos por el numero de telefono
          $contacto = $this->Cliente_Model->get_by_telefono($telefono,array(
            "id_empresa"=>$id_empresa
          ));
        }
      }

      // Si estamos consultando por una propiedad
      // pero el origen no es whatsapp
      if ($id_empresa != 45) {
        if (!empty($id_propiedad) && !($id_origen == 30 || $id_origen == 31)) {
          $this->load->model("Propiedad_Model");
          $propiedad = $this->Propiedad_Model->get($id_propiedad,array(
            "id_empresa"=>$id_empresa_relacion
          ));
          // Si no estamos definiendo un usuario desde la web, tenemos que poner el asignado en la propiedad
          if (empty($id_usuario)) $id_usuario = $propiedad->id_usuario;

          // Dependiendo de la configuracion
          $this->load->model("Web_Configuracion_Model");
          $web = $this->Web_Configuracion_Model->get($id_empresa);
          
          // Se tiene que enviar solo al usuario de la propiedad asignada
          if (isset($web->crm_notificar_usuario_propiedad) && $web->crm_notificar_usuario_propiedad == 1) {

            // Si es una propiedad de la misma empresa (no una de la RED)
            if ($propiedad->id_empresa == $id_empresa) {

              if (isset($propiedad->usuario_email) && !empty($propiedad->usuario_email)) {
                // Si tiene seteado un usuario, le mandamos a ese
                $para = array($propiedad->usuario_email);
                $id_usuario = $propiedad->id_usuario;

              } else {

                // En caso de que la propiedad no tenga usuario asignado
                if (isset($web->crm_enviar_emails_usuarios) && $web->crm_enviar_emails_usuarios == 0) {
                  $para = array($empresa->email);
                  $id_usuario = 0;

                } else if (isset($web->crm_enviar_emails_usuarios) && $web->crm_enviar_emails_usuarios == 1) {
                  // Entonces tenemos que elegir aleatoriamente uno
                  $this->load->model("Usuario_Model");
                  $aleatorio = $this->Usuario_Model->get_random(array(
                    "id_empresa"=>$id_empresa,
                  ));
                  if ($aleatorio !== FALSE) {
                    $para = array($aleatorio->email);
                    $id_usuario = $aleatorio->id;
                  }
                }
              }

            // Se esta consultando por una propiedad compartida
            } else {

              // En caso de que la propiedad no tenga usuario asignado
              if (isset($web->crm_enviar_emails_usuarios) && $web->crm_enviar_emails_usuarios == 0) {
                $para = array($empresa->email);
                $id_usuario = 0;

              } else if (isset($web->crm_enviar_emails_usuarios) && $web->crm_enviar_emails_usuarios == 1) {
                // Entonces tenemos que elegir aleatoriamente uno
                $this->load->model("Usuario_Model");
                $aleatorio = $this->Usuario_Model->get_random(array(
                  "id_empresa"=>$id_empresa,
                ));
                if ($aleatorio !== FALSE) {
                  $para = array($aleatorio->email);
                  $id_usuario = $aleatorio->id;
                }
              }

            }
          }

          // Se tiene que mandar tambien al email de la inmobiliaria
          if (isset($web->crm_notificar_inmobiliaria) && $web->crm_notificar_inmobiliaria == 1) {
            $para[] = $empresa->email;
          }        
        }
      }
      
      if ($contacto === FALSE) {
        // Debemos crearlo
        $contacto = new stdClass();
        $contacto->id_empresa = $id_empresa;
        $contacto->email = $email;
        $contacto->nombre = $nombre;
        $contacto->telefono = $telefono;
        $contacto->fax = $prefijo;
        $contacto->celular = $celular;
        $contacto->direccion = $direccion;
        $contacto->localidad = $ciudad;
        $contacto->id_localidad = $id_localidad;
        $contacto->id_usuario = $id_usuario;
        $contacto->fecha_inicial = date("Y-m-d");
        $contacto->fecha_ult_operacion = date("Y-m-d H:i:s");
        // Por defecto le ponemos contreña 1 a los que consultan para no tener problemas al momento de comprar
        $contacto->password = "c4ca4238a0b923820dcc509a6f75849b";
        $contacto->tipo = $tipo; // 1 = Contacto
        $contacto->activo = 1; // El cliente esta activo por defecto
        $contacto->id_sucursal = 0; // Para que en algunas BD no tire error de default value
        $contacto->custom_3 = (($empresa->id_proyecto == 3) ? "1" : "");
        $id = $this->Cliente_Model->insert($contacto);
        $contacto->id = $id;

        // REGISTRAMOS COMO UN EVENTO LA CREACION DEL NUEVO USUARIO
        $this->load->model("Consulta_Model");
        $this->Consulta_Model->registro_creacion_usuario(array(
          "id_contacto"=>$id,
          "id_empresa"=>$id_empresa,
        ));
      } else {
        // Si hay algun dato distinto, debemos actualizarlo
        $updates = array();
        if (!empty($nombre) && $nombre != $contacto->nombre) $updates[] = array("key"=>"nombre","value"=>$nombre);
        if (!empty($telefono) && $telefono != $contacto->telefono) $updates[] = array("key"=>"telefono","value"=>$telefono);
        if (!empty($prefijo) && $prefijo != $contacto->fax) $updates[] = array("key"=>"fax","value"=>$prefijo);
        if (!empty($id_usuario) && $id_usuario != $contacto->id_usuario) $updates[] = array("key"=>"id_usuario","value"=>$id_usuario);
        if (!empty($direccion) && $direccion != $contacto->direccion) $updates[] = array("key"=>"direccion","value"=>$direccion);
        if (!empty($localidad) && $localidad != $contacto->localidad) $updates[] = array("key"=>"localidad","value"=>$localidad);
        if (!empty($celular) && $celular != $contacto->celular) $updates[] = array("key"=>"celular","value"=>$celular);
        if (!empty($id_localidad) && $id_localidad != $contacto->id_localidad) $updates[] = array("key"=>"id_localidad","value"=>$id_localidad);
        if (sizeof($updates)>0) {
          $sql = "UPDATE clientes SET ";
          for ($it=0; $it < sizeof($updates); $it++) { 
            $up = $updates[$it];
            $sql.= $up["key"]." = '".$up["value"]."' ".(($it<sizeof($updates)-1)?",":"");
          }
          $sql.= "WHERE id = $contacto->id AND id_empresa = $id_empresa ";
          $this->db->query($sql);
        }
      }

      // Si no fue seteada el id de la empresa, la seteamos con el contacto buscado
      // para que mas adelante no tire error que no encuentra $id_empresa
      $id_empresa = $contacto->id_empresa;      

      // Dependiendo de cual atributo se envio
      $id_referencia = 0;
      if ($id_propiedad != 0) $id_referencia = $id_propiedad;
      else if ($id_articulo != 0) $id_referencia = $id_articulo;
      else if ($id_viaje != 0) $id_referencia = $id_viaje;
      else if ($id_auto != 0) $id_referencia = $id_auto;
      
      $fecha = date("Y-m-d H:i:s");
      $consulta = new stdClass();
      $consulta->id_empresa = $id_empresa;
      $consulta->id_empresa_relacion = $id_empresa_relacion;
      $consulta->id_entrada = $id_entrada;
      $consulta->fecha = $fecha;
      $consulta->hora = date("H:i:s");
      $consulta->asunto = $asunto;
      $consulta->subtitulo = $subtitulo;
      $consulta->texto = $mensaje;
      $consulta->id_contacto = $contacto->id;
      $consulta->id_origen = $id_origen;
      $consulta->id_usuario = $id_usuario;
      $consulta->id_referencia = $id_referencia;
      $this->modelo->insert($consulta);

      // Actualizamos el contacto con la ultima fecha de operacion
      $sql = "UPDATE clientes SET ";
      if ($no_actualizar_fecha == 0) $sql.= "fecha_ult_operacion = '$fecha', ";
      $sql.= "tipo = '$tipo', "; // Vuelve a TIPO = 1 (A CONTACTAR)
      $sql.= "no_leido = 1 ";
      $sql.= "WHERE id = $contacto->id AND id_empresa = $id_empresa ";
      $this->db->query($sql);

      // Guardamos una cookie del cliente
      setcookie("idc",$contacto->id,time()+60*60*24*365,"/");
      setcookie("vc_nombre",$contacto->nombre,time()+60*60*24*365,"/");
      setcookie("vc_email",$contacto->email,time()+60*60*24*365,"/");
      setcookie("vc_telefono",$contacto->telefono,time()+60*60*24*365,"/");

      // Por las dudas que haya quedado algun repetido, lo eliminamos y listo
      $para = array_unique($para);

      $body = "";
      if ($solo_mensaje == 1) {
        $body = nl2br($mensaje);
      } else {
        if ($id_origen == 30 || $id_origen == 31) { 

          $stamp = time();
          $sql = "INSERT INTO whatsapp_clicks (id_empresa,id_usuario,stamp,pagina) VALUES ('$id_empresa','$id_usuario','$stamp','$pagina') ";
          $this->db->query($sql);

          // Contacto de Clienapp (sea directo o fuera de linea)
          $clave_template = (($id_origen == 31) ? "contacto-clienapp-fuera-linea" : "contacto-clienapp");
          $temp = $this->Email_Template_Model->get_by_key($clave_template,1);
          $asunto = $temp->nombre;
          $body = $temp->texto;
          $link_panel = "https://app.inmovar.com/admin/app/#cliente_acciones/".$contacto->id;
          $link_whatsapp = "https://wa.me/".$prefijo.$telefono."?text=".urlencode("Hola $nombre muchas gracias por contactarte con nosotros");
          $body = str_replace("{{empresa}}", htmlentities($empresa->nombre,ENT_QUOTES), $body);
          $body = str_replace("{{nombre}}", $nombre, $body);
          $body = str_replace("{{telefono}}", $prefijo.$telefono, $body);
          $body = str_replace("{{email}}", $email, $body);
          $body = str_replace("{{subtitulo}}", $subtitulo, $body);
          $body = str_replace("{{mensaje}}", nl2br($mensaje), $body);
          $body = str_replace("{{link_whatsapp}}", $link_whatsapp, $body);
          $body = str_replace("{{link_panel}}", $link_panel, $body);

        } else {

          if (!empty($nombre)) $body.= "<b>Nombre:</b> $nombre <br/>";
          if (isset($para) && !empty($para)) {
            if (is_array($para)) $para = implode(", ", $para);
            $body.= "<b>Para:</b> $para <br/>";
          }
          if (!empty($email)) $body.= "<b>Email:</b> <a href='mailto:$email'>$email</a> <br/>";
          if (!empty($telefono)) $body.= "<b>Telefono:</b> <a href='tel:".$prefijo.$telefono."'>".$prefijo.$telefono."</a><br/>";
          if (!empty($ciudad)) $body.= "<b>Ciudad:</b> $ciudad <br/>";

          $link_propiedad = "";
          if (isset($empresa->dominios) && sizeof($empresa->dominios)>0 && isset($propiedad) && isset($propiedad->link)) {
            $link_propiedad = "https://".$empresa->dominios[0]."/".$propiedad->link;
            if ($propiedad->id_empresa != $id_empresa) $link_propiedad.= "?em=$propiedad->id_empresa";
            $link_propiedad = "<a href='".$link_propiedad."' target='_blank'>Ver propiedad</a>";
          }
          if (!empty($asunto)) $body.= "<b>Interesado en:</b> $asunto ".($link_propiedad)."<br/>";
          if (!empty($mensaje)) $body.= "<b>Comentarios:</b><br/> ".nl2br($mensaje)." <br/>";

          // Si existe el template asignado
          $temp = $this->Email_Template_Model->get_by_key("consulta",1);
          if ($temp !== FALSE) {
            $body_ant = $body;
            $body = $temp->texto;
            $body = str_replace("{{cuerpo}}", $body_ant, $body);
            $empresa_nombre = htmlentities($empresa->nombre,ENT_QUOTES);
            $empresa_nombre = ucwords(strtolower($empresa_nombre));
            $body = str_replace("{{nombre}}", $empresa_nombre, $body);
          }
        }        
      }

      if ($crear_entrada == 1) {
        $sql = "INSERT INTO not_entradas (fecha,id_empresa,titulo,subtitulo,id_categoria,activo,direccion,localidad,id_pais,custom_1,custom_2,custom_3,custom_4,custom_5,custom_6,custom_7,custom_8,custom_9,custom_10,eliminada) VALUES (";
        $sql.= "'$entrada_fecha','$id_empresa','$entrada_titulo','$entrada_subtitulo','$entrada_id_categoria','$entrada_activo','$entrada_direccion','$entrada_localidad','$entrada_id_pais','$entrada_custom_1','$entrada_custom_2','$entrada_custom_3','$entrada_custom_4','$entrada_custom_5','$entrada_custom_6','$entrada_custom_7','$entrada_custom_8','$entrada_custom_9','$entrada_custom_10',0)";
        file_put_contents("log_crear_entrada.txt", $sql."\n", FILE_APPEND);
        $this->db->query($sql);
        $id_entrada = $this->db->insert_id();
        $this->load->helper("file_helper");
        $link = $entrada_base_link."entrada/".filename($titulo,"-",0)."-".$id_entrada."/";
        $this->db->query("UPDATE not_entradas SET link = '$link' WHERE id = $id_entrada AND id_empresa = $id_empresa");
        if (!empty($entrada_ids_etiquetas)) {
          $ids_etiquetas = explode(",", $entrada_ids_etiquetas);
          foreach($ids_etiquetas as $id_etiqueta) {
            $this->db->query("INSERT INTO not_entradas_etiquetas (id_entrada,id_etiqueta,id_empresa) VALUES ($id_entrada,$id_etiqueta,$id_empresa) ");
          }
        }
      }

      $bcc_array = array();
      if ($testing == 1) $bcc_array[] = "basile.matias99@gmail.com";
      if (!empty($bcc)) {
        $arr = explode(",", $bcc);
        $bcc_array = array_merge($bcc_array,$arr);
        $bcc_array = array_unique($bcc_array);
      }

      require_once APPPATH.'libraries/Mandrill/Mandrill.php';
      mandrill_send(array(
        "to"=>$para,
        "from"=>(($id_empresa == 186) ? "info@varcreative.com" : "no-reply@varcreative.com"),
        "from_name"=>$empresa->nombre,
        "subject"=>html_entity_decode($asunto,ENT_QUOTES),
        "body"=>$body,
        "reply_to"=>$email,
        "bcc"=>$bcc_array,
      ));

      // Si tenemos que enviarle un template al mismo cliente
      if (!empty($template)) {
        
        $temp = $this->Email_Template_Model->get_by_key($template,$id_empresa);
        if ($temp !== FALSE) {
          $bcc_array = array_merge($bcc_array,$para);
          $body = $temp->texto;
          $body = str_replace("{{nombre}}", $nombre, $body);
          $body = str_replace("{{name}}", $nombre, $body);
          $body = str_replace("{{link_ficha_propiedad}}", $link_ficha_propiedad, $body);
          mandrill_send(array(
            "to"=>$email,
            "from"=>"no-reply@varcreative.com",
            "from_name"=>$empresa->nombre,
            "subject"=>$temp->nombre,
            "body"=>$body,
            "reply_to"=>$para,
            "bcc"=>$bcc_array,
          ));
        }
      }

      // Si la consulta la tenemos que enviar a TOKKO
      if (isset($empresa->config["tokko_apikey"]) && isset($empresa->config["tokko_enviar_consultas"]) && !empty($empresa->config["tokko_apikey"]) && $empresa->config["tokko_enviar_consultas"] == 1) {
        $this->load->library("tokko/TokkoWebContact");
        $auth = new TokkoAuth($empresa->config["tokko_apikey"]);
        $etiqueta = (($id_origen == 30 || $id_origen == 31) ? "Clienapp" : "Web");
        $data = array(
          'text' => ((!empty($subtitulo)) ? "Contacto desde: ".$subtitulo." | " : "").$mensaje,
          'name' => $nombre,
          'email' => $email,
          'cellphone' => $prefijo.$telefono,
          'tags' => array($etiqueta),
        );
        $webcontact = new TokkoWebContact($auth, $data);
        $response = $webcontact->send();        
      }

      // Si tenemos que mandar a Analytics
      // TODO: Hacer esto autoadministrable
      if ($id_empresa == 202 || $id_empresa == 900 || $id_empresa == 1336) {
        $url = 'http://www.google-analytics.com/collect';
        if ($id_empresa == 202) {
          $fields = [
            'v' => '1',
            'tid' => 'UA-97019594-1',
            'cid' => '555',
            't' => 'event',
            'ec' => 'Mistica Studio',
            'ea' => (($id_origen == 30 || $id_origen == 31) ? 'Whatsapp iniciado' : 'Mensaje Enviado'),
            'el' => (($id_origen == 30 || $id_origen == 31) ? 'Whatsapp' : 'Formulario'),
            'ev' => '1'
          ];
        } else {
          $fields = [
            'v' => '1',
            'tid' => 'UA-2156674-7',
            'cid' => '555',
            't' => 'event',
            'ec' => 'Whatsapp',
            'ea' => 'Iniciar Chat',
            'el' => 'boton',
            'ev' => '1'
          ];          
        }
        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);        
      }

    }
    
    $s = array("error"=>0);
    // Si se envio un cliente, mandamos la info actualizada
    if (!empty($id_cliente) || $id_origen == 30 || $id_origen == 31) {
      $s["nombre"] = $contacto->nombre;
      $s["email"] = $contacto->email;
      $s["telefono"] = $contacto->telefono;
    }
    echo json_encode($s);
  }

  function exportar($id_origen = 0) {
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename=consultas.csv');
    header('Pragma: no-cache');
    $id_empresa = parent::get_empresa();
    $sql = "SELECT CTO.email, CTO.nombre, CTO.telefono, CTA.* ";
    $sql.= "FROM crm_consultas CTA INNER JOIN clientes CTO ON (CTA.id_contacto = CTO.id) ";
    $sql.= "WHERE CTA.id_empresa = $id_empresa ";
    if ($id_origen != 0) $sql.= "AND CTA.id_origen = $id_origen ";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
     echo $r->nombre.";";
     echo $r->email.";";
     echo $r->telefono.";";
     echo "\n";
   }
 }
 
}
