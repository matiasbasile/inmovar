<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Oportunidades extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Oportunidad_Model', 'modelo');
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

  }

  function get($id) {
    $id_empresa = parent::get_empresa();
    // Obtenemos el listado
    if ($id == "index") {
    	$limit = parent::get_get("limit", 0);
    	$offset = parent::get_get("offset", 10);
    	$tipo = parent::get_get("tipo", -1);
    	$r = $this->modelo->buscar(array(
    		"limit"=>$limit,
    		"offset"=>$offset,
    		"tipo"=>$tipo,
    		"id_empresa"=>$id_empresa,
    	));
	  	echo json_encode($r);
    } else {
     	$propiedad = $this->modelo->get($id, array("id_empresa"=>$id_empresa));
     	echo json_encode($propiedad);
    }
  }

}