<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Inmobusquedas extends REST_Controller {

  // Recorremos todas las empresas, obtenemos la URL de la inmobiliaria que se esta sincronizando
  function importacion($id = 0) {
    set_time_limit(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $id = intval($id);
    $logging = 0;
    $sql = "SELECT * FROM web_configuracion WHERE url_web_inmobusqueda != '' ";
    if (!empty($id)) $sql.= "AND id_empresa = $id ";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
      try {
        $this->importa(array(
          "id_empresa" => $r->id_empresa,
          "url" => $r->url_web_inmobusqueda,
          "logging" => $logging,
        ));
      } catch(Exception $e) {
        echo $e->getMessage();
      }
    }
    echo json_encode(array("error"=>0));
  }

  function importa($config = array()) {
    
    $url = isset($config["url"]) ? $config["url"] : "";
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $logging = isset($config["logging"]) ? $config["logging"] : 1;

    $errores = array();
    $pages = 99999;
    $links = array();

    $this->load->model("Web_Configuracion_Model");
    $web_conf = $this->Web_Configuracion_Model->get($id_empresa);

    // Si no tiene configurado el ID de inmobusqueda
    if (empty($web_conf->inmobusqueda_id)) {
      $html = file_get_contents($url);
      $dom = new DOMDocument(); 
      libxml_use_internal_errors(true);
      $dom->loadHTML($html);
      $finder = new DomXPath($dom);
      $a = $finder->query("//div[contains(@id,'boxenviarmensaje')]//form//input/@id");
      if ($a["length"]->textContent != "eidam") {
        throw new Exception("Error: No tiene el campo hidden.");
      }
      $b = $finder->query("//div[contains(@id,'boxenviarmensaje')]//form//input/@value");
      $id = $b["length"]->textContent;

      // Seteamos el id de inmobusqueda para que la proxima sincronizacion ahorrarnos este paso
      $sql = "UPDATE web_configuracion SET inmobusqueda_id = $id WHERE id_empresa = $id_empresa ";
      $this->db->query($sql);

    } else {
      $id = $web_conf->inmobusqueda_id;
    }
    
    for ($i=1; $i <= $pages ; $i++) {
      $url = "https://www.inmobusqueda.com/perfil/perfil.resultados.php?pagina=$i&tipo=0&operacion=99&orden=1&publicada=0&dormitorios=99&disponible=200&provincia=0&ciudad=0&sobrecalle=&numero=&moneda=0&aptobanco=2&precio=0&preciohasta=10000000&dormitorios=99&dormitorios2=99&estado=99&estado2=99&antiguedad=200&antiguedad2=200&garage=7&eid=$id&eidc=&fichas=";
      $html = file_get_contents($url);
      $dom = new DOMDocument();
      libxml_use_internal_errors(true);
      $dom->loadHTML($html);
      $finder = new DomXPath($dom);
      if (strpos($dom->textContent, 'No hay resultados para su busqueda') === false) { 
        $a = $finder->query("//div[contains(@class,'cajaPremium2017')]//a/@href");
        foreach ($a as $key ) {
          if(!in_array($key->textContent, $links)){
            $links[]= $key->textContent;
          }
        }
      }else{
        break;
      }
    }

    $this->load->model("Propiedad_Model");
    $i=0;
    foreach($links as $link) {
      if ($logging==1) echo "Importando: $link <br/>";
      try {
        $s = $this->Propiedad_Model->importar_inmobusqueda(array(
          "id_empresa"=>$id_empresa,
          "link"=>$link,
        ));
        if (isset($s["errores"])) {
          $errores = array_merge($errores,$s["errores"]);
        }
        $i++;
      } catch(Exception $e) {
        echo $e->getMessage();
      }
    }
    if ($logging==1) echo "Propiedades importadas: $i";

    if (sizeof($errores)>0) {
      $body = implode("<br/>", $errores);
      require_once APPPATH.'libraries/Mandrill/Mandrill.php';
      mandrill_send(array(
        "to"=>"basile.matias99@gmail.com",
        "subject"=>"ERROR IMPORTACION INMOBUSQUEDA $id_empresa",
        "body"=>$body,
      ));
    }
  }
}