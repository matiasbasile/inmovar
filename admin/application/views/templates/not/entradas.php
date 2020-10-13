<script type="text/template" id="entradas_resultados_template">
  <div class="row mb20">
    <div class="col-md-4 sm-m-b">
      <div class="form-group">
        <input type="text" id="entradas_buscar" placeholder="<?php echo lang(array("es"=>"Buscar","en"=>"Search")); ?>..." value="<%= window.entradas_filter %>" autocomplete="off" class="form-control">
      </div>
    </div>
    <div class="col-md-4 sm-m-b">
      <div class="input-group">
        <select id="entradas_buscar_categorias" class="w100p"></select>
        <span class="input-group-btn">
          <button class="btn btn-default buscar"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </div>
    <div class="col-md-4 text-right">
      <% if (control.check("entradas")>2) { %>
        <a class="btn btn-info btn-addon nuevo ml5" href="javascript:void(0)">
          <?php echo lang(array("es"=>"&nbsp;&nbsp;Nueva Página&nbsp;&nbsp;","en"=>"&nbsp;&nbsp;New&nbsp;&nbsp;")); ?>
        </a>
      <% } %>
    </div>
  </div>
  <div class="bulk_action wrapper pb0">
    <button class="btn btn-default eliminar_lote btn-addon"><?php echo lang(array("es"=>"Eliminar","en"=>"Delete")); ?></button>
  </div>

  <div class="table-responsive">
    <table id="entradas_tabla" class="table table-striped sortable m-b-none default footable">
      <thead>
        <tr>
          <th style="width:20px;">
            <label class="i-checks m-b-none">
              <input class="esc sel_todos" type="checkbox"><i></i>
            </label>
          </th>
          <th class="w50 tac"><?php echo lang(array("es"=>"Imagen","en"=>"Image")); ?></th>
          <th class="sorting" data-sort-by="titulo"><?php echo lang(array("es"=>"T&iacute;tulo","en"=>"Title")); ?></th>
          <th class="sorting" data-sort-by="categoria"><?php echo lang(array("es"=>"Categor&iacute;a","en"=>"Category")); ?></th>
          <th class="th_acciones w150"><?php echo lang(array("es"=>"Acciones","en"=>"Actions")); ?></th>
        </tr>
      </thead>
      <tbody class="tbody"></tbody>
      <tfoot class="pagination_container hide-if-no-paging"></tfoot>
    </table>
  </div>
</script>

<script type="text/template" id="entradas_item_resultados_template">
  <% var clase = (activo==1)?"":"text-muted"; %>
  <td>
    <label class="i-checks m-b-none">
      <input class="esc check-row" value="<%= id %>" type="checkbox"><i></i>
    </label>
  </td>
  <td class="<%= clase %> data">
    <% if (!isEmpty(path)) { %>
      <img src="<%= show_path(path) %>" class="customcomplete-image"/>
    <% } %>
  </td>
  <td class="<%= clase %> data">
    <span class="text-info"><%= titulo %></span>
  </td>
  <td class="<%= clase %> data"><%= categoria %></td>
  <td class="tar <%= clase %>">
    <a target="_blank" href="https://<%= String(DOMINIO+link+'?preview=1').replace('//','/') %>"><i title="Ir a pagina" class="fa-external-link iconito fa"></i></a>
    <i title="Activo" class="fa-check iconito fa activo <%= (activo == 1)?"active":"" %>"></i>
    <i title="Destacado" class="fa fa-star iconito destacado <%= (destacado == 1)?"active":"" %>"></i>
    <div class="btn-group dropdown">
      <i title="Opciones" class="iconito fa fa-caret-down dropdown-toggle" data-toggle="dropdown"></i>
      <ul class="dropdown-menu pull-right">
        <li><a href="javascript:void(0)" class="duplicar" data-id="<%= id %>"><?php echo lang(array("es"=>"Duplicar","en"=>"Duplicate")); ?></a></li>
        <li><a href="javascript:void(0)" class="eliminar" data-id="<%= id %>"><?php echo lang(array("es"=>"Eliminar","en"=>"Delete")); ?></a></li>
      </ul>
    </div>
  </td>
</script>


<script type="text/template" id="entrada_template">
<?php include("entradas_detalle.php"); ?>
</script>
