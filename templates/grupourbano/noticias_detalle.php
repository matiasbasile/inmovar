<?php
$nombre_pagina = "noticia";
include_once("includes/init.php");
include_once("includes/funciones.php");
$entrada = $entrada_model->get($id,array(
  "relacionados_offset"=>2,
));

// Tomamos los datos de SEO
$seo_title = (!empty($entrada->seo_title)) ? ($entrada->seo_title) : $empresa->seo_title;
$seo_description = (!empty($entrada->seo_description)) ? ($entrada->seo_description) : $empresa->seo_description;
$seo_keywords = (!empty($entrada->seo_keywords)) ? ($entrada->seo_keywords) : $empresa->seo_keywords;

$titulo_pagina = $entrada->categoria;
$breadcrumb = array(
  array("titulo"=>$entrada->categoria,"link"=>"entradas/".$entrada->categoria_link."/"),
  array("titulo"=>$entrada->titulo,"link"=>$entrada->link),
);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo ($entrada->titulo); ?>" />
<meta property="og:description" content="<?php echo str_replace("\n","",(strip_tags(html_entity_decode($entrada->texto,ENT_QUOTES)))); ?>" />
<meta property="og:image" content="<?php echo current_url(TRUE); ?>/sistema/<?php echo $entrada->path; ?>"/>
</head>
<body>

<?php include("includes/header.php"); ?>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-9 primary">
        <div class="property-full-info">
          <?php 
          $entrada->images[] = $entrada->path;
          if (!empty($entrada->images)) { ?>
            <?php $foto = $entrada->images[0]; ?>
            <div id="gallery-slider">
              <div id="gallery-picture">
                <img src="<?php echo $foto ?>" alt="" />
              </div>
              <div id="hidden-thumbs">
                <?php foreach($entrada->images as $f) { ?>
                  <img src="<?php echo $f ?>" alt="" />
                <?php } ?>
              </div>
              <div class="thumbnails">
                <a href="javascript:void(0);" id="gallery-nav" class="prev-button"></a>
                <a href="javascript:void(0);" id="gallery-nav" class="next-button"></a>
                <div id="thumbcon"></div>
              </div>
            </div>
          <?php } ?>
          <div class="property-name"><?php echo ($entrada->titulo); ?></div>
          <div class="border-box">
            <div class="box-space" style="border-bottom:1px solid #e6e6e6; padding-bottom: 15px; margin-bottom: 15px">
              <div class="property-location">
                <?php if (!empty($entrada->subtitulo)) { ?>
                  <div class="pull-left"><?php echo ($entrada->subtitulo); ?></div>
                <?php } ?>
                <div class="pull-right">
                  <small><span class="st_sharethis_large"></span></small>
                </div>
              </div>
            </div>
            <div class="property-facilities">
              <div class="facilitie">
                <img src="images/calendar.png" alt="Fecha"/>
                <?php echo full_date($entrada->fecha); ?>
              </div>
            </div>            
            <?php if (!empty($entrada->texto)) { ?>
              <div class="box-space">
                <p><?php echo (html_entity_decode($entrada->texto,ENT_QUOTES)); ?></p>
              </div>
            <?php } ?>
            <?php if ($entrada->latitud != 0 && $entrada->longitud != 0) { ?>
              <div class="box-space">
                <div id="map"></div>
              </div>
            <?php } ?>
            <div class="info-title">formulario de consulta</div>
            <div class="box-space">
              <div class="form">
                <div class="row">
                  <?php include("includes/form_contacto.php"); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <?php
        // Entradaes relacionadas o similares
        
        // A las entradas relacionadas especificamente a mano, las debemos juntar por las
        // similares que coinciden en ciudad, tipo de operacion y tipo de inmueble
        
        if (!empty($entrada->relacionados)) { ?>
          <div class="block">
            <div class="section-title"><big>entradas similares</big></div>
            <?php foreach($entrada->relacionados as $r) { ?>
              <div class="col-md-6">
                <div class="property-item">
                  <div class="item-picture">
                    <div class="block">
                      <?php if (!empty($r->path)) { ?>
                        <img class="cover" src="<?php echo $r->path ?>" alt="<?php echo ($r->titulo) ?>" />
                      <?php } else { ?>
                        <img class="cover" src="images/no-image-1.jpg" alt="<?php echo ($r->titulo) ?>" />
                      <?php } ?>
                    </div>
                    <div class="view-more"><a href="/<?php echo $r->link ?>"></a></div>
                  </div>
                  <div class="property-detail">
                    <div class="property-name"><?php echo ($r->titulo) ?></div>
                    <?php if (!empty($r->descripcion)) { ?>
                      <p><?php echo ((strlen($r->descripcion)>80) ? substr($r->descripcion,0,80)."..." : $r->descripcion); ?></p>
                    <?php } ?>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
      <div class="col-md-3 secondary">
        <?php include("includes/sidebar.php"); ?>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php"); ?>
<script type="text/javascript">
  //OWL CAROUSEL(2) SCRIPT
jQuery(document).ready(function ($) {
"use strict";
$(".owl-carouselmarcas").owlCarousel({
      items : 5,
      itemsDesktop : [1279,2],
      itemsDesktopSmall : [979,2],
      itemsMobile : [639,1],
    });
});

</script>
<script type="text/javascript" src="js/galleryslider.js"></script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "94d2174e-398d-4a49-b5ce-0b6a19a58759", onhover: false, doNotHash: true, doNotCopy: false, hashAddressBar: false});</script>
</body>
</html>
