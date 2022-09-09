<div class="comprar-inner">
  <div class="row">
    <div class="col-lg-2">
      <div class="select-inner">
        <select id="country" class="round filter_tipo_operacion" name="venta">
          <?php $tipos_op = $propiedad_model->get_tipos_operaciones(array(
            "id_empresa" => $empresa->id,
            "solo_propias" => 1,
            "mostrar_todos" => 0,
          )); ?>
          <?php foreach ($tipos_op as $tipo) { ?>
            <option <?php echo ($vc_listado[0]->tipo_operacion == $tipo->nombre) ? "selected" : "" ?> value="<?php echo $tipo->link ?>"><?php echo $tipo->nombre ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-lg-2">
      <div class="select-inner">
        <select id="filter_propiedad" class="round filter_propiedad" name="tipo de propiedad">
          <?php $vc_tipo_inmueble = ""; ?>
          <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
          <?php foreach ($tipo_propiedades as $tipo) { ?>
            <?php if ($vc_listado[0]->id_tipo_inmueble == $tipo->id) $vc_listado[0]->tipo_inmueble = $tipo->nombre; ?>
            <option <?php echo ($vc_listado[0]->id_tipo_inmueble == $tipo->id) ? "selected" : "" ?> value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-lg-2">
      <div class="select-inner">
        <select id="filter_dormitorios" class="round filter_dormitorios" name="habitaciones">
          <?php $dormitorios = $propiedad_model->get_dormitorios(); ?>
          <?php foreach ($dormitorios as $dormitorio) { ?>
            <option <?php echo ($vc_listado[0]->dormitorios == $dormitorio->dormitorios) ? "selected" : "" ?> value="<?php echo $dormitorio->dormitorios; ?>"><?php echo (($dormitorio->dormitorios == 0) ? "DORMITORIOS" : $dormitorio->dormitorios) ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-lg-2">
      <div class="select-inner">
        <select id="country" class="round" name="baños">
          <option value="australia">baños</option>
          <option value="canada">baños</option>
          <option value="usa">baños</option>
        </select>
      </div>
    </div>
    <div class="col-lg-2">
      <div class="select-inner">
        <select id="country" class="round" name="precio">
          <option value="australia">precio</option>
          <option value="canada">precio</option>
          <option value="usa">precio</option>
        </select>
      </div>
    </div>
  </div>
</div>