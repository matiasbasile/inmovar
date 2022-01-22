<a href="javascript:void(0)" rel="nofollow" class="btn btn-primary btn-block mb-3 form-toggle style-two mt-5">AJUSTAR BÚSQUEDA</a>
<form onsubmit="return filtrar(this)" method="get" class="form-responsive mt-5">
  <div class="form-block">
    <div class="form">
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
        <option value="0">dormitorios</option>
        <?php $dormitorios = $propiedad_model->get_dormitorios(); ?>
        <?php foreach ($dormitorios as $dormitorio) { ?>
          <option <?php echo ($vc_dormitorios == $dormitorio->dormitorios)?"selected":"" ?> value="<?php echo $dormitorio->dormitorios; ?>"><?php echo $dormitorio->dormitorios ?></option>
        <?php } ?>
      </select>
      <select class="form-control filter_banios" name="bn">
        <option value="0">baños</option>
        <?php $banios = $propiedad_model->get_banios(); ?>
        <?php foreach ($banios as $banio) { ?>
          <option <?php echo ($vc_banios == $banio->banios)?"selected":"" ?> value="<?php echo $banio->banios; ?>"><?php echo $banio->banios ?></option>
        <?php } ?>
      </select>
      <div class="inputs-with">
        <input name="vc_minimo" class="form-control filter_minimo" type="number" value="<?php echo $vc_minimo ?>" min="0" placeholder="Precio Minimo">
      </div>
      <div class="inputs-with">
        <input name="vc_maximo" class="form-control filter_maximo" type="number" value="<?php echo $vc_maximo ?>" min="0" placeholder="Precio Maximo">
      </div>
      <button type="submit" class="btn btn-primary">BUSCAR</button>
    </div>
  </div>
  <div class="page-heading mt-5">
    <div class="row justify-content-between">
      <div class="col-md-7">
        <select class="form-control form-primary">
          <option>propiedades destacadas</option>
        </select>
        <a href="<?php echo mklink("web/mapa") ?>" class="btn btn-primary btn-sm"><i class="fa fa-map-marker mr-2" aria-hidden="true"></i> Ver en mapa</a>
      </div>
      <div class="col-md-5 text-right">
        <div class="custom-check">
          <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" name="banco" value="1">
          <label for="styled-checkbox-1">Apto Crédito</label>
        </div>
        <div class="custom-check">
          <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" name="per" value="1">
          <label for="styled-checkbox-2">Acepta Permuta</label>
        </div>
      </div>
    </div>
  </div>
</form>