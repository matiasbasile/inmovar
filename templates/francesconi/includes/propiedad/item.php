<?php
function item($p) { ?>
  <div class="col-lg-4 col-md-6">
    <div class="noved-card">
      <a href="<?php echo $p->link_propiedad ?>" class="noved-warp">
        <span>
          <img src="assets/images/icons/icon-15.png" alt="Icon">
        </span>
        <?php if ($p->es_oferta == 1) { ?>
          <span class="fill-btn">oportunidades</span>
        <?php } ?>
        <img src="<?php echo $p->imagen ?>" alt="<?php echo $p->nombre ?>" class="noved_img">
      </a>
      <div class="noved-inner">
        <h2 class="color-title"><a href="<?php echo $p->link_propiedad ?>"><?php echo $p->precio ?></a></h2>
        <p><a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a></p>
        <h5><?php echo $p->direccion_completa ?></h5>
        <div class="mis-link">
          <ul>
            <?php if (!empty($p->superficie_total)) { ?>
              <li><?php echo $p->superficie_total ?> m2</li>
            <?php } ?>
            <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-16.png" alt="Icon"><?php echo $p->dormitorios ?></a></li>
            <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-17.png" alt="Icon"><?php echo $p->banios ?></a></li>
            <li><a href="javascript:void(0);"><img src="assets/images/icons/icon-18.png" alt="Icon"><?php echo $p->cocheras ?></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
<?php } ?>