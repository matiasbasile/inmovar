<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Usuario_Model extends Abstract_Model {

  private $total;
	
	function __construct() {
		parent::__construct("com_usuarios","id");
	}

  function get_random($config = array()) {
    $id_empresa = (isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa());
    $sql = "SELECT id ";
    $sql.= "FROM com_usuarios ";
    $sql.= "WHERE id_empresa = $id_empresa ";
    $sql.= "AND activo = 1 ";
    $sql.= "AND recibe_notificaciones = 1 ";
    $sql.= "ORDER BY RAND() ASC ";
    $sql.= "LIMIT 0,1 ";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) return FALSE;
    $r = $q->row();
    return $this->get($r->id,array(
      "id_empresa"=>$id_empresa,
    ));
  }

  function get_usuario_principal($id_empresa) {
    $sql = "SELECT U.* ";
    $sql.= "FROM com_usuarios U INNER JOIN com_perfiles P ON (U.id_empresa = P.id_empresa AND U.id_perfiles = P.id) ";
    $sql.= "WHERE U.id_empresa = $id_empresa AND P.principal = 1 ";
    $sql.= "ORDER BY U.id ASC ";
    $q = $this->db->query($sql);
    return ($q->num_rows() > 0 ? $q->row() : FALSE);    
  }

  function delete($id) {
    $id_empresa = parent::get_empresa();
    if ($this->db->table_exists('toque_categorias_usuarios')) {
      $this->db->query("DELETE FROM toque_categorias_usuarios WHERE id_empresa = $id_empresa AND id_usuario = $id ");
    }
    if ($this->db->table_exists('profesionales_obras_sociales')) {
      $this->db->query("DELETE FROM profesionales_obras_sociales WHERE id_empresa = $id_empresa AND id_usuario = $id ");
    }
    if ($this->db->table_exists('profesionales_especialidades')) {
      $this->db->query("DELETE FROM profesionales_especialidades WHERE id_empresa = $id_empresa AND id_usuario = $id ");
    }
    if ($this->db->table_exists('profesionales_tipos_pacientes')) {
      $this->db->query("DELETE FROM profesionales_tipos_pacientes WHERE id_empresa = $id_empresa AND id_usuario = $id ");
    }
    if ($this->db->table_exists('profesionales_tipos_atenciones')) {
      $this->db->query("DELETE FROM profesionales_tipos_atenciones WHERE id_empresa = $id_empresa AND id_usuario = $id ");
    }
    if ($this->db->table_exists('profesionales_tipos_terapias')) {
      $this->db->query("DELETE FROM profesionales_tipos_terapias WHERE id_empresa = $id_empresa AND id_usuario = $id ");
    }
    if ($this->db->table_exists('profesionales_titulos')) {
      $this->db->query("DELETE FROM profesionales_titulos WHERE id_empresa = $id_empresa AND id_usuario = $id ");
    }
    if ($this->db->table_exists('profesionales_formas_pago')) {
      $this->db->query("DELETE FROM profesionales_formas_pago WHERE id_empresa = $id_empresa AND id_usuario = $id ");
    }
    if ($this->db->table_exists('com_usuarios_images')) {
      $this->db->query("DELETE FROM com_usuarios_images WHERE id_empresa = $id_empresa AND id_usuario = $id ");
    }
    parent::delete($id);
  }

  function duplicar($id) {
    $this->load->helper("fecha_helper");
    $this->load->helper("file_helper");

    $usuario = $this->get($id);
    if ($usuario === FALSE) {
      return array(
        "error"=>1,
        "mensaje"=>"No se encuentra el articulo con ID: $id",
      );
      return;
    }

    $usuario->id = 0;
    $horarios = isset($usuario->horarios) ? $usuario->horarios : array();
    $horarios_entrega = isset($usuario->horarios_entrega) ? $usuario->horarios_entrega : array();
    $sucursales = isset($usuario->sucursales) ? $usuario->sucursales : array();
    $toque_categorias = isset($usuario->toque_categorias) ? $usuario->toque_categorias : array();
    $obras_sociales = isset($usuario->obras_sociales) ? $usuario->obras_sociales : array();
    $especialidades = isset($usuario->especialidades) ? $usuario->especialidades : array();
    $tipos_pacientes = isset($usuario->tipos_pacientes) ? $usuario->tipos_pacientes : array();
    $tipos_terapias = isset($usuario->tipos_terapias) ? $usuario->tipos_terapias : array();
    $tipos_atenciones = isset($usuario->tipos_atenciones) ? $usuario->tipos_atenciones : array();
    $titulos = isset($usuario->titulos) ? $usuario->titulos : array();
    $formas_pago = isset($usuario->formas_pago) ? $usuario->formas_pago : array();
    $images = isset($usuario->images) ? $usuario->images : array();
    $solo_usuario = isset($usuario->solo_usuario) ? $usuario->solo_usuario : 0;
    $path_2 = isset($usuario->path_2) ? $usuario->path_2 : "";
    $facebook = isset($usuario->facebook) ? $usuario->facebook : "";
    $instagram = isset($usuario->instagram) ? $usuario->instagram : "";
    $linkedin = isset($usuario->linkedin) ? $usuario->linkedin : "";
    $custom_1 = isset($usuario->custom_1) ? $usuario->custom_1 : "";
    $custom_2 = isset($usuario->custom_2) ? $usuario->custom_2 : "";
    $custom_3 = isset($usuario->custom_3) ? $usuario->custom_3 : "";
    $custom_4 = isset($usuario->custom_4) ? $usuario->custom_4 : "";
    $custom_5 = isset($usuario->custom_5) ? $usuario->custom_5 : "";
    $custom_6 = isset($usuario->custom_6) ? $usuario->custom_6 : "";
    $custom_7 = isset($usuario->custom_7) ? $usuario->custom_7 : "";
    $custom_8 = isset($usuario->custom_8) ? $usuario->custom_8 : "";
    $custom_9 = isset($usuario->custom_9) ? $usuario->custom_9 : "";
    $custom_10 = isset($usuario->custom_10) ? $usuario->custom_10 : "";
    $clave_especial = isset($usuario->clave_especial) ? $usuario->clave_especial : "";
    $destacado = isset($usuario->destacado) ? $usuario->destacado : 0;
    $usuario->fecha_alta = date("Y-m-d H:i:s");

    $insert_id = $this->insert($usuario);
    
    // Guardamos las imagenes
    foreach($horarios as $im) {
      $sql = "INSERT INTO com_usuarios_horarios (id_empresa,id_usuario,desde,hasta,dia,tipo) VALUES( ";
      $sql.= "$usuario->id_empresa,$insert_id,'$im->desde','$im->hasta','$im->dia',0)";
      $this->db->query($sql);
    }

    foreach($horarios_entrega as $im) {
      $sql = "INSERT INTO com_usuarios_horarios (id_empresa,id_usuario,desde,hasta,dia,tipo) VALUES( ";
      $sql.= "$usuario->id_empresa,$insert_id,'$im->desde','$im->hasta','$im->dia',1)";
      $this->db->query($sql);
    }

    if ($this->db->table_exists('com_usuarios_sucursales')) {
      foreach($sucursales as $im) {
        $sql = "INSERT INTO com_usuarios_sucursales (id_empresa,id_usuario,id_sucursal) VALUES( ";
        $sql.= "$usuario->id_empresa,$insert_id,'$im->id_sucursal')";
        $this->db->query($sql);
      }
    }

    if ($this->db->table_exists('toque_categorias_usuarios')) {
      $k=0;
      foreach($toque_categorias as $im) {
        $sql = "INSERT INTO toque_categorias_usuarios (id_usuario,id_categoria,orden,id_empresa) VALUES( ";
        $sql.= "$insert_id,'$im',$k,$usuario->id_empresa)";
        $this->db->query($sql);        
        $k++;
      }
    }

    if ($this->db->table_exists('profesionales_obras_sociales')) {
      $k=0;
      foreach($obras_sociales as $im) {
        $sql = "INSERT INTO profesionales_obras_sociales (id_usuario,id_obra_social,orden,id_empresa) VALUES( ";
        $sql.= "$insert_id,'$im',$k,$usuario->id_empresa)";
        $this->db->query($sql);        
        $k++;
      }
    }
    if ($this->db->table_exists('profesionales_especialidades')) {
      $k=0;
      foreach($especialidades as $im) {
        $sql = "INSERT INTO profesionales_especialidades (id_usuario,id_especialidad,orden,id_empresa) VALUES( ";
        $sql.= "$insert_id,'$im',$k,$usuario->id_empresa)";
        $this->db->query($sql);        
        $k++;
      }
    }
    if ($this->db->table_exists('profesionales_tipos_pacientes')) {
      $k=0;
      foreach($tipos_pacientes as $im) {
        $sql = "INSERT INTO profesionales_tipos_pacientes (id_usuario,id_tipo_paciente,orden,id_empresa) VALUES( ";
        $sql.= "$insert_id,'$im',$k,$usuario->id_empresa)";
        $this->db->query($sql);        
        $k++;
      }
    }
    if ($this->db->table_exists('profesionales_tipos_terapias')) {
      $k=0;
      foreach($tipos_terapias as $im) {
        $sql = "INSERT INTO profesionales_tipos_terapias (id_usuario,id_tipo_terapia,orden,id_empresa) VALUES( ";
        $sql.= "$insert_id,'$im',$k,$usuario->id_empresa)";
        $this->db->query($sql);        
        $k++;
      }
    }
    if ($this->db->table_exists('profesionales_tipos_atenciones')) {
      $k=0;
      foreach($tipos_atenciones as $im) {
        $sql = "INSERT INTO profesionales_tipos_atenciones (id_usuario,id_tipo_atencion,orden,id_empresa) VALUES( ";
        $sql.= "$insert_id,'$im',$k,$usuario->id_empresa)";
        $this->db->query($sql);        
        $k++;
      }
    }
    if ($this->db->table_exists('profesionales_titulos')) {
      $k=0;
      foreach($titulos as $im) {
        $sql = "INSERT INTO profesionales_titulos (id_usuario,id_titulo,orden,id_empresa) VALUES( ";
        $sql.= "$insert_id,'$im',$k,$usuario->id_empresa)";
        $this->db->query($sql);        
        $k++;
      }
    }
    if ($this->db->table_exists('profesionales_formas_pago')) {
      $k=0;
      foreach($formas_pago as $im) {
        $sql = "INSERT INTO profesionales_formas_pago (id_usuario,id_forma_pago,orden,id_empresa) VALUES( ";
        $sql.= "$insert_id,'$im',$k,$usuario->id_empresa)";
        $this->db->query($sql);        
        $k++;
      }
    }


    // Guardamos las imagenes
    if ($this->db->table_exists('com_usuarios_images')) {
      $k=0;
      foreach($images as $im) {
        $this->db->query("INSERT INTO com_usuarios_images (id_empresa,id_usuario,path,orden) VALUES($data->id_empresa,$insert_id,'$im',$k)");
        $k++;
      }
    }    

    $this->save_extension(array(
      "id_usuario"=>$insert_id,
      "id_empresa"=>$usuario->id_empresa,
      "solo_usuario"=>$solo_usuario,
      "path_2"=>$path_2,
      "clave_especial"=>$clave_especial,
      "destacado"=>$destacado,
      "instagram"=>$instagram,
      "facebook"=>$facebook,
      "linkedin"=>$linkedin,
      "custom_1"=>$custom_1,
      "custom_2"=>$custom_2,
      "custom_3"=>$custom_3,
      "custom_4"=>$custom_4,
      "custom_5"=>$custom_5,
      "custom_6"=>$custom_6,
      "custom_7"=>$custom_7,
      "custom_8"=>$custom_8,
      "custom_9"=>$custom_9,
      "custom_10"=>$custom_10,
    ));
    
    return array(
      "id"=>$insert_id
    );
  }  

	function find($filter) {
		$id_empresa = $this->get_empresa();
		$sql = "SELECT U.*, IF(F.nombre IS NULL,'',F.nombre) AS perfil ";
		$sql.= "FROM com_usuarios U ";
		$sql.= "LEFT JOIN com_perfiles F ON (U.id_perfiles = F.id) ";
		$sql.= "WHERE U.id_empresa = $id_empresa ";
		$sql.= " AND (CONCAT(U.nombre) LIKE '%$filter%' ) ";
		$sql.= "ORDER BY U.nombre_usuario ASC ";
		$query = $this->db->query($sql);
		$result = $query->result();
		$this->db->close();
		return $result;
	}
    
	function buscar($config=array()) {

		$id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : $this->get_empresa();
		$filter = isset($config["filter"]) ? $config["filter"] : "";
    $buscar_horarios = isset($config["buscar_horarios"]) ? $config["buscar_horarios"] : 0;
    $id_sucursal = isset($config["id_sucursal"]) ? $config["id_sucursal"] : 0;
    $id_perfil = isset($config["id_perfil"]) ? $config["id_perfil"] : 0;
		$admin = isset($config["admin"]) ? $config["admin"] : 0;
		$limit = isset($config["limit"]) ? $config["limit"] : 0;
    $aparece_web = isset($config["aparece_web"]) ? $config["aparece_web"] : -1;
    $activo = isset($config["activo"]) ? $config["activo"] : -1;
    $in_ids = isset($config["in_ids"]) ? $config["in_ids"] : "";
		$offset = isset($config["offset"]) ? $config["offset"] : 10;
		$order = isset($config["order"]) ? $config["order"] : "U.nombre ASC ";
    $order = trim($order);
    if (empty($order)) $order = "U.nombre ASC ";

		$sql = "SELECT SQL_CALC_FOUND_ROWS U.*, ";
    $sql.= " IF(E.destacado IS NULL,0,E.destacado) AS destacado, ";
    $sql.= " IF(S.nombre IS NULL,'',S.nombre) AS sucursal, ";
    $sql.= " IF(F.nombre IS NULL,'',F.nombre) AS perfil ";
		$sql.= "FROM com_usuarios U ";
    $sql.= "LEFT JOIN com_usuarios_extension E ON (U.id_empresa = E.id_empresa AND U.id = E.id_usuario) ";
		$sql.= "LEFT JOIN com_perfiles F ON (U.id_perfiles = F.id AND U.id_empresa = F.id_empresa) ";
    $sql.= "LEFT JOIN almacenes S ON (S.id_empresa = U.id_empresa AND S.id = U.id_sucursal) ";
		$sql.= "WHERE U.id_empresa = $id_empresa ";
		if (!empty($filter)) $sql.= "AND U.nombre LIKE '%$filter%' ";
    if (!empty($id_sucursal)) $sql.= "AND U.id_sucursal = $id_sucursal ";
    if (!empty($id_perfil)) $sql.= "AND U.id_perfiles = $id_perfil ";
    if (!empty($in_ids)) $sql.= "AND U.id IN ($in_ids) ";
    if ($aparece_web != -1) $sql.= "AND U.aparece_web = $aparece_web ";
    if ($activo != -1) $sql.= "AND U.activo = $activo ";
		if ($admin == 1) $sql.= "AND U.admin = $admin ";
		$sql.= "ORDER BY $order ";
		$sql.= "LIMIT $limit, $offset ";
		$query = $this->db->query($sql);

    $q_total = $this->db->query("SELECT FOUND_ROWS() AS total");
    $total = $q_total->row();
    $this->total = $total->total;

		$result = $query->result();

    if ($buscar_horarios == 1) {
      foreach($result as $row) {
        $row->horarios = array();
        $row->horarios_entrega = array();
        // Obtenemos los horarios
        $sql = "SELECT AI.* ";
        $sql.= "FROM com_usuarios_horarios AI ";
        $sql.= "WHERE AI.id_usuario = $row->id AND AI.id_empresa = $row->id_empresa ";
        $sql.= "ORDER BY AI.dia ASC";
        $q = $this->db->query($sql);
        foreach($q->result() as $r) {
          if ($r->tipo == 1) $row->horarios_entrega[] = $r;
          else $row->horarios[] = $r;
        }
      }
    }

    foreach($result as $row) {
      // Obtenemos los datos guardados en la tabla de extension
      $row->solo_usuario = 0;
      $row->destacado = 0;
      $row->path_2 = "";
      $row->clave_especial = "";
      $row->instagram = "";
      $row->facebook = "";
      $row->linkedin = "";
      $row->custom_1 = "";
      $row->custom_2 = "";
      $row->custom_3 = "";
      $row->custom_4 = "";
      $row->custom_5 = "";
      $row->custom_6 = "";
      $row->custom_7 = "";
      $row->custom_8 = "";
      $row->custom_9 = "";
      $row->custom_10 = "";
      if ($this->db->table_exists('com_usuarios_extension')) {
        $sql = "SELECT * FROM com_usuarios_extension WHERE id_empresa = $row->id_empresa AND id_usuario = $row->id ";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
          $rr = $q->row();
          $row->solo_usuario = $rr->solo_usuario;
          $row->destacado = $rr->destacado;
          $row->path_2 = $rr->path_2;
          $row->clave_especial = $rr->clave_especial;
          $row->instagram = $rr->instagram;
          $row->facebook = $rr->facebook;
          $row->linkedin = $rr->linkedin;
          $row->custom_1 = $rr->custom_1;
          $row->custom_2 = $rr->custom_2;
          $row->custom_3 = $rr->custom_3;
          $row->custom_4 = $rr->custom_4;
          $row->custom_5 = $rr->custom_5;
          $row->custom_6 = $rr->custom_6;
          $row->custom_7 = $rr->custom_7;
          $row->custom_8 = $rr->custom_8;
          $row->custom_9 = $rr->custom_9;
          $row->custom_10 = $rr->custom_10;
        }
      }
    }

		$this->db->close();
		return $result;
	}

  function get_total_results() {
    return $this->total;
  }

  function get_by_email($email,$config = array()) {
    $id_empresa = (isset($config["id_empresa"])) ? $config["id_empresa"] : 0;
    $sql = "SELECT id, id_empresa ";
    $sql.= "FROM com_usuarios C ";
    $sql.= "WHERE C.email = '$email' ";
    if (!empty($id_empresa)) $sql.= "AND C.id_empresa = $id_empresa ";
    $query = $this->db->query($sql);
    if ($query->num_rows() == 0) return FALSE;
    $row = $query->row(); 
    return $this->get($row->id,array(
      "id_empresa"=>$row->id_empresa,
    ));
  } 
    
	function get($id,$config = array()) {
		$id_empresa = (isset($config["id_empresa"])) ? $config["id_empresa"] : $this->get_empresa();
		$sql = "SELECT U.*, IF(F.nombre IS NULL,'',F.nombre) AS perfil ";
		$sql.= "FROM com_usuarios U ";
		$sql.= "LEFT JOIN com_perfiles F ON (U.id_perfiles = F.id) ";
		$sql.= "WHERE U.id = $id AND U.id_empresa = $id_empresa ";
		$query = $this->db->query($sql);
		$row = $query->row();

    if ($row !== FALSE) {

      // Obtenemos los datos guardados en la tabla de extension
      $row->solo_usuario = 0;
      $row->destacado = 0;
      $row->path_2 = "";
      $row->clave_especial = "";
      $row->instagram = "";
      $row->facebook = "";
      $row->linkedin = "";
      $row->custom_1 = "";
      $row->custom_2 = "";
      $row->custom_3 = "";
      $row->custom_4 = "";
      $row->custom_5 = "";
      $row->custom_6 = "";
      $row->custom_7 = "";
      $row->custom_8 = "";
      $row->custom_9 = "";
      $row->custom_10 = "";
      if ($this->db->table_exists('com_usuarios_extension')) {
        $sql = "SELECT * FROM com_usuarios_extension WHERE id_empresa = $row->id_empresa AND id_usuario = $row->id ";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
          $rr = $q->row();
          $row->solo_usuario = $rr->solo_usuario;
          $row->destacado = $rr->destacado;
          $row->path_2 = $rr->path_2;
          $row->clave_especial = $rr->clave_especial;
          $row->instagram = $rr->instagram;
          $row->facebook = $rr->facebook;
          $row->linkedin = $rr->linkedin;
          $row->custom_1 = $rr->custom_1;
          $row->custom_2 = $rr->custom_2;
          $row->custom_3 = $rr->custom_3;
          $row->custom_4 = $rr->custom_4;
          $row->custom_5 = $rr->custom_5;
          $row->custom_6 = $rr->custom_6;
          $row->custom_7 = $rr->custom_7;
          $row->custom_8 = $rr->custom_8;
          $row->custom_9 = $rr->custom_9;
          $row->custom_10 = $rr->custom_10;
        }
      }

      // Obtenemos los horarios
      $sql = "SELECT AI.* ";
      $sql.= "FROM com_usuarios_horarios AI ";
      $sql.= "WHERE AI.id_usuario = $id AND AI.id_empresa = $row->id_empresa ";
      $sql.= "ORDER BY AI.dia ASC";
      $q = $this->db->query($sql);
      $row->horarios = array();
      $row->horarios_entrega = array();
      foreach($q->result() as $r) {
        if ($r->tipo == 1) $row->horarios_entrega[] = $r;
        else $row->horarios[] = $r;
      }

      $row->images = array();
      if ($this->db->table_exists('com_usuarios_images')) {
        $sql = "SELECT AI.* FROM com_usuarios_images AI WHERE AI.id_usuario = $id AND AI.id_empresa = $row->id_empresa ORDER BY AI.orden ASC";
        $q = $this->db->query($sql);
        $row->images = array();
        foreach($q->result() as $r) {
          $row->images[] = $r->path;
        }
      }

      // Obtenemos las sucursales
      $row->sucursales = array();
      if ($this->db->table_exists('com_usuarios_sucursales')) {
        $sql = "SELECT AI.id_sucursal, ALM.nombre ";
        $sql.= "FROM com_usuarios_sucursales AI ";
        $sql.= "INNER JOIN almacenes ALM ON (AI.id_sucursal = ALM.id AND AI.id_empresa = ALM.id_empresa) ";
        $sql.= "WHERE AI.id_usuario = $id AND AI.id_empresa = $row->id_empresa";
        $q = $this->db->query($sql);
        foreach($q->result() as $r) {
          $row->sucursales[] = $r;
        }
      }      

      $row->toque_categorias = array();
      if ($this->db->table_exists('toque_categorias_usuarios')) {
        $sql = "SELECT id_categoria AS id FROM toque_categorias_usuarios WHERE id_usuario = $row->id AND id_empresa = $row->id_empresa ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
          $row->toque_categorias = $query->result();        
        }
      }

      $row->obras_sociales = array();
      if (($row->id_empresa == 1245 || $row->id_empresa == 1319) && $this->db->table_exists('profesionales_obras_sociales')) {
        $sql = "SELECT id_obra_social AS id FROM profesionales_obras_sociales WHERE id_usuario = $row->id AND id_empresa = $row->id_empresa ";
        $query = $this->db->query($sql);
        $row->obras_sociales = $query->result();        
      }
      $row->especialidades = array();
      if (($row->id_empresa == 1245 || $row->id_empresa == 1319) && $this->db->table_exists('profesionales_especialidades')) {
        $sql = "SELECT id_especialidad AS id FROM profesionales_especialidades WHERE id_usuario = $row->id AND id_empresa = $row->id_empresa ";
        $query = $this->db->query($sql);
        $row->especialidades = $query->result();        
      }
      $row->tipos_pacientes = array();
      if (($row->id_empresa == 1245 || $row->id_empresa == 1319) && $this->db->table_exists('profesionales_tipos_pacientes')) {
        $sql = "SELECT id_tipo_paciente AS id FROM profesionales_tipos_pacientes WHERE id_usuario = $row->id AND id_empresa = $row->id_empresa ";
        $query = $this->db->query($sql);
        $row->tipos_pacientes = $query->result();        
      }
      $row->tipos_atenciones = array();
      if (($row->id_empresa == 1245 || $row->id_empresa == 1319) && $this->db->table_exists('profesionales_tipos_atenciones')) {
        $sql = "SELECT id_tipo_atencion AS id FROM profesionales_tipos_atenciones WHERE id_usuario = $row->id AND id_empresa = $row->id_empresa ";
        $query = $this->db->query($sql);
        $row->tipos_atenciones = $query->result();        
      }
      $row->tipos_terapias = array();
      if (($row->id_empresa == 1245 || $row->id_empresa == 1319) && $this->db->table_exists('profesionales_tipos_terapias')) {
        $sql = "SELECT id_tipo_terapia AS id FROM profesionales_tipos_terapias WHERE id_usuario = $row->id AND id_empresa = $row->id_empresa ";
        $query = $this->db->query($sql);
        $row->tipos_terapias = $query->result();        
      }
      $row->titulos = array();
      if (($row->id_empresa == 1245 || $row->id_empresa == 1319) && $this->db->table_exists('profesionales_titulos')) {
        $sql = "SELECT id_titulo AS id FROM profesionales_titulos WHERE id_usuario = $row->id AND id_empresa = $row->id_empresa ";
        $query = $this->db->query($sql);
        $row->titulos = $query->result();        
      }
      $row->formas_pago = array();
      if (($row->id_empresa == 1245 || $row->id_empresa == 1319) && $this->db->table_exists('profesionales_formas_pago')) {
        $sql = "SELECT id_forma_pago AS id FROM profesionales_formas_pago WHERE id_usuario = $row->id AND id_empresa = $row->id_empresa ";
        $query = $this->db->query($sql);
        $row->formas_pago = $query->result();        
      }

      $row->direcciones = array();
      if (($row->id_empresa == 1245 || $row->id_empresa == 1319)) {
        $this->load->model("Turno_Servicio_Model");
        $row->direcciones = $this->Turno_Servicio_Model->buscar(array(
          "offset"=>99999,
          "id_empresa"=>$row->id_empresa,
          "id_usuario"=>$row->id,
        ))["results"];
      }

    }

		$this->db->close();
		return $row;
	}
	
	function save($data) {

    if ($data->id == 0) {
      $data->fecha_alta = date("Y-m-d H:i:s");
      $data->last_update = time();      
    }
		unset($data->perfil);
		$data->id_empresa = $this->get_empresa();
    $data->last_update = time();
    $horarios = (isset($data->horarios)) ? $data->horarios : array();
    $horarios_entrega = (isset($data->horarios_entrega)) ? $data->horarios_entrega : array();
    $sucursales = (isset($data->sucursales)) ? $data->sucursales : array();
    $toque_categorias = (isset($data->toque_categorias)) ? $data->toque_categorias : array();
    $obras_sociales = (isset($data->obras_sociales)) ? $data->obras_sociales : array();
    $especialidades = (isset($data->especialidades)) ? $data->especialidades : array();
    $tipos_pacientes = (isset($data->tipos_pacientes)) ? $data->tipos_pacientes : array();
    $tipos_atenciones = (isset($data->tipos_atenciones)) ? $data->tipos_atenciones : array();
    $tipos_terapias = (isset($data->tipos_terapias)) ? $data->tipos_terapias : array();
    $titulos = (isset($data->titulos)) ? $data->titulos : array();
    $formas_pago = (isset($data->formas_pago)) ? $data->formas_pago : array();
    $direcciones = (isset($data->direcciones)) ? $data->direcciones : array();
    $images = (isset($data->images)) ? $data->images : array();
    unset($data->horarios);
    unset($data->horarios_entrega);
    unset($data->sucursales);
    unset($data->toque_categorias);
    unset($data->obras_sociales);
    unset($data->especialidades);
    unset($data->tipos_pacientes);
    unset($data->tipos_atenciones);
    unset($data->tipos_terapias);
    unset($data->titulos);
    unset($data->formas_pago);
    unset($data->direcciones);
    unset($data->images);

    // Estos datos se guardan en otra tabla
    $solo_usuario = (isset($data->solo_usuario)) ? $data->solo_usuario : 0;
    $path_2 = (isset($data->path_2)) ? $data->path_2 : "";
    $clave_especial = (isset($data->clave_especial)) ? $data->clave_especial : "";
    $destacado = (isset($data->destacado)) ? $data->destacado : 0;
    $instagram = (isset($data->instagram)) ? $data->instagram : "";
    $facebook = (isset($data->facebook)) ? $data->facebook : "";
    $linkedin = (isset($data->linkedin)) ? $data->linkedin : "";
    $custom_1 = (isset($data->custom_1)) ? $data->custom_1 : "";
    $custom_2 = (isset($data->custom_2)) ? $data->custom_2 : "";
    $custom_3 = (isset($data->custom_3)) ? $data->custom_3 : "";
    $custom_4 = (isset($data->custom_4)) ? $data->custom_4 : "";
    $custom_5 = (isset($data->custom_5)) ? $data->custom_5 : "";
    $custom_6 = (isset($data->custom_6)) ? $data->custom_6 : "";
    $custom_7 = (isset($data->custom_7)) ? $data->custom_7 : "";
    $custom_8 = (isset($data->custom_8)) ? $data->custom_8 : "";
    $custom_9 = (isset($data->custom_9)) ? $data->custom_9 : "";
    $custom_10 = (isset($data->custom_10)) ? $data->custom_10 : "";

    if ($data->id_empresa == 1284) {
      $data->celular = str_replace("+549", "", $data->celular);
      $data->celular = str_replace("+54", "", $data->celular);
    }

    $id = parent::save($data);

    // Guardamos lo que seria el link
    if ($data->id_empresa == 1234 || $data->id_empresa == 571 || $data->id_empresa == 1245 || $data->id_empresa == 1319) {
      $this->load->helper("file_helper");
      $link = filename($data->nombre,"-",0);
      $data->apellido = $link;
      $this->db->query("UPDATE com_usuarios SET apellido = '$data->apellido' WHERE id = $id AND id_empresa = $data->id_empresa ");
    }

    $this->save_extension(array(
      "id_usuario"=>$id,
      "id_empresa"=>$data->id_empresa,
      "solo_usuario"=>$solo_usuario,
      "path_2"=>$path_2,
      "clave_especial"=>$clave_especial,
      "destacado"=>$destacado,
      "instagram"=>$instagram,
      "facebook"=>$facebook,
      "linkedin"=>$linkedin,
      "custom_1"=>$custom_1,
      "custom_2"=>$custom_2,
      "custom_3"=>$custom_3,
      "custom_4"=>$custom_4,
      "custom_5"=>$custom_5,
      "custom_6"=>$custom_6,
      "custom_7"=>$custom_7,
      "custom_8"=>$custom_8,
      "custom_9"=>$custom_9,
      "custom_10"=>$custom_10,
    ));

    $minimo = "23:59:00";
    $maximo = "00:00:00";

    $this->db->query("DELETE FROM com_usuarios_horarios WHERE id_usuario = $id AND id_empresa = $data->id_empresa AND tipo = 0 ");
    foreach($horarios as $item) {
      $sql = "INSERT INTO com_usuarios_horarios (id_empresa,id_usuario,dia,desde,hasta,tipo";
      $sql.= ") VALUES ($data->id_empresa,$id,'$item->dia','$item->desde','$item->hasta',0) ";
      $this->db->query($sql);
    }

    $this->db->query("DELETE FROM com_usuarios_horarios WHERE id_usuario = $id AND id_empresa = $data->id_empresa AND tipo = 1 ");
    foreach($horarios_entrega as $item) {
      $sql = "INSERT INTO com_usuarios_horarios (id_empresa,id_usuario,dia,desde,hasta,tipo";
      $sql.= ") VALUES ($data->id_empresa,$id,'$item->dia','$item->desde','$item->hasta',1) ";
      $this->db->query($sql);
    }

    $this->db->query("DELETE FROM com_usuarios_sucursales WHERE id_usuario = $id AND id_empresa = $data->id_empresa ");
    foreach($sucursales as $id_sucursal) {
      $sql = "INSERT INTO com_usuarios_sucursales (id_empresa,id_usuario,id_sucursal";
      $sql.= ") VALUES ($data->id_empresa,$id,'$id_sucursal') ";
      $this->db->query($sql);
    }

    if ($this->db->table_exists('toque_categorias_usuarios')) {
      $this->db->query("DELETE FROM toque_categorias_usuarios WHERE id_usuario = $id AND id_empresa = $data->id_empresa ");
      $i=0;
      foreach($toque_categorias as $cat) {
        $sql = "INSERT INTO toque_categorias_usuarios (id_usuario,id_categoria,orden,id_empresa";
        $sql.= ") VALUES ($id,$cat,$i,$data->id_empresa) ";
        $this->db->query($sql);
        $i++;
      }
    }

    if ($data->id_empresa == 1245 || $data->id_empresa == 1319) {

      if ($this->db->table_exists('profesionales_obras_sociales')) {
        $this->db->query("DELETE FROM profesionales_obras_sociales WHERE id_usuario = $id AND id_empresa = $data->id_empresa ");
        $i=0;
        foreach($obras_sociales as $cat) {
          $sql = "INSERT INTO profesionales_obras_sociales (id_usuario,id_obra_social,orden,id_empresa";
          $sql.= ") VALUES ($id,$cat,$i,$data->id_empresa) ";
          $this->db->query($sql);
          $i++;
        }
      }

      if ($this->db->table_exists('profesionales_especialidades')) {
        $this->db->query("DELETE FROM profesionales_especialidades WHERE id_usuario = $id AND id_empresa = $data->id_empresa ");
        $i=0;
        foreach($especialidades as $cat) {
          $sql = "INSERT INTO profesionales_especialidades (id_usuario,id_especialidad,orden,id_empresa";
          $sql.= ") VALUES ($id,$cat,$i,$data->id_empresa) ";
          $this->db->query($sql);
          $i++;
        }
      }

      if ($this->db->table_exists('profesionales_tipos_pacientes')) {
        $this->db->query("DELETE FROM profesionales_tipos_pacientes WHERE id_usuario = $id AND id_empresa = $data->id_empresa ");
        $i=0;
        foreach($tipos_pacientes as $cat) {
          $sql = "INSERT INTO profesionales_tipos_pacientes (id_usuario,id_tipo_paciente,orden,id_empresa";
          $sql.= ") VALUES ($id,$cat,$i,$data->id_empresa) ";
          $this->db->query($sql);
          $i++;
        }
      }

      if ($this->db->table_exists('profesionales_tipos_terapias')) {
        $this->db->query("DELETE FROM profesionales_tipos_terapias WHERE id_usuario = $id AND id_empresa = $data->id_empresa ");
        $i=0;
        foreach($tipos_terapias as $cat) {
          $sql = "INSERT INTO profesionales_tipos_terapias (id_usuario,id_tipo_terapia,orden,id_empresa";
          $sql.= ") VALUES ($id,$cat,$i,$data->id_empresa) ";
          $this->db->query($sql);
          $i++;
        }
      }

      if ($this->db->table_exists('profesionales_tipos_atenciones')) {
        $this->db->query("DELETE FROM profesionales_tipos_atenciones WHERE id_usuario = $id AND id_empresa = $data->id_empresa ");
        $i=0;
        foreach($tipos_atenciones as $cat) {
          $sql = "INSERT INTO profesionales_tipos_atenciones (id_usuario,id_tipo_atencion,orden,id_empresa";
          $sql.= ") VALUES ($id,$cat,$i,$data->id_empresa) ";
          $this->db->query($sql);
          $i++;
        }
      }

      if ($this->db->table_exists('profesionales_titulos')) {
        $this->db->query("DELETE FROM profesionales_titulos WHERE id_usuario = $id AND id_empresa = $data->id_empresa ");
        $i=0;
        foreach($titulos as $cat) {
          $sql = "INSERT INTO profesionales_titulos (id_usuario,id_titulo,orden,id_empresa";
          $sql.= ") VALUES ($id,$cat,$i,$data->id_empresa) ";
          $this->db->query($sql);
          $i++;
        }
      }

      if ($this->db->table_exists('profesionales_formas_pago')) {
        $this->db->query("DELETE FROM profesionales_formas_pago WHERE id_usuario = $id AND id_empresa = $data->id_empresa ");
        $i=0;
        foreach($formas_pago as $cat) {
          $sql = "INSERT INTO profesionales_formas_pago (id_usuario,id_forma_pago,orden,id_empresa";
          $sql.= ") VALUES ($id,$cat,$i,$data->id_empresa) ";
          $this->db->query($sql);
          $i++;
        }
      }

      // Guardamos las direcciones
      $this->load->model("Turno_Servicio_Model");
      foreach($direcciones as $dir) {
        $dir->id_usuario = $id;
        if (isset($dir->nuevo) && $dir->nuevo == 1) unset($dir->id); // Si es nuevo borramos el ID para que lo inserte
        $this->Turno_Servicio_Model->save($dir);
      }

    }

    // Guardamos las imagenes
    if ($this->db->table_exists('com_usuarios_sucursales')) {
      $this->db->query("DELETE FROM com_usuarios_images WHERE id_usuario = $id AND id_empresa = $data->id_empresa");
      $k=0;
      foreach($images as $im) {
        $this->db->query("INSERT INTO com_usuarios_images (id_empresa,id_usuario,path,orden) VALUES($data->id_empresa,$id,'$im',$k)");
        $k++;
      }
    }

    return $id;
	}

  function save_extension($config = array()) {
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::id_empresa();
    $destacado = isset($config["destacado"]) ? $config["destacado"] : 0;
    $solo_usuario = isset($config["solo_usuario"]) ? $config["solo_usuario"] : 0;
    $path_2 = isset($config["path_2"]) ? $config["path_2"] : "";
    $clave_especial = isset($config["clave_especial"]) ? $config["clave_especial"] : "";
    $instagram = isset($config["instagram"]) ? $config["instagram"] : "";
    $facebook = isset($config["facebook"]) ? $config["facebook"] : "";
    $linkedin = isset($config["linkedin"]) ? $config["linkedin"] : "";
    $custom_1 = isset($config["custom_1"]) ? $config["custom_1"] : "";
    $custom_2 = isset($config["custom_2"]) ? $config["custom_2"] : "";
    $custom_3 = isset($config["custom_3"]) ? $config["custom_3"] : "";
    $custom_4 = isset($config["custom_4"]) ? $config["custom_4"] : "";
    $custom_5 = isset($config["custom_5"]) ? $config["custom_5"] : "";
    $custom_6 = isset($config["custom_6"]) ? $config["custom_6"] : "";
    $custom_7 = isset($config["custom_7"]) ? $config["custom_7"] : "";
    $custom_8 = isset($config["custom_8"]) ? $config["custom_8"] : "";
    $custom_9 = isset($config["custom_9"]) ? $config["custom_9"] : "";
    $custom_10 = isset($config["custom_10"]) ? $config["custom_10"] : "";
    $id  = $config["id_usuario"];

    if (!$this->db->table_exists('com_usuarios_extension')) return;

    $sql = "SELECT * FROM com_usuarios_extension WHERE id_empresa = $id_empresa AND id_usuario = $id ";
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
      $sql = "UPDATE com_usuarios_extension SET ";
      $sql.= "solo_usuario = '$solo_usuario', ";
      $sql.= "path_2 = '$path_2', ";
      $sql.= "clave_especial = '$clave_especial', ";
      $sql.= "instagram = '$instagram', ";
      $sql.= "facebook = '$facebook', ";
      $sql.= "linkedin = '$linkedin', ";
      $sql.= "custom_1 = '$custom_1', ";
      $sql.= "custom_2 = '$custom_2', ";
      $sql.= "custom_3 = '$custom_3', ";
      $sql.= "custom_4 = '$custom_4', ";
      $sql.= "custom_5 = '$custom_5', ";
      $sql.= "custom_6 = '$custom_6', ";
      $sql.= "custom_7 = '$custom_7', ";
      $sql.= "custom_8 = '$custom_8', ";
      $sql.= "custom_9 = '$custom_9', ";
      $sql.= "custom_10 = '$custom_10', ";
      $sql.= "destacado = '$destacado' ";
      $sql.= "WHERE id_empresa = $id_empresa AND id_usuario = $id ";
    } else {
      $sql = "INSERT INTO com_usuarios_extension ( ";
      $sql.= "id_usuario, id_empresa, solo_usuario,destacado,path_2,clave_especial, ";
      $sql.= "instagram, facebook, linkedin, custom_1, custom_2, custom_3, custom_4, custom_5, custom_6, custom_7, custom_8, custom_9, custom_10 ";
      $sql.= ") VALUES ($id, $id_empresa, '$solo_usuario','$destacado','$path_2','$clave_especial',";
      $sql.= "'$instagram', '$facebook', '$linkedin', '$custom_1', '$custom_2', '$custom_3', '$custom_4', '$custom_5', '$custom_6', '$custom_7', '$custom_8', '$custom_9', '$custom_10' ";
      $sql.= ") ";
    }
    $this->db->query($sql);
  }
	
}