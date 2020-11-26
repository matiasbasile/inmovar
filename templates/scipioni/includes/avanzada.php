<div class="sidebar-widget sidebar-avanzada <?php echo ($nombre_pagina == "listado") ? "" : "hidden-sm hidden-xs" ?>">
  <div class="main-title-2">
    <h4>Búsqueda avanzada</h4>
  </div>
  <form id="form_propiedades" onsubmit="return enviar_buscador_propiedades()" method="GET">
    <input type="hidden" id="view_hidden" value="<?php echo (isset($vc_view) ? $vc_view : 0) ?>" name="view"/>

    <div class="form-group">
      <a onclick="ver_lista()" href="javascript:void(0)" class="active mr15" id="ver_lista">
        <i class="fa fa-align-justify mr5"></i>
        Ver en lista
      </a>
      <a onclick="ver_mapa()" href="javascript:void(0)" id="ver_mapa">
        <i class="fa fa-map-marker mr5"></i>
        Ver en mapa
      </a>
    </div>

    <div class="form-group">
      <label>Tipo de operación</label>
      <select id="buscador_tipo_operacion" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
        <option value="todos">Todos</option>
        <?php foreach ($tipos_operaciones as $tipos) {  ?>
          <option <?php echo (isset($vc_tipo_operacion) && strtolower($vc_tipo_operacion) == strtolower($tipos->link))?"selected":"" ?> value="<?php echo $tipos->link ?>"><?php echo $tipos->nombre ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label>Localidad</label>
      <select id="buscador_localidad" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
      <option value="todos">Todas</option>
    <?php foreach ($localidades as $l) {  ?>
      <option <?php echo (isset($vc_link_localidad) && strtolower($vc_link_localidad) == strtolower($l->link))?"selected":"" ?> value="<?php echo $l->link ?>"><?php echo $l->nombre ?></option>
      <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label>Tipo de propiedad</label>
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
            <option <?php echo (isset($vc_dormitorios) && strtolower($vc_dormitorios) == strtolower($dorm->dormitorios)) ? "selected":"" ?> value="<?php echo $dorm->dormitorios ?>"><?php echo $dorm->dormitorios ?></option>
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
            <option <?php echo (isset($vc_banios) && strtolower($vc_banios) == strtolower($b->banios)) ? "selected":"" ?> value="<?php echo $b->banios ?>"><?php echo $b->banios ?></option>
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
            <option <?php echo (isset($vc_cocheras) && strtolower($vc_cocheras) == strtolower($c->cocheras)) ? "selected":"" ?> value="<?php echo $c->cocheras ?>"><?php echo $c->cocheras ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label>Minimo</label><br/>
          <input type="number" name="vc_minimo" value="<?php echo (isset($vc_minimo) ? $vc_minimo : 0) ?>">
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label>Maximo</label><br/>
          <input type="number" name="vc_maximo" value="<?php echo (isset($vc_maximo) ? $vc_maximo : (isset($vc_precio_maximo) ? $vc_precio_maximo : 0)) ?>">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 pr0">
        <div class="checkbox checkbox-theme checkbox-circle">
          <input id="checkbox1" <?php echo (isset($vc_apto_banco) && $vc_apto_banco == 1) ? "checked":"" ?> type="checkbox" value="1" name="banco">
          <label for="checkbox1">
            Apto crédito
          </label>
        </div>
      </div>
      <div class="col-md-6 pl0">
        <div class="checkbox checkbox-theme checkbox-circle">
          <input id="checkbox2" <?php echo (isset($vc_acepta_permuta) && $vc_acepta_permuta == 1) ? "checked":"" ?> type="checkbox" value="1" name="per">
          <label for="checkbox2">
            Acepta permuta
          </label>
        </div>
      </div>
    </div>

      <div class="busqueda-codigo">
        <div class="form-group">
          <label>Búsqueda por código</label><br>
          <input type="text" value="<?php echo (isset($vc_codigo))?$vc_codigo:"" ?>" name="cod">
        </div>
      </div>

    <div class="form-group">
      <button class="search-button">Buscar</button>
    </div>
  </form>
</div>
<script type="text/javascript">
function ver_lista() {
  $("#ver_mapa").removeClass("active");
  $("#ver_lista").addClass("active");
}
function ver_mapa() {
  $("#ver_lista").removeClass("active");
  $("#ver_mapa").addClass("active");
}
function enviar_buscador_propiedades() {
  var link = ($("#ver_lista").hasClass("active")) ? "<?php echo mklink("propiedades/")?>" : "<?php echo mklink("mapa/") ?>";
  var tipo_operacion = $("#buscador_tipo_operacion").val();
  var localidad = $("#buscador_localidad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>