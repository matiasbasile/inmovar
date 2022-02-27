<a href="javascript:void(0)" rel="nofollow" class="btn btn-primary btn-block mb-3 form-toggle style-two mt-5">AJUSTAR BÚSQUEDA</a>
<form id="form_buscador" onsubmit="return filtrar(this)" method="get" class="form-responsive mt-5">
  <div class="form-block">
    <input type="hidden" class="base_url" value="<?php echo (isset($buscador_mapa) ? mklink("mapa/") : mklink("propiedades/")) ?>" />
    <div class="form">
      <select class="form-control filter_tipo_operacion">
        <option value="0">OPERACIÓN</option>
        <?php $tipos_op = $propiedad_model->get_tipos_operaciones(); ?>
        <?php foreach ($tipos_op as $tipo) { ?>
          <option <?php echo ($vc_link_tipo_operacion == $tipo->link)?"selected":"" ?> value="<?php echo $tipo->link ?>"><?php echo $tipo->nombre ?></option>
        <?php } ?>
      </select>      
      <select id="filter_propiedad" class="form-control filter_propiedad" name="tp">
        <option value="0">PROPIEDAD</option>
        <?php $vc_tipo_inmueble = ""; ?>
        <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
        <?php foreach ($tipo_propiedades as $tipo) { ?>
          <?php if ($vc_id_tipo_inmueble == $tipo->id) $vc_tipo_inmueble = $tipo->nombre; ?>
          <option <?php echo ($vc_id_tipo_inmueble == $tipo->id)?"selected":"" ?> value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
        <?php } ?>
      </select>
      <select id="filter_localidad" class="form-control filter_localidad">
        <option value="0">Localidad</option>
        <?php $localidades = $propiedad_model->get_localidades(); ?>
        <?php foreach ($localidades as $localidad) { ?>
          <option <?php echo ($localidad->link == $vc_link_localidad)?"selected":"" ?> value="<?php echo $localidad->link ?>"><?php echo $localidad->nombre ?></option>
        <?php } ?>
      </select>
      <select id="filter_dormitorios" class="form-control filter_dormitorios" name="dm">
        <?php $dormitorios = $propiedad_model->get_dormitorios(); ?>
        <?php foreach ($dormitorios as $dormitorio) { ?>
          <option <?php echo ($vc_dormitorios == $dormitorio->dormitorios)?"selected":"" ?> value="<?php echo $dormitorio->dormitorios; ?>"><?php echo (($dormitorio->dormitorios == 0) ? "DORMITORIOS" : $dormitorio->dormitorios) ?></option>
        <?php } ?>
      </select>
      <select id="filter_banios" class="form-control filter_banios" name="bn">
        <?php $banios = $propiedad_model->get_banios(); ?>
        <?php foreach ($banios as $banio) { ?>
          <option <?php echo ($vc_banios == $banio->banios)?"selected":"" ?> value="<?php echo $banio->banios; ?>"><?php echo (($banio->banios == 0) ? "BAÑOS" : $banio->banios) ?></option>
        <?php } ?>
      </select>

      <select class="form-control" id="filter_rango_precios">
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
        <?php } ?>
      </select>
      <input type="hidden" id="filter_moneda" name="m" value="<?php echo (!empty($vc_moneda) ? $vc_moneda : ($vc_link_tipo_operacion == "alquileres" ? "ARS" : "USD")) ?>">
      <input name="vc_minimo" id="filter_minimo" class="form-control filter_minimo" type="hidden" value="<?php echo (empty($vc_minimo) ? "" : $vc_minimo) ?>" min="0" placeholder="Precio Minimo">
      <input name="vc_maximo" id="filter_maximo" class="form-control filter_maximo" type="hidden" value="<?php echo (empty($vc_maximo) ? "" : $vc_maximo) ?>" min="0" placeholder="Precio Maximo">
      <button type="submit" class="btn btn-primary">BUSCAR</button>
    </div>
  </div>
  <div class="page-heading mt-5">
    <div class="row justify-content-between">
      <div class="col-md-7">
        <select onchange="cambiar_checkboxes(this)" name="orden" class="form-control form-primary">
          <option <?php echo($vc_orden == 8)?"selected":"" ?> value="8">Propiedades Destacadas</option>
          <option <?php echo($vc_orden == 2)?"selected":"" ?> value="2">Precio Menor a Mayor</option>
          <option <?php echo($vc_orden == 1)?"selected":"" ?> value="1">Precio Mayor a Menor</option>
        </select>
        <?php if (isset($buscador_mapa)) { ?>
          <a onclick="buscar_listado(this)" href="javascript:void(0)" rel="nofollow" class="btn btn-primary btn-sm">
            <i class="fa fa-map-marker mr-2" aria-hidden="true"></i> Ver listado
          </a>
        <?php } else { ?>
          <a onclick="buscar_mapa(this)" href="javascript:void(0)" rel="nofollow" class="btn btn-primary btn-sm">
            <i class="fa fa-map-marker mr-2" aria-hidden="true"></i> Ver en mapa
          </a>
        <?php } ?>
      </div>
      <div class="col-md-5 text-right">
        <div class="custom-check">
          <input onchange="cambiar_checkboxes(this)" class="styled-checkbox" id="styled-checkbox-1" <?php echo ($vc_apto_banco == 1)?"checked":"" ?> type="checkbox" name="banco" value="1">
          <label for="styled-checkbox-1">Apto Crédito</label>
        </div>
        <div class="custom-check">
          <input onchange="cambiar_checkboxes(this)" class="styled-checkbox" id="styled-checkbox-2" <?php echo ($vc_acepta_permuta == 1)?"checked":"" ?> type="checkbox" name="per" value="1">
          <label for="styled-checkbox-2">Acepta Permuta</label>
        </div>
      </div>
    </div>

    <div class="pt30">   

      <?php if (!empty($vc_tipo_inmueble)) { ?>
        <span class="tag_buscador" data-field="filter_propiedad"><?php echo $vc_tipo_inmueble ?> <i class="fa fa-times"></i></span>
      <?php } ?>

      <?php if (!empty($vc_nombre_localidad)) { ?>
        <span class="tag_buscador" data-field="filter_localidad"><?php echo $vc_nombre_localidad ?> <i class="fa fa-times"></i></span>
      <?php } ?>

      <?php if (!empty($vc_dormitorios)) { ?>
        <span class="tag_buscador" data-field="filter_dormitorios"><?php echo $vc_dormitorios.(($vc_banios > 1)?" Dormitorios":" Dormitorio") ?> <i class="fa fa-times"></i></span>
      <?php } ?>

      <?php if (!empty($vc_banios)) { ?>
        <span class="tag_buscador" data-field="filter_banios"><?php echo $vc_banios.(($vc_banios > 1)?" Baños":" Baño") ?> <i class="fa fa-times"></i></span>
      <?php } ?>

      <?php if ($vc_link_tipo_operacion == "alquileres") { ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 25000) { ?><span class="tag_buscador" data-field="filter_rango_precios">$ 0 - 25.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 50000) { ?><span class="tag_buscador" data-field="filter_rango_precios">$ 25.000 - 50.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 75000) { ?><span class="tag_buscador" data-field="filter_rango_precios">$ 50.000 - 75.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 100000) { ?><span class="tag_buscador" data-field="filter_rango_precios">$ 75.000 - 100.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 150000) { ?><span class="tag_buscador" data-field="filter_rango_precios">$ 100.000 - 150.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 999999) { ?><span class="tag_buscador" data-field="filter_rango_precios">Más de $ 300.000 <i class="fa fa-times"></i></span><?php } ?>
      <?php } else { ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 25000) { ?><span class="tag_buscador" data-field="filter_rango_precios">U$S 0 - 25.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 50000) { ?><span class="tag_buscador" data-field="filter_rango_precios">U$S 25.000 - 50.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 75000) { ?><span class="tag_buscador" data-field="filter_rango_precios">U$S 50.000 - 75.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 100000) { ?><span class="tag_buscador" data-field="filter_rango_precios">U$S 75.000 - 100.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 125000) { ?><span class="tag_buscador" data-field="filter_rango_precios">U$S 100.000 - 125.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 150000) { ?><span class="tag_buscador" data-field="filter_rango_precios">U$S 125.000 - 150.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 200000) { ?><span class="tag_buscador" data-field="filter_rango_precios">U$S 150.000 - 200.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 300000) { ?><span class="tag_buscador" data-field="filter_rango_precios">U$S 200.000 - 300.000 <i class="fa fa-times"></i></span><?php } ?>
        <?php if (isset($vc_maximo) && $vc_maximo == 999999) { ?><span class="tag_buscador" data-field="filter_rango_precios">Más de U$S 300.000 <i class="fa fa-times"></i></span><?php } ?>
      <?php } ?>

      <?php if ($vc_apto_banco == 1) { ?>
        <span class="tag_buscador" data-field="styled-checkbox-1">Apto Crédito <i class="fa fa-times"></i></span>
      <?php } ?>

      <?php if ($vc_acepta_permuta == 1) { ?>
        <span class="tag_buscador" data-field="styled-checkbox-2">Acepta Permuta <i class="fa fa-times"></i></span>
      <?php } ?>

    </div>

  </div>
</form>
