<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

@session_start();
require_once 'models/meli.php';
require_once 'admin/params.php';

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

$sql = "SELECT * FROM web_configuracion WHERE ml_expires_in != '' ";
$q = mysqli_query($conx,$sql);
while (($empresa = mysqli_fetch_object($q)) !== NULL) {

  $ml_credentials = get_ml_credentials($empresa->id_empresa);
  $meli = new Meli($ml_credentials[0], $ml_credentials[1], $empresa->ml_access_token, $empresa->ml_refresh_token);

  if (empty($empresa->ml_access_token) || empty($empresa->ml_expires_in)) continue;

  // Debemos controlar si el access token sigue siendo valido
  if($empresa->ml_expires_in < time()) {
    try {
      // Refrescamos el access token
      $refresh = $meli->refreshAccessToken();
      if (isset($refresh['body']->access_token) && !empty($refresh['body']->access_token)) {
        $empresa->ml_access_token = $refresh['body']->access_token;
        $empresa->expires_in = time() + $refresh['body']->expires_in;
        $empresa->refresh_token = $refresh['body']->refresh_token;
        echo $empresa->ml_access_token."<br/>";
        guardar_tokens(array(
          "access_token"=>$empresa->ml_access_token,
          "expires_in"=>$empresa->expires_in,
          "refresh_token"=>$empresa->refresh_token,
          "id_empresa"=>$id_empresa,
        ));
      }

    } catch (Exception $e) {
      echo $e->getMessage()."<br/>";
    }
  }
}
echo "TERMINO <br/>";
?>