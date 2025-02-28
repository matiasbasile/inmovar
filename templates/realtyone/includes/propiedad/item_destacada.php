<?php function item_destacada($ent) { ?>
  <div class="col-lg-4 col-md-6">
    <div class="property-box">
      <div class="img-block">
        <div class="owl-carousel owl-theme" data-outoplay="true" data-nav="false" data-dots="true">
          <?php if (sizeof($ent->images) > 0) { ?>
            <?php foreach ($ent->images as $img) { ?>
              <div class="item">
                <a href="<?php echo $ent->link_propiedad ?>">
                  <img src="<?php echo $img ?>" alt="img">
                </a>
              </div>
            <?php } ?>
          <?php } else { ?>
            <div class="item">
              <a href="<?php echo $ent->link_propiedad ?>">
                <img src="<?php echo $ent->imagen ?>" alt="img">
              </a>
            </div>
          <?php } ?>
        </div>
        <?php if ($ent->nuevo == 1) { ?>
          <small>Nuevo!</small>
        <?php } ?>
      </div>
      <div class="title-box">
        <h4><?php echo $ent->precio ?>
          <?php if ($ent->precio_porcentaje_anterior < 0.00 && $ent->publica_precio == 1) { ?>
            <small> 
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"></path>
              </svg> <?php echo round(floatval($ent->precio_porcentaje_anterior * -1),0) ?>%
            </small>
          <?php } ?>            
        </h4>

        <?php if (!empty($ent->nombre)) { ?>
          <p><?php echo $ent->nombre ?></p>
        <?php } ?>

        <?php if (!empty($ent->direccion_completa)) { ?>
          <span><?php echo $ent->direccion_completa ?></span>
        <?php } ?>

      </div>
      <div class="aminities">
        <span><?php echo (!empty($ent->superficie_total) ? $ent->superficie_total : "-") ?> M2</span>
        <ul>
          <li><img src="assets/images/featured-properties-icon1.svg" alt="img"><?php echo (!empty($ent->dormitorios) ? $ent->dormitorios : "-") ?></li>
          <li><img src="assets/images/featured-properties-icon2.svg" alt="img"><?php echo (!empty($ent->banios) ? $ent->banios : "-") ?></li>
          <li><img src="assets/images/featured-properties-icon3.svg" alt="img"><?php echo (!empty($ent->cocheras) ? $ent->cocheras : "-") ?></li>
        </ul>
      </div>
    </div>
  </div>
<?php } ?>