<?php 
function item($r,$config = array()) { 
  global $empresa;
  $clase = isset($config["clase"]) ? $config["clase"] : "col-md-4 p-0 neighborhoods-list" ?>
  <div class="<?php echo $clase ?>">
    <a href="<?php echo $r->link_propiedad ?>">
      <?php if ($r->destacado == 1 && $r->id_empresa == $empresa->id) { ?>
        <img src="assets/images/estrella.png" class="estrella" alt="Propiedad Destacada" />
      <?php } ?>
      <div class="img-block">
        <?php if (!empty($r->imagen)) { ?>
          <img class="adaptable-img" src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
        <?php } else if (!empty($empresa->no_imagen)) { ?>
          <img class="adaptable-img" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
        <?php } else { ?>
          <img class="adaptable-img" src="assets/images/logoagua.jpg" alt="<?php echo ($r->nombre); ?>" />
        <?php } ?>

        <div class="neighborhoods-top">
          <p><?php echo $r->direccion_completa.(!empty($r->direccion_completa)?". ":"").$r->localidad ?></p>
          <h4><?php echo $r->precio ?></h4>
        </div>
        <div class="neighborhoods-bottom">
          <div class="neighborhoods-info">
            <h6><?php echo (!empty($r->dormitorios)) ? $r->dormitorios : "-" ?> Hab.</h6>
            <img src="assets/images/icon11.png" alt="img">
          </div>
          <div class="neighborhoods-info">
            <h6><?php echo (!empty($r->banios)) ? $r->banios : "-" ?> Baños</h6>
            <img src="assets/images/icon12.png" alt="img">
          </div>
          <div class="neighborhoods-info">
            <h6><?php echo (!empty($r->cocheras)) ? $r->cocheras : "-" ?> Auto</h6>
            <img src="assets/images/icon13.png" alt="img">
          </div>
          <div class="neighborhoods-info">
            <h6><?php echo (!empty($r->superficie_total)) ? $r->superficie_total : "-" ?> m2</h6>
            <img src="assets/images/icon14.png" alt="img">
          </div>
        </div>
      </div>
    </a>
  </div>
<?php } ?>