<script type="text/template" id="busquedas_resultados_template">
<% if (ID_PLAN == 1) { %>
  <div class="centrado rform mt30 mb30">
    <div class="panel panel-default tac">
      <div class="panel-body">
        <h1>Búsquedas</h1>
        <p>Inmovar</p>
        <div>
          <img style="max-width:450px;" class="w100p mb30" src="resources/images/busquedas.png" />
        </div>
        <p style="max-width:450px;" class="mb30 mla mra fs16">Aumente las ventas mejorando el seguimiento de clientes con <span class="c-main">Inmovar CRM</span></p>
        <a class="btn btn-lg btn-info mb30" href="app/#precios">
          <span>&nbsp;&nbsp;Activar Búsquedas&nbsp;&nbsp;</span>
        </a>
      </div>    
    </div>
  </div>
<% } else { %>
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-md-6 col-xs-8">
          <h1>Búsquedas</h1>
        </div>
        <div class="col-md-6 col-xs-4 tar">
          <a class="btn btn-info" href="app/#busquedas/0">
            <span class="material-icons show-xs">add</span>
            <span class="hidden-xs">&nbsp;&nbsp;Nueva Búsqueda&nbsp;&nbsp;</span>
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

      <div class="panel-body pb0">

        <div class="mb20">
          <div class="clearfix">
            <div class="row">
              <div class="col-xs-12 sm-m-b">
                <div class="input-group">
                  <input value="<%= window.busquedas_filter %>" type="text" id="busquedas_buscar" placeholder="Buscar..." autocomplete="off" class="form-control">
                  <span class="input-group-btn">
                    <button class="btn btn-default buscar"><i class="fa fa-search"></i></button>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="busquedas_tabla_cont" class="table-responsive">
          <table id="busquedas_tabla" class="table <%= (seleccionar)?'table-small':'' %> table-striped sortable m-b-none default footable">
            <thead>
              <tr>
                <th>Descripción</th>
                <th>Valores</th>
                <th>Descripción</th>
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
<% } %>
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
  <td><%= texto %></td>
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