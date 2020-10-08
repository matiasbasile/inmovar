<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Tutoriales extends REST_Controller {

  function __construct() {
    parent::__construct();
  }

  function buscar() {
    $id_modulo = parent::get_get("id_modulo",0);

    $lista = array(
      "id_modulo"=>"propiedades",
      "titulo"=>"Propiedades",
      "descripcion"=>"Lorep ipsum...",
      "videos"=>array(
        array(
          "id"=>1,
          "titulo"=>"Introducción",
          "descripcion"=>"Este es un video introductorio a la parte de propiedades.",
          "link"=>"https://www.youtube.com/watch?v=uLIs0j2WnlM",
        ),
        array(
          "id"=>2,
          "titulo"=>"Invitaciones",
          "descripcion"=>"Este es un video introductorio a la parte de propiedades 2.",
          "link"=>"https://www.youtube.com/watch?v=uLIs0j2WnlM",
        ),
      ),
    );

    echo json_encode(array(
      "results"=>$lista,
      "total"=>sizeof($lista),
    ));
  }

}