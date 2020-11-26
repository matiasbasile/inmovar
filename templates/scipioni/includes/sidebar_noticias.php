<div class="sidebar">
  <div class="sidebar-widget search-box">
    <form action="<?php echo mklink("entradas/") ?>" class="form-inline form-search" method="POST">
      <div class="form-group">
        <label class="sr-only" for="textsearch2">Buscar</label>
        <input type="text" class="form-control" id="textsearch2" name="buscador" placeholder="Buscar">
      </div>
      <button type="submit" class="btn"><i class="fa fa-search"></i></button>
    </form>
  </div>
  <?php if (isset($categorias) && sizeof($categorias)>0) { ?>
    <div class="sidebar-widget category-posts">
      <div class="main-title-2">
        <h1><span>Categorías</span></h1>
      </div>
      <ul class="list-unstyled list-cat">
        <?php foreach ($categorias as $c) {  ?>
        <li><a href="<?php echo mklink ("entradas/$c->link/") ?>"><?php echo ($c->nombre) ?></a></li>
        <?php } ?>
      </ul>
    </div>
  <?php } ?>
  <!-- Popular posts -->
  <div class="sidebar-widget popular-posts">
    <div class="main-title-2">
      <h1><span>Información</span></h1>
    </div>
    <?php foreach ($listado_total_entradas as $l) { ?>
      <div class="media">
        <?php if (!empty($l->path)) { ?>
          <div class="media-left">
            <a href="<?php echo mklink ($l->link) ?>"><img class="media-object" src="<?php echo $l->path ?>" alt="small-properties-3"></a>
          </div>
        <?php } ?>
        <div class="media-body">
          <h3 class="media-heading">
            <a href="<?php echo mklink ($l->link) ?>"><?php echo $l->titulo ?></a>
          </h3>
          <?php if ($l->mostrar_fecha == 1) { ?>
            <p><?php echo ($l->fecha) ?></p>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
  </div>
</div>