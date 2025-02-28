<?php
function item_inversiones($propiedad) { ?>
  <div class="property-box">
    <div class="img-block">
      <div class="owl-carousel owl-theme" data-outoplay="true" data-nav="false" data-dots="true">
        <?php foreach ($propiedad->images as $img) { ?>
          <div class="item">
            <a href="<?php echo $propiedad->link_propiedad ?>">
              <img src="<?php echo $img ?>" loading="lazy" alt="img">
            </a>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="title-box">
      <p><?php echo $propiedad->nombre ?></p>
      <span><?php echo $propiedad->direccion_completa ?></span>
    </div>
    <div class="white-box">
      <div class="delivery">
        <p>con entrega asegurada</p>
      <div class="comunicate">
        <div class="icon-box">
          <img src="assets/images/white-box-icon3.svg" alt="icon">
        </div>
        <h2><?php echo $propiedad->inversion_rentabilidad ?>%</h2>
      </div>
      <div class="inner-title">
        <p>rentabilidad estimada</p>
       <p> <strong>en dólares a <?php echo $propiedad->inversion_cantidad_meses ?> meses</strong></p>
      </div>
      </div>
      <div class="anchored">
        <p><?php echo $propiedad->inversion_porcentaje ?>% Fondeado</p>
        <div class="progress">
          <div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
          </div>
        </div>
          <div class="progressbar-status">
            <span>0%</span>
            <span>100%</span>
          </div>
        <a href="#0" class="btn btn-border">Invertí de pozo desde U$S <?php echo number_format($propiedad->inversion_minimo,0,",",".")?></a>
      </div>
    </div>
  </div>
<?php } ?>