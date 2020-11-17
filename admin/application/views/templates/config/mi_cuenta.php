<script type="text/template" id="mi_cuenta_template">  
  <div class="centrado rform">
    <div class="header-lg">
      <h1>Mi Cuenta</h1>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="panel padder-v item <%= moment(FECHA_PROX_VENC).isAfter(moment()) ? "bg-success" : "bg-danger" %> tac" style="height: 140px">
          <div class="h2 text-white m-t-md">$ <%= Number(saldo).format(2) %></div>
          <span class="text-muted text-md pt10 db">Saldo</span>
        </div>
      </div>
      <div class="col-md-3">
        <div class="panel padder-v item tac" style="height: 140px">
          <div class="h2 m-t-md"><%= moment(FECHA_PROX_VENC).format("DD/MM/YYYY") %></div>
          <span class="text-muted text-md pt10 db">Vencimiento</span>
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="table-responsive">
        <table id="mi_cuenta_table" class="table table-striped sortable footable">
          <thead>
            <tr>
              <th>Comprobante</th>
              <th>Plan</th>
              <th>Vencimiento</th>
              <th>Total</th>
              <th>Estado</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <% for(var i=0; i< comprobantes.length; i++) { %>
              <% var c = comprobantes[i] %>
              <tr>
                <td><%= c.comprobante %></td>
                <td><span class="text-info"><%= c.articulo %></span></td>
                <td><%= c.fecha %></td>
                <td><%= Number(c.total).format() %></td>
                <td>
                  <% if (c.pagada == 1) { %>
                    <span class="label bg-success">Pagada</span>
                  <% } else { %>
                    <span class="label bg-danger">Vencida</span>
                  <% } %>
                </td>
                <td>
                  <% if (c.pagada == 0 && !isEmpty(c.preference)) { %>
                    <a class="btn btn-default" href="<%= c.preference %>" target="_blank">
                      Pagar
                    </a>
                  <% } %>
                </td>                    
                <td>
                  <a class="btn btn-default" href="facturas/function/ver_pdf/<%= c.id %>/<%= c.id_punto_venta %>/<%= c.id_empresa %>/" target="_blank">
                    Ver Comprobante
                  </a>
                </td>
              </tr>
            <% } %>
          </tbody>
          <tfoot class="pagination_container hide-if-no-paging"></tfoot>
        </table>
      </div>
    </div>
	</div>  
</script>