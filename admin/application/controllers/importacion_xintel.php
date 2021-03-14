<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Importacion_Xintel extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Importacion_Xintel_Model', 'modelo',"id");
  }

  function importacion_xintel() {
    $this->modelo->importar_xintel();
  }  
    
}