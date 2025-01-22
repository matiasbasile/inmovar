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
    $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,tiempo_abandonado, tiempo_vencimiento, activo,orden,id_email_template) VALUES (";
    $sql.= "$ultimo, $data->id_empresa, '$data->nombre', '$data->tiempo_abandonado', '$data->tiempo_vencimiento', '$data->activo', '$data->orden','$data->id_email_template' )";
    $this->db->query($sql);
    $id = $this->db->insert_id();
    return $id;
  }

  function crear_por_defecto($config = array()) {
    $id_empresa = $config["id_empresa"];
    $imprimir = (isset($config["imprimir"]) ? $config["imprimir"] : 0);
    $salida = "";
    $id_asunto = 0;

    // A Contactar
    $sql = "SELECT * FROM crm_consultas_tipos WHERE id_empresa = $id_empresa AND id = 1";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) {
      $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,color,orden,activo,tiempo_vencimiento,tiempo_abandonado) VALUES(";
      $sql.= "1,'$id_empresa','A contactar','warning',1,1,7,30)";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    } else {
      $sql = "UPDATE crm_consultas_tipos ";
      $sql.= "SET nombre = 'A contactar', orden = 1, activo = 1, tiempo_vencimiento = 7, tiempo_abandonado = 30 ";
      $sql.= "WHERE id_empresa = $id_empresa AND id = 1 ";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    }

    // Tasar
    $sql = "SELECT * FROM crm_consultas_tipos WHERE id_empresa = $id_empresa AND id = 70";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) {
      $sql = "INSERT INTO crm_consultas_tipos (id, id_empresa, nombre, color, orden, activo, tiempo_vencimiento) VALUES (70, '$id_empresa', 'Tasar', 'warning', 1, 1, 7)";
      if ($imprimir == 1) {
          $salida .= $sql . ";\n";
      } else {
          $this->db->query($sql);
      }
  } else {
      // Actualización del registro existente
      $sql = "UPDATE crm_consultas_tipos SET nombre = 'Tasar', orden = 1, activo = 1, tiempo_vencimiento = 7 WHERE id_empresa = '$id_empresa' AND id = 1";
      if ($imprimir == 1) {
          $salida .= $sql . ";\n";
      } else {
          $this->db->query($sql);
      }
  }

    // Contactado
    $sql = "SELECT * FROM crm_consultas_tipos WHERE id_empresa = $id_empresa AND id = 2";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) {
      $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,color,orden,activo,tiempo_vencimiento,tiempo_abandonado) VALUES(";
      $sql.= "2,'$id_empresa','Contactados','info',2,1,7,30)";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    } else {
      $sql = "UPDATE crm_consultas_tipos ";
      $sql.= "SET nombre = 'Contactados', orden = 2, activo = 1, tiempo_vencimiento = 7, tiempo_abandonado = 30 ";
      $sql.= "WHERE id_empresa = $id_empresa AND id = 2 ";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    }
    $asuntos = array(
      "Respondido por email",
      "Respondido por redes sociales",
      "Respondido por portales",
      "Respondido por teléfono",
      "Respondido personalmente",
    );
    for($i=0;$i<sizeof($asuntos);$i++) {
      $asunto = $asuntos[$i];
      $id_asunto++;
      $sql = "SELECT * FROM crm_asuntos WHERE id_empresa = $id_empresa AND id = $id_asunto";
      $q1 = $this->db->query($sql);
      if ($q1->num_rows() == 0) {
        $sql = "INSERT INTO crm_asuntos (id,id_empresa,nombre,orden,activo,id_tipo) VALUES(";
        $sql.= "$id_asunto,'$id_empresa','".$asunto."',$id_asunto,1,2)";
        if ($imprimir == 1) $salida.= $sql.";\n";
        else $this->db->query($sql);
      }
    }

    // Actividad Programada
    $sql = "SELECT * FROM crm_consultas_tipos WHERE id_empresa = $id_empresa AND id = 3";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) {    
      $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,color,orden,activo,tiempo_vencimiento,tiempo_abandonado) VALUES(";
      $sql.= "3,'$id_empresa','Con actividad','info',3,1,7,30)";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    } else {
      $sql = "UPDATE crm_consultas_tipos ";
      $sql.= "SET nombre = 'Con actividad', orden = 3, activo = 1, tiempo_vencimiento = 7, tiempo_abandonado = 30 ";
      $sql.= "WHERE id_empresa = $id_empresa AND id = 3";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    }
    $asuntos = array(
      "Teléfono",
      "Reunión",
      "Visita",
      "Videollamada",
    );
    for($i=0;$i<sizeof($asuntos);$i++) {
      $asunto = $asuntos[$i];
      $id_asunto++;
      $sql = "SELECT * FROM crm_asuntos WHERE id_empresa = $id_empresa AND id = $id_asunto";
      $q1 = $this->db->query($sql);
      if ($q1->num_rows() == 0) {      
        $sql = "INSERT INTO crm_asuntos (id,id_empresa,nombre,orden,activo,id_tipo) VALUES(";
        $sql.= "$id_asunto,'$id_empresa','".$asunto."',$id_asunto,1,3)";
        if ($imprimir == 1) $salida.= $sql.";\n";
        else $this->db->query($sql);
      }
    }

    // En negociacion
    $sql = "SELECT * FROM crm_consultas_tipos WHERE id_empresa = $id_empresa AND id = 4";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) {
      $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,color,orden,activo,tiempo_vencimiento,tiempo_abandonado) VALUES(";
      $sql.= "4,'$id_empresa','En negociación','success',4,1,7,30)";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    } else {
      $sql = "UPDATE crm_consultas_tipos ";
      $sql.= "SET nombre = 'En negociación', orden = 4, activo = 1, tiempo_vencimiento = 7, tiempo_abandonado = 30 ";
      $sql.= "WHERE id_empresa = $id_empresa AND id = 4";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    }
    $asuntos = array(
      "Listo para firmar",
      "Esperando entrega y/o reserva",
    );
    for($i=0;$i<sizeof($asuntos);$i++) {
      $asunto = $asuntos[$i];
      $id_asunto++;
      $sql = "SELECT * FROM crm_asuntos WHERE id_empresa = $id_empresa AND id = $id_asunto";
      $q1 = $this->db->query($sql);
      if ($q1->num_rows() == 0) {      
        $sql = "INSERT INTO crm_asuntos (id,id_empresa,nombre,orden,activo,id_tipo) VALUES(";
        $sql.= "$id_asunto,'$id_empresa','".$asunto."',$id_asunto,1,4)";
        if ($imprimir == 1) $salida.= $sql.";\n";
        else $this->db->query($sql);
      }
    }

    // Finalizado
    $sql = "SELECT * FROM crm_consultas_tipos WHERE id_empresa = $id_empresa AND id = 98";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) {    
      $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,color,orden,activo,tiempo_vencimiento,tiempo_abandonado) VALUES(";
      $sql.= "98,'$id_empresa','Finalizados','success',98,1,0,0)";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    } else {
      $sql = "UPDATE crm_consultas_tipos ";
      $sql.= "SET nombre = 'Finalizados', orden = 98, activo = 1, tiempo_vencimiento = 7, tiempo_abandonado = 30 ";
      $sql.= "WHERE id_empresa = $id_empresa AND id = 98";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    }
    $asuntos = array(
      "Se concretó la operación correctamente",
    );
    for($i=0;$i<sizeof($asuntos);$i++) {
      $asunto = $asuntos[$i];
      $id_asunto++;
      $sql = "SELECT * FROM crm_asuntos WHERE id_empresa = $id_empresa AND id = $id_asunto";
      $q1 = $this->db->query($sql);
      if ($q1->num_rows() == 0) {      
        $sql = "INSERT INTO crm_asuntos (id,id_empresa,nombre,orden,activo,id_tipo) VALUES(";
        $sql.= "$id_asunto,'$id_empresa','".$asunto."',$id_asunto,1,98)";
        if ($imprimir == 1) $salida.= $sql.";\n";
        else $this->db->query($sql);
      }
    }    

    // Archivada
    $sql = "SELECT * FROM crm_consultas_tipos WHERE id_empresa = $id_empresa AND id = 99";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) {    
      $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,color,orden,activo,tiempo_vencimiento,tiempo_abandonado) VALUES(";
      $sql.= "99,'$id_empresa','Archivados','danger',99,1,0,0)";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    } else {
      $sql = "UPDATE crm_consultas_tipos ";
      $sql.= "SET nombre = 'Archivados', orden = 99, activo = 1, tiempo_vencimiento = 7, tiempo_abandonado = 30 ";
      $sql.= "WHERE id_empresa = $id_empresa AND id = 99";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    }
    $asuntos = array(
      "Volver a contactar más adelante",
      "No respondió el cliente",
      "El cliente no está interesado",
      "Los datos de contacto del cliente son erróneos",
    );
    for($i=0;$i<sizeof($asuntos);$i++) {
      $asunto = $asuntos[$i];
      $id_asunto++;
      $sql = "SELECT * FROM crm_asuntos WHERE id_empresa = $id_empresa AND id = $id_asunto";
      $q1 = $this->db->query($sql);
      if ($q1->num_rows() == 0) {      
        $sql = "INSERT INTO crm_asuntos (id,id_empresa,nombre,orden,activo,id_tipo) VALUES(";
        $sql.= "$id_asunto,'$id_empresa','".$asunto."',$id_asunto,1,99)";
        if ($imprimir == 1) $salida.= $sql.";\n";
        else $this->db->query($sql);
      }
    }

    // Tasacion
    $sql = "SELECT * FROM crm_consultas_tipos WHERE id_empresa = $id_empresa AND id = 7";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) {    
      $sql = "INSERT INTO crm_consultas_tipos (id,id_empresa,nombre,color,orden,activo,tiempo_vencimiento,tiempo_abandonado) VALUES(";
      $sql.= "7,'$id_empresa','Tasar','warning',3,1,7,7)";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    } else {
      $sql = "UPDATE crm_consultas_tipos ";
      $sql.= "SET nombre = 'Tasar', orden = 3, activo = 1, tiempo_vencimiento = 7, tiempo_abandonado = 7 ";
      $sql.= "WHERE id_empresa = $id_empresa AND id = 7";
      if ($imprimir == 1) $salida.= $sql.";\n";
      else $this->db->query($sql);
    }
    $asuntos = array(
      "Tasación",
    );
    for($i=0;$i<sizeof($asuntos);$i++) {
      $asunto = $asuntos[$i];
      $id_asunto++;
      $sql = "SELECT * FROM crm_asuntos WHERE id_empresa = $id_empresa AND id = $id_asunto";
      $q1 = $this->db->query($sql);
      if ($q1->num_rows() == 0) {      
        $sql = "INSERT INTO crm_asuntos (id,id_empresa,nombre,orden,activo,id_tipo) VALUES(";
        $sql.= "$id_asunto,'$id_empresa','".$asunto."',$id_asunto,1,7)";
        if ($imprimir == 1) $salida.= $sql.";\n";
        else $this->db->query($sql);
      }
    }

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