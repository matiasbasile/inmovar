<script type="text/template" id="oportunidades_resultados_template">
  <div class="centrado rform">

    <div class="stories_container"></div>

    <div class="header-lg">
      <div class="row">
        <div class="col-md-6 col-xs-8">
          <h1>Oportunidades</h1>
        </div>
        <div class="col-md-6 col-xs-4 tar">
          <% if (permiso > 1) { %>
            <a class="btn btn-info nueva_oportunidad" href="javascript:void(0)">
              <span class="material-icons show-xs">add</span>
              <span class="hidden-xs">&nbsp;&nbsp;Nueva Oportunidad&nbsp;&nbsp;</span>
            </a>
          <% } %>
        </div>
      </div>
    </div>

    <div class="tab-container mb0">
      <ul class="nav nav-tabs nav-tabs-2" role="tablist">
        <li id="buscar_propias_tab" data-tipo="0" class="buscar_tab <%= (window.oportunidades_tipo == 0)?"active":"" %>">
          <a href="javascript:void(0)">
            <?php //<i class="material-icons">store</i>  ?>
            Venta
            <span id="oportunidades_venta_total" class="counter">0</span>
          </a>
        </li>
        <li id="buscar_tipo_tab" data-tipo="1" class="buscar_tab <%= (window.oportunidades_tipo == 1)?"active":"" %>">
          <a href="javascript:void(0)">
            Compra
            <span id="oportunidades_compra_total" class="counter">0</span>
          </a>
        </li>
        <li id="buscar_mias_tab" data-tipo="-1" class="buscar_tab <%= (window.oportunidades_tipo == -1)?"active":"" %>">
          <a href="javascript:void(0)">
            Mis Oportunidades
            <span id="oportunidades_mias_total" class="counter">0</span>
          </a>
        </li>
      </ul>
    </div>

    <div class="panel panel-default">

      <div class="panel-body pb0">

        <div id="oportunidades_tabla_cont" class="table-responsive">
          <table id="oportunidades_tabla" class="table table-striped sortable m-b-none default footable">
            <thead>
              <tr>
                <th class="w100 tac"></th>
                <th>Informacion</th>
                <th>Precio</th>
                <th class="w150">Caract.</th>
                <th class="th_acciones w180">Acciones</th>
              </tr>
            </thead>
            <tbody class="tbody"></tbody>
            <tfoot class="pagination_container hide-if-no-paging"></tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/template" id="oportunidades_item_resultados_template">

  <% var clase = (activo==1)?"":"text-muted"; %>
  <td class="<%= clase %> p0 data">
    <% if (!isEmpty(path)) { %>
      <% var prefix = (path.indexOf("http") == 0) ? "" : "/admin/" %>
      <img src="<%= prefix + path %>?t=<%= Math.ceil(Math.random()*10000) %>" class="customcomplete-image br5"/>
    <% } %>
  </td>
  <td class="<%= clase %> p0 data">
    <%= titulo %><br>
    <%= descripcion %>
  </td>
  <td class="<%= clase %> data">
    <% if (valor_desde != 0) { %>
      Desde: <%= moneda %> <%= Number(valor_desde).format(0) %><br/>
    <% } %>
    <% if (valor_hasta != 0) { %>
      Hasta: <%= moneda %> <%= Number(valor_hasta).format(0) %>
    <% } %>
  </td>
  <td class="<%= clase %> data">
    <% if (ambientes > 0) { %><%= ambientes %> Amb.<br/><% } %>
    <% if (dormitorios > 0) { %><%= dormitorios %> Hab.<br/><% } %>
  </td>
  <td class="tal td_acciones">
    <% if (ID_EMPRESA == id_empresa) { %>
      <div class="btn-group dropdown ml10">
        <i title="Opciones" class="iconito text-muted-2 fa fa-caret-down dropdown-toggle" data-toggle="dropdown"></i>
        <ul class="dropdown-menu pull-right">
          <li><a href="javascript:void(0)" class="editar"><i class="text-muted-2 fa fa-pencil w25"></i> Editar</a></li>
          <% if (control.check("oportunidades") == 3) { %>
            <li class="divider"></li>
            <li><a href="javascript:void(0)" class="duplicar" data-id="<%= id %>"><i class="text-muted-2 fa fa-files-o w25"></i> Duplicar</a></li>
            <li><a href="javascript:void(0)" class="eliminar" data-id="<%= id %>"><i class="text-muted-2 fa fa-times w25"></i> Eliminar</a></li>
          <% } %>
        </ul>
      </div>
    <% } else { %>
      <div class="btn-group dropdown ml10">
        <i title="Opciones" class="iconito text-muted-2 fa fa-caret-down dropdown-toggle" data-toggle="dropdown"></i>
        <ul class="dropdown-menu pull-right">
          <li><a href="javascript:void(0)" class="ver"><i class="text-muted-2 fa fa-pencil w25"></i> Ver</a></li>
        </ul>
      </div>
    <% } %>
  </td>
</script>


<script type="text/template" id="oportunidades_edit_template">
  <div class="modal-header">
    <b>Nueva Oportunidad</b>
    <i class="pull-right cerrar_lightbox fs16 fa fa-times cp"></i>
  </div>
  <div class="modal-body">

    <div class="row">
      <div class="col-md-8">
        <div class="form-group">
          <label class="control-label">Titulo</label>
          <input maxlength="75" id="oportunidades_titulo" value="<%= titulo %>" type="text" class="form-control number" name="titulo"/>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Telefono de contacto</label>
          <input id="oportunidades_telefono" value="<%= telefono %>" type="text" class="form-control number" name="telefono"/>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label class="control-label">Descripcion</label>
          <textarea maxlength="200" id="oportunidades_descripcion" class="form-control" rows="3"><%= descripcion %></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Tipo</label>
          <select id="oportunidades_tipo" class="form-control" name="tipo">
            <option value="0">Venta</option>
            <option value="1">Compra</option>
          </select>
        </div>
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <label class="control-label">Propiedad</label>
          <div class="input-group">
            <input type="text" disabled placeholder="Interesado en propiedad..." autocomplete="off" id="operaciones_propiedad" class="form-control"/>
            <span class="input-group-btn">
              <button data-toggle="tooltip" title="Buscar propiedades" tabindex="-1" type="button" class="btn btn-default buscar_propiedades"><i class="fa fa-search"></i></button>
            </span>        
          </div>
        </div>      
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Fecha</label>
          <div class="input-group">
            <input type="text" placeholder="Fecha" id="oportunidades_fecha" value="<%= fecha %>" class="form-control" name="fecha"/>
            <span class="input-group-btn">
              <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
            </span>        
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Desde</label>
          <div class="input-group">
            <div class="input-group-btn">
              <select id="oportunidades_monedas" class="form-control w80">
                <% for(var i=0;i< window.monedas.length;i++) { %>
                  <% var o = monedas[i]; %>
                  <option <%= (o.signo == moneda)?"selected":"" %> value="<%= o.signo %>"><%= o.signo %></option>
                <% } %>
              </select>                      
            </div>
            <input id="oportunidades_valor_desde" value="<%= valor_desde %>" type="number" class="form-control number" name="valor_desde"/>
          </div>
        </div>
      </div>    
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Hasta</label>
          <input id="oportunidades_valor_hasta" value="<%= valor_hasta %>" type="number" class="form-control number" name="valor_hasta"/>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Tipo Inmueble</label>
          <select id="oportunidades_tipos_inmueble" class="w100p">
            <% for(var i=0;i< window.tipos_inmueble.length;i++) { %>
              <% var o = tipos_inmueble[i]; %>
              <option value="<%= o.id %>" <%= (o.id == id_tipo_inmueble)?"selected":"" %>><%= o.nombre %></option>
            <% } %>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Ambientes</label>
          <input type="number" min="0" id="oportunidades_ambientes" value="<%= ambientes %>" name="ambientes" class="form-control"/>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Dormitorios</label>
          <input type="number" min="0" id="oportunidades_dormitorios" value="<%= dormitorios %>" name="dormitorios" class="form-control"/>
        </div>
      </div>    
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Pais</label>
          <select id="oportunidades_paises" name="id_pais" class="form-control">
            <% for(var i=0;i< paises.length;i++) { %>
              <% var p = paises[i] %>
              <option <%= (id_pais == p.id)?"selected":"" %> value="<%= p.id %>"><%= p.nombre %></option>
            <% } %>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Provincia</label>
          <select id="oportunidades_provincias" name="id_provincia" class="form-control">
            <% for(var i=0;i< provincias.length;i++) { %>
              <% var p = provincias[i] %>
              <option data-id_pais="<%= p.id_pais %>" <%= (id_provincia == p.id)?"selected":"" %> value="<%= p.id %>"><%= p.nombre %></option>
            <% } %>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Departamento / Partido</label>
          <select id="oportunidades_departamentos" name="id_departamento" class="form-control"></select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Localidad</label>
          <select id="oportunidades_localidades" name="id_localidad" class="form-control"></select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Barrio</label>
          <select class="form-control" name="id_barrio" id="oportunidades_barrio"></select>
        </div>
      </div>
    </div>

    <?php
    multiple_upload(array(
      "name"=>"images",
      "label"=>"Galer&iacute;a de Fotos (Hasta 5 fotos)",
      "url"=>"propiedades/function/save_image/",
      "width"=>(isset($empresa->config["departamento_galeria_image_width"]) ? $empresa->config["departamento_galeria_image_width"] : 800),
      "height"=>(isset($empresa->config["departamento_galeria_image_height"]) ? $empresa->config["departamento_galeria_image_height"] : 600),
      "quality"=>(isset($empresa->config["departamento_galeria_image_quality"]) ? $empresa->config["departamento_galeria_image_quality"] : 0),
    )); ?>

  </div>
  <div class="modal-footer text-right">
    <button class="btn guardar btn-info tab">Guardar</button>
  </div>
</div>
</script>
