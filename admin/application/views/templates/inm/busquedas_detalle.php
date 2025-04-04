<div class="wrapper-md">
  <div class="centrado rform">

    <div class="header-lg pt0">
      <div class="row">
        <div class="col-md-6">
          <% if (edicion) { %>
            <h1 style="font-size:32px !important">Nueva Búsqueda</h1>
          <% } else { %>
            <h1 style="font-size:32px !important">Búsqueda Activa</h1>
          <% } %>
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
            <% if (edicion) { %>
              <div class="panel-description">
                Cargá los datos de la propiedad que estás buscando, y se les notificará a los demás colegas de la red. <br/>Recordá que las búsquedas permanecen activas durante 3 días.
              </div>
            <% } %>
          </div>
        </div>
      </div>
      <div class="panel-body expand" style="display:block">    
        <div class="padder">
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label class="control-label">Tipo Operacion</label>
                <select <%= (!edicion)?"disabled":"" %> id="busqueda_tipos_operacion" class="w100p">
                  <% for(var i=0;i< window.tipos_operacion.length;i++) { %>
                    <% var o = tipos_operacion[i]; %>
                    <option value="<%= o.id %>" <%= (o.id == id_tipo_operacion)?"selected":"" %>><%= o.nombre %></option>
                  <% } %>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label class="control-label">Tipo Inmueble</label>
                <select <%= (!edicion)?"disabled":"" %> id="busqueda_tipos_inmueble" class="w100p">
                  <% for(var i=0;i< window.tipos_inmueble.length;i++) { %>
                    <% var o = tipos_inmueble[i]; %>
                    <option value="<%= o.id %>" <%= (o.id == id_tipo_inmueble)?"selected":"" %>><%= o.nombre %></option>
                  <% } %>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Entre los valores</label>
                <div class="input-group">
                  <div class="input-group-btn">
                    <select <%= (!edicion)?"disabled":"" %> id="busqueda_monedas" class="form-control w80">
                      <% for(var i=0;i< window.monedas.length;i++) { %>
                        <% var o = monedas[i]; %>
                        <option value="<%= o.signo %>" value="<%= (moneda == o.signo) ? "selected":"" %>"><%= o.signo %></option>
                      <% } %>
                    </select>                      
                  </div>
                  <span class="dib w50p pl5">
                    <input <%= (!edicion)?"disabled":"" %> id="busqueda_precio_desde" value="<%= precio_desde %>" type="number" class="form-control number" name="precio_desde"/>
                  </span>
                  <span class="dib w50p pl5">
                    <input <%= (!edicion)?"disabled":"" %> id="busqueda_precio_hasta" value="<%= precio_hasta %>" type="number" class="form-control number" name="precio_hasta"/>
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label">Descripción de la búsqueda</label>
            <textarea <%= (!edicion)?"disabled":"" %> placeholder="Ej: acepta otra propiedad en forma de pago, etc." class="form-control h100" name="texto" id="busqueda_texto"><%= texto %></textarea>
          </div>
        </div>

      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-body">
        <div class="padder">
          <div class="form-group mb0 clearfix expand-link cp" id="expand_mapa">
            <label class="control-label cp">
              Zona de búsqueda
            </label>
            <% if (edicion) { %>
              <div class="panel-description">
                Indicá la ubicación aproximada de la propiedad que estás buscando.
              </div>
            <% } %>
          </div>
        </div>
      </div>
      <div class="panel-body expand" id="mapa_expandable">
        <div class="padder">

          <div class="row">
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <div style="height:380px;" class="mb10" id="mapa"></div>
                  <% if (edicion) { %>
                    <div class="help-block">
                      Podés arrastrar el marcador del mapa para ponerlo en la direccion exacta. 
                    </div>
                  <% } %>
                </div>
              </div>
              <div class="col-md-7">

                <div class="form-group">
                  <label class="control-label">Pais</label>
                  <select <%= (!edicion)?"disabled":"" %> id="busqueda_paises" name="id_pais" class="form-control">
                    <% for(var i=0;i< paises.length;i++) { %>
                      <% var p = paises[i] %>
                      <option <%= (id_pais == p.id)?"selected":"" %> value="<%= p.id %>"><%= p.nombre %></option>
                    <% } %>
                  </select>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Provincia</label>
                      <select <%= (!edicion)?"disabled":"" %> id="busqueda_provincias" name="id_provincia" class="form-control">
                        <% for(var i=0;i< provincias.length;i++) { %>
                          <% var p = provincias[i] %>
                          <option data-id_pais="<%= p.id_pais %>" <%= (id_provincia == p.id)?"selected":"" %> value="<%= p.id %>"><%= p.nombre %></option>
                        <% } %>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Departamento / Partido</label>
                      <select <%= (!edicion)?"disabled":"" %> id="busqueda_departamentos" name="id_departamento" class="form-control"></select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Localidad</label>
                      <select <%= (!edicion)?"disabled":"" %> id="busqueda_localidades" name="id_localidad" class="form-control"></select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Barrio</label>
                      <select <%= (!edicion)?"disabled":"" %> class="form-control" name="id_barrio" id="busqueda_barrio"></select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label">Calle</label>
                  <input <%= (!edicion)?"disabled":"" %> type="text" name="calle" id="busqueda_calle" value="<%= calle %>" class="form-control"/>
                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <% if (edicion) { %>
      <div class="tar">
        <button class="btn guardar btn-info btn-lg">Guardar</button>
      </div>
    <% } %>

  </div>
</div>