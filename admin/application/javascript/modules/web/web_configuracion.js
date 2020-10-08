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

// ============================================================
// AVANZADA

(function ( views, models ) {

  views.WebAvanzadaView = app.mixins.View.extend({

    template: _.template($("#web_avanzada_template").html()),

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