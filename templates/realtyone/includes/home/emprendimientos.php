<?php 
$emprendimientos = $propiedad_model->get_list(array(
  "offset" => 6,
  "orden_default"=>8,
  "id_tipo_operacion" => 4
));
if (sizeof($emprendimientos)>0) { ?>
  <section class="ventures">
    <div class="container">
      <div class="section-title">
        <h2>EMPRENDIMIENTOS</h2>
      </div>
      <div class="row">
        <?php foreach ($emprendimientos as $emp) { ?>
          <div class="col-lg-4 col-md-6">
            <a class="img-block stretched-link" href="<?php echo mklink($emp->link) ?>">
              <?php if (!empty($emp->imagen)) { ?>
                <img class="img-main" src="<?php echo $emp->imagen ?>" alt="<?php echo $emp->nombre ?>">
              <?php } ?>
              <div class="overley">
                <div class="precio">
                  <?php if (!empty($emp->precio)) { ?>
                    <span>Precio desde </span>
                    <h5><?php echo $emp->precio ?></h5>
                  <?php } ?>
                </div>
                <div class="canitas">
                  <?php if (!empty($emp->nombre)) { ?>
                    <p><?php echo $emp->nombre ?></p>
                  <?php } ?>
                  <?php if (!empty($emp->direccion_completa)) { ?>
                    <span><?php echo $emp->direccion_completa ?></span>
                  <?php } ?>
                  <div class="aminities">
                    <span><?php echo (!empty($emp->superficie_total)) ? $emp->superficie_total : "-" ?> M2</span>
                    <ul>
                      <li><img src="assets/images/featured-properties-icon1.svg" alt="icon"><?php echo (!empty($emp->dormitorios) ? $emp->dormitorios : "-")  ?></li>
                      <li><img src="assets/images/featured-properties-icon2.svg" alt="icon"><?php echo (!empty($emp->banios) ? $emp->banios : "-") ?></li>
                    </ul>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
<?php } ?>