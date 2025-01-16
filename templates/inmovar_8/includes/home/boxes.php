<div class="boxes_section">
  <div class="container">
    <div class="boxes_wraper">
      <div class="row">
        <div class="col-lg-4 col-md-4">
          <div class="box_div_wrap">
            <div class="box_wrap_img">
              <div class="img_hover"><img src="images/box_img1.png" alt="box_img1"></div>
            </div>
            <div class="box_wrap_content">
              <?php $t = $web_model->get_text("box1titv2","Ventas")?>
              <h5 class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h5>
              <?php $t = $web_model->get_text("box1txtv2","Encontra la propiedad <br> que estas buscando al <br> mejor precio.")?>
              <p class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
              <?php $t = $web_model->get_text("box1btnv2","Ver Propiedades") ?>
              <a class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" href="<?php echo (!empty($t->link))?$t->link:"javascript:void(0)" ?>"><?php echo $t->plain_text ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="box_div_wrap">
            <div class="box_wrap_img">
              <div class="img_hover"><img src="images/box_img2.png" alt="box_img2"></div>
            </div>
            <div class="box_wrap_content">
              <?php $t = $web_model->get_text("box2tit","Alquileres")?>
              <h5 class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h5>
              <?php $t = $web_model->get_text("box2txt","Encontra la propiedad <br> que estas buscando al <br> mejor precio.")?>
              <p class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
              <?php $t = $web_model->get_text("box2btnv2","Ver Propiedades") ?>
              <a class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" href="<?php echo (!empty($t->link))?$t->link:"javascript:void(0)" ?>"><?php echo $t->plain_text ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="box_div_wrap">
            <div class="box_wrap_img">
              <div class="img_hover"><img src="images/box_img3.png" alt="box_img3"></div>
            </div>
            <div class="box_wrap_content">
              <?php $t = $web_model->get_text("box3tit","Emprendimientos")?>
              <h5 class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h5>
              <?php $t = $web_model->get_text("box3txt","Encontra la propiedad <br> que estas buscando al <br> mejor precio.")?>
              <p class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
              <?php $t = $web_model->get_text("box3btnv2","Ver Propiedades") ?>
              <a class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" href="<?php echo (!empty($t->link))?$t->link:"javascript:void(0)" ?>"><?php echo $t->plain_text ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>