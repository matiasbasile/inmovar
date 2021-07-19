<script type="text/template" id="inicio_template">
  <div class="centrado rform">
    <div class="header-lg">
      <div class="row">
        <div class="col-xs-12 col-sm-9">
          <h1>Dashboard</h1>
        </div>
        <div class="col-xs-12 col-sm-3 tar">
          <input type="text" id="inicio_rango_fechas" class="form-control w100p calendar fr mt20">
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
          <a class="link fs14 block" href="app/#consultas"><i class="fa fa-external-link mr5"></i> Ver todas las consultas</a>
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
          <a class="link fs14 block" href="app/#permisos_red"><i class="fa fa-external-link mr5"></i> Ver inmobiliarias de la red</a>
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
          <a class="link fs14 block" href="javascript:workspace.ver_red()"><i class="fa fa-external-link mr5"></i> Ver tu red inmobiliaria</a>
        </div>
      </div>  

    </div>
    <div class="row">

      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading wrapper b-b b-light">
            <h4 class="m-t-none m-b-none"><span class="material-icons fs20 pr t2 mr10">local_offer</span> Visitas a tus Propiedades</h4>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-7">
                <table class="table w100p sin-borde">
                  <tr>
                    <td class="c-main"><span class="material-icons fs12 mr5">stop_circle</span> En Tu Sitio Web</td>
                    <td class="vam"><h3 class="c-main p0 m0"><%= visitas_sitio_web %></h3></td>
                  </tr>
                  <tr>
                    <td class="c-sec vam"><span class="material-icons fs12 mr5">stop_circle</span> Sitios Web de Red Inmovar</td>
                    <td class="vam"><h3 class="c-sec p0 m0"><%= visitas_red %></h3></td>
                  </tr>
                </table>
              </div>
              <div class="col-md-5">
                <div id="visitas_bar" style="height: 150px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading wrapper b-b b-light">
            <h4 class="m-t-none m-b-none"><span class="material-icons fs20 pr t2 mr10">local_offer</span> Consultas a tus Propiedades</h4>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-7">
                <table class="table w100p sin-borde">
                  <tr>
                    <td class="c-main"><span class="material-icons fs12 mr5">stop_circle</span> En Tu Sitio Web</td>
                    <td class="vam"><h3 class="c-main p0 m0"><%= consultas_sitio_web %></h3></td>
                  </tr>
                  <tr>
                    <td class="c-sec vam"><span class="material-icons fs12 mr5">stop_circle</span> Sitios Web de Red Inmovar</td>
                    <td class="vam"><h3 class="c-sec p0 m0"><%= consultas_red %></h3></td>
                  </tr>
                </table>
              </div>
              <div class="col-md-5">
                <div id="consultas_bar" style="height: 150px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="panel panel-default mb20">
          <div class="panel-heading wrapper b-b b-light">
            <h4 class="m-t-none m-b-none"><span class="material-icons fs20 pr t2 mr10">local_offer</span> Tus Propiedades Más Visitadas</h4>
          </div>
          <div class="panel-body">
            <div class="mh250">
              <table class="table w100p sin-borde">
                <% for(var i=0;i< mas_visitadas.length;i++) { %>
                  <% var p = mas_visitadas[i] %>
                  <tr>
                    <td class="pl15 pr0 w25">
                      <% if (!isEmpty(p.path)) { %>
                        <a href="app/#propiedades/<%= p.id %>">
                          <% var prefix = (p.path.indexOf("http") == 0) ? "" : "/admin/" %>
                          <img src="<%= prefix + p.path %>?t=<%= Math.ceil(Math.random()*10000) %>" class="customcomplete-image mr0"/>
                        </a>
                      <% } %>
                    </td>
                    <td class="">
                      <a href="app/#propiedades/<%= p.id %>">
                        <span class="c1"><%= p.titulo %></span><br/>
                        <span class="bold c1"><%= p.direccion_completa %></span><br/>
                        <span class="c1"><%= p.localidad %></span>
                      </a>
                    </td>
                    <td>
                      <button class="btn etiqueta"><%= p.visitas %> visitas</button>
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
                    <td class="pl15 pr0 w25">
                      <a href="app/#contacto_acciones/<%= p.id %>">
                        <% if (!isEmpty(p.path)) { %>
                          <% if (p.path.indexOf("http") == 0) { %>
                            <img src="<%= p.path %>" class="customcomplete-image mr0"/>
                          <% } else { %>
                            <img src="/admin/<%= p.path %>" class="customcomplete-image mr0"/>
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
  <div class="centrado rform">
    <div class="header-lg">
      <h1>Planes</h1>
    </div>
    <div class="row no-gutter m-t">

      <% for(var i=0; i< planes.length; i++) { %>
        <% var plan = planes[i] %>
        <% var descuento = (100 - Number((plan.precio_anual / plan.precio_sin_dto) * 100).toFixed(0)) %>
        <div class="col-md-4">
          <% if (plan.id == ID_PLAN) { %>
            <div class="plan panel b-a m-t-n-md m-b-xl">
              <div class="wrapper bg-info text-center m-l-n-xxs m-r-n-xxs">
                <h4 class="text-u-c m-b-none"><%= plan.nombre %></h4>
                <h2 class="m-t-none">
                  <% if (plan.precio_anual == 0) { %>
                    <span class="text-2x text-lt">GRATIS</span>
                  <% } else { %>
                    <sup class="pos-rlt" style="top:-22px">$</sup>
                    <span class="text-2x text-lt"><%= Number(plan.precio_anual).format(0) %></span>
                    <span class="text-xs">/ mes</span>
                  <% } %>
                </h2>
                <div class="tac fs18">
                  <% if (descuento > 0) { %>
                    <span><%= descuento %>% OFF!</span> 
                  <% } %>
                  <% if (plan.precio_sin_dto != 0) { %>
                    $<strike><%= Number(plan.precio_sin_dto).format(0) %></strike>
                  <% } %>
                </div>
              </div>
              <%= plan.observaciones %>
              <div class="panel-footer text-center b-t m-t bg-light lter">
                <a href="javascript:void(0)" class="btn btn-info m">PLAN CONTRATADO</a>
              </div>
            </div>
          <% } else { %>
            <div class="panel plan b-a">
              <div class="panel-heading wrapper-xs bg-success no-border">          
              </div>
              <div class="wrapper text-center b-b b-light">
                <h4 class="text-u-c m-b-none"><%= plan.nombre %></h4>
                <h2 class="m-t-none">
                  <% if (plan.precio_anual == 0) { %>
                    <span class="text-2x text-lt">GRATIS</span>
                  <% } else { %>
                    <sup class="pos-rlt" style="top:-22px">$</sup>
                    <span class="text-2x text-lt"><%= Number(plan.precio_anual).format(0) %></span>
                    <span class="text-xs">/ mes</span>
                  <% } %>
                </h2>
                <div class="tac fs18">
                  <% if (descuento > 0) { %>
                    <span><%= descuento %>% OFF!</span>
                  <% } %>
                  <% if (plan.precio_sin_dto != 0) { %>
                    $<strike><%= Number(plan.precio_anual).format(0) %></strike>
                  <% } %>
                </div>
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
</script>

<script type="text/template" id="tutoriales_template">
  <div class="centrado rform">
    <div class="header-lg">
      <h1>Tutoriales</h1>
    </div>
    <div class="row">
      <div class="col-md-3">
        <ul class="submenu">
          <% for(var i=0; i< categorias_videos.length;i++) { %>
            <% var cat = categorias_videos[i] %>
            <li>
              <a class="<%= (id_modulo == cat.nombre)?"active":"" %>" href="app/#tutoriales/<%= encodeURIComponent(cat.nombre) %>">
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
</script>

<script type="text/template" id="tutoriales_detalle_view">
  <% for(var i=0;i< videos.length;i++) { %>
    <% var v = videos[i] %>
    <div class="panel panel-default db">
      <div class="panel-body">
        <div class="padder">
          <div class="form-group mb0 clearfix expand-link cp">
            <label class="control-label cp">
              <%= v.titulo %>
            </label>
            <div class="panel-description">
              <%= v.descripcion %>
            </div>
          </div>
        </div>
      </div>
      <div class="panel-body expand" style="display:none">
        <iframe width="100%" height="400" src="https://www.youtube.com/embed/<%= v.link %>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>  
  <% } %>
</script>


<script type="text/template" id="soporte_template">
  <div class="centrado rform">
    <div class="header-lg">
      <h1>Soporte</h1>
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
            <select id="soporte_asunto" class="form-control">
              <option value="">Elige un tema</option>
              <option>Ayuda con mi cuenta</option>
              <option>Errores o problemas técnicos</option>
            </select>
          </div>
          <div class="form-group">
            <textarea id="soporte_texto" class="form-control h100" placeholder="Escribe tu consulta"></textarea>
          </div>
          <div class="form-group">
            <button id="soporte_enviar" class="btn btn-block btn-info">Enviar Consulta</button>
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
  <% if (tipo == "B") { %>
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
  <% } else if (tipo == "S") { %>
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
  <% } else if (tipo == "W") { %>    
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

  <?php // ALERTA DE BUSQUEDAS NUEVAS ?>
  <% } else if (tipo == "Z") { %>
    <div class="panel notification-panel mb0 tac">
      <a href="javascript:void(0)" class="fr cp limpiar_notificacion">
        <span class="material-icons">close</span>
      </a>
      <div class="tac">
        <span style="font-size: 36px;" class="material-icons">warning</span>
      </div>
      <h3>Nuevas búsquedas</h3>
      <p><%= texto %></p>
      <div class="mt5 mb5">
        <a href="app/#busquedas/" class="btn btn-block btn-info">Ver búsquedas</a>
      </div>
    </div>

  <?php // ALERTA DE CONSULTAS VENCIDAS ?>
  <% } else if (tipo == "V") { %>
    <div class="panel notification-panel mb0 tac">
      <a href="javascript:void(0)" class="fr cp limpiar_notificacion">
        <span class="material-icons">close</span>
      </a>
      <h3>Atención</h3>
      <p><%= texto %></p>
      <div class="mt5 mb5">
        <a href="app/#consultas_vencidas/" class="btn btn-block btn-info">Ver consultas</a>
      </div>
    </div>

  <% } %>
</script>