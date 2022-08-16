<div class="col-lg-3 pad-l4">
<div class="rightsidebar custom_select_arrow">
  <?php if (isset($propiedad)) {  ?>
  <div class="first_tab">
    <h5 class="heading_ng">Solicita una visita</h5>
    <div class="btn_tab">
      <input id="contacto_modal_fecha" min="<?php echo date("Y-m-d") ?>" style="width: 53%; padding-left: 10px" type="date" class="btn_emp" value="<?php echo date("Y-m-d") ?>"/>
      <!--<button class="btn_emp"> <img src="images/cal_icon.png" alt="cal_icon"> 22/11/2018</button>-->
      <select id="contacto_modal_hora" style="width: 44%; padding-left: 10px; background-image: none;" class="btn_emp">
        <option>A la mañana</option>
        <option>A la tarde</option>
      </select>
    </div>
    <a class="yellow_btn" href="javascript:abrir_contacto_modal()">Solicita una visita</a>

    <?php if (estaEnFavoritos($propiedad->id)) { ?>
      <a class="btn_emp2 active" rel="nofollow" href="/admin/favoritos/eliminar/?id=<?php echo $propiedad->id; ?>">
        <i class="fa fa-heart" aria-hidden="true"></i>
        Guardado en favoritos
      </a>
    <?php } else { ?>
      <a class="btn_emp2" rel="nofollow" href="/admin/favoritos/agregar/?id=<?php echo $propiedad->id; ?>">
        <i class="fa fa-heart" aria-hidden="true"></i>
        Guardar en lista de favoritos
      </a>
    <?php } ?>

    <ul class="box_footer_btm">
      <li><a href="<?php echo mklink("admin/propiedades/function/ficha/".$propiedad->hash) ?>" rel="nofollow" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> Imprimir Ficha</a></li>
      <li><a href="javascript:void(0)" onclick="enviar_ficha_email()" rel="nofollow"><i class="fa fa-envelope-o" aria-hidden="true"></i> Ficha por Email</a></li>
      
    </ul>
  </div>
<?php } ?>
  <form method="get" onsubmit="return onsubmit_buscador_propiedades()" id="form_propiedades">
    <input type="hidden" id="sidebar_orden" name="orden" value="<?php echo (isset($vc_orden)) ? $vc_orden : -1 ?>">
    <input type="hidden" id="sidebar_offset" name="offset" value="<?php echo (isset($vc_offset)) ? $vc_offset : 12 ?>">
    <div class="side_box">
      <h5 class="heading_ng">Filtros de Búsqueda</h5>
      <ul class="list_locate">
           <li>
            <label class="custom_checkbox">Listado <i class="fa fa-list-ul" aria-hidden="true"></i>
            <input type="radio" <?php echo ($titulo_pagina == "mapa")?"":"checked" ?> value="listado" name="tipo_busqueda">
            <span class="custom_checkmark"></span>
          </label>
        </li>
        <li>
            <label class="custom_checkbox">mapa <i class="fa fa-map-marker" aria-hidden="true"></i>
            <input type="radio" <?php echo ($titulo_pagina == "mapa")?"checked":"" ?> value="mapa" name="tipo_busqueda">
            <span class="custom_checkmark"></span>
          </label>
        </li>
      </ul>
      <div class="list_show_box">
        <div class="select_box_form">
          <div class="form-group">
            <label>Tipo de Operacion</label>
            <select class="form-control-white" id="tipo_operacion">
            <?php $tipos_operaciones = $propiedad_model->get_tipos_operaciones()?>
              <option value="todas">Todas</option>
              <?php foreach ($tipos_operaciones as $t) {  ?>
                <option value="<?php echo $t->link ?>" <?php echo (isset($vc_link_tipo_operacion) && $vc_link_tipo_operacion == $t->link) ? "selected" : "" ?>><?php echo $t->nombre ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Localidad</label>
            <?php $localidades = $propiedad_model->get_localidades(); ?>
            <select class="form-control-white" id="localidad">
              <option value="todas">Todas</option>
              <?php foreach ($localidades as $t) {  ?>
                <option value="<?php echo $t->link ?>" <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $t->link) ? "selected" : "" ?>><?php echo $t->nombre ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Tipo de Propiedad</label>
            <?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
            <select class="form-control-white" name="tp" id="tp">
              <option value="">Todas</option>
              <?php foreach ($tipos_propiedades as $t) {  ?>
                <option value="<?php echo $t->id ?>" <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $t->id) ? "selected " : "" ?>><?php echo $t->nombre ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Dormitorios</label>
            <?php $dormitorios_list = $propiedad_model->get_dormitorios(); ?>
            <select class="form-control-white" name="dm" id="dormitorios">
              <option value="">Todos</option>
              <?php foreach ($dormitorios_list as $t) {  ?>
                <option value="<?php echo $t->dormitorios ?>" <?php echo (isset($vc_dormitorios) && $vc_dormitorios == $t->dormitorios) ? "selected " : "" ?>><?php echo $t->dormitorios ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="checkbx_list">
          <ul>
            <li>
              <label class="custom_checkbox">Balcon 
                <input id="balcon" name="balcon" value="1" <?php echo (isset($vc_tiene_balcon) && $vc_tiene_balcon==1)?"checked":"" ?> type="checkbox">
                <span class="custom_checkmark"></span>
              </label>
            </li>
            <li>
              <label class="custom_checkbox">Frente 
                <input id="tiene_frente" name="tiene_frente" value="1" <?php echo (isset($vc_tiene_frente) && $vc_tiene_frente==1)?"checked":"" ?> type="checkbox">
                <span class="custom_checkmark"></span>
              </label>

            </li>
            <li>
              <label class="custom_checkbox">Cochera 
                <input id="cochera" name="cochera" value="1" <?php echo (isset($vc_tiene_cochera) && $vc_tiene_cochera==1)?"checked":"" ?> type="checkbox">
                <span class="custom_checkmark"></span>
              </label>
            </li>
            <li>
              <label class="custom_checkbox">Contrafrente 
                <input id="tiene_contrafrente" name="tiene_contrafrente" value="1" <?php echo (isset($vc_tiene_contrafrente) && $vc_tiene_contrafrente==1)?"checked":"" ?> type="checkbox">
                <span class="custom_checkmark"></span>
              </label>
            </li>
            <li>
              <label class="custom_checkbox">Patio 
                <input id="patio" name="patio" value="1" <?php echo (isset($vc_tiene_patio) && $vc_tiene_patio==1)?"checked":"" ?> type="checkbox">
                <span class="custom_checkmark"></span>
              </label>
            </li>
            <li>
              <label class="custom_checkbox">Interno 
                <input id="tiene_interno" name="tiene_interno" value="1" <?php echo (isset($vc_tiene_interno) && $vc_tiene_interno==1)?"checked":"" ?> type="checkbox">
                <span class="custom_checkmark"></span>
              </label>
            </li>
          </ul>
        </div>
        <div class="single_check">
          <div class="mb10">
            <label class="custom_checkbox">Apto cr&eacute;dito hipotecario 
              <input type="checkbox" <?php echo (isset($vc_apto_banco) && $vc_apto_banco == 1)?"checked":"" ?> value="1"  name="banco">
              <span class="custom_checkmark"></span>
            </label>
          </div>
          <div class="mb10">
            <label class="custom_checkbox">Recorrido Virtual
              <input type="checkbox" <?php echo (isset($vc_pint) && $vc_pint == 1)?"checked":"" ?> value="1"  name="pint">
              <span class="custom_checkmark"></span>
            </label>
          </div>
          <div class="mb10">
            <label class="custom_checkbox">Video
              <input type="checkbox" <?php echo (isset($vc_video) && $vc_video == 1)?"checked":"" ?> value="1"  name="video">
              <span class="custom_checkmark"></span>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label>Precio Minimo</label>
          <?php $divisor = (($vc_link_tipo_operacion == "alquileres") ? 1 : (isset($cotizacion_dolar) ? $cotizacion_dolar : 1)); ?>
          <?php $bloque = $vc_precio_maximo / 20; ?>
          <select class="form-control-white" name="vc_minimo">
            <?php 
            $cont = 0;
            for($i=0;$i<=20;$i++) { ?>
              <option <?php echo (isset($vc_minimo) && $vc_minimo == $cont) ? "selected":"" ?> value="<?php echo $cont ?>"><?php echo (($divisor>1)?"USD":"$")." ".number_format($cont / $divisor,0) ?></option>
            <?php $cont = $cont + $bloque; } ?>
          </select>
          <label>Precio Maximo</label>
          <select class="form-control-white" name="vc_maximo">
            <?php 
            $cont = 0;
            for($i=0;$i<=20;$i++) { ?>
              <option <?php echo (isset($vc_maximo) && $vc_maximo == $cont) ? "selected":"" ?> value="<?php echo $cont ?>"><?php echo (($divisor>1)?"USD":"$")." ".number_format($cont / $divisor,0) ?></option>
            <?php $cont = $cont + $bloque; } ?>
          </select>
        </div>
        <?php /*
        <div class="price_range">
          <div class="extra-controls form-inline">
            <div class="form-group">
              <p>Precio:</p>
              <span>$</span> <input type="text" name="" class="js-input-from" value="<?php echo (isset($vc_vc_minimo)) ? $vc_minimo : 0 ?>" />
              <span>$</span><input type="text" name="vc_maximo" class="js-input-to" value="<?php echo (isset($vc_maximo)) ? $vc_maximo : $vc_precio_maximo ?>" />
            </div>
          </div>
          <div class="range-slider">
            <input type="text" class="js-range-slider" value="" data-min="0" data-max="<?php echo $vc_precio_maximo ?>" data-from="<?php echo $vc_minimo ?>" data-to="<?php echo $vc_maximo ?>" />
          </div>
        </div>
        */ ?>
        <div class="por_div">
          <label>Busqueda por codigo</label>
          <input class="form-control-white" type="text" name="cod" placeholder="<?php echo (isset($vc_codigo) && !empty($vc_codigo))?$vc_codigo:"Ingrese codigo" ?>">
        </div>
        <div class="btn_submit">
          <input class="yellow_btn1 w100p db" type="submit" value="Buscar" style="cursor: pointer;">
        </div>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
function submit_buscador_propiedades() {
  // Cargamos el offset y el orden en este formulario
  $("#sidebar_orden").val($("#ordenador_orden").val());
  $("#sidebar_offset").val($("#ordenador_offset").val());
  $("#form_propiedades").submit();
}
function onsubmit_buscador_propiedades() { 
  var link = (($("input[name='tipo_busqueda']:checked").val() == "mapa") ? "<?php echo mklink("mapa/")?>" : "<?php echo mklink("propiedades/")?>");
  var tipo_operacion = $("#tipo_operacion").val();
  var localidad = $("#localidad").val();
  var tipo_propiedad = $("#tp").val();
  link = link + tipo_operacion + "/" + localidad + "/<?php echo $vc_params?>";

  $("#form_propiedades").attr("action",link);
  return true;
}
</script>