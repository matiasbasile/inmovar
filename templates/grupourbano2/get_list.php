<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("includes/init.php");
extract($propiedad_model->get_variables(array()));
foreach ($vc_listado as $propiedad) { 
  item($propiedad);
}
?>