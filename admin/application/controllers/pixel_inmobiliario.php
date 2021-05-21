<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Pixel_inmobiliario extends REST_Controller {
    
    function import(){
      set_time_limit(0);
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
      $url = "http://www.antoninipropiedades.com/";
      $config["url"] = $url;
      $id = $this->get_id($config);
      $config["id"] = $id;
      $links = $this->get_links($config);
      $config["links"] = $links;
      $data = $this->get_data($config);
      
    }
    function get_id($config = array()){
      $url = isset($config["url"]) ? $config["url"] : ""; //llega link anto
      $html = file_get_contents($url);
      $dom = new DOMDocument();
      libxml_use_internal_errors(true);
      $dom->loadHTML($html);
      $finder = new DomXPath($dom);
      $id = $finder->query("//div[@class='dropdown-menu']//a/@href"); //search for the id of the page
      $link = $id["length"]->textContent; //filter link
      $id = strpos($link,"?"); //search for ? 
      $idd = strpos($link,"&",$id); //search for &
      $idd = $id - $idd;
      $id = substr($link,$id+1,$idd-1); //extract the id
      return $id;
    }
    function get_links($config = array()){
      $url = isset($config["url"]) ? $config["url"] : ""; 
      $id = isset($config["id"]) ? $config["id"] : ""; 
      $count = 0;
      $i=1;
      $array_propierties = array();
      while($count < 9999){
        //Seleciion de link de opagina. Se podria pasar un parametro link sin el page= para que sea 100% dinamico
        $link = "http://www.antoninipropiedades.com/listing?user_id=157&page=".$i;
        $html = file_get_contents($link);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        $finder = new DomXPath($dom);
        // Buscamos los links de cada propiedad
        $nodes = $finder->query("//div[@class='thumbnail_one mb_30 color-secondery']//a");
        if($nodes->length != 0){ // porque si no se encuenta nada length es 0
          foreach ($nodes as $node) {
            if(in_array($node->getAttribute("href"), $array_propierties)){
            }else{
              $array_propierties[]= $node->getAttribute("href");
            }
          }
        }else{
          break;
        }
        $count=$count+1;
        $i=$i+1;
      } 
      return $array_propierties;
    }
    function get_data($config = array()){
      $links = isset($config["links"]) ? $config["links"] : array(); 
      print_r($links);
      foreach ($links as $key) {
        $imagen = array();

        $html = file_get_contents($key);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        $finder = new DomXPath($dom);
        $config = array();
        $config["link"] = $key;
       
        $atributes_top ="//div[contains(@class, 'property_single_top')]" ;
        $atributes_top_price = "//div[contains(@class, 'property-price')]";
        $atributes_top_place = "//div[contains(@class, 'btn-group d-flex')]";
        $atributes_center = "//div[contains(@id, 'gallery-1')]"; 
        $atributes_bottom = "//div[contains(@class, 'property_details')]";
        $location = "//div[contains(@class, 'map_widget')]";

        //Atributes 
        $title = $finder->query($atributes_top."//h5");
        $code = $finder->query($atributes_top."//h6");
        $direction = $finder->query($atributes_top."//p");
        $price = $finder->query($atributes_top_price."//p");
        $nose = $finder->query($atributes_top_price."//div");
        $description = $finder->query($atributes_bottom."//p");
        $location = $finder->query($location."//iframe");
        
        $location = $location[0]->getAttribute("src");
        
        $config["location"] = $location;
       
        $images = $finder->query($atributes_center."//img");
        
        foreach ($images as $key){
          $img = $key->getAttribute("src");
          $imagen[] = $img;
        }
        $config["images"] = $imagen;
        
        $description_place = $finder->query($atributes_top_place."//button");
        $data = array();
        foreach ($description_place as $key) {
          $data[] = $key->textContent;
        }
        $config["description_place"] = $data;


        $direction = $direction[0]->textContent;
        $config["direction"] = $direction;
        
        $price = $price[0]->textContent;
        $config["price"] = $price;
        
        $config["name"] =  $title[0]->textContent;
        $config["code"] = $code[0]->textContent;

        $config["property_type"] = $nose[0]->textContent; 
       
        $config["description"] = $description[0]->textContent;

        $this->filter_data($config);
       
      }
    }
    function filter_data($config = array()){
      $propiedades = new stdClass();
      $location = isset($config["location"]) ? $config["location"] : ""; //finish
      $images = isset($config["images"]) ? $config["images"] : array(); //finish
      $description_place = isset($config["description_place"]) ? $config["description_place"] : ""; //finish
      $direction = isset($config["direction"]) ? $config["direction"] : ""; //finish
      $price = isset($config["price"]) ? $config["price"] : ""; //finish
      $name = isset($config["name"]) ? $config["name"] : ""; //finish
      $code = isset($config["code"]) ? $config["code"] : ""; //finish
      $property_type = isset($config["property_type"]) ? $config["property_type"] : ""; //finish
      $description = isset($config["description"]) ? $config["description"] : ""; //finish
      $link = isset($config["link"]) ? $config["link"] : ""; //finish
      echo "<br>";
      
       
      echo "<br>";
      foreach ($description_place as $key){
        if(strpos($key,"Dormitorio") !== false ){
          $dormitorios = str_replace("Dormitorios","",$key);
          $propiedades->dormitorios = $dormitorios;
        }elseif(strpos($key,"Baño") !== false ) {
          $banios = str_replace("Baños","",$key);
          $propiedades->banios = $banios;
        }elseif(strpos($key,"M² Totales") !== false){
          $metros_totales = str_replace("M² Totales","",$key);
          $propiedades->superficie_total = $metros_totales;
        }elseif(strpos($key,"M² Cubiertos") !== false){
          $metros_cubiertos = str_replace("M² Cubiertos","", $key);
          $propiedades->superficie_cubierta = $metros_cubiertos;
        }elseif(strpos($key,"Ambientes") !== false){
          $ambientes = str_replace("Ambientes","",$key);
          $propiedades->ambientes = $ambientes;
        }
      }

      $a = strpos($location, "q=") + 2;
      $location = substr($location,$a); 
      $location = str_replace('&hl=es;z=14&output=embed'," ",$location);
      $location = explode(",",$location);
      
      $code = str_replace("Código: "," ",$code);
      $propiedades->codigo = $code;
      $propiedades->nombre = $name;
      $propiedades->latitud = $location[0];
      $propiedades->longitud = $location[1];
      $propiedades->inmobusquedas_url = $link;
      $propiedades->descripcion = $description;
     
      if($property_type=="Departamento"){
        $propiedades->id_tipo_inmueble = 2;
        }elseif($property_type=="Casa"){
          $propiedades->id_tipo_inmueble = 1;
        }elseif($property_type=="PH"){
          $propiedades->id_tipo_inmueble = 3;
        }elseif($property_type=="Oficina"){
          $propiedades->id_tipo_inmueble = 11;
        }elseif($property_type=="Lote"){
          $propiedades->id_tipo_inmueble = 7;
        }elseif($property_type=="Piso"){
          $propiedades->id_tipo_inmueble = 17;
        }elseif($property_type=="Dúplex"){
          $propiedades->id_tipo_inmueble = 15;
        }elseif($property_type=="Cochera"){
        $propiedades->id_tipo_inmueble = 13;
        }else{
          $propiedades->id_tipo_inmueble = 2;
        } 
      if(!empty($direction)){
        $calle = str_replace(" ", "..",$direction);
        $calle = str_replace(" ","..",$calle);
        $calle = explode(",",$calle);
        $calles = str_replace(".."," ",$calle[0]);
        $propiedades->calle = $calles;
      }
      if(isset($price)){
        if(strpos($price,'U$D')){
          $propiedades->moneda = 'U$S';
          $price = str_replace('U$D',"",$price);
          $price = str_replace(".","",$price);
          $propiedades->precio_final = $price;
        }else{
          $propiedades->moneda = '$';
          $price = str_replace('$',"",$price);
          $price = str_replace(".","",$price);
          $propiedades->precio_final = $price;
        }
      } 
      $direction = mb_strtolower($direction);
      if (strpos($direction, "casco urbano") !== FALSE) {
          $propiedades->id_localidad = 513;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "romero") !== FALSE) {
          $propiedades->id_localidad = 791;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "ringuelet") !== FALSE) {
          $propiedades->id_localidad = 776;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "san lorenzo") !== FALSE) {
          $propiedades->id_localidad = 5503;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "villa elvira") !== FALSE) {
          $propiedades->id_localidad = 5117;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "berisso") !== FALSE) {
          $propiedades->id_localidad = 5492;
          $propiedades->id_departamento = 66;
        } else if (strpos($direction, "gonnet") !== FALSE) {
          $propiedades->id_localidad = 396;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "hernández") !== FALSE) {
          $propiedades->id_localidad = 425;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "ensenada") !== FALSE) {
          $propiedades->id_localidad = 312;
          $propiedades->id_departamento = 117;
        } else if (strpos($direction, "gorina") !== FALSE) {
          $propiedades->id_localidad = 401;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "elisa") !== FALSE) {
          $propiedades->id_localidad = 946;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "san carlos") !== FALSE) {
          $propiedades->id_localidad = 5505;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "tolosa") !== FALSE) {
          $propiedades->id_localidad = 900;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "etcheverry") !== FALSE) {
          $propiedades->id_localidad = 326;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "berazategui") !== FALSE) {
          $propiedades->id_localidad = 122;
          $propiedades->id_departamento = 73;
        } else if (strpos($direction, "el retiro") !== FALSE) {
          $propiedades->id_localidad = 1624;
          $propiedades->id_departamento = 207;
        } else if (strpos($direction, "city bell") !== FALSE) {
          $propiedades->id_localidad = 205;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "pinamar") !== FALSE) {
          $propiedades->id_localidad = 725;
          $propiedades->id_departamento = 712;
        } else if (strpos($direction, "mar del plata") !== FALSE) {
          $propiedades->id_localidad = 600;
          $propiedades->id_departamento = 84;
        } else if (strpos($direction, "correas") !== FALSE) {
          $propiedades->id_localidad = 244;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "abasto") !== FALSE) {
          $propiedades->id_localidad = 10;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "arana") !== FALSE) {
          $propiedades->id_localidad = 56;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "olmos") !== FALSE) {
          $propiedades->id_localidad = 674;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "garibaldi") !== FALSE) {
          $propiedades->id_localidad = 948;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "el peligro") !== FALSE) {
          $propiedades->id_localidad = 5502;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "hornos") !== FALSE) {
          $propiedades->id_localidad = 5504;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "altos de san lorenzo") !== FALSE) {
          $propiedades->id_localidad = 5503;
          $propiedades->id_departamento = 9;
        } else if (strpos($direction, "hermosura") !== FALSE) {
          $propiedades->id_localidad = 5506;
          $propiedades->id_departamento = 9;
        }  else if (strpos($direction, "la plata") !== FALSE) {
          $propiedades->id_localidad = 513;
          $propiedades->id_departamento = 9;
        } else {
          $errores[] = "Localidad no encontrada [$link]";
        }
      
      print_r($propiedades);
      echo "fin";
    }

    function importar(){

      //$array_propierties= array("http://www.antoninipropiedades.com/ad/casa-en-venta-27");
      $limit_propierties = count($array_propierties);
      $count = 0; 
       
      $propierties = array(); 
      
      for ($i=0; $i < $limit_propierties; $i++) { 
        $imagen = array();
        //preguntar en cache
        $propiertiesss = new stdClass();
        $html = file_get_contents($array_propierties[$i]);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        $finder = new DomXPath($dom);
        $propiertiesss->inmobusquedas_url = $array_propierties[$i];
        $atributes_top ="//div[contains(@class, 'property_single_top')]" ;
        $atributes_top_price = "//div[contains(@class, 'property-price')]";
        $atributes_top_place = "//div[contains(@class, 'btn-group d-flex')]";
        $atributes_center = "//div[contains(@id, 'gallery-1')]"; 
        $atributes_bottom = "//div[contains(@class, 'property_details')]";
        $location = "//div[contains(@class, 'map_widget')]";

       

        $propiertiesss->nombre = "";
        $propiertiesss->codigo = 0;
        $propiertiesss->id_tipo_inmueble = 0;
        $propiertiesss->description = "";
        $propiertiesss->imagen = array();
        $propiertiesss->precio = 0;
        $propiertiesss->moneda = "";

        //Atributes 
        $title = $finder->query($atributes_top."//h5");
        $code = $finder->query($atributes_top."//h6");
        $direction = $finder->query($atributes_top."//p");
        $price = $finder->query($atributes_top_price."//p");
        $nose = $finder->query($atributes_top_price."//div");
        $description = $finder->query($atributes_bottom."//p");
        $location = $finder->query($location."//iframe");
        
        $location = $location[0]->getAttribute("src");
        $a = strpos($location, "q=") + 2;
        $location = substr($location,$a);
        $b = strpos($location,'&');
        $location = str_replace('&hl=es;z=14&output=embed'," ",$location);
        $location = explode(",",$location);
        $propiertiesss->latitud = $location[0];
        $propiertiesss->longitud = $location[1];
        $imagenes = $finder->query($atributes_center."//img");
       
        foreach ($imagenes as $key){
          $img = $key->getAttribute("src");
          $imagen[] = $img;
        }
        
        $description_place = $finder->query($atributes_top_place."//button");
        foreach($description_place as $key){
          $remplazamos_espacios = str_replace(" ", "",$key->textContent);
          $a = explode(" ", $remplazamos_espacios);
          if(strpos($a[0],"Dormitorio") !== false ){
            $dormitorios = str_replace("Dormitorios","",$a[0]);
            $propiertiesss->dormitorios = $dormitorios;
          }elseif(strpos($a[0],"Baño") !== false ) {
            $banios = str_replace("Baños","",$a[0]);
            $propiertiesss->banios = $banios;
          }elseif(strpos($a[0],"M²Totales") !== false){
            $metros_totales = str_replace("M²Totales","",$a[0]);
            $propiertiesss->superficie_total = $metros_totales;
          }elseif(strpos($a[0],"M²Cubiertos") !== false){
            $metros_cubiertos = str_replace("M²Cubiertos","", $a[0]);
            $propiertiesss->superficie_cubierta = $metros_cubiertos;
          }elseif(strpos($a[0],"Ambientes") !== false){
            $ambientes = str_replace("Ambientes","",$a[0]);
            $propiertiesss->ambientes = $ambientes;
          }
        }
        if(strpos($direction[0]->textContent,"La Plata")){
          $propiertiesss->id_localidad = 513;
          $calle = str_replace(" ", "..",$direction[0]->textContent);
          $calle = str_replace(" ","..",$calle);
          $calle = explode(",",$calle);
          $calles = str_replace(".."," ",$calle[0]);
          $propiertiesss->calle = $calles;
        }
        if(isset($price[0]->textContent)){
          if(strpos($price[0]->textContent,'U$D')){
            $propiertiesss->moneda = 'U$S';
            $price = str_replace('U$D',"",$price[0]->textContent);
            $price = str_replace(".","",$price);
            $propiertiesss->precio = $price;
          }else{
            $propiertiesss->moneda = '$';
            $price = str_replace('$',"",$price[0]->textContent);
            $price = str_replace(".","",$price);
            $propiertiesss->precio = $price;
          }
        }
        
        $propiertiesss->nombre = $title[0]->textContent;
        $code = str_replace("Código: "," ",$code[0]->textContent);
        $propiertiesss->codigo = $code;

        if($nose[0]->textContent=="Departamento"){
          $propiertiesss->id_tipo_inmueble = 2;
        }elseif($nose[0]->textContent=="Casa"){
          $propiertiesss->id_tipo_inmueble = 1;
        }elseif($nose[0]->textContent=="PH"){
          echo "hola";
          $propiertiesss->id_tipo_inmueble = 3;
        }elseif($nose[0]->textContent=="Oficina"){
          $propiertiesss->id_tipo_inmueble = 11;
        }elseif($nose[0]->textContent=="Lote"){
          $propiertiesss->id_tipo_inmueble = 7;
        }elseif($nose[0]->textContent=="Piso"){
          $propiertiesss->id_tipo_inmueble = 17;
        }elseif($nose[0]->textContent=="Duplex"){
          $propiertiesss->id_tipo_inmueble = 15;
        }elseif($nose[0]->textContent=="Cochera"){
          $propiertiesss->id_tipo_inmueble = 13;
        }
        
        $propiertiesss->description = $description[0]->textContent;
        $propiertiesss->imagen = $imagen;

        $propierties[] = $propiertiesss;
      }
      
    }
}