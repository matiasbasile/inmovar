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
                  <h3 class="m-t-sm m-b-xs">
                    <%= nombre.ucwords() %> 
                  </h3>
                  <a class="text-azul db fs15"><%= email.toLowerCase() %></a>
                  <% if (!isEmpty(telefono)) { %>
                    <a class="fs15 db"><i class="fa fa-whatsapp"></i> <%= telefono.toLowerCase() %></a>
                  <% } %>
                </div>
                <div class="col-xs-12">
                  <a class="text-link fs14" href="app/#clientes/<%= id %>">
                    Editar información
                  </a>
                </div>
              </div>

              <div class="cb oh mt15 mb15 text-muted">
                <label class="fs14">Asignado a:</label>
                <select id="contacto_ficha_usuarios" class="form-control no-model usuario_asignado">
                  <option value="0">Sin Asignar</option>
                  <% for (var i=0; i< usuarios.length; i++) { %>
                    <% var u = usuarios.models[i] %>
                    <option <%= (u.id == id_usuario)?"selected":"" %> value="<%= u.id %>"><%= u.get("nombre") %></option>
                  <% } %>
                </select>
              </div>

              <div class="acerca_de m-t text-muted">
                <label class="fs14">Estado:</label>
                <div class="form-group">
                  <button class="btn btn-block btn-info mostrar_estado">
                    <%= consulta_tipo %>
                    <span class="material-icons fs18 fr">expand_more</span>
                  </button>
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
              <a href="javascript:void(0)" class="cambiar_tab_grande" data-id="3" role="tab" data-toggle="tab"><i class="material-icons mr5">home</i>
                Propiedades interesadas
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" class="cambiar_tab_grande" data-id="4" role="tab" data-toggle="tab"><i class="material-icons mr5">visibility</i>
                Propiedades vistas
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

            <div class="panel panel-default mt-1">
              <div class="panel-body">
                <div id="contacto_busquedas_guardadas_vacio" style="display:block">
                  <div class="h3 tac" style="padding: 83px 0px;">No existen b&uacute;squedas guardadas</div>
                </div>
                <div id="contacto_busquedas_guardadas" class="table-responsive mb0" style="height: 191px; overflow:auto; display:none">
                  <table class="table table-striped sortable m-b-none default footable">
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

          </div>

          <div id="tab_grande_2" class="tab-pane tab_grande active">
            <div id="contacto_crear_consultas"></div>
            <div class="streamline b-l b-info m-l-lg m-b padder-v fs14"></div>
          </div>

          <div id="tab_grande_3" class="tab-pane tab_grande">

            <div class="panel panel-default mt-1">
              <div class="panel-body">
                <div class="tar">
                  <button class="btn btn-info mb20 buscar_propiedades">Buscar propiedades</button>
                </div>
                <div id="contacto_propiedades_interesadas_vacio" style="display:block">
                  <div class="h3 tac" style="padding: 83px 0px;">No existen propiedades interesadas</div>
                </div>
                <div id="contacto_propiedades_interesadas" class="owl-carousel" style="height: 191px; overflow:auto; display:none"></div>
              </div>
            </div>
          </div>

          <div id="tab_grande_4" class="tab-pane tab_grande">

            <div class="panel panel-default mt-1">
              <div class="panel-body">

                <div id="contacto_propiedades_vistas_vacio" style="display:block">
                  <div class="h3 tac" style="padding: 83px 0px;">No hay registro de propiedades vistas</div>
                </div>
                <div id="contacto_propiedades_vistas" class="table-responsive mb0" style="height: 500px; overflow:auto; display:none">
                  <table class="table table-striped sortable m-b-none default footable">
                    <thead>
                      <tr>
                        <th class="w50 tac"></th>
                        <th>Propiedad</th>
                        <th class="w150">Operación</th>
                        <th class="w150">Caract.</th>
                        <th>Fecha</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>

              </div>
            </div>
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


<script type="text/template" id="contacto_propiedad_vista_item_template">
  <td class="p0 data">
    <% if (!isEmpty(path)) { %>
      <% var prefix = (path.indexOf("http") == 0) ? "" : "/admin/" %>
      <img src="<%= prefix + path %>?t=<%= Math.ceil(Math.random()*10000) %>" class="customcomplete-image br5"/>
    <% } %>
  </td>
  <td class="data">
    <%= nombre %><br/>
    <span class="bold"><%= direccion_completa %></span><br/>
  </td>
  <td class="data">
    <%= moneda %> <%= Number(precio_final).format(0) %>
    <% if (id_tipo_estado != 1) { %>
      <br/><span class="text-info"><%= tipo_estado %></span>
    <% } %>
    <br/>Cod. <%= codigo_completo %>
  </td>
  <td class="data">
    <% if (ambientes > 0) { %><%= ambientes %> Amb.<br/><% } %>
    <% if (banios > 1) { %><%= banios %> Baños<br/><% } %>
    <% if (superficie_total > 0) { %>Sup. <%= superficie_total %> m<sup>2</sup><br/><% } %>
  </td>
  <td class="data"><%= fecha %></td>
</script>

<script type="text/template" id="contacto_edit_template">
  <div class="modal-header">
    <b>Nueva Consulta</b>
    <i class="pull-right cerrar_lightbox fs16 fa fa-times cp"></i>
  </div>
  <form class="modal-body" autocomplete="off">
    <div class="row">
      <div class="col-md-6">    
        <div class="form-group">
          <input type="text" placeholder="Nombre y Apellido" autocomplete="off" id="contacto_cliente_nombre" name="nombre" class="form-control"/>
        </div>
      </div>
      <div class="col-md-6">    
        <div class="form-group">
          <input type="text" placeholder="Email" id="contacto_cliente_email" name="email" class="form-control"/>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <select class="form-control w100" id="contacto_cliente_telefono_prefijo" name="fax">
                <?php include("application/views/templates/custom/paises.php"); ?>
              </select>
            </span>        
            <input type="text" placeholder="Celular" id="contacto_cliente_telefono" name="telefono" class="form-control"/>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <select class="form-control" id="contacto_consulta_tipo" name="tipo">
            <% for (var i=0;i< consultas_tipos.length;i++) { %>
              <% var t = consultas_tipos[i] %>
              <option <%= (t.id == tipo)?"selected":"" %> value="<%= t.id %>"><%= t.nombre %></option>
            <% } %>
          </select>
        </div>  
      </div>
    </div>
    <div class="form-group">
      <div class="input-group">
        <input type="text" disabled placeholder="Interesado en propiedad..." autocomplete="off" id="contacto_propiedad" class="form-control"/>
        <span class="input-group-btn">
          <button data-toggle="tooltip" title="Buscar propiedades" tabindex="-1" type="button" class="btn btn-default buscar_propiedades"><i class="fa fa-search"></i></button>
        </span>        
      </div>
    </div>      
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <div class="input-group">
            <input type="text" placeholder="Fecha" id="contacto_fecha" value="<%= fecha %>" class="form-control" name="fecha_ult_operacion"/>
            <span class="input-group-btn">
              <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>        
          </div>
        </div>
      </div>  
      <div class="col-md-6">
        <div class="form-group">
          <div class="btn-group">
            <label data-id_origen="5" data-toggle="tooltip" title="Email" class="btn btn-default active id_origen"><i class="fa fa-envelope"></i></label>
            <label data-id_origen="4" data-toggle="tooltip" title="Tel&eacute;fono" class="btn btn-default id_origen"><i class="fa fa-phone"></i></label>
            <label data-id_origen="26" data-toggle="tooltip" title="Facebook" class="btn btn-default id_origen"><i class="fa fa-facebook"></i></label>
            <label data-id_origen="24" data-toggle="tooltip" title="Instagram" class="btn btn-default id_origen"><i class="fa fa-instagram"></i></label>
            <label data-id_origen="3" data-toggle="tooltip" title="Personal" class="btn btn-default id_origen"><i class="fa fa-users"></i></label>
            <label data-id_origen="27" data-toggle="tooltip" title="Whatsapp" class="btn btn-default id_origen"><i class="fa fa-whatsapp"></i></label>
          </div>
        </div>
      </div>  
    </div>
    <div class="form-group">
      <textarea id="contacto_texto" name="texto" class="form-control" placeholder="Comentarios sobre la consulta..."></textarea>
    </div>
  </form>
  <div class="modal-footer clearfix">
    <button class="btn guardar pull-right btn-info">Guardar</button>
  </div>
</div>
</script>