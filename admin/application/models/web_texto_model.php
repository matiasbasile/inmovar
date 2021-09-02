<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Web_Texto_Model extends Abstract_Model {
	
	function __construct() {
		parent::__construct("web_textos","id","id_web_template ASC",1);
	}
    
	function find($filter) {
		$this->db->like("titulo",$filter);
		$query = $this->db->get($this->tabla);
		$result = $query->result();
		$this->db->close();
		return $result;
	}

	function get($id) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$o = parent::get($id);
		if (empty($o)) {
			$o = new stdClass();
			$o->clave = "";
			$o->id = 0;
			$o->id_empresa = $this->get_empresa();
			$o->id_idioma = "";
			$o->id_web_template = "";
			$o->link = "";
			$o->texto = "";
			$o->texto_en = "";
			$o->texto_pt = "";
			$o->titulo = "";
		}
		return $o;
    if ($this->usa_id_empresa == 1) {
      $id_empresa = $this->get_empresa();
      $query = $this->db->get_where($this->tabla,array($this->ident=>$id,"id_empresa"=>$id_empresa));
    } else {
      $query = $this->db->get_where($this->tabla,array($this->ident=>$id));
    }
    $row = $query->row(); 
    $this->db->close();
    return $row;
  }
	
	function get_all($limit = null, $offset = null,$order_by = '',$order = '') {
		
		// Devuelve los textos que son del template (NO DE LAS EMPRESAS EN PARTICULAR)
		$sql = "SELECT T.*, TMP.nombre AS template ";
		$sql.= "FROM web_textos T INNER JOIN web_templates TMP ON (T.id_web_template = TMP.id) ";
		$sql.= "WHERE T.id_empresa = 0 ";
		if (!empty($order_by))
			$sql.= "ORDER BY $order_by $order ";
		if (!is_null($limit) && (strlen($limit)>0) && !is_null($offset) && (strlen($offset)>0))
			$sql.= "LIMIT $limit, $offset ";
		$query = $this->db->query($sql);
		$result = $query->result();
		$this->db->close();
		return $result;
	}

	// Cada vez que guardamos un texto en un template PUBLICO, tenemos que buscar todos las empresas
	// que tienen configurado ese template, y agregarle el campo para que lo puedan editar,
	// con los valores por defecto que se cargaron. En caso de que ya lo tengan, no se hace nada
	function post_save($id) {
		
		$texto = $this->get($id);
		
		// Si el template que estamos modificando las claves es PUBLICO
		$this->load->model("Web_Template_Model");
		$web_template = $this->Web_Template_Model->get($texto->id_web_template);
		if ($web_template->publico == 1) {
			
			// Seleccionamos las empresas que tienen ese template pero no tienen cargada esa clave
			/*
			$sql = "SELECT E.id FROM empresas E ";
			$sql.= "WHERE E.id_web_template = $texto->id_web_template ";
			$sql.= "AND NOT EXISTS (SELECT * FROM web_textos WHERE clave = '$texto->clave' AND id_empresa = E.id ) ";
			$q = $this->db->query($sql);
			
			foreach($q->result() as $r) {
				$sql = "INSERT INTO web_textos (id_empresa,clave,texto,titulo,id_web_template,texto_en,texto_pt) VALUES (";
				$sql.= "$r->id, '$texto->clave', '$texto->texto', '$texto->titulo', $texto->id_web_template,'$texto->texto_en','$texto->texto_pt' )";
				$this->db->query($sql);
			}	
			*/		
		}
		
	}
}