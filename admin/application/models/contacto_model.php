<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Contacto_Model extends Abstract_Model {
	
	function __construct() {
		parent::__construct("clientes","id","nombre ASC");
	}

  // Se esta creando un nuevo contacto desde el panel de control
  function insert($data) {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $this->load->helper("fecha_helper");
    $id_propiedad = (isset($data->id_propiedad)) ? $data->id_propiedad : 0;
    $id_contacto = (isset($data->id_contacto)) ? $data->id_contacto : 0;
    $id_origen = (isset($data->id_origen)) ? $data->id_origen : 0;
    $id_usuario = (isset($data->id_usuario)) ? $data->id_usuario : 0;
    $editar_consulta = (isset($data->editar_consulta)) ? $data->editar_consulta : 0;
    $id_consulta = (isset($data->id_consulta)) ? $data->id_consulta : 0;
    $id_empresa_propiedad = (isset($data->id_empresa_propiedad)) ? $data->id_empresa_propiedad : $data->id_empresa;
    $texto = (isset($data->texto)) ? $data->texto : "";
    $asunto = (isset($data->asunto)) ? $data->asunto : "";
    $notificar_propietario = (isset($data->notificar_propietario)) ? $data->notificar_propietario : 0;
    $fecha_ult_operacion = (isset($data->fecha_ult_operacion)) ? $data->fecha_ult_operacion : date("d/m/Y H:i:s");

    $data->fecha_ult_operacion = fecha_mysql($fecha_ult_operacion);

    // Consultamos la fecha de vencimiento de acuerdo a la configuracion del tipo de consulta
    if (isset($data->tipo)) {
      $this->load->model("Consulta_Tipo_Model");
      $tipo_estado = $this->Consulta_Tipo_Model->get($data->tipo);
      if ($tipo_estado->tiempo_vencimiento > 0) {
        $datetime = DateTime::createFromFormat('d/m/Y H:i', $fecha_ult_operacion);
        if ($datetime != FALSE) {
          $datetime->modify("+".$tipo_estado->tiempo_vencimiento." days");
          $data->fecha_vencimiento = $datetime->format("Y-m-d H:i:s");
        }
      }      
    }

    if ($id_contacto == 0) {
      $id = parent::insert($data);
      $id_contacto = $id;
    } else {
      parent::update($id_contacto,$data);
      $id = $id_contacto;
    }
    // Tambien tenemos que insertar la consulta
    
    if ($editar_consulta == 1 && $id_consulta > 0) {
      $sql = "UPDATE crm_consultas ";
      $sql.= "SET ";
      $sql.= "fecha = '$data->fecha_ult_operacion', ";
      $sql.= "texto = '$texto', ";
      $sql.= "id_origen = '$id_origen', ";
      $sql.= "id_usuario = '$id_usuario', ";
      $sql.= "id_contacto = '$id_contacto', ";
      $sql.= "id_referencia = '$id_propiedad', ";
      $sql.= "id_empresa = '$data->id_empresa' ";
      $sql.= "WHERE id = '$id_consulta' ";
      $this->db->query($sql);
    } elseif (!empty($id_usuario)) {
      $this->load->model("Consulta_Model");
      $consulta = new stdClass();
      $consulta->tipo = 0; // Entrada
      $consulta->id_contacto = $id;
      $consulta->id_empresa = $data->id_empresa;
      $consulta->id_origen = $id_origen;
      $consulta->id_usuario = $id_usuario;
      $consulta->fecha = $fecha_ult_operacion;
      $consulta->texto = $texto;
      $consulta->asunto = $asunto;
      $consulta->id_referencia = $id_propiedad;
      $consulta->id_empresa_relacion = $id_empresa_propiedad;
      $this->Consulta_Model->insert($consulta);
    }


    //Visita
    
    if ($id_origen == 41) {

      require_once APPPATH.'libraries/Mandrill/Mandrill.php';
      $this->load->model("Email_Template_Model");

      $this->load->model("Propiedad_Model");
      $cliente = $this->get($id_contacto);
      $propiedad = $this->Propiedad_Model->get($id_propiedad);

      $this->load->helper("fecha_helper");

      $template = $this->Email_Template_Model->get_by_key("nueva-visita-contacto",$data->id_empresa);
      if (!isset($template->texto)) {
        $template = new stdClass();
        $template->nombre = "¡Nueva visita!";
        $template->texto = "{{nombre_contacto}}, se agendó una visita para la propiedad ubicada en {{direccion_propiedad}} a las {{fecha_hora}}.";
      }
      $body = $template->texto;
      $body = str_replace("{{nombre_contacto}}",$cliente->nombre,$body);
      $body = str_replace("{{direccion_propiedad}}",$propiedad->calle." ".$propiedad->altura." | ".$propiedad->localidad,$body);
      $body = str_replace("{{fecha_hora}}",fecha_es($fecha_ult_operacion),$body);
      
      mandrill_send(array(
        "from_name"=>"Inmovar",
        "to"=>$cliente->email,
        "subject"=>$template->nombre,
        "body"=>$body,
      ));

      if (isset($notificar_propietario) && !empty($notificar_propietario) && $propiedad->id_propietario != 0) {

        $template = $this->Email_Template_Model->get_by_key("nueva-visita-propietario",$data->id_empresa);
        if (!isset($template->texto)) {
          $template = new stdClass();
          $template->nombre = "¡Nueva visita!";
          $template->texto = "{{nombre_propietario}}, {{nombre_contacto} agendó una visita para la propiedad ubicada en {{direccion_propiedad}} a las {{fecha_hora}}.";
        }
        $body = $template->texto;
        $body = str_replace("{{nombre_propietario}}",$propiedad->propietario,$body);
        $body = str_replace("{{nombre_contacto}}",$cliente->nombre,$body);
        $body = str_replace("{{direccion_propiedad}}",$propiedad->calle." ".$propiedad->altura." | ".$propiedad->localidad,$body);
        $body = str_replace("{{fecha_hora}}",fecha_es($fecha_ult_operacion),$body);

        mandrill_send(array(
          "from_name"=>"Inmovar",
          "to"=>$propiedad->propietario_email,
          "subject"=>$template->nombre,
          "body"=>$body,
        ));

      }

    }


    return $id;
  }

	function get($id,$id_empresa = 0,$config = array()) {

		if (empty($id)) return FALSE;
		if ($id_empresa == 0) $id_empresa = parent::get_empresa();

    $this->load->model("Empresa_Model");
    $empresa = $this->Empresa_Model->get_min($id_empresa);

    $id_sucursal = isset($config["id_sucursal"]) ? $config["id_sucursal"] : 0;
		$sql = "SELECT C.*, ";
    $sql.= " IF(TIP.nombre IS NULL,'',TIP.nombre) AS consulta_tipo, ";
		$sql.= "  DATE_FORMAT(C.fecha_inicial,'%d/%m/%Y') AS fecha_inicial, ";
    $sql.= "  DATE_FORMAT(C.fecha_ult_operacion,'%d/%m/%Y %H:%i:%s') AS fecha_ult_operacion, ";
    $sql.= "  DATE_FORMAT(C.fecha_vencimiento,'%d/%m/%Y %H:%i:%s') AS fecha_vencimiento, ";
		$sql.= "  IF (TI.nombre IS NULL,'',TI.nombre) AS tipo_iva, ";
		$sql.= "  IF (L.nombre IS NULL,'',L.nombre) AS localidad ";
		$sql.= "FROM clientes C ";
		$sql.= " LEFT JOIN tipos_iva TI ON (C.id_tipo_iva = TI.id) ";
    $sql.= " LEFT JOIN crm_consultas_tipos TIP ON (C.tipo = TIP.id AND C.id_empresa = TIP.id_empresa) ";
		$sql.= " LEFT JOIN com_localidades L ON (C.id_localidad = L.id) ";
		$sql.= "WHERE C.id = $id ";
		$sql.= "AND C.id_empresa = $id_empresa ";
    if (!empty($id_sucursal)) $sql.= "AND C.id_sucursal = $id_sucursal ";
		$query = $this->db->query($sql);
		$row = $query->row(); 

    if ($row !== FALSE) {
      $this->load->model("Consulta_Model");
      $res = $this->Consulta_Model->buscar_consultas(array(
        "id_empresa"=>$id_empresa,
        "id_contacto"=>$row->id,
        "offset"=>999999,
      ));
      $row->consultas = $res["results"];

      $sql = "SELECT CO.id, CO.subtitulo, CO.id_origen, CO.id_usuario,  ";
      $sql.= " IF(RES.id IS NULL,0,1) AS respondido, ";
      $sql.= " IF(PRO.nombre IS NULL,'',PRO.nombre) AS propiedad_nombre, ";
      $sql.= " IF(PRO.id_tipo_operacion IS NULL,0,PRO.id_tipo_operacion) AS propiedad_id_tipo_operacion, ";
      $sql.= " IF(OPE.id IS NULL,'',OPE.nombre) AS propiedad_tipo_operacion, ";
      $sql.= " IF(USER.nombre IS NULL,'',USER.nombre) AS respondido_por, ";
      $sql.= " IF(RES.subtitulo IS NULL,'',RES.subtitulo) AS subtitulo ";
      $sql.= "FROM crm_consultas CO ";
      $sql.= "LEFT JOIN crm_consultas RES ON (RES.id_empresa = CO.id_empresa AND RES.id_contacto = CO.id_contacto AND RES.id_email_respuesta = CO.id AND RES.tipo = 1) ";
      $sql.= "LEFT JOIN com_usuarios USER ON (RES.id_usuario = USER.id AND RES.id_empresa = USER.id_empresa) ";
      $sql.= "LEFT JOIN inm_propiedades PRO ON (PRO.id_empresa = CO.id_empresa AND PRO.id = CO.id_referencia) ";
      $sql.= "LEFT JOIN inm_tipos_operacion OPE ON (PRO.id_tipo_operacion = OPE.id) ";
      $sql.= "WHERE CO.id_contacto = $row->id AND CO.id_empresa = $row->id_empresa ";
      $sql.= "AND CO.tipo = 0 ";
      $sql.= "AND CO.id_origen NOT IN (20,32) "; // Que no tome las creaciones de usuario ni las notificaciones del mismo sistema
      $sql.= "ORDER BY CO.fecha DESC ";
      $sql.= "LIMIT 0,1 ";
      $qq = $this->db->query($sql);
      if ($qq->num_rows()>0) {
        $respuesta = $qq->row();
        $row->id_consulta = $respuesta->id;
        $row->respondido = $respuesta->respondido;
        $row->respondido_por = $respuesta->respondido_por;
        $row->subtitulo = $respuesta->subtitulo;            
        $row->id_origen = $respuesta->id_origen;
        $row->id_usuario_asignado = $respuesta->id_usuario;
        $row->propiedad_nombre = $respuesta->propiedad_nombre;
        $row->propiedad_id_tipo_operacion = $respuesta->propiedad_id_tipo_operacion;
        $row->propiedad_tipo_operacion = $respuesta->propiedad_tipo_operacion;
        $row->propiedad_codigo = isset($respuesta->propiedad_codigo) ? $respuesta->propiedad_codigo : 0 ;
      } else {
        $row->respondido = 0;
        $row->id_consulta = 0;
        $row->respondido_por = "";
        $row->subtitulo = "";
        $row->id_origen = 0;
        $row->id_usuario_asignado = 0;
        $row->propiedad_nombre = "";
        $row->propiedad_id_tipo_operacion = 0;
        $row->propiedad_tipo_operacion = "";
        $row->propiedad_codigo = "";
      }

      // Buscamos tambien si tiene una tarea no realizada
      $sql = "SELECT id, asunto FROM crm_consultas CO ";
      $sql.= "WHERE CO.id_contacto = $row->id AND CO.id_empresa = $row->id_empresa ";
      $sql.= "AND CO.tipo = 1 ";
      $sql.= "AND CO.id_origen = 17 ";
      $sql.= "AND CO.estado = 0 ";
      $sql.= "LIMIT 0,1 ";
      $qq = $this->db->query($sql);
      if ($qq->num_rows()>0) {
        $r_tarea = $qq->row();
        $row->tarea_asignada = 1;
        $row->tarea_titulo = $r_tarea->asunto;
      } else {
        $row->tarea_asignada = 0;
        $row->tarea_titulo = "";
      }      

      // Obtenemos las etiquetas de esa entrada
      $sql = "SELECT E.nombre ";
      $sql.= " FROM clientes_etiquetas_relacion EE INNER JOIN clientes_etiquetas E ON (EE.id_etiqueta = E.id AND EE.id_empresa = E.id_empresa) ";
      $sql.= "WHERE EE.id_cliente = $id AND EE.id_empresa = $id_empresa ORDER BY EE.orden ASC";
      $q = $this->db->query($sql);
      $row->etiquetas = array();
      foreach($q->result() as $r) {
        $row->etiquetas[] = (html_entity_decode($r->nombre));
      }
    }
		return $row;
	}
    
	function find($filter) {
		$id_empresa = parent::get_empresa();
		$this->db->where("id_empresa",$id_empresa);
		$this->db->like("nombre",$filter);
		$query = $this->db->get($this->tabla);
		$result = $query->result();
		$this->db->close();
		return $result;
	}
	
	function find_by_email($email,$id_empresa = 0) {
		if ($id_empresa == 0) $id_empresa = parent::get_empresa();
		$res = FALSE;
		$q = $this->db->query("SELECT * FROM crm_contactos WHERE id_empresa = $id_empresa AND email = '$email'");
		if ($q->num_rows()>0) {
			$res = $q->row();
		}
		return $res;
	}

}