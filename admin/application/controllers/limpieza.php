<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Limpieza extends REST_Controller {

  function __construct() {
    parent::__construct();
  }

  function imagenes() {
    $id_empresa = 45;
    $contador = 0;
    $imagenes = array();
    $base = "uploads/$id_empresa/propiedades/";
    
    // Tabla inm_propiedades_images
    $sql = "SELECT * FROM inm_propiedades_images WHERE id_empresa = $id_empresa AND path != '' ";
    $q = $this->db->query($sql);
    $total_tabla_images = $q->num_rows();
    foreach($q->result() as $image) {
      $imagenes[] = $image->path;
    }

    // Imagen Principal
    $sql = "SELECT * FROM inm_propiedades WHERE id_empresa = $id_empresa AND path != '' ";
    $q = $this->db->query($sql);
    $total_paths = $q->num_rows();
    foreach($q->result() as $image) {
      $imagenes[] = $image->path;
    }

    echo "TOTAL DE IMAGENES: ".($total_tabla_images + $total_paths)."\n";

    $para_borrar = array();

    $archivos = glob($base."*");
    foreach($archivos as $archivo) {
      $encontro = false;
      foreach($imagenes as $imagen) {
        if ($imagen == $archivo) {
          $encontro = true;
          break;
        }
      }
      if (!$encontro) {
        $para_borrar[] = $archivo;
      }
    }

    echo "TOTAL DE ARCHIVOS PARA BORRAR: ".sizeof($para_borrar)."\n";
  }

}