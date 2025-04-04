<script type="text/template" id="clientes_panel_template">
<% if (ID_PLAN == 1) { %>
  <div class="centrado rform mt30 mb30">
    <div class="panel panel-default tac">
      <div class="panel-body">
        <h1>Contactos</h1>
        <p>Centraliza todos tus clientes en un solo lugar</p>
        <div>
          <img style="max-width:450px;" class="w100p mb30" src="resources/images/contactos.png" />
        </div>
        <p style="max-width:450px;" class="mb30 mla mra fs16">Guarda una copia completa de todos los contactos que consultaron a tu inmobiliaria en la <span class="c-main">Agenda de Contactos</span></p>
        <a class="btn btn-lg btn-info mb30" href="app/#precios">
          <span>&nbsp;&nbsp;Activar Contactos&nbsp;&nbsp;</span>
        </a>
      </div>    
    </div>
  </div>
<% } else { %>
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-md-6 col-xs-8">
          <h1>Contactos</h1>
        </div>
        <div class="col-md-6 col-xs-4 tar">
          <% if (permiso > 1) { %>
            <% if (window.clientes_custom_3 == 1) { %>
              <a href="app/#cliente/0" class="btn btn-info">
                <span class="material-icons show-xs">add</span>
                <span class="hidden-xs">&nbsp;&nbsp;Nuevo Contacto&nbsp;&nbsp;</span>
              </a>
            <% } else if (window.clientes_custom_4 == 1) { %>
              <a href="app/#inquilino/0" class="btn btn-info">
                <span class="material-icons show-xs">add</span>
                <span class="hidden-xs">&nbsp;&nbsp;Nuevo Inquilino&nbsp;&nbsp;</span>
              </a>
            <% } else if (window.clientes_custom_5 == 1) { %>
              <a href="app/#propietario/0" class="btn btn-info">
                <span class="material-icons show-xs">add</span>
                <span class="hidden-xs">&nbsp;&nbsp;Nuevo Propietario&nbsp;&nbsp;</span>
              </a>
            <% } %>
          <% } %>
        </div>
      </div>
    </div>

    <div class="tab-container mb0">
      <ul class="nav nav-tabs nav-tabs-2" role="tablist">
        <li id="clientes_tab" class="<%= (window.clientes_custom_3 == 1)?"active":"" %>">
          <a href="app/#clientes">
            <i class="material-icons">directions_run</i>
            Contactos
            <span id="clientes_counter" class="counter">0</span>
          </a>
        </li>
        <li id="inquilinos_tab" class="<%= (window.clientes_custom_4 == 1)?"active":"" %>">
          <a href="app/#inquilinos">
            <i class="material-icons">vpn_key</i>
            Inquilinos
            <span id="inquilinos_counter" class="counter">0</span>
          </a>
        </li>
        <li id="propietarios_tab" class="<%= (window.clientes_custom_5 == 1)?"active":"" %>">
          <a href="app/#propietarios">
            <i class="material-icons">home</i>
            Propietarios
            <span id="propietarios_counter" class="counter">0</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="panel panel-default">

      <div class="panel-body">

        <div class="mb20">
          <div class="clearfix">
            <div class="row">
              <div class="col-xs-12 sm-m-b">
                <div class="input-group">
                  <input type="text" id="clientes_buscar" value="<%= window.clientes_filter %>" placeholder="<?php echo lang(array("es"=>"Buscar","en"=>"Search")); ?>..." autocomplete="off" class="form-control">
                  <span class="input-group-btn">
                    <button class="btn btn-default buscar ml5"><i class="fa fa-search"></i></button>
                  </span>
                  <% if (permiso > 2) { %>
                    <span class="input-group-btn ml5">
                      <button class="btn btn-default btn-addon btn-addon-2 exportar_excel">
                        <i class="fa fa-upload"></i><span><?php echo lang(array("es"=>"Exportar","en"=>"Export")); ?></span>
                      </button>
                    </span>
                  <% } %>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table id="clientes_table" class="table table-striped sortable m-b-none default footable">
            <thead>
              <tr>
                <th style="width:20px;"></th>
                <th class="w50 tac hidden-xs"></th>
                <th class="sorting" data-sort-by="nombre"><?php echo lang(array("es"=>"Nombre","en"=>"Name")); ?></th>
                <% if (ID_EMPRESA == 1) { %>
                  <th>Venc.</th>
                <% } %>
                <th class="col-xxs-0">Telefono</th>
                <th class="col-xxs-0">Email</th>
                <% if (permiso > 1) { %>
                  <th class="th_acciones w120"><?php echo lang(array("es"=>"Acciones","en"=>"Actions")); ?></th>
                <% } %>
              </tr>
            </thead>
            <tbody></tbody>
            <tfoot class="pagination_container hide-if-no-paging"></tfoot>
          </table>
        </div>
      </div>

    </div>
  </div>
<% } %>
</script>


<script type="text/template" id="clientes_item">
  <% var clase = (activo==1)?"":"text-muted"; %>
  <td>
    <label class="i-checks m-b-none">
      <input class="esc check-row" value="<%= id %>" type="checkbox"><i></i>
    </label>
  </td>
  <td class="<%= clase %> data hidden-xs">
  <% if (!isEmpty(path)) { %>
    <% if (path.indexOf("http") == 0) { %>
      <img src="<%= path %>" class="customcomplete-image"/>
    <% } else { %>
      <img src="/admin/<%= path %>" class="customcomplete-image"/>
    <% } %>
  <% } else { %>
    <span class="avatar xs avatar-texto pull-left">
      <%= isEmpty(nombre) ? email.substr(0,1).toUpperCase() : nombre.substr(0,1).toUpperCase() %>
    </span>
  <% } %>
  </td>
  <td class='data'>
    <% if (isEmpty(nombre)) { %>
      <span class="capitalize <%= (activo==1)?'text-info':'text-muted' %>"><%= email %></span>
    <% } else { %>
      <span class="capitalize <%= (activo==1)?'text-info':'text-muted' %>"><%= nombre.ucwords() %></span>
    <% } %>
  </td>
  <% if (ID_EMPRESA == 1) { %>
    <td><%= fecha_vencimiento %></td>
  <% } %>
  <td>
    <% if (!isEmpty(telefono)) { %>
      <span><i class="fa mr5 fa-whatsapp"></i> <%= telefono %></span>
    <% } %>
  </td>
  <td>
    <% if (!isEmpty(email)) { %>
      <span><i class="fa mr5 fa-envelope-o"></i> <%= email %></span>
    <% } %>
  </td>
  <% if (permiso > 1) { %>
    <td class="<%= clase %> td_acciones">
      <i title="Activo" data-toggle="tooltip" class="fa-check iconito fa activo <%= (activo == 1)?"active":"" %>"></i>
      <div class="btn-group dropdown ml10">
        <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-plus"></i>
        </button>    
        <ul class="dropdown-menu pull-right">
          <% if (ID_EMPRESA == 341) { %>
            <% if (activo==1) { %>
              <li><a class="activar_laboral_gym" data-activo="0" href="javascript:void(0)">Desactivar</a></li>
            <% } else { %>
              <li><a class="activar_laboral_gym" data-activo="1" href="javascript:void(0)">Activar</a></li>
            <% } %>
          <% } %>
          <% if (permiso == 3) { %>
            <li><a href="javascript:void(0)" class="delete" data-id="<%= id %>">Eliminar</a></li>
          <% } %>
        </ul>
      </div>  
    </td>
  <% } %>
</script>

<script type="text/template" id="clientes_edit_panel_template">
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-md-6 col-xs-8">
          <h1>Contactos</h1>
        </div>
      </div>
    </div>
    <?php include("cli/clientes_detalle_3.php"); ?>
    <% if (edicion) { %>
      <div class="tar mb30">
        <button class="btn guardar btn-info btn-lg"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
      </div>
    <% } %>
  </div>
</div>
</script>

<script type="text/template" id="clientes_edit_mini_panel_template">
<div class="panel pb0 mb0">
  <div class="panel-body">
    
    <div class="form-group">
      <input type="text" autocomplete="off" placeholder="Nombre" name="nombre" class="tab form-control" id="clientes_mini_nombre"/>
    </div>
    <div class="form-group">
      <input type="text" autocomplete="off" name="email" placeholder="Email" class="form-control" id="clientes_mini_email"/>
    </div>

    <div class="form-group">
      <button class="btn btn-default ver_avanzadas btn-block">Ver m&aacute;s</button>
    </div>
    <div id="clientes_edit_mini_avanzadas" style="display: none;">
      <div class="form-group">
        <input type="text" autocomplete="off" name="telefono" placeholder="Telefono" class="form-control" id="clientes_mini_telefono"/>
      </div>    
      <div class="form-group">
        <input type="text" autocomplete="off" placeholder="Direccion" name="direccion" class="tab form-control" id="clientes_mini_direccion"/>
      </div>
    </div>

    <div class="form-group">
      <button class="btn guardar btn-success tab btn-block">Guardar</button>
    </div>
  </div>
</div>
</script>



<script type="text/template" id="clientes_timeline_panel_template">
<div class=" wrapper-md ng-scope">
  <h1 class="m-n h3"><i class="<%= clase_modulo %> icono_principal"></i><%= titulo_modulo %>
    / <b><%= (id == undefined)?"Nuevo":nombre.ucwords() %></b>
  </h1>
</div>
<div class="wrapper-md">
<div class="centrado rform">
    <div class="row">

      <div class="col-md-4">

        <div class="panel panel-default">
          <div class="panel-body">
            <div class="padder">
              <div class="row tac-xs">
                <div class="col-md-3 col-xs-12">
                  <% if (!isEmpty(path)) { %>
                    <img src="/admin/<%= path %>" class="customcomplete-image xl"/>
                  <% } else { %>
                    <span class="avatar xl avatar-texto <%= (activo==1)?'bg-info':'bg-light dker' %>">
                      <%= isEmpty(nombre) ? email.substr(0,1).toUpperCase() : nombre.substr(0,1).toUpperCase() %>
                    </span>
                  <% } %>
                </div>
                <div class="col-md-9 col-xs-12">
                  <h3 class="m-t-sm m-b-xs"><%= nombre.ucwords() %> </h3>
                  <a class="text-azul fs14"><%= email.toLowerCase() %></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="bold"><?php echo lang(array("es"=>"Acerca de","en"=>"About ")); ?> <%= nombre.ucwords() %> </span>
          </div>
          <div class="panel-body acerca_de">
            <div class="form-group">
              <label class="control-label"><?php echo lang(array("es"=>"Nombre","en"=>"Name")); ?></label>
              <span class="control-info"><%= nombre.ucwords() %></span>
            </div>
            <div class="form-group">
              <label class="control-label"><?php echo lang(array("es"=>"Teléfono","en"=>"Phone")); ?></label>
              <span class="control-info">+<%= fax %> <%= telefono %></span>
            </div>
            <div class="form-group">
              <div class="btn-group dropdown">
                <% if (tipo == 0) { %>
                  <button class="btn btn-sm btn-success btn-addon btn-addon2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-thumbs-up"></i><?php echo lang(array("es"=>"Con venta","en"=>"With sales")); ?></button>
                <% } else if (tipo == 1) { %>
                  <button class="btn btn-sm btn-warning btn-addon btn-addon2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-clock-o"></i><?php echo lang(array("es"=>"A contactar","en"=>"To contact")); ?></button>
                <% } else if (tipo == 2) { %>
                  <button class="btn btn-sm btn-info btn-addon btn-addon2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-check"></i><?php echo lang(array("es"=>"En progreso","en"=>"In progress")); ?></button>
                <% } else if (tipo == 3) { %>
                  <button class="btn btn-sm btn-danger btn-addon btn-addon2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-thumbs-down"></i><?php echo lang(array("es"=>"Sin venta","en"=>"Without sales")); ?></button>
                <% } %>
                <span class="fs12 m-l-xs"><i class="fa fa-caret-down"></i></span>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)" class="editar_tipo" data-tipo="1"><?php echo lang(array("es"=>"A contactar","en"=>"To contact")); ?></a></li>
                  <li><a href="javascript:void(0)" class="editar_tipo" data-tipo="2"><?php echo lang(array("es"=>"En progreso","en"=>"In progress")); ?></a></li>
                  <li><a href="javascript:void(0)" class="editar_tipo" data-tipo="0"><?php echo lang(array("es"=>"Con venta","en"=>"With sales")); ?></a></li>
                  <li><a href="javascript:void(0)" class="editar_tipo" data-tipo="3"><?php echo lang(array("es"=>"Sin venta","en"=>"Without sales")); ?></a></li>
                </ul>
              </div>  
            </div>
            <div class="form-group mb0 tar">
              <a class="btn btn-white" href="app/#<%= tipo_cliente %>/<%= id %>">
              <i class="fa fa-pencil m-r-xs"></i>
              Editar
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div id="cliente_crear_consultas"></div>
        <div class="streamline b-l b-info m-l-lg m-b padder-v fs14"></div>
      </div>
      
    </div>

  </div>
</div>
</script>