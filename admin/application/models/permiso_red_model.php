<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Permiso_Red_Model extends Abstract_Model {

  function solicitudes_pendientes($config = array()) {
    $id_empresa = (isset($config["id_empresa"])) ? $config["id_empresa"] : parent::get_empresa();
    $sql = "SELECT SQL_CALC_FOUND_ROWS PR.*, ";
    $sql.= " E.id, E.nombre, E.razon_social, WC.logo_1 AS logo, WC.email, ";
    $sql.= " WC.telefono_web, WC.direccion_web ";
    $sql.= "FROM inm_permisos_red PR ";
    $sql.= "INNER JOIN empresas E ON (PR.id_empresa = E.id) ";
    $sql.= "INNER JOIN web_configuracion WC ON (E.id = WC.id_empresa) ";
    $sql.= "LEFT JOIN com_localidades L ON (E.id_localidad = L.id) ";
    $sql.= "WHERE PR.id_empresa_compartida = $id_empresa ";
    $sql.= "AND PR.solicitud_permiso = 1 ";
    $q = $this->db->query($sql);
    $q_total = $this->db->query("SELECT FOUND_ROWS() AS total");
    $total = $q_total->row();      

    $salida = array();
    foreach($q->result() as $row) {
      // Consultamos si la otra inmobiliaria tiene el permiso web
      $sql = "SELECT * FROM inm_permisos_red ";
      $sql.= "WHERE id_empresa = $id_empresa ";
      $sql.= "AND id_empresa_compartida = $row->id ";
      $qqq = $this->db->query($sql);
      if ($qqq->num_rows()>0) {
        $rrr = $qqq->row();
        $row->permiso_web_otra = $rrr->permiso_web;
      } else {
        $row->permiso_web_otra = 0;
      }
      $salida[] = $row;
    }
    return array(
      "results"=>$salida,
      "total"=>$total->total,
    );
  }

  // Devuelve todas las inmobiliarias que estan compartiendo en la red
  function get_inmobiliarias_red($config = array()) {
    $id_empresa = (isset($config["id_empresa"])) ? $config["id_empresa"] : parent::get_empresa();
    $id_inmobiliaria = (isset($config["id_inmobiliaria"])) ? $config["id_inmobiliaria"] : 0;
    $sql = "SELECT E.id, E.nombre, E.razon_social, WC.logo_1 AS logo, WC.email, ";
    $sql.= " WC.telefono_web, WC.direccion_web, ";
    $sql.= " IF(L.nombre IS NULL,'',L.nombre) AS localidad ";
    $sql.= "FROM empresas E ";
    $sql.= "INNER JOIN web_configuracion WC ON (E.id = WC.id_empresa) ";
    $sql.= "LEFT JOIN com_localidades L ON (E.id_localidad = L.id) ";
    $sql.= "WHERE E.id_proyecto = 3 "; // Solamente los de INMOVAR
    $sql.= "AND E.activo = 1 "; // La empresa tiene que estar activa
    $sql.= "AND E.id != $id_empresa "; // Que no sea la misma empresa
    if (!empty($id_inmobiliaria)) $sql.= "AND E.id = $id_inmobiliaria ";
    $sql.= "ORDER BY E.id DESC ";
    $salida = array();
    $q = $this->db->query($sql);
    foreach($q->result() as $row) {
      $row->nombre = ucwords(mb_strtolower($row->nombre));
      $row->razon_social = ucwords(mb_strtolower($row->razon_social));
      $row->localidad = ucwords(mb_strtolower($row->localidad));
      $row->direccion = ucwords(mb_strtolower($row->direccion_web));
      $row->telefono = $row->telefono_web;
      $row->telefono_web = preg_replace("/[^0-9]/", "", $row->telefono_web);
      $salida[] = $row;
    }
    return $salida;
  }
  
  function notificar($config = array()) {
    $id_empresa = (isset($config["id_empresa"])) ? $config["id_empresa"] : parent::get_empresa();

    // Obtenemos los datos de la nueva inmobiliaria
    $this->load->model("Empresa_Model");
    $empresa = $this->Empresa_Model->get_min($id_empresa);
    $empresa->nombre = ucwords(strtolower($empresa->nombre));

    // Obtenemos los datos del email que vamos a armar
    $this->load->model("Email_Template_Model");
    $template = $this->Email_Template_Model->get_by_key("nueva-inmobiliaria",118);
    $bcc_array = array(); //array("basile.matias99@gmail.com","misticastudio@gmail.com");
    include_once APPPATH.'libraries/Mandrill/Mandrill.php';
    $empresas = $this->get_inmobiliarias_red(array(
      "id_empresa"=>$id_empresa
    ));
    foreach($empresas as $emp) {
      $emp->email = "basile.matias99@gmail.com";
      // Reemplazamos los textos
      $asunto = $template->nombre;
      $texto = $template->texto;
      $asunto = str_replace("{{inmobiliaria}}", $empresa->nombre, $asunto);
      $asunto = str_replace("{{nombre}}", $emp->nombre, $asunto);
      $texto = str_replace("{{inmobiliaria}}", $empresa->nombre, $texto);
      $texto = str_replace("{{nombre}}", $emp->nombre, $texto);
      // Enviamos el email a la inmobiliaria con la invitacion de la nueva
      mandrill_send(array(
        "to"=>$emp->email,
        "from"=>"no-reply@varcreative.com",
        "from_name"=>"Inmovar",
        "subject"=>$asunto,
        "body"=>$texto,
        "bcc"=>$bcc_array,
      ));
      // Guardamos una nueva notificacion en el panel de la propia inmobiliaria
      $this->db->insert("com_log",array(
        "id_empresa"=>$emp->id,
        "importancia"=>'N',
        "fecha"=>date('Y-m-d H:i:s'),
        "id_usuario"=>0,
        "texto"=>$asunto,
        "leida"=>0,
      ));
    }
  }

}