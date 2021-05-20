<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Adinco extends REST_Controller {

    function import(){
      $url = "https://www.aguirrebienesraices.com.ar/";
      $links = $this->get_links($url);
      foreach ($links as $key) {
        $get_data = $this->get_data($key);
      }
    }

    function get_links($url){
      $links = array();
      $a=1;
      while ($a <= 9999) {
        $urll = $url . "/home/properties". $page = ($a > 1 ) ? "/page:$a" : " "; 
        $html = file_get_contents($urll);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        $finder = new DomXPath($dom);
        $segurity = $finder->query("//div[@class='titulo']//h1");
      
        $segurity = $segurity["length"]->textContent;
        if($segurity == "Propiedades"){
          $link= $finder->query("//div[@class='listado']//a[@class='ampliar']/@href");
          foreach ($link as $key) {
            if(!in_array($key->textContent, $links)){
              $links[]= $key->textContent;
            }
          }
        }else{
          break;
        }
        $a += 1;
      } 
      return $links;

    }

    function get_data($link){
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
      $propiedad = new stdClass();
      $url = "https://www.aguirrebienesraices.com.ar". $link;
      $html = file_get_contents($url);
      $dom = new DOMDocument();
      libxml_use_internal_errors(true);
      $dom->loadHTML($html);
      $finder = new DomXPath($dom);
      $principal = "//div[@class='principal clearfix']";
      $data = "//div[@class='datos']";
      $image = "//div[@class='media clearfix']";
      $image = $finder->query($image."//img");
      $imagen = array();
      foreach ($image as $key){
        $img = $key->getAttribute("src");
        $imagen[] = $img;
      } 
      
  
        $data_info = $finder->query($principal.$data);
      
      $detail = "//div[@class='ficha']//div[@class='detalles']";
      $details = $finder->query($detail."//p");
      $details = $details["length"]->textContent;
      $title = $finder->query($principal.$data."//h4");
      $code = $finder->query($principal.$data."//p//span");
     
      $geolocation = $finder->query("//div[@class='detalles']//td//script");
      $latlng = strpos($html,"LatLng");
      $latlng = $latlng+7;
      //echo substr($html, $a);
      $latlngg = strpos($html,");",$latlng);
      $latlngg = $latlngg - $latlng;

      $latlngg = substr($html,$latlng,$latlngg); 
      $latlngg = explode(",",$latlngg);
      
      //Primary data section
      $length_ubication = strpos($data_info["length"]->textContent,"Ubicación");
      $length_province = strpos($data_info["length"]->textContent,"Provincia:");
      $length_direction = strpos($data_info["length"]->textContent,"Dirección");
      $length_cerca = strpos($data_info["length"]->textContent,"Cerca");
      $orientation = strpos($data_info["length"]->textContent,"Orientación :");
      $bedroom = strpos($data_info["length"]->textContent,"Dormitorios:");
      $bath = strpos($data_info["length"]->textContent,"Baños:");
      $covered_area = strpos($data_info["length"]->textContent,"Sup Cubierta						:");
      $antiquity = strpos($data_info["length"]->textContent,"Antigüedad:");
      $price = strpos($data_info["length"]->textContent,"Precio:");
      $provision = strpos($data_info["length"]->textContent,"Disposición :");
      
      $ubication = $length_province-$length_ubication;
      $province = $length_direction - $length_province;
      $direction =$length_cerca- $length_direction;
      $bedroomm = $bath-$bedroom;
      $bathh = $covered_area - $bath;
      $covered_areaa = $antiquity - $covered_area;
      $pricee = $provision - $price;

      $ubication = substr($data_info["length"]->textContent, $length_ubication,$ubication);
      $province = substr($data_info["length"]->textContent, $length_province,$province); 
      $direction = substr($data_info["length"]->textContent, $length_direction,$direction);
      $bedroom = substr($data_info["length"]->textContent, $bedroom,$bedroomm);
      $bath = substr($data_info["length"]->textContent, $bath,$bathh);
      $covered_area = substr($data_info["length"]->textContent, $covered_area,$covered_areaa);
      $price = substr($data_info["length"]->textContent, $price);

      $array = array("Ubicación:","Dirección					:","Dormitorios:","Baños:","Sup Cubierta						:","Precio:");
      $data = array($ubication,$direction,$bedroom,$bath,$covered_area,$price); 
      //echo $province;
      $a= $this->replace($data,$array);
      
      $ser = $finder->query($detail."//li");
     
      $property_type = $this->property_type($title["length"]->textContent);
      $operation_types = $this->operation_types($title["length"]->textContent);
      $code = explode("-",$code["length"]->textContent);


      $propiedad->nombre = $title["length"]->textContent;
      $propiedad->codigo = $code[1]; 
      $propiedad->descripcion = $details;
      $propiedad->id_tipo_inmueble = $property_type;
      $propiedad->id_tipo_operacion = $operation_types;
      if(strpos($price,'U$D')>0){
        $propiedad->moneda = 'U$S';
        $price = str_replace('Precio:',"",$price);
        $price = str_replace('.',"",$price);
        $propiedad->precio_final =  str_replace('U$D',"",$price);

      }else{
        $propiedad->moneda = "$";
        $price = str_replace('Precio:',"",$price);
        $price = str_replace('.',"",$price);
        $propiedad->precio_final =  str_replace('$',"",$price);
      }
      $propiedad->calle = str_replace("Dirección					:","",$direction);
      $propiedad->dormitorios = str_replace("Dormitorios:","",$bedroom);
      $propiedad->banios = str_replace("Baños:","",$bath);
      $covered_area= str_replace("Sup Cubierta						:","",$covered_area);
      $propiedad->superficie_cubierta = str_replace("Mts2","",$covered_area);
      foreach ($ser as $key) {
        if($key->textContent == "Agua Corriente"){
          $propiedad->servicios_agua_corriente = 1;
        }elseif($key->textContent == "Electricidad"){
          $propiedad->servicios_electricidad = 1;
        }elseif($key->textContent == "Electricidad"){
          $propiedad->servicios_electricidad = 1;
        }elseif($key->textContent == "Patio"){
          $propiedad->patio = 1;
        }elseif($key->textContent == "Balcon"){
          $propiedad->balcon = 1;
        }elseif($key->textContent == "Gas"){
          $propiedad->servicios_gas = 1;
        }elseif($key->textContent == "Cloacas"){
          $propiedad->servicios_cloacas = 1;
        }elseif($key->textContent == "Pavimento"){
          $propiedad->servicios_asfalto = 1;
        }elseif($key->textContent == "Telefono"){
          $propiedad->servicios_telefono = 1;
        }elseif($key->textContent == "Seguridad"){
          $propiedad->vigilancia = 1;
        }elseif($key->textContent == "Lavadero"){
          $propiedad->lavadero = 1;
        }elseif($key->textContent == "Parrilla"){
          $propiedad->parrilla = 1;
        }elseif($key->textContent == "Pileta"){
          $propiedad->piscina = 1;
        }
      }
      $propiedad->latitud = $latlngg[0];
      $propiedad->longitud = $latlngg[1];
      $propiedad->imagen = $imagen;
      print_r($propiedad);
      return $propiedad; 
    }

    function replace($data,$r){

      $response = array();
      for ($i=0; $i < count($data) ; $i++) { 
       $response[] = str_replace($r[$i]," ",$data[$i]);
      }
      return $response;
    }

    function property_type($title){
      if(strpos($title,"Casa")>0){
        return 1;
      }elseif(strpos($title,"Departamento")>0){
        return 2;
      }elseif(strpos($title,"PH")>0){
        return 3;
      }elseif(strpos($title,"Country")>0){
        return 4;
      }elseif(strpos($title,"Quinta")>0){
        return 5;
      }elseif(strpos($title,"Campo")>0){
        return 6;
      }elseif(strpos($title,"Terreno")>0){
        return 7;
      }elseif(strpos($title,"Galpon")>0){
        return 8;
      }elseif(strpos($title,"Local")>0){
        return 9;
      }elseif(strpos($title,"Fondo de Comercio")>0){
        return 10;
      }elseif(strpos($title,"Oficina")>0){
        return 11;
      }elseif(strpos($title,"Cochera")>0){
        return 13;
      }elseif(strpos($title,"Hotel")>0){
        return 20;
      }elseif(strpos($title,"Edificio")>0){
        return 2;
      }elseif(strpos($title,"Negocio Especial")>0){
        return 10;
      }elseif(strpos($title,"Emprendimiento")>0){
        return 2;
      }else{
        return 2;
      }

    }

    function operation_types($title){
      if(strpos($title,"Venta")>0){
        return 1;
      }elseif(strpos($title,"Alquiler")>0){
        return 2;
      }elseif(strpos($title,"Alquiler temporario")>0){
        return 3;
      }else{
        return 1;
      }
    }
    
    
}