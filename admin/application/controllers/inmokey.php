<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Inmokey extends REST_Controller {

  function file_get_content($url) {
    $html = file_get_contents($url);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $finder = new DomXPath($dom);
    return $dom;
  }

  function get_all_data() {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://websites-api.inmokey.com/properties?pageSize=9999&pageNumber=1&sorting=&viewType=grid&show_map=false&image_sizes%255B%255D=200x200&image_sizes%255B%255D=300x300&transactionType=2&_cid=12394',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_USERAGENT =>'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'authority: websites-api.inmokey.com',
        'method: GET',
        'path: /properties?pageSize=12&pageNumber=1&sorting=&viewType=grid&show_map=false&image_sizes%5B%5D=200x200&image_sizes%5B%5D=300x300&transactionType=2&_cid=12394',
        'origin: https://www.fabeiropropiedades.com.ar',
        'Referer: https://www.fabeiropropiedades.com.ar/',
        'x-auth-domain: fabeiropropiedades.com.ar'
      ),
    ));

    $response = curl_exec($curl);
    if ($response == false) {
      throw new Exception("Error al iniciar el Scrapper");
    }
    $response = json_decode($response);
    curl_close($curl);
    return $response->content;
  }

  function get_data($config = array()) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : 0;
    $all_data = $this->get_all_data();
    $i = 0;
    $this->load->model("Propiedad_Model");
    foreach ($all_data as $data) {
      $propiedad = new stdClass();
      $propiedad->codigo = $data->id;
      $sql = "SELECT id FROM inm_propiedades WHERE id_empresa = $id_empresa AND codigo = '$data->id' ";
      $q = $this->db->query($sql);
      if ($q->num_rows() == 0) $propiedad->id = 0;
      else {
        $r = $q->row();
        $propiedad->id = $r->id;
      }
      $propiedad->id_empresa = $id_empresa;
      $propiedad->nombre = $data->title;
      $propiedad->id_tipo_inmueble = $this->property_type($data->property_type->name);
      $propiedad->id_tipo_operacion = $this->operation_types($data->transaction_type->name);
      if($data->currency->name != ""){
        if ($data->currency->name == "USD") {
          $propiedad->moneda = 'U$S';
        }else{
          $propiedad->moneda = '$';
        }
      }
      
      $propiedad->simbolo_moneda = $data->expenses_currency->name;
      $propiedad->calle = $data->address;
      $propiedad->piso = "";
      $propiedad->numero = "";
      $propiedad->altura = "";
      $propiedad->zoom = 16;
      if ($data->address_number != "") {
        $propiedad->altura = $data->address_number;
      }
      if (isset($data->google_map_data->lat_lng)) {
        $map = explode(",", $data->google_map_data->lat_lng);
        $propiedad->latitud = $map[0];
        $propiedad->longitud = $map[1];
      }
      $propiedad->id_localidad = $this->location($data->city->name);
      $propiedad->id_provincia = $this->province($data->state->name);
      $propiedad->id_pais = $this->country($data->country->name);
      $propiedad->descripcion = $data->short_description;
      $propiedad->habitaciones = $data->rooms;
      $propiedad->ambientes = $data->bedrooms;
      $propiedad->banios = $data->bathrooms;
      $propiedad->valor_expensas = $data->expenses;
      $propiedad->garage = $data->garages;
      $propiedad->superficie_total = $data->m2;
      $propiedad->superficie_cubierta = $data->m2_covered;

      isset($data->year) ? $propiedad->year = $data->year : "";
      $propiedad->precio_final = $data->price;

      foreach ($data->amenities as $amenities) {
        $this->comodidades($propiedad,$amenities);
      }

      $propiedad->images = array();
      foreach ($data->images as $image) {
        $propiedad->images[] = $image->original;
      }

      $this->Propiedad_Model->save($propiedad);
      $i++;
    }
  }

  function comodidades($propiedad,$data){
    if ($data->name == "Balcón") {
      $propiedad->balcon = 1;
    } elseif ($data->name == "Patio") {
      $propiedad->patio = 1;
    } elseif ($data->name == "Gas natural") {
      $propiedad->servicios_gas = 1;
    } elseif ($data->name == "Agua corriente") {
      $propiedad->servicios_agua_corriente = 1;
    } elseif ($data->name == "Pavimento") {
      $propiedad->servicios_asfalto = 1;
    } elseif ($data->name == "Luz") {
      $propiedad->servicios_electricidad = 1;
    } elseif ($data->name == "Teléfono") {
      $propiedad->servicios_telefono = 1;
    } elseif ($data->name == "Video cable") {
      $propiedad->servicios_cable = 1;
    } elseif ($data->name == "Parrilla") {
      $propiedad->parrilla = 1;
    } elseif ($data->name == "Acepta mascotas") {
      $propiedad->permite_mascotas = 1;
    } elseif ($data->name == "Piscina") {
      $propiedad->piscina = 1;
    } elseif ($data->name == "Vigilancia") {
      $propiedad->vigilancia = 1;
    } elseif ($data->name == "Sala de juegos") {
      $propiedad->sala_juegos = 1;
    } elseif ($data->name == "Lavadero") {
      $propiedad->lavadero = 1;
    } elseif ($data->name == "Comedor") {
      $propiedad->living_comedor = 1;
    } elseif ($data->name == "Comedor diario") {
      $propiedad->living_comedor = 1;
    } elseif ($data->name == "Terraza") {
      $propiedad->terraza = 1;
    } elseif ($data->name == "Aire acondicionado") {
      $propiedad->servicios_aire_acondicionado = 1;
    } elseif ($data->name == "Internet") {
      $propiedad->servicios_internet = 1;
    }
  }

  function status($data){
    if ($data == "") {
      return false;
    }
    if ($data == "available") {
      return 1;
    }
  }

  function property_type($data){
    if ($data == "") {
      return false;
    }
    if ($data == "Casa") {
      return 1;
    } elseif ($data == "Departamento") {
      return 2;
    } elseif ($data == "PH") {
      return 3;
    } elseif ($data == "Country") {
      return 4;
    } elseif ($data == "Quinta") {
      return 5;
    } elseif ($data == "Campo") {
      return 6;
    } elseif ($data == "Terreno") {
      return 7;
    } elseif ($data == "Galpon") {
      return 8;
    } elseif ($data == "Local") {
      return 9;
    } elseif ($data == "Fondo de Comercio") {
      return 10;
    } elseif ($data == "Oficina") {
      return 11;
    } elseif ($data == "Cochera") {
      return 13;
    } elseif ($data == "Hotel") {
      return 20;
    } elseif ($data == "Edificio") {
      return 2;
    } elseif ($data == "Negocio Especial") {
      return 10;
    } elseif ($data == "Estancia") {
      return 5;
    } elseif ($data == "Casa Quinta") {
      return 22;
    } elseif ($data == "Duplex") {
      return 15;
    } elseif ($data == "Deposito") {
      return 18;
    } else {
      return 2;
    }
  }

  function operation_types($data){
    if ($data == "") {
      return false;
    }
    if ($data == "Venta") {
      return 1;
    } elseif ($data == "Alquiler") {
      return 2;
    } elseif ($data == "Alquiler temporario") {
      return 3;
    } else {
      return 1;
    }
  }

  function location($data){
    if ($data == "") {
      return false;
    }
    $direction = mb_strtolower($data);
    if ($direction == "casco urbano") {
      return  513;
    } elseif ($direction == "romero") {
      return  791;
    } elseif ($direction == "ringuelet") {
      return  776;
    } elseif ($direction == "san lorenzo") {
      return  5503;
    } elseif ($direction == "villa elvira") {
      return  5117;
    } elseif ($direction == "berisso") {
      return  5492;
    } elseif ($direction == "gonnet") {
      return  396;
    } elseif ($direction == "hernández") {
      return  425;
    } elseif ($direction == "ensenada") {
      return  312;
    } elseif ($direction == "gorina") {
      return  401;
    } elseif ($direction == "elisa") {
      return  946;
    } elseif ($direction == "san carlos") {
      return  5505;
    } elseif ($direction == "tolosa") {
      return  900;
    } elseif ($direction == "etcheverry") {
      return  326;
    } elseif ($direction == "berazategui") {
      return  122;
    } elseif ($direction == "el retiro") {
      return  1624;
    } elseif ($direction == "city bell") {
      return  205;
    } elseif ($direction == "pinamar") {
      return  725;
    } elseif ($direction == "mar del plata") {
      return  600;
    } elseif ($direction == "correas") {
      return  244;
    } elseif ($direction == "abasto") {
      return  10;
    } elseif ($direction == "arana") {
      return  56;
    } elseif ($direction == "olmos") {
      return  674;
    } elseif ($direction == "garibaldi") {
      return  948;
    } elseif ($direction == "el peligro") {
      return  5502;
    } elseif ($direction == "hornos") {
      return  5504;
    } elseif ($direction == "altos de san lorenzo") {
      return  5503;
    } elseif ($direction == "hermosura") {
      return  5506;
    } elseif ($direction == "la plata") {
      return  513;
    } else {
      return 0;
    }
  }

  function province($data){
    if($data == "") return FALSE;
    if($data == "Buenos Aires"){
      return 1;
    }
  }

  function country($data){
    if($data == "") return FALSE;
    if($data == "Argentina"){
      return 1;
    }
  }

  // Recorremos todas las empresas, obtenemos la URL de la inmobiliaria que se esta sincronizando
  function importacion($id_empresa) {
    set_time_limit(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $errores = array();
    try {
      $this->get_data(array(
        "id_empresa" => $id_empresa,
      ));
    } catch(Exception $e) {
      $errores[] = $e;
    }

    if (sizeof($errores)>0) {
      $body = implode("<br/>", $errores);
      echo $body;
      /*
      require_once APPPATH.'libraries/Mandrill/Mandrill.php';
      mandrill_send(array(
        "to"=>"basile.matias99@gmail.com",
        "subject"=>"ERROR IMPORTACION INMOKEY $id_empresa",
        "body"=>$body,
      ));
      */
    }    
  }

}