<?php
class Profesional_Model {

  private $id_empresa = 0;
  private $conx = null;
  private $total = 0;

  function __construct($id_empresa,$conx) {
    $this->id_empresa = $id_empresa;
    $this->conx = $conx;
  }

  // Obtenemos los datos del entrada
  function get($id,$config = array()) {

    $activo = isset($config["activo"]) ? $config["activo"] : 1;
    $destacado = isset($config["destacado"]) ? $config["destacado"] : -1;
    $not_id = isset($config["not_id"]) ? $config["not_id"] : 0;
    $id = (int)$id;
    $sql = "SELECT A.*, ";
    $sql.= " IF(C.nombre IS NULL,'',C.nombre) AS especialidad ";
    $sql.= "FROM med_profesionales A ";
    $sql.= "LEFT JOIN med_especialidades C ON (A.id_especialidad = C.id AND A.id_empresa = C.id_empresa) ";
    $sql.= "WHERE A.id = $id ";
    $sql.= "AND A.id_empresa = $this->id_empresa ";
    if ($activo != -1) $sql.= "AND A.activo = $activo ";
    if ($destacado != -1) $sql.= "AND A.destacado = $destacado ";
    if ($not_id > 0) $sql.= "AND A.id != $not_id ";

    $q = mysqli_query($this->conx,$sql);
    if (mysqli_num_rows($q) == 0) return array();
    $entrada = mysqli_fetch_object($q);
    $entrada = $this->encoding($entrada);
    $entrada->path = ((strpos($entrada->path,"http://")===FALSE)) ? "/admin/".$entrada->path : $entrada->path;
    return $entrada;
  }

  function get_especialidad($id) {
    $result = array();
    $sql = "SELECT * FROM med_especialidades WHERE id_empresa = $this->id_empresa ";
    $sql.= "AND id = $id ORDER BY orden ASC ";
    $q = mysqli_query($this->conx,$sql);
    if (mysqli_num_rows($q)==0) return FALSE;
    $row=mysqli_fetch_object($q);
    $row->nombre = utf8_encode($row->nombre);
    return $row;
  }

  function get_especialidades() {
    $result = array();
    $sql = "SELECT * FROM med_especialidades WHERE id_empresa = $this->id_empresa ORDER BY nombre ASC";
    $q = mysqli_query($this->conx,$sql);
    $salida = array();
    while (($row=mysqli_fetch_object($q))!==NULL) {
      $salida[] = $row;
    }
    return $salida;
  }

  function get_obras_sociales() {
    $result = array();
    $sql = "SELECT * FROM med_obras_sociales WHERE id_empresa = $this->id_empresa ORDER BY nombre ASC";
    $q = mysqli_query($this->conx,$sql);
    $salida = array();
    while (($row=mysqli_fetch_object($q))!==NULL) {
      $salida[] = $row;
    }
    return $salida;
  }

  function get_tipos_pacientes() {
    $result = array();
    $sql = "SELECT * FROM med_tipos_pacientes WHERE id_empresa = $this->id_empresa ORDER BY nombre ASC";
    $q = mysqli_query($this->conx,$sql);
    $salida = array();
    while (($row=mysqli_fetch_object($q))!==NULL) {
      $salida[] = $row;
    }
    return $salida;
  }

  function get_titulos() {
    $result = array();
    $sql = "SELECT * FROM med_titulos WHERE id_empresa = $this->id_empresa ORDER BY orden ASC";
    $q = mysqli_query($this->conx,$sql);
    $salida = array();
    while (($row=mysqli_fetch_object($q))!==NULL) {
      $salida[] = $row;
    }
    return $salida;
  }

  function get_localidades() {
    $result = array();
    $sql = "SELECT DISTINCT L.id, L.nombre FROM com_localidades L ";
    $sql.= " INNER JOIN turnos_servicios TS ON (TS.id_localidad = L.id) ";
    $sql.= " INNER JOIN com_usuarios A ON (A.id_empresa = TS.id_empresa AND A.id = TS.id_usuario) ";
    $sql.= "WHERE TS.id_empresa = $this->id_empresa ORDER BY L.nombre ASC";
    $q = mysqli_query($this->conx,$sql);
    $salida = array();
    while (($row=mysqli_fetch_object($q))!==NULL) {
      $salida[] = $row;
    }
    return $salida;    
  }

  function get_list($config = array()) {

    $limit = isset($config["limit"]) ? $config["limit"] : 0;
    $offset = isset($config["offset"]) ? $config["offset"] : 6;
    $activo = isset($config["activo"]) ? $config["activo"] : 1;
    $destacado = isset($config["destacado"]) ? $config["destacado"] : -1; // -1 = No se tiene en cuenta el parametro
    $filter = isset($config["filter"]) ? $config["filter"] : 0;
    $id_especialidad = isset($config["id_especialidad"]) ? $config["id_especialidad"] : 0;
    $especialidad = isset($config["especialidad"]) ? $config["especialidad"] : 0;
    $not_id = isset($config["not_id"]) ? $config["not_id"] : 0;
    $order_by = isset($config["order_by"]) ? $config["order_by"] : "A.apellido ASC";

    $sql = "SELECT SQL_CALC_FOUND_ROWS A.*, ";
    $sql.= " IF(C.nombre IS NULL,'',C.nombre) AS especialidad ";
    $sql.= "FROM med_profesionales A ";
    $sql.= "LEFT JOIN med_especialidades C ON (A.id_especialidad = C.id AND A.id_empresa = C.id_empresa) ";
    $sql.= "WHERE 1=1 ";
    $sql.= "AND A.id_empresa = $this->id_empresa ";
    if (!empty($filter)) $sql.= "AND CONCAT(A.apellido,' ',A.nombre) LIKE '%$filter%' ";
    if ($not_id > 0) $sql.= "AND A.id != $not_id ";
    if ($activo != -1) $sql.= "AND A.activo = $activo ";
    if ($destacado != -1) $sql.= "AND A.destacado = $destacado ";
    if (!empty($id_especialidad)) $sql.= "AND A.id_especialidad = $id_especialidad ";
    if (!empty($especialidad)) $sql.= "AND C.link = '$especialidad' ";
    $sql.= "ORDER BY $order_by ";
    $sql.= "LIMIT $limit,$offset ";
    $q = mysqli_query($this->conx,$sql);
    $salida = array();

    $q_total = mysqli_query($this->conx,"SELECT FOUND_ROWS() AS total");
    $t = mysqli_fetch_object($q_total);
    $this->total = $t->total;

    while(($r=mysqli_fetch_object($q))!==NULL) {
      $r = $this->encoding($r);
      $r->path = ((strpos($r->path,"http://")===FALSE)) ? "/admin/".$r->path : $r->path;
      $salida[] = $r;
    }
    return $salida;

  }

  function get_total_results() {
    return $this->total;
  }

  private function encoding($e) {
    $e->texto = utf8_encode($e->texto);
    $e->nombre = utf8_encode($e->nombre);
    $e->apellido = utf8_encode($e->apellido);
    $e->especialidad = utf8_encode($e->especialidad);
    return $e;
  }

}
?>