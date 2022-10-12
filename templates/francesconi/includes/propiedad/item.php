<?php
function item($p) { ?>
  <div class="col-lg-4 col-md-6">
    <div class="noved-card">
      <div class="noved-warp">
        <span>
          <a href="<?php echo $p->link_propiedad ?>">
            <img src="assets/images/icons/icon-15.png" alt="Icon">
          </a>
        </span>
        <?php if ($p->es_oferta == 1) { ?>
          <a href="javascript:void(0);" class="fill-btn">oportunidades</a>
        <?php } ?>
        <a href="<?php echo $p->link_propiedad ?>">
          <img src="<?php echo $p->imagen ?>" alt="<?php echo $p->nombre ?>">
        </a>
      </div>
      <div class="noved-inner">
        <h2 class="color-title"><?php echo $p->precio ?></h2>
        <p><?php echo $p->nombre ?></p>
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