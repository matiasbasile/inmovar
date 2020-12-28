<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Propiedad_Visita_Model extends Abstract_Model {
  
  function __construct() {
    parent::__construct("inm_propiedades_visitas","id","stamp DESC",1);
  }

  function contar($config = array()) {
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $id_empresa_relacionada = isset($config["id_empresa_relacionada"]) ? $config["id_empresa_relacionada"] : 0;
    $desde = isset($config["desde"]) ? $config["desde"] : "";
    $hasta = isset($config["hasta"]) ? $config["hasta"] : "";
    $id_propiedad = isset($config["id_propiedad"]) ? $config["id_propiedad"] : 0;

    $sql = "SELECT IF(COUNT(*) IS NULL,0,COUNT(*)) AS total ";
    $sql.= "FROM inm_propiedades_visitas R ";
    $sql.= "WHERE 1=1 ";
    if (empty($id_empresa_relacionada)) $sql.= "AND R.id_empresa = $id_empresa ";
    if (!empty($desde)) $sql.= "AND R.stamp >= '$desde' ";
    if (!empty($hasta)) $sql.= "AND R.stamp <= '$hasta' ";
    if (!empty($id_empresa_relacionada)) $sql.= "AND R.id_empresa_propiedad = $id_empresa_relacionada ";
    if (!empty($id_propiedad)) $sql.= "AND R.id_propiedad = $id_propiedad ";
    $q = $this->db->query($sql);
    $r = $q->row();
    return $r->total;
  }

}