<?php include "includes/init.php" ?>
<?php $page_active = "inicio" ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include "includes/head.php" ?>
</head>
<body>

  <?php include "includes/header.php" ?>

  <?php /*if ($empresa->id == 730) { ?>
    <?php $slide = $web_model->get_slider()?>
    <style type="text/css">.fondo { <?php if(sizeof($slide)>0) { $s = $slide[0]; echo 'background-image:url('.$s->path.')'; } ?> }</style>
    <section class="home-video-section">
      <div id="player" class="container-player"></div>
    </section>
  <?php } else {*/ ?>
    <?php $slide = $web_model->get_slider()?>
    <?php if (!empty($slide)) { ?>
      <section class="subheader subheader-slider subheader-slider-with-filter">
        <div class="slider-ppal owl-carousel">
          <?php foreach ($slide as $s){  ?>
            <div class="item">
              <div class="<?php echo (!empty($s->linea_1)?"shadow":"") ?>" style="height: 600px; background-size: cover; background-position: center center; background-image: url(<?php echo $s->path ?>)">
                <?php if (!empty($s->linea_1)) { ?>
                  <div class="container">
                    <h1 class="tac pb30" style="padding-top: 140px !important; text-shadow: 0px 0px 14px black;"><?php echo $s->linea_1 ?></h1>
                    <p class="tac" style="text-shadow: 0px 0px 14px black;"><?php echo $s->linea_2 ?></p>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </div><!-- end slider -->
      </section>
    <?php } ?>
  <?php //} ?>
  <section class="module no-padding-top filter filter-with-slider">
    <div class="container">
      <div class="tabs ui-tabs ui-corner-all ui-widget ui-widget-content" style="display: block;">

        <div id="tabs-1" class="ui-tabs-hide ui-tabs-panel ui-corner-bottom ui-widget-content" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
          <form onsubmit="enviar_buscador_propiedades()" id="form_propiedades">
            <div class="row">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-4">
                    <div class="filter-item">
                      <label>Tipo de Operación</label>
                      <select id="tipo_operacion" >
                        <?php $tipos_operaciones = $propiedad_model->get_tipos_operaciones() ?>
                        <option value="todas">Todas</option>
                        <?php foreach ($tipos_operaciones as $tp) { ?>
                          <option value="<?php echo $tp->link ?>"><?php echo $tp->nombre ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="filter-item">
                      <label>Localidad</label>
                      <select id="localidad">
                        <?php $localidades = $propiedad_model->get_localidades() ?>
                        <option value="todas">Todas</option>
                        <?php foreach ($localidades as $l) { ?>
                          <option value="<?php echo $l->link ?>"><?php echo $l->nombre ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="filter-item">
                      <label>Tipo de Propiedad</label>
                      <select id="tp" name="tp">
                        <?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades() ?>
                        <option value="">Todas</option>
                        <?php foreach ($tipos_propiedades as $tp) { ?>
                          <option value="<?php echo $tp->id ?>" ><?php echo $tp->nombre ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="row">
                  <div class="col-md-4">
                    <div class="filter-item">
                      <label>Direcci&oacute;n</label>
                      <input type="text" class="form-control" name="calle"/>
                    </div>
                  </div>                                    
                  <div class="col-md-4">
                    <div class="filter-item">
                      <label>Código</label>
                      <input type="text" class="form-control mb5" name="cod"/>
                    </div>
                    <div class="mb10 cb w100p oh">
                      <input id="apto_banco" class="border fl" type="checkbox" <?php echo (!empty($vc_apto_banco))?"checked":"" ?> name="banco" value="1">
                      <label class="fl" for="apto_banco">Apto Crédito</label>
                    </div>                    
                  </div>
                  <div class="col-md-4">
                    <div class="filter-item">
                      <label class="label-submit">Enviar</label><br>
                      <input type="submit" class="button alt w100p tac" value="Buscar">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>  
        <div class="clear"></div>
      </div>
    </div><!-- end tabs -->
  </div><!-- end container -->
</section>

<section class="module services">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-4">
        <div class="service-item shadow-hover">
          <?php $t = $web_model->get_text("box-one","Casas")?>
          <a href="<?php echo (!empty($t->link) ? $t->link : "javascript:void(0)") ?>"><i class="fa fa-home"></i></a>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><a href="<?php echo (!empty($t->link) ? $t->link : "javascript:void(0)") ?>"><?php echo $t->plain_text ?></a></h4>
          <?php $t = $web_model->get_text("box-one-txt","Depts accumsan ipsum velit Nam nec tellus a odio tincidunt auctor a ornare odio sedlon maurisvitae erat consequat auctor")?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="service-item shadow-hover">
          <?php $t = $web_model->get_text("box-two","Departamentos")?>
          <a href="<?php echo (!empty($t->link) ? $t->link : "javascript:void(0)") ?>"><i class="fa fa-building"></i></a>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><a href="<?php echo (!empty($t->link) ? $t->link : "javascript:void(0)") ?>"><?php echo $t->plain_text ?></a></h4>
          <?php $t = $web_model->get_text("box-two-txt","Claps accumsan ipsum velit Nam nec tellus a odio tincidunt auctor a ornare odio sedlon maurisvitae erat consequat auctor")?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="service-item shadow-hover">
          <?php $t = $web_model->get_text("box-three","Consultas")?>
          <a href="<?php echo (!empty($t->link) ? $t->link : "javascript:void(0)") ?>"><i class="fa fa-file-text"></i></a>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><a href="<?php echo (!empty($t->link) ? $t->link : "javascript:void(0)") ?>"><?php echo $t->plain_text ?></a></h4>
          <?php $t = $web_model->get_text("box-three-txt","Own accumsan ipsum velit Nam nec tellus a odio tincidunt auctor a ornare odio sedlon maurisvitae erat consequat auctor")?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
        </div>
      </div>
    </div><!-- end row -->
  </div><!-- end container -->
</section>




<?php 
$destacados = $propiedad_model->destacadas(array(
  "offset"=>12
)); 
if (sizeof($destacados)>0) { ?> 
  <section class="module no-padding properties featured">
    <div class="container">
      <div class="module-header">
        <h2>Propiedades <strong>Destacadas</strong></h2>
        <hr class="divisorcenter">
        <?php $t = $web_model->get_text("Destacados","Own accumsan ipsum velit Nam nec tellus a odio tincidunt auctor a ornare odio sedlon maurisvitae erat consequat auctor.")?>
        <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
          <?php echo $t->plain_text ?>
        </p>
      </div>
    </div>
    <div class="destacados owl-carousel">
      <?php foreach ($destacados as $d) {  ?> 
        <div class="item">
          <div class="property">
            <a href="<?php echo $d->link_propiedad ?>" class="property-img">
              <div class="img-fade"></div>
              <div class="property-tag button alt featured"><?php echo $d->tipo_operacion ?></div>
              <div class="property-tag button status"><?php echo $d->tipo_inmueble ?></div>
              <div class="property-price"><?php echo $d->precio ?></div>
              <div class="property-color-bar"></div>
              <div class="">
                <img src="/admin/<?php echo $d->path ?>" class="mi-img-responsive" />
              </div>
            </a>
            <a href="<?php echo $d->link_propiedad ?>" class="property-content">
              <div class="property-title">
                <h4><?php echo ucwords(strtolower($d->nombre)) ?></h4>
                <p class="property-address"><i class="fa fa-map-marker icon"></i><?php echo $d->direccion_completa." - ".$d->localidad?></p>
              </div>
              <table class="property-details">
                <tr>
                  <td><i class="fa fa-bed"></i> <?php echo (empty($d->dormitorios)) ? "-" : $d->dormitorios?> Dorm</td>
                  <td><i class="fa fa-shower"></i> <?php echo (empty($d->banios)) ? "-" : $d->banios ?> Baño<?php echo ($d->banios > 1)?"s":""?></td>
                  <td><i class="fa fa-expand"></i> <?php echo (empty($d->superficie_total)) ? "-" : $d->superficie_total ?> m<sup>2</sup></td>
                </tr>
              </table>
            </a>
          </div>
        </div>
      <?php } ?>
    </div><!-- end slider -->
  </section>
<?php } ?>

<?php /*
<section class="module property-categories">
  <div class="container">
    <div class="module-header">
      <h2>Browse Our Most <strong>Popular Categories</strong></h2>
      <hr class="divisorcenter">
      <p>Morbi accumsan ipsum velit nam nec tellus a odiose tincidunt auctor a ornare odio sed non mauris vitae erat consequat auctor</p>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-4">
        <a href="#" class="property-cat property-cat-condos">
          <h3>Condos & Villas</h3>
          <div class="color-bar"></div>
          <span class="button small">234 Properties</span>
        </a>
      </div>
      <div class="col-lg-4 col-md-4">
        <a href="#" class="property-cat property-cat-waterfront">
          <h3>Waterfront Homes</h3>
          <div class="color-bar"></div>
          <span class="button small">234 Properties</span>
        </a>
      </div>
      <div class="col-lg-4 col-md-4">
        <a href="#" class="property-cat property-cat-cozy">
          <h3>Cozy Houses</h3>
          <div class="color-bar"></div>
          <span class="button small">234 Properties</span>
        </a>
      </div>
    </div><!-- end row -->
  </div><!-- end container -->
</section>
*/ ?>

<?php $propiedades = $propiedad_model->ultimas(array("offset"=>3)); ?>
<?php if (!empty($propiedades)) { ?>
  <section class="module no-padding properties ultimas mb30">
    <div class="container">
      <div class="module-header">
        <h2>&Uacute;ltimas <strong>Propiedades</strong></h2>
        <hr class="divisorcenter">
        <?php $t = $web_model->get_text("Propiedades-txt","Own accumsan ipsum velit Nam nec tellus a odio tincidunt auctor a ornare odio sedlon maurisvitae erat consequat auctor.")?>
        <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
          <?php echo $t->plain_text ?>
        </div>
        <div class="row">
          <?php foreach ($propiedades as $p) { ?>
            <div class="col-lg-4 col-md-4">
              <div class="property shadow-hover">
                <a href="<?php echo $p->link_propiedad ?>" class="property-img">
                  <div class="img-fade"></div>
                  <div class="property-tag button alt featured"><?php echo $p->tipo_inmueble?></div>
                  <div class="property-tag button status">
                    <?php echo ($p->tipo_operacion_link == "alquileres")?"Alquilamos":"" ?>
                    <?php echo ($p->tipo_operacion_link == "ventas")?"Vendemos":"" ?>
                    <?php echo ($p->tipo_operacion_link == "alquileres-temporarios")?"Alquilamos":"" ?>
                  </div>
                  <div class="property-price"><?php echo $p->precio ?></div>
                  <div class="property-color-bar"></div>
                  <div class="">
                    <img class="mi-img-responsive" src="/admin/<?php echo $p->path ?>" alt="" />
                  </div>
                </a>
                <div class="property-content">
                  <div class="property-title">
                    <h4><a href="<?php echo $p->link_propiedad ?>"><?php echo ucwords(strtolower($p->nombre)) ?></a></h4>
                    <p class="property-address"><i class="fa fa-map-marker icon"></i><?php echo $p->direccion_completa ?></p>
                  </div>
                  <table class="property-details">
                    <tr>
                      <td><i class="fa fa-bed"></i> <?php echo (empty($p->dormitorios)) ? "-" : $p->dormitorios?> Dorm</td>
                      <td><i class="fa fa-tint"></i> <?php echo (empty($p->banios)) ? "-" : $p->banios ?> Baño<?php echo ($p->banios > 1)?"s":""?></td>
                      <td><i class="fa fa-expand"></i> <?php echo (empty($p->superficie_total)) ? "-" : $p->superficie_total ?> m<sup>2</sup></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          <?php } ?>
        </div><!-- end row -->
        <div class="center"><a href="<?php echo mklink ("propiedades/") ?>" class="button button-icon more-properties-btn"><i class="fa fa-angle-right"></i> Ver más propiedades</a></div>
      </div><!-- end container -->
    </section>
  <?php } ?>


<?php 
$listado = $entrada_model->get_list(array(
  "from_link_categoria"=>"blog"
)) ?>
  <?php if (!empty($listado)) {  ?>
    <section class="module properties">
      <div class="container">

        <div class="module-header">
          <h2><strong>Novedades</strong></h2>
          <hr class="divisorcenter">
          <?php $t = $web_model->get_text("Blog-Txt","BB accumsan ipsum velit Nam nec tellus a odio tincidunt auctor a ornare odio sedlon maurisvitae erat consequat auctor.")?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
            <?php echo $t->plain_text ?>
          </div>

          <div class="row">
            <?php foreach ($listado as $l) { ?>
              <div class="col-lg-4 col-md-4">
                <div class="property shadow-hover">
                  <?php if (!empty($l->path)) { ?>
                    <a href="<?php echo mklink ($l->link) ?>" class="property-img">
                      <div class="img-fade"></div>
                      <div class="property-tag button status-left"><?php echo $l->categoria ?></div>
                      <div class="property-color-bar"></div>
                      <img src="<?php echo $l->path ?>" alt="<?php echo ucwords(strtolower($l->titulo)) ?>" />
                    </a>
                  <?php } ?>
                  <div class="property-content">
                    <div class="property-title">
                      <h4><a href="<?php echo mklink ($l->link) ?>"><?php echo ucwords(strtolower($l->titulo)) ?></a></h4>
                      <p class="property-address">
                        <?php echo ((substr($l->plain_text,0,140))); echo (strlen($l->plain_text)>140)?"...":"" ?>                    
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div><!-- end row -->
          <div class="center"><a href="<?php echo mklink ("entradas/blog/") ?>" class="button button-icon more-properties-btn"><i class="fa fa-angle-right"></i> Ver más noticias</a></div>

        </div><!-- end container -->
      </section>
    <?php } ?>



<?php include "includes/footer.php" ?>

<?php include "includes/scripts.php" ?>
<script type="text/javascript" src="js/player.min.js"></script>

<script type="text/javascript">
//Parallax Script
/*
$(window).resize(function() {
  if (screen.width >= 768) {
    $('#player').ContainerPlayer({
      youTube: {  
        videoId: '9FbYfRFI4wQ',
        poster: false,
      },
      }).on('video.playing video.paused video.loaded video.ended', function(e) {
      console.log(e);
    });
  } else {
    $(".home-video-section").addClass("fondo");
  }
});
$(window).trigger('resize');
*/
$(document).ready(function(){
  if (screen.width >= 768) {
    var maximo = 0;
    $(".destacados .property-content").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    $(".destacados .property-content").height(maximo);

    maximo = 0;
    $(".ultimas .property-content").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    $(".ultimas .property-content").height(maximo);
  }
});

function enviar_buscador_propiedades() { 
  var link = "<?php echo mklink("propiedades/")?>";
  var tipo_operacion = $("#tipo_operacion").val();
  var localidad = $("#localidad").val();
  var tp = $("#tipo_operacion").val();
  link = link + tipo_operacion + "/" + localidad + "/?tp=" + tp ;
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>
</body>
</html>