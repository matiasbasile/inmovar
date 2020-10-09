<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Notificacion_Model extends Abstract_Model {
	
	function __construct() {
		parent::__construct("com_log","id");
	}

  function insertar($config = array()) {
    $id_empresa = (isset($config["id_empresa"])) ? $config["id_empresa"] : parent::get_empresa();
    $fecha = (isset($config["fecha"])) ? $config["fecha"] : date("Y-m-d H:i:s");
    $visto = (isset($config["visto"])) ? $config["visto"] : 0;
    $texto = (isset($config["texto"])) ? $config["texto"] : "";
    $titulo = (isset($config["titulo"])) ? $config["titulo"] : "";
    $importancia = (isset($config["importancia"])) ? $config["importancia"] : "N";
    $id_referencia = (isset($config["id_referencia"])) ? $config["id_referencia"] : 0;
    $link = (isset($config["link"])) ? $config["link"] : "";
    $sql = "INSERT INTO com_log (id_empresa, fecha, leida, texto, texto_2, link, importancia, id_referencia) VALUES (";
    $sql.= " '$id_empresa', '$fecha', '$visto', '$titulo', '$texto', '$link', '$importancia', '$id_referencia' ) ";
    $this->db->query($sql);
  }

	function buscar($config = array()) {
		$id_empresa = (isset($config["id_empresa"])) ? $config["id_empresa"] : parent::get_empresa();

		$lista = array();

    // Solicitudes Pendientes
    $sql = "SELECT E.*, WC.logo_1 AS path FROM inm_permisos_red PR INNER JOIN empresas E ON (PR.id_empresa = E.id) ";
    $sql.= " INNER JOIN web_configuracion WC ON (E.id = WC.id_empresa) ";
    $sql.= "WHERE PR.id_empresa_compartida = $id_empresa "; // Es al reves, la empresa compartida viene a ser la empresa que se esta consultado
    $sql.= "AND PR.solicitud_permiso = 1 "; // Si se envio la solicitud de permiso para publicar las propiedades
    $sql.= "AND PR.visto = 0 "; // Si no fue vista
    $sql.= "ORDER BY PR.id DESC ";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
      $r->titulo = $r->nombre;
      $r->tipo = 1; // Indica que es una solicitud
      $r->imagen = (!empty($r->path)) ? "/admin/".$r->path : "";
      $r->texto = "Solicita publicar tus propiedades en su sitio web";
      $lista[] = $r;
    }

    // Buscamos si hay alguna alertas de similitud
    $sql = "SELECT * FROM com_log WHERE id_empresa = $id_empresa AND importancia = 'W' AND leida = 0 ";
    $sql.= "ORDER BY fecha DESC ";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
      $r->titulo = $r->texto;
      $r->texto = $r->texto_2;
      $r->tipo = 2; // Notificacion de alerta de similitud
      $r->visto = $r->leida;
      $lista[] = $r;
    }

    // Buscamos si hay alguna notificacion normal
    $sql = "SELECT * FROM com_log WHERE id_empresa = $id_empresa AND importancia = 'N' AND leida = 0 ";
    $sql.= "ORDER BY fecha DESC ";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
      $r->titulo = $r->texto;
      $r->texto = $r->texto_2;
      $r->tipo = 3; // Notificacion normal
      $r->visto = $r->leida;
      $lista[] = $r;
    }

    // Aviso de nueva inmobiliaria
    $sql = "SELECT * FROM com_log WHERE id_empresa = $id_empresa AND importancia = 'B' AND leida = 0 ";
    $sql.= "ORDER BY fecha DESC ";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
      $r->titulo = $r->texto;
      $r->texto = $r->texto_2;
      $r->tipo = 4; // Bienvenido
      $r->visto = $r->leida;
      $lista[] = $r;
    }
    return array(
    	"results"=>$lista,
    	"total"=>sizeof($lista),
    );
	}
	
	function get_all($limit = null, $offset = null,$order_by = '',$order = '')  {
		$id_empresa = $this->get_empresa();
		$sql = "SELECT * FROM com_log WHERE id_empresa = $id_empresa AND importancia = 'N' ORDER BY fecha DESC";
		$query = $this->db->query($sql);
		$result = $query->result();
		$this->db->close();
		return $result;
	}	
	
}