<section class="filter-box">
  <form id="form_buscador" onsubmit="return filtrar()" method="get">

    <input type="hidden" id="orden_buscador" value="<?php echo ($vc_orden == 8) ? "selected" : "" ?>" name="orden" />
    <input type="hidden" class="base_url" value="<?php echo (isset($buscador_mapa) ? mklink("mapa/") : mklink("propiedades/")) ?>" />
    <input type="hidden" id="tipo_operacion" class="filter_tipo_operacion" value="<?php echo $vc_link_tipo_operacion ?>">

    <select id="filter_localidad" class="form-select form-control big filter_localidad">
      <option value="">Localidad</option>
      <?php $localidades = $propiedad_model->get_localidades(); ?>
      <?php foreach ($localidades as $localidad) { ?>
        <option <?php echo ($localidad->link == $vc_link_localidad)?"selected":"" ?> value="<?php echo $localidad->link ?>"><?php echo $localidad->nombre ?></option>
      <?php } ?>
    </select>
    
    <select id="filter_propiedad" class="form-select form-control big filter_propiedad" name="tp">
      <option value="0">Tipo de Propiedad</option>
      <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
      <?php foreach ($tipo_propiedades as $tipo) { ?>
        <option <?php echo ($vc_id_tipo_inmueble == $tipo->id) ? "selected" : "" ?> value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
      <?php } ?>
    </select>

    <select id="filter_dormitorios" class="form-select filter_dormitorios" name="dm">
      <option value="0">Dormitorios</option>
      <?php $dormitorios = $propiedad_model->get_dormitorios(); ?>
      <?php foreach ($dormitorios as $dormitorio) { ?>
        <?php if (empty($dormitorio->dormitorios)) continue; ?>
        <option <?php echo ($vc_dormitorios == $dormitorio->dormitorios) ? "selected" : "" ?> value="<?php echo $dormitorio->dormitorios; ?>">
          <?php echo $dormitorio->dormitorios ?>
        </option>
      <?php } ?>
    </select>
    
    <select id="filter_banios" class="form-select form-control filter_banios" name="bn">
      <option value="0">Baños</option>
      <?php $banios = $propiedad_model->get_banios(); ?>
      <?php foreach ($banios as $banio) { ?>
        <?php if (empty($banio->banios)) continue; ?>
        <option <?php echo ($vc_banios == $banio->banios) ? "selected" : "" ?> value="<?php echo $banio->banios; ?>">
          <?php echo $banio->banios ?>
        </option>
      <?php } ?>
    </select>

    <select id="filter_rango_precios" class="form-select form-control small">
      <option data-min="0" data-max="0">Precio</option>
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

    <div class="multiple-checkbox">
      <span class="check-desk">Otros 
        <a href="javascript:void(0)"><img src="assets/images/select-arrow.png" arrow> </a>
      </span>
      <a class="filter-mob" href="javascript:void(0)">FILTRAR <img src="assets/images/select-arrow.png" arrow> </a>
      <div class="checkbox-list check-desk-list">
        <div class="dropdown-form">

          <select onchange="copiar_select('filter_localidad')" id="filter_localidad_2" class="form-select form-control">
            <option value="">Localidad</option>
            <?php $localidades = $propiedad_model->get_localidades(); ?>
            <?php foreach ($localidades as $localidad) { ?>
              <option <?php echo ($localidad->link == $vc_link_localidad)?"selected":"" ?> value="<?php echo $localidad->link ?>"><?php echo $localidad->nombre ?></option>
            <?php } ?>
          </select>
          
          <select onchange="copiar_select('filter_propiedad')" id="filter_propiedad_2" class="form-select form-control">
            <option value="0">Tipo de Propiedad</option>
            <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
            <?php foreach ($tipo_propiedades as $tipo) { ?>
              <option <?php echo ($vc_id_tipo_inmueble == $tipo->id) ? "selected" : "" ?> value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
            <?php } ?>
          </select>

          <select onchange="copiar_select('filter_dormitorios')" id="filter_dormitorios_2" class="form-select form-control">
            <option value="0">Dormitorios</option>
            <?php $dormitorios = $propiedad_model->get_dormitorios(); ?>
            <?php foreach ($dormitorios as $dormitorio) { ?>
              <?php if (empty($dormitorio->dormitorios)) continue; ?>
              <option <?php echo ($vc_dormitorios == $dormitorio->dormitorios) ? "selected" : "" ?> value="<?php echo $dormitorio->dormitorios; ?>">
                <?php echo $dormitorio->dormitorios ?>
              </option>
            <?php } ?>
          </select>
          
          <select onchange="copiar_select('filter_banios')" id="filter_banios_2" class="form-select form-control">
            <option value="0">Baños</option>
            <?php $banios = $propiedad_model->get_banios(); ?>
            <?php foreach ($banios as $banio) { ?>
              <?php if (empty($banio->banios)) continue; ?>
              <option <?php echo ($vc_banios == $banio->banios) ? "selected" : "" ?> value="<?php echo $banio->banios; ?>">
                <?php echo $banio->banios ?>
              </option>
            <?php } ?>
          </select>

          <select onchange="copiar_select()" id="filter_rango_precios_2" class="form-select form-control">
            <option data-min="0" data-max="0">Precio</option>
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
            <?php } ?>
          </select>
        </div>
        <span class="check-mob">Otros <a href="javascript:void(0)" rel="nofollow"><img src="assets/images/select-arrow.png" arrow> </a></span>
        <div class="checkbox-list-top">
          <div class="form-check">
            <input type="checkbox" class="custom-control-input custom-control-input-green" id="customCheck1" <?php echo ($vc_apto_banco == 1)?"checked":"" ?> type="checkbox" name="banco" value="1">
            <label class="custom-control-label" for="customCheck1">Apto Crédito</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="custom-control-input custom-control-input-green" id="customCheck3" <?php echo ($vc_cocheras == 1)?"checked":"" ?> type="checkbox" name="gar" value="1">
            <label class="custom-control-label" for="customCheck2">Cochera</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="custom-control-input custom-control-input-green" id="customCheck2" <?php echo ($vc_acepta_permuta == 1)?"checked":"" ?> type="checkbox" name="per" value="1">
            <label class="custom-control-label" for="customCheck2">Acepta Permuta</label>
          </div>
        </div>
        <button type="submit" class="btn">Buscar</button>
      </div>
    </div>
    <button type="submit" class="btn">Buscar</button>
  </form>
</section>