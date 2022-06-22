// -----------
//   MODELO
// -----------

(function ( models ) {

  models.WebConfiguracion = Backbone.Model.extend({
    urlRoot: "web_configuracion/",
    defaults: {
      template_header: "header",
      asuntos_contacto: "",
      email: "",
      direccion: "",
      ciudad: "",
      codigo_postal: "",
      telefono: "",
      telefono_2: "",
      whatsapp: "",
      horario: "",
      analytics: "",
      view_id: "",
      zopim: "",
      pixel_fb: "",
      facebook: "",
      google_plus: "",
      youtube: "",
      tripadvisor:"",
      twitter: "",
      instagram: "",
      linkedin: "",
      seo_title: "",
      seo_keywords: "",
      seo_description: "",
      texto_contacto: "",
      texto_quienes_somos: "",
      latitud: 0,
      longitud: 0,
      zoom: 12,
      pago_ok: "",
      pago_pending: "",
      pago_fail: "",
      archivo: "",
      texto_registro: "",
      texto_registro_gracias: "",
      no_imagen: "",
      marca_agua: "",
      marca_agua_posicion: 0,
      mostrar_numeros_direccion_detalle: 1,
      mostrar_numeros_direccion_listado: 1,
      color_fondo_imagenes_defecto: "",
      color_principal: "",
      color_secundario: "",
      color_terciario: "",
      color_4: "",
      color_5: "",
      color_6: "",
      calidad_imagenes: 75,
      logo_1: "",
      logo_2: "",
      logo_3: "",
      texto_css: "",
      texto_js: "",
      comp_ultimos:1,
      comp_destacados:1,
      comp_banners:1,
      comp_marcas:1,
      comp_newsletter:1,
      comp_footer_grande:1,
      comp_logos_pagos:1,
      comp_slider_2: 1,
      comp_mapa: 1,
      comp_galeria: 1,
      comp_cronograma: 1,
      emails_alquileres: "",
      emails_ventas: "",
      emails_emprendimientos: "",
      emails_tasaciones: "",
      emails_contacto: "",
      emails_registro: "",
      images_meli: [],
      favicon: "",
      tienda_envio_desde: 0,
      comp_instagram: 0,
      instagram_id: "",
      cotizaciones: [],
      cotizaciones_minimo: 0,
      cotizaciones_maximo: 0,
      cotizaciones_porcentaje_sueldo: "",
    }
  });
	    
})( app.models );



(function ( views, models ) {

  views.WebSingleView = Backbone.View.extend({

    template: _.template($("#web_menu_edit_template").html()),

    initialize: function() {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));

      // Dependiendo del modulo
      if (self.model.get("id_modulo") == "diseno") {
        var conf = new app.models.WebConfiguracion({
          "id":ID_EMPRESA
        });
        conf.fetch({
          "success":function() {
            var view = new app.views.WebDisenoView({
              model: conf,
            });
            self.$("#configuracion_content").html(view.el);
          },
        });

      } else if (self.model.get("id_modulo") == "contenido") {

        var view = new app.views.WebContenidoView({
          model: new app.models.AbstractModel(),
        });
        self.$("#configuracion_content").html(view.el);

      } else if (self.model.get("id_modulo") == "contacto") {
        var conf = new app.models.WebConfiguracion({
          "id":ID_EMPRESA
        });
        conf.fetch({
          "success":function() {
            var view = new app.views.WebRedesView({
              model: conf,
            });
            self.$("#configuracion_content").html(view.el);
          },
        });

      } else if (self.model.get("id_modulo") == "dominio") {
        var conf = new app.models.WebConfiguracion({
          "id":ID_EMPRESA
        });
        conf.fetch({
          "success":function() {
            var view = new app.views.WebDominioView({
              model: conf,
            });
            self.$("#configuracion_content").html(view.el);
          },
        });

      } else if (self.model.get("id_modulo") == "avanzada") {
        var conf = new app.models.WebConfiguracion({
          "id":ID_EMPRESA
        });
        conf.fetch({
          "success":function() {
            var view = new app.views.WebAvanzadaView({
              model: conf,
            });
            self.$("#configuracion_content").html(view.el);
          },
        });

      } else if (self.model.get("id_modulo") == "seguimiento") {
        var conf = new app.models.WebConfiguracion({
          "id":ID_EMPRESA
        });
        conf.fetch({
          "success":function() {
            var view = new app.views.WebSeguimientoView({
              model: conf,
            });
            self.$("#configuracion_content").html(view.el);
          },
        });

      } else if (self.model.get("id_modulo") == "marcas") {
        var v = new app.views.MarcasTableView({
          collection: new app.collections.Marcas(),
        }); 
        self.$("#configuracion_content").html(v.el);   

      } else if (self.model.get("id_modulo") == "chat") {
        var conf = new app.models.WebConfiguracion({
          "id":ID_EMPRESA
        });
        conf.fetch({
          "success":function() {
            var view = new app.views.WebChatView({
              model: conf,
            });
            self.$("#configuracion_content").html(view.el);
          },
        });

      }
      
      return this;
    },
        
  });

})(app.views, app.models);


// ============================================================
// DISEÑO WEB

(function ( views, models ) {

  views.WebDisenoView = app.mixins.View.extend({

    template: _.template($("#web_diseno_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click .elegir_disenio":function(e) {
        if (!confirm("Desea elegir está plantilla para su web?")) return;
        var id_template = $(e.currentTarget).data("id");
        $.ajax({
          "url":"empresas/function/guardar_template/",
          "dataType":"json",
          "type":"post",
          "data":{
            "id_template":id_template,
          },
          "success":function(){
            location.reload();
          }
        });
      },
      "click .solicitar_disenio":function(){
        var view = new app.views.SolicitarDisenioView({
          model: new app.models.AbstractModel(),
        });
        crearLightboxHTML({
          "html":view.el,
          "width":800,
          "height":300,
        });
      },
    },

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));

      // COLOR PRINCIPAL
      this.$(".color_principal").colorpicker({
        "format": "rgb",
        "align": "left",
      });
      
      // COLOR SECUNDARIO
      this.$(".color_secundario").colorpicker({
        "format": "rgb",
        "align": "left",
      });
      
      // COLOR TERCIARIO
      this.$(".color_terciario").colorpicker({
        "format": "rgb",
        "align": "left",
      });

      this.render_sliders();

      return this;
    },

    render_sliders: function() {
      var self = this;
      var coleccion = new app.collections.Web_Slider();
      coleccion.server_api = {
        clave: "slider_1",
      };      
      var tabla = new app.views.Web_SliderListaView({
        collection: coleccion,
        editor: true,
        permiso: 3,
        clave: "slider_1",
      });
      this.$("#web_configuracion_sliders").html(tabla.el);
    },    
        
    validar: function() {
      var self = this;
      try {
        $(".error").removeClass("error");

        var color_principal = this.$(".color_principal").colorpicker('getValue');
        var color_secundario = this.$(".color_secundario").colorpicker('getValue');
        var color_terciario = this.$(".color_terciario").colorpicker('getValue');
        
        this.model.set({
          "color_principal":color_principal,
          "color_secundario":color_secundario,
          "color_terciario":color_terciario,
          "logo_1":$("#hidden_logo_1").val(),
        })
        return true;
      } catch(e) {
        return false;
      }
    },

    guardar: function() {
      var self = this;
      if (this.validar()) {
        this.model.save({},{
          success: function(model,response) {
            location.reload();
          }
        });
      }
    },    
  
  });

})(app.views, app.models);


(function ( views, models ) {

  views.SolicitarDisenioView = app.mixins.View.extend({

    template: _.template($("#web_solicitar_disenio").html()),

    myEvents: {
      "click #soporte_enviar":"enviar",
    },

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));

      return this;
    },

    enviar: function() {
      var asunto = this.$("#soporte_asunto").val();
      var texto = this.$("#soporte_texto").val();
      if (isEmpty(asunto)) {
        alert("Por favor seleccione un asunto.");
        this.$("#soporte_asunto").focus();
        return;
      }
      if (isEmpty(texto)) {
        alert("Por favor escriba el motivo de su consulta.");
        this.$("#soporte_texto").focus();
        return;
      }
      $.ajax({
        "url":"dashboard/function/enviar_soporte/",
        "dataType":"json",
        "type":"post",
        "data":{
          "asunto":asunto,
          "texto":texto,
        },
        "success":function(r) {
          if (r.error == 1) alert(r.mensaje);
          else {
            alert("Hemos recibido su consulta. Le responderemos a la mayor brevedad para solucionar su inconveniente.");
            location.reload();
          }
        }
      });
    },   
  
  });

})(app.views, app.models);

// ============================================================
// CONTENIDO

(function ( views, models ) {

  views.WebContenidoView = app.mixins.View.extend({

    template: _.template($("#web_contenido_template").html()),

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));

      var entradasView = new app.views.EntradasTableView({
        collection: new app.collections.Entradas(),
      });
      this.$("#entradas_container").html(entradasView.el);

      var categoriasView = new app.views.CategoriasEntradasTableView({
        collection: new app.collections.CategoriasEntradas(),
      });
      this.$("#categorias_entradas_container").html(categoriasView.el);

      return this;
    },
  
  });

})(app.views, app.models);


// ============================================================
// REDES

(function ( views, models ) {

  views.WebRedesView = app.mixins.View.extend({

    template: _.template($("#web_redes_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click .mostrar_ubicacion":function(){
        var self = this;
        var webConfiguracionMapaEditView = new app.views.WebConfiguracionMapaEditView({
          model:self.model,
          lightbox: true,
        });
        var d = $("<div/>").append(webConfiguracionMapaEditView.el);
        crearLightboxHTML({
          "html":d,
          "width":800,
          "height":500,
        });
      },
    },

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));

      $(this.el).find("#web_configuracion_asuntos").select2({
        tags: true,
      });

      return this;
    },
        
    validar: function() {
      var self = this;
      try {
        $(".error").removeClass("error");

        if (self.$("#web_configuracion_asuntos").length > 0) {
          var c = self.$("#web_configuracion_asuntos").select2("val");
          if (c != null) this.model.set({ "asuntos_contacto":c.join(";;;") });
        }        

        return true;
      } catch(e) {
        return false;
      }
    },

    guardar: function() {
      var self = this;
      if (this.validar()) {
        this.model.save({},{
          success: function(model,response) {
            location.reload();
          }
        });
      }
    },    
  
  });

})(app.views, app.models);


// ============================================================
// CHAT

(function ( views, models ) {

  views.WebChatView = app.mixins.View.extend({

    template: _.template($("#web_chat_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "change #web_seo_habilitar_clienapp":function() {
        if (this.$("#web_seo_habilitar_clienapp").is(":checked")) {
          this.$(".clienapp_container").slideDown();
        } else {
          this.$(".clienapp_container").slideUp();
        }
      },      
    },

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
        
    validar: function() {
      var self = this;
      try {
        $(".error").removeClass("error");

        this.model.set({
          "habilitar_clienapp":(this.$("#web_seo_habilitar_clienapp").is(":checked")?1:0),
          "clienapp_formulario":(this.$("#web_seo_clienapp_formulario").is(":checked")?0:1),
          "clienapp_mostrar_email":(this.$("#web_seo_clienapp_mostrar_email").is(":checked")?1:0),
          "clienapp_abierto":(this.$("#web_seo_clienapp_abierto").is(":checked")?1:0),
          "clienapp_sonido":(this.$("#web_seo_clienapp_sonido").is(":checked")?1:0),
        });

        return true;
      } catch(e) {
        return false;
      }
    },

    guardar: function() {
      var self = this;
      if (this.validar()) {
        this.model.save({},{
          success: function(model,response) {
            location.reload();
          }
        });
      }
    },    
  
  });

})(app.views, app.models);

// ============================================================
// AVANZADA

(function ( views, models ) {

  views.WebAvanzadaView = app.mixins.View.extend({

    template: _.template($("#web_avanzada_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click #web_cotizaciones_agregar":"agregar_cotizacion",
      "click .web_cotizaciones_editar":"editar_cotizacion",
      "click .web_cotizaciones_eliminar":"eliminar_cotizacion",        
    },

    agregar_cotizacion: function() {
      // Controlamos los valores
      var anios = this.$("#web_anios").val();
      var taza = this.$("#web_taza").val();
      var texto = this.$("#cotizaciones_texto").val();

      if (anios == 0){
        alert ("Por favor ingrese la cantidad de años");
        this.$("#web_anios").focus();
        return false;
      }

      if (taza == 0) {
        alert ("Por favor ingrese el porcentaje de la taza anual");
        this.$("#web_taza").focus();
        return false;
      }

      if (this.id_valor == null) {
        var id = 0;
      } else {
        var id = this.id_valor;
        this.id_valor = null;
      }
      var edito = 0;
      if (this.edito_valor != null) {
        var edito = 1;
        this.edito_valor = null;
      }

      var tr = "<tr class=''>";
      tr+="<td class='anios'>"+anios+"</td>";
      tr+="<td class='taza'>"+taza+"</td>";
      tr+="<td class='texto'>"+texto+"</td>";
      tr+="<td><i class='fa fa-pencil cp web_cotizaciones_editar'></i></td>";
      tr+="<td><i class='fa fa-times web_cotizaciones_eliminar text-danger cp'></i></td>";
      tr+="</tr>";
      
      if (this.valor == null) {
        $("#web_cotizaciones tbody").append(tr);
      } else {
        $(this.valor).replaceWith(tr);
        this.valor = null;
      }
      this.$("#web_anios").val(0);
      this.$("#web_taza").val(0);
      this.$("#cotizaciones_texto").val("");
      this.$("#web_anios").focus();
    },
    eliminar_cotizacion: function(e){
      $(e.currentTarget).parents("tr").addClass('eliminado');
      $(e.currentTarget).parents("tr").hide();
    },
    editar_cotizacion: function(e) {
      this.valor = $(e.currentTarget).parents("tr");
      $("#web_taza").val($(this.valor).find(".taza").text());
      $("#web_anios").val($(this.valor).find(".anios").text());
      $("#cotizaciones_texto").val($(this.valor).find(".texto").text());
      this.edito_valor = $(this.valor).find(".edito").val();
      //$("articulo_ingrediente_nombre").focus();
    },      

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
        
    validar: function() {
      var self = this;
      try {
        $(".error").removeClass("error");
        if (this.$("#web_cotizaciones").length > 0) {
          if ($("#cotizaciones_maximo").val() == 0) {
            alert ("El valor maximo no puede ser 0");
            return false;
          }
          var cotizaciones = new Array();
          this.$("#web_cotizaciones tbody tr").each(function(i,e){
            var eliminado = $(e).hasClass('eliminado') ? 1 : 0;
            cotizaciones.push({
              "anios": $(e).find(".anios").text(),
              "taza": $(e).find(".taza").text(),
              "texto": $(e).find(".texto").text(),
              "eliminado": eliminado,
            });
          });
          this.model.set({"cotizaciones":cotizaciones});
        }
        return true;
      } catch(e) {
        return false;
      }
    },

    guardar: function() {
      var self = this;
      if (this.validar()) {
        this.model.save({},{
          success: function(model,response) {
            location.reload();
          }
        });
      }
    },    
  
  });

})(app.views, app.models);


// ============================================================
// DOMINIO

(function ( views, models ) {

  views.WebDominioView = app.mixins.View.extend({

    template: _.template($("#web_dominio_template").html()),

    myEvents: {
      "click .guardar": "guardar",
    },

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
        
    validar: function() {
      var self = this;
      try {
        validate_input("web_dominio",IS_EMPTY,"Por favor, ingrese un nombre de dominio.");
        $(".error").removeClass("error");

        return true;
      } catch(e) {
        return false;
      }
    },

    guardar: function() {
      var self = this;
      if (this.validar()) {
        var dominio = this.$("#web_dominio").val();
        $.ajax({
          "url":"empresas/function/guardar_dominio/",
          "dataType":"json",
          "type":"post",
          "data":{
            "dominio":dominio,
          },
          "success":function() {
            location.reload();
          }
        });
      }
    },    
  
  });

})(app.views, app.models);


// ============================================================
// CODIGOS DE SEGUIMIENTO

(function ( views, models ) {

  views.WebSeguimientoView = app.mixins.View.extend({

    template: _.template($("#web_seguimiento_template").html()),

    myEvents: {
      "click .guardar": "guardar",
    },

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
        
    validar: function() {
      var self = this;
      try {
        $(".error").removeClass("error");

        return true;
      } catch(e) {
        return false;
      }
    },

    guardar: function() {
      var self = this;
      if (this.validar()) {
        this.model.save({},{
          success: function(model,response) {
            location.reload();
          }
        });
      }
    },    
  
  });

})(app.views, app.models);




(function ( views, models ) {

  views.WebConfiguracionMapaEditView = app.mixins.View.extend({

    template: _.template($("#web_configuracion_mapa_edit_panel_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click .add_marker": function() {
        var centro = this.map.getCenter();
        if (centro.lat() == this.latitud_original && centro.lng() == this.longitud_original) {
          var centro = new google.maps.LatLng(this.coor.lat()+0.001,this.coor.lng()+0.001);
        }
        this.add_marker(centro.lat(),centro.lng());
      },
      "click #link_tab5":function() {
        var self = this;
        setTimeout(function(){
          if (self.map == undefined) self.render_map();
          google.maps.event.trigger(self.map, "resize");
          self.map.setCenter(self.coor);
        },100);
      },
    },

    initialize: function() {
      _.bindAll(this);
      this.render();
      this.latitud_original = -34.6156625;
      this.longitud_original = -58.5033598;
    },

    render: function()
    {
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      
      this.marcadores = new Array();
      this.total_marcadores = 0;
      try {
        loadGoogleMaps('3',API_KEY_GOOGLE_MAPS).done(self.render_map);
      } catch(e) {
        console.log(e);
        setTimeout(function(){
          self.render_map();
        },1000);
      }
      return this;
    },
    
    render_map: function() {
      var self = this;
      var zoom = parseInt(self.model.get("zoom"));
      var latitud = (self.model.get("latitud"));
      var longitud = (self.model.get("longitud"));
      if (latitud == 0) {
        var latitud = this.latitud_original;
        var longitud = this.longitud_original;
        zoom = 12;
      }
      self.coor = new google.maps.LatLng(latitud,longitud);
      var mapOptions = {
        "zoom": zoom,
        "center": self.coor
      }
      self.map = new google.maps.Map(document.getElementById("web_configuracion_mapa_contacto"), mapOptions);

      // Agregamos los marcadores en el mapa
      
      if (!isEmpty(self.model.get("posiciones"))) {
        var posiciones = self.model.get("posiciones").split("/");
        for(var i=0;i<posiciones.length;i++) {
          var pos = posiciones[i];
          var p = pos.split(";");
          self.add_marker(p[0],p[1]);
        }      
      }      
    },
    
    add_marker: function(latitud,longitud) {
      var self = this;
      var coord = new google.maps.LatLng(latitud,longitud);  
      var marker = new google.maps.Marker({
        position: coord,
        map: self.map,
        draggable:true,
        title:"Arrastralo a la direccion correcta"
      });
      marker.id = this.total_marcadores;
      google.maps.event.addListener(marker, "dblclick", function (e) { 
        if (confirm("Realmente desea eliminar el marcador?")) {
          self.marcadores = self.marcadores.filter(function(ee){
            return (ee.id != marker.id);
          });
          marker.setMap(null);
        }
      });
      this.marcadores.push(marker);
      this.total_marcadores++;
    },
  
    validar: function() {
      var self = this;
      try {
        // Coordenadas
        var a = new Array();
        for(var i=0;i<self.marcadores.length;i++) {
          var marker = self.marcadores[i];
          var pos = marker.getPosition();
          var latitud = (isNaN(pos.lat())) ? 0 : pos.lat();
          var longitud = (isNaN(pos.lng())) ? 0 : pos.lng();
          var c = latitud+";"+longitud;
          a.push(c);
        }
        var posiciones = a.join("/");
        
        var zoom = parseInt(self.map.getZoom());
        var pos = self.map.getCenter();
        var latitud = (isNaN(pos.lat())) ? 0 : pos.lat();
        var longitud = (isNaN(pos.lng())) ? 0 : pos.lng();
        this.model.set({
          "zoom":zoom,
          "latitud":latitud,
          "longitud":longitud,
          "posiciones":posiciones,
        });
        
        $(".error").removeClass("error");
        return true;
      } catch(e) {
        return false;
      }
    },

    guardar: function() {
      var self = this;
      if (this.validar()) {
        $(".modal").last().trigger("click");
      }
  },  
  });

})(app.views, app.models);


// -----------
//   MODELO
// -----------

(function ( models ) {

  models.Web_Slide = Backbone.Model.extend({
    urlRoot: "web_slider/",
    defaults: {
      activo: 1,
      nombre: "",
      path: "",
      path_2: "",
      color_fondo: ((typeof COLOR_FONDO_IMAGENES_DEFECTO != "undefined") ? COLOR_FONDO_IMAGENES_DEFECTO : "rgb(255,255,255)"),
      texto_1: "",
      linea_1: "",
      linea_2: "",
      linea_3: "",
      linea_4: "",
      linea_5: "",
      clave: "",
      texto_link_1: "",
      link_1: "",
      texto_link_2: "",
      link_2: "",
      invertir_colores_letras: 0,
      id_proyecto: ID_PROYECTO,
      linea_1_en:"",
      linea_2_en:"",
      linea_3_en:"",
      linea_4_en:"",
      linea_5_en:"",
      linea_1_pt:"",
      linea_2_pt:"",
      linea_3_pt:"",
      linea_4_pt:"",
      linea_5_pt:"",
      video: "",
      path_movil: "",
    }
  });
    
})( app.models );


// ----------------------
//   COLECCION PAGINADA
// ----------------------

(function (collections, model, paginator) {

  collections.Web_Slider = paginator.requestPager.extend({

    model: model,
    paginator_ui: {
      perPage: 9999,
    },
    paginator_core: {
      url: "web_slider/"
    }
    
  });

})( app.collections, app.models.Web_Slide, Backbone.Paginator);



// ------------------------------
//   VISTA DE ITEM DE LA TABLA
// ------------------------------

(function ( app ) {

  app.views.Web_SlideItem = Backbone.View.extend({
    template: _.template($('#web_slider_item').html()),
    tagName: "li",
    className: "list-group-item",
    events: {
      "click": "editar",
      "click .delete": "borrar",
      "click .duplicar": "duplicar"
    },
    initialize: function(options) {
      this.model.bind("change",this.render,this);
      this.model.bind("destroy",this.render,this);
      this.options = options;
      this.permiso = this.options.permiso;
      this.editor = (typeof this.options.editor === "undefined") ? false : this.options.editor;
      _.bindAll(this);
    },
    render: function()
    {
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var obj = {
        permiso: this.permiso,
        editor: this.editor,
      };
      // Extendemos el objeto creado con el modelo de datos
      $.extend(obj,this.model.toJSON());

      $(this.el).html(this.template(obj));
      return this;
    },
    editar: function() {
      if (this.editor) {
        var self = this;
        var slide = new app.views.Web_SlideEditView({
          model:self.model,
          permiso: 3,
          editor: true,
        });
        var d = $("<div/>").append(slide.el);
        crearLightboxHTML({
          "html":d,
          "width":800,
          "height":500,
        });
      }
      else location.href="app/#web_slider/"+this.model.id;
    },
    borrar: function(e) {
      e.stopPropagation();
      if (confirmar("Realmente desea eliminar este elemento?")) {
        var self = this;
        $.ajax({
          "url":"web_slider/function/eliminar/"+self.model.id,
          "dataType":"json",
          "success":function(res){
            if (res.error == 0) {
              $(self.el).remove();  // Lo eliminamos de la vista      
            } else {
              alert("Ocurrio un error al eliminar el slider.");
            }
          }
        });
      }
      return false;
    },
    duplicar: function(e) {
      e.stopPropagation();
      var clonado = this.model.clone();
      clonado.set({id:null}); // Ponemos el ID como NULL para que se cree un nuevo elemento
      clonado.save({},{
        success: function(model,response) {
          model.set({id:response.id});
        }
      });
      this.model.collection.add(clonado);
      return false;
    }
  });

})( app );



// ----------------------
//   VISTA DE LA TABLA
// ----------------------

(function ( app ) {

  app.views.Web_SliderTableView = app.mixins.View.extend({

    template: _.template($("#web_slider_panel_template").html()),
    myEvents: {
      "click .agregar":function() {
        var self = this;
        var slide = new app.views.Web_SlideEditView({
          model:new app.models.Web_Slide({
            clave: self.clave,
          }),
          permiso: 3,
          collection: self.collection,
          editor: true,
        });
        var d = $("<div/>").append(slide.el);
        crearLightboxHTML({
          "html":d,
          "width":800,
          "height":500,
        });
      },
    },

    initialize : function (options) {

      _.bindAll(this); // Para que this pueda ser utilizado en las funciones

      var lista = this.collection;
      this.options = options;
      this.permiso = this.options.permiso;
      this.clave = (typeof this.options.clave === "undefined") ? "" : this.options.clave;
      this.editor = (typeof this.options.editor === "undefined") ? false : this.options.editor;

      // Creamos la lista de paginacion
      var pagination = new app.mixins.PaginationView({
        collection: lista
      });

      // Creamos el buscador
      var search = new app.mixins.SearchView({
        collection: lista
      });
      lista.on('sync', this.addAll, this);
      
      // Renderizamos por primera vez la tabla:
      // ----------------------------------------
      var obj = { permiso: this.permiso, editor: this.editor };
      
      // Cargamos el template
      $(this.el).html(this.template(obj));
      // Cargamos el paginador
      $(this.el).find(".pagination_container").html(pagination.el);
      // Cargamos el buscador
      $(this.el).find(".search_container").html(search.el);

      // Vamos a buscar los elementos y lo paginamos
      lista.pager();
    },

    addAll : function () {
      $(this.el).find("tbody").empty();
      this.collection.each(this.addOne);
      this.ordenable();
    },

    addOne : function ( item ) {
      var view = new app.views.Web_SlideItem({
        model: item,
        permiso: this.permiso,
        collection: this.collection,
        editor: this.editor,
      });
      $(this.el).find("tbody").append(view.render().el);
    }

  });
})(app);


(function ( app ) {

  app.views.Web_SliderListaView = app.mixins.View.extend({

    template: _.template($("#web_slider_panel_template").html()),
    myEvents: {
      "click .agregar":function() {
        var self = this;
        var slide = new app.views.Web_SlideEditView({
          model:new app.models.Web_Slide({
            clave: self.clave,
          }),
          permiso: 3,
          collection: self.collection,
          editor: true,
        });
        var d = $("<div/>").append(slide.el);
        crearLightboxHTML({
          "html":d,
          "width":600,
          "height":500,
        });
      },
    },

    initialize : function (options) {

      _.bindAll(this); // Para que this pueda ser utilizado en las funciones

      var lista = this.collection;
      this.options = options;
      this.permiso = this.options.permiso;
      this.clave = (typeof this.options.clave === "undefined") ? "" : this.options.clave;
      this.editor = (typeof this.options.editor === "undefined") ? false : this.options.editor;

      lista.on('sync', this.addAll, this);

      // Renderizamos por primera vez la tabla:
      // ----------------------------------------
      var obj = { permiso: this.permiso, editor: this.editor };
      
      // Cargamos el template
      $(this.el).html(this.template(obj));
      lista.pager();
    },

    addAll : function () {
      $(this.el).find("#web_slider_table").empty();
      this.collection.each(this.addOne);
      this.ordenable();
    },

    addOne : function ( item ) {
      var view = new app.views.Web_SlideItem({
        model: item,
        permiso: this.permiso,
        collection: this.collection,
        editor: this.editor,
      });
      $(this.el).find("#web_slider_table").append(view.render().el);
    }

  });
})(app);


// -------------------------------
//   VISTA DEL PANEL DE EDICION
// -------------------------------
(function ( views, models ) {

  views.Web_SlideEditView = app.mixins.View.extend({

    template: _.template($("#web_slider_edit_panel_template").html()),
  
    myEvents: {
      "click .guardar": "guardar",
      "click .nuevo": "limpiar",
      "click .importar_articulos":"importar_articulos",
      "click .importar_propiedades":"importar_propiedades",
      "click .importar_entradas":"importar_entradas",
    },
    
    importar_articulos: function() {
      var self = this;
      var tabla = new app.views.ArticulosTableView({
        collection: new app.collections.Articulos(),
        habilitar_seleccion: true,
        permiso: 1
      });
      var d = $("<div/>").append(tabla.el);
      crearLightboxHTML({
        "html":d,
        "width":700,
        "height":350,
        "callback":function() {
          if (typeof window.articulo_seleccionado === "undefined") return;
          // Llenamos los campos
          var a = window.articulo_seleccionado;
          var dominio = DOMINIO+"/"+a.get("link");
          dominio = dominio.replace("//","/");
          self.$("#web_slider_link_1").val("http://"+dominio);
          if (TEMPLATE == "GreenHouse") {
            var l = a.get("nombre")+"\n";
            l+= a.get("precio_final_dto")+"\n";
            l+= a.get("precio_final")+"\n";
            if (a.get("porc_bonif") > 0) l+= a.get("porc_bonif")+"\n";
            self.$("#web_slider_linea_1").val(l);
            if (!isEmpty(a.get("path"))) {
              self.set_image("path","/admin/"+a.get("path"));  
            }
          } else {
            var l = a.get("nombre")+"\n";
            l+= a.get("rubro")+"\n";
            l+= "PRECIO FINAL "+(a.get("moneda") == "1" ? "$" : a.get("moneda"))+" "+a.get("precio_final_dto")+"\n";
            l+= a.get("breve")+"\n";
            if (a.get("porc_bonif") > 0) l+= a.get("porc_bonif")+"% OFF"+"\n";
            self.$("#web_slider_linea_1").val(l);
            if (!isEmpty(a.get("path"))) {
              self.set_image("path_2","/admin/"+a.get("path"));  
            }
          }
        }
      });
    },

    importar_propiedades: function() {
      var self = this;
      var tabla = new app.views.PropiedadesTableView({
        collection: propiedades,
        habilitar_seleccion: true,
        permiso: 1
      });
      propiedades.fetch();
      var d = $("<div/>").append(tabla.el);
      crearLightboxHTML({
        "html":d,
        "width":800,
        "height":350,
        "callback":function() {
          if (typeof window.propiedad_seleccionado === "undefined") return;
          // Llenamos los campos
          var a = window.propiedad_seleccionado;
          self.$("#web_slider_linea_1").val(a.get("nombre"));
          self.$("#web_slider_linea_2").val(a.get("descripcion"));
          if (a.get("precio_final") == 0) {
            self.$("#web_slider_linea_3").val("Consultar");
          } else {
            self.$("#web_slider_linea_3").val(a.get("moneda")+" "+a.get("precio_final"));
          }
          var dominio = DOMINIO+"/"+a.get("link");
          dominio = dominio.replace("//","/");
          self.$("#web_slider_link_1").val("http://"+dominio);
          self.$("#web_slider_texto_link_1").val("Más detalles");
          dominio = DOMINIO+"/contacto/";
          dominio = dominio.replace("//","/");
          self.$("#web_slider_link_2").val("http://"+DOMINIO+"contacto/");
          self.$("#web_slider_texto_link_2").val("Consultar");
          if (!isEmpty(a.get("path"))) self.set_image("path","/admin/"+a.get("path"));
        }
      });
    },

    importar_entradas: function() {
      var self = this;
      var tabla = new app.views.EntradasTableView({
        collection: new app.collections.Entradas(),
        habilitar_seleccion: true,
        permiso: 1
      });
      var d = $("<div/>").append(tabla.el);
      crearLightboxHTML({
        "html":d,
        "width":800,
        "height":350,
        "callback":function() {
          if (typeof window.entrada_seleccionado === "undefined") return;
          // Llenamos los campos
          var a = window.entrada_seleccionado;
          self.$("#web_slider_linea_1").val(a.get("titulo"));
          self.$("#web_slider_linea_2").val(a.get("subtitulo"));
          var dominio = DOMINIO+"/"+a.get("link");
          dominio = dominio.replace("//","/");
          self.$("#web_slider_link_1").val("http://"+dominio);
          self.$("#web_slider_texto_link_1").val("Más detalles");
          dominio = DOMINIO+"/contacto/";
          dominio = dominio.replace("//","/");
          self.$("#web_slider_link_2").val("http://"+DOMINIO+"contacto/");
          self.$("#web_slider_texto_link_2").val("Consultar");
          if (!isEmpty(a.get("path"))) self.set_image("path","/admin/"+a.get("path"));
        }
      });
    },    

    initialize: function(options) {
      this.model.bind("destroy",this.render,this);
      this.options = options;
      this.collection = (typeof this.options.collection === "undefined") ? null : this.options.collection;
      this.editor = (typeof this.options.editor === "undefined") ? false : this.options.editor;
      _.bindAll(this);
      this.render();
    },

    render: function()
    {
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var edicion = false;
      if (this.options.permiso > 1) edicion = true;
      var obj = { edicion: edicion, id:this.model.id, editor:this.editor };
      // Extendemos el objeto creado con el modelo de datos
      $.extend(obj,this.model.toJSON());
  
      $(this.el).html(this.template(obj));
      
      this.$(".color_fondo").colorpicker({
        format: "rgb"
      });

      return this;
    },

    validar: function() {
      var self = this;
      try {
        var color_fondo = this.$(".color_fondo").colorpicker('getValue');
        this.model.set({
          "color_fondo":color_fondo,
        });
        return true;        
      } catch(e) {
        return false;
      }
    },
    
    guardar: function() {
      var self = this;
      var es_nuevo = false;
      if (this.validar()) {
        //var cktext = CKEDITOR.instances['web_slider_texto_1'].getData();
        if (this.model.id == null) {
          this.model.set({id:0});
          es_nuevo = true;
        }        
        this.model.save({
            //"texto_1":cktext,
            "path":$("#hidden_path").val(),
            "path_movil":$("#hidden_path_movil").val(),
            "path_2":$("#hidden_path_2").val(),
            "texto_link_1":$("#web_slider_texto_link_1").val(),
            "texto_link_2":$("#web_slider_texto_link_2").val(),
            "link_1":$("#web_slider_link_1").val(),
            "link_2":$("#web_slider_link_2").val(),
            "linea_1":$("#web_slider_linea_1").val(),
            "linea_2":$("#web_slider_linea_2").val(),
            "linea_3":$("#web_slider_linea_3").val(),
            "linea_4":$("#web_slider_linea_4").val(),
            "linea_5":$("#web_slider_linea_5").val(),
            "linea_1_en":$("#web_slider_linea_1_en").val(),
            "linea_2_en":$("#web_slider_linea_2_en").val(),
            "linea_3_en":$("#web_slider_linea_3_en").val(),
            "linea_4_en":$("#web_slider_linea_4_en").val(),
            "linea_5_en":$("#web_slider_linea_5_en").val(),
            "linea_1_pt":$("#web_slider_linea_1_pt").val(),
            "linea_2_pt":$("#web_slider_linea_2_pt").val(),
            "linea_3_pt":$("#web_slider_linea_3_pt").val(),
            "linea_4_pt":$("#web_slider_linea_4_pt").val(),
            "linea_5_pt":$("#web_slider_linea_5_pt").val(),
            "video": (self.$("#hidden_video").length > 0) ? $(self.el).find("#hidden_video").val() : "",
          },{
          success: function(model,response) {
            if (self.editor) {
              if (es_nuevo) self.collection.add(self.model);
              $(".modal").last().trigger("click");
            } else location.href="app/#web_sliders";  
          }
        });        
      }
    },    
    
    limpiar : function() {
      this.model = new app.models.Web_Slide()
      this.render();
    },
    
  });

})(app.views, app.models);



// -------------------------------
//   VISTA DEL PANEL DE EDICION
// -------------------------------
(function ( views, models ) {

  views.WebConfiguracionEditView = app.mixins.View.extend({

    template: _.template($("#web_configuracion_edit_panel_template").html()),

    className: "h100p",

    myEvents: {
      "click .guardar": "guardar",
      "click .conf_structure":"render_style",

      "click .color_combination":function(e) {
        var com = $(e.currentTarget);
        var color1 = $(com).find("span:eq(0)").css("backgroundColor");
        var color2 = $(com).find("span:eq(1)").css("backgroundColor");
        var color3 = $(com).find("span:eq(2)").css("backgroundColor");
        var color4 = $(com).find("span:eq(2)").css("backgroundColor");
        var color5 = $(com).find("span:eq(2)").css("backgroundColor");
        var color6 = $(com).find("span:eq(2)").css("backgroundColor");
        this.$(".color_principal").colorpicker('setValue',color1);
        this.$(".color_secundario").colorpicker('setValue',color2);
        this.$(".color_terciario").colorpicker('setValue',color3);
        if (this.$(".color_4").length > 0) this.$(".color_4").colorpicker('setValue',color4);
        if (this.$(".color_5").length > 0) this.$(".color_5").colorpicker('setValue',color5);
        if (this.$(".color_6").length > 0) this.$(".color_6").colorpicker('setValue',color6);
      },
      "click .header-accordion":function(e) {
        var header = $(e.currentTarget);
        var info = header.next(".info-accordion");
        this.$(".info-accordion").not(info).slideUp();
        this.$(".header-accordion").not(header).removeClass("active");
        info.slideToggle();
        header.toggleClass("active");
      },  

      "change #web_configuracion_instagram":function(e) {
        var c = this.$("#web_configuracion_instagram").is(":checked");
        if (c) this.$("#web_configuracion_instagram_id_cont").show();
        else this.$("#web_configuracion_instagram_id_cont").hide();
      },
    },

    initialize: function() {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var self = this;

      $(this.el).html(this.template(this.model.toJSON()));
      
      $(this.el).find("#web_configuracion_asuntos").select2({
        tags: true,
      });
      
      this.render_sliders();
      this.render_sliders_2();
      if (typeof SLIDER_3 !== "undefined") this.render_sliders_3();
      if (typeof SLIDER_4 !== "undefined") this.render_sliders_4();

      //this.render_componentes();
      
      // Cuando se carga el IFRAME, agregamos un Style dentro del HEAD
      // que es el que vamos a utilizar para modificar el estilo
      this.$("#iframe").load(function(){
        var style = document.createElement('style');
          style.id = 'dynamic_content';
          style.type ='text/css';
        $(style).text(".editable:hover { cursor:pointer; outline: dashed 1px grey; }");
        self.$("#iframe").contents().find("head").append(style);
        
        // Capturamos el evento cuando se hace click sobre un elemento editable
        self.$("#iframe").contents().find(".editable").click(function(e){
          e.preventDefault();
          var id = $(e.currentTarget).data("id");
          var id_empresa = $(e.currentTarget).data("id_empresa");
          if (typeof id_empresa === "undefined") id_empresa = ID_EMPRESA;
          if (typeof id === "undefined") return;
          var clave = $(e.currentTarget).data("clave");
          var width = $(e.currentTarget).data("width");
          if (typeof width === "undefined") width = 256;
          var height = $(e.currentTarget).data("height");
          if (typeof height === "undefined") height = 256;
          var quality = $(e.currentTarget).data("quality");
          if (typeof quality === "undefined") quality = 0.9;
          var es_imagen = false;
          if ($(e.currentTarget).is("img")) es_imagen = true;
          else {
            if ($(e.currentTarget).hasClass("editable-img")) es_imagen = true;
          }

          // Cargamos el modelo
          var texto = new app.models.WebTexto({
            "id":id,
          });
          texto.fetch({
            "success":function() {

              texto.set({
                "clave":clave,
                "titulo":clave,
                "id_empresa":id_empresa,
                "id_web_template":ID_WEB_TEMPLATE,
              });

              // Abrimos la vista en un lightbox
              var textoEditView = new app.views.WebTextoEditView({
                "model":texto,
                "lightbox": true,
                "es_imagen": es_imagen,
                "width":width,
                "height":height,
                "quality":quality,
              });
              var d = $("<div/>").append(textoEditView.el);
              crearLightboxHTML({
                "html":d,
                "width":800,
                "height":500,
              });
              if (!es_imagen) {
                workspace.crear_editor('web_textos_texto',{
                  "toolbar":"Basic"
                });                
              }
            },
          });
        });
      });
      
      this.$(".color_fondo_imagenes_defecto").colorpicker({
        format: "rgba"
      });
      
      // COLOR PRINCIPAL
      this.$(".color_principal").colorpicker({
        "format": "rgb",
        "align": "left",
      }).on("changeColor",self.render_style);
      
      // COLOR SECUNDARIO
      this.$(".color_secundario").colorpicker({
        "format": "rgb",
        "align": "left",
      }).on("changeColor",self.render_style);
      
      // COLOR TERCIARIO
      this.$(".color_terciario").colorpicker({
        "format": "rgb",
        "align": "left",
      }).on("changeColor",self.render_style);

      if (this.$(".color_4").length > 0) {
        this.$(".color_4").colorpicker({
          "format": "rgb",
          "align": "left",
        }).on("changeColor",self.render_style);
      }

      if (this.$(".color_5").length > 0) {
        this.$(".color_5").colorpicker({
          "format": "rgb",
          "align": "left",
        }).on("changeColor",self.render_style);
      }

      if (this.$(".color_6").length > 0) {
        this.$(".color_6").colorpicker({
          "format": "rgb",
          "align": "left",
        }).on("changeColor",self.render_style);
      }

      // Abrimos el primer elemento
      this.$(".header-accordion").first().trigger("click");
      
      return this;
    },

    render_componentes: function() {
      if (this.$("#web_configuracion_componentes").length > 0) {
        var self = this;
        var coleccion = new app.collections.WebComponentes();
        var tabla = new app.views.WebComponentesListaView({
          collection: coleccion,
        });
        this.$("#web_configuracion_componentes").html(tabla.el);
      }
    },
    
    render_sliders: function() {
      var self = this;
      var coleccion = new app.collections.Web_Slider();
      coleccion.server_api = {
        clave: "slider_1",
      };      
      var tabla = new app.views.Web_SliderListaView({
        collection: coleccion,
        editor: true,
        permiso: 3,
        clave: "slider_1",
      });
      this.$("#web_configuracion_sliders").html(tabla.el);
    },

    render_sliders_2: function() {
      var self = this;
      var coleccion = new app.collections.Web_Slider();
      coleccion.server_api = {
        clave:"slider_2",
      };
      var tabla = new app.views.Web_SliderListaView({
        collection: coleccion,
        editor: true,
        permiso: 3,
        clave: "slider_2",
      });
      this.$("#web_configuracion_sliders_2").html(tabla.el);
    },   

    render_sliders_3: function() {
      var self = this;
      var coleccion = new app.collections.Web_Slider();
      coleccion.server_api = {
        clave:"slider_3",
      };
      var tabla = new app.views.Web_SliderListaView({
        collection: coleccion,
        editor: true,
        permiso: 3,
        clave: "slider_3",
      });
      this.$("#web_configuracion_sliders_3").html(tabla.el);
    },     

    render_sliders_4: function() {
      var self = this;
      var coleccion = new app.collections.Web_Slider();
      coleccion.server_api = {
        clave:"slider_4",
      };
      var tabla = new app.views.Web_SliderListaView({
        collection: coleccion,
        editor: true,
        permiso: 3,
        clave: "slider_4",
      });
      this.$("#web_configuracion_sliders_4").html(tabla.el);
    },     

    render_sliders_5: function() {
      var self = this;
      var coleccion = new app.collections.Web_Slider();
      coleccion.server_api = {
        clave:"slider_5",
      };
      var tabla = new app.views.Web_SliderListaView({
        collection: coleccion,
        editor: true,
        permiso: 3,
        clave: "slider_5",
      });
      this.$("#web_configuracion_sliders_5").html(tabla.el);
    },     
    
    render_style:function() {
      
      this.$("#iframe").contents().find("#dynamic_content").empty();
      var r = this.$("#web_configuracion_template_custom").text();
      
      var color_principal = this.$(".color_principal").colorpicker("getValue");
      var regexp = new RegExp("\{\{color_principal\}\}","g");
      r = r.replace(regexp,color_principal);
      
      var color_secundario = this.$(".color_secundario").colorpicker("getValue");
      var regexp = new RegExp("\{\{color_secundario\}\}","g");
      r = r.replace(regexp,color_secundario);
      
      var color_terciario = this.$(".color_terciario").colorpicker("getValue");
      var regexp = new RegExp("\{\{color_terciario\}\}","g");
      r = r.replace(regexp,color_terciario);

      if (this.$(".color_4").length > 0) {
        var color_4 = this.$(".color_4").colorpicker("getValue");
        var regexp = new RegExp("\{\{color_4\}\}","g");
        r = r.replace(regexp,color_4);
      }

      if (this.$(".color_5").length > 0) {
        var color_5 = this.$(".color_5").colorpicker("getValue");
        var regexp = new RegExp("\{\{color_5\}\}","g");
        r = r.replace(regexp,color_5);
      }

      if (this.$(".color_6").length > 0) {
        var color_6 = this.$(".color_6").colorpicker("getValue");
        var regexp = new RegExp("\{\{color_6\}\}","g");
        r = r.replace(regexp,color_6);
      }
      
      // Mostramos u ocultamos los elementos
      r+="#ultimos { display: "+($("#web_configuracion_ultimos_productos").is(":checked") ? "block":"none")+" }";
      r+="#destacados { display: "+($("#web_configuracion_productos_destacados").is(":checked") ? "block":"none")+" }";
      r+=".banners { display: "+($("#web_configuracion_banners").is(":checked") ? "block":"none")+" }";
      r+="#marcas { display: "+($("#web_configuracion_marcas").is(":checked") ? "block":"none")+" }";
      r+="#logos { display: "+($("#web_configuracion_logos_mercadopago").is(":checked") ? "block":"none")+" }";
      r+="#newsletter { display: "+($("#web_configuracion_newsletter").is(":checked") ? "block":"none")+" }";
      r+="#footer_grande { display: "+($("#web_configuracion_footer_grande").is(":checked") ? "block":"none")+" }";
      
      this.$("#iframe").contents().find("#dynamic_content").append(r);
    },

    validar: function() {
      var self = this;
      try {
      var color = this.$(".color_fondo_imagenes_defecto").colorpicker('getValue');
      var color_principal = this.$(".color_principal").colorpicker('getValue');
      var color_secundario = this.$(".color_secundario").colorpicker('getValue');
      var color_terciario = this.$(".color_terciario").colorpicker('getValue');

      if (self.$("#web_configuracion_asuntos").length > 0) {
        var c = self.$("#web_configuracion_asuntos").select2("val");
        if (c != null) this.model.set({ "asuntos_contacto":c.join(";;;") });
      }

      if (self.$("#web_configuracion_template_header").length > 0) {
        this.model.set({
          "template_header":self.$("#web_configuracion_template_header").val(),
        });
      }

      this.model.set({          
        //"archivo":$("#hidden_archivo").val(),
        "no_imagen":$("#hidden_no_imagen").val(),
        "marca_agua":$("#hidden_marca_agua").val(),
        "favicon":$("#hidden_favicon").val(),
        //"color_fondo_imagenes_defecto":color,
        "color_principal":color_principal,
        "color_secundario":color_secundario,
        "color_terciario":color_terciario,
        "logo_1":$("#hidden_logo_1").val(),
      });

      if (this.$(".color_4").length > 0) {
        var color_4 = this.$(".color_4").colorpicker('getValue');
        this.model.set({"color_4":color_4});
      }

      if (this.$(".color_5").length > 0) {
        var color_5 = this.$(".color_5").colorpicker('getValue');
        this.model.set({"color_5":color_5});
      }

      if (this.$(".color_6").length > 0) {
        var color_6 = this.$(".color_6").colorpicker('getValue');
        this.model.set({"color_6":color_6});
      }

      $(".error").removeClass("error");
      return true;
      } catch(e) {
      return false;
      }
    },

    guardar: function() 
    {
      var self = this;
      if (this.validar()) {
        this.model.save({},{
          success: function(model,response) {
            location.reload();
          }
        });
      }
  },  
  });

})(app.views, app.models);