<script type="text/template" id="perfiles_panel_template">
  <div class="row mb20">
    <div class="row pl10 pr10">
      <a class="btn pull-right btn-info nuevo" href="javascript:void(0)">&nbsp;&nbsp;<?php echo lang(array("es"=>"Nuevo Perfil","en"=>"New Profile")); ?>&nbsp;&nbsp;</a>
    </div>
  </div>
  <div class="table-responsive">
    <table id="perfiles_table" class="table table-striped m-b-none default footable">
      <thead>
        <tr>
          <th><?php echo lang(array("es"=>"Nombre","en"=>"Name")); ?></th>
          <th class="th_acciones w120"><?php echo lang(array("es"=>"Acciones","en"=>"Actions")); ?></th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</script>


<script type="text/template" id="perfiles_item">
  <td><span class="ver text-info"><%= nombre %></span></td>
  <td>
    <% if (principal == 0) { %>
      <div class="btn-group dropdown ml10">
        <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-plus"></i>
        </button>    
        <ul class="dropdown-menu pull-right">
        <li><a href="javascript:void(0)" class="delete" data-id="<%= id %>"><?php echo lang(array("es"=>"Eliminar","en"=>"Delete")); ?></a></li>
        </ul>
      </div>  
    <% } %>
  </td>
</script>

<script type="text/template" id="perfiles_edit_panel_template">
<div class="modal-header">
  <b>Editar perfil</b>
  <i class="pull-right cerrar_lightbox fs20 fa fa-times cp"></i>
</div>
<div class="modal-body">
  <div class="form-group">
    <label class="control-label"><?php echo lang(array("es"=>"Nombre","en"=>"Name")); ?></label>
    <input type="text" name="nombre" class="form-control" id="perfiles_edit_nombre" value="<%= nombre %>"/>
  </div>
  <% if (USUARIO_PPAL == 1) { %>
    <div class="form-group">
      <div class="checkbox">
        <label class="i-checks">
          <input type="checkbox" name="solo_usuario" class="checkbox" value="1" <%= (solo_usuario == 1)?"checked":"" %>><i></i>
          <?php echo lang(array("es"=>"Mostrar solamente la informacion creada por el usuario","en"=>"Show only the information created by the user")); ?>
        </label>
      </div>        
    </div>
  <% } %>
  <div class="form-group b-a" style="overflow: auto; max-height: 400px">
    <div class="table-responsive">
      <table id="perfiles_tabla" class="table m-b-none default footable">
        <thead>
          <tr>
            <th class="vam"><?php echo lang(array("es"=>"Modulo","en"=>"Module")); ?></th>
            <th class="vam">
              <?php echo lang(array("es"=>"Permiso","en"=>"Permission")); ?>
              <div class="fr">
                <button class="btn btn-default btn-sm font-bold todos_administrables"><i class="fa fa-arrow-up"></i></button>
                <button class="btn btn-default btn-sm font-bold todos_ocultos"><i class="fa fa-arrow-down"></i></button>
              </div>
            </th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
  </div>
</script>