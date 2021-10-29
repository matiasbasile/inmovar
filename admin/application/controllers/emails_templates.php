<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Emails_Templates extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Email_Template_Model', 'modelo',"nombre ASC");
  }

  function enviar_plantilla() {

    set_time_limit(0);
    $id_empresa = parent::get_empresa();
    $id_plantilla = parent::get_post("id_email_template",0);
    $this->load->model("Empresa_Model");
    $empresa = $this->Empresa_Model->get($id_empresa);
    $this->load->model("Cliente_Model");
    require_once APPPATH.'libraries/Mandrill/Mandrill.php';

    // Obtenemos los contactos que se suscribieron a digital
    $contactos = $this->Cliente_Model->buscar(array(
      "id_empresa"=>$id_empresa,
      "tipo"=>8,
    ));
    $template = $this->modelo->get($id_plantilla,$id_empresa);
    if ($template === FALSE) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"No existe un template para la notificacion",
      ));
      exit();
    }
    $cantidad = 0;
    foreach($contactos["results"] as $c) {

      $body = $template->texto;
      $body = str_replace("{{nombre}}",$c->nombre,$body);
      $body = str_replace("'", "\"", $body);

      $array = array(
        "to"=>$c->email,
        "from"=>"no-reply@varcreative.com",
        "from_name"=>$empresa->nombre,
        "subject"=>$template->nombre,
        "body"=>$body,
      );

      // Si es la plantilla de certificado
      if ($id_plantilla == 135) {
        // Generamos el PDF
        $cache_dir = '/home/ubuntu/data/cache';
        require_once('/home/ubuntu/data/vendor/autoload.php');
        $mpdf = new \Mpdf\Mpdf([
          'tempDir' => $cache_dir,
          'orientation' => 'L'
        ]);
        $data_query = array(
          "nombre"=>$c->nombre,
        );
        $url = "https://www.allextruded.com/web/certificado/?".http_build_query($data_query);
        $html = file_get_contents($url);
        $mpdf->CSSselectMedia='mpdf';
        $mpdf->setBasePath($url);
        $mpdf->WriteHTML($html);
        $filename = "Certificado Webinar $c->nombre.pdf";
        $mpdf->Output($cache_dir."/".$filename, \Mpdf\Output\Destination::FILE);
        $array["attachments"] = array($cache_dir."/".$filename);
      }
      
      mandrill_send($array);
      $cantidad++;
    }
    echo json_encode(array(
      "error"=>0,
      "cantidad"=>$cantidad,
    ));
  }  

  function notificar_milling() {

    $id_empresa = parent::get_empresa();
    $this->load->model("Empresa_Model");
    $empresa = $this->Empresa_Model->get($id_empresa);
    $this->load->model("Cliente_Model");
    require_once APPPATH.'libraries/Mandrill/Mandrill.php';

    // Obtenemos los contactos que se suscribieron a digital
    $contactos = $this->Cliente_Model->buscar(array(
      "id_empresa"=>$id_empresa,
      "tipo"=>2,
    ));
    $template = $this->modelo->get_by_key("notificacion",$id_empresa);
    if ($template === FALSE) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"No existe un template para la notificacion",
      ));
      exit();
    }
    $cantidad = 0;
    foreach($contactos["results"] as $c) {

      $body = $template->texto;
      $body = str_replace("{{nombre}}",$c->nombre,$body);
      $body = str_replace("'", "\"", $body);
      
      mandrill_send(array(
        "to"=>$c->email,
        "from"=>"no-reply@varcreative.com",
        "from_name"=>$empresa->nombre,
        "subject"=>$template->nombre,
        "body"=>$body,
      ));
      $cantidad++;
    }
    echo json_encode(array(
      "error"=>0,
      "cantidad"=>$cantidad,
    ));
  }
    
}