<script type="text/template" id="web_textos_panel_template">
  <div class=" wrapper-md ng-scope">
	<h1 class="m-n h3">Bloques de Texto</h1>
  </div>
  <div class="wrapper-md ng-scope">
	<div class="panel panel-default">
	  <div class="panel-heading oh">
		<div class="search_container col-lg-3 col-md-4 col-sm-6"></div>
		<a class="btn pull-right btn-success btn-addon" href="app/#web_texto"><i class="fa fa-plus"></i>Nuevo</a>
	  </div>
	  <div class="panel-body">
		<div class="table-responsive">
		  <table id="web_textos_table" data-ordenable-table="web_texto" data-ordenable-where="" class="table table-striped ordenable m-b-none default footable">
			<thead>
			  <tr>
				<th>Titulo</th>
				<th>Template</th>
				<% if (permiso > 1) { %>
				  <th class="w25"></th>
				  <th class="w25"></th>
				<% } %>
			  </tr>
			</thead>
			<tbody></tbody>
			<tfoot class="web_textotion_container hide-if-no-paging"></tfoot>
		  </table>
		</div>
	  </div>
	</div>
  </div>
</script>


<script type="text/template" id="web_textos_item">
	<td><%= titulo %></td>
	<td><%= template %></td>
	<% if (permiso > 1) { %>
		<td><i class="fa fa-file-text-o edit text-dark" data-id="<%= id %>" /></td>
		<td><i class="fa fa-times delete text-danger" data-id="<%= id %>" /></td>
	<% } %>
</script>

<script type="text/template" id="web_textos_edit_panel_template">
<% if (!lightbox) { %>
  <div class=" wrapper-md ng-scope">
	<h1 class="m-n h3">
	  <% if (id == undefined) { %>
		  Nuevo Bloque de Texto
	  <% } else { %>
		  <%= (isEmpty(titulo)) ? clave : titulo %>
	  <% } %>	      
	</h1>
  </div>
  <div class="wrapper-md">
	<div class="tab-container">
		<ul class="nav nav-tabs" role="tablist">
		  <li class="active">
			  <a href="#tab1" role="tab" data-toggle="tab"><i class="fa fa-info"></i>Datos</a>
		  </li>
		</ul>
		<div class="tab-content">
		  <div id="tab1" class="tab-pane active panel-body">
			  <div class="form-horizontal">    
  
				  <div class="form-group">
					  <label class="col-lg-2 control-label tal">Titulo</label>
					  <div class="col-lg-10">
						  <input type="text" name="titulo" class="form-control" id="web_textos_titulo" value="<%= titulo %>"/>
					  </div>
				  </div>
				  <div class="form-group">
					  <label class="col-lg-2 control-label tal">Clave</label>
					  <div class="col-lg-10">
						  <input type="text" name="clave" class="form-control" id="web_textos_clave" value="<%= clave %>"/>
					  </div>
				  </div>
				  <div class="form-group">
					  <label class="col-lg-2 control-label tal">Link</label>
					  <div class="col-lg-10">
						  <input type="text" name="link" class="form-control" id="web_textos_link" value="<%= link %>"/>
					  </div>
				  </div>				  
				  <div class="form-group">
					  <label class="col-lg-2 control-label tal">Template</label>
					  <div class="col-lg-10">
						<select class="form-control" name="id_web_template" id="web_textos_templates"></select>
					  </div>
				  </div>				
				  <div class="form-group">
					  <div class="col-xs-12">
						  <textarea name="texto" id="web_textos_texto"><%= texto %></textarea>
					  </div>
				  </div>
				  
				  <div class="line line-dashed b-b line-lg pull-in"></div>
				  <% if (edicion) { %>
					  <div class="form-group">
						  <div class="col-xs-12">    
							  <button class="btn btn-success guardar">Guardar</button>
						  </div>
					  </div>
				  <% } %>
			  </div>
		  </div>
	  </div>
	</div>
  </div>  
<% } else { %>
  <div class="panel panel-default">
	<div class="panel-heading bold">Editar contenido</div>
	<div class="panel-body">
		<div class="row">
			<% if (es_imagen) { %>
				<div class="col-xs-12">
	            <?php
	            single_upload(array(
	                "name"=>"texto",
	                "label"=>"Imagen",
	                "url"=>"/admin/web_textos/function/save_image/",
	                "url_file"=>"/admin/web_textos/function/save_file/",
	            )); ?>
	      </div>
			<% } else { %>
			<div class="col-xs-12">
				<div class="tab-container">
					<ul class="nav nav-tabs" role="tablist">
					  <li class="active">
						  <a href="#tab1" id="link_tab1" role="tab" data-toggle="tab">Espa&ntilde;ol</a>
					  </li>
					  <li>
						  <a href="#tab2" id="link_tab2" role="tab" data-toggle="tab">Ingl&eacute;s</a>
					  </li>
					  <li>
						  <a href="#tab3" id="link_tab3" role="tab" data-toggle="tab">Portugues</a>
					  </li>
					</ul>
					<div class="tab-content">
					  	<div id="tab1" class="tab-pane active">
							<div class="form-horizontal">    
							  	<div class="form-group">
								  	<div class="col-xs-12">
								  		<textarea name="texto" id="web_textos_texto"><%= texto %></textarea>
								  	</div>
								</div>
							</div>
					   	</div>
						<div id="tab2" class="tab-pane">
							<div class="form-horizontal">    
							  	<div class="form-group">
								  	<div class="col-xs-12">
								  		<textarea name="texto_en" id="web_textos_texto_en"><%= texto_en %></textarea>
								  	</div>
								</div>
							</div>
					   	</div>
						<div id="tab3" class="tab-pane">
							<div class="form-horizontal">    
							  	<div class="form-group">
								  	<div class="col-xs-12">
								  		<textarea name="texto_pt" id="web_textos_texto_pt"><%= texto_pt %></textarea>
								  	</div>
								</div>
							</div>
					   	</div>
					</div>
				</div>
			</div>
			<% } %>

		  	<div class="form-group">
				<div class="col-xs-12">
			  		<input type="text" name="link" class="form-control" id="web_textos_link" placeholder="Link" value="<%= link %>"/>
				</div>
		  	</div>
		</div>

	</div>	
	<div class="panel-footer tar">
	  <button class="btn btn-success guardar">Guardar</button>
	</div>
  </div>
<% } %>
</script>