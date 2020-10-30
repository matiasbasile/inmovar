<script type="text/template" id="web_menu_edit_template">
<% if (ID_PLAN == 1) { %>
  <div class="centrado rform mt30 mb30">
    <div class="panel panel-default tac">
      <div class="panel-body">
        <h1>Sitio Web</h1>
        <p>Inmovar</p>
        <div>
          <img style="max-width:450px;" class="w100p mb30" src="resources/images/sitio-web.png" />
        </div>
        <p style="max-width:450px;" class="mb30 mla mra fs16">Aumente las ventas mejorando el seguimiento de clientes con <span class="c-main">Inmovar CRM</span></p>
        <a class="btn btn-lg btn-info mb30" href="app/#precios">
          <span>&nbsp;&nbsp;Activar Sitio Web&nbsp;&nbsp;</span>
        </a>
      </div>    
    </div>
  </div>
<% } else { %>
  <div class="wrapper-md">
    <div class="centrado rform">
      <div class="header-lg pt0">
        <div class="row">
          <div class="col-md-6">
            <h1 style="font-size:32px !important">Sitio Web</h1>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <ul class="submenu">
            <li>
              <a class="<%= (id_modulo == "diseno")?"active":"" %>" href="app/#web/diseno">
                <span class="material-icons">arrow_forward_ios</span>
                Diseño
              </a>
            </li>
            <li>
              <a class="<%= (id_modulo == "contenido")?"active":"" %>" href="app/#web/contenido">
                <span class="material-icons">arrow_forward_ios</span>
                Contenido
              </a>
            </li>
            <li>
              <a class="<%= (id_modulo == "contacto")?"active":"" %>" href="app/#web/contacto">
                <span class="material-icons">arrow_forward_ios</span>
                Redes y Contactos
              </a>
            </li>
            <li>
              <a class="<%= (id_modulo == "dominio")?"active":"" %>" href="app/#web/dominio">
                <span class="material-icons">arrow_forward_ios</span>
                Dominio
              </a>
            </li>
            <li>
              <a class="<%= (id_modulo == "seguimiento")?"active":"" %>" href="app/#web/seguimiento">
                <span class="material-icons">arrow_forward_ios</span>
                Códigos de Seguimiento
              </a>
            </li>
            <li>
              <a class="<%= (id_modulo == "chat")?"active":"" %>" href="app/#web/chat">
                <span class="material-icons">arrow_forward_ios</span>
                Chat Whatsapp
              </a>
            </li>
            <li>
              <a class="<%= (id_modulo == "avanzada")?"active":"" %>" href="app/#web/avanzada">
                <span class="material-icons">arrow_forward_ios</span>
                Avanzada
              </a>
            </li>
          </ul>
        </div>
        <div class="col-md-9">
          <div id="configuracion_content"></div>
        </div>
      </div>
    </div>
  </div>
<% } %>
</script>

<script type="text/template" id="web_diseno_template">
  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Elegir diseño para la web
          </label>
          <div class="panel-description">
            Seleccione la plantilla preferida para su web.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="row">
        <% for(var i=0;i<templates.length;i++) { %>
          <% var opcion = templates[i]; %>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="template-item <%= (ID_WEB_TEMPLATE == opcion.id) ? "selected":"" %>">
              <img style="height:280px" src="<%= opcion.thumbnail %>"/>
              <div class="template-item-footer">
                <span class="bold white"><%= opcion.nombre %></span>
              </div>
              <div class="template-item-over">
                <div class="template-item-over-nombre"><%= opcion.nombre %></div>
                <% if (!isEmpty(opcion.link_demo)) { %>
                  <div class="btn-item">
                    <a href="<%= opcion.link_demo %>" target="_blank" class="btn">Ver demo</a>
                  </div>
                <% } %>
                <% if (ID_WEB_TEMPLATE == opcion.id) { %>
                  <div class="btn-item">
                    <a href="app/#editar_template" class="btn">Editar plantilla</a>
                  </div>
                <% } else { %>
                  <div class="btn-item">
                    <button data-id="<%= opcion.id %>" class="btn elegir_disenio">Elegir dise&ntilde;o</button>
                  </div>
                <% } %>
              </div>    
            </div>
          </div>
        <% } %>  
      </div>
    </div>
  </div>

  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Logo
          </label>
          <div class="panel-description">
            Subí el logo de tu inmobiliaria.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="form-group oh">
        <div class="col-xs-12">
          <?php
          single_upload(array(
            "name"=>"logo_1",
            "label"=>"",
            "label_button"=>lang(array("es"=>"Subir logo","en"=>"Upload logo")),
            "class_button"=>"btn-info",
            "url"=>"web_configuracion/function/save_image/",
            "resizable"=>1,
            "crop_type"=>(isset($empresa->config["logo_1_crop_type"]) ? $empresa->config["logo_1_crop_type"] : 0),
          )); ?>
        </div>
      </div>
      <div class="clearfix">
        <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
      </div>
    </div>
  </div>

  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Carrusel principal
          </label>
          <div class="panel-description">
            Agrega imágenes al carrusel principal de tu web.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div id="web_configuracion_sliders" class="ordenable"></div>
    </div>
  </div>

</script>

<script type="text/template" id="web_contenido_template">

  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Páginas
          </label>
          <div class="panel-description">
            Crea y modifica diferentes páginas de contenido.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div id="entradas_container"></div>
    </div>
  </div>

  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Categorias
          </label>
          <div class="panel-description">
            Puede agrupar las páginas en diferentes categorias como blog, noticias, etc.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div id="categorias_entradas_container"></div>
    </div>
  </div>
</script>


<script type="text/template" id="web_redes_template">
  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Redes Sociales
          </label>
          <div class="panel-description">
            Ingresa todas tus redes sociales.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">
        <div class="form-group">
          <div class="input-group w100p">
            <span class="input-group-addon w40"><i class="fa fa-facebook"></i></span>
            <input type="text" name="facebook" placeholder="Facebook Link" class="form-control" value="<%= facebook %>"/>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group w100p">
            <span class="input-group-addon w40"><i class="fa fa-twitter"></i></span>
            <input type="text" name="twitter" placeholder="Twitter Link" class="form-control" value="<%= twitter %>"/>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group w100p">
            <span class="input-group-addon w40"><i class="fa fa-youtube"></i></span>
            <input type="text" name="youtube" placeholder="Youtube Link" class="form-control" value="<%= youtube %>"/>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group w100p">
            <span class="input-group-addon w40"><i class="fa fa-instagram"></i></span>
            <input type="text" name="instagram" placeholder="Instagram Link" class="form-control" value="<%= instagram %>"/>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group w100p">
            <span class="input-group-addon w40"><i class="fa fa-linkedin"></i></span>
            <input type="text" name="linkedin" placeholder="Linkedin Link" class="form-control" value="<%= linkedin %>"/>
          </div>
        </div>
        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>
      </div>
    </div>
  </div>

  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Información de Contacto
          </label>
          <div class="panel-description">
            Edita tu dirección, teléfonos de contacto, etc.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">
        <div class="form-group">
          <label class="control-label"><?php echo lang(array("es"=>"Email","en"=>"Email address")) ?></label>
          <input type="text" name="email" class="form-control" value="<%= email %>"/>
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
          <label class="control-label"><?php echo lang(array("es"=>"Horarios","en"=>"Schedule")) ?></label>
          <textarea name="horario" class="form-control"><%= horario %></textarea>
        </div>
        <div class="form-group">
          <label class="control-label"><?php echo lang(array("es"=>"Asuntos de contacto","en"=>"Contact matter")) ?></label>
          <select multiple id="web_configuracion_asuntos" style="width: 100%">
            <% if (!isEmpty(asuntos_contacto)) { %>
              <% var carac = asuntos_contacto.split(";;;") %>
              <% for (var i=0; i< carac.length; i++) { %>
                <% var o = carac[i] %>
                <option selected><%= o %></option>
              <% } %>
            <% } %>
          </select>
        </div>
        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>
      </div>
    </div>
  </div>  
</script>

<script type="text/template" id="web_avanzada_template">
  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            SEO
          </label>
          <div class="panel-description">
            Herramientas para mejorar el posicionamiento de su sitio.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">
        <div class="form-group">
          <label class="control-label"><?php echo lang(array("es"=>"Titulo","en"=>"Title")); ?></label>
          <textarea placeholder="<?php echo lang(array("es"=>"Titulo del navegador cuando se visualice la pagina.","en"=>"Web page title")); ?>" name="seo_title" class="form-control"><%= seo_title %></textarea>
        </div>
        <div class="form-group">
          <label class="control-label"><?php echo lang(array("es"=>"Descripci&oacute;n","en"=>"Description")); ?></label>
          <textarea placeholder="<?php echo lang(array("es"=>"Escribe una breve descripcion de la pagina.","en"=>"Short description about your company")); ?>" name="seo_description" class="form-control"><%= seo_description %></textarea>
        </div>
        <div class="form-group">
          <label class="control-label"><?php echo lang(array("es"=>"Palabras Clave","en"=>"Keywords")); ?></label>
          <textarea placeholder="<?php echo lang(array("es"=>"Escribe las palabras clave que describan tu actividad.","en"=>"Comma-separated words that describe your bussiness")); ?>" name="seo_keywords" class="form-control"><%= seo_keywords %></textarea>
        </div>
        <div class="form-group">
          <label class="control-label"><?php echo lang(array("es"=>"Personalizar robots.txt","en"=>"Customize robots.txt")); ?></label>
          <textarea placeholder="<?php echo lang(array("es"=>"Ingresa las lineas de tu archivo robots.txt.","en"=>"Write here the lines of your robots.txt file")); ?>" name="seo_robots" class="form-control"><%= seo_robots %></textarea>
        </div>
        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>
      </div>
    </div>
  </div>

  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Favicon
          </label>
          <div class="panel-description">
            Subí el favicon de tu web.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">
        <div class="form-group">
          <?php single_file_upload(array(
            "name"=>"favicon",
            "label"=>"",
            "url"=>"web_configuracion/function/save_file/",
          )); ?>
        </div>
        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>
      </div>
    </div>
  </div>  

  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Editor CSS y Javascript
          </label>
          <div class="panel-description">
            Editor avanzado de CSS y Javascript.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">
        <div class="tab-container">
          <ul class="nav nav-tabs" role="tablist">
            <li class="active">
              <a href="#tab1" role="tab" data-toggle="tab"><i class="fa fa-info"></i>CSS</a>
            </li>
            <li>
              <a href="#tab2" role="tab" data-toggle="tab"><i class="fa fa-info"></i>Javascript</a>
            </li>
          </ul>
          <div class="tab-content">
            <div id="tab1" class="tab-pane active panel-body">
              <textarea class="form-control" style="height:400px" id="web_editor_texto_css" name="texto_css"><%= texto_css %></textarea>
            </div>
            <div id="tab2" class="tab-pane panel-body">
              <textarea class="form-control" style="height:400px" id="web_editor_texto_js" name="texto_js"><%= texto_js %></textarea>
            </div>
          </div>
        </div>
        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>
      </div>
    </div>
  </div>  


</script>

<script type="text/template" id="web_dominio_template">
  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Dominio
          </label>
          <div class="panel-description">
            Configure un dominio para su web.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand" style="display:block">
      <div class="padder">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><span class="material-icons fs17">language</span></span>
            <input id="web_dominio" type="text" placeholder="Ej: www.misitio.com" class="form-control" value="<%= DOMINIO.replace("/","") %>"/>
          </div>
        </div>

        <p class="mt20">Para delegar su web a nuestros servidores, utilice los siguientes servidores DNS: </p>
        <div class="show-code mt10">
          dane.ns.cloudflare.com<br/>
          leah.ns.cloudflare.com
        </div>

        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/template" id="web_seguimiento_template">
  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Píxel de conversión de Facebook
          </label>
          <div class="panel-description">
            Copia el píxel de conversión de Facebook.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">
        <div class="form-group">
          <label>Píxel de conversión de Facebook</label>
          <input type="text" name="pixel_fb" class="form-control" value="<%= pixel_fb %>"/>
        </div>
        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>
      </div>
    </div>
  </div>

  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Códigos de Seguimiento de Google
          </label>
          <div class="panel-description">
            Copia los códigos de Google Analytics, Tag Manager, etc.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand">
      <div class="padder">
        <div class="form-group">
          <label class="control-label">Google Analytics</label>
          <textarea placeholder="<?php echo lang(array("es"=>"Pegue aqu&iacute; el c&oacute;digo provisto por Google Analytics.","en"=>"Insert here the Google Analytics code.")); ?>" name="analytics" class="form-control"><%= analytics %></textarea>
        </div>
        <div class="form-group">
          <label class="control-label"><?php echo lang(array("es"=>"Google Tag Manager Head","en"=>"Google Tag Manager Head")); ?></label>
          <textarea placeholder="<?php echo lang(array("es"=>"Pegue aqu&iacute; el c&oacute;digo provisto por Google Tag Manager que iria en el <head>.","en"=>"Insert here the Head Google Tag Manager code.")); ?>" name="gtm_head" class="form-control"><%= gtm_head %></textarea>
        </div>
        <div class="form-group">
          <label class="control-label"><?php echo lang(array("es"=>"Google Tag Manager Body","en"=>"Google Tag Manager Body")); ?></label>
          <textarea placeholder="<?php echo lang(array("es"=>"Pegue aqu&iacute; el c&oacute;digo provisto por Google Tag Manager que iria en el <body>.","en"=>"Insert here the Body Google Tag Manager code.")); ?>" name="gtm_body" class="form-control"><%= gtm_body %></textarea>
        </div>
        <div class="form-group">
          <label class="control-label"><?php echo lang(array("es"=>"Verificacion de sitio de Google","en"=>"Google Site Verification")); ?></label>
          <textarea placeholder="<?php echo lang(array("es"=>"Pegue aqu&iacute; el c&oacute;digo provisto por Google.","en"=>"Insert here the Google Verification Site code.")); ?>" name="google_site_verification" class="form-control"><%= google_site_verification %></textarea>
        </div>
        <div class="form-group">
          <label class="control-label"><?php echo lang(array("es"=>"Remarketing de Google","en"=>"Google Remarketing Code")); ?></label>
          <textarea placeholder="<?php echo lang(array("es"=>"Pegue aqu&iacute; el c&oacute;digo de Remarketing provisto por Google.","en"=>"Insert here the Google Remarketing code.")); ?>" name="remarketing" class="form-control"><%= remarketing %></textarea>
        </div>
        <div class="form-group">
          <label class="control-label">Google Adsense</label>
          <textarea placeholder="<?php echo lang(array("es"=>"Pegue aqu&iacute; el c&oacute;digo provisto por Google Adsense.","en"=>"Insert here the Google Adwords code.")); ?>" name="adsense" class="form-control"><%= adsense %></textarea>
        </div>
        <div class="form-group">
          <label class="control-label">View ID</label>
          <textarea placeholder="<?php echo lang(array("es"=>"C&oacute;digo de View ID para enlazar estad&iacute;sticas de Google Analytics.","en"=>"Insert here the View ID Code to bind web statics.")); ?>" name="view_id" class="form-control"><%= view_id %></textarea>
        </div>
        <div class="clearfix">
          <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/template" id="web_chat_template">
  <div class="panel panel-default db cp">
    <div class="panel-body">
      <div class="padder">
        <div class="form-group mb0 clearfix expand-link cp">
          <label class="control-label cp">
            Clienapp
          </label>
          <div class="panel-description">
            Habilitar y configurar Clienapp en tu web.
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body expand" style="display:<%= (habilitar_clienapp == 1)?"block":"" %>">
      <div class="padder">
        <?php include("configuracion_clienapp.php"); ?>
      </div>
      <div class="clearfix">
        <button class="btn fr btn-info guardar"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
      </div>
    </div>
  </div>

</script>






<script type="text/template" id="web_configuracion_edit_panel_template">
<div id="web_configuracion_template_custom" style="display: none">
<?php
if (!empty($empresa->path_template)) { 
  // Reemplazamos el PHP con lo que serian las variables
  $color_principal = "{{color_principal}}";
  $color_secundario = "{{color_secundario}}";
  $color_terciario = "{{color_terciario}}";
  $color_4 = "{{color_4}}";
  $color_5 = "{{color_5}}";
  $color_6 = "{{color_6}}";
  @include_once("../templates/".$empresa->path_template."/css/custom.php");
}
?>
</div>
<div style="width: 256px; float: left; height: 100%; overflow: auto; ">
  <div class="header-accordion bg-light lter">
    <?php echo lang(array(
      "es"=>"Logo de tu Web",
      "en"=>"Logo of your web",
    )); ?>
  </div>
  <div class="info-accordion">
    <p class="subtitle-accordion">
    <?php echo lang(array(
      "es"=>"Elegí el logo que tendrá tu página",
      "en"=>"Select a logo for your website",
    )); ?>
    </p>
    <ul class="list-accordion">
      <li><span>
      <?php echo lang(array(
        "es"=>"Puedes subir una imagen o adquirir un logo de nuestro catálogo.",
        "en"=>"You can upload a new logo or select a created one of our catalogue.",
      )); ?>
      </span></li>
      <li><span>
      <?php echo lang(array(
        "es"=>"Si no eleg&iacute;s ning&uacute;n logo, se usar&aacute; el nombre de tu empresa.",
        "en"=>"If you don't have any logo, your name will appear on the website.",
      )); ?>
      </span></li>
    </ul>
    <div class="form-group oh">
      <div class="col-xs-12">
        <?php
        single_upload(array(
        "name"=>"logo_1",
        "label"=>"",
        "label_button"=>lang(array("es"=>"Subir logo","en"=>"Upload logo")),
        "class_button"=>"btn-info",
        "url"=>"empresas/function/save_image/",
        "resizable"=>1,
        //"width"=>(isset($empresa->config["logo_1_width"]) ? $empresa->config["logo_1_width"] : 400),
        //"height"=>(isset($empresa->config["logo_1_height"]) ? $empresa->config["logo_1_height"] : 400),
        "crop_type"=>(isset($empresa->config["logo_1_crop_type"]) ? $empresa->config["logo_1_crop_type"] : 0),
        )); 
        ?>
      </div>
    </div>
    <div class="form-group oh cb mt15">
      <button class="btn btn-info guardar btn-block">
      <?php echo lang(array(
        "es"=>"Guardar",
        "en"=>"Save changes",
      )); ?>
      </button>
    </div>          
  </div>
  
  <div class="header-accordion bg-light lter">
      <?php echo lang(array(
        "es"=>"Colores de tu marca",
        "en"=>"Your website colors",
      )); ?>
  </div>
  <div class="info-accordion">
    <p class="subtitle-accordion mt15">
      Cambia los colores de la web
    </p>
    <div class="form-group oh cb">
      <div class="input-group color_principal colorpicker-component">
        <span class="input-group-addon"><i></i></span>
        <input type="text" class="form-control" value="<%= color_principal %>" />
      </div>
    </div>
    <div class="form-group oh cb">
      <div class="input-group color_secundario colorpicker-component">
        <span class="input-group-addon"><i></i></span>
        <input type="text" class="form-control" value="<%= color_secundario %>" />              
      </div>
    </div>
    <div class="form-group oh cb">
      <div class="input-group color_terciario colorpicker-component">
        <span class="input-group-addon"><i></i></span>
        <input type="text" class="form-control" value="<%= color_terciario %>" />              
      </div>
    </div>
    <div class="form-group oh cb mt15">
      <button class="btn btn-info guardar btn-block"><?php echo lang(array(
        "es"=>"Guardar",
        "en"=>"Save changes"
      )); ?></button>
    </div>
  </div>       

  <?php 
  // ===========================================================================================
  // TODO: NUEVA FORMA DE ORGANIZAR LOS COMPONENTES
  // Si el template configurado tiene registros en la tabla web_componentes
  // entonces se configura de esta forma
  if ($empresa->id_proyecto == 19) { ?>
    <div class="header-accordion bg-light lter">
      Componentes
    </div>
    <div class="info-accordion">
      <p class="subtitle-accordion">
        <?php echo lang(array(
          "es"=>"Muestre, oculte y ordene las distintas secciones de su web.",
          "en"=>"Show, hide and order the different sections of your website."
        )); ?>
      </p>
      <div id="web_configuracion_componentes" class="ordenable"></div>
    </div>
  <?php } else { 

  // ===========================================================================================
  ?>  
    
    <?php if (
      (isset($empresa->config["comp_ultimos"])) ||
      (isset($empresa->config["comp_destacados"])) ||
      (isset($empresa->config["comp_banners"])) ||
      (isset($empresa->config["comp_marcas"])) ||
      (isset($empresa->config["comp_slider_2"])) ||
      (isset($empresa->config["comp_mapa"])) ||
      (isset($empresa->config["comp_galeria"])) ||
      (isset($empresa->config["comp_cronograma"])) ||
      (isset($empresa->config["comp_logos_pagos"])) ||
      (isset($empresa->config["comp_newsletter"])) ||
      (isset($empresa->config["comp_categorias"])) ||
      (isset($empresa->config["comp_footer_grande"]))
    ) { ?>
      <div class="header-accordion bg-light lter">
        Componentes
      </div>
      <div class="info-accordion">
        <p class="subtitle-accordion">Configuraci&oacute;n de p&aacute;gina de inicio</p>

        <% if (TEMPLATE == "Shopvar 1") { %>
          <ul class="list-accordion">
            <li><span>Diseño de encabezado.</span></li>
          </ul>
          <div class="form-group oh mb10">
            <select name="template_header" id="web_configuracion_template_header" class="form-control">
              <option <%= (template_header == "header")?"selected":"" %> value="header">Header 1</option>
              <option <%= (template_header == "header2")?"selected":"" %> value="header2">Header 2</option>
              <option <%= (template_header == "header3")?"selected":"" %> value="header3">Header 3</option>
              <option <%= (template_header == "header4")?"selected":"" %> value="header4">Header 4</option>
            </select>
          </div>
        <% } %>

        <ul class="list-accordion">
          <li><span>Activa o desactiva los componentes que quieras mostrar u ocultar en el home.</span></li>
        </ul>
        <?php if (isset($empresa->config["comp_slider_2"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_slider_2==1)?"checked":"" %> id="web_configuracion_slider_2" name="comp_slider_2" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_slider_2">
              Carrusel secundario
            </label>
          </div>
        <?php } ?>
        <?php if (isset($empresa->config["comp_cronograma"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_cronograma==1)?"checked":"" %> id="web_configuracion_cronograma" name="comp_cronograma" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_cronograma">
              <?php echo (isset($empresa->config["comp_cronograma_label"]) ? $empresa->config["comp_cronograma_label"] : "Cronograma") ?>
            </label>
          </div>
        <?php } ?>
        <?php if (isset($empresa->config["comp_categorias"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_categorias==1)?"checked":"" %> id="web_configuracion_categorias" name="comp_categorias" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_categorias">
              <?php echo (isset($empresa->config["comp_categorias_label"]) ? $empresa->config["comp_categorias_label"] : "Categorias") ?>
            </label>
          </div>
        <?php } ?>
        <?php if (isset($empresa->config["comp_galeria"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_galeria==1)?"checked":"" %> id="web_configuracion_galeria" name="comp_galeria" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_galeria">
              <?php echo (isset($empresa->config["comp_galeria_label"]) ? $empresa->config["comp_galeria_label"] : "Galer&iacute;a de im&aacute;genes") ?>
            </label>
          </div>
        <?php } ?>
        <?php if (isset($empresa->config["comp_ultimos"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_ultimos==1)?"checked":"" %> id="web_configuracion_ultimos_productos" name="comp_ultimos" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_ultimos_productos">
              <% if (ID_PROYECTO == 3) { %>
                &Uacute;ltimas propiedades
              <% } else if (ID_PROYECTO == 2) { %>
                &Uacute;ltimos productos
              <% } else if (ID_PROYECTO == 5) { %>
                &Uacute;ltimas noticias
              <% } else { %>
                &Uacute;ltimos elementos
              <% } %>
            </label>
          </div>
        <?php } ?>
        <?php if (isset($empresa->config["comp_mapa"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_mapa==1)?"checked":"" %> id="web_configuracion_mapa" name="comp_mapa" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_mapa">
              Mapa
            </label>
          </div>
        <?php } ?>
        <?php if (isset($empresa->config["comp_destacados"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_destacados==1)?"checked":"" %> id="web_configuracion_productos_destacados" name="comp_destacados" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_productos_destacados">
              <% if (ID_PROYECTO == 3) { %>
                Propiedades destacadas
              <% } else if (ID_PROYECTO == 2) { %>
                Productos destacados
              <% } else { %>
                Elementos destacados
              <% } %>
            </label>
          </div>
        <?php } ?>
        <?php if (isset($empresa->config["comp_banners"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_banners==1)?"checked":"" %> id="web_configuracion_banners" name="comp_banners" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_banners">
              <% if (ID_PROYECTO == 5) { %>
                Links principales
              <% } else { %>
                <?php echo (isset($empresa->config["comp_banners_label"]) ? $empresa->config["comp_banners_label"] : "Banners publicitarios") ?>
              <% } %>
            </label>
          </div>
        <?php } ?>
        <?php if (isset($empresa->config["comp_marcas"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_marcas==1)?"checked":"" %> id="web_configuracion_marcas" name="comp_marcas" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_marcas">Logos de marcas o socios</label>
          </div>
        <?php } ?>
        <?php if (isset($empresa->config["comp_logos_pagos"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_logos_pagos==1)?"checked":"" %> id="web_configuracion_logos_mercadopago" name="comp_logos_pagos" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_logos_mercadopago">Logos de tarjetas</label>
          </div>
        <?php } ?>
        <?php if (isset($empresa->config["comp_newsletter"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_newsletter==1)?"checked":"" %> id="web_configuracion_newsletter" name="comp_newsletter" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_newsletter">Newsletter</label>
          </div>
        <?php } ?>
        <?php if (isset($empresa->config["comp_footer_grande"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_footer_grande==1)?"checked":"" %> id="web_configuracion_footer_grande" name="comp_footer_grande" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_footer_grande">Footer grande</label>
          </div>
        <?php } ?>

        <?php if (isset($empresa->config["comp_instagram"])) { ?>
          <div class="form-group oh">
            <label class="i-switch fl i-switch-xs bg-info mr10">
              <input type="checkbox" <%= (comp_instagram==1)?"checked":"" %> id="web_configuracion_instagram" name="comp_instagram" class="conf_structure checkbox" value="1">
              <i></i>
            </label>
            <label class="fl fs14 cp" for="web_configuracion_instagram">Instagram</label>
          </div>
          <div id="web_configuracion_instagram_id_cont" style="<%= (comp_instagram==0)?"display:none":"" %>">
            <div class="form-group">
              <input placeholder="Instagram Client ID" class="form-control" type="text" id="web_configuracion_instagram_id" name="instagram_id" value="<%= instagram_id %>"/>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input placeholder="Instagram User ID" class="form-control" type="text" id="web_configuracion_instagram_user_id" name="instagram_user_id" value="<%= instagram_user_id %>"/>
                <span class="input-group-btn">
                  <a tabindex="-1" target="_blank" href="https://codeofaninja.com/tools/find-instagram-user-id" class="btn btn-default btn-cal"><i class="fa fa-external-link"></i></a>
                </span>
              </div>
            </div>
            <div class="form-group">
              <input placeholder="Access Token" class="form-control" type="text" id="web_configuracion_instagram_access_token" name="instagram_access_token" value="<%= instagram_access_token %>"/>
            </div>
            <div class="form-group">
              <input placeholder="Cantidad Feeds" class="form-control" type="text" id="web_configuracion_instagram_limit" name="instagram_limit" value="<%= instagram_limit %>"/>
            </div>
          </div>
        <?php } ?>

        <div class="form-group oh cb mt15">
          <button class="btn btn-info guardar btn-block">Guardar</button>
        </div>      
      </div>
    <?php } ?>
  <?php } ?>

  <div class="header-accordion bg-light lter">
    <?php echo (isset($empresa->config["slider_1_titulo"]) ? $empresa->config["slider_1_titulo"] : lang(array("es"=>"Carrusel principal","en"=>"Main carrousel")) ); ?>        
  </div>
  <div class="info-accordion">
    <p class="subtitle-accordion">
      <?php echo lang(array(
        "es"=>"Eleg&iacute; las im&aacute;genes que pasar&aacute;n al tope de la p&aacute;gina de inicio.",
        "en"=>"Upload images for your main carrousel."
      )); ?>
    </p>
    <div id="web_configuracion_sliders" class="ordenable"></div>
    <div class="form-group oh cb mt15">
      <button class="btn btn-info guardar btn-block">
      <?php echo lang(array(
        "es"=>"Guardar",
        "en"=>"Save changes"
      )); ?>
      </button>
    </div>      
  </div>        

  <% if (ID_PROYECTO == 2 || ID_EMPRESA == 791 || ID_PROYECTO == 10) { %>
    <div class="header-accordion bg-light lter">
      Lista de Productos
    </div>
    <div class="info-accordion">
      <p class="subtitle-accordion">
        <?php echo lang(array(
          "es"=>"Selecciona las distintas categorias de productos para mostrar en la pagina principal.",
          "en"=>"Select the products that appers at the home."
        )); ?>
      </p>
      <div id="web_configuracion_barras_productos" class="ordenable"></div>
      <div class="form-group oh cb mt15">
        <button class="btn btn-info guardar btn-block">
        <?php echo lang(array(
          "es"=>"Guardar",
          "en"=>"Save changes"
        )); ?>
        </button>
      </div>      
    </div>    
  <% } %>

  <?php if (isset($empresa->config["slider_2_home_image_width"])) { ?>
    <div class="header-accordion bg-light lter">
      <?php echo (isset($empresa->config["slider_2_titulo"]) ? $empresa->config["slider_2_titulo"] : lang(array("es"=>"Carrusel secundario","en"=>"Secondary carrusel"))); ?>
    </div>
    <div class="info-accordion">
       <p class="subtitle-accordion">
        <?php echo lang(array(
          "es"=>"Esta información pasará en un segundo nivel en la página de inicio.",
          "en"=>"Upload images for your secondary carrousel."
        )); ?>
      </p>
      <div id="web_configuracion_sliders_2" class="ordenable"></div>
      <div class="form-group oh cb mt15">
        <button class="btn btn-info guardar btn-block">
      <?php echo lang(array(
        "es"=>"Guardar",
        "en"=>"Save changes"
      )); ?>
      </button>
      </div>      
    </div>
  <?php } ?>

  <?php if (isset($empresa->config["slider_3"])) { ?>
    <div class="header-accordion bg-light lter">
      <?php echo (isset($empresa->config["slider_3_titulo"]) ? $empresa->config["slider_3_titulo"] : lang(array("es"=>"Carrusel 3","en"=>"Carrousel 3"))); ?>
    </div>
    <div class="info-accordion">
      <p class="subtitle-accordion">
        <?php echo lang(array(
          "es"=>"Esta información pasará en un segundo nivel en la página de inicio.",
          "en"=>"Upload images for your secondary carrousel."
        )); ?>
      </p>
      <div id="web_configuracion_sliders_3" class="ordenable"></div>
      <div class="form-group oh cb mt15">
        <button class="btn btn-info guardar btn-block">
      <?php echo lang(array(
        "es"=>"Guardar",
        "en"=>"Save changes"
      )); ?>
      </button>
      </div>      
    </div>
  <?php } ?>

  <?php if (isset($empresa->config["slider_4"])) { ?>
    <div class="header-accordion bg-light lter">
      <?php echo (isset($empresa->config["slider_4_titulo"]) ? $empresa->config["slider_4_titulo"] : lang(array("es"=>"Carrusel 4","en"=>"Carrousel 4"))); ?>
    </div>
    <div class="info-accordion">
      <p class="subtitle-accordion">
        <?php echo lang(array(
          "es"=>"Esta información pasará en un segundo nivel en la página de inicio.",
          "en"=>"Upload images for your secondary carrousel."
        )); ?>
      </p>
      <div id="web_configuracion_sliders_4" class="ordenable"></div>
      <div class="form-group oh cb mt15">
        <button class="btn btn-info guardar btn-block">
      <?php echo lang(array(
        "es"=>"Guardar",
        "en"=>"Save changes"
      )); ?>
      </button>
      </div>      
    </div>
  <?php } ?>

  <div class="header-accordion bg-light lter">
    <?php echo lang(array("es"=>"Avanzada","en"=>"More options")) ?>
  </div>
  <div class="info-accordion">
    <p class="subtitle-accordion">
    <?php echo lang(array("es"=>"Favicon","en"=>"Favicon")) ?>
    </p>
    <div class="form-group oh">
      <div class="col-xs-12">
        <?php single_file_upload(array(
          "name"=>"favicon",
          "label"=>"",
          "url"=>"web_configuracion/function/save_file/",
        )); ?>
      </div>
    </div>
    <p class="subtitle-accordion">
    <?php echo lang(array("es"=>"Imagen por defecto cuando los elementos no tienen foto principal.","en"=>"Select a default image for items that do not have")) ?>
    </p>
    <div class="form-group oh">
      <div class="col-xs-12">
        <?php
        single_upload(array(
          "name"=>"no_imagen",
          "label"=>"",
          "url"=>"empresas/function/save_image/",
          "width"=>(isset($empresa->config["no_imagen_width"]) ? $empresa->config["no_imagen_width"] : 400),
          "height"=>(isset($empresa->config["no_imagen_height"]) ? $empresa->config["no_imagen_height"] : 400),
        )); 
        ?>
      </div>
    </div>
    <p class="subtitle-accordion">
      <?php echo lang(array("es"=>"Marca de Agua","en"=>"Watermark")) ?>
    </p>
    <div class="form-group oh">
      <div class="col-xs-12">
        <?php single_file_upload(array(
          "name"=>"marca_agua",
          "label"=>"",
          "url"=>"web_configuracion/function/save_file/",
        )); ?>
      </div>
    </div>
    <div class="form-group oh">
      <select class="form-control" id="web_configuracion_marca_agua_posicion" name="marca_agua_posicion">
        <option <%= (marca_agua_posicion==0)?"selected":"" %> value="0"><?php echo lang(array("es"=>"Posicion","en"=>"Position")) ?></option>
        <option <%= (marca_agua_posicion==10)?"selected":"" %> value="10"><?php echo lang(array("es"=>"Completo","en"=>"Full")) ?></option>
        <option <%= (marca_agua_posicion==5)?"selected":"" %> value="5"><?php echo lang(array("es"=>"Centrado","en"=>"Center")) ?></option>
        <option <%= (marca_agua_posicion==7)?"selected":"" %> value="7"><?php echo lang(array("es"=>"Arriba Izquierda","en"=>"Top Left")) ?></option>
        <option <%= (marca_agua_posicion==8)?"selected":"" %> value="8"><?php echo lang(array("es"=>"Arriba Centro","en"=>"Top Center")) ?></option>
        <option <%= (marca_agua_posicion==9)?"selected":"" %> value="9"><?php echo lang(array("es"=>"Arriba Derecha","en"=>"Top Right")) ?></option>        
        <option <%= (marca_agua_posicion==1)?"selected":"" %> value="1"><?php echo lang(array("es"=>"Abajo Izquierda","en"=>"Bottom Left")) ?></option>
        <option <%= (marca_agua_posicion==2)?"selected":"" %> value="2"><?php echo lang(array("es"=>"Abajo Centro","en"=>"Bottom Center")) ?></option>
        <option <%= (marca_agua_posicion==3)?"selected":"" %> value="3"><?php echo lang(array("es"=>"Abajo Derecha","en"=>"Bottom Right")) ?></option>
      </select>
    </div>
    <div class="form-group oh cb mt15">
      <button class="btn btn-info guardar btn-block">
      <?php echo lang(array(
        "es"=>"Guardar",
        "en"=>"Save changes",
      )); ?>
      </button>
    </div>      
  </div>

</div>
<div style="margin-left: 256px; height: 100%; width: calc(100% - 256px); ">
  <% var dom = ""; %>
  <% if (window.location.origin.indexOf("varcreative")>=0) { %>
    <% dom = window.location.protocol+"//www.varcreative.com/sandbox/"+ID_EMPRESA+"/" %>
  <% } else if (window.location.origin.indexOf("navaprostudio")>=0) { %>
    <% dom = window.location.protocol+"//www.navaprostudio.com/sandbox/"+ID_EMPRESA+"/" %>
  <% } else { %>
    <% dom = window.location.protocol+"//"+DOMINIO %>
  <% } %>
  <iframe id="iframe" src="<%= dom %>" style="width: 100%; height: 100%; border:none; padding: 0px; margin: -2px; "></iframe>
</div>
<?php
// Error en Chrome Versión 53.0.2785.101 m
// Se quedaba colgado por el maquetado
/*
?>
  <div class="col col-no-responsive w-md bg-light dk b-r bg-auto">
  <div class="vbox">
    <div class="row-row">
    <div class="cell scrollable">
      <div class="cell-inner">
      
      
      </div>
    </div>
    </div>
  </div>
  </div>
  <div class="col">
  <div class="vbox">
    <div class="row-row">
    <div class="cell">
      <div class="cell-inner">
        
      </div>
    </div>
    </div>
  </div>
  </div>
*/ ?>
</script>

<script type="text/template" id="web_configuracion_mapa_edit_panel_template">
<div class="panel panel-default">
  <div class="panel-heading">
  Ubicaciones
  </div>
  <div class="panel-body">
  <div style="height:400px;" id="web_configuracion_mapa_contacto"></div>
    <div class="help-block fs14 mb0">
      <button class="btn btn-default add_marker m-r">
      <?php echo lang(array(
        "es"=>"+ Marcador",
        "en"=>"+ Add Marker",
      )); ?>
      </button>
      <?php echo lang(array(
        "es"=>"Puede arrastrar el marcador del mapa para ponerlo en la direccion exacta. Doble click para eliminarlo.",
        "en"=>"Add a marker! Then simply dragging the marker to the right position. Double click for delete the marker.",
      )); ?>
    </div>
  </div>
  <div class="panel-footer">
  <button class="guardar btn btn-md btn-info">
      <?php echo lang(array(
        "es"=>"Guardar",
        "en"=>"Save changes",
      )); ?>
  </button>
  </div>
</div>
</script>

<script type="text/template" id="web_slider_panel_template">
<% if (editor) { %>
  <ul id="web_slider_table" data-ordenable-table="web_slider" class="list-group gutter list-group-lg list-group-sp ui-sortable ordenable"></ul>
  <div class="form-group oh cb">
    <button class="btn btn-default agregar btn-block">
    <?php echo lang(array(
        "es"=>"Agregar imagen",
        "en"=>"Add image",
      )); ?>
    </button>
  </div>  
<% } else { %>
  <div class=" wrapper-md ng-scope">
  <h1 class="m-n h3"><?php echo lang(array("es"=>"Slider de Home","en"=>"Home Slider")) ?></h1>
  </div>
  <div class="wrapper-md ng-scope">
    <div class="panel panel-default">
      <div class="panel-heading oh">
        <div class="search_container col-lg-4 col-md-6 col-sm-9 col-xs-12"></div>
        <a class="btn pull-right btn-info btn-addon" href="app/#web_slider"><i class="fa fa-plus"></i><?php echo lang(array("es"=>"Nuevo","en"=>"Add New")) ?></a>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table id="web_slider_table" data-ordenable-table="web_slider" class="table table-striped ordenable m-b-none default footable">
            <thead>
              <tr>
                <th class="w50"><?php echo lang(array("es"=>"Imagen","en"=>"Image")) ?></th>
                <th><?php echo lang(array("es"=>"Nombre","en"=>"Name")) ?></th>
                <% if (permiso > 1) { %>
                  <th class="w25"></th>
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
<% } %>
</script>

<script type="text/template" id="web_slider_item">
  <span class="dn id"><%= id %></span>
  <span><i class='fa fa-sort text-muted fa m-r-sm'></i> </span>
  <% if (!isEmpty(path)) { %>
    <img class='img_preview edit cp' style="margin-left: 10px; margin-right:10px; max-height:50px; max-width: 60%" src="<%= path %>" />
  <% } else { %>
    <span class='edit cp'><%= linea_1.substr(0,32) %></span>
  <% } %>
  <% if (permiso > 1) { %>
    <span class='cp pull-right'>
      <i class="fa fa-times delete text-danger" data-id="<%= id %>" />
    </span>
  <% } %>
</script>

<script type="text/template" id="web_slider_edit_panel_template">
<div class="panel panel-default rform">
  <div class="panel-heading clearfix">
    <b><%= (id == undefined)?"<?php echo lang(array("es"=>"Nuevo Slider","en"=>"New Slider")); ?>":"<?php echo lang(array("es"=>"Editar Slider","en"=>"Slider")); ?>" %></b>
    <div class="pull-right">
      <div class="btn-group dropdown">
        <button class="btn btn-sm btn-default dropdown-toggle btn-addon" data-toggle="dropdown">
          <i class="glyphicon glyphicon-import"></i><span class="hidden-xs"><?php echo lang(array("es"=>"Importar","en"=>"Import")); ?></span>
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu pull-right">
          <% if (control.check("entradas")>0) { %>
            <li><a href="javascript:void(0);" class="importar_entradas"><?php echo lang(array("es"=>"Páginas","en"=>"Posts")); ?></a></li>
          <% } %>
          <% if (control.check("articulos")>0) { %>
            <li><a href="javascript:void(0);" class="importar_articulos"><?php echo lang(array("es"=>"Articulos","en"=>"Products")); ?></a></li>
          <% } %>
          <% if (control.check("propiedades")>0) { %>
            <li><a href="javascript:void(0);" class="importar_propiedades"><?php echo lang(array("es"=>"Propiedades","en"=>"Properties")); ?></a></li>
          <% } %>
        </ul>
      </div>
    </div>
  </div>
  <div class="panel-body" style="overflow: auto; max-height: 400px; ">
    <% if (clave == "slider_2") { %>
      <?php
      single_upload(array(
        "name"=>"path",
        "label"=>lang(array("es"=>"Imagen de Fondo","en"=>"Background Image")),
        "url"=>"/admin/web_slider/function/save_image/",
        "url_file"=>"/admin/web_slider/function/save_file/",
        "width"=>(isset($empresa->config["slider_2_home_image_width"]) ? $empresa->config["slider_2_home_image_width"] : ((isset($empresa->config["slider_home_image_width"])) ? $empresa->config["slider_home_image_width"] :256)),
        "height"=>(isset($empresa->config["slider_2_home_image_height"]) ? $empresa->config["slider_2_home_image_height"] : ((isset($empresa->config["slider_home_image_height"])) ? $empresa->config["slider_home_image_height"] :256)),
        "quality"=>(isset($empresa->config["slider_2_home_image_quality"]) ? $empresa->config["slider_2_home_image_quality"] : 0.92),
      )); ?>  

    <% } else if (clave == "slider_3") { %>
      <?php
      single_upload(array(
        "name"=>"path",
        "label"=>lang(array("es"=>"Imagen de Fondo","en"=>"Background Image")),
        "url"=>"/admin/web_slider/function/save_image/",
        "url_file"=>"/admin/web_slider/function/save_file/",
        "width"=>(isset($empresa->config["slider_3_home_image_width"]) ? $empresa->config["slider_3_home_image_width"] : ((isset($empresa->config["slider_home_image_width"])) ? $empresa->config["slider_home_image_width"] :256)),
        "height"=>(isset($empresa->config["slider_3_home_image_height"]) ? $empresa->config["slider_3_home_image_height"] : ((isset($empresa->config["slider_home_image_height"])) ? $empresa->config["slider_home_image_height"] :256)),
        "quality"=>(isset($empresa->config["slider_3_home_image_quality"]) ? $empresa->config["slider_3_home_image_quality"] : 0.92),
      )); ?>   

    <% } else if (clave == "slider_4") { %>
      <?php
      single_upload(array(
        "name"=>"path",
        "label"=>lang(array("es"=>"Imagen de Fondo","en"=>"Background Image")),
        "url"=>"/admin/web_slider/function/save_image/",
        "url_file"=>"/admin/web_slider/function/save_file/",
        "width"=>(isset($empresa->config["slider_4_home_image_width"]) ? $empresa->config["slider_4_home_image_width"] : ((isset($empresa->config["slider_home_image_width"])) ? $empresa->config["slider_home_image_width"] :256)),
        "height"=>(isset($empresa->config["slider_4_home_image_height"]) ? $empresa->config["slider_4_home_image_height"] : ((isset($empresa->config["slider_home_image_height"])) ? $empresa->config["slider_home_image_height"] :256)),
        "quality"=>(isset($empresa->config["slider_4_home_image_quality"]) ? $empresa->config["slider_4_home_image_quality"] : 0.92),
      )); ?>   

    <% } else if (clave == "slider_5") { %>
      <?php
      single_upload(array(
        "name"=>"path",
        "label"=>lang(array("es"=>"Imagen de Fondo","en"=>"Background Image")),
        "url"=>"/admin/web_slider/function/save_image/",
        "url_file"=>"/admin/web_slider/function/save_file/",
        "width"=>(isset($empresa->config["slider_5_home_image_width"]) ? $empresa->config["slider_5_home_image_width"] : ((isset($empresa->config["slider_home_image_width"])) ? $empresa->config["slider_home_image_width"] :256)),
        "height"=>(isset($empresa->config["slider_5_home_image_height"]) ? $empresa->config["slider_5_home_image_height"] : ((isset($empresa->config["slider_home_image_height"])) ? $empresa->config["slider_home_image_height"] :256)),
        "quality"=>(isset($empresa->config["slider_5_home_image_quality"]) ? $empresa->config["slider_5_home_image_quality"] : 0.92),
      )); ?> 

    <% } else { %>
      <?php
      single_upload(array(
        "name"=>"path",
        "label"=>lang(array("es"=>"Imagen de Fondo","en"=>"Background Image")),
        "url"=>"/admin/web_slider/function/save_image/",
        "url_file"=>"/admin/web_slider/function/save_file/",
        "width"=>(isset($empresa->config["slider_home_image_width"]) ? $empresa->config["slider_home_image_width"] : 256),
        "height"=>(isset($empresa->config["slider_home_image_height"]) ? $empresa->config["slider_home_image_height"] : 256),
        "quality"=>(isset($empresa->config["slider_home_image_quality"]) ? $empresa->config["slider_home_image_quality"] : 0.92),
      )); ?>        
    <% } %>

    <div class="form-group lang-control">
      <div class="clearfix">
        <label class="control-label m-t-xs">
          <?php echo lang(array(
            "es"=>"Texto",
            "en"=>"Text",
          )); ?>
        </label>
        <div class="lang-control-btn">
          <label class="btn btn-default btn-lang active" data-id="web_slider_linea_1_cont" uncheckable=""><img title="Espa&ntilde;ol" src="resources/images/es.png"/></label>
          <label class="btn btn-default btn-lang" data-id="web_slider_linea_1_en_cont" uncheckable=""><img title="Ingl&eacute;s" src="resources/images/en.png"/></label>
          <label class="btn btn-default btn-lang" data-id="web_slider_linea_1_pt_cont" uncheckable=""><img title="Portugues" src="resources/images/pt.png"/></label>
        </div>
      </div>
      <div class="form-group">
        <div class="form-control-cont active" id="web_slider_linea_1_cont">
          <textarea id="web_slider_linea_1" class="form-control db" name="linea_1"><%= linea_1 %></textarea>
        </div>
        <div class="form-control-cont" id="web_slider_linea_1_en_cont">
          <textarea id="web_slider_linea_1_en" class="form-control db" name="linea_1_en"><%= linea_1_en %></textarea>
        </div>
        <div class="form-control-cont" id="web_slider_linea_1_pt_cont">
          <textarea id="web_slider_linea_1_pt" class="form-control db" name="linea_1_pt"><%= linea_1_pt %></textarea>
        </div>
      </div>
    </div>

    <div class="form-group mb0 tar">
      <a class="expand-link">
        <?php echo lang(array(
          "es"=>"+ M&aacute;s opciones",
          "en"=>"+ More options",
        )); ?>
      </a>
    </div>
  </div>

  <div class="panel-body expand">

    <div class="form-group">
      <label class="control-label"><?php echo lang(array("es"=>"Boton 1","en"=>"Button 1")); ?></label>
      <div class="row">
        <div class="col-md-6">
          <input type="text" name="texto_link_1" id="web_slider_texto_link_1" value="<%= texto_link_1 %>" placeholder="<?php echo lang(array("es"=>"Texto","en"=>"Text")); ?>" class="form-control"/>
        </div>
        <div class="col-md-6">
          <input type="text" name="link_1" id="web_slider_link_1" value="<%= link_1 %>" placeholder="Link" class="form-control"/>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label"><?php echo lang(array("es"=>"Boton 2","en"=>"Button 2")); ?></label>
      <div class="row">
        <div class="col-md-6">
          <input type="text" name="texto_link_2" id="web_slider_texto_link_2" value="<%= texto_link_2 %>" placeholder="<?php echo lang(array("es"=>"Texto","en"=>"Text")); ?>" class="form-control"/>
        </div>
        <div class="col-md-6">
          <input type="text" name="link_2" id="web_slider_link_2" value="<%= link_2 %>" placeholder="Link" class="form-control"/>
        </div>
      </div>
    </div>

    <?php
    single_file_upload(array(
      "name"=>"video",
      "label"=>"Video",
      "url"=>"/admin/web_slider/function/save_file/",
    )); ?>

    <?php
    single_upload(array(
      "name"=>"path_2",
      "label"=>lang(array("es"=>"Imagen de Frente","en"=>"Foreground Image")),
      "url"=>"/admin/web_slider/function/save_image/",
      "width"=>(isset($empresa->config["slider_home_2_image_width"]) ? $empresa->config["slider_home_2_image_width"] : 256),
      "height"=>(isset($empresa->config["slider_home_2_image_height"]) ? $empresa->config["slider_home_2_image_height"] : 256),
      "crop_type"=>(isset($empresa->config["slider_home_2_image_crop_type"]) ? $empresa->config["slider_home_2_image_crop_type"] : 0),
      "resizable"=>(isset($empresa->config["slider_home_2_image_resizable"]) ? $empresa->config["slider_home_2_image_resizable"] : 0),
    )); ?>

    <div class="form-group cb">
      <label class="control-label"><?php echo lang(array("es"=>"Color de Fondo","en"=>"Background Color")); ?></label>
      <div class="input-group color_fondo colorpicker-component">
        <input type="text" class="form-control" value="<%= color_fondo %>" />
        <span class="input-group-addon"><i></i></span>
      </div>
    </div>
    
    <div class="form-group cb">
      <label class="i-checks">
        <input type="checkbox" class="checkbox" name="invertir_colores_letras" <%= (invertir_colores_letras == 1)?"checked":"" %> value="1">
        <i></i><?php echo lang(array("es"=>"Invertir los colores de las letras.","en"=>"Invert colors of letters.")); ?>
      </label>
    </div>  

    <div class="form-group cb mb0">
      <% if (edicion) { %>
        <label class="i-checks">
          <input type="checkbox" id="web_slider_activo" name="activo" class="checkbox" value="1" <%= (activo == 1)?"checked":"" %> >
          <i></i>
          <?php echo lang(array("es"=>"El slider esta activo.","en"=>"The slider is active.")); ?>
        </label>
      <% } else { %>
        <span><%= ((activo==0) ? "Slider inactivo" : "Slider activo") %></span>
      <% } %>
    </div>

  </div>

  <% if (edicion) { %>
    <div class="panel-footer clearfix tar">
      <button class="btn guardar btn-info"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
    </div>
  <% } %>
</div>
</script>



<script type="text/template" id="web_barras_productos_panel_template">
<ul id="web_barras_productos_table" data-ordenable-table="web_barras_productos" class="list-group gutter list-group-lg list-group-sp ui-sortable ordenable"></ul>
<div class="form-group oh cb">
  <button class="btn btn-info agregar btn-block">
  <?php echo lang(array(
      "es"=>"Agregar",
      "en"=>"Add",
    )); ?>
  </button>
</div>  
</script>

<script type="text/template" id="web_barras_productos_item">
  <span class="dn id"><%= id %></span>
  <span><i class='fa fa-sort text-muted fa m-r-sm'></i> </span>
  <span class='edit cp'><%= nombre.substr(0,32) %></span>
  <span class='cp pull-right'>
    <i class="fa fa-times delete text-danger" data-id="<%= id %>" />
  </span>
</script>

<script type="text/template" id="web_barras_productos_edit_panel_template">
<div class="panel panel-default rform">
  <div class="panel-heading clearfix">
    <b><%= (id == undefined)?"<?php echo lang(array("es"=>"Nuevo","en"=>"New")); ?>":"<?php echo lang(array("es"=>"Editar","en"=>"Edit")); ?>" %></b>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Nombre</label>
          <input type="text" name="nombre" id="web_barras_productos_nombre" value="<%= nombre %>" class="form-control"/>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Subtitulo</label>
          <input type="text" name="subtitulo" id="web_barras_productos_subtitulo" value="<%= subtitulo %>" class="form-control"/>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Marca</label>
          <select id="web_barras_productos_marcas" class="w100p no-model">
            <option value="0">Seleccione</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Categoria</label>
          <select id="web_barras_productos_rubros" class="w100p form-control no-model">
            <option value="0">Seleccione</option>
            <%= workspace.crear_select(rubros,"",id_rubro) %>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Proveedor</label>
          <select id="web_barras_productos_proveedores" class="w100p no-model">
            <option value="0">Seleccione</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label">Etiqueta</label>
          <select id="web_barras_productos_etiquetas" class="w100p no-model">
            <option value="0">Seleccione</option>
            <% for (var i=0; i< articulos_etiquetas.length; i++) { %>
              <% var o = articulos_etiquetas[i] %>
              <option <%= (id_etiqueta == o.id)?"selected":"" %> value="<%= o.id %>"><%= o.nombre %></option>
            <% } %>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <label class="control-label">Cantidad</label>
        <input type="text" name="total_productos" id="web_barras_productos_total_productos" value="<%= total_productos %>" class="form-control"/>
      </div>
      <div class="col-md-4">
        <label class="control-label">Orden</label>
        <select id="web_barras_productos_aleatorio" class="w100p form-control no-model">
          <option <%= (aleatorio==0)?"selected":"" %> value="0">Normal</option>
          <option <%= (aleatorio==1)?"selected":"" %> value="1">Aleatorio</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="control-label">Link</label>
        <input type="text" name="link" id="web_barras_productos_link" value="<%= link %>" class="form-control"/>
      </div>
    </div>
  </div>
  <div class="panel-footer clearfix tar">
    <button class="btn guardar btn-info"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
  </div>
</div>
</script>


<script type="text/template" id="web_configuracion_menu_template">
  <div class="panel panel-default">
    <div class="panel-heading bold">Menu de opciones</div>
    <div class="panel-body">
      <div style="height:340px;overflow:auto">
        <div ui-jq="nestable" class="dd">
          <ol class="dd-list">
            <% for(var i=0;i< campos.length;i++) { %>
              <% var c = campos[i] %>
              <li class="dd-item dd3-item" data-id="'+o.id+'">
                <div class="dd-handle dd3-handle">Drag</div>
                <div class="dd3-content" style="padding:3px 10px 3px 50px">
                  <div class="clearfix columna_editable">
                    <label class="i-checks m-b-none pull-left mt7">
                      <input <%= (c.visible==1)?"checked":"" %> type="checkbox"><i></i>
                    </label>
                    <input data-campo="<%= c.campo %>" value="<%= c.titulo %>" type="text" class="form-control no-model pull-left w200"/>
                  </div>
                </div>
              </li>
            <% } %>
          </ol>
        </div>
      </div>
    </div>
    <div class="panel-footer clearfix tar">
      <button class="guardar btn btn-info">Guardar</button>
    </div>
  </div>
</script>


<script type="text/template" id="web_componentes_panel_template">
<ul id="web_componentes_table" data-ordenable-table="web_componentes" class="list-group gutter list-group-lg list-group-sp ui-sortable ordenable"></ul>
<?php /*
<div class="form-group oh cb">
  <button class="btn btn-info agregar btn-block">
  <?php echo lang(array(
      "es"=>"Agregar",
      "en"=>"Add",
    )); ?>
  </button>
</div>  
*/ ?>
</script>

<script type="text/template" id="web_componentes_item">
  <span class="dn id"><%= id %></span>
  <span><i class='fa fa-sort text-muted fa m-r-sm'></i> </span>
  <label class="i-checks m-b-none">
    <input class="checks-componente" <%= (activo==1)?"checked":"" %> value="<%= id %>" type="checkbox"><i></i>
  </label>  
  <span class='edit cp fs14 text-info'><%= (!isEmpty(nombre)) ? nombre.substr(0,32) : archivo.substr(0,32) %></span>
</script>

<script type="text/template" id="web_componentes_edit_panel_template">
<div class="panel panel-default rform">
  <div class="panel-heading clearfix">
    <b>Edici&oacute;n de componente</b>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <label class="control-label">Titulo</label>
      <input type="text" name="nombre" id="web_componentes_nombre" value="<%= nombre %>" class="form-control"/>
    </div>
    <div class="form-group">
      <label class="control-label">Subtitulo</label>
      <input type="text" name="subtitulo" id="web_componentes_subtitulo" value="<%= subtitulo %>" class="form-control"/>
    </div>
    <div class="form-group lang-control">
      <div class="clearfix">
        <label class="control-label m-t-xs"><?php echo lang(array("es"=>"Texto","en"=>"Text")); ?></label>
        <div class="lang-control-btn">
          <label class="btn btn-default btn-lang active" data-id="web_componente_texto_cont" uncheckable=""><img title="Espa&ntilde;ol" src="resources/images/es.png"/></label>
          <?php /*
          <label id="entrada_link_2" class="btn btn-default btn-lang" data-id="web_componente_texto_en_cont" uncheckable=""><img title="Ingl&eacute;s" src="resources/images/en.png"/></label>
          <label id="entrada_link_3" class="btn btn-default btn-lang" data-id="web_componente_texto_pt_cont" uncheckable=""><img title="Portugues" src="resources/images/pt.png"/></label>
          */ ?>
        </div>
      </div>
      <div class="form-group">
        <div class="form-control-cont active" id="web_componente_texto_cont">
          <textarea name="texto" name="texto" id="web_componente_texto"><%= texto %></textarea>
        </div>
        <div class="form-control-cont" id="web_componente_texto_en_cont">
          <textarea name="texto_en" name="texto_en" id="web_componente_texto_en"><%= texto_en %></textarea>
        </div>
        <div class="form-control-cont" id="web_componente_texto_pt_cont">
          <textarea name="texto_pt" name="texto_pt" id="web_componente_texto_pt"><%= texto_pt %></textarea>
        </div>
      </div>
    </div>
    <?php
    single_upload(array(
      "name"=>"path",
      "label"=>lang(array("es"=>"Imagen","en"=>"Image")),
      "url_file"=>"/admin/entradas/function/save_file/",
    )); ?>   

    <div class="form-group">
      <label class="control-label">ID Referencia</label>
      <input type="text" name="id_referencia" id="web_componentes_referencias" value="<%= id_referencia %>" class="form-control"/>
    </div>

    <?php /*
    <div class="row">
      <div class="col-md-4">
        <label class="control-label">Filtro</label>
        <input type="text" name="id_referencia" id="web_componentes_referencias" value="<%= id_referencia %>" class="form-control"/>
      </div>
      <div class="col-md-4">
        <label class="control-label">Link</label>
        <input type="text" name="link" id="web_componentes_link" value="<%= link %>" class="form-control"/>
      </div>
    </div>*/?>
  </div>
  <div class="panel-footer clearfix tar">
    <button class="btn guardar btn-info"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
  </div>
</div>
</script>