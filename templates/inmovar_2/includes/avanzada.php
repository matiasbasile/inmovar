<div class="sidebar-widget <?php echo ($nombre_pagina == "listado") ? "" : "hidden-sm hidden-xs" ?>">
  <div class="main-title-2">
    <h1>Búsqueda <span>avanzada</span></h1>
  </div>
  <form id="form_propiedades" onsubmit="return enviar_buscador_propiedades()" method="GET">
    <input type="hidden" id="view_hidden" value="<?php echo (isset($vc_view) ? $vc_view : "") ?>" name="view"/>
    <div class="checkbox checkbox-theme checkbox-circle">
      <input id="checkboxList" type="checkbox" class="MyCheck" <?php echo ($vc_view == 0) ? "checked" : "" ?> >
      <label for="checkboxList">
        Listado
      </label>
    </div>
    <div class="checkbox checkbox-theme checkbox-circle">
      <input id="checkboxMap" type="checkbox" class="MyCheck" <?php echo ($vc_view == 2) ? "checked" : "" ?>>
      <label for="checkboxMap">
        Mapa
      </label>
    </div>
    <div class="form-group">
      <label>Tipo de operación</label>
      <select id="buscador_tipo_operacion" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
        <option value="todos">Todos</option>
        <?php foreach ($tipos_operaciones as $tipos) {  ?>
          <option <?php echo (isset($vc_link_tipo_operacion) && $vc_link_tipo_operacion == $tipos->link)?"selected":"" ?>   value="<?php echo $tipos->link ?>"><?php echo $tipos->nombre ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label>Localidades</label>
      <select id="buscador_localidad" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
      <option value="todos">Todas</option>
    <?php foreach ($localidades as $l) {  ?>
      <option <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $l->link)?"selected":"" ?> value="<?php echo $l->link ?>"><?php echo $l->nombre ?></option>
      <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label>Tipos de propiedades</label>
      <select id="buscador_tipo_propiedad" class="selectpicker search-fields" name="tp" data-live-search="true" data-live-search-placeholder="Buscar" >
        <option value="0">Todos</option>
        <?php foreach ($tipos_propiedades as $tipos) { ?>
          <option <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $tipos->id) ? "selected":"" ?>  value="<?php echo $tipos->id ?>"><?php echo $tipos->nombre ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
          <label>Dormitorios</label>
          <select class="selectpicker search-fields" name="dm">
            <option value="">Todos</option>
            <?php foreach ($dormitorios_list as $dorm) {  ?>
            <option <?php echo (isset($vc_dormitorios) && $vc_dormitorios == $dorm->dormitorios) ? "selected":"" ?> value="<?php echo $dorm->dormitorios ?>"><?php echo $dorm->dormitorios ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
          <label>Baños</label>
          <select class="selectpicker search-fields" name="bn">
          <option value="">Todos</option>
            <?php foreach ($banios_list as $b) { ?>
            <option <?php echo (isset($vc_banios) && $vc_banios == $b->banios) ? "selected":"" ?> value="<?php echo $b->banios ?>"><?php echo $b->banios ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
          <label>Cocheras</label>
          <select class="selectpicker search-fields" data-live-search="true" name="gar">
            <option value="">Todos</option>
            <?php foreach ($cocheras_list as $c) { ?>
            <option <?php echo (isset($vc_cocheras) && $vc_cocheras == $c->cocheras) ? "selected":"" ?> value="<?php echo $c->cocheras ?>"><?php echo $c->cocheras ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
          <label>Búsqueda por código</label><br>
          <input type="text" value="<?php echo (isset($vc_codigo))?$vc_codigo:"" ?>" name="cod">
        </div>
      </div>
    </div>

    <div class="form-group" id="buscador-precio-minimo">
      <label>Valor Desde</label><br/>
      <div class="row">
        <div class="col-xs-5 pr0">
          <select class="form-control" id="moneda_precio_minimo" onchange="cambiar_moneda_precio_minimo()" name="m">
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
      <label>Valor Hasta</label><br/>
      <div class="row">
        <div class="col-xs-5 pr0">
          <select class="form-control" id="moneda_precio_maximo" onchange="cambiar_moneda_precio_maximo()">
            <option <?php echo (isset($vc_moneda) && $vc_moneda == "ars")?"selected":"" ?> value="ARS">$</option>
            <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
          </select>
        </div>
        <div class="col-xs-7 pl0">
          <input class="form-control" placeholder="Precio Maximo" id="precio_maximo" type="text" name="vc_maximo" value="<?php echo (isset($vc_maximo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>"/>
        </div>
      </div>
    </div>
    <div class="checkbox checkbox-theme checkbox-circle">
      <input id="checkbox1" <?php echo (isset($vc_apto_banco) && $vc_apto_banco == 1) ? "checked":"" ?> type="checkbox" value="1" name="banco">
      <label for="checkbox1">
        Apto crédito bancario
      </label>
    </div>
    <div class="checkbox checkbox-theme checkbox-circle">
      <input id="checkbox2" <?php echo (isset($vc_acepta_permuta) && $vc_acepta_permuta == 1) ? "checked":"" ?> type="checkbox" value="1" name="per">
      <label for="checkbox2">
        Acepta Permuta
      </label>
    </div>
    <div class="form-group">
      <button class="search-button">Buscar</button>
    </div>
  </form>
</div>

<script type="text/javascript">
function cambiar_moneda_precio_minimo() {
  var v = $("#moneda_precio_minimo").val();
  $("#moneda_precio_maximo").val(v);
}
function cambiar_moneda_precio_maximo() {
  var v = $("#moneda_precio_maximo").val();
  $("#moneda_precio_minimo").val(v);
}
function enviar_buscador_propiedades() {
  var link = "<?php echo mklink("propiedades/")?>";
  if ($("#checkboxMap").is(":checked")) {
    link = "<?php echo mklink("mapa/")?>";
    document.getElementById("view_hidden").value = "2";
  }
  var tipo_operacion = $("#buscador_tipo_operacion").val();
  var localidad = $("#buscador_localidad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>