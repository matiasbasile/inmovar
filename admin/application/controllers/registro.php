<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registro extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	function entrenaymas() {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		$profesional = $this->input->post("profesional");
		$especialidad = $this->input->post("especialidad");
		$nombre = $this->input->post("nombre");
		$localidad = $this->input->post("localidad");
		$direccion = $this->input->post("direccion");
		$provincia = $this->input->post("provincia");
		$pais = $this->input->post("pais");
		$telefono = $this->input->post("telefono");
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		$numero = $this->input->post("numero");
		$id_empresa = 1319;

		$data = new stdClass();
		$data->id = 0;
		$data->id_empresa = $id_empresa;
		$data->nombre = $nombre;
		$data->id_perfiles = 1357;
		$data->activo = 0;
		$data->fecha_alta = date("Y-m-d H:i:s");
		$data->password = md5($password);
		$data->celular = $telefono;
		$data->email = $email;
		$data->cargo = $numero;
		$data->titulos = array($profesional);
		$data->path = "";
		$data->especialidades = array($especialidad);

		$dir = new stdClass();
		$dir->id = 0;
		$dir->id_empresa = $id_empresa;
		$dir->nombre = "Dirección Principal";
		$dir->nuevo = 1;
		$dir->activo = 1;
		$dir->direccion = $direccion;
		$dir->provincia = $provincia;
		$dir->localidad = $localidad;
		$dir->pais = $pais;
		$dir->horarios = array();
		$data->direcciones = array($dir);

		$this->load->model("Usuario_Model");
		$this->Usuario_Model->save($data);

		$this->load->model("Empresa_Model");
		$empresa = $this->Empresa_Model->get($id_empresa);

		$this->load->model("Email_Template_Model");
		$template = $this->Email_Template_Model->get_by_key("email-nuevo-registro",$id_empresa);
    require APPPATH.'libraries/Mandrill/Mandrill.php';
    $body = $template->texto;
    $body = str_replace("{{nombre}}", $nombre, $body);
    mandrill_send(array(
      "to"=>$empresa->email,
      "from"=>"no-reply@varcreative.com",
      "subject"=>$template->nombre,
      "body"=>$body,
      "bcc"=>"basile.matias99@gmail.com",
    ));
		echo json_encode(array("error"=>0));
	}	

	function psicoweb() {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		$tipo = $this->input->post("tipo");
		$profesional = $this->input->post("profesional");
		$nombre = $this->input->post("nombre");
		$localidad = $this->input->post("localidad");
		$direccion = $this->input->post("direccion");
		$provincia = $this->input->post("provincia");
		$pais = $this->input->post("pais");
		$telefono = $this->input->post("telefono");
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		$numero = $this->input->post("numero");
		$id_empresa = 1245;

		$data = new stdClass();
		$data->id = 0;
		$data->id_empresa = $id_empresa;
		$data->nombre = $nombre;
		$data->id_perfiles = 1357;
		$data->activo = 0;
		$data->fecha_alta = date("Y-m-d H:i:s");
		$data->password = md5($password);
		$data->celular = "549".$telefono;
		$data->email = $email;
		$data->cargo = $numero;
		$data->custom_7 = $tipo; // TODO: CENTRO O PROFESIONAL
		$data->titulos = array($profesional);
		$data->path = "";

		$dir = new stdClass();
		$dir->id = 0;
		$dir->id_empresa = $id_empresa;
		$dir->nombre = utf8_decode("Dirección Principal");
		$dir->nuevo = 1;
		$dir->activo = 1;
		$dir->direccion = $direccion;
		$dir->provincia = $provincia;
		$dir->localidad = $localidad;
		$dir->pais = $pais;
		$dir->horarios = array();
		$data->direcciones = array($dir);

		$this->load->model("Usuario_Model");
		$this->Usuario_Model->save($data);

		$this->load->model("Empresa_Model");
		$empresa = $this->Empresa_Model->get($id_empresa);

		$this->load->model("Email_Template_Model");
		$template = $this->Email_Template_Model->get_by_key("email-nuevo-registro",$id_empresa);
    require APPPATH.'libraries/Mandrill/Mandrill.php';
    $body = $template->texto;
    $body = str_replace("{{nombre}}", $nombre, $body);
    mandrill_send(array(
      "to"=>$empresa->email,
      "from"=>"no-reply@varcreative.com",
      "subject"=>$template->nombre,
      "body"=>$body,
      "bcc"=>"basile.matias99@gmail.com",
    ));
		echo json_encode(array("error"=>0));
	}

	function pymvar() {
		
		if (!isset($_SESSION["perfil"])) redirect("/");
		$this->load->helper('url');
		
		$q_tipos_iva = $this->db->query("SELECT * FROM tipos_iva ORDER BY id ASC");
		$tipos_iva = $q_tipos_iva->result();
				
		$data = array(
			"base_url"=>$this->config->item("base_url"),
      "id_usuario" => $_SESSION["id"],
			"nombre_usuario" => $_SESSION["nombre_usuario"],
			"tipos_iva" => $tipos_iva,
		);
		
		$this->load->view('registro_pymvar',$data);
	}
	
	function guardar_pymvar() {
		
		$razon_social = $this->input->post("razon_social");
		$id_tipo_contribuyente = $this->input->post("id_tipo_contribuyente");
		$id_proyecto = 1;
		$cuit = $this->input->post("cuit");
		$punto_venta = $this->input->post("punto_venta");
		$path = $this->input->post("path");
		$nombre = $this->input->post("nombre");
		$disenio_factura = $this->input->post("disenio_factura");
		$disenio_factura_color = $this->input->post("disenio_factura_color");
		
		$empresa = new stdClass();
		$empresa->id_proyecto = $id_proyecto;
		$empresa->id_plan = 1; // PLAN BASICO
		$empresa->fecha_alta = date("Y-m-d");
		$empresa->crear_usuario = FALSE; // PARA QUE NO CREE UN NUEVO USUARIO, SINO QUE ENLACE CON EL QUE YA SE REGISTRO
		$empresa->razon_social = ($razon_social !== FALSE) ? $razon_social : "";
		$empresa->id_tipo_contribuyente = ($id_tipo_contribuyente !== FALSE) ? $id_tipo_contribuyente : 1;
		$empresa->cuit = ($cuit !== FALSE) ? $cuit : "";
		$empresa->logo = ($path !== FALSE) ? $path : "";
		$empresa->punto_venta = ($punto_venta !== FALSE) ? $punto_venta : 2;
		$empresa->nombre = ($nombre !== FALSE) ? $nombre : "";
		$empresa->email = $_SESSION["email"];
		$empresa->configuracion_menu = 1;
		$empresa->configuracion_menu_iconos = 1;
		$empresa->configuracion_sonido = 0;
		$empresa->configuracion_autogenerar_codigos = 1;
		
		$this->load->model("Empresa_Model");
		$salida = $this->Empresa_Model->insert($empresa);
		if ($salida["error"] === FALSE && $salida["id"] != 0) {
			
			$id_empresa = $salida["id"];
			
			$disenio_factura = ($disenio_factura !== FALSE) ? $disenio_factura : "";
			$disenio_factura_color = ($disenio_factura_color !== FALSE) ? $disenio_factura_color : "";
			// Los diseños son propiedades de los puntos de venta
			$sql = "UPDATE puntos_venta SET disenio_factura = '$disenio_factura', disenio_factura_color = '$disenio_factura_color' ";
			$sql.= "WHERE id_empresa = $id_empresa AND por_default = 1 ";
			$this->db->query($sql);
			
			$logo = str_replace("uploads/images","uploads/$id_empresa/images",$empresa->logo);
			$sql = "UPDATE empresas SET logo = '$logo' WHERE id = $id_empresa ";
			$this->db->query($sql);
			
			// Movemos la imagen subida
			@rename($empresa->logo,$logo);
			
			// ENTRAMOS AL SISTEMA
			$sql = "SELECT U.* ";
			$sql.= "FROM com_usuarios U INNER JOIN com_perfiles P ON (U.id_perfiles = P.id) ";
			$sql.= "WHERE U.id_empresa = $id_empresa AND U.id = ".$_SESSION["id"]." ";
			$sql.= "LIMIT 0,1 ";
			$query = $this->db->query($sql);
			$resultado = $query->result();
			$usuario = $query->row();
			
			// Actualizamos la session
			$_SESSION["perfil"] = $usuario->id_perfiles;
			$_SESSION["id_empresa"] = $usuario->id_empresa;
			
			$base = $this->config->item("base_url");
			header("Location: ".$base."app/");
			
		} else {
			// Hubo un error al guardar la empresa
			echo "HUBO UN ERROR AL GUARDAR LA EMPRESA";
		}
	}


	function inmovar() {
		
		if (!isset($_SESSION["perfil"])) redirect("/");
		$this->load->helper('url');
		
		// TODO: Esto deberia ser dinamico, pero por ahora es fijo
		$q = $this->db->query("SELECT * FROM web_templates WHERE id IN (8,9,10,11,12,13,14) ORDER BY id ASC");
		$templates = $q->result();
		
		$data = array(
			"base_url"=>$this->config->item("base_url"),
      "id_usuario" => $_SESSION["id"],
			"nombre_usuario" => $_SESSION["nombre_usuario"],
			"templates"=>$templates,
		);
		
		$this->load->view('registro_inmovar',$data);
	}
	
	function guardar_inmovar() {
		
		$razon_social = $this->input->post("razon_social");
		$id_proyecto = 3;
		$path = $this->input->post("path");
		$nombre = $this->input->post("nombre");
		$color = $this->input->post("color");
		$direccion = $this->input->post("direccion");
		$id_web_template = $this->input->post("id_web_template");
		
		$empresa = new stdClass();
		$empresa->id_proyecto = $id_proyecto;
		$empresa->id_plan = 1; // PLAN BASICO
		$empresa->fecha_alta = date("Y-m-d");
		$empresa->crear_usuario = FALSE; // PARA QUE NO CREE UN NUEVO USUARIO, SINO QUE ENLACE CON EL QUE YA SE REGISTRO
		$empresa->razon_social = ($razon_social !== FALSE) ? $razon_social : "";
		$empresa->nombre = $empresa->razon_social;
		$empresa->direccion = ($direccion !== FALSE) ? $direccion : "";
		$empresa->logo = ($path !== FALSE) ? $path : "";
		$empresa->email = $_SESSION["email"];
		$empresa->configuracion_menu = 1;
		$empresa->configuracion_menu_iconos = 1;
		$empresa->configuracion_sonido = 0;
		$empresa->configuracion_autogenerar_codigos = 1;
		$empresa->id_web_template = $id_web_template;
		
		$this->load->model("Empresa_Model");
		$salida = $this->Empresa_Model->insert($empresa);
		if ($salida["error"] === FALSE && $salida["id"] != 0) {
			
			$id_empresa = $salida["id"];
			
			// Actualizamos el color
			$this->db->query("UPDATE web_configuracion SET color_principal = '$color' WHERE id_empresa = $id_empresa ");
			
			$logo = str_replace("uploads/images","uploads/$id_empresa/images",$empresa->logo);
			$sql = "UPDATE empresas SET logo = '$logo', path = '$logo' WHERE id = $id_empresa ";
			$this->db->query($sql);
			
			// Movemos la imagen subida
			@rename($empresa->logo,$logo);
			
			// ENTRAMOS AL SISTEMA
			$sql = "SELECT U.* ";
			$sql.= "FROM com_usuarios U INNER JOIN com_perfiles P ON (U.id_perfiles = P.id) ";
			$sql.= "WHERE U.id_empresa = $id_empresa AND U.id = ".$_SESSION["id"]." ";
			$sql.= "LIMIT 0,1 ";
			$query = $this->db->query($sql);
			$resultado = $query->result();
			$usuario = $query->row();
			
			// Actualizamos la session
			$_SESSION["perfil"] = $usuario->id_perfiles;
			$_SESSION["id_empresa"] = $usuario->id_empresa;
			
			$base = $this->config->item("base_url");
			header("Location: ".$base."app/");
			
		} else {
			// Hubo un error al guardar la empresa
			echo "HUBO UN ERROR AL GUARDAR LA EMPRESA";
		}
	}
	
}