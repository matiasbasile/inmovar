<div class=" wrapper-md">
  <h1 class="m-n h3"><i class="fa fa-user-md icono_principal"></i><b>Profesionales</b></h1>
</div>
<div class="wrapper-md">
  <div class="centrado rform">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="padder">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label"><?php echo lang(array("es"=>"Nombre y Apellido","en"=>"Name")); ?></label>
                  <input type="text" <%= (!edicion || PERFIL == 1357)?"disabled":"" %> name="nombre" class="form-control" id="nombre" value="<%= nombre %>"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Email</label>
                  <input type="text" <%= (!edicion || id != undefined)?"disabled":"" %> name="email" class="form-control" id="usuarios_email" value="<%= email %>"/>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label">Títulos</label>
              <select id="usuario_titulos" class="w100p"></select>
            </div>            

            <div class="form-group">
              <label class="control-label">Nro. de Matrícula</label>
              <input type="text" <%= (!edicion || PERFIL == 1357)?"disabled":"" %> name="cargo" class="form-control" id="usuarios_cargo" value="<%= cargo %>"/>
            </div>

            <div class="form-group">
              <label class="control-label mb0">Temáticas más buscadas por los pacientes</label>
              <div class="text-muted fs14 mb5">A continuación podrá cargar todas las temáticas o áreas de trabajo:</div>
              <select id="usuario_toque_categorias" class="w100p"></select>
            </div>

          </div>
        </div>
      </div>

      <% if (edicion || cambiar_password) { %>
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="padder">
              <div class="form-group mb0 clearfix">
                <label class="control-label">
                  <?php echo lang(array("es"=>"Contrase&ntilde;a","en"=>"Password")); ?>
                </label>
                <a class="expand-link fr">
                  <?php echo lang(array(
                    "es"=>"Cambiar contrase&ntilde;a",
                    "en"=>"Change password",
                  )); ?>
                </a>
                <div class="panel-description">
                  <?php echo lang(array(
                    "es"=>"Clave utilizada para ingresar al sistema.",
                    "en"=>"In this section you can change your personal password.",
                  )); ?>                  
                </div>
              </div>
            </div>
          </div>
          <div class="panel-body expand">
            <div class="padder">
              <div class="form-group">
                <label class="control-label"><?php echo lang(array("es"=>"Contrase&ntilde;a","en"=>"Password")); ?></label>
                <input type="password" autocomplete="new-password" class="form-control" id="usuarios_password" placeholder="<?php echo lang(array("es"=>"Escriba aqui para cambiar la contrase&ntilde;a","en"=>"Enter here your new password")); ?>"/>
              </div>
              <div class="form-group">
                <label class="control-label"><?php echo lang(array("es"=>"Repetir contrase&ntilde;a","en"=>"Repeat password")); ?></label>
                <input type="password" autocomplete="new-password" class="form-control" id="usuarios_password_2" placeholder="<?php echo lang(array("es"=>"Escriba nuevamente la contrase&ntilde;a anterior","en"=>"Repeat your new password")); ?> "/>
              </div>
             </div>
          </div>
        </div> 
      <% } %>       

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="padder">
            <div class="form-group mb0 clearfix">
              <label class="control-label">
                <?php echo lang(array("es"=>"Datos personales","en"=>"Personal information")); ?>
              </label>
              <a class="expand-link fr">
                <?php echo lang(array(
                  "es"=>"+ Ver opciones",
                  "en"=>"+ View options",
                )); ?>
              </a>
              <div class="panel-description">
                <?php echo lang(array(
                  "es"=>"Informaci&oacute;n de contacto, redes sociales y foto de perfil.",
                  "en"=>"Contact information such as telephone, photo, etc.",
                )); ?>                  
              </div>
            </div>
          </div>
        </div>
        <div class="panel-body expand" style="display: block;">
          <div class="padder">

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Teléfono Fijo</label>
                  <div class="">
                    <input placeholder="Ej: 221 1234567" type="text" <%= (!edicion)?"disabled":"" %> name="telefono" class="form-control" id="telefono" value="<%= telefono %>"/>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Celular</label>
                  <div class="">
                    <input type="text" placeholder="Ej: 549 221 1234567" <%= (!edicion)?"disabled":"" %> name="celular" class="form-control" id="celular" value="<%= celular %>"/>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Web</label>
                  <div class="">
                    <input placeholder="Ej: www.google.com" <%= (!edicion)?"disabled":"" %> type="text" name="custom_5" class="form-control" id="custom_5" value="<%= custom_5 %>"/>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Facebook</label>
                  <div class="">
                    <input type="text" placeholder="Ej: www.facebook.com/miperfil" <%= (!edicion)?"disabled":"" %> name="facebook" class="form-control" id="facebook" value="<%= facebook %>"/>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Instagram</label>
                  <div class="">
                    <input type="text" placeholder="Ej: www.instagram.com/miperfil" <%= (!edicion)?"disabled":"" %> name="instagram" class="form-control" id="instagram" value="<%= instagram %>"/>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Linkedin</label>
                  <div class="">
                    <input placeholder="Ej: www.linkedin.com/miperfil" <%= (!edicion)?"disabled":"" %> type="text" name="linkedin" class="form-control" id="linkedin" value="<%= linkedin %>"/>
                  </div>
                </div>
              </div>
            </div>

            <?php
            single_upload(array(
              "name"=>"path",
              "label"=>lang(array("es"=>"Foto de Perfil","en"=>"Photo")),
              "url"=>"/admin/usuarios/function/save_image/",
              "width"=>(isset($empresa->config["usuario_image_width"]) ? $empresa->config["usuario_image_width"] : 256),
              "height"=>(isset($empresa->config["usuario_image_height"]) ? $empresa->config["usuario_image_height"] : 256),
            )); ?>
            <div class="text-muted">Se sugiere el uso de una foto personal de cara o una toma hasta el torso. No uses fotos que no te identifiquen. Recuerda que es la primera impresión que llevará el paciente. <a class="text-info" href="">Ver instructivo de foto de perfil.</a></div>

          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="padder">
            <div class="form-group mb0 clearfix">
              <label class="control-label">
                Datos Profesionales
              </label>
              <a class="expand-link fr">
                <?php echo lang(array(
                  "es"=>"+ Ver opciones",
                  "en"=>"+ View options",
                )); ?>
              </a>
              <div class="panel-description">
                Información relativa a consultas, especialidades, etc.
              </div>
            </div>
          </div>
        </div>
        <div class="panel-body expand" style="display: block;">
          <div class="padder">

            <div class="form-group">
              <label class="control-label">Obras Sociales</label>
              <select id="usuario_obras_sociales" class="w100p"></select>
            </div>

            <div class="form-group">
              <label class="control-label">Formas de Pago</label>
              <select id="usuario_formas_pago" class="w100p"></select>
            </div>

            <div class="form-group">
              <label class="control-label">Tipos de Pacientes</label>
              <select id="usuario_tipos_pacientes" class="w100p"></select>
            </div>

            <div class="form-group">
              <label class="control-label">Tipos de Atencion</label>
              <select id="usuario_tipos_atenciones" class="w100p"></select>
            </div>

            <div class="form-group">
              <label class="control-label">Tipos de Terapia</label>
              <select id="usuario_tipos_terapias" class="w100p"></select>
            </div>

            <div class="form-group">
              <label class="control-label">Sobre Mi</label>
              <div class="">
                <textarea <%= (!edicion)?"disabled":"" %> name="custom_3" class="form-control" id="custom_3"><%= custom_3 %></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label">Formación Académica</label>
              <div class="">
                <textarea <%= (!edicion)?"disabled":"" %> name="custom_4" class="form-control" id="custom_4"><%= custom_4 %></textarea>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="padder">
            <div class="form-group mb0 clearfix">
              <label class="control-label">Direcciones</label>
              <a class="expand-link fr">
                <?php echo lang(array(
                  "es"=>"+ Ver opciones",
                  "en"=>"+ View options",
                )); ?>
              </a>
              <div class="panel-description">
                <?php echo lang(array(
                  "es"=>"Agregue los lugares donde atiende.",
                )); ?>                  
              </div>
            </div>
          </div>
        </div>
        <div class="panel-body expand" style="<%= (direcciones.length>0) ? 'display:block':'' %>">
          <div class="padder">
            <div class="clearfix tar">
              <button class="btn btn-info nueva_direccion">+ Agregar</button>
            </div>
            <div id="usuario_direcciones" class="mt10"></div>
          </div>
        </div>
      </div>      

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="padder">
            <div class="form-group mb0 clearfix">
              <label class="control-label">Galería de Imágenes</label>
              <a class="expand-link fr">
                <?php echo lang(array(
                  "es"=>"+ Ver opciones",
                  "en"=>"+ View options",
                )); ?>
              </a>
            </div>
          </div>
        </div>
        <div class="panel-body expand" style="<%= (images.length > 0)?"display:block":"" %>">
          <div class="padder">
            <?php
            multiple_upload(array(
              "name"=>"images",
              "label"=>lang(array("en"=>"Image Gallery","es"=>"Galería de fotos")),
              "url"=>"usuarios/function/save_image/",
              "url_file"=>"usuarios/function/save_file/",
              "width"=>(isset($empresa->config["usuario_galeria_image_width"]) ? $empresa->config["usuario_galeria_image_width"] : 800),
              "height"=>(isset($empresa->config["usuario_galeria_image_height"]) ? $empresa->config["usuario_galeria_image_height"] : 600),
              "quality"=>(isset($empresa->config["usuario_galeria_image_quality"]) ? $empresa->config["usuario_galeria_image_quality"] : 0.8),
            )); ?>

          </div>
        </div>
      </div>

    </div>
  </div>  

  <% if (edicion || cambiar_password) { %>
    <div class="line b-b m-b-lg"></div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1 tar">
        <button class="btn btn-success guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
      </div>
    </div>
  <% } %>

</div>