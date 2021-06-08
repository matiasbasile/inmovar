<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Adinco extends REST_Controller {

    function import(){
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
      $url = "https://www.giachinopropiedades.com.ar/";
      $links = $this->get_links($url);
      if($links=="vacio"){
        $links = $this->get_links_v2($url);
        foreach($links as $key){
          $get_data = $this->get_data_v2($key);
        }
      }else{
        foreach ($links as $key) {
          $get_data = $this->get_data($key,$url);
        }
      }
      
    }
    function get_data_v2($link){
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
      $propiedad = new stdClass();
      $url = $link;
      $html = file_get_contents($url);
      $dom = new DOMDocument();
      libxml_use_internal_errors(true);
      $dom->loadHTML($html);
      $finder = new DomXPath($dom);
      $principal =$finder->query("//div[@class='col-xs-12 col-sm-8']//div[@class='col-sm-8']");
      $direction = $finder->query("//div[@class='col-xs-12 col-sm-8']//div[@class='col-sm-8']/div");
      $property_type = $finder->query("//div[@class='col-xs-12 col-sm-8']//div[@class='col-sm-8']/h2");
      $calle = $finder->query("//div[@class='col-xs-12 col-sm-8']//div[@class='col-sm-8']/h1");
      $precio = $finder->query("//div[@class='col-xs-12 col-sm-8']//div[@class='col-sm-8']/span");
      $file_body ="//div[@class='file_body']";
      $image = $finder->query($file_body."//div[@class='col-sm-8']//img");
      $covered_area = $finder->query($file_body."//div[@class='options']//div[@class='col-sm-6']//strong");
      $description = $finder->query($file_body."//p");
      $servises = $finder->query($file_body."//div[@class='col-sm-12 col-md-4']/h2");
      $data_servises = $finder->query($file_body."//div[@class='col-sm-12 col-md-4']/ul");
      $geolocation = $finder->query("//div[@class='col-sm-4 file_sidebar no-print']//div[@class='left']//iframe/@src");
      $geolocation = $geolocation["length"]->textContent;
      $imagen=array();
      foreach ($image as $key){
        $img = $key->getAttribute("src");
        $imagen[] = $img;
      }
      
      $location =strpos($geolocation,"&ll=");
      $location = substr($geolocation,$location+4);
      $location = str_replace("&output=embed"," ",$location); 
      $location = explode(",",$location);

      $propiedad->inmobusquedas_url = $url; 
      $propiedad->latitud = $location[0];
      $propiedad->longitud = $location[1];
      $propiedad->calle = $calle["length"]->textContent;
      $propiedad->id_localidad = $this->location($direction["length"]->textContent);
      $propiedad->id_tipo_inmueble = $this->property_type($property_type["length"]->textContent,1); 
      $property_type= explode("-",$property_type["length"]->textContent);
      foreach ($property_type as $key){
      
        if(strpos($key,"Dorm") !== false ){
          $dormitorios = explode("																	",$key);
          $dormitorios = str_replace("Dorm","",$dormitorios[1]);
          $propiedad->dormitorios = $dormitorios; 
        }elseif(strpos($key,"Baño") !== false ) {
          $banios = str_replace("Baño","",$key);
          $propiedad->banios = $banios;
        }elseif(strpos($key,"Mts2") !== false){
          $metros_totales = str_replace("Mts2","",$key);
          $propiedad->superficie_total = $metros_totales;
        }
      }
      $precio = explode(" ",$precio["length"]->textContent);
      if($precio[0] == 'U$D'){
        $propiedad->moneda = 'U$S';
      }else{
        $propiedad->moneda = '$';
      }
      $propiedad->precio_final = str_replace(".","",$precio[1]); 

     
      foreach ($data_servises as $key) {
        
        $data = explode("																			",$key->textContent);
        foreach ($data as $d ){
          if(strpos($d,"Agua Corriente") !== false){
            $propiedad->servicios_agua_corriente = 1;
          }elseif(strpos($d,"Electricidad" )!== false){
            $propiedad->servicios_electricidad = 1;
          }elseif(strpos($d,"Internet" )!== false){
            $propiedad->servicios_internet = 1;
          }elseif(strpos($d,"Patio" )!== false){
            $propiedad->patio = 1;
          }elseif(strpos($d, "Gas") !== false){
            $propiedad->servicios_gas = 1;
          }elseif(strpos($d,"Cloacas" )!== false){
            $propiedad->servicios_cloacas = 1;
          }elseif(strpos($d,"Pavimento")!== false){
            $propiedad->servicios_asfalto = 1;
          }elseif(strpos($d,"Telefono")!== false){
            $propiedad->servicios_telefono = 1;
          }elseif(strpos($d,"Seguridad" )!== false){
            $propiedad->vigilancia = 1;
          }elseif(strpos($d,"Lavadero" )!== false){
            $propiedad->lavadero = 1;
          }elseif(strpos($d,"Parrilla" )!== false){
            $propiedad->parrilla = 1;
          }elseif(strpos($d,"Videocable") !== false){
            $propiedad->servicios_cable = 1;
          }elseif(strpos($d,"Balcon" )!== false){
            $propiedad->balcon = 1;
          }elseif(strpos($d,"Terraza" )!== false){
            $propiedad->terraza = 1;
          }
        }
      }

      $propiedad->texto = $description["length"]->textContent; 
      $propiedad->codigo = $covered_area["length"]->textContent;
      $propiedad->path = $imagen;
      

      return $propiedad;
    }
    function location($loc){
      $location = explode("," , $loc);
      $direction = mb_strtolower($location[2]); 
      if (strpos($direction, "casco urbano") !== FALSE) {
        return  513;
      } else if (strpos($direction, "romero") !== FALSE) {
        return  791;
      } else if (strpos($direction, "ringuelet") !== FALSE) {
        return  776;
      } else if (strpos($direction, "san lorenzo") !== FALSE) {
        return  5503;
      } else if (strpos($direction, "villa elvira") !== FALSE) {
        return  5117;
      } else if (strpos($direction, "berisso") !== FALSE) {
        return  5492;
      } else if (strpos($direction, "gonnet") !== FALSE) {
        return  396;
      } else if (strpos($direction, "hernández") !== FALSE) {
        return  425;
      } else if (strpos($direction, "ensenada") !== FALSE) {
        return  312;
      } else if (strpos($direction, "gorina") !== FALSE) {
        return  401;
      } else if (strpos($direction, "elisa") !== FALSE) {
        return  946;
      } else if (strpos($direction, "san carlos") !== FALSE) {
        return  5505;
      } else if (strpos($direction, "tolosa") !== FALSE) {
        return  900;
      } else if (strpos($direction, "etcheverry") !== FALSE) {
        return  326;
      } else if (strpos($direction, "berazategui") !== FALSE) {
        return  122;
      } else if (strpos($direction, "el retiro") !== FALSE) {
        return  1624;
      } else if (strpos($direction, "city bell") !== FALSE) {
        return  205;
      } else if (strpos($direction, "pinamar") !== FALSE) {
        return  725;
      } else if (strpos($direction, "mar del plata") !== FALSE) {
        return  600;
      } else if (strpos($direction, "correas") !== FALSE) {
        return  244;
      } else if (strpos($direction, "abasto") !== FALSE) {
        return  10;
      } else if (strpos($direction, "arana") !== FALSE) {
        return  56;
      } else if (strpos($direction, "olmos") !== FALSE) {
        return  674;
      } else if (strpos($direction, "garibaldi") !== FALSE) {
        return  948;
      } else if (strpos($direction, "el peligro") !== FALSE) {
        return  5502;
      } else if (strpos($direction, "hornos") !== FALSE) {
        return  5504;
      } else if (strpos($direction, "altos de san lorenzo") !== FALSE) {
        return  5503;
      } else if (strpos($direction, "hermosura") !== FALSE) {
        return  5506;
      }  else if (strpos($direction, "la plata") !== FALSE) {
        return  513;
      } else {
        return 0;
      } 
    }
    function get_data($link,$url){
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
      $propiedad = new stdClass();
      $url = $url . $link;
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

    function property_type($title,$i){
      if($i = 1){
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
      }elseif($i = 0){
        
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
    function get_links_v2($url){
      $links = array();
      $a=1;
      while ($a <= 1 ){
        $urll = $url . "/home/properties". $page = ($a > 1 ) ? "/page:$a" : " "; 
        $html = file_get_contents($urll);
 
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        $finder = new DomXPath($dom);
        $segurity = $finder->query("//div[@class='content clearfix']//h1");
        
        $segurity = $segurity["length"]->textContent;
        if($segurity == "Resultados"){
          $link= $finder->query("//div[@class='list row']//a[@class='item']/@href");
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
        if($segurity["length"] != null){
          if($segurity["length"]->textContent == "Propiedades"){
            $link= $finder->query("//div[@class='listado']//a[@class='ampliar']/@href");
            foreach ($link as $key) {
              if(!in_array($key->textContent, $links)){
                $links[]= $key->textContent;
              }
            }
          }else{
            break;
          }
        }else{
          return "vacio";
          break;
        } 
        break;
        $a += 1;
      }
      return $links;
    }
    
}