<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Inmobusquedas extends REST_Controller {

  function importa(){
    $pages = 99999; //send as params
    $links = array(); //list of links from propierties
    $url = "https://www.inmobusqueda.com/alundincia"; //send as params
    $html = file_get_contents($url);
    $dom = new DOMDocument(); 
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $finder = new DomXPath($dom);
    $a = $finder->query("//div[contains(@id,'boxenviarmensaje')]//form//input/@id");
    $b = $finder->query("//div[contains(@id,'boxenviarmensaje')]//form//input/@value");
    $id = $b["length"]->textContent; //send as params
    
    if($a["length"]->textContent=="eidam"){
      for ($i=1; $i <= $pages ; $i++) { //amount of pages from the real estate
        $url = "https://www.inmobusqueda.com/perfil/perfil.resultados.php?pagina=$i&tipo=0&operacion=99&orden=1&publicada=0&dormitorios=99&disponible=200&provincia=0&ciudad=0&sobrecalle=&numero=&moneda=0&aptobanco=2&precio=0&preciohasta=10000000&dormitorios=99&dormitorios2=99&estado=99&estado2=99&antiguedad=200&antiguedad2=200&garage=7&eid=$id&eidc=&fichas=";
        $html = file_get_contents($url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        $finder = new DomXPath($dom);
        //verify what the content and that is not empty
        if (strpos($dom->textContent, 'No hay resultados para su busqueda') === false) { 
          $a = $finder->query("//div[contains(@class,'cajaPremium2017')]//a/@href");
          foreach ($a as $key ) {
            if(in_array($key->textContent, $links)){ //verify that is not repeated in the array
            }else{
              $links[]= $key->textContent; //if not repeated then to add 
            }
          }
        }else{
          break;
        }
      }
    }
  }
}