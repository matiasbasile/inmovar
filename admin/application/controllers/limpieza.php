<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Limpieza extends REST_Controller {

  function __construct() {
    parent::__construct();
  }

  function imagenes() {
    $id_empresa = 45;
    $base = "uploads/$id_empresa/propiedades/";
    $sql = "SELECT * FROM inm_propiedades_images WHERE id_empresa = $id_empresa ";
    $q = $this->db->query($sql);
    echo "TOTAL DE IMAGENES: ".$q->num_rows()."\n";
    $contador = 0;
    $imagenes = array();
    foreach($q->result() as $image) {
      $imagenes[] = $image->path;
    }

    $archivos = glob($base."*");
    print_r($archivos); exit();
    foreach($archivos as $archivo) {

    }

  }

}