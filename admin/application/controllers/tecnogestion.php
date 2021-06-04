<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Tecnogestion extends REST_Controller {

  function import(){
    set_time_limit(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $url = "https://www.fernandezber.com.ar";
    $links = $this->get_link($url);
    foreach($links as $link){
      $get_data = $this->get_data($url,$link);
    }
    
  }

  function get_link($url){
    $a = 1;
    $i=1;
    $links = array();
    $ch = curl_init("https://www.fernandezber.com.ar/Buscar/Inmuebles/");
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
    $respuesta = curl_exec ($ch);
    //o el error, por si falla
    $error = curl_error($ch);
    //y finalmente cerramos curl
    curl_close ($ch);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($respuesta);
    $finder = new DomXPath($dom);
    $segurity = $finder->query("//form[@class='searchForm hidden-xs']//input/@value");

    $segurity = explode(" ",$segurity["length"]->textContent);
    $segurity = $segurity[0] / 8;
    $segurity = round($segurity,0,PHP_ROUND_HALF_UP);
    while ($a<$segurity) {
      $ch = curl_init("$url/Buscar/CargaMasInmueblesParam");
      curl_setopt ($ch, CURLOPT_POST, 1);
      curl_setopt ($ch, CURLOPT_POSTFIELDS,"Pagina=$i&Orden=8&SucursalID=null&Operacion=&Producto=&Ubicacion=&PrecioDesde=&PrecioHasta=&IncluirEmprendimientos=1&Dormitorios=&Antiguedad=&DescripcionBusqueda=&ConCochera=null&AptoProfesional=null&ConBalcon=null&ConBalconTerraza=null&ConDependencia=null&Amoblado=null&ConVigilancia=null&Mapa=false&Geolocalizacion=&AptoCreditoHipotecario=false");
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
      $respuesta = curl_exec ($ch);
      //o el error, por si falla
      $error = curl_error($ch);
      //y finalmente cerramos curl
      curl_close ($ch);
      
      $html = @file_get_contents($respuesta);
      $dom = new DOMDocument();
      libxml_use_internal_errors(true);
      @$dom->loadHTML($respuesta);
      $finder = new DomXPath($dom);
      $link = $finder->query("//div[@class='col-lg-12 col-md-12']//a[@class='propertyImgLink']/@href"); 
      
      foreach ($link as $key){
        if(!in_array($key->textContent, $links)){
          $links[] = $key->textContent;
        }
      }
      $i++;
      $a++;
    }
    return $links;
  }
  
  function get_data($url,$link){
    $propiedades = new stdClass();
    $image = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_URL,"$url.$link");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
    $respuesta = curl_exec($ch);
    curl_close($ch);
    
    $html = @file_get_contents($respuesta);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($respuesta);
    $finder = new DomXPath($dom); 
    $images = $finder->query("//div[@class='col-lg-9 col-md-9']//div[@class='fotorama']//img/@src");
    foreach($images as $key){
      if(!in_array($key->textContent, $image)){
        $image[] = $key->textContent;
      }
    } 
    $propiedades->path = $image;
    $propierty_data = $finder->query("//div[@class='col-md-4']//ul[@class='overviewList']//li");
    foreach($propierty_data as $datas){
      $type_data = $datas->childNodes["length"]->textContent;
      $data = $datas->lastChild->textContent;
      
      if($type_data == "Producto "){
        $propiedades->id_tipo_inmueble = $this->property_type($data);
      }elseif($type_data == "Operación "){
        $propiedades->id_tipo_operacion = $this->operation_types($data);
      }elseif($type_data == "Barrio "){
        $propiedades->id_localidad = $this->location($data);
      }elseif($type_data == "Baños "){
        $propiedades->banios = $data;
      }/*elseif($type_data == "Despachos "){
        //AMBIENTES
      }elseif($type_data == "Antigüedad "){
        // PREGUNTAR
      }elseif($type_data == "Estado "){
        //como se llama en la tabla "muy bueno" "exelente" etc
      }elseif($type_data == "Orientación "){
        // como se llama en la tabla 
      }elseif($type_data == "Disposición"){
        
      } */elseif($type_data == "Sup. Total "){
        $data = explode(",",$data);
        $propiedades->superficie_total = $data[0];
      }elseif($type_data == "Sup. Cubierta "){
        $data = explode(",",$data);
        $propiedades->superficie_cubierta = $data[0];
      }elseif($type_data == "Sup. Descubierta "){
        $data = explode(",",$data);
        $propiedades->superficie_descubierta = $data[0];
      }elseif($type_data == "Dormitorios "){
        $propiedades->dormitorios = $data[0];
      }elseif($type_data == "Sup. Semi Cubierta "){
        $data = explode(",",$data);
        $propiedades->superficie_semidescubierta = $data[0];
      }elseif($type_data == "Cocheras "){
        $propiedades->cocheras = $data;
      }elseif($type_data == "Frente Lote "){
        $data = explode(",",$data);
        $propiedades->mts_frente = $data[0];
      }elseif($type_data == "Fondo Lote "){
        $data = explode(",",$data);
        $propiedades->mts_fondo = $data[0];
      }
      
    }
    $price = $finder->query("//div[@class='col-md-8 contenido-inmueble']//p[@class='price']");
    //print_r($propierty_data2["length"]->textContent);
    $price = explode(" ",$price["length"]->textContent);
    if($price[0] == 'U$S'){
      $propiedades->moneda = 'U$S';
      $propiedades->precio_final = str_replace(".","",$price[1]);
    }else{
      $propiedades->moneda = '$';
      $propiedades->precio_final = str_replace(".","",$price[1]);
    }
    
    $direction = $finder->query("//div[@class='col-md-8 contenido-inmueble']//h1[@class='direccion']");
    echo "<br>";
    $propiedades->calle = $direction["length"]->textContent;

    $description = $finder->query("//div[@class='col-md-8 contenido-inmueble']//p[@class='contenido-observaciones']");
    
    $propiedades->texto = $description["length"]->textContent;
    return $propiedades;
  }
  function property_type($data){
    if($data=="Casa"){
      return 1;
    }elseif($data=="Departamento"){
      return 2;
    }elseif($data=="PH"){
      return 3;
    }elseif($data=="Country"){
      return 4;
    }elseif($data=="Quinta"){
      return 5;
    }elseif($data=="Campo"){
      return 6;
    }elseif($data=="Terreno"){
      return 7;
    }elseif($data=="Galpon"){
      return 8;
    }elseif($data=="Local"){
      return 9;
    }elseif($data=="Fondo de Comercio"){
      return 10;
    }elseif($data=="Oficina"){
      return 11;
    }elseif($data=="Cochera"){
      return 13;
    }elseif($data=="Hotel"){
      return 20;
    }elseif($data=="Edificio"){
      return 2;
    }elseif($data=="Negocio Especial"){
      return 10;
    }elseif($data=="Emprendimiento"){
      return 2;
    }else{
      return 2;
    }
  }
  function operation_types($data){
    if($data=="Venta"){
      return 1;
    }elseif($data=="Alquiler"){
      return 2;
    }elseif($data=="Alquiler temporario"){
      return 3;
    }else{
      return 1;
    }
  }
  function location($data){
    $direction = mb_strtolower($data);
    if ($direction == "casco urbano"){
      return  513;
    } else if ($direction == "romero"){
      return  791;
    } else if ($direction == "ringuelet"){
      return  776;
    } else if ($direction == "san lorenzo"){
      return  5503;
    } else if ($direction == "villa elvira"){
      return  5117;
    } else if ($direction == "berisso"){
      return  5492;
    } else if ($direction == "gonnet"){
      return  396;
    } else if ($direction == "hernández"){
      return  425;
    } else if ($direction == "ensenada"){
      return  312;
    } else if ($direction == "gorina"){
      return  401;
    } else if ($direction == "elisa"){
      return  946;
    } else if ($direction == "san carlos"){
      return  5505;
    } else if ($direction == "tolosa"){
      return  900;
    } else if ($direction == "etcheverry"){
      return  326;
    } else if ($direction == "berazategui"){
      return  122;
    } else if ($direction == "el retiro"){
      return  1624;
    } else if ($direction == "city bell"){
      return  205;
    } else if ($direction == "pinamar"){
      return  725;
    } else if ($direction == "mar del plata"){
      return  600;
    } else if ($direction == "correas"){
      return  244;
    } else if ($direction == "abasto"){
      return  10;
    } else if ($direction == "arana"){
      return  56;
    } else if ($direction == "olmos"){
      return  674;
    } else if ($direction == "garibaldi"){
      return  948;
    } else if ($direction == "el peligro"){
      return  5502;
    } else if ($direction == "hornos"){
      return  5504;
    } else if ($direction == "altos de san lorenzo"){
      return  5503;
    } else if ($direction == "hermosura"){
      return  5506;
    }  else if ($direction == "la plata"){
      return  513;
    } else {
      return 0;
    }
  }
}
?>