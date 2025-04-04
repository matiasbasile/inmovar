<?php
$nombre_pagina = "detalle";
include_once("includes/init.php");
include_once("includes/funciones.php");
$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id,array(
  "id_empresa"=>$id_empresa,
  "id_empresa_original"=>$empresa->id,
));

if (($propiedad === FALSE || !isset($propiedad->nombre) || $propiedad->activo == 0) && !isset($get_params["preview"])) {
  header("HTTP/1.1 302 Moved Temporarily");
  header("Location:".mklink("/"));
  exit();
}

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
?>  
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include "includes/head.php" ?>
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo ($propiedad->nombre); ?>" />
<meta property="og:description" content="<?php echo str_replace("\n","",(strip_tags(html_entity_decode($propiedad->texto,ENT_QUOTES)))); ?>" />
<meta property="og:image" content="<?php echo current_url(TRUE); ?>/admin/<?php echo $propiedad->path; ?>"/>
<script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
<script>const ID_EMPRESA_RELACION = "<?php echo $id_empresa ?>";</script>
</head>
<body>

  <?php include "includes/header.php" ?>

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
         <img src="<?php echo $propiedad->imagen ?>" class="contain-detail">
       </div>
     <?php } ?>
     <div class="detail-top">
      <ul>
        <li>
          <div class="about-product">
            <?php if (!empty($propiedad->dormitorios)) {  ?><span><img src="assets/images/badroom-icon.png" alt="Badroom"> <?php echo $propiedad->dormitorios ?> Habitaci<?php echo ($propiedad->dormitorios > 1)?"ones":"ón" ?></span><?php } ?>
            <?php if (!empty($propiedad->banios)) {  ?><span><img src="assets/images/shower-icon.png" alt="Shower"> <?php echo $propiedad->banios ?> Baño<?php echo ($propiedad->banios > 1)?"s":"" ?></span><?php } ?>
            <span><img src="assets/images/sqft-icon.png" alt="Sqft"> <?php echo $propiedad->superficie_total ?> Metros Totales <?php echo (!empty($propiedad->superficie_cubierta))?"| ".$propiedad->superficie_cubierta." Cubiertos" :"" ?> <?php echo (!empty($propiedad->superficie_descubierta))?"| ".$propiedad->superficie_descubierta." Descubiertos" :"" ?></span>
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
          <big>
            <?php echo $propiedad->precio ?>
            <?php if ($propiedad->precio_porcentaje_anterior < 0.00 && $propiedad->publica_precio == 1) { ?>
              <span class="dib" style="color: #0dd384;">(<img src="assets/images/arrow_down.png" alt="Home" /> <?= floatval($propiedad->precio_porcentaje_anterior*-1) ?>%)</span>
            <?php } ?>
          </big>
        </li>
      </ul>
    </div>
    <div class="border-box-info">
      <div class="row">
        <div class="col-md-12">
          <h4>Descripción</h4>
        </div>
      </div>
      <p><?php echo $propiedad->texto ?></p>
    </div>
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
        <?php if (!empty($propiedad->lavadero)) {  ?><li>Lavadero</li><?php } ?>
        <?php if (!empty($propiedad->living_comedor)) {  ?><li>Living Comedor</li><?php } ?>
        <?php if (!empty($propiedad->terraza)) {  ?><li>Terraza</li><?php } ?>
        <?php if (!empty($propiedad->accesible)) {  ?><li>Accesible</li><?php } ?>
        <?php if (!empty($propiedad->balcon)) {  ?><li>Balcon</li><?php } ?>
        <?php if (!empty($propiedad->patio)) {  ?><li>Patio</li><?php } ?>
      </ul>
    </div>
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
        <form id="propiedad_form" onsubmit="return enviar_contacto()">

          <input type="hidden" value="<?php echo $propiedad->id ?>" class="id_propiedad" name="">
          <input type="hidden" value="Contacto por: <?php echo $propiedad->nombre ?>. Cod: <?php echo $propiedad->codigo ?>" class="asunto">

          <div class="form-group">
            <input class="form-control nombre" id="contacto_nombre" type="text" name="Nombre *" placeholder="Nombre *">
          </div>
          <div class="form-group">
            <input class="form-control email" id="contacto_email" type="email" name="Email *" placeholder="Email *">
          </div>
          <div class="form-group">
            <input class="form-control telefono" id="contacto_telefono" type="tel" name="WhatsApp (sin 0 ni 15) *" placeholder="WhatsApp (sin 0 ni 15) *">
          </div>
          <div class="form-group">
            <textarea class="form-control mensaje" id="contacto_mensaje">Estoy interesado en <?php echo $propiedad->nombre ?> Cod: <?php echo $propiedad->codigo ?></textarea>
          </div>
          <button id="contacto_submit" type="submit" class="btn btn-secoundry submit">Enviar por Email</button>
          <a class="btn btn-whatsup" href="javascript:void(0)" onclick="return enviar_contacto_whatsapp('propiedad_form')"><img src="assets/images/whatsapp2.png" alt="Whatsapp Icon" width="24"> enviar whatsapp</a>
        </form>
      </div>
      <div class="social">
        <span>Compartir:</span>
        <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()) ?>" target="_blank" ><i class="fa fa-facebook" aria-hidden="true"></i></a>
        <a target="_blank" href="https://api.whatsapp.com/send?text=<?php echo urlencode(current_url()) ?>"><i class="fa fa-whatsapp"></i></a>
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
                <a href="<?php echo ($p->link_propiedad) ?>"><img class="cover-home" src="<?php echo $p->imagen ?>" alt="Product"></a>
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
                    <strong><?php echo $p->precio ?></strong>
                  </li>
                </ul>
                <div class="average-detail">
                 <?php if ($p->dormitorios != "0") {  ?><span><img src="assets/images/badroom-icon.png" alt="Badroom Icon"> <?php echo $p->dormitorios  ?></span><?php } ?>
                 <?php if ($p->banios != "0") {  ?><span><img src="assets/images/shower-icon.png" alt="Shower Icon"> <?php echo $p->banios ?></span><?php } ?>
                 <?php if ($p->superficie_total != "0") {  ?><span><img src="assets/images/sqft-icon.png" alt="SQFT Icon"> <?php echo $p->superficie_total ?> m2</span><?php } ?>
                </div>
                <div class="btns-block">
                 <a href="<?php echo ($p->link_propiedad) ?>" class="btn btn-secoundry">Ver Detalles</a>
                 <a href="<?php echo ($p->link_propiedad) ?>#contacto_nombre" class="icon-box"></a>
                 <a href="#0" data-toggle="modal" data-target="#exampleModalCenter_<?php echo $p->id ?>"  class="icon-box whatsapp-box"></a>
                </div>
              </div>
            </div>
          </div>
          <?php $modales[] = $p; ?>
        <?php } ?>
      </div>    
    </div>
  </section>
<?php } ?>

<?php include "includes/footer.php" ?>

<link rel="stylesheet" type="text/css" href="assets/css/jquery.fancybox.min.css">
<script type="text/javascript" src="assets/js/jquery.fancybox.min.js"></script>

<?php if (isset($propiedad->latitud) && isset($propiedad->longitud) && $propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
  <?php include_once("templates/comun/mapa_js.php"); ?>
  <script type="text/javascript">
    $(document).ready(function(){
      mostrar_mapa(); 
    });
    function mostrar_mapa() {

      <?php if (!empty($propiedad->latitud && !empty($propiedad->longitud))) { ?>
        var mymap = L.map('map1').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
          tileSize: 512,
          maxZoom: 18,
          zoomOffset: -1,
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