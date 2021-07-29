<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Consulta_Model extends Abstract_Model {

  public $sql = "";

  /*
  ID_ORIGEN:
    1 = CONSULTA DE PROPIEDADES
    2 = REGISTRO DE NEWSLETTER
    3 = CONSULTA PERSONAL
    4 = CONSULTA TELEFONICA
    5 = EMAIL
    6 = WEB
    7 = TASACIONES WEB
    8 = SOLICITUD DE VISITAS WEB
    9 = WEB
    10 = FORMULARIO DE INTERESES
    11 = ARTICULOS WEB
    12 = COMENTARIOS
    13 = RESERVA DE VIAJE
    14 = NOTA
    15 = SMS
    16 = TURNO MEDICO
    17 = TAREA
    18 = COMPRA WEB
    19 = COMPRA DESDE MERCADOLIBRE
    20 = CREACION DE USUARIO
    21 = ENVIO DE EMAIL AUTOMATICO
    22 = APERTURA DE LINK DE EMAIL AUTOMATICO
    23 = TURNO EN GENERAL
    24 = INSTAGRAM
    25 = CONSULTA DESDE MERCADOLIBRE
    26 = FACEBOOK
    27 = WHATSAPP
    28 = EMAIL INTERESADO EN PROPIEDAD
    30 = CLIENAPP WHATSAPP
    31 = CLIENAPP CONSULTA FUERA DE LINEA
    32 = NOTIFICACION DEL SISTEMA: CAMBIO DE ESTADO O DE USUARIO
    40 = DIARIO EL DIA
    50 = BUSCADOR FLOTANTE
  */

  // =====================================
  // Estas funciones sirven para filtrar por grupos de origenes

  // Origenes que no tienen que aparecer en el listado de contactos
  function get_not_origenes_listado() {
    return "32,20,21,22";
  }

  // Incluye clienapp y los registros manuales de whatsapp
  function get_origenes_consultas_whatsapp() {
    return "30,31,27";
  }

  // Incluye cualquier formulario web
  function get_origenes_consultas_web() {
    return "1,2,6,7,8,9,10,11,12";
  }

  // Incluye todo lo que se registra manualmente
  function get_origenes_consultas_manuales() {
    return "3,4,5,14,15,26,24";
  }

  // =====================================

  
  function __construct() {
    parent::__construct("crm_consultas","id","fecha DESC");
  }

  // Esta funcion 
  function mover_estado($conf = array()) {
    $id_empresa = isset($conf["id_empresa"]) ? $conf["id_empresa"] : parent::get_empresa();
    $id = isset($conf["id"]) ? $conf["id"] : 0;
    $proximo_estado = isset($conf["proximo_estado"]) ? $conf["proximo_estado"] : 0;
  }

  function total_consultas($conf = array()) {
    $id_empresa = isset($conf["id_empresa"]) ? $conf["id_empresa"] : parent::get_empresa();
    $sql = "SELECT COUNT(*) AS total ";
    $sql.= "FROM crm_consultas WHERE id_empresa = $id_empresa ";
    $sql.= "AND id_origen NOT IN (20,21,22,28) ";
    $sql.= "AND tipo = 0 ";
    $q = $this->db->query($sql);
    $r = $q->row();
    return (is_null($r->total) ? 0 : $r->total);
  }

  function registro_creacion_usuario($conf = array()) {
    $id_empresa = isset($conf["id_empresa"]) ? $conf["id_empresa"] : parent::get_empresa();
    $id_contacto = isset($conf["id_contacto"]) ? $conf["id_contacto"] : 0;
    $fecha = isset($conf["fecha"]) ? $conf["fecha"] : date("Y-m-d H:i:s");
    $id_origen = 20; // CREACION DE USUARIO
    $sql = "INSERT INTO crm_consultas (id_empresa,fecha,asunto,id_origen,id_referencia,id_contacto,id_empresa_relacion) VALUES(";
    $sql.= "'$id_empresa','$fecha','Nuevo usuario','$id_origen','0','$id_contacto','$id_empresa')";
    $this->db->query($sql);
  }

  function registro_email_interesado_propiedad($conf = array()) {
    $id_empresa = isset($conf["id_empresa"]) ? $conf["id_empresa"] : parent::get_empresa();
    $id_contacto = isset($conf["id_contacto"]) ? $conf["id_contacto"] : 0;
    $id_propiedad = isset($conf["id_propiedad"]) ? $conf["id_propiedad"] : 0;
    $propiedad = isset($conf["propiedad"]) ? $conf["propiedad"] : "";
    $fecha = isset($conf["fecha"]) ? $conf["fecha"] : date("Y-m-d H:i:s");
    $id_origen = 28; // EMAIL INTERESADO EN PROPIEDAD
    $sql = "INSERT INTO crm_consultas (id_empresa,fecha,asunto,id_origen,id_referencia,id_contacto,id_empresa_relacion,tipo) VALUES(";
    $sql.= "'$id_empresa','$fecha','Interesado en propiedad $propiedad','$id_origen','$id_propiedad','$id_contacto','$id_empresa',1)";
    $this->db->query($sql);
    $id = $this->db->insert_id();
    return $id;
  }
    
  function find($filter) {
    $id_empresa = parent::get_empresa();
    $this->db->where("id_empresa",$id_empresa);
    $this->db->like("texto",$filter);
    $query = $this->db->get($this->tabla);
    $result = $query->result();
    $this->db->close();
    return $result;
  }

  function insert($data) {
    $id_empresa = (isset($data->id_empresa) ? $data->id_empresa : parent::get_empresa());
    $this->load->model("Cliente_Model");
    $this->load->helper("fecha_helper");

    // Si existe el message_id y no es vacio
    if (isset($data->message_id) && !empty($data->message_id)) {
      // Controlamos que no este guardada la misma consulta
      $sql = "SELECT * FROM crm_consultas WHERE id_empresa = $id_empresa AND message_id = '$data->message_id' ";
      $q = $this->db->query($sql);
      if ($q->num_rows() > 0) return;
    }


    if (isset($data->fecha)) {
      if (!isset($data->hora) || empty($data->hora) || strlen($data->fecha)>10) {
        $data->hora = substr($data->fecha, strpos($data->fecha, " ")+1);
      }
      $data->fecha = fecha_mysql($data->fecha);
      $data->fecha = substr($data->fecha, 0, 10)." ".$data->hora;      
    }
    // Links adjuntos son por ejemplo facturas
    $links_adjuntos = isset($data->links_adjuntos) ? $data->links_adjuntos : array();
    // Adjuntos son archivos realmente subidos al servidor
    $adjuntos = isset($data->adjuntos) ? $data->adjuntos : array();

    $data->nombre = isset($data->nombre) ? $data->nombre : "";
    $data->email = isset($data->email) ? $data->email : "";

    // Primero tenemos que crear el contacto
    if (isset($data->id_contacto) && $data->id_contacto == 0 && (!empty($data->nombre) || !empty($data->email)) ) {

      // Si se paso un email, buscamos el contacto para saber si existe
      $this->load->model("Cliente_Model");
      $contacto = (!empty($data->email)) ? $this->Cliente_Model->get_by_email($data->email,$id_empresa) : FALSE;
      
      if ($contacto === FALSE) {
        // Debemos crearlo
        $contacto = new stdClass();
        $contacto->id_empresa = $id_empresa;
        $contacto->email = $data->email;
        $contacto->nombre = $data->nombre;
        $contacto->telefono = (isset($data->telefono) ? $data->telefono: "");
        $contacto->fecha_inicial = date("Y-m-d");
        $contacto->fecha_ult_operacion = date("Y-m-d H:i:s");
        $contacto->tipo = 1; // 1 = Contacto
        $contacto->activo = 1; // El cliente esta activo por defecto
        $id = $this->Cliente_Model->insert($contacto);
        $contacto->id = $id;

        // REGISTRAMOS COMO UN EVENTO LA CREACION DEL NUEVO USUARIO
        $this->load->model("Consulta_Model");
        $this->Consulta_Model->registro_creacion_usuario(array(
          "id_contacto"=>$id,
          "id_empresa"=>$id_empresa,
        ));
      }

      $data->id_contacto = $contacto->id;
    }

    //$id = parent::insert($data);
    $sql = "INSERT INTO crm_consultas (";
    $sql.= "id_contacto,id_empresa_relacion,id_empresa,id_entrada,id_paciente,fecha,asunto,";
    $sql.= "texto,id_email_respuesta,id_origen,id_usuario,subtitulo,tipo,id_referencia,id_relacion,id_asunto,estado,message_id";
    $sql.= ") VALUES (";
    $sql.= (isset($data->id_contacto)) ? "'$data->id_contacto'," : "0,";
    $sql.= (isset($data->id_empresa_relacion)) ? "'$data->id_empresa_relacion'," : ((isset($data->id_empresa)) ? "'$data->id_empresa'," : "0,");
    $sql.= (isset($data->id_empresa)) ? "'$data->id_empresa'," : "0,";
    $sql.= (isset($data->id_entrada)) ? "'$data->id_entrada'," : "0,";
    $sql.= (isset($data->id_paciente)) ? "'$data->id_paciente'," : "0,";
    $sql.= (isset($data->fecha)) ? "'$data->fecha'," : "NOW(),";
    $sql.= (isset($data->asunto)) ? "'$data->asunto'," : "'',";
    $sql.= (isset($data->texto)) ? "'$data->texto'," : "'',";
    $sql.= (isset($data->id_email_respuesta)) ? "'$data->id_email_respuesta'," : "0,";
    $sql.= (isset($data->id_origen)) ? "'$data->id_origen'," : "0,";
    $sql.= (isset($data->id_usuario)) ? "'$data->id_usuario'," : "0,";
    $sql.= (isset($data->subtitulo)) ? "'$data->subtitulo'," : "'',";
    $sql.= (isset($data->tipo)) ? "'$data->tipo'," : "0,";
    $sql.= (isset($data->id_referencia)) ? "'$data->id_referencia'," : "0,";
    $sql.= (isset($data->id_relacion)) ? "'$data->id_relacion'," : "0,";
    $sql.= (isset($data->id_asunto)) ? "'$data->id_asunto'," : "0,";
    $sql.= (isset($data->estado)) ? "'$data->estado'," : "0,";
    $sql.= (isset($data->message_id)) ? "'$data->message_id'" : "''";
    $sql.= ")";
    @file_put_contents("consulta_insertar.txt", date("Y-m-d H:i:s")." - ".$sql."\n", FILE_APPEND);
    $this->db->query($sql);
    $id = $this->db->insert_id();

    // Si estamos consultando por una propiedad
    if (isset($data->id_referencia) && !empty($data->id_referencia)) {

      $data->id_empresa_relacion = (isset($data->id_empresa_relacion) ? $data->id_empresa_relacion : $data->id_empresa);
      $id_propiedad = $data->id_referencia;
      $this->load->model("Propiedad_Model");
      $propiedad = $this->Propiedad_Model->get($id_propiedad,array(
        "id_empresa"=>$data->id_empresa_relacion,
      ));

      // Guardamos el interes en la propiedad
      $sql = "SELECT * FROM inm_propiedades_contactos WHERE id_empresa = '$data->id_empresa' AND id_contacto = '$data->id_contacto' AND id_propiedad = '$id_propiedad'  ";
      $q_interesado = $this->db->query($sql);
      if ($q_interesado->num_rows() == 0) {
        $sql = "INSERT INTO inm_propiedades_contactos (id_empresa,id_contacto,fecha,id_propiedad,id_empresa_propiedad) VALUES(";
        $sql.= " '$id_empresa','$data->id_contacto',NOW(),'$id_propiedad','$data->id_empresa_relacion' )";
        $this->db->query($sql);
      }

      // Guardamos el tipo de busqueda dependiendo de los valores de la propiedad que consulto
      $sql = "INSERT INTO inm_busquedas_contactos (id_empresa,id_cliente,id_localidad,id_tipo_operacion,id_tipo_inmueble,fecha) VALUES(";
      $sql.= " '$id_empresa','$data->id_contacto','$propiedad->id_localidad','$propiedad->id_tipo_operacion','$propiedad->id_tipo_inmueble',NOW() )";
      $this->db->query($sql);

      // Etiquetamos automaticamente al cliente de acuerdo al tipo de propiedad que consulto
      $tag = new stdClass();
      $tag->id_empresa = $id_empresa;
      $tag->id_cliente = $data->id_contacto;
      $tag->nombre = $propiedad->tipo_operacion;
      $tag->orden = 0;
      $this->Cliente_Model->save_tag($tag);
    }

    // ESTAMOS MANDANDO
    if (isset($data->tipo) && $data->tipo == 1) {

      // Si estamos mandando un email, y estamos en estado "A Contactar" [ID = 1], 
      // pasamos automaticamente al estado "Contactado" [ID = 2]
      if (isset($data->id_contacto)) {
        $cliente = $this->Cliente_Model->get_by_id($data->id_contacto,array(
          "id_empresa"=>$id_empresa
        ));
        if ($cliente->tipo == 1) {
          // Editamos el tipo a 2
          $this->Cliente_Model->editar_tipo(array(
            "id_empresa"=>$id_empresa,
            "id"=>$data->id_contacto,
            "tipo"=>2,
            "registrar_evento"=>0, // para evitar crear otra consulta con el movimiento de estado
          ));
        }
      }      

      // Estamos enviando un EMAIL
      if ($data->id_origen == 5) {

        $this->load->model("Empresa_Model");
        $empresa = $this->Empresa_Model->get_min($id_empresa);

        $this->load->model("Usuario_Model");
        $usuario = $this->Usuario_Model->get($data->id_usuario);
        if ($usuario !== FALSE) {
          $email = "";
          if ($data->id_paciente != 0) {
            $this->load->model("Paciente_Model");  
            $paciente = $this->Paciente_Model->get($data->id_paciente);
            $email = $paciente->email;
          } else if ($data->id_contacto != 0) {
            $cliente = $this->Cliente_Model->get($data->id_contacto);
            $email = $cliente->email;
          }
          if (!empty($email)) {

            $base = $this->config->item("base_url");

            // Links de fichas adjuntas
            if (!empty($links_adjuntos)) {
              $links = array();
              foreach($links_adjuntos as $l) {
                
                // SI ES UN COMPROBANTE
                if ($l->tipo == 2) {
                  $q = $this->db->query("SELECT * FROM facturas WHERE id = $l->id_objeto AND id_empresa = $id_empresa ");
                  if ($q->num_rows()>0) {
                    $r = $q->row();
                    $links[] = "<a href='".$base."facturas/function/ver/$r->hash'>$r->comprobante</a>";
                  }
                }
                // SI ES UNA PROPIEDAD
                else if ($l->tipo == 3) {
                  $q = $this->db->query("SELECT * FROM inm_propiedades WHERE id = $l->id_objeto AND id_empresa = $id_empresa ");
                  if ($q->num_rows()>0) {
                    $r = $q->row();
                    $links[] = "<a href='".$base."propiedades/function/ficha/$r->hash'>$r->nombre</a>";
                  }

                // Si tenemos que mandar directamente el LINK sin procesarlo
                } else if ($l->tipo == -1) {
                  $links[] = $l->id_objeto;
                }
              }
              // NO SE ADJUNTA, SE MANDAN LINKS
              if (sizeof($links)>0) {
                $data->texto.= implode("<br/>",$links);
              }
            }

            if (sizeof($adjuntos)>0) {
              $adjuntos2 = array();
              foreach($adjuntos as $adj) {
                $adj = str_replace($base, "", $adj);
                $adjuntos2[] = $adj;

                // Insertamos el adjunto
                $adj2 = "/admin/".$adj;
                $sql = "INSERT INTO crm_emails_adjuntos (id_empresa,id_email,tipo,path) VALUES(";
                $sql.= "$data->id_empresa, $id, 0, '$adj2')";
                $this->db->query($sql);
              }
              $adjuntos = $adjuntos2;
            }

            // Obtenemos el contacto
            $contacto = $this->Cliente_Model->get($data->id_contacto,$data->id_empresa);
            if ($contacto->tipo == 1) {
              // Si el tipo de contacto esta "A CONTACTAR"
              // y le estamos respondiendo un email, entonces tenemos que pasarlo a "EN PROGRESO"
              $sql = "UPDATE clientes SET tipo = 2 WHERE id = $contacto->id AND id_empresa = $contacto->id_empresa ";
              $this->db->query($sql);
            }

            require APPPATH.'libraries/Mandrill/Mandrill.php';
            mandrill_send(array(
              "to"=>$email,
              "subject"=>$data->asunto,
              "body"=>$data->texto,
              "from_name"=>(($usuario->nombre != $empresa->nombre) ? ($usuario->nombre." - ".$empresa->nombre) : $usuario->nombre),
              "reply_to"=>$usuario->email,
              "bcc"=>"basile.matias99@gmail.com",
              "attachments"=>$adjuntos,
              "metadata"=>array(
                "id_contacto"=>$data->id_contacto,
                "id_consulta"=>$id,
                "id_empresa"=>$data->id_empresa,
              ),
            ));
          }
        }

      // Estamos mandando un SMS
      } else if ($data->id_origen == 15) {

        $celular = "";
        if ($data->id_paciente != 0) {
          $this->load->model("Paciente_Model");  
          $paciente = $this->Paciente_Model->get($data->id_paciente);
          $celular = $paciente->celular;
        } else if (!empty($data->asunto)) {
          $celular = $data->asunto;
        }

        if (!empty($celular)) {
          $this->load->helper("sms_helper");
          $salida = send_sms(array(
            "numero"=>$celular,
            "texto"=>$data->texto,
          ));
        }

      }

    }
    return $id;
  }

  function update($id,$data) {
    $this->load->helper("fecha_helper");
    $data->fecha = fecha_mysql($data->fecha);
    $data->fecha = substr($data->fecha, 0, 10)." ".$data->hora;
    $data->fecha_visto = fecha_mysql($data->fecha_visto);
    return parent::update($id,$data);
  }
  
  function get($id,$config = array()) {
    $id_empresa = (isset($config["id_empresa"])) ? $config["id_empresa"] : parent::get_empresa();

    $q = $this->db->query("SELECT id_proyecto FROM empresas WHERE id = $id_empresa");
    $proy = $q->row();
    $id_proyecto = $proy->id_proyecto;

    $sql = "SELECT SQL_CALC_FOUND_ROWS C.*, ";
    $sql.= " IF(TIP.nombre IS NULL,'',TIP.nombre) AS consulta_tipo, ";
    $sql.= " DATE_FORMAT(C.fecha,'%d/%m/%Y') AS fecha, ";
    $sql.= " DATE_FORMAT(C.fecha,'%H:%i') AS hora, ";
    $sql.= " IF(C.fecha_visto = '0000-00-00','',DATE_FORMAT(C.fecha_visto,'%d/%m/%Y %H:%i')) AS fecha_visto, ";
    $sql.= " IF(CO.nombre IS NULL,'',CO.nombre) AS nombre, ";  
    $sql.= " IF(CO.email IS NULL,'',CO.email) AS email, ";
    $sql.= " IF(CO.telefono IS NULL,'',CO.telefono) AS telefono, ";
    $sql.= " IF(CO.celular IS NULL,'',CO.celular) AS celular, ";
    $sql.= " IF(CO.fecha_vencimiento IS NULL,'',DATE_FORMAT(CO.fecha_vencimiento,'%d/%m/%Y %H:%i')) AS fecha_vencimiento, ";
    $sql.= " IF(P.nombre IS NULL,'',P.nombre) AS propiedad_nombre, ";
    $sql.= " IF(P.path IS NULL,'',P.path) AS propiedad_path, ";
    $sql.= " IF(P.calle IS NULL,'',CONCAT(P.calle,' ',P.altura)) AS propiedad_direccion, ";
    $sql.= " IF(P.id_tipo_operacion IS NULL,0,P.id_tipo_operacion) AS propiedad_id_tipo_operacion, ";
    $sql.= " IF(P.id_tipo_inmueble IS NULL,0,P.id_tipo_inmueble) AS propiedad_id_tipo_inmueble, ";    
    $sql.= " IF(L.nombre IS NULL,'',L.nombre) AS propiedad_ciudad, ";      
    $sql.= " IF(ASUN.color IS NULL,'',ASUN.color) AS color_asunto, ";
    $sql.= " IF(E.titulo IS NULL,'',E.titulo) AS entrada_nombre, ";
    $sql.= " IF(E.path IS NULL,'',E.path) AS entrada_path, ";
    $sql.= " IF(O.nombre IS NULL,'',O.nombre) AS origen, ";
    $sql.= " IF(O.path IS NULL,'',O.path) AS origen_path, ";
    $sql.= " IF(O.color IS NULL,'',O.color) AS color_origen, ";
    $sql.= " IF(EM.fecha IS NULL,'',DATE_FORMAT(EM.fecha,'%d/%m/%Y %H:%i')) AS email_fecha, ";
    $sql.= " IF(EM_U.nombre IS NULL,'',EM_U.nombre) AS email_usuario, ";    
    $sql.= " IF(EM.texto IS NULL,'',EM.texto) AS texto_respuesta, ";
    $sql.= " IF(EM.archivo IS NULL,'',EM.archivo) AS email_archivo_adjunto, ";
    $sql.= " IF(U.nombre IS NULL,'',U.nombre) AS usuario ";    
    $sql.= "FROM crm_consultas C ";
    $sql.= "LEFT JOIN clientes CO ON (C.id_contacto = CO.id AND C.id_empresa = CO.id_empresa) ";  
    $sql.= "LEFT JOIN crm_consultas_tipos TIP ON (CO.tipo = TIP.id AND CO.id_empresa = TIP.id_empresa) ";
    $sql.= "LEFT JOIN crm_origenes O ON (C.id_origen = O.id) ";
    $sql.= "LEFT JOIN crm_asuntos ASUN ON (C.id_asunto = ASUN.id) ";
    $sql.= "LEFT JOIN inm_propiedades P ON (C.id_referencia = P.id AND C.id_empresa_relacion = P.id_empresa) ";
    $sql.= "LEFT JOIN com_localidades L ON (P.id_localidad = L.id) ";
    $sql.= "LEFT JOIN com_usuarios U ON (C.id_usuario = U.id AND C.id_empresa = U.id_empresa) ";
    $sql.= "LEFT JOIN crm_emails EM ON (C.id_email_respuesta = EM.id AND C.id_empresa = EM.id_empresa) ";
    $sql.= "LEFT JOIN not_entradas E ON (C.id_entrada = E.id AND C.id_empresa = E.id_empresa) ";
    $sql.= "LEFT JOIN com_usuarios EM_U ON (EM_U.id = EM.id_usuario AND C.id_empresa = EM_U.id_empresa) ";    
    $sql.= "WHERE C.id = $id ";
    $sql.= "AND C.id_empresa = $id_empresa ";
    $q = $this->db->query($sql);
    $row = $q->row();
    if ($row !== FALSE) {
      $row->texto = nl2br($row->texto);
      $row->texto_respuesta = nl2br($row->texto_respuesta);
    }
    return $q->row();
  }

  function count_all() {
    $sql = "SELECT IF(COUNT(*) IS NULL,0,COUNT(*)) AS cantidad FROM crm_consultas ";
    $sql.= "WHERE id_empresa = ".parent::get_empresa()." ";
    $sql.= "AND tipo = 0 AND id_origen NOT IN (32,12,13,14,15,16,18,20,21,22,23) ";
    $q = $this->db->query($sql);
    $row = $q->row();
    return $row->cantidad;
  }

  function contar_consultas_red($config = array()) {
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $desde = isset($config["desde"]) ? $config["desde"] : "";
    $hasta = isset($config["hasta"]) ? $config["hasta"] : "";    
    $tipo = isset($config["tipo"]) ? $config["tipo"] : 0;
    $in_origenes = isset($config["in_origenes"]) ? $config["in_origenes"] : "";
    $not_in_origenes = isset($config["not_ids_origen"]) ? $config["not_ids_origen"] : "32,12,13,14,15,16,18,20,21,22,23";
    $clientes_unicos = isset($config["clientes_unicos"]) ? $config["clientes_unicos"] : 0;
    $referencia_unica = isset($config["referencia_unica"]) ? $config["referencia_unica"] : 0;

    $sql = "SELECT ";
    // Contamos los clientes unicos
    if ($clientes_unicos == 1) $sql.= "IF(COUNT(DISTINCT id_contacto) IS NULL,0,COUNT(DISTINCT id_contacto)) AS cantidad ";
    // Contamos las propiedades/articulos consultados
    else if ($referencia_unica == 1) $sql.= "IF(COUNT(DISTINCT id_referencia) IS NULL,0,COUNT(DISTINCT id_referencia)) AS cantidad ";
    // Contamos la cantidad total de consultas
    else $sql.= "IF(COUNT(*) IS NULL,0,COUNT(*)) AS cantidad ";
    $sql.= "FROM crm_consultas C ";
    $sql.= "LEFT JOIN clientes CLI ON (C.id_empresa = CLI.id_empresa AND C.id_contacto = CLI.id) ";
    $sql.= "WHERE C.id_empresa_relacion = $id_empresa AND C.id_empresa != $id_empresa ";
    if (!empty($in_origenes)) $sql.= "AND id_origen IN ($in_origenes) ";
    if (!empty($not_in_origenes)) $sql.= "AND id_origen NOT IN ($not_in_origenes) ";
    if ($tipo != -1) $sql.= "AND C.tipo = '$tipo' ";
    if (!empty($desde)) $sql.= "AND DATE_FORMAT(C.fecha,'%Y-%m-%d') >= '$desde' ";
    if (!empty($hasta)) $sql.= "AND DATE_FORMAT(C.fecha,'%Y-%m-%d') <= '$hasta' ";
    $this->sql = $sql;

    $q = $this->db->query($sql);
    $row = $q->row();
    return $row->cantidad;
  }

  function contar($config = array()) {

    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $in_origenes = isset($config["in_origenes"]) ? $config["in_origenes"] : "";
    $not_in_origenes = isset($config["not_ids_origen"]) ? $config["not_ids_origen"] : "32,12,13,14,15,16,18,20,21,22,23";
    $clientes_unicos = isset($config["clientes_unicos"]) ? $config["clientes_unicos"] : 0;
    $tipo = isset($config["tipo"]) ? $config["tipo"] : 0;
    $id_usuario = isset($config["id_usuario"]) ? $config["id_usuario"] : 0;
    $referencia_unica = isset($config["referencia_unica"]) ? $config["referencia_unica"] : 0;
    $tipo_estado = isset($config["tipo_estado"]) ? $config["tipo_estado"] : -1;
    $fecha = isset($config["fecha"]) ? $config["fecha"] : "";
    $desde = isset($config["desde"]) ? $config["desde"] : "";
    $hasta = isset($config["hasta"]) ? $config["hasta"] : "";
    $custom_1 = isset($config["custom_1"]) ? $config["custom_1"] : "";
    $id_referencia = isset($config["id_referencia"]) ? $config["id_referencia"] : 0;

    $sql = "SELECT ";
    // Contamos los clientes unicos
    if ($clientes_unicos == 1) $sql.= "IF(COUNT(DISTINCT id_contacto) IS NULL,0,COUNT(DISTINCT id_contacto)) AS cantidad ";
    // Contamos las propiedades/articulos consultados
    else if ($referencia_unica == 1) $sql.= "IF(COUNT(DISTINCT id_referencia) IS NULL,0,COUNT(DISTINCT id_referencia)) AS cantidad ";
    // Contamos la cantidad total de consultas
    else $sql.= "IF(COUNT(*) IS NULL,0,COUNT(*)) AS cantidad ";
    $sql.= "FROM crm_consultas C ";
    $sql.= "LEFT JOIN clientes CLI ON (C.id_empresa = CLI.id_empresa AND C.id_contacto = CLI.id) ";
    $sql.= "WHERE C.id_empresa = $id_empresa ";
    if (!empty($in_origenes)) $sql.= "AND id_origen IN ($in_origenes) ";
    if (!empty($not_in_origenes)) $sql.= "AND id_origen NOT IN ($not_in_origenes) ";
    if ($tipo != -1) $sql.= "AND C.tipo = '$tipo' ";
    if ($tipo_estado != -1) $sql.= "AND CLI.tipo = '$tipo_estado' ";
    if (!empty($id_usuario)) $sql.= "AND C.id_usuario = '$id_usuario' ";
    if (!empty($fecha)) $sql.= "AND DATE_FORMAT(C.fecha,'%Y-%m-%d') = '$fecha' ";
    if (!empty($desde)) $sql.= "AND DATE_FORMAT(C.fecha,'%Y-%m-%d') >= '$desde' ";
    if (!empty($hasta)) $sql.= "AND DATE_FORMAT(C.fecha,'%Y-%m-%d') <= '$hasta' ";
    if (!empty($id_referencia)) $sql.= "AND C.id_referencia = '$id_referencia' ";
    if (!empty($custom_1)) $sql.= "AND C.custom_1 = '$custom_1' ";
    $this->sql = $sql;

    $q = $this->db->query($sql);
    $row = $q->row();
    return $row->cantidad;    
  }
  
  function buscar($conf = array()) {
    
    $id_empresa = isset($conf["id_empresa"]) ? $conf["id_empresa"] : parent::get_empresa();
    if (empty($id_empresa)) return array();
    $vencidas = isset($conf["vencidas"]) ? $conf["vencidas"] : 0;
    $buscar_respuestas = isset($conf["buscar_respuestas"]) ? $conf["buscar_respuestas"] : 1;
    $buscar_adjuntos = isset($conf["buscar_adjuntos"]) ? $conf["buscar_adjuntos"] : 1;
    $tiene_id_referencia = isset($conf["tiene_id_referencia"]) ? $conf["tiene_id_referencia"] : -1;
    $id_origen = isset($conf["id_origen"]) ? $conf["id_origen"] : 0;
    $custom_1 = isset($conf["custom_1"]) ? $conf["custom_1"] : "";
    $limit = isset($conf["limit"]) ? $conf["limit"] : 0;
    $tipo = isset($conf["tipo"]) ? $conf["tipo"] : -1;
    $id_usuario = isset($conf["id_usuario"]) ? $conf["id_usuario"] : 0;
    $id_contacto = isset($conf["id_contacto"]) ? $conf["id_contacto"] : 0;
    $estado = isset($conf["estado"]) ? $conf["estado"] : -1;
    $filter = isset($conf["filter"]) ? $conf["filter"] : "";
    $id_asunto = isset($conf["id_asunto"]) ? $conf["id_asunto"] : 0;
    $id_profesional = isset($conf["id_profesional"]) ? $conf["id_profesional"] : 0;
    $estado_turno = isset($conf["estado_turno"]) ? $conf["estado_turno"] : -1;
    $fecha = isset($conf["fecha"]) ? $conf["fecha"] : "";
    $desde = isset($conf["desde"]) ? $conf["desde"] : "";
    $hasta = isset($conf["hasta"]) ? $conf["hasta"] : "";
    $not_ids_origen = isset($conf["not_ids_origen"]) ? $conf["not_ids_origen"] : "";
    $offset = isset($conf["offset"]) ? $conf["offset"] : 20;
    $id_origenes = isset($conf["id_origenes"]) ? str_replace("-",",",$conf["id_origenes"]) : "";
    $order_by = isset($conf["order_by"]) ? $conf["order_by"] : "C.fecha DESC, C.id DESC ";
    $solo_contar = isset($conf["solo_contar"]) ? $conf["solo_contar"] : 0;
    $buscar_totales = isset($conf["buscar_totales"]) ? $conf["buscar_totales"] : 1;

    // Primero buscamos los clientes
    $sql = "SELECT SQL_CALC_FOUND_ROWS C.*, ";
    $sql.= " DATE_FORMAT(C.fecha_vencimiento,'%d/%m/%Y %H:%i') AS fecha_vencimiento, ";
    $sql.= " IF(TIP.nombre IS NULL,'',TIP.nombre) AS consulta_tipo, ";
    $sql.= " IF(U.nombre IS NULL,'',U.nombre) AS usuario ";
    $sql.= "FROM clientes C ";    
    $sql.= "LEFT JOIN com_usuarios U ON (C.id_usuario = U.id AND C.id_empresa = U.id_empresa) ";
    $sql.= "LEFT JOIN crm_consultas_tipos TIP ON (C.tipo = TIP.id AND C.id_empresa = TIP.id_empresa) ";
    $sql.= "WHERE C.id_empresa = $id_empresa ";
    $sql.= "AND C.tipo != 0 "; // Para que no tome del sistema anterior
    if ($tipo != -1) $sql.= "AND C.tipo = $tipo "; // Filtro por estado
    if (!empty($filter)) $sql.= "AND C.nombre LIKE '%".$filter."%' ";
    if (!empty($id_contacto)) $sql.= "AND C.id = $id_contacto ";
    if (!empty($id_usuario)) $sql.= "AND C.id_usuario = $id_usuario ";
    // Si estamos buscando consultas vencidas, la fecha de vencimiento tiene que ser menor a la actual
    // y el estado no puede ser FINALIZADO (98) ni ARCHIVADO (99)
    if ($vencidas == 1) $sql.= "AND C.fecha_vencimiento <= NOW() AND C.tipo NOT IN (98,99) ";
    $sql.= "ORDER BY C.fecha_ult_operacion DESC ";
    $sql.= "LIMIT $limit, $offset";
    $sql2 = $sql;
    
    $q = $this->db->query($sql);
    $q_total = $this->db->query("SELECT FOUND_ROWS() AS total");
    $total = $q_total->row();
    if ($solo_contar == 1) return $total->total;

    $resultado = array();
    foreach($q->result() as $res) {

      $res->asunto = "";
      $res->fecha = "";
      $res->hora = "";
      $res->id_consulta = 0;
      $res->id_origen = 0;
      $res->origen = "";
      $res->propiedad_id = 0;
      $res->propiedad_nombre = "";
      $res->propiedad_path = "";
      $res->propiedad_id_tipo_operacion = 0;
      $res->propiedad_tipo_operacion = "";
      $res->propiedad_id_tipo_inmueble = 0;
      $res->propiedad_tipo_inmueble = "";
      $res->propiedad_direccion = "";
      $res->propiedad_ciudad = "";
      // Y despues tomamos la ultima consulta
      $consultas = $this->buscar_consultas(array(
        "id_contacto"=>$res->id,
        "id_empresa"=>$id_empresa,
        "limit"=>0,
        "offset"=>1,
        "tipo"=>0, // Consultas recibidas
        "not_ids_origen"=>$this->get_not_origenes_listado(),
      ));
      if (sizeof($consultas["results"])>0) {
        $rr = $consultas["results"][0];
        $res->id_consulta = $rr->id_consulta;
        $res->asunto = $rr->asunto;
        $res->fecha = $rr->fecha;
        $res->hora = $rr->hora;
        $res->origen = $rr->origen;
        $res->id_origen = $rr->id_origen;
        $res->propiedad_id = $rr->propiedad_id;
        $res->propiedad_nombre = $rr->propiedad_nombre;
        $res->propiedad_path = $rr->propiedad_path;
        $res->propiedad_id_tipo_operacion = $rr->propiedad_id_tipo_operacion;
        $res->propiedad_tipo_operacion = $rr->propiedad_tipo_operacion;
        $res->propiedad_id_tipo_inmueble = $rr->propiedad_id_tipo_inmueble;
        $res->propiedad_tipo_inmueble = $rr->propiedad_tipo_inmueble;
        $res->propiedad_ciudad = $rr->propiedad_ciudad;
        $res->propiedad_direccion = $rr->propiedad_direccion;

        // Buscamos si tiene alguna actividad asignada
      }

      $resultado[] = $res;
    }

    // Buscamos los totales de consultas por tipo
    if ($buscar_totales == 1) {
      $meta = array(
        "totales"=>array(),
      );
      $this->load->model("Consulta_Tipo_Model");
      $tipos = $this->Consulta_Tipo_Model->get_all();
      foreach($tipos as $tipo) {
        $sql = "SELECT IF(COUNT(*) IS NULL,0,COUNT(*)) AS cantidad ";
        $sql.= "FROM clientes C ";
        $sql.= "WHERE C.id_empresa = $id_empresa ";
        $sql.= "AND C.activo = 1 ";
        $sql.= "AND C.tipo = $tipo->id ";
        $q = $this->db->query($sql);
        $r = $q->row();
        $meta["totales"][$tipo->id] = $r->cantidad;
      }
    }
    
    return array(
      "sql"=>$sql2,
      "meta"=>$meta,
      "results"=>$resultado,
      "total"=>$total->total,
    );
  }


  function buscar_consultas($config = array()) {
    
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $id_contacto = isset($config["id_contacto"]) ? $config["id_contacto"] : 0;
    $not_ids_origen = isset($config["not_ids_origen"]) ? $config["not_ids_origen"] : "";
    $limit = isset($config["limit"]) ? $config["limit"] : 0;
    $tipo = isset($config["tipo"]) ? $config["tipo"] : -1;
    $offset = isset($config["offset"]) ? $config["offset"] : 20;

    $sql = "SELECT SQL_CALC_FOUND_ROWS ";
    $sql.= " C.*, C.id AS id_consulta, ";
    $sql.= " IF(CLI.nombre IS NULL,'',CLI.nombre) AS nombre, ";
    $sql.= " IF(CLI.fecha_vencimiento IS NULL,'',DATE_FORMAT(CLI.fecha_vencimiento,'%d/%m/%Y %H:%i')) AS fecha_vencimiento, ";
    $sql.= " IF(CLI.email IS NULL,'',CLI.email) AS email, ";
    $sql.= " DATE_FORMAT(C.fecha,'%d/%m/%Y') AS fecha, ";
    $sql.= " DATE_FORMAT(C.fecha,'%H:%i') AS hora, ";
    $sql.= " IF(USUARIO.nombre IS NULL,'',USUARIO.nombre) AS usuario, ";
    $sql.= " IF(O.nombre IS NULL,'',O.nombre) AS origen, ";
    $sql.= " IF(P.nombre IS NULL,'',P.nombre) AS propiedad_nombre, ";
    $sql.= " IF(P.path IS NULL,'',P.path) AS propiedad_path, ";
    $sql.= " IF(P.id IS NULL,0,P.id) AS propiedad_id, ";
    $sql.= " IF(P.id_tipo_operacion IS NULL,0,P.id_tipo_operacion) AS propiedad_id_tipo_operacion, ";
    $sql.= " IF(TIPO_OP.nombre IS NULL,'',TIPO_OP.nombre) AS propiedad_tipo_operacion, ";
    $sql.= " IF(P.id_tipo_inmueble IS NULL,0,P.id_tipo_inmueble) AS propiedad_id_tipo_inmueble, ";      
    $sql.= " IF(TIPO_INM.nombre IS NULL,'',TIPO_INM.nombre) AS propiedad_tipo_inmueble, ";
    $sql.= " IF(P.calle IS NULL,'',CONCAT(P.calle,' ',P.altura)) AS propiedad_direccion, ";
    $sql.= " IF(L.nombre IS NULL,'',L.nombre) AS propiedad_ciudad ";
    $sql.= "FROM crm_consultas C ";
    $sql.= "LEFT JOIN clientes CLI ON (C.id_empresa = CLI.id_empresa AND C.id_contacto = CLI.id) ";
    $sql.= "LEFT JOIN crm_consultas_tipos CON_TIPO ON (C.tipo = CON_TIPO.id AND C.id_empresa = CON_TIPO.id_empresa) ";
    $sql.= "LEFT JOIN com_usuarios USUARIO ON (C.id_usuario = USUARIO.id AND C.id_empresa = USUARIO.id_empresa) ";
    $sql.= "LEFT JOIN crm_origenes O ON (C.id_origen = O.id) ";
    $sql.= "LEFT JOIN inm_propiedades P ON (C.id_referencia = P.id AND C.id_empresa_relacion = P.id_empresa) ";
    $sql.= "LEFT JOIN inm_tipos_operacion TIPO_OP ON (P.id_tipo_operacion = TIPO_OP.id) ";
    $sql.= "LEFT JOIN inm_tipos_inmueble TIPO_INM ON (P.id_tipo_inmueble = TIPO_INM.id) ";
    $sql.= "LEFT JOIN com_localidades L ON (P.id_localidad = L.id) ";
    $sql.= "WHERE C.id_empresa = $id_empresa ";
    if ($tipo != -1) $sql.= "AND C.tipo = $tipo ";
    if (!empty($not_ids_origen)) $sql.= "AND C.id_origen NOT IN ($not_ids_origen) ";
    $sql.= "AND C.id_contacto = $id_contacto ";
    $sql.= "ORDER BY C.fecha DESC, C.id DESC ";
    $sql.= "LIMIT $limit,$offset ";
    $qq = $this->db->query($sql);

    $q = $this->db->query($sql);
    $q_total = $this->db->query("SELECT FOUND_ROWS() AS total");
    $total = $q_total->row();
    return array(
      "results"=>$qq->result(),
      "total"=>$total->total,
    );    
  }


}