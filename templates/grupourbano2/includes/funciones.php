<?php
function estaEnFavoritos($id) {
    if (!isset($_SESSION["favoritos"])) return false;
    $favoritos = explode(",",$_SESSION["favoritos"]);
    foreach($favoritos as $f) {
        if ($f == $id) return true;
    }
    return false;
}

function nombre_mes($i,$lang="es") {
    $n="";
    if ($lang == "es") {
        switch ($i) {
            case 1: $n = "Enero"; break;
            case 2: $n = "Febrero"; break;
            case 3: $n = "Marzo"; break;
            case 4: $n = "Abril"; break;
            case 5: $n = "Mayo"; break;
            case 6: $n = "Junio"; break;
            case 7: $n = "Julio"; break;
            case 8: $n = "Agosto"; break;
            case 9: $n = "Septiembre"; break;
            case 10: $n = "Octubre"; break;
            case 11: $n = "Noviembre"; break;
            case 12: $n = "Diciembre"; break;
        }        
    } else if ($lang == "es") {
        switch ($i) {
            case 1: $n = "January"; break;
            case 2: $n = "February"; break;
            case 3: $n = "March"; break;
            case 4: $n = "April"; break;
            case 5: $n = "May"; break;
            case 6: $n = "June"; break;
            case 7: $n = "July"; break;
            case 8: $n = "August"; break;
            case 9: $n = "September"; break;
            case 10: $n = "October"; break;
            case 11: $n = "November"; break;
            case 12: $n = "December"; break;
        }        
    }
	return $n;
}
?>