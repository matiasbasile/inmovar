<script type="text/template" id="propiedades_resultados_template">
  <?php include("propiedades_table.php") ?>
</script>

<script type="text/template" id="propiedades_item_resultados_template">
  <?php include("propiedades_item.php") ?>
</script>


<script type="text/template" id="propiedad_template">
  <?php include("propiedades_detalle.php") ?>
</script>


<script type="text/template" id="propiedades_departamentos_resultados_template">
<table id="departamentos_tabla" class="table table-small table-striped sortable m-b-none default footable">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Piso</th>
      <th class="th_acciones w50"></th>
    </tr>
  </thead>
  <tbody class="tbody"></tbody>
</table>
</script>

<script type="text/template" id="propiedades_departamentos_item_resultados_template">
<td class="text-info data"><%= nombre %></td>
<td class="data"><%= piso %></td>
<td class="tar td_acciones">
  <button class="btn btn-white eliminar"><i class="fa fa-trash"></i></button>
</td>
</script>

<script type="text/template" id="propiedad_departamento_template">
<div class="panel panel-default">
  <div class="panel-heading">
    <b>Editar departamento</b>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Nombre</label>
          <input type="text" required name="nombre" id="departamento_nombre" value="<%= nombre %>" class="form-control"/>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <% if (ID_EMPRESA == 208) { %>
            <label class="control-label">Galeria</label>
            <select class="form-control" name="piso" id="departamento_piso">
              <option <%= (piso=="Planos y vistas")?"selected":"" %>>Planos y vistas</option>
              <option <%= (piso=="Avance de obra")?"selected":"" %>>Avance de obra</option>
            </select>
          <% } else { %>
            <label class="control-label">Piso</label>
            <input type="text" name="piso" id="departamento_piso" value="<%= piso %>" class="form-control"/>
          <% } %>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Orden</label>
          <input type="text" name="orden" id="departamento_orden" value="<%= orden %>" class="form-control"/>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="i-checks">
        <input type="checkbox" id="departamento_disponible" name="disponible" class="checkbox" value="1" <%= (disponible == 1)?"checked":"" %> >
        <i></i>
        El departamento se encuentra disponible
      </label>
    </div>
    <div class="form-group">
      <label class="control-label">
        <?php echo lang(array(
          "es"=>"Descripci&oacute;n",
          "en"=>"Description",
        )); ?>
      </label>
      <textarea name="texto" name="departamento_texto" id="departamento_texto"><%= texto %></textarea>
    </div>
    <?php
    multiple_upload(array(
      "name"=>"images_dptos",
      "label"=>"Galer&iacute;a de Fotos",
      "url"=>"propiedades/function/save_image/",
      "width"=>(isset($empresa->config["departamento_galeria_image_width"]) ? $empresa->config["departamento_galeria_image_width"] : 800),
      "height"=>(isset($empresa->config["departamento_galeria_image_height"]) ? $empresa->config["departamento_galeria_image_height"] : 600),
      "quality"=>(isset($empresa->config["departamento_galeria_image_quality"]) ? $empresa->config["departamento_galeria_image_quality"] : 0),
    )); ?>
  </div>
  <div class="panel-footer clearfix tar">
    <button class="btn guardar btn-success">Guardar</button>
  </div>
</div>
</script>

<script type="text/template" id="propiedad_mercado_libre_template">
  <div class="panel panel-default">
    <div class="panel-heading fs16 bold">
      Compartir a MercadoLibre
      <i class="fa fa-times cerrar cp fr"></i>
    </div>
    <div class="panel-body">
      <div class="tab-container">
        <ul class="nav nav-tabs" role="tablist">
          <li class="active">
            <a id="propiedad_mercado_libre_paso_1_link" href="#propiedad_mercado_libre_tab1" class="buscar_todos" role="tab" data-toggle="tab">
              <i class="fa text-warning fa-calendar m-r-xs"></i>
              Datos
            </a>
          </li>
          <li>
            <a id="propiedad_mercado_libre_paso_2_link" href="#propiedad_mercado_libre_tab2" role="tab" data-toggle="tab">
              <i class="fa text-info fa-address-book m-r-xs"></i>
              Publicacion
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <div id="propiedad_mercado_libre_tab1" class="tab-pane active">
            <div class="row">
              <% if (!multiple) { %>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Titulo</label>
                    <input id="propiedad_mercado_libre_titulo_meli" value="<%= titulo_meli %>" type="text" class="form-control" name="titulo_meli"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Precio</label>
                    <input id="propiedad_mercado_libre_precio_meli" value="<%= precio_meli %>" type="text" class="form-control" name="precio_meli"/>
                  </div>
                </div>
              <% } %>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">Tipo de publicacion</label>
                  <select id="propiedad_mercado_libre_tipo_publicacion" class="form-control">
                    <option value="0">Seleccione</option>
                  </select>
                </div>
              </div>
            </div>
            <% if (!multiple) { %>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Descripcion</label>
                    <textarea style="height: 250px;" class="form-control" name="texto_meli" id="propiedad_mercado_libre_texto_meli"><%= texto_meli %></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <?php 
                  multiple_upload(array(
                    "name"=>"images_meli",
                    "label"=>"Im&aacute;genes adicionales",
                    "url"=>"propiedades/function/save_image/",
                    "width"=>(isset($empresa->config["producto_galeria_image_width"]) ? $empresa->config["producto_galeria_image_width"] : 800),
                    "height"=>(isset($empresa->config["producto_galeria_image_height"]) ? $empresa->config["producto_galeria_image_height"] : 600),
                    "resizable"=>(isset($empresa->config["producto_galeria_image_resizable"]) ? $empresa->config["producto_galeria_image_resizable"] : 0),
                    "upload_multiple"=>true,
                  )); ?>
                </div>
              </div>
            <% } else { %>
                <?php 
                multiple_upload(array(
                  "name"=>"images_meli",
                  "label"=>"Im&aacute;genes adicionales",
                  "url"=>"propiedades/function/save_image/",
                  "width"=>(isset($empresa->config["producto_galeria_image_width"]) ? $empresa->config["producto_galeria_image_width"] : 800),
                  "height"=>(isset($empresa->config["producto_galeria_image_height"]) ? $empresa->config["producto_galeria_image_height"] : 600),
                  "resizable"=>(isset($empresa->config["producto_galeria_image_resizable"]) ? $empresa->config["producto_galeria_image_resizable"] : 0),
                  "upload_multiple"=>true,
                )); ?>
            <% } %>
            <div class="clearfix tar">
              <button class="ir_paso_2 btn btn-success">Siguiente</button>
            </div>
          </div>
          <div id="propiedad_mercado_libre_tab2" class="tab-pane">
            <div style="overflow-y: auto;">
              <div style="height: 260px; text-align: center;" class="loading_grande">
                <img src="/admin/resources/images/spinner.gif" style="line-height: 260px;"/>
              </div>
              <div id="propiedad_mercado_libre_categorias"></div>
            </div>
            <div class="clearfix m-t">
              <button class="ir_paso_1 btn btn-default">Anterior</button>
            </div>
          </div>
        </div> 
      </div>   
    </div>
  </div>
</script>

<script type="text/template" id="propiedad_mercado_libre_categoria_template">
  <select size="15" class="form-control categoria_mercado_libre" data-nivel="<%= nivel %>">
    <% for(var i=0; i< categories.length; i++) { %>
      <% var cat = categories[i] %>
      <option <%= (cat.id == selected)?"selected":"" %> value="<%= cat.id %>"><%= cat.name %></option>
    <% } %>
  </select>
</script>


<script type="text/template" id="propiedad_buscar_interesados_template">
  <div class="modal-header">
    <b>Interesados en la propiedad</b>
    <i class="fa fa-times cerrar cp fr"></i>
  </div>
  <div class="modal-body">
    <div class="table-responsive" style="height:250px; overflow:auto">
      <table id="propiedad_buscar_interesados_tabla" class="table table-striped sortable m-b-none default footable">
        <thead>
          <tr>
            <th style="width:20px"></th>
            <th>Nombre</th>
            <th>Fecha Interes</th>
            <th>Email</th>
            <th>Tel&eacute;fono</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
  <div class="modal-footer tar">
    <button class="btn btn-info enviar_emails btn-addon"><i class="icon fa fa-send"></i>Enviar email</button>
  </div>
</div>
</script>

<script type="text/template" id="propiedad_buscar_interesados_item_template">
<% var link_completo = 'https://' + DOMINIO + ((DOMINIO.substr(DOMINIO.length - 1) == "/") ? "" : "/") + link %>
<td class="p0">
  <label class="i-checks">
    <input data-id="<%= id_contacto %>" class="propiedad_buscar_interesados_checkbox" type="checkbox" checked value="1">
    <i></i>
  </label>
</td>
<td><a href="app/#contacto_acciones/<%= id_contacto %>" class="bold"><%= nombre %></a>
<td><%= fecha %></td>
<td><%= email %></td>
<td>
  <% if (!isEmpty(telefono)) { %>
    <span data-link_completo="<%= link_completo %>" class="enviar_whatsapp_interesado"><i class="fa mr5 fa-whatsapp"></i> <%= telefono %></span>
  <% } %>
</td>
</script>

<script type="text/template" id="propiedad_estadistica_detalle_template">
  <div class="modal-header clearfix">
    <b class="pull-left mt5"><%= nombre %> <%= (!isEmpty(codigo)) ? "("+codigo+")" : "" %></b>
    <i class="fa fa-times fr cp cerrar fs16"></i>
  </div>
  <div class="modal-body">  
    <div class="tab-container mb0">
      <ul class="nav nav-tabs nav-tabs-2" role="tablist">
        <li class="render_tabla <%= (tab_default == "tabla")?"active":"" %>">
          <a href="#tab_propiedad_estadistica1" role="tab" data-toggle="tab">
            <i class="material-icons mr5">people</i>
            Contactos
          </a>
        </li>
        <li class="render_grafico <%= (tab_default == "grafico")?"active":"" %>">
          <a href="#tab_propiedad_estadistica2" role="tab" data-toggle="tab">
            <i class="material-icons mr5">equalizer</i>
            Grafico
          </a>
        </li>
        <div class="pull-right mr5">
          <div class="input-group pull-left mr5" style="width: 140px;">
            <input type="text" id="propiedad_estadistica_fecha_desde" class="form-control">
            <span class="input-group-btn">
              <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>              
          </div>
          <div class="input-group pull-left mr5" style="width: 140px;">
            <input type="text" id="propiedad_estadistica_fecha_hasta" class="form-control">
            <span class="input-group-btn">
              <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>
          </div>
          <button class="btn buscar btn-default pull-left"><i class="fa fa-search"></i></button>
        </div>
      </ul>
    </div>
    <div class="tab-content panel panel-default">
      <div id="tab_propiedad_estadistica1" class="tab-pane pr0 pl0 <%= (tab_default == "tabla")?"active":"" %>">
        <div style="height:250px; overflow: auto;">
          <table id="propiedad_estadistica_tabla" class="table table-striped sortable m-b-none default footable">
            <thead>
              <tr>
                <th style="width:150px">Fecha</th>
                <th>Contacto</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div id="tab_propiedad_estadistica2" class="tab-pane pr0 pl0 <%= (tab_default == "grafico")?"active":"" %>">
        <div id="propiedad_estadistica_grafico" style="height:250px;"></div>
      </div>
    </div>
  </div>
</script>

<script type="text/template" id="propiedad_preview_template">
  <?php include_once("propiedad_preview.php") ?>
</script>

<script type="text/template" id="propiedad_temporada_panel_template">
<div class="panel panel-default">
  <div class="panel-heading">
    <b>Editar tarifa de temporada</b>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <label class="control-label">Nombre</label>
      <input type="text" name="nombre" id="propiedad_temporada_nombre" value="<%= nombre %>" class="form-control"/>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Desde</label>
          <div class="input-group">
            <input type="text" id="propiedad_temporada_fecha_desde" value="<%= desde %>" class="form-control">
            <span class="input-group-btn">
              <button class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Hasta</label>
          <div class="input-group">
            <input type="text" id="propiedad_temporada_fecha_hasta" <%= hasta %> class="form-control">
            <span class="input-group-btn">
              <button class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Estadia Min.</label>
          <input type="text" name="minimo_dias_reserva" id="propiedad_temporada_minimo_dias_reserva" value="<%= minimo_dias_reserva %>" class="form-control"/>
        </div>
      </div>      
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Por Noche</label>
          <input type="text" id="propiedad_temporada_precio" value="<%= precio %>" name="precio" class="form-control"/>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Fin de Semana</label>
          <input type="text" id="propiedad_temporada_precio_finde" value="<%= precio_finde %>" name="precio_finde" class="form-control"/>
        </div>        
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Semana</label>
          <input type="text" id="propiedad_temporada_precio_semana" value="<%= precio_semana %>" name="precio_semana" class="form-control"/>
        </div>        
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Mes</label>
          <input type="text" id="propiedad_temporada_precio_mes" value="<%= precio_mes %>" name="precio_mes" class="form-control"/>
        </div>        
      </div>
    </div>
  </div>
  <div class="panel-footer clearfix tar">
    <button class="btn cancelar fl btn-default">Cancelar</button>
    <button class="btn guardar btn-success">Guardar</button>
  </div>
</div>
</script>

<script type="text/template" id="propiedad_impuesto_panel_template">
<div class="panel panel-default">
  <div class="panel-heading">
    <b>Editar impuesto o tasa</b>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <label class="control-label">Nombre</label>
      <input type="text" name="nombre" id="propiedad_impuesto_nombre" value="<%= nombre %>" class="form-control"/>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Tipo</label>
          <select class="form-control" name="tipo" id="propiedad_impuesto_tipo">
            <option value="1" <%= (tipo==1)?"selected":"" %>>Porcentaje por reserva</option>
            <option value="2" <%= (tipo==2)?"selected":"" %>>Tarifa por viajero</option>
            <option value="3" <%= (tipo==3)?"selected":"" %>>Tarifa por persona y noche</option>
            <option value="4" <%= (tipo==4)?"selected":"" %>>Tarifa por noche</option>
            <option value="5" <%= (tipo==5)?"selected":"" %>>Precio fijo por estadia</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Monto</label>
          <input type="text" id="propiedad_impuesto_monto" value="<%= monto %>" class="form-control">
        </div>
      </div>
    </div>
  </div>
  <div class="panel-footer clearfix tar">
    <button class="btn cancelar fl btn-default">Cancelar</button>
    <button class="btn guardar btn-success">Guardar</button>
  </div>
</div>
</script>

<script type="text/template" id="propietarios_panel_template">
  <div class="bg-light lter b-b wrapper-md ng-scope">
   <h1 class="m-n font-thin h3"><i class="fa fa-users icono_principal"></i>Propietarios</h1>
  </div>
  <div class="wrapper-md ng-scope">
  <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <div class="row">
        <div class="col-md-6 col-lg-3 sm-m-b">
          <div class="search_container"></div>
        </div>
        <div class="col-md-6 col-lg-offset-3 col-lg-6 text-right">
          <a class="btn btn-info btn-addon" href="app/#propietario"><i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo&nbsp;&nbsp;</a>
        </div>
      </div>
    </div>
    <div class="panel-body">
      <div class="b-a table-responsive">
        <table id="propietarios_table" class="table table-striped sortable m-b-none default footable">
          <thead>
            <tr>
              <th class="sorting" data-sort-by="nombre">Nombre</th>
              <th class="sorting" data-sort-by="email">Email</th>
              <th class="sorting" data-sort-by="telefono">Telefono</th>
              <th class="sorting" data-sort-by="celular">Celular</th>
              <% if (permiso > 1) { %>
                <th class="w100 th_acciones">Acciones</th>
              <% } %>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot class="pagination_container hide-if-no-paging"></tfoot>
        </table>
      </div>
    </div>
  </div>
  </div>  
</script>


<script type="text/template" id="propietarios_item">
  <td class='ver'><span class="text-info"><%= nombre %></span></td>
  <td class='ver'><span class=''><%= email %></span></td>
  <td class='ver'><span class=''><%= telefono %></span></td>
  <td class='ver'><span class=''><%= celular %></span></td>
  <% if (permiso > 1) { %>
    <div class="btn-group dropdown">
      <i title="Opciones" class="iconito fa fa-caret-down dropdown-toggle" data-toggle="dropdown"></i>
      <ul class="dropdown-menu pull-right">
      <li><a href="javascript:void(0)" class="delete" data-id="<%= id %>">Eliminar</a></li>
      </ul>
    </div>
  <% } %>
</script>

<script type="text/template" id="propietarios_edit_panel_template">

<div class="bg-light lter b-b wrapper-md ng-scope">
  <h1 class="m-n font-thin h3"><i class="fa fa-users icono_principal"></i>Propietarios / 
  <b><%= (id == undefined)?"Nuevo":nombre %></b>
  </h1>
</div>
<div class="wrapper-md">
  <div class="centrado rform">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="padder">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Nombre</label>
                    <% if (edicion) { %>
                      <input type="text" name="nombre" class="form-control" id="propietarios_nombre" value="<%= nombre %>"/>
                    <% } else { %>
                      <span><%= nombre %></span>
                    <% } %>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Email</label>
                    <% if (edicion) { %>
                      <input type="text" name="email" class="form-control" id="propietarios_email" value="<%= email %>"/>
                    <% } else { %>
                      <span><%= email %></span>
                    <% } %>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Telefono</label>
                    <% if (edicion) { %>
                      <input type="text" name="telefono" class="form-control" id="propietarios_telefono" value="<%= telefono %>"/>
                    <% } else { %>
                      <span><%= telefono %></span>
                    <% } %>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Celular</label>
                    <% if (edicion) { %>
                      <input type="text" name="celular" class="form-control" id="propietarios_celular" value="<%= celular %>"/>
                    <% } else { %>
                      <span><%= celular %></span>
                    <% } %>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Direccion</label>
                <% if (edicion) { %>
                  <input type="text" name="direccion" class="form-control" id="propietarios_direccion" value="<%= direccion %>"/>
                <% } else { %>
                  <span><%= direccion %></span>
                <% } %>
              </div>
              <div class="form-group">
                <label class="control-label">Observaciones</label>
                <% if (edicion) { %>
                  <textarea class="form-control" name="observaciones"><%= observaciones %></textarea>
                <% } else { %>
                  <span><%= observaciones %></span>
                <% } %>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1 clearfix">
        <button class="btn guardar fr btn-success">Guardar</button>
      </div>
    </div>
  </div>
</div>
</script>


<script type="text/template" id="propietarios_edit_mini_panel_template">
<div class="panel pb0 mb0">
  <div class="panel-body">
    <div class="oh m-b">
      <h4 class="h4 pull-left">Nuevo Propietario</h4>
      <span class="pull-right cp material-icons cerrar">close</span>
    </div>
    <div class="form-group">
      <input type="text" autocomplete="off" placeholder="Nombre" name="nombre" class="tab form-control" id="propietarios_mini_nombre"/>
    </div>
    <div class="form-group">
      <input type="text" autocomplete="off" placeholder="Email" name="email" class="tab form-control" id="propietarios_mini_email"/>
    </div>
    <div class="form-group">
      <input type="text" autocomplete="off" placeholder="Telefono" name="telefono" class="tab form-control" id="propietarios_mini_telefono"/>
    </div>
    <div class="form-group">
      <input type="text" autocomplete="off" placeholder="Celular" name="celular" class="tab form-control" id="propietarios_mini_celular"/>
    </div>
    <div class="form-group">
      <input type="text" autocomplete="off" placeholder="Direccion" name="direccion" class="tab form-control" id="propietarios_mini_direccion"/>
    </div>
    <div class="form-group">
      <textarea autocomplete="off" placeholder="Observaciones o notas..." name="observaciones" class="tab form-control h80" id="propietarios_mini_observaciones"></textarea>
    </div>
    <div class="text-right">
      <button class="btn guardar btn-info tab">Guardar</button>
    </div>
  </div>
</div>
</script>

<script type="text/template" id="propiedades_gasto_table">
<div class="table-responsive">
  <table id="gastos_tabla" class="table table-striped sortable m-b-none default footable">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Concepto</th>
        <th>Monto</th>
        <th>Observaciones</th>
        <th class="w20"></th>
        <th class="th_acciones w50"></th>
      </tr>
    </thead>
    <tbody class="tbody"></tbody>
    <tfoot class="tfoot">
      <tr>
        <td></td>
        <td class="tar fs16 bold">TOTAL:</td>
        <td><span class="total_gastos fs16 bold">0</span></td>
        <th></th>
        <td></td>
        <td></td>
      </tr>
    </tfoot>
  </table>
</div>
</script>

<script type="text/template" id="propiedades_gasto_item">
<td class="data"><%= moment(fecha.substring(0, 10), "YYYY-MM-DD").format("DD/MM/YYYY") %></td>
<td class="data"><%= concepto %></td>
<td class="data">$ <%= Number(monto).format(2) %></td>
<td class="data"><%= descripcion %></td>
<td class="data">
  <% if (!isEmpty(path)) { %>
    <a class="text-info" target="_blank" href="/admin/<%= path %>"><i class="fa fa-text"></i></a>
  <% } %>
</td>
<td class="tar td_acciones">
  <button class="btn btn-white eliminar"><i class="fa fa-trash"></i></button> 
</td>
</script>

<script type="text/template" id="propiedades_gasto_edit">
<div class="panel panel-default">
  <div class="panel-heading oh">
    <span class="bold fl fs16 mt7">Agregar gasto</span>
    <button class="fr btn btn-default cerrar"><i class="fa fa-times"></i></button>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Fecha</label>
          <input placeholder="Fecha" type="date" class="form-control" value="<%= fecha %>" id="propiedades_gastos_fecha" name="fecha"/>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Monto</label>
          <input type="number" value="<%= monto %>" class="form-control" id="propiedades_gastos_monto" name="monto">
        </div>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label">Concepto</label>
      <select class="form-control" id="propiedades_gastos_concepto" name="concepto">
        <option <%= (concepto == "") ? 'selected' : '' %> value="-">-</option>
      </select>
    </div>

    <div class="form-group">
      <label class="control-label">Observaciones</label>
      <textarea class="form-control" id="propiedades_gastos_descripcion" name="descripcion"><%= descripcion %></textarea>
    </div>
    <div class="form-group">
    <?php
    single_file_upload(array(
      "name"=>"path",
      "label"=>"Subir archivo de comprobante",
      "url"=>"gastos/function/save_file/",
    )); ?>
    </div>
  </div>
  <div class="panel-footer clearfix tar">
    <button class="btn guardar btn-info">Guardar</button>
  </div>
</div>
</script>