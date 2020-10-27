<div class="wrapper-md">
  <div class="centrado rform">

    <div class="header-lg pt0">
      <div class="row">
        <div class="col-md-6">
          <h1 style="font-size:32px !important">Nueva Búsqueda</h1>
        </div>
      </div>
    </div>    

    <div class="panel panel-default">
      <div class="panel-body">
        <div class="padder">
          <div class="form-group mb0 clearfix expand-link cp">
            <label class="control-label cp">
              Datos de la búsqueda
            </label>
            <div class="panel-description">
              <?php echo lang(array(
                "es"=>"Ingrese los datos de la búsqueda que desea realizar.",
                "en"=>"Agregar variantes a productos como talle, color, etc.",
              )); ?>                  
            </div>
          </div>
        </div>
      </div>
      <div class="panel-body expand" style="display:block">    
        <div class="padder">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Tipo Operacion</label>
                <select id="busqueda_tipos_operacion" class="w100p">
                  <% for(var i=0;i< window.tipos_operacion.length;i++) { %>
                    <% var o = tipos_operacion[i]; %>
                    <option value="<%= o.id %>" <%= (o.id == id_tipo_operacion)?"selected":"" %>><%= o.nombre %></option>
                  <% } %>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Tipo Inmueble</label>
                <select id="busqueda_tipos_inmueble" class="w100p">
                  <% for(var i=0;i< window.tipos_inmueble.length;i++) { %>
                    <% var o = tipos_inmueble[i]; %>
                    <option value="<%= o.id %>" <%= (o.id == id_tipo_inmueble)?"selected":"" %>><%= o.nombre %></option>
                  <% } %>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Valor Desde</label>
                <div class="input-group">
                  <div class="input-group-btn">
                    <select id="busqueda_monedas" class="form-control w80">
                      <% for(var i=0;i< window.monedas.length;i++) { %>
                        <% var o = monedas[i]; %>
                        <option><%= o.signo %></option>
                      <% } %>
                    </select>                      
                  </div>
                  <input id="busqueda_precio_desde" value="<%= precio_desde %>" type="number" class="form-control number" name="precio_desde"/>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Valor Hasta</label>
                <div class="input-group">
                  <div class="input-group-btn">
                    <select id="busqueda_monedas" class="form-control w80">
                      <% for(var i=0;i< window.monedas.length;i++) { %>
                        <% var o = monedas[i]; %>
                        <option><%= o.signo %></option>
                      <% } %>
                    </select>                      
                  </div>
                  <input id="busqueda_precio_hasta" value="<%= precio_hasta %>" type="number" class="form-control number" name="precio_hasta"/>
                </div>
              </div>
            </div>
          </div>

          <label class="control-label control-label-sub mt20">Zona de búsqueda</label>
          <div class="row">
            <div class="col-md-20">
              <div class="form-group">
                <label class="control-label">Pais</label>
                <select id="busqueda_paises" name="id_pais" class="form-control">
                  <% for(var i=0;i< paises.length;i++) { %>
                    <% var p = paises[i] %>
                    <option <%= (id_pais == p.id)?"selected":"" %> value="<%= p.id %>"><%= p.nombre %></option>
                  <% } %>
                </select>
              </div>
            </div>
            <div class="col-md-20">
              <div class="form-group">
                <label class="control-label">Provincia</label>
                <select id="busqueda_provincias" name="id_provincia" class="form-control">
                  <% for(var i=0;i< provincias.length;i++) { %>
                    <% var p = provincias[i] %>
                    <option data-id_pais="<%= p.id_pais %>" <%= (id_provincia == p.id)?"selected":"" %> value="<%= p.id %>"><%= p.nombre %></option>
                  <% } %>
                </select>
              </div>
            </div>
            <div class="col-md-20">
              <div class="form-group">
                <label class="control-label">Departamento / Partido</label>
                <select id="busqueda_departamentos" name="id_departamento" class="form-control"></select>
              </div>
            </div>
            <div class="col-md-20">
              <div class="form-group">
                <label class="control-label">Localidad</label>
                <select id="busqueda_localidades" name="id_localidad" class="form-control"></select>
              </div>
            </div>
            <div class="col-md-20">
              <div class="form-group">
                <label class="control-label">Barrio</label>
                <select class="form-control" name="id_barrio" id="busqueda_barrio"></select>
              </div>
            </div>
          </div>

          <label class="control-label control-label-sub mt20">Forma de Venta</label>
          <div class="row">       
            <div class="col-md-2">
              <div class="form-group">
                <label class="i-checks">
                  <input type="checkbox" id="busqueda_acepta_permuta" name="acepta_permuta" class="checkbox" value="1" <%= (acepta_permuta == 1)?"checked":"" %> >
                  <i></i> Acepta permuta
                </label>
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label class="i-checks">
                  <input type="checkbox" id="busqueda_apto_banco" name="apto_banco" class="checkbox" value="1" <%= (apto_banco == 1)?"checked":"" %> >
                  <i></i> Apto crédito
                </label>
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label class="i-checks">
                  <input type="checkbox" id="busqueda_acepta_financiacion" name="acepta_financiacion" class="checkbox" value="1" <%= (acepta_financiacion == 1)?"checked":"" %> >
                  <i></i> Acepta financiación
                </label>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>

    <div class="tar">
      <button class="btn guardar btn-info btn-lg">Guardar</button>
    </div>

  </div>
</div>