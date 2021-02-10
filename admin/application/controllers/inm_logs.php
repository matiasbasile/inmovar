<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Inm_Logs extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Inm_Logs_Model', 'modelo',"id");
  }

  function get($id) {
    $id_empresa = parent::get_empresa();
    // Obtenemos el listado
    if ($id == "index") {
      $limit = parent::get_get("limit",0);
      $offset = parent::get_get("offset",10);
      $operacion = parent::get_get("operacion",'');
      $usuario = parent::get_get("usuario",0);
      $fecha_desde = parent::get_get("fecha_desde",'');
      $fecha_hasta = parent::get_get("fecha_hasta",'');
      $salida = $this->modelo->buscar(array(
        "limit"=>$limit,
        "offset"=>$offset,
        "operacion"=>$operacion,
        "usuario"=>$usuario,
        "fecha_desde"=>$fecha_desde,
        "fecha_hasta"=>$fecha_hasta,
      ));
      echo json_encode($salida);
    } else {
      $log = $this->modelo->get($id,$id_empresa);
      echo json_encode($log);
    }
  }  
    
}