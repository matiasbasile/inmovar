<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once("abstract_model.php");

class Novedades_Model extends Abstract_Model {
	
	function __construct() {
		parent::__construct("novedades","id","id DESC", "0");
	}   

	function guardar_novedades($conf = array()) {
		$id_empresa = isset($conf['id_empresa']) ? $conf['id_empresa'] : parent::get_empresa();
		$novedades = isset($conf['novedades']) ? $conf['novedades'] : array();
		$id_usuario = isset($conf['id_usuario']) ? $conf['id_usuario'] : 0;
		$fecha = isset($conf['fecha']) ? $conf['fecha'] : date("Y-m-d H:i:s");

		foreach ($novedades as $n) {
			$sql = "INSERT INTO novedades_usuarios (id_novedad, id_usuario, id_empresa, fecha) ";
			$sql.= "VALUES ('$n', '$id_usuario', '$id_empresa', '$fecha') ";
			$this->db->query($sql);
		}

		return TRUE;
	}
}