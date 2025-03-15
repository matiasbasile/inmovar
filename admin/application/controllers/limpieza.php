<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Limpieza extends REST_Controller {

  function __construct() {
    parent::__construct();
  }

  function imagenes() {
    $sql = "SELECT id FROM empresas";
    $q = $this->db->query($sql);
    foreach($q->result() as $empresa) {
      echo "\nLIMPIANDO EMPRESA: $empresa->id \n";
      $this->borrar_imagenes($empresa->id);
      echo "-------------------\n";
    }
  }

  function borrar_imagenes($id_empresa, $ejecutar = 1) {
    $contador = 0;
    $imagenes = array();
    $base = "uploads/$id_empresa/propiedades/";
    
    // Tabla inm_propiedades_images
    $sql = "SELECT * FROM inm_propiedades_images WHERE id_empresa = $id_empresa AND path != '' ";
    $q = $this->db->query($sql);
    $total_tabla_images = $q->num_rows();
    foreach($q->result() as $image) {
      if (strpos($image->path, "?") !== false) {
        $image->path = substr($image->path, 0, strpos($image->path, "?"));
      }
      if (!in_array($imagenes, $image->path)) {
        $imagenes[] = $image->path;
      }
    }
    echo "inm_propiedades_images: ".($total_tabla_images)."\n";


    // Imagen Principal
    $sql = "SELECT * FROM inm_propiedades WHERE id_empresa = $id_empresa AND path != '' ";
    $q = $this->db->query($sql);
    $total_paths = $q->num_rows();
    foreach($q->result() as $image) {
      if (!in_array($imagenes, $image->path)) {
        $imagenes[] = $image->path;
      }
    }
    echo "inm_propiedades.path: ".($total_paths)."\n";

    // Archivo
    $sql = "SELECT * FROM inm_propiedades WHERE id_empresa = $id_empresa AND archivo != '' ";
    $q = $this->db->query($sql);
    $total_archivos = $q->num_rows();
    foreach($q->result() as $image) {
      if (!in_array($imagenes, $image->archivo)) {
        $imagenes[] = $image->archivo;
      }
    }
    echo "inm_propiedades.archivo: ".($total_archivos)."\n";


    echo "TOTAL BASE DE DATOS: ".($total_tabla_images + $total_paths + $total_archivos)."\n";

    $para_borrar = array();

    $archivos = glob($base."*");
    echo "TOTAL DE ARCHIVOS: ".sizeof($archivos)."\n";

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

    echo "TOTAL PARA BORRAR: ".sizeof($para_borrar)."\n";
    foreach($para_borrar as $archivo) {
      if ($ejecutar == 1) {
        unlink($archivo);
      }
    }
  }

}