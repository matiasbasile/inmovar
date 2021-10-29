<script type="text/template" id="novedades_table">
    
    <div class=" wrapper-md ng-scope">
      <h1 class="m-n h3">Listado de Novedades</h1>
    </div>    

    <div class="wrapper-md ng-scope">
        <div class="panel panel-default">
        
            <div class="panel-heading oh">
                <div class="search_container col-lg-4 col-md-6 col-sm-9 col-xs-12"></div>
                <a class="btn pull-right btn-success btn-addon" href="app/#novedad"><i class="fa fa-plus"></i>Nuevo</a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="novedades_table" class="table table-striped sortable m-b-none default footable">
                        <thead>
                            <tr>
                                <th>Titulo</th>
                                <th class="w25"></th>
                                <th class="w25"></th>
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


<script type="text/template" id="novedades_item">
	<td><span class='ver'><%= titulo %></span></td>
	<td><i class="fa fa-file-text-o edit text-dark" data-id="<%= id %>" /></td>
	<td><i class="fa fa-times delete text-danger" data-id="<%= id %>" /></td>
</script>

<script type="text/template" id="novedades_edit">

<div class=" wrapper-md ng-scope">
  <h1 class="m-n h3">
    <% if (id == undefined) { %>
        Nueva Novedad
    <% } else { %>
        <%= titulo %>
    <% } %>	      
  </h1>
</div>

<div class="wrapper-md ng-scope">
    <div class="panel panel-default">
    
        <div class="panel-heading">
            <span class="font-bold">Ingrese los datos</span>
        </div>
        <div class="panel-body">
        
            <div class="wrapper-md">
		     
              <div class="form-group">
                <label class="control-label">Titulo</label>
                <input type="text" required name="titulo" id="novedades_tiulo" value="<%= titulo %>" class="form-control"/>
              </div>     

                <?php
                    single_upload(array(
                    "name"=>"path",
                    "label"=>"Imagen principal",
                    "url"=>"/admin/novedades/function/save_image/",
                    )); 
                ?>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <% if (edicion) { %>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button class="btn guardar btn-success fr">Guardar</button>
                        </div>
                    </div>
                <% } %>
            </div>
        </div>
    </div>
</div>

</script>