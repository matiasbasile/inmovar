<li id="buscar_propias_tab" class="buscar_tab <%= (window.propiedades_buscar_red == 0)?"active":"" %>">
  <a href="javascript:void(0)">
    <i class="material-icons">store</i> Mis Propiedades
    <span id="propiedades_propias_total" class="counter">0</span>
  </a>
</li>
<% if (control.check("permisos_red")>0 || PROJECT_NAME == "Inmovar") { %>
  <li id="buscar_red_tab" class="buscar_tab <%= (window.propiedades_buscar_red == 1)?"active":"" %>">
    <a href="javascript:void(0)">
      <img class="svg" style="width: 17px; margin-right: 5px; position: relative; top: -2px;" src="resources/images/logo.svg" /> Red Inmovar La Plata
      <span id="propiedades_red_total" class="counter">0</span>
    </a>
  </li>
  <li id="buscar_red_tab_caba" class="buscar_tab <%= (window.propiedades_buscar_red == 2)?"active":"" %>">
    <a href="javascript:void(0)">
      <img class="svg" style="width: 17px; margin-right: 5px; position: relative; top: -2px;" src="resources/images/logo.svg" /> Red Inmovar CABA
      <span id="propiedades_red_total_caba" class="counter">0</span>
    </a>
  </li>
<% } %>
<li id="buscar_inactivas_tab" class="buscar_tab <%= (window.propiedades_buscar_red == 2)?"active":"" %>">
  <a href="javascript:void(0)">
    <i class="material-icons">domain_disabled</i> Desactivas
    <span id="propiedades_inactivas_total" class="counter">0</span>
  </a>
</li>
<?php /*
<li id="buscar_similitudes_tab" class="buscar_tab <%= (window.propiedades_buscar_red == 2)?"active":"" %>">
  <a href="javascript:void(0)">
    <i class="material-icons">warning</i> Similitudes
    <span id="propiedades_similitudes_total" class="counter">0</span>
  </a>
</li>
*/ ?>
