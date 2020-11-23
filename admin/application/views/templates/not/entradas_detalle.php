<div class="modal-header">
  <b>Editar página</b>
  <i class="pull-right cerrar_lightbox fs16 fa fa-times cp"></i>
</div>
<div class="modal-body">
  <div class="tab-container">
    <ul class="nav nav-tabs nav-tabs-2" role="tablist">
      <li class="active">
        <a role="tab" data-toggle="tab" href="#entrada_detalle_edit_ppal">
          <i class="material-icons">create</i> Información básica
        </a>
      </li>
      <li>
        <a role="tab" data-toggle="tab" href="#entrada_detalle_edit_multimedia">
          <i class="material-icons">perm_media</i> Multimedia
        </a>
      </li>
      <li>
        <a role="tab" data-toggle="tab" href="#entrada_detalle_edit_avanzada">
          <i class="material-icons">schedule</i> Avanzada
        </a>
      </li>
    </ul>
    <div class="tab-content">
      <div id="entrada_detalle_edit_ppal" class="tab-pane active">

        <div class="form-group lang-control">
          <label class="control-label">
            <?php echo lang(array(
              "es"=>"T&iacute;tulo",
              "en"=>"Title",
            )); ?>
          </label>
          <div class="input-group">
            <input type="text" id="entrada_titulo" class="form-control active" value="<%= titulo %>" name="titulo"/>
            <input type="text" id="entrada_titulo_en" name="titulo_en" class="form-control" id="entrada_titulo_en" value="<%= titulo_en %>"/>
            <input type="text" id="entrada_titulo_pt" name="titulo_pt" class="form-control" id="entrada_titulo_pt" value="<%= titulo_pt %>"/>
            <div class="input-group-btn">
              <label class="btn btn-default btn-lang active" data-id="entrada_titulo" uncheckable=""><img title="Espa&ntilde;ol" src="resources/images/es.png"/></label>
              <label class="btn btn-default btn-lang" data-id="entrada_titulo_en" uncheckable=""><img title="Ingl&eacute;s" src="resources/images/en.png"/></label>
              <label class="btn btn-default btn-lang" data-id="entrada_titulo_pt" uncheckable=""><img title="Portugues" src="resources/images/pt.png"/></label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label">
            <?php echo lang(array(
              "es"=>"Categor&iacute;a",
              "en"=>"Category",
            )); ?>
          </label>
          <% if (control.check("categorias_entradas")>1) { %>
            <div class="input-group">
              <select id="entrada_categorias" class="form-control"></select>
              <span class="input-group-btn">
                <button tabindex="-1" class="btn btn-default w100 agregar_categoria">
                  <?php echo lang(array(
                    "es"=>"+ Categor&iacute;a",
                    "en"=>"+ Add New",
                  )); ?>
                </button>
              </span>
            </div>
          <% } else { %>
            <select id="entrada_categorias" class="form-control"></select>
          <% } %>
        </div>              

        <div class="form-group lang-control">
          <div class="clearfix">
            <label class="control-label m-t-xs">
              <?php echo lang(array(
                "es"=>"Texto",
                "en"=>"Text",
              )); ?>
            </label>
            <div class="lang-control-btn">
              <label class="btn btn-default btn-lang active" data-id="entrada_texto_cont" uncheckable=""><img title="Espa&ntilde;ol" src="resources/images/es.png"/></label>
              <label id="entrada_link_2" class="btn btn-default btn-lang" data-id="entrada_texto_en_cont" uncheckable=""><img title="Ingl&eacute;s" src="resources/images/en.png"/></label>
              <label id="entrada_link_3" class="btn btn-default btn-lang" data-id="entrada_texto_pt_cont" uncheckable=""><img title="Portugues" src="resources/images/pt.png"/></label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-control-cont active" id="entrada_texto_cont">
              <textarea name="texto" name="texto" id="entrada_texto"><%= texto %></textarea>
            </div>
            <div class="form-control-cont" id="entrada_texto_en_cont">
              <textarea name="texto_en" name="texto_en" id="entrada_texto_en"><%= texto_en %></textarea>
            </div>
            <div class="form-control-cont" id="entrada_texto_pt_cont">
              <textarea name="texto_pt" name="texto_pt" id="entrada_texto_pt"><%= texto_pt %></textarea>
            </div>
          </div>
        </div>

        <?php
        single_upload(array(
            "name"=>"path",
            "label"=>lang(array("es"=>"Imagen Principal","en"=>"Featured Image")),
            "url"=>"/admin/entradas/function/save_image/",
            "url_file"=>"/admin/entradas/function/save_file/",
            "width"=>(isset($empresa->config["entrada_image_width"]) ? $empresa->config["entrada_image_width"] : 256),
            "height"=>(isset($empresa->config["entrada_image_height"]) ? $empresa->config["entrada_image_height"] : 256),
            "quality"=>(isset($empresa->config["entrada_image_quality"]) ? $empresa->config["entrada_image_quality"] : 0.92),
            "thumbnail_width"=>(isset($empresa->config["entrada_thumbnail_width"]) ? $empresa->config["entrada_thumbnail_width"] : 0),
            "thumbnail_height"=>(isset($empresa->config["entrada_thumbnail_height"]) ? $empresa->config["entrada_thumbnail_height"] : 0),
        )); ?>        

      </div><!-- Fin tab -->

      <div id="entrada_detalle_edit_avanzada" class="tab-pane">

        <div class="checkbox">
          <label class="i-checks">
            <input type="checkbox" id="entrada_habilitar_contacto" name="habilitar_contacto" class="checkbox" value="1" <%= (habilitar_contacto == 1)?"checked":"" %> >
            <i></i>
            <?php echo lang(array(
              "es"=>"Habilitar el formulario de consulta.",
              "en"=>"Enable a contact form.",
            )); ?>
          </label>
        </div>  

        <div class="form-group">
          <label class="control-label">
            <?php echo lang(array(
              "es"=>"Etiquetas",
              "en"=>"Tags",
            )); ?>
          </label>
          <select multiple id="entrada_etiquetas" style="width: 100%">
            <% for (var i=0; i< etiquetas.length; i++) { %>
              <% var o = etiquetas[i] %>
              <option selected><%= o %></option>
            <% } %>
          </select>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="control-label">
                <label class="i-checks m-b-none">
                  <input id="entrada_mostrar_fecha" value="1" <%= (mostrar_fecha==1)?"checked":"" %> type="checkbox"><i></i>
                  <?php echo lang(array(
                    "es"=>"Mostrar fecha de publicaci&oacute;n",
                    "en"=>"Show publication date",
                  )); ?>
                </label>
              </label>
              <div class="input-group">
                <input type="text" name="fecha" id="entrada_fecha" value="<%= fecha %>" class="form-control"/>
                <span class="input-group-btn">
                  <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
                </span>              
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label">
            <?php echo lang(array(
              "es"=>"T&iacute;tulo",
              "en"=>"Title",
            )); ?>
          </label>
          <label class="control-label fr">
            <span id="entrada_seo_title_cantidad">0</span>
            <?php echo lang(array(
              "es"=>"de",
              "en"=>"of",
            )); ?>
            <span>70</span>
          </label>
          <input type="text" data-max="70" data-id="entrada_seo_title_cantidad" name="seo_title" id="entrada_seo_title" value="<%= seo_title %>" class="form-control text-remain"/>
        </div>
        <div class="form-group">
          <label class="control-label">
            <?php echo lang(array(
              "es"=>"Descripci&oacute;n",
              "en"=>"Description",
            )); ?>
          </label>
          <label class="control-label fr">
            <span id="entrada_seo_description_cantidad">0</span>
            <?php echo lang(array(
              "es"=>"de",
              "en"=>"of",
            )); ?>
            <span>160</span>
          </label>
          <textarea data-max="160" data-id="entrada_seo_description_cantidad" name="seo_description" id="entrada_seo_description" class="form-control text-remain"><%= seo_description %></textarea>
        </div>
        <div class="form-group">
          <div class="checkbox">
            <label class="i-checks">
              <input type="checkbox" id="entrada_seo_ocultar_sitemap" name="seo_ocultar_sitemap" class="checkbox" value="1" <%= (seo_ocultar_sitemap == 1)?"checked":"" %> >
              <i></i>
              <?php echo lang(array(
                "es"=>"No agregar la entrada al sitemap.xml.",
                "en"=>"No add this post to sitemap.xml.",
              )); ?>
            </label>
          </div>
        </div>              
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="control-label">
                <?php echo lang(array("es"=>"Prioridad","en"=>"Priority")) ?>
              </label>
              <input type="text" name="seo_sitemap_priority" id="entrada_seo_sitemap_priority" value="<%= seo_sitemap_priority %>" class="form-control"/>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="control-label">
                <?php echo lang(array("es"=>"Frecuencia","en"=>"Change Frecuency")) ?>
              </label>
              <select name="seo_sitemap_change_freq" id="entrada_seo_sitemap_change_freq" class="form-control">
                <option value="" <%= (seo_sitemap_change_freq == "")?"selected":"" %>>-</option>
                <option value="always" <%= (seo_sitemap_change_freq == "always")?"selected":"" %>>Always</option>
                <option value="hourly" <%= (seo_sitemap_change_freq == "hourly")?"selected":"" %>>Hourly</option>
                <option value="daily" <%= (seo_sitemap_change_freq == "daily")?"selected":"" %>>Daily</option>
                <option value="weekly" <%= (seo_sitemap_change_freq == "weekly")?"selected":"" %>>Weekly</option>
                <option value="monthly" <%= (seo_sitemap_change_freq == "monthly")?"selected":"" %>>Monthly</option>
                <option value="yearly" <%= (seo_sitemap_change_freq == "yearly")?"selected":"" %>>Yearly</option>
                <option value="never" <%= (seo_sitemap_change_freq == "never")?"selected":"" %>>Never</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <?php for($i=1;$i<=20;$i++) { ?>

            <?php if (isset($empresa->config["entrada_custom_".$i."_file"])) { ?>
              
              <div class="col-xs-12">
                <?php single_file_upload(array(
                  "name"=>"custom_$i",
                  "label"=>$empresa->config["entrada_custom_".$i."_file"],
                  "url"=>"/admin/entradas/function/save_file/",
                )); ?>
              </div>

            <?php } else if (isset($empresa->config["entrada_custom_".$i."_label"])) { ?>
              <div class="<?php echo (isset($empresa->config['entrada_custom_'.$i.'_class'])) ? $empresa->config['entrada_custom_'.$i.'_class'] :'col-xs-12'?>">
                <div class="form-group">
                  <label class="control-label"><?php echo $empresa->config["entrada_custom_".$i."_label"] ?></label>
                  <?php if(isset($empresa->config['entrada_custom_'.$i.'_values'])) { 
                    $values = explode("|",$empresa->config['entrada_custom_'.$i.'_values']); ?>
                    <select class="form-control" name="custom_<?php echo $i ?>">
                      <?php foreach($values as $value) { ?>
                        <option <%= (<?php echo "custom_".$i ?> == "<?php echo $value ?>")?"selected":""  %> value="<?php echo $value ?>"><?php echo $value ?></option>
                      <?php } ?>
                    </select>
                  <?php } else { ?>
                    <input type="text" name="custom_<?php echo $i ?>" id="entrada_custom_<?php echo $i ?>" value="<%= custom_<?php echo $i ?> %>" class="form-control"/>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
        </div>
      </div><!-- Fin tab -->

      <div id="entrada_detalle_edit_multimedia" class="tab-pane">

        <?php
        if (isset($empresa->config["entrada_image_2_label"])) {
          single_upload(array(
            "name"=>"path_2",
            "label"=>$empresa->config["entrada_image_2_label"],
            "url"=>"/admin/entradas/function/save_image/",
            "url_file"=>"/admin/entradas/function/save_file/",
            "width"=>(isset($empresa->config["entrada_image_2_width"]) ? $empresa->config["entrada_image_2_width"] : 256),
            "height"=>(isset($empresa->config["entrada_image_2_height"]) ? $empresa->config["entrada_image_2_height"] : 256),
            "quality"=>(isset($empresa->config["entrada_image_2_quality"]) ? $empresa->config["entrada_image_2_quality"] : 0.92),
          )); 
        } ?>

        <?php
        multiple_upload(array(
          "name"=>"images",
          "label"=>lang(array("en"=>"Image Gallery","es"=>"Galería de fotos")),
          "url"=>"entradas/function/save_image/",
          "url_file"=>"entradas/function/save_file/",
          "width"=>(isset($empresa->config["entrada_galeria_image_width"]) ? $empresa->config["entrada_galeria_image_width"] : 800),
          "height"=>(isset($empresa->config["entrada_galeria_image_height"]) ? $empresa->config["entrada_galeria_image_height"] : 600),
          "quality"=>(isset($empresa->config["entrada_galeria_image_quality"]) ? $empresa->config["entrada_galeria_image_quality"] : 0.8),
        )); ?>
        <div class="form-group">
          <label class="control-label">Video</label>
          <textarea id="entrada_video" style="height:80px;" placeholder="<?php echo lang(array('es'=>'Inserte aquí el código de insercción de su video','en'=>'Paste here your insertion code'));?>" class="form-control" name="video"><%= video %></textarea>
        </div>

        <?php
        single_file_upload(array(
          "name"=>"archivo",
          "label"=>lang(array("es"=>"Archivo adjunto","en"=>"Atacchment file")),
          "url"=>"/admin/entradas/function/save_file/",
        )); ?>

        <?php
        if (isset($empresa->config["entrada_logo_mostrar"])) { 
          single_upload(array(
            "name"=>"logo",
            "label"=>(isset($empresa->config["entrada_logo_label"]) ? $empresa->config["entrada_logo_label"] : "Logo"),
            "url"=>"/admin/entradas/function/save_image/",
            "width"=>(isset($empresa->config["entrada_logo_image_width"]) ? $empresa->config["entrada_logo_image_width"] : 256),
            "height"=>(isset($empresa->config["entrada_logo_image_height"]) ? $empresa->config["entrada_logo_image_height"] : 256),
            "quality"=>(isset($empresa->config["entrada_logo_image_quality"]) ? $empresa->config["entrada_logo_image_quality"] : 0.92),
          )); 
        } ?>

        <div class="form-group">
          <label class="control-label">
            <?php echo lang(array(
              "es"=>"Link externo",
              "en"=>"External link",
            )); ?>
          </label>
          <input type="text" name="link_externo" id="entrada_link_externo" value="<%= link_externo %>" class="form-control"/>
        </div>                

      </div><!-- Fin tab -->

    </div>
  </div>

</div>

<div class="modal-footer">
  <button title="<?php echo lang(array("es"=>"Abre la entrada desde la web","en"=>"View the post preview on the web")) ?>" class="btn m-r-xs previsualizar btn-default">
    <?php echo lang(array("es"=>"Previsualizar","en"=>"&nbsp;&nbsp;Preview&nbsp;&nbsp;",)); ?>
  </button>
  <button title="<?php echo lang(array("es"=>"Guarda los cambios pero no se aplican a la web","en"=>"Save the changes without apply on the web")) ?>" class="btn m-r-xs guardar_borrador btn-default">
  <?php echo lang(array("es"=>"Guardar en borrador","en"=>"Save as draft",)); ?>
  </button>
  <button title="<?php echo lang(array("es"=>"Guarda los cambios y los publica en la web","en"=>"The changes will be saved and applied on the web")) ?>" class="btn m-r-xs guardar btn-info">
    <?php echo lang(array("es"=>"&nbsp;&nbsp;Publicar&nbsp;&nbsp;","en"=>"&nbsp;&nbsp;Publish&nbsp;&nbsp;",)); ?>
  </button>
</div>