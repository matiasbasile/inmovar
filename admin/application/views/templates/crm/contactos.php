<script type="text/template" id="contacto_ficha_template">
  <div class="centrado rform pt40">
    <div class="row">
      <div class="col-md-3">

        <div class="panel panel-default">
          <div class="panel-body">
            <div class="">
              <div class="row tac">
                <div class="col-xs-12">
                  <% if (!isEmpty(path)) { %>
                    <img src="/admin/<%= path %>" class="customcomplete-image xl"/>
                  <% } else { %>
                    <span class="avatar xl avatar-texto <%= (activo==1)?'':'bg-light dker' %>">
                      <%= isEmpty(nombre) ? email.substr(0,1).toUpperCase() : nombre.substr(0,1).toUpperCase() %>
                    </span>
                  <% } %>
                </div>
                <div class="col-xs-12">
                  <h3 class="m-t-sm m-b-xs"><%= nombre.ucwords() %> </h3>
                  <a class="text-azul db fs14"><%= email.toLowerCase() %></a>
                  <% if (!isEmpty(telefono)) { %>
                    <a class="fs14 db"><%= telefono.toLowerCase() %></a>
                  <% } %>
                </div>
              </div>

              <div class="cb oh mt5 text-muted">
                <select class="form-control no-model usuario_asignado">
                  <% for (var i=0; i< usuarios.length; i++) { %>
                    <% var u = usuarios.models[i] %>
                    <option <%= (u.id == id_usuario)?"selected":"" %> value="<%= u.id %>"><%= u.get("nombre") %></option>
                  <% } %>
                </select>
              </div>

              <div class="acerca_de m-t">
                <div class="row">
                  <div class="col-xs-8 pr0">
                    <div class="form-group">
                      <button class="btn btn-info mostrar_estado"><%= consulta_tipo %></button>
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="form-group mb0 tar">
                      <a class="btn btn-white" href="app/#clientes/<%= id %>">
                        <i class="fa fa-pencil"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
      <div class="col-md-9">
        
        <div class="tab-container mb0">
          <ul class="nav nav-tabs nav-tabs-2" role="tablist">
            <li class="active">
              <a href="javascript:void(0)" class="cambiar_tab_grande" data-id="2" role="tab" data-toggle="tab"><i class="material-icons mr5">directions_run</i>
                Seguimiento
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" class="cambiar_tab_grande" data-id="1" role="tab" data-toggle="tab"><i class="material-icons mr5">search</i>
                Perfil de búsqueda
              </a>
            </li>
          </ul>
        </div>
        <div class="tab-content">

          <div id="tab_grande_1" class="tab-pane tab_grande">

            <div class="panel panel-default">
              <div id="contacto_propiedades_interesadas_vacio" style="display:block">
                <div class="h3 tac" style="padding: 83px 0px;">No existen propiedades interesadas</div>
              </div>
              <div id="contacto_propiedades_interesadas" class="owl-carousel" style="height: 191px; overflow:auto; display:none"></div>
            </div>

            <div id="contacto_ficha_propiedades"></div>

            <div class="panel panel-default">
              <div id="contacto_busquedas_guardadas_vacio" style="display:block">
                <div class="h3 tac" style="padding: 83px 0px;">No existen b&uacute;squedas guardadas</div>
              </div>
              <div id="contacto_busquedas_guardadas" class="table-responsive mb0" style="height: 191px; overflow:auto; display:none">
                <table class="table table-small table-striped sortable m-b-none default footable">
                  <thead>
                    <tr>
                      <th>Localidades</th>
                      <th>Inmueble</th>
                      <th>Operacion</th>
                      <th>Fecha</th>
                      <th class="w25"></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>            

          </div>

          <div id="tab_grande_4" class="tab-pane tab_grande">
            
          </div>

          <div id="tab_grande_2" class="tab-pane tab_grande active">
            <div id="contacto_crear_consultas"></div>
            <div class="streamline b-l b-info m-l-lg m-b padder-v fs14"></div>
          </div>

          <div id="tab_grande_3" class="tab-pane tab_grande">

          </div>

        </div>
      </div>
    </div>
  </div>
</div>

</script>

<script type="text/template" id="contacto_busqueda_guardada_item_template">
<td><%= localidades %></td>
<td><%= tipos_inmueble %></td>
<td><%= tipos_operacion %></td>
<td><%= fecha %></td>
<td><i class="fa fa-trash cp eliminar_busqueda_guardada"></i></td>
</script>


<script type="text/template" id="contacto_propiedad_interesada_item_template">
<% var imagen = (isEmpty(path)) ? "" : ((path.indexOf("http")==0) ? path : '/admin/'+path) %>
<div class="propiedad_interesada cp" <% if (!isEmpty(imagen)) { %>style="background-image:url('<%= imagen %>')" <% } %>>
  <div class="propiedad_interesada_sombra"></div>
  <a class="propiedad_interesada_titulo" href="javascript:void(0)"><%= nombre %></a>
  <a class="propiedad_interesada_eliminar" href="javascript:void(0)"><i class="fa fa-trash"></i></a>
</div>
</script>


<script type="text/template" id="contacto_edit_template">
<div class="panel panel-default mb0">
  <div class="panel-heading font-bold">
    Nuevo Contacto
    <i class="pull-right cerrar_lightbox fa fa-times cp"></i>
  </div>
  <form class="panel-body" autocomplete="off">
    <div class="form-group">
      <input type="text" placeholder="Nombre y Apellido" autocomplete="off" id="contacto_cliente_nombre" name="nombre" class="form-control"/>
    </div>  
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <input type="text" placeholder="Celular" id="contacto_cliente_telefono" name="telefono" class="form-control"/>
        </div>  
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <input type="text" placeholder="Email" id="contacto_cliente_email" name="email" class="form-control"/>
        </div>  
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        <div class="form-group">
          <div class="input-group">
            <input type="text" placeholder="Fecha" id="contacto_fecha" value="<%= fecha_ult_operacion %>" class="form-control" name="fecha_ult_operacion"/>
            <span class="input-group-btn">
              <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>        
          </div>
        </div>
      </div>  
      <div class="col-xs-6">
        <div class="form-group">
          <div class="btn-group">
            <label data-id_origen="4" data-toggle="tooltip" title="Tel&eacute;fono" class="btn btn-default active btn-info id_origen"><i class="fa fa-phone"></i></label>
            <label data-id_origen="5" data-toggle="tooltip" title="Email" class="btn btn-default id_origen"><i class="fa fa-envelope"></i></label>
            <label data-id_origen="26" data-toggle="tooltip" title="Facebook" class="btn btn-default id_origen"><i class="fa fa-facebook"></i></label>
            <label data-id_origen="3" data-toggle="tooltip" title="Personal" class="btn btn-default id_origen"><i class="fa fa-users"></i></label>
            <label data-id_origen="27" data-toggle="tooltip" title="Whatsapp" class="btn btn-default id_origen"><i class="fa fa-whatsapp"></i></label>
          </div>
        </div>
      </div>  
    </div>
  </form>
  <div class="panel-footer clearfix">
    <button class="cerrar_lightbox btn btn-default">Cerrar</button>
    <button class="btn guardar pull-right btn-success">Guardar</button>
  </div>
</div>
</script>