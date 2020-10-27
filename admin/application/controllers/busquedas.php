<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';

class Busquedas extends REST_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Busqueda_Model', 'modelo');
  }

  function upload_images($id_empresa = 0) {
    $id_empresa = (empty($id_empresa)) ? $this->get_empresa() : $id_empresa;
    return parent::upload_images(array(
      "id_empresa"=>$id_empresa,
      "clave_width"=>"busqueda_galeria_image_width",
      "clave_height"=>"busqueda_galeria_image_height",
      "upload_dir"=>"uploads/$id_empresa/propiedades/",
    ));
  }

  function save_file() {
    $this->load->helper("file_helper");
    $this->load->helper("imagen_helper");
    $id_empresa = $this->get_empresa();
    if (!isset($_FILES['path']) || empty($_FILES['path'])) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"No se ha enviado ningun archivo."
      ));
      return;
    }
    // Primero copiamos el archivo
    $filename = filename($_FILES["path"]["name"],"-");
    $path = "uploads/$id_empresa/propiedades/";
    $filename = rename_if_exists($path,$filename);
    @move_uploaded_file($_FILES["path"]["tmp_name"],$path.$filename);
    // Si es una imagen, lo redimensionamos
    if (is_image($filename)) {
      resize(array(
        "dir"=>$path,
        "filename"=>$filename,
      ));
    }
    echo json_encode(array(
      "path"=>$path.$filename,
      "error"=>0,
    ));
  }   

  function save_image($dir="",$filename="") {
    $id_empresa = $this->get_empresa();
    $dir = "uploads/$id_empresa/propiedades/";
    $filename = $this->input->post("file");
    $res = parent::save_image($dir,$filename);

    if ($this->input->post("thumbnail_width") !== FALSE) {
      $resp = json_decode($res);
      $filename = str_replace($dir, "", $resp->path);
      $thumbnail_width = $this->input->post("thumbnail_width");
      $thumbnail_height = $this->input->post("thumbnail_height");
      if ($thumbnail_width != 0 && $thumbnail_height != 0) {
        parent::thumbnails(array(
          "dir"=>$dir,
          "preffix"=>"thumb_",
          "filename"=>$filename,
          "thumbnail_width"=>$thumbnail_width,
          "thumbnail_height"=>$thumbnail_height,                
          "tipo_redimension"=>2,
        ));                
      }
    }        
    echo $res;
  }
    
  function duplicar($id) {
      
    $this->load->helper("fecha_helper");
    $this->load->helper("file_helper");

    $id_empresa = parent::get_empresa();

    $busqueda = $this->modelo->get($id);
    if ($busqueda === FALSE) {
      echo json_encode(array(
        "error"=>1,
        "mensaje"=>"No se encuentra la busqueda con ID: $id",
      ));
      return;
    }
    $busqueda->id = 0;
    $insert_id = $this->modelo->insert($busqueda);
    
    // Actualizamos las relaciones
    echo json_encode(array(
      "id"=>$insert_id
    ));
  }
    
  /**
   *  Obtenemos los datos de un busqueda en particular
   */
  function get($id) {
    $id_empresa = parent::get_empresa();
    // Obtenemos el listado
    if ($id == "index") {
      $sql = "SELECT A.*, ";
      $sql.= "IF(A.fecha_publicacion='0000-00-00','',DATE_FORMAT(A.fecha_publicacion,'%d/%m/%Y')) AS fecha_publicacion, ";
      $sql.= "IF(P.nombre IS NULL,'',P.nombre) AS propietario, ";
      $sql.= "IF(TE.nombre IS NULL,'',TE.nombre) AS tipo_estado, ";
      $sql.= "IF(TI.nombre IS NULL,'',TI.nombre) AS tipo_inmueble, ";
      $sql.= "IF(X.nombre IS NULL,'',X.nombre) AS tipo_operacion, ";
      $sql.= "IF(L.nombre IS NULL,'',L.nombre) AS localidad ";
      $sql.= "FROM inm_busquedas A ";
      $sql.= "LEFT JOIN inm_tipos_estado TE ON (A.id_tipo_estado = TE.id) ";
      $sql.= "LEFT JOIN inm_tipos_inmueble TI ON (A.id_tipo_inmueble = TI.id) ";
      $sql.= "LEFT JOIN inm_tipos_operacion X ON (A.id_tipo_operacion = X.id) ";
      $sql.= "LEFT JOIN clientes P ON (A.id_propietario = P.id AND A.id_empresa = P.id_empresa) ";
      $sql.= "LEFT JOIN com_localidades L ON (A.id_localidad = L.id) ";
      $sql.= "WHERE A.activo = 1 AND A.id_empresa = '$id_empresa' ";
      $sql.= "ORDER BY A.nombre ASC ";
      $q = $this->db->query($sql);
      $result = $q->result();
      echo json_encode(array(
        "results"=>$result,
        "total"=>sizeof($result)
      ));
    } else {
      $busqueda = $this->modelo->get($id);
      echo json_encode($busqueda);
    }
  }

  function ver_busqueda($id,$id_empresa) {
    $busqueda = $this->modelo->get($id,array(
      "id_empresa"=>$id_empresa
    ));
    echo json_encode($busqueda);    
  }
    
    
  /**
   *  Muestra todos los busquedas filtrando segun distintos parametros
   *  El resultado esta paginado
   */
  function ver() {
      
    $limit = $this->input->get("limit");
    $id_tipo_operacion = str_replace("-",",",parent::get_get("id_tipo_operacion",""));
    $id_tipo_estado = str_replace("-",",",parent::get_get("id_tipo_estado",""));
    $id_tipo_inmueble = str_replace("-",",",parent::get_get("id_tipo_inmueble",""));
    $buscar_red = parent::get_get("buscar_red",0);
    $buscar_red_empresa = parent::get_get("buscar_red_empresa",0);
    $id_propietario = parent::get_get("id_propietario",0);
    $filter = $this->input->get("filter");
    $offset = $this->input->get("offset");
    $order_by = $this->input->get("order_by");
    $order = $this->input->get("order");
    $id_categoria = $this->input->get("id_categoria");
    $monto = ($this->input->get("monto") !== FALSE) ? $this->input->get("monto") : "";
    $monto_2 = ($this->input->get("monto_2") !== FALSE) ? $this->input->get("monto_2") : "";
    $monto_tipo = ($this->input->get("monto_tipo") !== FALSE) ? $this->input->get("monto_tipo") : "igual";
    $monto_moneda = ($this->input->get("monto_moneda") !== FALSE) ? $this->input->get("monto_moneda") : "$";
    $id_usuario = ($this->input->get("id_usuario") !== FALSE) ? $this->input->get("id_usuario") : 0;
    $id_localidad = str_replace("-",",",parent::get_get("id_localidad",""));
    $apto_banco = ($this->input->get("apto_banco") !== FALSE) ? $this->input->get("apto_banco") : 0;
    $acepta_permuta = ($this->input->get("acepta_permuta") !== FALSE) ? $this->input->get("acepta_permuta") : 0;
    $filtro_meli = ($this->input->get("filtro_meli") !== FALSE) ? $this->input->get("filtro_meli") : -1;
    $filtro_olx = ($this->input->get("filtro_olx") !== FALSE) ? $this->input->get("filtro_olx") : -1;
    $filtro_inmovar = ($this->input->get("filtro_inmovar") !== FALSE) ? $this->input->get("filtro_inmovar") : -1;
    $filtro_inmobusquedas = ($this->input->get("filtro_inmobusquedas") !== FALSE) ? $this->input->get("filtro_inmobusquedas") : -1;
    $filtro_argenprop = ($this->input->get("filtro_argenprop") !== FALSE) ? $this->input->get("filtro_argenprop") : -1;
    $activo = parent::get_get("activo",-1);
    $dormitorios = ($this->input->get("dormitorios") !== FALSE) ? $this->input->get("dormitorios") : "";
    $banios = ($this->input->get("banios") !== FALSE) ? $this->input->get("banios") : "";
    $calle = ($this->input->get("calle") !== FALSE) ? $this->input->get("calle") : "";
    $id_empresa = ($this->input->get("id_empresa") !== FALSE) ? $this->input->get("id_empresa") : parent::get_empresa();
    if (!empty($order_by) && !empty($order)) $order = $order_by." ".$order;
    else $order = "";

    if (!is_numeric($monto)) $monto = "";
    if (!is_numeric($monto_2)) $monto_2 = "";

    // Si term esta definido, es porque estamos buscando de la barra
    $term = $this->input->get("term");
    if ($term !== FALSE) $filter = $term;
    $filter = trim($filter);
      
    $conf = array(
      "buscar_red"=>$buscar_red,
      "buscar_red_empresa"=>$buscar_red_empresa,
      "limit"=>$limit,
      "offset"=>$offset,
      "filter"=>$filter,
      "order"=>$order,
      "id_empresa"=>$id_empresa,
      "id_tipo_operacion"=>$id_tipo_operacion,
      "id_tipo_estado"=>$id_tipo_estado,
      "id_tipo_inmueble"=>$id_tipo_inmueble,
      "id_localidad"=>$id_localidad,
      "dormitorios"=>$dormitorios,
      "banios"=>$banios,
      "filtro_meli"=>$filtro_meli,
      "filtro_olx"=>$filtro_olx,
      "filtro_inmovar"=>$filtro_inmovar,
      "filtro_inmobusquedas"=>$filtro_inmobusquedas,
      "filtro_argenprop"=>$filtro_argenprop,
      "activo"=>$activo,
      "monto"=>$monto,
      "monto_2"=>$monto_2,
      "monto_moneda"=>$monto_moneda,
      "apto_banco"=>$apto_banco,
      "acepta_permuta"=>$acepta_permuta,
      "calle"=>$calle,
      "id_usuario"=>$id_usuario,
      "id_propietario"=>$id_propietario,
    );
    $r = $this->modelo->buscar($conf);

    // Dependiendo desde donde se hace la busqueda, devolvemos uno u otro formato
    if ($term === FALSE) {
      echo json_encode($r);
    } else {
      $salida = array();
      foreach($r["results"] as $row) {
        $rr = array();
        $rr["id"] = $row->id;
        $rr["value"] = $row->id;
        $rr["label"] = $row->nombre;
        $rr["info"] = $row->calle." ".$row->altura." - ".$row->localidad;
        $rr["path"] = $row->path;
        $salida[] = $rr;
      }
      echo json_encode($salida);
    }
  }

  private function limpiar_campo($str) {
    $str = str_replace("&", "", $str);
    $str = str_replace("´", "", $str);
    $str = strip_tags($str);
    $str = html_entity_decode($str,ENT_QUOTES);
    $str = str_replace("\n", " ", $str);
    $str = str_replace("\"", "", $str);
    $str = str_replace("'", "", $str);
    $str = str_replace(";", "", $str);
    $str = trim($str);
    //$str = utf8_encode($str);
    return $str;
  }

}