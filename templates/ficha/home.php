<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
$ver_precios = ($empresa->tienda_ver_precios == 0 || ($empresa->tienda_ver_precios == 1 && isset($_SESSION["id_cliente"])));
$ver_carrito = ($empresa->tienda_carrito < 2);
$ver_consulta = ($empresa->tienda_consulta_productos == 0);
$incluir_buscador_neumaticos = (isset($empresa->tipo_empresa)) ? (($empresa->tipo_empresa == 1)?1:0) : 0;
$incluir_turnos = (isset($empresa->tipo_empresa)) ? (($empresa->tipo_empresa == 2 || isset($empresa->config["incluir_turnos"]))?1:0) : 0;

$boton_comprar_ahora = isset($empresa->config["boton_comprar_ahora"]) ? $empresa->config["boton_comprar_ahora"] : "comprar ahora";
$boton_comprar = isset($empresa->config["boton_comprar"]) ? $empresa->config["boton_comprar"] : "COMPRAR";
$boton_agregar_carrito = isset($empresa->config["boton_agregar_carrito"]) ? $empresa->config["boton_agregar_carrito"] : "agregar al carrito";
$ocultar_boton_agregar_carrito = isset($empresa->config["ocultar_boton_agregar_carrito"]) ? $empresa->config["ocultar_boton_agregar_carrito"] : 0;
$ocultar_boton_comprar = isset($empresa->config["ocultar_boton_comprar"]) ? $empresa->config["ocultar_boton_comprar"] : 0;
?>
<?php if (!empty($empresa->gtm_head)) { echo html_entity_decode($empresa->gtm_head,ENT_QUOTES); } ?>
<base href="/templates/ficha/"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<?php 
$title = (isset($seo_title)) ? (html_entity_decode($seo_title,ENT_QUOTES)) : (html_entity_decode($empresa->seo_title,ENT_QUOTES));
$title = str_replace("\n", " ", $title);
?>
<title><?php echo $title ?></title>

<?php 
$description = (isset($seo_description)) ? (html_entity_decode($seo_description,ENT_QUOTES)) : (html_entity_decode($empresa->seo_description,ENT_QUOTES));
$description = str_replace("\n", " ", $description);
?>
<meta name="description" content="<?php echo $description ?>">

<?php 
$keywords = (isset($seo_keywords)) ? (html_entity_decode($seo_keywords,ENT_QUOTES)) : (html_entity_decode($empresa->seo_keywords,ENT_QUOTES));
$keywords = str_replace("\n", " ", $keywords);
?>
<meta name="keywords" content="<?php echo $keywords ?>">

<?php include_once("templates/comun/ldjson/organization.php"); ?>

<?php if (strpos(strtolower($empresa->favicon), ".png")>0) { ?>
  <link rel="shortcut icon" type="image/png" href="/admin/<?php echo $empresa->favicon ?>"/>
<?php } else if (strpos(strtolower($empresa->favicon), ".ico")>0) { ?>
  <link rel="shortcut icon" type="image/x-icon" href="/admin/<?php echo $empresa->favicon ?>" />
<?php } else { ?>
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<?php } ?>

<link href="/admin/resources/css/common.css" media="all" type="text/css" rel="stylesheet"/>

<?php if (isset($incluir_buscador_neumaticos) && $incluir_buscador_neumaticos == 1) { ?>
  <?php include_once("templates/comun/neumaticos/buscador_css.php"); ?>
<?php } ?>

<?php if (isset($incluir_turnos) && $incluir_turnos == 1) { ?>
  <link rel="stylesheet" type="text/css" href="/admin/resources/js/jquery/ui/jquery-ui.min.css">
  <link rel="stylesheet" type="text/css" href="/admin/resources/js/jquery/ui/jquery-ui.theme.min.css">
<?php } ?>


<style type="text/css">
:root {
  <?php if (!empty($empresa->color_principal)) { ?>
    --c1: <?php echo $empresa->color_principal ?>;
  <?php } ?>
  <?php if (!empty($empresa->color_secundario)) { ?>
    --c2: <?php echo $empresa->color_secundario ?>;
  <?php } ?>
  <?php if (!empty($empresa->color_terciario)) { ?>
    --c3: <?php echo $empresa->color_terciario ?>;
  <?php } ?>
  <?php if (!empty($empresa->color_4)) { ?>
    --c4: <?php echo $empresa->color_4 ?>;
  <?php } ?>
  <?php if (!empty($empresa->color_5)) { ?>
    --c5: <?php echo $empresa->color_5 ?>;
  <?php } ?>
  <?php if (!empty($empresa->color_6)) { ?>
    --c6: <?php echo $empresa->color_6 ?>;
  <?php } ?>
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href='assets/fonts/openSans.css' rel='stylesheet' type='text/css'>
<link href='assets/css/style.css' rel='stylesheet' type='text/css'>
<link href="assets/css/jquery-bxslider.css" rel="stylesheet" />
<link href="https://static.tokkobroker.com/static/css/jquery-ui-1.11.14.css?20210623013909" />

<script type="text/javascript" src="assets/js/jsapi.js"></script>
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-sticky.js"></script>

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="20 y 32 | La Plata" />
<meta name="twitter:image" content="https://static.tokkobroker.com/pictures/10310731172228030020173195667303805718351347376946130912451072671840420925279.jpg" />
<?php include "templates/comun/post_head.php" ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33967930-4', 'auto');
  ga('send', 'pageview');

</script>

</head>

<body class="bgcolorA">

<link rel="stylesheet" href="assets/css/jquery.mCustomScrollbar.css" />

<div id="big_slides_container" style="display:none;">
	<div id="big_slides_close" onClick="close_enlarged()">X</div>
	<div id="big_slides_prev" onClick="prev_enlarged()"></div>
	<div id="big_slides_next" onClick="next_enlarged()"></div>
    <img id="big_img" onload="center()">
</div>

<script>

function center(){
var parent_height = $('#big_img').parent().height();
var parent_width = $('#big_img').parent().width();

var image_height = $('#big_img').height();
var image_width = $('#big_img').width();

var top_margin = (parent_height - image_height)/2;
var left_margin = (parent_width - image_width)/2;

var next_margin = left_margin + image_width - 50;
var close_margin = left_margin + image_width - 40;
var close_top = top_margin - 40;

$('#big_img').css( 'margin-top' , top_margin);
$('#big_img').css( 'margin-left' , left_margin);
/*$('#big_slides_prev').css( 'margin-left' , left_margin);
$('#big_slides_next').css( 'margin-left' , next_margin);
$('#big_slides_close').css ( 'margin-top', close_top);
$('#big_slides_close').css ( 'margin-left', close_margin); */
}

</script>

<div class="header"><img src="https://static.tokkobroker.com/logos/8274/Ridella.jpg" height="100" /></div>

<div id="property_detail_wrapper" class="content_wrapper">

    <div id="property_detail_content">

        <div id="ficha">
            <div id="header_ficha">
                  
                <div class="pre-title-header"><?= $propiedad->nombre ?></div>
                <div class="titulo_header">
                    <div class="titulo_address" style=""><?= $propiedad->calle ?> | <?= $propiedad->localidad ?></div>
                    <div class="titulo_precio">

                    </div>
                </div>
            </div>

            <div id="ficha_slider">
                <ul class="slides" onClick="enlarge()">
                    
                        
                            <li data-thumb="https://static.tokkobroker.com/pictures/10310731172228030020173195667303805718351347376946130912451072671840420925279.jpg"> <img src="https://static.tokkobroker.com/pictures/10310731172228030020173195667303805718351347376946130912451072671840420925279.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 1" /></li>
                        
                            <li data-thumb="https://static.tokkobroker.com/pictures/63119213139912688178411842487794057619414033553825619873750376882171374745530.jpg"> <img src="https://static.tokkobroker.com/pictures/63119213139912688178411842487794057619414033553825619873750376882171374745530.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 2" /></li>
                        
                            <li data-thumb="https://static.tokkobroker.com/pictures/36252178531727002310253554524784809984628253327030271974943829284299199873427.jpg"> <img src="https://static.tokkobroker.com/pictures/36252178531727002310253554524784809984628253327030271974943829284299199873427.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 3" /></li>
                        
                            <li data-thumb="https://static.tokkobroker.com/pictures/49725233523305756678731128811332357345529160313026921124556410057806807696965.jpg"> <img src="https://static.tokkobroker.com/pictures/49725233523305756678731128811332357345529160313026921124556410057806807696965.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 4" /></li>
                        
                            <li data-thumb="https://static.tokkobroker.com/pictures/70395707087771075696208934104638630689039843454515665688141646514597072486814.jpg"> <img src="https://static.tokkobroker.com/pictures/70395707087771075696208934104638630689039843454515665688141646514597072486814.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 5" /></li>
                        
                            <li data-thumb="https://static.tokkobroker.com/pictures/75668594932886527279033846700064803167406528336496070379902704481860978222888.jpg"> <img src="https://static.tokkobroker.com/pictures/75668594932886527279033846700064803167406528336496070379902704481860978222888.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 6" /></li>
                        
                            <li data-thumb="https://static.tokkobroker.com/pictures/88461507502800074974332944632187119089746093043185308625897629226714179046885.jpg"> <img src="https://static.tokkobroker.com/pictures/88461507502800074974332944632187119089746093043185308625897629226714179046885.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 7" /></li>
                        


                    
                </ul>
            </div>

            <script>
              var current_ix = 0;
              function enlarge(){
                  src = $("#slider_thumbs").find(".active").find(".slider-thumb").data("big");
                  if (src == undefined){
                      src = 'img/no-image.svg';
                  }
                  $('#big_img').attr('src', src);
                  $("#big_slides_container").height($(window).height());
                  $("#big_slides_container").width($(window).width());
                  current_ix = $("#slider_thumbs").find("a").index($("#slider_thumbs").find(".active"));
                  $("#big_slides_container").fadeIn();
              }
              function next_enlarged(){
                  if ($("#slider_thumbs").find("a").length-1 == current_ix){
                      next_ix = 0;
                  }else{
                      next_ix = current_ix + 1;
                  }
                  $('#big_img').attr('src', $("#slider_thumbs").find("a").eq(next_ix).find('img').data("big"));
                  current_ix = next_ix;
              }

              function prev_enlarged(){
                  if (current_ix == 0){
                      next_ix = $("#slider_thumbs").find("a").length-1;
                  }else{
                      next_ix = current_ix - 1;
                  }
                  $('#big_img').attr('src', $("#slider_thumbs").find("a").eq(next_ix).find('img').data("big"));
                  current_ix = next_ix;
              }

              function close_enlarged(){
                  $("#big_slides_container").fadeOut();
              }
            </script>
<div class="tostick">
    <div id="ficha_detalle" class="card">
        <div id="ficha_detalle_head" class="bgcolorC" style="text-transform: uppercase;">Detalles de la propiedad</div>
        <div id="ficha_detalle_cuerpo">
            <div class="operations-box">
                
                
                <div class="op-venta">
                    <div class="op-operation"><?= $propiedad->tipo_operacion ?></div>
                    <div class="op-values"> 
                        <div class="op-value"><?= $propiedad->precio ?></div>
                    </div>
                </div>
                
                
            </div>
            <div class="ficha_detalle_item"><b>Direccion</b><br/><?= $propiedad->calle ?> | <?= $propiedad->localidad ?></div>
            <div class="ficha_detalle_item"><b>Localidad/Partido</b><br/><?= $propiedad->localidad ?></div>
            
            <div id="ficha_detalle_ref">(REF. EPH3702409)</div>
        </div>
        <div id="slider_thumbs" class="noprint">
            
                
                    <a data-slide-index="0" href=""><img src="https://static.tokkobroker.com/thumbs/10310731172228030020173195667303805718351347376946130912451072671840420925279_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/10310731172228030020173195667303805718351347376946130912451072671840420925279.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 1"></a>
                
                    <a data-slide-index="1" href=""><img src="https://static.tokkobroker.com/thumbs/63119213139912688178411842487794057619414033553825619873750376882171374745530_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/63119213139912688178411842487794057619414033553825619873750376882171374745530.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 2"></a>
                
                    <a data-slide-index="2" href=""><img src="https://static.tokkobroker.com/thumbs/36252178531727002310253554524784809984628253327030271974943829284299199873427_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/36252178531727002310253554524784809984628253327030271974943829284299199873427.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 3"></a>
                
                    <a data-slide-index="3" href=""><img src="https://static.tokkobroker.com/thumbs/49725233523305756678731128811332357345529160313026921124556410057806807696965_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/49725233523305756678731128811332357345529160313026921124556410057806807696965.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 4"></a>
                
                    <a data-slide-index="4" href=""><img src="https://static.tokkobroker.com/thumbs/70395707087771075696208934104638630689039843454515665688141646514597072486814_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/70395707087771075696208934104638630689039843454515665688141646514597072486814.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 5"></a>
                
                    <a data-slide-index="5" href=""><img src="https://static.tokkobroker.com/thumbs/75668594932886527279033846700064803167406528336496070379902704481860978222888_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/75668594932886527279033846700064803167406528336496070379902704481860978222888.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 6"></a>
                
                    <a data-slide-index="6" href=""><img src="https://static.tokkobroker.com/thumbs/88461507502800074974332944632187119089746093043185308625897629226714179046885_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/88461507502800074974332944632187119089746093043185308625897629226714179046885.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 7"></a>
                
            
        </div>
    </div>

    <div id="producer_container" class="card">
      <img src="https://static.tokkobroker.com/static/img/user.png"/>
      <div id="producer_info">
          <div id="producer_name">LAUTARO SESSA</div>
          <div class="producer-item"><a href="mailto:lautaro@ridellapropiedades.com"><img src="https://static.tokkobroker.com/static/img/mail.svg?20210623013909"><div>lautaro@ridellapropiedades.com</div></a></div>
          
          <div class="producer-item"><a href="tel: 5492216318721" ><img src="https://static.tokkobroker.com/static/img/cellphone.svg?20210623013909"><div> 5492216318721</div></a></div>
      </div>
    </div>

</div>

<div id="ficha_desc">


<section id="ficha_informacion_basica" class="card" style="color:  !important; width: 100%;">
    <div class="titulo2">Información básica.</div>
    <ul class="ficha_ul" id="lista_informacion_basica">
        
          <li><i class="fa fa-check detalleColorC"></i>Ambientes: <?= $propiedad->ambientes ?></li>
        

        
          <li><i class="fa fa-check detalleColorC"></i>Dormitorios: <?= $propiedad->dormitorios ?></li>
        

        
          <li><i class="fa fa-check detalleColorC"></i>Baños: <?= $propiedad->banios ?></li>
        

        

        
          <li><i class="fa fa-check detalleColorC"></i>Cocheras: <?= $propiedad->cocheras ?></li>
        

        

        
          <li><i class="fa fa-check detalleColorC"></i>Condición: no encontre</li>
        

        

        <li><i class="fa fa-check detalleColorC"></i>Antigüedad: no encontre</li>

        
          <li><i class="fa fa-check detalleColorC"></i>Situación: no encontre </li>
        

        

        

        

        
    </ul>
</section>
<script>
  if( $("#lista_informacion_basica li").length == 0 ){ $("#ficha_informacion_basica").hide(); }
</script>



<section id="ficha_superficies" class="card" style="color:  !important; width: 100%;">
    <div class="titulo2">Superficies</div>
    <ul class="ficha_ul" id="lista_superficies">
        
        
                <li><i class="fa fa-check detalleColorC"></i>Superficie del terreno: <?= $propiedad->superficie_total ?></li>
            
        

        
        <li><i class="fa fa-check detalleColorC"></i>Superficie cubierta: <?= $propiedad->superficie_cubierta ?></li>
        

        

        

        
        <li><i class="fa fa-check detalleColorC"></i>Total construido: que poner?</li>
        
    </ul>
</section>

<script>if( $("#lista_superficies li").length == 0 ){ $("#ficha_superficies").hide(); }</script>
    <div class="card">
        
            <div class="titulo2">Descripción</div>
            <?= $propiedad->texto ?>
        
        
    </div>
</div>


<div id="ficha_contacto" style="color:  !important;" class="card noprint">
    <div class="titulo2" style="text-transform: uppercase;">Contacto</div>
    <div id="ficha_gracias" style="height:300px; display:none; color:  !important;">
    Gracias por tu consulta. <br>
    Te responderemos a la brevedad.
    </div>
    <div class="ficha_contacto_item"><label>Nombre</label> <input id="contact_name" type="text" /></div>
    <div class="ficha_contacto_item"><label>Teléfono</label> <input id="contact_phone" type="text" /></div>
    <div class="ficha_contacto_item"><label>E-mail</label> <input id="contact_email" type="text" /></div>
    
        <div class="ficha_contacto_item"><label>Tipo de operación</label>
            <select id="contact_operation">

            </select>
        </div>
    

    <div class="ficha_contacto_item"><label>Mensaje</label> <textarea id="contact_text">Estoy interesado en esta propiedad.</textarea></div>
    <div id="ficha_send" class="detalleColor" style="cursor:pointer;" onclick="send_webcontact()">ENVIAR</div>
</div>

<script>
    // using jQuery
    function getCookie(name) {
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }

    function csrfSafeMethod(method) {
        return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
    }

    $.ajaxSetup({
        beforeSend: function(xhr, settings) {
            if (!csrfSafeMethod(settings.type) && !this.crossDomain) {
                xhr.setRequestHeader("X-CSRFToken", '0Ubdu16Okhymhr3I7WKnJ4OAQD3PujCP');
            }
        }
    });

    var sending = false;

    function validate_mail(mail){
        var filter = /[\w-\.]{1,}@([\w-]{1,}\.)*([\w-]{1,}\.)[\w-]{2,4}/;
        if(filter.test(mail))
            return true;
        else
            return false;
    }


    function is_form_valid(){
        if ($("#contact_name").val().trim() == "" & $("#contact_phone").val().trim() == "" & $("#contact_email").val().trim() == ""){
            $("#contact_name").attr("placeholder", "Complete su nombre por favor");
            $("#contact_phone").attr("placeholder", "Complete su telefono por favor");
            $("#contact_email").attr("placeholder", "Complete su email por favor");
            return false;
        }

        if( validate_mail($("#contact_email").val()) == false ){
            $("#contact_email").attr("placeholder", "El email es inválido");
            return false;
        }

        return true
    }

    function send_webcontact(){
        if (!sending & is_form_valid()){
            sending = true;
            $("#ficha_send").html("Enviando...")
            data = {"property_id": '3702409',
                    "name": $("#contact_name").val(),
                    "phone": $("#contact_phone").val(),
                    "email": $("#contact_email").val(),
                    "operation": $("#contact_operation").val(),
                    "text": $("#contact_text").val(),
                    };
            var jqxhr = $.ajax( '/webcontact/', {'type':"POST", 'data': data} )
                .done(function(result) {
                        if (result == "Error"){
                            $("#ficha_send").html("ENVIAR")
                            alert("Ha ocurrido un error, intentalo nuevamente en unos minutos.Ha ocurrido un error. Vuelva a intentarlo en unos minutos")
                        }else{
                            $("#ficha_send").hide()
                            $(".ficha_contacto_item").hide();
                            $("#ficha_gracias").show();
                            $("#ficha_gracias").append('<iframe frameborder="0" height="1" width="1" src="/gracias"></iframe>');
                        }
                        sending = false;
                    })
                .fail(function() {
                    })
        }
    }
</script>



<section id="ficha_mapa" style="color:  !important;" class="card noprint">
  <div class="titulo2">Ubicación</div>
  <div style="height: 500px;" id="mapid"></div>
</section>



<div id="network_portal" class="card">
    Nota importante: Toda la información y medidas provistas son aproximadas y deberán ratificarse con la documentación pertinente y no compromete contractualmente a nuestra empresa. Los gastos (expensas, ABL) expresados      refieren a la última información recabada y deberán confirmarse. Fotografias no vinculantes ni contractuales.
    
</div>

    </div>

    <script src="assets/js/jquery.bxslider.min.js"></script>
    <script src="assets/js/jquery-mCustomScrollbar.concat.min.js"></script>

    <script>

        (function($){
            $(window).load(function(){
                $("#slider_thumbs").mCustomScrollbar({
                      axis:"x",
                  theme:"dark-thin",
                  autoExpandScrollbar:true,
                  advanced:{autoExpandHorizontalScroll:true}
                   });
                   $("#slider_thumbs").slideDown();
            });
        })(jQuery);


        $(document).ready(function(){
            $('.slides').bxSlider({
                  pagerCustom: '#slider_thumbs'
            });

            $('.bx-prev').click(function (evt) {
                evt.stopPropagation();
                if($( "#mCSB_1_container" ).position().left > -40){
                  $( "#mCSB_1_container" ).animate({ "left": (349-$( "#mCSB_1_container" ).width())}, "slow");
                }else{
                  $( "#mCSB_1_container" ).animate({ "left": "+=94px" }, "slow" );
                }
            });

            $('.bx-next').click(function (evt) {
                evt.stopPropagation();
                if($( "#mCSB_1_container" ).position().left <  (360-$( "#mCSB_1_container" ).width())){
                  $( "#mCSB_1_container" ).animate({ "left":"0"}, "slow");
                }else{
                  $( "#mCSB_1_container" ).animate({ "left": "-=94px" }, "slow" );
                }
            });


        });


        $( window ).resize(function() {

            var newH = (600/800) * $(".resultados-list-home li").width();
            $(".prop-img").height( newH );

        });

    </script>

</div>

<div class="footer">
    <div class="powered">Powered by</div> <a href="https://www.tokkobroker.com" target="_blank"> <img class="poweredimg" src="https://static.tokkobroker.com/static/img/logotokko_small_bw.svg?20210623013909" /></a>
</div>



</div>

<script>
    function stickCheck(){
        if ( $(window).width() > 767 ) {
            $(".tostick").sticky({topSpacing: 20, bottomSpacing: 20});
        }else{
            $(".tostick").unstick();
        }
    }

    $(document).ready(function(){
        stickCheck();
    });

    $(window).resize(function() {
        stickCheck();
    })
</script>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
<?php if (!empty($propiedad->latitud) && !empty($propiedad->longitud)) { ?>
	<script type="text/javascript">
		$(document).ready(function(){

			var mymap = L.map('mapid').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], 15);

	    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
	      tileSize: 512,
	      maxZoom: 18,
	      zoomOffset: -1,
	      id: 'mapbox/streets-v11',
	      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
	    }).addTo(mymap);


			var icono = L.icon({
				iconUrl: 'assets/images/map-logo.png',
		      iconSize:     [101, 112], // size of the icon
		      iconAnchor:   [50, 112], // point of the icon which will correspond to marker's location
		    }); 

			L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>],{
				icon: icono
			}).addTo(mymap);
		});
	</script>
<?php } ?>
</body>
</html>
