<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
    $this->load->library('user_agent');
    $this->load->view('inicio',array(
      "is_explorer"=>$this->agent->is_browser("Internet Explorer"),
      "base_url"=>$this->config->item("base_url"),
    ));
	}
    
  // Cambia el estado del programa
  function estado() {
    $estado = $_SESSION["estado"];
    if ($estado == 0) $_SESSION["estado"] = 1;
    else $_SESSION["estado"] = 0;
    echo json_encode(array("error"=>false));
  }
	
  public function recuperar() {
    $this->load->view('recuperar_pass',array(
      "base_url"=>$this->config->item("base_url"),
    ));
  }

  public function registro() {
    $id_plan = ($this->input->get("p") !== FALSE) ? $this->input->get("p") : 3;
    $email = ($this->input->get("email") !== FALSE) ? $this->input->get("email") : "";
    $this->load->view('registro',array(
      "id_plan"=>$id_plan,
      "email"=>$email,
      "base_url"=>$this->config->item("base_url"),
    ));
  }
	
	public function restaurar() {
		$id = $this->input->get("id");
		if ($id == FALSE) header("Location: /panel/login/");
		// Si el usuario inicio el proceso de recupero de contrase�a
		$q = $this->db->query("SELECT * FROM com_usuarios WHERE id = $id AND inicio_recup_pass = 1");
		if ($q->num_rows() > 0) {
			// Mostramos la pantalla para restaurar el password
			$this->load->view('restaurar_pass',array(
				"id"=>$id,
				"base_url"=>$this->config->item("base_url"),
			));			
		} else {
			// Sino, solamente redireccionamos
			header("Location: /panel/");
		}
	}	
	
	public function recuperar_pass() {
		$error = 1; $mensaje = "";
		if (isset($_POST["email"])) {
			$email = isset($_POST["email"])?filter_var($_POST["email"],FILTER_SANITIZE_STRING):"";
			$q = $this->db->query("SELECT * FROM com_usuarios WHERE email = '$email' LIMIT 0,1");
		  	if ($q->num_rows()>0) {
				$cliente = $q->row();
				
				$q_conf = $this->db->query("SELECT * FROM configuracion WHERE id = 1");
				$conf = $q_conf->row();
				
				// Enviamos el email al propio usuario
				$body = $conf->recuperar_pass_comercio_texto;
				$body = str_replace("{{usuario_id}}",$cliente->id,$body);
				$body = str_replace("{{usuario_nombre}}",$cliente->nombre,$body);
				$body = str_replace("{{usuario_apellido}}",$cliente->apellido,$body);
				$headers = "From: info@quelotraigan.com\r\n";
				$headers.= "MIME-Version: 1.0\r\n";
				$headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				@mail($email,$conf->recuperar_pass_comercio_asunto,$body,$headers);
				$this->db->query("UPDATE com_usuarios SET inicio_recup_pass = 1 WHERE id = $cliente->id");
				echo json_encode(array(
					"error"=>0,
					"mensaje"=>"Hemos enviado un email para restaurar tu clave a tu correo electronico.",
				));					
			} else {
				echo json_encode(array(
					"error"=>1,
					"mensaje"=>"No existe ningun usuario en el sistema registrado con el email: '$email'.",
				));				
			}
		}
	}
	
	public function restaurar_pass() {
		$id = $this->input->post("id");
		$password = $this->input->post("password");
		$this->db->query("UPDATE com_usuarios SET password = '$password', inicio_recup_pass = 0 WHERE id = $id AND inicio_recup_pass = 1");
		echo json_encode(array(
			"error"=>0, "mensaje"=>"Tu clave ha sido restaurada. Puedes iniciar sesion con tus nuevos datos."
		));
	}
	
	
	// Esta funcion solo esta disponible si estamos logueados como SUPERADMIN o venimos del SUPERADMIN
	function cambiar_empresa($id_empresa = 0) {
		$volver_admin = ((isset($_SESSION["volver_superadmin"]) && $_SESSION["volver_superadmin"] == 1) ? 1 : 0);
		$id_perfil = $_SESSION["perfil"];
		if ($id_perfil == -1) {
			$sql = "SELECT U.* ";
			$sql.= "FROM com_usuarios U INNER JOIN com_perfiles P ON (U.id_perfiles = P.id) ";
			$sql.= "WHERE U.id_empresa = $id_empresa AND P.principal = 1 AND P.id_empresa = $id_empresa ";
			$sql.= "LIMIT 0,1 ";
			$query = $this->db->query($sql);
			$resultado = $query->result();
			if (empty($resultado)) {
				// Usuario incorrecto
				echo json_encode(array("error"=>1,"mensaje"=>"Nombre de usuario y/o claves incorrectos."));
				return;
			}

      // Guardamos los datos anteriores en la sesion
      $id_anterior = $_SESSION["id"];
      $perfil_anterior = $_SESSION["perfil"];
      $nombre_usuario_anterior = $_SESSION["nombre_usuario"];
      $email_anterior = $_SESSION["email"];
      $id_empresa_anterior = $_SESSION["id_empresa"];
      $estado_anterior = $_SESSION["estado"];

			$usuario = $query->row();
			$_SESSION = array();
			$_SESSION["volver_superadmin"] = 1;
			$_SESSION["id"] = $usuario->id;
			$_SESSION["perfil"] = $usuario->id_perfiles;
			$_SESSION["nombre"] = $usuario->nombre." ".$usuario->apellido;
			$_SESSION["nombre_usuario"] = $usuario->nombre;
			$_SESSION["email"] = $usuario->email;
			$_SESSION["id_empresa"] = $usuario->id_empresa;
      $_SESSION["lang"] = (isset($usuario->language) ? (!empty($usuario->language) ? $usuario->language : "es" ) : "es");
			$_SESSION["estado"] = 1;

      $_SESSION["id_anterior"] = $id_anterior;
      $_SESSION["perfil_anterior"] = $perfil_anterior;
      $_SESSION["nombre_usuario_anterior"] = $nombre_usuario_anterior;
      $_SESSION["email_anterior"] = $email_anterior;
      $_SESSION["id_empresa_anterior"] = $id_empresa_anterior;
      $_SESSION["estado_anterior"] = $estado_anterior;

			echo json_encode(array("error"=>0,"id_perfil"=>$usuario->id_perfiles));			
		} else {
			if ($volver_admin == 1) {

        $id_anterior = $_SESSION["id_anterior"];
        $perfil_anterior = $_SESSION["perfil_anterior"];
        $nombre_usuario_anterior = $_SESSION["nombre_usuario_anterior"];
        $email_anterior = $_SESSION["email_anterior"];
        $id_empresa_anterior = $_SESSION["id_empresa_anterior"];
        $estado_anterior = $_SESSION["estado_anterior"];

        // Si soy yo
				$_SESSION = array();
        $_SESSION["id"] = $id_anterior;
        $_SESSION["perfil"] = $perfil_anterior;
        $_SESSION["nombre_usuario"] = $nombre_usuario_anterior;
        $_SESSION["email"] = $email_anterior;
        $_SESSION["id_empresa"] = $id_empresa_anterior;
        $_SESSION["estado"] = $estado_anterior;
        $_SESSION["lang"] = "es";
				$_SESSION["volver_superadmin"] = 0;
      }
			echo json_encode(array("error"=>0));
		}
	}	
	

  // Esta funcion solo esta disponible si estamos logueados como SUPERADMIN o venimos del SUPERADMIN
  function cambiar_usuario($id_empresa = 0, $id_usuario = 0) {
    $volver_admin = ((isset($_SESSION["volver_superadmin"]) && $_SESSION["volver_superadmin"] == 1) ? 1 : 0);
    $id_perfil = $_SESSION["perfil"];
    if ($id_perfil != -1 && $volver_admin != 1 && $id_empresa != 571 && $id_empresa != 1284) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"Operacion no permitida",
      ));
      exit();
    }
    $sql = "SELECT U.* ";
    $sql.= "FROM com_usuarios U ";
    $sql.= "WHERE U.id_empresa = $id_empresa ";
    $sql.= "AND U.id = $id_usuario ";
    $sql.= "LIMIT 0,1 ";
    $query = $this->db->query($sql);
    $resultado = $query->result();
    if (empty($resultado)) {
      // Usuario incorrecto
      echo json_encode(array("error"=>1,"mensaje"=>"Nombre de usuario y/o claves incorrectos."));
      return;
    }
    $usuario = $query->row();
    $_SESSION = array();
    $_SESSION["volver_superadmin"] = 1;
    $_SESSION["id"] = $usuario->id;
    $_SESSION["perfil"] = $usuario->id_perfiles;
    $_SESSION["nombre"] = $usuario->nombre." ".$usuario->apellido;
    $_SESSION["nombre_usuario"] = $usuario->nombre;
    $_SESSION["email"] = $usuario->email;
    $_SESSION["id_empresa"] = $usuario->id_empresa;
    $_SESSION["lang"] = (isset($usuario->language) ? (!empty($usuario->language) ? $usuario->language : "es" ) : "es");
    $_SESSION["estado"] = 1;
    echo json_encode(array("error"=>0,"id_perfil"=>$usuario->id_perfiles));     
  } 

	// UTILIZADO EN LOS LOGINS DE LAS PAGINAS CON SUS RESPECTIVOS CLIENTES
	function check_cliente() {

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		header('Access-Control-Allow-Origin: *');
		$email = $this->input->post("email");
		$password = $this->input->post("password");
    $lang = ($this->input->post("lang") !== FALSE) ? $this->input->post("lang") : "es";

		if ($email === FALSE) {
			echo json_encode(array(
				"error"=>1,
				"mensaje"=>"No se especifico el parametro email",
			));
			exit();
		}
		if ($this->input->post("ps") !== FALSE) $password = $this->input->post("ps");
		$id_empresa = $this->input->post("id_empresa");
    $id_proyecto = ($this->input->post("id_proyecto") !== FALSE) ? $this->input->post("id_proyecto") : 0;
		
		$sql = "SELECT C.*, IF(L.codigo_postal IS NULL,'',L.codigo_postal) AS codigo_postal ";
		$sql.= "FROM clientes C LEFT JOIN com_localidades L ON (C.id_localidad = L.id) ";
		$sql.= "WHERE C.email = '$email' ";
		$sql.= "AND C.password = '$password' ";
		$sql.= "AND C.id_empresa = '$id_empresa' ";
		$sql.= "LIMIT 0,1 ";
		$query = $this->db->query($sql);

		// Datos invalidos
		$resultado = $query->result();
		if (empty($resultado)) {
			// Usuario incorrecto
      $men = ($lang == "en") ? "Incorrect password." : "Nombre de usuario y/o claves incorrectos.";
			echo json_encode(array("error"=>true,"mensaje"=>$men));
			return;
		} else {

			$cliente = $query->row();

			// LaboralGym si permite usuarios no habilitados para entrar a la app
      if ($cliente->activo == 0 && $id_empresa != 341) {
        // El usuario aun no esta habilitado
        echo json_encode(array(
          "error"=>true,
          "mensaje"=>"El usuario no se encuentra habilitado. Por favor comuniquese con el administrador."));
        return;        
      }

			$_SESSION["id_cliente"] = $cliente->id;
			$_SESSION["nombre"] = $cliente->nombre;
			$_SESSION["codigo_postal"] = $cliente->codigo_postal;
			$_SESSION["direccion"] = $cliente->direccion;
			$_SESSION["telefono"] = $cliente->telefono;
      $_SESSION["celular"] = $cliente->celular;
      $_SESSION["cliente_lista"] = $cliente->lista;
      $_SESSION["cliente_descuento"] = $cliente->descuento;
			$_SESSION["email"] = $email;

			$tiempo = time()+(60*60*24*90);
			setcookie("id_cliente_1",$cliente->id,$tiempo,"/");
			setcookie("nombre_1",$cliente->nombre,$tiempo,"/");
			setcookie("codigo_postal_1",$cliente->codigo_postal,$tiempo,"/");
			setcookie("direccion_1",$cliente->direccion,$tiempo,"/");
			setcookie("telefono_1",$cliente->telefono,$tiempo,"/");
      setcookie("celular_1",$cliente->celular,$tiempo,"/");
      setcookie("cliente_lista_1",$cliente->lista,$tiempo,"/");
      setcookie("cliente_descuento_1",$cliente->descuento,$tiempo,"/");
      setcookie("activo",$cliente->activo,$tiempo,"/");
			setcookie("email_1",$email,$tiempo,"/");

      // Estamos buscando los alumnos
      if ($id_proyecto == 5) {
        $this->load->model("Alumno_Model");
        $alumno = $this->Alumno_Model->get($cliente->id,array(
          "id_empresa"=>$id_empresa,
        ));
        if ($alumno !== FALSE) {
          $_SESSION["nombre"] = $alumno->nombre;
          $_SESSION["id_comision"] = $alumno->id_comision;
        }
      }
			
			// Si el cliente tiene algun pedido, lo cargamos en la session tambien
			/*
			$this->load->model("Pedido_Model");
			$pedido = $this->Pedido_Model->get_by_cliente($cliente->id);
			if (!empty($pedido)) {
				$pedido = json_encode($pedido);
				$_SESSION["pedido"] = $pedido;				
			}
			*/

			$salida = array(
				"error"=>false,
				"id"=>$cliente->id,
				"nombre"=>$cliente->nombre,
				"activo"=>$cliente->activo,
				"id_empresa"=>$cliente->id_empresa, // Se devuelve la empresa para poder compararla con la que se esta logueando
			);
			if ($id_empresa == 341) {
				$salida["custom_1"] = $cliente->custom_1;
				$salida["custom_2"] = $cliente->custom_2;
			}
			echo json_encode($salida);
		}
	}
	

	// UTILIZADO EN LOS LOGINS DE LAS INMOBILIARIAS
	function check_propietario() {
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		
		$sql = "SELECT C.* ";
		$sql.= "FROM inm_propietarios C ";
		$sql.= "WHERE C.email = '$email' ";
		$sql.= "AND C.password = '$password' ";
		$sql.= "LIMIT 0,1 ";
		$query = $this->db->query($sql);

		// Datos invalidos
		$resultado = $query->result();
		if (empty($resultado)) {
			// Usuario incorrecto
			echo json_encode(array("error"=>true,"mensaje"=>"Nombre de usuario y/o claves incorrectos."));
			return;
		} else {
			$cliente = $query->row();
			$_SESSION["id_propietario"] = $cliente->id;
			$_SESSION["nombre"] = $cliente->nombre;
			$_SESSION["telefono"] = $cliente->telefono;
			$_SESSION["email"] = $email;
			echo json_encode(array(
				"error"=>false,
				"id_empresa"=>$cliente->id_empresa, // Se devuelve la empresa para poder compararla con la que se esta logueando
			));
		}
	}
	
	function check() {

    header('Access-Control-Allow-Origin: *');
		$email = $this->input->post("nombre");
		$password = $this->input->post("password");

    if ($email == FALSE || empty($email) || $password == FALSE || empty($password) || (strpos($email, ";")>0) || (strpos($password, ";")>0) ) {
      echo json_encode(array("error"=>true,"mensaje"=>"Parametros incorrectos.")); return;
    }
		
		// Controlamos si es SUPERADMIN
    // 1805Inmovar2020
		if ($email == "inmovar" && $password == "9fa6c4b0bfb38bf9bd996c995032c59b") {
			
			// Guardamos el usuario en la session
			$_SESSION["id"] = 0;
      $_SESSION["superusuario"] = 1;
			$_SESSION["perfil"] = -1;
			$_SESSION["nombre_usuario"] = "Superadmin";
			$_SESSION["email"] = "info@inmovar.com.ar";
			$_SESSION["id_empresa"] = 0;
			$_SESSION["estado"] = 0;
      $_SESSION["lang"] = "es";
			echo json_encode(array("error"=>false));
			return;
			
		} else {
			$this->load->model("Usuario_Model");

      $this->db->where("email",$email);
      $this->db->where("password",$password);
      $query = $this->db->get("com_usuarios");
	
			// Datos invalidos
			$resultado = $query->result();
			if (empty($resultado)) {
				// Usuario incorrecto
				echo json_encode(array("error"=>true,"mensaje"=>"Nombre de usuario y/o claves incorrectos."));
				return;
			}
			$usuario = $query->row();

      $this->load->model("Log_Model");
			
			// ES UN USUARIO ADMINISTRADOR
			if ($usuario->admin == 1) {
				
				// Guardamos el usuario en la session
				$_SESSION["id"] = $usuario->id;
				$_SESSION["perfil"] = -1;
				$_SESSION["nombre_usuario"] = $usuario->nombre;
				$_SESSION["email"] = $usuario->email;
				$_SESSION["id_empresa"] = 0;
				$_SESSION["estado"] = (isset($usuario->estado_inicial) ? $usuario->estado_inicial : 0);
        $_SESSION["lang"] = (isset($usuario->language) ? (!empty($usuario->language) ? $usuario->language : "es" ) : "es");

        // Log
        $this->Log_Model->registrar(array(
          "id_empresa"=>0,
          "texto"=>$usuario->nombre." ha ingresado al sistema.",
          "importancia"=>"L",
        ));

				echo json_encode(array("error"=>false));
				return;
				
			} else {
				
				// FALTA COMPLETAR EL REGISTRO
				// Un usuario normal siempre debe tener una empresa asociada al mismo
				if ($usuario->id_empresa == 0) {
					
					
				// ES UN USUARIO REGULAR
				} else {

					// Si hay que controlar el acceso por horarios
					if ($usuario->hora_desde != "00:00:00" && $usuario->hora_hasta != "00:00:00") {
						$ahora = date("H:i:s");
						if (!($usuario->hora_desde <= $ahora && $ahora <= $usuario->hora_hasta)) {
							echo json_encode(array("error"=>true,"mensaje"=>"ERROR: Ud. no esta habilitado para entrar al sistema en este horario."));
							return;					
						}
					}

          // Controlamos si es la primera vez que entra al sistema
          if ($this->db->field_exists("primer_login","web_configuracion")) {
            $q = $this->db->query("SELECT WC.*, E.id_proyecto FROM web_configuracion WC INNER JOIN empresas E ON (WC.id_empresa = E.id) WHERE WC.id_empresa = $usuario->id_empresa AND WC.primer_login = 1");
            if ($q->num_rows()>0) {
              $web_configuracion = $q->row();
              $this->db->query("UPDATE web_configuracion SET primer_login = 0 WHERE id_empresa = $usuario->id_empresa ");

              $sql = "SELECT * FROM crm_emails_templates ";
              $sql.= "WHERE clave = 'primeros-pasos' AND id_empresa = 0 "; // TEMPLATES COPIADOS DE VARCREATIVE ID_EMPRESA = 118
              $query = $this->db->query($sql);
              $template = $query->row();
              if (!empty($template)) {
                $bcc_array = array("basile.matias99@gmail.com","misticastudio@gmail.com");
                require_once APPPATH.'libraries/Mandrill/Mandrill.php';
                $body = $template->texto;
                $body = str_replace("{{email}}",$usuario->email,$body);
                $body = str_replace("{{nombre}}",htmlentities($usuario->nombre,ENT_QUOTES),$body);
                mandrill_send(array(
                  "to"=>$usuario->email,
                  "from"=>"no-reply@varcreative.com",
                  "from_name"=>"Inmovar",
                  "subject"=>$template->nombre,
                  "body"=>$body,
                  "bcc"=>$bcc_array,
                ));
              }
            }
          }
					
					// TODO: Deberiamos controlar si no tiene vencido el pago
					
					// Guardamos el usuario en la session
					$_SESSION["id"] = $usuario->id;
					$_SESSION["perfil"] = $usuario->id_perfiles;
					$_SESSION["email"] = $usuario->email;
					$_SESSION["nombre_usuario"] = $usuario->nombre;
					$_SESSION["id_empresa"] = $usuario->id_empresa;
					$_SESSION["estado"] = (isset($usuario->estado_inicial) ? $usuario->estado_inicial : 0);
          $_SESSION["lang"] = (isset($usuario->language) ? (!empty($usuario->language) ? $usuario->language : "es" ) : "es");

					// Log
					$this->Log_Model->registrar(array(
            "id_empresa"=>$usuario->id_empresa,
            "texto"=>$usuario->nombre." ha ingresado al sistema.",
            "importancia"=>"L",
          ));
				}				
			}
			
			
			echo json_encode(array("error"=>false,"id_empresa"=>$usuario->id_empresa));
		}
	}


	// UTILIZADO EN LA APP
	function check_vendedor() {

		header('Access-Control-Allow-Origin: *');
		$email = $this->input->post("email");
		$password = $this->input->post("password");

		$sql = "SELECT V.*, ";
		$sql.= " IF (D.dispositivo IS NULL,0,D.dispositivo) AS dispositivo ";
		$sql.= "FROM vendedores V ";
		$sql.= "LEFT JOIN com_dispositivos D ON (V.id_empresa = D.id_empresa AND D.id_vendedor = V.id) ";
		$sql.= "WHERE V.email = '$email' ";
		$sql.= "AND V.password = '$password' ";
    $sql.= "AND V.id_empresa != 980 ";  // Para que no tome los vendedores cargados en la cuenta principal de YEYO
		$sql.= "LIMIT 0,1 ";
		$query = $this->db->query($sql);

		// Datos invalidos
		$resultado = $query->result();
		if (empty($resultado)) {
			// Usuario incorrecto
			echo json_encode(array(
				"error"=>1,
				"mensaje"=>"Usuario o clave incorrectos.",
				"dispositivo"=>0,
				"id"=>0,
			));
			return;
			
		} else {

			$vendedor = $query->row();
      $this->load->model("Empresa_Model");
      $empresa = $this->Empresa_Model->get_min($vendedor->id_empresa);

			/*
      if ($cliente->activo == 0) {
        // El usuario aun no esta habilitado
        echo json_encode(array(
          "error"=>1,
          "mensaje"=>"El vendedor no se encuentra habilitado. Por favor comuniquese con el administrador."));
        return;        
      }
      */
			echo json_encode(array(
				"error"=>0,
				"mensaje"=>"",
				"id"=>$vendedor->id,
        "empresa"=>$empresa->nombre,
        "id_empresa"=>$vendedor->id_empresa,
        "dispositivo"=>$vendedor->dispositivo,
        
        // PROVISORIO PARA PROBAR
        // Le da permisos de borrar la base de datos en la app
        "admin"=>1, 
        
        // Perfil del vendedor en la aplicacion
        // 0 = Vendedor
        // 1 = Solo repartidor
        // 2 = Ambos
        "perfil_app"=>$vendedor->perfil_app,  

        // Lista por defecto utilizada por el vendedor
        // 0 = Ninguna
        // 1..6 Opciones
        "lista_defecto"=>$vendedor->lista_defecto,

        // Indica si la empresa controla stock o no
        // TODO: Hacerlo dinamico despues
        "usa_stock"=>(($vendedor->id_empresa == 853)?1:0),
			));
		}
	}


	/**
	 * Cerramos la session del usuario y redireccionamos al inicio
	 */
	function logout() {
		$_SESSION = array();  
		@session_destroy();
    $base = $this->config->item("base_url");
    $base = str_replace("index.php/", "", $base);
		redirect($base);
	}

  function logout_ajax() {
    $_SESSION = array();  
    @session_destroy();    
    $tiempo = time()-3600;
    setcookie("id_cliente_1","",$tiempo,"/");
    setcookie("nombre_1","",$tiempo,"/");
    setcookie("codigo_postal_1","",$tiempo,"/");
    setcookie("direccion_1","",$tiempo,"/");
    setcookie("latitud","",$tiempo,"/");
    setcookie("longitud","",$tiempo,"/");
    setcookie("telefono_1","",$tiempo,"/");
    setcookie("celular_1","",$tiempo,"/");
    setcookie("cliente_lista_1","",$tiempo,"/");
    setcookie("cliente_descuento_1","",$tiempo,"/");
    setcookie("activo","",$tiempo,"/");
    setcookie("email_1","",$tiempo,"/");
    echo json_encode(array("error"=>0));
  }

}
