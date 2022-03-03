<?php
// SLIDER PRINCIPAL
$slider = $web_model->get_slider();
?>
<section class="banner">
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <?php $c = 0; ?>
      <?php foreach ($slider as $r) { ?>
        <div class="carousel-item <?php echo ($c == 0 ? "active" : "") ?>" style="background: url(<?php echo $r->path ?>) no-repeat 50% 0; background-size: cover;"></div>
        <?php $c++; ?>
      <?php } ?>
      <ol class="carousel-indicators">
        <?php $c = 0; ?>
        <?php foreach ($slider as $i) { ?>
          <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $c ?>" class="<?php echo ($c == 0 ? "active" : "") ?>"></li>
          <?php $c++; ?>
        <?php } ?>
      </ol>
    </div>
  </div>
  <div class="carousel-caption">
    <div class="container">
      <form onsubmit="return filtrar(this)" method="get">
        <input type="hidden" class="base_url" value="<?php echo mklink("propiedades/") ?>" />
        <select class="form-control filter_tipo_operacion">
          <option value="0">Operación</option>
          <?php $tipo_operaciones = $propiedad_model->get_tipos_operaciones(array(
            "id_empresa"=>$empresa->id,
            "solo_propias"=>1,
            "mostrar_todos"=>0,
          )); ?>
          <?php foreach ($tipo_operaciones as $operaciones) { ?>
            <option value="<?php echo $operaciones->link ?>"><?php echo $operaciones->nombre ?></option>
          <?php } ?>
        </select>
        <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
        <select class="form-control filter_propiedad" name="tp">
          <option value="0">Propiedad</option>
          <?php foreach ($tipo_propiedades as $tipo) { ?>
            <option value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
          <?php } ?>
        </select>
        <select class="form-control filter_localidad">
          <option value="0">Localidad</option>
          <?php $localidades = $propiedad_model->get_localidades(); ?>
          <?php foreach ($localidades as $localidad) { ?>
            <option value="<?php echo $localidad->link ?>"><?php echo $localidad->nombre ?></option>
          <?php } ?>
        </select>
        <button type="submit" class="btn btn-primary">BUSCAR</button>
      </form>
    </div>
  </div>
</section>
