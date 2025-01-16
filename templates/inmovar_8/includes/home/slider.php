<?php $slides = $web_model->get_slider();
if (sizeof($slides)>0) { ?>
<div class="home_slider">
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <ol class="carousel-indicators">
      <?php $x=0; foreach ($slides as $s) { ?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $x ?>" class="<?php echo ($x==0)?"active":"" ?>"></li>
      <?php $x++; } ?>
    </ol>
    <div class="carousel-inner">      
      <?php $x=0; foreach ($slides as $s) {  ?>
        <div class="carousel-item <?php echo ($x==0)?"active":"" ?>" style="background-image: url(<?php echo $s->path ?>);z-index: -1">
          <div class="container">
            <div class="srch-main-wrap">
              <div class="home-banner-srch">
                <div class="display-table">
                  <div class="carousel-caption-table-cell text-center vat">
                    <div class="main_banner_srch">
                      <div class="slider_heading_para">
                        <h1 style="z-index: 99"><?php echo $s->linea_1.(!empty($s->linea_2)?"<br/>".$s->linea_2:"") ?></h1>
                        <?php if (!empty($s->linea_3)) { ?>
                          <p><?php echo $s->linea_3 ?></p>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php $x++; } ?>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Anterior</span> </a> <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Siguiente</span> </a> </div>
    <div class="container">
      <div class="srch-main-wrap">
        <div class="home-banner-srch">
          <div class="display-table">
            <div class="carousel-caption-table-cell text-center">
              <div class="main_banner_srch">
                <div class="banner_input_boxes">
                  <div class="row">
                    <div class="col-lg-10 col-md-9">
                      <div class="on_input">
                        <div class="row margin_row">
                          <div class="col-lg-3 col-md-3 border-left">
                            <?php $tipos_operaciones = $propiedad_model->get_tipos_operaciones(); ?>
                            <select id="tipo_operacion">
                              <option value="todas">Tipos Operaciones</option>
                              <?php foreach ($tipos_operaciones as $t) {  ?>
                                <option value="<?php echo $t->link ?>"><?php echo $t->nombre ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-lg-4 col-md-4 border-left">
                             <?php $localidades = $propiedad_model->get_localidades(); ?>
                            <select id="localidad">
                              <option value="todas">Localidades</option>
                              <?php foreach ($localidades as $t) {  ?>
                                <option value="<?php echo $t->link ?>"><?php echo $t->nombre ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-lg-5 col-md-5 border-left">
                            <?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
                            <select id="tp">
                              <option value="0">Tipos propiedades</option>
                              <?php foreach ($tipos_propiedades as $t) {  ?>
                                <option value="<?php echo $t->id ?>"><?php echo $t->nombre ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-3 pad-left">
                      <div class="sub_btn">
                        <form id="form_propiedades">
                          <input type="hidden" name="tp" id="tp_hidden" value="0">
                          <input type="submit" onclick="enviar_buscador_propiedades()" class="btn1" value="Buscar">
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="banner_check_box">
                    <div class="checkbox_div">
                      <label class="label_r">
                        <input type="radio" value="lista" checked="checked" name="radio">
                        <span class="checkmark"></span> Mostrar en lista 
                      </label>
                    </div>
                    <div class="checkbox_div">
                      <label class="label_r">
                        <input type="radio" value="mapa" name="radio">
                        <span class="checkmark"></span> Mostrar en mapa 
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>