<?php 
$get_params["offset"] = 12;
extract($propiedad_model->get_variables(array(
  "solo_propias"=>1,
)));
if (isset($params[1])) {
  if ($params[1] == "proximos-proyectos") {
    $get_params["offset"] = 999;
    $vc_listado = $propiedad_model->get_list(array("ids_tipo_operacion"=>"6,7","offset"=>999,"solo_propias"=>1));
    $vc_total_resultados = sizeof($vc_listado);
  }
}
if (isset($params[1])) {
  if ($params[1] == "proyectos-finalizados") {
    $get_params["offset"] = 999;
    extract($propiedad_model->get_variables());
    $vc_total_resultados = sizeof($vc_listado);
  }
}
if (isset($params[1])) {
  if ($params[1] == "proyectos-en-construccion") {
    $get_params["offset"] = 999;
    $vc_listado = $propiedad_model->get_list(array("id_tipo_operacion"=>6,"solo_propias"=>1));
    $vc_total_resultados = sizeof($vc_listado);
  }
}
if (isset($params[1])) {
  if ($params[1] == "proyectos-a-estrenar") {
    $get_params["offset"] = 999;
    $vc_listado = $propiedad_model->get_list(array("id_tipo_operacion"=>7,"solo_propias"=>1));
    $vc_total_resultados = sizeof($vc_listado);
  }
}
$page_act = $vc_link_tipo_operacion;
$localidades = $propiedad_model->get_localidades();
foreach($localidades as $l) { 
 if ($l->link == $vc_link_localidad) { 
  $vc_nombre_localidad = $l->nombre;
  $vc_link_localidad = $l->link;
 }
}
$tipos_propiedades = $propiedad_model->get_tipos_propiedades();
foreach($tipos_propiedades as $l) { 
 if ($l->id == $vc_id_tipo_inmueble) { 
  $vc_nombre_tipo_propiedad = $l->nombre;
 }
}
$vc_banios = isset($get_params["bn"]) ? $get_params["bn"] : 0;
$vc_dormitorios= isset($get_params["dm"]) ? $get_params["dm"] : 0;
$conservar = '0-9'; // juego de caracteres a conservar
$regex = sprintf('~[^%s]++~i', $conservar); // case insensitive
$empresa->telefono_num = preg_replace($regex, '', $empresa->telefono);
$empresa->telefono_num_2 = preg_replace($regex, '', $empresa->telefono_2);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "head_new.php" ?>
  <style type="text/css">
    .edit {
    margin: 0 30px;
    min-width: 108px;
    height: 46px !important;
    padding: 8px 50px 8px 20px;
    line-height: normal;
    color: #222222 !important;
    border: 2px solid #dfdfdf !important;
    background-color: #fff !important;
    border-radius: 8px !important;
    text-align: center;
    font-size: 18px;
    text-transform: none;
    font-weight: 400 !important;
    background-position: 90% 50%;
    background-repeat: no-repeat;
    background-size: 15px auto;
   }
  </style>
</head>
<body>

  <?php include "header_new.php" ?>

  <!-- Page Title -->
  <section class="page-title">
    <div class="container">
      <h1>
        <?php echo ($vc_link_tipo_operacion == "alquileres")?"Alquileres":"" ?>
        <?php echo ($vc_link_tipo_operacion == "ventas")?"Ventas":"" ?>
        <?php echo ($vc_link_tipo_operacion == "emprendimientos")?"Emprendimientos":"" ?>
        <?php echo ($vc_link_tipo_operacion == "proyectos-finalizados")?"Proyectos Finalizados":"" ?>
        <?php echo ($vc_link_tipo_operacion == "proximos-proyectos")?"Edificios en desarrollo":"" ?>
        <?php echo ($vc_link_tipo_operacion == "proyectos-a-estrenar" || $vc_link_tipo_operacion == "proyectos-en-construccion")?"Edificios en desarrollo":"" ?>
      </h1>
    </div>
  </section>

  <!-- Product Category -->

  <form id="form_propiedades">
    <input type="hidden" id="localidad" value="<?php echo (!empty($vc_link_localidad))?$vc_link_localidad:"todas" ?>" name="">
    <input type="hidden" id="tp" value="<?php echo (!empty($vc_id_tipo_inmueble))?$vc_id_tipo_inmueble:"todas" ?>" name="tp">
    <input type="hidden" id="dm" value="<?php echo (!empty($vc_dormitorios))?"$vc_dormitorios":"" ?>" name="dm">
    <input type="hidden" id="bn" value="<?php echo (!empty($vc_banios))?"$vc_banios":"" ?>" name="bn">
    <input type="hidden" id="moneda" value="ARS" name="m">
    <input type="hidden" id="banco" value="<?php echo (!empty($vc_apto_banco) == 1)?"1":"" ?>" name="banco">
    <input type="hidden" id="per" value="<?php echo (!empty($vc_acepta_permuta) == 1)?"1":"" ?>" name="per">
    <input type="hidden" id="vc_minimo" value="<?php echo (!empty($vc_minimo))?"$vc_minimo":"" ?>" name="vc_minimo">
    <input type="hidden" id="vc_maximo" value="<?php echo (!empty($vc_maximo))?"$vc_maximo":"" ?>" name="vc_maximo">
    <input type="hidden" id="tipo_operacion" value="<?php echo (!empty($vc_link_tipo_operacion))?$vc_link_tipo_operacion:"todas" ?>" name="">
  </form>
  <?php if ($vc_link_tipo_operacion != "proyectos-finalizados" && $vc_link_tipo_operacion != "proximos-proyectos" && $vc_link_tipo_operacion != "proyectos-en-construccion" && $vc_link_tipo_operacion != "proyectos-a-estrenar")  {  ?>
    <div class="product-category">
    <div class="container">
      <div class="left-menu">
        <nav class="navbar navbar-expand-lg navbar-light">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownlocalidades" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo (!empty($vc_nombre_localidad))?$vc_nombre_localidad:"Localidades" ?> 
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownlocalidades">
                  <?php $localidades = $propiedad_model->get_localidades()?>
                  <?php foreach ($localidades as $l) {  ?>
                    <a class="localidad dropdown-item <?php echo ($l->link == $vc_link_localidad)?"active":"" ?>" href="javascript:void(0)" onclick="change_localidad('<?php echo $l->link ?>','<?php echo $l->nombre?>')"><?php echo $l->nombre ?></a>
                  <?php } ?>
                  <!-- <div class="bottom-button">
                    <a href="javascript:void(0)">Cancelar</a>
                    <a href="javascript:void(0)" onclick="enviar_buscador_propiedades()">Aplicar</a>
                  </div> -->
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdowntipospropiedad" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo (!empty($vc_nombre_tipo_propiedad))?$vc_nombre_tipo_propiedad:"Tipo de Propiedad" ?> 
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdowntipospropiedad">
                  <?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades()?>
                  <?php foreach ($tipos_propiedades as $l) {  ?>
                    <a class="tp dropdown-item <?php echo ($l->id == $vc_id_tipo_inmueble)?"active":"" ?>" href="javascript:void(0)" onclick="change_tp('<?php echo $l->id ?>','<?php echo $l->nombre?>')"><?php echo $l->nombre ?></a>
                  <?php } ?>
                  <!-- <div class="bottom-button">
                    <a href="javascript:void(0)">Cancelar</a>
                    <a href="javascript:void(0)" onclick="enviar_buscador_propiedades()">Aplicar</a>
                  </div> -->
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdowndormitorios" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Dormitorios
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdowndormitorios">
                  <?php $dormitorios = $propiedad_model->get_dormitorios()?>
                  <?php foreach ($dormitorios as $l) { 
                    if ($l->dormitorios != 0) {   ?>
                    <a class="dm dropdown-item <?php echo ($vc_dormitorios == $l->dormitorios)?"active":""?>" href="javascript:void(0)" onclick="change_dm('<?php echo $l->dormitorios ?>')"><?php echo $l->dormitorios  ?></a>
                    <?php } ?>
                  <?php } ?>
                  
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownbanios" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Baños
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownbanios">
                  <?php $banios = $propiedad_model->get_banios()?>
                  <?php foreach ($banios as $l) {
                    if ($l->banios != 0 && $l->banios < 5) {   ?>
                    <a class="bn dropdown-item <?php echo ($vc_banios == $l->banios)?"active":""?>" href="javascript:void(0)" onclick="change_bn('<?php echo $l->banios ?>')"><?php echo $l->banios  ?></a>
                    <?php } ?>
                  <?php } ?>
                  
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Precios
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item <?php echo ($vc_maximo == "25000" && $vc_minimo == "0")?"active":"" ?>" href="javascript:void(0)" onclick="change_price('0','25000')">Hasta 25.000</a>
                  <a class="dropdown-item <?php echo ($vc_maximo == "50000" && $vc_minimo == "25000")?"active":"" ?>" href="javascript:void(0)" onclick="change_price('25000','50000')">25.000 a 50.000</a>
                  <a class="dropdown-item <?php echo ($vc_maximo == "75000" && $vc_minimo == "50000")?"active":"" ?>" href="javascript:void(0)" onclick="change_price('50000','75000')">50.000 a 75.000</a>
                  <a class="dropdown-item <?php echo ($vc_maximo == "100000" && $vc_minimo == "75000")?"active":"" ?>" href="javascript:void(0)" onclick="change_price('75000','100000')">75.000 a 100.000</a>
                  <a class="dropdown-item <?php echo ($vc_maximo == "150000" && $vc_minimo == "100000")?"active":"" ?>" href="javascript:void(0)" onclick="change_price('100000','150000')">100.000 a 150.000</a>
                  <a class="dropdown-item <?php echo ($vc_maximo == "" && $vc_minimo == "150000")?"active":"" ?>" href="javascript:void(0)" onclick="change_price('150000','')">Más de 150.000</a>
                  <!-- <div class="bottom-button">
                    <a href="#0">Cancelar</a>
                    <a href="#0">Aplicar</a>
                  </div> -->
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownbanios" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Adicionales
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownbanios">
                  <a class="bn dropdown-item <?php echo ($vc_acepta_permuta == 1)?"active":"" ?>" href="javascript:void(0)" onclick="change_permuta()">Acepta Permuta</a>
                  <a class="bn dropdown-item <?php echo ($vc_apto_banco == 1)?"active":"" ?>" href="javascript:void(0)" onclick="change_banco()">Apto Banco</a>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </div>
      <div class="right-button">
        <a class="btn btn-secoundry" href="<?php echo mklink ("propiedades/$vc_link_tipo_operacion/todas/") ?>">Limpiar Filtros</a>
      </div>
    </div>
  </div>
<?php } ?>

  <!-- Product Listing -->
  <section class="product-listing inner-listing">
    <div class="container">
      <div class="section-title">
        <div class="title-left">
          <h2>
            <?php echo ($vc_link_tipo_operacion == "alquileres")?"Propiedades en alquiler":"" ?>
            <?php echo ($vc_link_tipo_operacion == "ventas")?"Propiedades en venta":"" ?>
            <?php echo ($vc_link_tipo_operacion == "emprendimientos")?"Emprendimientos":"" ?>
            <?php echo ($vc_link_tipo_operacion == "proyectos-finalizados")?"Todos los proyectos":"" ?>
            <?php echo ($vc_link_tipo_operacion == "proximos-proyectos")?"Todos los proyectos":"" ?>
            <?php echo ($vc_link_tipo_operacion == "proyectos-a-estrenar")?"Edificios a estrenar":"" ?>
            <?php echo ($vc_link_tipo_operacion == "proyectos-en-construccion")?"Edificios en construcción":"" ?>

          </h2>
         <!--  <?php if (!empty($vc_listado)) {  ?>
            <span>Se encontr<?php echo ($vc_total_resultados > 1)?"aron":"ó" ?> <?php echo $vc_total_resultados ?> propiedad<?php echo ($vc_total_resultados > 1)?"es":"" ?></span>
          <?php } else { ?>
            <span>No se encontraron resultados para su búsqueda.</span>
          <?php }?> -->
        </div>
        <?php if ($vc_link_tipo_operacion != "proyectos-finalizados" && $vc_link_tipo_operacion != "proximos-proyectos" && $vc_link_tipo_operacion != "proyectos-en-construccion" && $vc_link_tipo_operacion != "proyectos-a-estrenar")  {  ?>
          <div class="title-right">
            <form action="<?php echo mklink ("propiedades/".(empty($vc_link_tipo_operacion)?"todas":$vc_link_tipo_operacion)."/".(empty($vc_link_localidad)?"todas":$vc_link_localidad)."/?tp=".(empty($vc_id_tipo_inmueble)?"":$vc_id_tipo_inmueble)) ?>" method="GET" id="orden_form">
              <small>ordenar por:</small>
              <input type="hidden"  name="tp" value="<?php echo $vc_id_tipo_inmueble?>">
              <select onchange="enviar_orden()" name="orden" class="form-control">
                <option <?php echo ($vc_orden == -1 ) ? "selected" : "" ?> value="nuevo">Ver los más nuevos</option>
                <option <?php echo ($vc_orden == 2 ) ? "selected" : "" ?> value="barato">Precio menor a mayor</option>
                <option <?php echo ($vc_orden == 1 ) ? "selected" : "" ?> value="caro">Precio mayor a menor</option>
                <option <?php echo ($vc_orden == 4 ) ? "selected" : "" ?> value="destacados">Destacados</option>
              </select>  
            </form>
          </div> 
        <?php } elseif ($vc_link_tipo_operacion != "proyectos-finalizados") { ?>
          <!-- <div class="title-right">
            <form>
              <small>PROYECTOS:</small>
              <select name="enviar_proyectos" class="form-control" id="enviar_proyectos">
                <option value="<?php echo mklink ("propiedades/proximos-proyectos/") ?>">TODOS</option>
                <option <?php echo ($vc_link_tipo_operacion == "proyectos-en-construccion" ) ? "selected" : "" ?> value="<?php echo mklink ("propiedades/proyectos-en-construccion/") ?>">EN CONSTRUCCIÓN</option>
                <option <?php echo ($vc_link_tipo_operacion == "proyectos-a-estrenar" ) ? "selected" : "" ?> value="<?php echo mklink ("propiedades/proyectos-a-estrenar/") ?>">A ESTRENAR</option>
              </select>  
            </form>
          </div> -->
        <?php } ?>
      </div>
      <div class="row">
        <?php foreach ($vc_listado as $p) {   
          $link_propiedad = (isset($p->pertenece_red) && $p->pertenece_red == 1) ? mklink($p->link)."&em=".$p->id_empresa : mklink($p->link); ?>          
          <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="product-list-item">
              <div class="product-img">
                <a href="<?php echo ($p->link_propiedad) ?>"><img class="cover-home" src="/admin/<?php echo $p->path ?>" alt="Product"></a>
              </div>
              <div class="product-details">
                <h4><?php echo $p->nombre ?></h4>
                <h5>
                <?php echo $p->direccion_completa ?>
                <?php if (!empty($p->localidad)) { ?>
                &nbsp;&nbsp;|&nbsp;&nbsp;<?php echo ($p->localidad); ?>
                <?php } ?>
                </h5>
                <ul>
                  <?php if ($vc_link_tipo_operacion != "proyectos-finalizados" && $vc_link_tipo_operacion != "proximos-proyectos" && $vc_link_tipo_operacion != "proyectos-a-estrenar" && $vc_link_tipo_operacion != "proyectos-en-construccion") { ?>
                    <li>
                      <strong><?php echo ($p->precio_final !=0)?$p->moneda." ".$p->precio_final:"Consultar" ?></strong>
                    </li>
                  <?php } ?>
                </ul>
                  <div class="average-detail  <?php echo ($vc_link_tipo_operacion == "proyectos-finalizados" || $vc_link_tipo_operacion == "proximos-proyectos" || $vc_link_tipo_operacion == "proyectos-en-construccion" || $vc_link_tipo_operacion == "proyectos-a-estrenar")?"pt0":""  ?>">
                     <?php if ($p->dormitorios != "0") {  ?><span><img src="images/badroom-icon.png" alt="Badroom Icon"> <?php echo $p->dormitorios  ?></span><?php } ?>
                    <?php if ($p->banios != "0") {  ?><span><img src="images/shower-icon.png" alt="Shower Icon"> <?php echo $p->banios ?></span><?php } ?>
                     <?php if ($p->superficie_total != "0") {  ?><span><img src="images/sqft-icon.png" alt="SQFT Icon"> <?php echo $p->superficie_total ?> m2</span><?php } ?>
                  </div>
                <div class="btns-block">
                  <?php if ($vc_link_tipo_operacion != "proyectos-finalizados") {  ?>
                    <a href="<?php echo ($p->link_propiedad) ?>" class="btn btn-secoundry">Más Información</a>
                    <a href="<?php echo ($p->link_propiedad) ?>#contacto_nombre" class="icon-box"></a>
                    <a href="#0" onclick="llenar_id(<?php echo $p->id ?>)" data-toggle="modal" data-target="#exampleModalCenter" class="icon-box whatsapp-box"></a>
                  <?php } else { ?>
                    <a href="<?php echo ($p->link_propiedad) ?>" class="btn btn-secoundry w-100">ver galería de fotos</a>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <?php if ($vc_total_paginas > 1) {  ?>
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <?php if ($vc_page > 0) { ?>
              <li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"><i class="fa fa-chevron-left"></i></a></li>
            <?php } ?>
            <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
              <?php if (abs($vc_page-$i)<2) { ?>
                <?php if ($i == $vc_page) { ?>
                  <li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $i+1 ?></a></li>
                <?php } else { ?>
                  <li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.$i."/".$vc_params ) ?>"><?php echo $i+1 ?></a></li>
                <?php } ?>
              <?php } ?>
            <?php } ?>
            <?php if ($vc_page < $vc_total_paginas-1) { ?>
              <li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params ) ?>"><i class="fa fa-chevron-right"></i></a></li>
            <?php } ?>
          </ul>
        </nav>
      <?php } ?>
    </div>
  </section>

  <!-- Footer -->
  <?php include "footer_new.php" ?>

  <!-- Scripts -->
  <script src="js/correa/jquery.min.js"></script>
  <script src="js/correa/bootstrap.bundle.min.js"></script>
  <script src="js/correa/html5.min.js"></script>
  <script src="js/correa/respond.min.js"></script>
  <script src="js/correa/placeholders.min.js"></script>
  <script src="js/correa/owl.carousel.min.js"></script>
  <script src="js/correa/scripts.js"></script>
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5><img src="images/whatsapp-icon-2.png" alt="Whatsapp"> enviar whatsapp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <img src="images/popup-close.png" alt="Close Btn">
                </button>
              </div>
              <div class="modal-body">
                <form onsubmit="return enviar_contacto()">
                  <div class="form-group">
                    <input type="hidden" value="" id="contacto_id_propiedad" name="">
                    <input type="name" name="Nombre *" id="contacto_nombre" placeholder="Nombre *" class="form-control">
                  </div>
                  <div class="form-group">
                    <input type="email" name="Email *" id="contacto_email" placeholder="Email *" class="form-control">
                  </div>
                  <div class="form-group">
                    <input type="tel" name="WhatsApp (sin 0 ni 15) *" id="contacto_telefono" placeholder="WhatsApp (sin 0 ni 15) *" class="form-control">
                  </div>
                  <div class="form-group">
                    <textarea id="contacto_mensaje" placeholder="Estoy interesado en “Duplex en venta en Ringuelet Cod: 1234”" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <button type="submit" id="contacto_submit" class="btn">hablar ahora</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
  <script type="text/javascript">
    function llenar_id(item) { 
      $("#contacto_id_propiedad").val(item);
    } 
  </script>
  <script type="text/javascript">
          function enviar_contacto() {

            var nombre = jQuery("#contacto_nombre").val();
            var email = jQuery("#contacto_email").val();
            var mensaje = jQuery("#contacto_mensaje").val();
            var telefono = jQuery("#contacto_telefono").val();
            var id_propiedad = jQuery("#contacto_id_propiedad").val();

            if (isEmpty(nombre) || nombre == "Nombre") {
              alert("Por favor ingrese un nombre");
              jQuery("#contacto_nombre").focus();
              return false;          
            }


            if (isEmpty(telefono) || telefono == "telefono") {
              alert("Por favor ingrese un telefono");
              jQuery("#contacto_telefono").focus();
              return false;          
            }

            if (!validateEmail(email)) {
              alert("Por favor ingrese un email valido");
              jQuery("#contacto_email").focus();
              return false;          
            }
            if (isEmpty(mensaje) || mensaje == "Mensaje") {
              alert("Por favor ingrese un mensaje");
              jQuery("#contacto_mensaje").focus();
              return false;              
            }    
            jQuery("#contacto_submit").attr('disabled', 'disabled');
            var datos = {
              "para":"<?php echo $empresa->email ?>",
              "nombre":nombre,
              "telefono":telefono,
              "email":email,
              "asunto":"Consulta por propiedad",
              "mensaje":mensaje,
              "id_propiedad":id_propiedad,
              "id_empresa":ID_EMPRESA,
            }
            jQuery.ajax({
              "url":"/admin/consultas/function/enviar/",
              "type":"post",
              "dataType":"json",
              "data":datos,
              "success":function(r){
                if (r.error == 0) {
                  alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
                <?php if ($nombre_pagina == "alquileres") {  ?>
                  window.location.href = "https://api.whatsapp.com/send?phone=542216822274&text="+ mensaje;
                <?php } else {  ?>
                  window.location.href = "https://api.whatsapp.com/send?phone=5492216519750&text="+ mensaje;
                <?php } ?>
                } else {
                  alert("Ocurrio un error al enviar su email. Disculpe las molestias");
                  jQuery("#contacto_submit").removeAttr('disabled');
                }
              }
            });
            return false;
          }
        </script>
        
  <script type="text/javascript">
    function change_localidad (link,nombre) { 
      $('#localidad').val(link);
      enviar_buscador_propiedades()
    }
    function change_tp (link,nombre) { 
      $('#tp').val(link);
      enviar_buscador_propiedades()
    }
    function change_bn (link,nombre) { 
      $('#bn').val(link);
      enviar_buscador_propiedades()
    }
    function change_dm (dm) { 
      $('#dm').val(dm);
      enviar_buscador_propiedades()
    }
    function change_price (min,max) { 
      $('#vc_minimo').val(min);
      $('#vc_maximo').val(max);
      enviar_buscador_propiedades()
    }
     function change_permuta () { 
      $('#per').val(1);
      enviar_buscador_propiedades()
    }
     function change_banco () { 
      $('#banco').val(1);
      enviar_buscador_propiedades()
    }

   </script>
  <script type="text/javascript">
  $(document).ready(function(){
    var maximo = 0;
    $(".product-details h4").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".product-details h4").height(maximo);
  });

   $(document).ready(function(){
    var maximo = 0;
    $(".product-details h5").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".product-details h5").height(maximo);
  });
<?php if ($vc_link_tipo_operacion != "proyectos-finalizados" && $vc_link_tipo_operacion != "proximos-proyectos" && $vc_link_tipo_operacion != "proyectos-en-construccion" && $vc_link_tipo_operacion != "proyectos-a-estrenar")  {  ?>
  $(document).ready(function(){
    var maximo = 0;
    $(".product-details .average-detail").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".product-details .average-detail").height(maximo);
  });
<?php } ?>
</script>
<script>
    $(function(){
      // bind change event to select
      $('#enviar_proyectos').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>
<script type="text/javascript">
  function enviar_orden() { 
    $("#orden_form").submit();
  }
  function enviar_buscador_propiedades() { 
    var link = "<?php echo mklink("propiedades/")?>";
    var tipo_operacion = $("#tipo_operacion").val();
    var localidad = $("#localidad").val();
    link = link + tipo_operacion + "/" + localidad + "/";
    $("#form_propiedades").attr("action",link);
    $("#form_propiedades").submit();
    return true;
  }
</script>
</body>
</html>