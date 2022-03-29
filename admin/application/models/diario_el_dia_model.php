<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Diario_El_Dia_Model extends CI_Model {
	
	// Parsea el email

	function parse_all_email($texto_email) {
		// Cargamos las librerias
		//include_once '/home/ubuntu/inmovar/admin/application/libraries/Text/inline_function.php';
		include_once 'C:\xampp\inmovar\admin\application\libraries\Text\inline_function.php';
		// Este es el template utilizado que tiene los placeholders donde se va a extraer informacion
		$template = <<<XML
			* Has recibido una consulta de un interesado: * {{titulo}} $ {{precio}} {{sup_cubierta}} m=C2=B2 sup. cubierta {{dormitorios}} Dormitorios {{tipo_dpto}} en {{tipo_operacion}} en La Plata... Ver propiedad Interesado: {{email}} Tel=C3=A9fono: {{telefono}} Mensaje: {{mensaje}} Responder mensaje servicio brindado por
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
		    if (strpos($original, " ") !== false) {
		    	$items_ori = explode(" ", $original);
		    	$items_final = $this->filtrar_nuevo_array(explode(' ', $final));

		    	for ($i=0; $i < sizeof($items_ori); $i++) { 
		    		$original = $items_ori[$i];
		    		$final = $items_final[$i];
		    		//echo $original." ".$final;
						$consulta = $this->add_objeto($consulta, $original, $final);
		    	}

		    } else {
			    // Vamos llenando el objeto
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

    return $obj;
	}

	function filtrar_nuevo_array($array) {
		$newarray = array();
		$i = 0;
    foreach ($array as $k => $value) {
      if ($value !== "") {
      	$newarray[$i] = $value;
      	$i++;
      }
    }

    return $newarray;
	}

	function parse_email($texto_email) {

		// Cargamos las librerias
		//include_once '/home/ubuntu/inmovar/admin/application/libraries/Text/inline_function.php';
		include_once '/admin/application/libraries/Text/inline_function.php';
		// Este es el template utilizado que tiene los placeholders donde se va a extraer informacion
		$template = <<<XML
ID Viviendas.ElDia.com.ar de la Propiedad sobre la que se consulta: {{id}}<br><br>Codigo de la Propiedad en la Inmobiliaria: Codigo de la Propiedad Inmobiliaria: {{codigo}}<br><br>La propiedad puede ser consultada {{link}}<br><br>Operacion: '{{operacion}}'<br><br>Direccion: {{direccion}}<br><br>Quien Realiza la Consulta: <br><br>Apellido y Nombre: {{nombre}}<br><br>Telefono: {{telefono}}<br><br>Mail: {{email}}<br><br>La consulta realizada es: <br><p>{{mensaje}}</p><br/>      
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
		    file_put_contents("log_diario_el_dia.txt", date("Y-m-d H:i:s")." - ORIG: ".$original." || FINAL: ".$final."\n", FILE_APPEND);

		    // Vamos llenando el objeto
		    if ($original == "{{codigo}}") $consulta->codigo_propiedad = $final;
		    else if ($original == "{{telefono}}") $consulta->telefono = $final;
		    else if ($original == "{{direccion}}") $consulta->direccion_propiedad = $final;
		    else if ($original == "{{link}}") $consulta->link = $final;
		    else if ($original == "{{email}}") $consulta->email = $final;
		    else if ($original == "{{nombre}}") $consulta->nombre = $final;
		    else if ($original == "{{mensaje}}") $consulta->mensaje = strip_tags($final);
		  }
		}
		return $consulta;
	}

}