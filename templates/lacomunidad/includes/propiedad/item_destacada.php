<?php
function item_destacada($ent)
{ ?>
  <div class="col-lg-4 col-md-6">
    <div class="property-box">
      <div class="img-block">
        <div class="owl-carousel owl-theme" data-outoplay="true" data-nav="false" data-dots="true">
          <?php if (sizeof($ent->images) > 0) { ?>
            <?php foreach ($ent->images as $img) { ?>
              <div class="item"><img src="<?php echo $img ?>" alt="img"></div>
            <?php } ?>
          <?php } else { ?>
            <div class="item"><img src="<?php echo $ent->imagen ?>" alt="img"></div>
          <?php } ?>

        </div>
        <small>Nuevo!</small>
      </div>
      <div class="title-box">
        <?php if ($ent->precio_final != 0 && $ent->publica_precio == 1) { ?>
          <h4><a href="#0" class="stretched-link">U$S <?php echo number_format($ent->precio_final, 0) ?><small> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"></path>
                </svg> 10%</small></a></h4>
        <?php } ?>
        <?php if (!empty($ent->nombre)) { ?>
          <p><?php echo $ent->nombre ?></p>
        <?php } ?>
        <?php if (!empty($ent->direccion_completa)) { ?>
          <span><?php echo $ent->direccion_completa ?></span>
        <?php } ?>
      </div>
      <div class="aminities">
        <?php if (!empty($ent->superficie_total)) { ?>
          <span><?php echo $ent->superficie_total ?> M2</span>
        <?php } ?>
        <ul>
          <?php if (!empty($ent->dormitorios)) { ?>
            <li><img src="assets/images/featured-properties-icon1.svg" alt="img"><?php echo $ent->dormitorios ?></li>
          <?php } ?>
          <?php if (!empty($ent->banios)) { ?>
            <li><img src="assets/images/featured-properties-icon2.svg" alt="img"><?php echo $ent->banios ?></li>
          <?php } ?>
          <?php if (!empty($ent->cocheras)) { ?>
            <li><img src="assets/images/featured-properties-icon3.svg" alt="img"><?php echo $ent->cocheras ?></li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
<?php } ?>