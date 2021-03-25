<?php include ("includes/init.php");
$page_act = "detalle";
$propiedad = $propiedad_model->get($id,array(
  "buscar_total_visitas"=>1,
  "buscar_relacionados_offset"=>3,
  "id_empresa"=>$id_empresa,
  "id_empresa_original"=>$empresa->id,
));

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad"=>$propiedad->id));

if ($propiedad->id_tipo_operacion == 1) $vc_moneda = "USD";
else $vc_moneda = "$";
if ($propiedad === FALSE || !isset($propiedad->nombre)) header("Location:".mklink("/"));
?>
<!DOCTYPE html>
<html>
<head>
<?php include ("includes/head.php");?>
<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:type" content="website" />
<meta property="og:description" content="<?php echo $propiedad->seo_description; ?>" />
<meta property="og:site_name" content="<?php echo $empresa->nombre ?>">
<meta property="og:title" content="<?php echo $propiedad->seo_title ?>" />
<meta property="og:image" content="<?php echo ((!empty($propiedad->imagen)) ? $propiedad->imagen : $empresa->no_imagen); ?>"/>
<meta property="og:image:width" content="800"/>
<meta property="og:image:height" content="600"/>
<script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
</head>
<body>

<?php include ("includes/header.php");?>

<main id="ts-main">

  <!--BREADCRUMB
    =========================================================================================================-->

  <!--GALLERY CAROUSEL
    =========================================================================================================-->
  <?php if (sizeof($propiedad->images)>0) { ?>
    <section id="gallery-carousel" class="">
      <div class="owl-carousel ts-gallery-carousel ts-gallery-carousel__multi" data-owl-dots="1" data-owl-items="3" data-owl-center="1" data-owl-loop="1">
        <?php foreach ($propiedad->images as $imagenes) { ?>
          <div class="slide">
            <div class="ts-image" data-bg-image="<?php echo $imagenes ?>">
              <a href="<?php echo $imagenes ?>" class="ts-zoom popup-image"><i class="fa fa-search-plus"></i>Zoom</a>
            </div>
          </div>
        <?php } ?>
      </div>
    </section>
  <?php } ?>

  <!--PAGE TITLE
    =========================================================================================================-->
  <section id="page-title" class="border-bottom ts-white-gradient">
    <div class="container">

      <div class="d-block d-sm-flex justify-content-between">

        <div class="ts-title mb-0">
          <h1><?php echo $propiedad->nombre;?></h1>
          <h5 class="ts-opacity__90">
            <i class="fa fa-map-marker text-primary"></i>
              <?php echo ($propiedad->direccion_completa) ?><?php echo (!empty($propiedad->localidad))?". ".$propiedad->localidad:"" ?>
          </h5>
        </div>

        <h3>
          <span class="badge badge-primary p-3 font-weight-normal ts-shadow__sm"><?php echo $propiedad->precio;?></span>
        </h3>

      </div>

    </div>
  </section>

  <!--CONTENT
    =========================================================================================================-->
  <section id="content">
    <div class="container">
      <div class="row flex-wrap-reverse">

        <!--LEFT SIDE
          =============================================================================================-->
        <div class="col-md-5 col-lg-4">

          <!--DETAILS
            =========================================================================================-->
          <section id="location">

            <h3>Localizaci&oacute;n</h3>

            <div class="ts-box p-0">
              <div class="ts-map ts-map__detail" id="ts-map-simple"
                 data-ts-map-leaflet-provider="https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png"
                 data-ts-map-zoom="<?php echo $propiedad->zoom?>"
                 data-ts-map-center-latitude="<?php echo $propiedad->latitud?>"
                 data-ts-map-center-longitude="<?php echo $propiedad->longitud?>"
                 data-ts-map-scroll-wheel="1"
                 data-ts-map-controls="0"></div>
              <div class="p-3 ts-text-color-light">
                <i class="fa fa-map-marker mr-2"></i>
                  <?php echo ($propiedad->direccion_completa) ?><?php echo (!empty($propiedad->localidad))?". ".$propiedad->localidad:"" ?>
              </div>
            </div>

          </section>

        </div>

        <div class="col-md-7 col-lg-8">

          <section id="description">

            <h3>Descripción</h3>
            <div class="ts-box">

              <?php echo $propiedad->texto;?>
            
              <dl class="ts-description-list__line mb-0 ts-column-count-2">

                <?php if (!empty($propiedad->codigo)) { ?>
                  <dt>Código:</dt>
                  <dd class="border-bottom pb-2"><?php echo $propiedad->codigo;?></dd>
                <?php } ?>

                <dt>Tipo:</dt>
                <dd class="border-bottom pb-2"><?php echo $propiedad->tipo_inmueble;?></dd>

                <dt>Estado:</dt>
                <dd class="border-bottom pb-2"><?php echo $propiedad->tipo_operacion;?></dd>

                <?php 
                // AMBIENTES
                if ($propiedad->id_tipo_inmueble != 5 && $propiedad->id_tipo_inmueble != 6 && $propiedad->id_tipo_inmueble != 7 && $propiedad->id_tipo_inmueble != 13 && $propiedad->id_tipo_inmueble != 9 && $propiedad->id_tipo_inmueble != 10) { ?>
                    <dt>Ambientes:</dt>
                    <dd class="border-bottom pb-2"><?php echo (!empty($propiedad->ambientes)) ? $propiedad->ambientes : "-" ?></dd>
                  <dt>Dormitorios:</dt>
                  <dd class="border-bottom pb-2"><?php echo (!empty($propiedad->dormitorios)) ? $propiedad->dormitorios : "-" ?></dd>
                  <dt>Baños:</dt>
                  <dd><?php echo (!empty($propiedad->banios)) ? (($propiedad->banios == 1)?"1 Baño":$propiedad->banios." Baños") : "-" ?></dd>
                  <dt>Cocheras:</dt>
                  <dd class="border-bottom pb-2"><?php echo (!empty($propiedad->cocheras)) ? (($propiedad->cocheras == 1)?"Cochera":$propiedad->cocheras." Cocheras") : "Sin cochera" ?></dd>
                <?php } ?>

                  <dt>Sup. Cubierta:</dt>
                  <dd class="border-bottom pb-2"><?php echo (!empty($propiedad->superficie_cubierta))?$propiedad->superficie_cubierta." mts<sup>2</sup>":"-"; ?></dd>
                  <dt>Sup. Semicubierta:</dt>
                  <dd class="border-bottom pb-2"><?php echo (!empty($propiedad->superficie_semicubierta))?$propiedad->superficie_semicubierta." mts<sup>2</sup>":"-"; ?></dd>
                  <dt>Sup. Descubierta:</dt>
                  <dd class="border-bottom pb-2"><?php echo (!empty($propiedad->superficie_descubierta))?$propiedad->superficie_descubierta." mts<sup>2</sup>":"-"; ?></dd>
                  <dt>Sup. Total:</dt>
                  <dd class="border-bottom pb-2"><?php echo (!empty($propiedad->superficie_total))?$propiedad->superficie_total." mts<sup>2</sup>":"-"; ?></dd>

                <?php 
                // MEDIDAS DEL TERRENO
                if ($propiedad->mts_frente != 0) { ?>
                  <dt>Mts. Frente:</dt>
                  <dd><?php echo str_replace(".00", "", $propiedad->mts_frente) ?> Mts.</dd>
                <?php } ?>
                <?php if ($propiedad->mts_frente != 0) { ?>
                  <dt>Mts. Fondo:</dt>
                  <dd><?php echo str_replace(".00", "", $propiedad->mts_fondo) ?> Mts.</dd>
                <?php } ?>

              </dl>
            </div>

          </section>

          <!--FEATURES
            ========================================================================================-->
          <?php if (!empty($propiedad->servicios_cloacas) || (!empty($propiedad->servicios_agua_corriente)) || (!empty($propiedad->servicios_asfalto)) || (!empty($propiedad->servicios_gas)) || (!empty($propiedad->servicios_telefono)) || (!empty($propiedad->servicios_telefono)) || (!empty($propiedad->servicios_cable)) || ($propiedad->apto_banco == 1) || ($propiedad->acepta_permuta == 1)) {  ?>
            <section id="amenities">
              <h3>Servicios</h3>
              <div class="ts-box">
                <ul class="ts-list-colored-bullets ts-text-color-light ts-column-count-3 ts-column-count-md-2">
                  <?php if ($propiedad->servicios_cloacas == 1) { ?>
                    <li>Cloacas</li>
                  <?php } ?>
                  <?php if ($propiedad->servicios_agua_corriente == 1) { ?>
                    <li>Agua Corriente</li>
                  <?php } ?>
                  <?php if ($propiedad->servicios_electricidad == 1) { ?>
                    <li>Luz</li>
                  <?php } ?>
                  <?php if ($propiedad->servicios_asfalto == 1) { ?>
                    <li>Asfalto</li>
                  <?php } ?>
                  <?php if ($propiedad->servicios_gas == 1) { ?>
                    <li>Gas Natural</li>
                  <?php } ?>
                  <?php if ($propiedad->servicios_telefono == 1) { ?>
                    <li>Teléfono</li>
                  <?php } ?>
                  <?php if ($propiedad->servicios_cable == 1) { ?>
                    <li>TV Cable</li>
                  <?php } ?>
                  <?php if ($propiedad->apto_banco == 1) {  ?>
                    <li>Apto para crédito bancario</li>
                  <?php } ?>
                  <?php if ($propiedad->acepta_permuta == 1) {  ?>
                    <li>Posibilidad de permuta</li>
                  <?php } ?>
                </ul>
              </div>
            </section>
          <?php } ?>

          <!--VIDEO
          =============================================================================================-->
          <?php /*
          <section id="video">

            <h3>Video</h3>

            <div class="embed-responsive embed-responsive-16by9 rounded ts-shadow__md">
              <iframe src="https//player.vimeo.com/video/9799783?color=ffffff&title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>

          </section>
          */?>

          <section id="form-contacto">
            <h3>Formulario de Contacto</h3>
            <?php include("includes/form_contacto.php"); ?>
          </section>

        </div>

      </div>
    </div>
  </section>

  <?php if (sizeof($propiedad->relacionados)>0) { ?>
    <section id="similar-properties">
      <div class="container">

        <hr class="mb-5">

        <h3>Propiedades Relacionadas</h3>

        <div class="row">
        <?php foreach ($propiedad->relacionados as $p){?>
          <div class="col-sm-6 col-lg-4">
            <div class="card ts-item ts-card ts-item__lg">
              <div class="ts-ribbon">
                <i class="fa fa-thumbs-up"></i>
              </div>

              <a href="<?php echo mklink("$p->link")?>" class="card-img ts-item__image" data-bg-image="<?php echo $p->imagen;?>">
                <div class="ts-item__info-badge">
                  <?php echo $p->precio;?>
                </div>
                <figure class="ts-item__info">
                  <h4><?php echo $p->nombre;?></h4>
                  <aside>
                    <i class="fa fa-map-marker mr-2"></i>
                  <?php echo ($p->direccion_completa) ?><?php echo (!empty($p->localidad))?". ".$p->localidad:"" ?>
                  </aside>
                </figure>
              </a>

              <!--Card Body-->
              <div class="card-body">
                <div class="ts-description-lists">
                  <?php if (!empty($p->superficie)) { ?>
                    <dl>
                      <dt>Sup.</dt>
                      <dd><?php echo (!empty($p->superficie)) ? $p->superficie : "-" ?></dd>
                    </dl>
                  <?php } ?>
                  <dl>
                    <dt>Dormitorios</dt>
                    <dd><?php echo (!empty($p->dormitorios)) ? $p->dormitorios : "-" ?></dd>
                  </dl>
                  <dl>
                    <dt>Baños</dt>
                    <dd><?php echo (!empty($p->banios)) ? $p->banios : "-" ?></dd>
                  </dl>
                </div>
              </div>
              <!--Card Footer-->
              <a href="<?php echo mklink("$p->link")?>" class="card-footer">
                <span class="ts-btn-arrow">Más Información</span>
              </a>

            </div>
          </div>
          
        <?php } ?>
        </div>

      </div>
    </section>
  <?php } ?>

</main>

<?php include ("includes/footer.php");?>
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