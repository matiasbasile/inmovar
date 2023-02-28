<script type="text/template" id="agenda_calendario_view">
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-md-4">
          <h1>Agenda</h1>
        </div>
      </div>
    </div>
    
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <% if (SOLO_USUARIO == 0) { %>
            <div class="col-md-3">
              <div class="form-group">
                <label>Filtro por usuario</label>
                <select class="form-control buscar" id="agenda_id_usuario">
                  <option value="-1">Todos los usuarios</option>
                  <option value="0">Sin asignar</option>
                  <% for (var i=0; i< usuarios.length; i++) { %>
                    <% var u = usuarios.models[i] %>
                    <option value="<%= u.id %>"><%= u.get("nombre") %></option>
                  <% } %>              
                </select>
              </div>
            </div>
          <% } %>
        </div>
        <div id="agenda_calendario"></div>
      </div>
    </div>
  </div>   
</script>
