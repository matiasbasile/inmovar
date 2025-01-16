<div class="nostros_part">
  <div class="container">
    <div class="nostros_wrap p0 pt30">
      <div class="row">
        <?php $nosotros = $entrada_model->get_list(array("categoria"=>"empresa","offset"=>1)) ?>
        <?php foreach ($nosotros as $l) {  ?>
          <div class="col-lg-6 col-md-6">
            <div class="nostros_content display-table">
              <div class="display-table-cell">
                <h2 class="heading2"><?php echo $l->titulo ?></h2>
                <p><?php echo utf8_encode($l->descripcion) ?></p>
                <a href="<?php echo mklink ("entradas/empresa/")  ?>" class="btn2">leer más</a> </div>
            </div>
          </div>
        <div class="col-lg-6 col-md-6">
          <div class="nostros_img"> <img src="<?php echo $l->path ?>" alt="demo_img3"> </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>