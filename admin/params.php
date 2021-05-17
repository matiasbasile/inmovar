<?php
if (session_status() == PHP_SESSION_NONE) {
  @session_start();
}
date_default_timezone_set("America/Argentina/Buenos_Aires");
if (!defined("SERVER_DB")) { DEFINE ("SERVER_DB","localhost"); }
if (!defined("DATABASE")) { DEFINE ("DATABASE","inmovar"); }
if (!defined("USER_DB")) { DEFINE ("USER_DB","root"); }
if (!defined("PASSWORD_DB")) { DEFINE ("PASSWORD_DB","varcreative1805"); }
if (!defined("FORCE_HTTPS")) { DEFINE ("FORCE_HTTPS",false); }
if (!defined("DOMINIO")) { DEFINE ("DOMINIO","http://app.inmovar.com/"); }

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
    $pageURL = 'http';
    if (FORCE_HTTPS || (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")) { $pageURL .= "s"; }
    $pageURL .= "://";
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
