<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Consulta_Tipo_Model extends Abstract_Model {
	
	function __construct() {
		parent::__construct("crm_consultas_tipos","id","nombre ASC");
	}

  function save($data) {
    $data->nombre = ucwords(mb_strtolower($data->nombre));
    if ($data->id == -1) {
      $data->id = 0;
      $id = $this->insert($data);
    } else $id = $this->update($data->id,$data);
    return $id;
  }

  function insert($data) {
    $ultimo = 1;
    $sql = "SELECT IF(MAX(id) IS NULL,0,MAX(id)) AS ultimo FROM crm_consultas_tipos WHERE id_empresa = $data->id_empresa";
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
      $r = $q->row();
      $ultimo = intval($r->ultimo) + 1;      
    }
    $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,tiempo_proximo_estado, tiempo_vencimiento, activo,orden,id_email_template) VALUES (";
    $sql.= "$ultimo, $data->id_empresa, '$data->nombre', '$data->tiempo_proximo_estado', '$data->tiempo_vencimiento', '$data->activo', '$data->orden','$data->id_email_template' )";
    $this->db->query($sql);
    $id = $this->db->insert_id();
    return $id;
  }

  function crear_por_defecto($config = array()) {
    $id_empresa = $config["id_empresa"];
    $imprimir = (isset($config["imprimir"]) ? $config["imprimir"] : 0);
    $salida = "";

    $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,color,orden,activo) VALUES(";
    $sql.= "2,'$id_empresa','En Progreso','info',2,1)";
    if ($imprimir == 1) $salida.= $sql.";\n";
    else $this->db->query($sql);

    $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,color,orden,activo) VALUES(";
    $sql.= "1,'$id_empresa','A Contactar','warning',1,1)";
    if ($imprimir == 1) $salida.= $sql.";\n";
    else $this->db->query($sql);

    $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,color,orden,activo) VALUES(";
    $sql.= "0,'$id_empresa','Finalizado','success',3,1)";
    if ($imprimir == 1) $salida.= $sql.";\n";
    else $this->db->query($sql);

    $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,color,orden,activo) VALUES(";
    $sql.= "3,'$id_empresa','Abandonado','danger',4,1)";
    if ($imprimir == 1) $salida.= $sql.";\n";
    else $this->db->query($sql);

    return $salida;
  }

	function get($id,$config = array()) {
		$id_empresa = (isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa());
		$id = (int)$id;
		$sql = "SELECT R.* ";
		$sql.= "FROM crm_consultas_tipos R ";
		$sql.= "WHERE R.id = $id ";
		$sql.= "AND R.id_empresa = $id_empresa ";
		$q = $this->db->query($sql);
		if ($q->num_rows() == 0) return array();
		$row = $q->row();
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
	
	// Reordena los elementos del arbol
	function reorder($elements,$orden = 0, $id_padre = 0) {
		$id_empresa = parent::get_empresa();

		if (isset($elements["id"])) {
			$id = $elements["id"];
			if (!empty($id)) {
				$sql = "UPDATE crm_consultas_tipos SET orden = $orden ";
				$sql.= "WHERE id = $id AND id_empresa = $id_empresa ";
				$this->db->query($sql);				
			}
		}
		if (isset($elements["children"]) && is_array($elements["children"])){
			for($i=0;$i<sizeof($elements["children"]);$i++) {
				$e = $elements["children"][$i];
				$this->reorder($e,$i,$id);
			}
		}
	}
	
}