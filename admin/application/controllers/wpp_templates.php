<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Wpp_Templates extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Wpp_Templates_Model', 'modelo',"nombre ASC");
  }

    
}