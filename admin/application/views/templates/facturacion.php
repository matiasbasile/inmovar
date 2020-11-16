<script type="text/template" id="facturacion_edit_panel_template">
  <?php include("fact/facturacion_edit_comprobante.php"); ?>
</script>

<script type="text/template" id="factura_item_template">
  <% var clase = "editar" %>
  <td class="<%= clase %>"><%= Number(cantidad).toFixed(2) %></td>
  <td class="<%= clase %>">
    <%= (anulado==1 && control.check("estadisticas_ventas")>=3)?"(ANULADO) <br/>":"" %><%= nombre %>
    <%= (typeof variante != undefined && !isEmpty(variante)) ? "<br/><span class='text-muted'>"+variante+"</span>" : "" %>
    <% if (custom_3 == 1) { %>
      <span class="label bg-warning m-l reservado">Reservado</span>
    <% } %>
    <% if (!isEmpty(descripcion)) { %><br/><span class="text-muted"><%= descripcion %></span><% } %>
  </td>
  <td class="<%= clase %>"><%= Number(((discrimina_iva) ? neto : precio)).toFixed(2) %></td>
  <td><%= Number(bonificacion).toFixed(2) %>%</td>
  <td class="<%= clase %>"><%= Number(((discrimina_iva) ? total_sin_iva : total_con_iva)).toFixed(2) %></td>
  <% if (edicion) { %>
    <td class="w25 p5">
      <% if (id_factura == 0) { %>
        <i title="Eliminar" class="glyphicon glyphicon-remove do_eliminar text-danger" />
      <% } %>
    </td>
  <% } %>
</script>