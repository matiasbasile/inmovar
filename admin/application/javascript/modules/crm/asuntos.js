(function ( models ) {

  models.Asunto = Backbone.Model.extend({
    urlRoot: "asuntos/",
    defaults: {
      nombre: "",
      color: "",
      activo: 1,
      orden: 0,
      id_empresa: ID_EMPRESA,
    }
  });

})( app.models );


(function (collections, model, paginator) {
  collections.Asuntos = paginator.requestPager.extend({
    model: model,
    paginator_core: {
      url: "asuntos/"
    }
  });
})( app.collections, app.models.Asunto, Backbone.Paginator);


(function ( app ) {
  app.views.AsuntoItem = Backbone.View.extend({
    tagName: "tr",
    template: _.template($('#asuntos_item').html()),
    events: {
      "click .ver": "editar",
      "click .delete": "borrar",
      "click .duplicar": "duplicar"
    },
    initialize: function(options) {
      this.model.bind("change",this.render,this);
      this.model.bind("destroy",this.render,this);
      this.options = options;
      _.bindAll(this);
    },
    render: function() {
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
    editar: function() {
      // Cuando editamos un elemento, indicamos a la vista que lo cargue en los campos
      location.href="app/#asunto/"+this.model.id;
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

  app.views.AsuntosTableView = app.mixins.View.extend({

   template: _.template($("#asuntos_panel_template").html()),

   initialize : function (options) {

      _.bindAll(this); // Para que this pueda ser utilizado en las funciones

      var lista = this.collection;
      this.options = options;

      // Creamos la lista de paginacion
      var pagination = new app.mixins.PaginationView({
        collection: lista
      });

      // Creamos el buscador
      var search = new app.mixins.SearchView({
        collection: lista
      });

      this.collection.on('sync', this.addAll, this);

      $(this.el).html(this.template());
      $(this.el).find(".pagination_container").html(pagination.el);
      $(this.el).find(".search_container").html(search.el);
      lista.pager();
    },

    addAll : function () {
      $(this.el).find("tbody").empty();
      this.collection.each(this.addOne);
    },

    addOne : function ( item ) {
      var view = new app.views.AsuntoItem({
        model: item,
      });
      $(this.el).find("tbody").append(view.render().el);
    }

  });
})(app);



// -------------------------------
//   VISTA DEL PANEL DE EDICION
// -------------------------------
(function ( views, models ) {

  views.AsuntoEditView = app.mixins.View.extend({

    template: _.template($("#asuntos_edit_panel_template").html()),

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
      var obj = { id:this.model.id };
      $.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));
      return this;
    },

    validar: function() {
      try {
        // Validamos los campos que sean necesarios
        validate_input("asuntos_nombre",IS_EMPTY,"Por favor, ingrese un nombre.");
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
        },{
          success: function(model,response) {
            location.href="app/#asuntos";
          }
        });
      }
    },

    limpiar : function() {
      this.model = new app.models.Asunto();
      this.render();
    },

  });

})(app.views, app.models);



// -------------------------------
//   VISTA DEL PANEL DE EDICION
// -------------------------------
(function ( views, models ) {

  views.AsuntoMiniEditView = app.mixins.View.extend({

    template: _.template($("#asuntos_edit_mini_panel_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click .cerrar": "cerrar",
      "keypress .tab":function(e) {
        if (e.keyCode == 13) {
          e.preventDefault();
          $(e.currentTarget).parent().next().find(".tab").focus();
        }
      },
      "keyup .tab":function(e) {
        if (e.which == 27) this.cerrar();
      },
      "keypress .guardar":function(e) {
        if (e.keyCode == 13) this.guardar();
      },
    },

    initialize: function(options) {
      this.options = options;
      this.input = this.options.input;
      this.onSave = this.options.onSave;
      this.callback = this.options.callback;

      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      var obj = { id:this.model.id };
      $.extend(obj,this.model.toJSON());

      $(this.el).html(this.template(obj));

      if (this.input != undefined) {
        // Seteamos lo que tiene el input de referencia
        $(this.el).find("#asuntos_mini_nombre").val($(this.input).val().trim());
      }

      return this;
    },

    focus: function() {
      $(this.el).find("#asuntos_mini_nombre").focus();
    },

    validar: function() {
      var self = this;
      try {
        validate_input("asuntos_mini_nombre",IS_EMPTY,"Por favor, ingrese un nombre.");
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
          "nombre":$("#asuntos_mini_nombre").val(),
          "color": "", // COLOR POR DEFECTO
          "activo":1,
        },{
          success: function(model,response) {
            if (response.error == 1) {
              show(response.mensaje);
            } else {
              if (typeof self.onSave != "undefined") self.onSave(model);
              if (typeof self.callback != "undefined") self.callback(model.id);
              self.cerrar();
            }
          }
        });
      }
    },

    cerrar: function() {
      $(this.el).parents(".customcomplete").remove();
    },

  });

})(app.views, app.models);
