<?php $emprendimientos = $propiedad_model->get_list(array(
  "tipos_operaciones"=>"emprendimientos",
  "offset"=>2,
  "tiene_etiqueta_link"=>"emprendimiento", // Tiene que estar marcado con una ETIQUETA
));
if (sizeof($emprendimientos)>0) { ?>
  <div class="empredimi_section">
    <div class="container">
      <div class="empredimi_wraper">
        <h2 class="white_heading text-center margin_heading">Emprendimientos</h2>
        <div class="row">
          <?php if (sizeof($emprendimientos) == 1) { ?>
            <?php foreach ($emprendimientos as $l) {  ?>
              <div class="col-md-6" style="margin: 0 auto;">
                <div class="emprendimientos_box"> 
                  <?php if (!empty($l->imagen)) { ?>
                    <img src="<?php echo $l->imagen ?>" alt="<?php echo ($l->nombre);?>">
                  <?php } else if (!empty($empresa->no_imagen)) { ?>
                    <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($l->nombre);?>">
                  <?php } else { ?>
                    <img src="images/no-imagen.png" alt="<?php echo ($l->nombre);?>">
                  <?php } ?>
                  <div class="empr_box_content">
                    <h5><a href="<?php echo $l->link_propiedad?>"><?php echo $l->nombre ?></a></h5>
                    <div class="anchor_btn_div"> <a class="anchor_btn" href="<?php echo mklink ($l->link) ?>">Ver Proyecto <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } else { ?>
            <?php foreach ($emprendimientos as $l) {  ?>
              <div class="col-lg-6 col-md-6">
                <div class="emprendimientos_box"> 

                  <?php if (!empty($l->imagen)) { ?>
                    <img src="<?php echo $l->imagen ?>" alt="<?php echo ($l->nombre);?>">
                  <?php } else if (!empty($empresa->no_imagen)) { ?>
                    <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($l->nombre);?>">
                  <?php } else { ?>
                    <img src="images/no-imagen.png" alt="<?php echo ($l->nombre);?>">
                  <?php } ?>

                  <div class="empr_box_content">
                    <h5><a href="<?php echo $l->link_propiedad?>"><?php echo $l->nombre ?></a></h5>
                    <div class="anchor_btn_div"> <a class="anchor_btn" href="<?php echo mklink ($l->link) ?>">Ver Proyecto <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>