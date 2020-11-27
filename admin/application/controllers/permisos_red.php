<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Permisos_Red extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Permiso_Red_Model', 'modelo');
  }

  // Esta funcion notifica el registro de una empresa nueva en Inmovar
  // Se ejecuta como una tarea programada para que no retrase el registro de la empresa nueva
  function notificar($id_empresa) {
    $this->modelo->notificar(array(
      "id_empresa"=>$res["id"],
    ));
    echo json_encode(array("error"=>0));
  } 

  // Obtiene los datos de las inmobiliarias participantes de la red
  function get_by_empresa() {
    $id_empresa = parent::get_empresa();
    $id = parent::get_post("id",0);
    $filter = parent::get_post("filter","");
    $s = $this->modelo->get_inmobiliarias_red(array(
      "id_empresa"=>$id_empresa,
      "id_inmobiliaria"=>$id,
      "filter"=>$filter,
    ));
    $salida = array();
    foreach($s as $row) {
      $sql = "SELECT * FROM inm_permisos_red ";
      $sql.= "WHERE id_empresa_compartida = $row->id ";
      $sql.= "AND id_empresa = $id_empresa ";
      $qq = $this->db->query($sql);
      if ($qq->num_rows()>0) {
        $rr = $qq->row();
        $row->estado = $rr->estado;
        $row->solicitud_permiso = $rr->solicitud_permiso;
        $row->permiso_red = $rr->permiso_red;
        $row->permiso_web = $rr->permiso_web;
        $row->bloqueado = $rr->bloqueado;

        // Consultamos si la otra inmobiliaria tiene el permiso web
        $sql = "SELECT * FROM inm_permisos_red ";
        $sql.= "WHERE id_empresa_compartida = $id_empresa ";
        $sql.= "AND id_empresa = $row->id ";
        $qqq = $this->db->query($sql);
        if ($qqq->num_rows()>0) {
          $rrr = $qqq->row();
          $row->permiso_web_otra = $rrr->permiso_web;
        } else {
          $row->permiso_web_otra = 0;
        }

      } else {
        $row->estado = 0;
        $row->solicitud_permiso = 0;
        $row->permiso_red = 0;
        $row->permiso_web = 0;
        $row->permiso_web_otra = 0;
        $row->bloqueado = 0;
      }
      $salida[] = $row;
    }

    // Contamos el total de solicitudes pendientes
    $pendientes = $this->modelo->solicitudes_pendientes(array(
      "id_empresa"=>$id_empresa
    ));

    echo json_encode(array(
      "results"=>$salida,
      "solicitudes_pendientes"=>$pendientes["total"],
    ));
  }

  function guardar_permiso_red() {
    $id_empresa = parent::get_empresa();
    $id_empresa_compartida = parent::get_post("id_empresa_compartida",0);
    $permiso_red = parent::get_post("permiso_red",0);

    // Actualizamos los permisos de la empresa con la otra inmobiliaria
    $sql = "SELECT * FROM inm_permisos_red WHERE id_empresa = $id_empresa AND id_empresa_compartida = $id_empresa_compartida ";
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
      $sql = "UPDATE inm_permisos_red SET permiso_red = $permiso_red WHERE id_empresa = $id_empresa AND id_empresa_compartida = $id_empresa_compartida ";
    } else {
      $sql = "INSERT INTO inm_permisos_red (id_empresa, id_empresa_compartida, permiso_red) VALUES ($id_empresa, $id_empresa_compartida, $permiso_red) ";
    }
    $this->db->query($sql);

    // Si el permiso de la red se desactiva,
    // automaticamente se vuelve para atras los permisos de la web tambien
    if ($permiso_red == 0) {

      // Limpiamos los permisos de la web que tiene la empresa con la otra inmobiliaria
      $sql = "UPDATE inm_permisos_red SET ";
      $sql.= " solicitud_permiso = 0, permiso_web = 0 ";
      $sql.= "WHERE id_empresa = $id_empresa AND id_empresa_compartida = $id_empresa_compartida ";
      $this->db->query($sql);

      // Del otro lado, se tiene que bloquear
      $sql = "UPDATE inm_permisos_red ";
      $sql.= " SET bloqueado = 1, solicitud_permiso = 0, permiso_web = 0 ";
      $sql.= "WHERE id_empresa_compartida = $id_empresa AND id_empresa = $id_empresa_compartida ";
      $this->db->query($sql);

    } else {

      // Del otro lado, se deberia desbloquear (por las dudas que estaba bloqueado anteriormente)
      $sql = "UPDATE inm_permisos_red ";
      $sql.= " SET bloqueado = 0 ";
      $sql.= "WHERE id_empresa_compartida = $id_empresa AND id_empresa = $id_empresa_compartida ";
      $this->db->query($sql);

    }

    echo json_encode(array(
      "error"=>0,
    ));
  }

  // Se envia una solicitud para poder mostrar las propiedades de "id_empresa_compartida" en mi propia web (en la de id_empresa)
  function solicitar_permiso() {
    $id_empresa = parent::get_empresa();
    $id_empresa_compartida = parent::get_post("id_empresa_compartida",0);

    // Actualizamos los permisos de la empresa con la otra inmobiliaria
    $sql = "SELECT * FROM inm_permisos_red WHERE id_empresa = $id_empresa AND id_empresa_compartida = $id_empresa_compartida ";
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
      $sql = "UPDATE inm_permisos_red SET solicitud_permiso = 1 WHERE id_empresa = $id_empresa AND id_empresa_compartida = $id_empresa_compartida ";
    } else {
      $sql = "INSERT INTO inm_permisos_red (id_empresa, id_empresa_compartida, solicitud_permiso) VALUES ($id_empresa, $id_empresa_compartida, 1) ";
    }
    $this->db->query($sql);

    echo json_encode(array(
      "error"=>0,
    ));
  }

  // Se acepta el permiso enviado para mostrar las propiedades mias en la web del otro
  function aceptar_permiso() {
    $id_empresa = parent::get_empresa();
    $id_empresa_compartida = parent::get_post("id_empresa_compartida",0);
    $inversa = parent::get_post("inversa",0);

    $sql = "UPDATE inm_permisos_red SET ";
    $sql.= " solicitud_permiso = 0, ";
    $sql.= " permiso_web = 1 ";
    $sql.= "WHERE "; // Se pone al reves porque es el otro el que solicito el permiso
    $sql.= " id_empresa_compartida = $id_empresa AND id_empresa = $id_empresa_compartida ";
    $this->db->query($sql);

    // La inmobiliaria que recibio la solicitud tambien acepto poner las propiedades de la otra en su propia web
    if ($inversa == 1) {

      $sql = "SELECT * FROM inm_permisos_red WHERE id_empresa = $id_empresa AND id_empresa_compartida = $id_empresa_compartida ";
      $q = $this->db->query($sql);
      if ($q->num_rows() > 0) {
        $sql = "UPDATE inm_permisos_red SET solicitud_permiso = 0, permiso_red = 1, permiso_web = 1 WHERE id_empresa = $id_empresa AND id_empresa_compartida = $id_empresa_compartida ";
      } else {
        $sql = "INSERT INTO inm_permisos_red (id_empresa, id_empresa_compartida, solicitud_permiso, permiso_red, permiso_web) VALUES ($id_empresa, $id_empresa_compartida, 0, 1, 1) ";
      }
      $this->db->query($sql);
    }

    echo json_encode(array(
      "error"=>0,
    ));
  }

  // El descartar solamente lo saca de las notificaciones
  // es decir pone visto = 1
  // ya que la solicitud queda pendiente siempre en caso de no aceptarla
  function descartar_permiso() {
    $id_empresa = parent::get_empresa();
    $id_empresa_compartida = parent::get_post("id_empresa_compartida",0);
    $inversa = parent::get_post("inversa",0);

    $sql = "UPDATE inm_permisos_red SET ";
    $sql.= " visto = 1 ";
    $sql.= "WHERE "; // Se pone al reves porque es el otro el que solicito el permiso
    $sql.= " id_empresa_compartida = $id_empresa AND id_empresa = $id_empresa_compartida ";
    $this->db->query($sql);

    echo json_encode(array(
      "error"=>0,
    ));
  }

  // Elimina directamente la solicitud
  function eliminar_solicitud() {
    $id_empresa = parent::get_empresa();
    $id_empresa_compartida = parent::get_post("id_empresa_compartida",0);

    $sql = "UPDATE inm_permisos_red SET ";
    $sql.= " solicitud_permiso = 0, visto = 0, permiso_web = 0 ";
    $sql.= "WHERE "; // Se pone al reves porque es el otro el que solicito el permiso
    $sql.= " id_empresa_compartida = $id_empresa AND id_empresa = $id_empresa_compartida ";
    $this->db->query($sql);

    echo json_encode(array(
      "error"=>0,
    ));
  }  

  function ver_solicitudes_pendientes() {
    $id_empresa = parent::get_empresa();
    $salida = $this->modelo->solicitudes_pendientes(array(
      "id_empresa"=>$id_empresa
    ));

    $participantes = $this->modelo->get_inmobiliarias_red();
    $salida["total_red_inmovar"] = sizeof($participantes);

    echo json_encode($salida);
  }

  function insert() {}
  function update($id) {}
  function delete($id) {}
  function get() {}

}