<script type="text/template" id="configuracion_menu_edit_template">
<div class="centrado rform">
  <div class="header-lg">
    <h1>Configuración</h1>
  </div>
  <div class="row">
    <div class="col-md-3">
      <ul class="submenu">
        <li>
          <a class="<%= (id_modulo == "datos")?"active":"" %>" href="app/#configuracion/datos">
            <span class="material-icons">arrow_forward_ios</span>
            Datos de la inmobiliaria
          </a>
        </li>
        <% if (ID_PLAN > 1) { %>
          <li>
            <a class="<%= (id_modulo == "integraciones")?"active":"" %>" href="app/#configuracion/integraciones">
              <span class="material-icons">arrow_forward_ios</span>
              Portales
            </a>
          </li>
        <% } %>
        <li>
          <a class="<%= (id_modulo == "api")?"active":"" %>" href="app/#configuracion/api">
            <span class="material-icons">arrow_forward_ios</span>
            API para desarrolladores
          </a>
        </li>
        <li>
          <a class="<%= (id_modulo == "notificaciones")?"active":"" %>" href="app/#configuracion/notificaciones">
            <span class="material-icons">arrow_forward_ios</span>
            Notificaciones
          </a>
        </li>
        <li>
          <a class="<%= (id_modulo == "usuarios" || id_modulo == "perfiles" || id_modulo == "usuarios-perfiles")?"active":"" %>" href="app/#configuracion/usuarios-perfiles">
            <span class="material-icons">arrow_forward_ios</span>
            Usuarios y perfiles
          </a>
        </li>
        <li>
          <a class="<%= (id_modulo == "emails_templates")?"active":"" %>" href="app/#configuracion/emails_templates">
            <span class="material-icons">arrow_forward_ios</span>
           Plantillas de email
          </a>
        </li>
        <li>
          <a class="<%= (id_modulo == "wpp_templates")?"active":"" %>" href="app/#configuracion/wpp_templates">
            <span class="material-icons">arrow_forward_ios</span>
           Plantillas de Whatsapp
          </a>
        </li>
      </ul>
    </div>
    <div class="col-md-9">
      <div id="configuracion_content"></div>
    </div>
  </div>
</div>
</script>

<script type="text/template" id="configuracion_integraciones">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            MercadoLibre
          </label>
          <div class="panel-description">
            Sincronice las propiedades con MercadoLibre
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">
        <% if (isEmpty(ML_ACCESS_TOKEN)) { %>
          <a class="btn btn-default" href="https://app.inmovar.com/connect_meli.php?id_empresa=<%= ID_EMPRESA %>" target="_blank">Habilitar la sincronizacion</a>
        <% } else { %>

          <div class="form-group">
            <label class="control-label">Descripcion de su empresa que se compartira con sus propiedades</label>
            <textarea name="ml_texto_empresa" class="form-control h200"><%= ml_texto_empresa %></textarea>
          </div>

          <?php
          $label = lang(array(
            "es"=>"Im&aacute;genes adicionales",
            "en"=>"Photos",
          )); ?>
          <?php 
          multiple_upload(array(
            "name"=>"images_meli",
            "label"=>$label,
            "url"=>"articulos/function/save_image/",
            "width"=>(isset($empresa->config["producto_galeria_image_width"]) ? $empresa->config["producto_galeria_image_width"] : 800),
            "height"=>(isset($empresa->config["producto_galeria_image_height"]) ? $empresa->config["producto_galeria_image_height"] : 600),
            "resizable"=>(isset($empresa->config["producto_galeria_image_resizable"]) ? $empresa->config["producto_galeria_image_resizable"] : 0),
            "upload_multiple"=>true,
          )); ?>

          <div class="clearfix">
            <a class="btn btn-default borrar_sincro_meli">Dejar de sincronizar</a>
            <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
          </div>

        <% } %>
      </div>
    </div>
  </div>

  <?php /*
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            OLX
          </label>
          <div class="panel-description">
            Sincronice las propiedades con OLX
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="clearfix">
        <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
      </div>            
    </div>
  </div>*/ ?>

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Argenprop
          </label>
          <div class="panel-description">
            Sincronice las propiedades con Argenprop
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">
        <div class="form-group">
          <label class="control-label">Usuario</label>
          <input type="text" class="form-control" name="argenprop_usuario" value="<%= argenprop_usuario %>" />
        </div>
        <div class="form-group">
          <label class="control-label">Contraseña</label>
          <input type="text" class="form-control" name="argenprop_password" value="<%= argenprop_password %>" />
        </div>
        <div class="form-group">
          <label class="control-label">ID Vendedor</label>
          <input type="text" class="form-control" name="argenprop_id_vendedor" value="<%= argenprop_id_vendedor %>" />
        </div>

        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>

      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Tokko Brokers
          </label>
          <div class="panel-description">
            Sincronice las propiedades con Tokko Brokers
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">
        <div class="form-group">
          <label class="control-label">API Key</label>
          <input type="text" class="form-control" name="tokko_apikey" value="<%= tokko_apikey %>" />
        </div>
        <div class="form-group">
          <div class="checkbox">
            <label class="i-checks">
              <input type="checkbox" id="web_seo_tokko_enviar_consultas" name="tokko_enviar_consultas" <%= (tokko_enviar_consultas == 1) ? 'checked' : '' %>><i></i> 
              Enviar consultas a Tokko Brokers.
            </label>
          </div>                    
        </div>                  
        <div class="form-group">
          <div class="checkbox">
            <label class="i-checks">
              <input type="checkbox" id="web_seo_tokko_importacion" name="tokko_importacion" <%= (tokko_importacion == 1) ? 'checked' : '' %>><i></i> 
              Importar automáticamente propiedades de Tokko Brokers.
            </label>
          </div>                    
        </div>                  

        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>

      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Inmobusqueda
          </label>
          <div class="panel-description">
            Sincronice las propiedades con Inmobusqueda
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">

        <div class="form-group">
          <label class="control-label">URL de inmobiliaria en Inmobusqueda</label>
          <div class="input-group">            
            <input type="text" class="form-control" name="url_web_inmobusqueda" value="<%= url_web_inmobusqueda %>" />
            <span class="input-group-btn">
              <button class="sincronizar_inmobusqueda btn btn-default">Sincronizar</button>
            </span>
          </div>
        </div>

        <div class="form-group">
          <div class="checkbox">
            <label class="i-checks">
              <input type="checkbox" id="web_seo_inmobusqueda_diario" name="inmobusqueda_diario" <%= (inmobusqueda_diario == 1) ? 'checked' : '' %>><i></i> 
              Importar todas las noches las propiedades desde Inmobusqueda.
            </label>
          </div>                    
        </div>                          

        <div class="form-group">
          <label class="control-label">URL de exportación de propiedades a Inmobusqueda</label>
          <input type="text" class="form-control" name="url_inmobusqueda" value="<%= url_inmobusqueda %>" />
        </div>

        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>

      </div>
    </div>
  </div>
</script>

<script type="text/template" id="configuracion_api">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            API Key
          </label>
          <div class="panel-description">
            Datos de conexión para sincronizar propiedades con Inmovar.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand" style="display:block">
      <div class="padder">
        <div class="form-group">
          <label class="control-label">Clave privada</label>
          <input type="text" disabled class="form-control" value="<%= hex_md5(ID_EMPRESA) %>" />
        </div>
      </div>
    </div>
  </div>  
</script>

<script type="text/template" id="configuracion_datos">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Datos de la inmobiliaria
          </label>
          <div class="panel-description">
            Actualice los datos de su inmobiliaria.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand" style="display:block">
      <div class="padder">

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Nro. de Matrícula</label>
              <input type="text" name="codigo" class="form-control" id="empresas_codigo" value="<%= codigo %>"/>
            </div>
          </div>          
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Raz&oacute;n Social</label>
              <input type="text" name="razon_social" class="form-control" id="empresas_razon_social" value="<%= razon_social %>"/>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label">Email</label>
          <input type="text" name="email" class="form-control" id="empresas_email" value="<%= email %>"/>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Tipo de contribuyente</label>
              <select class="form-control" name="tipo_contribuyente" id="empresas_tipo_contribuyente">
                <option value="2" <%= (id_tipo_contribuyente == 2) ? "selected": "" %>>Monotributo</option>
                <option value="1" <%= (id_tipo_contribuyente == 1) ? "selected": "" %>>Responsable Inscripto</option>
                <option value="3" <%= (id_tipo_contribuyente == 3) ? "selected": "" %>>Exento</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">CUIT</label>
              <input type="text" name="cuit" class="form-control" id="empresas_cuit" value="<%= cuit %>"/>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label"><?php echo lang(array("es"=>"Dirección","en"=>"Address")) ?></label>
          <input type="text" name="direccion_web" class="form-control" value="<%= direccion_web %>"/>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"><?php echo lang(array("es"=>"Ciudad","en"=>"City")) ?></label>
              <input type="text" name="ciudad" class="form-control" value="<%= ciudad %>"/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"><?php echo lang(array("es"=>"Código Postal","en"=>"Postal Code")) ?></label>
              <input type="text" name="codigo_postal" class="form-control" value="<%= codigo_postal %>"/>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"><?php echo lang(array("es"=>"Teléfono","en"=>"Phone ")) ?></label>
              <input type="text" name="telefono_web" class="form-control" value="<%= telefono_web %>"/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"><?php echo lang(array("es"=>"Teléfono 2","en"=>"Phone two")) ?></label>
              <input type="text" name="telefono_2" class="form-control" value="<%= telefono_2 %>"/>
            </div>
          </div>
        </div>        

        <div class="form-group">
          <?php
          single_upload(array(
           "name"=>"logo",
           "label"=>"Encabezado de informes",
           "url"=>"empresas/function/save_image/",
           "resizable"=>1,
           "description"=>"Utilizado en los comprobantes, remitos, presupuestos, etc. Tama&ntilde;o recomendado: 450 x 280 p&iacute;xeles"
           )); ?>
        </div>
        <div class="form-group">
          <?php
          single_upload(array(
           "name"=>"path",
           "label"=>"Foto de perfil del sistema",
           "url"=>"empresas/function/save_image/",
           "width"=>400,
           "height"=>400,
           "description"=>"Utilizado como imagen de perfil del sistema. Tama&ntilde;o recomendado: 200 x 200 p&iacute;xeles"
           )); ?>
        </div>        

        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>        

      </div>
    </div>
  </div>  
</script>

<script type="text/template" id="configuracion_notificaciones">

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Consultas de la web
          </label>
          <div class="panel-description">
            Configure el comportamiento al recibir consultas a través de la web.
          </div>
        </div>
      </div>
    </div>          
    <div class="panel-body expand" style="display:block">
      <div class="padder">

        <div class="form-group">
          <div class="checkbox">
            <label class="i-checks">
              <input type="checkbox" id="crm_notificar_inmobiliaria" name="crm_notificar_inmobiliaria" <%= (crm_notificar_inmobiliaria == 1) ? 'checked' : '' %>><i></i>
              Enviar notificación por email a la cuenta de la inmobiliaria (<b><%= EMAIL %></b>)
            </label>
          </div>
        </div>

        <div class="form-group">
          <div class="checkbox">
            <label class="i-checks">
              <input type="checkbox" id="crm_notificar_usuario_propiedad" name="crm_notificar_usuario_propiedad" <%= (crm_notificar_usuario_propiedad == 1) ? 'checked' : '' %>><i></i>
              Enviar notificación por email al usuario asignado de la propiedad.
            </label>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label">En caso de que la propiedad no tenga usuario asignado:</label>
          <select id="crm_enviar_emails_usuarios" name="crm_enviar_emails_usuarios" class="form-control">
            <option <%= (crm_enviar_emails_usuarios == 0)?"selected":"" %> value="0">Notificar al email de la inmobiliaria (<%= EMAIL %>)</option>
            <option <%= (crm_enviar_emails_usuarios == 1)?"selected":"" %> value="1">Elegir aleatoriamente entre todos los usuarios que reciben notificaciones</option>
          </select>
        </div>  

        <div class="form-group">
          <label class="control-label">Enviar como copia oculta a las siguientes direcciones de emails (separadas por coma)</label>
          <input type="text" class="form-control" value="<%= bcc_email %>" name="bcc_email"/>
        </div>

        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>
      </div>
    </div>
  </div>  


  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Otras notificaciones
          </label>
          <div class="panel-description">
            Determine cuando recibir notificaciones del sistema.
          </div>
        </div>
      </div>
    </div>          
    <div class="panel-body expand" style="display:block">
      <div class="padder">

        <div class="form-group">
          <div class="checkbox">
            <label class="i-checks">
              <input type="checkbox" id="crm_notificar_tareas" name="crm_notificar_tareas" <%= (crm_notificar_tareas == 1) ? 'checked' : '' %>><i></i>
              Notificar por email cuando se asigna una nueva tarea.
            </label>
          </div>                    
        </div>

        <div class="form-group">
          <div class="checkbox">
            <label class="i-checks">
              <input type="checkbox" id="crm_notificar_asignaciones_usuarios" name="crm_notificar_asignaciones_usuarios" <%= (crm_notificar_asignaciones_usuarios == 1) ? 'checked' : '' %>><i></i>
              Notificar por email cuando se asigna un usuario a un contacto.
            </label>
          </div>
        </div>

        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>
      </div>
    </div>
  </div>  
</script>


<script type="text/template" id="configuracion_usuarios">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Usuarios
          </label>
          <div class="panel-description">
            Crear, modificar o eliminar cuentas de usuario.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand" style="display:block">
      <div id="usuarios_container">
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Perfiles
          </label>
          <div class="panel-description">
            Administrar las acciones que puede realizar cada perfil de usuario.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div id="perfiles_container">
      </div>
    </div>
  </div>
</script>


<script type="text/template" id="configuracion_emails">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Plantillas de Emails
          </label>
          <div class="panel-description">
            Crear, modificar o eliminar plantillas de emails.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand" style="display:block">
      <div id="emails_container">
      </div>
    </div>
  </div>
</script>

<script type="text/template" id="configuracion_wpp">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Plantillas de Whatsapp
          </label>
          <div class="panel-description">
            Crear, modificar o eliminar plantillas de Whatsapp.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand" style="display:block">
      <div id="wpps_container">
      </div>
    </div>
  </div>
</script>