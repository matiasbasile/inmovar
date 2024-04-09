<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() == PHP_SESSION_NONE) {
  @session_start();
}
date_default_timezone_set("America/Argentina/Buenos_Aires");
if (!defined("PROJECT_NAME")) { DEFINE ("PROJECT_NAME",(isset($_SERVER["PROJECT_NAME"]) ? $_SERVER["PROJECT_NAME"] : "Inmovar")); }
if (!defined("DATABASE")) { DEFINE ("DATABASE",(isset($_SERVER["DATABASE"]) ? $_SERVER["DATABASE"] : "inmovar")); }
if (!defined("SERVER_DB")) { DEFINE ("SERVER_DB",(isset($_SERVER["SERVER_DB"]) ? $_SERVER["SERVER_DB"] : "localhost")); }
if (!defined("USER_DB")) { DEFINE ("USER_DB",(isset($_SERVER["USER_DB"]) ? $_SERVER["USER_DB"] : "root")); }
if (!defined("PASSWORD_DB")) { DEFINE ("PASSWORD_DB",(isset($_SERVER["PASSWORD_DB"]) ? $_SERVER["PASSWORD_DB"] : "varcreative1805")); }
if (!defined("FORCE_HTTPS")) { DEFINE ("FORCE_HTTPS",(isset($_SERVER["FORCE_HTTPS"]) ? $_SERVER["FORCE_HTTPS"] : false)); }
if (!defined("DOMINIO")) { DEFINE ("DOMINIO",(isset($_SERVER["DOMINIO"]) ? $_SERVER["DOMINIO"] : "https://app.inmovar.com/")); }
if (!defined("COLOR_1")) { DEFINE ("COLOR_1",(isset($_SERVER["COLOR_1"]) ? $_SERVER["COLOR_1"] : "1d36c2")); }
if (!defined("COLOR_2")) { DEFINE ("COLOR_2",(isset($_SERVER["COLOR_2"]) ? $_SERVER["COLOR_2"] : "0dd384")); }
if (!defined("LOGO")) { DEFINE ("LOGO",(isset($_SERVER["LOGO"]) ? $_SERVER["LOGO"] : "/admin/resources/images/inmovar-grande.png")); }
if (!defined("LOGO_LOGIN")) { DEFINE ("LOGO_LOGIN",(isset($_SERVER["LOGO_LOGIN"]) ? $_SERVER["LOGO_LOGIN"] : "/admin/resources/images/logo-login.png")); }
if (!defined("CSS_LOGIN")) { DEFINE ("CSS_LOGIN",(isset($_SERVER["CSS_LOGIN"]) ? $_SERVER["CSS_LOGIN"] : "")); }

// Clave general para los mapas
include_once("admin/application/helpers/mapbox_helper.php");
if (!defined("MAPBOX_KEY")) { DEFINE ("MAPBOX_KEY",(isset($_SERVER["MAPBOX_KEY"]) ? $_SERVER["MAPBOX_KEY"] : get_mapbox_key())); } 

if (!function_exists("get_conex")) {
  function get_conex() {
    // Conectamos con la base de datos
    $conx = mysqli_connect(SERVER_DB,USER_DB,PASSWORD_DB,DATABASE);
    if ($conx === FALSE) {
      echo "Error al conectar con la base de datos";
      return;
    }
    mysqli_set_charset($conx,"utf8");
    return $conx;
  }
}

if (!function_exists("get_mysqli")) {
  function get_mysqli() {
    // Conectamos con la base de datos
    $mysqli = new mysqli(SERVER_DB,USER_DB,PASSWORD_DB,DATABASE);
    if ($mysqli === FALSE) {
      echo "Error al conectar con la base de datos";
      return;
    }
    $mysqli->set_charset("utf8");
    return $mysqli;
  }
}

if (!function_exists("get_conex_local_data")) {
  function get_conex_local_data() {
    $connection = mysqli_init();
    mysqli_options($connection,MYSQLI_OPT_LOCAL_INFILE,true);
    mysqli_real_connect($connection,SERVER_DB,USER_DB,PASSWORD_DB,DATABASE);
    return $connection;
  }
}

if (!function_exists("current_url")) {
  function current_url($solo_dominio = FALSE, $sin_parametros = FALSE) {
    $pageURL = "https://";
    if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
      $pageURL .= $_SERVER["HTTP_HOST"].":".$_SERVER["SERVER_PORT"];
    } else {
      $pageURL .= $_SERVER["HTTP_HOST"];
    }
    if (!$solo_dominio) $pageURL.= $_SERVER["REQUEST_URI"];
    if ($sin_parametros && strpos($pageURL, "?")>0) {
      $pageURL = substr($pageURL, 0, strpos($pageURL, "?"));
    }
    return $pageURL;
  }
}

if (!function_exists("send_error")) {
  function send_error($config = array()) {
    $to = (isset($config["to"]) ? $config["to"] : "basile.matias99@gmail.com");
    $subject = (isset($config["subject"]) ? $config["subject"] : "ERROR");
    $message = (isset($config["message"]) ? $config["message"] : "");
    $log_file = (isset($config["log_file"]) ? $config["log_file"] : "");
    $headers = "From:info@varcreative.com\r\n";
    $headers.= "MIME-Version: 1.0\r\n";
    $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    @mail($to,$subject,$message,$headers);
    if (!empty($log_file)) {
      file_put_contents($log_file, date("Y-m-d H:i:s").": ".$subject."\n".$message."\n\n",FILE_APPEND);
    }
  }
}

$conx = get_conex();
?>