<?php $destacadas = $propiedad_model->destacadas(array(
  "offset"=>3,
));
if (sizeof($destacadas)>0) { ?>
  <aside id="featured-properties">
    <header><h3>Propiedades Destacadas</h3></header>
    <?php foreach($destacadas as $r) { ?>
      <div class="property small">
        <a href="<?php echo $r->link_propiedad ?>">
          <div class="property-image">
            <?php if (!empty($r->imagen)) { ?>
              <img src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
            <?php } else if (!empty($empresa->no_imagen)) { ?>
              <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
            <?php } else { ?>
              <img src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
            <?php } ?>
          </div>
        </a>
        <div class="info">
          <a href="<?php echo $r->link_propiedad ?>"><h4><?php echo $r->nombre ?></h4></a>
          <figure><?php echo $r->direccion_completa ?></figure>
          <div class="tag price"><?php echo ($r->precio_final != 0 && $r->publica_precio == 1) ? $r->moneda." ".number_format($r->precio_final,0) : "Consultar"; ?></div>
        </div>
      </div>
    <?php } ?>
  </aside>
<?php } ?>