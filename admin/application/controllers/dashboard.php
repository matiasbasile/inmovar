<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Dashboard extends REST_Controller {

  function __construct() {
    parent::__construct();
  }

  function enviar_soporte() {
    $asunto = parent::get_post("asunto");
    $texto = parent::get_post("texto");
    $id_empresa = parent::get_empresa();
    $this->load->model("Empresa_Model");
    $empresa = $this->Empresa_Model->get($id_empresa);
    if (empty($asunto)) {
      echo json_encode(array("error"=>1,"mensaje"=>"El asunto es vacio"));
      return;
    }
    if (empty($texto)) {
      echo json_encode(array("error"=>1,"mensaje"=>"El texto es vacio"));
      return;
    }
    $bcc_array = array(
      "basile.matias99@gmail.com",
      "misticastudio@gmail.com",
    );
    $asunto = utf8_decode($asunto);
    $texto = utf8_decode($texto);
    require_once APPPATH.'libraries/Mandrill/Mandrill.php';
    $body = "";
    $body.= "Cliente: $empresa->nombre <br/>";
    $body.= "Asunto: $asunto <br/>";
    $body.= "Mensaje: <br/>$texto";
    mandrill_send(array(
      "to"=>"soporte@inmovar.com",
      "subject"=>"Soporte Inmovar",
      "body"=>$body,
      "bcc"=>$bcc_array,
    ));
    echo json_encode(array(
      "error"=>0,
    ));
  }

  function get_info() {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $id_empresa = parent::get_empresa();
    $fecha_desde = $this->input->get("desde");
    $fecha_hasta = $this->input->get("hasta");
    $this->load->helper("fecha_helper");
    $desde = fecha_mysql($fecha_desde);
    $hasta = fecha_mysql($fecha_hasta);
    $datos = array();
    $datos["desde"] = $fecha_desde;
    $datos["hasta"] = $fecha_hasta;
    
    $this->load->model("Propiedad_Model");
    $datos["total_propiedades"] = $this->Propiedad_Model->count_all();
    $datos["mas_visitadas"] = $this->Propiedad_Model->mas_visitadas(array(
      "id_empresa"=>$id_empresa,
      "offset"=>3,
      "desde"=>$desde." 00:00:00",
      "hasta"=>$hasta." 23:59:59",
    ));

    // Cantidad de propiedades que tiene la red en total
    $datos["total_propiedades_red"] = $this->Propiedad_Model->total_propiedades_red_completa();

    // Cantidad de propiedades que tiene la red compartida con esta inmobiliaria
    $datos["total_propiedades_tu_red"] = $this->Propiedad_Model->total_propiedades_red_empresa();
    
    // Ultimas consultas
    $this->load->model("Consulta_Model");
    $consultas = $this->Consulta_Model->buscar(array(
      "tipo"=>1,
      "offset"=>3
    ));
    $datos["consultas"] = $consultas["results"];
    $datos["total_consultas"] = $this->Consulta_Model->contar(array(
      "desde"=>$desde." 00:00:00",
      "hasta"=>$hasta." 23:59:59",
      "tipo"=>0,
    ));

    $this->load->model("Propiedad_Visita_Model");
    $datos["visitas_sitio_web"] = $this->Propiedad_Visita_Model->contar(array(
      "id_empresa"=>$id_empresa,
      "desde"=>$desde." 00:00:00",
      "hasta"=>$hasta." 23:59:59",
    ));
    $datos["visitas_red"] = $this->Propiedad_Visita_Model->contar(array(
      "id_empresa_relacionada"=>$id_empresa, // Las visitas en la red se cuentan al reves
      "desde"=>$desde." 00:00:00",
      "hasta"=>$hasta." 23:59:59",
    ));
    $datos["total_visitas"] = $datos["visitas_sitio_web"] + $datos["visitas_red"];

    $datos["consultas_sitio_web"] = $this->Consulta_Model->contar(array(
      "id_empresa"=>$id_empresa,
      "tipo"=>0,
      "desde"=>$desde." 00:00:00",
      "hasta"=>$hasta." 23:59:59",
    ));
    $datos["consultas_red"] = $this->Consulta_Model->contar_consultas_red(array(
      "desde"=>$desde,
      "hasta"=>$hasta,
    ));

    echo json_encode($datos);
  }  
}