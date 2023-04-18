<% if (vista_busqueda) { %>
  <div class="modal-header">
    <b>Buscar propiedades</b>
    <i class="pull-right cerrar_lightbox fs16 fa fa-times cp"></i>
  </div>
  <div class="modal-body">
    
    <?php include("buscar_propiedades.php") ?>

    <div class="tab-container mb0">
      <ul class="nav nav-tabs nav-tabs-2" role="tablist">
        <?php include("tabs_propiedades.php") ?>
      </ul>
      <div class="tab-content">
        <div class="table-responsive">
          <table id="propiedades_tabla" class="table table-striped sortable m-b-none default footable">
            <thead>
              <tr>
                <th class="w50 tac"></th>
                <th>Propiedad</th>
                <th class="" data-sort-by="precio_final">Operación</th>
                <th class="w150">Caract.</th>
                <th class="w120 mostrar_en_red" style="display: none;"></th>
              </tr>
            </thead>
            <tbody class="tbody"></tbody>
            <tfoot class="pagination_container hide-if-no-paging"></tfoot>
          </table>
        </div>
      </div>
      <div class="bulk_action tar m-t">
        <div class="dib m-r">
          <p><b class="cantidad_seleccionados"></b> elementos seleccionados</p>  
        </div>
        <button class="btn btn-default marcar_interes">Marcar Inter&eacute;s</button>
        <button class="btn btn-info enviar_por_email">Enviar fichas por email</button>
        <button class="btn btn-success enviar_whatsapp">Enviar Whatsapp</button>
      </div>
    </div>

  </div>
<% } else { %>

  <div class="centrado rform">

    <% if (!seleccionar) { %>

      <div class="stories_container"></div>

      <div class="header-lg">
        <div class="row">
          <div class="col-md-6 col-xs-8">
            <h1>Propiedades</h1>
          </div>
          <div class="col-md-6 col-xs-4 tar">
            <% if (permiso > 1) { %>
              <a class="btn btn-info" href="app/#propiedades/0">
                <span class="material-icons show-xs">add</span>
                <span class="hidden-xs">&nbsp;&nbsp;Nueva Propiedad&nbsp;&nbsp;</span>
              </a>
            <% } %>
          </div>
        </div>
      </div>
    <% } %>

    <div class="tab-container mb0">
      <ul class="nav nav-tabs nav-tabs-2" role="tablist">
        <?php include("tabs_propiedades.php") ?>
      </ul>
    </div>

    <div class="panel panel-default">

      <?php include("buscar_propiedades.php") ?>
      <% if (!seleccionar) { %>
        <div class="bulk_action wrapper pb0">
          <p><b class="cantidad_seleccionados"></b> elementos seleccionados <b class="imagenes_propiedades"></b></p>
          <button class="btn btn-default enviar_por_email btn-addon"><i class="icon fa fa-send"></i>Enviar fichas por email</button>
          <button class="btn btn-default enviar_por_whatsapp btn-addon"><i class="icon fa fa-whatsapp"></i>Enviar fichas por whatsapp</button>
          <% if (control.check("permisos_red")>0 || PROJECT_NAME == "Inmovar") { %>
            <div class="btn-group dropdown">
              <button class="btn btn-default btn-addon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon fa fa-share-alt"></i>Red Inmovar
              </button>
              <ul class="dropdown-menu">
                <li><a href="javascript:void(0)" class="compartir_red_multiple">Compartir</a></li>
                <li><a href="javascript:void(0)" class="no_compartir_red_multiple">No Compartir</a></li>
              </ul>
            </div> 
          <% } %>
        </div>
      <% } %>

      <div class="panel-body pb0">

        <div style="height:500px;display:<%= (window.propiedades_mapa == 1)?"block":"none" %>" id="propiedades_mapa"></div>

        <div id="propiedades_tabla_cont" class="table-responsive">
          <table id="propiedades_tabla" class="table <%= (seleccionar)?'table-small':'' %> table-striped sortable m-b-none default footable">
            <thead>
              <tr>
                <th style="width:20px;">
                  <label class="i-checks m-b-none">
                    <input class="esc sel_todos" type="checkbox"><i></i>
                  </label>
                </th>
                <th class="w50 tac"></th>
                <th>Propiedad</th>
                <th class="" data-sort-by="precio_final">Operación</th>
                <th class="w150">Caract.</th>
                <th class="w120"></th>
                <th class="th_acciones w180">
                  Acciones

                  <div class="fr btn-group dropdown ml10">
                    <i title="Opciones" class="iconito text-muted-2 fa fa-sort dropdown-toggle" data-toggle="dropdown"></i>
                    <ul class="dropdown-menu pull-right">
                      <li><a href="javascript:void(0)" class="ttn">Ordenar Por:</a></li>
                      <li><a href="javascript:void(0)" class="ttn sort"><i data-val="precio_final" class="fa fa-check mr5 dn" aria-hidden="true"></i>Precio</a></li>
                      <li><a href="javascript:void(0)" class="ttn sort"><i data-val="codigo" class="fa fa-check mr5 dn" aria-hidden="true"></i>Codigo</a></li>
                      <li class="divider"></li>
                      <li><a href="javascript:void(0)" class="ttn sort-a"><i data-val="ASC" class="fa fa-check mr5" aria-hidden="true"></i> Ascendente</a></li>
                      <li><a href="javascript:void(0)" class="ttn sort-a"><i data-val="DESC" class="fa fa-check mr5 dn" aria-hidden="true"></i>Descendente</a></li>
                    </ul>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody class="tbody"></tbody>
            <tfoot class="pagination_container hide-if-no-paging"></tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
<% } %>
