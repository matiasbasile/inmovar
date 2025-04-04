<?php
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

// Si estamos enviando los datos del articulo que queremos compartir
if (isset($_GET["id_empresa"])) {
  $id_empresa = filter_var($_GET["id_empresa"]);
  $_SESSION["id_empresa"] = $id_empresa;
} else {
  $id_empresa = isset($_SESSION["id_empresa"]) ? $_SESSION["id_empresa"] : 0;
}

$sql = "SELECT * FROM web_configuracion WHERE id_empresa = $id_empresa ";
$q = mysqli_query($conx,$sql);
if (mysqli_num_rows($q)==0) {
  echo "EMPRESA NO VALIDA"; exit();
}
$empresa = mysqli_fetch_object($q);

if (!isset($id_empresa)) $id_empresa = 0;
$ml_credentials = get_ml_credentials($id_empresa);
$meli = new Meli($ml_credentials[0], $ml_credentials[1], $empresa->ml_access_token, $empresa->ml_refresh_token);

if (isset($_GET["code"])) {

  // Obtenemos el usuario
  $user = $meli->authorize($_GET['code'], "https://app.inmovar.com/connect_meli.php");
  $empresa->ml_access_token = $user['body']->access_token;
  $empresa->expires_in = time() + $user['body']->expires_in;
  $empresa->refresh_token = $user['body']->refresh_token;
  guardar_tokens(array(
    "access_token"=>$empresa->ml_access_token,
    "expires_in"=>$empresa->expires_in,
    "refresh_token"=>$empresa->refresh_token,
    "ml_user_id"=>$user['body']->user_id,
    "id_empresa"=>$id_empresa,
  ));
  echo "Su cuenta de MercadoLibre esta sincronizada. Puede cerrar esta ventana y volver a recargar el sistema.";
  exit();

}

if (!empty($empresa->ml_access_token) && !empty($empresa->ml_expires_in)) {

  // Debemos controlar si el access token sigue siendo valido
  if($empresa->ml_expires_in < time()) {
    try {
      // Refrescamos el access token
      $refresh = $meli->refreshAccessToken();
      if (isset($refresh['body']->access_token) && !empty($refresh['body']->access_token)) {
        $empresa->ml_access_token = $refresh['body']->access_token;
        $empresa->expires_in = time() + $refresh['body']->expires_in;
        $empresa->refresh_token = $refresh['body']->refresh_token;
        guardar_tokens(array(
          "access_token"=>$empresa->ml_access_token,
          "expires_in"=>$empresa->expires_in,
          "refresh_token"=>$empresa->refresh_token,
          "id_empresa"=>$id_empresa,
        ));
      }

    } catch (Exception $e) {
      echo $e->getMessage();
      exit();
    }
  }

  // ID de usuario MERCADOLIBRE
  $params = array('access_token'=>$empresa->ml_access_token);
  $response = $meli->get("/users/me", $params);
  // Guardamos el usuario de ML
  if ($response["httpCode"] == 200) {
    $body = $response["body"];
    guardar_tokens(array(
      "ml_user_id"=>$body->id,
      "id_empresa"=>$id_empresa,
    ));
    echo "Su cuenta de MercadoLibre esta sincronizada. Puede cerrar esta ventana y volver a recargar el sistema.";
  }
  exit();

} else {

  // Redireccionamos automaticamente para que el usuario acepte los permisos de la aplicacion
  $url = $meli->getAuthUrl(
    "https://app.inmovar.com/connect_meli.php", 
    Meli::$AUTH_URL['MLA']
  );
  header("Location: $url");

}
?>