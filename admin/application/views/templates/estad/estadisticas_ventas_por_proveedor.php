<script type="text/template" id="estadisticas_ventas_por_proveedor_template">
  <div id="estadisticas_ventas_por_proveedor_container" class="col">
    <div class="bg-light titulo-pagina lter b-b wrapper-md">
      <div class="row">
        <div class="col-xs-12">
          <h1 class="m-n h3 text-black">
            <i class="fa fa-bar-chart icono_principal"></i>Estad&iacute;sticas
            / <b>Ventas por Proveedor</b>
          </h1>
        </div>
      </div>
    </div>

    <div class="wrapper-md">

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="">
            <div class="input-group pull-left" style="width: 140px;">
              <input type="text" id="estadisticas_ventas_por_proveedor_fecha_desde" class="form-control">
              <span class="input-group-btn">
                <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
              </span>              
            </div>
            <div class="input-group pull-left" style="width: 140px;">
              <input type="text" id="estadisticas_ventas_por_proveedor_fecha_hasta" class="form-control">
              <span class="input-group-btn">
                <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
              </span>              
            </div>
            <% if (typeof almacenes != "undefined") { %>
              <select class="form-control pull-left m-l-xs" style="display: inline-block; width: 160px;" id="estadisticas_ventas_por_proveedor_sucursales">
                <% if (ID_SUCURSAL != 0) { %>
                  <% for(var i=0; i< almacenes.length; i++) { %>
                    <% var alm = almacenes[i] %>
                    <% if (ID_SUCURSAL == alm.id) { %>
                      <option value="<%= alm.id %>"><%= alm.nombre %></option>
                    <% } %>
                  <% } %>
                <% } else { %>
                  <option value="0">Sucursal</option>
                  <% for(var i=0; i< almacenes.length; i++) { %>
                    <% var alm = almacenes[i] %>
                    <option value="<%= alm.id %>"><%= alm.nombre %></option>
                  <% } %>
                <% } %>
              </select>
            <% } %>
            <button class="btn btn-default buscar pull-left m-l-xs"><i class="fa fa-search"></i></button>

            <div class="btn-group dropdown pull-right">
              <button class="btn btn-default dropdown-toggle btn-addon" data-toggle="dropdown">
                <i class="fa fa-cog"></i><span><?php echo lang(array("es"=>"Opciones","en"=>"Options")); ?></span>
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="javascript:void(0)" class="exportar">Exportar Excel</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table id="estadisticas_ventas_por_proveedor_table" class="table table-small table-striped sortable m-b-none default footable">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Proveedor</th>
                  <th>Cantidad</th>
                  <th>CMV</th>
                  <th>Venta</th>
                  <th>Ganancia</th>
                  <th>%</th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot class="bg-important">
                <tr>
                  <td></td>
                  <td></td>
                  <td id="estadisticas_ventas_por_proveedor_cantidad" class="bold">0</td>
                  <td id="estadisticas_ventas_por_proveedor_costo_final" class="bold">$ 0.00</td>
                  <td id="estadisticas_ventas_por_proveedor_total_final" class="bold">$ 0.00</td>
                  <td id="estadisticas_ventas_por_proveedor_ganancia" class="bold">$ 0.00</td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</script>

<script type="text/template" id="estadisticas_ventas_por_proveedor_item_template">
  <td><%= id_proveedor %></td>
  <td><span class="text-info"><%= proveedor %></span></td>
  <td><%= Number(cantidad).toFixed(2) %></td>
  <td>$ <%= Number(costo_final).toFixed(2) %></td>
  <td>$ <%= Number(total_final).toFixed(2) %></td>
  <td>$ <%= Number(total_final - costo_final).toFixed(2) %></td>
  <% var porc = (total_general > 0) ? (total_final * 100 / total_general) : 0 %>
  <td><%= Number(porc).toFixed(3) %> %</td>
</script>