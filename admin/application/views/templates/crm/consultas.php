<script type="text/template" id="consultas_panel_template">
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-md-6">
          <h1>Seguimiento</h1>
        </div>
        <div class="col-md-6 tar">
          <a class="btn btn-info nuevo_cliente" href="javascript:void(0)">
            <span>&nbsp;&nbsp;Nueva Consulta&nbsp;&nbsp;</span>
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
              <span class="consultas_estado consultas_estado_<%= tipo.id %>">(0)</span>
            </a>
          </li>
        <% } %>
        <li>
          <a href="app/#consultastipos" class="btn-tab-large">
            <i class="material-icons md-22 mr0">settings</i>
          </a>
        </li>
      </ul>
    </div>
    <div class="panel panel-default">
      <div class="panel-body pb0">

        <div class="mb20 mt15">
          <div class="clearfix">
            <div class="row">
              <div class="col-md-4 sm-m-b">
                <div class="input-group">
                  <input type="text" id="consultas_buscar" value="<%= window.consultas_filter %>" placeholder="<?php echo lang(array("es"=>"Buscar","en"=>"Search")); ?>..." autocomplete="off" class="form-control">
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
                <th style="min-width:250px"><?php echo lang(array("es"=>"Nombre","en"=>"Name")); ?></th>
                <th class="pl0" colspan="2">Interesado en</th>
                <th>Origen</th>
                <th class="w150">Acciones</th>
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
  <td class="pr0">
    <label class="i-checks m-b-none">
      <input class="esc check-row" value="<%= id %>" type="checkbox"><i></i>
    </label>
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
          <% for (var i=0; i< usuarios.length; i++) { %>
            <% var u = usuarios.models[i] %>
            <option <%= (u.id == id_usuario)?"selected":"" %> value="<%= u.id %>"><%= u.get("nombre") %></option>
          <% } %>
        </select>
      </div>
    </div>
  </td>
  <td class="p0 data">
    <% if (!isEmpty(propiedad_path)) { %>
      <% var prefix = (propiedad_path.indexOf("http") == 0) ? "" : "/admin/" %>
      <img src="<%= prefix + propiedad_path %>?t=<%= Math.ceil(Math.random()*10000) %>" class="customcomplete-image"/>
    <% } %>
  </td>
  <td class="data">
    <% if (propiedad_id != 0) { %>
      <%= propiedad_direccion %>, <%= propiedad_ciudad %>
      <br/><%= propiedad_tipo_operacion %>
    <% } else { %>
      <span>Asignar interés</span>
    <% } %>
  </td>
  <td class="data">
    <span style="color:#5a5a5a">
      <% if (id_origen == 30) { %>
        <i class="fa fa-whatsapp"></i> Whatsapp
      <% } else { %>
        <i class="fa fa-globe"></i> Web
      <% } %>
    </span>
    <br/><span><%= (moment("DD/MM/YYYY") == fecha)?"Hoy":fecha %> <%= hora %></span>
  </td>
  <td>
    <button data-toggle="tooltip" title="Click para realizar acción" class="btn etiqueta btn-menu-compartir mostrar_estado">
      Vencida
    </button>
  </td>
</script>

<script type="text/template" id="consulta_edit_template">
<div class="panel panel-default mb0">
  <div class="panel-heading font-bold">
    <%= (!isEmpty(asunto)) ? asunto : ((id == undefined) ? "<?php echo lang(array("es"=>"Nueva Consulta","en"=>"New Contact")); ?>" : "<?php echo lang(array("es"=>"Consulta","en"=>"Contact")); ?>") %>
    <i class="pull-right cerrar_lightbox fa fa-times cp"></i>
  </div>
  <form class="panel-body" autocomplete="off">
    <div class="form-group">
      <input type="text" placeholder="<?php echo lang(array("es"=>"Nombre y Apellido","en"=>"Full Name")); ?>" autocomplete="off" id="consulta_cliente_nombre" name="nombre" class="form-control"/>
    </div>  
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <input type="text" placeholder="<?php echo lang(array("es"=>"Tel&eacute;fono","en"=>"Telephone")); ?>" autocomplete="off" id="consulta_cliente_telefono" name="telefono" class="form-control"/>
        </div>  
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <input type="text" placeholder="<?php echo lang(array("es"=>"Email","en"=>"Email Address")); ?>" id="consulta_cliente_email" autocomplete="off" name="email" class="form-control"/>
        </div>  
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        <div class="form-group">
          <div class="input-group">
            <input type="text" placeholder="<?php echo lang(array("es"=>"Fecha","en"=>"Date")); ?>" id="consulta_fecha" autocomplete="off" value="<%= fecha %>" class="form-control" name="fecha"/>
            <span class="input-group-btn">
              <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>        
          </div>
        </div>
      </div>  
      <div class="col-xs-6">
        <div class="form-group">
          <div class="btn-group">
            <label data-id_origen="4" data-toggle="tooltip" title="<?php echo lang(array("es"=>"Tel&eacute;fono","en"=>"Telephone")); ?>" class="btn btn-default active btn-info id_origen"><i class="fa fa-phone"></i></label>
            <label data-id_origen="5" data-toggle="tooltip" title="Email" class="btn btn-default id_origen"><i class="fa fa-envelope"></i></label>
            <label data-id_origen="26" data-toggle="tooltip" title="Facebook" class="btn btn-default id_origen"><i class="fa fa-facebook"></i></label>
            <label data-id_origen="3" data-toggle="tooltip" title="Personal" class="btn btn-default id_origen"><i class="fa fa-users"></i></label>
            <label data-id_origen="27" data-toggle="tooltip" title="Whatsapp" class="btn btn-default id_origen"><i class="fa fa-whatsapp"></i></label>
          </div>
        </div>
      </div>  
    </div>
    <div class="form-group">
      <textarea name="texto" class="form-control h100" placeholder="<?php echo lang(array("es"=>"Escriba aqui la consulta...","en"=>"Write the query here...")); ?>" id="consulta_texto"><%= texto %></textarea>
    </div>
    <?php /*
    <% if (control.check("propiedades")>0) { %>
      <div class="form-group">
        <div class="checkbox">
          <label class="i-checks">
            <input type="checkbox" checked=""><i></i> Enviar ficha de propiedad al contacto al guardar.
          </label>
        </div>                  
      </div>
    <% } %>
    */ ?>
  </form>
  <div class="panel-footer clearfix">
    <button class="cerrar_lightbox btn btn-default"><?php echo lang(array("es"=>"Cerrar","en"=>"Close")); ?></button>
    <button class="btn guardar pull-right btn-info"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
  </div>
</div>
</script>

<script type="text/template" id="crear_consulta_timeline_template">
  <div class="panel panel-default mb0">
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
      <li>
        <a id="tab_link_observacion" href="#tab_observacion" role="tab" data-toggle="tab"><i class="fa fa-file-text text-muted"></i> Nota</a>
      </li>
    </ul>
    <div class="tab-content">
      <div id="tab1" class="tab-pane panel-body <%= (active_tab=='tab1')?'active':'' %>">
        <div class="form-group">
          <div class="input-group">
            <input type="text" id="consulta_email_asunto" placeholder="Asunto" class="form-control"/>
            <div class="input-group-btn dropdown">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
          <textarea id="consulta_email_texto"></textarea>
        </div>      
        <div class="form-group clearfix">
          <div class="fl">
            <div class="w200">
              <span class="btn btn-default fileinput-button">
                <i class="glyphicon glyphicon-folder-open m-r-xs"></i>
                <span>Adjuntar archivos</span>
                <input id="fileupload_timeline" type="file" name="files[]" multiple>
              </span>
              <div id="progress_timeline" class="progress" style="display: none">
                <div class="progress-bar progress-bar-success"></div>
              </div>
              <div id="files_timeline" class="files"></div>
            </div>
          </div>
          <button class="btn btn-pd btn-info guardar_email fr">Enviar</button>
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
            <textarea id="consulta_whatsapp" placeholder="Escribe aqui tu mensaje..." class="form-control h100 no-model"></textarea>
          </div>
          <div class="form-group clearfix">
            <% if (alerta_celular) { %>
              <div class="alert alert-warning mb0 p5 fl alert-dismissable">
                <i class="fa fa-warning"></i>
                Atenci&oacute;n! La persona no tiene cargada un celular de contacto.
              </div>
            <% } %>
            <button class="btn btn-pd btn-info enviar_whatsapp fr">Enviar</button>
          </div>
        </div>
      <% } %>

      <% if (mostrar_tarea) { %>
        <div id="tab_tarea" class="tab-pane panel-body <%= (active_tab=='tab_tarea')?'active':'' %>">
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
      <div id="tab_nota" class="tab-pane panel-body <%= (active_tab=='tab_nota')?'active':'' %>">
        <div class="form-group">
          <textarea id="consulta_nota" placeholder="Escribe aqui alguna nota u observacion..." class="form-control no-model h100"></textarea>
        </div>
        <div class="form-group tar">
          <button class="btn btn-pd btn-info guardar_nota fr">Guardar</button>
        </div>
      </div>
      <div id="tab_observacion" class="tab-pane panel-body <%= (active_tab=='tab_observacion')?'active':'' %>">
        <div class="form-group">
          <textarea id="consulta_observacion" placeholder="Escribe aqui alguna nota u observacion..." class="form-control no-model h100"><%= nota %></textarea>
        </div>
        <div class="form-group tar">
          <button class="btn btn-pd btn-info guardar_observacion fr">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</script>



<script type="text/template" id="cambiar_estado_consulta_template">
<div class="panel panel-default mb0">
  <div class="panel-body">

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
            <div><%= telefono %></div>
          </div>
        </div>

      </div>
      <div class="col-md-5">
        <div class="form-group">
          <label class="control-label bold">Cambiar de estado</label>
          <div>
            <div class="btn-group dropdown w100p">
              <button class="btn btn-info btn-lg tac w100p dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><%= consulta_tipo %></button>
              <span class="fs12 m-l-xs"></span>
              <ul class="dropdown-menu">
                <% for (var i=0;i< consultas_tipos.length;i++) { %>
                  <% var t = consultas_tipos[i] %>
                  <li><a href="javascript:void(0)" class="editar_tipo" data-tipo="<%= t.id %>"><%= t.nombre %></a></li>
                <% } %>          
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <ul class="nav nav-tabs nav-tabs-2" role="tablist">
      <% var active_tab = "tab1" %>
      <li class="active">
        <a href="#tab_nota_cambiar_estado" role="tab" data-toggle="tab"><span class="material-icons fs14 mr5">help</span> Motivo</a>
      </li>
      <li>
        <a href="#tab_tarea_cambiar_estado" role="tab" data-toggle="tab"><span class="material-icons fs14 mr5">event</span> Actividad</a>
      </li>
    </ul>
    <div class="tab-content">
      <div id="tab_tarea_cambiar_estado" class="tab-pane panel-body b-a">
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <div class="input-group">
                <select id="cambiar_estado_consulta_asuntos" class="select w100p"></select>
                <span class="input-group-btn">
                  <button tabindex="-1" class="btn btn-default agregar_asunto">+</button>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <div class="input-group">
                    <input placeholder="Fecha" type="text" class="form-control no-model" id="cambiar_estado_consulta_fecha"/>
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

      <div id="tab_nota_cambiar_estado" class="tab-pane panel-body b-a active">
        <div class="form-group">
          <select class="form-control no-model">
            <option>Seleccione un motivo</option>
            <option>No esta interesado</option>
            <option>Dejó de responder</option>
          </select>
        </div>
        <div class="form-group">
          <textarea id="consulta_nota" placeholder="Escribe aqui alguna nota u observacion..." class="form-control no-model h100"></textarea>
        </div>
        <div class="form-group tar">
          <button class="btn btn-pd btn-info guardar_nota fr">Guardar</button>
        </div>
      </div>
    </div>
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
              <% if (!isEmpty(fecha_visto)) { %>
                <i class="fa fa-eye text-info mr5" data-toggle="tooltip" title="<%= fecha_visto %>"></i>
              <% } %>
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
      <% } else if (id_origen == 26) { %>
        <i title="Facebook" class="fa fa-facebook"></i>
      <% } else if (id_origen == 27 || id_origen == 30 || id_origen == 31) { %>
        <i title="Whatsapp" class="fa fa-whatsapp"></i>
      <% } else if (id_origen == 3) { %>
        <i title="Personal" class="fa fa-user"></i>
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
              <?php echo lang(array("es"=>"est&aacute; interesado en","en"=>"is interested in")); ?>
            <% } else if (id_origen == 3) { %>
              <?php echo lang(array("es"=>"se contact&oacute;","en"=>"spoke")); ?>
            <% } else if (id_origen == 4) { %>
              <?php echo lang(array("es"=>"llam&oacute;","en"=>"called")); ?>
            <% } else { %>
              <?php echo lang(array("es"=>"escribi&oacute;","en"=>"wrote")); ?>
            <% } %>
            <%= (id_referencia != 0) ? " por:":":" %>
            <span class="text-muted fs13 pull-right">

              <% if ((id_origen == 5 || id_origen == 9 || id_origen == 10) && !isEmpty(fecha_visto)) { %>
                <i class="fa fa-eye text-info mr5" data-toggle="tooltip" title="<%= fecha_visto %>"></i>
              <% } %>

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
                <span class="h4"><%= asunto %></span>
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
              <a href="javascript:void(0)" class="btn responder_email btn-white fr">
                <i class="fa fa-mail-forward"></i>
                Responder
              </a>
            <% } %>
          </div>
        </div>
      <% } else { %>
        <div class="panel-body">
          <div class="consulta_timeline_texto"><%= nl2br(texto) %></div>
          <div class="dn editar_texto_container">
            <textarea id="consulta_timeline_edicion_texto" name="texto" class="form-control h100"><%= texto %></textarea>
            <div class="tar m-t-xs">
              <button class="btn btn-default descartar_texto">Cancelar</button>
              <button class="btn btn-success guardar_texto">Guardar</button>
            </div>
          </div>
          <!-- NOTA -->
          <% if (id_origen == 14) { %>          
            <div class="opciones tar">
              <a class="expand-link">
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
              <i class="fa fa-pencil"></i> Editar
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


<script type="text/template" id="email_template">
<div class="panel panel-default mb0">
  <div class="panel-heading font-bold">
    Enviar Email
    <i class="pull-right cerrar_lightbox fa fa-times cp"></i>
  </div>
  <div class="panel-body">
    <div class="form-horizontal">
      <div class="form-group">
        <div class="col-sm-3 col-md-2 col-xs-12">
          <label class="control-label">Para:</label>
        </div>
        <div class="col-sm-9 col-md-10 col-xs-12">
          <input type="text" name="email" id="email_nombre" value="<%= email %>" class="form-control"/>
        </div>
      </div>      
      <div class="form-group">
        <div class="col-sm-3 col-md-2 col-xs-12">
          <label class="control-label">Asunto:</label>
        </div>
        <div class="col-sm-9 col-md-10 col-xs-12">
          <div class="input-group">
            <input type="text" name="asunto" id="email_asunto" value="<%= asunto %>" class="form-control"/>
            <div class="input-group-btn dropdown">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Plantillas <span class="caret"></span>
              </button>
              <ul class="dropdown-menu pull-right">
                <li><a class="cargar_plantilla" href="javascript:void(0)">Cargar</a></li>
                <li><a class="guardar_plantilla" href="javascript:void(0)">Guardar</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="form-group col-xs-12">
        <span class="btn btn-default fileinput-button">
          <i class="glyphicon glyphicon-folder-open m-r-xs"></i>
          <span>Adjuntar archivos</span>
          <input id="fileupload" type="file" name="files[]" multiple>
        </span>
        <div id="progress" class="progress" style="display: none">
          <div class="progress-bar progress-bar-success"></div>
        </div>
        <div id="files" class="files"></div>
      </div>

      <% if (links_adjuntos.length > 0) { %>
        <div class="form-group">
          <div class="col-sm-3 col-md-2 col-xs-12">
            <label class="control-label">Fichas:</label>
          </div>
          <div class="col-sm-9 col-md-10 col-xs-12">
            <% for (var i=0;i< links_adjuntos.length;i++) { %>
              <% var adjunto = links_adjuntos[i]; %>
              <button data-position="<%= i %>" class="btn btn-default m-b"><%= adjunto.nombre %><i class="ml5 eliminar_adjunto fa fa-times"></i></button>
            <% } %>
          </div>
        </div>
      <% } %>

      <div class="form-group">
        <div class="col-xs-12">
          <textarea name="texto" id="email_texto"><%= texto %></textarea>
        </div>
      </div>      
    </div>
  </div>
  <div class="panel-footer clearfix">
    <button class="btn guardar pull-right btn-info btn-addon">
      <i class="fa fa-send"></i><span>Enviar</span>
    </button>
  </div>
</div>
</script>



<script type="text/template" id="asuntos_panel_template">
  <div class=" wrapper-md ng-scope">
    <h1 class="m-n h3"><i class="fa fa-cog icono_principal"></i><?php echo lang(array("es"=>"Configuracion","en"=>"Configuration")); ?>
      / <b>Asuntos</b>
    </h1>
  </div>
  <div class="wrapper-md ng-scope">
    <div class="panel panel-default">
    
      <div class="panel-heading oh">
        <div class="row">
          <div class="col-md-6 col-lg-3 sm-m-b">
            <div class="search_container"></div>
          </div>
          <div class="col-md-6 col-lg-offset-3 col-lg-6 text-right">
            <a class="btn btn-info btn-addon" href="app/#asunto"><i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo&nbsp;&nbsp;</a>
          </div>
        </div>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table id="asuntos_table" class="table table-striped sortable m-b-none default footable">
            <thead>
              <tr>
                <th style="width:20px;">
                  <label class="i-checks m-b-none">
                    <input class="esc sel_todos" type="checkbox"><i></i>
                  </label>
                </th>
                <th class="sorting" data-sort-by="nombre">Nombre</th>
                <th class="w100"></th>
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


<script type="text/template" id="asuntos_item">
  <td>
    <label class="i-checks m-b-none">
      <input class="esc check-row" value="<%= id %>" type="checkbox"><i></i>
    </label>
  </td>
  <td class="ver"><span class='text-info'><%= nombre %></span></td>
  <td class="p5 td_acciones">
    <% if (id_empresa > 0) { %>
      <i title="Activo" class="fa-check iconito fa activo <%= (activo == 1)?"active":"" %>"></i>
      <div class="btn-group dropdown ml10">
        <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-plus"></i>
        </button>   
        <ul class="dropdown-menu pull-right">
          <li><a href="javascript:void(0)" class="duplicar" data-id="<%= id %>">Duplicar</a></li>
          <li><a href="javascript:void(0)" class="delete" data-id="<%= id %>">Eliminar</a></li>
        </ul>
      </div>
    <% } %>
  </td>
</script>

<script type="text/template" id="asuntos_edit_panel_template">
<div class=" wrapper-md ng-scope">
  <h1 class="m-n h3"><i class="fa fa-cog icono_principal"></i><?php echo lang(array("es"=>"Configuracion","en"=>"Configuration")); ?>
    / Asuntos
    / <b><%= (id == undefined) ? 'Nuevo' : nombre %></b>
  </h1>
</div>
<div class="wrapper-md ng-scope">
  <div class="centrado rform">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-body">
          
            <div class="padder">
              <div class="form-group">
                <label class="control-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="asuntos_nombre" value="<%= nombre %>"/>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Color</label>
                    <input type="text" name="color" class="form-control" id="asuntos_color" value="<%= color %>"/>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Orden</label>
                    <input type="text" name="orden" class="form-control" id="asuntos_orden" value="<%= orden %>"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <% if (id_empresa > 0) { %>
          <button class="btn guardar btn-success">Guardar</button>
        <% } %>
      </div>
    </div>
  </div>
</div>

</script>

<script type="text/template" id="asuntos_edit_mini_panel_template">
<div class="panel pb0 mb0">
  <div class="panel-body">
    <div class="oh m-b">
      <h4 class="h4 pull-left">Nuevo asunto</h4>
      <i class="pull-right fa fa-times text-muted cp cerrar"></i>
    </div>
    <div class="form-group">
      <input placeholder="Nombre" type="text" name="nombre" class="form-control tab" id="asuntos_mini_nombre" value="<%= nombre %>"/>
    </div>
    <div class="form-group clearfix mb0">
      <a target="_blank" href="app/#asuntos" class="fl btn btn-default"><i class="fa fa-pencil"></i></a>
      <button class="btn guardar fr tab btn-success">Guardar</button>
    </div>
  </div>
</div>
</script>

<script type="text/template" id="consultas_item_template">
  <a class="avatar-letra avatar mt0 thumb pull-left m-r" href="app/#cliente_acciones/<%= id_contacto %>">
    <%= (isEmpty(nombre)) ? email.substr(0,1) : nombre.substr(0,1) %>
  </a>
  <div class="pull-right text-sm text-muted text-right">
    <span class="hidden-xs"><%= fecha %></b> a las <b><%= hora %> hs.</b></span>
    <% if (!isEmpty(email_usuario)) { %>
      <br/><span class="consulta_hace">
        Respondido por: <span class="label bg-light m-l-sm ng-binding"><%= email_usuario %></span>
      </span>
    <% } %>   
  </div>
  <div class="clear">
    <div>
        <a class="text-md" href="app/#cliente_acciones/<%= id_contacto %>">
          <%= (isEmpty(nombre)) ? email : nombre %>
        </a>
        <% if (!isEmpty(usuario)) { %><span class="label bg-light m-l-sm ng-binding"><%= usuario %></span><% } %>
    </div>
    <a href="app/#cliente_acciones/<%= id_contacto %>" class="text-ellipsis m-t-xs"><%= (isEmpty(texto)) ? asunto : ((texto.length > 120) ? texto.substr(0,120)+"..." : texto) %></a>
  </div>
</script>

<script type="text/template" id="consultas_tipos_tree_panel_template">
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-md-6">
          <h1>Estados</h1>
        </div>
        <div class="col-md-6 tar">
          <a class="btn btn-info nuevo" href="javascript:void(0)">
            <span>&nbsp;&nbsp;Nuevo Estado&nbsp;&nbsp;</span>
          </a>
        </div>
      </div>
    </div>  
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        Arrastre los estados de acuerdo al orden que seguirán las consultas
      </div>
      <div class="panel-body clearfix">
        <div ui-jq="nestable" class="dd">
          <ol class="dd-list">
            <% for(var i=0;i<consultas_tipos.length;i++) { %>
              <% var o = consultas_tipos[i] %>
              <li class="dd-item dd3-item" data-id="<%= o.id %>">
                <div class="dd-handle dd3-handle">Drag</div>
                <div class="dd3-content">
                  <a href="javascript:void" class="editar cp text-info"><%= o.nombre %></a>
                </div>       
              </li>
            <% } %>
          </ol>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/template" id="consultas_tipos_edit_panel_template">
<div class="panel panel-default rform">
  <div class="panel-heading">
    <b><%= (id == undefined) ? "Nueva Categoria" : nombre+" ("+id+")" %></b>
    <i class="fa fa-times cerrar fr cp"></i>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <label class="control-label">Nombre</label>
      <input <%= (!edicion)?"disabled":"" %> placeholder="Ej: En proceso, pendiente, en espera de confirmación, etc." type="text" name="nombre" class="form-control" id="consultas_tipos_nombre" value="<%= nombre %>"/>
    </div>

    <h4 class="bold">Automatización:</h4>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Vencimiento despues de (días):</label>
          <input <%= (!edicion)?"disabled":"" %> placeholder="Días" type="text" name="tiempo_proximo_estado" class="form-control" id="consultas_tipos_tiempo_proximo_estado" value="<%= tiempo_proximo_estado %>"/>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Mover a Archivados despues de (días):</label>
          <input <%= (!edicion)?"disabled":"" %> placeholder="Días" type="text" name="tiempo_vencimiento" class="form-control" id="consultas_tipos_tiempo_vencimiento" value="<%= tiempo_vencimiento %>"/>
        </div>
      </div>
    </div>
  </div>
  <?php //<% if (control.check("consultas")>1) { %>?>
    <div class="panel-footer clearfix tar" style="border-top: none">
      <% if (id != undefined && control.check("consultas")>2) { %>
        <button class="btn btn-danger eliminar fl">Eliminar</button>
      <% } %>
      <button class="btn guardar btn-info">Guardar</button>
    </div>
  <?php //<% } %>?>
</div>
</script>