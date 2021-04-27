(function ( models ) {

  models.EmailTemplate = Backbone.Model.extend({
    urlRoot: "emails_templates/",
    defaults: {
      nombre: "",
      texto: "",
      clave: "",
      id_empresa: ID_EMPRESA,
    }
  });
      
})( app.models );


(function (collections, model, paginator) {

  collections.EmailsTemplates = paginator.requestPager.extend({
    model: model,
    paginator_core: {
      url: "emails_templates/"
    },
  });

})( app.collections, app.models.EmailTemplate, Backbone.Paginator);


(function ( app ) {

  app.views.EmailTemplateItem = Backbone.View.extend({
    tagName: "tr",
    attributes: function() {
      return {
        id: this.model.id // Es necesario hacer esto para reordenar
      }
    },
    template: _.template($('#emails_templates_item').html()),
    events: {
      "click .edit": "editar",
      "click .delete": "borrar",
      "click .notificar": "notificar",
      "click .duplicar": "duplicar"
    },
    initialize: function(options) {
      this.model.bind("change",this.render,this);
      this.model.bind("destroy",this.render,this);
      this.options = options;
      this.permiso = this.options.permiso;
      this.habilitar_seleccion = (typeof options.habilitar_seleccion != "undefined") ? options.habilitar_seleccion : false;
      _.bindAll(this);
    },
    render: function()
    {
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var obj = { 
        permiso: this.permiso,
        seleccion: this.habilitar_seleccion,
      };
      // Extendemos el objeto creado con el modelo de datos
      $.extend(obj,this.model.toJSON());

      $(this.el).html(this.template(obj));
      return this;
    },
    editar: function() {
      var template = new app.models.EmailTemplate({ "id": this.model.id });
      template.fetch({
        "success":function() {
          var view = new app.views.EmailTemplateEditView({
            model: template,
            lightbox: 1,
          });
          crearLightboxHTML({
            "html":view.el,
            "width":700,
            "height":500,
          });
          workspace.crear_editor("emails_templates_texto");
        }
      });
    },
    borrar: function(e) {
      if (confirmar("Realmente desea eliminar este elemento?")) {
        this.model.destroy();  // Eliminamos el modelo
        $(this.el).remove();  // Lo eliminamos de la vista
      }
      e.stopPropagation();
    },
    notificar: function() {
      var self = this;
      $.ajax({
        "url":"emails_templates/function/enviar_plantilla/",
        "dataType":"json",
        "data":{
          "id_email_template":self.model.id,
        },
        "type":"post",
        "timeout":0,
        "dataType":"json",
        "success":function(r) {
          if (r.error == 0) {
            alert("Proceso terminado. Se han enviado "+r.cantidad+" emails.");
            location.reload();
          }
          else alert(r.mensaje);
        },
      });
    },
    duplicar: function(e) {
      var clonado = this.model.clone();
      clonado.set({id:null}); // Ponemos el ID como NULL para que se cree un nuevo elemento
      clonado.save({},{
        success: function(model,response) {
          model.set({id:response.id});
        }
      });
      this.model.collection.add(clonado);
      e.stopPropagation();
    }
  });

})( app );



// ----------------------
//   VISTA DE LA TABLA
// ----------------------

(function ( app ) {

  app.views.EmailsTemplatesTableView = app.mixins.View.extend({

    template: _.template($("#emails_templates_panel_template").html()),
    events: {
      "click .nuevo": "nuevo_template",
    },
    initialize : function (options) {

      _.bindAll(this); // Para que this pueda ser utilizado en las funciones

      var lista = this.collection;
      this.options = options;
      this.permiso = this.options.permiso;
      this.habilitar_seleccion = (typeof options.habilitar_seleccion != "undefined") ? options.habilitar_seleccion : false;

      // Creamos la lista de email_templatecion
      var pagination = new app.mixins.PaginationView({
        collection: lista
      });

      // Creamos el buscador
      var search = new app.mixins.SearchView({
        collection: lista
      });

      this.collection.on('sync', this.addAll, this);
      
      // Renderizamos por primera vez la tabla:
      // ----------------------------------------
      var obj = { 
        permiso: this.permiso,
        seleccion: this.habilitar_seleccion,
      };
      
      // Cargamos el template
      $(this.el).html(this.template(obj));
      // Cargamos el email_templatedor
      $(this.el).find(".pagination_container").html(pagination.el);
      // Cargamos el buscador
      $(this.el).find(".search_container").html(search.el);

      // Vamos a buscar los elementos y lo email_templatemos
      lista.pager();
    },

    addAll : function () {
      $(this.el).find("tbody").empty();
      this.collection.each(this.addOne);
    },

    addOne : function ( item ) {
      var self = this;
      var view = new app.views.EmailTemplateItem({
        model: item,
        permiso: this.permiso,
        habilitar_seleccion: self.habilitar_seleccion,
      });
      $(this.el).find("tbody").append(view.render().el);
    },

    nuevo_template: function(){
      var template = new app.models.EmailTemplate();
      var view = new app.views.EmailTemplateEditView({
        model: template,
        lightbox: 1,
      });
      crearLightboxHTML({
        "html":view.el,
        "width":700,
        "height":500,
      });
      workspace.crear_editor("emails_templates_texto");
    },

  });
})(app);



// -------------------------------
//   VISTA DEL PANEL DE EDICION
// -------------------------------
(function ( views, models ) {

  views.EmailTemplateEditView = app.mixins.View.extend({

    template: _.template($("#emails_templates_edit_panel_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click .nuevo": "limpiar",
    },

    initialize: function(options) {
      this.model.bind("destroy",this.render,this);
      this.options = options;
      _.bindAll(this);
      this.render();
    },

    render: function() {
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var self = this;
      var edicion = false;
      if (this.options.permiso > 1) edicion = true;
      this.lightbox = (typeof this.options.lightbox != "undefined") ? this.options.lightbox : false;
      var obj = { "edicion": edicion, id:this.model.id, "lightbox":this.lightbox };
      console.log(obj);
      $.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));
      return this;
    },

    validar: function() {
      var self = this;
      try {
        // Validamos los campos que sean necesarios
        if (!this.lightbox) {
          validate_input("emails_templates_nombre",IS_EMPTY,"Por favor, ingrese un nombre.");
          var id_web_template = $("#emails_templates_templates").val();
          this.model.set({
            "id_web_template":id_web_template,
          });
        }
        if (this.model.id == null) {
          this.model.set({id:0});
        }
        return true;                
      } catch(e) {
        return false;
      }
    },
        
    guardar: function() {
      var self = this;
      if (this.validar()) {
        var cktext = CKEDITOR.instances['emails_templates_texto'].getData();
        this.model.save({
            "texto":cktext,
          },{
          success: function(model,response) {
            if (self.lightbox) location.reload();
            else location.href="app/#emails_templates";
          }
        });                 
      }
    },
        
    limpiar : function() {
      this.model = new app.models.EmailTemplate();
      this.render();
    },
    
  });

})(app.views, app.models);

// ============================================================
// USUARIOS Y PERFILES

(function ( views, models ) {

  views.ConfiguracionEmailsView = app.mixins.View.extend({

    template: _.template($("#configuracion_emails").html()),

    myEvents: {
    },

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));

      var usuariosView = new app.views.EmailsTemplatesTableView({
        collection: new app.collections.EmailsTemplates(),
      });
      this.$("#emails_container").html(usuariosView.el);

      return this;
    },
        
  });

})(app.views, app.models);