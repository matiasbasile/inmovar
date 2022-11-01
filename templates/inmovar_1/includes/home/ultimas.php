<?php if ($empresa->comp_ultimos == 1) { 
  $ultimas = $propiedad_model->ultimas(array(
    "offset"=>8,
  ));
  if (sizeof($ultimas)>0) { ?>
    <section id="new-properties" class="block">
      <div class="container">
        <header class="section-title">
          <h2>&Uacute;ltimas Propiedades</h2>
          <a href="<?php echo mklink("propiedades/"); ?>" class="link-arrow">Ver todas</a>
        </header>
        <div class="row">
          <?php foreach($ultimas as $r) { ?>
          <div class="col-md-3 col-sm-6 mb30">
            <div class="property">
              <a href="<?php echo $r->link_propiedad ?>">
                <div class="property-image">
                  <?php if ($r->id_tipo_estado == 2) { ?>
                    <figure class="ribbon">Alquilado</figure>
                  <?php } else if ($r->id_tipo_estado == 4) { ?>
                    <figure class="ribbon">Reservado</figure>
                  <?php } else if ($r->id_tipo_estado == 3) { ?>
                    <figure class="ribbon">Vendido</figure>
                  <?php } ?>                        
                  <?php if (!empty($r->imagen)) { ?>
                    <img class="alto" src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                  <?php } else if (!empty($empresa->no_imagen)) { ?>
                    <img class="alto" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                  <?php } else { ?>
                    <img class="alto" src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
                  <?php } ?>
                </div>
                <div class="overlay">
                  <div class="info">
                    <div class="tag price"><?php echo ($r->precio_final != 0 && $r->publica_precio == 1) ? $r->moneda." ".number_format($r->precio_final,0) : "Consultar"; ?></div>
                    <h3><?php echo $r->nombre ?></h3>
                    <figure><?php echo $r->direccion_completa.", ".$r->localidad; ?></figure>
                  </div>
                  <ul class="additional-info">
                    <?php if (!empty($r->superficie_total)) { ?>
                    <li>
                      <header>Superficie:</header>
                      <figure><?php echo $r->superficie_total ?> m<sup>2</sup></figure>
                    </li>
                    <?php } ?>
                    <li>
                      <header>Habitaciones:</header>
                      <figure><?php echo (!empty($r->dormitorios)) ? $r->dormitorios : "-" ?></figure>
                    </li>
                    <li>
                      <header>Ba&ntilde;os:</header>
                      <figure><?php echo (!empty($r->banios)) ? $r->banios : "-" ?></figure>
                    </li>
                    <li>
                      <header>Cocheras:</header>
                      <figure><?php echo (!empty($r->cocheras)) ? $r->cocheras : "-" ?></figure>
                    </li>
                  </ul>
                </div>
              </a>
            </div><!-- /.property -->
          </div>
          <?php } ?>
        </div>
      </div>
    </section>
  <?php } ?>
<?php } ?>
