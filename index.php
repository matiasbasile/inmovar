<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ( extension_loaded( 'zlib' ) ) { ob_start( 'ob_gzhandler' ); }
ob_start();
if (session_status() == PHP_SESSION_NONE) {
  @session_start();
}
include("admin/params.php");
@include("admin/error_handler.php");

// 1) ANALIZAMOS LA URL
$dominio = strtolower($_SERVER["HTTP_HOST"]);
//$dominio = str_replace("www.","",$dominio);
$url = strtolower($_SERVER['REQUEST_URI']);
$url = str_replace(".php","",$url);
$url = (strpos($url,"/")==0) ? substr($url,1) : $url;

// ANALIZAMOS LA URL
$params = explode("/",$url);
$get_params = array();
$ultimo = end($params);
if (empty($ultimo) || strpos($ultimo,"?") === 0 || strpos($ultimo,"#") === 0) {
  if (strpos($ultimo,"?") == 0) {
    $ultimo = substr($ultimo,1); // Sacamos el ?
    $gets = explode("&", $ultimo);
    foreach($gets as $g) {
      $f = explode("=",$g);
      if (sizeof($f)==2) $get_params[$f[0]] = urldecode($f[1]);
    }
    unset($params[sizeof($params)-1]);
  } else if (strpos($ultimo,"#") == 0) {
    unset($params[sizeof($params)-1]);
  }
  //if (substr($url, -1) == "/") unset($params[sizeof($params)-1]);
  $ultimo = end($params);
}

function go_404() {
  global $dir_template, $empresa, $conx;
  if (file_exists("$dir_template/404.php")) include("$dir_template/404.php");
  else include("404.php");
}

function get_empresa_by_dominio($dominio) {
  global $conx;
  if (empty($dominio)) return FALSE;
  $dominio_con_www = (strpos("www.", $dominio) === FALSE) ? "www.".$dominio : $dominio;
  $sql = "SELECT E.*, T.path AS template_path, WC.*, ";
  $sql.= " IF(L.nombre IS NULL,'',L.nombre) AS localidad ";
  $sql.= "FROM empresas E ";
  $sql.= " INNER JOIN empresas_dominios ED ON (E.id = ED.id_empresa) ";
  $sql.= " INNER JOIN web_configuracion WC ON (E.id = WC.id_empresa) ";
  $sql.= " INNER JOIN web_templates T ON (E.id_web_template = T.id) ";
  $sql.= " LEFT JOIN com_localidades L ON (E.id_localidad = L.id) ";
  $sql.= "WHERE ED.dominio = '$dominio' ";
  if ($dominio_con_www != $dominio) $sql.= "OR ED.dominio = '$dominio_con_www' ";
  $q = mysqli_query($conx,$sql);
  if (mysqli_num_rows($q)>0) {
    $empresa = mysqli_fetch_object($q);
    $empresa->direccion = $empresa->direccion_web;
    $empresa->telefono = $empresa->telefono_web;    
    if (isset($empresa->configuraciones_especiales) && !empty($empresa->configuraciones_especiales)) {
      $empresa->config = array();
      $lineas = explode(";",$empresa->configuraciones_especiales);
      foreach($lineas as $l) {
        $l = trim($l);
        if (empty($l)) continue;
        if (strpos($l,"=")>0) {
          $campos = explode("=",$l);
          $clave = trim($campos[0]);
          $valor = trim($campos[1]);
          if (empty($clave)) continue;
          $empresa->config[$clave] = $valor;
        }
      }      
    }
    return $empresa;
  } else {
    return FALSE;
  }
}

function get_empresa_by_id($id) {
  global $conx;
  $sql = "SELECT E.*, T.path AS template_path, WC.*, ";
  $sql.= " IF(L.nombre IS NULL,'',L.nombre) AS localidad ";
  $sql.= "FROM empresas E ";
  $sql.= " INNER JOIN empresas_dominios ED ON (E.id = ED.id_empresa) ";
  $sql.= " INNER JOIN web_configuracion WC ON (E.id = WC.id_empresa) ";
  $sql.= " INNER JOIN web_templates T ON (E.id_web_template = T.id) ";
  $sql.= " LEFT JOIN com_localidades L ON (E.id_localidad = L.id) ";
  $sql.= "WHERE E.id = '$id' ";
  $q = mysqli_query($conx,$sql);
  if (mysqli_num_rows($q)>0) {
    $empresa = mysqli_fetch_object($q);
    $empresa->direccion = $empresa->direccion_web;
    $empresa->telefono = $empresa->telefono_web;    
    if (isset($empresa->configuraciones_especiales) && !empty($empresa->configuraciones_especiales)) {
      $empresa->config = array();
      $lineas = explode(";",$empresa->configuraciones_especiales);
      foreach($lineas as $l) {
        $l = trim($l);
        if (empty($l)) continue;
        if (strpos($l,"=")>0) {
          $campos = explode("=",$l);
          $clave = trim($campos[0]);
          $valor = trim($campos[1]);
          if (empty($clave)) continue;
          $empresa->config[$clave] = $valor;
        }
      }      
    }
    return $empresa;
  } else {
    return FALSE;
  }
}

function get_empresa_by_dominio_inmovar($dominio) {
  global $conx;
  $sql = "SELECT E.*, T.path AS template_path, WC.*, ";
  $sql.= " IF(L.nombre IS NULL,'',L.nombre) AS localidad ";
  $sql.= "FROM empresas E ";
  $sql.= " INNER JOIN web_configuracion WC ON (E.id = WC.id_empresa) ";
  $sql.= " INNER JOIN web_templates T ON (E.id_web_template = T.id) ";
  $sql.= " LEFT JOIN com_localidades L ON (E.id_localidad = L.id) ";
  $sql.= "WHERE E.id = '$dominio' "; // Termina siendo el ID
  $q = mysqli_query($conx,$sql);
  if (mysqli_num_rows($q)>0) {
    $empresa = mysqli_fetch_object($q);
    $empresa->direccion = $empresa->direccion_web;
    $empresa->telefono = $empresa->telefono_web;
    if (isset($empresa->configuraciones_especiales) && !empty($empresa->configuraciones_especiales)) {
      $empresa->config = array();
      $lineas = explode(";",$empresa->configuraciones_especiales);
      foreach($lineas as $l) {
        $l = trim($l);
        if (empty($l)) continue;
        if (strpos($l,"=")>0) {
          $campos = explode("=",$l);
          $clave = trim($campos[0]);
          $valor = trim($campos[1]);
          if (empty($clave)) continue;
          $empresa->config[$clave] = $valor;
        }
      }      
    }
    return $empresa;
  } else {
    return FALSE;
  } 
}

function mklink($url) {
  global $dominio;
  $d = $dominio;
  if (substr($d,-1) !== "/") $d.="/"; // Si no termina con /, se la agregamos
  $d = (strpos($d, "http://") !== FALSE) ? $d : "http://".$d; // Siempre le agregamos el http://
  if ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") || (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && strtolower($_SERVER["HTTP_X_FORWARDED_PROTO"]) == "https")) { $d = str_replace("http://", "https://", $d); }
  return $d.(($url !== "/")?$url:"");
}

// Primero consultamos si es por alguna pagina de prueba, al estilo inmovar.com/sandbox/dominio/
if ( (!(strpos($dominio, "app.inmovar") === FALSE) || !(strpos($dominio, "sandbox.inmovar") === FALSE)) && isset($params[0]) && $params[0] == "sandbox" ) {
  // Buscamos el dominio dentro de inmovar
  if (!empty($params[1])) {
    $empresa = get_empresa_by_dominio_inmovar($params[1]);
    if ($empresa !== FALSE) {
      $dominio = $dominio."/sandbox/".$params[1]."/";
      $base = "/sandbox/".$params[1]."/";
      // Movemos el array dos lugares para adelante (sandbox/dominio/ son dos lugares);
      array_shift($params);
      array_shift($params);
      $ultimo = end($params);
    }
  }

} else if ( isset($params[0]) && $params[0] == "ficha" && isset($params[1])  && isset($params[2]) ) {
  $empresa = get_empresa_by_dominio_inmovar($params[1]);
  $hash = urldecode($params[2]);
  $hash = str_replace(" ", "", $hash);
  if (strpos($hash, "?") > 0) $hash = substr($hash, 0, strpos($hash, "?"));
  $sql = "SELECT id, id_empresa FROM inm_propiedades WHERE hash = '$hash' ";
  $empresa->template_path = "ficha";
  $q_prop = mysqli_query($conx,$sql);
  if (mysqli_num_rows($q_prop)>0) {
    $propiedad = mysqli_fetch_object($q_prop);
  } else {
    go_404();
  }

} else if ( isset($params[0]) && $params[0] == "buscador" ) {
  // Buscamos el dominio dentro de inmovar
  if (!empty($params[1])) {
    $empresa = get_empresa_by_dominio_inmovar($params[1]);
    $empresa->template_path = "buscador";
    if ($empresa !== FALSE) {
      $dominio = $dominio."/buscador/".$params[1]."/";
      $base = "/buscador/".$params[1]."/";
      // Movemos el array dos lugares para adelante (buscador/dominio/ son dos lugares);
      array_shift($params);
      array_shift($params);
      $ultimo = end($params);
    }
  }

// Consultamos por el dominio
} else {
  $empresa = get_empresa_by_dominio($dominio);
  $base = "/";

  // Controlamos si tiene configurado un dominio principal
  if (!empty($empresa->dominio_ppal) && $empresa->dominio_ppal != $dominio) {
    // Redireccionamos
    $actual = $_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'];
    $nueva = str_replace($_SERVER["HTTP_HOST"], $empresa->dominio_ppal, $actual);
    if (strpos($nueva, "http://") === FALSE) $nueva = "http://".$nueva;
    header("HTTP/1.1 301 Moved Permanently"); 
    header("Location: $nueva");
    exit();
  }
}

// Si no se encontro, redireccionamos
if ($empresa === FALSE) {
  header('Content-Type: text/html; charset=UTF-8');
  include("404.php");
  exit();
}

// Si es un SITEMAP
if (strpos($url,"sitemap.xml") !== FALSE) {
  header('Content-Type: text/xml; charset=UTF-8');
  include("admin/sitemap.php");
  ob_end_flush();
  exit();
}

// Si es ROBOTS.TXT
if (strpos($url,"robots.txt") !== FALSE) {
  if (empty($empresa->seo_robots)) {
    header('Content-Type: text/plain; charset=UTF-8');
    echo "User-agent: *\n";
    echo "Disallow: /admin/\n";
    echo "Disallow: /admin/*\n";
    echo "Disallow: /compra-ok/\n";
    echo "Disallow: /compra-ok/*\n";
    echo "Disallow: /compra-pending/\n";
    echo "Disallow: /compra-pending/*\n";
    echo "Disallow: /compra-fail/\n";
    echo "Disallow: /compra-fail/*\n";
    echo "Disallow: /favoritos/\n";
    echo "Disallow: /favoritos/*\n";
    echo "Disallow: /cart/\n";
    echo "Disallow: /cart/*\n";
    echo "Sitemap: ".current_url(TRUE,TRUE)."/sitemap.xml\n";
  } else echo $empresa->seo_robots;
  ob_end_flush();
  exit();
}

header('Content-Type: text/html; charset=UTF-8');

$fecha_suspension = new DateTime($empresa->fecha_suspension);
$fecha_suspension->modify("+1 month");
if ($empresa->administrar_pagos == 1 && $fecha_suspension->format("Y-m-d") < date("Y-m-d")) {
  ob_end_flush();
  exit();
}

$dominio = "http://".$dominio;
$nombre_pagina = (sizeof($params)>0) ? $params[0] : "";

if ( $nombre_pagina == "ficha") {
  include_once("models/Propiedad_Model.php");
  $propiedad_model = new Propiedad_Model($empresa->id,$conx);
  $propiedad = $propiedad_model->get_by_hash($hash);
  $id = $propiedad->id;
  include("templates/ficha/home.php");  

} else if (isset($empresa->template_path) && !empty($empresa->template_path)) {

  $dir_template = "templates/$empresa->template_path/";

  // Controlamos a que pagina desea ir
  if ($nombre_pagina == "index" || $nombre_pagina == "/" || empty($nombre_pagina) || strpos($nombre_pagina,"?") === 0) {
    if (file_exists($dir_template.$empresa->template_home.".php")) include($dir_template.$empresa->template_home.".php");
    else go_404();

  } else if ($nombre_pagina == "contacto" || $nombre_pagina == "contact") {
    if (file_exists($dir_template.$empresa->template_contacto.".php")) include($dir_template.$empresa->template_contacto.".php");
    else go_404();

  } else if ($nombre_pagina == "gracias" || $nombre_pagina == "thanks") {
    if (file_exists($dir_template."gracias.php")) include($dir_template."gracias.php");
    else go_404();

  } else if ($nombre_pagina == "ofertas" || $nombre_pagina == "oportunidades") {
    if (file_exists($dir_template."propiedades_listado.php")) {
      $buscar_ofertas = 1;
      include($dir_template."propiedades_listado.php");
    } else  {
      go_404();
    }

  } else if ($nombre_pagina == "pagina") {
    $id = substr($ultimo,strrpos($ultimo,"-")+1); // Obtenemos el ID del ultimo parametro
    if (file_exists($dir_template.$empresa->template_pagina.".php")) include($dir_template.$empresa->template_pagina.".php");
    else go_404();

  // Si la pagina empieza con WEB, vamos al archivo especificado por el segundo parametro
  // Esto permite dar libertad a cada template por si hay que mostrar archivos especificos del proyecto,
  // asi, todo lo que empiece por web/* es como ejecutar *.php
  } else if ($nombre_pagina == "web" && isset($params[1])) {
    if (file_exists($dir_template.$params[1].".php")) include($dir_template.$params[1].".php");
    else go_404();

  // Si la pagina comienza con "e" solamente, es un link para redirigir
  } else if ($nombre_pagina == "e") {
    if (isset($params[1])) $id_link = intval($params[1]);
    else {
      $id_link = substr($_SERVER["REQUEST_URI"], strrpos($_SERVER["REQUEST_URI"], "/")+1);
    }
    $id_link = (strpos($id_link, "?")>0) ? substr($id_link, 0, strpos($id_link, "?")) : $id_link;
    $sql = "SELECT link FROM qr_redirecciones WHERE id = $id_link ";
    $q_link = mysqli_query($conx,$sql);
    if (mysqli_num_rows($q_link)>0) {
      $o_link = mysqli_fetch_object($q_link);
      header("Location: ".$o_link->link);
    }

  // Si la pagina comienza solamente con "p", es un link que viene de tokko
  } else if ($nombre_pagina == "p") {
    $pos = strpos($params[1], "-prop?");
    if ($pos > 0) {
      $id_tokko = substr($params[1], 0, $pos);
      include_once("models/Propiedad_Model.php");
      $propiedad_model = new Propiedad_Model($empresa->id,$conx);
      $propiedad = $propiedad_model->get_by_tokko_id($hash);
      if ($propiedad !== FALSE) {
        $id = $propiedad->id;
        include("templates/ficha/home.php");  
      } else {
        go_404();
      }
    } {
      go_404();
    }

  } else if ($nombre_pagina == "mapa") {
    if (file_exists($dir_template."mapa.php")) include($dir_template."mapa.php");
    else go_404();

  } else if ($nombre_pagina == "subi-tu-propiedad") {
    if (file_exists($dir_template."subi_propiedad.php")) include($dir_template."subi_propiedad.php");
    else go_404();

  } else if ($nombre_pagina == "carrito") {
    if (file_exists($dir_template."carrito.php")) include($dir_template."carrito.php");
    else go_404();

  } else if ($nombre_pagina == "checkout") {
    if (file_exists($dir_template."checkout.php")) include($dir_template."checkout.php");
    else go_404();

  } else if ($nombre_pagina == "login") {
    if (file_exists($dir_template."login.php")) include($dir_template."login.php");
    else go_404();

  } else if ($nombre_pagina == "logout") {
    include("logout.php");

  } else if ($nombre_pagina == "registro") {
    if (file_exists($dir_template."registro.php")) include($dir_template."registro.php");
    else go_404();

  } else if ($nombre_pagina == "perfil") {
    if (file_exists($dir_template."perfil.php")) include($dir_template."perfil.php");
    else go_404();

  } else if ($nombre_pagina == "staff") {
    if (file_exists($dir_template."staff.php")) include($dir_template."staff.php");
    else go_404();

  } else if ($nombre_pagina == "mis-propiedades") {
    if (file_exists($dir_template."mis_propiedades.php")) include($dir_template."mis_propiedades.php");
    else go_404();

  } else if ($nombre_pagina == "subi-tu-propiedad") {
    if (file_exists($dir_template."subi_propiedad.php")) include($dir_template."subi_propiedad.php");
    else go_404();

  } else if ($nombre_pagina == "favoritos") {
    if (file_exists($dir_template."favoritos.php")) include($dir_template."favoritos.php");
    else go_404();

  } else if ($nombre_pagina == "preview") {
    $id = substr($ultimo,strrpos($ultimo,"-")+1); // Obtenemos el ID del ultimo parametro
    if (file_exists($dir_template."includes/modal_preview.php")) include($dir_template."includes/modal_preview.php");
    else go_404();

  } else if ($nombre_pagina == "noticias" || $nombre_pagina == "entradas") {
    if (file_exists($dir_template.$empresa->template_noticias_listado.".php")) include($dir_template.$empresa->template_noticias_listado.".php");
    else go_404();

  } else if ($nombre_pagina == "propiedades") {
    if (file_exists($dir_template."propiedades_listado.php")) include($dir_template."propiedades_listado.php");
    else go_404();

  } else if ($nombre_pagina == "propiedad") {
    $id = substr($ultimo,strrpos($ultimo,"-")+1); // Obtenemos el ID del ultimo parametro
    if (file_exists($dir_template."propiedades_detalle.php")) include($dir_template."propiedades_detalle.php");
    else go_404();

  } else if ($nombre_pagina == "profile") {
    if (file_exists($dir_template."profile.php")) include($dir_template."profile.php");
    else go_404();    

  } else if ($nombre_pagina == "construccion") {
    if (file_exists($dir_template."construccion.php")) include($dir_template."construccion.php");
    else go_404();

  // GRUPO URBANO
  } else if ($nombre_pagina == "la-plata") {
    // Propiedades en Venta de La Plata
    $config_grupo = array(
      "link_tipo_operacion"=>"ventas",
      "id_localidad"=>513,
      "solo_propias"=>1,
    );
    include($dir_template."propiedades_listado.php");

  } else if ($nombre_pagina == "gonnet") {
    // Propiedades en Venta de Gonnet
    $config_grupo = array(
      "link_tipo_operacion"=>"ventas",
      "id_localidad"=>396,
      "solo_propias"=>1,
    );
    include($dir_template."propiedades_listado.php");

  } else if ($nombre_pagina == "city-bell") {
    // Propiedades en Venta de City Bell
    $config_grupo = array(
      "link_tipo_operacion"=>"ventas",
      "id_localidad"=>205,
      "solo_propias"=>1,
    );
    include($dir_template."propiedades_listado.php");

  } else if ($nombre_pagina == "costa-atlantica") {
    // Propiedades en Venta de Mar del Plata, Villa Gesell
    $config_grupo = array(
      "link_tipo_operacion"=>"ventas",
      "in_ids_localidades"=>"600,951",
      "solo_propias"=>1,
    );
    include($dir_template."propiedades_listado.php");

  } else if ($nombre_pagina == "vengo-a-estudiar") {
    $config_grupo = array(
      "link_tipo_operacion"=>"alquileres",
      "id_localidad"=>513,
      "in_ids_tipo_inmueble"=>"2", // Depto / Monoambiente
      "in_dormitorios"=>"1,2",
      "solo_propias"=>1,
    );
    include($dir_template."propiedades_listado.php");

  } else if ($nombre_pagina == "me-independizo") {
    $config_grupo = array(
      "link_tipo_operacion"=>"alquileres",
      "id_localidad"=>513,
      "in_ids_tipo_inmueble"=>"2", // Depto
      "in_dormitorios"=>"1,2",
      "solo_propias"=>1,
    );
    include($dir_template."propiedades_listado.php");

  } else if ($nombre_pagina == "ya-somos-mas") {
    $config_grupo = array(
      "link_tipo_operacion"=>"alquileres",
      "id_localidad"=>513,
      "in_ids_tipo_inmueble"=>"2", // Depto
      "in_dormitorios"=>"2,3",
      "solo_propias"=>1,
    );
    include($dir_template."propiedades_listado.php");

  } else if ($nombre_pagina == "soy-emprendedor") {
    $config_grupo = array(
      "link_tipo_operacion"=>"alquileres",
      "id_localidad"=>513,
      "in_ids_tipo_inmueble"=>"9", // Local
      "solo_propias"=>1,
    );
    include($dir_template."propiedades_listado.php");

  } else if ($nombre_pagina == "mi-primer-depto") {
    $config_grupo = array(
      "link_tipo_operacion"=>"ventas",
      "id_localidad"=>513,
      "in_ids_tipo_inmueble"=>"2", // Depto / Monoambiente
      "solo_propias"=>1,
      "in_dormitorios"=>"1", //1 Dormitorio
    );
    include($dir_template."propiedades_listado.php");

  } else if ($nombre_pagina == "mi-casa") {
    $config_grupo = array(
      "link_tipo_operacion"=>"ventas",
      "in_ids_tipo_inmueble"=>"1,15", // Casa / Duplex
      "solo_propias"=>1,
    );
    include($dir_template."propiedades_listado.php");

  } else if ($nombre_pagina == "vamos-a-construir") {
    $config_grupo = array(
      "link_tipo_operacion"=>"ventas",
      //"id_localidad"=>513, //Cambio Marcelo 09/06/2022
      "in_ids_tipo_inmueble"=>"7", // Lotes
      "solo_propias"=>1,
    );
    include($dir_template."propiedades_listado.php");

  } else if ($nombre_pagina == "inversion") {
    $config_grupo = array(
      "link_tipo_operacion"=>"ventas",
      "id_localidad"=>513,
      "ids_tipo_operacion"=>"1,4,5", // Venta / Emprendimientos / Obras
      "in_ids_tipo_inmueble"=>"2", // Depto / Monoambiente
      "solo_propias"=>1,
      //"in_dormitorios"=>"1", //1 Dormitorio
    );
    include($dir_template."propiedades_listado.php");

  } else {

    // Primero buscamos si ya tiene el ID
    $id = substr($ultimo,strrpos($ultimo,"-")+1); // Obtenemos el ID del ultimo parametro
    if (is_numeric($id)) {
      if (file_exists($dir_template.$empresa->template_noticias_detalle.".php")) include($dir_template.$empresa->template_noticias_detalle.".php");
      else go_404();

    } else if ($empresa->id == 1234) {
      if (file_exists($dir_template."comercios_detalle.php")) include($dir_template."comercios_detalle.php");
      else go_404();

    } else {
      // Sino buscamos directamente en el campo LINK
      $url = "";
      foreach($params as $p) $url.= "$p/";
      $l = $url;
      // Si tiene un ?, tomamos hasta ahi
      $l = ((strpos($l, "?") !== FALSE) ? substr($l, 0, strpos($l, "?")) : $l);
      $sql = "SELECT id FROM not_entradas WHERE id_empresa = $empresa->id AND (link = '$l' OR link = '$l/') ";
      $q = mysqli_query($conx,$sql);
      if (mysqli_num_rows($q)>0) {
        $r = mysqli_fetch_object($q);
        $id = $r->id;
        if (file_exists($dir_template.$empresa->template_noticias_detalle.".php")) include($dir_template.$empresa->template_noticias_detalle.".php");
        else go_404();
      } else {
        // No existe la pagina buscada, vamos a una pagina de ERROR 404 GENERAL
        go_404();
      }
    }

  }

}

ob_end_flush();
?>