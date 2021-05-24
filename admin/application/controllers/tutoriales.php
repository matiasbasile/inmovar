<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Tutoriales extends REST_Controller {

  function __construct() {
    parent::__construct();
  }

  function buscar() {
    $id_modulo = parent::get_get("id_modulo",0);

    $sql = "SELECT * FROM com_videos ";
    $sql.= "WHERE clave = '$id_modulo' ";
    $sql.= "ORDER BY id DESC ";
    $q = $this->db->query($sql);
    $videos = array();
    foreach($q->result() as $r) {
      $r->video_es = str_replace("https://www.youtube.com/watch?v=", "", $r->video_es);
      $r->video_es = str_replace("https://youtube.com/watch?v=", "", $r->video_es);
      $videos[] = array(
        "id"=>$r->id,
        "titulo"=>$r->nombre_es,
        "descripcion"=>$r->texto_es,
        "link"=>$r->video_es,
      );
    }

    $lista = array(
      "id_modulo"=>$id_modulo,
      "titulo"=>$id_modulo,
      "videos"=>$videos,
    );

    echo json_encode(array(
      "results"=>$lista,
      "total"=>sizeof($lista),
    ));
  }

}