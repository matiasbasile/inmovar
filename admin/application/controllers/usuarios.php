<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Usuarios extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Usuario_Model', 'modelo');
  }

  function recuperar_pass() {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json; charset=UTF-8');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $email = parent::get_post("email","");
    $id_empresa = parent::get_post("id_empresa",0);
    $lang = parent::get_post("lang","es");
    if (empty($email)) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"ERROR: no se envio un email.",
      ));
      exit();
    }
    $usuario = $this->modelo->get_by_email($email,array(
      "id_empresa"=>$id_empresa
    ));
    if ($usuario === FALSE) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"No se encontro un usuario con ese email.",
      ));
      exit();
    }

    // Si no existe una empresa definida, tenemos que tomar VARCREATIVE
    if (empty($id_empresa)) $id_empresa = 936;

    $this->load->model("Empresa_Model");
    $empresa = $this->Empresa_Model->get($id_empresa);
    $this->load->model("Email_Template_Model");
    $template = $this->Email_Template_Model->get_by_key("recuperar-clave",$id_empresa);
    
    // Generamos un nuevo password aleatorio
    $password = rand(0,10000);
    $bcc_array = array("basile.matias99@gmail.com");
    require APPPATH.'libraries/Mandrill/Mandrill.php';
    $body = $template->texto;
    $body = str_replace("{{nombre}}", $usuario->nombre, $body);
    $body = str_replace("{{email}}", $email, $body);
    $body = str_replace("{{password}}", $password, $body);
    mandrill_send(array(
      "to"=>$email,
      "from"=>"no-reply@varcreative.com",
      "from_name"=>$empresa->nombre,
      "subject"=>$template->nombre,
      "body"=>$body,
      "bcc"=>$bcc_array,
    ));

    $password_md5 = md5($password);
    $sql = "UPDATE com_usuarios SET password = '$password_md5' WHERE id = $usuario->id ";
    $sql.= "AND id_empresa = $usuario->id_empresa ";
    $this->db->query($sql);

    if ($lang == "en") $men = "We have sent an email to restore your password.";
    else $men = "Hemos enviado un email para restaurar la clave a su correo electronico.";
    echo json_encode(array(
      "error"=>0,
      "mensaje"=>$men,
    ));       
  }  

  // Utilizado en PsicoWeb
  function activar_usuario() {
    $id_empresa = parent::get_empresa();
    $id_usuario = parent::get_post("id",0);
    $activo = parent::get_post("activo",1);

    // Guardamos en la base de datos que el usuario esta activo
    $sql = "UPDATE com_usuarios SET activo = '$activo' ";
    $sql.= "WHERE id_empresa = $id_empresa ";
    $sql.= "AND id = '$id_usuario' ";
    $q = $this->db->query($sql);    

    // Si tenemos configurado un email, lo mandamos
    $this->load->model("Email_Template_Model");
    $template = $this->Email_Template_Model->get_by_key("email-activacion",$id_empresa);
    if ($template !== FALSE && $activo == 1) {

      $usuario = $this->modelo->get($id_usuario);
      $this->load->model("Empresa_Model");
      $empresa = $this->Empresa_Model->get($id_empresa);

      $bcc_array = array("basile.matias99@gmail.com");
      require APPPATH.'libraries/Mandrill/Mandrill.php';
      $body = $template->texto;
      $body = str_replace("{{nombre}}", $usuario->nombre, $body);
      mandrill_send(array(
        "to"=>$usuario->email,
        "from"=>"no-reply@varcreative.com",
        "from_name"=>$empresa->nombre,
        "subject"=>$template->nombre,
        "body"=>$body,
        "bcc"=>$bcc_array,
      ));
    }
    echo json_encode(array(
      "error"=>0,
    ));
  }

  function duplicar($id) {
    $salida = $this->modelo->duplicar($id);
    echo json_encode($salida);
  }  

  function change_destacado() {
    $id_empresa = parent::get_empresa();
    $id = parent::get_post("id",0);
    $value = parent::get_post("value",0);
    $sql = "UPDATE com_usuarios_extension SET destacado = '$value' ";
    $sql.= "WHERE id_empresa = $id_empresa ";
    $sql.= "AND id_usuario = '$id' ";
    $q = $this->db->query($sql);
    echo json_encode(array(
      "error"=>0,
    ));
  }  

  function upload_images($id_empresa = 0) {
    $id_empresa = (empty($id_empresa)) ? $this->get_empresa() : $id_empresa;
    return parent::upload_images(array(
      "id_empresa"=>$id_empresa,
      "clave_width"=>"usuario_galeria_image_width",
      "clave_height"=>"usuario_galeria_image_height",
      "upload_dir"=>"uploads/$id_empresa/entradas/",
    ));
  }  

  // Pasa el campo id_sucursal de la tabla usuarios a un registro de la tabla com_usuarios_sucursales
  function update_usuarios_sucursales() {
    $sql = "SELECT * FROM com_usuarios WHERE id_sucursal != 0 ";
    $q = $this->db->query($sql);
    foreach($q->result() as $usuario) {
      $sql = "SELECT * FROM com_usuarios_sucursales WHERE id_empresa = $usuario->id_empresa AND id_sucursal = $usuario->id_sucursal AND id_usuario = $usuario->id ";
      $qq = $this->db->query($sql);
      if ($qq->num_rows()<=0) {
        $sql = "INSERT INTO com_usuarios_sucursales (id_empresa, id_usuario, id_sucursal) VALUES ($usuario->id_empresa, $usuario->id, $usuario->id_sucursal) ";
        $this->db->query($sql);        
      }
    }
    echo "TERMINO";
  }

  function cambiar_sucursal() {
    $id_sucursal = (int) parent::get_post("id_sucursal",0);
    $id_usuario = (isset($_SESSION["id"]) ? $_SESSION["id"] : 0);
    $id_empresa = parent::get_empresa();
    // Comprobamos que la sucursal que esta queriendo cambiar es permitida
    $sql = "SELECT * FROM com_usuarios_sucursales WHERE id_empresa = $id_empresa AND id_usuario = $id_usuario AND id_sucursal = $id_sucursal ";
    $q = $this->db->query($sql);
    if ($q->num_rows()>0) {
      // Actualizamos el ID de la empresa del usuario
      $this->db->query("UPDATE com_usuarios SET id_sucursal = $id_sucursal WHERE id_empresa = $id_empresa AND id = $id_usuario ");
      echo json_encode(array(
        "error"=>0,
      ));
    } else {
      parent::send_error("No tiene permisos para cambiar a la sucursal con ID $id_sucursal.");
    }
  }

  function export($id_empresa = 0, $id_sucursal = 0, $last_update = 0) {
    if ($id_empresa == 0) { echo gzdeflate("0"); exit(); }
    $sql = "SELECT A.* ";
    $sql.= "FROM com_usuarios A ";
    $sql.= "WHERE A.id_empresa = $id_empresa ";
    if ($id_sucursal != 0) $sql.= "AND A.id_sucursal = $id_sucursal ";
    if ($last_update > 0) $sql.= "AND A.last_update >= $last_update ";

    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) { echo gzdeflate("0"); exit(); }

    $this->load->helper("import_helper");
    $salida = create_string_to_export($q);
    
    // Enviamos la cadena comprimida para ahorrar ancho de banda
    echo gzdeflate($salida);
  }

  function get($id) {

    if ($id == "index") {
      $conf = array();
      $limit = $this->input->get("limit");
      if ($limit !== FALSE) $conf["limit"] = $limit;
      $offset = $this->input->get("offset");
      if ($offset !== FALSE) $conf["offset"] = $offset;
      $filter = $this->input->get("filter");
      if ($filter !== FALSE) $conf["filter"] = $filter;
      $order_by = $this->input->get("order_by");
      $order = $this->input->get("order");
      if ($order_by !== FALSE) $conf["order"] = $order_by." ".$order;
      $admin = $this->input->get("admin");
      if ($admin !== FALSE) $conf["admin"] = $admin;
      $conf["id_empresa"] = $this->get_empresa();

      $conf["id_sucursal"] = parent::get_get("id_sucursal",0);
      $conf["id_perfil"] = parent::get_get("id_perfil",0);

      $lista = $this->modelo->buscar($conf);
      $total = $this->modelo->get_total_results();
      $salida = array(
        "total"=> $total,
        "results"=>$lista
      );
      echo json_encode($salida);
    }  else {
      // Estamos obteniendo un elemento en particular
      echo json_encode($this->modelo->get($id));
    }
  }    
    
  function save_file() {
    $this->load->helper("file_helper");
    $id_empresa = $this->get_empresa();
    if (!isset($_FILES['path']) || empty($_FILES['path'])) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"No se ha enviado ningun archivo."
      ));
      return;
    }
    $filename = filename($_FILES["path"]["name"],"-");
    $path = "uploads/$id_empresa/$filename";
    @move_uploaded_file($_FILES["path"]["tmp_name"],$path);
    echo json_encode(array(
      "path"=>$path,
      "error"=>0,
    ));
  }
    
  function save_image($dir="",$filename="") {
		$id_empresa = $this->get_empresa();
		$dir = "uploads/$id_empresa/";
		$filename = $this->input->post("file");
		echo parent::save_image($dir,$filename);
  }    
    
}