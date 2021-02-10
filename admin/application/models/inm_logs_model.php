<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Inm_Logs_Model extends Abstract_Model {
  
  function __construct() {
    parent::__construct("inm_logs","id","id DESC");
  }
    
  function find($filter) {
    $this->db->like("nombre",$filter);
    $query = $this->db->get($this->tabla);
    $result = $query->result();
    $this->db->close();
    return $result;
  }
  
  function get($id,$id_empresa=0) {
    if ($id_empresa == 0) $id_empresa = parent::get_empresa();
    $sql = "SELECT * FROM inm_logs ";
    $sql.= "WHERE id = '$id' AND id_empresa = $id_empresa ";
    $query = $this->db->query($sql);
    if ($query->num_rows() == 0) return FALSE;
    $row = $query->row(); 
    $this->db->close();
    return $row;
  }

  function guardar($params = array()){
    $id_empresa = isset($params["id_empresa"]) ? $params["id_empresa"] : parent::get_empresa();
    $id_usuario = isset($params["id_usuario"]) ? $params["id_usuario"] : 0;
    $usuario_nombre = isset($params["usuario_nombre"]) ? $params["usuario_nombre"] : "";
    $fecha = isset($params["fecha"]) ? $params["fecha"] : "0000-00-00 00:00:00";
    $comentario = isset($params["comentario"]) ? $params["comentario"] : "";
    $sql = "INSERT INTO inm_logs ";
    $sql.= "(id_empresa, id_usuario, operacion, fecha, comentario) VALUES ";
    $sql.= "($id_empresa, $id_usuario, '$operacion', '$fecha', '$comentario') ";
    $this->db->query($sql);
  }

  function buscar($conf = array()){
    $id_empresa = parent::get_empresa();
    $limit = isset($conf["limit"]) ? $conf["limit"] : 0;
    $offset = isset($conf["offset"]) ? $conf["offset"] : 10;
    $usuario = isset($conf["usuario"]) ? $conf["usuario"] : 0;
    $fecha_desde = isset($conf["fecha_desde"]) ? $conf["fecha_desde"] : "";//Que tome el inicio del día
    $fecha_hasta = isset($conf["fecha_hasta"]) ? $conf["fecha_hasta"]." 23:59:00" : "";//Que tome el final del día

    $sql = "SELECT SQL_CALC_FOUND_ROWS LT.* ";
    $sql.= "FROM inm_logs LT ";
    $sql.= "WHERE LT.id_empresa = $id_empresa ";
    if (!empty($operacion)) $sql.= "AND LT.operacion = '$operacion' ";
    if (!empty($usuario)) $sql.= "AND LT.id_usuario = '$usuario' ";
    if (!empty($fecha_desde) && !empty($fecha_hasta)) {
      $sql.= "AND LT.fecha >= '$fecha_desde' AND LT.fecha <= '$fecha_hasta' ";
    } 
    $sql.= "ORDER BY LT.fecha DESC ";
    $sql.= "LIMIT $limit, $offset ";
    $q = $this->db->query($sql);
    $q_total = $this->db->query("SELECT FOUND_ROWS() AS total");
    $total = $q_total->row();
    return array(
      "results"=>$q->result(),
      "total"=>$total->total,
    );
  }

}