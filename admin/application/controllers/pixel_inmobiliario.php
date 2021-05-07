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
      
      for ($i=0; $i < 5; $i++) { 
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
        $propiertiesss->nose = "";
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
        echo "<br>";
        print_r($location);
        echo "<br>";
        $a = strpos($location, "q=") + 2;
        $location = substr($location,$a);
        $b = strpos($location,'&');
        echo "<br>";
        echo $a;
        echo "<br>";
        echo $b;
        echo "<br>";
        echo $location;
        echo "<br>";
        $location = str_replace('&hl=es;z=14&output=embed'," ",$location);
        $location = explode(",",$location);
        print_r($location);
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
        
        $propiertiesss->nose = $nose[0]->textContent;
        $propiertiesss->description = $description[0]->textContent;
        $propiertiesss->imagen = $imagen;

        $propierties[] = $propiertiesss;
      }
      print_r($propierties);
      
      
      
      
        
      


  
/*
        $nodes = $finder->query("//div[@id='listadoFo3tos']//a");
        foreach ($nodes as $node) {
          $imagen = $node->getAttribute("href");
          $cc = explode("/", $imagen);
          $filename = end($cc);
          //grab_image($imagen,"../importar/inmobusqueda/cache/$filename");
          $imagenes[] = "uploads/$id_empresa/propiedades/".$filename;
        }

        $propiedad->path = (sizeof($imagenes)>0) ? $imagenes[0] : "";
        $propiedad->nombre = "";
        $propiedad->superficie_total = "";
        $propiedad->direccion = "";
        $propiedad->precio_final = "";
        $propiedad->ciudad = "";

        // Buscamos el nombre
        $nodes = $finder->query("//div[contains(@class, 'nombresobreslide')]");
        foreach ($nodes as $node) {
          $i=0;
          foreach($node->childNodes as $c) {
            if ($i==0) $propiedad->nombre = trim($c->textContent);
            else if ($i==1) $propiedad->superficie_total = trim($c->textContent);
            else if ($i==3) {
              // Direccion y precio
              $j = 0;
              if ($c->hasChildNodes()) {
                foreach($c->childNodes as $cc) {
                  if ($j == 0) $propiedad->direccion = trim($cc->textContent);
                  else if ($j == 2) $propiedad->precio_final = trim($cc->textContent);
                  $j++;
                }
              }
            } else if ($i==5) {
              // Ciudad
              $propiedad->ciudad = $c->textContent;
            }
            $i++;
          }
        }

        $propiedad->atributos = array();

        $nodes = $finder->query("//*[contains(@class, 'detalleizquierda')]");
        foreach ($nodes as $node) {
          $propiedad->atributos[] = array(
            "propiedad"=>$node->textContent,
          );
          $node->parentNode->removeChild($node);
        }

        $nodes = $finder->query("//*[contains(@class, 'detallederecha')]");
        $i=0;
        foreach ($nodes as $node) {
          $propiedad->atributos[$i]["valor"] = $node->textContent;
          $node->parentNode->removeChild($node);
          $i++;
        }

        $nodes = $finder->query("//*[contains(@class, 'descripcion')]");
        $i=0;
        $propiedad->texto = "";
        foreach ($nodes as $node) {
          if ($i==1) { 
            foreach($node->childNodes as $c) {
              if ($c->nodeName == "#text") $propiedad->texto.= $c->textContent; 
            }
            break;
          }
          $i++;
        }
        $propiedad->texto = trim($propiedad->texto);

        // Si el titulo tiene la palabra Venta
        if (strpos($propiedad->nombre, "Venta")>0) {
          $propiedad->compartida = 1;
          $propiedad->id_tipo_operacion = 1;
        } else $propiedad->id_tipo_operacion = 2;

        // Dependiendo de las palabras clave del titulo
        $propiedad->id_tipo_inmueble = 0;
        if (strpos($propiedad->nombre, "Casa") !== FALSE) {
          $propiedad->id_tipo_inmueble = 1;
        } else if (strpos($propiedad->nombre, "Departamento") !== FALSE) {
          $propiedad->id_tipo_inmueble = 2;
        } else if (strpos($propiedad->nombre, "PH") !== FALSE) {
          $propiedad->id_tipo_inmueble = 3;
        } else if (strpos($propiedad->nombre, "Lote") !== FALSE) {
          $propiedad->id_tipo_inmueble = 7;
        } else if (strpos($propiedad->nombre, "Campo") !== FALSE) {
          $propiedad->id_tipo_inmueble = 6;
        } else if (strpos($propiedad->nombre, "Terreno") !== FALSE) {
          $propiedad->id_tipo_inmueble = 7;
        } else if (strpos($propiedad->nombre, "Galpon") !== FALSE || strpos($propiedad->nombre, "Galpón") !== FALSE) {
          $propiedad->id_tipo_inmueble = 8;
        } else if (strpos($propiedad->nombre, "Local") !== FALSE) {
          $propiedad->id_tipo_inmueble = 9;
        } else if (strpos($propiedad->nombre, "Oficina") !== FALSE) {
          $propiedad->id_tipo_inmueble = 11;
        } else if (strpos($propiedad->nombre, "Cochera") !== FALSE) {
          $propiedad->id_tipo_inmueble = 13;
        } else if (strpos($propiedad->nombre, "Monoambiente") !== FALSE) {
          $propiedad->id_tipo_inmueble = 2;
        } else if (strpos($propiedad->nombre, "Deposito") !== FALSE || strpos($propiedad->nombre, "Depósito") !== FALSE) {
          $propiedad->id_tipo_inmueble = 18;
        } else if (strpos($propiedad->nombre, "Duplex") !== FALSE || strpos($propiedad->nombre, "Dúplex") !== FALSE) {
          $propiedad->id_tipo_inmueble = 15;
        }

        // Acomodamos el precio y la moneda
        $propiedad->moneda = '$';
        $propiedad->publica_precio = 1;
        if (strpos($propiedad->precio_final, 'u$d') !== FALSE) {
          $propiedad->moneda = 'U$S';
          $propiedad->precio_final = str_replace('u$d', '', $propiedad->precio_final);
        } else if (strpos($propiedad->precio_final, "Consulte") !== FALSE) {
          $propiedad->publica_precio = 0;
          $propiedad->precio_final = 0;
        }
        $propiedad->precio_final = str_replace("$", "", $propiedad->precio_final);
        $propiedad->precio_final = str_replace(".", "", $propiedad->precio_final);
        $precio = explode(" ", $propiedad->precio_final);
        $propiedad->precio_final = $precio[0];

        // La superficie total puede tener la cantidad de dormitorios tmb
        $subtitulo = explode("   ", $propiedad->superficie_total);
        $propiedad->dormitorios = "";
        if (sizeof($subtitulo)>1) {
          $propiedad->dormitorios = $subtitulo[0];
          $propiedad->dormitorios = str_replace(" Dorm", "", $propiedad->dormitorios);
          $propiedad->superficie_total = $subtitulo[1];
          $propiedad->superficie_total = str_replace(" mts", "", $propiedad->superficie_total);
          $propiedad->superficie_total = str_replace(",", ".", $propiedad->superficie_total);
        }

        $propiedad->activo = 1;
        $propiedad->id_tipo_estado = 1; // Por defecto todas activas
        $propiedad->fecha_ingreso = date("Y-m-d");

        // Analizamos la ciudad
        $propiedad->id_localidad = 0;
        $propiedad->id_departamento = 0;
        if (strpos($propiedad->ciudad, "casco urbano") !== FALSE) {
          $propiedad->id_localidad = 513;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Romero") !== FALSE) {
          $propiedad->id_localidad = 791;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Ringuelet") !== FALSE) {
          $propiedad->id_localidad = 776;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "San Lorenzo") !== FALSE) {
          $propiedad->id_localidad = 5503;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Villa Elvira") !== FALSE) {
          $propiedad->id_localidad = 5117;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Berisso") !== FALSE) {
          $propiedad->id_localidad = 5492;
          $propiedad->id_departamento = 66;
        } else if (strpos($propiedad->ciudad, "Gonnet") !== FALSE) {
          $propiedad->id_localidad = 396;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Hernández") !== FALSE) {
          $propiedad->id_localidad = 425;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Ensenada") !== FALSE) {
          $propiedad->id_localidad = 312;
          $propiedad->id_departamento = 117;
        } else if (strpos($propiedad->ciudad, "Gorina") !== FALSE) {
          $propiedad->id_localidad = 401;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Elisa") !== FALSE) {
          $propiedad->id_localidad = 946;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "San Carlos") !== FALSE) {
          $propiedad->id_localidad = 5505;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Tolosa") !== FALSE) {
          $propiedad->id_localidad = 900;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Etcheverry") !== FALSE) {
          $propiedad->id_localidad = 326;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Correas") !== FALSE) {
          $propiedad->id_localidad = 244;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Abasto") !== FALSE) {
          $propiedad->id_localidad = 10;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Arana") !== FALSE) {
          $propiedad->id_localidad = 56;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Olmos") !== FALSE) {
          $propiedad->id_localidad = 674;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Garibaldi") !== FALSE) {
          $propiedad->id_localidad = 948;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "El Peligro") !== FALSE) {
          $propiedad->id_localidad = 5502;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Hornos") !== FALSE) {
          $propiedad->id_localidad = 5504;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "City Bell") !== FALSE) {
          $propiedad->id_localidad = 205;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Brandsen") !== FALSE) {
          $propiedad->id_localidad = 231;
          $propiedad->id_departamento = 32;
        } else if (strpos($propiedad->ciudad, "San Vicente") !== FALSE) {
          $propiedad->id_localidad = 840;
          $propiedad->id_departamento = 26;
        } else if (strpos($propiedad->ciudad, "San Vicente") !== FALSE) {
          $propiedad->id_localidad = 840;
          $propiedad->id_departamento = 26;
        } else if (strpos($propiedad->ciudad, "Chascomus") !== FALSE) {
          $propiedad->id_localidad = 197;
          $propiedad->id_departamento = 15;
        } else if (strpos($propiedad->ciudad, "Quilmes") !== FALSE) {
          $propiedad->id_localidad = 759;
          $propiedad->id_departamento = 74;
        } else if (strpos($propiedad->ciudad, "Quilmes") !== FALSE) {
          $propiedad->id_localidad = 759;
          $propiedad->id_departamento = 74;
        } else if (strpos($propiedad->ciudad, "Balvanera") !== FALSE) {
          $propiedad->id_localidad = 5473;
          $propiedad->id_departamento = 605;
        } else if (strpos($propiedad->ciudad, "Chapadmalal") !== FALSE) {
          $propiedad->id_localidad = 194;
          $propiedad->id_departamento = 84;
        } else if (strpos($propiedad->ciudad, "Alvear") !== FALSE) {
          $propiedad->id_localidad = 358;
          $propiedad->id_departamento = 116;
        } else if (strpos($propiedad->ciudad, "El Retiro") !== FALSE) {
          $propiedad->id_localidad = 1624;
          $propiedad->id_departamento = 207;
        } else if (strpos($propiedad->ciudad, "Hermosura") !== FALSE) {
          $propiedad->id_localidad = 5506;
          $propiedad->id_departamento = 9;
        } else if (strpos($propiedad->ciudad, "Pinamar") !== FALSE) {
          $propiedad->id_localidad = 725;
          $propiedad->id_departamento = 712;
        } else if (strpos($propiedad->ciudad, "Mar Azul") !== FALSE) {
          $propiedad->id_localidad = 951;
          $propiedad->id_departamento = 713;
        } else if (strpos(strtolower($propiedad->ciudad), "mar del plata") !== FALSE) {
          $propiedad->id_localidad = 600;
          $propiedad->id_departamento = 84;
        } else if (strpos(strtolower($propiedad->ciudad), "magdalena") !== FALSE) {
          $propiedad->id_localidad = 591;
          $propiedad->id_departamento = 36;
        } else if (strpos(strtolower($propiedad->ciudad), "haras del sur") !== FALSE) {
          $propiedad->id_localidad = 513;
          $propiedad->id_departamento = 9;
        }

        // Analizamos algunos atributos mas
        $propiedad->banios = 0;
        $propiedad->cocheras = 0;
        $propiedad->servicios_cloacas = 0;
        $propiedad->servicios_agua_corriente = 0;
        $propiedad->servicios_asfalto = 0;
        $propiedad->servicios_electricidad = 0;
        $propiedad->servicios_telefono = 0;
        $propiedad->servicios_cable = 0;
        $propiedad->superficie_cubierta = 0;
        $propiedad->ambientes = 0;

        foreach($propiedad->atributos as $atributo) {
          if ($atributo["propiedad"] == "Baños") {
            $propiedad->banios = $atributo["valor"];
          } else if ($atributo["propiedad"] == "Garage") {
            if ($atributo["valor"] == "Si" || strlen($atributo["valor"])>2) $propiedad->cocheras = 1;
          } else if ($atributo["propiedad"] == "Cloacas") {
            if ($atributo["valor"] == "Si") $propiedad->servicios_cloacas = 1;
          } else if ($atributo["propiedad"] == "Agua") {
            if ($atributo["valor"] == "Si") $propiedad->servicios_agua_corriente = 1;
          } else if ($atributo["propiedad"] == "Asfalto") {
            if ($atributo["valor"] == "Si") $propiedad->servicios_asfalto = 1;
          } else if ($atributo["propiedad"] == "Energia") {
            if ($atributo["valor"] == "Si") $propiedad->servicios_electricidad = 1;
          } else if ($atributo["propiedad"] == "Teléfono") {
            if ($atributo["valor"] == "Si") $propiedad->servicios_telefono = 1;
          } else if ($atributo["propiedad"] == "Cable") {
            if ($atributo["valor"] == "Si") $propiedad->servicios_cable = 1;
          } else if ($atributo["propiedad"] == "Superficie Construida") {
            $s = explode(" ", $atributo["valor"]);
            $propiedad->superficie_cubierta = $s[0];
          } else if ($atributo["propiedad"] == "Ambientes") {
            $propiedad->ambientes = (($atributo["valor"] == "-") ? 0 : $atributo["valor"]);
          }
        }

        if (!empty($propiedad->id_localidad)) {
          $sql = "SELECT * FROM com_localidades WHERE id = $propiedad->id_localidad ";
          $q_loc = $this->db->query($sql);
          if ($q_loc->num_rows() > 0) {
            $localidad = $q_loc->row();
            $localidad->nombre = ucwords(mb_strtolower($localidad->nombre));
            $propiedad->nombre = $propiedad->nombre." en ".$localidad->nombre;
          }
        } else {
          $errores[] = "COD: [$link] : No existe localidad $propiedad->ciudad.";
        }

        // INSERTAMOS EL OBJETO
        $insert_id = $this->modelo->save($propiedad);
        $hash = md5($insert_id);

        // Actualizamos el link
        $propiedad->link = "propiedad/".filename($propiedad->nombre,"-",0)."-".$insert_id."/";
        $this->db->query("UPDATE inm_propiedades SET link = '$propiedad->link', hash='$hash' WHERE id = $insert_id AND id_empresa = $id_empresa");

        // INSERTAMOS LAS IMAGENES
        $k=0;
        foreach($imagenes as $im) {
          $this->db->query("INSERT INTO inm_propiedades_images (id_empresa,id_propiedad,path,orden,plano) VALUES($id_empresa,$insert_id,'$im',$k,0)");
          $k++;
        }
        $cant_insert++;
      } */
    }
}