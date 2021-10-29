<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Novedades extends REST_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Novedades_Model', 'modelo');
	}

	function save_image($dir="",$filename="") {
	    $id_empresa = $this->get_empresa();
	    $dir = "uploads/novedades/";
	    $filename = $this->input->post("file");
	    $res = parent::save_image($dir,$filename);
	    echo $res;
	}

	function guardar_novedades() {
		$id_empresa = parent::get_post("id_empresa", parent::get_empresa());
		$id_usuario = parent::get_post("id_usuario", 0);
		$id_novedades = parent::get_post("id_novedades", array());

		$this->modelo->guardar_novedades(array(
			"id_empresa"=>$id_empresa,
			"id_usuario"=>$id_usuario,
			"novedades"=>$id_novedades,
		));
		echo json_encode(array(
			"error"=>0,
		));
	}
	
}