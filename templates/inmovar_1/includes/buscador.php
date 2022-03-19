<form onsubmit="return filtrar(this)" method="get" role="form" id="form_propiedades" class="<?php echo ($nombre_pagina=="home")?"form-map":"" ?> form-search">
  <?php if ($nombre_pagina == "home") { ?><h2>Buscador</h2><?php } ?>

  <input type="hidden" name="orden" value="<?php echo $vc_orden ?>" id="orden_hidden">

  <div class="form-group oh">
    <input value="<?php echo mklink("propiedades/") ?>" <?php echo ($nombre_pagina != "mapa")?"checked":"" ?> type="radio" name="tipo_vista" id="list-view">
    <label for="list-view">Listado</label>
    <input value="<?php echo mklink("mapa/") ?>" <?php echo ($nombre_pagina == "mapa")?"checked":"" ?> type="radio" name="tipo_vista" id="map-view">
    <label for="map-view">Mapa</label>
  </div>  

  <div class="form-group" id="buscador-codigo">
    <input type="text" id="filter_codigo" class="form-control filter_codigo" name="cod" value="<?php echo isset($vc_codigo)?$vc_codigo:"" ?>" placeholder="Buscar por c&oacute;digo" />
  </div>
  <div class="form-group" id="buscador-tipo-operacion">
    <select id="tipo_operacion" class="filter_tipo_operacion">
      <?php $filter_tipos_operacion = $propiedad_model->get_tipos_operaciones();
      foreach($filter_tipos_operacion as $r) { ?>
        <option <?php echo (isset($vc_id_tipo_operacion) && $vc_id_tipo_operacion == $r->id) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
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
  <div class="form-group" id="buscador-antiguedad">
    <select class="filter_antiguedad" name="antiguedad">
      <option value="0">Antig&uuml;edad</option>
      <option value="1" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==1)?"selected":"" ?>>A estrenar</option>
      <option value="2" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==2)?"selected":"" ?>>2 a&ntilde;os</option>
      <option value="5" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==5)?"selected":"" ?>>5 a&ntilde;os</option>
      <option value="10" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==10)?"selected":"" ?>>10 a&ntilde;os</option>
      <option value="20" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==20)?"selected":"" ?>>20 a&ntilde;os</option>
      <option value="30" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==30)?"selected":"" ?>>30 a&ntilde;os</option>
      <option value="40" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==40)?"selected":"" ?>>40 a&ntilde;os</option>
      <option value="50" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==50)?"selected":"" ?>>50 a&ntilde;os</option>
      <option value="60" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==60)?"selected":"" ?>>60 a&ntilde;os</option>
      <option value="70" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==70)?"selected":"" ?>>70 a&ntilde;os</option>
      <option value="80" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==80)?"selected":"" ?>>80 a&ntilde;os</option>
      <option value="90" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==90)?"selected":"" ?>>90 a&ntilde;os</option>
      <option value="100" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==100)?"selected":"" ?>>100 a&ntilde;os</option>
      <option value="200" <?php echo (isset($vc_antiguedad)&&$vc_antiguedad==200)?"selected":"" ?>>M&aacute;s de 100 a&ntilde;os</option>
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
  </div><!-- /.form-group -->
</form>
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
  var link = $("input[name='tipo_vista']:checked").val();
  var tipo_operacion = $("#tipo_operacion").val();
  var localidad = $("#localidad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>