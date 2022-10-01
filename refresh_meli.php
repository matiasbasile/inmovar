<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

@session_start();
require_once 'models/meli.php';
require_once 'admin/params.php';
require_once 'admin/application/libraries/Mandrill/Mandrill.php';

// Guarda los tokens para volverlos a reutilizar mas tarde
function guardar_tokens($array=array()) {
  global $conx;
  $id_empresa = $array["id_empresa"];
  $sql = "UPDATE web_configuracion SET ";
  if (isset($array["access_token"]) && !empty($array["access_token"])) $sql.= " ml_access_token = '".$array["access_token"]."', ";
  if (isset($array["refresh_token"]) && !empty($array["refresh_token"])) $sql.= " ml_refresh_token = '".$array["refresh_token"]."', ";
  if (isset($array["expires_in"]) && !empty($array["expires_in"])) $sql.= " ml_expires_in = '".$array["expires_in"]."', ";
  if (isset($array["ml_user_id"]) && !empty($array["ml_user_id"])) $sql.= " ml_user_id = '".$array["ml_user_id"]."', ";
  $sql.= " id_empresa = $id_empresa ";
  $sql.= "WHERE id_empresa = $id_empresa ";
  mysqli_query($conx,$sql);
}

$errores = array();
$sql = "SELECT WC.*, E.nombre FROM web_configuracion WC INNER JOIN empresas E ON (WC.id_empresa = E.id) WHERE WC.ml_expires_in != '' ";
$q = mysqli_query($conx,$sql);
while (($empresa = mysqli_fetch_object($q)) !== NULL) {

  $ml_credentials = get_ml_credentials($empresa->id_empresa);
  $meli = new Meli($ml_credentials[0], $ml_credentials[1], $empresa->ml_access_token, $empresa->ml_refresh_token);

  if (empty($empresa->ml_access_token) || empty($empresa->ml_expires_in)) continue;

  try {
    // Refrescamos el access token
    $refresh = $meli->refreshAccessToken();
    $body = $refresh['body'];
    if ($refresh["httpCode"] == 200) {
      if (isset($body->access_token) && !empty($body->access_token)) {
        $empresa->ml_access_token = $body->access_token;
        $empresa->expires_in = time() + $body->expires_in;
        $empresa->refresh_token = $body->refresh_token;
        guardar_tokens(array(
          "access_token"=>$empresa->ml_access_token,
          "expires_in"=>$empresa->expires_in,
          "refresh_token"=>$empresa->refresh_token,
          "id_empresa"=>$empresa->id_empresa,
        ));
      }
    } else {
      $errores[] = $empresa->nombre." ".$body->message;
    }
  } catch (Exception $e) {
    $errores[] = $empresa->nombre." ".$e->getMessage();
  }
}
/*
if (sizeof($errores)>0) {
  $body = implode("<br/>", $errores);
  mandrill_send(array(
    "to"=>"basile.matias99@gmail.com",
    "subject"=>"ERROR TOKEN MERCADOLIBRE INMOVAR",
    "from"=>"no-reply@varcreative.com",
    "from_name"=>"Inmovar",
    "body"=>$body,
  ));  
}
*/
?>