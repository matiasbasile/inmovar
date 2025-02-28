<section class="the-property">
  <div class="container">
    <div class="section-title">
      <h2>ENCONTRÁ LA PROPIEDAD QUE ESTÁS BUSCANDO</h2>
    </div>
    <?php // FALTAN: Duplex, Countries, Locales ?>
    <div class="owl-carousel owl-theme" data-outoplay="true" data-items="4" data-nav="true" data-dots="false" data-margin="25" data-items-tablet="3" data-items-mobile-landscape="2" data-items-mobile-portrait="1">

      <?php // CASAS
      $id_tipo_inmueble = 1;
      $cantidad = $propiedad_model->get_list(array(
        "id_tipo_inmueble"=>$id_tipo_inmueble,
        "solo_contar"=>1,
      )); 
      if ($cantidad > 0) { ?>
        <a href="<?php echo mklink("propiedades/ventas/?tp=".$id_tipo_inmueble) ?>" class="item">
          <div class="icon-box">
            <img src="assets/images/property-icon1.svg" alt="icon">
          </div>
          <div class="inner-text">
            <h5>Casas</h5>
            <p><?php echo $cantidad ?> <span>Disponibles</span></p>
          </div>
        </a>
      <?php } ?>

      <?php // DEPARTAMENTOS
      $id_tipo_inmueble = 2;
      $cantidad = $propiedad_model->get_list(array(
        "id_tipo_inmueble"=>$id_tipo_inmueble,
        "solo_contar"=>1,
      )); 
      if ($cantidad > 0) { ?>      
        <a href="<?php echo mklink("propiedades/ventas/?tp=".$id_tipo_inmueble) ?>" class="item">
          <div class="icon-box">
            <img src="assets/images/property-icon2.svg" alt="icon">
          </div>
          <div class="inner-text">
            <h5>Deptos</h5>
            <p><?php echo $cantidad ?> <span>Disponibles</span></p>
          </div>
        </a>
      <?php } ?>

      <?php // TERRENOS
      $id_tipo_inmueble = 7;
      $cantidad = $propiedad_model->get_list(array(
        "id_tipo_inmueble"=>$id_tipo_inmueble,
        "solo_contar"=>1,
      )); 
      if ($cantidad > 0) { ?>            
        <a href="<?php echo mklink("propiedades/ventas/?tp=".$id_tipo_inmueble) ?>" class="item">
          <div class="icon-box">
            <img src="assets/images/property-icon4.svg" alt="icon">
          </div>
          <div class="inner-text">
            <h5>Terrenos</h5>
            <p><?php echo $cantidad ?> <span>Disponibles</span></p>
          </div>
        </a>
      <?php } ?>

      <?php // PH
      $id_tipo_inmueble = 3;
      $cantidad = $propiedad_model->get_list(array(
        "id_tipo_inmueble"=>$id_tipo_inmueble,
        "solo_contar"=>1,
      )); 
      if ($cantidad > 0) { ?>      
        <a href="<?php echo mklink("propiedades/ventas/?tp=".$id_tipo_inmueble) ?>" class="item">
          <div class="icon-box">
            <img src="assets/images/property-icon2.svg" alt="icon">
          </div>
          <div class="inner-text">
            <h5>PH</h5>
            <p><?php echo $cantidad ?> <span>Disponibles</span></p>
          </div>
        </a>
      <?php } ?>

      <?php // OFICINAS 
      $id_tipo_inmueble = 11;
      $cantidad = $propiedad_model->get_list(array(
        "id_tipo_inmueble"=>$id_tipo_inmueble,
        "solo_contar"=>1,
      )); 
      if ($cantidad > 0) { ?>
        <a href="<?php echo mklink("propiedades/ventas/?tp=".$id_tipo_inmueble) ?>" class="item">
          <div class="icon-box">
            <img src="assets/images/property-icon3.svg" alt="icon">
          </div>
          <div class="inner-text">
            <h5>Oficinas</h5>
            <p><?php echo $cantidad ?> <span>Disponibles</span></p>
          </div>
        </a>
      <?php } ?>

    </div>
  </div>
</section>