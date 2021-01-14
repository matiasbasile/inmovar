<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Alquileres_Cuotas_Extras extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Alquileres_Cuotas_Extras_Model', 'modelo');
    }
    
    function get_extras_by_cuotas(){
      $id_cuota = parent::get_post("id_cuota", 0);
      $id_empresa = parent::get_post("id_empresa", 0);
      $resultado = array();
      $sql = "SELECT * FROM inm_alquileres_cuotas_extras ";
      $sql.= "WHERE id_empresa = $id_empresa AND id_cuota = $id_cuota ";

      $q = $this->db->query($sql);
      foreach ($q->result() as $e) {
        $resultado[] = $e;
      }

      echo json_encode(array(
        "error"=>0,
        "results"=>$resultado,
      ));
    }
}