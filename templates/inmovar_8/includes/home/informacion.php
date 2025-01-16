<?php $categorias_informacion = $entrada_model->get_subcategorias(186)?>  
<?php if (!empty($categorias_informacion)) {  ?>
<!-- Information part Start here -->
  <div class="info_section">
    <div class="container">
      <div class="info_wrap">
        <h2 class="heading2 margin_heading text-center">Información</h2>
        <div class="row">
          <?php $x=1;foreach ($categorias_informacion as $c) { if ($x<=6) {   ?>
            <div class="col-lg-4 col-md-6">
              <div class="info_img_box"> <a href="<?php echo mklink ("entradas/$c->link/") ?>">
                <div class="info_img_wrap"> <img src="/admin/<?php echo $c->path ?>"> </div>
                <div class="info_content_wrap">
                  <p>información</p>
                  <h5><?php echo utf8_encode($c->nombre)?></h5>
                </div>
                </a> </div>
            </div>
          <?php } $x++;    } ?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>