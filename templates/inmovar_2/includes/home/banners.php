<?php if ($empresa->comp_banners == 1) { ?>
  <div class="mb50 our-service">
    <div class="container">
      <!-- Main title -->
      <div class="main-title">
        <?php $t = $web_model->get_text("Asesoramiento-Titulo-General","Nuestros Servicios")?>
        <h2 class="main-title-h2"><span class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></span></h2>
      </div>
      <div class="row mgn-btm wow">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInLeft delay-04s">
          <div class="content">
            <i class="fa fa-building"></i>
            <?php $t = $web_model->get_text("Asesoramiento-Titulo-1","Ventas")?>
            <h4 data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></h4>
            <?php $t = $web_model->get_text("Asesoramiento-Texto-1","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam")?>
            <p data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></p>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInLeft delay-04s">
          <div class="content">
            <i class="fa fa-key"></i>
            <?php $t = $web_model->get_text("Asesoramiento-Titulo-2","Alquileres")?>
            <h4 data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></h4>
            <?php $t = $web_model->get_text("Asesoramiento-Texto-2","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam")?>
            <p data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></p>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInRight delay-04s">
          <div class="content">
            <i class="fa fa-handshake-o"></i>
            
            <?php $t = $web_model->get_text("Asesoramiento-Titulo-3","Obras")?>
            <h4 data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></h4>
            <?php $t = $web_model->get_text("Asesoramiento-Texto-3","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam")?>
            <p data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></p>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInRight delay-04s">
          <div class="content">
            <i class="fa fa-home"></i>
            <?php $t = $web_model->get_text("Asesoramiento-Titulo-4","Tasaciones")?>
            <h4 data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></h4>
            <?php $t = $web_model->get_text("Asesoramiento-Texto-4","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam")?>
            <p data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" class="editable"><a href="<?php echo (!empty($t->link)) ? $t->link : "javascript:void(0)" ?>"><?php echo $t->plain_text ?></a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
