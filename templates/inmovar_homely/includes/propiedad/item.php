<?php 
function item($r,$config = array()) { 
  global $empresa;
  $clase = isset($config["clase"]) ? $config["clase"] : "col-lg-6 col-md-6" ?>
  <div class="<?php echo $clase ?>">
    <div class="property shadow-hover">
      <a href="<?php echo $r->link_propiedad ?>" class="property-img">
        <div class="img-fade"></div>
        <div class="property-tag button alt featured"><?php echo $r->tipo_operacion?></div>
        <div class="property-tag button alt featured left"><?php echo $r->tipo_estado ?></div>  
        <div class="property-tag button status"><?php echo $r->tipo_inmueble ?></div>
        <div class="property-price"><?php echo $r->precio ?></div>
        <div class="property-color-bar"></div>
        <div class="">
          <?php if (!empty($r->imagen)) { ?>
            <img src="<?php echo $r->imagen ?>" class="mi-img-responsive" alt="<?php echo ($r->nombre); ?>" />
          <?php } else if (!empty($empresa->no_imagen)) { ?>
            <img src="/admin/<?php echo $empresa->no_imagen ?>" class="mi-img-responsive" alt="<?php echo ($r->nombre); ?>" />
          <?php } else { ?>
            <img src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
          <?php } ?>
        </div>
      </a>
      <div class="property-content">
        <div class="property-title">
        <h4><a href="<?php echo $r->link_propiedad ?>"><?php echo ucwords(strtolower($r->nombre)) ?></a></h4>
          <p class="property-address"><i class="fa fa-map-marker icon"></i><?php echo $r->direccion_completa.". ".$r->localidad ?> <br> Código: <?php echo $r->codigo ?></p>
        </div>
        <table class="property-details">
          <tr>
            <td><i class="fa fa-bed"></i> <?php echo empty($r->dormitorios) ? "-" : $r->dormitorios?> Dorm</td>
            <td><i class="fa fa-shower"></i> <?php echo (empty($r->banios)) ? "-" : $r->banios ?> Baño<?php echo ($r->banios > 1)?"s":""?></td>
            <td><i class="fa fa-expand"></i> <?php echo (empty($r->superficie_total)) ? "-" : $r->superficie_total ?> m<sup>2</sup></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
<?php } ?>