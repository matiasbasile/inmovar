<script type="text/template" id="consultas_panel_template">
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-md-6 col-xs-8">
          <h1>Seguimiento</h1>
        </div>
        <div class="col-md-6 col-xs-4 tar">
          <a class="btn btn-info nuevo_cliente" href="javascript:void(0)">
            <span class="material-icons show-xs">add</span>
            <span class="hidden-xs">&nbsp;&nbsp;Nueva Consulta&nbsp;&nbsp;</span>
          </a>
        </div>
      </div>
    </div>

    <div class="tab-container mb0">
      <ul class="nav nav-tabs nav-tabs-2" role="tablist">
        <% for(var i=0;i< consultas_tipos.length;i++) { %>
          <% var tipo = consultas_tipos[i] %>
          <li data-tipo="<%= tipo.id %>" class="cambiar_tab <%= (window.consultas_tipo == tipo.id)?"active":"" %>">
            <a href="javascript:void(0)">
              <%= tipo.nombre %>
              <span class="consultas_estado consultas_estado_<%= tipo.id %> counter">0</span>
            </a>
          </li>
        <% } %>
        <li id="consultas_vencidas_tab" class="<%= (window.consultas_vencidas == 1)?"active":"" %>">
          <a href="javascript:void(0)">
            Vencidos
            <span id="consultas_vencidas_counter" class="counter">0</span>
          </a>
        </li>
        <li>
          <a href="app/#consultastipos" class="btn-tab-large">
            <i class="material-icons md-22 mr0 mt2 mb2">settings</i>
          </a>
        </li>
      </ul>
    </div>
    <div class="panel panel-default">
      <div class="panel-body pb0">

        <div class="mb20">
          <div class="clearfix">
            <div class="row">
              <div class="col-xs-12 sm-m-b">
                <div class="input-group">
                  <input type="text" id="consultas_buscar" value="<%= window.consultas_filter %>" placeholder="<?php echo lang(array("es"=>"Buscar","en"=>"Search")); ?>..." autocomplete="off" class="form-control">

                  <% if (SOLO_USUARIO == 0) { %>
                    <span class="input-group-btn">
                      <select id="consultas_usuarios" class="form-control w250">
                        <option value="0">Usuario asignado</option>
                        <% for(var i=0;i< window.usuarios.models.length;i++) { %>
                          <% var o = window.usuarios.models[i]; %>
                          <option value="<%= o.id %>" <%= (o.id == window.consultas_usuario)?"selected":"" %>><%= o.get("nombre") %></option>
                        <% } %>
                      </select>
                    </span>
                  <% } %>

                  <span class="input-group-btn">
                    <button class="btn btn-default buscar"><i class="fa fa-search"></i></button>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="bulk_action wrapper pl0 pt0">
          <button class="btn btn-default eliminar_lote btn-addon"><i class="icon fa fa-trash"></i>Eliminar</button>
        </div>

        <div class="table-responsive">
          <table id="consultas_table" class="table table-striped sortable footable">
            <thead>
              <tr>
                <th style="width:20px;"></th>
                <th style="width:20px;"></th>
                <th style="min-width:250px"><?php echo lang(array("es"=>"Nombre","en"=>"Name")); ?></th>
                <th class="pl0" colspan="2">Interesado en</th>
                <th>Origen</th>
                <th class="w150">Estado</th>
              </tr>
            </thead>
            <tbody></tbody>
            <tfoot class="pagination_container hide-if-no-paging"></tfoot>
          </table>
        </div>
      </div>

    </div>
  </div>
</script>

<script type="text/template" id="consultas_item">
  <td class="p0">
    <label class="i-checks m-b-none">
      <input class="esc check-row" value="<%= id %>" type="checkbox"><i></i>
    </label>
  </td>
  <td class="p0 w25">
    <% if (!isEmpty(path)) { %>
      <% if (path.indexOf("http") == 0) { %>
        <img src="<%= path %>" class="customcomplete-image mr0"/>
      <% } else { %>
        <img src="/admin/<%= path %>" class="customcomplete-image mr0"/>
      <% } %>
    <% } else { %>
      <span class="avatar xs avatar-texto pull-left">
        <%= isEmpty(nombre) ? email.substr(0,1).toUpperCase() : nombre.substr(0,1).toUpperCase() %>
      </span>
    <% } %>
  </td>  
  <td>
    <div>
      <% if (isEmpty(nombre)) { %>
        <span class="capitalize data text-link fs16"><%= email %></span>
      <% } else { %>
        <span class="capitalize data text-link fs16"><%= nombre.ucwords() %></span>
      <% } %>
      <div class="cb oh mt5">
        <span class="material-icons fs16 fl mr5">person</span>
        <select style="background-color:transparent;border:none;padding:0px;font-size:13px;margin-top:2px" class="no-model usuario_asignado fl">
          <option value="0">Sin asignar</option>
          <% for (var i=0; i< usuarios.length; i++) { %>
            <% var u = usuarios.models[i] %>
            <option <%= (u.id == id_usuario)?"selected":"" %> value="<%= u.id %>"><%= u.get("nombre") %></option>
          <% } %>
        </select>
      </div>
    </div>
  </td>
  <td class="p0 data w40">
    <% if (!isEmpty(propiedad_path)) { %>
      <% var prefix = (propiedad_path.indexOf("http") == 0) ? "" : "/admin/" %>
      <img src="<%= prefix + propiedad_path %>?t=<%= Math.ceil(Math.random()*10000) %>" class="customcomplete-image mr0"/>
    <% } %>
  </td>
  <td class="data">
    <% if (propiedad_id != 0) { %>
      <span class="bold"><%= propiedad_tipo_inmueble %> en <%= propiedad_tipo_operacion %></span><br/>
      <%= propiedad_direccion %>, <%= propiedad_ciudad %>
    <% } else { %>
      <span class="btn etiqueta desactivo btn-menu-compartir">Asignar interés</span>
    <% } %>
  </td>
  <td class="data">
    <span style="color:#5a5a5a">
      <% if (id_origen == 27 || id_origen == 30 || id_origen == 31) { %>
        <i class="fa fa-whatsapp"></i> Whatsapp

      <% } else if (id_origen == 24) { %>
        <i class="fa fa-instagram"></i> Instagram

      <% } else if (id_origen == 26) { %>
        <i class="fa fa-facebook"></i> Facebook

      <% } else if (id_origen == 40) { %>
        <i class="fa fa-globe"></i> Diario El Dia

      <% } else if (id_origen == 28 || id_origen == 5 || id_origen == 21 || id_origen == 22 || id_origen == 28) { %>
        <i class="fa fa-envelope"></i> Email

      <% } else if (id_origen == 2) { %>
        <i class="fa fa-globe"></i> Newsletter

      <% } else if (id_origen == 3) { %>
        <i class="fa fa-users"></i> Personal

      <% } else if (id_origen == 4) { %>
        <i class="fa fa-telephone"></i> Teléfono

      <% } else if (id_origen == 14) { %>
        <i class="fa fa-blank"></i> Nota

      <% } else if (id_origen == 15) { %>
        <i class="fa fa-envelope"></i> SMS

      <% } else if (id_origen == 17) { %>
        <i class="fa fa-envelope"></i> Tarea

      <% } else if (id_origen == 25) { %>
        <i class="fa fa-envelope"></i> MercadoLibre

      <% } else if (id_origen == 50) { %>
        <i class="fa fa-search"></i> Búsqueda

      <% } else if (id_origen == 1 || id_origen == 6 || id_origen == 7 || id_origen == 8 || id_origen == 9 || id_origen == 10) { %>
        <i class="fa fa-globe"></i> Web

      <% } %>
    </span>
    <br/><span><%= (moment("DD/MM/YYYY") == fecha)?"Hoy":fecha %> <%= hora %></span>
  </td>
  <td>
    <button data-toggle="tooltip" title="Click para realizar acción" class="btn etiqueta btn-menu-compartir mostrar_estado">
      <%= consulta_tipo %>
      <?php /*
      <% if (moment(fecha_vencimiento,"DD/MM/YYYY").isSameOrAfter(moment())) { %>
        En progreso
      <% } else { %>
        Vencida
      <% } %>*/?>
    </button>
  </td>
</script>

<script type="text/template" id="crear_consulta_timeline_template">
  <div class="panel panel-default mt-1 mb0">
    <ul class="nav nav-tabs nav-tabs-3" role="tablist">
      <% var active_tab = "tab1" %>
      <li class="active">
        <a id="tab1_link" href="#tab1" role="tab" data-toggle="tab"><i class="fa fa-envelope text-muted"></i> Email</a>
      </li>
      <% if (mostrar_sms) { %>
        <li>
          <a id="tab2_link" href="#tab2" role="tab" data-toggle="tab"><i class="fa fa-commenting text-muted"></i> SMS</a>
        </li>
      <% } %>
      <% if (mostrar_whatsapp) { %>
        <li>
          <a id="tab3_link" href="#tab3" role="tab" data-toggle="tab"><i class="fa fa-whatsapp text-muted"></i> Whatsapp</a>
        </li>
      <% } %>
      <% if (mostrar_tarea) { %>
        <li>
          <a id="tab3_link" href="#tab_tarea" role="tab" data-toggle="tab"><i class="fa fa-clock-o text-muted"></i> Tarea</a>
        </li>
      <% } %>
      <?php /*
      <li>
        <a id="tab_link_observacion" href="#tab_observacion" role="tab" data-toggle="tab"><i class="fa fa-file-text text-muted"></i> Nota</a>
      </li>
      */ ?>
      <li>
        <a id="tab_link_nota" href="#tab_nota" role="tab" data-toggle="tab"><i class="fa fa-file-text text-muted"></i> Nota</a>
      </li>  

      <li>
        <a href="javascript:void(0)" class="nueva_visita"><i class="fa fa-home text-muted"></i> Visita</a>
      </li>  

    </ul>
    <div class="tab-content">
      <div id="tab1" class="tab-pane panel-body <%= (active_tab=='tab1')?'active':'' %>">
        <div class="form-group">
          <div class="input-group">
            <input type="text" <%= (alerta_email)?"disabled":"" %> id="consulta_email_asunto" placeholder="Asunto" class="form-control"/>
            <div class="input-group-btn dropdown">
              <button <%= (alerta_email)?"disabled":"" %> type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Plantillas <span class="caret"></span>
              </button>
              <ul class="dropdown-menu pull-right">
                <li><a class="cargar_plantilla" href="javascript:void(0)">Cargar</a></li>
                <li><a class="guardar_plantilla" href="javascript:void(0)">Guardar</a></li>
              </ul>
            </div>
          </div>  
        </div>
        <div class="form-group">
          <textarea <%= (alerta_email)?"disabled":"" %> id="consulta_email_texto"></textarea>
        </div>      
        <div class="form-group clearfix">
          <div class="fl">
            <div class="w200">
              <span class="btn btn-default fileinput-button">
                <i class="glyphicon glyphicon-folder-open m-r-xs"></i>
                <span>Adjuntar archivos</span>
                <input <%= (alerta_email)?"disabled":"" %> id="fileupload_timeline" type="file" name="files[]" multiple>
              </span>
              <div id="progress_timeline" class="progress" style="display: none">
                <div class="progress-bar progress-bar-success"></div>
              </div>
              <div id="files_timeline" class="files"></div>
            </div>
          </div>
          <button <%= (alerta_email)?"disabled":"" %> class="btn btn-pd btn-info guardar_email fr">Enviar</button>
        </div>
        <% if (alerta_email) { %>
          <div class="form-group clearfix">
            <div class="alert alert-warning alert-dismissable">
              <i class="fa fa-warning"></i>
              Atenci&oacute;n! La persona no tiene cargada un email de contacto.
            </div>
          </div>
        <% } %>
      </div>

      <% if (mostrar_sms) { %>
        <div id="tab2" class="tab-pane panel-body <%= (active_tab=='tab2')?'active':'' %>">
          <div class="form-group">
            <% if (telefonos.length > 0) { %>
              <div class="form-group fl w200">
                <select id="consulta_sms_telefono" class="form-control">
                  <% for(var k=0;k< telefonos.length; k++) { %>
                    <% var telefono = telefonos[k] %>
                    <option><%= telefono %></option>
                  <% } %>
                </select>
              </div>
            <% } %>
            <label class="control-label fr">
              <span id="consulta_sms_title">0</span> de <span>160</span>
            </label>
            <textarea data-max="160" data-id="consulta_sms_title" id="consulta_sms" class="form-control h100 no-model text-remain"></textarea>
          </div>
          <div class="form-group clearfix">
            <% if (alerta_celular) { %>
              <div class="alert alert-warning mb0 p5 fl alert-dismissable">
                <i class="fa fa-warning"></i>
                Atenci&oacute;n! La persona no tiene cargada un celular de contacto.
              </div>
            <% } %>
            <button class="btn btn-pd btn-info guardar_sms fr">Guardar</button>
          </div>
        </div>
      <% } %>

      <% if (mostrar_whatsapp) { %>
        <div id="tab3" class="tab-pane panel-body <%= (active_tab=='tab3')?'active':'' %>">
          <div class="form-group">
            <textarea <%= (alerta_celular)?"disabled":"" %> id="consulta_whatsapp" placeholder="Escribe aqui tu mensaje..." class="form-control h100 no-model"></textarea>
          </div>
          <div class="form-group clearfix">
            <% if (alerta_celular) { %>
              <div class="alert alert-warning mb0 p5 fl alert-dismissable">
                <i class="fa fa-warning"></i>
                Atenci&oacute;n! La persona no tiene cargada un celular de contacto.
              </div>
            <% } %>
            <button <%= (alerta_celular)?"disabled":"" %> class="btn btn-pd btn-info enviar_whatsapp fr">Enviar</button>
          </div>
        </div>
      <% } %>

      <% if (mostrar_tarea) { %>
        <div id="tab_tarea" class="tab-pane mt-1 panel-body <%= (active_tab=='tab_tarea')?'active':'' %>">
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label class="control-label">Tarea</label>
                <div class="input-group">
                  <select id="consulta_tarea_asuntos" class="select w100p"></select>
                  <span class="input-group-btn">
                    <button tabindex="-1" class="btn btn-info agregar_asunto">+</button>  
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Fecha</label>
                    <div class="input-group">
                      <input placeholder="Fecha" type="text" class="form-control no-model" id="consulta_tarea_fecha"/>
                      <span class="input-group-btn">
                        <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
                      </span>        
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <textarea id="consulta_tarea_texto" placeholder="Escribe aqui la tarea para realizar..." class="form-control no-model h100"></textarea>
          </div>
          <div class="form-group clearfix tar">
            <button class="btn btn-pd btn-info guardar_tarea">Guardar</button>
          </div>
        </div>
      <% } %>
      <div id="tab_nota" class="tab-pane mt-1 panel-body <%= (active_tab=='tab_nota')?'active':'' %>">
        <div class="form-group">
          <textarea id="consulta_nota" placeholder="Escribe aquí alguna nota u observación..." class="form-control no-model h100"></textarea>
        </div>
        <div class="form-group tar">
          <button class="btn btn-pd btn-info guardar_nota fr">Guardar</button>
        </div>
      </div>
      <div id="tab_observacion" class="tab-pane mt-1 panel-body <%= (active_tab=='tab_observacion')?'active':'' %>">
        <div class="form-group">
          <textarea id="consulta_observacion" placeholder="Escribe aquí alguna nota u observación..." class="form-control no-model h100"><%= nota %></textarea>
        </div>
        <div class="form-group tar">
          <button class="btn btn-pd btn-info guardar_observacion fr">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</script>



<script type="text/template" id="cambiar_estado_consulta_template">
  <div class="modal-header">
    <b>Cambiar estado de consulta</b>
    <i class="pull-right cerrar_lightbox fs16 fa fa-times cp"></i>    
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-7">

        <div class="row tac">
          <div class="col-xs-3">
            <% if (!isEmpty(path)) { %>
              <img src="/admin/<%= path %>" class="customcomplete-image xl"/>
            <% } else { %>
              <span class="avatar xl avatar-texto <%= (activo==1)?'':'bg-light dker' %>">
                <%= isEmpty(nombre) ? email.substr(0,1).toUpperCase() : nombre.substr(0,1).toUpperCase() %>
              </span>
            <% } %>
          </div>
          <div class="col-xs-9 tal mb20">
            <h3 class="m-t-sm m-b-xs"><%= nombre.ucwords() %> </h3>
            <div><a class="text-link"><%= email %></a></div>
            <div><i class="fa fa-whatsapp"></i> <%= telefono %></div>
          </div>
        </div>

      </div>
      <div class="col-md-5">
        <div class="form-group">
          <label class="control-label bold">Cambiar de estado</label>
          <div>
            <input type="hidden" id="consulta_cambio_estado_id_tipo" value="<%= tipo %>" />
            <div class="btn-group dropdown w100p">
              <button id="consulta_cambio_estado_boton_tipo" class="btn btn-info btn-lg tac w100p dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <%= consulta_tipo %>
                <span class="material-icons fr">expand_more</span>
              </button>
              <ul class="dropdown-menu">
                <% for (var i=0;i< consultas_tipos.length;i++) { %>
                  <% var t = consultas_tipos[i] %>
                  <?php // El estado A Contactar solamente se va a mostrar si ya esta en A Contactar (sino no se puede volver a este estado mas) ?>
                  <% if ((i == 0 && tipo == 1) || i > 0) { %>
                    <li><a href="javascript:void(0)" class="editar_tipo" data-tipo="<%= t.id %>"><%= t.nombre %></a></li>
                  <% } %>
                <% } %>          
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Seleccione un motivo</label>
          <select id="cambiar_estado_consulta_asuntos" class="form-control"></select>
        </div>
      </div>
      <div id="cambiar_estado_consulta_fecha_cont" class="col-md-6">
        <div class="form-group">
          <label class="control-label">Fecha y hora de la actividad</label>
          <div class="input-group">
            <input placeholder="Fecha" type="text" class="form-control no-model" id="cambiar_estado_consulta_fecha"/>
            <span class="input-group-btn">
              <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>        
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <textarea id="consulta_nota" placeholder="Escribe aquí alguna nota u observación..." class="form-control no-model h100"></textarea>
    </div>

  </div>
  <div class="modal-footer tar">
    <% if (moment(fecha_vencimiento,"DD/MM/YYYY").isSameOrBefore(moment())) { %>
      <button data-toggle="tooltip" title="Posterga la fecha vencimiento de la consulta" class="btn btn-pd btn-white postergar">Postergar</button>
    <% } %>
    <button class="btn btn-pd btn-info guardar">Guardar</button>
  </div>
</div>
</script>


<script type="text/template" id="consulta_timeline_template">
  <?php 
  // CREACION DE USUARIO
  ?>
  <% if (id_origen == 20) { %>
    <a class="pull-left thumb-sm bg-info avatar avatar-texto xs m-l-n-md">
      <i class="fa fa-user"></i>
    </a>
    <div class="m-l-lg panel b-a">
      <div class="panel-heading clearfix pos-rlt b-b b-light">
        <span class="arrow left"></span>
        <div>
          <div class="pb5">
            <?php echo lang(array("es"=>"Se cre&oacute; el usuario:","en"=>"Creation:")); ?>
            <b><%= (tipo == 1) ? usuario.ucwords() : nombre.ucwords() %></b>
            <span class="text-muted fs13 pull-right">
              <i class="fa fa-clock-o"></i>
              <%= mostrar_fecha(fecha,hora) %>
            </span>
          </div>
        </div>
      </div>
    </div>
  <?php // FIN DE CREACION DE USUARIO ?>

  <?php 
  // NOTIFICACION DEL SISTEMA. CAMBIO DE USUARIO. CAMBIO DE ESTADO
  ?>
  <% } else if (id_origen == 32) { %>
    <a class="pull-left thumb-sm bg-info avatar avatar-texto xs m-l-n-md">
      <i class="fa fa-user"></i>
    </a>
    <div class="m-l-lg panel b-a">
      <div class="panel-heading clearfix pos-rlt b-b b-light">
        <span class="arrow left"></span>
        <div>
          <div class="pb5">
            <b class="mr5"><%= asunto %>:</b>
            <%= texto.replace(">","<i class='fa fa-caret-right ml5 mr5'></i>") %>
            <%= (!isEmpty(custom_1)) ? "<br/>"+nl2br(custom_1) : "" %>
            <span class="text-muted fs13 pull-right">
              <i class="fa fa-clock-o"></i>
              <%= mostrar_fecha(fecha,hora) %>
            </span>
          </div>
        </div>
      </div>
    </div>
  <?php // FIN DE NOTIFICACION DEL SISTEMA ?>

  <?php 
  // EMAIL DE INTERES PROPIEDAD
  ?>
  <% } else if (id_origen == 28) { %>
    <a class="pull-left thumb-sm bg-info avatar avatar-texto xs m-l-n-md">
      <i class="fa fa-envelope"></i>
    </a>
    <div class="m-l-lg panel b-a">
      <div class="panel-heading clearfix pos-rlt b-b b-light pb10">
        <span class="arrow left"></span>
        <div>
          <div class="pb5">
            Se envi&oacute; un email de interes
            <b><%= (tipo == 1) ? usuario.ucwords() : nombre.ucwords() %></b>
            <span class="text-muted fs13 pull-right">
              <?php /*
              <% if (!isEmpty(fecha_visto)) { %>
                <i class="fa fa-eye text-info mr5" data-toggle="tooltip" title="<%= fecha_visto %>"></i>
              <% } %>
              */ ?>
              <i class="fa fa-clock-o"></i>
              <%= mostrar_fecha(fecha,hora) %>
            </span>
          </div>
          <div class="dt pb5">
            <div class="dtc vam">
              <a href="app/#propiedades/<%= id_referencia %>" class="consulta_propiedad">
                <% if (!isEmpty(propiedad_path)) { %>
                  <img class="customcomplete-image fn" src="<%= propiedad_path %>"/>
                <% } %>
              </a>
            </div>
            <div class="dtc vam">
              <span class="h4"><%= asunto %></span>
              <br/><span class="text-muted fs14"><%= propiedad_direccion %> | <%= propiedad_ciudad %></span>
              <% if (id_empresa_relacion != id_empresa) { %>
                <span class="label bg-danger m-l-sm">Red</span>
              <% } %>
            </div>
          </div>
        </div>
      </div>
    </div>  
  <?php // FIN DE EMAIL DE INTERES PROPIEDAD ?>

  <!-- TAREA -->
  <% } else if (id_origen == 17) { %>
    <a class="pull-left thumb-sm bg-info avatar avatar-texto xs m-l-n-md">
      <i title="Tarea" class="fa fa-calendar"></i>
    </a>
    <div class="m-l-lg panel b-a">
      <div class="panel-heading clearfix pos-rlt b-b b-light">
        <span class="arrow left"></span>
        <div class="pb5">
          <b><%= asunto %></b>
          <span class="text-muted fs13 m-l"><i class="fa fa-user m-r-xs"></i> <%= usuario.ucwords() %></span>
          <span class="text-muted fs13 pull-right">
            <i class="fa fa-clock-o"></i>
            <%= mostrar_fecha(fecha,hora) %>
          </span>
        </div>        
      </div>
      <div class="panel-body">
        <div class="consulta_timeline_texto"><%= nl2br(texto) %></div>
      </div>
      <div class="panel-footer">
        <a href="javascript:void(0)" class="btn ver_tarea btn-white">
          <i class="fa fa-pencil m-r-xs"></i>
          Ver Tarea
        </a>
      </div>
    </div>

  <% } else { %>

    <a class="pull-left thumb-sm bg-info avatar avatar-texto xs m-l-n-md">
      <% if (id_origen == 14) { %>
        <i title="Nota" class="fa fa-file-text"></i>
      <% } else if (id_origen == 15) { %>
        <i title="SMS" class="fa fa-commenting"></i>
      <% } else if (id_origen == 5 || id_origen == 9 || id_origen == 10) { %>
        <i title="Email" class="fa fa-envelope"></i>
      <% } else if (id_origen == 4) { %>
        <i title="Telefono" class="fa fa-phone"></i>
      <% } else if (id_origen == 40) { %>
        <i title="Diario El Dia" class="fa fa-globe"></i>
      <% } else if (id_origen == 24) { %>
        <i title="Instagram" class="fa fa-instagram"></i>
      <% } else if (id_origen == 26) { %>
        <i title="Facebook" class="fa fa-facebook"></i>
      <% } else if (id_origen == 27 || id_origen == 30 || id_origen == 31) { %>
        <i title="Whatsapp" class="fa fa-whatsapp"></i>
      <% } else if (id_origen == 3) { %>
        <i title="Personal" class="fa fa-user"></i>
      <% } else if (id_origen == 50) { %>
        <i title="Búsqueda" class="fa fa-search"></i>
      <% } else if (id_origen == 41) { %>
        <i title="Visita" class="fa fa-home"></i>
      <% } else { %>
        <i class="fa fa-user"></i>
      <% } %>
    </a>
    <div class="m-l-lg panel b-a">
      <div class="panel-heading clearfix pos-rlt b-b b-light">
        <span class="arrow left"></span>
        <div>
          <div class="pb5">
            <b><%= (tipo == 1) ? usuario.ucwords() : nombre.ucwords() %></b>
            <% if (id_origen == 10) { %>
              <?php echo lang(array("es"=>"está interesado en","en"=>"is interested in")); ?><%= (id_referencia != 0) ? " por:":":" %>
            <% } else if (id_origen == 3) { %>
              <?php echo lang(array("es"=>"se contactó","en"=>"spoke")); ?><%= (id_referencia != 0) ? " por:":":" %>
            <% } else if (id_origen == 4) { %>
              <?php echo lang(array("es"=>"llamó por teléfono","en"=>"called")); ?><%= (id_referencia != 0) ? " por:":":" %>
            <% } else if (id_origen == 24) { %>
              escribió por Instagram
            <% } else if (id_origen == 26) { %>
              escribió por Facebook
            <% } else if (id_origen == 27) { %>
              escribió por Whatsapp
            <% } else if (id_origen == 41) { %>
              visitará:
            <% } else { %>
              <?php echo lang(array("es"=>"escribió","en"=>"wrote")); ?><%= (id_referencia != 0) ? " por:":":" %>
            <% } %>
            <span class="text-muted fs13 pull-right">

              <?php /*
              <% if ((id_origen == 5 || id_origen == 9 || id_origen == 10) && !isEmpty(fecha_visto)) { %>
                <i class="fa fa-eye text-info mr5" data-toggle="tooltip" title="<%= fecha_visto %>"></i>
              <% } %>
              */ ?>

              <i class="fa fa-clock-o"></i>
              <%= mostrar_fecha(fecha,hora) %>
            </span>
          </div>
          <div class="dt pb5">
            <% if (id_referencia != 0) { %>
              <div class="dtc vam">
                <a href="app/#propiedades/<%= id_referencia %>" class="consulta_propiedad">
                  <% if (!isEmpty(propiedad_path)) { %>
                    <img class="customcomplete-image fn" src="<%= propiedad_path %>"/>
                  <% } %>
                </a>
              </div>
              <div class="dtc vam">
                <span class="h4"><%= propiedad_tipo_inmueble %> en <%= propiedad_tipo_operacion %></span>
                <br/><span class="text-muted fs14"><%= propiedad_direccion %> | <%= propiedad_ciudad %></span>
                <% if (id_empresa_relacion != id_empresa) { %>
                  <span class="label bg-danger m-l-sm">Red</span>
                <% } %>
              </div>
            <% } else if (!isEmpty(asunto)) { %>
              <div class="dtc vam">
                <span class="h4"><%= asunto %></span>
              </div>
            <% } %>
          </div>
        </div>
      </div>
      <% if (id_origen == 1 || id_origen == 5 || id_origen == 9 || id_origen == 10 || id_origen == 27) { %>
        <div class="panel-body">
          <div class="consulta_timeline_texto">
            <%= (isHtml(texto)) ? texto : nl2br(texto) %>
          </div>
          <div class="oh">
            <div class="fl">
              <% for(var k=0;k< adjuntos.length; k++) { %>
                <% var adj = adjuntos[k] %>
                <div>
                  <a href="<%= adj.path %>" target="_blank" class="link"><i class="fa fa-file"></i> <%= adj.path %></a>
                </div>
              <% } %>
            </div>
            <% if (id_origen != 27) { %>
              <a href="javascript:void(0)" class="btn responder_email mt10 btn-white fr">
                <i class="fa fa-mail-forward"></i>
                Responder Email
              </a>
            <% } %>
          </div>
        </div>
      <% } else if (!isEmpty(texto)) { %>
        <div class="panel-body">
          <div class="consulta_timeline_texto"><%= nl2br(texto) %></div>
          <div class="dn editar_texto_container">
            <textarea id="consulta_timeline_edicion_texto" name="texto" class="form-control h100"><%= texto %></textarea>
            <div class="tar m-t-xs">
              <button class="btn btn-default descartar_texto">Cancelar</button>
              <button class="btn btn-info guardar_texto">Guardar</button>
            </div>
          </div>
          <!-- NOTA -->
          <% if (id_origen == 14) { %>          
            <div class="opciones tar">
              <a class="expand-link-2">
                <?php echo lang(array(
                  "es"=>"+ M&aacute;s opciones",
                  "en"=>"+ More options",
                )); ?>
              </a>
            </div>
          <% } %>
        </div>
        <!-- NOTA -->
        <% if (id_origen == 14) { %>          
          <div class="panel-body expand tar">
            <a href="javascript:void(0)" class="btn editar_texto btn-white">
              <i class="fa fa-pencil"></i>
            </a>
            <a href="javascript:void(0)" class="btn eliminar btn-white">
              <i class="fa fa-trash"></i>
            </a>
          </div>
        <% } %>

      <% } %><!-- Fin IF -->

      <% if (children.length > 0) { %>
        <% for (var i=0; i< children.length; i++) { %>
          <% var hijo = children[i] %>
          <div class="panel-body b-b" style="background-color: #f9f9f9">
            <div class="pb5">
              <b><%= hijo.usuario.ucwords() %></b> respondi&oacute;:
              <span class="text-muted fs13 pull-right">
                <i class="fa fa-clock-o"></i>
                <%= mostrar_fecha(hijo.fecha,hijo.hora) %>
              </span>
            </div>
            <div><%= nl2br(hijo.texto) %></div>
            <div>
              <% for(var k=0;k< hijo.adjuntos.length; k++) { %>
                <% var adj = hijo.adjuntos[k] %>
                <div>
                  <a href="<%= adj.path %>" target="_blank" class="link"><i class="fa fa-file"></i> <%= adj.path %></a>
                </div>
              <% } %>
            </div>
          </div>
        <% } %>
      <% } %>

    </div>
  <% } %>
</script>

<script type="text/template" id="nueva_visita_edit_template">
  <div class="modal-header">
    <b>Nueva Visita</b>
    <i class="pull-right cerrar_lightbox fs16 fa fa-times cp"></i>
  </div>
  <form class="modal-body" autocomplete="off">
    <div class="row">
      <div class="col-md-6">    
        <div class="form-group">
          <label>Nombre</label>
          <input type="text" placeholder="Nombre y Apellido" autocomplete="off" id="nueva_visita_nombre" name="nombre" class="form-control"/>
        </div>
      </div>
      <div class="col-md-6">    
        <div class="form-group">
          <label>Email</label>
          <input type="text" placeholder="Email" id="nueva_visita_email" name="email" class="form-control"/>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Celular</label>
          <div class="input-group">
            <span class="input-group-btn">
              <select class="form-control w100" id="nueva_visita_telefono_prefijo" name="fax">
                <?php include("application/views/templates/custom/paises.php"); ?>
              </select>
            </span>        
            <input type="text" placeholder="Celular" id="nueva_visita_telefono" name="telefono" class="form-control"/>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <label>Fecha de la Visita</label>
        <div class="form-group">
          <div class="input-group">
            <input type="text" placeholder="Fecha" id="nueva_visita_fecha" value="<%= fecha %>" class="form-control" name="fecha_ult_operacion"/>
            <span class="input-group-btn">
              <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>        
          </div>
        </div>
      </div>    
    </div>
    <div class="form-group">
      <label>Propiedad</label>
      <div class="input-group">
        <input type="text" disabled placeholder="Interesado en propiedad..." autocomplete="off" id="nueva_visita_propiedad" class="form-control"/>
        <span class="input-group-btn">
          <button data-toggle="tooltip" title="Buscar propiedades" tabindex="-1" type="button" class="btn btn-default buscar_propiedades"><i class="fa fa-search"></i></button>
        </span>        
      </div>
    </div>      
    <div class="form-group">
      <label>Comentarios</label>
      <textarea id="nueva_visita_texto" name="texto" class="form-control" placeholder="Comentarios sobre la visita..."><%= texto %></textarea>
    </div>

    <div class="form-group dn">
      <div class="checkbox">
        <label class="i-checks">
          <input type="checkbox" id="nueva_visita_notificacion"><i></i> 
          <span class="propietario_nombre dib ml5">Notificar al propietario.</span>
        </label>
      </div>                    
    </div>  

    <% if (mostrar_usuarios == 1) { %>

      <div class="form-group">
        <label>Usuario que hara la visita</label>
        <select class="form-control" id="nueva_visita_usuario">
          <option value="0">Sin asignar</option>
          <% for (var i=0; i< usuarios.length; i++) { %>
            <% var u = usuarios.models[i] %>
            <option <%= (u.id == id_usuario)?"selected":"" %> value="<%= u.id %>"><%= u.get("nombre") %></option>
          <% } %>          
        </select>
      </div> 

    <% } %>

  </form>
  <div class="modal-footer clearfix">
    <button class="btn guardar pull-right btn-info">Guardar</button>
  </div>
</div>
</script>