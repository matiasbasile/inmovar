<script type="text/template" id="email_template">
<div class="panel panel-default mb0">
  <div class="panel-heading font-bold">
    Enviar Email
    <i class="pull-right cerrar_lightbox fa fa-times cp"></i>
  </div>
  <div class="panel-body">
    <div class="form-horizontal">
      <div class="form-group">
        <div class="col-sm-3 col-md-2 col-xs-12">
          <label class="control-label">Para:</label>
        </div>
        <div class="col-sm-9 col-md-10 col-xs-12">
          <input type="text" name="email" id="email_nombre" value="<%= email %>" class="form-control"/>
        </div>
      </div>      
      <div class="form-group">
        <div class="col-sm-3 col-md-2 col-xs-12">
          <label class="control-label">Asunto:</label>
        </div>
        <div class="col-sm-9 col-md-10 col-xs-12">
          <div class="input-group">
            <input type="text" name="asunto" id="email_asunto" value="<%= asunto %>" class="form-control"/>
            <div class="input-group-btn dropdown">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Plantillas <span class="caret"></span>
              </button>
              <ul class="dropdown-menu pull-right">
                <li><a class="cargar_plantilla" href="javascript:void(0)">Cargar</a></li>
                <li><a class="guardar_plantilla" href="javascript:void(0)">Guardar</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="form-group col-xs-12">
        <span class="btn btn-default fileinput-button">
          <i class="glyphicon glyphicon-folder-open m-r-xs"></i>
          <span>Adjuntar archivos</span>
          <input id="fileupload" type="file" name="files[]" multiple>
        </span>
        <div id="progress" class="progress" style="display: none">
          <div class="progress-bar progress-bar-success"></div>
        </div>
        <div id="files" class="files"></div>
      </div>

      <% if (links_adjuntos.length > 0) { %>
        <div class="form-group">
          <div class="col-sm-3 col-md-2 col-xs-12">
            <label class="control-label">Fichas:</label>
          </div>
          <div class="col-sm-9 col-md-10 col-xs-12">
            <% for (var i=0;i< links_adjuntos.length;i++) { %>
              <% var adjunto = links_adjuntos[i]; %>
              <button data-position="<%= i %>" class="btn btn-default m-b"><%= adjunto.nombre %><i class="ml5 eliminar_adjunto fa fa-times"></i></button>
            <% } %>
          </div>
        </div>
      <% } %>

      <div class="form-group">
        <div class="col-xs-12">
          <textarea name="texto" id="email_texto"><%= texto %></textarea>
        </div>
      </div>      
    </div>
  </div>
  <div class="panel-footer clearfix">
    <button class="btn guardar pull-right btn-info btn-addon">
      <i class="fa fa-send"></i><span>Enviar</span>
    </button>
  </div>
</div>
</script>

<script type="text/template" id="enviar_plantilla_template">
<div class="panel panel-default mb0">
  <div class="panel-heading font-bold">
    Enviar Plantilla
    <i class="pull-right cerrar_lightbox fa fa-times cp"></i>
  </div>
  <div class="panel-body">
    <div class="form-horizontal">
      <div class="form-group">
        <div class="col-sm-1 col-md-1 col-xs-12">
          <label class="control-label">Para:</label>
        </div>
        <div class="col-sm-9 col-md-9 col-xs-12">
          <select type="text" name="email" id="enviar_plantilla_clientes" class="form-control"></select>
        </div>
        <div class="col-sm-2 col-md-2 col-xs-12">
          <a id="agregar_cliente" class="btn btn-default btn-block">+ Agregar</a>
        </div>
      </div>      

      <div class="form-group">
        <div class="col-xs-12">
          <textarea name="texto" class="form-control h100" id="enviar_plantilla_texto"></textarea>
        </div>
      </div>      
    </div>
  </div>
  <div class="panel-footer clearfix">
    <button class="btn enviar pull-right btn-info btn-addon">
      <i class="fa fa-send"></i><span>Enviar</span>
    </button>
  </div>
</div>
</script>