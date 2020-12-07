<script type="text/template" id="consultas_tipos_tree_panel_template">
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-md-6">
          <h1>Estados</h1>
        </div>
        <?php /*
        <div class="col-md-6 tar">
          <a class="btn btn-info nuevo" href="javascript:void(0)">
            <span>&nbsp;&nbsp;Nuevo Estado&nbsp;&nbsp;</span>
          </a>
        </div>
        */ ?>
      </div>
    </div>  
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        Arrastre los estados de acuerdo al orden que seguirán las consultas
      </div>
      <div class="panel-body clearfix">
        <div ui-jq="nestable" class="dd">
          <ol class="dd-list">
            <% for(var i=0;i<consultas_tipos.length;i++) { %>
              <% var o = consultas_tipos[i] %>
              <li class="dd-item dd3-item" data-id="<%= o.id %>">
                <div class="dd-handle dd3-handle">Drag</div>
                <div class="dd3-content">
                  <a href="javascript:void" class="editar cp text-info"><%= o.nombre %></a>
                </div>       
              </li>
            <% } %>
          </ol>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/template" id="consultas_tipos_edit_panel_template">
<div class="modal-header">
  <b><%= (id == undefined) ? "Nueva Categoria" : nombre+" ("+id+")" %></b>
  <i class="pull-right cerrar fs16 fa fa-times cp"></i>
</div>  
<div class="modal-body">
  <div class="form-group">
    <label class="control-label">Nombre</label>
    <input <%= (!edicion)?"disabled":"" %> placeholder="Ej: En proceso, pendiente, en espera de confirmación, etc." type="text" name="nombre" class="form-control" id="consultas_tipos_nombre" value="<%= nombre %>"/>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label">Aviso de vencimiento luego de (días):</label>
        <input <%= (!edicion)?"disabled":"" %> placeholder="Días" type="text" name="tiempo_vencimiento" class="form-control" id="consultas_tipos_tiempo_vencimiento" value="<%= tiempo_vencimiento %>"/>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label">Mover a Archivados despues de (días):</label>
        <input <%= (!edicion)?"disabled":"" %> placeholder="Días" type="text" name="tiempo_abandonado" class="form-control" id="consultas_tipos_tiempo_abandonado" value="<%= tiempo_abandonado %>"/>
      </div>
    </div>
  </div>
</div>
<?php //<% if (control.check("consultas")>1) { %>?>
  <div class="modal-footer clearfix tar">
    <% if (id != undefined && control.check("consultas")>2) { %>
      <button class="btn btn-danger eliminar fl">Eliminar</button>
    <% } %>
    <button class="btn guardar btn-info">Guardar</button>
  </div>
<?php //<% } %>?>
</script>