<?php

include 'models/Web_Model.php';
$web_model = new Web_Model($empresa->id, $conx);
include 'models/Entrada_Model.php';
$entrada_model = new Entrada_Model($empresa->id, $conx);
include 'models/Articulo_Model.php';
$articulo_model = new Articulo_Model($empresa->id, $conx);
include 'models/Propiedad_Model.php';
$propiedad_model = new Propiedad_Model($empresa->id, $conx);
include 'models/Usuario_Model.php';
$usuario_model = new Usuario_Model($empresa->id, $conx);
include_once 'admin/application/helpers/fecha_helper.php';
$conservar = '0-9'; // juego de caracteres a conservar
$regex = sprintf('~[^%s]++~i', $conservar); // case insensitive
$empresa->telefono_num = preg_replace($regex, '', $empresa->telefono);
$empresa->telefono_num_2 = preg_replace($regex, '', $empresa->telefono_2);
include_once 'propiedad/item.php';
include_once 'entrada/item.php';
