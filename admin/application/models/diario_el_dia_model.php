<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Diario_El_Dia_Model extends CI_Model {
	
	// Parsea el email
	function parse_email($texto_email) {

		// Cargamos las librerias
		include_once '/home/ubuntu/admin/application/libraries/Text/inline_function.php';

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
		    $original = trim($original);
		    $final = implode(" ", $dif->final);

		    // Vamos llenando el objeto
		    if ($original == "{{id}}") $consulta->id_propiedad = $final;
		    else if ($original == "{{telefono}}") $consulta->telefono = $final;
		    else if ($original == "{{email}}") $consulta->email = $final;
		    else if ($original == "{{nombre}}") $consulta->nombre = $final;
		    else if ($original == "{{direccion}}") $consulta->direccion = $final;
		    else if ($original == "{{operacion}}") $consulta->operacion = $final;
		    else if ($original == "{{link}}") $consulta->link = $final;
		    else if ($original == "{{mensaje}}") $consulta->mensaje = strip_tags($final);
		  }
		}
		return $consulta;
	}

}