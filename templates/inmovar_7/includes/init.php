<?php
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);

include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);

include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("sistema/application/helpers/fecha_helper.php");
$conservar = '0-9'; // juego de caracteres a conservar
$regex = sprintf('~[^%s]++~i', $conservar); // case insensitive
$empresa->telefono_num = preg_replace($regex, '', $empresa->telefono);
$empresa->telefono_num_2 = preg_replace($regex, '', $empresa->telefono_2);
?>