<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Menu_Alquileres_Model extends Abstract_Model {
	
	function __construct() {
		parent::__construct("menu_alquileres","id");
	}

  function save($data) {
    
    $row = $this->get($data->id);
    //No tenemos resultados
    if ($row === FALSE || empty($row)) {
      $id = parent::insert($data);
    } else {
      $id = parent::save($data);
    }

    return $id;
  }
	
}