<?php
function item($p)
{ ?>
<div class="col-lg-4 col-md-6">
    <div class="card">
        <div class="img-wrap">
            <img src="<?php echo $p->imagen; ?>" alt="<?php echo $p->nombre; ?>">
        </div>
        <div class="card-body">
            <h2><a href="<?php echo $p->link_propiedad; ?>" class="stretched-link"><?php echo $p->precio; ?></a></h2>
            <h3><?php echo $p->nombre; ?></h3>
            <h4><?php echo $p->direccion_completa; ?></h4>
        </div>
        <div class="card-footer">
            <?php if (!empty($p->superficie_total)) { ?>
            <span><?php echo $p->superficie_total; ?> m2</span>
            <?php } ?>
            <ul>
                <li><img src="assets/images/bed.png" alt="Bed"><?php echo $p->dormitorios; ?></li>
                <li><img src="assets/images/wash.png" alt="Wash"><?php echo $p->banios; ?></li>
                <li><img src="assets/images/car.png" alt="Car"><?php echo $p->cocheras; ?></li>
            </ul>
        </div>
    </div>
</div>
<?php } ?>