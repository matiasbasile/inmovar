<div class="search-filter">
  <div class="form-title">Filtros de Búsqueda</div>
  <form method="get" onsubmit="return onsubmit_buscador_propiedades()" id="form_propiedades">
    <input type="hidden" id="sidebar_orden" name="orden" value="<?php echo (isset($vc_orden)) ? $vc_orden : -1 ?>">
    <input type="hidden" id="sidebar_offset" name="offset" value="<?php echo (isset($vc_offset)) ? $vc_offset : 12 ?>">
    <div class="box-space">
      <input value="listado" <?php echo ($nombre_pagina != "mapa")?"checked":"" ?> type="checkbox" onchange="comprobar(this)" name="tipo_busqueda" id="list-view2">
      <label for="list-view2">Listado <img src="assets/images/list-view-icon.png" alt="List View" /></label>
      <input value="mapa" <?php echo ($nombre_pagina == "mapa")?"checked":"" ?> type="checkbox" onchange="comprobar(this)" name="tipo_busqueda" id="map-view">
      <label for="map-view">Mapa <img src="assets/images/location-icon.png" alt="Map View" /></label>
    </div>
    <div class="box-space">
      <div class="textbox-title">Tipo de Operación</div>
      <select class="form-control" id="tipo_operacion">
        <?php $tipos_operaciones = $propiedad_model->get_tipos_operaciones()?>
        <option value="todas">Todas</option>
        <?php foreach ($tipos_operaciones as $t) {  ?>
          <option value="<?php echo $t->link ?>" <?php echo (isset($vc_link_tipo_operacion) && $vc_link_tipo_operacion == $t->link) ? "selected" : "" ?>><?php echo $t->nombre ?></option>
        <?php } ?>
      </select>
      <div class="textbox-title">Localidad</div>
      <?php $localidades = $propiedad_model->get_localidades(); ?>
      <select class="form-control" id="localidad">
        <option value="todas">Todas</option>
        <?php foreach ($localidades as $t) {  ?>
          <option value="<?php echo $t->link ?>" <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $t->link) ? "selected" : "" ?>><?php echo $t->nombre ?></option>
        <?php } ?>
      </select>
      <div class="textbox-title">Tipo de Propiedad</div>
      <?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
      <select class="form-control" name="tp" id="tp">
        <option value="">Todas</option>
        <?php foreach ($tipos_propiedades as $t) {  ?>
          <option value="<?php echo $t->id ?>" <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $t->id) ? "selected " : "" ?>><?php echo $t->nombre ?></option>
        <?php } ?>
      </select>
      <div class="textbox-title">Dormitorios</div>
      <?php $dormitorios_list = $propiedad_model->get_dormitorios(); ?>
      <select class="form-control" name="dm" id="dormitorios">
        <option value="">Todos</option>
        <?php foreach ($dormitorios_list as $t) {  ?>
          <option value="<?php echo $t->dormitorios ?>" <?php echo (isset($vc_dormitorios) && $vc_dormitorios == $t->dormitorios) ? "selected " : "" ?>><?php echo $t->dormitorios ?></option>
        <?php } ?>
      </select>
      <div class="checkboxes-block">
        <div class="row">
          <div class="col-md-6">
            <input id="balcon" name="balcon" value="1" <?php echo (isset($vc_tiene_balcon) && $vc_tiene_balcon==1)?"checked":"" ?> type="checkbox">
            <label for="balcon">Balcón</label>
          </div>
          <div class="col-md-6">
            <input id="tiene_frente" name="tiene_frente" value="1" <?php echo (isset($vc_tiene_frente) && $vc_tiene_frente==1)?"checked":"" ?> type="checkbox">
            <label for="tiene_frente">Frente</label>
          </div>
          <div class="col-md-6">
            <input id="cochera" name="cochera" value="1" <?php echo (isset($vc_tiene_cochera) && $vc_tiene_cochera==1)?"checked":"" ?> type="checkbox">
            <label for="cochera">Cochera</label>
          </div>
          <div class="col-md-6">
            <input id="tiene_contrafrente" name="tiene_contrafrente" value="1" <?php echo (isset($vc_tiene_contrafrente) && $vc_tiene_contrafrente==1)?"checked":"" ?> type="checkbox">
            <label for="tiene_contrafrente">Contrafrente</label>
          </div>
          <div class="col-md-6">
            <input id="patio" name="patio" value="1" <?php echo (isset($vc_tiene_patio) && $vc_tiene_patio==1)?"checked":"" ?> type="checkbox">
            <label for="patio">Patio</label>
          </div>
          <div class="col-md-6">
            <input id="tiene_interno" name="tiene_interno" value="1" <?php echo (isset($vc_tiene_interno) && $vc_tiene_interno==1)?"checked":"" ?> type="checkbox">
            <label for="tiene_interno">Interno</label>
          </div>
        </div>
      </div>
    </div>
    <div class="box-space">
      <input id="apto_banco" type="checkbox" <?php echo (isset($vc_apto_banco) && $vc_apto_banco == 1)?"checked":"" ?> value="1"  name="banco">
      <label for="apto_banco">APTO CRÉDITO HIPOTECARIO</label>
    </div>
    <div class="box-space">
      <div class="textbox-title">Precio Mínimo</div>
      <div style="display: inline-flex; width: 100%">
        <select class="form-control" id="moneda_precio_minimo" onchange="cambiar_moneda_precio_minimo()" name="m">
          <option <?php echo (isset($vc_moneda) && $vc_moneda == "ars")?"selected":"" ?> value="ARS">$</option>
          <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
        </select>
        <input class="form-control" placeholder="Precio Minimo" id="precio_minimo" type="text" name="vc_minimo" value="<?php echo (isset($vc_minimo) ? (($vc_minimo == 0)?"":$vc_minimo) : "") ?>">
      </div>
      <div class="textbox-title">Precio Máximo</div>
      <div style="display: inline-flex; width: 100%">
        <select class="form-control" id="moneda_precio_maximo" onchange="cambiar_moneda_precio_maximo()">
          <option <?php echo (isset($vc_moneda) && $vc_moneda == "ars")?"selected":"" ?> value="ARS">$</option>
          <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
        </select>
        <input class="form-control" placeholder="Precio Maximo" id="precio_maximo" type="text" name="vc_maximo" value="<?php echo (isset($vc_maximo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>"/>
      </div>
    </div>
    <div class="box-space">
      <div class="textbox-title">Búsqueda por código</div>
      <input class="form-control" type="text" name="cod" placeholder="<?php echo (isset($vc_codigo) && !empty($vc_codigo))?$vc_codigo:"Ingrese codigo" ?>">
      <input type="submit" value="Buscar" class="btn btn-orange" />
    </div>
  </form>
</div>
<script type="text/javascript">
  function cambiar_moneda_precio_minimo() {
    var v = $("#moneda_precio_minimo").val();
    $("#moneda_precio_maximo").val(v);
  }
  function cambiar_moneda_precio_maximo() {
    var v = $("#moneda_precio_maximo").val();
    $("#moneda_precio_minimo").val(v);
  }
  function comprobar(checkbox){
    otro = checkbox.parentNode.querySelector("[type=checkbox]:not(#" + checkbox.id + ")");
    if (otro.checked){
      otro.checked = false;
    }
  }
</script>