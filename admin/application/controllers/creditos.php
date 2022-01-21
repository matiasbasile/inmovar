<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Creditos extends REST_Controller {

  function __construct() {
    parent::__construct();
  }

  function obtener() {
    header("Access-Control-Allow-Origin: *");
    $monto = parent::get_post("monto");
    $tna = parent::get_post("tna");
    $cuotas = parent::get_post("cuotas");
    $ch = curl_init();
    $url = "http://mberenguer.com.ar/wp-admin/admin-ajax.php";
    $post = array(
      "action"=>"calcular_cuotas_sistema_frances",
      "monto"=>$monto,
      "tna"=>$tna,
      "cuotas"=>$cuotas,
    );
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);    
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    echo $result;
  }
  
}