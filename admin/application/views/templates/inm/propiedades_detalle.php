<div class="centrado rform">

  <div class="header-lg">
    <div class="row">
      <div class="col-md-6 col-xs-8">
        <h1>Propiedades</h1>
      </div>
    </div>
  </div>  

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Tipo y operación
          </label>
          <div class="panel-description">Datos sobre la operación del inmueble.</div>
        </div>
      </div>
    </div>
    <div class="panel-body expand" style="display:block">    
      <div class="padder">

        <% if (ID_EMPRESA == 1575) { %>
          <div class="form-group">
            <label class="control-label">Título</label>
            <input <%= (!edicion)?"disabled":"" %> class="form-control" id="propiedad_nombre" value="<%= nombre %>" type="text" name="nombre">
          </div>
        <% } %>

        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">C&oacute;digo</label>
              <div class="input-group">
                <span class="input-group-addon"><%= CODIGO %>-</span>
                <input <%= (!edicion)?"disabled":"" %> type="text" name="codigo" id="propiedad_codigo" value="<%= codigo %>" class="form-control"/>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">Tipo Operacion</label>
                  <select <%= (!edicion)?"disabled":"" %> id="propiedad_tipos_operacion" class="w100p">
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
                  <select <%= (!edicion)?"disabled":"" %> id="propiedad_tipos_inmueble" class="w100p">
                    <% for(var i=0;i< window.tipos_inmueble.length;i++) { %>
                      <% var o = tipos_inmueble[i]; %>
                      <option value="<%= o.id %>" <%= (o.id == id_tipo_inmueble)?"selected":"" %>><%= o.nombre %></option>
                    <% } %>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">Cartel en web</label>
                  <select <%= (!edicion)?"disabled":"" %> id="propiedad_tipos_estado" class="form-control">
                    <% for(var i=0;i< window.tipos_estado.length;i++) { %>
                      <% var o = tipos_estado[i]; %>
                      <option value="<%= o.id %>" <%= (o.id == id_tipo_estado)?"selected":"" %>><%= o.nombre %></option>
                    <% } %>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">Asignado a</label>
                  <div class="input-group">
                    <select <%= (!edicion)?"disabled":"" %> <%= (ID_EMPRESA == 45 && (PERFIL == 106 || PERFIL == 1807) && id != undefined) ? "disabled" : '' %> id="propiedad_usuarios" class="form-control">
                      <option value="0">Seleccione</option>
                      <% for(var i=0;i< window.usuarios.models.length;i++) { %>
                        <% var o = window.usuarios.models[i]; %>
                        <% if (SOLO_USUARIO == 0 || (SOLO_USUARIO == 1 && o.id == ID_USUARIO)) { %>
                          <option value="<%= o.id %>" <%= (o.id == id_usuario)?"selected":"" %>><%= o.get("nombre") %></option>
                        <% } %>
                      <% } %>
                    </select>
                    <span class="input-group-addon"><a href="app/#configuracion/usuarios-perfiles" target="_blank"><i class="material-icons fs16">north_east</i></a></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> 

        <div class="form-group">
          <label class="control-label">Propietario</label>
          <div class="input-group">
            <select id="propiedad_propietarios" style="width: 100%" class="form-control"></select>
            <span class="input-group-addon"><a href="app/#propietarios" target="_blank"><i class="material-icons fs16">north_east</i></a></span>
            <div class="input-group-btn">
              <button type="button" class="btn btn-info nuevo_propietario">+ Agregar</button>
            </div>
          </div>
        </div>        

      </div>

    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Precio
          </label>
          <div class="panel-description">Información sobre el valor y formas de venta.</div>
        </div>
      </div>
    </div>
    <div class="panel-body expand" style="display:block">    
      <div class="padder">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">Valor</label>
              <div class="input-group">
                <div class="input-group-btn">
                  <select <%= (!edicion)?"disabled":"" %> id="propiedad_monedas" class="form-control w80">
                    <% for(var i=0;i< window.monedas.length;i++) { %>
                      <% var o = monedas[i]; %>
                      <option <%= (o.signo == moneda)?"selected":"" %> value="<%= o.signo %>"><%= o.signo %></option>
                    <% } %>
                  </select>                      
                </div>
                <input <%= (!edicion)?"disabled":"" %> id="propiedad_precio_final" value="<%= precio_final %>" type="number" class="form-control number" name="precio_final"/>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">Expensas</label>
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input <%= (!edicion)?"disabled":"" %> id="propiedad_valor_expensas" value="<%= valor_expensas %>" type="number" class="form-control number" name="valor_expensas"/>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">Mostrar</label>
              <select <%= (!edicion)?"disabled":"" %> id="propiedad_publica_precio" class="form-control" name="publica_precio">
                <option <%= (publica_precio == 1) ? "selected" : "" %> value="1">Mostrar precio en la web</option>
                <option <%= (publica_precio == 0) ? "selected" : "" %> value="0">Ocultar precio</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">Últ. actualización</label>
              <input <%= (!edicion)?"disabled":"" %> type="date" name="fecha_publicacion" id="propiedad_fecha_publicacion" value="<%= fecha_publicacion %>" class="form-control"/>
            </div>
          </div>            
        </div>          

        <label class="control-label control-label-sub mt10 mb10">Forma de Venta</label>
        <div class="row">       
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_acepta_permuta" name="acepta_permuta" class="checkbox" value="1" <%= (acepta_permuta == 1)?"checked":"" %> >
                <i></i> Acepta permuta
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_apto_banco" name="apto_banco" class="checkbox" value="1" <%= (apto_banco == 1)?"checked":"" %> >
                <i></i> Apto crédito
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_acepta_financiacion" name="acepta_financiacion" class="checkbox" value="1" <%= (acepta_financiacion == 1)?"checked":"" %> >
                <i></i> Acepta financiación
              </label>
            </div>
          </div>
        </div> 
        <div class="permutas_div <%= (acepta_permuta == 1)?"":"dn" %>">
          <div class="row">
            <div class="col-md-9">
              <label class="control-label control-label-sub mt10 mb10">Opciones de Permuta</label>
            </div>
            <div class="col-md-3 tar">
              <button class="btn btn-info nueva_permuta">+ Agregar</button>
            </div>
          </div>         
          <div id="propiedades_permutas" class="mt10"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp" id="expand_mapa">
          <label class="control-label cp">
            <?php echo lang(array(
              "es"=>"Ubicaci&oacute;n",
              "en"=>"Location",
            )); ?>
          </label>
          <div class="panel-description">
            <?php echo lang(array(
              "es"=>"Indique la direcci&oacute;n de la propiedad.",
              "en"=>"Agregar variantes a productos como talle, color, etc.",
            )); ?>                  
          </div>
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
                <div class="help-block">
                  Puede arrastrar el marcador del mapa para ponerlo en la direccion exacta. 
                  Tambi&eacute;n puede utilizar la vista de Street View, para mostrar el frente de la propiedad.
                </div>
              </div>            
            </div>
            <div class="col-md-7">

              <div class="form-group">
                <label class="control-label">Pais</label>
                <select <%= (!edicion)?"disabled":"" %> id="propiedad_paises" name="id_pais" class="form-control">
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
                    <select <%= (!edicion)?"disabled":"" %> id="propiedad_provincias" name="id_provincia" class="form-control">
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
                    <select <%= (!edicion)?"disabled":"" %> id="propiedad_departamentos" name="id_departamento" class="form-control"></select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Localidad</label>
                    <select <%= (!edicion)?"disabled":"" %> id="propiedad_localidades" name="id_localidad" class="form-control"></select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Barrio</label>
                    <select <%= (!edicion)?"disabled":"" %> class="form-control" name="id_barrio" id="propiedad_barrio"></select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Ubicación</label>
                    <select <%= (!edicion)?"disabled":"" %> name="tipo_ubicacion" id="propiedad_tipo_ubicacion" class="form-control">
                      <option <%= (tipo_ubicacion == 0)?"selected":"" %> value="0">Calle</option>
                      <option <%= (tipo_ubicacion == 1)?"selected":"" %> value="1">Esquina</option>
                      <option <%= (tipo_ubicacion == 2)?"selected":"" %> value="2">Ruta</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <label class="control-label">Calle</label>
                    <input <%= (!edicion)?"disabled":"" %> type="text" name="calle" id="propiedad_calle" value="<%= calle %>" class="form-control"/>
                  </div>
                </div>
              </div>

              <div id="propiedad_detalle_calle" class="row" style="<%= (tipo_ubicacion != 0)?"display:none":"" %>">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Altura</label>
                    <input <%= (!edicion)?"disabled":"" %> type="text" name="altura" id="propiedad_altura" value="<%= altura %>" class="form-control"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Piso</label>
                    <input <%= (!edicion)?"disabled":"" %> type="text" name="piso" id="propiedad_piso" value="<%= piso %>" class="form-control"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Dpto.</label>
                    <input <%= (!edicion)?"disabled":"" %> type="text" name="numero" id="propiedad_numero" value="<%= numero %>" class="form-control"/>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Entre las calles</label>
                    <div class="input-group">
                      <input <%= (!edicion)?"disabled":"" %> type="text" name="entre_calles" id="propiedad_entre_calles" value="<%= entre_calles %>" class="form-control"/>
                      <span class="input-group-addon">y</span>
                      <input <%= (!edicion)?"disabled":"" %> type="text" name="entre_calles_2" id="propiedad_entre_calles_2" value="<%= entre_calles_2 %>" class="form-control"/>
                    </div>  
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Tipo de Acceso</label>
                    <select class="form-control" name="tipo_calle" id="propiedad_tipo_calle">
                      <option <%= (tipo_calle == 0)?"selected":"" %> value="0">Sin especificar</option>
                      <option <%= (tipo_calle == 1)?"selected":"" %> value="1">Asfalto</option>
                      <option <%= (tipo_calle == 2)?"selected":"" %> value="2">Tierra</option>
                      <option <%= (tipo_calle == 3)?"selected":"" %> value="3">Arena</option>
                      <option <%= (tipo_calle == 4)?"selected":"" %> value="4">Ripio</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Mostrar</label>
                    <select <%= (!edicion)?"disabled":"" %> id="propiedad_publica_altura" name="publica_altura" class="form-control">
                      <option <%= (publica_altura == 1)?"selected":"" %> value="1">Dirección exacta</option>
                      <option <%= (publica_altura == 2)?"selected":"" %> value="2">Dirección aproximada</option>
                      <option <%= (publica_altura == 0)?"selected":"" %> value="0">Ocultar dirección</option>
                    </select>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            <?php echo lang(array(
              "es"=>"Caracter&iacute;sticas ",
              "en"=>"Location",
            )); ?>
          </label>
          <div class="panel-description">
            <?php echo lang(array(
              "es"=>"Agregue m&aacute;s datos espec&iacute;ficos de la propiedad, como superficie, cantidad de ambientes, etc.",
              "en"=>"Agregar variantes a productos como talle, color, etc.",
            )); ?>                  
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">

        <label class="control-label control-label-sub">Ambientes</label>

        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label"><%= (ID_EMPRESA == 685)?"Camas":"Ambientes" %></label>
              <input <%= (!edicion)?"disabled":"" %> type="number" min="0" id="propiedad_ambientes" value="<%= ambientes %>" name="ambientes" class="form-control"/>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Dormitorios</label>
              <input <%= (!edicion)?"disabled":"" %> type="number" min="0" id="propiedad_dormitorios" value="<%= dormitorios %>" name="dormitorios" class="form-control"/>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Cocheras</label>
              <input <%= (!edicion)?"disabled":"" %> type="number" min="0" id="propiedad_cocheras" value="<%= cocheras %>" name="cocheras" class="form-control"/>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Ba&ntilde;os</label>
              <input <%= (!edicion)?"disabled":"" %> type="number" min="0" id="propiedad_banios" value="<%= banios %>" name="banios" class="form-control"/>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Antigüedad</label>
              <select <%= (!edicion)?"disabled":"" %> name="nuevo" id="propiedad_antiguedad" class="form-control">
                <option value="0" <%= (nuevo == 0)?"selected":"" %>>-</option>
                <option value="1" <%= (nuevo == 1)?"selected":"" %>>A estrenar</option>
                <option value="2" <%= (nuevo == 2)?"selected":"" %>>Aprox. 2 a&ntilde;os</option>
                <option value="5" <%= (nuevo == 5)?"selected":"" %>>Aprox. 5 a&ntilde;os</option>
                <option value="10" <%= (nuevo == 10)?"selected":"" %>>Aprox. 10 a&ntilde;os</option>
                <option value="20" <%= (nuevo == 20)?"selected":"" %>>Aprox. 20 a&ntilde;os</option>
                <option value="30" <%= (nuevo == 30)?"selected":"" %>>Aprox. 30 a&ntilde;os</option>
                <option value="40" <%= (nuevo == 40)?"selected":"" %>>Aprox. 40 a&ntilde;os</option>
                <option value="50" <%= (nuevo == 50)?"selected":"" %>>Aprox. 50 a&ntilde;os</option>
                <option value="60" <%= (nuevo == 60)?"selected":"" %>>Aprox. 60 a&ntilde;os</option>
                <option value="70" <%= (nuevo == 70)?"selected":"" %>>Aprox. 70 a&ntilde;os</option>
                <option value="80" <%= (nuevo == 80)?"selected":"" %>>Aprox. 80 a&ntilde;os</option>
                <option value="90" <%= (nuevo == 90)?"selected":"" %>>Aprox. 90 a&ntilde;os</option>
                <option value="100" <%= (nuevo == 100)?"selected":"" %>>Aprox. 100 a&ntilde;os</option>
                <option value="200" <%= (nuevo == 200)?"selected":"" %>>M&aacute;s de 100 a&ntilde;os</option>
              </select>
            </div>
          </div>    

          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Orientaci&oacute;n Depto.</label>
              <select <%= (!edicion)?"disabled":"" %> class="form-control" id="propiedad_ubicacion_departamento" name="ubicacion_departamento">
                <option value="" <%= (ubicacion_departamento=="")?"selected":"" %>>-</option>
                <option value="F" <%= (ubicacion_departamento=="F")?"selected":"" %>>Frente</option>
                <option value="C" <%= (ubicacion_departamento=="C")?"selected":"" %>>Contrafrente</option>
                <option value="I" <%= (ubicacion_departamento=="I")?"selected":"" %>>Interno</option>
              </select>
            </div>
          </div>

        </div>          

        <label class="control-label control-label-sub">Superficie</label>

        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Cubierta</label>
              <div class="input-group">                  
                <input <%= (!edicion)?"disabled":"" %> type="text" id="propiedad_superficie_cubierta" name="superficie_cubierta" value="<%= superficie_cubierta %>" class="form-control superficie"/>
                <span class="input-group-addon">m<sup>2</sup></span>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Descubierta</label>
              <div class="input-group">                  
                <input <%= (!edicion)?"disabled":"" %> type="text" id="propiedad_superficie_descubierta" name="superficie_descubierta" value="<%= superficie_descubierta %>" class="form-control superficie"/>
                <span class="input-group-addon">m<sup>2</sup></span>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Semicubierta</label>
              <div class="input-group">                  
                <input <%= (!edicion)?"disabled":"" %> type="text" id="propiedad_superficie_semicubierta" name="superficie_semicubierta" value="<%= superficie_semicubierta %>" class="form-control superficie"/>
                <span class="input-group-addon">m<sup>2</sup></span>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Total</label>
              <div class="input-group">                  
                <input <%= (!edicion)?"disabled":"" %> type="text" id="propiedad_superficie_total" name="superficie_total" value="<%= superficie_total %>" class="form-control"/>
                <span class="input-group-addon">m<sup>2</sup></span>
              </div>                
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Frente</label>
              <div class="input-group">                  
                <input <%= (!edicion)?"disabled":"" %> type="text" id="propiedad_mts_frente" name="mts_frente" value="<%= mts_frente %>" class="form-control"/>
                <span class="input-group-addon">mts.</span>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="control-label">Fondo</label>
              <div class="input-group">                  
                <input <%= (!edicion)?"disabled":"" %> type="text" id="propiedad_mts_fondo" name="mts_fondo" value="<%= mts_fondo %>" class="form-control"/>
                <span class="input-group-addon">mts.</span>
              </div>
            </div>
          </div>
        </div>

        <label class="control-label control-label-sub">Servicios</label>

        <div class="row">       
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_cloacas" name="servicios_cloacas" class="checkbox" value="1" <%= (servicios_cloacas == 1)?"checked":"" %> >
                <i></i> Cloacas
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_agua_corriente" name="servicios_agua_corriente" class="checkbox" value="1" <%= (servicios_agua_corriente == 1)?"checked":"" %> >
                <i></i> Agua Corriente
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_electricidad" name="servicios_electricidad" class="checkbox" value="1" <%= (servicios_electricidad == 1)?"checked":"" %> >
                <i></i> Electricidad
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">            
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_asfalto" name="servicios_asfalto" class="checkbox" value="1" <%= (servicios_asfalto == 1)?"checked":"" %> >
                <i></i> Asfalto
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_gas" name="servicios_gas" class="checkbox" value="1" <%= (servicios_gas == 1)?"checked":"" %> >
                <i></i> Gas Natural
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_aire_acondicionado" name="servicios_aire_acondicionado" class="checkbox" value="1" <%= (servicios_aire_acondicionado == 1)?"checked":"" %> >
                <i></i> Aire Acondicionado
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_telefono" name="servicios_telefono" class="checkbox" value="1" <%= (servicios_telefono == 1)?"checked":"" %> >
                <i></i> Tel&eacute;fono
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_cable" name="servicios_cable" class="checkbox" value="1" <%= (servicios_cable == 1)?"checked":"" %> >
                <i></i> TV Cable
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_internet" name="servicios_internet" class="checkbox" value="1" <%= (servicios_internet == 1)?"checked":"" %> >
                <i></i> WiFi
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_uso_comercial" name="servicios_uso_comercial" class="checkbox" value="1" <%= (servicios_uso_comercial == 1)?"checked":"" %> >
                <i></i> Uso Comercial
              </label>
            </div>
          </div>
        </div>


        <label class="control-label control-label-sub">Amenities</label>

        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_patio" name="patio" class="checkbox" value="1" <%= (patio == 1)?"checked":"" %> >
                <i></i> Patio
              </label>
            </div>
          </div>
          
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_balcon" name="balcon" class="checkbox" value="1" <%= (balcon == 1)?"checked":"" %> >
                <i></i> Balcón
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_terraza" name="terraza" class="checkbox" value="1" <%= (terraza == 1)?"checked":"" %> >
                <i></i> Terraza
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_accesible" name="accesible" class="checkbox" value="1" <%= (accesible == 1)?"checked":"" %> >
                <i></i> Baño accesible
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_parrilla" name="parrilla" class="checkbox" value="1" <%= (parrilla == 1)?"checked":"" %> >
                <i></i> Parrilla
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_piscina" name="piscina" class="checkbox" value="1" <%= (piscina == 1)?"checked":"" %> >
                <i></i> Piscina
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_gimnasio" name="gimnasio" class="checkbox" value="1" <%= (gimnasio == 1)?"checked":"" %> >
                <i></i> Gimnasio
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_vigilancia" name="vigilancia" class="checkbox" value="1" <%= (vigilancia == 1)?"checked":"" %> >
                <i></i> Vigilancia
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_sala_juegos" name="sala_juegos" class="checkbox" value="1" <%= (sala_juegos == 1)?"checked":"" %> >
                <i></i> Sala de juegos
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_ascensor" name="ascensor" class="checkbox" value="1" <%= (ascensor == 1)?"checked":"" %> >
                <i></i> Ascensor
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_lavadero" name="lavadero" class="checkbox" value="1" <%= (lavadero == 1)?"checked":"" %> >
                <i></i> Lavadero
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_living_comedor" name="living_comedor" class="checkbox" value="1" <%= (living_comedor == 1)?"checked":"" %> >
                <i></i> Living comedor
              </label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_permite_mascotas" name="permite_mascotas" class="checkbox" value="1" <%= (permite_mascotas == 1)?"checked":"" %> >
                <i></i> Permite mascotas
              </label>
            </div>
          </div>

        </div>

        <label class="control-label control-label-sub">Descripci&oacute;n</label>
        <div class="form-group">
          <textarea <%= (!edicion)?"disabled":"" %> name="texto" name="propiedad_texto" data-ckeditor="basic" id="propiedad_texto"><%= texto %></textarea>
        </div>          

      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            <?php echo lang(array(
              "es"=>"Multimedia",
              "en"=>"Multimedia",
            )); ?>
          </label>
          <div class="panel-description">
            <?php echo lang(array(
              "es"=>"Agregue galeria de imagenes, videos, etc.",
              "en"=>"Agregue galeria de imagenes, videos, etc.",
            )); ?>                  
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">

        <?php
        multiple_upload(array(
          "name"=>"images",
          "label"=>"Galer&iacute;a de Fotos",
          "url"=>"propiedades/function/save_image/",
          "crop_type"=>(isset($empresa->config["propiedad_galeria_crop_type"]) ? $empresa->config["propiedad_galeria_crop_type"] : 0),
          "width"=>(isset($empresa->config["propiedad_galeria_image_width"]) ? $empresa->config["propiedad_galeria_image_width"] : 800),
          "height"=>(isset($empresa->config["propiedad_galeria_image_height"]) ? $empresa->config["propiedad_galeria_image_height"] : 600),
          "quality"=>(isset($empresa->config["propiedad_galeria_image_quality"]) ? $empresa->config["propiedad_galeria_image_quality"] : 0),
          "upload_multiple"=>true,
        )); ?>

        <% if (ID_EMPRESA == 1575) { %>
          <?php
          multiple_upload(array(
            "name"=>"planos",
            "label"=>"Planos",
            "url"=>"propiedades/function/save_image/",
            "width"=>(isset($empresa->config["propiedad_plano_image_width"]) ? $empresa->config["propiedad_plano_image_width"] : 1200),
            "height"=>(isset($empresa->config["propiedad_plano_image_height"]) ? $empresa->config["propiedad_plano_image_height"] : 600),
            "quality"=>(isset($empresa->config["propiedad_plano_image_quality"]) ? $empresa->config["propiedad_plano_image_quality"] : 0),
          )); ?>
        <% } %>

        <div class="form-group">
          <label class="control-label">Video</label>
          <textarea <%= (!edicion)?"disabled":"" %> id="propiedad_video" style="height:80px;" placeholder="Pegue aqui el codigo del video que desea insertar" class="form-control" name="video"><%= video %></textarea>
        </div>

        <?php
        single_file_upload(array(
          "name"=>"archivo",
          "label"=>"Archivo adjunto",
          "url"=>"/admin/propiedades/function/save_file/",
        )); ?>

        <?php
        single_file_upload(array(
          "name"=>"audio",
          "label"=>"Archivo de audio",
          "url"=>"/admin/propiedades/function/save_file/",
        )); ?>

        <div class="form-group">
          <label class="control-label">Recorrido 3D</label>
          <textarea <%= (!edicion)?"disabled":"" %> id="propiedad_pint" style="height:80px;" placeholder="Pegue aqui el codigo que desea insertar" class="form-control" name="pint"><%= pint %></textarea>
        </div>

      </div>
    </div>
  </div>  

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            <?php echo lang(array(
              "es"=>"Documentacion",
              "en"=>"Documentacion",
            )); ?>
          </label>
          <div class="panel-description">
            <?php echo lang(array(
              "es"=>"Agregue información de la propiedad, formas de la operación, etc.",
              "en"=>"Agregue información de la propiedad, formas de la operación, etc.",
            )); ?>                  
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">

        <label class="control-label control-label-sub">Documentacion de la propiedad</label>
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedades_servicios_escritura" name="servicios_escritura" class="checkbox" value="1" <%= (servicios_escritura == 1)?"checked":"" %> >
                <i></i> Escritura
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_reglamento" name="servicios_reglamento" class="checkbox" value="1" <%= (servicios_reglamento == 1)?"checked":"" %> >
                <i></i> Reglamento
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_plano_obra" name="servicios_plano_obra" class="checkbox" value="1" <%= (servicios_plano_obra == 1)?"checked":"" %> >
                <i></i> Plano Obra
              </label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_plano_ph" name="servicios_plano_ph" class="checkbox" value="1" <%= (servicios_plano_ph == 1)?"checked":"" %> >
                <i></i> Plano PH
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">Fecha Chequeado</label>
              <input <%= (!edicion)?"disabled":"" %> type="date" name="servicios_fecha_chequeado" id="propiedad_servicios_fecha_chequeado" value="<%= servicios_fecha_chequeado %>" class="form-control"/>              
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <label class="control-label">Escritura</label>
            <select class="form-control" name="documentacion_escritura">
              <option value="0">Seleccione</option>         
              <option <%= (documentacion_escritura == 1) ? 'selected' : '' %> value="1">Compraventa</option>  
              <option <%= (documentacion_escritura == 2) ? 'selected' : '' %> value="2">Donación</option>  
              <option <%= (documentacion_escritura == 3) ? 'selected' : '' %> value="3">Parte Indivisa</option>  
              <option <%= (documentacion_escritura == 4) ? 'selected' : '' %> value="4">Fidelcomiso</option>  
              <option <%= (documentacion_escritura == 5) ? 'selected' : '' %> value="5">Tracto Abreviado</option>  
            </select>
          </div>
          <div class="col-md-2">
            <label class="control-label">Estado Parcelario</label>
            <select class="form-control" name="documentacion_estado_parcelario">
              <option value="0">Seleccione</option>         
              <option <%= (documentacion_estado_parcelario == 1) ? 'selected' : '' %> value="1">No lleva</option>  
              <option <%= (documentacion_estado_parcelario == 2) ? 'selected' : '' %> value="2">Lleva</option>  
            </select>
          </div>
          <div class="col-md-2">
            <label class="control-label">Estado</label>
            <select class="form-control" name="documentacion_estado">
              <option value="0">Seleccione</option>         
              <option <%= (documentacion_estado == 1) ? 'selected' : '' %> value="1">Desocupada</option>  
              <option <%= (documentacion_estado == 2) ? 'selected' : '' %> value="2">Ocupada</option> 
              <option <%= (documentacion_estado == 3) ? 'selected' : '' %> value="3">Alquilada</option> 
            </select>
          </div>
          <div class="col-md-3">
            <label class="control-label">Impuesto</label>
            <select class="form-control" name="documentacion_impuesto">
              <option value="0">Seleccione</option>         
              <option <%= (documentacion_impuesto == 1) ? 'selected' : '' %> value="1">Impuesto Transferencia de Inmuebles</option>  
              <option <%= (documentacion_impuesto == 2) ? 'selected' : '' %> value="2">Anticipo de Ganancias</option>  
            </select>
          </div>
          <div class="col-md-3">
            <label class="control-label">Coti</label>
            <select class="form-control" name="documentacion_coti">
              <option value="0">Seleccione</option>         
              <option <%= (documentacion_coti == 1) ? 'selected' : '' %> value="1">Corresponde</option>  
              <option <%= (documentacion_coti == 2) ? 'selected' : '' %> value="2">No Corresponde</option>  
            </select>
          </div>
        </div>
        <label class="control-label control-label-sub mt20">Forma de la Operación</label>
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_reservas" name="servicios_reservas" class="checkbox" value="1" <%= (servicios_reservas == 1)?"checked":"" %> >
                <i></i> Reserva
              </label>
              <br>
              <label class="control-label">Plazo de Reserva (Dias)</label>
              <input name="plazo_reserva" type="number" value="<%= plazo_reserva %>" class="form-control" placeholder="Plazo">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                  <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_boleto" name="servicios_boleto" class="checkbox" value="1" <%= (servicios_boleto == 1)?"checked":"" %> >
                  <i></i> Boleto
              </label>
              <br>
              <label class="control-label">Plazo de Boleto (Dias)</label>
              <input name="plazo_boleto" type="number" value="<%= plazo_boleto %>" class="form-control" placeholder="Plazo">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="i-checks">
                <input <%= (!edicion)?"disabled":"" %> type="checkbox" id="propiedad_servicios_escri_plazo" name="servicios_escri_plazo" class="checkbox" value="1" <%= (servicios_escri_plazo == 1)?"checked":"" %> >
                <i></i> Escritura
              </label>
            <br>
            <label class="control-label">Plazo de Escritura (Dias)</label>
            <input name="plazo_escritura" type="number" value="<%= plazo_escritura %>" class="form-control" placeholder="Plazo">
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>  

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Control de Gastos
          </label>
          <div class="panel-description">Indique los distintos gastos asociados a esta propiedad.</div>
        </div>
      </div>
    </div>    
    <div class="panel-body expand">  
      <div class="padder">  
        <div class="tar">
          <button class="btn btn-info nuevo_gasto">+ Agregar</button>
        </div>
        <div id="propiedad_gastos" class="mt10"></div>
      </div>
    </div>
  </div>

  <% if (ID_EMPRESA == 1575) { %>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="padder">
          <div class="form-group mb0 clearfix expand-link cp">
            <label class="control-label cp">
              <?php echo lang(array(
                "es"=>"Departamentos",
                "en"=>"Departaments",
              )); ?>
            </label>
            <div class="panel-description">
              <?php echo lang(array(
                "es"=>"Agregue datos espec&iacute;ficos de los distintos departamentos o unidades que forman la obra.",
              )); ?>                  
            </div>
          </div>
        </div>
      </div>
      <div class="panel-body expand" style="<%= (departamentos.length>0) ? 'display:block':'' %>">
        <div class="padder">
          <div class="clearfix tar">
            <button <%= (!edicion)?"disabled":"" %> class="btn btn-info nuevo_departamento">+ Agregar</button>
          </div>
          <div id="propiedad_departamentos" class="mt10"></div>
        </div>
      </div>
    </div>
  <% } %>

  <?php 
  $usa_custom = false;
  for($i=1;$i<=10;$i++) {
    if ((isset($empresa->config["propiedad_custom_".$i."_label"])) || (isset($empresa->config["propiedad_custom_".$i."_file"]))) {
      $usa_custom = true;
      break;
    }
  } 
  if ($usa_custom) { ?>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="padder">
          <div class="form-group mb0 clearfix expand-link cp">
            <label class="control-label cp">Información adicional</label>
            <div class="panel-description">Campos específicos de la cuenta.</div>
          </div>
        </div>
      </div>
      <div class="panel-body expand">
        <div class="padder">

          <% if (ID_EMPRESA == 1575) { %>
            <div class="form-group">
              <label class="control-label">Ubicación</label>
              <input <%= (!edicion)?"disabled":"" %> class="form-control" id="propiedad_descripcion_ubicacion" value="<%= descripcion_ubicacion %>" type="text" name="descripcion_ubicacion">
            </div>
          <% } %>

          <div class="row">
            <?php for($i=1;$i<=10;$i++) { ?>

              <?php if (isset($empresa->config["propiedad_custom_".$i."_file"])) { ?>
                
                <div class="col-xs-12">
                  <?php single_file_upload(array(
                    "name"=>"custom_$i",
                    "label"=>$empresa->config["propiedad_custom_".$i."_file"],
                    "url"=>"/admin/propiedades/function/save_file/",
                  )); ?>
                </div>

              <?php } else if (isset($empresa->config["propiedad_custom_".$i."_label"])) { ?>
                <div class="<?php echo (isset($empresa->config['propiedad_custom_'.$i.'_class'])) ? $empresa->config['propiedad_custom_'.$i.'_class'] :'col-xs-12'?>">
                  <div class="form-group">
                    <label class="control-label"><?php echo $empresa->config["propiedad_custom_".$i."_label"] ?></label>
                    <?php if(isset($empresa->config['propiedad_custom_'.$i.'_values'])) { 
                      $values = explode("|",$empresa->config['propiedad_custom_'.$i.'_values']); ?>
                      <select class="form-control" name="custom_<?php echo $i ?>">
                        <?php foreach($values as $value) { ?>
                          <option <%= (<?php echo "custom_".$i ?> == "<?php echo $value ?>")?"selected":""  %> value="<?php echo $value ?>"><?php echo $value ?></option>
                        <?php } ?>
                      </select>
                    <?php } else { ?>
                      <input type="text" name="custom_<?php echo $i ?>" id="propiedad_custom_<?php echo $i ?>" value="<%= custom_<?php echo $i ?> %>" class="form-control"/>
                    <?php } ?>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
          </div>

        </div>
      </div>
    </div>
  

    <div class="panel panel-default">
      <div class="panel-body">
        <div class="padder">
          <div class="form-group mb0 clearfix">
            <label class="control-label">
              <?php echo lang(array(
                "es"=>"SEO",
                "en"=>"SEO",
              )); ?>
            </label>
            <a class="expand-link fr">
              <?php echo lang(array(
                "es"=>"+ Ver opciones",
                "en"=>"+ View options",
              )); ?>
            </a>
            <div class="panel-description">
              <?php echo lang(array(
                "es"=>"Mejore el posicionamiento de su web utilizando las siguientes opciones.",
                "en"=>"Agregar variantes a productos como talle, color, etc.",
              )); ?>                  
            </div>
          </div>
        </div>
      </div>
      <div class="panel-body expand">
        <div class="padder">
          <div class="form-group">
            <label class="control-label">
              <?php echo lang(array(
                "es"=>"T&iacute;tulo",
                "en"=>"Title",
              )); ?>
            </label>
            <label class="control-label fr">
              <span id="propiedad_seo_title_cantidad">0</span>
              <?php echo lang(array(
                "es"=>"de",
                "en"=>"of",
              )); ?>
              <span>70</span>
            </label>
            <input type="text" data-max="70" data-id="propiedad_seo_title_cantidad" name="seo_title" id="propiedad_seo_title" value="<%= seo_title %>" class="form-control text-remain"/>
          </div>
          <div class="form-group">
            <label class="control-label">
              <?php echo lang(array(
                "es"=>"Descripci&oacute;n",
                "en"=>"Description",
              )); ?>
            </label>
            <label class="control-label fr">
              <span id="propiedad_seo_description_cantidad">0</span>
              <?php echo lang(array(
                "es"=>"de",
                "en"=>"of",
              )); ?>
              <span>160</span>
            </label>
            <textarea data-max="160" data-id="propiedad_seo_description_cantidad" name="seo_description" id="propiedad_seo_description" class="form-control text-remain"><%= seo_description %></textarea>
          </div>
          <div class="form-group">
            <label class="control-label">
              <?php echo lang(array(
                "es"=>"C&oacute;digo de seguimiento",
                "en"=>"",
              )); ?>
            </label>
            <textarea name="codigo_seguimiento" id="propiedad_codigo_seguimiento" class="form-control"><%= codigo_seguimiento %></textarea>
          </div>
        </div>
      </div>
    </div>

  <?php } ?>

  <% if (edicion) { %>
    <div class="tar mb30">
      <button class="btn guardar btn-info btn-lg">Guardar</button>
    </div>
  <% } %>

</div>