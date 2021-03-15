<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Importacion_Xintel_Model extends Abstract_Model {
  
  function __construct() {
    parent::__construct("inm_logs","id","id DESC");
  }

  private $array = [];
  private $errors = [];
    
  function importar_xintel($url =  "http://xintel.com.ar/api/?json=resultados.fichas&suc=JYB&apiK=4m17zq256jvsm24wOnqbev43y&page=0") {
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    set_time_limit(0);
    $this->load->model("Propiedad_Model");
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
      //if (!in_array($p->in_loc, $this->array)) $this->array[] = $p->in_loc;
      
      $sql = "SELECT * FROM inm_propiedades WHERE codigo = '$p->in_num' AND id_empresa = '$id_empresa' ";
      $q = $this->db->query($sql);
      
      if ($q->num_rows()==0) {

        
        $sql = "SELECT * FROM com_localidades WHERE nombre = '$p->in_loc' ";
        $l = $this->db->query($sql);
        if ($l->num_rows()==0){
          if ($p->in_loc == "Barrancas de Iraola"){
            $id_localidad = 538;
          } elseif ($p->in_loc == "Montevideo"){
            $id_localidad = 2607;
          } elseif ($p->in_loc == "Gonnet, Manuel B."){
            $id_localidad = 396;
          } elseif ($p->in_loc == "Brandsen"){
            $id_localidad = 2031;
          } elseif ($p->in_loc == "Hudson, Guillermo E."){
            $id_localidad = 431;
          } elseif ($p->in_loc == "Gorina, Joaquin"){
            $id_localidad = 401;
          } else {
            $id_localidad = 0;
          }
        } else {
          $loc = $l->row();
          $id_localidad = $loc->id;
        }

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
        $path_pro = $result->resultado->img[$x][0];
        $codigo = "JYB".$p->in_num;
        
        /*$sql = "INSERT INTO inm_propiedades (";
        $sql.= "codigo, texto, codigo_xintel, id_empresa, id_tipo_inmueble, id_tipo_operacion, id_tipo_estado, moneda, precio_final, path, latitud, longitud, ";
        $sql.= "dormitorios, cocheras, banios, ambientes, superficie_cubierta, superficie_total, superficie_descubierta, superficie_semicubierta, calle, numero, activo, compartida) ";
        $sql.= "VALUES ('$p->in_num', '$obs', '$codigo', $id_empresa, $tipo_inmueble, $tipo, 1, '$p->alquiler_moneda', '$p->in_val', '$path', '$latitud', '$longitud', ";
        $sql.= "'$p->dormitorios', '$p->in_coc', '$p->in_ban', '$p->ambientes_num', '$p->in_m01', '$p->in_sto', '$p->in_m02', '$p->in_m03', '$p->in_cal', '$p->in_nro', 1, 1); ";
        $this->db->query($sql);*/        
        $curl = "https://xintel.com.ar/api/?cache=12032021&json=fichas.propiedades&amaira=false&suc=JYB&global=LU3AIKPR4F6ZSUY8GQODKWRO8&emprendimiento=True&oppel=&esweb=&apiK=4m17zq256jvsm24wOnqbev43y&id=".$p->in_num."&_=1615575453648";
        $c = curl_init($curl);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $re = curl_exec($c);
        $re = json_decode($re);
        foreach ($re->resultado->img as $path){
          $images[] = $path;
        }
        //propiedad
        $pr = new stdClass();
        $pr->id = 0;
        $pr->codigo = $p->in_num;
        $pr->texto = $obs;
        $pr->codigo_xintel = $codigo;
        $pr->id_empresa = $id_empresa;
        $pr->id_tipo_inmueble = $tipo_inmueble;
        $pr->id_tipo_operacion = $tipo;
        $pr->id_tipo_estado = 1;
        $pr->moneda = $p->alquiler_moneda;
        $pr->precio_final = $p->in_val;
        $pr->path = $path_pro;
        $pr->latitud = $latitud;
        $pr->longitud = $longitud;
        $pr->dormitorios = $p->dormitorios;
        $pr->cocheras = $p->in_coc;
        $pr->banios = $p->in_ban;
        $pr->ambientes = $p->ambientes_num;
        $pr->superficie_cubierta = $p->in_m01;
        $pr->superficie_total = $p->in_sto;
        $pr->superficie_descubierta = $p->in_m02;
        $pr->superficie_semicubierta = $p->in_m03;
        $pr->calle = $p->in_cal;
        $pr->numero = $p->in_nro;
        $pr->activo = 1;
        $pr->compartida = 1;
        $pr->altura = $p->in_nro;
        $pr->piso = $p->in_pis;
        $pr->id_localidad = $id_localidad;
        $pr->images = $images;

        $this->Propiedad_Model->save($pr);

      } else {
        
        $data = $q->row();

        if ($p->operacion == "Venta"){
          $tipo = 1;
        } elseif ($p->operacion == "Alquiler"){
          $tipo = 2;
        } else {
          $tipo = 1;
        }
        $obs = utf8_decode($p->in_obs);
        $path_pro = $result->resultado->img[$x][0];
        
        /*$sql = "UPDATE inm_propiedades SET id_tipo_operacion = '$tipo', moneda = '$p->alquiler_moneda', ";
        $sql.= "precio_final = '$p->in_val', path = '$path', texto = '$obs', ";
        $sql.= "dormitorios = '$p->dormitorios', cocheras = '$p->in_coc', banios = '$p->in_ban', ambientes = '$p->ambientes_num', ";
        $sql.= "superficie_cubierta = '$p->in_m01', superficie_total = '$p->in_sto', superficie_descubierta = '$p->in_m02', ";
        $sql.= "superficie_semicubierta = '$p->in_m03', calle = '$p->in_cal', numero = '$p->in_nro', activo = 1, compartida = 1 ";
        $sql.= "WHERE id_empresa = $id_empresa AND codigo = '$p->in_num' ";
        $this->db->query($sql);*/

        $curl = "https://xintel.com.ar/api/?cache=12032021&json=fichas.propiedades&amaira=false&suc=JYB&global=LU3AIKPR4F6ZSUY8GQODKWRO8&emprendimiento=True&oppel=&esweb=&apiK=4m17zq256jvsm24wOnqbev43y&id=".$p->in_num."&_=1615575453648";
        $c = curl_init($curl);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $re = curl_exec($c);
        $re = json_decode($re);
        $orden = 1;

        $sql = "DELETE FROM inm_propiedades_images WHERE id_propiedad = $data->id AND id_empresa = $id_empresa ";
        $this->db->query($sql);

        $images = array();
        foreach ($re->resultado->img as $path){
          $images[] = $path;
        }

        //propiedad
        $pr = new stdClass();
        $pr->id = $data->id;
        $pr->id_tipo_inmueble = $data->id_tipo_inmueble;
        $pr->id_localidad = $data->id_localidad;
        $pr->id_empresa = $id_empresa;
        $pr->codigo = $data->codigo;
        $pr->id_tipo_operacion = $tipo;
        $pr->moneda = $p->alquiler_moneda;
        $pr->precio_final = $p->in_val;
        $pr->path = $path_pro;
        $pr->dormitorios = $p->dormitorios;
        $pr->cocheras = $p->in_coc;
        $pr->banios = $p->in_ban;
        $pr->ambientes = $p->ambientes_num;
        $pr->superficie_cubierta = $p->in_m01;
        $pr->superficie_total = $p->in_sto;
        $pr->superficie_descubierta = $p->in_m02;
        $pr->superficie_semicubierta = $p->in_m03;
        $pr->calle = $p->in_cal;
        $pr->numero = $p->in_nro;
        $pr->activo = 1;
        $pr->compartida = 1;
        $pr->altura = $p->in_nro;
        $pr->piso = $p->in_pis;
        $pr->texto = $obs;
        $pr->images = $images;

        $this->Propiedad_Model->save($pr);
      }
      $x++;
    }
    //Recursividad para que traiga todas las imagenes
    /*
    if ($pagina < $total_paginas){
      $url = "http://xintel.com.ar/api/?json=resultados.fichas&suc=JYB&apiK=4m17zq256jvsm24wOnqbev43y&page=".($pagina+1);
      $this->importar_xintel($url);
    }*/
  }

}
