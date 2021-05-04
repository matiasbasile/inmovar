<?php
$nombre_pagina = "detalle";
include_once("includes/init.php");
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
if ($propiedad === FALSE || !isset($propiedad->nombre)) header("Location:".mklink("/"));
$page_act = $propiedad->tipo_operacion_link;
?>  
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>

  <!-- Header -->
  <?php include "includes/header.php" ?>

  <section class="listing-detail">
    <div class="container">
      <div class="row list-header">
        <div class="col-lg-6">
          <div class="section-title">
            <h2><?php echo $propiedad->nombre ?></h2>
            <h3><?php echo $propiedad->direccion_completa ?></h3>
          </div>
        </div>
        <div class="col-lg-6">
          <h4><?php echo $propiedad->precio ?></h4>
          <ul class="listinfo">
            <li>
              <img src="assets/images/icon4.png" alt="Icon"> <?php echo ($propiedad->dormitorios != 0)?$propiedad->dormitorios:"-" ?> Habitaci<?php echo ($propiedad->dormitorios > 1)?"ones":"ón" ?>
            </li>
            <li>
              <img src="assets/images/icon5.png" alt="Icon"> <?php echo ($propiedad->banios != 0)?$propiedad->banios:"-" ?> Baño<?php echo ($propiedad->banios > 1)?"s":"" ?>
            </li>
            <li>
              <img src="assets/images/icon6.png" alt="Icon"> <?php echo ($propiedad->superficie_total != 0)?$propiedad->superficie_total:"-" ?> Totales
            </li>
          </ul>
        </div>
      </div>
    </div>
    <?php if (!empty($propiedad->images)) { ?>
      <div class="owl-carousel" data-items="3" data-items-lg="3" data-items-md="2" data-margin="3" data-center="false" data-loop="flase" data-nav="true" data-dots="false">
        <?php foreach ($propiedad->images as $i) {  ?>
          <div class="item">
            <a href="<?php echo $i ?>" class="fancybox"><img src="<?php echo $i ?>" alt="Image"></a>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
    <div class="container">
      <div class="row full-info">
        <div class="col-lg-8">
          <div class="block">
            <h5>Descripción</h5>
            <p><?php echo $propiedad->texto ?></p>
          </div>
          <div class="block">
            <h5>Servicios</h5>
            <ul class="bullet-list icon">
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
          <div class="block">
            <h5>Superficies</h5>
            <ul class="bullet-list">
              <li>
                Cubierta: <strong><?php echo $propiedad->superficie_cubierta ?></strong>
              </li>
              <li>
                Descubierta: <strong><?php echo $propiedad->superficie_descubierta ?></strong>
              </li>
              <li>
                Semicubierta: <strong><?php echo $propiedad->superficie_semicubierta ?></strong>
              </li>
              <li>
                Total: <strong><?php echo $propiedad->superficie_total ?></strong>
              </li>
            </ul>
          </div>
          <?php if ($propiedad->dormitorios != 0 ||  $propiedad->banios != 0 || $propiedad->living_comedor == 1 || $propiedad->cocheras > 0 || $propiedad->patio ==1 || $propiedad->balcon == 1 || $propiedad->terraza == 1) {  ?>
            <div class="block">
              <h5>Ambientes</h5>
              <ul class="bullet-list icon">
                <?php if ($propiedad->dormitorios > 0) {  ?>
                  <LI>Dormitorio</LI>
                <?php } ?>
                <?php if ($propiedad->living_comedor == 1) {  ?>
                  <LI>Living Comedor</LI>
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
                <?php if ($propiedad->terraza == 1) {  ?>
                  <LI>Terraza</LI>
                <?php } ?>
              </ul>
            </div>
          <?php } ?>
          <div class="block">
            <h5>Adicionales</h5>
            <ul class="bullet-list">
              <li>Apto Crédito: 
                <strong><?php echo ($propiedad->apto_banco == 1)?"Sí":"No" ?></strong>
              </li>
              <li>Acepta Permuta:
                <strong><?php echo ($propiedad->acepta_permuta == 1)?"Sí":"No" ?></strong>
              </li>
            </ul>
          </div>
          <?php if (isset($propiedad->latitud) && isset($propiedad->longitud) && $propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
            <div class="block">
              <h5>Ubicación en mapa</h5>
              <!-- Map -->
              <div id="map1" style="min-height: 320px"></div>
            </div>
          <?php } ?>
        </div>
        <div class="col-lg-4">
          <form class="form-consult" onsubmit="return enviar_contacto()">
            <h6>enviar consulta</h6>
            <div class="form-inner">
              <div class="form-group">
                <input type="text" class="form-control" id="contacto_nombre" placeholder="Nombre *">
              </div>
              <div class="form-group">
                <input type="email" class="form-control" id="contacto_email" placeholder="Email *">
              </div>
              <div class="form-group">
                <input type="tel" class="form-control" id="contacto_telefono" placeholder="WhatsApp (sin 0 ni 15) *">
              </div>
              <div class="form-group">
                <textarea class="form-control" id="contacto_mensaje" placeholder="Estoy interesado en “Duplex en venta en Ringuelet Cod: 1234”"></textarea>
              </div>
              <button type="submit" id="contacto_submit" class="btn">enviar por email</button>
              <a href="javascript:void(0)" onclick="enviar_contacto_whatsapp()" class="btn whatsbtn"><img src="assets/images/whatsicon.png" alt="whatsicon">enviar whatsapp</a>
            </div>
            <div class="socials">
              <span>Compartir:</span>
              <ul>
                <li><a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()) ?>" target="_blank" ><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                <li><a target="_blank" href="https://api.whatsapp.com/send?text=<?php echo urlencode(current_url()) ?>"><i class="fab fa-whatsapp"></i></a></li>
                <li><a href="javascript:void(0)" onclick="myFunction()"><i class="fas fa-link"></i></a></li>
              </ul>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Recently Added -->
  <section class="featured-properties recently-added pt-5 slider-properties">
    <div class="container">
      <div class="section-title">
        <h2>Propiedades Similares</h2>
        <span>Estas son algunas otras propiedades que podrían interesarte</span>
      </div>
      <div class="owl-carousel" data-items="3" data-items-lg="2" data-items-md="2" data-margin="0" data-center="false" data-loop="true" data-nav="true" data-dots="true">
        <?php foreach ($propiedad->relacionados as $p) { ?>
          <div class="item">
            <div class="list-item">
              <img src="/admin/<?php echo $p->path ?>" alt="Property Img">
              <div class="overlay-block">
                <div class="top-item">
                  <div class="tag <?php echo ($p->id_tipo_operacion == 4)?"dark-blue":($p->id_tipo_operacion ==2)?"light-blue":"" ?>">
                    <?php echo ($p->id_tipo_operacion == 1)?"En Venta":"" ?>
                    <?php echo ($p->id_tipo_operacion == 2)?"En Alquiler":"" ?>
                    <?php echo ($p->id_tipo_operacion == 4)?"Emprendimientos":"" ?>
                  </div>
                  <big><?php echo ($p->precio == 0 )?"Consultar":$p->precio ?></big>
                </div>
                <div class="bottom-item">
                  <h3><?php echo $p->nombre ?></h3>
                  <span><?php echo $p->direccion_completa ?></span>
                  <ul>
                    <li>Habitaciones: <small><?php echo ($p->dormitorios != "0")?$p->dormitorios:"-" ?></small></li>
                    <li>Baños: <small><?php echo ($p->banios != "0")?$p->banios:"-" ?></small></li>
                    <li>Metros: <small><?php echo ($p->superficie_total != "0")?$p->superficie_total:"-" ?></small></li>
                  </ul>
                </div>
                <a class="plus" href="<?php echo ($p->link_propiedad) ?>"><img src="assets/images/plus-icon.png" alt="Plus Icon"></a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include "includes/footer.php" ?>


  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/html5.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  <script src="assets/js/scripts.js"></script>
<script type="text/javascript">
  $(window).on("load",function(){
    $(".scroll-box").mCustomScrollbar();
  });
</script>
<script type="text/javascript">
  $(".fancybox").fancybox();
</script>
<script type="text/javascript">
  function myFunction() {
    /* Get the text field */
    var copyText = "<?php echo current_url()?>";

    document.execCommand(copyText);

    /* Alert the copied text */
    alert("¡Link copiado! Listo para compartir");
  }
</script>
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
      "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
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
      "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
      "type":"post",
      "dataType":"json",
      "data":datos,
      "success":function(r){
        if (r.error == 0) {
          alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
          window.location.href = "https://api.whatsapp.com/send?phone=<?php echo $empresa->telefono ?>&text="+ mensaje;
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");
          jQuery("#contacto_submit").removeAttr('disabled');
        }
      }
    });
    return false;
  }
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
if (jQuery(window).width()>767) { 
  $(document).ready(function(){
    var maximo = 0;
    $(".bottom-item").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".bottom-item").height(maximo);
  });
}
</script>
</body>
</html>