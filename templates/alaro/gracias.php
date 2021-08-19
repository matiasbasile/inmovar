<?php
include_once("includes/funciones.php");
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
$nombre_pagina = "contacto";
$header_cat = "";
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="loading">
<?php include("includes/header.php"); ?>

<?php include("templates/comun/gracias.php"); ?>

<!--CONTACT PAGE INFO-->

<?php include("includes/footer.php"); ?>
</body>
</html>