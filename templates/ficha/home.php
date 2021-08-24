<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("includes/head.php"); ?>
<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo ($propiedad->titulo." - ".$propiedad->subtitulo); ?>" />
<?php $og_desc = strip_tags(html_entity_decode($propiedad->texto,ENT_QUOTES));
$og_desc = str_replace("\n","",$og_desc);
$og_desc = str_replace("\"","",$og_desc);
$og_desc = (strlen($og_desc)>180) ? substr($og_desc, 0, 180)."..." : $og_desc; ?>
<meta property="og:description" content="<?php echo $og_desc ?>" />
<?php if (!empty($propiedad->path)) { ?>
<meta property="og:image" content="<?php echo current_url(TRUE); ?><?php echo (!empty($propiedad->images[0]))?$propiedad->images[0]:$propiedad->path; ?>"/>
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<?php } ?>
</head>
<body class="bgcolorA">
  <div id="big_slides_container" style="display:none;">
  	<div id="big_slides_close" onClick="close_enlarged()">X</div>
  	<div id="big_slides_prev" onClick="prev_enlarged()"></div>
  	<div id="big_slides_next" onClick="next_enlarged()"></div>
    <img id="big_img" onload="center()">
  </div>
  <div class="header"> 
    <img src="/admin/<?= $empresa->logo_1 ?>" height="100" />
  </div>
  <div id="property_detail_wrapper" class="content_wrapper">
    <div id="property_detail_content">
      <div id="ficha">
        <div id="header_ficha">
          <div class="titulo_header">
            <div class="titulo_address" style="">
              <?php echo $propiedad->nombre ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="ficha_slider">
      <ul class="slides" onClick="enlarge()">
        <?php foreach ($propiedad->images as $key) { ?>
          <li data-thumb="<?= $key ?>">
            <img src="<?= $key ?>"  class="zoomImg" />
          </li>
        <?php } ?>
      </ul>
    </div>
    <div class="tostick">
      <div id="ficha_detalle" class="card">
        <div id="ficha_detalle_head" class="bgcolorC" style="text-transform: uppercase;">Detalles de la propiedad</div>
          <div id="ficha_detalle_cuerpo">
            <div class="operations-box">
              <div class="op-venta">
                <?php if(isset($propiedad->tipo_operacion)){ ?>
                  <div class="op-operation"><?= $propiedad->tipo_operacion ?></div>
                <?php } ?>
                <div class="op-values"> 
                  <div class="op-value"><?= $propiedad->precio ?></div>
                </div>
              </div>
            </div>
            <div class="ficha_detalle_item">
              <b>Dirección:</b><br/>
              <?php echo $propiedad->direccion_completa ?>
            </div>
            <?php if(isset($propiedad->localidad)){ ?>
              <div class="ficha_detalle_item">
                <b>Localidad/Partido:</b><br/><?= $propiedad->localidad ?>
              </div>
            <?php } ?>
            <?php if(isset($propiedad->codigo)){ ?>
              <div id="ficha_detalle_ref">( COD. <?= $propiedad->codigo ?> )</div>
            <?php } ?>
          </div>
          <div id="slider_thumbs" class="noprint mb20">
            <?php
            $x_img = 0;
            foreach ($propiedad->images as $key) { ?>
              <a data-slide-index="<?= $x_img ?>" href="">
                <img src="<?= $key ?>" data-big="<?= $key ?>" class="slider-thumb">
              </a>
            <?php $x_img +=1; } ?>
          </div>
        </div>

        <?php 
        // SI LA PROPIEDAD ES LA MISMA QUE LA EMPRESA
        if ($empresa->id == $propiedad->id_empresa) { 
          // Entonces tomamos los datos del vendedor
          $nombre_usuario = (!empty($propiedad->usuario) ? $propiedad->usuario : $empresa->nombre);
          $email_usuario = (!empty($propiedad->usuario_email) ? $propiedad->usuario_email : $empresa->email);
          $telefono_usuario = (!empty($propiedad->usuario_celular) ? $propiedad->usuario_celular : $empresa->telefono);
        } else {
          // Tomamos los datos de la empresa
          $nombre_usuario = $empresa->nombre;
          $email_usuario = $empresa->email;
          $telefono_usuario = $empresa->telefono;
        } 
        $telefono_usuario_f = preg_replace('/\D/', '', $telefono_usuario); ?>
        <div id="producer_container" class="card">
          <img src="assets/images/icon-agent.png"/>
          <div id="producer_info">
            <div id="producer_name"><?= $nombre_usuario ?></div>
            <div class="producer-item">
              <a href="mailto:<?= $email_usuario ?>">
                <img src="templates/ficha/assets/img/mail.svg">
                <div><?= $email_usuario ?></div>
              </a>
            </div>
            <div class="producer-item">
              <a href="tel:<?= $telefono_usuario_f ?>" >
                <img src="templates/ficha/assets/img/cellphone.svg">
                <div><?= $telefono_usuario ?></div>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div id="ficha_desc">
        <section id="ficha_informacion_basica" class="card">
          <div class="titulo2">Información básica</div>
          <ul class="ficha_ul" id="lista_informacion_basica">
          <?= isset($propiedad->ambientes) ? "<li><i class='fa fa-check detalleColorC'></i>Ambientes: $propiedad->ambientes </li>" : "" ?>
          <?= isset($propiedad->dormitorios) ? "<li><i class='fa fa-check detalleColorC'></i>Dormitorios: $propiedad->dormitorios  </li>" : "" ?>
          <?= isset($propiedad->banios) ? "<li><i class='fa fa-check detalleColorC'></i>Baños: $propiedad->banios </li>" : "" ?>
          <?= isset($propiedad->cocheras) ? "<li><i class='fa fa-check detalleColorC'></i>Cocheras: $propiedad->cocheras </li>" : "" ?>
          <?= $propiedad->parrilla != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Parrilla: Si </li>" : "" ?>
          <?= $propiedad->permite_mascotas != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Permite Mascotas: Si </li>" : "" ?>
          <?= $propiedad->piscina != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Piscina: Si </li>" : "" ?>
          <?= $propiedad->vigilancia != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Vigilancia: Si </li>" : "" ?>
          <?= $propiedad->sala_juegos != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Sala de Juegos: Si </li>" : "" ?>
          <?= $propiedad->ascensor != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Ascensor: Si </li>" : "" ?> 
          <?= $propiedad->lavadero != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Lavadero: Si </li>" : "" ?> 
          <?= $propiedad->living_comedor != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Living Comedor: Si </li>" : "" ?>  
          <?= $propiedad->terraza != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Terraza: Si </li>" : "" ?> 
          <?= $propiedad->accesible != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Accesible: Si </li>" : "" ?> 
          <?= $propiedad->gimnasio != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Gimnasio: Si </li>" : "" ?> 
          <!--<?= $propiedad->servicios_aire_acondicionado != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Aire Acondicionado: Si </li>" : "" ?> 
          <?= $propiedad->servicios_uso_comercial != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Uso Comercial: Si </li>" : "" ?> 
          <?= $propiedad->servicios_internet != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Internet: Si </li>" : "" ?> 
          <?= $propiedad->servicios_gas != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Gas: Si </li>" : "" ?> 
          <?= $propiedad->servicios_cloacas != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Cloacas: Si </li>" : "" ?> 
          <?= $propiedad->servicios_agua_corriente != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Agua Corriente: Si </li>" : "" ?> 
          <?= $propiedad->servicios_asfalto != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Asfalto: Si </li>" : "" ?>  
          <?= $propiedad->servicios_electricidad != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Electricidad: Si </li>" : "" ?> 
          <?= $propiedad->servicios_telefono != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Telefono: Si </li>" : "" ?> 
          <?= $propiedad->servicios_cable != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Cable: Si </li>" : "" ?>  -->
          <?= $propiedad->balcon != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Balcon: Si </li>" : "" ?> 
          <?= $propiedad->patio != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Patio: Si </li>" : "" ?> 
          <?= $propiedad->acepta_financiacion != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Financiacion: Si </li>" : "" ?> 
          <?= $propiedad->acepta_permuta != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Acepta Permuta: Si </li>" : "" ?> 
          </ul>
        </section>
        <section class="card">
          <div class="titulo2">Servicios</div>
          <ul class="ficha_ul" id="lista_informacion_basica">
          <?= $propiedad->servicios_aire_acondicionado != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Aire Acondicionado: Si </li>" : "" ?> 
          <?= $propiedad->servicios_uso_comercial != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Uso Comercial: Si </li>" : "" ?> 
          <?= $propiedad->servicios_internet != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Internet: Si </li>" : "" ?> 
          <?= $propiedad->servicios_gas != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Gas: Si </li>" : "" ?> 
          <?= $propiedad->servicios_cloacas != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Cloacas: Si </li>" : "" ?> 
          <?= $propiedad->servicios_agua_corriente != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Agua Corriente: Si </li>" : "" ?> 
          <?= $propiedad->servicios_asfalto != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Asfalto: Si </li>" : "" ?>  
          <?= $propiedad->servicios_electricidad != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Electricidad: Si </li>" : "" ?> 
          <?= $propiedad->servicios_telefono != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Telefono: Si </li>" : "" ?> 
          <?= $propiedad->servicios_cable != 0 ? "<li><i class='fa fa-check detalleColorC'></i>Cable: Si </li>" : "" ?> 
          </ul>
        </section> 
        <section id="ficha_superficies" class="card">
          <div class="titulo2">Superficies</div>
          <ul class="ficha_ul" id="lista_superficies">
            <?= !empty($propiedad->superficie_cubierta) ? "<li><i class='fa fa-check detalleColorC'></i>Superficie Cubierta: $propiedad->superficie_cubierta m²</li>" : "" ?>
            <?= !empty($propiedad->superficie_semicubierta) ? "<li><i class='fa fa-check detalleColorC'></i>Superficie Semicubierta: $propiedad->superficie_semicubierta m²</li>" : "" ?>
            <?= !empty($propiedad->superficie_descubierta) ? "<li><i class='fa fa-check detalleColorC'></i>Superficie Descubierta: $propiedad->superficie_descubierta m²</li>" : "" ?>
            <?= !empty($propiedad->superficie_total) ? "<li><i class='fa fa-check detalleColorC'></i>Superficie Total: $propiedad->superficie_total m² </li>" : "" ?>
          </ul>
        </section>
        <div class="card">
          <div class="titulo2">
            Descripción
          </div>
          <?= $propiedad->texto ?>
        </div>
      </div>

      <section id="ficha_mapa" class="card">
        <div class="titulo2">Ubicación</div>
        <div style="height: 400px" id="mapid"></div>
      </section>

      <section id="ficha_mapa" class="card noprint">
        <div class="titulo2">Contacto</div>
        <?php include("contacto.php") ?>
      </section>

    </div>
  </div>
  <div class="footer">
    <div class="powered">
      Somos parte de 
    </div>
      <a href="https://www.inmovar.com/" target="_blank"> 
        <img class="poweredimg" src="/admin/resources/images/inmovar-grande.png" />
      </a>
  </div>

  <?php include('includes/footer.php'); ?>

</div>
</body>
</html>
