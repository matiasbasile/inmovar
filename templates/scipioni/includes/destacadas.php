<div class="sidebar-widget popular-posts">
  <div class="main-title-2">
    <h1>Propiedades <span>destacadas</span></h1>
  </div>
  <?php foreach ($propiedades_destacadas as $l) {  ?>
    <div class="media">
      <div class="media-left">
        <a href="<?php echo $l->link_propiedad ?>">
          <?php if (!empty($l->path)) { ?>
            <img class="media-object" src="/admin/<?php echo $l->path ?>" alt="<?php echo ($l->nombre); ?>" />
          <?php } else if (!empty($empresa->no_imagen)) { ?>
            <img class="media-object" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($l->nombre); ?>" />
          <?php } else { ?>
            <img class="media-object" src="images/logo.png" alt="<?php echo ($l->nombre); ?>" />
          <?php } ?>
        </a>
      </div>
      <div class="media-body">
        <h3 class="media-heading">
          <a href="<?php echo mklink ($l->link )?>"><?php echo $l->nombre ?></a>
        </h3>
        <p><?php echo $l->tipo_inmueble." - ".$l->tipo_operacion ?></p>
      </div>
    </div>
  <?php } ?>
</div>