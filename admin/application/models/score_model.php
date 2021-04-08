<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Score_Model extends Abstract_Model {
  
  function __construct() {
    parent::__construct("inm_propiedades","id","id ASC");
  }
  
  function calcular($conf = array()){

    //A calcular le llega un ID_EMPRESA y un ID
    $id_empresa = (isset($conf["id_empresa"])) ? $conf["id_empresa"] : -1;
    $id = (isset($conf["id"])) ? $conf["id"] : 0;
    $debug = (isset($conf["debug"])) ? $conf["debug"] : 0;

    $this->load->model("Propiedad_Model");
    //Obtenemos la cotizacion actual del dolar
    $dolar = $this->Propiedad_Model->get_dolar();
    //Si no llega un id, tomamos todas las propiedades de todas las empresas
    if ($id == 0){
      $propiedades = $this->Propiedad_Model->buscar(array("id_empresa"=>$id_empresa));
      
      foreach ($propiedades["results"] as $propiedad) {
        $propiedad->dolar = $dolar;
        $this->logica($propiedad,array(
        	"debug"=>$debug,
      	));
      }
      
      return "LISTO";
    //Si llega uno, solo tomamos esa propiedad
    } else {
      $propiedad = $this->Propiedad_Model->get($id, array("id_empresa"=>$id_empresa));
      $propiedad->dolar = $dolar;
      $score = $this->logica($propiedad,array(
        "debug"=>$debug,
      ));

      return $score;
    }
  }

  function logica($propiedad,$config = array()) {
  	$debug = (isset($config["debug"])) ? $config["debug"] : 0;
    //Conseguimos el AVG
    $sql = "SELECT AVG(precio_final/superficie_total) as avg FROM inm_propiedades WHERE precio_final != 0 AND superficie_total != 0 AND moneda = '".'U$S'."'";
    $q = $this->db->query($sql);
    $q = $q->row();

    //Si por alguan razon la propiedad viene sin ID y ID_EMPRESA
    if ($propiedad->id != 0 && $propiedad->id_empresa != 0) {
      //Inicializamos la variable modificador, que aumentara o restara dependiendo la ficha de su propiedad
      //Si aumenta es negativo, si resta es positivo
      $modificador = 0;
      if ($debug == 1) echo "<h1>Propiedad ID: $propiedad->id</h1>";
      //Si la propiedad tiene superficie total y y el precio es de mas de 100, la division entre estas 2 va a ser la base inicial
      if ($propiedad->superficie_total != 0 && $propiedad->precio_final >= 100){
        //Pasamos los pesos a dolares para que los numeros sean mas pequeños
        if ($propiedad->moneda == "$") $propiedad->precio_final = $propiedad->precio_final/$propiedad->dolar;
        $base = $propiedad->precio_final/$propiedad->superficie_total;
        if ($debug == 1) echo "0-1) $propiedad->id inicializo con una base de $base <br>";
      //Sino, la base inicial es el AVG 1*5
      } else {
        $base = round($q->avg)*1.5;
        if ($debug == 1) echo "0-2) $propiedad->id inicializo con una base de $base <br>";
      }


      //Si la propiedad tiene video
      if ($propiedad->video != "") $modificador += -15;
      if ($debug == 1) echo "Video $modificador <br>";
      //Si la propiedad tiene modelado 3d
      if ($propiedad->pint != "") $modificador += -5;
      if ($debug == 1) echo "3D $modificador <br>";

      $img = sizeof($propiedad->images);
      //Si no tiene imagenes penalizamos
      if ($img == 0) {
        $modificador += 50;
      } elseif ($img >= 1 && $img <= 4) {
        $modificador += -1;
      } elseif ($img >= 5 && $img <= 9) {
        $modificador += -4;
      } elseif ($img >= 10 && $img <= 14) {
        $modificador += -6;
      } elseif ($img >= 15){
        $modificador += -10;
      }

      if ($debug == 1) echo "Imagenes ($img) $modificador <br>";

      //Le sacamos las tags a la descripcion
      $texto = strip_tags($propiedad->texto);
      $len = strlen($texto);

      if ($len == 0) {
        $modificador += 20;
      } elseif ($len >= 100 && $len <= 249) {
        $modificador += -2;
      } elseif ($len >= 250 && $len <= 499) {
        $modificador += -4;
      } elseif ($len >= 500) {
        $modificador += -10;
      }

      if ($debug == 1) echo "Texto ($len) $modificador <br>";
      //Si el precio es menor que 100 penalizamos
      if ($propiedad->precio_final < 100) $modificador += 50;
      if ($debug == 1) echo "Precio final $modificador <br>";
      //Si no tiene localidad penalizamos
      if ($propiedad->id_localidad == 0) $modificador += 70;
      if ($debug == 1) echo "Localidad $modificador <br>";
      //Si no tiene direccion penalizamos
      if ($propiedad->calle == "" && $propiedad->altura == "") $modificador += 50;
      if ($debug == 1) echo "Direccion $modificador <br>";
      //Si es terreno, galpon, cochera, campo, edificio industiral calculamos frente y fondo
      if ($propiedad->id_tipo_inmueble == 7 || $propiedad->id_tipo_inmueble == 8 || $propiedad->id_tipo_inmueble == 13 || $propiedad->id_tipo_inmueble == 6 || $propiedad->id_tipo_inmueble == 19){
        if ($propiedad->mts_fondo != 0) $modificador += -5;
        if ($propiedad->mts_frente != 0) $modificador += -5;
        if ($debug == 1) echo "Fondo | Frente $modificador <br>";
      } else {
        //Si no, calculamos dormitorios, ambientes y baños
        if ($propiedad->ambientes == 0) $modificador += 3;
        if ($propiedad->dormitorios  == 0) $modificador += 3;
        if ($propiedad->banios == 0) $modificador += 3;
        if ($debug == 1) echo "Ambientes | Dormitorios | Banios $modificador <br>";
      }

      $score = $base*(1+($modificador/100));
      $score = round($score);

      //Actualizamos el puntaje
      $sql = "UPDATE inm_propiedades SET score = '$score' WHERE id = '$propiedad->id' AND id_empresa = '$propiedad->id_empresa' ";
      $this->db->query($sql);

      if ($debug == 1) echo "1-0) $propiedad->id ($propiedad->id_empresa) finalizo con un SCORE DE $score <br>";

      return $score;

    } else {
      return "ERROR: NO ID";
    }
  }
  
}