<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Realtyone extends REST_Controller
{
  private $subred = 1;
  private $id_empresa = 2807;
  private $tokko_apikey = "";
  private $errores = array();

  function __construct()
  {
    parent::__construct();
    $this->load->model('Propiedad_Model', 'modelo');
  }

  function get_tokko_properties($config = array()) {
    $type = (isset($config["type"]) ? $config["type"] : "property");
    $limit = 1000;
    $offset = 0;
    $url = "https://tokkobroker.com/api/v1/$type/?lang=es_ar&format=json&limit=".$limit."&offset=".$offset."&key=".$this->tokko_apikey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    $salida = json_decode($result);

    $this->load->model("Log_Model");
    $this->Log_Model->imprimir(array(
      "append" => 0, // Asi limpiamos el archivo de log
      "id_empresa" => $this->id_empresa,
      "file" => date("Ymd") . "_importacion_tokko.txt",
      "texto" => print_r($salida->objects,TRUE) . "\n\n",
    ));

    return $salida->objects;
  }

  private function marcar_importacion() {
    // Marcamos todas las propiedades en un principio, 
    // despues por cada propiedad vamos sacando la marca
    // y al final de todo, solo sacar aquellas que sigan marcadas
    $marca_importacion = date("YmdHis");
    $sql = "UPDATE inm_propiedades P ";
    $sql .= " INNER JOIN empresas E ON (P.id_empresa = E.id) ";
    $sql .= "SET P.marca_importacion = $marca_importacion ";
    $sql .= "WHERE E.subred = $this->subred ";
    $this->db->query($sql);
  }

  // IMPORTACION DE PROPIEDADES DE TOKKO BROKERS
  // Esta funcion se ejecuta en un cronjob
  function importar_tokko()
  {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    set_time_limit(0);

    include_once APPPATH . 'libraries/tokko/api.php';
    $this->load->model("Propiedad_Model");
    $this->load->helper("file_helper");
    $this->load->model("Log_Model");

    $properties = $this->get_tokko_properties();

    /*
    $emprendimientos = $this->get_tokko_properties(array(
      "type"=>"development"
    ));
    foreach($emprendimientos as &$emprendimiento) {
      $emprendimiento->id_tipo_operacion = 4;
    }

    // Juntamos ambos arrays
    $properties = array_merge($properties, $emprendimientos);
    */

    if (sizeof($properties) > 0) {
      // Marcamos todas las propiedades en un principio, 
      // despues por cada propiedad vamos sacando la marca
      // y al final de todo, solo sacar aquellas que sigan marcadas
      $this->marcar_importacion();
    }

    $this->Log_Model->imprimir(array(
      "id_empresa" => $this->id_empresa,
      "file" => date("Ymd") . "_importacion_tokko.txt",
      "texto" => "CANTIDAD DE PROPIEDADES A IMPORTAR: " . sizeof($properties) . "\n\n",
    ));

    foreach ($properties as $property) {
      try {
        $this->importar_propiedad($property);
      } catch (Exception $e) {
        $this->errores[] = $e->getMessage();
      }
    } // Fin FOR propiedades

    // Si hay errores, nos lo mandamos por email
    if (sizeof($this->errores) > 0) {
      $body = implode("<br/>", $this->errores);
      require_once APPPATH . 'libraries/Mandrill/Mandrill.php';
      mandrill_send(array(
        "to" => "basile.matias99@gmail.com",
        "subject" => "ERROR IMPORTACION TOKKO",
        "body" => $body,
      ));
    } else {
      echo json_encode(array("error" => 0));
    }
  }

  private function importar_propiedad($property) {

    $this->load->model("Log_Model");
    $this->load->model("Propiedad_Model");
    $this->load->model("Empresa_Model");

    $this->Log_Model->imprimir(array(
      "id_empresa" => $this->id_empresa,
      "file" => date("Ymd") . "_importacion_tokko.txt",
      "texto" => print_r($property, TRUE) . "\n\n",
    ));

    $email_empresa = $property->branch->email;
    $empresa = $this->Empresa_Model->get_empresa_by_email($email_empresa);

    if ($empresa === false) {
      throw new Exception("No se encuentra la cuenta de $email_empresa");
    }

    if ($empresa->subred != $this->subred) {
      // La empresa obtenida no pertenece a la subred de REALTY ONE
      throw new Exception("La empresa de $email_empresa no pertenece a la subred de REALTY ONE");
    }

    $p = new stdClass();
    $p->id_empresa = $empresa->id;
    $p->nombre = $property->publication_title;

    $p->codigo = $property->reference_code;
    $p->codigo = preg_replace("/[^0-9.]/", "", $p->codigo);

    $p->id_tipo_estado = 1; // Disponible
    $p->calle = isset($property->real_address) ? $property->real_address : $property->address;
    $p->altura = "";
    $p->piso = "";
    $p->numero = "";
    $p->banios = isset($property->bathroom_amount) ? $property->bathroom_amount : 0;
    $p->texto = $property->description;
    $p->latitud = $property->geo_lat;
    $p->longitud = $property->geo_long;
    $p->tokko_id = $property->id;
    $p->tokko_url = (isset($property->public_url) ? $property->public_url : "");
    $p->dormitorios = (isset($property->suite_amount) ? $property->suite_amount : 0);
    $p->ambientes = (isset($property->room_amount) ? $property->room_amount : 0);
    $p->cocheras = isset($property->parking_lot_amount) ? $property->parking_lot_amount : 0;
    $p->superficie_cubierta = isset($property->roofed_surface) ? $property->roofed_surface : 0;
    $p->superficie_semicubierta = isset($property->semiroofed_surface) ? $property->semiroofed_surface : 0;
    $p->superficie_descubierta = isset($property->unroofed_surface) ? $property->unroofed_surface : 0;
    $p->superficie_total = isset($property->total_surface) ? $property->total_surface : 0;
    $p->zoom = 17;
    $p->activo = 1;

    // TAGS
    $tags = $property->tags;
    if (sizeof($tags) > 0) {
      foreach ($tags as $t) {
        if ($t->name == "Agua Corriente") $p->servicios_agua_corriente = 1;
        else if ($t->name == "Cloaca") $p->servicios_cloacas = 1;
        else if ($t->name == "Gas Natural") $p->servicios_gas = 1;
        else if ($t->name == "Electricidad") $p->servicios_electricidad = 1;
        else if ($t->name == "Pavimento") $p->servicios_asfalto = 1;
        else if ($t->name == "Telefono") $p->servicios_telefono = 1;
        else if ($t->name == "Cable") $p->servicios_cable = 1;
        else if ($t->name == "Balcón") $p->balcon = 1;
        else if ($t->name == "Apto crédito") $p->apto_banco = 1;
      }
    }

    // ID_TIPO_OPERACION
    if (isset($property->operations)) {
      $operations = $property->operations;
      $operacion = $operations[0];
      if ($operacion->operation_type == "Venta") {
        $p->id_tipo_operacion = 1;
      } else if ($operacion->operation_type == "Alquiler") {
        $p->id_tipo_operacion = 2;
      } else {
        // OTRO TIPO DE OPERACION, POR EL MOMENTO NO LA PERMITIMOS
        continue;
      }
    } else if (isset($property->id_tipo_operacion)) {
      // Ya viene dentro del objeto (Ej. emprendimientos)
      $p->id_tipo_operacion = $property->id_tipo_operacion;
    }

    // PRECIO
    $p->publica_precio = 1;
    $p->precio_final = 0;
    if (isset($operacion->prices)) {
      foreach ($operacion->prices as $precio) {
        if ($precio->price > 0) {
          if ($precio->currency == "USD") $p->moneda = 'U$S';
          else $p->moneda = '$';
          $p->precio_final = $precio->price;
        }
      }
    }

    // TIPO PROPIEDAD
    $tipo = $property->type;
    $p->id_tipo_inmueble = 0;
    if ($tipo->name == "Departamento") $p->id_tipo_inmueble = 2;
    else if ($tipo->name == "Casa") $p->id_tipo_inmueble = 1;
    else if ($tipo->name == "Terreno") $p->id_tipo_inmueble = 7;
    else if ($tipo->name == "PH") $p->id_tipo_inmueble = 3;
    else if ($tipo->name == "Local") $p->id_tipo_inmueble = 9;
    else if ($tipo->name == "Galpón") $p->id_tipo_inmueble = 8;
    else if ($tipo->name == "Oficina") $p->id_tipo_inmueble = 11;
    else if ($tipo->name == "Cochera") $p->id_tipo_inmueble = 13;
    else if ($tipo->name == "Fondo de Comercio") $p->id_tipo_inmueble = 10;
    else if ($tipo->name == "Quinta") $p->id_tipo_inmueble = 5;
    else if ($tipo->name == "Campo") $p->id_tipo_inmueble = 6;
    else if ($tipo->name == "Depósito") $p->id_tipo_inmueble = 18;
    else if ($tipo->name == "Edificio Comercial") $p->id_tipo_inmueble = 23;
    else if ($tipo->name == "Hotel") $p->id_tipo_inmueble = 24;
    else if ($tipo->name == "Barrio Abierto") $p->id_tipo_inmueble = 4;
    else if ($tipo->name == "Barrio Privado") $p->id_tipo_inmueble = 4;
    else if ($tipo->name == "Edificio") $p->id_tipo_inmueble = 28;
    else if ($tipo->name == "Edificio de oficinas") $p->id_tipo_inmueble = 23;
    else if ($tipo->name == "Nave Industrial") $p->id_tipo_inmueble = 19;
    else {
      // Si no esta definica el tipo de propiedad, lo ponemos como error
      $this->errores[] = "ERROR NO SE ENCUENTRA TIPO INMUEBLE: <br/>" . $tipo->name . "<br/>";
    }

    // LOCALIDAD
    $location = $property->location;
    $p->id_localidad = 0;
    $p->id_departamento = 0;
    $p->id_provincia = 1;
    $p->id_pais = 1;
    if ($location->name == "La Plata" || $location->name == "Villa Parque Sicardi" || $location->id == 26524) $p->id_localidad = 513;
    else if ($location->name == "City Bell") $p->id_localidad = 205;
    else if ($location->name == "Berisso" || $location->name == "Los Talas") $p->id_localidad = 5492;
    else if ($location->name == "Bme Bavio Gral Mansilla") $p->id_localidad = 111;
    else if ($location->name == "Pilar") $p->id_localidad = 723;
    else if ($location->name == "Manuel B Gonnet") $p->id_localidad = 396;
    else if ($location->name == "Tolosa") $p->id_localidad = 900;
    else if ($location->name == "Villa Elvira") $p->id_localidad = 5117;
    else if ($location->name == "Abasto") $p->id_localidad = 10;
    else if ($location->name == "Costa Esmeralda") $p->id_localidad = 3249;
    else if ($location->name == "Ringuelet") $p->id_localidad = 776;
    else if ($location->name == "Nueva Hermosura") $p->id_localidad = 5506;
    else if ($location->name == "San Bernardo Del Tuyu") $p->id_localidad = 812;
    else if ($location->name == "Mar Del Tuyu") $p->id_localidad = 601;
    else if ($location->name == "San Clemente Del Tuyu") $p->id_localidad = 815;
    else if ($location->name == "Ensenada") $p->id_localidad = 312;
    else if ($location->name == "Villa Gesell") $p->id_localidad = 951;
    else if ($location->name == "Necochea") $p->id_localidad = 655;
    else if ($location->name == "Mar De Ajo") $p->id_localidad = 599;
    else if (strpos(mb_strtolower($location->short_location), "punta del este") !== FALSE) $p->id_localidad = 5499;
    else if ($location->name == "Los Hornos") $p->id_localidad = 5504;
    else if ($location->name == "Congreso") $p->id_localidad = 5493;
    else if ($location->name == "General Madariaga") $p->id_localidad = 365;
    else if ($location->name == "Joaquin Gorina") $p->id_localidad = 401;
    else if ($location->name == "Lisandro Olmos Etcheverry") $p->id_localidad = 674;
    else if ($location->name == "Guillermo E Hudson" || strpos($location->full_location, "Guillermo E Hudson") !== FALSE) $p->id_localidad = 431;
    else if ($location->name == "Coronel Brandsen" || strpos($location->full_location, "Coronel Brandsen") !== FALSE) $p->id_localidad = 231;

    else if ($location->name == "Miami Beach") $p->id_localidad = 5500;
    else if ($location->name == "El Palmar") $p->id_localidad = 5511;
    else if (strpos(mb_strtolower($location->short_location), "palermo soho") !== FALSE) $p->id_localidad = 5482;
    else if (strpos(mb_strtolower($location->short_location), "flores sur") !== FALSE) $p->id_localidad = 5478;
    else if (strpos(mb_strtolower($location->short_location), "palermo hollywood") !== FALSE) $p->id_localidad = 5482;

    // Si no se encuentra el nombre exacto, pero la ubicacion completa contiene el nombre de La Plata
    else if (strpos($location->full_location, "La Plata") !== FALSE) $p->id_localidad = 513;

    else {
      // Sino buscamos por nombre
      $sql = "SELECT L.*, D.id_provincia, D.id AS id_departamento, P.id_pais ";
      $sql .= " FROM com_localidades L ";
      $sql .= " INNER JOIN com_departamentos D ON (L.id_departamento = D.id) ";
      $sql .= " INNER JOIN com_provincias P ON (D.id_provincia = P.id) ";
      $sql .= "WHERE L.nombre = '$location->name' LIMIT 0,1 ";
      $qq = $this->db->query($sql);
      if ($qq->num_rows() > 0) {
        $rr = $qq->row();
        $p->id_localidad = $rr->id;
        $p->id_departamento = $rr->id_departamento;
        $p->id_provincia = $rr->id_provincia;
        $p->id_pais = $rr->id_pais;
      }
    }

    // Si no se encontro una localidad, lo ponemos como error
    if (empty($p->id_localidad)) {
      $this->errores[] = "ERROR NO SE ENCUENTRA LOCALIDAD: <br/>" . $location->name . "<br/>";
    } else {
      // Obtenemos los otros datos de la localidad para estar seguros de que completamos todos los datos de ubicacion en el panel
      $sql = "SELECT L.*, D.id_provincia, D.id AS id_departamento, P.id_pais ";
      $sql .= " FROM com_localidades L ";
      $sql .= " INNER JOIN com_departamentos D ON (L.id_departamento = D.id) ";
      $sql .= " INNER JOIN com_provincias P ON (D.id_provincia = P.id) ";
      $sql .= "WHERE L.id = $p->id_localidad LIMIT 0,1 ";
      $qq = $this->db->query($sql);
      if ($qq->num_rows() > 0) {
        $rr = $qq->row();
        $p->id_departamento = $rr->id_departamento;
        $p->id_provincia = $rr->id_provincia;
        $p->id_pais = $rr->id_pais;
      }
    }

    $p->images = array();
    $images = $property->photos;
    if (sizeof($images) > 0) {
      $ppal = $images[0];
      $p->path = $ppal->image;
      foreach ($images as $im) {
        if (empty($im->image)) continue;
        $p->images[] = $im->image;
      }
    }

    // Si tiene video
    if (isset($property->videos) && is_array($property->videos) && sizeof($property->videos)>0) {
      $v1 = $property->videos[0];
      $p->video = $v1->player_url;
    }

    // Consultamos si la propiedad ya esta subida
    $sql = "SELECT * FROM inm_propiedades WHERE tokko_id = '" . $property->id . "' AND id_empresa = $p->id_empresa ";
    $q = $this->db->query($sql);
    $p->no_controlar_plan = 1;
    
    if ($q->num_rows() > 0) {
      $r = $q->row();
      $p->id = $r->id;
      $p->es_oferta = $r->es_oferta;
      $p->id_usuario = $r->id_usuario;
      $p->no_controlar_codigo = 1;
      $p->fecha_importacion = date("Y-m-d H:i:s");
      $this->Propiedad_Model->save($p);

    } else {
      $p->fecha_ingreso = date("Y-m-d");
      $p->fecha_publicacion = date("Y-m-d");
      $p->fecha_importacion = date("Y-m-d H:i:s");
      $p->id = $this->Propiedad_Model->save($p);
    }
  }

}
