<script type="text/template" id="usuarios_panel_template">
  <div class="mb20">
    <div class="input-group">
      <input type="text" id="usuarios_buscar" value="<%= window.usuarios_filter %>" placeholder="<?php echo lang(array("es"=>"Buscar","en"=>"Search")); ?>..." autocomplete="off" class="form-control">
      <span class="input-group-btn pl5 pr5">
        <select id="usuarios_perfiles" class="w250 form-control no-model"></select>
      </span>
      <span class="input-group-btn">
        <a class="btn btn-info nuevo" href="javascript:void(0)">&nbsp;&nbsp;<?php echo lang(array("es"=>"Nuevo Usuario","en"=>"Add User")); ?>&nbsp;&nbsp;</a>
      </span>
    </div>
  </div>
  <div class="table-responsive">
    <table id="usuarios_table" class="table table-striped sortable m-b-none default">
      <thead>
        <tr>
          <th><?php echo lang(array("es"=>"Nombre","en"=>"Name")); ?></th>
          <th><?php echo lang(array("es"=>"Perfil","en"=>"Profile")); ?></th>
          <th class="th_acciones tar"><?php echo lang(array("es"=>"Acciones","en"=>"Actions")); ?></th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</script>

<script type="text/template" id="usuarios_item">
  <% var clase = (activo==1)?"text-info":"text-muted" %>
  <td class="ver"><span class='<%= clase %>'><%= nombre.ucwords() %></span></td>
  <td class='ver'><span><%= perfil.ucwords() %></span></td>
  <td class="p5 td_acciones tar">
    <i data-toggle="tooltip" title="Activo" class="fa-check iconito fa activo <%= (activo == 1)?"active":"" %>"></i>
    <div class="btn-group dropdown ml10">
      <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-plus"></i>
      </button>        
      <ul class="dropdown-menu pull-right">
        <% if (VOLVER_SUPERADMIN == 1 || ID_USUARIO == 0) { %>
          <li><a href="javascript:void(0)" class="login" data-id="<%= id %>">Login</a></li>
        <% } %>
        <li><a href="javascript:void(0)" class="duplicar" data-id="<%= id %>"><?php echo lang(array("es"=>"Duplicar","en"=>"Duplicate")); ?></a></li>
        <li><a href="javascript:void(0)" class="delete" data-id="<%= id %>"><?php echo lang(array("es"=>"Eliminar","en"=>"Delete")); ?></a></li>
      </ul>
    </div>    
  </td>
</script>

<script type="text/template" id="usuarios_edit_panel_template">
  <div class="modal-header">
    <b>Editar usuario</b>
    <i class="pull-right cerrar_lightbox fs16 fa fa-times cp"></i>
  </div>
  <div class="modal-body">
    <div class="tab-container">
      <ul class="nav nav-tabs nav-tabs-2" role="tablist">
        <li class="active">
          <a role="tab" data-toggle="tab" href="#usuario_edit_ppal">
            <i class="material-icons">vpn_key</i> Datos de usuario
          </a>
        </li>
        <li>
          <a role="tab" data-toggle="tab" href="#usuario_edit_datos">
            <i class="material-icons">account_circle</i> Datos personales
          </a>
        </li>
        <li>
          <a role="tab" data-toggle="tab" href="#usuario_edit_whatsapp">
            <i class="material-icons">schedule</i> Horarios de atención
          </a>
        </li>
      </ul>
      <div class="tab-content">
        <div id="usuario_edit_ppal" class="tab-pane active">
          <div class="">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label"><?php echo lang(array("es"=>"Nombre","en"=>"Name")); ?></label>
                  <input type="text" name="nombre" class="form-control" id="nombre" value="<%= nombre %>"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Email</label>
                  <input type="text" name="email" class="form-control" id="usuarios_email" value="<%= email %>"/>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label"><?php echo lang(array("es"=>"Perfil","en"=>"Profile")); ?></label>
              <select class="form-control" id="usuario_perfiles"></select>
            </div>

            <% if (cambiar_password) { %>
              <div class="form-group">
                <label class="control-label"><?php echo lang(array("es"=>"Contrase&ntilde;a","en"=>"Password")); ?></label>
                <input type="password" autocomplete="new-password" class="form-control" id="usuarios_password" placeholder="<?php echo lang(array("es"=>"Escriba aqui para cambiar la contrase&ntilde;a","en"=>"Enter here your new password")); ?>"/>
              </div>
              <div class="form-group">
                <label class="control-label"><?php echo lang(array("es"=>"Repetir contrase&ntilde;a","en"=>"Repeat password")); ?></label>
                <input type="password" autocomplete="new-password" class="form-control" id="usuarios_password_2" placeholder="<?php echo lang(array("es"=>"Escriba nuevamente la contrase&ntilde;a anterior","en"=>"Repeat your new password")); ?> "/>
              </div>
            <% } %>            

          </div>
        </div>
        <div id="usuario_edit_datos" class="tab-pane">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label"><?php echo lang(array("es"=>"DNI","en"=>"Identification Number")); ?></label>
                <div class="">
                  <input type="text" name="dni" class="form-control" id="dni" value="<%= dni %>"/>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label"><?php echo lang(array("es"=>"Direcci&oacute;n","en"=>"Address")); ?></label>
                <div class="">
                  <input type="text" name="direccion" class="form-control" id="direccion" value="<%= direccion %>"/>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label"><?php echo lang(array("es"=>"Tel&eacute;fono","en"=>"Telephone")); ?></label>
                <div class="">
                  <input type="text" name="telefono" class="form-control" id="telefono" value="<%= telefono %>"/>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label"><?php echo lang(array("es"=>"Celular","en"=>"Mobile")); ?></label>
                <div class="">
                  <input type="text" name="celular" class="form-control" id="celular" value="<%= celular %>"/>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label"><?php echo lang(array("es"=>"Idioma","en"=>"Language")); ?></label>
                <div class="">
                  <select class="form-control" name="language" id="usuario_language">
                    <option <%= (language=="es")?"selected":"" %> value="es"><?php echo lang(array("es"=>"Espa&ntilde;ol","en"=>"Spanish")); ?></option>
                    <option <%= (language=="en")?"selected":"" %> value="en"><?php echo lang(array("es"=>"Ingl&eacute;s","en"=>"English")); ?></option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label"><?php echo lang(array("es"=>"Cargo","en"=>"Position")); ?></label>
                <div class="">
                  <input type="text" name="cargo" class="form-control" id="cargo" value="<%= cargo %>"/>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label"><?php echo lang(array("es"=>"Titulo","en"=>"Title")); ?></label>
                <div class="">
                  <input type="text" name="titulo" class="form-control" id="titulo" value="<%= titulo %>"/>
                </div>
              </div>
            </div>
          </div>

          <?php
          single_upload(array(
            "name"=>"path",
            "label"=>lang(array("es"=>"Foto","en"=>"Photo")),
            "url"=>"/admin/usuarios/function/save_image/",
            "width"=>(isset($empresa->config["usuario_image_width"]) ? $empresa->config["usuario_image_width"] : 256),
            "height"=>(isset($empresa->config["usuario_image_height"]) ? $empresa->config["usuario_image_height"] : 256),
          )); ?>

          <?php
          single_upload(array(
            "name"=>"path_2",
            "label"=>lang(array("es"=>"Portada","en"=>"Portada")),
            "url"=>"/admin/usuarios/function/save_image/",
            "width"=>(isset($empresa->config["usuario_image_2_width"]) ? $empresa->config["usuario_image_2_width"] : 256),
            "height"=>(isset($empresa->config["usuario_image_2_height"]) ? $empresa->config["usuario_image_2_height"] : 256),
          )); ?>

          <?php /* GRUPO URBANO UTILIZA ESTAS OPCIONES */ ?>
          <% if (ID_EMPRESA == 45) { %>
            <?php
            single_file_upload(array(
              "label"=>"Archivo para descargar",
              "name"=>"archivo",
              "url"=>"/admin/usuarios/function/save_file/",
            )); ?>
          <% } %>        

          <div class="form-group">
            <div class="checkbox">
              <label class="i-checks">
                <input type="checkbox" name="aparece_web" class="checkbox" value="1" <%= (aparece_web == 1)?"checked":"" %>><i></i>
                <?php echo lang(array("es"=>"Habilitar el usuario para que aparezca en la web","en"=>"Enable the user to appear on the web")); ?>
              </label>
            </div>
          </div>

          <div class="form-group">
            <div class="checkbox">
              <label class="i-checks">
                <input type="checkbox" name="solo_usuario" class="checkbox" value="1" <%= (solo_usuario == 1)?"checked":"" %>><i></i>
                <?php echo lang(array("es"=>"Mostrar solamente la informacion correspondiente al usuario","en"=>"Show only the information created by the user")); ?>
              </label>
            </div>        
          </div>

        </div>  


        <div id="usuario_edit_whatsapp" class="tab-pane">

          <div class="row clearfix">
            <div class="form-group col-sm-4">
              <label class="control-label">Dia de la semana</label>
              <select id="usuario_horario_dia" class="form-control no-model" style="width: 100%">
                <option value="1">Lunes</option>
                <option value="2">Martes</option>
                <option value="3">Miercoles</option>
                <option value="4">Jueves</option>
                <option value="5">Viernes</option>
                <option value="6">Sabado</option>
                <option value="7">Domingo</option>
              </select>
            </div>
            <div class="form-group col-sm-2">
              <label class="control-label">Hora desde</label>
              <input type="text" id="usuario_horario_desde" class="form-control">
            </div>
            <div class="form-group col-sm-2">
              <label class="control-label">Hora hasta</label>
              <input type="text" id="usuario_horario_hasta" class="form-control">
            </div>
            <div class="form-group col-sm-2">
              <label class="control-label">&nbsp;</label>
              <a id="horario_agregar" class="btn btn-default btn-block">+ Agregar</a>
            </div>
          </div>
          <div class="table-responsive">
            <table id="usuario_horarios_tabla" class="table m-b-none default footable">
              <thead>
                <tr>
                  <th style="display: none"></th>
                  <th>Dia de la semana</th>
                  <th>Desde</th>
                  <th>Hasta</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <% for(var i=0;i< horarios.length;i++) { %>
                  <% var p = horarios[i] %>
                  <tr>
                    <td class='dn dia'><%= p.dia %></td>
                    <td class="editar_horario">
                      <span class="text-info editar_horario">
                        <%= (p.dia==1)?"Lunes":"" %>
                        <%= (p.dia==2)?"Martes":"" %>
                        <%= (p.dia==3)?"Miercoles":"" %>
                        <%= (p.dia==4)?"Jueves":"" %>
                        <%= (p.dia==5)?"Viernes":"" %>
                        <%= (p.dia==6)?"Sabado":"" %>
                        <%= (p.dia==7)?"Domingo":"" %>
                      </span>
                    </td>
                    <td class="desde editar_horario"><%= p.desde.substr(0,5) %></td>
                    <td class="hasta editar_horario"><%= p.hasta.substr(0,5) %></td>
                    <td class="tar">
                      <button class="btn btn-sm btn-white eliminar_horario"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                <% } %>
              </tbody>
            </table>
          </div>
          <div class="form-group">
            <label class="control-label">En caso de estar fuera de horario:</label>
            <div class="">
              <select class="form-control" name="ocultar_notificaciones" id="usuario_ocultar_notificaciones">
                <option <%= (ocultar_notificaciones=="0")?"selected":"" %> value="0"><?php echo lang(array("es"=>"Marcar como no disponible y mostrar formulario de contacto","en"=>"Set the user as not available and show the form.")); ?></option>
                <option <%= (ocultar_notificaciones=="1")?"selected":"" %> value="1"><?php echo lang(array("es"=>"No mostrar el usuario","en"=>"Hide the user")); ?></option>
              </select>
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>

  <% if (cambiar_password) { %>
    <div class="modal-footer">
      <button class="btn btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
    </div>
  <% } %>

</script>