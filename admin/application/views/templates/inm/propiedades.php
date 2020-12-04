<script type="text/template" id="propiedades_resultados_template">
<% if (vista_busqueda) { %>
  <div class="modal-header">
    <b>Buscar propiedades</b>
    <i class="pull-right cerrar_lightbox fs16 fa fa-times cp"></i>
  </div>
  <div class="modal-body">
    
    <?php include("buscar_propiedades.php") ?>

    <div class="tab-container mb0">
      <ul class="nav nav-tabs nav-tabs-2" role="tablist">
        <?php include("tabs_propiedades.php") ?>
      </ul>
      <div class="tab-content">
        <div class="table-responsive">
          <table id="propiedades_tabla" class="table table-striped sortable m-b-none default footable">
            <thead>
              <tr>
                <th class="w50 tac"></th>
                <th>Propiedad</th>
                <th class="w150 sorting" data-sort-by="precio_final">Operación</th>
                <th class="w150">Caract.</th>
              </tr>
            </thead>
            <tbody class="tbody"></tbody>
            <tfoot class="pagination_container hide-if-no-paging"></tfoot>
          </table>
        </div>
      </div>
      <div class="bulk_action tar m-t">
        <div class="dib m-r">
          <p><b class="cantidad_seleccionados"></b> elementos seleccionados</p>  
        </div>
        <button class="btn btn-default marcar_interes">Marcar Inter&eacute;s</button>
        <button class="btn btn-info enviar">Enviar fichas por email</button>
        <button class="btn btn-success enviar_whatsapp">Enviar Whatsapp</button>
      </div>
    </div>

  </div>
<% } else { %>

  <div class="centrado rform">

    <% if (!seleccionar) { %>

      <?php //include("historias.php"); ?>

      <div class="header-lg">
        <div class="row">
          <div class="col-md-6 col-xs-8">
            <h1>Propiedades</h1>
          </div>
          <div class="col-md-6 col-xs-4 tar">
            <% if (permiso > 1) { %>
              <a class="btn btn-info" href="app/#propiedades/0">
                <span class="material-icons show-xs">add</span>
                <span class="hidden-xs">&nbsp;&nbsp;Nueva Propiedad&nbsp;&nbsp;</span>
              </a>
            <% } %>
          </div>
        </div>
      </div>
    <% } %>

    <div class="tab-container mb0">
      <ul class="nav nav-tabs nav-tabs-2" role="tablist">
        <?php include("tabs_propiedades.php") ?>
      </ul>
    </div>

    <div class="panel panel-default">

      <?php include("buscar_propiedades.php") ?>
      <% if (!seleccionar) { %>
        <div class="bulk_action wrapper pb0">
          <p><b class="cantidad_seleccionados"></b> elementos seleccionados</p>
          <button class="btn btn-default enviar btn-addon"><i class="icon fa fa-send"></i>Enviar fichas por email</button>
          <div class="btn-group dropdown">
            <button class="btn btn-default btn-addon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon fa fa-share-alt"></i>Red Inmovar
            </button>
            <ul class="dropdown-menu">
              <li><a href="javascript:void(0)" class="compartir_red_multiple">Compartir</a></li>
              <li><a href="javascript:void(0)" class="no_compartir_red_multiple">No Compartir</a></li>
            </ul>
          </div> 
        </div>
      <% } %>

      <div class="panel-body pb0">

        <div style="height:500px;display:<%= (window.propiedades_mapa == 1)?"block":"none" %>" id="propiedades_mapa"></div>

        <div id="propiedades_tabla_cont" class="table-responsive">
          <table id="propiedades_tabla" class="table <%= (seleccionar)?'table-small':'' %> table-striped sortable m-b-none default footable">
            <thead>
              <tr>
                <th style="width:20px;">
                  <label class="i-checks m-b-none">
                    <input class="esc sel_todos" type="checkbox"><i></i>
                  </label>
                </th>
                <th class="w50 tac"></th>
                <th>Propiedad</th>
                <th class="w150 sorting" data-sort-by="precio_final">Operación</th>
                <th class="w150">Caract.</th>
                <th></th>
                <th class="th_acciones w150">Acciones</th>
              </tr>
            </thead>
            <tbody class="tbody"></tbody>
            <tfoot class="pagination_container hide-if-no-paging"></tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
<% } %>
</script>

<script type="text/template" id="propiedades_item_resultados_template">
  <% var clase = (activo==1)?"":"text-muted"; %>
  <% if (!vista_busqueda) { %>
    <td>
      <input type="hidden" id="<%= id %>_localidad" value="<%= id_localidad %>"/>
      <input type="hidden" id="<%= id %>_tipo_operacion" value="<%= id_tipo_operacion %>"/>
      <input type="hidden" id="<%= id %>_tipo_inmueble" value="<%= id_tipo_inmueble %>"/>
      <label class="i-checks m-b-none">
        <input class="esc check-row" value="<%= id %>" type="checkbox"><i></i>
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
    <%= tipo_inmueble %> en <%= tipo_operacion %><br/>
    <span class="bold"><%= direccion_completa %></span><br/>
    <%= localidad %>
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
  <% if (!seleccionar && !vista_busqueda) { %>

    <?php // MIS PROPIEDADES ?>
    <% if (id_empresa == ID_EMPRESA) { %>
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
                        <% if (argenprop_habilitado == 1) { %>
                          <li><a class="argenprop_pausar" href="javascript:void(0)">Pausar</a></li>
                        <% } else if (argenprop_habilitado > 1) { %>
                          <li><a class="argenprop_activar" href="javascript:void(0)">Activar</a></li>
                        <% } %>
                        <?php /*
                        <li><a class="argenprop_eliminar" href="javascript:void(0)">Eliminar</a></li>
                        */ ?>
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
        
        <i <%= (!edicion)?"disabled":"" %> data-toggle="tooltip" title="Activa en Web" class="fa-check iconito fa activo <%= (activo == 1)?"active":"" %>"></i>
        <i <%= (!edicion)?"disabled":"" %> data-toggle="tooltip" title="Destacado" class="fa fa-star iconito warning destacado <%= (destacado == 1)?"active":"" %>"></i>

        <i <%= (!edicion)?"disabled":"" %> data-toggle="tooltip" title="Compartida en Red Inmovar" class="fa fa-share-alt iconito compartida <%= (compartida == 1)?"active":"" %>"></i>
        <div class="fr btn-group dropdown ml10">
          <i title="Opciones" class="iconito text-muted-2 fa fa-caret-down dropdown-toggle" data-toggle="dropdown"></i>
          <ul class="dropdown-menu pull-right">
            <li><a href="javascript:void(0)" class="editar"><i class="text-muted-2 fa fa-pencil w25"></i> Editar</a></li>
            <li class="divider"></li>
            <li><a href="javascript:void(0)" class="ver_interesados"><i class="text-muted-2 fa fa-users w25"></i> Ver interesados</a></li>
            <li><a href="javascript:void(0)" class="buscar_interesados"><i class="text-muted-2 fa fa-search w25"></i> Buscar interesados</a></li>
            <li class="divider"></li>
            <li><a href="<%= link_completo %>" target="_blank"><i class="text-muted-2 fa fa-globe w25"></i> Ver web</a></li>
            <li><a href="javascript:void(0)" class="ver_ficha" data-id="<%= id %>"><i class="text-muted-2 fa fa-file w25"></i> Ver ficha</a></li>

            <% if (control.check("propiedades") == 3) { %>
              <li class="divider"></li>
              <li><a href="javascript:void(0)" class="duplicar" data-id="<%= id %>"><i class="text-muted-2 fa fa-files-o w25"></i> Duplicar</a></li>
              <li><a href="javascript:void(0)" class="eliminar" data-id="<%= id %>"><i class="text-muted-2 fa fa-times w25"></i> Eliminar</a></li>
            <% } %>
          </ul>
        </div>
      </td>
    <% } else { %>

      <?php // PROPIEDADES DE LA RED ?>
      <td>
        <div class="dt">
          <div class="dtc">
            <% if (!isEmpty(logo_inmobiliaria)) { %>
              <img src="<%= logo_inmobiliaria %>" class="customcomplete-image" style="border-radius:100%"/>
            <% } %>
          </div>
          <div class="dtc">
            <b class="text-dark"><%= inmobiliaria %></b>
          </div>
        </div>
      </td>
      <td>
        <% if (permiso_web == 1) { %>
          <% if (bloqueado_web == 1) { %>
            <div data-toggle="tooltip" title="Compartida en web" class="doble-check bloqueado_web">
              <span class="material-icons text-danger">clear</span>
            </div>
          <% } else { %>
            <div data-toggle="tooltip" title="Compartida en web" class="doble-check bloqueado_web">
              <span class="material-icons text-success">done</span>
              <span class="material-icons text-success">done</span>
            </div>
          <% } %>
        <% } else { %>
          <div data-toggle="tooltip" title="No compartida en web" class="doble-check">
            <span class="material-icons text-success">done</span>
            <span class="material-icons">done</span>
          </div>
        <% } %>
      </td>

    <% } %>
  <% } %>
</script>


<script type="text/template" id="propiedad_template">
<?php include("propiedades_detalle.php") ?>
</script>


<script type="text/template" id="propiedades_departamentos_resultados_template">
<table id="departamentos_tabla" class="table table-small table-striped sortable m-b-none default footable">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Piso</th>
      <th class="th_acciones w50"></th>
    </tr>
  </thead>
  <tbody class="tbody"></tbody>
</table>
</script>

<script type="text/template" id="propiedades_departamentos_item_resultados_template">
<td class="text-info data"><%= nombre %></td>
<td class="data"><%= piso %></td>
<td class="tar td_acciones">
  <button class="btn btn-white eliminar"><i class="fa fa-trash"></i></button>
</td>
</script>

<script type="text/template" id="propiedad_departamento_template">
<div class="panel panel-default">
  <div class="panel-heading">
    <b>Editar departamento</b>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Nombre</label>
          <input type="text" required name="nombre" id="departamento_nombre" value="<%= nombre %>" class="form-control"/>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <% if (ID_EMPRESA == 208) { %>
            <label class="control-label">Galeria</label>
            <select class="form-control" name="piso" id="departamento_piso">
              <option <%= (piso=="Planos y vistas")?"selected":"" %>>Planos y vistas</option>
              <option <%= (piso=="Avance de obra")?"selected":"" %>>Avance de obra</option>
            </select>
          <% } else { %>
            <label class="control-label">Piso</label>
            <input type="text" name="piso" id="departamento_piso" value="<%= piso %>" class="form-control"/>
          <% } %>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Orden</label>
          <input type="text" name="orden" id="departamento_orden" value="<%= orden %>" class="form-control"/>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="i-checks">
        <input type="checkbox" id="departamento_disponible" name="disponible" class="checkbox" value="1" <%= (disponible == 1)?"checked":"" %> >
        <i></i>
        El departamento se encuentra disponible
      </label>
    </div>
    <div class="form-group">
      <label class="control-label">
        <?php echo lang(array(
          "es"=>"Descripci&oacute;n",
          "en"=>"Description",
        )); ?>
      </label>
      <textarea name="texto" name="departamento_texto" id="departamento_texto"><%= texto %></textarea>
    </div>
    <?php
    multiple_upload(array(
      "name"=>"images_dptos",
      "label"=>"Galer&iacute;a de Fotos",
      "url"=>"propiedades/function/save_image/",
      "width"=>(isset($empresa->config["departamento_galeria_image_width"]) ? $empresa->config["departamento_galeria_image_width"] : 800),
      "height"=>(isset($empresa->config["departamento_galeria_image_height"]) ? $empresa->config["departamento_galeria_image_height"] : 600),
      "quality"=>(isset($empresa->config["departamento_galeria_image_quality"]) ? $empresa->config["departamento_galeria_image_quality"] : 0),
    )); ?>
  </div>
  <div class="panel-footer clearfix tar">
    <button class="btn guardar btn-success">Guardar</button>
  </div>
</div>
</script>

<script type="text/template" id="propiedad_mercado_libre_template">
  <div class="panel panel-default">
    <div class="panel-heading fs16 bold">
      Compartir a MercadoLibre
      <i class="fa fa-times cerrar cp fr"></i>
    </div>
    <div class="panel-body">
      <div class="tab-container">
        <ul class="nav nav-tabs" role="tablist">
          <li class="active">
            <a id="propiedad_mercado_libre_paso_1_link" href="#propiedad_mercado_libre_tab1" class="buscar_todos" role="tab" data-toggle="tab">
              <i class="fa text-warning fa-calendar m-r-xs"></i>
              Datos
            </a>
          </li>
          <li>
            <a id="propiedad_mercado_libre_paso_2_link" href="#propiedad_mercado_libre_tab2" role="tab" data-toggle="tab">
              <i class="fa text-info fa-address-book m-r-xs"></i>
              Publicacion
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <div id="propiedad_mercado_libre_tab1" class="tab-pane active">
            <div class="row">
              <% if (!multiple) { %>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Titulo</label>
                    <input id="propiedad_mercado_libre_titulo_meli" value="<%= titulo_meli %>" type="text" class="form-control" name="titulo_meli"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Precio</label>
                    <input id="propiedad_mercado_libre_precio_meli" value="<%= precio_meli %>" type="text" class="form-control" name="precio_meli"/>
                  </div>
                </div>
              <% } %>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">Tipo de publicacion</label>
                  <select id="propiedad_mercado_libre_tipo_publicacion" class="form-control">
                    <option value="0">Seleccione</option>
                  </select>
                </div>
              </div>
            </div>
            <% if (!multiple) { %>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Descripcion</label>
                    <textarea style="height: 250px;" class="form-control" name="texto_meli" id="propiedad_mercado_libre_texto_meli"><%= texto_meli %></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <?php 
                  multiple_upload(array(
                    "name"=>"images_meli",
                    "label"=>"Im&aacute;genes adicionales",
                    "url"=>"propiedades/function/save_image/",
                    "width"=>(isset($empresa->config["producto_galeria_image_width"]) ? $empresa->config["producto_galeria_image_width"] : 800),
                    "height"=>(isset($empresa->config["producto_galeria_image_height"]) ? $empresa->config["producto_galeria_image_height"] : 600),
                    "resizable"=>(isset($empresa->config["producto_galeria_image_resizable"]) ? $empresa->config["producto_galeria_image_resizable"] : 0),
                    "upload_multiple"=>true,
                  )); ?>
                </div>
              </div>
            <% } else { %>
                <?php 
                multiple_upload(array(
                  "name"=>"images_meli",
                  "label"=>"Im&aacute;genes adicionales",
                  "url"=>"propiedades/function/save_image/",
                  "width"=>(isset($empresa->config["producto_galeria_image_width"]) ? $empresa->config["producto_galeria_image_width"] : 800),
                  "height"=>(isset($empresa->config["producto_galeria_image_height"]) ? $empresa->config["producto_galeria_image_height"] : 600),
                  "resizable"=>(isset($empresa->config["producto_galeria_image_resizable"]) ? $empresa->config["producto_galeria_image_resizable"] : 0),
                  "upload_multiple"=>true,
                )); ?>
            <% } %>
            <div class="clearfix tar">
              <button class="ir_paso_2 btn btn-success">Siguiente</button>
            </div>
          </div>
          <div id="propiedad_mercado_libre_tab2" class="tab-pane">
            <div style="overflow-y: auto;">
              <div style="height: 260px; text-align: center;" class="loading_grande">
                <img src="/admin/resources/images/spinner.gif" style="line-height: 260px;"/>
              </div>
              <div id="propiedad_mercado_libre_categorias"></div>
            </div>
            <div class="clearfix m-t">
              <button class="ir_paso_1 btn btn-default">Anterior</button>
            </div>
          </div>
        </div> 
      </div>   
    </div>
  </div>
</script>

<script type="text/template" id="propiedad_mercado_libre_categoria_template">
  <select size="15" class="form-control categoria_mercado_libre" data-nivel="<%= nivel %>">
    <% for(var i=0; i< categories.length; i++) { %>
      <% var cat = categories[i] %>
      <option <%= (cat.id == selected)?"selected":"" %> value="<%= cat.id %>"><%= cat.name %></option>
    <% } %>
  </select>
</script>


<script type="text/template" id="propiedad_buscar_interesados_template">
  <div class="modal-header">
    <b>Interesados en la propiedad</b>
    <i class="fa fa-times cerrar cp fr"></i>
  </div>
  <div class="modal-body">
    <div class="table-responsive" style="height:250px; overflow:auto">
      <table id="propiedad_buscar_interesados_tabla" class="table table-striped sortable m-b-none default footable">
        <thead>
          <tr>
            <th style="width:20px"></th>
            <th>Nombre</th>
            <th>Fecha Interes</th>
            <th>Email</th>
            <th>Tel&eacute;fono</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
  <div class="modal-footer tar">
    <button class="btn btn-info enviar_emails btn-addon"><i class="icon fa fa-send"></i>Enviar email</button>
  </div>
</div>
</script>

<script type="text/template" id="propiedad_buscar_interesados_item_template">
<% var link_completo = 'https://' + DOMINIO + ((DOMINIO.substr(DOMINIO.length - 1) == "/") ? "" : "/") + link %>
<td class="p0">
  <label class="i-checks">
    <input data-id="<%= id_contacto %>" class="propiedad_buscar_interesados_checkbox" type="checkbox" checked value="1">
    <i></i>
  </label>
</td>
<td><a href="app/#contacto_acciones/<%= id_contacto %>" class="bold"><%= nombre %></a>
<td><%= fecha %></td>
<td><%= email %></td>
<td>
  <% if (!isEmpty(telefono)) { %>
    <span data-link_completo="<%= link_completo %>" class="enviar_whatsapp_interesado"><i class="fa mr5 fa-whatsapp"></i> <%= telefono %></span>
  <% } %>
</td>
</script>

<script type="text/template" id="propiedad_estadistica_detalle_template">
  <div class="modal-header clearfix">
    <b class="pull-left mt5"><%= nombre %> <%= (!isEmpty(codigo)) ? "("+codigo+")" : "" %></b>
    <i class="fa fa-times fr cp cerrar fs16"></i>
  </div>
  <div class="modal-body">  
    <div class="tab-container mb0">
      <ul class="nav nav-tabs nav-tabs-2" role="tablist">
        <li class="render_tabla <%= (tab_default == "tabla")?"active":"" %>">
          <a href="#tab_propiedad_estadistica1" role="tab" data-toggle="tab">
            <i class="material-icons mr5">people</i>
            Contactos
          </a>
        </li>
        <li class="render_grafico <%= (tab_default == "grafico")?"active":"" %>">
          <a href="#tab_propiedad_estadistica2" role="tab" data-toggle="tab">
            <i class="material-icons mr5">equalizer</i>
            Grafico
          </a>
        </li>
        <div class="pull-right mr5">
          <div class="input-group pull-left mr5" style="width: 140px;">
            <input type="text" id="propiedad_estadistica_fecha_desde" class="form-control">
            <span class="input-group-btn">
              <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>              
          </div>
          <div class="input-group pull-left mr5" style="width: 140px;">
            <input type="text" id="propiedad_estadistica_fecha_hasta" class="form-control">
            <span class="input-group-btn">
              <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>
          </div>
          <button class="btn buscar btn-default pull-left"><i class="fa fa-search"></i></button>
        </div>
      </ul>
    </div>
    <div class="tab-content panel panel-default">
      <div id="tab_propiedad_estadistica1" class="tab-pane pr0 pl0 <%= (tab_default == "tabla")?"active":"" %>">
        <div style="height:250px; overflow: auto;">
          <table id="propiedad_estadistica_tabla" class="table table-striped sortable m-b-none default footable">
            <thead>
              <tr>
                <th style="width:150px">Fecha</th>
                <th>Contacto</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div id="tab_propiedad_estadistica2" class="tab-pane pr0 pl0 <%= (tab_default == "grafico")?"active":"" %>">
        <div id="propiedad_estadistica_grafico" style="height:250px;"></div>
      </div>
    </div>
  </div>
</script>

<script type="text/template" id="propiedad_preview_template">
  <?php include_once("propiedad_preview.php") ?>
</script>

<script type="text/template" id="propiedad_temporada_panel_template">
<div class="panel panel-default">
  <div class="panel-heading">
    <b>Editar tarifa de temporada</b>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <label class="control-label">Nombre</label>
      <input type="text" name="nombre" id="propiedad_temporada_nombre" value="<%= nombre %>" class="form-control"/>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Desde</label>
          <div class="input-group">
            <input type="text" id="propiedad_temporada_fecha_desde" value="<%= desde %>" class="form-control">
            <span class="input-group-btn">
              <button class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Hasta</label>
          <div class="input-group">
            <input type="text" id="propiedad_temporada_fecha_hasta" <%= hasta %> class="form-control">
            <span class="input-group-btn">
              <button class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Estadia Min.</label>
          <input type="text" name="minimo_dias_reserva" id="propiedad_temporada_minimo_dias_reserva" value="<%= minimo_dias_reserva %>" class="form-control"/>
        </div>
      </div>      
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Por Noche</label>
          <input type="text" id="propiedad_temporada_precio" value="<%= precio %>" name="precio" class="form-control"/>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Fin de Semana</label>
          <input type="text" id="propiedad_temporada_precio_finde" value="<%= precio_finde %>" name="precio_finde" class="form-control"/>
        </div>        
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Semana</label>
          <input type="text" id="propiedad_temporada_precio_semana" value="<%= precio_semana %>" name="precio_semana" class="form-control"/>
        </div>        
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Mes</label>
          <input type="text" id="propiedad_temporada_precio_mes" value="<%= precio_mes %>" name="precio_mes" class="form-control"/>
        </div>        
      </div>
    </div>
  </div>
  <div class="panel-footer clearfix tar">
    <button class="btn cancelar fl btn-default">Cancelar</button>
    <button class="btn guardar btn-success">Guardar</button>
  </div>
</div>
</script>

<script type="text/template" id="propiedad_impuesto_panel_template">
<div class="panel panel-default">
  <div class="panel-heading">
    <b>Editar impuesto o tasa</b>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <label class="control-label">Nombre</label>
      <input type="text" name="nombre" id="propiedad_impuesto_nombre" value="<%= nombre %>" class="form-control"/>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Tipo</label>
          <select class="form-control" name="tipo" id="propiedad_impuesto_tipo">
            <option value="1" <%= (tipo==1)?"selected":"" %>>Porcentaje por reserva</option>
            <option value="2" <%= (tipo==2)?"selected":"" %>>Tarifa por viajero</option>
            <option value="3" <%= (tipo==3)?"selected":"" %>>Tarifa por persona y noche</option>
            <option value="4" <%= (tipo==4)?"selected":"" %>>Tarifa por noche</option>
            <option value="5" <%= (tipo==5)?"selected":"" %>>Precio fijo por estadia</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Monto</label>
          <input type="text" id="propiedad_impuesto_monto" value="<%= monto %>" class="form-control">
        </div>
      </div>
    </div>
  </div>
  <div class="panel-footer clearfix tar">
    <button class="btn cancelar fl btn-default">Cancelar</button>
    <button class="btn guardar btn-success">Guardar</button>
  </div>
</div>
</script>