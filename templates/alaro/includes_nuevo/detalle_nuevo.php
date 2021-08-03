<?php
$nombre_pagina = "detalle";
$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id,array(
  "id_empresa"=>$id_empresa,
  "id_empresa_original"=>$empresa->id,
));
// Tomamos los datos de SEO
$seo_title = (!empty($propiedad->seo_title)) ? ($propiedad->seo_title) : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? ($propiedad->seo_description) : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? ($propiedad->seo_keywords) : $empresa->seo_keywords;

$nombre_pagina = $propiedad->tipo_operacion_link;
$breadcrumb = array(
  array("titulo"=>$propiedad->tipo_operacion,"link"=>"propiedades/".$propiedad->tipo_operacion_link."/"),
  array("titulo"=>$propiedad->localidad,"link"=>"propiedades/".$propiedad->tipo_operacion_link."/".$propiedad->localidad_link."/"),
  array("titulo"=>$propiedad->nombre,"link"=>$propiedad->link),
);

$precio_maximo = $propiedad_model->get_precio_maximo(array(
  "id_tipo_operacion"=>($propiedad->id_tipo_operacion != 5) ? $propiedad->id_tipo_operacion : 0
));

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad"=>$propiedad->id));

// Minimo
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;

// Maximo
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo;

if ($propiedad->id_tipo_operacion == 1) $vc_moneda = "USD";
else $vc_moneda = "$";
?>  
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "head_new.php" ?>
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?php echo ($propiedad->nombre); ?>" />
  <meta property="og:description" content="<?php echo str_replace("\n","",(strip_tags(html_entity_decode($propiedad->texto,ENT_QUOTES)))); ?>" />
  <meta property="og:image" content="<?php echo current_url(TRUE); ?>/admin/<?php echo $propiedad->path; ?>"/>
  <script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
  <style type="text/css">
  	.slick-dots { display: none !important }
  </style>
</head>
<body>

  <?php include "header_new.php" ?>

  <!-- Page Title -->
  <section class="page-title">
    <div class="container">
      <h1>
        <?php echo ($propiedad->id_tipo_operacion == 1)?"Comprar":"" ?>
        <?php echo ($propiedad->id_tipo_operacion == 2)?"Alquilar":"" ?>
        <?php echo ($propiedad->id_tipo_operacion == 4)?"Emprendimientos":"" ?>
      </h1>
    </div>
  </section>

  <!-- Product Details -->
  <section class="product-detail mb30">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">        
          <?php if (!empty($propiedad->images)) {  ?>
            <div class="banner">
              <div class="slider">
                <?php foreach ($propiedad->images as $i) { ?>
                  <a href="<?php echo $i ?>" class="item" data-fancybox="gallery">
                    <img class="contain-detail" src="<?php echo $i ?>" alt="slide1">
                  </a>
                <?php } ?>
              </div>
              <div class="slider-nav">
                <?php foreach ($propiedad->images as $i) { ?>
                  <div class="item">
                    <img src="<?php echo $i ?>" alt="slide1">
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } else { ?>
            <div class="banner">
              <img src="/admin/<?php echo $propiedad->path ?>" class="contain-detail">
            </div>
          <?php } ?>
          <div class="detail-top">
            <ul>
              <li>
                <div class="about-product">
                  <?php if (!empty($propiedad->dormitorios)) {  ?><span><img src="images/badroom-icon.png" alt="Badroom"> <?php echo $propiedad->dormitorios ?> Habitaci<?php echo ($propiedad->dormitorios > 1)?"ones":"ón" ?></span><?php } ?>
                  <?php if (!empty($propiedad->banios)) {  ?><span><img src="images/shower-icon.png" alt="Shower"> <?php echo $propiedad->banios ?> Baño<?php echo ($propiedad->banios > 1)?"s":"" ?></span><?php } ?>
                  <span><img src="images/sqft-icon.png" alt="Sqft"> <?php echo $propiedad->superficie_total ?> Metros Totales <?php echo (!empty($propiedad->superficie_cubierta))?"| ".$propiedad->superficie_cubierta." Cubiertos" :"" ?> <?php echo (!empty($propiedad->superficie_descubierta))?"| ".$propiedad->superficie_descubierta." Descubiertos" :"" ?></span>
                </div>
                <h2><?php echo $propiedad->nombre ?></h2>              
              </li>
              <li class="price-block">
                <span>
                  <?php echo $propiedad->direccion_completa ?>
                  <?php if (!empty($propiedad->localidad)) { ?>
                    &nbsp;&nbsp;|&nbsp;&nbsp;<?php echo ($propiedad->localidad); ?>
                  <?php } ?>
                </span>
                <big><?php echo ($propiedad->precio_final != 0)?$propiedad->moneda." ".$propiedad->precio_final:"Consultar" ?></big>
              </li>
            </ul>
          </div>
          <?php if (!empty($propiedad->texto)){ ?>
            <div class="border-box-info">
              <div class="row">
                <div class="col-md-12">
                  <h4>Descripción</h4>
                </div>
              </div>
              <p><?php echo $propiedad->texto ?></p>
            </div>
          <?php } ?>

          <?php if ((!empty($propiedad->servicios_electricidad)) || (!empty($propiedad->servicios_gas)) || (!empty($propiedad->servicios_agua_corriente)) || (!empty($propiedad->servicios_cloacas)) || (!empty($propiedad->servicios_asfalto)) || (!empty($propiedad->servicios_telefono)) || (!empty($propiedad->servicios_cable)) || (!empty($propiedad->servicios_aire_acondicionado)) || (!empty($propiedad->servicios_uso_comercial)) || (!empty($propiedad->servicios_internet)) || (!empty($propiedad->gimnasio)) || (!empty($propiedad->parrilla)) || (!empty($propiedad->permite_mascotas)) || (!empty($propiedad->piscina)) || (!empty($propiedad->vigilancia)) || (!empty($propiedad->sala_juegos)) || (!empty($propiedad->ascensor)))  {  ?>
            <div class="border-box-info">
              <div class="row">
                <div class="col-md-12">
                  <h4>servicios</h4>
                </div>
              </div>
              <ul>
                <?php if (!empty($propiedad->servicios_electricidad)) {  ?><li>Electricidad</li><?php } ?>
                <?php if (!empty($propiedad->servicios_gas)) {  ?><li>Gas</li><?php } ?>
                <?php if (!empty($propiedad->servicios_agua_corriente)) {  ?><li>Agua Corriente</li><?php } ?>
                <?php if (!empty($propiedad->servicios_cloacas)) {  ?><li>Cloacas</li><?php } ?>
                <?php if (!empty($propiedad->servicios_asfalto)) {  ?><li>Asfalto</li><?php } ?>
                <?php if (!empty($propiedad->servicios_telefono)) {  ?><li>Teléfono</li><?php } ?>
                <?php if (!empty($propiedad->servicios_cable)) {  ?><li>Cable</li><?php } ?>
                <?php if (!empty($propiedad->servicios_aire_acondicionado)) {  ?><li>Aire</li><?php } ?>
                <?php if (!empty($propiedad->servicios_uso_comercial)) {  ?><li>Uso Comercial</li><?php } ?>
                <?php if (!empty($propiedad->servicios_internet)) {  ?><li>WiFi</li><?php } ?>
                <?php if (!empty($propiedad->gimnasio)) {  ?><li>Gimnasio</li><?php } ?>
                <?php if (!empty($propiedad->parrilla)) {  ?><li>Parrilla</li><?php } ?>
                <?php if (!empty($propiedad->permite_mascotas)) {  ?><li>Permite Mascotas</li><?php } ?>
                <?php if (!empty($propiedad->piscina)) {  ?><li>Piscina</li><?php } ?>
                <?php if (!empty($propiedad->vigilancia)) {  ?><li>Vigilancia</li><?php } ?>
                <?php if (!empty($propiedad->sala_juegos)) {  ?><li>Sala de Juegos</li><?php } ?>
                <?php if (!empty($propiedad->ascensor)) {  ?><li>Ascensor</li><?php } ?>
              </ul>
            </div>
          <?php } ?>
          <div class="border-box-info">
            <div class="row">
              <div class="col-md-12">
                <h4>superficies</h4>
              </div>
              <div class="col-md-3">
                <span>Cubierta:</span>
                <strong><?php echo $propiedad->superficie_cubierta ?></strong>
              </div>
              <div class="col-md-3">
                <span>Descubierta</span>
                <strong><?php echo $propiedad->superficie_descubierta ?></strong>
              </div>
              <div class="col-md-3">
                <span>Semicubierta</span>
                <strong><?php echo $propiedad->superficie_semicubierta ?></strong>
              </div>
              <div class="col-md-3">
                <span>Total</span>
                <strong><?php echo $propiedad->superficie_total ?></strong>
              </div>
            </div>
          </div>
          <?php if (($propiedad->dormitorios > 0) || ($propiedad->banios > 0) || ($propiedad->cocheras > 0) || ($propiedad->patio == 1) || ($propiedad->balcon == 1)) { ?>
            <div class="border-box-info">
              <div class="row">
                <div class="col-md-12">
                  <h4>ambientes</h4>
                </div>
              </div>
              <ul>
                <?php if ($propiedad->dormitorios > 0) {  ?>
                  <LI>Dormitorio</LI>
                <?php } ?>
                <?php if ($propiedad->banios > 0) {  ?>
                  <LI>Baño</LI>
                <?php } ?>
                <?php if ($propiedad->cocheras > 0) {  ?>
                  <LI>Cochera</LI>
                <?php } ?>
                <?php if ($propiedad->patio == 1) {  ?>
                  <LI>Patio</LI>
                <?php } ?>
                <?php if ($propiedad->balcon == 1) {  ?>
                  <LI>Balcón</LI>
                <?php } ?>
              </ul>
            </div>
          <?php } ?>
          <div class="border-box-info">
            <div class="row">
              <div class="col-md-12">
                <h4>adicionales</h4>
              </div>
              <div class="col-md-3">
                <span>Apto Crédito:</span>
                <strong><?php echo ($propiedad->apto_banco == 1)?"Sí":"No" ?></strong>
              </div>
              <div class="col-md-3">
                <span>Acepta Permuta:</span>
                <strong><?php echo ($propiedad->acepta_permuta == 1)?"Sí":"No" ?></strong>
              </div>
            </div>
          </div>
          <div class="map-block">
            <h4>ubicación en mapa</h4>
            <div id="map1"></div>
          </div>
        </div>
        <div class="col-lg-4 pl-5">
          <div class="sidebar-box">
            <h2>enviar consulta</h2>
            <div class="sidebar-border-box">
              <form onsubmit="return enviar_contacto()">
                <div class="form-group">
                  <input class="form-control" id="contacto_nombre" type="text" name="Nombre *" placeholder="Nombre *">
                </div>
                <div class="form-group">
                  <input class="form-control" id="contacto_email" type="email" name="Email *" placeholder="Email *">
                </div>
                <div class="form-group">
                  <input class="form-control" id="contacto_telefono" type="tel" name="WhatsApp (sin 0 ni 15) *" placeholder="WhatsApp (sin 0 ni 15) *">
                </div>
                <div class="form-group">
                  <textarea class="form-control" id="contacto_mensaje" placeholder="Estoy interesado en “Duplex en venta en Ringuelet Cod: 1234”"></textarea>
                </div>
                <button id="contacto_submit" type="submit" class="btn btn-secoundry">Enviar por Email</button>
                <a class="btn btn-whatsup" href="javascript:void(0)" onclick="return enviar_contacto_whatsapp()"><img src="images/whatsapp2.png" alt="Whatsapp Icon" width="24"> enviar whatsapp</a>
              </form>
            </div>
            <div class="social">
              <span>Compartir:</span>
              <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()) ?>" target="_blank" ><i class="fa fa-facebook" aria-hidden="true"></i></a>
              <a target="_blank" href="https://api.whatsapp.com/send?text=<?php echo urlencode(current_url()) ?>"><i class="fa fa-whatsapp"></i></a>
              <a href="javascript:void(0)"><i class="fa fa-link"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Product Listing -->
  <?php if (!empty($propiedad->relacionados)) {  ?>
    <section class="product-listing">
      <div class="container">
        <div class="section-title">
          <h2>propiedades similares</h2>
        </div>
        <div class="owl-carousel" data-items="3" data-items-lg="2" data-margin="35" data-loop="true" data-nav="true" data-dots="true">
          <?php foreach ($propiedad->relacionados as $p) { 
            $link_propiedad = (isset($p->pertenece_red) && $p->pertenece_red == 1) ? mklink($p->link)."&em=".$p->id_empresa : mklink($p->link); ?>
            <div class="item">
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
                    <li>
                      <strong><?php echo ($p->precio !=0)?$p->precio:"Consultar" ?></strong>
                    </li>
                  </ul>
                  <div class="average-detail">
                    <?php if ($p->dormitorios != "0") {  ?><span><img src="images/badroom-icon.png" alt="Badroom Icon"> <?php echo $p->dormitorios  ?></span><?php } ?>
                    <?php if ($p->banios != "0") {  ?><span><img src="images/shower-icon.png" alt="Shower Icon"> <?php echo $p->banios ?></span><?php } ?>
                    <?php if ($p->superficie_total != "0") {  ?><span><img src="images/sqft-icon.png" alt="SQFT Icon"> <?php echo $p->superficie_total ?> m2</span><?php } ?>
                  </div>
                  <div class="btns-block">
                    <a href="<?php echo ($p->link_propiedad) ?>" class="btn btn-secoundry">Ver Detalles</a>
                    <a href="<?php echo ($p->link_propiedad) ?>#contacto_nombre" class="icon-box"></a>
                    <a href="#0" data-toggle="modal" data-target="#exampleModalCenter"  class="icon-box whatsapp-box"></a>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>    
      </div>
    </section>
  <?php } ?>

  <!-- Footer -->
  <?php include "footer_new.php" ?>

  <!-- Scripts -->
  <script src="js/correa/jquery.min.js"></script>
  <script src="js/correa/bootstrap.bundle.min.js"></script>
  <script src="js/correa/html5.min.js"></script>
  <script src="js/correa/respond.min.js"></script>
  <script src="js/correa/placeholders.min.js"></script>
  <script src="js/correa/owl.carousel.min.js"></script>
  <script src="js/correa/slick.min.js"></script>
  <script src="js/correa/scripts.js"></script>
  <script type="text/javascript"></script>
  <script type="text/javascript">
    function enviar_contacto() {
      var nombre = jQuery("#contacto_nombre").val();
      var email = jQuery("#contacto_email").val();
      var mensaje = jQuery("#contacto_mensaje").val();
      var telefono = jQuery("#contacto_telefono").val();

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
        "asunto":"Consulta por: <?php echo $propiedad->nombre ?>",
        "mensaje":mensaje,
        "id_propiedad":"<?php echo $propiedad->id ?>",
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
            location.reload();
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
    function enviar_contacto_whatsapp() {
      var nombre = jQuery("#contacto_nombre").val();
      var email = jQuery("#contacto_email").val();
      var mensaje = jQuery("#contacto_mensaje").val();
      var telefono = jQuery("#contacto_telefono").val();

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
        "asunto":"Consulta por: <?php echo $propiedad->nombre ?>",
        "mensaje":mensaje,
        "id_propiedad":"<?php echo $propiedad->id ?>",
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
  <link rel="stylesheet" type="text/css" href="css/correa/jquery.fancybox.min.css">
  <script type="text/javascript" src="js/correa/jquery.fancybox.min.js"></script>
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
    $(document).ready(function(){
      var maximo = 0;
      $(".product-details .average-detail").each(function(i,e){
        if ($(e).height() > maximo) maximo = $(e).height();
      });
      maximo = Math.ceil(maximo);
      $(".product-details .average-detail").height(maximo);
    });
  </script>
  <?php if (isset($propiedad->latitud) && isset($propiedad->longitud) && $propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
    <?php include_once("templates/comun/mapa_js.php"); ?>
    <script type="text/javascript">
      $(document).ready(function(){
        mostrar_mapa(); 
      });
      function mostrar_mapa() {

        <?php if (!empty($propiedad->latitud && !empty($propiedad->longitud))) { ?>
          var mymap = L.map('map1').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);

          L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
            tileSize: 512,
            maxZoom: 18,
            zoomOffset: -1,
            id: 'mapbox/streets-v11',
            accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
          }).addTo(mymap);

          L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>]).addTo(mymap);

        <?php } ?>
      }
    </script>
  <?php } ?>
  <script type="text/javascript">
    $('.slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: '.slider',
      dots: true,
      arrows: true,
      centerMode: false,
      focusOnSelect: true
    });
  </script>
  <?php 
// Creamos el codigo de seguimiento para registrar la visita
  echo $propiedad_model->tracking_code(array(
    "id_propiedad"=>$propiedad->id,
    "id_empresa_compartida"=>$id_empresa,
    "id_empresa"=>$empresa->id,
  ));
  ?>
</body>
</html>