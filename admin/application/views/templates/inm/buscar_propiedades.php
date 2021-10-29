<div class="panel-heading pt15 clearfix">
  <div class="row">

    <div class="col-md-3 col-sm-6 col-xs-12 mh50 pr5 pl5">
      <div class="form-group">
        <input value="<%= window.propiedades_filter %>" type="text" id="propiedades_buscar" placeholder="Buscar..." autocomplete="off" class="form-control">
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12 mh50 pr5 pl5">
      <div class="form-group">
        <div class="input-group">
          <select multiple="multiple" class="form-control no-model" id="propiedades_buscar_localidades"></select>
          <span class="input-group-btn">
            <div class="btn-group dropdown pull-right">
              <button class="btn btn-default dropdown-toggle btn-addon" data-toggle="dropdown">
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <% for (var i=0;i< window.localidades.length; i++) { %>
                  <% var localidad = window.localidades[i] %>
                  <li><a href="javascript:void(0)" data-id="<%= localidad.id %>" data-nombre="<%= localidad.nombre %>" class="setear_localidad"><%= localidad.nombre %> (<%= localidad.cantidad %>)</a></li>
                <% } %>
              </ul>
            </div>
          </span>
        </div>
      </div>
    </div>

    <div class="col-md-2 col-sm-6 col-xs-12 mh50 pr5 pl5">
      <div class="form-group">
        <select style="width: 100%" id="propiedades_buscar_tipos_operacion">
          <% for(var i=0;i< window.tipos_operacion.length;i++) { %>
            <% var o = tipos_operacion[i]; %>
            <option <%= (window.propiedades_id_tipo_operacion == o.id)?"selected":"" %> value="<%= o.id %>"><%= o.nombre %></option>
          <% } %>
        </select>
      </div>
    </div>    

    <div class="col-md-2 col-sm-6 col-xs-12 mh50 pr5 pl5">
      <div class="form-group">
        <select style="width: 100%" id="propiedades_buscar_tipos_inmueble">
          <% for(var i=0;i< window.tipos_inmueble.length;i++) { %>
            <% var o = tipos_inmueble[i]; %>
            <option <%= (window.propiedades_id_tipo_inmueble == o.id)?"selected":"" %> value="<%= o.id %>"><%= o.nombre %></option>
          <% } %>
        </select>    
      </div>
    </div>

    <div class="col-md-2 col-sm-6 col-xs-12 mh50 pr5 pl5">
      <div class="input-group">
        <span class="input-group-btn">
          <button class="btn-advanced-search m-l mt10 advanced-search-btn"><i class="fa fa-plus-circle"></i><span><?php echo lang(array("es"=>"M&aacute;s Filtros","en"=>"More Filters")); ?></span></button>
        </span>
      </div>
    </div>

  </div>
</div>
<% var display = (window.propiedades_id_tipo_inmueble != 0 || window.propiedades_id_tipo_estado != 0 || window.propiedades_id_tipo_operacion != 0 || (window.propiedades_id_localidad != 0 && window.propiedades_id_localidad != null) || !isEmpty(window.propiedades_filter) || !isEmpty(window.propiedades_direccion) || !isEmpty(window.propiedades_monto) || window.propiedades_apto_banco == 1 || window.propiedades_acepta_permuta == 1 || !isEmpty(window.propiedades_dormitorios) || !isEmpty(window.propiedades_banios) || !isEmpty(window.propiedades_compartida_en) ) ? "display:block" : "display:none" %>
<div class="advanced-search-div bg-light dk" style="<%= display %>">
  <div class="wrapper clearfix">
    <div class="row pl10 pr10">

      <?php /*
      <div class="col-md-3 dn col-sm-6 col-xs-12 h50 pr5 pl5">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button data-toggle="tooltip" title="Apto para cr&eacute;dito hipotecario" id="propiedades_buscar_apto_banco" class="btn btn-default <%= (window.propiedades_apto_banco == 1)?'btn-info':'' %>">
                <i class="fa fa-bank"></i>
              </button>
            </span>
            <span class="input-group-btn">
              <button data-toggle="tooltip" title="Acepta permuta" id="propiedades_buscar_acepta_permuta" class="btn btn-default ml0 <%= (window.propiedades_acepta_permuta == 1)?'btn-info':'' %>">
                <i class="fa fa-exchange"></i>
              </button>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12 h50 pr5 pl5">
        <div class="form-group">
          <input type="text" class="form-control no-model" id="propiedades_buscar_codigo" placeholder="Código de propiedad">
        </div>
      </div>
      */ ?>

      <div class="col-md-3 col-sm-6 col-xs-12 h50 pr5 pl5">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <div class="btn-group dropdown ml0">
                <button class="btn btn-default dropdown-toggle btn-addon" data-toggle="dropdown">
                  <span id="propiedades_buscar_monto_moneda"><%= window.propiedades_monto_moneda %></span>
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)" class="setear_moneda">U$D</a></li>
                  <li><a href="javascript:void(0)" class="setear_moneda">$</a></li>
                </ul>
              </div>
            </span>
            <span class="input-group-btn w40p pr5">
              <input type="text" value="<%= window.propiedades_monto %>" placeholder="Desde" id="propiedades_buscar_monto" class="form-control no-model">
            </span>
            <input type="text" value="<%= window.propiedades_monto_2 %>" placeholder="Hasta" id="propiedades_buscar_monto_2" class="form-control no-model">
          </div>
        </div>
      </div>

      <div class="col-md-2 col-sm-6 col-xs-12 mh50 pr5 pl5">
        <div class="form-group">
          <div class="input-group">
            <select multiple="multiple" class="form-control no-model" id="propiedades_buscar_dormitorios"></select>
            <span class="input-group-btn">
              <div class="btn-group dropdown pull-right">
                <button class="btn btn-default dropdown-toggle btn-addon" data-toggle="dropdown">
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)" data-id="1" data-nombre="1" class="setear_dormitorio">1</a></li>
                  <li><a href="javascript:void(0)" data-id="2" data-nombre="2" class="setear_dormitorio">2</a></li>
                  <li><a href="javascript:void(0)" data-id="3" data-nombre="3" class="setear_dormitorio">3</a></li>
                  <li><a href="javascript:void(0)" data-id="4" data-nombre="4" class="setear_dormitorio">4</a></li>
                  <li><a href="javascript:void(0)" data-id="5" data-nombre="5" class="setear_dormitorio">5</a></li>
                  <li><a href="javascript:void(0)" data-id="6" data-nombre="6" class="setear_dormitorio">6</a></li>
                  <li><a href="javascript:void(0)" data-id="7" data-nombre="7" class="setear_dormitorio">Más</a></li>
                </ul>
              </div>
            </span>
          </div>
        </div>
      </div>

      <div class="col-md-2 col-sm-6 col-xs-12 mh50 pr5 pl5">
        <div class="form-group">
          <div class="input-group">
            <select multiple="multiple" class="form-control no-model" id="propiedades_buscar_banios"></select>
            <span class="input-group-btn">
              <div class="btn-group dropdown pull-right">
                <button class="btn btn-default dropdown-toggle btn-addon" data-toggle="dropdown">
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)" data-id="1" data-nombre="1" class="setear_banio">1</a></li>
                  <li><a href="javascript:void(0)" data-id="2" data-nombre="2" class="setear_banio">2</a></li>
                  <li><a href="javascript:void(0)" data-id="3" data-nombre="3" class="setear_banio">3</a></li>
                  <li><a href="javascript:void(0)" data-id="4" data-nombre="4" class="setear_banio">4</a></li>
                  <li><a href="javascript:void(0)" data-id="5" data-nombre="5" class="setear_banio">5</a></li>
                  <li><a href="javascript:void(0)" data-id="6" data-nombre="6" class="setear_banio">6</a></li>
                  <li><a href="javascript:void(0)" data-id="7" data-nombre="7" class="setear_banio">Más</a></li>
                </ul>
              </div>
            </span>
          </div>
        </div>
      </div>

      <div class="col-md-2 col-sm-6 col-xs-12 mh50 pr5 pl5">
        <div class="form-group">
          <div class="input-group">
            <select multiple="multiple" class="form-control no-model" id="propiedades_buscar_cocheras"></select>
            <span class="input-group-btn">
              <div class="btn-group dropdown pull-right">
                <button class="btn btn-default dropdown-toggle btn-addon" data-toggle="dropdown">
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)" data-id="1" data-nombre="1" class="setear_cochera">1</a></li>
                  <li><a href="javascript:void(0)" data-id="2" data-nombre="2" class="setear_cochera">2</a></li>
                  <li><a href="javascript:void(0)" data-id="3" data-nombre="3" class="setear_cochera">3</a></li>
                  <li><a href="javascript:void(0)" data-id="4" data-nombre="4" class="setear_cochera">Más</a></li>
                </ul>
              </div>
            </span>
          </div>
        </div>
      </div>

      <div class="col-md-2 col-sm-3 col-xs-12 h50 pr5 pl5">
        <div class="form-group">
          <select style="width: 100%" id="propiedades_buscar_tipos_estado">
            <% for(var i=0;i< window.tipos_estado.length;i++) { %>
              <% var o = tipos_estado[i]; %>
              <option <%= (window.propiedades_id_tipo_estado == o.id)?"selected":"" %> value="<%= o.id %>"><%= o.nombre %></option>
            <% } %>
          </select>
        </div>
      </div>
    </div>

    <div class="row pl10 pr10">

      <div class="col-md-2 col-sm-3 col-xs-12 h50 pr5 pl5">
        <div class="form-group">
          <select id="propiedad_usuarios" class="form-control">
            <option value="0">Vendedor</option>
            <% for(var i=0;i< window.usuarios.models.length;i++) { %>
              <% var o = window.usuarios.models[i]; %>
              <option <%= (window.propiedades_id_usuario == o.id) ? 'selected' : '' %>value="<%= o.id %>"><%= o.get("nombre") %></option>
            <% } %>
          </select>
        </div>
      </div>

      <div class="col-sm-4 col-xs-12 h50 pr5 pl5">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <input type="text" class="form-control no-model" value="<%= window.propiedades_direccion %>" id="propiedades_buscar_direccion" placeholder="Calle" />
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <div class="input-group">
                <input type="text" id="propiedades_entre_calles" placeholder="Entre calle" value="<%= window.propiedades_entre_calles %>" class="form-control no-model"/>
                <span class="input-group-addon">y</span>
                <input type="text" id="propiedades_entre_calles_2" placeholder="calle" value="<%= window.propiedades_entre_calles_2 %>" class="form-control no-model"/>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-3 col-xs-12 h50 pr5 pl5">
        <div class="form-group">
          <select class="form-control" id="propiedades_buscar_propietarios"></select>
        </div>
      </div>

      <div class="col-md-2 col-sm-3 col-xs-12 h50 pr5 pl5">
        <div class="form-group">
          <select class="form-control" id="propiedades_buscar_compartida_en">
            <option <%= (window.propiedades_compartida_en == "")?"selected":"" %> value="">Compartida en</option>
            <optgroup label="Red Inmovar">
              <option <%= (window.propiedades_compartida_en == "red")?"selected":"" %> value="red">Compartidas en Red Inmovar</option>
              <option <%= (window.propiedades_compartida_en == "no_red")?"selected":"" %> value="no_red">No compartidas en Red Inmovar</option>
            </optgroup>
            <optgroup label="Web">
              <option <%= (window.propiedades_compartida_en == "web")?"selected":"" %> value="web">Activas en web</option>
              <option <%= (window.propiedades_compartida_en == "no_web")?"selected":"" %> value="no_web">No activas en web</option>
            </optgroup>
            <optgroup label="MercadoLibre">
              <option <%= (window.propiedades_compartida_en == "meli")?"selected":"" %> value="meli">Compartidas en MercadoLibre</option>
              <option <%= (window.propiedades_compartida_en == "no_meli")?"selected":"" %> value="no_meli">No compartidas en MercadoLibre</option>
            </optgroup>
            <optgroup label="OLX">
              <option <%= (window.propiedades_compartida_en == "olx")?"selected":"" %> value="olx">Compartidas en OLX</option>
              <option <%= (window.propiedades_compartida_en == "no_olx")?"selected":"" %> value="no_olx">No compartidas en OLX</option>
            </optgroup>
            <optgroup label="Inmobusqueda">
              <option <%= (window.propiedades_compartida_en == "inmobusquedas")?"selected":"" %> value="inmobusquedas">Compartidas en Inmobusqueda</option>
              <option <%= (window.propiedades_compartida_en == "no_inmobusquedas")?"selected":"" %> value="no_inmobusquedas">No compartidas en Inmobusqueda</option>
            </optgroup>
            <optgroup label="Argenprop">
              <option <%= (window.propiedades_compartida_en == "argenprop")?"selected":"" %> value="argenprop">Compartidas en Argenprop</option>
              <option <%= (window.propiedades_compartida_en == "no_argenprop")?"selected":"" %> value="no_argenprop">No compartidas en Argenprop</option>
            </optgroup>
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-12 h50 pr5 pl5 mostrar_en_red" style="<%= (window.propiedades_buscar_red == 1)?'display:block':'display:none' %>">
        <select style="width: 100%" id="propiedades_buscar_inmobiliarias">
          <option value="0">Inmobiliaria</option>
          <% for(var i=0;i< window.empresas.length;i++) { %>
            <% var o = empresas[i] %>
            <option <%= (window.propiedades_buscar_red_empresa == o.id)?"selected":"" %> value="<%= o.id %>"><%= o.nombre %></option>
          <% } %>
        </select>        
      </div>
      
      <div class="col-md-2 col-sm-3 col-xs-12 h50 pr5 pl5">
        <button data-toggle="tooltip" title="Ver como lista" id="propiedades_ver_lista" class="btn btn-default <%= (window.propiedades_mapa == 0)?'btn-info':'' %>">
          <i class="fa fa-list"></i>
        </button>
        <button data-toggle="tooltip" title="Ver como mapa" id="propiedades_ver_mapa" class="btn btn-default <%= (window.propiedades_mapa == 1)?'btn-info':'' %>">
          <i class="fa fa-map-marker"></i>
        </button>
      </div>

    </div>
    
  </div>
</div>