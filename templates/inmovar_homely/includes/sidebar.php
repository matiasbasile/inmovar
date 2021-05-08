<div class="widget widget-sidebar sidebar-properties advanced-search">
  <h4><span>Búsqueda Avanzada</span></h4>
  <div class="widget-content box">
    <form onsubmit="return onsubmit_buscador_propiedades()" id="form_propiedades">
      <input type="hidden" id="sidebar_orden" name="orden" value="<?php echo (isset($vc_orden)) ? $vc_orden : -1 ?>">
      <input type="hidden" id="sidebar_offset" name="offset" value="<?php echo (isset($vc_offset)) ? $vc_offset : 12 ?>">
      <div class="form-block border">
        <label for="property-status">Tipo de Operación</label>
        <select id="tipo_operacion" class="border">
          <?php $tipos_operaciones = $propiedad_model->get_tipos_operaciones() ?>
          <option value="todas">Todas</option>
          <?php foreach ($tipos_operaciones as $tp) { ?>
            <option value="<?php echo $tp->link ?>" <?php echo ($vc_link_tipo_operacion == $tp->link)?"selected":"" ?> ><?php echo $tp->nombre ?></option>
          <?php } ?>
        </select>
      </div>


      <div class="form-block border">
        <label for="property-location">Localidad</label>
        <select id="localidad" class="border">
          <?php $localidades = $propiedad_model->get_localidades() ?>
          <option value="todas">Todas</option>
          <?php foreach ($localidades as $l) { ?>
            <option value="<?php echo $l->link ?>" <?php echo ($vc_link_localidad == $l->link)?"selected":"" ?> ><?php echo $l->nombre ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-block border">
        <label for="property-type">Tipo de Propiedad</label>
        <select id="tp" name="tp" class="border">
          <?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades() ?>
          <option value="">Todas</option>

          <?php foreach ($tipos_propiedades as $tp) { ?>
            <option value="<?php echo $tp->id ?>" <?php echo ($vc_id_tipo_inmueble == $tp->id)?"selected":"" ?> ><?php echo $tp->nombre ?></option>
          <?php } ?>
        </select>
      </div>

      <div id="sidebar_precios" class="form-block border">
        <div class="form-group">
          <style type="text/css">
            #moneda_precio_minimo { width: 25%  !important}
            #precio_minimo { width: 75%  !important}
            #moneda_precio_maximo { width: 25%  !important}
            #precio_maximo { width: 75%  !important}
          </style>
          <label>Precio Mínimo</label>
          <?php $divisor = (($vc_link_tipo_operacion == "ventas" && isset($cotizacion_dolar)) ? $cotizacion_dolar : 1); ?>
          <?php $bloque = $vc_precio_maximo / 20; ?>
          <div style="display: inline-flex;width: 100%;">
            <select id="moneda_precio_minimo" onchange="cambiar_moneda_precio_minimo()" name="m">
              <option <?php echo (isset($vc_moneda) && $vc_moneda == "ARS")?"selected":"" ?> value="ARS">$</option>
              <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
            </select>
              <input type="text" id="precio_minimo" value="<?php echo (isset($vc_minimo) ? (($vc_minimo == 0)?"":$vc_minimo) : "") ?>"/> 
              <input type="hidden" id="precio_minimo_oculto" name="vc_minimo" value="<?php echo (isset($vc_minimo) ? (($vc_minimo == 0)?"":$vc_minimo) : "") ?>"/>
            </div>
            <label>Precio Máximo</label>
            <div style="display: inline-flex; width: 100%">
              <select id="moneda_precio_maximo" onchange="cambiar_moneda_precio_maximo()">
                <option <?php echo (isset($vc_moneda) && $vc_moneda == "ARS")?"selected":"" ?> value="ARS">$</option>
                <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
              </select>
              <input type="text" id="precio_maximo" value="<?php echo (isset($vc_minimo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>"/>
              <input type="hidden" id="precio_maximo_oculto" name="vc_maximo" value="<?php echo (isset($vc_maximo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>"/>
            </div>
          
            
            </div>

          </div>

          <div class="form-block border">
            <label for="property-type">Dirección</label>
            <input class="border" name="calle" type="text" value="<?php echo(!empty($vc_calle))?$vc_calle:"" ?>">
          </div>          

          <div class="form-block border">
            <div class="col-lg-6 pl0 ">
              <label>Dormitorios</label>
              <select  name="dm" class="border">
                <?php $dormitorios = $propiedad_model->get_dormitorios() ?>
                <option value="">Todos</option>
                <option <?php echo ($vc_dormitorios == 99)?"selected":"" ?> value="99">Monoambiente</option>
                <?php foreach ($dormitorios as $dm) { ?>
                  <?php if ($dm->dormitorios != 0) {  ?>
                    <option value="<?php echo $dm->dormitorios ?>" <?php echo ($vc_dormitorios == $dm->dormitorios)?"selected":"" ?> ><?php echo $dm->dormitorios ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
            <div class="col-lg-6 pr0">
              <label>Baños</label>
              <select name="bn" class="border">
                <?php $banios = $propiedad_model->get_banios() ?>
                <option value="">Todos</option>
                <?php foreach ($banios as $bn) { ?>
                  <option value="<?php echo $bn->banios ?>" <?php echo ($vc_banios == $bn->banios)?"selected":"" ?> ><?php echo $bn->banios ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-block border">
            <label for="property-type">Búsqueda por código</label>
            <input class="border" name="cod" type="text" value="<?php echo(!empty($vc_codigo))?$vc_codigo:"" ?>">
          </div>

          <div class="form-block border">
            <div class="col-lg-6 col-xs-12 pl0 mb20">
              <input id="apto_banco" class="border fl" type="checkbox" <?php echo (!empty($vc_apto_banco))?"checked":"" ?> name="banco" value="1">
              <label class="fl" for="apto_banco">Apto Crédito</label>
            </div>
            <div class="col-lg-6 col-xs-12 pr0 mb20">
              <input id="acepta_permuta" class="border fl" type="checkbox" <?php echo (!empty($vc_acepta_permuta))?"checked":"" ?> name="per" value="1">
              <label class="fl" for="acepta_permuta">Acepta Permuta</label>
            </div>
          </div>

          <div class="form-block mt20">
            <input type="submit" class="button w100p" value="Buscar propiedades" />
          </div>
        </form>
      </div><!-- end widget content -->
    </div>
    <script type="text/javascript">
      function cambiar_moneda_precio_minimo() {
          var v = $("#moneda_precio_minimo").val();
          $("#moneda_precio_maximo").val(v);
          $("#moneda_precio_maximo_choosen a span").text(v);
        }
        function cambiar_moneda_precio_maximo() {
          var v = $("#moneda_precio_maximo").val();
          $("#moneda_precio_minimo").val(v);
          $("#moneda_precio_minimo_choosen a span").text(v);
        }
    </script>