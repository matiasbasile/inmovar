<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Oportunidad_Model extends Abstract_Model {
	
	function __construct() {
		parent::__construct("oportunidades","id","fecha DESC");
	}

	function save($data){
		$images = $data->images;
		unset ($data->images);
		$id = parent::save($data);
		foreach ($images as $i) {
			$sql = "INSERT INTO oportunidades_images (id_empresa, id_oportunidad, path) VALUES ";
			$sql.= "($data->id_empresa, $id, '$i') ";
			$this->db->query($sql);
		}
		return $id;
	}

	function buscar($conf = array()) {
		$salida = array();
		$id_empresa = (isset($conf["id_empresa"])) ? $conf["id_empresa"] : $this->get_empresa();
    	$limit = isset($conf["limit"]) ? $conf["limit"] : 0;
		$offset = isset($conf["offset"]) ? $conf["offset"] : 0;
    	$tipo = isset($conf["tipo"]) ? $conf["tipo"] : -1;
    	$sql = "SELECT SQL_CALC_FOUND_ROWS O.* ";
    	$sql.= "FROM oportunidades O ";
    	$sql.= "WHERE 1 = 1 ";
    	if ($tipo > -1) $sql.= "AND O.tipo = '$tipo'  AND O.id_empresa != '$id_empresa' ";
    	if ($tipo == -1) $sql.= "AND O.id_empresa = '$id_empresa' ";
    	if (!empty($offset)) $sql.= "LIMIT $limit, $offset ";
	    $q = $this->db->query($sql);
	    $q_total = $this->db->query("SELECT FOUND_ROWS() AS total");
	    $total = $q_total->row();

	    foreach ($q->result() as $o) {
	    	//$sql = "SELECT path FROM oportunidades_images WHERE id_empresa = '$o->id_empresa' AND id_oportunidad = '$o->id'";
	    	//$c = $this->db->query($sql);
	    	//$o->images = $c->result();
	    	$salida[] = $o;
	    }

    	$sql = "SELECT SQL_CALC_FOUND_ROWS O.* ";
    	$sql.= "FROM oportunidades O ";
    	$sql.= "WHERE O.tipo = '0' AND O.id_empresa != '$id_empresa' ";
    	$this->db->query($sql);
   	    $r_total = $this->db->query("SELECT FOUND_ROWS() AS total");
	    $t = $r_total->row();
	    $total_venta = $t->total;

    	$sql = "SELECT SQL_CALC_FOUND_ROWS O.* ";
    	$sql.= "FROM oportunidades O ";
    	$sql.= "WHERE O.tipo = '1' AND O.id_empresa != '$id_empresa' ";
    	$this->db->query($sql);
   	    $r_total = $this->db->query("SELECT FOUND_ROWS() AS total");
	    $t = $r_total->row();
	    $total_compras = $t->total;

    	$sql = "SELECT SQL_CALC_FOUND_ROWS O.* ";
    	$sql.= "FROM oportunidades O ";
    	$sql.= "WHERE O.id_empresa = '$id_empresa' ";
    	$this->db->query($sql);
   	    $r_total = $this->db->query("SELECT FOUND_ROWS() AS total");
	    $t = $r_total->row();
	    $total_mias = $t->total;

	    $ss = array(
	      "results"=>$salida,
	      "total"=>$total->total,
	      "meta"=>array(
	        "total_venta"=>$total_venta,
	        "total_compras"=>$total_compras,
	        "total_mias"=>$total_mias,
	      ),
	    );      
	    return $ss;

	}

}