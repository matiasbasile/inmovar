<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Clientes extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Cliente_Model', 'modelo');
  }

  private $codigo_validacion_toque = 7569;
  private $codigo_validacion_pedienchacabuco = 8921;

  function eliminar_por_lote() {
    $id_empresa = parent::get_empresa();
    $ids = parent::get_post("ids");
    if (!is_array($ids) || sizeof($ids) == 0) {
      echo json_encode(array("error"=>1));
      exit();
    }
    foreach($ids as $id) {
      $this->modelo->delete($id);
    }    
    echo json_encode(array("error"=>0));
  }

  // USADO EN CRM/CONSULTAS
  function editar_tipo() {
    $id_empresa = parent::get_empresa();
    $ids = parent::get_post("ids");
    $custom_1 = parent::get_post("custom_1",""); // OBSERVACIONES
    $id_asunto = parent::get_post("id_asunto",0); // MOTIVO
    $ids = explode(",", $ids);
    $tipo = parent::get_post("tipo",-1);
    $fecha_vencimiento = parent::get_post("fecha_vencimiento","");
    $id_usuario = parent::get_post("id_usuario",0);

    foreach($ids as $id) {
      $salida = $this->modelo->editar_tipo(array(
        "id_empresa"=>$id_empresa,
        "id"=>$id,
        "id_usuario"=>$id_usuario,
        "fecha_vencimiento"=>$fecha_vencimiento,
        "id_asunto"=>$id_asunto,
        "custom_1"=>$custom_1,
        "tipo"=>$tipo,
      ));
      if ($salida["error"] == 1) {
        echo json_encode($salida);
        exit();
      }
    }
    echo json_encode(array("error"=>0));
  }

  // USADO EN CRM/CONSULTAS
  function editar_vencimiento() {
    $id_empresa = parent::get_empresa();
    $ids = parent::get_post("ids");
    $ids = explode(",", $ids);
    $tipo = parent::get_post("tipo",-1);
    foreach($ids as $id) {
      $salida = $this->modelo->editar_vencimiento(array(
        "id_empresa"=>$id_empresa,
        "id"=>$id,
        "tipo"=>$tipo,
      ));
      if ($salida["error"] == 1) {
        echo json_encode($salida);
        exit();
      }
    }
    echo json_encode(array("error"=>0));
  }  

  function ver_calendario_pagos() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $id_empresa = parent::get_empresa();
    $desde = parent::get_post("desde");
    $hasta = parent::get_post("hasta");
    $this->load->helper("fecha_helper");
    $desde = fecha_mysql($desde);
    $hasta = fecha_mysql($hasta);
    $id_vendedor = parent::get_post("id_vendedor",0);
    $id_proyecto = parent::get_post("id_proyecto",0);
    $estado_empresa = parent::get_post("estado_empresa",-1);
    $this->load->model("Cliente_Model");
    $clientes = $this->Cliente_Model->buscar(array(
      "offset"=>999999,
    ));
    $d = new DateTime($desde);
    $h = new DateTime($hasta);
    $interval = DateInterval::createFromDateString('1 month');
    $period = new DatePeriod($d, $interval, $h);
    $salida = array(
      "meses"=>array(),
      "resultado"=>array(),
      "totales"=>array(),
    );
    foreach($period as $dt) {
      $salida["meses"][] = $dt->format("m/Y");
      $salida["totales"][] = 0;
    }
    // Recorremos las empresas
    foreach($clientes["results"] as $cliente) {

      $estado = -1;
      $proyecto = "";
      $vendedores = array();

      if ($id_empresa == 936) {
        // Si es VARCREATIVE
        // A los clientes lo enlazamos con las empresas
        $sql = "SELECT E.*, PRO.nombre AS proyecto FROM empresas E INNER JOIN com_proyectos PRO ON (E.id_proyecto = PRO.id) WHERE E.id = $cliente->id ";
        $qq = $this->db->query($sql);
        if ($qq->num_rows() == 0) continue;
        $empresa = $qq->row();

        // Aplicamos el filtro por proyecto
        if ($id_proyecto != 0 && $id_proyecto != $empresa->id_proyecto) continue;
        // Si son webs propias, no las mostramos
        if ($empresa->id_proyecto == 9) continue;

        // Aplicamos el filtro por estado de empresa
        if ($estado_empresa != -1 && $estado_empresa != $empresa->estado_empresa) continue;

        // Aplicamos el filtro por vendedor
        $sql = "SELECT EV.*, V.nombre FROM empresas_vendedores EV INNER JOIN com_usuarios V ON (EV.id_usuario = V.id AND V.admin = 1) WHERE EV.id_empresa = $empresa->id ";
        if ($id_vendedor != 0) $sql.= "AND id_usuario = $id_vendedor ";
        $qq = $this->db->query($sql);
        if ($id_vendedor != 0 && $qq->num_rows() == 0) continue;
        foreach($qq->result() as $v) {
          $vendedores[] = $v;
        }

        $estado = $empresa->estado_empresa;
        $proyecto = $empresa->proyecto;
      }
      $emp = array(
        "id"=>$cliente->id,
        "cliente"=>$cliente->nombre,
        "estado_empresa"=>$estado,
        "proyecto"=>$proyecto,
        "vendedores"=>$vendedores,
        "pagos"=>array(),
      );
      $i=0;
      foreach($period as $dt) {
        $sql = "SELECT SUM(ABS(F.cta_cte) * IF(TC.negativo = 1,-1,1)) AS total ";
        $sql.= "FROM facturas F ";
        $sql.= "INNER JOIN tipos_comprobante TC ON (F.id_tipo_comprobante = TC.id) ";
        $sql.= "WHERE F.id_empresa = $id_empresa ";
        $sql.= "AND F.id_cliente = $cliente->id ";
        $sql.= "AND F.anulada = 0 ";
        $sql.= "AND F.fecha >= '".$dt->format("Y-m-01")."' ";
        $sql.= "AND F.fecha <= '".$dt->format("Y-m-t")."' ";
        $qq = $this->db->query($sql);
        $rr = $qq->row();
        $monto = $rr->total;
        $emp["pagos"][] = array(
          "monto"=>$monto
        );
        $salida["totales"][$i] += $monto;
        $i++;
      }
      $salida["resultado"][] = $emp;
    }
    echo json_encode($salida);
  }  

  // Comprueba si el email existe en la base de datos
  function check_email() {
    header('Access-Control-Allow-Origin: *');
    $id_empresa = parent::get_post("id_empresa",0);
    $tipo = parent::get_post("tipo",-1);
    if (!is_numeric($id_empresa)) {
      echo json_encode(array("error"=>1,"mensaje"=>"Error param id_empresa"));
      exit();
    }
    if (!is_numeric($tipo)) {
      echo json_encode(array("error"=>1,"mensaje"=>"Error param tipo"));
      exit();
    }
    $email = parent::get_post("email","");
    $sql = "SELECT * FROM clientes WHERE email = '$email' AND id_empresa = $id_empresa ";
    if ($tipo != -1) $sql.= "AND tipo = '$tipo' ";
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
      echo json_encode(array("error"=>0));
    } else {
      echo json_encode(array("error"=>1,"mensaje"=>"The email does not exist. Please sign up."));
    }
  }

  // Esta funcion activa el cliente y redirige hacia el parametro "u"
  // Sirve como {{link}} cuando se envia una validacion de email
  function registro_valido() {
    header('Access-Control-Allow-Origin: *');
    $id_empresa = parent::get_get("e",0);
    $id_cliente = parent::get_get("c",0);
    $url = parent::get_get("u","");

    $sql = "SELECT * FROM clientes WHERE id_empresa = '$id_empresa' AND id = '$id_cliente' LIMIT 0,1 ";
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
      $r = $q->row();

      // Activamos el cliente
      $sql = "UPDATE clientes SET activo = 1 WHERE id_empresa = '$id_empresa' AND id = '$id_cliente' ";
      $this->db->query($sql);

      if ($id_empresa == 256) {
        $this->modelo->enviar_constant_contact(array(
          "id_empresa"=>256,
          "nombre"=>$r->nombre,
          "email"=>$r->email,
          "listas"=>["a3bfd2a6-3183-11ea-8915-d4ae5275dbea"],
        ));
      }
    }

    // Analizamos la URL para agregarle el parametro especial para hacer que la pagina haga un login al principio
    if (strpos($url, "?") === FALSE) {
      if (substr($url, -1, 1) == "/") $url.= "?check=".$id_cliente;
      else $url.= "/?check=".$id_cliente;
    } else $url.= "&check=".$id_cliente;
    header("Location: ".$url);
  }

  function convertir_empresas() {
    $id_empresa = 1;
    $sql = "SELECT * FROM empresas";
    $q = $this->db->query($sql);
    foreach($q->result() as $row) {
      $celular = $row->telefono_empresa;
      $celular = preg_replace("/[^0-9]/", "", $celular );
      $cuit = $row->cuit;
      $cuit = preg_replace("/[^0-9]/", "", $cuit );
      $sql = "INSERT INTO clientes (";
      $sql.= " id_empresa, id, codigo, tipo, nombre, id_tipo_documento, cuit, direccion, ";
      $sql.= " id_localidad, id_provincia, id_tipo_iva, activo, email, celular, fecha_inicial, path, forma_pago ";
      $sql.= ") VALUES (";
      $sql.= " '$id_empresa', '$row->id', '$row->id', 1, '$row->razon_social', '80', '$cuit', '$row->direccion_empresa', ";
      $sql.= " '$row->id_localidad', '$row->id_provincia', '$row->id_tipo_contribuyente', 1, '$row->email', '$celular', '$row->fecha_alta', '$row->path', 'C' ";
      $sql.= ")";
      $this->db->query($sql);
    }
    echo "TERMINO";
  }

  function ajuste_masivo_canasta_basica() {
    $id_empresa = parent::get_empresa();
    $ids = parent::get_post("ids","");
    $estado = parent::get_post("estado",1);
    $ids = str_replace("-", ",", $ids);
    $fecha = date("Y-m-d");
    $sql = "UPDATE clientes SET custom_5 = '$estado' ";
    $sql.= "WHERE id_empresa = $id_empresa ";
    $sql.= "AND id IN ($ids) ";
    $this->db->query($sql);
    echo json_encode(array(
      "error"=>0,
    ));
  }  

  function calcular_links() {
    $this->load->helper("file_helper");
    $sql = "SELECT * FROM clientes ";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
      $r->nombre = trim($r->nombre);
      $r->nombre = strtolower($r->nombre);
      $link = filename($r->nombre,"-",0);
      $this->db->query("UPDATE clientes SET nombre_fantasia = '$link' WHERE id = $r->id ");  
    }
    echo "TERMINO";
  }

  function calcular_total_facturacion() {
    $id_empresa = 622;
    $sql = "SELECT * FROM clientes_etiquetas_relacion WHERE id_empresa = $id_empresa";
    $q = $this->db->query($sql);
    $total = 0;
    $i=0;
    foreach($q->result() as $c) {
      $sql = "SELECT * FROM facturas WHERE id_empresa = $id_empresa AND id_cliente = $c->id_cliente AND fecha < '2019-06-01' ";
      $q_fact = $this->db->query($sql);
      if ($q_fact->num_rows()>0) {
        $fact = $q_fact->row();
        $total += $fact->total;
        $i++;
      } else {
        echo "No se encuentra factura de $c->id_cliente<br/>";
      }
    }
    echo "COMPROBANTES: $i<br/>";
    echo "TOTAL: ".$total;
  }

  function validar_verificacion() {
    header('Access-Control-Allow-Origin: *');
    $id_cliente = parent::get_post("id_cliente",0);
    $codigo = parent::get_post("codigo","");
    $id_empresa = parent::get_post("id_empresa",0);    
    $this->load->model("Empresa_Model");
    if ($this->Empresa_Model->es_toque($id_empresa)) {
      $this->load->model("Cliente_Model");
      $cliente = $this->Cliente_Model->get($id_cliente,$id_empresa,array(
        "buscar_consultas"=>0,
        "buscar_etiquetas"=>0,
      ));
      if ($cliente === FALSE) {
        echo json_encode(array("error"=>1)); exit();
      }
      if (($id_empresa == 571 && $codigo == $this->codigo_validacion_toque) || 
          ($id_empresa == 1234 && $codigo == $this->codigo_validacion_pedienchacabuco)) 
      {
        $this->db->query("UPDATE clientes SET activo = 1 WHERE id = $id_cliente AND id_empresa = $id_empresa");
        $tiempo = time()+(60*60*24*90);
        setcookie("activo",1,$tiempo,"/");  
        $error = 0;
        echo json_encode(array(
          "email"=>$cliente->email,
          "password"=>$cliente->password,
          "error"=>0,
        ));
      } else {
        echo json_encode(array(
          "error"=>1,
        ));      
      }
    } else {
      echo json_encode(array(
        "error"=>1,
      ));
    }
  }

  function enviar_sms_verificacion() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Access-Control-Allow-Origin: *');
    $id_cliente = parent::get_post("id_cliente",0);
    $id_empresa = parent::get_post("id_empresa",0);
    $url = parent::get_post("url",0); // Utilizado para redireccionar

    $this->load->model("Empresa_Model");
    $this->load->model("Cliente_Model");
    $cliente = $this->Cliente_Model->get($id_cliente,$id_empresa,array(
      "buscar_consultas"=>0,
      "buscar_etiquetas"=>0,
    ));
    if (!empty($cliente) && $this->Empresa_Model->es_toque($id_empresa)) {
      
      $this->load->helper("sms_helper");
      $celular = trim($cliente->telefono);
      $celular.= trim($cliente->celular);

      // Tambien por las dudas enviamos un email
      $this->load->model("Email_Template_Model");
      $template = $this->Email_Template_Model->get_by_key("email-verificacion",$id_empresa);
      if ($template !== FALSE) {
        if ($id_empresa == 571) $bcc_array = array();
        else $bcc_array = array("basile.matias99@gmail.com");

        require_once APPPATH.'libraries/Mandrill/Mandrill.php';
        $body = $template->texto;
        $body = str_replace("{{nombre}}", $cliente->nombre, $body);
        mandrill_send(array(
          "to"=>$cliente->email,
          "from"=>"no-reply@varcreative.com",
          "from_name"=>"Toque",
          "subject"=>$template->nombre,
          "body"=>$body,
          "bcc"=>$bcc_array,
        ));
      }

      echo json_encode(array(
        "error"=>0,
      ));

    } else {

      // BUSCAMOS SI TIENE UN TEMPLATE DE EMAIL LLAMADO "EMAIL-VERIFICACION"
      $this->load->model("Email_Template_Model");
      $template = $this->Email_Template_Model->get_by_key("email-verificacion",$id_empresa);
      if ($template !== FALSE) {

        $this->load->model("Empresa_Model");
        $empresa = $this->Empresa_Model->get_min($id_empresa);

        $bcc_array = array("basile.matias99@gmail.com");
        require_once APPPATH.'libraries/Mandrill/Mandrill.php';
        $body = $template->texto;

        // Reemplazamos con el link de verificacion
        $pars = http_build_query(array(
          "c"=>$id_cliente,
          "e"=>$id_empresa,
          "u"=>$url,
        ));
        $body = str_replace("{{link}}", "https://app.inmovar.com/admin/clientes/function/registro_valido/?".$pars, $body);        
        $body = str_replace("{{empresa}}", $empresa->nombre, $body);
        $body = str_replace("{{cliente}}", $cliente->nombre, $body);

        mandrill_send(array(
          "to"=>$cliente->email,
          "from"=>"no-reply@varcreative.com",
          "from_name"=>$empresa->nombre,
          "subject"=>$template->nombre,
          "body"=>$body,
          "bcc"=>$bcc_array,
        ));

        echo json_encode(array(
          "error"=>0,
          "mensaje"=>"Hemos enviado un email a su casilla de correo. Si no lo encuentra revise tambien su casilla de correo no deseado.",
        ));

      } else {

        // SI NO OCURRE NADA DE LO ANTERIOR, MANDAMOS EL ERROR
        echo json_encode(array(
          "error"=>1,
        ));
      }
    }
  }

  function generar_qr_link($id_cliente) {
    $id_empresa = parent::get_empresa();
    if ($id_empresa == 403) {
      $url_base = "https://aqfeed.info";
    } else {
      $url_base = "https://mymag.info";
    }
    $cliente = $this->modelo->get($id_cliente,$id_empresa,array(
      "buscar_consultas"=>0,
      "buscar_etiquetas"=>0,
    ));
    $this->load->model("Empresa_Model");
    $empresa = $this->Empresa_Model->get($id_empresa);
    $link = $url_base."/admin/qr/registrar/?e=".$id_empresa."&c=".$id_cliente."&l=".urlencode($cliente->codigo_postal);

    // Primero buscamos si ya hay una redireccion con ese mismo link
    $sql = "SELECT id FROM qr_redirecciones WHERE link = '$link' ";
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
      $r = $q->row();
      $id = $r->id;
    } else {
      // Buscamos el proximo ID
      $sql = "SELECT MAX(id) AS id FROM qr_redirecciones ";
      $q = $this->db->query($sql);
      $r = $q->row();
      $id = is_null($r->id) ? 1 : ($r->id + 1);
      // Insertamos
      $sql = "INSERT INTO qr_redirecciones (id,link) VALUES ('$id','$link') ";
      $this->db->query($sql);
    }
    echo json_encode(array(
      "link"=>$url_base."/e/".$id,
    ));
  }

  function generar_qr($id_cliente) {
    $id_empresa = parent::get_empresa();
    if ($id_empresa == 403) {
      $url_base = "https://aqfeed.info";
    } else {
      $url_base = "https://mymag.info";
    }
    $cliente = $this->modelo->get($id_cliente,$id_empresa,array(
      "buscar_consultas"=>0,
      "buscar_etiquetas"=>0,
    ));
    $this->load->model("Empresa_Model");
    $empresa = $this->Empresa_Model->get($id_empresa);
    $output = "png";
    $link = $url_base."/admin/qr/registrar/?e=".$id_empresa."&c=".$id_cliente."&l=".urlencode($cliente->codigo_postal);
    require APPPATH.'libraries/phpqrcode/qrlib.php';
    header('Content-Type: image/png');
    header('Content-Disposition: attachment; filename="QR '.$empresa->nombre.' '.$cliente->nombre.'.png"');
    QRcode::png($link);
  }

  function importar_excel() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $id_empresa = parent::get_empresa();
    $tabla = "clientes";
    try {
      $id = parent::start_import_excel(array(
        "tabla"=>$tabla
      ));
    } catch(Exception $e) {
      header("Location: /admin/app/#$tabla");
    }
    header("Location: /admin/app/#importacion/$tabla/$id");
  }

  function eliminar_repetidos() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    set_time_limit(0);
    $id_empresa = 133;
    $sql = "SELECT DISTINCT nombre FROM clientes WHERE id_empresa = $id_empresa ";
    $q = $this->db->query($sql);
    $ids = array();
    foreach($q->result() as $row) {
      $qq = $this->db->query("SELECT id FROM clientes WHERE nombre = '$row->nombre' AND id_empresa = $id_empresa ORDER BY cuit DESC LIMIT 0,1 ");
      $rr = $qq->row();
      $ids[] = array(
        "id"=>$rr->id,
        "nombre"=>$row->nombre,
      );
    }
    $eliminados = 0;
    foreach($ids as $row) {
      $sql = "SELECT id FROM clientes WHERE nombre = '".$row["nombre"]."' AND id_empresa = $id_empresa AND id != ".$row["id"];
      $qq = $this->db->query($sql);
      foreach($qq->result() as $rr) {
        $sql = "UPDATE facturas SET id_cliente = ".$row["id"]." WHERE id_cliente = $rr->id AND id_empresa = $id_empresa ";
        $this->db->query($sql);
        $sql = "UPDATE facturas_items SET id_cliente = ".$row["id"]." WHERE id_cliente = $rr->id AND id_empresa = $id_empresa ";
        $this->db->query($sql);
        $sql = "DELETE FROM clientes WHERE id_empresa = $id_empresa AND id = $rr->id ";
        $this->db->query($sql);
        $eliminados++;
      }
    }
    echo "TERMINO. Cantidad de eliminados: $eliminados ";
  }

  function upload_files($id_empresa = 0) {
    $id_empresa = (empty($id_empresa)) ? $this->get_empresa() : $id_empresa;
    return parent::upload_files(array(
      "id_empresa"=>$id_empresa,
      "upload_dir"=>"uploads/$id_empresa/",
    ));
  }

  function get_consultas() {
    $this->load->model("Consulta_Model");
    $id_contacto = $this->input->post("id_cliente");
    $res = $this->Consulta_Model->buscar_consultas(array(
      "id_contacto"=>$id_contacto,
      "offset"=>999999,
    ));
    echo json_encode($res["results"]);
  }

  function reset_password() {
    $this->load->helper("encode_helper");
    $id_empresa = $this->input->post("id_empresa");
    $email = $this->input->post("email");
    $cliente = $this->modelo->get_by_email($email,$id_empresa);
    if ($cliente != FALSE) {
      // Generamos un nuevo password aleatorio
      $nuevo = rand_string();
      // Codificamos el password en MD5
      $nuevo_md5 = md5($nuevo);
      // Guardamos el pass en la base de datos
      $sql = "UPDATE clientes SET password = '$nuevo_md5' WHERE id = $cliente->id AND id_empresa = $id_empresa ";
      $this->db->query($sql);
      // Enviamos un email al usuario
      $this->load->model("Email_Template_Model");
      $template = $this->Email_Template_Model->get_by_key("recuperar-clave",$id_empresa);
      if ($template === FALSE) {
        $body = "Hola {{cliente_nombre}}, tu nueva clave de acceso es: {{password}}.";
        $asunto = $template->nombre;
      } else {
        $body = $template->texto;
        $asunto = "Recuperar clave";
      }

      $this->load->model("Empresa_Model");
      $empresa = $this->Empresa_Model->get($id_empresa);

      $body = str_replace("{{cliente_id}}",$cliente->id,$body);
      $body = str_replace("{{cliente_nombre}}",$cliente->nombre,$body);
      $body = str_replace("{{password}}",$nuevo,$body);
      $body = str_replace("{{empresa}}",$empresa->nombre,$body);
      $body = str_replace("{{id_empresa}}",$empresa->id,$body);

      $headers = "From: no-reply@varcreative.com\r\n";
      $headers.= "MIME-Version: 1.0\r\n";
      $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      @mail($email,$asunto,$body,$headers);
      echo json_encode(array(
        "error"=>0,
        "mensaje"=>"Hemos enviado un email a su casilla de correo con una nueva clave de acceso. Por favor revise su bandeja de entrada y correo no deseado.",
      ));
    } else {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"No se encuentra registrado '$email' en el sistema.",
      ));
    }
  }

  function registrar() {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json; charset=UTF-8');

    file_put_contents("log_registro_clientes.txt", print_r($_POST,true)."\n\n", FILE_APPEND);

    $id_empresa = $this->input->post("id_empresa");
    $email = $this->input->post("email");
    if (empty($email)) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"El email es obligatorio",
      ));
      exit();
    }
    $nombre = parent::get_post("nombre","");
    $telefono = parent::get_post("telefono","");
    $fax = parent::get_post("fax","549");
    $celular = parent::get_post("celular","");
    $direccion = parent::get_post("direccion","");
    $codigo_postal = parent::get_post("codigo_postal","");
    $id_tipo_documento = parent::get_post("id_tipo_documento",96);
    $id_tipo_iva = parent::get_post("id_tipo_iva",4);
    $cuit = parent::get_post("cuit","");
    $path = parent::get_post("path","");
    $id_localidad = parent::get_post("id_localidad",0);
    $observaciones = parent::get_post("observaciones","");
    $localidad = parent::get_post("localidad","");
    $id_provincia = parent::get_post("id_provincia",0);
    $latitud = parent::get_post("latitud",0);
    $longitud = parent::get_post("longitud",0);
    $password = parent::get_post("password","");
    $custom_1 = parent::get_post("custom_1","");
    $custom_2 = parent::get_post("custom_2","");
    $custom_3 = parent::get_post("custom_3","");
    $custom_4 = parent::get_post("custom_4","");
    $contacto_telefono = parent::get_post("contacto_telefono","");
    $contacto_nombre = parent::get_post("contacto_nombre","");

    // Opciones: 
    // "" = Web con email
    // F = Facebook
    // G = Google
    $tipo_registro = parent::get_post("tipo_registro","");

    // Si el tipo de registro se hace con facebook o google


    $lang = parent::get_post("lang","es");
    
    if ($this->input->post("ps") !== FALSE) $password = $this->input->post("ps");
    $enviar_email = parent::get_post("enviar_email",1);
    $activo = parent::get_post("activo",1);
    $codigo_vendedor = parent::get_post("codigo_vendedor","");
    $tipo = ($this->input->post("tipo") !== FALSE) ? $this->input->post("tipo") : 2; // 2 = EN PROGRESO
    $id_vendedor = 0;
    $etiquetas = ($this->input->post("etiquetas") !== FALSE) ? json_decode($this->input->post("etiquetas")) : array();
    $salida = array();

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
          "mensaje"=>($lang == "en") ? "The validation code is incorrect." : "El codigo de validacion es incorrecto.",
          "error"=>1,
        );
        echo json_encode($salida);
        exit();
      }
    }

    // Controlamos si existe el codigo del vendedor
    if (!empty($codigo_vendedor)) {
      $this->load->model("Vendedor_Model");
      $vendedor = $this->Vendedor_Model->get(0,array(
        "id_empresa"=>$id_empresa,
        "codigo"=>$codigo_vendedor,
      ));
      if ($vendedor !== FALSE) $id_vendedor = $vendedor->id;
    }

    if ($id_empresa == 256 && !empty($tipo_registro)) {
      $this->modelo->enviar_constant_contact(array(
        "id_empresa"=>256,
        "nombre"=>$nombre,
        "email"=>$email,
        "listas"=>["a3bfd2a6-3183-11ea-8915-d4ae5275dbea"],
      ));
    }

    $this->load->model("Empresa_Model");
    $mensaje = "";

    $cliente = $this->modelo->get_by_email($email,$id_empresa);
    // SI NO ENCONTRO AL CLIENTE
    if ($cliente === FALSE) {
      $fecha = date("Y-m-d H:i:s");
      // Debemos guardar el cliente
      $cliente = new stdClass();
      $uploaded = 1;
      $forma_pago = (($id_empresa == 256) ? $tipo_registro : "E");
      $fecha_inicial = $fecha;
      $fecha_ult_operacion = $fecha;
      $sql = "INSERT INTO clientes (nombre,email,telefono,celular,fax,password,cuit,direccion,id_empresa,id_provincia,id_localidad,enviar_email,tipo,activo,uploaded,forma_pago,fecha_inicial,fecha_ult_operacion,id_vendedor,id_sucursal,id_tipo_documento,latitud,longitud,custom_3,custom_4,path,id_tipo_iva,codigo_postal,localidad,observaciones,custom_1,custom_2,contacto_telefono,contacto_nombre) VALUES(";
      $sql.= "'$nombre','$email','$telefono','$celular','$fax','$password','$cuit','$direccion','$id_empresa','$id_provincia','$id_localidad','$enviar_email','$tipo','$activo','$uploaded','$forma_pago','$fecha_inicial','$fecha_ult_operacion','$id_vendedor',0,'$id_tipo_documento','$latitud','$longitud','$custom_3','$custom_4','$path','$id_tipo_iva','$codigo_postal','$localidad','$observaciones','$custom_1','$custom_2','$contacto_telefono','$contacto_nombre')";
      $this->db->query($sql);
      $id_cliente = $this->db->insert_id();

      // Si es LaboralGym APP
      if ($id_empresa == 341) {
        // Guardamos los datos por defecto que tiene el cliente
        $this->db->query("UPDATE clientes SET custom_1 = '10', custom_2 = 'LMIJVSD' WHERE id = $id_cliente AND id_empresa = 341 ");
      }

      // REGISTRAMOS COMO UN EVENTO LA CREACION DEL NUEVO USUARIO
      $this->load->model("Consulta_Model");
      $this->Consulta_Model->registro_creacion_usuario(array(
        "id_contacto"=>$id_cliente,
        "id_empresa"=>$id_empresa,
        "fecha"=>$fecha,
      ));


      // Si tenemos etiquetas, convertimos
      if (sizeof($etiquetas)>0) {
        $this->load->helper("file_helper");
        $this->load->model("Cliente_Etiqueta_Model");
        foreach($etiquetas as $etiqueta) {
          $etiq = $this->Cliente_Etiqueta_Model->get_by_name($etiqueta,$id_empresa);
          if ($etiq === FALSE) {
            // Insertamos la etiqueta
            $etiq = new stdClass();
            $etiq->id_empresa = $id_empresa;
            $etiq->nombre = $etiqueta;
            $etiq->link = filename($etiqueta,"-",0);
            $this->db->insert("clientes_etiquetas",$etiq);
            $etiq->id = $this->db->insert_id();
          }
        }
        // Controlamos si ya existe la relacion
        $sql = "SELECT * FROM clientes_etiquetas_relacion ";
        $sql.= "WHERE id_etiqueta = $etiq->id ";
        $sql.= "AND id_empresa = $id_empresa ";
        $sql.= "AND id_cliente = $id_cliente ";
        $qq = $this->db->query($sql);
        if ($qq->num_rows() == 0) {
          // Insertamos la relacion
          $sql = "INSERT INTO clientes_etiquetas_relacion (id_cliente,id_etiqueta,id_empresa,orden) VALUES($id_cliente,$etiq->id,$id_empresa,1) ";
          $this->db->query($sql);
        }
      }

      $salida = array(
        "id"=>$id_cliente,
        "error"=>0,
        "mensaje"=>$mensaje,
      );      

    // El cliente existe, pero debemos actualizar sus datos
    // Ej: El cliente hizo una consulta, pero nunca una compra
    } else if (isset($cliente->tipo) && ($tipo == 0 || $tipo != $cliente->tipo)) {

      if ($id_empresa == 341) {
        // Si ya existe el cliente, decimos que se loguee
        echo json_encode(array(
          "error"=>1,
          "mensaje"=>"El cliente ya esta registrado en el sistema. Por favor inicie sesion para entrar.",
        ));
        exit();
      }

      // Actualizamos los datos
      $updates = array();
      if (!empty($nombre)) $updates[] = array("key"=>"nombre","value"=>$nombre);
      if (!empty($email)) $updates[] = array("key"=>"email","value"=>$email);
      if (!empty($telefono)) $updates[] = array("key"=>"telefono","value"=>$telefono);
      if (!empty($celular)) $updates[] = array("key"=>"celular","value"=>$celular);
      if (!empty($direccion)) $updates[] = array("key"=>"direccion","value"=>$direccion);
      if (!empty($id_localidad)) $updates[] = array("key"=>"id_localidad","value"=>$id_localidad);
      if (!empty($id_provincia)) $updates[] = array("key"=>"id_provincia","value"=>$id_provincia);
      if (!empty($password)) $updates[] = array("key"=>"password","value"=>$password);
      if (!empty($cuit)) $updates[] = array("key"=>"cuit","value"=>$cuit);
      if (!empty($latitud)) $updates[] = array("key"=>"latitud","value"=>$latitud);
      if (!empty($longitud)) $updates[] = array("key"=>"longitud","value"=>$longitud);
      if (!empty($contacto_nombre)) $updates[] = array("key"=>"contacto_nombre","value"=>$contacto_nombre);
      if (!empty($contacto_telefono)) $updates[] = array("key"=>"contacto_telefono","value"=>$contacto_telefono);
      if (!empty($custom_1)) $updates[] = array("key"=>"custom_1","value"=>$custom_1);
      if (!empty($custom_2)) $updates[] = array("key"=>"custom_2","value"=>$custom_2);
      if (!empty($custom_3)) $updates[] = array("key"=>"custom_3","value"=>$custom_3);
      if (!empty($custom_4)) $updates[] = array("key"=>"custom_4","value"=>$custom_4);
      if (!empty($path)) $updates[] = array("key"=>"path","value"=>$path);
      if (!empty($id_tipo_documento)) $updates[] = array("key"=>"id_tipo_documento","value"=>$id_tipo_documento);
      if (!empty($id_tipo_iva)) $updates[] = array("key"=>"id_tipo_iva","value"=>$id_tipo_iva);
      if (!empty($id_vendedor)) $updates[] = array("key"=>"id_vendedor","value"=>$id_vendedor);
      if (!empty($enviar_email)) $updates[] = array("key"=>"enviar_email","value"=>$enviar_email);
      $updates[] = array("key"=>"fecha_ult_operacion","value"=>date("Y-m-d H:i:s"));
      $updates[] = array("key"=>"tipo","value"=>$tipo);
      if (sizeof($updates)>0) {
        $sql = "UPDATE clientes SET ";
        for ($it=0; $it < sizeof($updates); $it++) { 
          $up = $updates[$it];
          $sql.= $up["key"]." = '".$up["value"]."' ".(($it<sizeof($updates)-1)?",":"");
        }
        $sql.= "WHERE id = $cliente->id AND id_empresa = $id_empresa ";
        $this->db->query($sql);
      }

      $mensaje = ($this->Empresa_Model->es_milling($id_empresa) ? $cliente->contacto_nombre : "");

      $salida = array(
        "id"=>$cliente->id,
        "error"=>0,
        "mensaje"=>$mensaje,
      );
      echo json_encode($salida);
      exit();

    } else {
      $mensaje = ($this->Empresa_Model->es_milling($id_empresa) ? $cliente->contacto_nombre : "");
      // El cliente ya existe
      $salida = array(
        "id"=>$cliente->id,
        "error"=>0,
        "mensaje"=>$mensaje,
      );
      echo json_encode($salida);
      exit();
    }

    // Enviamos un email de MUCHAS GRACIAS
    $empresa = $this->Empresa_Model->get($id_empresa);
    $this->load->model("Email_Template_Model");

    $template = FALSE;
    if (!empty($tipo_registro) && $id_empresa == 256) {
      // En Milling mandamos un template ya cargado
      $template = $this->Email_Template_Model->get_by_key("gracias-registro",$id_empresa);
    } else if (!empty($empresa->config["id_email_registro"])) {
      // Comprobamos que se haya configurado un template para mandar
      $template = $this->Email_Template_Model->get($empresa->config["id_email_registro"],$id_empresa);
    }
    if ($template !== FALSE) {
      $bcc_array = array("basile.matias99@gmail.com");
      require_once APPPATH.'libraries/Mandrill/Mandrill.php';
      $body = $template->texto;
      $body = str_replace("{{nombre}}", $nombre, $body);
      mandrill_send(array(
        "to"=>$email,
        "from"=>"no-reply@varcreative.com",
        "from_name"=>$empresa->nombre,
        "subject"=>$template->nombre,
        "body"=>$body,
        "reply_to"=>$empresa->email,
        "bcc"=>$bcc_array,
      ));
      //$mensaje = ($id_empresa == 256) ? "Thank you for your registration. We have sent an email to your mailbox to complete your profile." : "Muchas gracias por su registro. Se ha enviado un email a su casilla de correo.";
    }  
      
    echo json_encode($salida);
  }

  function recuperar_pass() {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json; charset=UTF-8');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $email = parent::get_post("email","");
    $id_empresa = parent::get_post("id_empresa",0);
    $lang = parent::get_post("lang","es");
    if (empty($email)) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"ERROR: no se envio un email.",
      ));
      exit();
    }
    $cliente = $this->modelo->get_by_email($email,$id_empresa);
    if ($cliente === FALSE) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"El cliente no esta registrado",
      ));
      exit();
    } else {

      $this->load->model("Empresa_Model");
      $empresa = $this->Empresa_Model->get($id_empresa);
      $this->load->model("Email_Template_Model");
      $template = $this->Email_Template_Model->get_by_key("recuperar-clave",$id_empresa);
      if ($template !== FALSE) {

        // Generamos un nuevo password aleatorio
        if ($id_empresa == 256) {
          $password = rand(100000,999999);  
        } else {
          $password = rand(0,10000);
        }
        $bcc_array = array("basile.matias99@gmail.com");
        require_once APPPATH.'libraries/Mandrill/Mandrill.php';
        $body = $template->texto;
        $body = str_replace("{{nombre}}", $cliente->nombre, $body);
        $body = str_replace("{{password}}", $password, $body);
        mandrill_send(array(
          "to"=>$email,
          "from"=>"no-reply@varcreative.com",
          "from_name"=>$empresa->nombre,
          "subject"=>$template->nombre,
          "body"=>$body,
          "reply_to"=>$empresa->email,
          //"bcc"=>$bcc_array,
        ));

        $password_md5 = md5($password);
        $sql = "UPDATE clientes SET password = '$password_md5' WHERE id_empresa = $id_empresa AND id = $cliente->id ";
        $this->db->query($sql);

        if ($lang == "en") {
          $men = "We have sent an email to restore your password.";
        } else {
          $men = "Hemos enviado un email para restaurar tu clave a tu correo electronico.";
        }
        echo json_encode(array(
          "error"=>0,
          "mensaje"=>$men,
        ));       
      } else {
        echo json_encode(array(
          "error"=>1,
          "mensaje"=>"Ocurrio un error al enviar la plantilla del email.",
        ));                 
      }
    }
  }  

  function editar() {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $id_empresa = $this->input->post("id_empresa");
    $email = $this->input->post("email");
    if (empty($email)) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"El email es obligatorio",
      ));
      exit();
    }
    $nombre = parent::get_post("nombre","");
    $telefono = parent::get_post("telefono",-1);
    $celular = parent::get_post("celular",-1);
    $direccion = parent::get_post("direccion",-1);
    $id_tipo_documento = parent::get_post("id_tipo_documento",96);
    $cuit = parent::get_post("cuit",-1);
    $id_localidad = parent::get_post("id_localidad",-1);
    $id_provincia = parent::get_post("id_provincia",-1);
    $latitud = parent::get_post("latitud",-1);
    $longitud = parent::get_post("longitud",-1);
    $password = parent::get_post("password","");
    $custom_3 = parent::get_post("custom_3",-1);
    $custom_4 = parent::get_post("custom_4",-1);

    $cliente = $this->modelo->get_by_email($email,$id_empresa);
    if ($cliente === FALSE) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"El cliente no esta registrado",
      ));
    } else {

      // Actualizamos los datos
      $updates = array();
      if (!empty($nombre)) $updates[] = array("key"=>"nombre","value"=>$nombre);
      if (!empty($email)) $updates[] = array("key"=>"email","value"=>$email);
      if ($telefono != -1) $updates[] = array("key"=>"telefono","value"=>$telefono);
      if ($celular != -1) $updates[] = array("key"=>"celular","value"=>$celular);
      if ($direccion != -1) $updates[] = array("key"=>"direccion","value"=>$direccion);
      if ($id_localidad != -1) $updates[] = array("key"=>"id_localidad","value"=>$id_localidad);
      if ($id_provincia != -1) $updates[] = array("key"=>"id_provincia","value"=>$id_provincia);
      if (!empty($password)) $updates[] = array("key"=>"password","value"=>$password);
      if ($cuit != -1) $updates[] = array("key"=>"cuit","value"=>$cuit);
      if ($latitud != -1) $updates[] = array("key"=>"latitud","value"=>$latitud);
      if ($longitud != -1) $updates[] = array("key"=>"longitud","value"=>$longitud);
      if ($custom_3 != -1) $updates[] = array("key"=>"custom_3","value"=>$custom_3);
      if ($custom_4 != -1) $updates[] = array("key"=>"custom_4","value"=>$custom_4);
      if (!empty($id_tipo_documento)) $updates[] = array("key"=>"id_tipo_documento","value"=>$id_tipo_documento);
      $updates[] = array("key"=>"fecha_ult_operacion","value"=>date("Y-m-d H:i:s"));
      if (sizeof($updates)>0) {
        $sql = "UPDATE clientes SET ";
        for ($it=0; $it < sizeof($updates); $it++) { 
          $up = $updates[$it];
          $sql.= $up["key"]." = '".$up["value"]."' ".(($it<sizeof($updates)-1)?",":"");
        }
        $sql.= "WHERE id = $cliente->id AND id_empresa = $id_empresa ";
        $this->db->query($sql);
      }

      // Actualizamos el objeto
      $cliente = $this->modelo->get_by_email($email,$id_empresa);

      $_SESSION["id_cliente"] = $cliente->id;
      $_SESSION["nombre"] = $cliente->nombre;
      $_SESSION["codigo_postal"] = $cliente->codigo_postal;
      $_SESSION["direccion"] = $cliente->direccion;
      $_SESSION["telefono"] = $cliente->telefono;
      $_SESSION["celular"] = $cliente->celular;
      $_SESSION["cliente_lista"] = $cliente->lista;
      $_SESSION["cliente_descuento"] = $cliente->descuento;
      $_SESSION["email"] = $email;

      $tiempo = time()+(60*60*24*90);
      setcookie("id_cliente_1",$cliente->id,$tiempo,"/");
      setcookie("nombre_1",$cliente->nombre,$tiempo,"/");
      setcookie("codigo_postal_1",$cliente->codigo_postal,$tiempo,"/");
      setcookie("direccion_1",$cliente->direccion,$tiempo,"/");
      setcookie("telefono_1",$cliente->telefono,$tiempo,"/");
      setcookie("celular_1",$cliente->celular,$tiempo,"/");
      setcookie("cliente_lista_1",$cliente->lista,$tiempo,"/");
      setcookie("cliente_descuento_1",$cliente->descuento,$tiempo,"/");
      setcookie("activo",$cliente->activo,$tiempo,"/");
      setcookie("email_1",$email,$tiempo,"/");

      $salida = array(
        "id"=>$cliente->id,
        "error"=>0,
      );
      echo json_encode($salida);
    }
  }

  function get($id) {
    
    $id_empresa = parent::get_empresa();
    // Obtenemos el listado
    if ($id == "index") {

      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);

      $order_by = ($this->input->get("order_by") !== FALSE) ? $this->input->get("order_by")." " : "";
      $order = ($this->input->get("order") !== FALSE) ? $this->input->get("order") : "";
      $filter = ($this->input->get("term") !== FALSE) ? urldecode($this->input->get("term")) : "";
      $codigo_propiedad = ($this->input->get("codigo_propiedad") !== FALSE) ? urldecode($this->input->get("codigo_propiedad")) : "";
      $id_usuario = ($this->input->get("id_usuario") !== FALSE) ? urldecode($this->input->get("id_usuario")) : 0;
      $custom_3 = parent::get_get("custom_3","");
      $custom_4 = parent::get_get("custom_4","");
      $custom_5 = parent::get_get("custom_5","");
      $desde = parent::get_get("desde","");
      $hasta = parent::get_get("hasta","");
      $tipo = ($this->input->get("tipo") !== FALSE) ? $this->input->get("tipo") : -1;
      $id_vendedor = parent::get_get("id_vendedor",0);
      $id_etiqueta = parent::get_get("id_etiqueta",0);
      $id_proyecto = parent::get_get("id_proyecto",0);
      $limit = $this->input->get("limit");
      $offset = $this->input->get("offset");
      $buscar_respuesta = ($this->input->get("buscar_respuesta") !== FALSE) ? $this->input->get("buscar_respuesta") : 0;

      $r = $this->modelo->buscar(array(
        "filter"=>$filter,
        "codigo_propiedad"=>$codigo_propiedad,
        "order"=>$order_by.$order,
        "limit"=>$limit,
        "tipo"=>$tipo,
        "id_vendedor"=>$id_vendedor,
        "id_etiqueta"=>$id_etiqueta,
        "id_proyecto"=>$id_proyecto,
        "activo"=>(($id_empresa == 70)?1:-1),
        "offset"=>$offset,
        "id_usuario"=>$id_usuario,
        "buscar_respuesta"=>$buscar_respuesta,
        "custom_3"=>$custom_3,
        "custom_4"=>$custom_4,
        "custom_5"=>$custom_5,
        "desde"=>$desde,
        "hasta"=>$hasta,
      ));
      echo json_encode($r);

    } else {

      $id_sucursal = parent::get_get("id_sucursal",0);
      $cliente = $this->modelo->get($id,$id_empresa,array(
        "id_sucursal"=>$id_sucursal
      ));
      echo json_encode($cliente);
    }
  }    

  function insert() {
    $array = $this->parse_put();
    $id_empresa = parent::get_empresa();
    $this->load->helper("fecha_helper");
    $this->load->helper("file_helper");
    if (isset($array->fecha_inicial)) $array->fecha_inicial = fecha_mysql($array->fecha_inicial);
    else $array->fecha_inicial = date("Y-m-d");
    if (isset($array->fecha_ult_operacion)) $array->fecha_ult_operacion = fecha_mysql($array->fecha_ult_operacion);
    if (empty($array->fecha_ult_operacion)) $array->fecha_ult_operacion = date("Y-m-d H:i:s");
    if (isset($array->fecha_vencimiento)) $array->fecha_vencimiento = fecha_mysql($array->fecha_vencimiento);
    $array->id_empresa = $id_empresa;
    $array->cuit = str_replace("-","",$array->cuit);
    $array->cuit = str_replace(" ","",$array->cuit);

    // Controlamos si el codigo ya existe
    $codigo = trim($array->codigo);
    if (!empty($codigo)) {
      $q = $this->db->query("SELECT * FROM clientes WHERE codigo = '$array->codigo' AND id_empresa = $id_empresa");
      if ($q->num_rows()>0) {
        echo json_encode(array(
          "error"=>1,
          "mensaje"=>"ERROR: Ya existe un cliente con el codigo $array->codigo."
          ));
        return;
      }
    }

    // Controlamos si el CUIT ya existe
    /*
    $cuit = trim($array->cuit);
    if (!empty($cuit)) {
        $q = $this->db->query("SELECT * FROM clientes WHERE cuit = '$array->cuit' AND id_empresa = $id_empresa");
        if ($q->num_rows()>0) {
            echo json_encode(array(
                "error"=>1,
                "mensaje"=>"ERROR: El cuit es repetido con otro cliente."
            ));
            return;
        }
    }
    */

    $etiquetas = $array->etiquetas;
    unset($array->etiquetas);

    // Dependiendo de la configuracion del sistema, si es LOCAL o NO
    $this->load->model("Configuracion_Model");
    $array->uploaded = ($this->Configuracion_Model->es_local()==1)?0:1;

    $id = $this->modelo->insert($array);

    // Guardamos las relaciones con las etiquetas (Y se crean en caso de que no exitan)
    $i=1;
    foreach($etiquetas as $e) {
      $tag = new stdClass();
      $tag->id_empresa = $array->id_empresa;
      $tag->id_cliente = $id;
      $tag->nombre = $e;
      $tag->orden = $i;
      $this->modelo->save_tag($tag);
      $i++;
    }

    echo json_encode(array(
      "id"=>$id,
      "error"=>0
    ));
  }

  function update($id) {

    if ($id == 0) { $this->insert($id); return; }
    $id_empresa = parent::get_empresa();
    $array = $this->parse_put();
    $etiquetas = $array->etiquetas;
    unset($array->etiquetas);
    $this->load->helper("fecha_helper");
    $this->load->helper("file_helper");
    $array->fecha_inicial = fecha_mysql($array->fecha_inicial);
    $array->fecha_ult_operacion = fecha_mysql($array->fecha_ult_operacion);
    $array->fecha_vencimiento = fecha_mysql($array->fecha_vencimiento);
    $array->id_empresa = $id_empresa;
    $array->cuit = str_replace("-","",$array->cuit);
    $array->cuit = str_replace(" ","",$array->cuit);        

    // Controlamos que el CUIT no exista
    /*
    $cuit = trim($array->cuit);
    if (!empty($cuit)) {
        $q = $this->db->query("SELECT * FROM clientes WHERE cuit = '$array->cuit' AND id != $id AND id_empresa = $id_empresa");
        if ($q->num_rows()>0) {
            echo json_encode(array(
                "error"=>1,
                "mensaje"=>"ERROR: El cuit es repetido con otro cliente."
            ));
            return;
        }
    }
    */
        
    // Controlamos si el codigo ya existe
    $codigo = trim($array->codigo);
    if (!empty($codigo)) {
      $q = $this->db->query("SELECT * FROM clientes WHERE codigo = '$array->codigo' AND id != $id AND id_empresa = $id_empresa");
      if ($q->num_rows()>0) {
        echo json_encode(array(
          "error"=>1,
          "mensaje"=>"ERROR: El codigo es repetido con otro cliente."
          ));
        return;
      }
    }

    $this->modelo->save($array);

    // Guardamos las relaciones con las etiquetas (Y se crean en caso de que no exitan)
    $i=1;
    $this->db->query("DELETE FROM clientes_etiquetas_relacion WHERE id_cliente = $id AND id_empresa = $array->id_empresa");
    foreach($etiquetas as $e) {
      $tag = new stdClass();
      $tag->id_empresa = $array->id_empresa;
      $tag->id_cliente = $id;
      $tag->nombre = $e;
      $tag->orden = $i;
      $this->modelo->save_tag($tag);
      $i++;
    }        

    echo json_encode(array(
      "id"=>$id,
      "error"=>0
    ));
  }

  function next() {
    $id_empresa = parent::get_empresa();
    $codigo = $this->modelo->next();
    echo json_encode(array(
      "codigo"=>$codigo,
    ));
  }

  function save_image($dir="",$filename="") {
    $id_empresa = $this->get_empresa();
    $dir = "uploads/$id_empresa/";
    $filename = $this->input->post("file");
    $res = parent::save_image($dir,$filename);

    $thumbnail_width = $this->input->post("thumbnail_width");
    if (!empty($thumbnail_width)) {
      $resp = json_decode($res);
      $filename = str_replace($dir, "", $resp->path);
      $thumbnail_width = $this->input->post("thumbnail_width");
      $thumbnail_height = $this->input->post("thumbnail_height");
      parent::thumbnails(array(
        "dir"=>$dir,
        "preffix"=>"thumb_",
        "filename"=>$filename,
        "thumbnail_width"=>$thumbnail_width,
        "thumbnail_height"=>$thumbnail_height,                
      ));
    }
    echo $res;
  }

  function get_by_nombre() {
    $id_empresa = parent::get_empresa();
    $nombre = $this->input->get("term");
    $s = $this->modelo->buscar(array(
      "filter"=>$nombre,
    ));
    $resultado = array();
    foreach($s["results"] as $r) {
      $rr = new stdClass();
      $rr->id = $r->id;
      $rr->value = $r->codigo;
      $rr->label = $r->nombre;
      $rr->info = (!empty($r->direccion)) ? $r->direccion.((!empty($r->localidad))?" - ".$r->localidad : "") : "";
      $rr->nombre = $r->nombre;
      $rr->email = $r->email;
      $rr->telefono = $r->telefono;
      $rr->id_sucursal = $r->id_sucursal;
      $rr->latitud = $r->latitud;
      $rr->longitud = $r->longitud;
      $resultado[] = $rr;
    }            
    echo json_encode($resultado);
  }

  function get_by_cuit() {
    $id_empresa = parent::get_empresa();
    $nombre = $this->input->get("term");
    $s = $this->modelo->buscar(array(
      "cuit"=>$nombre,
    ));
    $resultado = array();
    foreach($s["results"] as $r) {
      $rr = new stdClass();
      $rr->id = $r->id;
      $rr->value = $r->codigo;
      $rr->label = $r->nombre;
      $rr->info = (!empty($r->direccion)) ? $r->direccion.((!empty($r->localidad))?" - ".$r->localidad : "") : "";
      $rr->nombre = $r->nombre;
      $rr->email = $r->email;
      $rr->telefono = $r->telefono;
      $rr->id_sucursal = $r->id_sucursal;
      $rr->latitud = $r->latitud;
      $rr->longitud = $r->longitud;
      $resultado[] = $rr;
    }            
    echo json_encode($resultado);
  }  

  function get_by_telefono() {
    $id_empresa = parent::get_empresa();
    $nombre = $this->input->get("term");
    $s = $this->modelo->buscar(array(
      "telefono"=>$nombre,
    ));
    $resultado = array();
    foreach($s["results"] as $r) {
      $rr = new stdClass();
      $rr->id = $r->id;
      $rr->value = $r->codigo;
      $rr->label = $r->nombre;
      $rr->info = (!empty($r->direccion)) ? $r->direccion.((!empty($r->localidad))?" - ".$r->localidad : "") : "";
      $rr->nombre = $r->nombre;
      $rr->email = $r->email;
      $rr->telefono = $r->telefono;
      $rr->id_sucursal = $r->id_sucursal;
      $rr->latitud = $r->latitud;
      $rr->longitud = $r->longitud;
      $resultado[] = $rr;
    }            
    echo json_encode($resultado);
  }  

  function get_by_codigo() {
    $id_empresa = parent::get_empresa();
    $codigo = $this->input->get("codigo");
    $s = $this->modelo->get_by_codigo($codigo);
    echo json_encode($s);
  }    

  function get_by_descripcion() {
    $id_empresa = parent::get_empresa();
    $descripcion = $this->input->get("term");
    $sql = "SELECT A.* ";
    $sql.= "FROM clientes A ";
    $sql.= "WHERE A.nombre LIKE '%$descripcion%' ";
    $sql.= "AND A.id_empresa = $id_empresa ";
    $q = $this->db->query($sql);
    $resultado = array();
    foreach($q->result() as $r) {
      $rr = new stdClass();
      $rr->id = $r->id;
      $rr->id_real = $r->id;
      $rr->value = $r->id;
      $rr->label = $r->nombre;
      $rr->path = $r->path;
      $resultado[] = $rr;
    }
    echo json_encode($resultado);
  }    



  function get_info($codigo) {

    $id_empresa = parent::get_empresa();
    
    // Consumidor final
    if ($codigo == 0) {
      $row = new stdClass();
      $row->id_tipo_iva = 4;
      $row->nombre = "Consumidor Final";
      $row->cuit = "";
      $row->saldo = 0;
      $row->email = "";
      $row->direccion = "";
      $row->percibe_ib = 0;
      $row->descuento = 0;
      $row->error = 0;
      $row->id_vendedor = 0;
      $row->lista = 0;
      $row->forma_pago = "E";
      echo json_encode($row);
      return;
    }
    
    // Obtenemos el cliente
    $row = $this->modelo->get_by_codigo($codigo);
    if ($row == FALSE) { echo json_encode(array("error"=>1,"mensaje"=>"No existe un cliente con el codigo '$codigo'")); return; }
    if ($row->activo == 0) { echo json_encode(array("error"=>1,"mensaje"=>"El cliente $row->nombre esta desactivado.")); return; }
    $row->error = 0;
    $row->mensaje = "";
    $row->saldo = $this->modelo->saldo($row->id);
    echo json_encode($row);
  }


    /*
    // Tipo = P -> Pagado
    // Tipo = D -> Todavia debe
    function consulta() {
        
        $this->load->helper("fecha_helper");
        $fecha_desde = $this->input->post("fecha_desde");
        if (!empty($fecha_desde)) $fecha_desde = fecha_mysql($fecha_desde);
        $fecha_hasta = $this->input->post("fecha_hasta");
        if (!empty($fecha_hasta)) $fecha_hasta = fecha_mysql($fecha_hasta);
        
        // Obtenemos los registros que estan dentro del intervalo de fechas
        $sql = "SELECT CL.nombre, C.tipo, C.numero, C.id, ";
        $sql.= "DATE_FORMAT(C.fecha,'%d/%m/%Y') AS fecha, ";
        $sql.= "C.total AS total, ";
        $sql.= "CL.nombre, CL.cuit AS cuit ";
        $sql.= "FROM facturas C ";
        $sql.= "LEFT JOIN clientes CL ON (C.id_cliente = CL.id) ";
        $sql.= "WHERE C.cta_cte != 0 ";
        $sql.= "AND '$fecha_desde' <= DATE_FORMAT(C.fecha,'%Y-%m-%d') ";
        $sql.= "AND DATE_FORMAT(C.fecha,'%Y-%m-%d') <= '$fecha_hasta' ";
        $sql.= "ORDER BY C.fecha ASC ";
        $q = $this->db->query($sql);
        echo json_encode($q->result());
    }
    */

  function save_file() {
    $this->load->helper("file_helper");
    $id_empresa = $this->get_empresa();
    if (!isset($_FILES['path']) || empty($_FILES['path'])) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"No se ha enviado ningun archivo."
      ));
      return;
    }
    $filename = filename($_FILES["path"]["name"],"-");
    $path = "uploads/$id_empresa/$filename";
    @move_uploaded_file($_FILES["path"]["tmp_name"],$path);
    echo json_encode(array(
      "path"=>$path,
      "error"=>0,
    ));
  } 
    
  function cuentas_corrientes($fecha_desde = "", $fecha_hasta = "", $codigo = 0, $id_empresa = 0, $id_cliente = 0, $id_sucursal = 0, $moneda = "ARS") {

    $this->load->helper("fecha_helper");

    $id_empresa = parent::get_empresa();
    $estado = (!isset($_SESSION["estado"])) ? 0 : (($_SESSION["estado"]==1)?1:0);

    if (!empty($codigo)) {
      $cliente = $this->modelo->get_by_codigo($codigo,array(
        "id_sucursal"=>$id_sucursal,
      ));
    } else {
      $cliente = $this->modelo->get($id_cliente,$id_empresa,array(
        "id_sucursal"=>$id_sucursal,
      ));
    }

    // Acomodamos los datos de entrada
    $fecha_desde = fecha_mysql(str_replace("-","/",$fecha_desde));
    $fecha_hasta = fecha_mysql(str_replace("-","/",$fecha_hasta));

    $data = array();
    $data["saldo_inicial"] = $this->modelo->saldo($cliente->id,$id_empresa,$fecha_desde,array(
      "moneda"=>$moneda,
    ));
    $data["datos"] = $this->modelo->get_cuenta_corriente(array(
      "id_cliente"=>$cliente->id,
      "id_empresa"=>$id_empresa,
      "estado"=>$estado,
      "id_sucursal"=>$id_sucursal,
      "fecha_desde"=>$fecha_desde,
      "fecha_hasta"=>$fecha_hasta,
      "moneda"=>$moneda,
    ));
    
    // Imprimimos la salida
    echo json_encode($data);
  }

  function asignar_pagos() {
    $pagos = parent::get_get("pagos",array());
    $id_empresa = parent::get_get("id_empresa",parent::get_empresa());
    $id_factura = parent::get_get("id_factura",0);
    $id_punto_venta = parent::get_get("id_punto_venta",0);
    foreach($pagos as $p) {
      $sql = "INSERT INTO facturas_pagos (id_empresa,id_pago,id_factura,monto,id_punto_venta) VALUES (";
      $sql.= "$id_empresa,$p->id,$id_factura,$p->monto,$id_punto_venta)";
      $this->db->query($sql);
    }
    echo json_encode(array("error"=>0));
  }


  function imprimir_detalle_cuentas_corrientes() {

    $this->load->helper("fecha_helper");
    $moneda = parent::get_get("moneda","ARS");
    $detalle_items = parent::get_get("detalle_items",0);
    $id_cliente = parent::get_get("id_cliente",0);
    $id_sucursal = parent::get_get("id_sucursal",0);
    $fecha_desde = parent::get_get("fecha_desde",date("d-m-Y"));
    $fecha_hasta = parent::get_get("fecha_hasta",date("d-m-Y"));
    $fecha_desde = fecha_mysql(str_replace("-","/",$fecha_desde));
    $fecha_hasta = fecha_mysql(str_replace("-","/",$fecha_hasta));
    $estado = (!isset($_SESSION["estado"])) ? 0 : (($_SESSION["estado"]==1)?1:0);
    $id_empresa = parent::get_empresa();
    
    $cliente = $this->modelo->get($id_cliente,$id_empresa,array(
      "id_sucursal"=>$id_sucursal,
    ));

    $data = array();
    $data["cliente"] = $cliente;
    $data["saldo_inicial"] = $this->modelo->saldo($id_cliente,$id_empresa,$fecha_desde,array(
      "moneda"=>$moneda,
    ));
    $data["detalle_items"] = $detalle_items;
    $data["datos"] = array();
    $data["fecha_desde"] = fecha_es($fecha_desde);
    $data["fecha_hasta"] = fecha_es($fecha_hasta);

    $pars = array(
      "id_cliente"=>$cliente->id,
      "id_empresa"=>$id_empresa,
      "estado"=>$estado,
      "id_sucursal"=>$id_sucursal,
      "fecha_desde"=>$fecha_desde,
      "fecha_hasta"=>$fecha_hasta,
      "moneda"=>$moneda,
      "id_empresa"=>$id_empresa,
    );
    $cuenta = $this->modelo->get_cuenta_corriente($pars);
    foreach($cuenta as $row) {
      $row->items = array();
      if ($detalle_items == 1) {
        // Obtenemos los items
        $sql = "SELECT * FROM facturas_items WHERE id_factura = $row->id AND id_punto_venta = $row->id_punto_venta AND id_empresa = $id_empresa ORDER BY id ASC ";
        $q_items = $this->db->query($sql);
        $row->items = $q_items->result();
      }
      $data["datos"][] = $row;
    }

    // Obtenemos la empresa
    $this->load->model("Empresa_Model");
    $data["empresa"] = $this->Empresa_Model->get($id_empresa);

    $header = $this->load->view("reports/factura/header",null,true);
    $data["header"] = $header;

    $this->load->view("reports/cuenta_corriente_cliente.php",$data);
  }


  function exportar() {

    set_time_limit(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $this->load->model("Empresa_Model");
    $this->load->helper("excel_helper.php");
    $order = urldecode(parent::get_get("order",""));
    $tipo = urldecode(parent::get_get("tipo",-1));
    $filter = urldecode(parent::get_get("filter",""));
    $id_proyecto = urldecode(parent::get_get("id_proyecto",0));
    $custom_3 = parent::get_get("custom_3","");
    $custom_4 = parent::get_get("custom_4","");
    $custom_5 = parent::get_get("custom_5","");
    if ($id_proyecto == 3) {
      $this->load->model("Consulta_Model");
      $this->load->model("Propiedad_Model");
    }
    $codigo_propiedad = urldecode(parent::get_get("codigo_propiedad",""));
    $id_empresa = parent::get_empresa();
    $r = $this->modelo->buscar(array(
      "tipo"=>$tipo,
      "order"=>$order,
      "id_empresa"=>$id_empresa,
      "filter"=>$filter,
      "offset"=>9999999,
      "codigo_propiedad"=>$codigo_propiedad,
      "custom_3"=>$custom_3,
      "custom_4"=>$custom_4,
      "custom_5"=>$custom_5,
    ));

    if ($this->Empresa_Model->es_milling($id_empresa)) {
      $header = array("Name","Email","Telephone","Address","Country","Company","Position","Category","Registration Date");
      $datos = array();
      foreach($r["results"] as $ar) {
        $rr = new stdClass();
        $rr->nombre = $ar->nombre;
        $rr->email = $ar->email;
        $rr->telefono = $ar->telefono;
        $rr->direccion = $ar->direccion;
        $rr->contacto_telefono = $ar->contacto_telefono;
        $rr->contacto_nombre = $ar->contacto_nombre;
        $rr->custom_1 = $ar->custom_1;
        $rr->custom_3 = $ar->custom_3;
        $rr->fecha_ult_operacion = $ar->fecha_ult_operacion;
        $datos[] = $rr;
      }

    } else {
      $header = array("Codigo","Nombre","Email","Telefono","Direccion","Localidad");
      if ($id_empresa == 571) {
        $header[] = "Fecha Registro";
      } else if ($id_proyecto == 3) {
        $header[] = "Codigo Prop.";
        $header[] = "Titulo";
      }
      $datos = array();
      foreach($r["results"] as $ar) {
        $rr = new stdClass();
        $rr->codigo = $ar->codigo;
        $rr->nombre = $ar->nombre;
        $rr->email = $ar->email;
        $rr->telefono = $ar->telefono;
        $rr->direccion = $ar->direccion;
        $rr->localidad = $ar->localidad;

        // Si es INMOVAR
        if ($id_empresa == 571) {
          $rr->fecha_registro = $ar->fecha_inicial;
        } else if ($id_proyecto == 3) {
          $sql = "SELECT P.codigo, P.nombre ";
          $sql.= "FROM crm_consultas C ";
          $sql.= "INNER JOIN inm_propiedades P ON (P.id_empresa = C.id_empresa AND P.id = C.id_referencia) ";
          $sql.= "WHERE C.id_empresa = $id_empresa ";
          $sql.= "AND C.id_contacto = $ar->id ";
          $sql.= "AND C.tipo = 0 ";
          $sql.= "ORDER BY C.fecha DESC ";
          $sql.= "LIMIT 0,1 ";
          $qq = $this->db->query($sql);
          foreach($qq->result() as $propiedad) {
            $rr->propiedad_codigo = $propiedad->codigo;
            $rr->propiedad_nombre = $propiedad->nombre;
          }
        }
        $datos[] = $rr;
      }    
    }
    $this->load->library("Excel");
    $this->excel->create(array(
      "date"=>"",
      "filename"=>"clientes",
      "footer"=>array(),
      "header"=>$header,
      "data"=>$datos,
      "title"=>($this->Empresa_Model->es_milling($id_empresa) ? "Contacts" : "Clientes"),
    ));
  }


  function export($id_empresa = 0, $id_sucursal = 0, $last_update = 0) {
    if ($id_empresa == 0) { echo gzdeflate("0"); exit(); }
    $sql = "SELECT A.* ";
    $sql.= "FROM clientes A ";
    $sql.= "WHERE A.id_empresa = $id_empresa ";
    if ($last_update > 0) $sql.= "AND UNIX_TIMESTAMP(A.fecha_ult_operacion) >= $last_update ";

    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) { echo gzdeflate("0"); exit(); }

    $this->load->helper("import_helper");
    $salida = create_string_to_export($q);
    
    // Enviamos la cadena comprimida para ahorrar ancho de banda
    echo gzdeflate($salida);
  }

  function exportar_csv() {
    $id_empresa = parent::get_empresa();
    $this->load->dbutil();
    $this->load->helper('download');
    $query = $this->db->query("SELECT * FROM clientes WHERE id_empresa = $id_empresa");
    $salida = $this->dbutil->csv_from_result($query, ";", "\r\n");
    force_download('clientes.csv', $salida);
  }

  function importar() {
    $tabla = "clientes";
    parent::import($tabla,1);
    header("Location: app/#$tabla");
  }


    // Funciones utilizadas para ordenar por saldos
      static function ordenar_saldos($a,$b) {
        return ($a->saldo > $b->saldo) ? 1 : -1;
      }
      static function ordenar_saldos_desc($a,$b) {
        return ($a->saldo > $b->saldo) ? -1 : 1;
      }


      function listado_saldos() {

        $id_empresa = parent::get_empresa();
        $fecha = $this->input->get("fecha");
        $filtrar_en_cero = $this->input->get("filtrar_en_cero");
        $agrupado_por = $this->input->get("agrupado_por");
        $id_etiqueta = parent::get_get("id_etiqueta",0);
        $this->load->helper("fecha_helper");
        if ($fecha !== FALSE) $fecha = fecha_mysql(str_replace("-","/",$fecha));
        $fecha_desde = ($this->input->get("fecha_desde") !== FALSE) ? fecha_mysql(str_replace("-","/",$this->input->get("fecha_desde"))) : "";
        
        $order_by = $this->input->get("order_by");
        $order_direction = $this->input->get("order");
        if ($order_by != "saldo") {
          if (!empty($order_by)) $order = $order_by." ".$order_direction;
          else $order = "";            
        } else $order = "";
        
        $result = $this->modelo->listado_saldos($id_empresa,$fecha,$order,$filtrar_en_cero,array(
          "id_etiqueta"=>$id_etiqueta,
          "fecha_desde"=>$fecha_desde,
        ));
        
        if ($order_by == "saldo") {
          if ($order_direction == "asc") usort($result,array("Clientes", "ordenar_saldos"));
          else usort($result,array("Clientes", "ordenar_saldos_desc"));
        }
        
        // Si debemos agrupar los resultados
        if (!empty($agrupado_por)) {

          $salida = array();
          if ($agrupado_por == "vendedor") {

            $this->load->model("Vendedor_Model");
            foreach($result as $r) {
              if (!isset($salida[$r->id_vendedor])) {
                        // Obtenemos la informacion del vendedor y la ponemos como encabezado
                $vendedor = $this->Vendedor_Model->get($r->id_vendedor);
                if (empty($vendedor)) {
                  $info = array(
                    "id"=>0,
                    "nombre"=>"Vendedor no definido",
                    "codigo"=>"-1",
                    "saldo"=>0,
                    "fecha_ultimo_pago"=>"",
                    );
                } else {
                  $info = array(
                    "id"=>$vendedor->id,
                    "nombre"=>$vendedor->nombre,
                    "codigo"=>"-1",
                    "saldo"=>0,
                    "fecha_ultimo_pago"=>"",
                    );
                }
                $salida[$r->id_vendedor] = array(
                  "header"=>$info,
                  "rows"=>array(),
                  );
              }
              $id_vendedor = $r->id_vendedor;
              unset($r->id_vendedor);
              $salida[$id_vendedor]["rows"][] = $r;
              $salida[$id_vendedor]["header"]["saldo"] += $r->saldo;
            }

                // Ahora ajustamos el formato
            $salida2 = array();
            foreach($salida as $key => $value) {
                    // Encabezado que corresponde al nombre del vendedor
              $header = $value["header"];
              $salida2[] = $header;
                    // Resultado
              foreach($value["rows"] as $row) {
                $salida2[] = $row;    
              }
                    // Footer que corresponde al nombre del vendedor
              $header["codigo"] = "-2";
              $salida2[] = $header;
            }
            $salida = $salida2;
          }

          echo json_encode(array(
            "results"=>$salida,
            "total"=>sizeof($salida)
            ));

        } else {
          echo json_encode(array(
            "results"=>$result,
            "total"=>sizeof($result)
            ));            
        }
        
      }


  function actualizar_padron() {

    $id_empresa = parent::get_empresa();
    set_time_limit(0);
    // Tomamos los cuits de los clientes
    $query = $this->db->query("SELECT cuit FROM clientes WHERE id_empresa = $id_empresa ");
    // Lo pasamos a un array;
    $clientes = array();
    foreach($query->result() as $proveedor) {
      $cuit = trim($proveedor->cuit);
      if (!empty($cuit)) {
        $clientes[] = trim(str_replace("-","",$cuit));  
      }
    }
    foreach (glob("uploads/padrones/PadronRGSPer*.txt") as $filename) {
      $handle = @fopen($filename, "r");
      if ($handle) {
        // Vamos tomando la linea del archivo
        while (($linea = fgets($handle)) !== FALSE) {
          $cuit = substr($linea,29,11);
          // Si el CUIT es de algun proveedor
          if (in_array($cuit,$clientes)) {

            // Tomamos el porcentaje de retencion
            $porc = substr($linea,47,4);
            $porc = (float)(str_replace(",",".",$porc));
            $percibe_ib = ($porc > 0) ? 1 : 0;

            // Tenemos que actualizar el porcentaje
            $sql = "UPDATE clientes SET ";
            $sql.= "percepcion_ib = $porc, percibe_ib = $percibe_ib ";
            $sql.= "WHERE cuit = '$cuit' AND id_empresa = $id_empresa ";
            $this->db->query($sql);
          }
        }
        if (!feof($handle)) {
          echo "ERROR: No se puede abrir el archivo.";
          return;
        }
        fclose($handle);
      } else {
        echo "ERROR: No se puede abrir el archivo $filename.";
        return;
      }

      // Termino todo bien
      echo "OK: El padron se ha actualizado correctamente.";
      return;
    }
    echo "ERROR: No existe el archivo de padron en la carpeta.";
    return;
  }


  function get_clientes() {
    $id_empresa = parent::get_get("id_empresa");

    $r = $this->modelo->buscar(array(
      "id_empresa"=>$id_empresa,
      "get_telefonos"=>1,
    ));

    echo json_encode($r);
  }   

}