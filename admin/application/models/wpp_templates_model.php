<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Wpp_Templates_Model extends Abstract_Model {
  
  function __construct() {
    parent::__construct("crm_wpp_templates","id","nombre ASC");
  }
    
  function find($filter) {
    $this->db->like("nombre",$filter);
    $query = $this->db->get($this->tabla);
    $result = $query->result();
    $this->db->close();
    return $result;
  }

  function get_by_key($clave,$id_empresa=0) {
    if ($id_empresa == 0) $id_empresa = parent::get_empresa();
    $sql = "SELECT * FROM crm_wpp_templates ";
    $sql.= "WHERE clave = '$clave' AND id_empresa = $id_empresa ";
    $query = $this->db->query($sql);
    if ($query->num_rows() == 0) return FALSE;
    $row = $query->row(); 
    $this->db->close();
    return $row;
  }
  
  function get($id,$id_empresa=0) {
    if ($id_empresa == 0) $id_empresa = parent::get_empresa();
    $sql = "SELECT * FROM crm_wpp_templates ";
    $sql.= "WHERE id = '$id' AND id_empresa = $id_empresa ";
    $query = $this->db->query($sql);
    if ($query->num_rows() == 0) return FALSE;
    $row = $query->row(); 
    $this->db->close();
    return $row;
  }
}