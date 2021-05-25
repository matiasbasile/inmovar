<form onsubmit="return filtrar(this)" method="get" role="form" id="form_propiedades" class="<?php echo ($nombre_pagina=="home")?"form-map":"" ?> form-search">

  <header>
    <h3>
      Filtrar
      <i onclick="cerrar_filtros()" class="cerrar_filtros fa fa-times"></i>
    </h3>
  </header>

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
      <div class="col-xs-3 pr0">
        <select id="moneda_precio_minimo" name="m">
          <option <?php echo (isset($vc_moneda) && $vc_moneda == "ars")?"selected":"" ?> value="ARS">$</option>
          <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
        </select>
      </div>
      <div class="col-xs-9 pl0">
        <div class="row">
          <div class="col-xs-6 pr0">
            <input class="form-control" placeholder="Máx." id="precio_maximo" type="text" name="vc_maximo" value="<?php echo (isset($vc_maximo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>"/>
          </div>
          <div class="col-xs-6 pl0">
            <input class="form-control" placeholder="Min." id="precio_minimo" type="text" name="vc_minimo" value="<?php echo (isset($vc_minimo) ? (($vc_minimo == 0)?"":$vc_minimo) : "") ?>"/>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-buscar btn-default">Aplicar</button>
  </div>
</form>

<div class="buscador-flotante">
  <div class="row">
    <div class="col-xs-6">
      <button onclick="ver_filtros()" class="button">Filtrar</button>
    </div>
    <div class="col-xs-6">
      <button onclick="ver_orden()" class="button">Ordenar</button>
    </div>
  </div>
</div>

<div id="orden_propiedades" class="form-search">
  <header>
    <h3>
      Ordenar
      <i onclick="cerrar_filtros()" class="cerrar_filtros fa fa-times"></i>
    </h3>
  </header>
  <div class="form-group">
    <input type="radio" name="ordenar" <?php echo ($vc_orden == -1 ) ? "checked" : "" ?> value="nuevo" id="orden_1" />
    <label for="orden_1">Más nuevos</label>
  </div>
  <div class="form-group">
    <input type="radio" name="ordenar" <?php echo ($vc_orden == 2 ) ? "checked" : "" ?> value="barato" id="orden_2" />
    <label for="orden_2">Menor precio</label>
  </div>
  <div class="form-group">
    <input type="radio" name="ordenar" <?php echo ($vc_orden == 1 ) ? "checked" : "" ?> value="caro" id="orden_3" />
    <label for="orden_3">Mayor precio</label>
  </div>
  <div class="form-group">
    <input type="radio" name="ordenar" <?php echo ($vc_orden == 4 ) ? "checked" : "" ?> value="destacado" id="orden_4" />
    <label for="orden_4">Destacados</label>
  </div>
  <div class="form-group">
    <button onclick="aplicar_orden()" class="btn btn-buscar btn-default">Aplicar</button>
  </div>
</form>

<script>
function ver_filtros() {
  $("#form_propiedades").addClass("active");
}
function cerrar_filtros() {
  $("#form_propiedades").removeClass("active");
  $("#orden_propiedades").removeClass("active");
}
function ver_orden() {
  $("#orden_propiedades").addClass("active");
}
function aplicar_orden() {
  var v = $("input[name='ordenar']:checked").val();
  $("#orden_select").val(v).trigger("change");
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