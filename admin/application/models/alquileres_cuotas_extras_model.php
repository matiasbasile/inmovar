<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Alquileres_Cuotas_Extras_Model extends Abstract_Model {
  
  function __construct() {
    parent::__construct("inm_alquileres_cuotas_extras","id","id DESC");
  }

  function save($data){
    
    $sql = "DELETE FROM inm_alquileres_cuotas_extras WHERE id_empresa = $data->id_empresa AND id_cuota = $data->id_cuota AND id_alquiler = $data->id_alquiler";
    $this->db->query($sql);

    foreach ($data->extras as $e) {
      $sql = "INSERT INTO inm_alquileres_cuotas_extras ";
      $sql.= "(id_empresa, id_alquiler, id_cuota, monto, nombre) ";
      $sql.= "VALUES ($data->id_empresa, $data->id_alquiler, $data->id_cuota, $e->monto, '$e->nombre') ";
      $this->db->query($sql);
    }
  }

}