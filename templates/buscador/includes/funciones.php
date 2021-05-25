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

function full_date_from_mysql($date) {
    if (empty($date)) return FALSE;
    $a = explode(" ",$date);
	$dia = substr($a[0],8,2);
	$mes = substr($a[0],5,2);
	$anio = substr($a[0],0,4);
    return nombres_dias(date("l",strtotime("$anio/$mes/$dia"))).", $dia de ".get_mes($mes)." de $anio";
}

function get_mes($i) {
	$n="";
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
	return $n;
}

function nombres_dias($from)
{
	$nombreDia = getdate(strtotime($from));
	$nomb = strtolower($nombreDia["weekday"]);
	$n = "";
	switch ($nomb) {
		case "sunday": $n = "Domingo"; break;
		case "monday": $n = "Lunes"; break;
		case "tuesday": $n = "Martes"; break;
		case "wednesday": $n = "Miercoles"; break;
		case "thursday": $n = "Jueves"; break;
		case "friday": $n = "Viernes"; break;
		case "saturday": $n = "Sabado"; break;
	}
	return $n;
}

function mostrar_video($video,$config=array()) {
    $width = isset($config["width"]) ? $config["width"] : 560;
    $height = isset($config["height"]) ? $config["height"] : 270;
    if (strpos($video, "watch?v=")>0) {
        // No tiene el iframe, es un link de youtube
        $ex = explode("watch?v=", $video);
        $param = (strpos($ex[1], "&")>0) ? substr($ex[1], 0, strpos($ex[1], "&")) : $ex[1];
        echo '<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$param.'" frameborder="0" allowfullscreen></iframe>';
    } else if (strpos($video,"iframe")>0) {
        // Ya tiene el iframe, se pone tal cual
        echo $video; 
    } else {
        // Lo ponemos como un link externo y listo
        echo "<a target='_blank' href='$video'>$video</a>";
    }
}
?>