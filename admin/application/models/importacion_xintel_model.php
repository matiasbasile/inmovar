<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Importacion_Xintel_Model extends Abstract_Model {
  
  function __construct() {
    parent::__construct("inm_logs","id","id DESC");
  }
    
  function importar_xintel($url =  "http://xintel.com.ar/api/?json=resultados.fichas&suc=JYB&apiK=4m17zq256jvsm24wOnqbev43y&page=0") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    set_time_limit(0);

    $id_empresa = 1503;
    $c = curl_init($url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $result = curl_exec($c);
    $result = json_decode($result);


    $total_paginas = intval($result->resultado->datos->paginas);
    $pagina = intval($result->resultado->datos->SiguientePag)-1;
    if ($pagina == 0){
      $sql = "UPDATE inm_propiedades SET activo = 0, compartida = 0 WHERE id_empresa = '$id_empresa' ";
      $this->db->query($sql);
    }
    $x=0;
    
    foreach ($result->resultado->fichas as $p) {

      $sql = "SELECT * FROM inm_propiedades WHERE codigo = '$p->in_num' AND id_empresa = '$id_empresa' ";
      $q = $this->db->query($sql);
      
      if ($q->num_rows()==0) {
        $coor = explode(",", $p->in_coo);
        $latitud = $coor[0];
        $longitud = $coor[1];

        if ($p->in_tip == "C"){
          $tipo_inmueble = 1; 
        } elseif ($p->in_tip == "T") {
          $tipo_inmueble = 7; 
        } elseif ($p->in_tip == "D") {
          $tipo_inmueble = 2;
        } elseif ($p->in_tip == "O") {
          $tipo_inmueble = 11;
        } elseif ($p->in_tip == "H") {
          $tipo_inmueble = 13;
        } elseif ($p->in_tip == "L") {
          $tipo_inmueble = 9;
        } elseif ($p->in_tip == "G") {
          $tipo_inmueble = 8;
        } else {
          $tipo_inmueble = 2; 
        }

        if ($p->operacion == "Venta"){
          $tipo = 1;
        } elseif ($p->operacion == "Alquiler"){
          $tipo = 2;
        } else {
          $tipo = 1;
        }

        $obs = utf8_decode($p->in_obs);
        $p->in_cal = str_replace("''", "", $p->in_cal);
        $path = $result->resultado->img[$x][0];
        $codigo = "JYB".$p->in_num;
        $sql = "INSERT INTO inm_propiedades (";
        $sql.= "codigo, texto, codigo_xintel, id_empresa, id_tipo_inmueble, id_tipo_operacion, id_tipo_estado, moneda, precio_final, path, latitud, longitud, ";
        $sql.= "dormitorios, cocheras, banios, ambientes, superficie_cubierta, superficie_total, superficie_descubierta, superficie_semicubierta, calle, numero, activo, compartida) ";
        $sql.= "VALUES ('$p->in_num', '$obs', '$codigo', $id_empresa, $tipo_inmueble, $tipo, 1, '$p->alquiler_moneda', '$p->in_val', '$path', '$latitud', '$longitud', ";
        $sql.= "'$p->dormitorios', '$p->in_coc', '$p->in_ban', '$p->ambientes_num', '$p->in_m01', '$p->in_sto', '$p->in_m02', '$p->in_m03', '$p->in_cal', '$p->in_nro', 1, 1); ";

        $this->db->query($sql);
      } else {
        if ($p->operacion == "Venta"){
          $tipo = 1;
        } elseif ($p->operacion == "Alquiler"){
          $tipo = 2;
        } else {
          $tipo = 1;
        }
        $obs = utf8_decode($p->in_obs);
        $path = $result->resultado->img[$x][0];
        $sql = "UPDATE inm_propiedades SET id_tipo_operacion = '$tipo', moneda = '$p->alquiler_moneda', ";
        $sql.= "precio_final = '$p->in_val', path = '$path', texto = '$obs', ";
        $sql.= "dormitorios = '$p->dormitorios', cocheras = '$p->in_coc', banios = '$p->in_ban', ambientes = '$p->ambientes_num', ";
        $sql.= "superficie_cubierta = '$p->in_m01', superficie_total = '$p->in_sto', superficie_descubierta = '$p->in_m02', ";
        $sql.= "superficie_semicubierta = '$p->in_m03', calle = '$p->in_cal', numero = '$p->in_nro', activo = 1, compartida = 1 ";
        $sql.= "WHERE id_empresa = $id_empresa AND codigo = '$p->in_num' ";
        $this->db->query($sql);
      }
      $x++;
    }
    if ($pagina < $total_paginas){
      $url = "http://xintel.com.ar/api/?json=resultados.fichas&suc=JYB&apiK=4m17zq256jvsm24wOnqbev43y&page=".($pagina+1);
      $this->importar_xintel($url);
    }
  }

}
