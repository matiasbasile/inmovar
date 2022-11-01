<?php if ($empresa->comp_ultimos == 1) { 
  $ultimas = $propiedad_model->ultimas(array(
    "offset"=>6,
  ));
  if (sizeof($ultimas)>0) { ?>
    <div class="mb50 recently-properties chevron-icon">
      <div class="container">
        <!-- Main title -->
        <div class="main-title">
          <h2 class="main-title-h2"><span>Últimas</span> Propiedades</h2>
        </div>
        <div class="row">
          <div class="carousel our-partners slide" id="ourPartners2">
            <div  id="owl-demo" class="carousel-inner owl-carousel owl-them">
              <?php foreach ($ultimas as $p) { ?>
              <div class="item active">
                <!-- Property start -->
                  <div class="property">
                    <!-- Property img -->
                    <a href="<?php echo $p->link_propiedad ?>" class="property-img">
                      <?php if ($p->id_tipo_estado >= 2) { ?>
                        <div class="property-tag button vendido alt featured"><?php echo $p->tipo_estado ?></div>
                      <?php } else { ?>
                        <div class="property-tag button alt featured"><?php echo $p->tipo_operacion ?></div>
                      <?php } ?>
                      <div class="property-tag button sale"><?php echo $p->tipo_inmueble ?></div>
                      <div class="property-price">
                        <?php echo $p->precio ?>
                      </div>
                      <?php if (!empty($p->imagen)) { ?>
                        <img class="img-responsive" src="<?php echo $p->imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                      <?php } else if (!empty($empresa->no_imagen)) { ?>
                        <img class="img-responsive" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                      <?php } else { ?>
                        <img class="img-responsive" src="images/logo.png" alt="<?php echo ($p->nombre); ?>" />
                      <?php } ?>
                    </a>
                    <div class="property-content">
                      <div class="height-igual">
                        <!-- title -->
                        <h1 class="title title-height-igual">
                          <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                        </h1>
                        <!-- Property address -->
                        <h3 class="property-address">
                          <a href="<?php echo $p->link_propiedad ?>">
                            <i class="fa fa-map-marker"></i><?php echo $p->direccion_completa ?>, <?php echo $p->localidad ?>
                          </a>
                        </h3>
                        <?php echo ver_caracteristicas($p); ?>
                      </div>
                      <?php /*
                      <div class="property-footer">
                        <span class="left"><i class="fa fa-calendar-o icon"></i> <?php echo $p->fecha_publicacion ?></span>
                      </div>
                      */ ?>
                    </div>
                  </div>
                <!-- Property end -->
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
<?php } ?>