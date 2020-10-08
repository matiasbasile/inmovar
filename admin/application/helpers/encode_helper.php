<?php
// Funcion utilizada para imprimir los acentos correctamente
// en la impresora EPSON T-1000

function toAscii($s) {
    $s = mb_convert_encoding($s,"ISO-8859-1");
    for($i=0;$i<strlen($s);$i++) {
        $c = substr($s,$i,1);
        if ($c == "�") $s = str_replace($c,chr(164),$s);
        if ($c == "�") $s = str_replace($c,chr(165),$s);
        if ($c == "�") $s = str_replace($c,chr(160),$s);
        if ($c == "�") $s = str_replace($c,chr(130),$s);
        if ($c == "�") $s = str_replace($c,chr(161),$s);
        if ($c == "�") $s = str_replace($c,chr(162),$s);
        if ($c == "�") $s = str_replace($c,chr(163),$s);
        if ($c == "�") $s = str_replace($c,chr(160),$s);
        if ($c == "�") $s = str_replace($c,chr(144),$s);
        if ($c == "�") $s = str_replace($c,chr(161),$s);
        if ($c == "�") $s = str_replace($c,chr(162),$s);
        if ($c == "�") $s = str_replace($c,chr(163),$s);
    }
    return $s;
}

function rand_string($length=6) {
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
  $size = strlen( $chars );
  $str = "";
  for( $i = 0; $i < $length; $i++ ) {
    $str.= $chars[ rand( 0, $size - 1 ) ];
  }
  return $str;
}
?>