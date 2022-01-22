(function ( models ) {

  models.Marca = Backbone.Model.extend({
    urlRoot: "marcas/",
    defaults: {
      nombre: "",
      path: "",
      link: "",
      activo: 1,
      orden: 0,
      descuento: 0,
      grupo: 0,
    }
  });

})( app.models );


(function (collections, model, paginator) {
  collections.Marcas = paginator.requestPager.extend({
    model: model,
    paginator_core: {
      url: "marcas/"
    }
  });
})( app.collections, app.models.Marca, Backbone.Paginator);


(function ( app ) {
  app.views.MarcaItem = app.mixins.View.extend({
    tagName: "tr",
    template: _.template($('#marcas_item').html()),
    myEvents: {
      "click .ver": "editar",
      "click .delete": "borrar",
      "click .duplicar": "duplicar",
      "click .activo":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        var activo = this.model.get("activo");
        activo = (activo == 1)?0:1;
        self.model.set({"activo":activo});
        this.change_property({
          "table":"marcas",
          "attribute":"activo",
          "value":activo,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
    },
    initialize: function(options) {
      this.model.bind("change",this.render,this);
      this.model.bind("destroy",this.render,this);
      this.view = options.view;
      this.options = options;
      this.permiso = control.check("marcas");
      _.bindAll(this);
    },
    render: function() {
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var obj = { permiso: this.permiso };
      // Extendemos el objeto creado con el modelo de datos
      $.extend(obj,this.model.toJSON());

      $(this.el).html(this.template(obj));
      return this;
    },
    editar: function() {
      // Cuando editamos un elemento, indicamos a la vista que lo cargue en los campos
      var self = this;
      var modelo = new app.models.Marca({"id":self.model.id});
      modelo.fetch({
        "success":function(){
          var that = self;
          var v = new app.views.MarcaEditView({
            model: modelo,
            view: self.view,
            lightbox: true,
          });
          crearLightboxHTML({
            "html":v.el,
            "width":800,
            "height":400,
            "callback":function() {
              that.view.buscar();
            }            
          });
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

  app.views.MarcasTableView = app.mixins.View.extend({

   template: _.template($("#marcas_panel_template").html()),

    myEvents: {
      "click .nuevo":"nuevo",
    },

    "nuevo":function(){
      var self = this;
      var v = new app.views.MarcaEditView({
        model: new app.models.Marca(),
        view: self,
        lightbox: true,
      });
      crearLightboxHTML({
        "html":v.el,
        "width":800,
        "height":400,
        "callback":function() {
          self.buscar();
        }
      });
    },

   initialize : function (options) {

      _.bindAll(this); // Para que this pueda ser utilizado en las funciones

      var lista = this.collection;
      this.options = options;
      this.permiso = control.check("marcas");

      // Creamos la lista de paginacion
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
      var obj = { permiso: this.permiso };
      
      // Cargamos el template
      $(this.el).html(this.template(obj));
      // Cargamos el paginador
      $(this.el).find(".pagination_container").html(pagination.el);
      // Cargamos el buscador
      $(this.el).find(".search_container").html(search.el);

      // Vamos a buscar los elementos y lo paginamos
      this.buscar();
    },

    buscar: function() {
      this.collection.pager();
    },

    addAll : function () {
      $(this.el).find("tbody").empty();
      this.collection.each(this.addOne);
    },

    addOne : function ( item ) {
      var self = this;
      var view = new app.views.MarcaItem({
        model: item,
        permiso: this.permiso,
        view: self,
      });
      $(this.el).find("tbody").append(view.render().el);
    }

  });
})(app);



// -------------------------------
//   VISTA DEL PANEL DE EDICION
// -------------------------------
(function ( views, models ) {

  views.MarcaEditView = app.mixins.View.extend({

    template: _.template($("#marcas_edit_panel_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click .nuevo": "limpiar",
    },

    initialize: function(options) {
      this.model.bind("destroy",this.render,this);
      _.bindAll(this);
      this.options = options;
      this.render();
    },

    render: function() {
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var edicion = false;
      if (control.check("marcas") > 1) edicion = true;
      var obj = { edicion: edicion, id:this.model.id };
      // Extendemos el objeto creado con el modelo de datos
      $.extend(obj,this.model.toJSON());

      $(this.el).html(this.template(obj));

      return this;
    },

    validar: function() {
      try {
        // Validamos los campos que sean necesarios
        validate_input("marcas_nombre",IS_EMPTY,"Por favor, ingrese un nombre.");
        // No hay ningun error
        $(".error").removeClass("error");
        return true;
      } catch(e) {
        return false;
      }
    },

    guardar: function() {
      var self = this;
      if (this.validar()) {
        if (this.model.id == null) {
          this.model.set({id:0});
        }
        this.model.save({
          "id_empresa":ID_EMPRESA,
          "path":$("#hidden_path").val(),
        },{
          success: function(model,response) {
            location.href="app/#marcas";
          }
        });
      }
    },

    limpiar : function() {
      this.model = new app.models.Marca()
      this.render();
    },

  });

})(app.views, app.models);