<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Limpieza extends REST_Controller {

  function __construct() {
    parent::__construct();
  }

  function imagenes() {
    $id_empresa = 45;
    $sql = "SELECT * FROM inm_propiedades_images WHERE id_empresa = $id_empresa ";
    $q = $this->db->query($sql);
    echo "TOTAL DE IMAGENES: ".$q->num_rows();
    $contador = 0;
    $imagenes = array();
    foreach($q->result() as $image) {
      echo $image->path; exit();
    }
  }

}