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
        <select id="filter_banios" class="round filter_banios" name="baños">
          <?php $banios = $propiedad_model->get_banios(); ?>
          <?php foreach ($banios as $banio) { ?>
            <option <?php echo ($vc_listado[0]->banios == $banio->banios) ? "selected" : "" ?> value="<?php echo $banio->banios; ?>"><?php echo (($banio->banios == 0) ? "BAÑOS" : $banio->banios) ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-lg-2">
      <div class="select-inner">
        <select id="filter_rango_precios" class="round" name="precio">
          <option data-min="0" data-max="0">PRECIO</option>
          <?php if ($vc_link_tipo_operacion == "alquileres") { ?>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 25000) ? "selected" : "" ?> data-min="0" data-max="25000">$ 0 - 25.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 50000) ? "selected" : "" ?> data-min="25000" data-max="50000">$ 25.000 - 50.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 75000) ? "selected" : "" ?> data-min="50000" data-max="75000">$ 50.000 - 75.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 100000) ? "selected" : "" ?> data-min="75000" data-max="100000">$ 75.000 - 100.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 150000) ? "selected" : "" ?> data-min="100000" data-max="150000">$ 100.000 - 150.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 999999) ? "selected" : "" ?> data-min="150000" data-max="999999">Más de $ 300.000</option>
          <?php } else { ?>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 25000) ? "selected" : "" ?> data-min="0" data-max="25000">U$S 0 - 25.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 50000) ? "selected" : "" ?> data-min="25000" data-max="50000">U$S 25.000 - 50.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 75000) ? "selected" : "" ?> data-min="50000" data-max="75000">U$S 50.000 - 75.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 100000) ? "selected" : "" ?> data-min="75000" data-max="100000">U$S 75.000 - 100.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 125000) ? "selected" : "" ?> data-min="100000" data-max="125000">U$S 100.000 - 125.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 150000) ? "selected" : "" ?> data-min="125000" data-max="150000">U$S 125.000 - 150.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 200000) ? "selected" : "" ?> data-min="150000" data-max="200000">U$S 150.000 - 200.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 300000) ? "selected" : "" ?> data-min="200000" data-max="300000">U$S 200.000 - 300.000</option>
            <option <?php echo (isset($vc_maximo) && $vc_maximo == 999999) ? "selected" : "" ?> data-min="300000" data-max="999999">Más de U$S 300.000</option>
            <input type="hidden" id="filter_moneda" name="m" value="<?php echo (!empty($vc_moneda) ? $vc_moneda : ($vc_listado[0]->link_tipo_operacion == "alquileres" ? "ARS" : "USD")) ?>">
          <?php } ?>
        </select>
      </div>
    </div>
  </div>
</div>