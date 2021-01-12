<div class="tab-container mb0">
  <ul class="nav nav-tabs nav-tabs-2" role="tablist">
    <li class="<%= (active=='alquileres')?'active':''%>">
      <a href="<%= (active=='alquileres')?'javascript:void(0)':'app/#alquileres' %>">
        <i class="material-icons">vpn_key</i>
        Alquileres
      </a>
    </li>
    <li class="<%= (active=='recibos_alquileres_adeudados')?'active':''%>">
      <a href="<%= (active=='recibos_alquileres_adeudados')?'javascript:void(0)':'app/#recibos_alquileres/0' %>">
        <i class="material-icons">pending_actions</i>
        Por cobrar
      </a>
    </li>
    <li class="<%= (active=='recibos_alquileres_pagados')?'active':''%>">
      <a href="<%= (active=='recibos_alquileres_pagados')?'javascript:void(0)':'app/#recibos_alquileres/1' %>">
        <i class="material-icons">done</i>
        Pagados
      </a>
    </li>
    <li class="<%= (active=='cuentas_corrientes_clientes')?'active':''%>">
      <a href="<%= (active=='cuentas_corrientes_clientes')?'javascript:void(0)':'app/#cuentas_corrientes_clientes' %>">
        <i class="material-icons">people</i>
        Cuenta Corriente
      </a>
    </li>
  </ul>
</div>