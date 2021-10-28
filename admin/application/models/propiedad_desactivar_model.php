<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Propiedad_Desactivar_Model extends Abstract_Model {
  
  function __construct() {
    parent::__construct("inm_propiedades_desactivadas","id","id DESC");
  }

  function save($data) {
  	$sql = "UPDATE inm_propiedades SET activo = 0, compartida = 0 WHERE id_empresa = '$data->id_empresa' AND id = '$data->id_propiedad' ";
  	$this->db->query($sql);
  	$data->fecha = date("Y-m-d H:i:s");
  	$id = parent::save($data);
  	return $id;
  }

}