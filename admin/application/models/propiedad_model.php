<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Propiedad_Model extends Abstract_Model {
  
  function __construct() {

    parent::__construct("inm_propiedades","id");
  }

  function desactivar_vencidas() {
    //En vez de llamar a la funcion buscar, que tiene muchos parametros
    //Y no siemrpe me va a traer los correctos
    //Yo simplemente hago un sql de toda la base de datos
    $hoy = date("Y-m-d");
    $sql = "UPDATE inm_propiedades ";
    $sql.= "SET ";
    $sql.= "activo = 0 ";
    $sql.= "WHERE ";
    $sql.= "(fecha_vencimiento <= '$hoy' AND fecha_vencimiento != '0000-00-00') ";
    $sql.= "AND activo = 1 ";
    $this->db->query($sql);
  }

  function obtener_propiedades_similares($config = array()) {
    $salida = array();
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $id_propiedad = isset($config["id_propiedad"]) ? $config["id_propiedad"] : 0;
    $id_localidad = isset($config["id_localidad"]) ? $config["id_localidad"] : 0;
    $id_tipo_inmueble = isset($config["id_tipo_inmueble"]) ? $config["id_tipo_inmueble"] : 0;
    $id_tipo_operacion = isset($config["id_tipo_operacion"]) ? $config["id_tipo_operacion"] : 0;
    $limit = isset($config["limit"]) ? $config["limit"] : 0;
    $offset = isset($config["offset"]) ? $config["offset"] : 5;
    $calle = isset($config["calle"]) ? $config["calle"] : "";
    $calle = mb_strtolower($calle);
    $altura = isset($config["altura"]) ? $config["altura"] : "";
    $altura = mb_strtolower($altura);
    $piso = isset($config["piso"]) ? $config["piso"] : "";
    $piso = mb_strtolower($piso);
    $numero = isset($config["numero"]) ? $config["numero"] : "";
    $numero = mb_strtolower($numero);

    // Buscamos propiedades que sean iguales en la red
    $sql = "SELECT P.*, ";
    $sql.= "IF(U.nombre IS NULL,'',U.nombre) AS usuario, ";
    if (!empty($id_localidad)) $sql.= "IF(L.nombre IS NULL,'',L.nombre) AS localidad, ";
    $sql.= "E.nombre AS empresa, E.path AS empresa_path, E.telefono_empresa AS empresa_telefono, E.direccion_empresa AS empresa_direccion, E.email AS empresa_email, ";
    $sql.= "E.codigo AS codigo_inmobiliaria, CONCAT(E.codigo,'-',P.codigo) AS codigo_completo, ";
    $sql.= "E.incluye_comision_35, ";
    $sql.= "IF(X.nombre IS NULL,'',X.nombre) AS tipo_operacion, ";
    $sql.= "IF(TI.nombre IS NULL,'',TI.nombre) AS tipo_inmueble ";
    $sql.= "FROM inm_propiedades P ";
    if (!empty($id_localidad)) $sql.= "LEFT JOIN com_localidades L ON (P.id_localidad = L.id) ";
    $sql.= "LEFT JOIN com_usuarios U ON (P.id_usuario = U.id AND P.id_empresa = U.id_empresa) ";
    $sql.= "LEFT JOIN inm_tipos_inmueble TI ON (P.id_tipo_inmueble = TI.id) ";
    $sql.= "LEFT JOIN inm_tipos_operacion X ON (P.id_tipo_operacion = X.id) ";
    $sql.= "INNER JOIN empresas E ON (P.id_empresa = E.id) ";
    $sql.= "WHERE P.id_empresa != $id_empresa ";
    $sql.= "AND P.id != $id_propiedad ";
    $sql.= "AND P.id_tipo_inmueble = $id_tipo_inmueble ";
    if (!empty($id_localidad)) $sql.= "AND P.id_localidad = $id_localidad ";
    if (!empty($id_tipo_operacion)) $sql.= "AND P.id_tipo_operacion = $id_tipo_operacion ";
    if (!empty($calle)) $sql.= "AND LOWER(calle) = '$calle' ";
    if (!empty($altura)) $sql.= "AND LOWER(altura) = '$altura' ";
    if (!empty($piso)) $sql.= "AND LOWER(piso) = '$piso' ";
    if (!empty($numero)) $sql.= "AND LOWER(numero) = '$numero' ";
    $sql.= "AND P.compartida >= 1 "; // Tiene que estar compartida en la RED
    $sql.= "LIMIT $limit,$offset ";
    $q = $this->db->query($sql);

    foreach ($q->result() as $p) {
      $p->direccion_completa = $p->calle.(!empty($p->entre_calles) ? " e/ ".$p->entre_calles.(!empty($p->entre_calles_2) ? " y ".$p->entre_calles_2 : "") : "");
      $p->direccion_completa.= (($p->publica_altura == 1)?" N° ".$p->altura:"") . (!empty($p->piso) ? " Piso ".$p->piso : "") . (!empty($p->numero) ? " Depto. ".$p->numero : "");
      $salida[] = $p;
    }

    return $salida;
  }  

  function get_precios_propiedades($conf = array()) {
    $res = new Stdclass;
    $un_año_antes = new DateTime('1 year ago');
    $id_empresa = isset($conf['id_empresa']) ? $conf['id_empresa'] : parent::get_empresa();
    $id_propiedad = isset($conf['id_propiedad']) ? $conf['id_propiedad'] : 0;
    $fecha_desde = isset($conf['fecha_desde']) ? $conf['fecha_desde'] : $un_año_antes->format('Y-m-d');
    $fecha_hasta = isset($conf['fecha_hasta']) ? $conf['fecha_hasta'] : date('Y-m-d');
    $intervalo = "D";
    $desde = new DateTime($fecha_desde);
    $hasta = new DateTime($fecha_hasta);
    $hasta->add(new DateInterval('P1D'));
    $interval = new DateInterval('P1'.$intervalo);
    $range = new DatePeriod($desde,$interval,$hasta);
    $diff = $hasta->diff($desde)->format("%a"); 
    $res->precios = array();
    $sql = "SELECT PV.* FROM inm_propiedades_precios_historicos PV ";
    $sql.= "WHERE PV.id_empresa = '$id_empresa' ";
    $sql.= "AND PV.id_propiedad = '$id_propiedad' ";
    $sql.= "AND PV.precio_anterior = 0.00 ";
    $q = $this->db->query($sql);
    //Nos fijamos el precio de cuando se creo la propiedad para ponerlo siempre primero
    if ($q->num_rows() > 0 ){
      $row = $q->row();
      $precio_anterior = intval($row->precio_nuevo);
    } else {
      //Sino usamos null asi se lo saltea el grafico
      $precio_anterior = null;
    }
    foreach($range as $fecha) {

      // Sacamos las visitas web
      $sql = "SELECT PV.* FROM inm_propiedades_precios_historicos PV ";
      $sql.= "WHERE PV.id_empresa = '$id_empresa' ";
      $sql.= "AND PV.id_propiedad = '$id_propiedad' ";
      $sql.= "AND fecha = '".$fecha->format("Y-m-d")."' LIMIT 0,1 ";
      $q = $this->db->query($sql);
      if ($q->num_rows() > 0) {
        $r = $q->row();
        $res->precios[] = intval($r->precio_nuevo);
        $precio_anterior = intval($r->precio_nuevo);
      } else {
        $res->precios[] = $precio_anterior;        
      } 
    }

    return $res;
  }

  function buscar_similitudes($config = array()) {
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $id_propiedad = isset($config["id_propiedad"]) ? $config["id_propiedad"] : 0;
    $id_localidad = isset($config["id_localidad"]) ? $config["id_localidad"] : 0;
    $id_tipo_inmueble = isset($config["id_tipo_inmueble"]) ? $config["id_tipo_inmueble"] : 0;
    $calle = isset($config["calle"]) ? $config["calle"] : "";
    $calle = mb_strtolower($calle);
    $altura = isset($config["altura"]) ? $config["altura"] : "";
    $altura = mb_strtolower($altura);
    $piso = isset($config["piso"]) ? $config["piso"] : "";
    $piso = mb_strtolower($piso);
    $numero = isset($config["numero"]) ? $config["numero"] : "";
    $numero = mb_strtolower($numero);

    $this->load->model("Empresa_Model");
    $empresa = $this->Empresa_Model->get($id_empresa);

    // Buscamos propiedades que sean iguales en la red
    $sql = "SELECT * FROM inm_propiedades ";
    $sql.= "WHERE id_empresa != $id_empresa ";
    $sql.= "AND id != $id_propiedad ";
    $sql.= "AND id_tipo_inmueble = $id_tipo_inmueble ";
    $sql.= "AND LOWER(calle) = '$calle' ";
    $sql.= "AND LOWER(altura) = '$altura' ";
    $sql.= "AND LOWER(piso) = '$piso' ";
    $sql.= "AND LOWER(numero) = '$numero' ";
    $sql.= "AND compartida >= 1 "; // Tiene que estar compartida en la RED
    $q = $this->db->query($sql);
    $this->load->model("Notificacion_Model");
    foreach($q->result() as $r) {
      // Si encontramos resultados, tenemos que alertar
      // (en caso de que no hayamos alertado anteriormente)
      $sql = "SELECT 1 FROM com_log WHERE id_empresa = $r->id_empresa AND link = $r->id AND importancia = 'W' AND id_referencia = $id_propiedad ";
      $qq = $this->db->query($sql);
      if ($qq->num_rows() == 0) {
        $this->Notificacion_Model->insertar(array(
          "id_empresa"=>$r->id_empresa,
          "importancia"=>"W",
          "titulo"=>"Alerta de Similitud",
          "texto"=>"Una de sus propiedades tiene problema de similitud con otra propiedad subida por $empresa->nombre",
          "link"=>$r->id,
          "id_referencia"=>$id_propiedad,
        ));
      }

      // Y tambien tenemos que alertar a la propia inmobiliaria
      $sql = "SELECT 1 FROM com_log WHERE id_empresa = $id_empresa AND link = $id_propiedad AND importancia = 'W' ";
      $qq = $this->db->query($sql);
      if ($qq->num_rows() == 0) {
        $this->Notificacion_Model->insertar(array(
          "id_empresa"=>$id_empresa,
          "importancia"=>"W",
          "titulo"=>"Alerta de Similitud",
          "texto"=>"Una de sus propiedades tiene problema de similitud con otras en la red",
          "link"=>$id_propiedad,
        ));
      }
    }
  }
  
  // Controla si la empresa puede seguir creando propiedades o no
  function controlar_plan($id_empresa) {
    $sql = "SELECT * FROM empresas WHERE id = $id_empresa ";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) {
      return array(
        "error"=>1,
        "mensaje"=>"La empresa con ID $id_empresa no existe",
      );
    }
    $empresa = $q->row();
    if ($empresa->limite == 0) return TRUE;
    else {
      $sql = "SELECT IF(COUNT(*) IS NULL,0,COUNT(*)) AS cantidad ";
      $sql.= "FROM inm_propiedades ";
      $sql.= "WHERE id_empresa = $id_empresa ";
      $qqq = $this->db->query($sql);
      $rrr = $qqq->row();
      $cantidad = $rrr->cantidad;
      if ($cantidad < $empresa->limite) {
        return TRUE;
      } else {

        // Lanzamos un email pidiendo que actualice el plan
        $this->load->model("Email_Template_Model");
        $temp = $this->Email_Template_Model->get_by_key("cambiar-plan",118);
        $bcc_array = array("basile.matias99@gmail.com","misticastudio@gmail.com");
        $texto = $temp->texto;
        $texto = str_replace("{{nombre}}", $empresa->nombre, $texto);
        require_once APPPATH.'libraries/Mandrill/Mandrill.php';
        mandrill_send(array(
          "to"=>$empresa->email,
          "subject"=>$temp->nombre,
          "body"=>$texto,
          "bcc"=>$bcc_array,
        ));

        // Devolvemos el error
        return array(
          "error"=>1,
          "mensaje"=>"Ha llegado al limite de su plan contratado. Por favor comuniquese para actualizar al plan siguiente.",
        );        
      }
    }
  }

  // Devuelve el total de propiedades compartidas en la red completa
  function total_propiedades_red_completa() {
    $sql = "SELECT IF(COUNT(*) IS NULL,0,COUNT(*)) AS cantidad ";
    $sql.= "FROM inm_propiedades A ";
    $sql.= "INNER JOIN empresas E ON (A.id_empresa = E.id) ";
    $sql.= "WHERE A.activo = 1 "; // La propiedad tiene que estar activa
    $sql.= "AND E.activo = 1 ";   // y la empresa tambien
    $sql.= "AND A.id_tipo_estado NOT IN (2,3,4,6) ";
    $sql.= "AND A.compartida >= 1 ";
    $q = $this->db->query($sql);
    $r = $q->row();
    return $r->cantidad;
  }

  function total_propiedades_red_empresa($config = array()) {
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $sql = "SELECT IF(COUNT(*) IS NULL,0,COUNT(*)) AS cantidad ";
    $sql.= "FROM inm_propiedades A ";
    $sql.= "INNER JOIN empresas E ON (A.id_empresa = E.id) ";
    $sql.= "WHERE A.activo = 1 "; // La propiedad tiene que estar activa
    $sql.= "AND E.activo = 1 ";   // y la empresa tambien
    $sql.= "AND A.compartida >= 1 ";
    $sql.= "AND A.id_tipo_estado NOT IN (2,3,4,6) ";
    $sql.= "AND (A.id_empresa IN (";
    $sql.= " SELECT PR.id_empresa FROM inm_permisos_red PR ";
    $sql.= " WHERE PR.id_empresa_compartida = $id_empresa ";
    $sql.= " AND PR.permiso_red = 1 "; // Tiene el permiso habilitado
    $sql.= ") OR A.id_empresa = $id_empresa) ";
    $q = $this->db->query($sql);
    $r = $q->row();
    return $r->cantidad;
  }

  function count_all() {
    if ($this->usa_id_empresa == 1) {
      $id_empresa = $this->get_empresa();
      $this->db->where("id_empresa",$id_empresa);
    }
    $this->db->where("de_prueba","0");
    $this->db->from($this->tabla);
    $r = $this->db->count_all_results();
    $this->db->close();
    return $r;
  }  

  function sincronizar_calendario($config = array()) {
    $icalfile = isset($config["link"]) ? $config["link"] : "";
    $id_propiedad = isset($config["id_propiedad"]) ? $config["id_propiedad"] : 0;
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : 0;
    require_once APPPATH.'libraries/icalendar/zapcallib.php';
    $this->load->model("Propiedad_Reserva_Model");

    $urlbase = $icalfile;
    $urlbase = str_replace("https://", "", $urlbase);
    $urlbase = str_replace("http://", "", $urlbase);
    $b = explode("/", $urlbase);
    $urlbase = $b[0];

    $c = curl_init($icalfile);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $icalfeed = curl_exec($c);
    if (curl_error($c)) die(curl_error($c));
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
    curl_close($c);

    if (empty($icalfeed)) {
      // Intentamos con file_get_contents
      $icalfeed = file_get_contents($icalfile);
    }

    $eventos = array();
    $lineas = explode("\n", $icalfeed);
    $comenzo_evento = false;
    $evento = new stdClass();
    $evento->uid = "";
    $evento->start = "";
    $evento->end = "";
    foreach($lineas as $linea) {
      $linea = trim($linea);
      if (strpos($linea, "BEGIN:VEVENT") !== FALSE) {
        $evento = new stdClass();
        $evento->uid = "";
        $evento->start = "";
        $evento->end = "";        
        $comenzo_evento = true; continue;
      }
      if ($comenzo_evento) {
        // Fin del evento
        if (strpos($linea, "END:VEVENT") !== FALSE) {
          $eventos[] = $evento;
          $comenzo_evento = false; continue;
        }
        // Fecha de Inicio
        if (strpos($linea, "DTSTART;VALUE=DATE:") !== FALSE) {
          $fecha = str_replace("DTSTART;VALUE=DATE:", "", $linea);
          $evento->start = substr($fecha, 0, 4)."-".substr($fecha, 4, 2)."-".substr($fecha, 6, 2);
        }
        // Fecha de Fin
        if (strpos($linea, "DTEND;VALUE=DATE:") !== FALSE) {
          $fecha = str_replace("DTEND;VALUE=DATE:", "", $linea);
          $evento->end = substr($fecha, 0, 4)."-".substr($fecha, 4, 2)."-".substr($fecha, 6, 2);
        }
        // Fecha de Fin
        if (strpos($linea, "SUMMARY:") !== FALSE) {
          $comentario = str_replace("SUMMARY:", "", $linea);
          $evento->comentario = $urlbase.": ".$comentario;
        }        
        // UID
        if (strpos($linea, "UID:") !== FALSE) {
          $evento->uid = str_replace("UID:", "", $linea);
        }
      }
    }

    foreach($eventos as $evento) {
      if (empty($evento->uid) || empty($evento->start) || empty($evento->end)) continue;
      $sql = "SELECT * FROM inm_propiedades_reservas ";
      $sql.= "WHERE id_propiedad = $id_propiedad AND id_empresa = $id_empresa ";
      $sql.= "AND fecha_desde = '$evento->start' AND fecha_hasta = '$evento->end' ";
      //$sql.= "AND uid = '$evento->uid' ";
      $q = $this->db->query($sql);
      if ($q->num_rows() == 0) {
        // Insertamos la nueva reserva
        $sql = "INSERT INTO inm_propiedades_reservas (id_empresa, id_propiedad, fecha_desde, fecha_hasta, id_estado, comentario, uid) VALUES (";
        $sql.= "'$id_empresa', '$id_propiedad', '$evento->start', '$evento->end', 0, '$evento->comentario', '$evento->uid' )";
        $this->db->query($sql);
        $id_reserva = $this->db->insert_id();

        // Recorremos las fechas
        $d = new DateTime($evento->start);
        $h = new DateTime($evento->end);
        $interval = new DateInterval('P1D');
        $range = new DatePeriod($d,$interval,$h);
        foreach($range as $fecha) {
          $f = $fecha->format("Y-m-d");
          $sql = "INSERT INTO inm_propiedades_reservas_disponibilidad (id_empresa,id_propiedad,fecha,disponible,id_reserva) VALUES(";
          $sql.= "'$id_empresa','$id_propiedad','$f','0','$id_reserva')";
          $this->db->query($sql);          
        }

      } else {
        $reserva = $q->row();
        // Actualizamos la reserva
        $sql = "UPDATE inm_propiedades_reservas ";
        $sql.= "SET comentario = '$evento->comentario' ";
        $sql.= "WHERE id_propiedad = $id_propiedad AND id_empresa = $id_empresa ";
        $sql.= "AND fecha_desde = '$evento->start' AND fecha_hasta = '$evento->end' ";
        $this->db->query($sql);
        $id_reserva = $reserva->id;
        // Borramos la disponibilidad para volverla a crear
        $sql = "DELETE FROM inm_propiedades_reservas_disponibilidad WHERE id_empresa = $id_empresa AND id_propiedad = $id_propiedad AND id_reserva = $id_reserva";
        $this->db->query($sql);
      }

      // Recorremos las fechas y cancelamos la disponibilidad
      $d = new DateTime($evento->start);
      $h = new DateTime($evento->end);
      $interval = new DateInterval('P1D');
      $range = new DatePeriod($d,$interval,$h);
      foreach($range as $fecha) {
        $f = $fecha->format("Y-m-d");
        $sql = "INSERT INTO inm_propiedades_reservas_disponibilidad (id_empresa,id_propiedad,fecha,disponible,id_reserva) VALUES(";
        $sql.= "'$id_empresa','$id_propiedad','$f','0','$id_reserva')";
        $this->db->query($sql);          
      }
    }
  }

  function get_propiedad_meli($id,$config=array()) {
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $sql = "SELECT * FROM inm_propiedades_meli ";
    $sql.= "WHERE id_propiedad = $id AND id_empresa = $id_empresa ";
    $q = $this->db->query($sql);
    if ($q->num_rows()>0) {
      $prop_meli = $q->row();
      return $prop_meli;
    } return FALSE;
  }

  function update_meli($art) {
    
    // Si no existe esta opcion, solamente salimos
    if (!isset($art->categoria_meli)) return FALSE;
    if (empty($art->categoria_meli)) return FALSE;

    $this->load->model("Empresa_Model");
    $usa_meli = $this->Empresa_Model->usa_mercadolibre($art->id_empresa);
    if (!$usa_meli) return FALSE;

    $prop_meli = $this->get_propiedad_meli($art->id);
    if ($prop_meli === FALSE) {
      // Debemos insertar el elemento en la otra tabla
      $this->db->insert("inm_propiedades_meli",array(
        "id_propiedad"=>$art->id,
        "id_empresa"=>$art->id_empresa,
        "activo_meli"=>0,
        "titulo_meli"=>$art->titulo_meli,
        "texto_meli"=>$art->texto_meli,
        "categoria_meli"=>$art->categoria_meli,
        "precio_meli"=>$art->precio_meli,
        "ciudad_meli"=>$art->ciudad_meli,
        "list_type_id"=>$art->list_type_id,
      ));
    } else {
      // Debemos actualizar los datos de la otra tabla
      $this->db->where("id_propiedad",$art->id);
      $this->db->where("id_empresa",$art->id_empresa);
      $this->db->update("inm_propiedades_meli",array(
        "id_propiedad"=>$art->id,
        "id_empresa"=>$art->id_empresa,
        "activo_meli"=>$art->activo_meli,
        "titulo_meli"=>$art->titulo_meli,
        "texto_meli"=>$art->texto_meli,
        "categoria_meli"=>$art->categoria_meli,
        "precio_meli"=>$art->precio_meli,
        "ciudad_meli"=>$art->ciudad_meli,
        "list_type_id"=>$art->list_type_id,
      ));
    }
    return TRUE;
  }

  function update_publicacion_mercadolibre($id) {

    // Volvemos a obtener el objeto
    $prop_meli = $this->get($id);
    if ($prop_meli === FALSE) return FALSE;

    if ($prop_meli->status == "active") {

      // El propiedad esta activo en MercadoLibre
      // entonces lo que tenemos que hacer es sincronizar los datos con la publicacion

      // Obtenemos la configuracion de la empresa
      $this->load->model("Empresa_Model");
      $web_conf = $this->Empresa_Model->get_web_conf($prop_meli->id_empresa);
      if ($web_conf === FALSE) return FALSE;
      if (empty($web_conf->ml_access_token) || empty($web_conf->ml_refresh_token)) return FALSE;

      require_once '../models/meli.php';
      $meli = new Meli(ML_APP_ID, ML_APP_SECRET, $web_conf->ml_access_token, $web_conf->ml_refresh_token);
      if($web_conf->ml_expires_in < time()) {
        try {
          // Refrescamos el access token
          $refresh = $meli->refreshAccessToken();
          if (isset($refresh['body']->access_token) && !empty($refresh['body']->access_token)) {
            $web_conf->ml_access_token = $refresh['body']->access_token;
            $web_conf->ml_expires_in = time() + $refresh['body']->expires_in;
            $web_conf->ml_refresh_token = $refresh['body']->refresh_token;
            $this->db->where("id_empresa",$web_conf->id_empresa);
            $this->db->update("web_configuracion",$web_conf);
          }
        } catch (Exception $e) {
          echo $e->getMessage();
          return FALSE;
        }
      }

      $params = array('access_token'=>$web_conf->ml_access_token);
      $body = array(
        "price" => $prop_meli->precio_meli
      );
      if ($prop_meli->id_empresa == 1749) {
        $body = array(
          "seller_contact" => array(
            "country_code" => "54",
            "phone" => "2215419009",
            "country_code2" => "",
            "phone2" => "",
          )
        );
      }
      $response = $meli->put("/items/".$prop_meli->id_meli, $body, $params);
      if ($response["httpCode"] == 200) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
  }

  function find($filter) {
    $id_empresa = parent::get_empresa();
    $this->db->where("id_empresa",$id_empresa);
    $this->db->like("nombre",$filter);
    $query = $this->db->get($this->tabla);
    $result = $query->result();
    $this->db->close();
    return $result;
  }
    
  // Controlamos si existe el codigo
  function existe_codigo($codigo,$id = 0,$id_empresa = 0) {
    $id_empresa = (empty($id_empresa)) ? parent::get_empresa() : $id_empresa;
    if (empty($codigo)) return FALSE;
    $sql = "SELECT * FROM inm_propiedades WHERE codigo = '$codigo' AND id_empresa = '$id_empresa' ";
    if ($id != 0) $sql.= "AND id != $id ";
    $q = $this->db->query($sql);
    return ($q->num_rows()>0);
  }

  function mas_visitadas($config = array()) {
    $id_empresa = (isset($config["id_empresa"])) ? $config["id_empresa"] : parent::get_empresa();
    $offset = (isset($config["offset"])) ? $config["offset"] : 6;
    $desde = (isset($config["desde"])) ? $config["desde"] : "";
    $hasta = (isset($config["hasta"])) ? $config["hasta"] : "";
    $sql = "SELECT id_propiedad, COUNT(*) AS cantidad ";
    $sql.= "FROM inm_propiedades_visitas ";
    $sql.= "WHERE id_empresa_propiedad = $id_empresa ";
    if (!empty($desde)) $sql.= "AND stamp >= '$desde' ";
    if (!empty($hasta)) $sql.= "AND stamp <= '$hasta' ";
    $sql.= "GROUP BY id_propiedad ";
    $sql.= "ORDER BY cantidad DESC ";
    $sql.= "LIMIT 0, $offset ";
    $q = $this->db->query($sql);
    $salida = array();
    foreach($q->result() as $r) {
      $rr = $this->get($r->id_propiedad,array(
        "id_empresa"=>$id_empresa
      ));
      if (!empty($rr)) {
        $obj = new stdClass();
        $obj->id = $rr->id;
        $obj->titulo = $rr->tipo_inmueble." en ".$rr->tipo_operacion;
        $obj->direccion_completa = $rr->direccion_completa;
        $obj->codigo = $rr->codigo;
        $obj->localidad = $rr->localidad;
        $obj->visitas = (is_null($r->cantidad) ? 0 : $r->cantidad);
        $obj->path = $rr->path;
        $salida[] = $obj;
      }
    }
    return $salida;
  }
    
  /**
   * Obtiene los propiedades a partir de diferentes parametros
   */
  function buscar($conf = array()) {
    
    $id_empresa = (isset($conf["id_empresa"])) ? $conf["id_empresa"] : parent::get_empresa();
    $buscar_red = (isset($conf["buscar_red"])) ? $conf["buscar_red"] : 0;
    $buscar_red_empresa = (isset($conf["buscar_red_empresa"])) ? $conf["buscar_red_empresa"] : 0;
    $id_propietario = (isset($conf["id_propietario"])) ? $conf["id_propietario"] : 0;
    $id_tipo_estado = (isset($conf["id_tipo_estado"])) ? $conf["id_tipo_estado"] : 0;
    $id_tipo_operacion = (isset($conf["id_tipo_operacion"])) ? $conf["id_tipo_operacion"] : 0;
    $id_tipo_inmueble = (isset($conf["id_tipo_inmueble"])) ? $conf["id_tipo_inmueble"] : 0;
    $id_localidad = (isset($conf["id_localidad"])) ? $conf["id_localidad"] : 0;
    $calle = (isset($conf["calle"])) ? trim($conf["calle"]) : "";
    $entre_calles = (isset($conf["entre_calles"])) ? trim($conf["entre_calles"]) : "";
    $entre_calles_2 = (isset($conf["entre_calles_2"])) ? trim($conf["entre_calles_2"]) : "";
    $id_usuario = (isset($conf["id_usuario"])) ? $conf["id_usuario"] : 0;
    $apto_banco = (isset($conf["apto_banco"])) ? $conf["apto_banco"] : 0;
    $acepta_permuta = (isset($conf["acepta_permuta"])) ? $conf["acepta_permuta"] : 0;
    $filter = (isset($conf["filter"])) ? $conf["filter"] : "";
    $limit = (isset($conf["limit"])) ? $conf["limit"] : 0;
    $offset = (isset($conf["offset"])) ? $conf["offset"] : 0;
    $order = (isset($conf["order"])) ? $conf["order"] : "";
    $activo = (isset($conf["activo"])) ? $conf["activo"] : -1;
    $filtro_meli = (isset($conf["filtro_meli"])) ? $conf["filtro_meli"] : -1;
    $filtro_olx = (isset($conf["filtro_olx"])) ? $conf["filtro_olx"] : -1;
    $filtro_inmovar = (isset($conf["filtro_inmovar"])) ? $conf["filtro_inmovar"] : -1;
    $filtro_inmobusquedas = (isset($conf["filtro_inmobusquedas"])) ? $conf["filtro_inmobusquedas"] : -1;
    $filtro_argenprop = (isset($conf["filtro_argenprop"])) ? $conf["filtro_argenprop"] : -1;
    $monto = (isset($conf["monto"])) ? $conf["monto"] : "";
    $monto_2 = (isset($conf["monto_2"])) ? $conf["monto_2"] : "";
    $monto_moneda = (isset($conf["monto_moneda"])) ? $conf["monto_moneda"] : "$";
    $dormitorios = (isset($conf["dormitorios"])) ? $conf["dormitorios"] : "";
    $banios = (isset($conf["banios"])) ? $conf["banios"] : "";
    $cocheras = (isset($conf["cocheras"])) ? $conf["cocheras"] : "";
    $olx_habilitado = (isset($conf["olx_habilitado"])) ? $conf["olx_habilitado"] : -1;
    $buscar_imagenes = (isset($conf["buscar_imagenes"])) ? $conf["buscar_imagenes"] : 0;

    // Cotizacion del dolar
    $cotizacion = 1;
    $q_cot = $this->db->query('SELECT * FROM cotizaciones WHERE moneda = "U$D" ORDER BY fecha DESC LIMIT 0,1 ');
    if ($q_cot->num_rows()>0) {
      $r_cot = $q_cot->row();
      $cotizacion = $r_cot->valor;
    }
    if (!is_numeric($monto)) $monto = 0;
    if (!is_numeric($monto_2)) $monto_2 = 99999999999999;
    
    $sql_count = "COUNT(*) AS cantidad ";
    
    $sql_fields = "SQL_CALC_FOUND_ROWS A.*, ";
    $sql_fields.= "E.razon_social AS inmobiliaria, E.path AS logo_inmobiliaria, E.id AS id_inmobiliaria, ";
    $sql_fields.= "E.incluye_comision_35, ";
    $sql_fields.= "E.codigo AS codigo_inmobiliaria, CONCAT(E.codigo,'-',A.codigo) AS codigo_completo, ";
    $sql_fields.= "IF(A.valido_hasta='0000-00-00','',DATE_FORMAT(A.valido_hasta,'%d/%m/%Y')) AS valido_hasta, ";
    $sql_fields.= "IF(A.fecha_publicacion='0000-00-00','',DATE_FORMAT(A.fecha_publicacion,'%d/%m/%Y')) AS fecha_publicacion, ";
    $sql_fields.= "IF(P.nombre IS NULL,'',P.nombre) AS propietario, ";
    $sql_fields.= "IF(TE.nombre IS NULL,'',TE.nombre) AS tipo_estado, ";
    $sql_fields.= "IF(TI.nombre IS NULL,'',TI.nombre) AS tipo_inmueble, ";
    $sql_fields.= "IF(X.nombre IS NULL,'',X.nombre) AS tipo_operacion, ";
    $sql_fields.= "IF(U.nombre IS NULL,'',U.nombre) AS usuario, ";
    $sql_fields.= "IF(U.email IS NULL,'',U.email) AS usuario_email, ";
    $sql_fields.= "IF(L.nombre IS NULL,'',L.nombre) AS localidad, ";
    $sql_fields.= "IF(L.id_localidad_inmobusquedas IS NULL,0,L.id_localidad_inmobusquedas) AS id_localidad_inmobusquedas, ";
    $sql_fields.= "IF(L.id_partido_inmobusquedas IS NULL,0,L.id_partido_inmobusquedas) AS id_partido_inmobusquedas, ";
    $sql_fields.= "IF(PROV.id_inmobusquedas IS NULL,0,PROV.id_inmobusquedas) AS id_provincia_inmobusquedas ";

    $sql_from = "FROM inm_propiedades A ";
    $sql_from.= "INNER JOIN empresas E ON (A.id_empresa = E.id) ";
    $sql_from.= "INNER JOIN web_configuracion WC ON (WC.id_empresa = E.id) ";
    $sql_from.= "LEFT JOIN inm_tipos_estado TE ON (A.id_tipo_estado = TE.id) ";
    $sql_from.= "LEFT JOIN inm_tipos_inmueble TI ON (A.id_tipo_inmueble = TI.id) ";
    $sql_from.= "LEFT JOIN inm_tipos_operacion X ON (A.id_tipo_operacion = X.id) ";
    $sql_from.= "LEFT JOIN com_usuarios U ON (A.id_usuario = U.id AND A.id_empresa = U.id_empresa) ";
    $sql_from.= "LEFT JOIN clientes P ON (A.id_propietario = P.id AND A.id_empresa = P.id_empresa) ";
    $sql_from.= "LEFT JOIN com_localidades L ON (A.id_localidad = L.id) ";
    $sql_from.= "LEFT JOIN com_departamentos DEP ON (L.id_departamento = DEP.id) ";
    $sql_from.= "LEFT JOIN com_provincias PROV ON (DEP.id_provincia = PROV.id) ";
    if ($filtro_meli >= 0) $sql_from.= "LEFT JOIN inm_propiedades_meli PROP_MELI ON (A.id = PROP_MELI.id_propiedad AND A.id_empresa = PROP_MELI.id_empresa) ";

    $sql_where = "WHERE 1=1 ";
    if ($olx_habilitado != -1) $sql_where.= "AND A.olx_habilitado = $olx_habilitado ";
    if (!empty($filter)) $sql_where.= "AND (A.codigo LIKE '%$filter%' OR CONCAT(E.codigo,'-',A.codigo) = '$filter' OR A.nombre LIKE '%$filter%' OR A.calle LIKE '%$filter%') ";
    if (!empty($id_tipo_estado)) $sql_where.= "AND A.id_tipo_estado = $id_tipo_estado ";
    if (!empty($id_tipo_operacion)) $sql_where.= "AND A.id_tipo_operacion IN ($id_tipo_operacion) ";
    if (!empty($id_tipo_inmueble)) $sql_where.= "AND A.id_tipo_inmueble IN ($id_tipo_inmueble) ";
    
    if (!empty($id_propietario)) $sql_where.= "AND A.id_propietario = $id_propietario ";
    if (!empty($id_localidad)) $sql_where.= "AND A.id_localidad IN ($id_localidad) ";
    if (!empty($calle)) $sql_where.= "AND TRIM(A.calle) = '$calle' ";
    if (!empty($entre_calles)) $sql_where.= "AND TRIM(A.entre_calles) = '$entre_calles' ";
    if (!empty($entre_calles_2)) $sql_where.= "AND TRIM(A.entre_calles_2) = '$entre_calles_2' ";
    if ($apto_banco == 1) $sql_where.= "AND A.apto_banco = 1 ";
    if ($acepta_permuta == 1) $sql_where.= "AND A.acepta_permuta = 1 ";
    if (!empty($dormitorios)) {
      if (strpos($dormitorios,"-")>0) {
        $dormitorios_array = explode("-", $dormitorios);
        foreach($dormitorios_array as &$dom) $dom = intval($dom);
        $dormitorios = implode(",", $dormitorios_array);
        $sql_where.= "AND (A.dormitorios IN ($dormitorios) ";
        if (in_array("7", $dormitorios_array)) $sql_where.= "OR A.dormitorios > 6 ";
        $sql_where.= ") ";
      } else {
        $dormitorios = intval($dormitorios);
        if ($dormitorios == "7") $sql_where.= "AND A.dormitorios > 6 ";
        else $sql_where.= "AND A.dormitorios = $dormitorios ";
      }
    }
    if (!empty($banios)) {
      if (strpos($banios,"-")>0) {
        $banios_array = explode("-", $banios);
        foreach($banios_array as &$dom) $dom = intval($dom);
        $banios = implode(",", $banios_array);
        $sql_where.= "AND (A.banios IN ($banios) ";
        if (in_array("7", $banios_array)) $sql_where.= "OR A.banios > 6 ";
        $sql_where.= ") ";
      } else {
        $banios = intval($banios);
        if ($banios == "7") $sql_where.= "AND A.banios > 6 ";
        else $sql_where.= "AND A.banios = $banios ";
      }
    }
    if (!empty($cocheras)) {
      if (strpos($cocheras,"-")>0) {
        $cocheras_array = explode("-", $cocheras);
        foreach($cocheras_array as &$dom) $dom = intval($dom);
        $cocheras = implode(",", $cocheras_array);
        $sql_where.= "AND (A.cocheras IN ($cocheras) ";
        if (in_array("4", $cocheras_array)) $sql_where.= "OR A.cocheras > 3 ";
        $sql_where.= ") ";
      } else {
        $cocheras = intval($cocheras);
        if ($cocheras == "4") $sql_where.= "AND A.cocheras > 3 ";
        else $sql_where.= "AND A.cocheras = $cocheras ";
      }
    }

    if ($monto_moneda == 'U$D') {
      $sql_where.= "AND (";
      $sql_where.= "(A.precio_final >= $monto AND A.precio_final <= $monto_2 AND A.moneda = '".'U$S'."') ";
      if ($cotizacion != 0) $sql_where.= "OR (A.moneda = '$' AND ((A.precio_final / $cotizacion) >= $monto) AND ((A.precio_final / $cotizacion) <= $monto_2) ) ";
      $sql_where.= ") ";
    } else if ($monto_moneda == "$") {
      $sql_where.= "AND (";
      $sql_where.= "(A.precio_final >= $monto AND A.precio_final <= $monto_2 AND A.moneda = '$') ";
      $sql_where.= "OR (A.moneda = '".'U$S'."' AND (A.precio_final * $cotizacion) >= $monto AND (A.precio_final * $cotizacion) <= $monto_2 ) ";
      $sql_where.= ") ";      
    }

    // Bloque de SQL que identifica que estamos buscando en la red
    $sql_red = "AND A.compartida >= 1 "; // En primer lugar tiene que estar compartida
    $sql_red.= "AND A.activo = 1 "; // SIEMPRE BUSCA LAS ACTIVAS
    $sql_red.= "AND E.activo = 1 "; // LA EMPRESA TIENE QUE ESTAR ACTIVA
    $sql_red.= "AND A.id_tipo_estado NOT IN (2,3,4,6) "; // Tampoco tiene sentido buscar las vendidas o alquiladas
    $sql_red.= "AND A.id_empresa IN (";
    $sql_red.= " SELECT PR.id_empresa FROM inm_permisos_red PR ";
    $sql_red.= " WHERE PR.id_empresa_compartida = $id_empresa ";
    $sql_red.= " AND PR.permiso_red = 1 "; // Tiene el permiso habilitado
    if (!empty($buscar_red_empresa)) $sql_red.= " AND PR.id_empresa = $buscar_red_empresa ";
    $sql_red.= ") ";
    if ($buscar_red >= 1) $sql_red.= "AND E.id_zona_red = $buscar_red ";

    $sql_final = "";

    $sql_activo = ($activo != -1 && $activo != '') ? "AND A.activo = $activo " : " ";

    if ($buscar_red >= 1) {

      // ARMAMOS LA CONSULTA PARA LA RED
      $sql = "SELECT ".$sql_fields.$sql_from.$sql_where.$sql_red;
      if (!empty($order)) $sql.= "ORDER BY $order ";
      if ($offset != 0) $sql.= "LIMIT $limit, $offset ";
      $sql_final = $sql;
      $q = $this->db->query($sql);

      $q_total = $this->db->query("SELECT FOUND_ROWS() AS total");
      $total = $q_total->row();
      $total_red = $total->total;
      $total_resultados = $total->total;

      // Ahora hacemos la misma consulta, pero sobre mis propiedades
      $sql_where_2 = "AND A.id_empresa = $id_empresa ";
      $sql = "SELECT ".$sql_count.$sql_from.$sql_where.$sql_where_2.$sql_activo;
      $q_total = $this->db->query($sql);
      $total = $q_total->row();
      $total_propias = $total->cantidad;

    } else {

      // Si estamos buscando en MIS PROPIEDADES
      $sql_where_2 = "";

      // Si estamos buscando por la red inmovar, el filtro de SOLO_USUARIO no deberia aplicarse
      if (!empty($id_usuario)) $sql_where_2.= "AND A.id_usuario = $id_usuario ";      

      // Estos filtros solo se aplican para propiedades propias, no para las de la red
      if ($filtro_meli == 1) $sql_where_2.= "AND PROP_MELI.status = 'active' ";
      else if ($filtro_meli == 2) $sql_where_2.= "AND PROP_MELI.status = 'paused' ";
      else if ($filtro_meli == 3) $sql_where_2.= "AND PROP_MELI.status = 'closed' ";
      else if ($filtro_meli == 0) $sql_where_2.= "AND (PROP_MELI.id_propiedad IS NULL OR PROP_MELI.status = '') ";
      
      if ($filtro_olx == 1) $sql_where_2.= "AND A.olx_habilitado = 1 AND A.olx_id != '' ";
      else if ($filtro_olx == 2) $sql_where_2.= "AND A.olx_habilitado = 1 AND A.olx_id = '' ";
      else if ($filtro_olx == 0) $sql_where_2.= "AND A.olx_habilitado = 0 ";

      if ($filtro_inmovar == 1) $sql_where_2.= "AND A.compartida >= 1 ";
      else if ($filtro_inmovar == 0) $sql_where_2.= "AND A.compartida = 0 ";

      if ($filtro_inmobusquedas == 1) $sql_where_2.= "AND A.inmobusquedas_habilitado = 1 AND A.inmobusquedas_url != '' ";
      else if ($filtro_inmobusquedas == 2) $sql_where_2.= "AND A.inmobusquedas_habilitado = 1 AND A.inmobusquedas_url = '' ";
      else if ($filtro_inmobusquedas == 3) $sql_where_2.= "AND A.inmobusquedas_habilitado = 1 ";
      else if ($filtro_inmobusquedas == 0) $sql_where_2.= "AND A.inmobusquedas_habilitado = 0 ";

      if ($filtro_argenprop == 1) $sql_where_2.= "AND A.argenprop_habilitado >= 1 ";
      else if ($filtro_argenprop == 0) $sql_where_2.= "AND A.argenprop_habilitado = 0 ";

      if ($id_empresa != -1) $sql_where_2.= "AND A.id_empresa = $id_empresa ";

      // ARMAMOS LA CONSULTA PRINCIPAL
      $sql = "SELECT ".$sql_fields.$sql_from.$sql_where.$sql_where_2.$sql_activo;
      if (!empty($order)) $sql.= "ORDER BY $order ";
      if ($offset != 0) $sql.= "LIMIT $limit, $offset ";
      $sql_final = $sql;
      $q = $this->db->query($sql);      

      $q_total = $this->db->query("SELECT FOUND_ROWS() AS total");
      $total = $q_total->row();   
      $total_resultados = $total->total;

      $total_propias = $total->total;

      // Ahora hacemos la misma consulta, pero sobre las propiedades de la RED
      $sql = "SELECT ".$sql_count.$sql_from.$sql_where.$sql_red;
      $q_total = $this->db->query($sql);
      $total = $q_total->row();
      $total_red = $total->cantidad;
    }

    // Propiedades totales (activas y no activas)
    $sql = "SELECT COUNT(*) as total ".$sql_from.$sql_where.$sql_where_2;
    if (!empty($order)) $sql.= "ORDER BY $order ";
    $sql_final = $sql;
    $q_total = $this->db->query($sql);
    $r_total = $q_total->row();
    $total_todas = $r_total->total;
    $hoy = date("Y-m-d");
    $salida = array();
    foreach($q->result() as $r) {

      //0 Sin vencer
      //1 A 1 mes de vencer
      //2 Vencida
      $r->pronto_a_vencer = 0;

      if (!empty($r->fecha_vencimiento) && $r->fecha_vencimiento != "0000-00-00") {  

        $datediff = strtotime($r->fecha_vencimiento) - strtotime($hoy);
        $dias_para_vencimiento = round($datediff / (60 * 60 * 24));

        if ($dias_para_vencimiento >= 1 && $dias_para_vencimiento <= 31) {
          $r->pronto_a_vencer = 1;
        } else if ($dias_para_vencimiento <= 0) {
          $r->pronto_a_vencer = 2;
        }

      }

      if ($buscar_imagenes == 1) {
        $sql = "SELECT AI.* FROM inm_propiedades_images AI ";
        $sql.= "WHERE AI.id_propiedad = $r->id AND AI.id_empresa = $r->id_empresa ORDER BY AI.orden ASC";
        $qq = $this->db->query($sql);
        $r->images = array();
        $r->planos = array();
        foreach($qq->result() as $rr) {
          if ($rr->plano == 1) $r->planos[] = $rr->path;
          else $r->images[] = $rr->path;
        }
      }

      $r->bloqueado_web = 0;
      $r->permiso_web = 0;
      // Si estamos buscando en la red
      if ($buscar_red >= 1) {

        // Controlamos si la otra inmobiliaria nos dio permiso
        $sql = "SELECT permiso_web FROM inm_permisos_red ";
        $sql.= "WHERE id_empresa = $id_empresa ";
        $sql.= "AND id_empresa_compartida = $r->id_inmobiliaria ";
        $sql.= "AND solicitud_permiso = 0 ";
        $sql.= "AND bloqueado = 0 ";
        $qqq = $this->db->query($sql);
        if ($qqq->num_rows() > 0) {
          $rrr = $qqq->row();
          $r->permiso_web = $rrr->permiso_web;
        }

        // Controlamos si tenemos bloqueada a la propiedad
        $sql = "SELECT 1 FROM inm_propiedades_bloqueadas ";
        $sql.= "WHERE id_empresa = $id_empresa ";
        $sql.= "AND id_propiedad = $r->id ";
        $sql.= "AND id_empresa_propiedad = $r->id_inmobiliaria ";
        $qqq = $this->db->query($sql);
        if ($qqq->num_rows() > 0) $r->bloqueado_web = 1;
      }

      $ingresar_row = 1;

      // Si esta compartido en MercadoLibre
      $r->activo_meli = 0;
      $r->categoria_meli = "";
      $r->permalink = "";
      $r->status = "";
      $r->id_meli = "";
      $qqq = $this->db->query("SELECT * FROM inm_propiedades_meli WHERE id_empresa = $id_empresa AND id_propiedad = $r->id ");
      if ($qqq->num_rows()>0) {
        $rrr = $qqq->row();
        $r->id_meli = $rrr->id_meli;
        $r->activo_meli = $rrr->activo_meli;
        $r->categoria_meli = $rrr->categoria_meli;
        $r->permalink = $rrr->permalink;
        $r->status = $rrr->status;
      }

      $r->titulo = ($r->id_empresa != 1575) ? $this->generar_titulo($r) : $r->nombre;
      $r->direccion_completa = $r->calle.(!empty($r->entre_calles) ? " e/ ".$r->entre_calles.(!empty($r->entre_calles_2) ? " y ".$r->entre_calles_2 : "") : "");
      $r->direccion_completa.= (($r->publica_altura == 1)?" N° ".$r->altura:"") . (!empty($r->piso) ? " Piso ".$r->piso : "") . (!empty($r->numero) ? " Depto. ".$r->numero : "");

      $r->direccion_completa_red = $r->calle.(!empty($r->entre_calles) ? " e/ ".$r->entre_calles.(!empty($r->entre_calles_2) ? " y ".$r->entre_calles_2 : "") : "");

      // Formamos el precio (si se debe mostrar o no)
      if ($r->publica_precio == 1) {
        $r->precio = $r->moneda." ".number_format($r->precio_final,0,"",".");
      } else {
        $r->precio = "Consultar";
      }

      /*
      if ($filtro_meli == 1 && $r->status != "active") $ingresar_row = 0;
      else if ($filtro_meli == 2 && $r->status != "paused") $ingresar_row = 0;
      else if ($filtro_meli == 3 && $r->status != "closed") $ingresar_row = 0;
      else if ($filtro_meli == 0 && !empty($r->id_meli)) $ingresar_row = 0; 
      */
      $salida[] = $r;
    }

    if ($activo == 1) {
      $total_activas = $total_propias;
      $total_inactivas = $total_todas - $total_propias;
    } else if ($activo == 0) {
      $total_inactivas = $total_propias;
      $total_activas = $total_todas - $total_propias;
    } else {
      $total_activas = $total_propias;
      $total_inactivas = $total_propias;
    }

    return array(
      "results"=>$salida,
      "total"=>$total_resultados,
      "sql"=>$sql_final,
      "meta"=>array(
        "total_red"=>$total_red,
        "total_activas"=>$total_activas,
        "total_inactivas"=>$total_inactivas,
      ),
      
    );
  }

  function save($data) {

    $no_controlar_codigo = (isset($data->no_controlar_codigo) ? $data->no_controlar_codigo : 0);

    if (isset($data->id) && $data->id != 0) { //Si ya tiene ID
      $sql = "SELECT precio_final FROM inm_propiedades where id = $data->id AND id_empresa = $data->id_empresa ";
      $q = $this->db->query($sql);
      if ($q->num_rows() > 0) {
        $r = $q->row();
        if (empty($data->precio_final)) $data->precio_final = 0;
        if (empty($r->precio_final)) $r->precio_final = 0;
        if ($r->precio_final != $data->precio_final){
          $fecha = date("Y-m-d");
          $sql = "INSERT INTO inm_propiedades_precios_historicos (id_propiedad, id_empresa, precio_anterior, precio_nuevo, fecha) VALUES ";
          $sql.= "($data->id, $data->id_empresa, '$r->precio_final', '$data->precio_final', '$fecha') ";

          $data->precio_porcentaje_anterior = (($data->precio_final - $r->precio_final)/$r->precio_final)*100;
          $this->db->query($sql);
        }
      }
    //Si el ID es 0:
    } else {
      $data->fecha_ingreso = date("Y-m-d");
      $data->fecha_vencimiento = date("Y-m-d", strtotime($data->fecha_ingreso." +3 months"));
    }

    $this->load->helper("file_helper");
    $this->load->helper("fecha_helper");    

    // Guardamos lo que no se persiste
    $id_empresa = $data->id_empresa;
    $images = (isset($data->images)) ? $data->images : array();
    $images_meli = (isset($data->images_meli)) ? $data->images_meli : array();
    $planos = (isset($data->planos)) ? $data->planos : array();
    $departamentos = (isset($data->departamentos)) ? $data->departamentos : array();
    $gastos = (isset($data->gastos)) ? $data->gastos : array();
    $permutas = (isset($data->permutas)) ? $data->permutas : array();
    $productos_relacionados = (isset($data->relacionados)) ? $data->relacionados : array();
    $temporada = (isset($data->temporada)) ? $data->temporada : array();
    $impuestos = (isset($data->impuestos)) ? $data->impuestos : array();
    $id_meli = isset($data->id_meli) ? $data->id_meli : "";
    $permalink = isset($data->permalink) ? $data->permalink : "";
    $fecha_publicacion = isset($data->fecha_publicacion) ? $data->fecha_publicacion : "";
    $activo_meli = isset($data->activo_meli) ? $data->activo_meli : 0;
    $titulo_meli = isset($data->titulo_meli) ? $data->titulo_meli : "";
    $texto_meli = isset($data->texto_meli) ? $data->texto_meli : "";
    $categoria_meli = isset($data->categoria_meli) ? $data->categoria_meli : "";
    $precio_meli = isset($data->precio_final) ? $data->precio_final : 0;
    $list_type_id = isset($data->list_type_id) ? $data->list_type_id : "";
    $ciudad_meli = isset($data->ciudad_meli) ? $data->ciudad_meli : "";
    $status = isset($data->status) ? $data->status : "";    

    if (isset($data->valido_hasta)) $data->valido_hasta = fecha_mysql($data->valido_hasta);
    $data->fecha_publicacion = (!empty($data->fecha_publicacion)) ? fecha_mysql($data->fecha_publicacion) : date("Y-m-d");
    $data->codigo = isset($data->codigo) ? $data->codigo : "";
    $data->codigo = trim($data->codigo);

    // La primera foto del array es la imagen principal
    if (sizeof($images)>0) {
      $data->path = $images[0];
      $data->path = str_replace(" / ", "/", $data->path);
    }

    // Si no tiene propietario asignado
    if ((!isset($data->id_propietario) || is_null($data->id_propietario)) && $no_controlar_codigo == 0) $data->id_propietario = 0;

    $tipo_inmueble = "";
    $q = $this->db->query("SELECT * FROM inm_tipos_inmueble WHERE id = $data->id_tipo_inmueble");
    if ($q->num_rows() > 0) {
      $ti = $q->row();  
      $tipo_inmueble = $ti->nombre;
    }
    
    $tipo_operacion = "";
    $q = $this->db->query("SELECT * FROM inm_tipos_operacion WHERE id = $data->id_tipo_operacion");
    if ($q->num_rows() > 0) {
      $ti = $q->row();  
      $tipo_operacion = $ti->nombre;
    }

    $localidad = "";
    $q = $this->db->query("SELECT * FROM com_localidades WHERE id = $data->id_localidad");
    if ($q->num_rows() > 0) {
      $ti = $q->row();  
      $localidad = $ti->nombre;
    }

    if ($data->id_empresa != 1575) {
      $data->nombre = $tipo_inmueble." en ".$tipo_operacion.((!empty($localidad)) ? " en ".$localidad : "");
    }

    $data->calle = str_replace(" - La Plata", "", $data->calle);
    
    // Si en el campo calle tiene un e/ o entre, tenemos que sacarlo
    if (strpos(mb_strtolower($data->calle), "e/")>0) {
      $entre = substr($data->calle, strpos(mb_strtolower($data->calle), "e/"));
      if (strpos($entre, "y")>0) {
        $e = explode("y", $entre);
        if (sizeof($e)==2) {
          $data->calle = str_replace($entre, "", $data->calle);
          $entre_calles = trim($e[0]);
          $entre_calles = str_replace("e/", "", $entre_calles);
          $entre_calles_2 = trim($e[1]);
          $data->entre_calles = ucwords($entre_calles);
          $data->entre_calles_2 = ucwords($entre_calles_2);
        }
      }
    }
    if (strpos(mb_strtolower($data->calle), "entre")>0) {
      $entre = substr($data->calle, strpos(mb_strtolower($data->calle), "entre"));
      if (strpos($entre, "y")>0) {
        $e = explode("y", $entre);
        if (sizeof($e)==2) {
          $data->calle = str_replace($entre, "", $data->calle);
          $entre_calles = trim($e[0]);
          $entre_calles = str_replace("entre", "", $entre_calles);
          $entre_calles_2 = trim($e[1]);
          $data->entre_calles = ucwords($entre_calles);
          $data->entre_calles_2 = ucwords($entre_calles_2);
        }
      }
    }

    try {

      // Evaluamos si es un insert o un update
      $id = isset($data->id) ? $data->id : null;
      if ( (is_null($id)) || ($id == 0)) {
        // Insertamos los datos, removiendo el id para que no haya problemas
        if (isset($data->id)) unset($data->id);
        $id = $this->insert($data);
        $fecha = date("Y-m-d");
        $sql = "INSERT INTO inm_propiedades_precios_historicos (id_propiedad, id_empresa, precio_anterior, precio_nuevo, fecha) VALUES ";
        $sql.= "($id, $data->id_empresa, '0', '$data->precio_final', '$fecha') ";
        $this->db->query($sql); 
      } else {
        // Si tiene algun valor, debemos actualizarlo
        $this->update($id,$data);
      }

      // POST SAVE
      // =================

      // CONTROLAMOS SI ESTA PUBLICADO EN MERCADOLIBRE
      $data->categoria_meli = $categoria_meli;
      $data->id_meli = $id_meli;
      $data->permalink = $permalink;
      $data->fecha_publicacion = $fecha_publicacion;
      $data->activo_meli = $activo_meli;
      $data->titulo_meli = $titulo_meli;
      $data->texto_meli = $texto_meli;
      $data->categoria_meli = $categoria_meli;
      $data->precio_meli = $precio_meli;
      $data->list_type_id = $list_type_id;
      $data->ciudad_meli = $ciudad_meli;
      $data->status = $status;
      $publicado = $this->update_meli($data);
      if ($publicado) $this->update_publicacion_mercadolibre($id);
      
      // Propiedades relacionadas
      if ($no_controlar_codigo == 0) {
        $this->db->query("DELETE FROM inm_propiedades_relacionados WHERE id_propiedad = $id AND id_empresa = $id_empresa");
        $i=1;
        foreach($productos_relacionados as $p) {
          $this->db->insert("inm_propiedades_relacionados",array(
            "id_propiedad"=>$id,
            "id_relacion"=>$p->id,
            "id_rubro"=>0,
            "destacado"=>$p->destacado,
            "orden"=>$i,
          ));
          $i++;
        }
      }

      // Actualizamos los departamentos
      if ($no_controlar_codigo == 0) {
        $this->db->query("DELETE FROM inm_departamentos WHERE id_propiedad = $id AND id_empresa = $id_empresa");
        $this->db->query("DELETE FROM inm_departamentos_images WHERE id_propiedad = $id AND id_empresa = $id_empresa");
        $i=1;
        foreach($departamentos as $p) {
          $this->db->insert("inm_departamentos",array(
            "id_propiedad"=>$id,
            "nombre"=>$p->nombre,
            "texto"=>$p->texto,
            "piso"=>$p->piso,
            "id_empresa"=>$p->id_empresa,
            "disponible"=>$p->disponible,
            "orden"=>$p->orden,
          ));
          $id_departamento = $this->db->insert_id();
          // Insertamos las fotos del departamento
          $j=0;
          foreach($p->images_dptos as $f) {
            $this->db->insert("inm_departamentos_images",array(
              "id_propiedad"=>$id,
              "id_departamento"=>$id_departamento,
              "path"=>$f,
              "id_empresa"=>$p->id_empresa,
              "orden"=>$j,
            ));
            $j++;
          }
          $i++;
        }
      }

      // Actualizamos los gastos
      if ($no_controlar_codigo == 0) {
        $this->db->query("DELETE FROM inm_propiedades_gastos WHERE id_propiedad = $id AND id_empresa = $id_empresa");
        foreach($gastos as $p) {
          $this->db->insert("inm_propiedades_gastos",array(
            "id_propiedad"=>$id,
            "path"=>$p->path,
            "descripcion"=>$p->descripcion,
            "fecha"=>$p->fecha,
            "id_empresa"=>$p->id_empresa,
            "concepto"=>$p->concepto,
            "monto"=>$p->monto,
          ));
        }
      }

      if ($no_controlar_codigo == 0) {
        $this->db->query("DELETE FROM inm_propiedades_permutas WHERE id_propiedad = $id AND id_empresa = $id_empresa");
        foreach($permutas as $p) {
          $this->db->insert("inm_propiedades_permutas",array(
            "id_propiedad"=>$id,
            "id_empresa"=>$p->id_empresa,
            "banios"=>$p->banios,
            "dormitorios"=>$p->dormitorios,
            "cocheras"=>$p->cocheras,
            "precio_maximo"=>$p->precio_maximo,
            "id_localidad"=>$p->id_localidad,
            "id_tipo_inmueble"=>$p->id_tipo_inmueble,
          ));
        }
      }
          
      // Guardamos las imagenes
      $this->db->query("DELETE FROM inm_propiedades_images WHERE plano = 0 AND id_propiedad = $id AND id_empresa = $id_empresa");
      $k=0;
      foreach($images as $im) {
        $im = str_replace(" / ", "/", $im);
        $this->db->query("INSERT INTO inm_propiedades_images (plano,id_empresa,id_propiedad,path,orden) VALUES(0,$id_empresa,$id,'$im',$k)");
        $k++;
      }
      $this->db->query("DELETE FROM inm_propiedades_images_meli WHERE id_propiedad = $id AND id_empresa = $id_empresa");
      $k=0;
      foreach($images_meli as $im) {
        $sql = "INSERT INTO inm_propiedades_images_meli (id_empresa,id_propiedad,path,orden";
        $sql.= ") VALUES( ";
        $sql.= "$id_empresa,$id,'$im',$k)";
        $this->db->query($sql);
        $k++;
      }  
      
      // Guardamos los planos
      $this->db->query("DELETE FROM inm_propiedades_images WHERE plano = 1 AND id_propiedad = $id AND id_empresa = $id_empresa");
      $k=0;
      foreach($planos as $im) {
        $im = str_replace(" / ", "/", $im);
        $this->db->query("INSERT INTO inm_propiedades_images (plano,id_empresa,id_propiedad,path,orden) VALUES(1,$id_empresa,$id,'$im',$k)");
        $k++;
      }

      // Guardamos los precios
      if ($no_controlar_codigo == 0) {
        $this->db->query("DELETE FROM inm_propiedades_precios WHERE id_propiedad = $id AND id_empresa = $data->id_empresa");
        foreach($temporada as $im) {
          $desde = fecha_mysql($im->fecha_desde);
          $hasta = fecha_mysql($im->fecha_hasta);
          $this->db->query("INSERT INTO inm_propiedades_precios (id_empresa,id_propiedad,promocion,fecha_desde,fecha_hasta,precio_finde,precio_semana,precio_mes,nombre,minimo_dias_reserva,precio) VALUES($data->id_empresa,$id,0,'$desde','$hasta',$im->precio_finde,$im->precio_semana,$im->precio_mes,'$im->nombre',$im->minimo_dias_reserva,$im->precio)");
        }

        // Guardamos los impuestos
        $this->db->query("DELETE FROM inm_propiedades_impuestos WHERE id_propiedad = $id AND id_empresa = $data->id_empresa");
        $k=0;
        foreach($impuestos as $im) {
          $this->db->query("INSERT INTO inm_propiedades_impuestos (id_empresa,id_propiedad,nombre,tipo,monto,orden) VALUES($data->id_empresa,$id,'$im->nombre','$im->tipo','$im->monto',$k)");
          $k++;
        }
      }

      // Si se inserta una nueva propiedad, buscamos si choca con alguna otra en la red
      $this->buscar_similitudes(array(
        "id_empresa"=>$data->id_empresa,
        "id_tipo_inmueble"=>$data->id_tipo_inmueble,
        "calle"=>$data->calle,
        "altura"=>$data->altura,
        "piso"=>$data->piso,
        "numero"=>$data->numero,
        "id_localidad"=>$data->id_localidad,
        "id_propiedad"=>$id,
      ));    

      return $id;

    } catch(Exception $e) {
      // Si capturamos alguna excepcion, la volvemos a mandar
      throw $e;
    }
  }

  // ACTUALIZAR UNA PROPIEDAD
  function update($id,$data) {

    // Controlamos que no se este editando por un codigo de otra propiedad
    if (!empty($data->codigo) && !isset($data->no_controlar_codigo)) {
      if ($this->existe_codigo($data->codigo,$id,$data->id_empresa)) {
        throw new Exception("El codigo '$data->codigo' ya existe en otra propiedad.");
      }      
    }


    $s = parent::update($id,$data);

    if (isset($data->argenprop_url) && !empty($data->argenprop_url)) {
      $this->compartir_argenprop(array(
        "id_empresa"=>$data->id_empresa,
        "id_propiedad"=>$id,
      ));
    }

    return $s;
  }

  // INSERTAR UNA PROPIEDAD
  function insert($data) {

    // Controlamos el plan elegido, si se llego al maximo
    if (!isset($data->no_controlar_plan)) {
      $control_plan = $this->controlar_plan($data->id_empresa);
      if ($control_plan !== TRUE) {
        throw new Exception($controlar_plan["mensaje"]);
      }
    }

    // Controlamos si el codigo ya existe con otra propiedad
    if (!isset($data->no_controlar_codigo)) {
      if (!empty($data->codigo)) {
        if ($this->existe_codigo($data->codigo,0,$data->id_empresa)) {
          throw new Exception("El codigo '$data->codigo' ya existe.");
        }      
      }
    }

    // Si no tiene codigo, le creamos uno
    if (!isset($data->codigo) || empty($data->codigo)) {
      $data->codigo = $this->next(array(
        "id_empresa"=>$data->id_empresa,
      ));
    }
      
    // Insertamos la propiedad
    $id = parent::insert($data);

    // Actualizamos el link
    $data->hash = md5($id.$data->id_empresa);
    $data->link = "propiedad/".filename($data->nombre,"-",0)."-".$id."/";
    $this->db->query("UPDATE inm_propiedades SET link = '$data->link', hash='$data->hash' WHERE id = $id AND id_empresa = $data->id_empresa");

    return $id;
  }
  
  // Obtenemos el proximo codigo automatico
  function next($config = array()) {
    $id_empresa = (isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa());
    $q = $this->db->query("SELECT IF(MAX(codigo) IS NULL,0,MAX(codigo)) AS codigo FROM inm_propiedades WHERE id_empresa = $id_empresa");
    $r = $q->row();
    return ((int)$r->codigo + 1);
  }

  function get_visitas_propiedad($conf = array()) {
    $res = new Stdclass;
    $un_mes_antes = new DateTime('1 month ago');
    $id_empresa = isset($conf['id_empresa']) ? $conf['id_empresa'] : parent::get_empresa();
    $id_propiedad = isset($conf['id_propiedad']) ? $conf['id_propiedad'] : 0;
    $fecha_desde = isset($conf['fecha_desde']) ? $conf['fecha_desde'] : $un_mes_antes->format('Y-m-d');
    $fecha_hasta = isset($conf['fecha_hasta']) ? $conf['fecha_hasta'] : date('Y-m-d');
    //No buscar
    $no_buscar = isset($conf['no_buscar']) ? $conf['no_buscar'] : 0;
    $intervalo = "D";
    $desde = new DateTime($fecha_desde);
    $hasta = new DateTime($fecha_hasta);
    $hasta->add(new DateInterval('P1D'));
    $interval = new DateInterval('P1'.$intervalo);
    $range = new DatePeriod($desde,$interval,$hasta);
    $diff = $hasta->diff($desde)->format("%a"); 
    $res->visitas_web = array();
    $res->clientes_consultas = array();
    $res->visitas_panel = array();
    $res->consultas_panel = array();
    // Recorremos cada dia del rango
    if ($no_buscar == 0) {
      foreach($range as $fecha) {

        // Sacamos las visitas web
        $sql = "SELECT PV.*, DATE_FORMAT(PV.stamp,'%Y-%m-%d') as fecha FROM inm_propiedades_visitas PV ";
        $sql.= "WHERE PV.id_empresa = '$id_empresa' ";
        $sql.= "AND PV.id_propiedad = '$id_propiedad' ";
        $sql.= "AND DATE_FORMAT(PV.stamp,'%Y-%m-%d') = '".$fecha->format("Y-m-d")."' ";
        $q = $this->db->query($sql);
        $res->visitas_web[] = $q->num_rows();

        // Sacamos las visitas del panel
        $sql = "SELECT PV.*, DATE_FORMAT(PV.fecha,'%Y-%m-%d') as fecha FROM visitas_panel PV ";
        $sql.= "WHERE PV.id_propiedad = '$id_propiedad' AND PV.tipo = 0 ";
        $sql.= "AND DATE_FORMAT(PV.fecha,'%Y-%m-%d') = '".$fecha->format("Y-m-d")."' ";
        $q = $this->db->query($sql);
        $res->visitas_panel[] = $q->num_rows();


        // Sacamos als consultas

        $sql = "SELECT CC.*, IF(C.nombre IS NULL, '', C.nombre) as cliente_nombre FROM crm_consultas CC ";
        $sql.= "LEFT JOIN clientes C ON (C.id = CC.id_contacto AND C.id_empresa = CC.id_empresa) ";
        $sql.= "WHERE CC.id_empresa = '$id_empresa' ";
        $sql.= "AND CC.id_referencia = '$id_propiedad' ";
        $sql.= "AND DATE_FORMAT(CC.fecha,'%Y-%m-%d') = '".$fecha->format("Y-m-d")."' ";
        //$sql.= "AND CC.tipo IN (1,2) ";
        $q = $this->db->query($sql);

        $res->consultas[] = $q->num_rows();

        if ($q->num_rows() > 0 ) { 
          foreach ($q->result() as $con) {
            $res->clientes_consultas[] = $con;
          }
        }

        // Sacamos las visitas del panel
        $sql = "SELECT PV.*, DATE_FORMAT(PV.fecha,'%Y-%m-%d') as fecha FROM visitas_panel PV ";
        $sql.= "WHERE PV.id_propiedad = '$id_propiedad' AND PV.tipo = 1 ";
        $sql.= "AND DATE_FORMAT(PV.fecha,'%Y-%m-%d') = '".$fecha->format("Y-m-d")."' ";
        $q = $this->db->query($sql);
        $res->consultas_panel[] = $q->num_rows();


      }
    }


    $sql = "SELECT PV.* FROM inm_propiedades_visitas PV ";
    $sql.= "WHERE PV.id_empresa = '$id_empresa' ";
    $sql.= "AND PV.id_propiedad = '$id_propiedad' ";
    $sql.= "AND DATE_FORMAT(PV.stamp,'%Y-%m-%d') >= '$fecha_desde' AND DATE_FORMAT(PV.stamp,'%Y-%m-%d') <= '$fecha_hasta' ";
    $q = $this->db->query($sql);
    $res->total_web = $q->num_rows();

    $sql = "SELECT PV.* FROM visitas_panel PV ";
    $sql.= "WHERE PV.id_propiedad = '$id_propiedad' AND PV.tipo = 0 ";
    $sql.= "AND DATE_FORMAT(PV.fecha,'%Y-%m-%d') >= '$fecha_desde' AND DATE_FORMAT(PV.fecha,'%Y-%m-%d') <= '$fecha_hasta' ";
    $q = $this->db->query($sql);
    $res->total_panel = $q->num_rows();

    $sql = "SELECT CC.* FROM crm_consultas CC ";
    $sql.= "WHERE DATE_FORMAT(CC.fecha,'%Y-%m-%d') >= '$fecha_desde' AND DATE_FORMAT(CC.fecha,'%Y-%m-%d') <= '$fecha_hasta' ";
    $sql.= "AND CC.id_referencia = '$id_propiedad' ";
    $sql.= "AND CC.id_empresa = '$id_empresa' ";
    $q = $this->db->query($sql);
    $res->total_consultas_web = $q->num_rows();

    $sql = "SELECT PV.* FROM visitas_panel PV ";
    $sql.= "WHERE PV.id_propiedad = '$id_propiedad' AND PV.tipo = 1 ";
    $sql.= "AND DATE_FORMAT(PV.fecha,'%Y-%m-%d') >= '$fecha_desde' AND DATE_FORMAT(PV.fecha,'%Y-%m-%d') <= '$fecha_hasta' ";
    $q = $this->db->query($sql);
    $res->total_consultas_panel = $q->num_rows();

    $res->total_consultas = $res->total_consultas_web;//+$res->total_consultas_panel;
    //Para guardar las fechas en formato YYYY-MM-DD
    $res->fechas_sql = array($fecha_desde, $fecha_hasta);

    $res->id_propiedad = $id_propiedad;
    return $res;
  }
  
  
  function get($id,$config=array()) {
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $id_empresa_original = isset($config["id_empresa_original"]) ? $config["id_empresa_original"] : $id_empresa;
    $get_data = isset($config["get_data"]) ? $config["get_data"] : 0;
    $fecha_desde = isset($config["fecha_desde"]) ? $config["fecha_desde"] : "";
    $fecha_hasta = isset($config["fecha_hasta"]) ? $config["fecha_hasta"] : "";
    $hoy = date("Y-m-d");

    // Obtenemos los datos del propiedad
    $id = (int)$id;
    $sql = "SELECT A.*, ";
    $sql.= "IF(A.valido_hasta='0000-00-00','',DATE_FORMAT(A.valido_hasta,'%d/%m/%Y')) AS valido_hasta, ";
    $sql.= "A.fecha_publicacion AS fecha_publicacion_f, ";
    $sql.= "IF(A.fecha_publicacion='0000-00-00','',DATE_FORMAT(A.fecha_publicacion,'%d/%m/%Y')) AS fecha_publicacion, ";
    $sql.= "E.nombre AS empresa, E.path AS empresa_path, E.telefono_empresa AS empresa_telefono, E.direccion_empresa AS empresa_direccion, E.email AS empresa_email, ";
    $sql.= "E.codigo AS codigo_inmobiliaria, CONCAT(E.codigo,'-',A.codigo) AS codigo_completo, ";
    $sql.= "E.incluye_comision_35, ";
    $sql.= "IF(P.nombre IS NULL,'',P.nombre) AS propietario, ";
    $sql.= "IF(P.telefono IS NULL,'',P.telefono) AS propietario_telefono, ";
    $sql.= "IF(P.email IS NULL,'',P.email) AS propietario_email, ";
    $sql.= "IF(P.direccion IS NULL,'',P.direccion) AS propietario_direccion, ";
    $sql.= "IF(TE.nombre IS NULL,'',TE.nombre) AS tipo_estado, ";
    $sql.= "IF(TI.nombre IS NULL,'',TI.nombre) AS tipo_inmueble, ";
    $sql.= "IF(X.nombre IS NULL,'',X.nombre) AS tipo_operacion, ";
    $sql.= "IF(U.nombre IS NULL,'',U.nombre) AS usuario, ";
    $sql.= "IF(U.email IS NULL,'',U.email) AS usuario_email, ";
    $sql.= "IF(U.celular IS NULL,'',U.celular) AS usuario_celular, ";
    $sql.= "IF(L.nombre IS NULL,'',L.nombre) AS localidad ";
    $sql.= "FROM inm_propiedades A ";
    $sql.= "INNER JOIN empresas E ON (A.id_empresa = E.id) ";
    $sql.= "LEFT JOIN inm_tipos_estado TE ON (A.id_tipo_estado = TE.id) ";
    $sql.= "LEFT JOIN inm_tipos_inmueble TI ON (A.id_tipo_inmueble = TI.id) ";
    $sql.= "LEFT JOIN inm_tipos_operacion X ON (A.id_tipo_operacion = X.id) ";
    $sql.= "LEFT JOIN clientes P ON (A.id_propietario = P.id AND A.id_empresa = P.id_empresa) ";
    $sql.= "LEFT JOIN com_localidades L ON (A.id_localidad = L.id) ";
    $sql.= "LEFT JOIN com_usuarios U ON (A.id_usuario = U.id AND A.id_empresa = U.id_empresa) ";
    $sql.= "WHERE A.id = $id ";
    $sql.= "AND A.id_empresa = $id_empresa ";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) return array();
    $propiedad = $q->row();

    //Calculamos la cantidad de meses que la propiedad estuvo activa
    $f1 = strtotime($propiedad->fecha_ingreso);
    $f2 = strtotime(date("Y-m-d"));
    $y1 = date('Y', $f1);
    $y2 = date('Y', $f2);
    $m1 = date('m', $f1);
    $m2 = date('m', $f2);
    $propiedad->meses_activa = (($y2 - $y1) * 12) + ($m2 - $m1);
    //Ademas traemos los días que esta activa porque es una buena informacion para tener
    $f1 = new DateTime($propiedad->fecha_ingreso);
    $f2 = new DateTime();
    $propiedad->dias_activa = $f2->diff($f1)->format("%a");
    

    // Obtenemos los propiedades relacionados con ese producto
    $sql = "SELECT A.id, A.nombre, A.path, AR.destacado ";
    $sql.= "FROM inm_propiedades A INNER JOIN inm_propiedades_relacionados AR ON (A.id = AR.id_relacion) ";
    $sql.= "WHERE AR.id_propiedad = $id ";
    $sql.= "ORDER BY AR.orden ASC ";
    $q = $this->db->query($sql);
    $propiedad->relacionados = array();
    foreach($q->result() as $r) {
      $obj = new stdClass();
      $obj->id = $r->id;
      $obj->nombre = $r->nombre;
      $obj->path = $r->path;
      $obj->destacado = $r->destacado;
      $propiedad->relacionados[] = $obj;
    }


    $propiedad->propiedades_relacionadas = $this->obtener_propiedades_similares(array(
      "id"=>$propiedad->id,
      "id_empresa"=>$propiedad->id_empresa,
      "id_localidad"=>$propiedad->id_localidad,
      "id_tipo_inmueble"=>$propiedad->id_tipo_inmueble,
      "id_tipo_operacion"=>$propiedad->id_tipo_operacion,
    ));


    if ($get_data == 1) {
      $visitas_propiedad_array = array();
      $visitas_propiedad_array['id_propiedad'] = $id;
      $visitas_propiedad_array['id_empresa'] = $id_empresa;
      if (!empty($fecha_desde)) $visitas_propiedad_array['fecha_desde'] = $fecha_desde;
      if (!empty($fecha_hasta)) $visitas_propiedad_array['fecha_hasta'] = $fecha_hasta;
      $propiedad->data_graficos = $this->get_visitas_propiedad($visitas_propiedad_array);
    }

    // Obtenemos los departamentos
    $sql = "SELECT * ";
    $sql.= "FROM inm_departamentos ";
    $sql.= "WHERE id_propiedad = $id AND id_empresa = $propiedad->id_empresa ";
    $sql.= "ORDER BY orden ASC, piso ASC ";
    $q = $this->db->query($sql);
    $propiedad->departamentos = array();
    foreach($q->result() as $r) {
      // Obtenemos las imagenes
      $sql = "SELECT path FROM inm_departamentos_images ";
      $sql.= "WHERE id_empresa = $propiedad->id_empresa ";
      $sql.= "AND id_propiedad = $propiedad->id ";
      $sql.= "AND id_departamento = $r->id ";
      $qq = $this->db->query($sql);
      $r->images_dptos = array();
      foreach($qq->result() as $rr) $r->images_dptos[] = $rr->path;
      $propiedad->departamentos[] = $r;
    }

    // Obtenemos los gastos
    $sql = "SELECT * ";
    $sql.= "FROM inm_propiedades_gastos ";
    $sql.= "WHERE id_propiedad = $id AND id_empresa = $propiedad->id_empresa ";
    $q = $this->db->query($sql);
    $propiedad->gastos = array();
    foreach($q->result() as $r) {
      $propiedad->gastos[] = $r;
    }

    // Obtenemos las permutas
    $sql = "SELECT P.*, IF(I.nombre IS NULL, '', I.nombre) as inmueble_nombre, ";
    $sql.= "IF (L.nombre IS NULL, '', L.nombre) as localidad_nombre ";
    $sql.= "FROM inm_propiedades_permutas P ";
    $sql.= "LEFT JOIN com_localidades L ON (L.id = P.id_localidad) ";
    $sql.= "LEFT JOIN inm_tipos_inmueble I ON (I.id = P.id_tipo_inmueble) ";
    $sql.= "WHERE P.id_propiedad = $id AND P.id_empresa = $propiedad->id_empresa ";
    $q = $this->db->query($sql);
    $propiedad->permutas = array();
    foreach($q->result() as $r) {
      $propiedad->permutas[] = $r;
    }

    // Obtenemos las imagenes de ese propiedad
    $sql = "SELECT AI.* FROM inm_propiedades_images_meli AI ";
    $sql.= "WHERE AI.id_propiedad = $id AND AI.id_empresa = $id_empresa ";
    $sql.= "ORDER BY AI.orden ASC";
    $q = $this->db->query($sql);
    $propiedad->images_meli = array();
    foreach($q->result() as $r) {
      $propiedad->images_meli[] = $r->path;
    }

    // TODO: CAMBIAR EL ID POR ID_INMOBUSQUEDA, Y HACER UN ID AUTOINCREMENTABLE
    $propiedad->id_barrio_argenprop = 0;
    $propiedad->id_barrio_inmobusqueda = 0;
    if (!empty($propiedad->id_barrio)) {
      $sql = "SELECT * FROM com_barrios WHERE id = $propiedad->id_barrio ";
      $q = $this->db->query($sql);
      if ($q->num_rows() > 0) {
        $barrio = $q->row();
        $propiedad->id_barrio_argenprop = $barrio->id_argenprop;
        $propiedad->id_barrio_inmobusqueda = $barrio->id;
      }
    }

    // Obtenemos los precios
    $this->load->helper("fecha_helper");
    $propiedad->temporada = array();
    $propiedad->promociones = array();
    $sql = "SELECT AI.* FROM inm_propiedades_precios AI WHERE AI.id_propiedad = $id AND AI.id_empresa = $id_empresa ORDER BY AI.id ASC";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
      $r->fecha_desde = fecha_es($r->fecha_desde);
      $r->fecha_hasta = fecha_es($r->fecha_hasta);
      if ($r->promocion == 0) {
        $propiedad->temporada[] = $r;
      } else if ($r->promocion == 1) {
        $propiedad->promociones[] = $r;
      }
    }

    $sql = "SELECT AI.* FROM inm_propiedades_impuestos AI WHERE AI.id_propiedad = $id AND AI.id_empresa = $id_empresa ORDER BY AI.orden ASC";
    $q = $this->db->query($sql);
    $propiedad->impuestos = ($q->num_rows()>0) ? $q->result() : array();

    /*
    // Obtenemos las categorias relacionados con ese producto
    $sql = "SELECT R.id, R.nombre ";
    $sql.= "FROM rubros R INNER JOIN inm_propiedades_relacionados AR ON (R.id = AR.id_rubro) ";
    $sql.= "WHERE AR.id_propiedad = $id ";
    $sql.= "ORDER BY AR.orden ASC ";
    $q = $this->db->query($sql);
    $propiedad->rubros_relacionados = array();
    foreach($q->result() as $r) {
      $obj = new stdClass();
      $obj->id = $r->id;
      $obj->nombre = $r->nombre;
      $propiedad->rubros_relacionados[] = $obj;
    }
    */
    
    // Obtenemos las imagenes de ese propiedad
    $sql = "SELECT AI.* FROM inm_propiedades_images AI ";
    $sql.= "WHERE AI.id_propiedad = $id AND AI.id_empresa = $id_empresa ORDER BY AI.orden ASC";
    $q = $this->db->query($sql);
    $propiedad->images = array();
    $propiedad->planos = array();
    foreach($q->result() as $r) {
      if ($r->plano == 1) $propiedad->planos[] = $r->path;
      else $propiedad->images[] = $r->path;
    }

    // Buscamos si el propiedad esta compartido en MERCADOLIBRE
    $propiedad_meli = $this->get_propiedad_meli($id,array(
      "id_empresa"=>$id_empresa,
    ));
    if ($propiedad_meli !== FALSE) {
      $propiedad->id_meli = $propiedad_meli->id_meli;
      $propiedad->permalink = $propiedad_meli->permalink;
      $propiedad->fecha_publicacion = $propiedad_meli->fecha_publicacion;
      $propiedad->titulo_meli = $propiedad_meli->titulo_meli;
      $propiedad->texto_meli = $propiedad_meli->texto_meli;
      $propiedad->precio_meli = $propiedad_meli->precio_meli;
      $propiedad->categoria_meli = $propiedad_meli->categoria_meli;
      $propiedad->activo_meli = $propiedad_meli->activo_meli;
      $propiedad->list_type_id = $propiedad_meli->list_type_id;
      $propiedad->ciudad_meli = $propiedad_meli->ciudad_meli;
      $propiedad->status = $propiedad_meli->status;

    } else {

      $sql = "SELECT ml_texto_empresa FROM web_configuracion WHERE id_empresa = $id_empresa LIMIT 0,1";
      $qw = $this->db->query($sql);
      $web_conf = $qw->row();

      $propiedad->id_meli = "";
      $propiedad->permalink = "";
      //$propiedad->fecha_publicacion = "";
      $propiedad->titulo_meli = $propiedad->nombre;
      $propiedad->texto_meli = strip_tags($propiedad->texto)."\n\n".$web_conf->ml_texto_empresa;
      $propiedad->precio_meli = $propiedad->precio_final;
      $propiedad->categoria_meli = "";
      $propiedad->activo_meli = -1; // Todavia no fue compartido
      $propiedad->list_type_id = 0;
      $propiedad->ciudad_meli = "";
      $propiedad->status = "";
    }

    $propiedad->titulo = ($propiedad->id_empresa != 1575) ? $this->generar_titulo($propiedad) : $propiedad->nombre;

    $propiedad->direccion_completa = $propiedad->calle.(!empty($propiedad->entre_calles) ? " e/ ".$propiedad->entre_calles.(!empty($propiedad->entre_calles_2) ? " y ".$propiedad->entre_calles_2 : "") : "");
    $propiedad->direccion_completa.= (($propiedad->publica_altura == 1)?" N° ".$propiedad->altura:"") . (!empty($propiedad->piso) ? " Piso ".$propiedad->piso : "") . (!empty($propiedad->numero) ? " Depto. ".$propiedad->numero : "");

    $propiedad->direccion_completa_red = $propiedad->calle.(!empty($propiedad->entre_calles) ? " e/ ".$propiedad->entre_calles.(!empty($propiedad->entre_calles_2) ? " y ".$propiedad->entre_calles_2 : "") : "");

    $propiedad->usuario_celular =  preg_replace("/[^0-9]/", "", $propiedad->usuario_celular);

    // Formamos el precio (si se debe mostrar o no)
    if ($propiedad->publica_precio == 1) {
      $propiedad->precio = $propiedad->moneda." ".number_format($propiedad->precio_final,0,"",".");
    } else {
      $propiedad->precio = "Consultar";
    }    

    $propiedad->bloqueado_web = 0;
    if ($propiedad->id_empresa != $id_empresa_original) {
      $propiedad->permiso_web = 0;

      // Controlamos si la otra inmobiliaria nos dio permiso
      $sql = "SELECT permiso_web FROM inm_permisos_red ";
      $sql.= "WHERE id_empresa = $propiedad->id_empresa ";
      $sql.= "AND id_empresa_compartida = $id_empresa_original ";
      $sql.= "AND solicitud_permiso = 0 ";
      $sql.= "AND bloqueado = 0 ";
      $propiedad->sql = $sql;
      $qqq = $this->db->query($sql);
      if ($qqq->num_rows() > 0) {
        $rrr = $qqq->row();
        $propiedad->permiso_web = $rrr->permiso_web;
      }

      // Controlamos si tenemos bloqueada a la propiedad
      $sql = "SELECT 1 FROM inm_propiedades_bloqueadas ";
      $sql.= "WHERE id_empresa = $id_empresa_original ";
      $sql.= "AND id_propiedad = $propiedad->id ";
      $sql.= "AND id_empresa_propiedad = $propiedad->id_empresa ";
      $qqq = $this->db->query($sql);
      if ($qqq->num_rows() > 0) $propiedad->bloqueado_web = 1;
    } else {
      $propiedad->permiso_web = 1;
    }


    $propiedad->pronto_a_vencer = 0;

    if (!empty($propiedad->fecha_vencimiento) && $propiedad->fecha_vencimiento != "0000-00-00") {  

      $datediff = strtotime($propiedad->fecha_vencimiento) - strtotime($hoy);
      $dias_para_vencimiento = round($datediff / (60 * 60 * 24));

      if ($dias_para_vencimiento >= 1 && $dias_para_vencimiento <= 31) {
        $propiedad->pronto_a_vencer = 1;
      } else if ($dias_para_vencimiento <= 0) {
        $propiedad->pronto_a_vencer = 2;
      }

    }

    return $propiedad;
  }
  
  // Generamos un titulo de acuerdo a los parametros
  function generar_titulo($r) {
    $s = "";
    $s.= $r->tipo_inmueble." en ".$r->tipo_operacion;
    if (!empty($r->localidad)) $s.= " en ".$r->localidad;
    if (!empty($r->codigo_completo)) $s.=" [Cod: $r->codigo_completo]";
    return $s; 
  }
  
  
  function get_by_hash($hash) {
    
    // Obtenemos los datos del propiedad
    $sql = "SELECT A.* ";
    $sql.= "FROM inm_propiedades A ";
    $sql.= "WHERE A.hash = '$hash' ";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) return array();
    $p = $q->row();
    $propiedad = $this->get($p->id,array(
      "id_empresa"=>$p->id_empresa
    ));
    return $propiedad;
  }
  
  function get_by_id($id,$config = array()) {
    $id_empresa = (isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa());
    // Obtenemos los datos del propiedad
    $id = (int)$id;
    $sql = "SELECT A.*, ";
    $sql.= "IF(P.nombre IS NULL,'',P.nombre) AS propietario, ";
    $sql.= "IF(TE.nombre IS NULL,'',TE.nombre) AS tipo_estado, ";
    $sql.= "IF(TI.nombre IS NULL,'',TI.nombre) AS tipo_inmueble, ";
    $sql.= "IF(X.nombre IS NULL,'',X.nombre) AS tipo_operacion, ";
    $sql.= "IF(L.nombre IS NULL,'',L.nombre) AS localidad ";
    $sql.= "FROM inm_propiedades A ";
    $sql.= "LEFT JOIN inm_tipos_estado TE ON (A.id_tipo_estado = TE.id) ";
    $sql.= "LEFT JOIN inm_tipos_inmueble TI ON (A.id_tipo_inmueble = TI.id) ";
    $sql.= "LEFT JOIN inm_tipos_operacion X ON (A.id_tipo_operacion = X.id) ";
    $sql.= "LEFT JOIN clientes P ON (A.id_propietario = P.id AND A.id_empresa = P.id_empresa) ";
    $sql.= "LEFT JOIN com_localidades L ON (A.id_localidad = L.id) ";
    $sql.= "WHERE A.id = '$id' AND A.id_empresa = '$id_empresa' ";
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
      $propiedad = $q->row();      
    } else {
      $propiedad = FALSE;
    }
    return $propiedad;
  }
  
  function get_by_codigo($codigo,$config = array()) {
    $id_empresa = (isset($config["id_empresa"])) ? $config["id_empresa"] : parent::get_empresa();
    // Obtenemos los datos del propiedad
    $codigo = (int)$codigo;
    $sql = "SELECT A.*, ";
    $sql.= "IF(P.nombre IS NULL,'',P.nombre) AS propietario, ";
    $sql.= "IF(TE.nombre IS NULL,'',TE.nombre) AS tipo_estado, ";
    $sql.= "IF(TI.nombre IS NULL,'',TI.nombre) AS tipo_inmueble, ";
    $sql.= "IF(X.nombre IS NULL,'',X.nombre) AS tipo_operacion, ";
    $sql.= "IF(L.nombre IS NULL,'',L.nombre) AS localidad ";
    $sql.= "FROM inm_propiedades A ";
    $sql.= "LEFT JOIN inm_tipos_estado TE ON (A.id_tipo_estado = TE.id) ";
    $sql.= "LEFT JOIN inm_tipos_inmueble TI ON (A.id_tipo_inmueble = TI.id) ";
    $sql.= "LEFT JOIN inm_tipos_operacion X ON (A.id_tipo_operacion = X.id) ";
    $sql.= "LEFT JOIN clientes P ON (A.id_propietario = P.id AND A.id_empresa = P.id_empresa) ";
    $sql.= "LEFT JOIN com_localidades L ON (A.id_localidad = L.id) ";
    $sql.= "WHERE A.codigo = '$codigo' AND A.id_empresa = '$id_empresa' ";
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
      $propiedad = $q->row();      
    } else {
      $propiedad = FALSE;
    }
    return $propiedad;
  }
  
  function delete($id) {
    // Controlamos que se este borrando un propiedad que pertenece a la empresa de la session
    $id_empresa = parent::get_empresa();
    if ($id_empresa === FALSE) return;
    $q = $this->db->query("SELECT * FROM inm_propiedades WHERE id = $id AND id_empresa = $id_empresa ");
    if ($q->num_rows()>0) {
      $this->db->query("DELETE FROM inm_propiedades_gastos WHERE id_propiedad = $id AND id_empresa = $id_empresa");
      $this->db->query("DELETE FROM inm_propiedades_impuestos WHERE id_propiedad = $id AND id_empresa = $id_empresa");
      $this->db->query("DELETE FROM inm_propiedades_precios WHERE id_propiedad = $id AND id_empresa = $id_empresa");
      $this->db->query("DELETE FROM inm_departamentos WHERE id_propiedad = $id AND id_empresa = $id_empresa");
      $this->db->query("DELETE FROM inm_departamentos_images WHERE id_propiedad = $id AND id_empresa = $id_empresa");
      $this->db->query("DELETE FROM inm_propiedades_relacionados WHERE id_propiedad = $id ");
      $this->db->query("DELETE FROM inm_propiedades_images WHERE id_propiedad = $id AND id_empresa = $id_empresa");
      $this->db->query("DELETE FROM inm_propiedades_images_meli WHERE id_propiedad = $id AND id_empresa = $id_empresa");
      $this->db->query("DELETE FROM inm_propiedades_meli WHERE id_propiedad = $id AND id_empresa = $id_empresa ");
      $this->db->query("DELETE FROM inm_propiedades WHERE id = $id AND id_empresa = $id_empresa");
    }
  }

  function get_dolar(){
    $sql_cot = 'SELECT * FROM cotizaciones WHERE moneda = "U$D" ORDER BY fecha DESC LIMIT 0,1 ';
    $q = $this->db->query($sql_cot);
    $q = $q->row();
    
    return $q->valor;
  }

  function importar_inmobusqueda($config = array()) {

    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $link = isset($config["link"]) ? $config["link"] : "";
    $id_propiedad = isset($config["id_propiedad"]) ? $config["id_propiedad"] : 0;
    $errores = array();
    $this->load->helper("file_helper");
    $this->load->helper("fecha_helper");  
    $this->load->model("Log_Model");  

    $link = str_replace("https://www.inmobusqueda.com.ar/ficha-", "", $link);
    $link = str_replace("http://www.inmobusqueda.com.ar/ficha-", "", $link);
    $link = str_replace("../importar/inmobusqueda/cache/", "", $link);
    $link = str_replace(".txt", "", $link);
    $link_inmobusqueda = $link;
    $link = "http://www.inmobusqueda.com.ar/ficha-".$link;    

    $propiedad = new stdClass();
    $propiedad->id = 0;
    $es_nueva = TRUE;
    $obtener_link = true;
    // Consultamos si ya existe alguna propiedad con ese link, para setearle el ID
    $sql = "SELECT * FROM inm_propiedades WHERE id_empresa = $id_empresa ";
    if (!empty($id_propiedad)) $sql.= "AND id = $id_propiedad ";
    else $sql.= " AND inmobusquedas_url = '$link' ";
    $q = $this->db->query($sql);
    if ($q->num_rows() > 0) {
      $r = $q->row();
      $propiedad = $r;
      $es_nueva = FALSE;

      // Controlamos si se bajo el archivo el dia de hoy
      // esto se hace por si hay algun error, se corrije y no volverlo a bajar
      $f = "logs/$id_empresa/ib_".$propiedad->id.".txt";
      if (file_exists($f)) {
        $time = filemtime($f);
        if (date("Y-m-d",$time) == date("Y-m-d")) {
          $html = file_get_contents($f);
          $obtener_link = false;
        }
      }
    }

    $f = "logs/$id_empresa/ib_".$link_inmobusqueda.".txt";
    if (file_exists($f)) {
      $time = filemtime($f);
      if (date("Y-m-d",$time) == date("Y-m-d")) {
        $html = file_get_contents($f);
        $obtener_link = false;
      }      
    }

    if ($obtener_link) {
      $c = curl_init();
      curl_setopt_array($c, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_USERAGENT =>'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36',
      ));
      $html = curl_exec($c);
      curl_close($c);
      if (strpos($html, "Bot no autorizado") !== FALSE) {
        return array(
          "errores"=>array("Bot no autorizado view-source:$link | ".$link_inmobusqueda),
        );
      }
    }

    $propiedad->id_empresa = $id_empresa;
    $propiedad->inmobusquedas_habilitado = 0;
    $propiedad->inmobusquedas_url = $link;
    $errores = array();
    $imagenes = array();
    $propiedad->latitud = 0;
    $propiedad->longitud = 0;
    $propiedad->zoom = 16;

    // Procesamos las lineas del archivo para encontrar la latitud y longitud
    $lineas = explode("\n", $html);
    foreach($lineas as $l) {
      if (strpos($l, "center: [") !== FALSE) {
        $l = str_replace("center: [", "", $l);
        $l = str_replace("],", "", $l);
        $pos = explode(", ", $l);
        $propiedad->latitud = trim($pos[0]);
        $propiedad->longitud = trim($pos[1]);
        break;
      }
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $finder = new DomXPath($dom);

    // Buscamos las fotos
    $nodes = $finder->query("//div[@id='listadoFo3tos']//a");
    foreach ($nodes as $node) {
      $imagen = $node->getAttribute("href");
      $cc = explode("/", $imagen);
      $filename = end($cc);
      if (!file_exists("uploads/$id_empresa")) @mkdir("uploads/$id_empresa");
      if (!file_exists("uploads/$id_empresa/propiedades")) @mkdir("uploads/$id_empresa/propiedades");
      $path = "uploads/$id_empresa/propiedades/$filename";
      if (!file_exists($path)) grab_image($imagen,$path);
      $imagenes[] = $path;
    }

    $propiedad->path = (sizeof($imagenes)>0) ? $imagenes[0] : "";
    $propiedad->nombre = "";
    $propiedad->superficie_total = "";
    $propiedad->calle = "";
    $propiedad->altura = "";
    $propiedad->piso = "";
    $propiedad->numero = "";
    $propiedad->precio_final = "";
    $propiedad->ciudad = "";

    // Buscamos el nombre
    $nodes = $finder->query("//div[contains(@class, 'nombresobreslide')]");
    foreach ($nodes as $node) {
      $i=0;
      foreach($node->childNodes as $c) {
        if ($i==0) $propiedad->nombre = trim($c->textContent);
        else if ($i==1) $propiedad->superficie_total = trim($c->textContent);
        else if ($i==3) {
          // Direccion y precio
          $j = 0;
          if ($c->hasChildNodes()) {
            foreach($c->childNodes as $cc) {
              if ($j == 0) $propiedad->calle = trim($cc->textContent);
              else if ($j == 2) $propiedad->precio_final = trim($cc->textContent);
              $j++;
            }
          }
        } else if ($i==5) {
          // Ciudad
          $propiedad->ciudad = $c->textContent;
        }
        $i++;
      }
    }
    if (empty($propiedad->calle)) $errores[] = "No se encontro calle [$link]";

    $propiedad->atributos = array();

    $nodes = $finder->query("//*[contains(@class, 'detalleizquierda')]");
    foreach ($nodes as $node) {
      $propiedad->atributos[] = array(
        "propiedad"=>$node->textContent,
      );
      $node->parentNode->removeChild($node);
    }

    $nodes = $finder->query("//*[contains(@class, 'detallederecha')]");
    $i=0;
    foreach ($nodes as $node) {
      $propiedad->atributos[$i]["valor"] = $node->textContent;
      $node->parentNode->removeChild($node);
      $i++;
    }

    $nodes = $finder->query("//*[contains(@class, 'descripcion')]");
    $i=0;
    $propiedad->texto = "";
    foreach ($nodes as $node) {
      if ($i==1) { 
        foreach($node->childNodes as $c) {
          if ($c->nodeName == "#text") $propiedad->texto.= $c->textContent; 
        }
        break;
      }
      $i++;
    }
    $propiedad->texto = trim($propiedad->texto);

    // Si el titulo tiene la palabra Venta
    if (strpos($propiedad->nombre, "Venta")>0) {
      $propiedad->id_tipo_operacion = 1;
      // Por defecto compartimos
      $propiedad->compartida = 2;
    } else {
      $propiedad->id_tipo_operacion = 2;
      $propiedad->compartida = 0;
    }

    // Dependiendo de las palabras clave del titulo
    $propiedad->id_tipo_inmueble = 0;
    if (strpos($propiedad->nombre, "Casa") !== FALSE) {
      $propiedad->id_tipo_inmueble = 1;
    } else if (strpos($propiedad->nombre, "Departamento") !== FALSE) {
      $propiedad->id_tipo_inmueble = 2;
    } else if (strpos($propiedad->nombre, "PH") !== FALSE) {
      $propiedad->id_tipo_inmueble = 3;
    } else if (strpos($propiedad->nombre, "Lote") !== FALSE) {
      $propiedad->id_tipo_inmueble = 7;
    } else if (strpos($propiedad->nombre, "Campo") !== FALSE) {
      $propiedad->id_tipo_inmueble = 6;
    } else if (strpos($propiedad->nombre, "Terreno") !== FALSE) {
      $propiedad->id_tipo_inmueble = 7;
    } else if (strpos($propiedad->nombre, "Galpon") !== FALSE || strpos($propiedad->nombre, "Galpón") !== FALSE) {
      $propiedad->id_tipo_inmueble = 8;
    } else if (strpos($propiedad->nombre, "Local") !== FALSE) {
      $propiedad->id_tipo_inmueble = 9;
    } else if (strpos($propiedad->nombre, "Oficina") !== FALSE) {
      $propiedad->id_tipo_inmueble = 11;
    } else if (strpos($propiedad->nombre, "Countries") !== FALSE) {
      $propiedad->id_tipo_inmueble = 4;
    } else if (strpos($propiedad->nombre, "Piso") !== FALSE) {
      $propiedad->id_tipo_inmueble = 17;
    } else if (strpos($propiedad->nombre, "Cochera") !== FALSE) {
      $propiedad->id_tipo_inmueble = 13;
    } else if (strpos($propiedad->nombre, "Monoambiente") !== FALSE) {
      $propiedad->id_tipo_inmueble = 2;
    } else if (strpos($propiedad->nombre, "Edificio") !== FALSE) {
      $propiedad->id_tipo_inmueble = 2;
    } else if (strpos($propiedad->nombre, "Deposito") !== FALSE || strpos($propiedad->nombre, "Depósito") !== FALSE) {
      $propiedad->id_tipo_inmueble = 18;
    } else if (strpos($propiedad->nombre, "Duplex") !== FALSE || strpos($propiedad->nombre, "Dúplex") !== FALSE) {
      $propiedad->id_tipo_inmueble = 15;
    } else if (strpos(mb_strtolower($propiedad->nombre), "fondo de comercio") !== FALSE) {
      $propiedad->id_tipo_inmueble = 10;
    } else if (strpos(mb_strtolower($propiedad->nombre), "fracciones") !== FALSE) {
      $propiedad->id_tipo_inmueble = 25;
    } else if (strpos(mb_strtolower($propiedad->nombre), "hotel") !== FALSE) {
      $propiedad->id_tipo_inmueble = 24;
    } else if (strpos(mb_strtolower($propiedad->nombre), "haras") !== FALSE) {
      $propiedad->id_tipo_inmueble = 26;
    } else {
      $errores[] = "Tipo de inmueble no encontrado [$link]";
    }

    // Acomodamos el precio y la moneda
    $propiedad->moneda = '$';
    $propiedad->publica_precio = 1;
    if (strpos($propiedad->precio_final, 'u$d') !== FALSE) {
      $propiedad->moneda = 'U$S';
      $propiedad->precio_final = str_replace('u$d', '', $propiedad->precio_final);
    } else if (strpos($propiedad->precio_final, "Consulte") !== FALSE) {
      $propiedad->publica_precio = 0;
      $propiedad->precio_final = 0;
    }
    $propiedad->precio_final = str_replace("$", "", $propiedad->precio_final);
    $propiedad->precio_final = str_replace(".", "", $propiedad->precio_final);
    $precio = explode(" ", $propiedad->precio_final);
    $propiedad->precio_final = $precio[0];

    // La superficie total puede tener la cantidad de dormitorios tmb
    $subtitulo = explode("   ", $propiedad->superficie_total);
    $propiedad->dormitorios = "";
    if (sizeof($subtitulo)>1) {
      $propiedad->dormitorios = $subtitulo[0];
      $propiedad->dormitorios = str_replace(" Dorm", "", $propiedad->dormitorios);
      $propiedad->superficie_total = $subtitulo[1];
      $propiedad->superficie_total = str_replace(" mts", "", $propiedad->superficie_total);
      $propiedad->superficie_total = str_replace(",", ".", $propiedad->superficie_total);
    }

    $propiedad->activo = 1;
    $propiedad->id_tipo_estado = 1; // Por defecto todas activas
    $propiedad->fecha_ingreso = date("Y-m-d");

    // Analizamos la ciudad
    $propiedad->id_localidad = 0;
    $propiedad->id_departamento = 0;
    $propiedad->ciudad = mb_strtolower($propiedad->ciudad);
    if (strpos($propiedad->ciudad, "casco urbano") !== FALSE) {
      $propiedad->id_localidad = 513;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "romero") !== FALSE) {
      $propiedad->id_localidad = 791;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "ringuelet") !== FALSE) {
      $propiedad->id_localidad = 776;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "san lorenzo") !== FALSE) {
      $propiedad->id_localidad = 5503;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "villa elvira") !== FALSE) {
      $propiedad->id_localidad = 5117;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "berisso") !== FALSE) {
      $propiedad->id_localidad = 5492;
      $propiedad->id_departamento = 66;
    } else if (strpos($propiedad->ciudad, "gonnet") !== FALSE) {
      $propiedad->id_localidad = 396;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "hernández") !== FALSE) {
      $propiedad->id_localidad = 425;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "ensenada") !== FALSE) {
      $propiedad->id_localidad = 312;
      $propiedad->id_departamento = 117;
    } else if (strpos($propiedad->ciudad, "gorina") !== FALSE) {
      $propiedad->id_localidad = 401;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "elisa") !== FALSE) {
      $propiedad->id_localidad = 946;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "san carlos") !== FALSE) {
      $propiedad->id_localidad = 5505;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "tolosa") !== FALSE) {
      $propiedad->id_localidad = 900;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "etcheverry") !== FALSE) {
      $propiedad->id_localidad = 326;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "berazategui") !== FALSE) {
      $propiedad->id_localidad = 122;
      $propiedad->id_departamento = 73;
    } else if (strpos($propiedad->ciudad, "el retiro") !== FALSE) {
      $propiedad->id_localidad = 1624;
      $propiedad->id_departamento = 207;
    } else if (strpos($propiedad->ciudad, "city bell") !== FALSE) {
      $propiedad->id_localidad = 205;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "pinamar") !== FALSE) {
      $propiedad->id_localidad = 725;
      $propiedad->id_departamento = 712;
    } else if (strpos($propiedad->ciudad, "mar del plata") !== FALSE) {
      $propiedad->id_localidad = 600;
      $propiedad->id_departamento = 84;
    } else if (strpos($propiedad->ciudad, "correas") !== FALSE) {
      $propiedad->id_localidad = 244;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "abasto") !== FALSE) {
      $propiedad->id_localidad = 10;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "arana") !== FALSE) {
      $propiedad->id_localidad = 56;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "olmos") !== FALSE) {
      $propiedad->id_localidad = 674;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "garibaldi") !== FALSE) {
      $propiedad->id_localidad = 948;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "el peligro") !== FALSE) {
      $propiedad->id_localidad = 5502;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "hornos") !== FALSE) {
      $propiedad->id_localidad = 5504;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "altos de san lorenzo") !== FALSE) {
      $propiedad->id_localidad = 5503;
      $propiedad->id_departamento = 9;
    } else if (strpos($propiedad->ciudad, "hermosura") !== FALSE) {
      $propiedad->id_localidad = 5506;
      $propiedad->id_departamento = 9;
    } else if (strpos(strtolower($propiedad->ciudad), "mar del plata") !== FALSE) {
      $propiedad->id_localidad = 600;
      $propiedad->id_departamento = 84;
    } else if (strpos(strtolower($propiedad->ciudad), "magdalena") !== FALSE) {
      $propiedad->id_localidad = 591;
      $propiedad->id_departamento = 36;
    } else if (strpos(strtolower($propiedad->ciudad), "punta indio") !== FALSE) {
      $propiedad->id_localidad = 752;
      $propiedad->id_departamento = 36;
    } else if (strpos(strtolower($propiedad->ciudad), "haras del sur") !== FALSE) {
      $propiedad->id_localidad = 513;
      $propiedad->id_departamento = 9;
    } else if (strpos(strtolower($propiedad->ciudad), "villa gesell") !== FALSE) {
      $propiedad->id_localidad = 951;
      $propiedad->id_departamento = 713;
    } else if (strpos(strtolower($propiedad->ciudad), "chascomus") !== FALSE) {
      $propiedad->id_localidad = 197;
      $propiedad->id_departamento = 15;
    } else if (strpos(strtolower($propiedad->ciudad), "general belgrano") !== FALSE) {
      $propiedad->id_localidad = 360;
      $propiedad->id_departamento = 97;
    } else if (strpos(strtolower($propiedad->ciudad), "san rafael") !== FALSE) {
      $propiedad->id_localidad = 3331;
      $propiedad->id_departamento = 355;
    } else if (strpos(strtolower($propiedad->ciudad), "punta indio") !== FALSE) {
      $propiedad->id_localidad = 752;
      $propiedad->id_departamento = 36;
    } else if (strpos(strtolower($propiedad->ciudad), "los cocos") !== FALSE) {
      $propiedad->id_localidad = 1829;
      $propiedad->id_departamento = 207;
    } else if (strpos(strtolower($propiedad->ciudad), "veronica") !== FALSE) {
      $propiedad->id_localidad = 928;
      $propiedad->id_departamento = 36;
    } else if (strpos(strtolower($propiedad->ciudad), "miralagos club de campo") !== FALSE) {
      $propiedad->id_localidad = 513;
      $propiedad->id_departamento = 9;
    } else if (strpos(strtolower($propiedad->ciudad), "san bernardo") !== FALSE) {
      $propiedad->id_localidad = 5509;
      $propiedad->id_departamento = 711;
    } else if (strpos(strtolower($propiedad->ciudad), "nueva atlantis") !== FALSE) {
      $propiedad->id_localidad = 5509;
      $propiedad->id_departamento = 711;
    } else if (strpos(strtolower($propiedad->ciudad), "posada de los lagos") !== FALSE) {
      $propiedad->id_localidad = 231;
      $propiedad->id_departamento = 32;
    } else if (strpos(strtolower($propiedad->ciudad), "guardia del monte") !== FALSE) {
      $propiedad->id_localidad = 835;
      $propiedad->id_departamento = 92;
    } else if (strpos(strtolower($propiedad->ciudad), "puerto madero") !== FALSE) {
      $propiedad->id_localidad = 5440;
      $propiedad->id_departamento = 574;
      $propiedad->id_barrio = 97;
    } else if (strpos(strtolower($propiedad->ciudad), "nuñez") !== FALSE) {
      $propiedad->id_localidad = 5440;
      $propiedad->id_departamento = 574;
      $propiedad->id_barrio = 66;
    } else {
      // Sino buscamos por nombre
      // En inmobusqueda, el nombre de la localidad esta como primera posicion hasta la coma
      $ciudad = mb_strtolower($propiedad->ciudad);
      $localidad = explode(",", $ciudad);
      $localidad = (sizeof($localidad)>0) ? $localidad[0] : $ciudad;
      $localidad = trim($localidad);
      $sql = "SELECT L.*, D.id_provincia, D.id AS id_departamento, P.id_pais ";
      $sql.= " FROM com_localidades L ";
      $sql.= " INNER JOIN com_departamentos D ON (L.id_departamento = D.id) ";
      $sql.= " INNER JOIN com_provincias P ON (D.id_provincia = P.id) ";
      $sql.= "WHERE L.nombre LIKE '%$localidad%' LIMIT 0,1 ";
      $qq = $this->db->query($sql);
      if ($qq->num_rows() > 0) {
        $rr = $qq->row();
        $propiedad->id_localidad = $rr->id;
        $propiedad->id_departamento = $rr->id_departamento;
        $propiedad->id_provincia = $rr->id_provincia;
        $propiedad->id_pais = $rr->id_pais;
      } else {
        $errores[] = "Localidad no encontrada [$ciudad] [$link]";
      }
    }

    // Analizamos algunos atributos mas
    $propiedad->banios = 0;
    $propiedad->cocheras = 0;
    $propiedad->servicios_cloacas = 0;
    $propiedad->servicios_agua_corriente = 0;
    $propiedad->servicios_asfalto = 0;
    $propiedad->servicios_electricidad = 0;
    $propiedad->servicios_telefono = 0;
    $propiedad->servicios_cable = 0;
    $propiedad->superficie_cubierta = 0;
    $propiedad->ambientes = 0;

    foreach($propiedad->atributos as $atributo) {
      if ($atributo["propiedad"] == "Baños") {
        $propiedad->banios = $atributo["valor"];
      } else if ($atributo["propiedad"] == "Garage") {
        if ($atributo["valor"] == "Si" || strlen($atributo["valor"])>2) $propiedad->cocheras = 1;
      } else if ($atributo["propiedad"] == "Cloacas") {
        if ($atributo["valor"] == "Si") $propiedad->servicios_cloacas = 1;
      } else if ($atributo["propiedad"] == "Agua") {
        if ($atributo["valor"] == "Si") $propiedad->servicios_agua_corriente = 1;
      } else if ($atributo["propiedad"] == "Asfalto") {
        if ($atributo["valor"] == "Si") $propiedad->servicios_asfalto = 1;
      } else if ($atributo["propiedad"] == "Energia") {
        if ($atributo["valor"] == "Si") $propiedad->servicios_electricidad = 1;
      } else if ($atributo["propiedad"] == "Teléfono") {
        if ($atributo["valor"] == "Si") $propiedad->servicios_telefono = 1;
      } else if ($atributo["propiedad"] == "Cable") {
        if ($atributo["valor"] == "Si") $propiedad->servicios_cable = 1;
      } else if ($atributo["propiedad"] == "Superficie Construida") {
        $s = explode(" ", $atributo["valor"]);
        $propiedad->superficie_cubierta = $s[0];
      } else if ($atributo["propiedad"] == "Ambientes") {
        $propiedad->ambientes = (($atributo["valor"] == "-") ? 0 : $atributo["valor"]);
      }
    }
  
    // INSERTAMOS EL OBJETO
    $id_propiedad = $this->save($propiedad);
    $hash = md5($id_propiedad.$propiedad->id_empresa);

    // Actualizamos el link
    $propiedad->link = "propiedad/".filename($propiedad->nombre,"-",0)."-".$id_propiedad."/";
    $this->db->query("UPDATE inm_propiedades SET link = '$propiedad->link', hash='$hash' WHERE id = $id_propiedad AND id_empresa = $id_empresa");

    // Controlamos si tenemos que traer o no las fotos
    $this->load->model("Web_Configuracion_Model");
    $web_conf = $this->Web_Configuracion_Model->get($propiedad->id_empresa);
    if ($web_conf->inmobusqueda_diario_fotos == 0 || $es_nueva) {
      // INSERTAMOS LAS IMAGENES
      $k=0;
      $this->db->query("DELETE FROM inm_propiedades_images WHERE id_empresa = $id_empresa AND id_propiedad = $id_propiedad ");
      foreach($imagenes as $im) {
        $sql = "INSERT INTO inm_propiedades_images (id_empresa,id_propiedad,path,orden,plano) VALUES($id_empresa,$id_propiedad,'$im',$k,0)";
        $this->db->query($sql);
        $k++;
        $this->Log_Model->imprimir(array(
          "id_empresa"=>$id_empresa,
          "file"=>"ib_log.txt",
          "texto"=>$sql,
        ));
      }
    }

    $this->Log_Model->imprimir(array(
      "id_empresa"=>$id_empresa,
      "file"=>"ib_".$id_propiedad.".txt",
      "texto"=>$html,
      "append"=>0, // Para que reemplace los archivos
      "fecha"=>"", // Para que no ponga la fecha al principio
    ));

    return array(
      "errores"=>$errores,
    );
  }

  function compartir_argenprop($config = array()) {

    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    $id_propiedad = isset($config["id_propiedad"]) ? $config["id_propiedad"] : 0;
    $this->load->model("Log_Model");

    $propiedad = $this->get($id_propiedad,array(
      "id_empresa"=>$id_empresa
    ));
    if (empty($propiedad)) {
      return array(
        "error"=>1,
        "mensaje"=>"No se encuentra la propiedad con ID: $id_propiedad",
      );
    }

    $this->load->model("Web_Configuracion_Model");
    $web_conf = $this->Web_Configuracion_Model->get($id_empresa);
    if (empty($web_conf->argenprop_usuario) || empty($web_conf->argenprop_password) || empty($web_conf->argenprop_id_vendedor)) {
      return array(
        "error"=>1,
        "mensaje"=>"Falta configurar las credenciales de Argenprop. Por favor ingreselas en Configuracion / Avanzada / Integracion con Argenprop",
      );
      exit();
    }

    $headers = array(
      'cache-control' => 'no-cache',
      'content-type' => 'application/x-www-form-urlencoded'
    );

    $id_origen = $propiedad->id."_".$propiedad->id_empresa;
    //$usuario_argenprop = 'integrador@argenprop.com';
    //$password_argenprop = '123456';
    //$id_vendedor = '242566';
    $usuario_argenprop = $web_conf->argenprop_usuario;
    $password_argenprop = $web_conf->argenprop_password;
    $id_vendedor = $web_conf->argenprop_id_vendedor;

    $id_tipo_operacion = "1"; // Venta
    if ($propiedad->id_tipo_operacion == 2) {
      $id_tipo_operacion = "2"; // Alquiler
    } else if ($propiedad->id_tipo_operacion == 3) {
      $id_tipo_operacion = "3"; // Alquiler temporario
    } else if ($propiedad->id_tipo_operacion == 4) {
      $id_tipo_operacion = "1"; // Emprendimientos: es venta en realidad
    }

    $id_tipo_propiedad = "3"; // Casa
    if ($propiedad->id_tipo_inmueble == 2 || $propiedad->id_tipo_inmueble == 14) {
      $id_tipo_propiedad = "1"; // Departamento o Monoambiente
    } else if ($propiedad->id_tipo_inmueble == 5 || $propiedad->id_tipo_inmueble == 22) {
      $id_tipo_propiedad = "4"; // Quinta
    } else if ($propiedad->id_tipo_inmueble == 13) {
      $id_tipo_propiedad = "5"; // Cochera
    } else if ($propiedad->id_tipo_inmueble == 9) {
      $id_tipo_propiedad = "6"; // Local
    } else if ($propiedad->id_tipo_inmueble == 7) {
      $id_tipo_propiedad = "8"; // Terreno
    } else if ($propiedad->id_tipo_inmueble == 11) {
      $id_tipo_propiedad = "9"; // Oficina
    } else if ($propiedad->id_tipo_inmueble == 6 || $propiedad->id_tipo_inmueble == 25) {
      $id_tipo_propiedad = "10"; // Campo
    } else if ($propiedad->id_tipo_inmueble == 10) {
      $id_tipo_propiedad = "11"; // Fondo de Comercio
    } else if ($propiedad->id_tipo_inmueble == 8) {
      $id_tipo_propiedad = "12"; // Galpon
    } else if ($propiedad->id_tipo_inmueble == 3) {
      $id_tipo_propiedad = "2"; // PH
    } else if ($propiedad->id_tipo_inmueble == 20 || $propiedad->id_tipo_inmueble == 24) {
      $id_tipo_propiedad = "7"; // Hotel o Hostel
    }

    $monto = (string)round($propiedad->precio_final,0);
    $moneda = "2";
    if ($propiedad->moneda == '$') $moneda = "1";

    $propiedad->texto = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $propiedad->texto);
    $propiedad->texto = mb_convert_encoding($propiedad->texto, 'UTF-8', 'UTF-8');
    $propiedad->texto = str_replace("</p>", "</p>\n", $propiedad->texto);
    $propiedad->texto = str_replace("<br/>", "\n", $propiedad->texto);
    $propiedad->texto = str_replace("<br />", "\n", $propiedad->texto);
    $propiedad->texto = str_replace("<br>", "\n", $propiedad->texto);
    $propiedad->texto = strip_tags($propiedad->texto);

    $titulo = $this->generar_titulo($propiedad);

    $fields = array(
      'usr' => $usuario_argenprop,
      'psd' => $password_argenprop,
      'aviso.SistemaOrigen.Id' => '10',
      'aviso.Vendedor.IdOrigen' => $id_origen,
      'aviso.EsWeb' => 'true',
      'aviso.Vendedor.Id' => $id_vendedor,
      'aviso.IdOrigen' => $id_origen,
      'aviso.InformacionAdicional' => $propiedad->texto,
      'aviso.Titulo' => substr($titulo, 0, 100),
      'aviso.TipoOperacion' => $id_tipo_operacion,
      'visibilidades[0].MontoOperacion' => $monto,
      'visibilidades[0].Moneda.Id' => $moneda,
      'tipoPropiedad' => $id_tipo_propiedad,
    );

    $this->load->model("Localidad_Model");
    $localidad = $this->Localidad_Model->get_argenprop($propiedad->id_localidad);
    $fields['propiedad.Direccion.Pais.Id'] = $localidad->id_pais_argenprop;
    $fields['propiedad.Direccion.Provincia.Id'] = $localidad->id_provincia_argenprop;
    $fields['propiedad.Direccion.Partido.Id'] = $localidad->id_departamento_argenprop;
    $fields['propiedad.Direccion.Localidad.Id'] = $localidad->id_localidad_argenprop;
    if (!empty($localidad->id_barrio_argenprop)) $fields["propiedad.Direccion.Barrio.Id"] = $localidad->id_barrio_argenprop;
    else if (!empty($propiedad->id_barrio_argenprop)) $fields["propiedad.Direccion.Barrio.Id"] = $propiedad->id_barrio_argenprop;
    $fields['propiedad.Direccion.Coordenadas.Latitud'] = $propiedad->latitud;
    $fields['propiedad.Direccion.Coordenadas.Longitud'] = $propiedad->longitud;
    $fields['propiedad.Direccion.Nombrecalle'] = $propiedad->calle.(!empty($propiedad->entre_calles) ? " e/ $propiedad->entre_calles y $propiedad->entre_calles_2" : "");
    $fields['propiedad.Direccion.Numero'] = $propiedad->altura;
 
    if (!empty($propiedad->superficie_cubierta)) $fields['propiedad.SuperficieCubierta'] = "$propiedad->superficie_cubierta";
    if (!empty($propiedad->superficie_total)) $fields['propiedad.SuperficieTotal'] = "$propiedad->superficie_total";
    if (!empty($propiedad->nuevo)) $fields['propiedad.Antiguedad'] = "$propiedad->nuevo";
    if (!empty($propiedad->ambientes)) $fields['propiedad.CantidadAmbientes'] = "$propiedad->ambientes";
    if (!empty($propiedad->banios)) $fields['propiedad.CantidadBanos'] = "$propiedad->banios";
    if (!empty($propiedad->dormitorios)) $fields['propiedad.CantidadDormitorios'] = "$propiedad->dormitorios";
    if (!empty($propiedad->cocheras)) $fields['propiedad.CantidadCocheras'] = "$propiedad->cocheras";
    if ($propiedad->balcon == 1) $fields["propiedad.Ambientes.Balcon"] = 'true';
    if ($propiedad->patio == 1) $fields["propiedad.Ambientes.Patio"] = 'true';

    if ($propiedad->apto_profesional == 1) $fields["propiedad.AptoProfesional"] = 'true';
    if ($propiedad->servicios_gas == 1) $fields["propiedad.Instalaciones.GasNatural"] = 'true';
    //if ($propiedad->servicios_cloacas == 1) $fields["propiedad.Ambientes.Patio"] = 'true';
    if ($propiedad->servicios_agua_corriente == 1) $fields["propiedad.Ambientes.Patio"] = 'true';
    //if ($propiedad->servicios_asfalto == 1) $fields["propiedad.Ambientes.Patio"] = 'true';
    if ($propiedad->servicios_electricidad == 1) $fields["propiedad.Instalaciones.Electricidad"] = 'true';
    if ($propiedad->servicios_telefono == 1) $fields["propiedad.Instalaciones.Telefono"] = 'true';
    if ($propiedad->servicios_cable == 1) $fields["propiedad.Servicios.Videocable"] = 'true';

    if (!empty($propiedad->id_usuario)) {
      $this->load->model("Usuario_Model");
      $usuario = $this->Usuario_Model->get($propiedad->id_usuario,array(
        "id_empresa"=>$id_empresa
      ));
      if ($id_empresa == 45) $usuario->email = "info@grupo-urbano.com.ar";
      if (!empty($usuario)) {
        if (!empty($usuario->nombre)) $fields['aviso.DatosContacto.Nombre'] = $usuario->nombre;
        if (!empty($usuario->celular)) $fields['aviso.DatosContacto.Celular'] = $usuario->celular;
        if (!empty($usuario->telefono)) $fields['aviso.DatosContacto.Telefono'] = $usuario->telefono;
        if (!empty($usuario->email)) $fields['aviso.DatosContacto.Email'] = $usuario->email;
      }
    }

    if (!empty($propiedad->path)) $fields["aviso.fotos[0].url"] = "https://app.inmovar.com/admin/".$propiedad->path;
    $i = 1;
    foreach($propiedad->images as $image) {
      $fields["aviso.fotos[$i].url"] = "https://app.inmovar.com/admin/".$image;
      $i++;
    }

    $this->Log_Model->imprimir(array("file"=>"argenprop.txt","id_empresa"=>$id_empresa,"texto"=>"PREPARANDO PARA COMPARTIR: \n".print_r($fields,TRUE)));

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, 'https://www.inmuebles.clarin.com/Publicaciones/Publicar?contentType=json');
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
    $result = curl_exec($ch);
    $this->Log_Model->imprimir(array("file"=>"argenprop.txt","id_empresa"=>$id_empresa,"texto"=>"COMPARTIR: ".$result));

    $array = json_decode($result);
    if (!is_array($array)) {
      return array(
        "error"=>1,
        "mensaje"=>$result,
      );
      exit();
    }
    if (!isset($array[0]) || !is_numeric($array[0])) {
      return array(
        "error"=>1,
        "mensaje"=>$result,
      );
      exit();      
    }
    $id_argenprop = $array[0];

    $url_final = "https://www.argenprop.com/prop--".$id_argenprop;

    // Actualizamos la tabla
    $sql = "UPDATE inm_propiedades SET argenprop_habilitado = 1, argenprop_url = '$url_final' ";
    $sql.= "WHERE id_empresa = $id_empresa AND id = $id_propiedad ";
    $this->db->query($sql);
    return array(
      "error"=>0,
      "mensaje"=>$url_final,
    );
  }

}