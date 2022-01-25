(function ( models ) {

  models.Usuarios = Backbone.Model.extend({
    urlRoot: "usuarios/",
    defaults: {
      nombre_usuario: "",
      password: "",
      id_perfiles: 0,
      id_empresa: 0,
      id_sucursal: 0,
      sucursal: "",
      nombre: "",
      apellido: "",
      dni: "",
      fecha_alta: "",
      direccion: "",
      telefono: "",
      celular: "",
      email: "",
      activo: 1,
      admin: 0,
      hora_desde: "",
      hora_hasta: "",
      aparece_web: ((ID_PROYECTO==14)?1:0),
      archivo: "",
      cargo: "",
      titulo: "",
      path: "",
      estado_inicial: 1,
      ocultar_notificaciones: 0,
      id_vendedor: 0,
      language: "es",
      horarios: [],
      horarios_entrega: [],
      sucursales: [],
      images: [],
      recibe_notificaciones: 1,

      // Estos datos se guardan en otra tabla
      solo_usuario: 0,
      destacado: 0,
      path_2: "",
      clave_especial: "",
      facebook: "",
      instagram: "",
      linkedin: "",
      custom_1: "",
      custom_2: "",
      custom_3: "",
      custom_4: "",
      custom_5: "",
      custom_6: "",
      custom_7: "",
      custom_8: "",
      custom_9: "",
      custom_10: "",
    }
  });
      
})( app.models );


(function (collections, model, paginator) {

  collections.Usuarios = paginator.requestPager.extend({

    model: model,

    paginator_core: {
      url: "usuarios/"
    },

    paginator_ui: {
      perPage: 999999,
    },    
    
  });

})( app.collections, app.models.Usuarios, Backbone.Paginator);



(function ( app ) {

  app.views.UsuariosItem = app.mixins.View.extend({
    tagName: "tr",
    template: _.template($('#usuarios_item').html()),
    myEvents: {
      "click .edit": "editar",
      "click .ver": "editar",
      "click .delete": "borrar",
      "click .duplicar":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if (confirm("Desea duplicar el elemento?")) {
          $.ajax({
            "url":"usuarios/function/duplicar/"+self.model.id,
            "dataType":"json",
            "success":function(r){
              //window.location.href = "app/#articulo/"+r.id;
              location.reload();
            },
          });
        }
        return false;
      },
      "click .login":"login",
      "click .activo":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        var activo = this.model.get("activo");
        activo = (activo == 1)?0:1;
        self.model.set({"activo":activo});
        this.change_property({
          "table":"com_usuarios",
          "url":"usuarios/function/change_property/",
          "attribute":"activo",
          "value":activo,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
      "click .recibe_notificaciones":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        var recibe_notificaciones = this.model.get("recibe_notificaciones");
        recibe_notificaciones = (recibe_notificaciones == 1)?0:1;
        self.model.set({"recibe_notificaciones":recibe_notificaciones});
        this.change_property({
          "table":"com_usuarios",
          "url":"usuarios/function/change_property/",
          "attribute":"recibe_notificaciones",
          "value":recibe_notificaciones,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
    },
    initialize: function(options) {
      this.options = options;
      this.view = options.view;
      _.bindAll(this);
    },
    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      $('[data-toggle="tooltip"]').tooltip();
      return this;
    },
    editar: function() {
      var self = this;
      var usuario = new app.models.Usuarios({"id":self.model.id});
      usuario.fetch({
        "success":function(){
          var that = self;
          var v = new app.views.UsuariosEditView({
            model: usuario,
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
    borrar: function() {
      if (confirmar("Realmente desea eliminar este elemento?")) {
        this.model.destroy();  // Eliminamos el modelo
        $(this.el).remove();  // Lo eliminamos de la vista
        this.view.buscar();
      }
    },
    login: function(e) {
      var self = this;
      e.stopPropagation();
      $.ajax({
        "url":"login/cambiar_usuario/"+ID_EMPRESA+"/"+self.model.id,
        "dataType":"json",
        "success":function(r){
          if (r.error == 1) {
            alert(r.mensaje)
          } else {
            location.reload();
          }
        }
      });
    },
  });

})( app );


(function ( app ) {

  app.views.UsuariosTableView = app.mixins.View.extend({

    template: _.template($("#usuarios_panel_template").html()),

    myEvents: {
      "click .buscar":"buscar",
      "click .nuevo":"nuevo",
      "keypress #usuarios_buscar":function(e){
        if (e.which == 13) this.buscar();
      },
    },

    initialize : function (options) {
      var self = this;
      _.bindAll(this); // Para que this pueda ser utilizado en las funciones
      this.options = options;
      this.admin = (typeof options.admin != undefined) ? options.admin : 0;

      window.usuarios_filter = (typeof window.usuarios_filter != "undefined") ? window.usuarios_filter : "";
      window.usuarios_id_sucursal = (typeof window.usuarios_id_sucursal != "undefined") ? window.usuarios_id_sucursal : 0;
      window.usuarios_id_perfil = (typeof window.usuarios_id_perfil != "undefined") ? window.usuarios_id_perfil : 0;
      window.usuarios_page = (typeof window.usuarios_page != "undefined") ? window.usuarios_page : 1;

      this.render();
      this.collection.off('sync');
      this.collection.on('sync', this.addAll, this);
      this.buscar();
    },

    render: function() {

      var self = this;
      // Creamos la lista de paginacion
      this.pagination = new app.mixins.PaginationView({
        ver_filas_pagina: true,
        collection: self.collection
      });
      
      $(this.el).html(this.template({
        "admin":this.admin,
      }));

      this.$(".pagination_container").html(this.pagination.el);

      new app.mixins.Select({
        modelClass: app.models.Perfiles,
        url: "perfiles/",
        render: "#usuarios_perfiles",
        firstOptions: ["<option value='0'>Perfil</option>"],
      });

      return this;
    },

    buscar: function() {

      var cambio_parametros = false;

      if (window.usuarios_filter != this.$("#usuarios_buscar").val().trim()) {
        window.usuarios_filter = this.$("#usuarios_buscar").val().trim();
        cambio_parametros = true;
      }
      if (window.usuarios_id_sucursal != this.$("#usuarios_sucursales").val()) {
        window.usuarios_id_sucursal = this.$("#usuarios_sucursales").val();
        cambio_parametros = true;
      }
      if (window.usuarios_id_perfil != this.$("#usuarios_perfiles").val()) {
        window.usuarios_id_perfil = this.$("#usuarios_perfiles").val();
        cambio_parametros = true;
      }

      if (cambio_parametros) window.usuarios_page = 1;
      var datos = {
        "filter":encodeURIComponent(window.usuarios_filter),
        "id_sucursal":window.usuarios_id_sucursal,
        "id_perfil":window.usuarios_id_perfil,
        "admin":this.admin,
      }
      this.collection.server_api = datos;
      this.collection.goTo(window.usuarios_page);
    },

    addAll : function () {
      $(this.el).find("tbody").empty();
      this.collection.each(this.addOne);
    },

    addOne : function ( item ) {
      var self = this;
      var view = new app.views.UsuariosItem({
        model: item,
        view: self,
      });
      $(this.el).find("tbody").append(view.render().el);
    },

    nuevo: function() {
      var self = this;
      var v = new app.views.UsuariosEditView({
        model: new app.models.Usuarios(),
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

  });
})(app);


(function ( views, models ) {

  views.UsuariosEditView = app.mixins.View.extend({

    template: _.template($("#usuarios_edit_panel_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click #horario_agregar":"agregar_horario",
      "click .editar_horario":"editar_horario",
      "click .eliminar_horario":function(e){
        $(e.currentTarget).parents("tr").remove();
      },
      "keypress #usuario_horario_hasta":function(e) {
        if (e.which == 13) this.agregar_horario();
      },

      "click #horario_entrega_agregar":"agregar_horario_entrega",
      "click .editar_horario_entrega":"editar_horario_entrega",
      "click .eliminar_horario_entrega":function(e){
        $(e.currentTarget).parents("tr").remove();
      },
      "keypress #usuario_horario_entrega_hasta":function(e) {
        if (e.which == 13) this.agregar_horario_entrega();
      },

      // ABRIMOS MODAL PARA UPLOAD MULTIPLE
      "click .upload_multiple":function(e) {
        var self = this;
        this.open_multiple_upload({
          "model": self.model,
          "url": "usuarios/function/upload_images/",
          "view": self,
        });
      },
      "click .nueva_direccion":function(){
        var self = this;
        var v = new app.views.TurnoServicioEditView({
          model: new app.models.TurnoServicio({
            "nuevo":1,
            "id_usuario":self.model.id,
          }),
          collection: self.direcciones,
          lightbox: true,
        });
        crearLightboxHTML({
          "html":v.el,
          "width":600,
          "height":140,
          "callback":function() {
            console.log(self.direcciones);
          }
        });
      },      
    },

    initialize: function(options) {
      _.bindAll(this);
      this.options = options;
      this.view = options.view;
      this.id_perfil_default = (typeof options != undefined) ? options.id_perfil_default : PERFIL;
      this.render();
    },

    render: function() {
      var self = this;
      var obj = { 
        id:this.model.id,
        cambiar_password: (this.model.isNew() || ID_USUARIO == this.model.id || USUARIO_PPAL == 1),
      };
      $.extend(obj,this.model.toJSON());

      $(this.el).html(this.template(obj));

      $(this.el).find("#usuario_horario_desde").mask("99:99");
      $(this.el).find("#usuario_horario_hasta").mask("99:99");

      this.stopListening();
      this.listenTo(this.model, 'change_table', self.render_tabla_fotos);
      this.render_tabla_fotos();
      $(this.el).find("#images_tabla").sortable();

      new app.mixins.Select({
        modelClass: app.models.Perfiles,
        url: "perfiles/",
        render: "#usuario_perfiles",
        name : "id_perfiles",
        firstOptions: ["<option value='0'>-</option>"],
        selected : self.model.get("id_perfiles"),
      });

      // Si esta habilitado el modulo y existe el componente
      if (control.check("vendedores")>0 && this.$("#usuario_vendedores").length > 0) {
        new app.mixins.Select({
          modelClass: app.models.Vendedor,
          url: "vendedores/",
          render: "#usuario_vendedores",
          name : "id_vendedor",
          firstOptions: ["<option value='0'>-</option>"],
          selected: self.model.get("id_vendedor"),
        });
      }
    },

    render_tabla_fotos: function() {
      var images = this.model.get("images");
      this.$("#images_tabla").empty();
      if (images.length == 0) {
        this.$("#images_container").removeClass('tiene');
      } else {
        this.$("#images_container").addClass('tiene');
        for(var i=0;i<images.length;i++) {
          var path = images[i];
          var pth = path+"?t="+parseInt(Math.random()*100000);
          var li = "";
          li+="<li class='list-group-item'>";
          li+=" <span><i class='fa fa-sort text-muted fa m-r-sm'></i> </span>";
          li+=" <img style='margin-left: 10px; margin-right:10px; max-height:50px' class='img_preview' src='"+pth+"'/>";
          li+=" <span class='filename'>"+path+"</span>";
          li+=" <span class='cp pull-right m-t eliminar_foto' data-property='images'><i class='fa fa-fw fa-times'></i> </span>";
          li+=" <span data-id='images' class='cp m-r pull-right m-t editar_foto_multiple'><i class='fa fa-pencil'></i> </span>";
          li+="</li>";
          this.$("#images_tabla").append(li);
        }
      }
    }, 

    agregar_horario: function() {
      // Controlamos los valores
      var desde = $("#usuario_horario_desde").val();
      if (isEmpty(desde)) {
        alert("Por favor ingrese una fecha");
        $("#usuario_horario_desde").focus();
        return;
      }
      var hasta = $("#usuario_horario_hasta").val();
      if (isEmpty(hasta)) {
        alert("Por favor ingrese una fecha");
        $("#usuario_horario_hasta").focus();
        return;
      }
      var dia = $("#usuario_horario_dia").val();
      var nombre_dia = $("#usuario_horario_dia option:selected").text();
      var tr = "<tr>";
      tr+="<td class='dn dia'>"+dia+"</td>";
      tr+="<td class='editar_horario'><span class='text-info'>"+nombre_dia+"</td>";
      tr+="<td class='desde editar_horario'>"+desde+"</td>";
      tr+="<td class='hasta editar_horario'>"+hasta+"</td>";
      tr+="<td class='tar'>";
      tr+="<button class='btn btn-sm btn-white eliminar_horario'><i class='fa fa-trash'></i></button>";
      tr+="</td>";
      tr+="</tr>";
      if (this.item_horario == null) {
        $("#usuario_horarios_tabla tbody").append(tr);
      } else {
        $(this.item_horario).replaceWith(tr);
        this.item_horario = null;
      }
      $("#usuario_horario_desde").val("");
      $("#usuario_horario_hasta").val("");
      $("#usuario_horario_dia").focus();
    },
    
    editar_horario: function(e) {
      this.item_horario = $(e.currentTarget).parents("tr");
      $("#usuario_horario_dia").val($(this.item_horario).find(".dia").text());
      $("#usuario_horario_desde").val($(this.item_horario).find(".desde").text());
      $("#usuario_horario_hasta").val($(this.item_horario).find(".hasta").text());
    },

    agregar_horario_entrega: function() {
      // Controlamos los valores
      var desde = $("#usuario_horario_entrega_desde").val();
      if (isEmpty(desde)) {
        alert("Por favor ingrese una fecha");
        $("#usuario_horario_entrega_desde").focus();
        return;
      }
      var hasta = $("#usuario_horario_entrega_hasta").val();
      if (isEmpty(hasta)) {
        alert("Por favor ingrese una fecha");
        $("#usuario_horario_entrega_hasta").focus();
        return;
      }
      var dia = $("#usuario_horario_entrega_dia").val();
      var nombre_dia = $("#usuario_horario_entrega_dia option:selected").text();
      var tr = "<tr>";
      tr+="<td class='dn dia'>"+dia+"</td>";
      tr+="<td class='editar_horario_entrega'><span class='text-info'>"+nombre_dia+"</td>";
      tr+="<td class='desde editar_horario_entrega'>"+desde+"</td>";
      tr+="<td class='hasta editar_horario_entrega'>"+hasta+"</td>";
      tr+="<td class='tar'>";
      tr+="<button class='btn btn-sm btn-white eliminar_horario_entrega'><i class='fa fa-trash'></i></button>";
      tr+="</td>";
      tr+="</tr>";
      if (this.item_horario_entrega == null) {
        $("#usuario_horario_entregas_tabla tbody").append(tr);
      } else {
        $(this.item_horario_entrega).replaceWith(tr);
        this.item_horario_entrega = null;
      }
      $("#usuario_horario_entrega_desde").val("");
      $("#usuario_horario_entrega_hasta").val("");
      $("#usuario_horario_entrega_dia").focus();
    },
    
    editar_horario_entrega: function(e) {
      this.item_horario_entrega = $(e.currentTarget).parents("tr");
      $("#usuario_horario_entrega_dia").val($(this.item_horario_entrega).find(".dia").text());
      $("#usuario_horario_entrega_desde").val($(this.item_horario_entrega).find(".desde").text());
      $("#usuario_horario_entrega_hasta").val($(this.item_horario_entrega).find(".hasta").text());
    },

    validar: function() {
      var self = this;
      try {
        validate_input("usuarios_email",IS_EMAIL,"Por favor, ingrese un email.");

        if (this.$("#usuario_horarios_tabla").length > 0) {
          var k = 0;
          var horarios = new Array();
          $("#usuario_horarios_tabla tbody tr").each(function(i,e){
            horarios.push({
              "dia": $(e).find(".dia").text(),
              "desde": $(e).find(".desde").text(),
              "hasta": $(e).find(".hasta").text(),
            });
            k++;
          });
          this.model.set({"horarios":horarios});
        }

        if (this.$("#usuario_horario_entregas_tabla").length > 0) {
          var k = 0;
          var horarios_entrega = new Array();
          $("#usuario_horario_entregas_tabla tbody tr").each(function(i,e){
            horarios_entrega.push({
              "dia": $(e).find(".dia").text(),
              "desde": $(e).find(".desde").text(),
              "hasta": $(e).find(".hasta").text(),
            });
            k++;
          });
          this.model.set({"horarios_entrega":horarios_entrega});
        }

        // Listado de Imagenes
        if (this.$("#images_tabla").length > 0) {
          var images = new Array();
          $(this.el).find("#images_tabla .list-group-item .filename").each(function(i,e){
            images.push($(e).text());
          });
          self.model.set({"images":images});
        }

        if (this.$("#usuarios_password").length > 0) {
          if (this.model.id == null) {
            validate_input("usuarios_password",IS_EMPTY,"Por favor, ingrese una clave para el usuario.");
            validate_input("usuarios_password_2",IS_EMPTY,"Por favor, ingrese una clave para el usuario.");
          }
          var password_1 = $("#usuarios_password").val();
          var password_2 = $("#usuarios_password_2").val();
          if (password_1 != password_2) {
            show("ERROR: Las claves no coinciden. Ingrese nuevamente.");
            $("#usuarios_password_2").focus();
            return false;
          }
          if (!isEmpty(password_1)) {
            password_1 = hex_md5(password_1);
            this.model.set({
              "password":password_1
            });                    
          }          
        }

        if (this.$("#usuarios_sucursales").length > 0) {
          var c = $("#usuarios_sucursales").select2("val");
          if (c != null && c.length > 0) {
            var id_sucursal = c[0];
            this.model.set({
              "id_sucursal":id_sucursal,
              "sucursales":c,
            });
          } else {
            this.model.set({
              "id_sucursal":0,
              "sucursales":[],
            });            
          }
        }

        if (this.$("#usuario_vendedores").length > 0) {
          this.model.set({
            "id_vendedor":this.$("#usuario_vendedores").val(),
          });
        }

        this.model.set({
          "archivo":(this.$("#hidden_archivo").length > 0) ? $("#hidden_archivo").val() : "",
          "path":(this.$("#hidden_path").length > 0) ? $("#hidden_path").val() : "",
        });

        this.model.set({
          "id_perfiles": ((self.$("#usuario_perfiles").length > 0) ? self.$("#usuario_perfiles").val() : self.id_perfil_default),
        });

        if (this.$("#hidden_path_2").length > 0) {
          this.model.set({
            "path_2":(this.$("#hidden_path_2").length > 0) ? $("#hidden_path_2").val() : "",
          });
        }

        if (this.model.get("id_perfiles") == 0) {
          alert("Por favor seleccione un perfil de usuario.");
          return false;
        }

        return true;
      } catch(e) {
        return false;
      }
    },
        
    guardar: function() {
      var self = this;
      if (this.validar()) {
        this.model.set({
          "language": ((self.$("#usuario_language").length > 0) ? self.$("#usuario_language").val() : 0),
          "recibe_notificaciones": ((self.$("#recibe_notificaciones").length > 0) ? (self.$("#recibe_notificaciones").is(":checked") ? 1 : 0) : 0),
        });
        if (this.model.id == null) {
          this.model.set({id:0});
        }
        this.model.save({},{
          success: function(model,response) {
            location.reload();
            //$('.modal:last').modal('hide'); // Cerramos si hay otro lightbox abierto
          }
        });
      }
    },
    
  });

})(app.views, app.models);
