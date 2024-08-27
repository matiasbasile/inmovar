<?php 
include "includes/init.php";
$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id,array(
  "buscar_total_visitas"=>1,
  "buscar_relacionados_offset"=>3,
  "id_empresa"=>$id_empresa,
));

if (($propiedad === FALSE || !isset($propiedad->nombre) || $propiedad->activo == 0) && !isset($get_params["preview"])) {
  header("HTTP/1.1 302 Moved Temporarily");
  header("Location:".mklink("/"));
  exit();
}

if (!empty($titulo_pagina)) { $titulo_pagina = $propiedad->nombre; }
$nombre_pagina = "detalle";
$mostro_video = 0;
if (!empty($propiedad->imagen)) $propiedad->images = array_merge(array($propiedad->imagen),$propiedad->images);

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad"=>$propiedad->id));

?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include "includes/head.php" ?>
<?php include "templates/comun/og.php" ?>

<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css"/>
<script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
<script>const ID_EMPRESA_RELACION = "<?php echo $id_empresa ?>";</script>
</head>
<body class="detalle">

  <div class="home-slider">
    <?php include("includes/header.php") ?>
    <div class="container">
      <div class="breadcrumb-area">
        <?php if ($propiedad->id_tipo_operacion == 1) { ?>
          <h3 class="h1">Propiedades en Venta</h3>
        <?php } else if ($propiedad->id_tipo_operacion == 2)  { ?>
          <h3 class="h1">Propiedades en Alquiler</h3>
        <?php } else if ($propiedad->id_tipo_operacion == 3)  { ?>
          <h3 class="h1">Propiedades en Alquiler Temporario</h3>
        <?php } ?>
        <ul class="breadcrumbs">
          <li><a href="<?php echo mklink ("/") ?>">Inicio</a></li>
          <li class="active"><?php echo $propiedad->tipo_operacion ?></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="properties-details-page content-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
          <!-- Header -->
          <div class="heading-properties clearfix sidebar-widget">
            <h1 class="titulo-propiedad"><?php echo $propiedad->nombre ?></h1>
            <div class="oh pt5">
              <div class="pull-left">
                <?php if (!empty($propiedad->direccion_completa) || !empty($propiedad->localidad)) { ?>
                  <p>
                    <i class="fa fa-map-marker"></i><?php 
                    echo ((!empty($propiedad->direccion_completa)) ? $propiedad->direccion_completa.". " : "");
                    echo (!empty($propiedad->localidad) ? " ".$propiedad->localidad : ""); ?>
                  </p>
                <?php } ?>
              </div>
              <div class="pull-right">
                <h3>
                  <span>
                    <?php echo ($propiedad->precio_final != 0 && $propiedad->publica_precio == 1) ? $propiedad->moneda." ".number_format($propiedad->precio_final,0) : "Consultar"; ?>
                    <?php if ($propiedad->precio_porcentaje_anterior < 0.00 && $propiedad->publica_precio == 1) { ?>
                      <span class="dib" style="color: #0dd384;">(<img src="images/arrow_down.png" alt="Home" /> <?= floatval($propiedad->precio_porcentaje_anterior*-1) ?>%)</span>
                    <?php } ?>  
                  </span>
                </h3>
              </div>
            </div>
            <p class="codigo oh">
              <div class="fl">
                <b>Código:</b> <?php echo $propiedad->codigo ?>
              </div>
              <?php if (!empty($propiedad->valor_expensas)) { ?>
                <div class="fr">
                  <b>Expensas: </b> <?php echo "$ ".number_format($propiedad->valor_expensas,0) ?>
                </div>
              <?php } ?>
            </p>
          </div>
          <!-- Properties details section start -->
          <div class="sidebar-widget mrg-btm-40">
            <!-- Properties detail slider start -->
            <div class="properties-detail-slider simple-slider mrg-btm-40 ">
              <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                <div class="carousel-outer">
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                    <?php if (!empty($propiedad->images)) {  ?>
                      <?php $i=0; 
                      foreach ($propiedad->images as $img) { $i++; ?>
                        <div class="item <?php echo ($i==1) ? "active" : "" ?>">
                          <a data-fancybox="gallery" href="<?php echo $img ?>">
                            <img src="<?php echo $img ?>" class="thumb-preview" alt="<?php echo $propiedad->nombre ?>">
                            <?php if ($propiedad->id_tipo_estado >= 2) { ?>
                              <div class="property-tag button vendido alt featured"><?php echo $propiedad->tipo_estado ?></div>
                            <?php } ?>                            
                          </a>
                        </div>
                        <a class="left carousel-control" href="#carousel-custom" role="button" data-slide="prev">
                          <span class="slider-mover-left no-bg" aria-hidden="true">
                            <i class="fa fa-angle-left"></i>
                          </span>
                          <span class="sr-only">Siguiente</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-custom" role="button" data-slide="next">
                          <span class="slider-mover-right no-bg" aria-hidden="true">
                            <i class="fa fa-angle-right"></i>
                          </span>
                          <span class="sr-only">Anterior</span>
                        </a>
                      <?php } ?>
                    <?php } else if (!empty($propiedad->imagen)) { ?>
                      <div class="item active">
                        <a data-fancybox="gallery" href="<?php echo $propiedad->imagen ?>">
                          <img src="<?php echo $propiedad->imagen ?>" class="thumb-preview">
                        </a>
                      </div>
                    <?php } else if (empty($propiedad->imagen) && !empty($propiedad->video)) { ?>
                      <?php $mostro_video = 1; echo $propiedad->video ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>

            <?php if (!empty($propiedad->texto)) { ?>
              <div class="properties-description mrg-btm-40 ">
                <div class="main-title-2">
                  <h2><span>Descripción</span></h2>
                </div>
                <?php echo $propiedad->texto ?>              
              </div>
            <?php } ?>

            <div class="properties-condition mrg-btm-20 ">
              <div class="main-title-2">
                <h2><span>Más detalles</span></h2>
              </div>
              <div class="row">

                <div class="caracteristicas_ppales col-xs-12">
                  <?php ver_caracteristicas($propiedad) ?>
                </div>

                <?php if (!empty($propiedad->superficie_cubierta)) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-star-o"></i><?php echo "Sup. Cubierta: ".$propiedad->superficie_cubierta." mts<sup>2</sup>"; ?>
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if (!empty($propiedad->superficie_semicubierta)) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-star-half-empty"></i><?php echo "Sup. Semicubierta: ".$propiedad->superficie_semicubierta." mts<sup>2</sup>"; ?>
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if (!empty($propiedad->superficie_descubierta)) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-star"></i><?php echo "Sup. Descubierta: ".$propiedad->superficie_descubierta." mts<sup>2</sup>"; ?>
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if (!empty($propiedad->superficie_total)) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-star"></i><?php echo "Sup. Total: ".$propiedad->superficie_total." mts<sup>2</sup>"; ?>
                      </li>
                    </ul>
                  </div>
                <?php } ?>

                <?php if (!empty($propiedad->caracteristicas)) {  ?>
                  <?php $array = explode (";;;",$propiedad->caracteristicas) ?>
                  <?php foreach($array as $a) { ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <ul class="condition">
                        <li>
                          <i class="fa fa-check"></i><?php echo $a ?>
                        </li>
                      </ul>
                    </div>
                  <?php } ?>
                <?php } ?>

                <?php if ($propiedad->mts_frente != 0) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-arrows-h"></i>
                        Frente: <?php echo str_replace(".00", "", $propiedad->mts_frente) ?> Mts.
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->mts_fondo != 0) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-arrows-v"></i>
                        Fondo: <?php echo str_replace(".00", "", $propiedad->mts_fondo) ?> Mts.
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->id_tipo_inmueble != 5 && $propiedad->id_tipo_inmueble != 6 && $propiedad->id_tipo_inmueble != 7 && $propiedad->id_tipo_inmueble != 13 && $propiedad->id_tipo_inmueble != 9 && $propiedad->id_tipo_inmueble != 10) { ?>
                  
                  <?php if (!empty($propiedad->ambientes)) { ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <ul class="condition">
                        <li>
                          <i class="fa fa-home"></i><?php echo $propiedad->ambientes ?> Ambientes
                        </li>
                      </ul>
                    </div>
                  <?php } ?>

                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-bed"></i><?php echo (!empty($propiedad->dormitorios)) ? $propiedad->dormitorios : "-" ?> Dormitorios
                      </li>
                    </ul>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-bath"></i><?php echo (!empty($propiedad->banios)) ? (($propiedad->banios == 1)?"1 Baño":$propiedad->banios." Baños") : "-" ?>
                      </li>
                    </ul>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-car"></i><?php echo (!empty($propiedad->cocheras)) ? (($propiedad->cocheras == 1)?"Cochera":$propiedad->cocheras." Cocheras") : "Sin cochera" ?>
                      </li>
                    </ul>
                  </div>
                <?php } ?>

                <?php if ($propiedad->servicios_cloacas == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-bath"></i>Cloacas
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_agua_corriente == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-tint"></i>Agua Corriente
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_electricidad == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-bolt"></i>Electricidad
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_asfalto == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-truck"></i>Asfalto
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_gas == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-fire"></i>Gas Natural
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_telefono == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-phone"></i>Teléfono
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_cable == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-television"></i>TV Cable
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_aire_acondicionado == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Aire Acondicionado
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_uso_comercial == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Uso Comercial
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->servicios_internet == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Internet
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->gimnasio == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Gimnasio
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->parrilla == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Parrilla
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->permite_mascotas == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Permite Mascotas
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->piscina == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Piscina
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->vigilancia == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Vigilancia
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->sala_juegos == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Sala de Juegos
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->ascensor == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Ascensor
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->lavadero == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Lavadero
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->living_comedor == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Living Comedor
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->terraza == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Terraza
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->accesible == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Accesible
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->balcon == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Balcon
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->patio == 1) { ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-check"></i>Patio
                      </li>
                    </ul>
                  </div>
                <?php } ?>
                <?php if ($propiedad->apto_banco == 1) {  ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-bank"></i>Apto para crédito bancario
                      </li>
                    </ul>
                  </div>
                <?php } ?>

                <?php if ($propiedad->acepta_permuta == 1) {  ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="condition">
                      <li>
                        <i class="fa fa-exchange"></i>Posibilidad de permuta
                      </li>
                    </ul>
                  </div>
                <?php } ?>

              </div>
            </div>
            <!-- Properties condition end -->
          </div>
          <!-- Properties details section end -->

          <!-- Location start -->
          <?php if(!empty($propiedad->latitud)) { ?>
            <div class="location sidebar-widget">
              <div class="map">
                <div class="main-title-2 mb10">
                  <h2><span>Ubicación</span></h2>
                </div>
                <div class="heading-properties mb20">
                  <p>
                    <i class="fa fa-map-marker"></i><?php echo $propiedad->direccion_completa.", ".$propiedad->localidad?>
                  </p>
                </div>
                <div id="googleMap" style="width:100%;height:320px;"></div>
              </div>
            </div>
          <?php } ?>

          <div class="sidebar-widget contact-form agent-widget">
            <div class="main-title-2">
              <h2>Consultá por esta propiedad</h2>
            </div>
            <form onsubmit="return enviar_contacto();">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <input type="text" id="contacto_nombre" name="nombre" class="input-text" placeholder="Nombre">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group enter-email">
                    <input type="email" id="contacto_email" name="email" class="input-text" placeholder="Email">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group number">
                    <input type="text" id="contacto_telefono" name="phone" class="input-text"  placeholder="Teléfono">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group message">
                    <textarea class="input-text" id="contacto_mensaje" name="message" placeholder="Mensaje"></textarea>
                  </div>
                </div>
                <div class="col-lg-12">
                  <button type="submit" id="contacto_submit" class="button-md button-theme btn-block">Enviar consulta</button>
                </div>
              </div>
            </form>
          </div>
          
          <?php if (!empty($propiedad->video) && $mostro_video == 0) {  ?>
            <div class="inside-properties sidebar-widget">
              <div class="main-title-2">
                <h2><span>Video</span></h2>
              </div>
              <?php 
              if (strpos($propiedad->video, "iframe")>0) echo $propiedad->video;
              else {
                $pars_video = parse_url($propiedad->video, PHP_URL_QUERY);
                if (isset($pars_video["v"])) {
                  echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$pars_video["v"].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                }
              } ?>
            </div>
          <?php } ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <!-- Sidebar start -->
          <div class="sidebar right">
            
            <?php include("includes/avanzada.php"); ?>

            <div class="social-media sidebar-widget clearfix">
              <!-- Main Title 2 -->
              <div class="main-title-2">
                <h4>Compartir propiedad</h4>
              </div>
              <!-- Social list -->
              <ul class="social-list">
                <li><a class="facebook" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()) ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a class="twitter" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(html_entity_decode($propiedad->nombre,ENT_QUOTES)) ?>&amp;url=<?php echo urlencode(current_url()) ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a class="google" href="https://plus.google.com/share?url=<?php echo current_url() ?>" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                <li><a class="mail" href="mailto:?subject=<?php echo html_entity_decode($propiedad->nombre,ENT_QUOTES) ?>&body=<?php echo(current_url()) ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                <li><a class="whatsapp" href="whatsapp://send?text=<?php echo urlencode(current_url()) ?>"><i class="fa fa-whatsapp"></i></a></li>
              </ul>
            </div>
            
            <?php //include("includes/destacadas.php"); ?>
            
          </div>
          <!-- Sidebar end -->
        </div>


        <?php if (!empty($propiedad->relacionados)) { ?>
          <div class="col-xs-12">
            <div class="row">
              <div class="recently-properties clearfix">
                <?php foreach ($propiedad->relacionados as $p) { ?>
                  <div class="col-sm-4 col-xs-12">
                    <div class="property">
                      <div class="property-img">
                        <?php /*if ($p->id_tipo_estado == 2 || $p->id_tipo_estado == 3 || $p->id_tipo_estado == 4) { ?>
                          <div class="property-tag button vendido alt featured"><?php echo $p->tipo_estado ?></div>
                        <?php } else { ?>
                          <div class="property-tag button alt featured"><?php echo $p->tipo_operacion ?></div>
                        <?php }*/ ?>
                        <?php if (!empty($p->imagen)) { ?>
                          <img class="img-responsive" src="<?php echo $p->imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                        <?php } else if (!empty($empresa->no_imagen)) { ?>
                          <img class="img-responsive" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                        <?php } else { ?>
                          <img class="img-responsive" src="images/logo.png" alt="<?php echo ($p->nombre); ?>" />
                        <?php } ?>
                        <div class="hover">
                          <a href="<?php echo $p->link_propiedad ?>"><i class="fa fa-plus"></i></a>
                          <a href="/admin/favoritos/agregar/?id=<?php echo $p->id; ?>"><i class="fa fa-heart"></i></a>
                        </div>
                      </div>
                      <div class="property-content">
                        <div class="height-igual">
                          <!-- title -->
                          <h5 class="title">
                            <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                          </h5>
                          <div class="precio_final">
                            <?php echo $p->precio ?>
                          </div>                          
                          <?php echo ver_direccion($p); ?>
                          <?php echo ver_caracteristicas($p); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </div>
  <!-- Properties details page end -->
  <!-- Footer start -->
<?php include "includes/footer.php" ?>
<script type="text/javascript" src="js/jquery.fancybox.min.js"></script>

<script>
$(document).ready(function(){
  <?php if (!empty($propiedad->latitud && !empty($propiedad->longitud))) { ?>
    var mymap = L.map('googleMap').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
    }).addTo(mymap);


    var icono = L.icon({
      iconUrl: 'images/map-marker.png',
      iconSize:     [48, 33], // size of the icon
      iconAnchor:   [22, 33], // point of the icon which will correspond to marker's location
    });

    L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>]).addTo(mymap);

  <?php } ?>
});
</script>
<script type="text/javascript">
function enviar_orden() { 
  $("#orden_form").submit();
}
function enviar_contacto() {
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var id_propiedad = "<?php echo $propiedad->id ?>";
  
  if (isEmpty(nombre)) {
    alert("Por favor ingrese un nombre");
    $("#contacto_nombre").focus();
    return false;          
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_email").focus();
    return false;          
  }
  if (isEmpty(telefono)) {
    alert("Por favor ingrese un telefono");
    $("#contacto_telefono").focus();
    return false;          
  }
  if (isEmpty(mensaje)) {
    alert("Por favor ingrese un mensaje");
    $("#contacto_mensaje").focus();
    return false;              
  }    
  
  $("#contacto_submit").attr('disabled', 'disabled');
  var datos = {
    "para":"<?php echo $empresa->email ?>",
    "bcc":"<?php echo $empresa->bcc_email ?>",
    "nombre":nombre,
    "asunto": "Contacto para: <?php echo $propiedad->nombre ?>",
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "id_propiedad":id_propiedad,
    "id_empresa":ID_EMPRESA,
    "id_empresa_relacion":"<?php echo $id_empresa ?>",
    "id_origen": 9,
  }
  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        window.location.href ='<?php echo mklink ("web/gracias/") ?>';
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
      }
    }
  });
  return false;
}
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