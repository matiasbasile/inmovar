<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Planes extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Plan_Model', 'modelo');
    }
    
    function get_by_proyecto($id_proyecto) {
        $lista = $this->modelo->get_by_proyecto($id_proyecto);
        echo json_encode(array(
            "total"=> sizeof($lista),
            "results"=>$lista
        ));
    }
    
}