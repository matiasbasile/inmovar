<% var clase = (activo==1)?"":"text-muted"; %>
<% if (!vista_busqueda) { %>
  <td>
    <input type="hidden" id="<%= id %>_localidad" value="<%= id_localidad %>"/>
    <input type="hidden" id="<%= id %>_tipo_operacion" value="<%= id_tipo_operacion %>"/>
    <input type="hidden" id="<%= id %>_tipo_inmueble" value="<%= id_tipo_inmueble %>"/>
    <label class="i-checks m-b-none">
      <input class="esc check-row" data-img="<%= path %>" data-id_empresa="<%= id_empresa %>" value="<%= id %>" type="checkbox"><i></i>
    </label>
  </td>
<% } %>
<td class="<%= clase %> p0 data">
  <% if (!isEmpty(path)) { %>
    <% var prefix = (path.indexOf("http") == 0) ? "" : "/admin/" %>
    <img src="<%= prefix + path %>?t=<%= Math.ceil(Math.random()*10000) %>" class="customcomplete-image br5"/>
  <% } %>
</td>
<td class="<%= clase %> data">
  <% if (ID_EMPRESA == 1575) { %>
    <%= nombre %>
  <% } else { %>
    <%= tipo_inmueble %> en <%= tipo_operacion %><br/>
    <span class="bold"><%= direccion_completa %></span><br/>
    <%= localidad %>
  <% } %>
  <% if (id_empresa != ID_EMPRESA && incluye_comision_35 == 1) { %>
    <br/><span class="btn etiqueta">Incluye 3% Comisión</span>
  <% } %>
</td>
<td class="<%= clase %> data">
  <%= tipo_operacion %><br/>
  <%= moneda %> <%= Number(precio_final).format(0) %>
  <% if (id_tipo_estado != 1) { %>
    <br/><span class="text-info"><%= tipo_estado %></span>
  <% } %>
  <br/>Cod. <%= codigo_completo %>
</td>
<td class="<%= clase %> data">
  <% if (ambientes > 0) { %><%= ambientes %> Amb.<br/><% } %>
  <% if (banios > 1) { %><%= banios %> Baños<br/><% } %>
  <% if (superficie_total > 0) { %>Sup. <%= superficie_total %> m<sup>2</sup><br/><% } %>
</td>
<% if (!seleccionar) { %>

  <?php // MIS PROPIEDADES ?>
  <% if (id_empresa == ID_EMPRESA) { %>
    <% if (!vista_busqueda) { %>
      <td class="vam">
        <div class="dropdown">
          <% var esta_compartida = (!isEmpty(permalink) || !isEmpty(olx_id) || inmobusquedas_habilitado == 1 || argenprop_habilitado == 1 || eldia_habilitado == 1) ? 1 : 0 %>
          
          <button class="btn etiqueta btn-menu-compartir">
            <%= (esta_compartida==1)?"Compartida":"Sin Difundir" %>
          </button>

          <div class="menu-compartir">
            <div class="dt">

              <div class="dtr">
                <div class="dtc menu-compartir-logo facebook tac">
                  <% if (compartida_facebook == 1) { %>
                    <img src="/admin/resources/images/facebook.png" data-toggle="tooltip" title="Compartir en Facebook"/>
                  <% } else { %>
                    <img src="/admin/resources/images/facebook_d.png" data-toggle="tooltip" title="Compartir en Facebook"/>
                  <% } %>
                </div>
                <div class="dtc menu-compartir-nombre">
                  <span class="facebook">Facebook</span>
                </div>
                <div class="dtc menu-compartir-submenu">
                </div>
              </div>

              <% if (typeof DOMINIO != "undefined" && !isEmpty(DOMINIO) && (typeof ML_ACCESS_TOKEN != "undefined")) { %>
                <div class="dtr">
                  <div class="dtc menu-compartir-logo tac">
                    <% if (isEmpty(ML_ACCESS_TOKEN)) { %>
                      <img src="/admin/resources/images/ML-Off.png" data-toggle="tooltip" class="compartir_meli" title="Compartir en MercadoLibre"/>
                    <% } else { %>
                      <% if (typeof permalink != "undefined" && !isEmpty(permalink)) { %>
                        <div style="position: relative;">
                          <img src="/admin/resources/images/ML-On.png" data-toggle="tooltip" title="Compartido en MercadoLibre"/>
                          <% if (status == 'active') { %>
                            <b style="position: absolute; bottom: -5px; right: -5px; font-size: 7px" class="badge bg-success pull-right"><i class="fa fa-play"></i></b>
                          <% } else if (status == 'paused') { %>
                            <b style="position: absolute; bottom: -5px; right: -5px; font-size: 7px" class="badge bg-danger pull-right"><i class="fa fa-pause"></i></b>
                          <% } else if (status == 'closed') { %>
                            <b style="position: absolute; bottom: -5px; right: -5px; font-size: 7px" class="badge bg-danger pull-right"><i class="fa fa-times"></i></b>
                          <% } %>
                        </div>
                      <% } else { %>
                        <img src="/admin/resources/images/ML-Off.png" data-toggle="tooltip" class="compartir_meli" title="Compartir en MercadoLibre"/>
                      <% } %>
                    <% } %>
                  </div>
                  <div class="dtc menu-compartir-nombre">
                    <span class="compartir_meli">MercadoLibre</span>
                  </div>
                  <div class="dtc menu-compartir-submenu">
                    <div class="btn-group dropdown ml10">
                      <i title="Opciones" class="iconito fa fa-caret-down dropdown-toggle menu-compartir-submenu-dropdown" data-toggle="dropdown"></i>
                      <ul class="dropdown-menu pull-right">
                        <li><a target="_blank" href="<%= permalink %>">Ver publicacion</a></li>
                        <% if (status == 'paused') { %>
                          <li><a class="compartir_meli" data-id_meli="<%= id_meli %>" href="javascript:void(0)">Modificar</a></li>
                          <li><a class="meli_reactivar" data-id_meli="<%= id_meli %>" href="javascript:void(0)">Reactivar</a></li>
                          <li><a class="meli_finalizar" data-id_meli="<%= id_meli %>" href="javascript:void(0)">Finalizar</a></li>
                        <% } else if (status == 'active') { %>
                          <li><a class="compartir_meli" data-id_meli="<%= id_meli %>" href="javascript:void(0)">Modificar</a></li>
                          <li><a class="meli_pausar" data-id_meli="<%= id_meli %>" href="javascript:void(0)">Pausar</a></li>
                        <% } else if (status == 'closed') { %>
                          <li><a class="meli_eliminar" data-id_meli="<%= id_meli %>" href="javascript:void(0)">Eliminar</a></li>
                        <% } %>
                      </ul>
                    </div>
                  </div>
                </div>
              <% } %>

              <div class="dtr">
                <div class="dtc menu-compartir-logo tac">
                  <% if (olx_habilitado == 0) { %>
                    <img src="/admin/resources/images/OLX-Off.png" data-toggle="tooltip" class="compartir_olx" title="Compartir en OLX"/>
                  <% } else { %>
                    <div style="position: relative;">
                      <% if (isEmpty(olx_id)) { %>
                        <img src="/admin/resources/images/OLX-On.png" data-toggle="tooltip" title="Esperando aprobacion de OLX"/>
                        <b style="position: absolute; bottom: -5px; right: -5px; font-size: 7px" class="badge bg-warning pull-right"><i class="fa fa-clock-o"></i></b>
                      <% } else { %>
                        <img src="/admin/resources/images/OLX-On.png" data-toggle="tooltip" title="Compartido en OLX"/>
                        <b style="position: absolute; bottom: -5px; right: -5px; font-size: 7px" class="badge bg-success pull-right"><i class="fa fa-play"></i></b>
                      <% } %>
                    </div>
                  <% } %>
                </div>
                <div class="dtc menu-compartir-nombre">
                  <span class="compartir_olx">OLX</span>
                </div>
                <div class="dtc menu-compartir-submenu">
                  <div class="btn-group dropdown ml10">
                    <i title="Opciones" class="iconito fa fa-caret-down dropdown-toggle menu-compartir-submenu-dropdown" data-toggle="dropdown"></i>
                    <ul class="dropdown-menu pull-right">
                      <% if (!isEmpty(olx_id)) { %>
                        <li><a target="_blank" href="https://www.olx.com.ar/iid-<%= olx_id %>">Ver publicacion</a></li>
                      <% } %>
                      <li><a class="compartir_olx" href="javascript:void(0)">Dejar de compartir</a></li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="dtr">
                <div class="dtc menu-compartir-logo tac">
                  <div style="position: relative;">
                    <img src="<%= (inmobusquedas_habilitado==1)?"/admin/resources/images/inmobusquedas.png":"/admin/resources/images/inmobusquedas_d.png" %>" data-toggle="tooltip" class="<%= (inmobusquedas_habilitado==0) ? "inmobusquedas_habilitado":"" %>" title="<%= (inmobusquedas_habilitado==0)? "Compartir en Inmobusqueda": ((isEmpty(inmobusquedas_url))?"Revisar informacion":"Compartido correctamente") %>"/>
                    <% if (inmobusquedas_habilitado==1 && !isEmpty(inmobusquedas_url)) { %>
                      <b style="position: absolute; bottom: -5px; right: -5px; font-size: 7px" class="badge bg-success pull-right"><i class="fa fa-play"></i></b>
                    <% } else if (inmobusquedas_habilitado==1 && isEmpty(inmobusquedas_url)) { %>
                      <b style="position: absolute; bottom: -5px; right: -5px; font-size: 7px" class="badge bg-danger pull-right"><i class="fa fa-times"></i></b>
                    <% } %>
                  </div>
                </div>
                <div class="dtc menu-compartir-nombre">
                  <span class="inmobusquedas_habilitado">Inmobusqueda</span>
                </div>
                <div class="dtc menu-compartir-submenu">
                  <div class="btn-group dropdown ml10">
                    <i title="Opciones" class="iconito fa fa-caret-down dropdown-toggle menu-compartir-submenu-dropdown" data-toggle="dropdown"></i>
                    <ul class="dropdown-menu pull-right">
                      <% if (!isEmpty(inmobusquedas_url)) { %>
                        <li><a target="_blank" href="https://www.inmobusqueda.com.ar/ficha-<%= inmobusquedas_url %>">Ver publicacion</a></li>
                      <% } %>
                      <li><a class="inmobusquedas_habilitado" href="javascript:void(0)">Dejar de compartir</a></li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="dtr">
                <div class="dtc menu-compartir-logo tac">
                  <div style="position: relative;">
                    <img src="<%= (argenprop_habilitado >= 1)?"/admin/resources/images/argenprop.png":"/admin/resources/images/argenprop_d.png" %>" data-toggle="tooltip" class="argenprop_habilitado" title="<%= (argenprop_habilitado==1)? "Compartido en Argenprop":"Compartir en Argenprop" %>"/>
                    <% if (argenprop_habilitado==1) { %>
                      <b style="position: absolute; bottom: -5px; right: -5px; font-size: 7px" class="badge bg-success pull-right"><i class="fa fa-play"></i></b>
                    <% } else if (argenprop_habilitado > 1) { %>
                      <b style="position: absolute; bottom: -5px; right: -5px; font-size: 7px" class="badge bg-danger pull-right"><i class="fa fa-times"></i></b>
                    <% } %>
                  </div>
                </div>
                <div class="dtc menu-compartir-nombre">
                  <span class="argenprop_habilitado">Argenprop</span>
                </div>
                <div class="dtc menu-compartir-submenu">
                  <% if (!isEmpty(argenprop_url)) { %>
                    <div class="btn-group dropdown ml10">
                      <i title="Opciones" class="iconito fa fa-caret-down dropdown-toggle menu-compartir-submenu-dropdown" data-toggle="dropdown"></i>
                      <ul class="dropdown-menu pull-right">
                        <li><a target="_blank" href="<%= argenprop_url %>">Ver publicacion</a></li>
                        <li><a class="argenprop_habilitado" href="javascript:void(0)">Actualizar datos</a></li>
                        <% if (argenprop_habilitado == 1) { %>
                          <li><a class="argenprop_pausar" href="javascript:void(0)">Pausar</a></li>
                        <% } else if (argenprop_habilitado > 1) { %>
                          <li><a class="argenprop_activar" href="javascript:void(0)">Activar</a></li>
                        <% } %>
                        <li><a class="argenprop_eliminar" href="javascript:void(0)">Eliminar</a></li>
                      </ul>
                    </div>
                  <% } %>
                </div>
              </div>

              <div class="dtr">
                <div class="dtc menu-compartir-logo tac">
                  <img src="<%= (eldia_habilitado==1)?"/admin/resources/images/eldia.png":"/admin/resources/images/eldia_d.png" %>" data-toggle="tooltip" class="eldia_habilitado" title="<%= (eldia_habilitado==1)? "Compartido en Diario El Dia":"Compartir en Diario El Dia" %>"/>
                </div>
                <div class="dtc menu-compartir-nombre">
                  <span class="eldia_habilitado">Diario El Dia</span>
                </div>
                <div class="dtc menu-compartir-submenu">
                </div>
              </div>

            </div>
          </div>
        </div>
      </ul>

      <td class="tar td_acciones">
        
        <i <%= (!edicion)?"disabled":"" %> data-toggle="tooltip" title="Activa en mi Web" class="fa-check iconito fa activo <%= (activo == 1)?"active":"" %>"></i>
        <i <%= (!edicion)?"disabled":"" %> data-toggle="tooltip" title="Destacado" class="fa fa-star iconito warning destacado <%= (destacado == 1)?"active":"" %>"></i>

        <i <%= (!edicion)?"disabled":"" %> data-toggle="tooltip" title="Compartida en Red Inmovar" class="fa fa-share-alt iconito compartida <%= (compartida >= 1)?"active":"" %>"></i>
        <i <%= (!edicion)?"disabled":"" %> data-toggle="tooltip" title="Compartida en Webs de colegas" class="fa fa-globe iconito compartida_2 <%= (compartida == 2)?"active":"" %>"></i>

        <div class="fr btn-group dropdown ml10">
          <i title="Opciones" class="iconito text-muted-2 fa fa-caret-down dropdown-toggle" data-toggle="dropdown"></i>
          <ul class="dropdown-menu pull-right">
            <li><a href="javascript:void(0)" class="editar"><i class="text-muted-2 fa fa-pencil w25"></i> Editar</a></li>
            <li class="divider"></li>
            <li><a href="javascript:void(0)" class="ver_interesados"><i class="text-muted-2 fa fa-users w25"></i> Ver interesados</a></li>
            <li><a href="javascript:void(0)" class="buscar_interesados"><i class="text-muted-2 fa fa-search w25"></i> Buscar interesados</a></li>
            <li class="divider"></li>
            <li><a href="javascript:void(0)" class="ver_ficha_web" data-id="<%= id %>"><i class="text-muted-2 fa fa-file w25"></i> Ver ficha web</a></li>
            <li><a href="javascript:void(0)" class="ver_ficha" data-id="<%= id %>"><i class="text-muted-2 fa fa-file w25"></i> Ver ficha hoja A4</a></li>
            <li><a href="<%= link_completo %>" target="_blank"><i class="text-muted-2 fa fa-globe w25"></i> Ver en web</a></li>

            <% if (control.check("propiedades") == 3) { %>
              <li class="divider"></li>
              <li><a href="javascript:void(0)" class="duplicar" data-id="<%= id %>"><i class="text-muted-2 fa fa-files-o w25"></i> Duplicar</a></li>
              <li><a href="javascript:void(0)" class="eliminar" data-id="<%= id %>"><i class="text-muted-2 fa fa-times w25"></i> Eliminar</a></li>
            <% } %>
          </ul>
        </div>

        <?php /*
        <% if (id_empresa == ID_EMPRESA) { %>
          <div class="cb oh mt5">
            <span class="material-icons fs16 fl mr5">person</span>
            <select style="background-color:transparent;border:none;padding:0px;font-size:13px;margin-top:2px" class="no-model usuario_asignado fl">
              <option value="0">Seleccione</option>
              <% for(var i=0;i< window.usuarios.models.length;i++) { %>
                <% var o = window.usuarios.models[i]; %>
                <% if (SOLO_USUARIO == 0 || (SOLO_USUARIO == 1 && o.id == ID_USUARIO)) { %>
                  <option value="<%= o.id %>" <%= (o.id == id_usuario)?"selected":"" %>><%= o.get("nombre") %></option>
                <% } %>
              <% } %>
            </select>
          </div>
        <% } %>
        */ ?>

      </td>
    <% } %>

  <% } else { %>

    <?php // PROPIEDADES DE LA RED ?>
    <td>
      <div class="dt">
        <div class="dtc vam">
          <% if (!isEmpty(logo_inmobiliaria)) { %>
            <img src="<%= logo_inmobiliaria %>" class="customcomplete-image" style="border-radius:100%; width: 64px; height:64px;border:1px solid #eaeff0"/>
          <% } %>
        </div>
        <div class="dtc vam pl10">
          <b class="text-dark"><%= inmobiliaria %></b>
        </div>
      </div>
    </td>
    <% if (!vista_busqueda) { %>
      <td>
        <% if (permiso_web == 1) { %>
          <% if (bloqueado_web == 1) { %>
            <div data-toggle="tooltip" title="Compartida en web" class="doble-check fl bloqueado_web">
              <span class="material-icons text-danger">clear</span>
            </div>
          <% } else { %>
            <div data-toggle="tooltip" title="Compartida en web" class="doble-check fl bloqueado_web">
              <span class="material-icons text-success">done</span>
              <span class="material-icons text-success">done</span>
            </div>
          <% } %>
        <% } else { %>
          <div data-toggle="tooltip" title="No compartida en web" class="doble-check fl">
            <span class="material-icons text-success">done</span>
            <span class="material-icons">done</span>
          </div>
        <% } %>

        <div class="fr btn-group dropdown ml10">
          <i title="Opciones" class="iconito text-muted-2 fa fa-caret-down dropdown-toggle" data-toggle="dropdown"></i>
          <ul class="dropdown-menu pull-right">
            <li><a href="javascript:void(0)" class="ver_ficha_web" data-id="<%= id %>"><i class="text-muted-2 fa fa-file w25"></i> Ver ficha web</a></li>
            <li><a href="javascript:void(0)" class="ver_ficha" data-id="<%= id %>"><i class="text-muted-2 fa fa-file w25"></i> Ver ficha hoja A4</a></li>
            <% if (permiso_web == 1) { %>
              <li><a href="<%= link_completo %>?em=<%= id_empresa %>" target="_blank"><i class="text-muted-2 fa fa-globe w25"></i> Ver en web</a></li>
            <% } %>
          </ul>
        </div>

      </td>
    <% } %>

  <% } %>
<% } %>
