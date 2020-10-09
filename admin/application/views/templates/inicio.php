<script type="text/template" id="inicio_template">
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-xs-6">
          <h1>Dashboard</h1>
        </div>
        <div class="col-xs-6 tar">
          <input type="text" value="Última Semana" class="form-control w180 calendar fr mt20">
        </div>
      </div>
    </div>
    <div class="row text-center">

      <div class="col-xs-6 col-sm-3">
        <div class="panel-default tal panel p15 item" style="height: 100px">
          <div class="dt w100p">
            <div class="dtc vam">
              <span class="h4 block bold c1">Tus Propiedades</span>    
            </div>
            <div class="dtc tar vam">
              <div class="h1 c1"><%= total_propiedades %></div>
            </div>
          </div>
          <a class="link fs14 block" href="app/#propiedades/0"><i class="fa fa-external-link mr5"></i> Cargar nueva propiedad</a>
        </div>
      </div>

      <div class="col-xs-6 col-sm-3">
        <div class="panel-default tal panel p15 item" style="height: 100px">
          <div class="dt w100p">
            <div class="dtc vam">
              <span class="h4 block bold c1">Tus Consultas</span>    
            </div>
            <div class="dtc tar vam">
              <div class="h1 c1"><%= total_consultas %></div>
            </div>
          </div>
          <a class="link fs14 block" href="app/#consultas"><i class="fa fa-external-link mr5"></i> Consultas sin responder</a>
        </div>
      </div>

      <div class="col-xs-6 col-sm-3">
        <div class="panel-default tal panel p15 item" style="height: 100px">
          <div class="dt w100p">
            <div class="dtc vam">
              <span class="h4 block bold c1">Red Inmovar</span>    
            </div>
            <div class="dtc tar vam">
              <div class="h1 c1"><%= total_propiedades_red %></div>
            </div>
          </div>
          <a class="link fs14 block" href="app/#propiedades"><i class="fa fa-external-link mr5"></i> Propiedades por revisar</a>
        </div>
      </div>  

      <div class="col-xs-6 col-sm-3">
        <div class="panel-default tal panel p15 item" style="height: 100px">
          <div class="dt w100p">
            <div class="dtc vam">
              <span class="h4 block bold c1">Tu Red</span>    
            </div>
            <div class="dtc tar vam">
              <div class="h1 c1"><%= total_propiedades_tu_red %></div>
            </div>
          </div>
          <a class="link fs14 block" href="app/#permisos_red"><i class="fa fa-external-link mr5"></i> Invitaciones pendientes</a>
        </div>
      </div>  

    </div>
    <div class="row">

      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading wrapper b-b b-light">
            <h4 class="m-t-none m-b-none"><span class="material-icons fs20 pr t2 mr10">local_offer</span> Visitas</h4>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <table class="table w100p sin-borde">
                  <tr>
                    <td class="c-main"><span class="material-icons fs12 mr5">stop_circle</span> Sitio Web</td>
                    <td class="vam"><h3 class="c-main p0 m0"><%= visitas_sitio_web %></h3></td>
                  </tr>
                  <tr>
                    <td class="c-sec vam"><span class="material-icons fs12 mr5">stop_circle</span> Red Inmovar</td>
                    <td class="vam"><h3 class="c-sec p0 m0"><%= visitas_red %></h3></td>
                  </tr>
                </table>
              </div>
              <div class="col-md-6">
                <div id="visitas_bar" style="height: 150px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading wrapper b-b b-light">
            <h4 class="m-t-none m-b-none"><span class="material-icons fs20 pr t2 mr10">local_offer</span> Consultas</h4>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <table class="table w100p sin-borde">
                  <tr>
                    <td class="c-main"><span class="material-icons fs12 mr5">stop_circle</span> Sitio Web</td>
                    <td class="vam"><h3 class="c-main p0 m0"><%= consultas_sitio_web %></h3></td>
                  </tr>
                  <tr>
                    <td class="c-sec vam"><span class="material-icons fs12 mr5">stop_circle</span> Red Inmovar</td>
                    <td class="vam"><h3 class="c-sec p0 m0"><%= consultas_red %></h3></td>
                  </tr>
                </table>
              </div>
              <div class="col-md-6">
                <div id="consultas_bar" style="height: 150px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="panel panel-default mb20">
          <div class="panel-heading wrapper b-b b-light">
            <h4 class="m-t-none m-b-none"><span class="material-icons fs20 pr t2 mr10">local_offer</span> Más Visitadas</h4>
          </div>
          <div class="panel-body">
            <div class="mh250">
              <table class="table w100p sin-borde">
                <% for(var i=0;i< mas_visitadas.length;i++) { %>
                  <% var p = mas_visitadas[i] %>
                  <tr>
                    <td class="p0">
                      <% if (!isEmpty(p.path)) { %>
                        <a href="app/#propiedades/<%= p.id %>">
                          <% var prefix = (p.path.indexOf("http") == 0) ? "" : "/admin/" %>
                          <img src="<%= prefix + p.path %>?t=<%= Math.ceil(Math.random()*10000) %>" class="customcomplete-image"/>
                        </a>
                      <% } %>
                    </td>
                    <td class="">
                      <a href="app/#propiedades/<%= p.id %>">
                        <span class="bold c1"><%= p.tipo_inmueble %> en <%= p.tipo_operacion %></span><br/>
                        <%= p.calle %> <%= p.altura %> <%= p.piso %> <%= p.numero %>
                        / 
                        <%= p.localidad %>
                      </a>
                    </td>
                    <td>
                      <button class="btn etiqueta">0 visitas</button>
                    </td>
                  </tr>
                <% } %>
              </table>
            </div>
            <div class="tac">
              <a class="link" href="app/#propiedades">Ver todas las propiedades <span class="material-icons pr t2 ml5 fs12">arrow_forward_ios</span></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="panel panel-default mb20">
          <div class="panel-heading wrapper b-b b-light">
            <h4 class="m-t-none m-b-none"><span class="material-icons fs20 pr t2 mr10">local_offer</span> Últimas Consultas</h4>
          </div>
          <div class="panel-body">
            <div class="mh250">
              <table class="table w100p sin-borde">
                <% for(var i=0;i< consultas.length;i++) { %>
                  <% var p = consultas[i] %>
                  <tr>
                    <td class="p0">
                      <a href="app/#contacto_acciones/<%= p.id %>">
                        <% if (!isEmpty(p.path)) { %>
                          <% if (p.path.indexOf("http") == 0) { %>
                            <img src="<%= p.path %>" class="customcomplete-image"/>
                          <% } else { %>
                            <img src="/admin/<%= p.path %>" class="customcomplete-image"/>
                          <% } %>
                        <% } else { %>
                          <span class="avatar xs avatar-texto pull-left">
                            <%= isEmpty(p.nombre) ? p.email.substr(0,1).toUpperCase() : p.nombre.substr(0,1).toUpperCase() %>
                          </span>
                        <% } %>
                      </a>
                    </td>
                    <td class="">
                      <a href="app/#contacto_acciones/<%= p.id %>">
                        <span class="bold c1"><%= p.nombre %></span><br/>
                        <% if (p.propiedad_id != 0) { %>
                          <span class="c1"><%= p.propiedad_tipo_inmueble %> en <%= p.propiedad_tipo_operacion %></span><br/>
                          <%= p.propiedad_direccion %> / <%= p.propiedad_ciudad %>
                        <% } %>
                      </a>
                    </td>
                    <td><%= p.fecha %><br/><%= p.hora %></td>
                    <td>
                      <% if (!isEmpty(p.usuario)) { %>
                        <!--<span class="block text-muted fs14 mb5">Asignada a</span>-->
                        <button class="btn btn-sm"><%= p.usuario %></button>
                      <% } %>
                    </td>
                  </tr>
                <% } %>
              </table>
            </div>
            <div class="tac">
              <a class="link" href="app/#consultas">Ver todas las consultas <span class="material-icons pr t2 ml5 fs12">arrow_forward_ios</span></a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</script>

<script type="text/template" id="precios_template">
  <div ui-view="" class="fade-in-down ng-scope">
    <div class=" wrapper-md hidden-print ng-scope">
      <h1 class="m-n h3">Planes </h1>
    </div>
    <div class="wrapper-md ng-scope">
      <div class="row no-gutter m-t">

        <% for(var i=0; i< planes.length; i++) { %>
          <% var plan = planes[i] %>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <% if (plan.id == ID_PLAN) { %>
              <div class="panel b-a m-t-n-md m-b-xl">
                <div class="wrapper bg-info text-center m-l-n-xxs m-r-n-xxs">
                  <h4 class="text-u-c m-b-none"><%= plan.nombre %></h4>
                  <h2 class="m-t-none">
                    <sup class="pos-rlt" style="top:-22px">$</sup>
                    <span class="text-2x text-lt"><%= Number(plan.precio_anual).toFixed(0) %></span>
                    <span class="text-xs">/ mes</span>
                  </h2>
                </div>
                <%= plan.observaciones %>
                <div class="panel-footer text-center b-t m-t bg-light lter">
                  <a href="javascript:void(0)" class="btn btn-info m">PLAN CONTRATADO</a>
                </div>
              </div>
            <% } else { %>
              <div class="panel b-a">
                <div class="panel-heading wrapper-xs bg-success no-border">          
                </div>
                <div class="wrapper text-center b-b b-light">
                  <h4 class="text-u-c m-b-none"><%= plan.nombre %></h4>
                  <h2 class="m-t-none">
                    <sup class="pos-rlt" style="top:-22px">$</sup>
                    <span class="text-2x text-lt"><%= Number(plan.precio_anual).toFixed(0) %></span>
                    <span class="text-xs">/ mes</span>
                  </h2>
                </div>
                <%= plan.observaciones %>
                <div class="panel-footer text-center">
                  <a data-id="<%= plan.id %>" class="contratar_plan btn btn-success m">CONTRATAR</a>
                </div>
              </div>
            <% } %>
          </div>
        <% } %>
        
      </div>
    </div>
  </div>  
</script>

<script type="text/template" id="tutoriales_template">
<div class="wrapper-md">
  <div class="centrado rform">
    <div class="header-lg pt0">
      <div class="row">
        <div class="col-md-6">
          <h1 style="font-size:32px !important">Tutoriales</h1>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <ul class="submenu">
          <% for(var i=0; i< categorias_videos.length;i++) { %>
            <% var cat = categorias_videos[i] %>
            <li>
              <a class="<%= (id_modulo == cat.link)?"active":"" %>" href="app/#tutoriales/<%= cat.link %>">
                <span class="material-icons">arrow_forward_ios</span>
                <%= cat.nombre %>
              </a>
            </li>
          <% } %>
        </ul>
      </div>
      <div class="col-md-9">
        <div id="tutoriales_content"></div>
      </div>
    </div>
  </div>
</div>
</script>

<script type="text/template" id="tutoriales_detalle_view">
  <% for(var i=0;i< videos.length;i++) { %>
    <% var v = videos[i] %>
    <a href="<%= v.link %>" target="_blank" class="panel panel-default db">
      <div class="panel-body">
        <div class="padder">
          <div class="form-group mb0 clearfix cp">
            <label class="control-label cp">
              <%= v.titulo %>
            </label>
            <div class="panel-description">
              <%= v.descripcion %>
            </div>
          </div>
        </div>
      </div>
    </a>  
  <% } %>
</script>


<script type="text/template" id="soporte_template">
<div class="wrapper-md">
  <div class="centrado rform">
    <div class="header-lg pt0">
      <div class="row">
        <div class="col-md-6">
          <h1 style="font-size:32px !important">Soporte</h1>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="padder">
          <div class="form-group mb0 clearfix expand-link cp">
            <label class="control-label cp">
              <span class="material-icons fl pr t3 mr10">headset_mic</span>
              ¿Necesitás ayuda?
            </label>
          </div>
        </div>
      </div>
      <div class="panel-body expand" style="display:block">
        <div class="padder">
          <div class="panel-description mb10">
            Si tenés dudas, sugerencias o simplemente necesitás ayuda con tu cuenta,
            no dudes en contactarnos.<br/>
            Responderemos tu consulta en 24hs. hábiles a tu correo electrónico.
          </div>
          <div class="form-group">
            <select name="" id="soporte_asunto" class="form-control">
              <option>Elige un tema</option>
              <option>Ayuda con mi cuenta</option>
              <option>Errores o problemas técnicos</option>
            </select>
          </div>
          <div class="form-group">
            <textarea class="form-control h100" placeholder="Escribe tu consulta"></textarea>
          </div>
          <div class="form-group">
            <button class="btn btn-block btn-info">Enviar Consulta</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</script>

<script type="text/template" id="tutoriales_item_template">
  <a target="_blank" href="<%= video_es %>" class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix">
          <label class="control-label cp">
            <%= nombre_es %>
          </label>
          <div class="panel-description">
            <%= texto_es %>
          </div>
        </div>
      </div>
    </div>
  </a>  
</script>

<script type="text/template" id="notificacion_item_template">
  <?php // NOTIFICACION DE BIENVENIDA DE UNA NUEVA INMOBILIARIA ?>
  <% if (tipo == 4) { %>
    <div class="panel notification-panel mb0 tac">
      <a href="javascript:void(0)" class="fr cp limpiar_notificacion">
        <span class="material-icons">close</span>
      </a>
      <div class="tac">
        <span style="font-size: 36px;" class="material-icons">sentiment_satisfied_alt</span>
      </div>
      <p><%= texto %></p>
      <h3><%= titulo %></h3>
      <div class="mt5 mb5">
        <a href="app/#permisos_red/<%= link %>" class="btn btn-block btn-success aceptar_permiso_red">Invitalo a compartir</a>
      </div>
    </div>

  <?php // SOLICITUD PARA COMPARTIR EN LA WEB ?>
  <% } else if (tipo == 1) { %>
    <div class="panel notification-panel mb0 tac">
      <% if (!isEmpty(imagen)) { %>
        <div class="media">
          <img src="<%= imagen %>"/>
        </div>
      <% } %>
      <h3><%= titulo %></h3>
      <p><%= texto %></p>
      <div class="row mb20">
        <div class="col-xs-6 pr5">
          <button class="btn btn-block btn-success aceptar_permiso_red">Aceptar</button>
        </div>
        <div class="col-xs-6 pl5">
          <button class="btn btn-block btn-info descartar_permiso_red">Descartar</button>
        </div>
      </div>
      <div class="row tal">
        <div class="col-xs-2">
          <label class="i-checks">
            <input id="permiso_red_inversa" type="checkbox" class="checkbox" value="1"><i></i>            
          </label>
        </div>
        <div class="col-xs-10 pl0">
          <label class="cp" for="permiso_red_inversa">Deseo también publicar sus propiedades en mi sitio web.</label>
        </div>
      </div>
    </div>

  <?php // ALERTA DE SIMILITUD DE PROPIEDADES ?>
  <% } else if (tipo == 2) { %>    
    <div class="panel notification-panel mb0 tac">
      <a href="javascript:void(0)" class="fr cp limpiar_notificacion">
        <span class="material-icons">close</span>
      </a>
      <div class="tac">
        <span style="font-size: 36px;" class="material-icons">warning</span>
      </div>
      <h3><%= titulo %></h3>
      <p><%= texto %></p>
      <div class="mt5 mb5">
        <a href="app/#propiedades/" class="btn btn-block btn-info">Revisar</a>
      </div>
    </div>

  <?php // ALERTA DE CONSULTAS VENCIDAS ?>
  <% } else if (tipo == 3) { %>
    <div class="panel notification-panel mb0 tac">
      <a href="javascript:void(0)" class="fr cp limpiar_notificacion">
        <span class="material-icons">close</span>
      </a>
      <h3>Nuevo</h3>
      <p>Tiene consultas vencidas</p>
    </div>

  <% } %>
</script>