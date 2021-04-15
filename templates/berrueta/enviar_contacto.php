<?php
//include("params.php");
$nombre = isset($_POST["nombre"]) ? filter_var($_POST["nombre"],FILTER_SANITIZE_STRING) : "";
$apellido = isset($_POST["apellido"]) ? filter_var($_POST["apellido"],FILTER_SANITIZE_STRING) : "";
$email = isset($_POST["email"]) ? filter_var($_POST["email"],FILTER_SANITIZE_STRING) : "";
$mensaje = isset($_POST["mensaje"]) ? filter_var($_POST["mensaje"],FILTER_SANITIZE_STRING) : "";
$telefono = isset($_POST["telefono"]) ? filter_var($_POST["telefono"],FILTER_SANITIZE_STRING) : "";
$asunto = isset($_POST["asunto"]) ? filter_var($_POST["asunto"],FILTER_SANITIZE_STRING) : "Contacto";

if (!empty($email)) {
    
    // Armamos el email
    $body = "";
    if (!empty($nombre)) $body.= "Nombre: $nombre <br/>";
    if (!empty($apellido)) $body.= "Apellido: $apellido <br/>";
    if ($asunto != "Contacto") $body.= "Asunto: $asunto <br/>";
    if (!empty($email)) $body.= "Email: $email <br/>";
    if (!empty($telefono)) $body.= "Telefono: $telefono <br/>";
    if (!empty($mensaje)) $body.= "Comentarios: $mensaje <br/>";
    if (!empty($email)) $headers = "From: $email\r\n";
    else $headers = "From: ".$conf->email_recepcion."\r\n";
    /*
    // Guardamos el contacto
    $sql = "INSERT INTO contactos (tipo,email,activo,nombre,apellido,telefono,mensaje,asunto,fecha) VALUES ";
    $sql.= "('C','$email',1,'$nombre','$apellido','$telefono','$mensaje','$asunto',NOW()) ";
    mysqli_query($conx,$sql);
    */
    
    // Enviamos el email
    $headers.= "MIME-Version: 1.0\r\n";
    $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    //$to = $conf->email;
    $to = "basile.matias99@gmail.com";
    if (@mail($to,$asunto,$body,$headers)) {
        echo json_encode(array("error"=>0));
    } else {
        echo json_encode(array("error"=>1));
    }
} else {
    echo json_encode(array("error"=>1));
}
?>