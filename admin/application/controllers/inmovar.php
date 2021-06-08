<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inmovar extends CI_Controller {

  function __construct() {
    parent::__construct();
  }

/*
// INSTALACION
<script type="text/javascript" src="https://app.inmovar.com/admin/resources/js/loader.js"></script>
<script type="text/javascript">loadScript("https://app.inmovar.com/admin/inmovar/get/"+window.location.hostname+"/");</script>
*/

  function get($id_empresa = 0) {
    @session_start();
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    header('Access-Control-Allow-Origin: *');

    $this->load->model("Empresa_Model");
    $empresa = $this->Empresa_Model->get_by_md5_id($id_empresa);
    if (empty($empresa)) {
      exit();
    }
    $id_empresa = $empresa->id_empresa;
    $conf = array();

    $useragent=$_SERVER['HTTP_USER_AGENT'];
    $conf["movil"] = (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) ? 1 : 0;
    $conf["abierto"] = (isset($empresa->config["clienapp_abierto"]) ? $empresa->config["clienapp_abierto"] : 1);
    $conf["posicion"] = (isset($empresa->config["clienapp_posicion"]) ? $empresa->config["clienapp_posicion"] : "D");
    $conf["empresa"] = $empresa;

    // Tipos de Inmueble
    $q = $this->db->query("SELECT id,nombre,link FROM inm_tipos_inmueble ORDER BY orden ASC");
    $conf["tipos_inmueble"] = $q->result();

    // Localidades
    $this->load->model('Localidad_Model');
    $conf["localidades"] = $this->Localidad_Model->utilizadas(array(
      "id_empresa"=>$id_empresa,
      "id_proyecto"=>3,
    ));

    $tpl_base = $this->load->view("buscador/chat_base",null,true);
    $this->load->view("buscador/chat",array(
      "id_empresa"=>$id_empresa,
      "config"=>$conf,
      "tpl_base"=>$tpl_base,
    ));
  }

  private function get_post($clave,$default = "") {
    $value = $this->input->post($clave);
    if ($value === FALSE) return $default;
    else return ($value);
  }  

  function registrar() {
    @session_start();
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    header('Access-Control-Allow-Origin: *');

    $this->load->model("Cliente_Model");
    $this->load->model("Consulta_Model");

    $id_empresa = $this->get_post("id_empresa",0);
    $nombre = $this->get_post("nombre",0);
    $telefono = $this->get_post("telefono",0);
    $prefijo = $this->get_post("prefijo",0);
    $id_localidad = $this->get_post("id_localidad",0);
    $id_tipo_operacion = $this->get_post("id_tipo_operacion",0);
    $id_tipo_inmueble = $this->get_post("id_tipo_inmueble",0);
    $email = $this->get_post("email",0);

    $contacto = (!empty($email)) ? $this->Cliente_Model->get_by_email($email,$id_empresa) : FALSE;

    if ($contacto === FALSE) {
      // Debemos crearlo
      $contacto = new stdClass();
      $contacto->id_empresa = $id_empresa;
      $contacto->email = $email;
      $contacto->nombre = $nombre;
      $contacto->telefono = $telefono;
      $contacto->fax = $prefijo;
      $contacto->fecha_inicial = date("Y-m-d");
      $contacto->fecha_ult_operacion = date("Y-m-d H:i:s");
      // Por defecto le ponemos contreña 1 a los que consultan para no tener problemas al momento de comprar
      $contacto->password = "c4ca4238a0b923820dcc509a6f75849b";
      $contacto->tipo = 1; // 1 = Contacto
      $contacto->activo = 1; // El cliente esta activo por defecto
      $contacto->id_sucursal = 0; // Para que en algunas BD no tire error de default value
      $contacto->custom_3 = 1; // Que es un contacto
      $id = $this->Cliente_Model->insert($contacto);
      $contacto->id = $id;

      // REGISTRAMOS COMO UN EVENTO LA CREACION DEL NUEVO USUARIO
      $this->Consulta_Model->registro_creacion_usuario(array(
        "id_contacto"=>$id,
        "id_empresa"=>$id_empresa,
      ));
    } else {
      // Si hay algun dato distinto, debemos actualizarlo
      $updates = array();
      if (!empty($nombre) && $nombre != $contacto->nombre) $updates[] = array("key"=>"nombre","value"=>$nombre);
      if (!empty($telefono) && $telefono != $contacto->telefono) $updates[] = array("key"=>"telefono","value"=>$telefono);
      if (!empty($prefijo) && $prefijo != $contacto->fax) $updates[] = array("key"=>"fax","value"=>$prefijo);
      if (sizeof($updates)>0) {
        $sql = "UPDATE clientes SET ";
        for ($it=0; $it < sizeof($updates); $it++) { 
          $up = $updates[$it];
          $sql.= $up["key"]." = '".$up["value"]."' ".(($it<sizeof($updates)-1)?",":"");
        }
        $sql.= "WHERE id = $contacto->id AND id_empresa = $id_empresa ";
        $this->db->query($sql);
      }
    }

    $texto = "Interés: ";

    $this->load->model("Tipo_Inmueble_Model");
    $tipo_inmueble = $this->Tipo_Inmueble_Model->get($id_tipo_inmueble);
    $texto.= $tipo_inmueble->nombre;

    if ($id_tipo_operacion == 2) $texto.= " en Alquiler";
    else $texto.= " en Venta";

    if (!empty($id_localidad)) {
      $this->load->model("Localidad_Model");
      $localidad = $this->Localidad_Model->get($id_localidad);
      if (!empty($localidad)) {
        $texto.= " en $localidad->nombre";
      }
    }

    $fecha = date("Y-m-d H:i:s");
    $consulta = new stdClass();
    $consulta->id_empresa = $id_empresa;
    $consulta->id_empresa_relacion = $id_empresa;
    $consulta->id_entrada = 0;
    $consulta->fecha = $fecha;
    $consulta->hora = date("H:i:s");
    $consulta->asunto = "Búsqueda por Formulario";
    $consulta->subtitulo = "";
    $consulta->texto = $texto;
    $consulta->id_contacto = $contacto->id;
    $consulta->id_origen = 50; // Origen que indica el interes
    $consulta->id_usuario = 0; // No es de ningun usuario
    $consulta->id_referencia = 0; // No es de ninguna propiedad
    $this->Consulta_Model->insert($consulta);

    // Actualizamos el contacto con la ultima fecha de operacion
    $sql = "UPDATE clientes SET ";
    $sql.= "fecha_ult_operacion = '$fecha', ";
    $sql.= "tipo = 1, "; // Vuelve a contactar
    $sql.= "no_leido = 1 ";
    $sql.= "WHERE id = $contacto->id AND id_empresa = $id_empresa ";
    $this->db->query($sql);    

    // Guardamos el tipo de busqueda dependiendo de los valores de la propiedad que consulto
    $sql = "INSERT INTO inm_busquedas_contactos (id_empresa,id_cliente,id_localidad,id_tipo_operacion,id_tipo_inmueble,fecha) VALUES(";
    $sql.= " '$id_empresa','$contacto->id','$id_localidad','$id_tipo_operacion','$id_tipo_inmueble',NOW() )";
    $this->db->query($sql);

    echo json_encode(array(
      "error"=>0,
    ));

  }
}