// -----------
//   MODELO
// -----------

(function ( models ) {

  models.Novedades = Backbone.Model.extend({
    urlRoot: "novedades/",
    defaults: {
      path: "",
      titulo: "",
    }
  });
    
})( app.models );



(function (collections, model, paginator) {
  collections.Novedades = paginator.requestPager.extend({
    model: model,
    paginator_core: {
      url: "novedades/"
    }
  });
})( app.collections, app.models.Novedades, Backbone.Paginator);


// ------------------------------
//   VISTA DE ITEM DE LA TABLA
// ------------------------------

(function ( app ) {

  app.views.NovedadesItem = Backbone.View.extend({
    tagName: "tr",
    template: _.template($('#novedades_item').html()),
      events: {
    "click": "editar",
    "click .ver": "editar",
    "click .delete": "borrar",
    "click .duplicar": "duplicar"
    },
    initialize: function(options) {
      // Si el modelo cambia, debemos renderizar devuelta el elemento
      this.model.bind("change",this.render,this);
      this.model.bind("destroy",this.render,this);
      this.options = options;
      this.permiso = this.options.permiso;
      _.bindAll(this);
    },
    render: function()
    {
    // Creamos un objeto para agregarle las otras propiedades que no son el modelo
    var obj = {
      permiso: this.permiso,
      id: this.model.id
    };
    // Extendemos el objeto creado con el modelo de datos
    $.extend(obj,this.model.toJSON());

      $(this.el).html(this.template(obj));
      return this;
    },
    editar: function() {
      location.href="app/#novedad/"+this.model.id;
    },
    borrar: function(e) {
      if (confirmar("Realmente desea eliminar este elemento?")) {
        this.model.destroy(); // Eliminamos el modelo
        $(this.el).remove();  // Lo eliminamos de la vista
      }
      e.stopPropagation();
    },
  });

})( app );



// ----------------------
//   VISTA DE LA TABLA
// ----------------------

(function ( app ) {

  app.views.NovedadesTableView = Backbone.View.extend({

    template: _.template($("#novedades_table").html()),

  initialize : function (options) {

    _.bindAll(this); // Para que this pueda ser utilizado en las funciones

    var lista = this.collection;

    // Guardamos las referencias
    this.options = options;
    this.permiso = this.options.permiso;

    // Creamos la lista de paginacion
    var pagination = new app.mixins.PaginationView({
      collection: lista,
    });

    // Creamos el buscador
    var search = new app.mixins.SearchView({
      collection: lista
    });

    lista.on('add', this.addOne, this);
    lista.on('pager', this.addAll, this);
    lista.on('all', this.render, this);
    
    // Renderizamos por primera vez la tabla:
    // ----------------------------------------
    var obj = { permiso: this.permiso };
    
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
  },

  addOne : function ( item ) {
    var view = new app.views.NovedadesItem({
      model: item,
      permiso: this.permiso,
    });
    $(this.el).find("tbody").append(view.render().el);
  }

  });
})(app);



// -------------------------------
//   VISTA DEL PANEL DE EDICION
// -------------------------------
(function ( views, models ) {

  views.NovedadesEditView = app.mixins.View.extend({

    template: _.template($("#novedades_edit").html()),
  
    myEvents: {
      "click .guardar": "guardar",
      "click .limpiar": "limpiar",
    },

    initialize: function(options) {
      this.model.bind("destroy",this.render,this);
      this.bind("limpiar",this.limpiar,this); // Limpiamos el objeto
      _.bindAll(this);
      this.options = options;
      this.render();
    },

    render: function() {
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var edicion = false;
      if (this.options.permiso > 1) edicion = true;
      var obj = { edicion: edicion, id: this.model.id };
      // Extendemos el objeto creado con el modelo de datos
      $.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));
      
      return this;
    },

    validar: function() {
      try {
        var self = this;       
        // No hay ningun error

        this.model.set({
          "path": $("#hidden_path").val(),
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
        if (this.model.id == null || this.model.id == 0) {
          this.model.set({id:0});
        }
        this.model.save({},{
          success: function(model,response) { 
            location.href="app/#novedades";
          }
        });
      }
    },
    
    limpiar : function() {
      this.model = new app.models.Novedades()
      this.render();
    },    
  });

})(app.views, app.models);
