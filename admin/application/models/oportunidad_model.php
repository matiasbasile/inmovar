<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Oportunidad_Model extends Abstract_Model {
	
	function __construct() {
		parent::__construct("oportunidades","id","fecha DESC");
	}

}