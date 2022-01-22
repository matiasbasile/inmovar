<script type="text/template" id="marcas_panel_template">
  <div class="panel-heading oh">
    <div class="row">
      <div class="col-md-6 col-lg-3 sm-m-b">
        <div class="search_container"></div>
      </div>
      <% if (control.check("marcas") > 1) { %>
        <div class="col-md-6 col-lg-offset-3 col-lg-6 text-right">
          <a class="btn btn-info btn-addon nuevo"><i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo&nbsp;&nbsp;</a>
        </div>
      <% } %>
    </div>
  </div>
  <div class="panel-body">
    <div class="b-a table-responsive">
      <table id="marcas_table" class="table table-striped sortable m-b-none default footable">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input class="esc sel_todos" type="checkbox"><i></i>
              </label>
            </th>
            <th class="w50 tac hidden-xs"></th>
            <th class="sorting" data-sort-by="nombre">Nombre</th>
            <% if (permiso > 1) { %>
              <th class="w100"></th>
            <% } %>
          </tr>
        </thead>
        <tbody></tbody>
        <tfoot class="pagination_container hide-if-no-paging"></tfoot>
      </table>
    </div>
  </div>
</script>


<script type="text/template" id="marcas_item">
  <td>
    <label class="i-checks m-b-none">
      <input class="esc check-row" value="<%= id %>" type="checkbox"><i></i>
    </label>
  </td>
  <td class="ver hidden-xs">
    <% if (!isEmpty(path)) { %><img src="/sistema/<%= path %>" class="customcomplete-image"/><% } %>
  </td>
  <td class="ver"><span class='text-info'><%= nombre %></span></td>
  <% if (permiso > 1) { %>
    <td class="p5 td_acciones">
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
    </td>
  <% } %>
</script>

<script type="text/template" id="marcas_edit_panel_template">
  <div class="modal-body">
  
    <div class="padder">

      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
            <label class="control-label">Nombre</label>
            <input type="text" <%= (!edicion)?"disabled":"" %> name="nombre" class="form-control" id="marcas_nombre" value="<%= nombre %>"/>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label class="control-label">Orden</label>
            <input <%= (!edicion)?"disabled":"" %> type="text" name="orden" class="form-control" id="marcas_orden" value="<%= orden %>"/>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label class="control-label">Grupo</label>
            <input <%= (!edicion)?"disabled":"" %> type="text" name="grupo" class="form-control" id="marcas_grupo" value="<%= grupo %>"/>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
            <label class="control-label">Link</label>
            <input <%= (!edicion)?"disabled":"" %> type="text" name="link" class="form-control" id="marcas_link" value="<%= link %>"/>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label">Descuento</label>
            <input <%= (!edicion)?"disabled":"" %> type="text" name="descuento" class="form-control" id="marcas_descuento" value="<%= descuento %>"/>
          </div>
        </div>
      </div>
      
      <?php
      single_upload(array(
        "name"=>"path",
        "label"=>"Imagen",
        "url"=>"/sistema/marcas/function/save_image/",
        "url_file"=>"/sistema/marcas/function/save_file/",
        "width"=>(isset($empresa->config["marca_image_width"]) ? $empresa->config["marca_image_width"] : 400),
        "height"=>(isset($empresa->config["marca_image_height"]) ? $empresa->config["marca_image_height"] : 400),
        "quality"=>(isset($empresa->config["marca_image_quality"]) ? $empresa->config["marca_image_quality"] : 0.92),
      )); ?>                     
      
    </div>
  </div>
  <div class="modal-footer">
    <% if (edicion) { %>
      <button class="btn guardar btn-success">Guardar</button>
    <% } %>
  </div>

</script>