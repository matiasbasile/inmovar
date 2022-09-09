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
        <select id="country" class="round" name="tipo de propiedad">
          <option value="australia">tipo de propiedad</option>
          <option value="canada">tipo de propiedad</option>
          <option value="usa">tipo de propiedad</option>
        </select>
      </div>
    </div>
    <div class="col-lg-2">
      <div class="select-inner">
        <select id="country" class="round" name="habitaciones">
          <option value="australia">habitaciones</option>
          <option value="canada">habitaciones</option>
          <option value="usa">habitaciones</option>
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