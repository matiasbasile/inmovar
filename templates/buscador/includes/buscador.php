<form onsubmit="return filtrar(this)" method="get" role="form" id="form_propiedades" class="<?php echo ($nombre_pagina=="home")?"form-map":"" ?> form-search">
  <?php if ($nombre_pagina == "home") { ?><h2>Buscador</h2><?php } ?>

  <div class="form-group" id="buscador-tipo-operacion">
    <select id="tipo_operacion" class="filter_tipo_operacion">
      <?php $filter_tipos_operacion = $propiedad_model->get_tipos_operaciones();
      foreach($filter_tipos_operacion as $r) { ?>
        <option <?php echo (isset($vc_link_tipo_operacion) == $r->link) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
      <?php } ?>
    </select>
  </div><!-- /.form-group -->
  <div class="form-group" id="buscador-localidad">
    <select id="localidad" class="filter_localidad">
      <option value="0">Localidad</option>
      <?php $filter_localidades = $propiedad_model->get_localidades();
      foreach($filter_localidades as $r) { ?>
        <option <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $r->link) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
      <?php } ?>
    </select>
  </div><!-- /.form-group -->
  <div class="form-group" id="buscador-tipo-propiedad">
    <select class="filter_tipo_propiedad" name="tp">
      <option value="0">Tipo de Propiedad</option>
      <?php $filter_tipos_propiedades = $propiedad_model->get_tipos_propiedades();
      foreach($filter_tipos_propiedades as $r) { ?>
        <option <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $r->id) ? "selected":"" ?> value="<?php echo $r->id ?>"><?php echo $r->nombre ?></option>
      <?php } ?>
    </select>
  </div><!-- /.form-group -->
  <div class="form-group" id="buscador-dormitorios">
    <select class="filter_dormitorios" name="dm">
      <option value="">Habitaciones</option>
      <?php $filter_dormitorios = $propiedad_model->get_dormitorios();
      foreach($filter_dormitorios as $r) { ?>
        <option <?php echo (isset($vc_dormitorios) && $vc_dormitorios == $r->dormitorios) ? "selected":"" ?> value="<?php echo $r->dormitorios ?>"><?php echo $r->dormitorios ?></option>
      <?php } ?>
    </select>
  </div><!-- /.form-group -->
  <div class="form-group" id="buscador-banios">
    <select class="filter_banios" name="bn">
      <option value="">Ba&ntilde;os</option>
      <?php $filter_banios = $propiedad_model->get_banios();
      foreach($filter_banios as $r) { ?>
        <option <?php echo (isset($vc_banios) && $vc_banios == $r->banios) ? "selected":"" ?> value="<?php echo $r->banios ?>"><?php echo $r->banios ?></option>
      <?php } ?>
    </select>
  </div><!-- /.form-group -->
  <div class="form-group" id="buscador-precio-minimo">
    <div class="row">
      <div class="col-xs-5 pr0">
        <select id="moneda_precio_minimo" onchange="cambiar_moneda_precio_minimo()" name="m">
          <option <?php echo (isset($vc_moneda) && $vc_moneda == "ars")?"selected":"" ?> value="ARS">$</option>
          <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
        </select>
      </div>
      <div class="col-xs-7 pl0">
        <input class="form-control" placeholder="Precio Minimo" id="precio_minimo" type="text" name="vc_minimo" value="<?php echo (isset($vc_minimo) ? (($vc_minimo == 0)?"":$vc_minimo) : "") ?>"/>
      </div>
    </div>
  </div>
  <div class="form-group" id="buscador-precio-maximo">
    <div class="row">
      <div class="col-xs-5 pr0">
        <select id="moneda_precio_maximo" onchange="cambiar_moneda_precio_maximo()">
          <option <?php echo (isset($vc_moneda) && $vc_moneda == "ars")?"selected":"" ?> value="ARS">$</option>
          <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
        </select>
      </div>
      <div class="col-xs-7 pl0">
        <input class="form-control" placeholder="Precio Maximo" id="precio_maximo" type="text" name="vc_maximo" value="<?php echo (isset($vc_maximo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>"/>
      </div>
    </div>
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-default">Buscar</button>
  </div>
</form>

<div class="buscador-flotante">
  <div class="row">
    <div class="col-xs-6">
      <button onclick="ver_filtros()" class="btn btn-default">Filtrar</button>
    </div>
    <div class="col-xs-6">
      <button onclick="ver_orden()" class="btn btn-default">Ordenar</button>
    </div>
  </div>
</div>

<script>
function cambiar_moneda_precio_minimo() {
  var v = $("#moneda_precio_minimo").val();
  $("#moneda_precio_maximo").val(v);
}
function cambiar_moneda_precio_maximo() {
  var v = $("#moneda_precio_maximo").val();
  $("#moneda_precio_minimo").val(v);
}

function filtrar() { 
  var link = "<?php echo mklink("propiedades/") ?>";
  var tipo_operacion = $("#tipo_operacion").val();
  var localidad = $("#localidad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>