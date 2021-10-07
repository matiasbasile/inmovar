<style type="text/css">
.propiedad_preview .modal-body { background-color: #f0f3f4 !important; }
.propiedad_preview .modal-body .titulo { font-weight: bold; font-size: 22px; color: #2e3345; }
.propiedad_preview .modal-body .expand { background-color: white; color: #5a5a5a; font-size: 15px; }
.propiedad_preview .modal-body .expand .subtitulo { font-size: 18px; font-weight: bold; padding: 10px 0px; border-bottom: solid 1px #dddedf; margin-bottom: 15px; color: #2e3345; }
#propiedades_preview_slider { margin: 0px 0px 10px 0px; border: none; }
.propiedad-preview .flex-direction-nav a { text-shadow: none; width: 46px; height: 46px; background-color: white; border-radius: 100%; text-align: center; }
.propiedad-preview .flex-direction-nav a:before { font-size: 20px; line-height: 50px; }
.propiedad-preview .flex-direction-nav a.flex-prev:before { text-indent: -3px; }
.propiedad-preview .flex-direction-nav a.flex-next:before { text-indent: 3px; }
#propiedades_preview_carousel { margin: 0px; border: none; }
#propiedades_preview_carousel .slides img { padding: 5px; cursor: pointer; }
.propiedad_preview_texto iframe { width: 100%; }
</style>
<div class='modal-content propiedad-preview'>
  <div class='modal-body'>
    <div class="row pl10 pr10">
      <div class="col-md-6 pl5 pr5">
        <div class="">
          <div class="tab-container mb0">
            <ul class="nav nav-tabs nav-tabs-2" role="tablist">
              <li class="active">
                <a id="propiedad_preview_1_link" href="#propiedad_preview_tab1" class="oh buscar_todos" role="tab" data-toggle="tab">
                  <i class="material-icons">image</i>
                  <span class="hidden-xs m-l-xs">Im&aacute;genes</span>
                </a>
              </li>
              <li>
                <a id="propiedad_preview_2_link" class="oh" href="#propiedad_preview_tab2" role="tab" data-toggle="tab">
                  <i class="material-icons">room</i>
                  <span class="hidden-xs m-l-xs">Ubicaci&oacute;n</span>
                </a>
              </li>
              <% if(!isEmpty(nota_publica) || !isEmpty(nota_privada)) { %>
                <li>
                  <a id="propiedad_preview_4_link" class="oh" href="#propiedad_preview_tab4" role="tab" data-toggle="tab">
                    <i class="material-icons">event_note</i>
                    <span class="hidden-xs m-l-xs">Notas</span>
                  </a>
                </li>
              <% } %>

              <% if (id_empresa != ID_EMPRESA) { %>
                <li>
                  <a id="propiedad_preview_3_link" class="oh" href="#propiedad_preview_tab3" role="tab" data-toggle="tab">
                    <i class="material-icons">share</i>
                    <span class="hidden-xs m-l-xs">Datos de la Red</span>
                  </a>
                </li>
              <% } %>

              <% if (id_empresa == ID_EMPRESA) { %>
              
                <li class="">
                  <a id="propiedad_preview_5_link" href="#propiedad_preview_tab5" class="oh buscar_todos" role="tab" data-toggle="tab">
                    <i class="material-icons">schedule</i>
                    <span class="hidden-xs m-l-xs"> Reportes</span>
                  </a>
                </li>
              
              <% } %>

              <li class="show-xs-dib fr" id="cerrar_preview" style="float: right !important;">
                <a href="javascript:void" class="oh" style="background-color: transparent !important; border-color: transparent !important; padding-right: 0px !important">
                  <i class="material-icons mr0">close</i>
                </a>
              </li>
            </ul>
            <div class="tab-content" style="overflow: auto;max-height: 562px;">

              <div id="propiedad_preview_tab1" class="tab-pane active">
                <div id="propiedades_preview_slider" class="flexslider">
                  <ul class="slides">
                    <% for (var i=0;i< images.length;i++) { %>
                      <% var im2 = images[i] %>
                      <% var im = (isEmpty(im2)) ? "" : ((im2.indexOf("http")==0) ? im2 : '/admin/'+im2) %>
                      <li>
                        <div style="overflow: hidden; width: 100%; height: 400px; background-image: url(<%= im %>); background-repeat: no-repeat; background-position: center center; background-size: contain"></div>
                      </li>
                    <% } %>
                  </ul>
                </div>
                <div id="propiedades_preview_carousel" class="flexslider">
                  <ul class="slides">
                    <% for (var i=0;i< images.length;i++) { %>
                      <% var im2 = images[i] %>
                      <% var im = (isEmpty(im2)) ? "" : ((im2.indexOf("http")==0) ? im2 : '/admin/'+im2) %>
                      <li style="margin: 5px">
                        <div style="overflow: hidden; width: 100%; height: 100px; background-image: url(<%= im %>); cursor: pointer; background-repeat: no-repeat; background-position: center center; background-size: cover"></div>
                      </li>
                    <% } %>
                  </ul>
                </div>
              </div>

              <div id="propiedad_preview_tab2" class="tab-pane">
                <div style="height:510px;" id="propiedad_preview_mapa"></div>
              </div>

              <div id="propiedad_preview_tab4" class="tab-pane">
                <% if (id_empresa == ID_EMPRESA && !isEmpty(nota_privada)) { %>
                  <div class="mb30">
                    <b>Nota Privada:</b><br/>
                    <%= nota_privada %>
                  </div>
                  <hr/>
                <% } %>
                <% if(!isEmpty(nota_publica)) { %>
                  <div>
                    <b>Nota P&uacute;blica:</b><br/>
                    <%= nota_publica %>
                  </div>
                <% } %>
              </div>

              <div id="propiedad_preview_tab3" class="tab-pane">
                <div class="titulo mt5 mb10"><%= empresa %></div>
                <% if (!isEmpty(empresa_direccion)) { %>
                  <div class="clearfix mb15">
                    <b>Direcci&oacute;n:</b> <span><%= empresa_direccion %></span>
                  </div>
                <% } %>
                <% if (!isEmpty(empresa_telefono)) { %>
                  <div class="clearfix mb15">
                    <b>Tel&eacute;fono:</b> <span><%= empresa_telefono %></span>
                  </div>
                <% } %>
                <% if (!isEmpty(empresa_email)) { %>
                  <div class="clearfix mb15">
                    <b>Email:</b> <a class="text-info cp" href="mailto:<%= empresa_email %>"><%= empresa_email %></a>
                  </div>
                <% } %>
              </div>

              <div id="propiedad_preview_tab5" class="tab-pane">

                <div class="row fixed-grafico">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Fecha desde</label>
                      <div class="input-group">
                        <input type="text" name="fecha_cobro" class="form-control" id="propiedad_preview_fecha_desde"/>
                        <span class="input-group-btn">
                          <button style="height: 35px;" tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="material-icons">date_range</i></button>
                        </span>              
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Fecha hasta</label>
                      <div class="input-group">
                        <input type="text" name="fecha_debitado" class="form-control" id="propiedad_preview_fecha_hasta"/>
                        <span class="input-group-btn">
                          <button style="height: 35px;" tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="material-icons">date_range</i></button>
                        </span>              
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mt20 tar">
                    <button class="btn btn-info imprimir_reporte">Imprimir PDF</button>
                  </div>
                </div>

                <div class="row">
      		        <div class="col-sm-12">
      					    <div class="block panel padder-v item bg-info mb0" style="height: 105px; margin-top: 70px;">
      						  	<div class="h1 font-thin text-white h1 m-t-md total_visitas tac mt10">0</div>
      						  	<span class="text-muted text-md tac db">Visitas</span>
      						</div>
		            </div>
                <div class="col-sm-4">
      						<div class="block panel padder-v item" style="height: 105px">
      						  	<span class="font-thin text-muted h1 block m-t-md total_web tac">0</span>
      						  	<span class="text-muted text-md db tac">En tu Web</span>
      						</div>
              	</div>
              	<div class="col-sm-4">
      						<div class="block panel padder-v item" style="height: 105px">
      						  	<span class="font-thin h1 block m-t-md total_otra_web tac">0</span>
      						  	<span class="text-muted text-md db tac fs16">Otras Web</span>
      						</div>
                </div>
                <div class="col-sm-4">
      						<div class="block panel padder-v item" style="height: 105px">
      						  	<span class="font-thin h1 block m-t-md total_panel tac">0</span>
      						  	<span class="text-muted text-md db tac">En el panel</span>
      						</div>
                </div>
              </div>
              <div class="row">
		            <div class="col-sm-12">
					       <div class="block panel padder-v item bg-success mb0" style="height: 105px">
						  	   <div class="h1 font-thin text-white h1 m-t-md total_consultas tac mt10">0</div>
						  	   <span class="text-muted text-md tac db">Consultas</span>
						     </div>
		            </div>
              <div class="col-sm-4">
    						<div class="block panel padder-v item" style="height: 105px">
    						  	<span class="font-thin h1 block m-t-md consultas_web tac">0</span>
    						  	<span class="text-muted text-md db tac">En tu Web</span>
    						</div>
              </div>
              <div class="col-sm-4">
    						<div class="block panel padder-v item" style="height: 105px">
    						  	<span class="font-thin h1 block m-t-md consultas_otra_web tac">0</span>
    						  	<span class="text-muted text-md db tac">Otras Web</span>
    						</div>
              </div>
              <div class="col-sm-4">
    						<div class="block panel padder-v item" style="height: 105px">
    						  	<span class="font-thin h1 block m-t-md consultas_panel tac">0</span>
    						  	<span class="text-muted text-md db tac">En el panel</span>
    						</div>
              </div>
            </div>
                <div class="h150" style="width: 540px;" id="vision_general_bar"></div>

                <div class="consultas">
                  <div class="row">
                    <div class="col-md-12 consul">
                      <% for(var i=0;i< data_graficos.clientes_consultas.length;i++) { %>
                        <% var r = data_graficos.clientes_consultas[i] %>
                        <% if (c.tipo == 1) tipo = 'A contactar'; %>
                        <% if (c.tipo == 2) tipo = 'Contactado'; %>
                        <% if (c.tipo == 3) tipo = 'Con actividad'; %>
                        <% if (c.tipo == 4) tipo = 'En negociacion' %>
                        <p><span class="text-info"> <%= r.cliente_nombre %></span> | <%= moment(r.fecha,"YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY HH:mm:ss") %> | <%= tipo %> </p>
                      <% } %>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 pl5 pr5">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="padder">

              <div class="clearfix">
                <% if (!isEmpty(codigo)) { %>
                  <b>C&oacute;digo:</b> <span><%= codigo_completo %></span> 
                <% } %>
                <span class="etiqueta pull-right"><%= tipo_estado %></span>
              </div>

              <div class="titulo mt5 mb10"><%= tipo_inmueble %> en <%= tipo_operacion %></div>

              <div class="clearfix mb15">
                <% if (!isEmpty(direccion_completa)) { %>
                  <span><%= direccion_completa %></span> | 
                <% } %>
                <span><%= localidad %></span>
              </div>

              <div class="clearfix">
                <div class="titulo"><%= moneda %> <%= Number(precio_final).format(0) %></div>
                <div class="oh">
                  <% if (apto_banco==1) { %>
                    <span class="dib mr15 btn etiqueta btn-menu-compartir">Apto Crédito Bancario</span>
                  <% } %>
                  <% if (acepta_permuta==1) { %>
                    <span class="dib mr15 btn etiqueta btn-menu-compartir">Acepta Permuta</span>
                  <% } %>
                </div>
              </div>

            </div>
          </div>
          <div class="panel-body expand db">
            <div class="padder">
              <div class="subtitulo">Informaci&oacute;n B&aacute;sica</div>
              <div class="propiedad_preview_texto"><%= texto %></div>
              <div class="subtitulo">Caracter&iacute;sticas</div>
              <div class="row pl10 pr10">
                <div class="col-sm-4 col-xs-6 mb15 pl5 pr5">
                  <b>Dormitorios: </b> <%= (dormitorios>0)?dormitorios:"-" %>
                </div>
                <div class="col-sm-4 col-xs-6 mb15 pl5 pr5">
                  <b>Ba&ntilde;os: </b> <%= (banios>0)?banios:"-" %>
                </div>
                <div class="col-sm-4 col-xs-6 mb15 pl5 pr5">
                  <b>Cochera: </b> <%= (cocheras>0)?cocheras:"No posee" %>
                </div>
                <div class="col-sm-4 col-xs-6 mb15 pl5 pr5">
                  <b>Sup. Total: </b> <%= (superficie_total>0)?superficie_total+" Mts.<sup>2</sup>":"-" %>
                </div>
                <div class="col-sm-4 col-xs-6 mb15 pl5 pr5">
                  <b>Antig&uuml;edad: </b> 
                  <%= (nuevo == 0)?"No definida":"" %>
                  <%= (nuevo == 1)?"A estrenar":"" %>
                  <%= (nuevo == 2)?"Aprox. 2 a&ntilde;os":"" %>
                  <%= (nuevo == 5)?"Aprox. 5 a&ntilde;os":"" %>
                  <%= (nuevo == 10)?"Aprox. 10 a&ntilde;os":"" %>
                  <%= (nuevo == 20)?"Aprox. 20 a&ntilde;os":"" %>
                  <%= (nuevo == 30)?"Aprox. 30 a&ntilde;os":"" %>
                  <%= (nuevo == 40)?"Aprox. 40 a&ntilde;os":"" %>
                  <%= (nuevo == 50)?"Aprox. 50 a&ntilde;os":"" %>
                  <%= (nuevo == 60)?"Aprox. 60 a&ntilde;os":"" %>
                  <%= (nuevo == 70)?"Aprox. 70 a&ntilde;os":"" %>
                  <%= (nuevo == 80)?"Aprox. 80 a&ntilde;os":"" %>
                  <%= (nuevo == 90)?"Aprox. 90 a&ntilde;os":"" %>
                  <%= (nuevo == 100)?"Aprox. 100 a&ntilde;os":"" %>
                  <%= (nuevo == 200)?"M&aacute;s de 100 a&ntilde;os":"" %>
                </div>
              </div>
            </div>
          </div>
          
          <div class="panel-footer">
            <div>
              <!--
              <button class="btn btn-default mr5 enviar_whatsapp btn-addon"><i class="icon text-success fa fa-whatsapp"></i>Enviar Whatsapp</button>
              <button class="btn btn-default mr5 marcar_interes btn-addon"><i class="icon text-warning fa fa-star"></i>Marcar Inter&eacute;s</button>
              <button class="btn btn-default mr5 enviar btn-addon"><i class="icon fa text-info fa-send"></i>Enviar Email</button>
              -->
              <button class="btn btn-default mr5 ver_ficha btn-addon"><i class="icon fa fa-file text-muted-2"></i>Ver Ficha</button>
              <% if (id_empresa == ID_EMPRESA) { %>
                <button class="btn btn-default mr5 editar btn-addon"><i class="icon fa fa-pencil"></i>Editar</button>
              <% } %>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
