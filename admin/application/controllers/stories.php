<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Stories extends REST_Controller {

  function __construct() {
    parent::__construct();
    //$this->load->model('Story_Model', 'modelo');
  }

  function search() {
    $id_empresa = parent::get_empresa();
    $id_usuario = parent::get_get("id_usuario");
    $salida = array();
    $story = array(
      "id"=>1,
      "photo"=>"",
      "name"=>"",
      "link"=>"",
      "lastUpdate"=>date("Y-m-d H:i:s"),
      "seen"=>false,
      "items"=>array(
        array(
          "id"=>1,
          "type"=>"photo",
          "length"=>3,
          "src"=>"",
          "preview"=>"",
          "seen"=>false,
        )
      )
    );
    $salida["stories"] = array($story);
    echo json_encode($salida);
  }
  
}