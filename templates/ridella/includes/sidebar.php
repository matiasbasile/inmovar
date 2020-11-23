
<div class="col-md-3 col-md-push-9 secondary">
  <div class="border-box">
    
    <a href="javascript:void(0)" onclick="abrir_form_propiedades()" class="form-title abrir_form_propiedades">BUSCADOR<?php //echo (isset($vc_link_tipo_operacion)) ? strtoupper($vc_link_tipo_operacion) : "BUSCADOR" ?></a>

    <form id="form_propiedades" onsubmit="return enviar_buscador_propiedades()" method="GET">
      <div class="box-space">
        <input checked type="radio" name="tipo_vista" id="list-view3" />
        <label for="list-view3">Listado <img src="images/list-view-icon.png" alt="List View" /></label>
        <input type="radio" name="tipo_vista" id="map-view" />
        <label for="map-view">Mapa <img src="images/location-icon2.png" alt="Map View" /></label>
      </div>
      <div class="box-space">
        <select id="tipo_operacion" style="display: none">
          <?php $tipos_operaciones = $propiedad_model->get_tipos_operaciones()?>
          <option value="todas">Todas</option>
          <?php foreach ($tipos_operaciones as $t) {  ?>
            <option value="<?php echo $t->link ?>" <?php echo (isset($vc_link_tipo_operacion) && $vc_link_tipo_operacion == $t->link) ? "selected" : "" ?>><?php echo $t->nombre ?></option>
          <?php } ?>
        </select>
        <div class="textbox-title">Localidad</div>
        <select onchange="cambiar_departamentos()" id="departamento" name="dep">
          <option value="todas">Todas</option>
          <?php foreach ($departamentos as $l) {  ?>
            <option value="<?php echo $l->id ?>" <?php echo (isset($vc_id_departamento) && $vc_id_departamento == $l->id) ? "selected" : "" ?>><?php echo $l->nombre ?></option>
          <?php } ?>
        </select>
        <div class="textbox-title">Barrios</div>
        <select id="localidad">
          <option value="todas">Todos</option>
          <?php foreach ($localidades as $l) {  ?>
            <option value="<?php echo $l->link ?>" <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $l->link) ? "selected" : "" ?>><?php echo $l->nombre ?></option>
          <?php } ?>
        </select>
        <div class="textbox-title">Tipo de Propiedad</div>
        <select name="tp">
          <option value="">Todas</option>
          <?php foreach ($tipos_propiedades as $tp) {  ?>
          <option value="<?php echo $tp->id ?>" <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $tp->id) ? "selected" : "" ?>><?php echo $tp->nombre ?></option>
          <?php } ?>
        </select>
        <div class="textbox-title">Dormitorios</div>
        <?php $dormitorios_list = $propiedad_model->get_dormitorios()?>
        <select name="dm">
          <option value="">Todos</option>
          <?php foreach ($dormitorios_list as $d) {  ?>
            <?php if ($d->dormitorios != 0) {  ?>          
             <option <?php echo (isset($vc_dormitorios) && $vc_dormitorios == $d->dormitorios) ? "selected" : "" ?>  value="<?php echo $d->dormitorios?>"><?php echo $d->dormitorios ?> dormitorios</option>
            <?php } ?>
          <?php } ?>
        </select>
        <div class="textbox-title">Baños</div>
        <?php $banios_list = $propiedad_model->get_banios()?>
        <div class="dropdown checkboxes">
          <div class="select">
            <span>Baños</span>
          </div>
          <ul class="dropdown-menu checkboxes">
            <?php foreach ($banios_list as $b) {  ?>
              <li>
                <label>
                  <div class="custom-control custom-checkbox buscador">
                    <input <?php echo (in_array($b->banios, $vc_banios))?"checked":"" ?> value="<?php echo $b->banios ?>" type="checkbox" class="banio custom-control-input" id="banio_<?php echo $b->banios ?>">
                    <label class="custom-control-label" for="tipo_paciente_<?php echo $b->banios ?>"><?php echo $b->banios ?></label>
                  </div>
                </label>
              </li>
            <?php } ?>
          </ul>
        </div>   
        <?php /*     
        <select name="bn">
          <option value="">Todos</option>
          <?php foreach ($banios_list as $b) {  ?>
            <?php if ($b->banios != 0) {  ?>          
              <option <?php echo (isset($vc_banios) && $vc_banios == $b->banios) ? "selected" : "" ?> value="<?php echo $b->banios ?>"><?php echo $b->banios ?></option>
            <?php } ?>
          <?php }?>
        </select>
        */ ?>
      </div>
      <div class="box-space banking-credit">
        <input <?php echo (!empty($vc_apto_banco)) ? "checked" : "" ?> type="checkbox" name="banco" id="ab" />
        <label for="ab">Apto Crédito Bancario</label>
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
              <input class="form-control" id="precio_minimo" type="text" value="<?php echo (isset($vc_minimo) ? (($vc_minimo == 0)?"":$vc_minimo) : "") ?>"/>
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
              <input class="form-control" id="precio_maximo" type="text" value="<?php echo (isset($vc_maximo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>"/>
              <input type="hidden" id="precio_maximo_oculto" name="vc_maximo" value="<?php echo (isset($vc_maximo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>"/>
            </div>
          </div>
        </div>
      </div>
      <div class="box-space">
        <div class="textbox-title">Búsqueda por código</div>
        <input class="form-control" type="text" name="cod" placeholder="Ingrese código" value="<?php echo (!empty($vc_codigo)) ?$vc_codigo : "" ?>" />
        <button type="submit" class="btn btn-red"><img src="images/search-icon2.png" alt="Search" /> Buscar</button>
      </div>
    </form>
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
function cambiar_departamentos() {
  var id_departamento = $("#departamento").val();
  $.ajax({
    "url":"/admin/localidades/function/get_by_departamento/"+id_departamento,
    "dataType":"json",
    "success":function(r){
      $("#localidad").empty();
      $("#localidad").append("<option value='0'>Todos</option>");
      for(var i=0;i<r.results.length;i++) {
        var o = r.results[i];
        $("#localidad").append("<option value='"+o.id+"'>"+o.nombre+"</option>");
      }
    }
  })
}
</script>