<form id="form_buscador" onsubmit="return filtrar(this)" method="get">
  <div class="comprar-inner">
    <div class="row">
      <div class="col-lg-2">
        <div class="select-inner">
          <select id="tipo_operacion" class="round filter_tipo_operacion">
            <?php $tipos_op = $propiedad_model->get_tipos_operaciones(array(
              "id_empresa" => $empresa->id,
              "solo_propias" => 1,
              "mostrar_todos" => 0,
            )); ?>
            <?php foreach ($tipos_op as $tipo) { ?>
              <option <?php echo ($vc_link_tipo_operacion == $tipo->link) ? "selected" : "" ?> value="<?php echo $tipo->link ?>"><?php echo $tipo->nombre ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="select-inner">
          <select id="filter_propiedad" class="round filter_propiedad" name="tp">
            <option value="0">TIPO DE PROPIEDAD</option>
            <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
            <?php foreach ($tipo_propiedades as $tipo) { ?>
              <option <?php echo ($vc_id_tipo_inmueble == $tipo->id) ? "selected" : "" ?> value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="select-inner">
          <select id="filter_dormitorios" class="round filter_dormitorios" name="dm">
            <option value="0">HABITACIONES</option>
            <?php $dormitorios = $propiedad_model->get_dormitorios(); ?>
            <?php foreach ($dormitorios as $dormitorio) { ?>
              <option <?php echo ($vc_dormitorios == $dormitorio->dormitorios) ? "selected" : "" ?> value="<?php echo $dormitorio->dormitorios; ?>">
                <?php echo $dormitorio->dormitorios ?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="select-inner">
          <select id="filter_banios" class="round filter_banios" name="bn">
            <option value="0">BAÑOS</option>
            <?php $banios = $propiedad_model->get_banios(); ?>
            <?php foreach ($banios as $banio) { ?>
              <option <?php echo ($vc_banios == $banio->banios) ? "selected" : "" ?> value="<?php echo $banio->banios; ?>">
                <?php echo $banio->banios ?>
              </option>
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
              <input type="hidden" id="filter_moneda" name="m" value="<?php echo (!empty($vc_moneda) ? $vc_moneda : ($vc_link_tipo_operacion == "alquileres" ? "ARS" : "USD")) ?>">
              <input name="vc_minimo" id="filter_minimo" class="form-control filter_minimo" type="hidden" value="<?php echo (empty($vc_minimo) ? "" : $vc_minimo) ?>" min="0" placeholder="Precio Minimo">
              <input name="vc_maximo" id="filter_maximo" class="form-control filter_maximo" type="hidden" value="<?php echo (empty($vc_maximo) ? "" : $vc_maximo) ?>" min="0" placeholder="Precio Maximo">
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="row align-items-center">
    <div class="col-lg-3">
      <div class="select-inner">
        <select onchange="order_solo()" id="country" name="orden" class="round">
          <option value="8" <?php echo ($vc_orden == 8) ? "selected" : "" ?>>Propiedades Destacadas</option>
          <option value="2" <?php echo ($vc_orden == 2) ? "selected" : "" ?>>precio de menor a mayor</option>
          <option value="1" <?php echo ($vc_orden == 1) ? "selected" : "" ?>>precio de mayor a menor</option>
        </select>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="check-inner">
        <div class="check-form">
          <div class="custom-control custom-checkbox custom-checkbox-green">
            <input onchange="cambiar_checkboxes(this)" type="checkbox" class="custom-control-input custom-control-input-green" id="customCheck1" <?php echo ($vc_apto_banco == 1)?"checked":"" ?> type="checkbox" name="banco" value="1">
            <label class="custom-control-label" for="customCheck1">Apto Crédito</label>
          </div>
        </div>
        <div class="check-form">
          <div class="custom-control custom-checkbox custom-checkbox-green">
            <input onchange="cambiar_checkboxes(this)" type="checkbox" class="custom-control-input custom-control-input-green" id="customCheck2" <?php echo ($vc_acepta_permuta == 1)?"checked":"" ?> type="checkbox" name="per" value="1">
            <label class="custom-control-label" for="customCheck2">Acepta Permuta</label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="comprar-btns">
        <a href="javascript:void(0)" onclick="" class="border-btn">ver en mapa</a>
        <button type="submit" class="fill-btn">buscar</button>
      </div>
    </div>
  </div>
</form>