(function ( models ) {

  models.MenuAlquileres = Backbone.Model.extend({
    urlRoot: "menu_alquileres/",
    defaults: {
      id: ID_EMPRESA,
      comision_inmobiliaria: 0,
      id_empresa: ID_EMPRESA,
    }
  });
      
})( app.models );


(function ( views, models ) {

  views.MenuAlquileresEditView = app.mixins.View.extend({

    template: _.template($("#menu_alquileres_edit_panel_template").html()),

    myEvents: {
      "click .guardar": "guardar",
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
        this.model.save({
          },{
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

  views.ConfiguracionMenuAlquileres = app.mixins.View.extend({

    template: _.template($("#configuracion_alquileres").html()),

    myEvents: {
    },

    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));

      var alquileres = new app.models.MenuAlquileres({ "id": ID_EMPRESA });
      alquileres.fetch({
        "success":function() {
          view = new app.views.MenuAlquileresEditView({
            model: alquileres,
            permiso: 3
          });
          this.$("#alquileres_container").html(view.el);
        }
      });


      return this;
    },
        
  });

})(app.views, app.models);