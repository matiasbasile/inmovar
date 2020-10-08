<script type="text/template" id="clientes_etiquetas_panel_template">
    
    <div class=" wrapper-md ng-scope">
      <h1 class="m-n h3">Listado de Etiquetas</h1>
    </div>
    <div class="wrapper-md ng-scope">
        <div class="panel panel-default">
        
            <div class="panel-heading oh">
                <div class="search_container col-lg-4 col-md-6 col-sm-9 col-xs-12"></div>
                <a class="btn pull-right btn-success btn-addon" href="app/#entrada_etiqueta"><i class="fa fa-plus"></i>Nueva</a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="clientes_etiquetas_table" class="table table-striped sortable m-b-none default footable">
                        <thead>
                            <tr>
                                <th class="sorting" data-sort-by="nombre">Nombre</th>
                                <% if (permiso > 1) { %>
                                    <th class="w25"></th>
                                    <th class="w25"></th>
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
</script>


<script type="text/template" id="clientes_etiquetas_item">
	<td><span class='ver'><%= nombre %></span></td>
	<% if (permiso > 1) { %>
		<td><i class="fa fa-file-text-o edit text-dark" data-id="<%= id %>" /></td>
		<td><i class="fa fa-times delete text-danger" data-id="<%= id %>" /></td>
	<% } %>
</script>

<script type="text/template" id="clientes_etiquetas_edit_panel_template">

<div class=" wrapper-md ng-scope">
  <h1 class="m-n h3">
    <% if (id == undefined) { %>
        Nueva Etiqueta
    <% } else { %>
        <%= nombre %>
    <% } %>	      
  </h1>
</div>

<div class="wrapper-md ng-scope">
    <div class="panel panel-default">
    
        <div class="panel-heading">
            <span class="font-bold">Ingrese los datos</span>
        </div>
        <div class="panel-body">
        
            <div class="form-horizontal">

                <div class="form-group">
                    <label class="col-lg-2 control-label">Nombre</label>
                    <div class="col-lg-10">
                        <% if (edicion) { %>
                            <input type="text" name="nombre" class="form-control" id="clientes_etiquetas_nombre" value="<%= nombre %>"/>
                        <% } else { %>
                            <span><%= nombre %></span>
                        <% } %>
                    </div>
                </div>				
				
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <% if (edicion) { %>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn guardar btn-success">Guardar</button>
                        </div>
                    </div>
                <% } %>
            </div>
        </div>
    </div>
</div>

</script>