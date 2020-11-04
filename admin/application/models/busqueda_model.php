<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Busqueda_Model extends Abstract_Model {
  
  function __construct() {
    parent::__construct("inm_busquedas","id");
  }

  function find($filter) {
    $id_empresa = parent::get_empresa();
    $this->db->where("id_empresa",$id_empresa);
    $this->db->like("nombre",$filter);
    $query = $this->db->get($this->tabla);
    $result = $query->result();
    $this->db->close();
    return $result;
  }
    
  /**
   * Obtiene los busquedas a partir de diferentes parametros
   */
  function buscar($conf = array()) {
    
    $id_empresa = (isset($conf["id_empresa"])) ? $conf["id_empresa"] : parent::get_empresa();
    $not_id_empresa = (isset($conf["not_id_empresa"])) ? $conf["not_id_empresa"] : 0;
    $buscar_red = (isset($conf["buscar_red"])) ? $conf["buscar_red"] : 1;
    $id_propietario = (isset($conf["id_propietario"])) ? $conf["id_propietario"] : 0;
    $id_tipo_estado = (isset($conf["id_tipo_estado"])) ? $conf["id_tipo_estado"] : 0;
    $id_tipo_operacion = (isset($conf["id_tipo_operacion"])) ? $conf["id_tipo_operacion"] : 0;
    $id_tipo_inmueble = (isset($conf["id_tipo_inmueble"])) ? $conf["id_tipo_inmueble"] : 0;
    $id_localidad = (isset($conf["id_localidad"])) ? $conf["id_localidad"] : 0;
    $solo_contar = (isset($conf["solo_contar"])) ? $conf["solo_contar"] : 0;
    $calle = (isset($conf["calle"])) ? $conf["calle"] : "";
    $apto_banco = (isset($conf["apto_banco"])) ? $conf["apto_banco"] : 0;
    $acepta_permuta = (isset($conf["acepta_permuta"])) ? $conf["acepta_permuta"] : 0;
    $filter = (isset($conf["filter"])) ? $conf["filter"] : "";
    $limit = (isset($conf["limit"])) ? $conf["limit"] : 0;
    $offset = (isset($conf["offset"])) ? $conf["offset"] : 0;
    $order = (isset($conf["order"])) ? $conf["order"] : "";
    $activo = (isset($conf["activo"])) ? $conf["activo"] : -1;

    $sql_fields = "SQL_CALC_FOUND_ROWS A.*, ";
    $sql_fields.= "E.razon_social AS inmobiliaria, WC.logo_1 AS logo_inmobiliaria, E.id AS id_inmobiliaria, ";
    $sql_fields.= "E.codigo AS codigo_inmobiliaria, CONCAT(E.codigo,'-',A.codigo) AS codigo_completo, ";
    $sql_fields.= "IF(A.valido_hasta='0000-00-00','',DATE_FORMAT(A.valido_hasta,'%d/%m/%Y')) AS valido_hasta, ";
    $sql_fields.= "IF(A.fecha_publicacion='0000-00-00','',DATE_FORMAT(A.fecha_publicacion,'%d/%m/%Y')) AS fecha_publicacion, ";
    $sql_fields.= "IF(P.nombre IS NULL,'',P.nombre) AS propietario, ";
    $sql_fields.= "IF(TE.nombre IS NULL,'',TE.nombre) AS tipo_estado, ";
    $sql_fields.= "IF(TI.nombre IS NULL,'',TI.nombre) AS tipo_inmueble, ";
    $sql_fields.= "IF(X.nombre IS NULL,'',X.nombre) AS tipo_operacion, ";
    $sql_fields.= "IF(U.nombre IS NULL,'',U.nombre) AS usuario, ";
    $sql_fields.= "IF(U.email IS NULL,'',U.email) AS usuario_email, ";
    $sql_fields.= "IF(L.nombre IS NULL,'',L.nombre) AS localidad, ";
    $sql_fields.= "IF(L.id_localidad_inmobusquedas IS NULL,0,L.id_localidad_inmobusquedas) AS id_localidad_inmobusquedas, ";
    $sql_fields.= "IF(L.id_partido_inmobusquedas IS NULL,0,L.id_partido_inmobusquedas) AS id_partido_inmobusquedas, ";
    $sql_fields.= "IF(PROV.id_inmobusquedas IS NULL,0,PROV.id_inmobusquedas) AS id_provincia_inmobusquedas ";

    $sql_from = "FROM inm_busquedas A ";
    $sql_from.= "INNER JOIN empresas E ON (A.id_empresa = E.id) ";
    $sql_from.= "INNER JOIN web_configuracion WC ON (WC.id_empresa = E.id) ";
    $sql_from.= "LEFT JOIN inm_tipos_estado TE ON (A.id_tipo_estado = TE.id) ";
    $sql_from.= "LEFT JOIN inm_tipos_inmueble TI ON (A.id_tipo_inmueble = TI.id) ";
    $sql_from.= "LEFT JOIN inm_tipos_operacion X ON (A.id_tipo_operacion = X.id) ";
    $sql_from.= "LEFT JOIN com_usuarios U ON (A.id_usuario = U.id AND A.id_empresa = U.id_empresa) ";
    $sql_from.= "LEFT JOIN clientes P ON (A.id_propietario = P.id AND A.id_empresa = P.id_empresa) ";
    $sql_from.= "LEFT JOIN com_localidades L ON (A.id_localidad = L.id) ";
    $sql_from.= "LEFT JOIN com_departamentos DEP ON (L.id_departamento = DEP.id) ";
    $sql_from.= "LEFT JOIN com_provincias PROV ON (DEP.id_provincia = PROV.id) ";

    $sql_where = "WHERE 1=1 ";
    if ($buscar_red == 0) $sql_where.= "AND A.id_empresa = $id_empresa ";
    else if ($buscar_red == 1) {
      // Si estamos buscando de la red, tienen que desaparecer a los 5 dias
      $f = new DateTime();
      $f->modify("-5 days");
      $fecha = $f->format("Y-m-d");
      $sql_where.= "AND A.id_empresa != $id_empresa AND fecha_publicacion >= '$fecha' ";
    }

    if ($activo != -1) $sql_where.= "AND A.activo = $activo ";
    if (!empty($filter)) $sql_where.= "AND (A.codigo LIKE '%$filter%' OR A.nombre LIKE '%$filter%' OR A.calle LIKE '%$filter%') ";
    if (!empty($id_tipo_estado)) $sql_where.= "AND A.id_tipo_estado = $id_tipo_estado ";
    if (!empty($id_tipo_operacion)) $sql_where.= "AND A.id_tipo_operacion IN ($id_tipo_operacion) ";
    if (!empty($id_tipo_inmueble)) $sql_where.= "AND A.id_tipo_inmueble IN ($id_tipo_inmueble) ";
    
    if (!empty($id_propietario)) $sql_where.= "AND A.id_propietario = $id_propietario ";
    if (!empty($id_localidad)) $sql_where.= "AND A.id_localidad IN ($id_localidad) ";
    if (!empty($calle)) $sql_where.= "AND A.calle = '$calle' ";
    if ($apto_banco == 1) $sql_where.= "AND A.apto_banco = 1 ";
    if ($acepta_permuta == 1) $sql_where.= "AND A.acepta_permuta = 1 ";

    // Bloque de SQL que identifica que estamos buscando en la red
    $sql_red = "AND A.compartida = 1 "; // En primer lugar tiene que estar compartida
    $sql_red.= "AND A.id_empresa IN (";
    $sql_red.= " SELECT PR.id_empresa FROM inm_permisos_red PR ";
    $sql_red.= " WHERE PR.id_empresa_compartida = $id_empresa ";
    $sql_red.= " AND PR.permiso_red = 1 "; // Tiene el permiso habilitado
    $sql_red.= ") ";

    if (!empty($not_id_empresa)) $sql_where.= "AND A.id_empresa != $not_id_empresa ";
    else if ($id_empresa != -1) $sql_where.= "AND A.id_empresa = $id_empresa ";

    // Si solamente debemos contar la cantidad de resultados
    if ($solo_contar == 1) {
      $sql = "SELECT COUNT(*) AS cantidad ".$sql_from.$sql_where;
      $q = $this->db->query($sql);
      $r = $q->row();
      return array(
        "results"=>[],
        "total"=>$r->cantidad,
      );
    }

    // ARMAMOS LA CONSULTA PRINCIPAL
    $sql = "SELECT ".$sql_fields.$sql_from.$sql_where;
    if (!empty($order)) $sql.= "ORDER BY $order ";
    if ($offset != 0) $sql.= "LIMIT $limit, $offset ";
    $q = $this->db->query($sql);

    $q_total = $this->db->query("SELECT FOUND_ROWS() AS total");
    $total = $q_total->row();      
    $total2 = $total->total;

    $sql = "SELECT IF(COUNT(*) IS NULL,0,COUNT(*)) AS total ";
    $sql.= "FROM inm_busquedas A ";
    $sql.= "WHERE A.activo = $activo ";
    $sql.= "AND A.id_empresa != $id_empresa ";
    $qq = $this->db->query($sql);
    $rr = $qq->row();
    $total_red = $rr->total;
    
    $sql = "SELECT IF(COUNT(*) IS NULL,0,COUNT(*)) AS total ";
    $sql.= "FROM inm_busquedas A ";
    $sql.= "WHERE A.activo = $activo ";
    $sql.= "AND A.id_empresa = $id_empresa ";
    $qq = $this->db->query($sql);
    $rr = $qq->row();
    $total_propias = $rr->total;

    return array(
      "results"=>$q->result(),
      "total"=>$total2,
      "meta"=>array(
        "total_red"=>$total_red,
        "total_propias"=>$total_propias,
      ),
    );
  }

  function get($id,$config=array()) {
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    // Obtenemos los datos del busqueda
    $id = (int)$id;
    $sql = "SELECT A.*, ";
    $sql.= "IF(A.valido_hasta='0000-00-00','',DATE_FORMAT(A.valido_hasta,'%d/%m/%Y')) AS valido_hasta, ";
    $sql.= "IF(A.fecha_publicacion='0000-00-00','',DATE_FORMAT(A.fecha_publicacion,'%d/%m/%Y')) AS fecha_publicacion, ";
    $sql.= "E.nombre AS empresa, E.path AS empresa_path, E.telefono_empresa AS empresa_telefono, E.direccion_empresa AS empresa_direccion, E.email AS empresa_email, ";
    $sql.= "E.codigo AS codigo_inmobiliaria, CONCAT(E.codigo,'-',A.codigo) AS codigo_completo, ";
    $sql.= "IF(P.nombre IS NULL,'',P.nombre) AS propietario, ";
    $sql.= "IF(P.telefono IS NULL,'',P.telefono) AS propietario_telefono, ";
    $sql.= "IF(P.email IS NULL,'',P.email) AS propietario_email, ";
    $sql.= "IF(P.direccion IS NULL,'',P.direccion) AS propietario_direccion, ";
    $sql.= "IF(TE.nombre IS NULL,'',TE.nombre) AS tipo_estado, ";
    $sql.= "IF(TI.nombre IS NULL,'',TI.nombre) AS tipo_inmueble, ";
    $sql.= "IF(X.nombre IS NULL,'',X.nombre) AS tipo_operacion, ";
    $sql.= "IF(U.nombre IS NULL,'',U.nombre) AS usuario, ";
    $sql.= "IF(U.email IS NULL,'',U.email) AS usuario_email, ";
    $sql.= "IF(L.nombre IS NULL,'',L.nombre) AS localidad ";
    $sql.= "FROM inm_busquedas A ";
    $sql.= "INNER JOIN empresas E ON (A.id_empresa = E.id) ";
    $sql.= "LEFT JOIN inm_tipos_estado TE ON (A.id_tipo_estado = TE.id) ";
    $sql.= "LEFT JOIN inm_tipos_inmueble TI ON (A.id_tipo_inmueble = TI.id) ";
    $sql.= "LEFT JOIN inm_tipos_operacion X ON (A.id_tipo_operacion = X.id) ";
    $sql.= "LEFT JOIN clientes P ON (A.id_propietario = P.id AND A.id_empresa = P.id_empresa) ";
    $sql.= "LEFT JOIN com_localidades L ON (A.id_localidad = L.id) ";
    $sql.= "LEFT JOIN com_usuarios U ON (A.id_usuario = U.id AND A.id_empresa = U.id_empresa) ";
    $sql.= "WHERE A.id = $id ";
    $sql.= "AND A.id_empresa = $id_empresa ";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) return array();
    $busqueda = $q->row();
    return $busqueda;
  }
  
  function get_by_id($id,$config = array()) {
    $id_empresa = (isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa());
    // Obtenemos los datos del busqueda
    $id = (int)$id;
    $sql = "SELECT A.*, ";
    $sql.= "IF(P.nombre IS NULL,'',P.nombre) AS propietario, ";
    $sql.= "IF(TE.nombre IS NULL,'',TE.nombre) AS tipo_estado, ";
    $sql.= "IF(TI.nombre IS NULL,'',TI.nombre) AS tipo_inmueble, ";
    $sql.= "IF(X.nombre IS NULL,'',X.nombre) AS tipo_operacion, ";
    $sql.= "IF(L.nombre IS NULL,'',L.nombre) AS localidad ";
    $sql.= "FROM inm_busquedas A ";
    $sql.= "LEFT JOIN inm_tipos_estado TE ON (A.id_tipo_estado = TE.id) ";
    $sql.= "LEFT JOIN inm_tipos_inmueble TI ON (A.id_tipo_inmueble = TI.id) ";
    $sql.= "LEFT JOIN inm_tipos_operacion X ON (A.id_tipo_operacion = X.id) ";
    $sql.= "LEFT JOIN clientes P ON (A.id_propietario = P.id AND A.id_empresa = P.id_empresa) ";
    $sql.= "LEFT JOIN com_localidades L ON (A.id_localidad = L.id) ";
    $sql.= "WHERE A.id = '$id' AND A.id_empresa = '$id_empresa' ";
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
      $busqueda = $q->row();      
    } else {
      $busqueda = FALSE;
    }
    return $busqueda;
  }
  
  function delete($id) {
    // Controlamos que se este borrando un busqueda que pertenece a la empresa de la session
    $id_empresa = parent::get_empresa();
    if ($id_empresa === FALSE) return;
    $q = $this->db->query("SELECT * FROM inm_busquedas WHERE id = $id AND id_empresa = $id_empresa ");
    if ($q->num_rows()>0) {
      $this->db->query("DELETE FROM inm_busquedas WHERE id = $id AND id_empresa = $id_empresa");
    }
  }

}