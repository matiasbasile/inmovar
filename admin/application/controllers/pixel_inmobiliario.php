<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Pixel_inmobiliario extends REST_Controller {
    
    function importar(){
      set_time_limit(0);
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);

      $id_empresa = 1507;
      $errores = array();
      $cant_insert = 0;
      $this->load->helper("file_helper");
      $this->load->helper("fecha_helper");    

      // Este script procesa los archivos HTML cacheados
      // y analiza la estructura para volcarlos a la base nuestra

      // Recorremos los archivos TXT dentro de la carpeta cache
      $count= 0;
      $i=1;
      $array_propierties = array();
      while($count < 5){
        //Seleciion de link de opagina. Se podria pasar un parametro link sin el page= para que sea 100% dinamico
        $link= "http://www.antoninipropiedades.com/listing?user_id=157&purpose=sale&page=".$i;
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