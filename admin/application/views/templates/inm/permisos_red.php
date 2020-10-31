<script type="text/template" id="permisos_red_template">
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-md-6 col-xs-8">
          <h1>Red Inmovar</h1>
        </div>
        <div class="col-md-6 col-xs-4 tar">
          <a href='javascript:void(0)' class='btn btn-info invitar_colega'>
            <span class="material-icons show-xs">add</span>
            <span class="hidden-xs">&nbsp;&nbsp;Invitá a tu colega&nbsp;&nbsp;</span>
          </a>
        </div>
      </div>
    </div>

    <div class="row">

      <div class="tab-container mb0">
        <ul class="nav nav-tabs nav-tabs-2" role="tablist">
          <li id="buscar_propias_tab" class="buscar_tab active">
            <a href="javascript:void(0)">
              <i class="material-icons">store</i> Inmobiliarias
              <span id="propiedades_total" class="counter">0</span>
            </a>
          </li>
          <li id="buscar_red_tab" class="buscar_tab <%= (window.propiedades_buscar_red == 1)?"active":"" %>">
            <a href="javascript:void(0)">
              <i class="material-icons">share</i> Solicitudes pendientes
              <span id="propiedades_red_total" class="counter">0</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="">
            <div class='oh mb10'>
              
            </div>
            <div class="">
              <table id="permisos_red_tabla" class="table table-striped sortable m-b-none default footable">
                <thead>
                  <tr>
                    <th class="w50"></th>
                    <th>Inmobiliaria</th>
                    <th>Información</th>
                    <th class="tac">Tu Sitio Web</th>
                    <th style="width:130px" class="tac">Red Interna</th>
                  </tr>
                </thead>
                <tbody class="tbody">
                  <% for(var i=0;i< results.length;i++) { %>
                    <% var m = results[i] %>
                    <tr data-id="<%= m.id %>">
                      <td class="p0">
                        <% if (!isEmpty(m.logo)) { %>
                          <img src="/admin/<%= m.logo %>" class="customcomplete-image"/>
                        <% } %>
                      </td>                      
                      <td>
                        <span class="text-dark bold"><%= m.razon_social %></span><br/>
                      </td>
                      <td>
                        <% if (!isEmpty(m.telefono_web)) { %>
                          <a class="enviar_whatsapp" data-telefono="<%= m.telefono_web %>"><%= m.telefono %></a><br/>
                        <% } %>
                        <% if (!isEmpty(m.email)) { %>
                          <a href="mailto:<%= m.email %>"><%= m.email %></a><br/>
                        <% } %>
                        <% if (!isEmpty(m.direccion)) { %><%= m.localidad %><br/><% } %>
                      </td>
                      <td class="tac">
                        <% if (m.bloqueado == 0) { %>
                          <% if (m.permiso_web == 0) { %>
                            <% if (m.permiso_red == 0) { %>
                              <button data-toggle="tooltip" title="Debes activar la red para compartir en tu sitio" class="btn etiqueta desactivo">Desactivado</button>
                            <% } else { %>
                              <% if (m.solicitud_permiso == 0) { %>
                                <button data-id="<%= m.id %>" data-toggle="tooltip" title="Solicita permiso para publicar sus propiedades en tu web" class="btn etiqueta solicitar_permiso">Solicitar permiso</button>
                              <% } else if (m.solicitud_permiso == 1) { %>
                                <% if (m.permiso_web_otra == 1) { %>
                                  <div data-toggle="tooltip" title="Esperando permiso pero compartiendo mis propiedades en su web" class="doble-check">
                                    <span class="material-icons">done</span>
                                    <span class="material-icons text-success">done</span>
                                  </div>
                                <% } else { %>
                                  <div data-toggle="tooltip" title="Esperando permiso" class="doble-check">
                                    <span class="material-icons">done</span>
                                    <span class="material-icons">done</span>
                                  </div>
                                <% } %>
                              <% } %>
                            <% } %>
                          <% } else if (m.permiso_web == 1) { %>
                            <% if (m.permiso_web_otra == 1) { %>
                              <div data-toggle="tooltip" title="Ambos compartiendo en sus webs" class="doble-check">
                                <span class="material-icons text-success">done</span>
                                <span class="material-icons text-success">done</span>
                              </div>
                            <% } else { %>
                              <div data-toggle="tooltip" title="Solo sus propiedades en tu web" class="doble-check">
                                <span class="material-icons text-success">done</span>
                                <span class="material-icons">done</span>
                              </div>
                            <% } %>
                          <% } %>
                        <% } else { %>
                          <button data-toggle="tooltip" title="Comunicate con la otra inmobiliaria para poder compartir" class="btn etiqueta desactivo">Desactivado</button>
                        <% } %>
                      </td>
                      <td class="">
                        <div style="margin: 0 auto">
                          <% if (m.bloqueado == 0) { %>
                            <label data-toggle="tooltip" title="Activo en Red Inmovar" class="i-switch fl m-l-lg">
                              <input type="checkbox" class="permiso_red" data-id="<%= m.id %>" <%= (m.permiso_red == 1)?"checked":"" %>>
                              <i></i>
                            </label>
                          <% } else { %>
                            <label data-toggle="tooltip" title="Comunicate con la otra inmobiliaria para poder compartir" class="i-switch disabled fl m-l-lg">
                              <input type="checkbox" disabled <%= (m.permiso_red == 1)?"checked":"" %>>
                              <i></i>
                            </label>
                          <% } %>                        
                        </div>
                      </td>
                    </tr>
                  <% } %>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</script>

<script type="text/template" id="invitar_colega_template">
  <div class="panel panel-default">
    <div class="panel-heading bold">Invitar a un colega</div>
    <div class="panel-body">
      <div class="form-group">
        <label>Nombre del colega / inmobiliaria</label>
        <input type="text" id="invitar_colega_inmobiliaria" class="form-control no-model">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="text" id="invitar_colega_email" class="form-control no-model">
      </div>
    </div>
    <div class="panel-footer clearfix tar">
      <button class="enviar btn btn-info">Enviar</button>
    </div>
  </div>
</script>