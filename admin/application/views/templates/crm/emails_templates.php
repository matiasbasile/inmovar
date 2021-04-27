<script type="text/template" id="emails_templates_panel_template">
<% if (seleccion) { %>
  <div class="modal-header">
    <b>Seleccionar una plantilla</b>
    <i class="pull-right cerrar_lightbox fs16 fa fa-times cp"></i>
  </div>
  <div class="modal-body">
    <div class="form-group">
      <div class="search_container"></div>
    </div>
    <div class="table-responsive" style="overflow: auto; max-height: 400px">
      <table id="emails_templates_table" data-ordenable-table="email_template" data-ordenable-where="" class="table table-small table-striped ordenable m-b-none default footable">
        <thead>
          <tr colspan="2">
            <th><?php echo lang(array("es"=>"Nombre","en"=>"Name")); ?></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
<% } else { %>
  <div class="panel panel-default" style="border: none;">
    <div class="panel-heading clearfix">
      <div class="row">
        <div class="search_container col-lg-3 col-md-6"></div>
        <div class="col-md-6 col-lg-offset-3 col-lg-6 text-right">
          <a class="btn pull-right btn-info btn-addon nuevo" href="javascript:void(0)"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo lang(array("es"=>"Nuevo","en"=>"New")); ?>&nbsp;&nbsp;</a>
        </div>
      </div>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table id="emails_templates_table" data-ordenable-table="email_template" data-ordenable-where="" class="table table-striped ordenable m-b-none default footable">
          <thead>
            <tr>
              <th><?php echo lang(array("es"=>"Asunto","en"=>"Subject")); ?></th>
              <th class="w25"></th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot class="pagination_container hide-if-no-paging"></tfoot>
        </table>
      </div>
    </div>
  </div>
<% } %>
</script>


<script type="text/template" id="emails_templates_item">
  <td class="edit"><%= nombre %></td>
  <td>
    <% if (!seleccion) { %>
      <div class="btn-group dropdown">
        <i title="Opciones" class="iconito fa fa-caret-down dropdown-toggle" data-toggle="dropdown"></i>
        <ul class="dropdown-menu pull-right">
          <li><a href="javascript:void(0)" class="delete" data-id="<%= id %>"><?php echo lang(array("es"=>"Eliminar","en"=>"Delete")); ?></a></li>
        </ul>
      </div>
    <% } %>
  </td>
</script>

<script type="text/template" id="emails_templates_edit_panel_template">
<% if (!lightbox) { %>
  <div class=" wrapper-md ng-scope">
    <h1 class="m-n h3"><i class="fa fa-cog icono_principal"></i><?php echo lang(array("es"=>"Configuraci&oacute;n","en"=>"Configuration")); ?>
      / <?php echo lang(array("es"=>"Plantillas de Emails","en"=>"Email Templates")); ?>
      / <b><%= (id == undefined) ? "<?php echo lang(array("es"=>"Nuevo","en"=>"New")); ?>":"<?php echo lang(array("es"=>"Editar","en"=>"Edit")); ?>" %></b>
    </h1>
  </div>
  <div class="wrapper-md">
    <div class="centrado rform">

      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="padder">
                <div class="form-group">
                  <label class="control-label"><?php echo lang(array("es"=>"Asunto","en"=>"Subject")); ?></label>
                  <input type="text" name="nombre" class="form-control" id="emails_templates_nombre" value="<%= nombre %>"/>
                </div>
                <?php if (isset($volver_superadmin) && $volver_superadmin == 1) { ?>
                  <div class="form-group">
                    <label class="control-label"><?php echo lang(array("es"=>"Clave","en"=>"Key")); ?></label>
                    <input type="text" name="clave" class="form-control" id="emails_templates_clave" value="<%= clave %>"/>
                  </div>
                <?php } ?>
                <div class="form-group">
                  <textarea name="texto" id="emails_templates_texto"><%= texto %></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="line b-b m-b-lg"></div>

      <div class="row">
        <div class="col-md-10 col-md-offset-1 tar">
          <button class="btn guardar btn-success"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>
      </div>

    </div>
  </div>
  
  <% } else { %>
    <div class="panel panel-default">
      <div style="font-size: 14px;" class="panel-heading bold"><b><%= (id == undefined) ? "<?php echo lang(array("es"=>"Nueva plantilla","en"=>"New")); ?>":"<?php echo lang(array("es"=>"Editar plantilla","en"=>"Edit")); ?>" %></b></div>
      <div class="panel-body">
        <div class="form-group">
          <label for="emails_templates_nombre">Nombre</label>
          <input type="text" name="nombre" value="<%= nombre %>"  id="emails_templates_nombre" class="form-control">
        </div>
        <% if (VOLVER_SUPERADMIN == 1) { %>
          <div class="form-group">
            <label for="emails_templates_clave">Key</label>
            <input type="text" name="clave" value="<%= clave %>" id="emails_templates_clave" class="form-control">
          </div>
        <% } %>
        <label for="emails_templates_texto">Texto</label>
        <textarea name="texto" id="emails_templates_texto"><%= texto %></textarea>
      </div>
      <div class="panel-footer tar">
        <button class="btn btn-success guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
      </div>
    </div>
  <% } %>
</script>