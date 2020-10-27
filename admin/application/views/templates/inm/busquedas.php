<script type="text/template" id="busquedas_resultados_template">
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-md-6">
          <h1>Búsquedas</h1>
        </div>
        <div class="col-md-6 tar">
          <a class="btn btn-info" href="app/#busquedas/0">
            <span>&nbsp;&nbsp;Nueva Búsqueda&nbsp;&nbsp;</span>
          </a>
        </div>
      </div>
    </div>

    <div class="tab-container mb0">
      <ul class="nav nav-tabs nav-tabs-2" role="tablist">
        <li id="buscar_propias_tab" class="buscar_tab <%= (window.busquedas_buscar_red == 0)?"active":"" %>">
          <a href="javascript:void(0)">
            <i class="material-icons">store</i> Búsquedas Activas
            <span id="busquedas_propias_total" class="counter">0</span>
          </a>
        </li>
      </ul>
    </div>

    <div class="panel panel-default">

      <div class="panel-heading pt15 clearfix">
        <div class="row">

          <div class="col-md-3 col-sm-6 col-xs-12 mh50 pr5 pl5">
            <div class="form-group">
              <input value="<%= window.busquedas_filter %>" type="text" id="busquedas_buscar" placeholder="Buscar..." autocomplete="off" class="form-control">
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12 mh50 pr5 pl5">
            <div class="form-group">
              <div class="input-group">
                <select multiple="multiple" class="form-control no-model" id="busquedas_buscar_localidades"></select>
                <span class="input-group-btn">
                  <div class="btn-group dropdown pull-right ml0">
                    <button class="btn btn-default dropdown-toggle btn-addon" data-toggle="dropdown">
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                      <% for (var i=0;i< Math.min(window.localidades.length,10); i++) { %>
                        <% var localidad = window.localidades[i] %>
                        <li><a href="javascript:void(0)" data-id="<%= localidad.id %>" data-nombre="<%= localidad.nombre %>" class="setear_localidad"><%= localidad.nombre %> (<%= localidad.cantidad %>)</a></li>
                      <% } %>
                    </ul>
                  </div>
                </span>
              </div>
            </div>
          </div>

          <div class="col-md-2 col-sm-6 col-xs-12 mh50 pr5 pl5">
            <div class="form-group">
              <select style="width: 100%" id="busquedas_buscar_tipos_operacion">
                <% for(var i=0;i< window.tipos_operacion.length;i++) { %>
                  <% var o = tipos_operacion[i]; %>
                  <option <%= (window.busquedas_id_tipo_operacion == o.id)?"selected":"" %> value="<%= o.id %>"><%= o.nombre %></option>
                <% } %>
              </select>
            </div>
          </div>    

          <div class="col-md-2 col-sm-6 col-xs-12 mh50 pr5 pl5">
            <div class="form-group">
              <select style="width: 100%" id="busquedas_buscar_tipos_inmueble">
                <% for(var i=0;i< window.tipos_inmueble.length;i++) { %>
                  <% var o = tipos_inmueble[i]; %>
                  <option <%= (window.busquedas_id_tipo_inmueble == o.id)?"selected":"" %> value="<%= o.id %>"><%= o.nombre %></option>
                <% } %>
              </select>    
            </div>
          </div>

          <div class="col-md-2 col-sm-6 col-xs-12 mh50 pr5 pl5">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn-advanced-search m-l mt10 advanced-search-btn"><i class="fa fa-plus-circle"></i><span><?php echo lang(array("es"=>"M&aacute;s Filtros","en"=>"More Filters")); ?></span></button>
              </span>
            </div>
          </div>

        </div>
      </div>

      <div class="panel-body pb0">

        <div id="busquedas_tabla_cont" class="table-responsive">
          <table id="busquedas_tabla" class="table <%= (seleccionar)?'table-small':'' %> table-striped sortable m-b-none default footable">
            <thead>
              <tr>
                <th>Descripción</th>
                <th>Operación</th>
                <th>Inmobiliaria</th>
              </tr>
            </thead>
            <tbody class="tbody"></tbody>
            <tfoot class="pagination_container hide-if-no-paging"></tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

</script>

<script type="text/template" id="busquedas_item_resultados_template">
  <% var clase = ""; %>
  <td class="<%= clase %> data">
    <%= tipo_inmueble %> en <%= tipo_operacion %><br/>
    <%= localidad %>
  </td>
  <td class="<%= clase %> data">
    Desde: <%= moneda %> <%= Number(precio_desde).format(0) %><br/>
    Hasta: <%= moneda %> <%= Number(precio_hasta).format(0) %><br/>
  </td>
  <td>
    <div class="dt">
      <div class="dtc">
        <% if (isEmpty(logo_inmobiliaria)) { %>
          <img class="w100p" src="<%= logo_inmobiliaria %>"/>
        <% } %>
      </div>
      <div class="dtc">
        <b class="text-dark"><%= inmobiliaria %></b><br/>
        <button class="btn etiqueta btn-menu-compartir mt10">
          Contactar
        </button>
      </div>
    </div>
  </td>
</script>


<script type="text/template" id="busqueda_template">
<?php include("busquedas_detalle.php") ?>
</script>

<script type="text/template" id="busqueda_preview_template">
  <?php include_once("busqueda_preview.php") ?>
</script>