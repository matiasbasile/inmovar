<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Importacion_Email_Model extends CI_Model {
  
  // Parsea el email

  function parse_all_email($texto_email) {
    // Cargamos las librerias
    //include_once '/home/ubuntu/inmovar/admin/application/libraries/Text/inline_function.php';
    include_once 'C:\xampp\inmovar\admin\application\libraries\Text\inline_function.php';
    // Este es el template utilizado que tiene los placeholders donde se va a extraer informacion
    $template = <<<XML
      * Has recibido una consulta de un interesado: * {{titulo}} $ {{precio}} {{sup_cubierta}} m² sup. cubierta 
      {{dormitorios}} Dormitorios {{tipo_dpto}} en {{tipo_operacion}} en La Plata... Ver propiedad 
      Nombre: {{nombre}} Interesado: {{email}} Teléfono: {{telefono}} Mensaje: {{mensaje}} Responder mensaje servicio brindado por
    XML;
    $template = str_replace("<br>", " ", $template);
    $texto_email = str_replace("<br>", " ", $texto_email);
    $hlines1 = explode(" ",$template);
    $hlines2 = explode(" ",$texto_email);

    // La funcion recibe dos arrays, por eso se explotan con espacios y enters
    $diff = new Text_Diff($hlines1, $hlines2);

    $consulta = new stdClass();
    foreach($diff->getDiff() as $dif) {
      // Si DIF es de clase change, es porque es un cambio
      if (get_class($dif) == "Text_Diff_Op_change") {
        $original = implode(" ", $dif->orig);
        $original = str_replace("'", "", $original);
        $original = strip_tags($original);
        $original = trim($original);
        $final = implode(" ", $dif->final);

        //Palabras a quitar que van surgiendo desde los errores
        //Del original
        $original = str_replace(" Responder mensaje", "", $original);
        //Del final
        $final = str_replace(" Respondermensaje ", "", $final);
        if (strpos($original, " ") !== false) {
          $res = $this->filtrar_nuevo_array($final, $original);
          
          $items_ori = $res['items_ori'];
          $items_final = $res['items_final'];

          for ($i=0; $i < sizeof($items_ori); $i++) { 
            $original = $items_ori[$i];
            $final = $items_final[$i];
            //echo $original." ".$final."<br>";
            $consulta = $this->add_objeto($consulta, $original, $final);
          }

        } else {
          $consulta = $this->add_objeto($consulta, $original, $final);
        }
      }
    }
    return $consulta;   
  }


  function add_objeto($obj, $original, $final) {
    if ($original == "{{titulo}}") $obj->titulo = $final;
    else if ($original == "{{precio}}") $obj->precio = $final;
    else if ($original == "{{sup_cubierta}}") $obj->sup_cubierta = $final;
    else if ($original == "{{dormitorios}}") $obj->dormitorios = $final;
    else if ($original == "{{tipo_dpto}}") $obj->tipo_dpto = $final;
    else if ($original == "{{tipo_operacion}}") $obj->tipo_operacion = $final;
    else if ($original == "{{email}}") $obj->email = $final;
    else if ($original == "{{telefono}}") $obj->telefono = $final;
    else if ($original == "{{mensaje}}") $obj->mensaje = $final;  
    else if ($original == "{{nombre}}") $obj->nombre = $final;     

    return $obj;
  }

  function filtrar_nuevo_array($array_texto, $original) {
    $salida = array();
    //Primero verificamos si hay un signo peso, en el caso
    //De que lo haya, estamos teniendo el titulo, precio y sup_cubierta
    //Sino, son otros campos
    //Palabras a quitar que van surgiendo desde los errores
    
    $array_texto = str_replace("Interesado:", "", $array_texto);
    $array_texto = str_replace("Nombre:", "", $array_texto);
    $array_texto = str_replace("Teléfono:", "", $array_texto);

    if (strpos($array_texto, "$") !== false) {
      //Entonces, si lo hay lo que tenemos que hacer es volver a dividirlo para saber que esa es nuestro titulo
      $titulo_propiedad = substr($array_texto,0,strpos($array_texto, "$"));
      $otros_strings = substr($array_texto, strpos($array_texto, "$"));

      $nuevo_array = explode(" ", $otros_strings);
      $nuevo_array_filtrado = array();
      $i = 0;
      foreach ($nuevo_array as $k => $value) {
        if ($value !== "") {
          $nuevo_array_filtrado[$i] = $value;
          $i++;
        }
      }
      $array_salida[0] = $titulo_propiedad;
      $array_salida[1] = $nuevo_array_filtrado[0];
      $array_salida[2] = $nuevo_array_filtrado[1];

    } elseif (strpos($array_texto, "@") !== false) {
      $array = explode(" ", $array_texto);
      $pre_array_salida = array();
      $i = 0;
      foreach ($array as $k => $value) {
        if ($value !== "") {
          $pre_array_salida[$i] = $value;
          $i++;
        }
      }    
      //En este caso si hay un @ SABEMOS SI O SI que la posicion que contenga el arroba debe ser
      // la pos 0 o 1, si la posicion es 2 o mas significa que hay un nombre que tiene 1 o mas espacios
      if (strpos($pre_array_salida[0], "@") === false && strpos($pre_array_salida[1], "@") === false) {    
        //Entonces si estas 2 posiciones no tienen @ tenemos que recorrer el array y unificar
        //Todas las posiciones anteriores
        $i = 0;
        $encontro = 0;
        $nombre = "";
        $ultima_pos = 0;
        foreach ($pre_array_salida as $k => $value) {
          if (strpos($value, "@") === false && $encontro == 0) {
            $nombre .= " ".$value;
            $ultima_pos = $k;
            $i++;
          } elseif (strpos($value, "@") === true) {
            $encontro = 1;
          }
        }  
        $array_salida[0] = $nombre;
        $array_salida[1] = $pre_array_salida[$ultima_pos+1];
        //$array_salida[2] = $pre_array_salida[$ultima_pos+2];
      //Si el @ esta en una posicion valida, simplemente duplicamos el array 
      } else {
        $array_salida = $pre_array_salida;
      }

    } else {
      $array = explode(" ", $array_texto);
      $array_salida = array();
      $i = 0;
      foreach ($array as $k => $value) {
        if ($value !== "") {
          $array_salida[$i] = $value;
          $i++;
        }
      }
    }

    $array_ori = explode(" ", $original);

    $i = 0;
    foreach ($array_ori as $k => $value) {
      //SI EL ITEM ES DIFERENTE DE VACIO Y
      //COMIENZA CON {{ Y TERMINA CON }}
      //SE AGREGA
      if ($value !== "" && (substr($value, 0, 2) == "{{" && substr($value, strlen($value)-2) == "}}")) {
        $array_items[$i] = $value;
        $i++;
      }
    }

    $salida['items_ori'] = $array_items;
    $salida['items_final'] = $array_salida;
    return $salida;
  }

}