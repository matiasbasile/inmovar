<div class="border-box">
  <div class="form-title">BUSCADOR</div>
  <form class="filter_form" onsubmit="return filtrar(this)" method="get">
    <input type="hidden" name="orden" id="filter_order" value="<?php echo $vc_orden ?>"/>
    <input type="hidden" name="offset" id="filter_offset" value="<?php echo $vc_offset ?>"/>
    <input type="hidden" name="view" id="filter_view" value=""/>
    <div class="box-space">
      <input type="checkbox" id="show-in-list" <?php echo($nombre_pagina!="mapa")?"checked":"" ?> />
      <label for="show-in-list">Listado <img src="images/list-view-icon.png" alt="List View" /></label>
      <input type="checkbox" id="show-in-map" <?php echo($nombre_pagina=="mapa")?"checked":"" ?> />
      <label for="show-in-map">Mapa <img src="images/location-icon2.png" alt="Map View" /></label>
    </div>
    <div class="box-space">
      <div class="textbox-title">Tipo de Operaci&oacute;n</div>
      <select id="tipo_operacion" class="filter_tipo_operacion">
        <?php $filter_tipos_operacion = $propiedad_model->get_tipos_operaciones();
        foreach($filter_tipos_operacion as $r) { ?>
          <option <?php echo (isset($vc_link_tipo_operacion) && $vc_link_tipo_operacion == $r->link) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
        <?php } ?>
      </select>
      <div class="textbox-title">Localidad</div>
      <select id="localidad" class="filter_localidad">
        <option value="0">Todas</option>
        <?php $filter_localidades = $propiedad_model->get_localidades();
        foreach($filter_localidades as $r) { ?>
          <option <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $r->link) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
        <?php } ?>
      </select>
      <div class="textbox-title">Tipo de Propiedad</div>
      <select class="filter_tipo_propiedad" name="tp">
        <option value="0">Todas</option>
        <?php $filter_tipos_propiedades = $propiedad_model->get_tipos_propiedades();
        foreach($filter_tipos_propiedades as $r) { ?>
          <option <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $r->id) ? "selected":"" ?> value="<?php echo $r->id ?>"><?php echo $r->nombre ?></option>
        <?php } ?>
      </select>
      <div class="textbox-title">Dormitorios</div>
      <select class="filter_dormitorios" name="dm">
        <option value="">Todas</option>
        <?php $filter_dormitorios = $propiedad_model->get_dormitorios();
        foreach($filter_dormitorios as $r) { ?>
          <option <?php echo (isset($vc_dormitorios) && $vc_dormitorios == $r->dormitorios) ? "selected":"" ?> value="<?php echo $r->dormitorios ?>"><?php echo $r->dormitorios ?></option>
        <?php } ?>
      </select>
      <div class="textbox-title">Ba&ntilde;os</div>
      <select class="filter_banios" name="bn">
        <option value="">Todas</option>
        <?php $filter_banios = $propiedad_model->get_banios();
        foreach($filter_banios as $r) { ?>
          <option <?php echo (isset($vc_banios) && $vc_banios == $r->banios) ? "selected":"" ?> value="<?php echo $r->banios ?>"><?php echo $r->banios ?></option>
        <?php } ?>
      </select>      
    </div>
    <div class="box-space">
      <input id="filter_apto_credito" type="checkbox" <?php echo (isset($vc_apto_banco) && $vc_apto_banco == 1)?"checked":"" ?> value="1"  name="banco">
      <label for="filter_apto_credito">Apto cr&eacute;dito hipotecario</label>
    </div>
    <div class="box-space">
      <input <?php echo (isset($vc_acepta_permuta) && $vc_acepta_permuta == 1) ? "checked":"" ?> type="checkbox" name="per" value="1" id="filter_acepta_permuta">
      <label for="filter_acepta_permuta">Acepta Permuta</label>
    </div>


    <div class="box-space">
      <div class="textbox-title">Precio Minimo</div>
      <div class="w100p fl cb">
        <div class="row">
          <div class="col-xs-5 pr0">
            <select id="moneda_precio_minimo" onchange="cambiar_moneda_precio_minimo()" name="m">
              <option <?php echo (isset($vc_moneda) && $vc_moneda == "ARS")?"selected":"" ?> value="ARS">$</option>
              <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
            </select>
          </div>
          <div class="col-xs-7 pl0">
            <input class="form-control" style="height: 40px" id="precio_minimo" type="text" value="<?php echo (isset($vc_minimo) ? (($vc_minimo == 0)?"":$vc_minimo) : "") ?>"/>
            <input type="hidden" id="precio_minimo_oculto" name="vc_minimo" value="<?php echo (isset($vc_minimo) ? (($vc_minimo == 0)?"":$vc_minimo) : "") ?>"/>
          </div>
        </div>
      </div>
      <div class="textbox-title">Precio Maximo</div>
      <div class="w100p fl cb">
        <div class="row">
          <div class="col-xs-5 pr0">
            <select id="moneda_precio_maximo" onchange="cambiar_moneda_precio_maximo()">
              <option <?php echo (isset($vc_moneda) && $vc_moneda == "ARS")?"selected":"" ?> value="ARS">$</option>
              <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
            </select>
          </div>
          <div class="col-xs-7 pl0">
            <input class="form-control" style="height: 40px" id="precio_maximo" type="text" value="<?php echo (isset($vc_maximo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>"/>
            <input type="hidden" id="precio_maximo_oculto" name="vc_maximo" value="<?php echo (isset($vc_maximo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>"/>
          </div>
        </div>
      </div>
    </div>
    
    <div class="box-space">
      <div class="textbox-title">B&uacute;squeda por c&oacute;digo</div>
      <input type="text" name="cod" value="<?php echo isset($vc_codigo)?$vc_codigo:"" ?>" placeholder="Ingrese c&oacute;digo" />
      <button type="submit"class="btn btn-blue"><img src="images/search-icon.png" alt="Search" /> Buscar</button>
    </div>
  </form>
</div>
