(function ( views, models ) {

	views.Configuracion_menuSingleView = Backbone.View.extend({

		template: _.template($("#configuracion_menu_edit_template").html()),

    initialize: function() {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));

      // Dependiendo del modulo
      if (self.model.get("id_modulo") == "integraciones") {
        var conf = new app.models.WebConfiguracion({
          "id":ID_EMPRESA
        });
        conf.fetch({
          "success":function() {
            var view = new app.views.ConfiguracionIntegracionesView({
              model: conf,
            });
            self.$("#configuracion_content").html(view.el);
          },
        });

      } else if (self.model.get("id_modulo") == "datos") {
        var conf = new app.models.Empresas({
          "id":ID_EMPRESA
        });
        conf.fetch({
          "success":function() {
            var view = new app.views.ConfiguracionDatosView({
              model: conf,
            });
            self.$("#configuracion_content").html(view.el);
          },
        });        

      } else if (self.model.get("id_modulo") == "api") {

        var view = new app.views.ConfiguracionApiView({
          model: new app.models.AbstractModel(),
        });
        self.$("#configuracion_content").html(view.el);

      } else if (self.model.get("id_modulo") == "notificaciones") {
        var conf = new app.models.WebConfiguracion({
          "id":ID_EMPRESA
        });
        conf.fetch({
          "success":function() {
            var view = new app.views.ConfiguracionNotificacionesView({
              model: conf,
            });
            self.$("#configuracion_content").html(view.el);
          },
        });

      } else if (self.model.get("id_modulo") == "usuarios-perfiles") {

        var view = new app.views.ConfiguracionUsuariosView({
          model: new app.models.AbstractModel(),
        });
        self.$("#configuracion_content").html(view.el);

      } else if (self.model.get("id_modulo") == "emails_templates") {

        var view = new app.views.ConfiguracionEmailsView({
          model: new app.models.AbstractModel(),
        });
        self.$("#configuracion_content").html(view.el);

      } else if (self.model.get("id_modulo") == "usuarios") {

        var view = new app.views.UsuariosTableView({
          collection: usuarios,
        });    
        self.$("#configuracion_content").html(view.el);

      } else if (self.model.get("id_modulo") == "perfiles") {

        var view = new app.views.PerfilesTableView({
          collection: new app.collections.Perfiles(),
        });    
        self.$("#configuracion_content").html(view.el);

      }
      
      return this;
    },
        
	});

})(app.views, app.models);


// ============================================================
// INTEGRACIONES

(function ( views, models ) {

  views.ConfiguracionIntegracionesView = app.mixins.View.extend({

    template: _.template($("#configuracion_integraciones").html()),

    myEvents: {
      "click .guardar": "guardar",

      "click .sincronizacion_completa_articulos_meli":function() {
        workspace.esperar("Sincronizando...");
        $.ajax({
          "url":"articulos/function/sincronizacion_completa_meli/",
          "timeout":0,
          "dataType":"json",
          "success":function(r) {
            if (r.error == 0) {
              location.reload();
            } else if (r.error == 1) {
              $(".modal:last").trigger('click');
              alert("Hubo un error al sincronizar con la cuenta de MercadoLibre");
            }
          },
        });
      },

      "click .importacion_meli":function() {
        workspace.esperar("Sincronizando...");
        $.ajax({
          "url":"articulos_meli/function/obtener_publicaciones/",
          "timeout":0,
          "dataType":"json",
          "success":function(r) {
            if (r.error == 0) {
              location.reload();
            } else if (r.error == 1) {
              $(".modal:last").trigger('click');
              alert("Hubo un error al sincronizar con la cuenta de MercadoLibre");
            }
          },
        });
      },

      "click .borrar_sincro_meli":function() {
        $.ajax({
          "url":"web_configuracion/function/save_attribute/",
          "timeout":0,
          "dataType":"json",
          "type":"post",
          "data":{
            "attribute":"ml_access_token",
            "value":"",
          },
          "success":function() {
            window.location.reload();
          }
        })
      },
    },

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));

      if (this.$("#images_meli_tabla").length > 0) {
        this.listenTo(this.model, 'change_table', self.render_tabla_fotos);
        this.render_tabla_fotos();            
        $(this.el).find("#images_meli_tabla").sortable();
      }

      return this;
    },
        
    validar: function() {
      var self = this;
      try {
        $(".error").removeClass("error");

        // Listado de Imagenes
        if ($(this.el).find("#images_meli_tabla").length > 0) {
          var images_meli = new Array();
          $(this.el).find("#images_meli_tabla .list-group-item .filename").each(function(i,e){
            images_meli.push($(e).text());
          });
          this.model.set({
            "images_meli":images_meli,  
          });        
        }

        if (this.$("#web_seo_tokko_enviar_consultas").length > 0) {
          this.model.set({
            "tokko_enviar_consultas":(self.$("#web_seo_tokko_enviar_consultas").is(":checked") ? 1 : 0),
            "tokko_importacion":(self.$("#web_seo_tokko_importacion").is(":checked") ? 1 : 0),
          });
        }
        return true;
      } catch(e) {
        return false;
      }
    },

    render_tabla_fotos: function() {
      var images_meli = this.model.get("images_meli");
      this.$("#images_meli_tabla").empty();
      if (images_meli.length == 0) {
        this.$("#images_meli_container").removeClass('tiene');
      } else {
        this.$("#images_meli_container").addClass('tiene');
        for(var i=0;i<images_meli.length;i++) {
          var path = images_meli[i];
          var pth = path+"?t="+parseInt(Math.random()*100000);
          var li = "";
          li+="<li class='list-group-item'>";
          li+=" <span><i class='fa fa-sort text-muted fa m-r-sm'></i> </span>";
          li+=" <img style='margin-left: 10px; margin-right:10px; max-height:50px' class='img_preview' src='"+pth+"'/>";
          li+=" <span class='filename'>"+path+"</span>";
          li+=" <span class='cp pull-right m-t eliminar_foto' data-property='images_meli'><i class='fa fa-fw fa-times'></i> </span>";
          li+=" <span data-id='images_meli' class='cp m-r pull-right m-t editar_foto_multiple'><i class='fa fa-pencil'></i> </span>";
          li+="</li>";
          this.$("#images_meli_tabla").append(li);
        }                
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
// API

(function ( views, models ) {

  views.ConfiguracionApiView = app.mixins.View.extend({

    template: _.template($("#configuracion_api").html()),

    myEvents: {
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
        
  });

})(app.views, app.models);


// ============================================================
// NOTIFICACIONES

(function ( views, models ) {

  views.ConfiguracionNotificacionesView = app.mixins.View.extend({

    template: _.template($("#configuracion_notificaciones").html()),

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

      if (control.check("emails_templates") > 0) {
        new app.mixins.Select({
          modelClass: app.models.EmailTemplate,
          url: "emails_templates/",
          render: "#web_seo_email_carrito_abandonado",
          firstOptions: ["<option value='0'>Seleccione una plantilla</option>"],
          selected: self.model.get("id_email_carrito_abandonado"),
          onComplete:function(c) {
            crear_select2("web_seo_email_carrito_abandonado");
          },
        });
        new app.mixins.Select({
          modelClass: app.models.EmailTemplate,
          url: "emails_templates/",
          render: "#web_seo_id_email_post_compra",
          firstOptions: ["<option value='0'>Seleccione una plantilla</option>"],
          selected: self.model.get("id_email_post_compra"),
          onComplete:function(c) {
            crear_select2("web_seo_id_email_post_compra");
          },
        });  
        new app.mixins.Select({
          modelClass: app.models.EmailTemplate,
          url: "emails_templates/",
          render: "#web_seo_id_email_registro",
          firstOptions: ["<option value='0'>Seleccione una plantilla</option>"],
          selected: self.model.get("id_email_registro"),
          onComplete:function(c) {
            crear_select2("web_seo_id_email_registro");
          },
        });  
      }
      return this;
    },
        
    validar: function() {
      var self = this;
      try {
        $(".error").removeClass("error");

        if (control.check("emails_templates")) { 
          this.model.set({
            "id_email_carrito_abandonado":self.$("#web_seo_email_carrito_abandonado").val(),
            "id_email_post_compra":self.$("#web_seo_id_email_post_compra").val(),
            "id_email_registro":self.$("#web_seo_id_email_registro").val(),
          });
        }

        if (this.$("#crm_notificar_asignaciones_usuarios").length > 0) {
          this.model.set({
            "crm_notificar_asignaciones_usuarios":(this.$("#crm_notificar_asignaciones_usuarios").is(":checked")?1:0),
            "crm_notificar_tareas":(this.$("#crm_notificar_tareas").is(":checked")?1:0),
          });
        }

        if (this.$("#crm_enviar_emails_usuarios").length > 0) {
          // Diferencia si se quiere enviar un email de una consulta al email de la empresa
          // o si a los usuarios asignados a la propiedad
          this.model.set({
            "crm_enviar_emails_usuarios":(this.$("#crm_enviar_emails_usuarios").val()),
          });
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
// DATOS DE LA INMOBILIARIA

(function ( views, models ) {

  views.ConfiguracionDatosView = app.mixins.View.extend({

    template: _.template($("#configuracion_datos").html()),

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
      this.$("#empresas_cuit").mask("99-99999999-9");    
      return this;
    },
        
    validar: function() {
      var self = this;
      try {
        this.model.set({
          "logo":$("#hidden_logo").val(),
          "path":$("#hidden_path").val(),
          "id_tipo_contribuyente":self.$("#empresas_tipo_contribuyente").val(),
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
// USUARIOS Y PERFILES

(function ( views, models ) {

  views.ConfiguracionUsuariosView = app.mixins.View.extend({

    template: _.template($("#configuracion_usuarios").html()),

    myEvents: {
    },

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));

      var usuariosView = new app.views.UsuariosTableView({
        collection: new app.collections.Usuarios(),
      });
      this.$("#usuarios_container").html(usuariosView.el);

      var perfilesView = new app.views.PerfilesTableView({
        collection: new app.collections.Perfiles(),
      });
      this.$("#perfiles_container").html(perfilesView.el);

      return this;
    },
        
  });

})(app.views, app.models);