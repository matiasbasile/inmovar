<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("abstract_model.php");

class Empresa_Model extends Abstract_Model {
  
  private $modulos = array();
  private $dominios = array();
  private $vendedores = array();
  private $total = 0;
  
  function __construct() {
    parent::__construct("empresas","id","razon_social ASC",0);
  }

  function es_milling($id) {
    return (($id == 256 || $id == 257 || $id == 403 || $id == 448 || $id == 493 || $id == 520 || $id == 521 || $id == 522 || $id == 523 || $id == 598 || $id == 1039 || $id == 1368) ? 1 : 0);
  }

  function es_toque($id) {
    return (($id == 571 || $id == 1216 || $id == 1234 || $id == 1275) ? 1 : 0);
  }

  // Obtenemos el idioma de la web
  function get_idioma_web($id_empresa) {
    $res = "es";
    if ($this->db->field_exists("idioma_web","web_configuracion")) {
      $sql = "SELECT idioma_web FROM web_configuracion WHERE id_empresa = $id_empresa ";
      $q = $this->db->query($sql);
      if ($q->num_rows() == 0) return $res;
      $r = $q->row();
      return (!empty($r->idioma_web) ? $r->idioma_web : $res);
    }
    return $res;
  }

  // Obtenemos las palabras clave que forman la base del link
  function get_base_link($config = array()) {
    $id_empresa = (isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa());
    $clave = $config["clave"];
    $idioma = $this->get_idioma_web($id_empresa);
    if ($clave == "producto") {
      if ($idioma == "en") return "product";
    } else if ($clave == "productos") {
      if ($idioma == "en") return "products";
    } else if ($clave == "entrada") {
      if ($idioma == "en") return "post";
    } else if ($clave == "entradas") {
      if ($idioma == "en") return "posts";
    }
    // Si no es ninguna de las anteriores, devolvemos la misma clave ya que siempre la usamos en español
    return mb_strtolower($clave);
  }

  // Devuelve el ID del vendedor DON YEYO
  function get_id_vendedor_don_yeyo() {
    return 2445;
  }

  // Devuelve un array de IDS de empresas asignadas a un vendedor
  function get_ids_empresas_por_vendedor($id_vendedor) {
    $sql = "SELECT id_empresa FROM empresas_vendedores ";
    $sql.= "WHERE id_usuario = '$id_vendedor' ";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) return array();
    else {
      $salida = array();
      foreach($q->result() as $r) {
        $salida[] = $r->id_empresa;
      }
      return $salida;
    }
  }

  // Esta funcion se encarga de mandar los emails de recordatorios de pagos cuando se esta por vencer la cuenta,
  // cuando la cuenta esta justo en el dia del vencimiento o cuando la cuenta ya esta vencida
  // Es usada en controllers/empresas/controlar_vencimientos/
  function enviar_recordatorios_pagos($config = array()) {
    
    $fecha = isset($config["fecha"]) ? $config["fecha"] : date("Y-m-d");
    $clave_template = isset($config["clave_template"]) ? $config["clave_template"] : "cuenta-por-vencer";

    $id_empresa_varcreative = 1;
    $this->load->model("Email_Template_Model");
    $this->load->model("Factura_Model");
    $this->load->model("Log_Model");
    $bcc_array = array("basile.matias99@gmail.com","misticastudio@gmail.com");
    include_once APPPATH.'libraries/Mandrill/Mandrill.php';    

    $sql = "SELECT E.*, DATE_FORMAT(E.fecha_suspension,'%d/%m/%Y') AS fecha_suspension, P.id_articulo, PRO.nombre AS proyecto ";
    $sql.= "FROM empresas E INNER JOIN planes P ON (E.id_plan = P.id) ";
    $sql.= "INNER JOIN com_proyectos PRO ON (E.id_proyecto = PRO.id) ";
    $sql.= "where E.fecha_suspension = '$fecha' AND E.administrar_pagos = 1";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {

      $nombre = htmlentities($r->nombre,ENT_QUOTES);
      $nombre = ucwords(strtolower($nombre));      

      // Buscamos la ultima factura generada a ese cliente
      $factura = $this->Factura_Model->get_ultima(array(
        "id_empresa"=>$id_empresa_varcreative,
        "id_cliente"=>$r->id,
        "buscar_consultas"=>0,
        "buscar_etiquetas"=>0,
      ));
      if (empty($factura)) {
        $this->Log_Model->imprimir(array(
          "id_empresa"=>$id_empresa_varcreative,
          "id_usuario"=>0,
          "file"=>"controlar_vencimientos.txt",
          "texto"=>"Error al obtener la ultima factura de $nombre."
        ));
        continue;        
      }

      $this->Log_Model->imprimir(array(
        "id_empresa"=>$id_empresa_varcreative,
        "id_usuario"=>0,
        "file"=>"controlar_vencimientos.txt",
        "texto"=>"Envio email de cuenta por vencer a $nombre."
      ));
      $template = $this->Email_Template_Model->get_by_proyecto($clave_template,$r->id_proyecto);
      $body = $template->texto;
      $body = str_replace("{{email}}",$r->email,$body);
      $body = str_replace("{{nombre}}",$nombre,$body);
      $body = str_replace("{{fecha_suspension}}",$r->fecha_suspension,$body);
      $body = str_replace("{{link_factura}}", "https://app.inmovar/admin/facturas/function/ver_pdf/".$factura->id."/".$factura->id_punto_venta."/".$factura->id_empresa."/", $body);
      mandrill_send(array(
        "to"=>$r->email,
        "from"=>"no-reply@varcreative.com",
        "from_name"=>$r->proyecto,
        "subject"=>$template->nombre,
        "body"=>$body,
        "reply_to"=>"no-reply@varcreative.com",
        "bcc"=>$bcc_array,
      ));
    }    
  }


  function find($filter) {
    return $this->get_all(null,null,$filter);
  }

  // Mueve las fechas y actualiza el estado de cuenta de la empresa
  function actualizar_pago_empresa($config) {
    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : parent::get_empresa();
    // Si es un pago nuestro, tenemos que mover la fecha de vencimiento de la cuenta de empresa
    $sql = "UPDATE empresas SET ";
    $sql.= " fecha_ultimo_pago = '".date("Y-m-d")."', ";
    $sql.= " fecha_prox_venc = DATE_ADD(fecha_prox_venc, INTERVAL 1 MONTH), ";
    $sql.= " fecha_suspension = DATE_ADD(fecha_suspension, INTERVAL 1 MONTH) ";
    $sql.= "WHERE id = $id_empresa ";
    $sql.= "AND administrar_pagos = 1 ";
    $this->db->query($sql);
  }

  function usa_mercadolibre($id_empresa) {
    $sql = "SELECT ml_access_token FROM web_configuracion WHERE id_empresa = $id_empresa ";
    $q = $this->db->query($sql);
    if ($q->num_rows() == 0) return false;
    $row = $q->row();
    return ((empty($row->ml_access_token)) ? false : true);
  }

  function get_empresa_min($id_empresa) {
    $sql = "SELECT * FROM empresas WHERE id = $id_empresa";
    $q = $this->db->query($sql);
    if ($q->num_rows()>0) {
      return $q->row();
    } else return FALSE;
  }

  function get_web_conf($id_empresa) {
    $sql = "SELECT * FROM web_configuracion WHERE id_empresa = $id_empresa";
    $q = $this->db->query($sql);
    if ($q->num_rows()>0) {
      return $q->row();
    } else return FALSE;
  }
  
  function count_all($id_proyecto = 0) {
    return $this->total;

    $sql = "SELECT IF(COUNT(*) IS NULL,0,COUNT(*)) AS total FROM empresas ";
    $sql.= "WHERE 1=1 ";
    if (!empty($id_proyecto)) $sql.= "AND id_proyecto = $id_proyecto ";
    $q = $this->db->query($sql);
    $row = $q->row();
    return $row->total;
  }  

  function buscar($config = array()) {
    
    $id_usuario = isset($config["id_usuario"]) ? $config["id_usuario"] : 0;
    $estado_empresa = isset($config["estado_empresa"]) ? $config["estado_empresa"] : -1;
    $id_proyecto = isset($config["id_proyecto"]) ? $config["id_proyecto"] : 0;
    $filter = isset($config["filter"]) ? $config["filter"] : "";
    $limit = isset($config["limit"]) ? $config["limit"] : 0;
    $offset = isset($config["offset"]) ? $config["offset"] : 50;

    $sql = "SELECT SQL_CALC_FOUND_ROWS E.*, ";
    $sql.= " IF(WC.tipo_empresa IS NULL,0,WC.tipo_empresa) AS tipo_empresa, ";
    $sql.= " IF(P.nombre IS NULL,'',P.nombre) AS plan, ";
    $sql.= " IF(P.limite_articulos IS NULL,'',P.limite_articulos) AS limite_articulos, ";
    $sql.= " PR.nombre AS proyecto, ";
    $sql.= " IF(E.administrar_pagos = 0,0,IF(NOW() > E.fecha_suspension,2,IF(NOW() > E.fecha_prox_venc,1,0))) AS estado, ";
    $sql.= " DATE_FORMAT(E.fecha_prox_venc,'%d/%m/%Y') AS fecha_prox_venc, ";
    $sql.= " DATE_FORMAT(E.fecha_suspension,'%d/%m/%Y') AS fecha_suspension, ";
    $sql.= " DATE_FORMAT(E.fecha_alta,'%d/%m/%Y') AS fecha_alta ";
    $sql.= "FROM empresas E ";
    $sql.= "INNER JOIN com_proyectos PR ON (E.id_proyecto = PR.id) ";
    $sql.= "LEFT JOIN web_configuracion WC ON (E.id = WC.id_empresa) ";
    $sql.= "LEFT JOIN planes P ON (E.id_plan = P.id) ";
    $sql.= "WHERE 1=1 ";
    if ($id_usuario != 0) $sql.= "AND EXISTS (SELECT 1 FROM empresas_vendedores EV WHERE EV.id_empresa = E.id AND EV.id_usuario = $id_usuario) ";
    if ($id_proyecto != 0) $sql.= "AND E.id_proyecto = $id_proyecto ";
    if ($estado_empresa != -1) $sql.= "AND E.estado_empresa = $estado_empresa ";
    if (!empty($filter)) $sql.= "AND E.razon_social LIKE '%$filter%' ";
    $sql.= "ORDER BY E.id DESC ";
    if (!empty($offset)) $sql.= "LIMIT $limit, $offset ";
    $query = $this->db->query($sql);

    $q_total = $this->db->query("SELECT FOUND_ROWS() AS total");
    $total = $q_total->row();
    $this->total = $total->total;

    $salida = array();
    foreach($query->result() as $r) {
      $r->cantidad_facturas = 0;
      $r->cantidad_articulos = 0;
      $r->ultimo_acceso = "";

      $sql = "SELECT * FROM empresas_dominios WHERE id_empresa = $r->id ";
      $qq = $this->db->query($sql);
      $r->dominios = $qq->result();

      $sql = "SELECT EV.*, V.nombre FROM empresas_vendedores EV INNER JOIN com_usuarios V ON (EV.id_usuario = V.id) WHERE EV.id_empresa = $r->id AND V.admin = 1 ";
      $qq = $this->db->query($sql);
      $r->vendedores = $qq->result();

      // Fecha ultima conexion
      $sql = "SELECT L.texto, DATE_FORMAT(L.fecha,'%d/%m/%Y %H:%i') AS fecha FROM com_log L WHERE L.id_empresa = $r->id AND L.importancia = 'L' ORDER BY L.fecha DESC ";
      $qq = $this->db->query($sql);
      $r->usuario_ultimo_ingreso = "";
      $r->fecha_ultimo_ingreso = "";
      if ($qq->num_rows() > 0) {
        $rr = $qq->row();
        $r->usuario_ultimo_ingreso = $rr->texto;
        $r->fecha_ultimo_ingreso = $rr->fecha;
      }

      // Si es INMOVAR, contamos las propiedades
      $r->cantidad = 0;
      if ($id_proyecto == 3) {
        $sql = "SELECT IF(COUNT(*) IS NULL,0,COUNT(*)) AS cantidad ";
        $sql.= "FROM inm_propiedades ";
        $sql.= "WHERE id_empresa = $r->id ";
        $qqq = $this->db->query($sql);
        $rrr = $qqq->row();
        $r->cantidad = $rrr->cantidad;
      }

      $salida[] = $r;
    }
    $this->db->close();
    return $salida;
  }
    
  function get_all($limit = null, $offset = null,$order = "",$order_by="") {
    $filter = "";
    $id_usuario = $this->input->get("id_usuario");
    $id_proyecto = $this->input->get("id_proyecto");
    $estado_empresa = (($this->input->get("estado_empresa") !== FALSE) ? $this->input->get("estado_empresa") : -1);
    return $this->buscar(array(
      "id_usuario"=>$id_usuario,
      "id_proyecto"=>$id_proyecto,
      "estado_empresa"=>$estado_empresa,
      "limit"=>$limit,
      "offset"=>$offset,
    ));
  }
    
  function get($id) {
    $sql = "SELECT E.*, ";
    $sql.= " IF(E.administrar_pagos = 0,0,IF(NOW() > E.fecha_suspension,2,IF(NOW() > E.fecha_prox_venc,1,0))) AS estado_cuenta, ";
    $sql.= " IF(WT.nombre IS NULL,'',WT.nombre) AS template, ";
    $sql.= " IF(WT.path IS NULL,'',WT.path) AS path_template, ";
    $sql.= " IF(PR.nombre IS NULL,'',PR.nombre) AS proyecto, ";
    $sql.= " IF(TI.nombre IS NULL,'',TI.nombre) AS tipo_contribuyente, ";
    $sql.= " IF(L.nombre IS NULL,'',L.nombre) AS localidad, ";
    $sql.= " IF(L.id_departamento IS NULL,0,L.id_departamento) AS id_departamento, ";
    $sql.= " IF(DEP.id_provincia IS NULL,0,DEP.id_provincia) AS id_provincia, ";
    $sql.= " IF(PRO.id_pais IS NULL,0,PRO.id_pais) AS id_pais, ";
    $sql.= " IF(L.codigo_postal IS NULL,'',L.codigo_postal) AS codigo_postal ";
    $sql.= "FROM empresas E ";
    $sql.= "LEFT JOIN com_proyectos PR ON (E.id_proyecto = PR.id) ";
    $sql.= "LEFT JOIN com_localidades L ON (E.id_localidad = L.id) ";
    $sql.= "LEFT JOIN com_departamentos DEP ON (L.id_departamento = DEP.id) ";
    $sql.= "LEFT JOIN com_provincias PRO ON (DEP.id_provincia = PRO.id) ";
    $sql.= "LEFT JOIN tipos_iva TI ON (E.id_tipo_contribuyente = TI.id) ";
    $sql.= "LEFT JOIN web_templates WT ON (E.id_web_template = WT.id) ";
    $sql.= "WHERE E.id = $id ";
    $query = $this->db->query($sql);
    $row = $query->row();
    if ($row === FALSE || empty($row)) {
      return FALSE;
    }
    
    // Obtenemos los dominios
    $row->dominios = array();
    $q = $this->db->query("SELECT * FROM empresas_dominios WHERE id_empresa = $id");
    foreach($q->result() as $r) {
      $row->dominios[] = $r->dominio;
    }  

    // Obtenemos los vendedores
    $row->vendedores = array();
    $q = $this->db->query("SELECT EV.*, U.nombre FROM empresas_vendedores EV INNER JOIN com_usuarios U ON (EV.id_usuario = U.id AND U.id_empresa = 0 AND U.admin = 1) WHERE EV.id_empresa = $id");
    foreach($q->result() as $r) {
      $row->vendedores[] = $r;
    } 

    // Obtenemos las facturas
    $row->facturas = array();
    $sql = "SELECT EF.*, ";
    $sql.= " IF(EF.vencimiento != '0000-00-00',DATE_FORMAT(EF.vencimiento,'%d/%m/%Y'),'') AS vencimiento, ";
    $sql.= " IF(EF.fecha_pago != '0000-00-00',DATE_FORMAT(EF.fecha_pago,'%d/%m/%Y'),'') AS fecha_pago ";
    $sql.= "FROM empresas_facturas EF WHERE EF.id_empresa = $id ORDER BY EF.vencimiento DESC";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
      $row->facturas[] = $r;
    } 
    
    // Obtenemos las claves de configuracion del template DEPENDIENDO DEL PROYECTO
    $row->config = array();
    $q = $this->db->query("SELECT * FROM web_templates_config WHERE id_template = $row->id_web_template ");
    foreach($q->result() as $r) {
      $row->config[$r->clave] = $r->valor;
    }

    $q = $this->db->query("SELECT * FROM fact_configuracion WHERE id_empresa = $id ");
    if ($q->num_rows()>0) {
      $fact_configuracion = $q->result_array();
      $row->config = array_merge($row->config,$fact_configuracion[0]);

      // Si la cotizacion del dolar esta en cero, la tomamos de otra tabla
      // La cotizacion la tomamos de otra tabla, no del campo 
      if ($row->config["cotizacion_dolar"] == 0) {
        $this->load->model("Configuracion_Model");
        $row->config["cotizacion_dolar"] = $this->Configuracion_Model->get_cotizacion(array(
          "id_empresa"=>$id,
        ));
      }

      unset($row->config["id_empresa"]);
    }


    // IMPORTANTE:
    // La propiedad 'configuraciones_especiales' la usamos como texto para poder escribir cualquier configuracion adicional
    // de esta manera, no tenemos que estar agregando propiedades a la tabla fact_configuracion
    // sino que ahi mismo escribimos nuevas propiedades y vamos usando si existen
    if (isset($row->configuraciones_especiales)) {
      $lineas = explode(";",$row->configuraciones_especiales);
      foreach($lineas as $l) {
        $l = trim($l);
        if (empty($l)) continue;
        if (strpos($l,"=")>0) {
          $campos = explode("=",$l);
          $clave = trim($campos[0]);
          $valor = trim($campos[1]);
          if (empty($clave) || empty($valor)) continue;
          $row->config[$clave] = $valor;
        }
      }
    }


    // Si es RESTOVAR
    $row->categorias = array();
    if ($row->id_proyecto == 10) {
      $q = $this->db->query("SELECT * FROM delivery_configuracion WHERE id_empresa = $id ");
      if ($q->num_rows()>0) {
        $delivery_configuracion = $q->result_array();
        $row = (object) array_merge((array) $row, $delivery_configuracion[0]);
        unset($row->id_empresa);
      }

      // Obtenemos las categorias
      $sql = "SELECT E.nombre FROM delivery_categorias_empresas EE INNER JOIN delivery_categorias E ON (EE.id_categoria = E.id) ";
      $sql.= "WHERE EE.id_empresa = $id ORDER BY EE.orden ASC";
      $q = $this->db->query($sql);
      foreach($q->result() as $r) {
        $row->categorias[] = $r->nombre;
      }

    // Si es COLVAR
    } else if ($row->id_proyecto == 5) {
      $q = $this->db->query("SELECT * FROM aca_configuracion WHERE id_empresa = $id ");
      if ($q->num_rows()>0) {
        $aca_configuracion = $q->result_array();
        $row = (object) array_merge((array) $row, $aca_configuracion[0]);
        unset($row->id_empresa);
      }

    // Si es MANTENIMIENTO
    } else if ($row->id_proyecto == 13) {

      $q = $this->db->query("SELECT * FROM mant_configuracion WHERE id_empresa = $id ");
      if ($q->num_rows()>0) {
        $mant_configuracion = $q->result_array();
        $row = (object) array_merge((array) $row, $mant_configuracion[0]);
        unset($row->id_empresa);
      }

    }

    // tipo_empresa:
    // 0 = Ninguna
    // 1 = Neumaticos
    // 2 = Turnos
    // 3 = Pedidos / Distribuidoras
    // 4 = La Plata Construye
    
    $sql = "SELECT * ";
    $sql.= "FROM web_configuracion WHERE id_empresa = $id ";
    $q = $this->db->query($sql);
    if ($q->num_rows()>0) {

      $web_configuracion = $q->row();
      $row->telefono = $web_configuracion->telefono_web;
      $row->direccion = $web_configuracion->direccion_web;
      $row->direccion_web = $web_configuracion->direccion_web;
      $row->ciudad = $web_configuracion->ciudad;
      $row->email = $web_configuracion->email; // IMPORTANTE
      $row->telefono_web = $web_configuracion->telefono_web;
      $row->codigo_postal = $web_configuracion->codigo_postal;
      $row->config["favicon"] = $web_configuracion->favicon;
      $row->config["telefono_2"] = $web_configuracion->telefono_2;
      $row->config["no_imagen"] = $web_configuracion->no_imagen;
      $row->config["calidad_imagenes"] = $web_configuracion->calidad_imagenes;
      $row->config["color_fondo_imagenes_defecto"] = $web_configuracion->color_fondo_imagenes_defecto;
      $row->config["color_principal"] = $web_configuracion->color_principal;
      $row->config["color_secundario"] = $web_configuracion->color_secundario;
      $row->config["color_terciario"] = $web_configuracion->color_terciario;
      $row->config["posiciones"] = $web_configuracion->posiciones;
      $row->config["logo_1"] = $web_configuracion->logo_1;
      $row->config["tienda_ver_precios"] = $web_configuracion->tienda_ver_precios;
      $row->config["tienda_carrito"] = $web_configuracion->tienda_carrito;
      $row->config["tienda_consulta_productos"] = $web_configuracion->tienda_consulta_productos;
      $row->config["ml_access_token"] = $web_configuracion->ml_access_token;
      $row->config["ml_refresh_token"] = $web_configuracion->ml_refresh_token;
      $row->config["ml_expires_in"] = $web_configuracion->ml_expires_in;
      $row->config["ml_texto_empresa"] = $web_configuracion->ml_texto_empresa;
      $row->config["ml_recargo_precio"] = $web_configuracion->ml_recargo_precio;
      $row->config["ml_lista_base"] = $web_configuracion->ml_lista_base;
      $row->config["emails_alquileres"] = $web_configuracion->emails_alquileres;
      $row->config["emails_ventas"] = $web_configuracion->emails_ventas;
      $row->config["emails_emprendimientos"] = $web_configuracion->emails_emprendimientos;
      $row->config["emails_tasaciones"] = $web_configuracion->emails_tasaciones;
      $row->config["emails_contacto"] = $web_configuracion->emails_contacto;
      $row->config["emails_registro"] = $web_configuracion->emails_registro;
      $row->config["bcc_email"] = $web_configuracion->bcc_email;
      $row->config["clienapp_abierto"] = $web_configuracion->clienapp_abierto;
      $row->config["clienapp_posicion"] = $web_configuracion->clienapp_posicion;
      $row->config["clienapp_sonido"] = $web_configuracion->clienapp_sonido;
      if (isset($web_configuracion->clienapp_formulario)) $row->config["clienapp_formulario"] = $web_configuracion->clienapp_formulario;
      $row->config["tipo_empresa"] = $web_configuracion->tipo_empresa;
      $row->config["estructura"] = $web_configuracion->estructura;
      $row->config["tienda_envio_desde"] = $web_configuracion->tienda_envio_desde;
      $row->config["clienapp_mantener_cerrado"] = $web_configuracion->clienapp_mantener_cerrado;
      $row->config["texto_registro"] = $web_configuracion->texto_registro;
      $row->config["texto_registro_gracias"] = $web_configuracion->texto_registro_gracias;
      $row->config["texto_staff"] = $web_configuracion->texto_staff;
      $row->config["texto_newsletter"] = $web_configuracion->texto_newsletter;
      $row->config["texto_contacto"] = $web_configuracion->texto_contacto;
      if (isset($web_configuracion->comp_instagram)) $row->config["comp_instagram"] = $web_configuracion->comp_instagram;
      if (isset($web_configuracion->instagram_id)) $row->config["instagram_id"] = $web_configuracion->instagram_id;
      if (isset($web_configuracion->instagram_user_id)) $row->config["instagram_user_id"] = $web_configuracion->instagram_user_id;
      if (isset($web_configuracion->instagram_access_token)) $row->config["instagram_access_token"] = $web_configuracion->instagram_access_token;
      if (isset($web_configuracion->instagram_limit)) $row->config["instagram_limit"] = $web_configuracion->instagram_limit;
      if (isset($web_configuracion->marca_agua)) $row->config["marca_agua"] = $web_configuracion->marca_agua;
      if (isset($web_configuracion->marca_agua_posicion)) $row->config["marca_agua_posicion"] = $web_configuracion->marca_agua_posicion;
      if (isset($web_configuracion->menu_configuracion)) $row->config["menu_configuracion"] = $web_configuracion->menu_configuracion;
      if (isset($web_configuracion->clienapp_prefijo)) $row->config["clienapp_prefijo"] = $web_configuracion->clienapp_prefijo;
      if (isset($web_configuracion->clienapp_largo_telefono)) $row->config["clienapp_largo_telefono"] = $web_configuracion->clienapp_largo_telefono;
      if (isset($web_configuracion->clienapp_mostrar_email)) $row->config["clienapp_mostrar_email"] = $web_configuracion->clienapp_mostrar_email;
      if (isset($web_configuracion->tokko_apikey)) $row->config["tokko_apikey"] = $web_configuracion->tokko_apikey;
      if (isset($web_configuracion->tokko_enviar_consultas)) $row->config["tokko_enviar_consultas"] = $web_configuracion->tokko_enviar_consultas;
      if (isset($web_configuracion->tokko_importacion)) $row->config["tokko_importacion"] = $web_configuracion->tokko_importacion;
      if (isset($web_configuracion->crm_enviar_emails_usuarios)) $row->config["crm_enviar_emails_usuarios"] = $web_configuracion->crm_enviar_emails_usuarios;
      if (isset($web_configuracion->id_email_registro)) $row->config["id_email_registro"] = $web_configuracion->id_email_registro;
      if (isset($web_configuracion->orden_listado)) $row->config["orden_listado"] = $web_configuracion->orden_listado;
      if (isset($web_configuracion->booking)) $row->config["booking"] = $web_configuracion->booking;
      if (isset($web_configuracion->pagina_en_construccion)) $row->config["pagina_en_construccion"] = $web_configuracion->pagina_en_construccion;
      if (isset($web_configuracion->pagina_en_construccion_imagen)) $row->config["pagina_en_construccion_imagen"] = $web_configuracion->pagina_en_construccion_imagen;

    } else {
      // Valores de configuracion por defecto (Ej: PYMVAR no tiene web_configuracion pero algunos parametros por defecto son necesarios)
      $row->config["color_fondo_imagenes_defecto"] = "rgba(255,255,255,1)";
      $row->config["tipo_empresa"] = 0;
    }
    
    $this->db->close();
    return $row;
  }
    
  function save($data) {
    $this->load->helper("fecha_helper");
    $this->load->helper("file_helper");
    if (isset($data->modulos)) $this->modulos = $data->modulos;
    if (isset($data->dominios) && !is_array($data->dominios)) $this->dominios = explode(";;;",$data->dominios);    
    else $this->dominios = array();
    if (isset($data->fecha_prox_venc) && !empty($data->fecha_prox_venc)) $data->fecha_prox_venc = fecha_mysql($data->fecha_prox_venc);
    if (isset($data->fecha_suspension) && !empty($data->fecha_suspension)) $data->fecha_suspension = fecha_mysql($data->fecha_suspension);    
    $this->remove_fields($data);
    return parent::save($data);
  }

  function update($id,$data) {

    $this->load->helper("file_helper");    
    $this->load->helper("fecha_helper");
    $data->link = filename($data->nombre,"-",0);

    if (isset($data->facturas)) {
      foreach($data->facturas as $factura) {
        $factura->fecha_pago = fecha_mysql($factura->fecha_pago);
        $this->db->where("id_empresa",$id);
        $this->db->where("id",$factura->id);
        $this->db->update("empresas_facturas",array(
          "pagada"=>$factura->pagada,
          "observaciones"=>$factura->observaciones,
          "fecha_pago"=>$factura->fecha_pago,
        ));
      }
    }

    if (isset($data->vendedores)) {
      $this->db->query("DELETE FROM empresas_vendedores WHERE id_empresa = $id");
      // Guardamos los modulos que estan habilitados
      foreach($data->vendedores as $d) {
        if (!empty($d)) {
          $this->db->query("INSERT INTO empresas_vendedores (id_empresa,id_usuario,monto) VALUES ('$id','$d->id_usuario','$d->monto')");
        }
      }
    }

    // Actualizamos los campos que pertenecen a la otra tabla
    $sql = "UPDATE web_configuracion SET ";
    if (isset($data->direccion_web)) $sql.= " direccion_web = '$data->direccion_web', ";
    if (isset($data->codigo_postal)) $sql.= " codigo_postal = '$data->codigo_postal', ";
    if (isset($data->ciudad)) $sql.= " ciudad = '$data->ciudad', ";
    if (isset($data->telefono_web)) $sql.= " telefono_web = '$data->telefono_web', ";
    if (isset($data->telefono_2)) $sql.= " telefono_2 = '$data->telefono_2', ";
    $sql.= " id_empresa = $id ";
    $sql.= "WHERE id_empresa = $id ";
    $this->db->query($sql);

    // Actualizamos el cliente
    $sql = "UPDATE clientes SET ";
    $sql.= " fecha_ult_operacion = NOW(), ";
    $sql.= " nombre = '$data->razon_social', ";
    $sql.= " email = '$data->email', ";
    $sql.= " direccion = '$data->direccion', ";
    $sql.= " telefono = '$data->telefono', ";
    $sql.= " forma_pago = 'C', ";
    $sql.= " cuit = '$data->cuit' ";
    $sql.= "WHERE id_empresa = 1 AND id = $id";
    $this->db->query($sql);

    return parent::update($id,$data);
  }

  function get_id_empresa_by_dominio($dominio = "",$config = array()) {
    $test = isset($config["test"]) ? $config["test"] : 0;
    $dominio = str_replace("/", "", $dominio);
    $dominio = str_replace("www.", "", $dominio);
    if (empty($dominio)) return 0;
    $sql = "SELECT id_empresa ";
    $sql.= "FROM empresas_dominios ";
    $sql.= "WHERE dominio = '$dominio' OR dominio = 'www.$dominio' ";
    $q = $this->db->query($sql);
    if ($q->num_rows()>0) {
      $row = $q->row();
      return $row->id_empresa;
    } else {
      return 0;
    }
  }

  function get_min($id) {
    $sql = "SELECT E.*, T.path AS template_path, WC.*, PR.nombre AS proyecto, ";
    $sql.= " IF(L.nombre IS NULL,'',L.nombre) AS localidad, ";
    $sql.= " IF(L.codigo_postal IS NULL,'',L.codigo_postal) AS codigo_postal ";
    $sql.= "FROM empresas E ";
    $sql.= "INNER JOIN com_proyectos PR ON (E.id_proyecto = PR.id) ";
    $sql.= " LEFT JOIN web_configuracion WC ON (E.id = WC.id_empresa) ";
    $sql.= " LEFT JOIN web_templates T ON (E.id_web_template = T.id) ";
    $sql.= " LEFT JOIN com_localidades L ON (E.id_localidad = L.id) ";
    $sql.= "WHERE E.id = '$id' ";
    $q = $this->db->query($sql);
    return $q->row();    
  }

  function get_empresa_by_email($email) {
    $sql = "SELECT E.* ";
    $sql.= "FROM empresas E ";
    $sql.= "WHERE E.email = '$email' ";
    $q = $this->db->query($sql);
    return ($q->num_rows() > 0 ? $q->row() : FALSE);
  }

  function get_empresa_by_hash($hash) {
    $sql = "SELECT E.* ";
    $sql.= "FROM empresas E ";
    $sql.= "WHERE MD5(E.id) = '$hash' ";
    $q = $this->db->query($sql);
    return ($q->num_rows() > 0 ? $q->row() : FALSE);
  }
  
  function get_empresa_by_dominio($dominio) {
    $dominio = str_replace("/", "", $dominio);
    $dominio_con_www = (strpos("www.", $dominio) === FALSE) ? "www.".$dominio : $dominio;
    $sql = "SELECT E.*, T.path AS template_path, WC.*, ";
    $sql.= " IF(L.nombre IS NULL,'',L.nombre) AS localidad, ";
    $sql.= " IF(L.codigo_postal IS NULL,'',L.codigo_postal) AS codigo_postal ";
    $sql.= "FROM empresas E ";
    $sql.= " INNER JOIN empresas_dominios ED ON (E.id = ED.id_empresa) ";
    $sql.= " LEFT JOIN web_configuracion WC ON (E.id = WC.id_empresa) ";
    $sql.= " LEFT JOIN web_templates T ON (E.id_web_template = T.id) ";
    $sql.= " LEFT JOIN com_localidades L ON (E.id_localidad = L.id) ";
    $sql.= "WHERE ED.dominio = '$dominio' ";
    if ($dominio_con_www != $dominio) $sql.= "OR ED.dominio = 'www.".$dominio."' ";
    $q = $this->db->query($sql);
    return $q->row();
  }
  
  function post_save($id) {
    
    // Para arreglar cuando se inserta
    if (is_array($id)) $id = $id["id"];
    
    if (!empty($this->modulos)) {
      $f_tar = date("Y-m-d H:i:s");
      $this->db->query("DELETE FROM com_modulos_empresas WHERE id_empresa = $id");
      // Guardamos los modulos que estan habilitados
      foreach($this->modulos as $m) {
        if ($m->habilitado > 0) {
          $sql = "INSERT INTO com_modulos_empresas ";
          $sql.= " (id_empresa,id_modulo,fecha_alta ";
          if (isset($m->nombre)) $sql.= ",nombre_es";
          if (isset($m->visible)) $sql.= ",visible";
          $sql.= ") VALUES (";
          $sql.= " '$id','$m->id','$f_tar'";
          if (isset($m->nombre)) $sql.= ",'$m->nombre'";
          if (isset($m->visible)) $sql.= ",'$m->visible'";
          $sql.= ")";
          $this->db->query($sql);
        }
      }      
    }
    if (!empty($this->dominios)) {
      $this->db->query("DELETE FROM empresas_dominios WHERE id_empresa = $id");
      // Guardamos los modulos que estan habilitados
      foreach($this->dominios as $d) {
        if (!empty($d)) {
          $this->db->query("INSERT INTO empresas_dominios (id_empresa,dominio) VALUES ('$id','$d')");  
        }
      }      
    }
  }
  
  // Funcion privada que elimina todas las propiedades que no se persisten
  private function remove_fields($data) {

    unset($data->dominios);
    unset($data->error);
    unset($data->punto_venta);
    unset($data->usuario);
    unset($data->crear_usuario);
    unset($data->password);
    unset($data->provincia);
    unset($data->localidad);
    unset($data->modulos);
    unset($data->plan);
    unset($data->template);
    unset($data->path_template);
    unset($data->mensaje);
    unset($data->proyecto);
    unset($data->tipo_contribuyente);
    unset($data->codigo_postal);    
  }

  
  // CUANDO SE CREA UNA NUEVA EMPRESA, SE DEBEN CREAR :
  // - LOS REGISTROS DE LA TABLA NUMEROS_COMPROBANTES
  // - UN PERFIL DE USUARIO ADMINISTRADOR
  // - UN USUARIO ADMINISTRADOR
  function insert($array) {
    
    $this->load->helper("fecha_helper");
    $this->load->helper("file_helper");
    
    // Guardamos el nombre en una variable temporal
    // pero como nombre ponemos igual a la razon social (que seria el nombre de la inmobiliaria no el que se registro)
    $nombre = $array->nombre;
    $array->nombre = $array->razon_social;

    $crear_usuario = isset($array->crear_usuario) ? $array->crear_usuario : TRUE;
    $punto_venta = isset($array->punto_venta) ? $array->punto_venta : 2;
    $password = isset($array->password) ? $array->password : "";

    $tipo_empresa = 0;
    $vendedores = (isset($array->vendedores)) ? $array->vendedores : array();
    $dominios = (isset($array->dominios)) ? explode(";;;",$array->dominios) : array();
    $password = (isset($array->password) ? ((strlen($array->password)<32) ? md5($array->password) : $array->password) : "c4ca4238a0b923820dcc509a6f75849b");
    
    // Eliminamos todo lo que no se persiste
    $this->remove_fields($array);
    
    $array->activo = 1;
    $array->fecha_alta = date("Y-m-d");
    $this->load->model("Tipo_Comprobante_Model");
    $comprobantes = $this->Tipo_Comprobante_Model->get_all();
    
    $array->link = filename($array->razon_social,"-",0);
    
    //$this->db->db_debug = FALSE;
    //$this->db->trans_start();

    if (!isset($array->id_empresa_modelo)) $array->id_empresa_modelo = 1454;
    $id_empresa_modelo = $array->id_empresa_modelo;
    unset($array->numero_ib);
    unset($array->fecha_inicio);
    unset($array->percibe_ib);
    unset($array->retiene_ib);
    unset($array->retiene_ganancias);

    $array->activo = 0; // Por defecto la empresa esta inactiva
    $array->id_web_template = 33; // Por defecto el template 1
    $id_empresa = parent::insert($array);
    if (empty($id_empresa)) {
      return array("id"=>0,"error"=>TRUE,"mensaje"=>"Error al crear la empresa.");
    }
    // Crear los directorios de la empresa
    mkdir("uploads/$id_empresa/");
    mkdir("uploads/$id_empresa/comprobantes/");
    mkdir("uploads/$id_empresa/images/");
    mkdir("uploads/$id_empresa/certificados/");
    mkdir("uploads/$id_empresa/certificados/produccion/");
    mkdir("uploads/$id_empresa/certificados/testing/");
    mkdir("uploads/$id_empresa/slider/");
    mkdir("uploads/$id_empresa/paginas/");
    mkdir("uploads/$id_empresa/articulos/");
    mkdir("uploads/$id_empresa/propiedades/");
    mkdir("uploads/$id_empresa/marcas/");
    mkdir("uploads/$id_empresa/entradas/");
    mkdir("uploads/$id_empresa/publicidades/");
    mkdir("uploads/$id_empresa/alumnos/");
    mkdir("uploads/$id_empresa/clasificados/");

    // Copiamos el editor
    if (file_exists("uploads/editor")) {
      // Copiamos todos los archivos del editor a la carpeta de la empresa
      copy_all("uploads/editor","uploads/$id_empresa/editor");
    }
    
    // Puntos de Venta para la empresa
    // Se crean 2 puntos de venta, uno manual y otro electronico
    $modelo_factura = "basico";

    // Creamos los almacenes
    $sql = "INSERT INTO almacenes (nombre,id_empresa) VALUES ('Negocio',$id_empresa) ";
    $this->db->query($sql);
    $id_almacen = $this->db->insert_id();

    // Creamos la caja de EFECTIVO
    $this->db->query("INSERT INTO cajas (nombre,id_empresa,activo,tipo) VALUES ('Efectivo',$id_empresa,1,0)");
    
    $sql = "INSERT INTO puntos_venta (id_empresa,activo,nombre,numero,tipo_impresion,enviar_email,disenio_factura,disenio_factura_color,por_default,id_sucursal,tipo_uso) VALUES(";
    $sql.= "$id_empresa,1,'PV 1',1,'P',0,'$modelo_factura','dark_blue',1,$id_almacen,'W')";
    $this->db->query($sql);
    $id_punto_venta_1 = $this->db->insert_id();
    // Creamos los numeros de comprobantes para ese punto de venta
    foreach($comprobantes as $c) {
      $sql = "INSERT INTO numeros_comprobantes (id_empresa,id_punto_venta,id_tipo_comprobante,ultimo,copias) VALUES (";
      $sql.= "$id_empresa,$id_punto_venta_1,$c->id,0,1)";
      $this->db->query($sql);
    }
    $sql = "INSERT INTO almacenes_puntos_venta (id_empresa,id_almacen,id_punto_venta) VALUES ($id_empresa,$id_almacen,$id_punto_venta_1) ";
    $this->db->query($sql);
        
    // Tabla de configuracion
    $this->db->insert("fact_configuracion",array(
      "id_empresa"=>$id_empresa,
      "supervisor"=>"e10adc3949ba59abbe56e057f20f883e", // 123456
      "disenio_factura"=>$modelo_factura,
      "facturacion_template_factura"=>$modelo_factura,
      "facturacion_tipo"=>"",
      "facturacion_testing"=>1,
      "facturacion_consultar_eliminar_item"=>1,
      "facturacion_conservar_cliente_al_guardar"=>1,
      "facturacion_cantidad_copias"=>2, // Con duplicado
      "facturacion_gestiona_stock_default"=>0,
      "facturacion_editar_descuento"=>1,
      "facturacion_permite_anular_producto"=>1,
      "facturacion_modificar_descripcion"=>1,
      "facturacion_modificar_item"=>1,
      "facturacion_modificar_precio"=>1,
      "facturacion_mostrar_numero"=>1,
      "facturacion_mostrar_fecha"=>1,
      "facturacion_codigo_finalizar"=>"0",
      "facturacion_usa_cache_clientes"=>0,
      "facturacion_usa_cache_articulos"=>0,
      "facturacion_cantidad_decimales"=>2,
      "facturacion_usa_nplu"=>0,
      "facturacion_controlar_caja_abierta"=>0,
      "facturacion_forma_pago"=>"M",
      "facturacion_cantidad_items"=>9999,
      "facturacion_abrir_dialogo_imprimir"=>0,
      "facturacion_imprimir_item_al_final"=>1,
      "facturacion_crear_cliente"=>1,
      "facturacion_mostrar_logo_en_comprobante"=>1,
      "facturacion_ocultar_cuenta_corriente"=>1,
      "numero_ib"=>"",
      "fecha_inicio"=>"",
      "percibe_ib"=>0,
      "retiene_ib"=>0,
      "retiene_ganancias"=>0,
    ));
      
    // Creamos un registro de configuracion
    $sql = "INSERT INTO web_configuracion (id_empresa,id_proyecto,email,entradas_por_pagina,tipo_empresa,primer_login,seo_title,";
    $sql.= " template_header,template_footer,template_home,template_contacto,template_productos_detalle,template_productos_listado,template_noticias_detalle,template_noticias_listado,template_pagina,color_fondo_imagenes_defecto, ";
    $sql.= " clienapp_abierto, clienapp_posicion, clienapp_sonido, tienda_registro_direccion, tienda_registro_telefono, crm_notificar_asignaciones_usuarios, crm_notificar_tareas, tienda_registro_ciudad, crm_enviar_emails_usuarios ";
    $sql.= ") VALUES ('$id_empresa','$array->id_proyecto','$array->email',16,'$tipo_empresa',1,'$array->nombre',";
    $sql.= "'header','footer','home','contacto','productos_detalle','productos_listado','noticias_detalle','noticias_listado','pagina','rgba(255,255,255,1)', ";
    $sql.= " 1, 'D', 1, 1, 1, 1, 1, 1, 2 ";
    $sql.= ")";
    $this->db->query($sql);

    // Crea un nuevo cliente de la cuenta 936. VARCREATIVE, utilizada para facturar
    $id_empresa_varcreative = 1;
    $celular = (isset($array->telefono) ? $array->telefono : (isset($array->telefono_empresa) ? $array->telefono_empresa : ""));
    $celular = preg_replace("/[^0-9]/", "", $celular );
    $array->direccion = (isset($array->direccion) ? $array->direccion : "");
    $array->id_localidad = (isset($array->id_localidad) ? $array->id_localidad : 0);
    $cuit = (isset($array->cuit) ? $array->cuit : "");
    $cuit = preg_replace("/[^0-9]/", "", $cuit );
    $sql = "INSERT INTO clientes (";
    $sql.= " id, id_empresa, tipo, nombre, email, codigo, activo, fecha_inicial, forma_pago, ";
    $sql.= " id_tipo_iva, cuit, id_tipo_documento, direccion, id_localidad, celular, fecha_ult_operacion ";
    $sql.= ") VALUES (";
    $sql.= " '$id_empresa', $id_empresa_varcreative, 1, '$array->razon_social', '$array->email', '$id_empresa', 1, NOW(), 'C', ";
    $sql.= " '$array->id_tipo_contribuyente', '$cuit', '80', '$array->direccion', '$array->id_localidad', '$celular', NOW() ";
    $sql.= ")";
    $this->db->query($sql);
    $id_cliente = $this->db->insert_id();

    $id_articulo = 1;
    $this->load->model("Factura_Model");
    $this->Factura_Model->crear(array(
      "id_empresa"=>$id_empresa_varcreative,
      "es_periodica"=>1,
      // Por una cuestion de que la facturacion periodica necesita empezar a copiar a partir de una factura ya hecha,
      // creamos una anulada con la fecha de hoy. Dentro de un mes la factura sale bien
      "anulada"=>1, 
      "fecha"=>date("Y-m-d"),
      // Cliente que terminamos de insertar recien
      "id_cliente"=>$id_cliente,
      // El id_articulo coincide con el plan elegido
      // De esta manera, cuando nosotros cambiemos el precio ya en las proximas facturas se cambia solo
      "id_articulo"=>$id_articulo,
    ));      

    $marcelo = new stdClass();
    $marcelo->id_usuario = 920;
    $marcelo->monto = 0;
    $leo = new stdClass();
    $leo->id_usuario = 1638;
    $leo->monto = 0;
    $matias = new stdClass();
    $matias->id_usuario = 1636;
    $matias->monto = 0;

    if (isset($_SESSION["id"]) && isset($_SESSION["perfil"])) {
      // Si fue creado desde el mismo panel
      $user = new stdClass();
      $user->id_usuario = $_SESSION["id"];
      $user->monto = 0;
      $vendedores[] = $user;
    }

    // ------------------------------
    // DUPLICACION DE DATOS DE EMPRESAS
    $tablas = array();

    $tablas = array(
      "not_categorias",
      "not_entradas",
      "web_slider",
      "web_textos",
    );
    if (empty($vendedores)) {
      $vendedores[] = $marcelo;
    }

    if ($id_empresa_modelo != 0) {
      $this->duplicar_empresa(array(
        "id_empresa"=>$id_empresa,
        "id_empresa_modelo"=>$id_empresa_modelo,
        "tablas"=>$tablas,
        "nombre"=>(isset($array->nombre) ? $array->nombre : ""),
        "email"=>(isset($array->email) ? $array->email : ""),
      ));

      // Si cuando creamos la empresa, elegimos duplicar, y no le configuramos un template, tomamos el de la empresa original
      $sql = "SELECT E.id_web_template FROM empresas E WHERE E.id = $id_empresa_modelo";
      $q_emp = $this->db->query($sql);
      if ($q_emp->num_rows()>0) {
        $emp = $q_emp->row();  
        $sql = "UPDATE empresas SET id_web_template = $emp->id_web_template WHERE id = $id_empresa ";
        $this->db->query($sql);
      }
    }

    // FIN DUPLICACION DE DATOS
    // ------------------------------


    // Ponemos los vendedores
    $encontro_m = false;
    foreach($vendedores as $d) { if ($d->id_usuario == $matias->id_usuario) $encontro_m = true; }
    if (!$encontro_m) $vendedores[] = $matias;
    foreach($vendedores as $d) {
      if (!empty($d)) {
        $q_user = $this->db->query("SELECT * FROM empresas_vendedores WHERE id_empresa = '$id_empresa' AND id_usuario = '$d->id_usuario' ");
        if ($q_user->num_rows() == 0) {
          $this->db->query("INSERT INTO empresas_vendedores (id_empresa,id_usuario,monto) VALUES ('$id_empresa','$d->id_usuario','$d->monto')");
        }
      }
    }
    
    // Tipos de consultas
    $this->load->model("Consulta_Tipo_Model");
    $this->Consulta_Tipo_Model->crear_por_defecto(array(
      "id_empresa"=>$id_empresa,
    ));
        
    // Permisos para ese perfil creado
    // Solamente los modulos que pertenecen al proyecto y son por DEFECTO
    // Si no se copio anteriormente
    $sql = "SELECT * FROM com_modulos_empresas WHERE id_empresa = $id_empresa";
    $q_select = $this->db->query($sql);
    if ($q_select->num_rows() == 0) {

      // PERFIL DE USUARIO ADMINISTRADOR PARA LA EMPRESA
      $this->db->query("INSERT INTO com_perfiles (nombre,id_empresa,principal) VALUES ('Administrador',$id_empresa,1)");
      $id_perfil = $this->db->insert_id();

      $f_tar = date("Y-m-d H:i:s");
      $q = $this->db->query("SELECT * FROM com_modulos M INNER JOIN com_modulos_proyectos MP ON (M.id = MP.id_modulo) WHERE MP.id_proyecto = $array->id_proyecto AND MP.estado = 2");
      foreach($q->result() as $modulo) {
        if ($id_empresa_modelo != 0) {
          // Buscamos el registro de la tabla com_modulos_empresas
          $q_modulo_empresa = $this->db->query("SELECT * FROM com_modulos_empresas WHERE id_modulo = $modulo->id AND id_empresa = $id_empresa_modelo");
          if ($q_modulo_empresa->num_rows()>0) {
            // Y lo copiamos
            $modulo_empresa = $q_modulo_empresa->row();
            $this->db->query("INSERT INTO com_modulos_empresas (id_modulo,id_empresa,fecha_alta,visible,nombre_es,nombre_en) VALUES($modulo->id,$id_empresa,'$f_tar',$modulo_empresa->visible,'$modulo_empresa->nombre_es','$modulo_empresa->nombre_en')");
          }
          // Buscamos el registro de la tabla com_permisos_modulos
          $q_permiso_modulo = $this->db->query("SELECT * FROM com_permisos_modulos WHERE id_modulos = $modulo->id AND id_empresa = $id_empresa_modelo");
          if ($q_permiso_modulo->num_rows()>0) {
            // Y lo copiamos
            $permiso_modulo = $q_permiso_modulo->row();
            $this->db->query("INSERT INTO com_permisos_modulos (id_modulos,id_empresa,id_perfiles,permiso) VALUES($modulo->id,$id_empresa,$id_perfil,$permiso_modulo->permiso)");
          }
        } else {
          // Insertamos los registros en ambas tablas
          $this->db->query("INSERT INTO com_modulos_empresas (id_modulo,id_empresa,fecha_alta,visible) VALUES($modulo->id,$id_empresa,'$f_tar',$modulo->visible)");
          $this->db->query("INSERT INTO com_permisos_modulos (id_modulos,id_empresa,id_perfiles,permiso) VALUES($modulo->id,$id_empresa,$id_perfil,3)");
        }
      }

      // USUARIO PRINCIPAL DE LA CUENTA
      if ($crear_usuario == TRUE) {
        // TODO: controlar que no haya un usuario con el mismo nombre
        $aparece_web = 1;
        // Aca usamos $nombre (que seria el nombre de la persona que se registro, no el nombre de la inmobiliaria)
        $sql = "INSERT INTO com_usuarios (nombre_usuario,password,id_empresa,nombre,fecha_alta,id_perfiles,activo,email,aparece_web,estado_inicial) VALUES (";
        $sql.= "'$nombre','$password',$id_empresa,'$nombre','$f_tar',$id_perfil,1,'$array->email','$aparece_web',1)";
      } else {
        // NO HAY QUE CREAR UN USUARIO, SINO HAY QUE ENLAZARLO CON EL QUE YA SE REGISTRO
        $sql = "UPDATE com_usuarios SET ";
        $sql.= " id_perfiles = '$id_perfil', ";
        $sql.= " id_empresa = '$id_empresa', ";
        $sql.= " activo = 1 ";
        $sql.= "WHERE id_empresa = 0 AND email = '$array->email' ";
      }
      $this->db->query($sql);
    }


    // PERMISOS DE LA RED
    $this->load->model("Notificacion_Model");
    $sql = "SELECT * FROM empresas WHERE id != $id_empresa ";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
      
      // A la empresa creada, le damos los permisos de red del resto de las empresas
      $sql = "INSERT INTO inm_permisos_red (id_empresa, id_empresa_compartida, permiso_red) VALUES (";
      $sql.= " $id_empresa, $r->id, 1 )";
      $this->db->query($sql);
      
      // Al resto de las empresas, le agregamos el permiso de red de la empresa creada
      $sql = "INSERT INTO inm_permisos_red (id_empresa, id_empresa_compartida, permiso_red) VALUES (";
      $sql.= " $r->id, $id_empresa, 1 )";
      $this->db->query($sql);
    }
    
    // Relacionamos los dominios
    foreach($dominios as $d) {
      // Controlamos que no exista el dominio
      $q_dom = $this->db->query("SELECT * FROM empresas_dominios WHERE dominio = '$d' ");
      if ($q_dom->num_rows() == 0) {
        $this->db->query("INSERT INTO empresas_dominios (id_empresa,dominio) VALUES ('$id_empresa','$d')");  
      }
    }

    $array->dominio_varcreative = "app.inmovar.com/sandbox/".$id_empresa."/";
    $this->db->query("UPDATE empresas SET dominio_varcreative = '$array->dominio_varcreative', codigo = '$id_empresa' WHERE id = $id_empresa ");
    
    //$this->db->trans_complete();
    
    /*if ($this->db->trans_status() === FALSE) {
      
      // Hacemos rollback de las carpetas creadas
      @rmdir("uploads/$id_empresa/comprobantes/");
      @rmdir("uploads/$id_empresa/images/");
      @rmdir("uploads/$id_empresa/certificados/produccion/");
      @rmdir("uploads/$id_empresa/certificados/testing/");
      @rmdir("uploads/$id_empresa/certificados/");
      @rmdir("uploads/$id_empresa/slider/");
      @rmdir("uploads/$id_empresa/articulos/");
      @rmdir("uploads/$id_empresa/propiedades/");
      @rmdir("uploads/$id_empresa/paginas/");
      @rmdir("uploads/$id_empresa/marcas/");
      @rmdir("uploads/$id_empresa/entradas/");
      return array(
        "id"=>0,"error"=>TRUE,
        "mensaje"=>$this->db->_error_message()
      );
    } else {*/
      return array("id"=>$id_empresa,"error"=>FALSE);
    //}
  }


  // Esta funcion activa la empresa y manda las notificaciones
  function activar_empresa($id_empresa) {

    $empresa = $this->get_min($id_empresa);
    if ($empresa->activo == 1) return;
    $sql = "UPDATE empresas SET activo = 1, estado_empresa = 10 WHERE id = $id_empresa ";
    $this->db->query($sql);

    // PERMISOS DE LA RED
    $this->load->model("Notificacion_Model");
    $sql = "SELECT * FROM empresas WHERE id != $id_empresa ";
    $q = $this->db->query($sql);
    foreach($q->result() as $r) {
      // Notificacion al resto de las empresas
      $this->Notificacion_Model->insertar(array(
        "id_empresa"=>$r->id,
        "titulo"=>"$empresa->nombre",
        "texto"=>"Dale la bienvenida a un nuevo colega",
        "importancia"=>"B",
        "link"=>$id_empresa,
      ));
    }
  }


  function duplicar_empresa($config = array()) {

    $id_empresa = isset($config["id_empresa"]) ? $config["id_empresa"] : 0;
    $id_empresa_modelo = isset($config["id_empresa_modelo"]) ? $config["id_empresa_modelo"] : 0;
    $tablas = isset($config["tablas"]) ? $config["tablas"] : array();

    // Datos por defecto para crear el nuevo usuario
    $email = isset($config["email"]) ? $config["email"] : "";
    $nombre = isset($config["nombre"]) ? $config["nombre"] : "";

    $q = $this->db->query("SELECT * FROM web_configuracion WHERE id_empresa = $id_empresa_modelo");
    if ($q->num_rows() > 0) {

      // Copiamos algunos campos de la configuracion web, como los colores, etc..
      $web_conf = $q->row();
      $sql = "UPDATE web_configuracion SET ";
      $sql.= " color_principal = '$web_conf->color_principal', ";
      $sql.= " color_secundario = '$web_conf->color_secundario', ";
      $sql.= " color_terciario = '$web_conf->color_terciario', ";
      $sql.= " color_4 = '$web_conf->color_4', ";
      $sql.= " color_5 = '$web_conf->color_5', ";
      $sql.= " color_6 = '$web_conf->color_6', ";
      $sql.= " comp_ultimos = '$web_conf->comp_ultimos', ";
      $sql.= " comp_destacados = '$web_conf->comp_destacados', ";
      $sql.= " comp_banners = '$web_conf->comp_banners', ";
      $sql.= " comp_marcas = '$web_conf->comp_marcas', ";
      $sql.= " comp_newsletter = '$web_conf->comp_newsletter', ";
      $sql.= " comp_footer_grande = '$web_conf->comp_footer_grande', ";
      $sql.= " comp_logos_pagos = '$web_conf->comp_logos_pagos', ";
      $sql.= " comp_slider_2 = '$web_conf->comp_slider_2', ";
      $sql.= " comp_mapa = '$web_conf->comp_mapa', ";
      $sql.= " comp_galeria = '$web_conf->comp_galeria', ";
      $sql.= " comp_categorias = '$web_conf->comp_categorias', ";
      $sql.= " comp_cronograma = '$web_conf->comp_cronograma', ";
      $sql.= " tienda_ver_precios = '$web_conf->tienda_ver_precios', ";
      $sql.= " tienda_carrito = '$web_conf->tienda_carrito', ";
      $sql.= " tienda_consulta_productos = '$web_conf->tienda_consulta_productos', ";
      $sql.= " id_email_carrito_abandonado = '$web_conf->id_email_carrito_abandonado', ";
      $sql.= " tiempo_envio_carrito_abandonado = '$web_conf->tiempo_envio_carrito_abandonado', ";
      $sql.= " tienda_registro_direccion = '$web_conf->tienda_registro_direccion', ";
      $sql.= " tienda_registro_ciudad = '$web_conf->tienda_registro_ciudad', ";
      $sql.= " tienda_registro_documento = '$web_conf->tienda_registro_documento', ";
      $sql.= " tienda_registro_telefono = '$web_conf->tienda_registro_telefono', ";
      $sql.= " tienda_registro_password = '$web_conf->tienda_registro_password', ";
      $sql.= " asuntos_contacto = '$web_conf->asuntos_contacto', ";
      $sql.= " no_imagen = '$web_conf->no_imagen', ";
      $sql.= " color_fondo_imagenes_defecto = '$web_conf->color_fondo_imagenes_defecto', ";
      $sql.= " sin_pagos = '$web_conf->sin_pagos', ";
      $sql.= " sin_envios = '$web_conf->sin_envios', ";
      $sql.= " sin_carrito = '$web_conf->sin_carrito', ";
      $sql.= " configurar_disenio = '$web_conf->configurar_disenio', ";
      $sql.= " subir_elemento = '$web_conf->subir_elemento', ";
      $sql.= " datos_empresa = '$web_conf->datos_empresa', ";
      $sql.= " texto_css = '$web_conf->texto_css', ";
      $sql.= " texto_js = '$web_conf->texto_js', ";
      $sql.= " logo_1 = '$web_conf->logo_1', ";
      $sql.= " logo_2 = '$web_conf->logo_2', ";
      $sql.= " logo_3 = '$web_conf->logo_3', ";
      $sql.= " articulo_mostrar_precio_neto = '$web_conf->articulo_mostrar_precio_neto', ";
      $sql.= " ml_texto_empresa = '$web_conf->ml_texto_empresa', ";
      $sql.= " ml_recargo_precio = '$web_conf->ml_recargo_precio', ";
      $sql.= " tienda_descuento_cantidad_1 = '$web_conf->tienda_descuento_cantidad_1', ";
      $sql.= " tienda_descuento_monto_1 = '$web_conf->tienda_descuento_monto_1', ";
      $sql.= " tienda_descuento_porcentaje_1 = '$web_conf->tienda_descuento_porcentaje_1', ";
      $sql.= " tienda_descuento_cantidad_2 = '$web_conf->tienda_descuento_cantidad_2', ";
      $sql.= " tienda_descuento_monto_2 = '$web_conf->tienda_descuento_monto_2', ";
      $sql.= " tienda_descuento_porcentaje_2 = '$web_conf->tienda_descuento_porcentaje_2', ";
      $sql.= " tienda_descuento_cantidad_3 = '$web_conf->tienda_descuento_cantidad_3', ";
      $sql.= " tienda_descuento_monto_3 = '$web_conf->tienda_descuento_monto_3', ";
      $sql.= " tienda_descuento_porcentaje_3 = '$web_conf->tienda_descuento_porcentaje_3', ";
      $sql.= " tienda_descuento_cantidad_4 = '$web_conf->tienda_descuento_cantidad_4', ";
      $sql.= " tienda_descuento_monto_4 = '$web_conf->tienda_descuento_monto_4', ";
      $sql.= " tienda_descuento_porcentaje_4 = '$web_conf->tienda_descuento_porcentaje_4' ";
      $sql.= "WHERE id_empresa = $id_empresa ";
      $this->db->query($sql);

      // Copiamos la configuraciones especiales de la empresa
      $sql = "SELECT * FROM empresas WHERE id = $id_empresa_modelo";
      $q = $this->db->query($sql);
      $empresa_base = $q->row();
      $this->db->query("UPDATE empresas SET configuraciones_especiales = '$empresa_base->configuraciones_especiales' WHERE id = $id_empresa ");

      // Duplicamos la informacion de las siguientes tablas
      foreach($tablas as $tabla) {
        $q = $this->db->query("SELECT * FROM $tabla WHERE id_empresa = $id_empresa_modelo");
        foreach($q->result() as $row) {
          // Volvemos a insertar la fila, pero con la empresa cambiada
          $row->id_empresa = $id_empresa;

          // Si la tabla es com_usuarios, tenemos que reemplazar el email
          if ($tabla == "com_usuarios" && !empty($email)) {
            $row->email = $email;
            $row->nombre = $nombre;
          }

          $this->db->insert($tabla,$row);
        }
      }

      // Creamos nuevos templates de emails
      $this->load->model("Email_Template_Model");
      $this->Email_Template_Model->insert_preset($id_empresa);

    }

  }

}