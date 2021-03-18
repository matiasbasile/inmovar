<?php 
$cant_favoritos = 0;
if (isset($_SESSION["favoritos"])) {
  $arr = explode(",",$_SESSION["favoritos"]);
  $cant_favoritos = sizeof($arr)-1;
}
?>
<header>
  <?php if (!empty($empresa->logo_1)) {  ?>
    <a href="<?php echo mklink ("/") ?>" class="logo">
      <img src="/admin/<?php echo $empresa->logo_1 ?>" alt="Logo">
    </a>
  <?php } ?>
  <nav class="w100p">
    <div class="tab-content w100p buscador-header">
      <div id="ventas" class="tab-pane fade in active">
        <form id="form_propiedades" onsubmit="enviar_buscador_propiedades()">
          <input type="hidden" id="tipo_operacion" value="ventas" name="">
          <div class="row rowcontainer">
            <div class="col-md-10 mb10 rowcontainer">
              <div class="row mt13">
                <div class="col-md-3 h50 bg-white">
                  <?php $localidades = $propiedad_model->get_localidades(); ?>
                  <select class="form-control" id="localidad">
                    <option value="todas">ELIGE ZONA</option>
                    <?php foreach ($localidades as $t) {  ?>
                      <option value="<?php echo $t->link ?>"><?php echo $t->nombre ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-3 h50 bg-white">
                  <?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
                  <select class="form-control" name="tp">
                    <option value="0">TIPO DE PROPIEDAD</option>
                    <?php foreach ($tipos_propiedades as $t) {  ?>
                      <option value="<?php echo $t->id ?>"><?php echo $t->nombre ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-3 h50 bg-white">
                  <label for="precio_desde" class="label_buscador ml20">DESDE</label>
                  <input type="number" id="precio_desde" class="form-control w60p"> 
                </div>
                <div class="col-md-3 h50 bg-white">
                  <label for="precio_hasta" class="label_buscador">HASTA</label>
                  <input type="number" id="precio_hasta" class="form-control w60p" style="border-right: none !important;"> 
                </div>
              </div>
            </div>
            <div class="col-md-2 pt0 tac">
              <button type="submit" class="btn btn-red">Buscar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </nav>
</header>