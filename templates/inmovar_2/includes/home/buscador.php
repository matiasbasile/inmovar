<div class="search-area mb50">
  <div class="container">
    <div class="search-area-inner">
      <div class="search-contents ">

        <form id="form_propiedades" class="buscador-home" onsubmit="return enviar_buscador_propiedades()" method="GET">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Tipo de Operación</label>
                    <select id="tipo_operacion" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar" >
                      <?php $tipos_operaciones = $propiedad_model->get_tipos_operaciones() ?>
                      <option value="todas">Todas</option>
                      <?php foreach ($tipos_operaciones as $tp) { ?>
                        <option value="<?php echo $tp->link ?>"><?php echo $tp->nombre ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Localidad</label>
                    <select id="localidad" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
                      <?php $localidades = $propiedad_model->get_localidades() ?>
                      <option value="todas">Todas</option>
                      <?php foreach ($localidades as $l) { ?>
                        <option value="<?php echo $l->link ?>"><?php echo $l->nombre ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Tipo de Propiedad</label>
                    <select id="tp" name="tp" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
                      <?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades() ?>
                      <option value="">Todas</option>
                      <?php foreach ($tipos_propiedades as $tp) { ?>
                        <option value="<?php echo $tp->id ?>" ><?php echo $tp->nombre ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Direcci&oacute;n</label>
                    <input type="text" class="form-control" name="calle"/>
                  </div>
                </div>                                    
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Dormitorios</label>
                    <select name="dm" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
                      <?php $dormitorios = $propiedad_model->get_dormitorios() ?>
                      <option value="">-</option>
                      <option value="99">Monoambiente</option>
                      <?php foreach ($dormitorios as $dm) { ?>
                        <?php if ($dm->dormitorios != 0) {  ?>
                          <option value="<?php echo $dm->dormitorios ?>"><?php echo $dm->dormitorios ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>                                    
                <div class="col-md-3">
                  <div class="form-group mb10">
                    <label>Código</label>
                    <input type="text" class="form-control mb5" name="cod"/>
                  </div>
                  <div class="mb10 cb w100p oh">
                    <input id="apto_banco" class="border fl" type="checkbox" <?php echo (!empty($vc_apto_banco))?"checked":"" ?> name="banco" value="1">
                    <label class="fl" for="apto_banco">Apto Crédito</label>
                  </div>                    
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <button class="search-button">Buscar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>            
        <!--
        <form id="form_propiedades" class="buscador-home" onsubmit="return enviar_buscador_propiedades()" method="GET">
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <label>Tipo de operación</label>
                <select id="buscador_tipo_operacion" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
                  <option value="todos">Todos</option>
                  <?php foreach ($tipos_operaciones as $tipos) {  ?>
                  <option <?php echo (isset($tipo_operacion) && $tipo_operacion == $tipos->link)?"selected":"" ?>   value="<?php echo $tipos->link ?>"><?php echo $tipos->nombre ?></option>
                  <?php } ?>
                </select>
              </div>  
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <label>Localidades</label>
                <select id="buscador_localidad" class="selectpicker search-fields" data-live-search="true" data-live-search-placeholder="Buscar">
                  <option value="todos">Todas</option>
                  <?php foreach ($localidades as $l) {  ?>
                  <option <?php echo (isset($link_localidad) && $link_localidad == $l->link)?"selected":"" ?> value="<?php echo $l->link ?>"><?php echo $l->nombre ?></option>
                  <?php } ?>
                </select>
              </div> 
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <label>Tipo de propiedad</label>
                <select id="buscador_tipo_propiedad" class="selectpicker search-fields" name="tp" data-live-search="true" data-live-search-placeholder="Buscar" >
                  <option value="0">Todos</option>
                  <?php foreach ($tipos_propiedades as $tipos) { ?>
                  <option <?php echo (isset($tipo_inmueble) && $tipo_inmueble == $tipos->id) ? "selected":"" ?>  value="<?php echo $tipos->id ?>"><?php echo $tipos->nombre ?></option>
                  <?php } ?>
                </select>
              </div>  
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <button class="search-button">Buscar</button>
              </div>
            </div>
          </div>
        </form>
        -->
      </div>
    </div>
  </div>
</div>
