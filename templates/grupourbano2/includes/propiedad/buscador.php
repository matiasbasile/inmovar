<a href="javascript:void(0)" rel="nofollow" class="btn btn-primary btn-block mb-3 form-toggle style-two mt-5">AJUSTAR BÚSQUEDA</a>
<form onsubmit="return filtrar(this)" method="get" class="form-responsive mt-5">
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
      <select class="form-control filter_propiedad" name="tp">
        <option value="0">DEPARTAMENTOS</option>
        <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
        <?php foreach ($tipo_propiedades as $tipo) { ?>
          <option <?php echo ($vc_id_tipo_inmueble == $tipo->id)?"selected":"" ?> value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
        <?php } ?>
      </select>
      <select class="form-control filter_localidad">
        <option value="0">Localidad</option>
        <?php $localidades = $propiedad_model->get_localidades(); ?>
        <?php foreach ($localidades as $localidad) { ?>
          <option <?php echo ($localidad->link == $vc_link_localidad)?"selected":"" ?> value="<?php echo $localidad->link ?>"><?php echo $localidad->nombre ?></option>
        <?php } ?>
      </select>
      <select class="form-control filter_dormitorios" name="dm">
        <?php $dormitorios = $propiedad_model->get_dormitorios(); ?>
        <?php foreach ($dormitorios as $dormitorio) { ?>
          <option <?php echo ($vc_dormitorios == $dormitorio->dormitorios)?"selected":"" ?> value="<?php echo $dormitorio->dormitorios; ?>"><?php echo (($dormitorio->dormitorios == 0) ? "DORMITORIOS" : $dormitorio->dormitorios) ?></option>
        <?php } ?>
      </select>
      <select class="form-control filter_banios" name="bn">
        <?php $banios = $propiedad_model->get_banios(); ?>
        <?php foreach ($banios as $banio) { ?>
          <option <?php echo ($vc_banios == $banio->banios)?"selected":"" ?> value="<?php echo $banio->banios; ?>"><?php echo (($banio->banios == 0) ? "BAÑOS" : $banio->banios) ?></option>
        <?php } ?>
      </select>
      <input name="vc_minimo" class="form-control filter_minimo" type="number" value="<?php echo (empty($vc_minimo) ? "" : $vc_minimo) ?>" min="0" placeholder="Precio Minimo">
      <input name="vc_maximo" class="form-control filter_maximo" type="number" value="<?php echo (empty($vc_maximo) ? "" : $vc_maximo) ?>" min="0" placeholder="Precio Maximo">
      <button type="submit" class="btn btn-primary">BUSCAR</button>
    </div>
  </div>
  <div class="page-heading mt-5">
    <div class="row justify-content-between">
      <div class="col-md-7">
        <select name="orden" class="form-control form-primary">
          <option <?php echo($vc_orden == 4)?"selected":"" ?> value="destacados">Propiedades Destacadas</option>
          <option <?php echo($vc_orden == 2)?"selected":"" ?> value="barato">Precio Menor a Mayor</option>
          <option <?php echo($vc_orden == 1)?"selected":"" ?> value="caro">Precio Mayor a Menor</option>
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
          <input class="styled-checkbox" id="styled-checkbox-1" <?php echo ($vc_apto_banco == 1)?"checked":"" ?> type="checkbox" name="banco" value="1">
          <label for="styled-checkbox-1">Apto Crédito</label>
        </div>
        <div class="custom-check">
          <input class="styled-checkbox" id="styled-checkbox-2" <?php echo ($vc_acepta_permuta == 1)?"checked":"" ?> type="checkbox" name="per" value="1">
          <label for="styled-checkbox-2">Acepta Permuta</label>
        </div>
      </div>
    </div>
  </div>
</form>