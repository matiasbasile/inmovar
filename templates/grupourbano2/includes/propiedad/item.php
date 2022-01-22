<?php 
function item($r) { ?>
  <div class="col-md-4 p-0 neighborhoods-list">
    <a href="<?php echo mklink($r->link) ?>">
      <div class="img-block">

        <?php if (!empty($r->imagen)) { ?>
          <img class="adaptable-img" src="<?php echo $r->imagen ?>" alt="<?php echo ($r->titulo); ?>" />
        <?php } else if (!empty($empresa->no_imagen)) { ?>
          <img class="adaptable-img" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->titulo); ?>" />
        <?php } else { ?>
          <img class="adaptable-img" src="assets/images/no-image-2.jpg" alt="<?php echo ($r->titulo); ?>" />
        <?php } ?>
        
        <div class="neighborhoods-top">
          <p><?php echo $r->direccion_completa.(!empty($r->direccion_completa)?". ":"").$r->localidad ?></p>
          <h4><?php echo $r->precio ?></h4>
        </div>
        <div class="neighborhoods-bottom">
          <?php if ($r->ambientes != 0) { ?>
            <div class="neighborhoods-info">
              <h6><?php echo $r->ambientes ?> Hab.</h6>
              <img src="assets/images/icon11.png" alt="img">
            </div>
          <?php } ?>
          <?php if ($r->ambientes != 0) { ?>
            <div class="neighborhoods-info">
              <h6><?php echo $r->ambientes ?> Baños</h6>
              <img src="assets/images/icon12.png" alt="img">
            </div>
          <?php } ?>
          <?php if ($r->cocheras != 0) { ?>
            <div class="neighborhoods-info">
              <h6><?php echo $r->cocheras ?> Auto</h6>
              <img src="assets/images/icon13.png" alt="img">
            </div>
          <?php } ?>
          <?php if ($r->superficie_total != 0) { ?>
            <div class="neighborhoods-info">
              <h6><?php echo $r->superficie_total ?> m2</h6>
              <img src="assets/images/icon14.png" alt="img">
            </div>
          <?php } ?>
        </div>
      </div>
    </a>
  </div>
<?php } ?>