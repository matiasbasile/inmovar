<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Gasto_Model extends Abstract_Model {
  
  function __construct() {
    parent::__construct("inm_propiedades_gastos","id","id DESC");
  }

}