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
      "photo"=>"https://app.inmovar.com/admin/uploads/1435/images622301690508.jpg",
      "name"=>"Autino Propiedades",
      "link"=>"",
      "lastUpdate"=>time(),
      "seen"=>false,
      "items"=>array(
        array(
          "id"=>1,
          "type"=>"photo",
          "length"=>3,
          "link"=>"",
          "linkText"=>"",
          "time"=>time(),
          "src"=>"https://app.inmovar.com/admin/uploads/1577/propiedades/img-20210301-wa0024.jpg?t=91489?t=6233?t=15190?t=4921",
          "preview"=>"https://app.inmovar.com/admin/uploads/1577/propiedades/img-20210301-wa0024.jpg?t=91489?t=6233?t=15190?t=4921",
          "seen"=>false,
        ),
        array(
          "id"=>2,
          "type"=>"photo",
          "length"=>3,
          "link"=>"",
          "linkText"=>"",
          "time"=>time(),
          "src"=>"https://app.inmovar.com/admin/uploads/1577/propiedades/img-20210226-wa0103.jpg?t=35907?t=76486?t=8427",
          "preview"=>"https://app.inmovar.com/admin/uploads/1577/propiedades/img-20210226-wa0103.jpg?t=35907?t=76486?t=8427",
          "seen"=>false,
        ),
      )
    );
    $salida["stories"] = array($story);
    echo json_encode($salida);
  }
  
}