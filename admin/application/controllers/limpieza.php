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
      if (strpos($image->path, "?") !== false) {
        $image->path = substr($image->path, 0, strpos($image->path, "?"));
      }
      if (!in_array($imagenes, $image->path)) {
        $imagenes[] = $image->path;
      }
    }
    echo "TOTAL DE IMAGENES EN inm_propiedades_images: ".($total_tabla_images)."\n";


    // Imagen Principal
    $sql = "SELECT * FROM inm_propiedades WHERE id_empresa = $id_empresa AND path != '' ";
    $q = $this->db->query($sql);
    $total_paths = $q->num_rows();
    foreach($q->result() as $image) {
      if (!in_array($imagenes, $image->path)) {
        $imagenes[] = $image->path;
      }
    }
    echo "TOTAL DE IMAGENES EN inm_propiedades.path: ".($total_paths)."\n";

    // Archivo
    $sql = "SELECT * FROM inm_propiedades WHERE id_empresa = $id_empresa AND archivo != '' ";
    $q = $this->db->query($sql);
    $total_archivos = $q->num_rows();
    foreach($q->result() as $image) {
      if (!in_array($imagenes, $image->archivo)) {
        $imagenes[] = $image->archivo;
      }
    }
    echo "TOTAL DE IMAGENES EN inm_propiedades.archivo: ".($total_archivos)."\n";


    echo "TOTAL DE IMAGENES EN BASE DE DATOS: ".($total_tabla_images + $total_paths + $total_archivos)."\n";

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

    echo "TOTAL DE ARCHIVOS PARA BORRAR: ".sizeof($para_borrar)."\n";
    foreach($para_borrar as $archivo) {
      $nuevo = str_replace($base, $base."backup/", $archivo);
      echo $nuevo; exit();
    }


    echo "TOTAL DE ARCHIVOS EXISTENTES: ".sizeof($estan)."\n";
  }

}