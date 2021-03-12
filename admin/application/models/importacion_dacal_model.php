<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Importacion_Dacal_Model extends Abstract_Model {
  
  function __construct() {
    parent::__construct("inm_logs","id","id DESC");
  }
    
  function importar_dacal() {
    $id_empresa = 1502;
    $url = "https://www.dacalbienesraices.com.ar/json/propiedades.json";
    $c = curl_init($url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $result = curl_exec($c);
    $result = json_decode($result);
    foreach ($result as $p) {

      $sql = "UPDATE inm_propiedades SET activo = 0, compartida = 0 WHERE id_empresa = '$id_empresa' ";
      $this->db->query($sql);

      $sql = "SELECT id FROM inm_propiedades WHERE codigo_tokko = '$p->id' AND id_empresa = 'id_empresa' ";
      $q = $this->db->query($sql);
      if ($q->num_rows()==0) {


        $path = $this->decodificar_url_tokko($p->imgs[0], 1);
        $tipo = $p->ope[0]->t;
        $moneda = $p->ope[0]->m;
        if ($moneda == "USD" ){
          $moneda = "U$S";
        } else {
          $moneda = "$";
        }
        $valor = $p->ope[0]->v;

        if ($p->pt == 1){
          $tipo_inmueble = 7; 
        } elseif ($p->pt == 2) {
          $tipo_inmueble = 2; 
        } elseif ($p->pt == 3) {
          $tipo_inmueble = 1;
        } elseif ($p->pt == 4) {
          $tipo_inmueble = 5;
        } elseif ($p->pt == 5) {
          $tipo_inmueble = 11;
        } elseif ($p->pt == 7) {
          $tipo_inmueble = 9;
        } elseif ($p->pt == 8) {
          $tipo_inmueble = 19;
        } elseif ($p->pt == 9) {
          $tipo_inmueble = 6;
        } elseif ($p->pt == 10) {
          $tipo_inmueble = 13;
        } elseif ($p->pt == 11) {
          $tipo_inmueble = 19;
        } elseif ($p->pt == 12) {
          $tipo_inmueble = 19;
        } elseif ($p->pt == 13) {
          $tipo_inmueble = 3;
        } elseif ($p->pt == 14) {
          $tipo_inmueble = 18;
        } 

        $sql = "INSERT INTO inm_propiedades (";
        $sql.= "codigo_tokko, id_empresa, id_tipo_inmueble, id_tipo_operacion, id_tipo_estado, moneda, precio_final, path, latitud, longitud, ";
        $sql.= "link, dormitorios, cocheras, superficie_cubierta, superficie_total, calle, activo, compartida) ";
        $sql.= "VALUES ('$p->id', $id_empresa, $tipo_inmueble, $tipo, 1, '$moneda', '$valor', '$path', '$p->lat', '$p->lon', ";
        $sql.= "'$p->url', '$p->dm', '$p->co', '$p->sc', '$p->s', '$p->dir', 1, 1) ";

        $this->db->query($sql);
        $id = $this->db->insert_id();
        $x = 1;
        
        foreach ($p->imgs as $img) {
          $path = $this->decodificar_url_tokko($img);
          $sql = "INSERT INTO inm_propiedades_images ( ";
          $sql.= "id_empresa, id_propiedad, path, orden) VALUES ";
          $sql.= "($id_empresa, $id, '$path', '$x') ";
          $this->db->query($sql);
          $x++;
        }
      } else {
        
        $data = $q->row();
        $path = $this->decodificar_url_tokko($p->imgs[0], 1);
        $tipo = $p->ope[0]->t;
        $moneda = $p->ope[0]->m;
        if ($moneda == "USD" ){
          $moneda = "U$S";
        } else {
          $moneda = "$";
        }
        $valor = $p->ope[0]->v;

        $sql = "UPDATE inm_propiedades SET id_tipo_operacion = '$tipo', moneda = '$moneda', ";
        $sql.= "precio_final = '$valor', path = '$path', latitud = '$p->lat', longitud = '$p->long', ";
        $sql.= "link = '$p->url', dormitorios = '$p->dm', cocheras = '$p->co', superficie_cubierta = '$p->sc', ";
        $sql.= "superficie_total = '$p->s', calle = '$p->dir', activo = 1, compartida = 1 ";
        $sql.= "WHERE id_empresa = $id_empresa AND id = $data->id ";
        $this->db->query($sql);

        $sql = "DELETE FROM inm_propiedades_imagenes WHERE id_propiedad = $data->id AND id_empresa = $id_empresa ";
        $this->db->query($sql);
        $x = 1;

        foreach ($p->imgs as $img) {
          $path = $this->decodificar_url_tokko($img);
          $sql = "INSERT INTO inm_propiedades_images ( ";
          $sql.= "id_empresa, id_propiedad, path, orden) VALUES ";
          $sql.= "($id_empresa, $id, '$path', '$x') ";
          $this->db->query($sql);
          $x++;
        }

      }


    }

    echo "termino";
  }

  function decodificar_url_tokko($url, $thumb = 0){

    $url = str_replace('[DEM]' ,'https://dacalbienesraices.com.ar/dacal2019//imgs/emprendimientos/', $url);
    $url = str_replace('[STK]' ,'https://static.tokkobroker.com/thumbs/', $url);
    $url = str_replace('[tb.j]'  ,'_thumb.jpg', $url);

    // Descomprimimos imagenes
    $pos1 = strrpos($url, "[FF");
    if($pos1 > 0){
      $pos2 = strrpos($url, "]", $pos1);
      $val1 = $pos1+3;
      $val2 = ($pos2-$pos1)-3;
      $numeros_comprimidos = substr($url, $val1, $val2);
      //echo $numeros_comprimidos;
      $resultado = "";
      $numeros = explode(".", $numeros_comprimidos);
      for ($i=0; $i < sizeof($numeros) ; $i++) { 
        $re = "/^0+/";
        $m = preg_match($re, $numeros[$i], $matches) ? $matches[0] : '';
        //echo $m."<br>";
        $resultado = $resultado.$m.base_convert($numeros[$i], 36, 10);
        $resultado = strval($resultado);
      }

      $url = str_replace('[FF'.$numeros_comprimidos.']',$resultado, $url);
    }
    // ==========================
    if ($thumb == 0) {
      $url = str_replace('_thumb','', $url);
      $url = str_replace('/thumbs/','/pictures/', $url);
    }
    return $url;
  }

}
