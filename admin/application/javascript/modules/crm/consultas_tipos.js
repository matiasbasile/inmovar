(function ( models ) {

  models.Consultatipo = Backbone.Model.extend({
    urlRoot: "consultas_tipos/",
    defaults: {
      nombre: "",
      color: "",
      orden: 0,
      id_empresa: ID_EMPRESA,
      activo: 1,
      id_email_template: 0,
      tiempo_abandonado: 30,
      tiempo_vencimiento: 7,
      id_proximo_estado: -1,
    }
  });

})( app.models );


(function (collections, model, paginator) {
  collections.Consultastipos = paginator.requestPager.extend({
    model: model,
    paginator_core: {
      url: "consultas_tipos/"
    }
  });
})( app.collections, app.models.Consultatipo, Backbone.Paginator);


(function ( app ) {

  app.views.ConsultastiposTableView = app.mixins.View.extend({

    template: _.template($("#consultas_tipos_tree_panel_template").html()),

    myEvents: {
      "click .editar":function(e) {
        var self = this;
        e.preventDefault();
        var id = $(e.currentTarget).parents(".dd-item").data("id");
        var cat = new app.models.Consultatipo({ id: id });
        cat.fetch({
          "success":function(){
            self.ver(cat);
          }
        });
      },
      "click .nuevo":function() {
        var modelo = new app.models.Consultatipo();
        this.ver(modelo);
      },
    },

    ver: function(modelo) {
      var categoria = new app.views.ConsultatipoEditView({
        model: modelo,
        permiso: 3,
      });
      var d = $("<div/>").append(categoria.el);
      crearLightboxHTML({
        "html":d,
        "width":600,
        "height":500,
        "escapable":false,
      });
    },
    
    initialize : function () {
      _.bindAll(this); // Para que this pueda ser utilizado en las funciones
      this.render();
    },

    render : function() {

      var self = this;
      $(this.el).html(this.template());

      this.$('.dd').nestable();
      this.$('.dd').on('change',this.reorder);            

      return this;      
    }, 

    reorder: function() {
      var serialize = this.$('.dd').nestable('serialize');
      $.ajax({
        "url":"consultas_tipos/function/reorder/",
        "type":"post",
        "dataType":"json",
        "data":{
          "datos":serialize,
        }
      });
    },

  });
})(app);



(function ( views, models ) {

  views.ConsultatipoEditView = app.mixins.View.extend({

    template: _.template($("#consultas_tipos_edit_panel_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click .nuevo": "limpiar",
      "click .eliminar": "eliminar",
      "click .cerrar": function(){
        $('.modal:last').modal('hide');
      },
    },

    eliminar : function() {
      if (!confirmar("Realmente desea eliminar este elemento?")) return;
      var self = this;      
      var consulta_tipo = new app.models.Consultatipo({
        "id":self.model.id
      });
      consulta_tipo.destroy();
      consulta_tipo.fetch({
        "success":function() {
          location.reload();
        }
      });
    },        

    initialize: function(options) {
      this.model.bind("destroy",this.render,this);
      this.options = options;
      _.bindAll(this);
      this.render();      
    },

    render: function() {
      var self = this;
      var edicion = true;
      //if (this.options.permiso > 1) edicion = true;
      var obj = { edicion: edicion, id:this.model.id };
      $.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));

      new app.mixins.Select({
        modelClass: app.models.EmailTemplate,
        url: "emails_templates/",
        render: "#consultas_tipos_emails_templates",
        firstOptions: ["<option value='0'>Seleccione una plantilla</option>"],
        selected: self.model.get("id_email_template"),
        onComplete:function(c) {
          crear_select2("consultas_tipos_emails_templates");
        },
      });
      return this;
    },

    validar: function() {
      var self = this;
      try {
        validate_input("consultas_tipos_nombre",IS_EMPTY,"Por favor, ingrese un nombre.");

        if (this.$("#consultas_tipos_emails_templates").length > 0) {
          this.model.set({
            "id_email_template":self.$("#consultas_tipos_emails_templates").val(),
          });
        }
        this.model.set({
          "id_proximo_estado":self.$("#consultas_tipos_proximo_estado").val(),
        });
        return true;
      } catch(e) {
        return false;
      }
    },

    guardar: function() {
      var self = this;
      if (this.validar()) {
        if (this.model.id == null) {
          this.model.set({id:-1});
        }
        this.model.save({
          "id_empresa":ID_EMPRESA,
        },{
          success: function(model,response) {
            location.reload();
          }
        });
      }
    },

    limpiar : function() {
      this.model = new app.models.Consultatipo();
      this.render();
    },

  });

})(app.views, app.models);