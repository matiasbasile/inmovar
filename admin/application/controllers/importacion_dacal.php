<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Importacion_Dacal extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Importacion_Dacal_Model', 'modelo',"id");
  }

  function importacion_dacal() {
    $this->modelo->importar_dacal();
  }  
    
}