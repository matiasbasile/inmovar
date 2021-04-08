<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Score extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Score_Model', 'modelo');
  }

  function prueba(){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ini_set('max_execution_time', 0);
    $a = $this->modelo->calcular(array(
      "id"=>270,
      "id_empresa"=>45,
      "debug"=>0,
    ));
    echo $a;  

  }

    
}