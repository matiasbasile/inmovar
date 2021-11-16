<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Notificaciones extends REST_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Notificacion_Model', 'modelo');
	}

  // CONSULTA SI HAY NUEVAS NOTIFICACIONES PARA EL USUARIO
  function buscar() {
    $id_empresa = parent::get_empresa();
    $salida = $this->modelo->buscar();
    echo json_encode($salida);
  }  
	
	// LIMPIA LA NOTIFICACION
	function limpiar_notificacion() {
    $id_empresa = parent::get_empresa();
    $id = parent::get_post("id",0);
		$sql = "UPDATE com_log SET leida = 1 WHERE id_empresa = $id_empresa ";
    $sql.= "AND id = $id ";
		$this->db->query($sql);
		echo json_encode(array("error"=>0));
	}

	function prueba() {
		$this->load->library("Sendinblue");
    	$s = new Sendinblue();
    	$s->blue_send();
	}
	
}