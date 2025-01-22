<!-- Banner Section -->
<?php $slides = $web_model->get_slider()?>
<section class="banner">
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <?php $x=0;foreach ($slides as $s) { ?>
        <div class="carousel-item <?php echo ($x==0)?"active":"" ?>" style="background: url(<?php echo $s->path ?>) no-repeat 50% 0; background-size: cover;"></div>
      <?php $x++; } ?>
      <ol class="carousel-indicators">
        <?php $x=0; foreach ($slides as $s) {  ?>
          <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $x ?>" class="<?php echo ($x==0)?"active":"" ?>"></li>
        <?php $x++; }?>
      </ol>
    </div>
  </div>
  <div class="carousel-caption">
    <form onsubmit="filtrar()" id="form_propiedades" >
      <div class="row">
        <div class="col-xl-3 col-md-6">
          <?php $tipos_op = $propiedad_model->get_tipos_operaciones()?>
          <select class="form-control" id="tipo_operacion">
            <option value="todas">Tipo de Operación</option>
            <?php foreach ($tipos_op as $tp) {  ?>
              <option value="<?php echo $tp->link ?>"><?php echo $tp->nombre ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-xl-3 col-md-6">
          <?php $tipos_prop = $propiedad_model->get_tipos_propiedades()?>
          <select class="form-control" id="tp" name="tp">
            <option value="todas">Tipo de Propiedad</option>
            <?php foreach ($tipos_prop as $tp) {  ?>
              <option value="<?php echo $tp->id ?>"><?php echo $tp->nombre ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-xl-4 col-md-6">
          <?php $localidades = $propiedad_model->get_localidades()?>
          <select class="form-control" id="localidad">
            <option value="todas">Localidades</option>
            <?php foreach ($localidades as $tp) {  ?>
              <option value="<?php echo $tp->link ?>"><?php echo $tp->nombre ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-xl-2 col-md-6">
          <button type="submit" class="btn btn-secoundry">Buscar</button>
        </div>
      </div>
    </form>
  </div>
</section>