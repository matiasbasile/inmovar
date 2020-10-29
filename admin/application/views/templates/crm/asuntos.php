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
