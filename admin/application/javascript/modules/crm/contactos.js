(function ( models ) {

  models.Contacto = Backbone.Model.extend({
    urlRoot: "contactos/",
    defaults: {
      id_contacto: 0, // Lo usamos para saber si cargo un cliente nuevo o es uno anterior
      nombre: "",
      email: "",
      telefono: "",
      celular: "",
      direccion: "",
      tipo: 1,
      activo: 1,
      fax: "549",

      // Estos campos no son del contacto exactamente, sino de la consulta, pero como se carga todo junto la primera vez lo tenemos que poner
      texto: "",
      fecha: "",
      id_origen: 0,
      id_propiedad: 0,
      id_empresa: ID_EMPRESA,
      id_usuario: ID_USUARIO,
    }
  });
	  
})( app.models );


(function ( views, models ) {

	views.ContactoFichaView = app.mixins.View.extend({

		template: _.template($("#contacto_ficha_template").html()),

		myEvents: {
      "click .advanced-search-btn":function(){}, // Para que no me haga dos veces dentro del PropiedadesTableView
      "click .buscar_propiedades":"buscar_propiedades",

      "click .mostrar_estado":function(e) {
        e.preventDefault();
        e.stopPropagation();
        var self = this;
        var view = new app.views.CambiarEstadoConsultaView({
          "model":self.model,
          "view":self,
        });
        crearLightboxHTML({
          "html":view.el,
          "width":600,
          "height":140,
          "callback":function() {
            location.reload();
          }
        });
      },

      "click .cambiar_tab_grande":function(e) {
        var id = $(e.currentTarget).data("id");
        $(e.currentTarget).parents(".nav-tabs").find(".active").removeClass("active");
        $(e.currentTarget).parent().addClass("active");
        this.$(".tab_grande").hide();
        this.$("#tab_grande_"+id).show();
      },

      "change #contacto_ficha_usuarios":function(e) {
        var self = this;
        var id_usuario_asignado = $(e.currentTarget).val();
        $.ajax({
          "url":"consultas/function/editar_usuario_asignado/",
          "dataType":"json",
          "type":"post",
          "data":{
            "id_contacto":self.model.id,
            "ids":self.model.get("id_consulta"),
            "id_usuario_asignado":id_usuario_asignado,
            "id_usuario":ID_USUARIO,
          },
          "success":function() {
            self.fetch();
          },
        });
      },      
      "click .editar_tipo":function(e) {
        var self = this;
        var tipo = $(e.currentTarget).data("tipo");
        var v = new app.views.ConsultaCambioEstado({
          "model":self.model,
          "tipo":tipo,
        });
        crearLightboxHTML({
          "html":v.el,
          "width":450,
          "height":140,
          "callback":function() {
            self.fetch();
          }
        });        
      },
      "click .change_custom":function(e) {
        var self = this;
        var custom = $(e.currentTarget).data("custom");
        var clase_activa = $(e.currentTarget).data("active");
        if ($(e.currentTarget).hasClass("activo")) {
          var valor = 0;
          $(e.currentTarget).removeClass("activo");
          $(e.currentTarget).removeClass(clase_activa);
        } else {
          var valor = 1;
          $(e.currentTarget).addClass("activo");
          $(e.currentTarget).addClass(clase_activa);
        }
        self.model.set({custom:valor});
        this.change_property({
          "table":"clientes",
          "attribute":custom,
          "value":valor,
          "id":self.model.id,
          "success":function() {
            location.reload();
          }
        });
      },      
		},

    initialize: function(options) {
      this.model.bind("destroy",this.render,this);
      _.bindAll(this);
      this.options = options;
      window.contacto_tab_principal = (typeof options.contacto_tab_principal != "undefined") ? options.contacto_tab_principal : "buscar_propiedades";
      this.render();
    },

    fetch: function() {
      var self = this;
      this.model.fetch({
        "success":function(){
          self.render();
        }
      })
    },

    marcar_leido:function() {
      var self = this;
      self.model.set({"no_leido":0});
      this.change_property({
        "table":"clientes",
        "attribute":"no_leido",
        "value":0,
        "id":self.model.id,
      });
      return false;
    },

    buscar_propiedades: function() {
      var self = this;
      var view = new app.views.PropiedadesTableView({
        "collection":new app.collections.Propiedades(),
        "vista_busqueda":true,
      });
      crearLightboxHTML({
        "html":view.el,
        "width":860,
        "height":140,
        "callback":function() {
          self.agregar_interes();
        }
      });
    },

    agregar_interes: function() {
      if (typeof window.propiedad_seleccionado == "undefined") return;
      var self = this;
      var ids = new Array();
      var ids_empresas = new Array();
      ids.push(window.propiedad_seleccionado.id);
      ids_empresas.push(window.propiedad_seleccionado.get("id_empresa"));
      $.ajax({
        "url":"contactos/function/guardar_propiedades_interesadas/",
        "type":"post",
        "dataType":"json",
        "data":{
          "ids":ids,
          "ids_empresas":ids_empresas,
          "id_cliente":self.model.id,
        },
        "success":function(r) {
          if (r.error == 1) alert("Ocurrio un error al guardar los intereses de las propiedades seleccionadas.");
          else {
            $('#contacto_propiedades_interesadas').owlCarousel('destroy'); 
            self.render_propiedades_interesadas();
          }
        },
      });
    },    

    render: function() {
      var self = this;
    	var edicion = false;
      if (this.options.permiso > 1) edicion = true;
      var obj = { edicion: edicion, id:this.model.id };
    	$.extend(obj,this.model.toJSON());
    	$(this.el).html(this.template(obj));

      self.render_timeline();
      self.render_busquedas();
      self.render_propiedades_interesadas();
      self.render_propiedades_vistas();

      setTimeout(function(){
        $('[data-toggle="tooltip"]').tooltip();   
      },1000);

      // Cuando entramos a la consulta, marcamos al cliente como leido
      this.marcar_leido();

      return this;
    },

    render_timeline: function() {
      var self = this;
      var modelo = new app.models.Consulta({
        "id_contacto":self.model.id,
        "email":self.model.get("email"),
        "fecha":moment().format("DD/MM/YYYY"),
        "hora":moment().format("HH:mm:ss"),
        "fax":self.model.get("fax"),
        "celular":self.model.get("celular"),
        "telefono":self.model.get("telefono"),
      });
      modelo.on("remove",this.actualizar_consultas,this);
      this.editor = new app.views.CrearConsultaTimeline({
        "model":modelo,
        "view":self,
        "mostrar_tarea": (control.check("tareas")>0),
        "alerta_celular":(isEmpty(self.model.get("telefono"))),
        "alerta_email":(isEmpty(self.model.get("email"))),
        "nota": self.model.get("observaciones"),
        "mostrar_whatsapp": true,
      });
      this.$("#contacto_crear_consultas").html(this.editor.el);        
      this.render_consultas();
    },

    guardar_nota: function(value) {
      var self = this;
      self.model.set({"observaciones":value});
      this.change_property({
        "table":"clientes",
        "attribute":"observaciones",
        "value":value,
        "id":self.model.id,
      });      
    },

    actualizar_consultas: function() {
      var self = this;
      $.ajax({
        "url":"clientes/function/get_consultas/",
        "data":{
          "id_cliente":self.model.id,
        },
        "type":"post",
        "dataType":"json",
        "success":function(r){
          self.model.set({"consultas":r});
          // Limpiamos el editor con una consulta nueva
          var modelo = new app.models.Consulta({
            "id_contacto":self.model.id,
            "fecha":moment().format("DD/MM/YYYY"),
            "hora":moment().format("HH:mm:ss"),
          });
          modelo.on("remove",this.actualizar_consultas,this);
          self.editor.model = modelo;
          self.editor.limpiar();
          self.render_consultas();
        }
      })
    },

    render_consultas: function() {
      var self = this;
      this.$(".streamline").empty();
      var consultas = this.model.get("consultas");
      for(var i=0; i<consultas.length;i++) {
        var c = consultas[i];
        var view = new app.views.ConsultaTimeline({
          "model":new app.models.Consulta(c),
          "editor":self.editor,
        });
        this.$(".streamline").append(view.el);
      }
    },

    render_propiedades_interesadas: function() {
      var self = this;
      $.ajax({
        "url":"contactos/function/ver_interesadas/",
        "dataType":"json",
        "type":"get",
        "data":{
          "id_cliente":self.model.id,
        },
        "success":function(r) {
          self.$("#contacto_propiedades_interesadas").empty();
          if (r.results.length == 0) {
            self.$("#contacto_propiedades_interesadas").hide();
            self.$("#contacto_propiedades_interesadas_vacio").show();
          } else {
            self.$("#contacto_propiedades_interesadas_vacio").hide();
            self.$("#contacto_propiedades_interesadas").show();
            for(var i=0; i<r.results.length; i++) {
              var o = r.results[i];
              var view = new views.ContactoPropiedadInteresadaItem({
                model: new app.models.AbstractModel(o),
                parent: self,
              });
              self.$("#contacto_propiedades_interesadas").append(view.el);
            }
            self.$("#contacto_propiedades_interesadas").owlCarousel({
              margin: 5,
              dots: false,
              nav: false,
              responsive: {
                0: {
                  items: 2,
                },
                768: {
                  items: 3,
                },
                1200: {
                  items: 4,
                }
              }
            });
          }
        }
      })
    },

    render_busquedas: function() {
      var self = this;
      $.ajax({
        "url":"contactos/function/ver_busquedas/",
        "dataType":"json",
        "type":"get",
        "data":{
          "id_cliente":self.model.id,
        },
        "success":function(r) {
          self.$("#contacto_busquedas_guardadas tbody").empty();
          if (r.length == 0) {
            self.$("#contacto_busquedas_guardadas").hide();
            self.$("#contacto_busquedas_guardadas_vacio").show();
          } else {
            self.$("#contacto_busquedas_guardadas_vacio").hide();
            self.$("#contacto_busquedas_guardadas").show();
            for(var i=0; i<r.length; i++) {
              var o = r[i];
              var view = new views.ContactoBusquedaGuardadaItem({
                model: new app.models.AbstractModel(o),
                parent: self,
              });
              self.$("#contacto_busquedas_guardadas tbody").append(view.el);
            }            
          }
        }
      })
    },

    render_propiedades_vistas: function() {
      var self = this;
      $.ajax({
        "url":"contactos/function/propiedades_vistas/",
        "dataType":"json",
        "type":"get",
        "data":{
          "id_cliente":self.model.id,
        },
        "success":function(r) {
          self.$("#contacto_propiedades_vistas tbody").empty();
          if (r.results.length == 0) {
            self.$("#contacto_propiedades_vistas").hide();
            self.$("#contacto_propiedades_vistas_vacio").show();
          } else {
            self.$("#contacto_propiedades_vistas_vacio").hide();
            self.$("#contacto_propiedades_vistas").show();
            for(var i=0; i<r.results.length; i++) {
              var o = r.results[i];
              var view = new views.ContactoPropiedadVistaItem({
                model: new app.models.AbstractModel(o),
                parent: self,
              });
              self.$("#contacto_propiedades_vistas tbody").append(view.el);
            }            
          }
        }
      })
    },

	});

})(app.views, app.models);


(function ( views, models ) {

  views.ContactoBusquedaGuardadaItem = app.mixins.View.extend({

    template: _.template($("#contacto_busqueda_guardada_item_template").html()),
    tagName: "tr",
    myEvents: {
      "click .eliminar_busqueda_guardada":function(e) {
        if (!confirm("Realmente desea eliminar esta busqueda?")) return;
        var self = this;
        $.ajax({
          "url":"contactos/function/eliminar_busqueda/",
          "type":"post",
          "dataType":"json",
          "data":{
            "id":self.model.id,
          },
          "success":function() {
            self.parent.render_busquedas();
          }
        })
      },
    },

    initialize: function(options) {
      _.bindAll(this);
      this.options = options;
      this.parent = options.parent;
      this.render();
    },

    render: function() {
      var self = this;
      var obj = { id:this.model.id };
      $.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));
      return this;
    },

  });

})(app.views, app.models);


(function ( views, models ) {

  views.ContactoPropiedadVistaItem = app.mixins.View.extend({

    template: _.template($("#contacto_propiedad_vista_item_template").html()),
    tagName: "tr",
    myEvents: {
      "click .data":function(){
        var self = this;
        $.ajax({
          "url":"propiedades/function/ver_propiedad/"+self.model.get("id_propiedad")+"/"+self.model.get("id_empresa"),
          "dataType":"json",
          "success":function(r) {
            var propiedad = new app.models.Propiedades(r);
            var view = new app.views.PropiedadPreview({
              model: propiedad,
              telefono: self.parent.model.get("telefono"),
              email: self.parent.model.get("email"),
              id_cliente: self.parent.model.id,
              ficha_contacto: self.parent,
            });
            crearLightboxHTML({
              "html":view.el,
              "width":1200,
              "height":500,
            });
          }
        });
      },
    },

    initialize: function(options) {
      _.bindAll(this);
      this.options = options;
      this.parent = options.parent;
      this.render();
    },

    render: function() {
      var self = this;
      var obj = { id:this.model.id };
      $.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));
      return this;
    },

  });

})(app.views, app.models);


(function ( views, models ) {

  views.ContactoPropiedadInteresadaItem = app.mixins.View.extend({

    template: _.template($("#contacto_propiedad_interesada_item_template").html()),
    myEvents: {
      "click .propiedad_interesada_eliminar":function(e) {
        e.stopPropagation();
        e.preventDefault();
        if (!confirm("Realmente desea eliminar esta propiedad de la lista de intereses?")) return;
        var self = this;
        $.ajax({
          "url":"contactos/function/eliminar_interes/",
          "type":"post",
          "dataType":"json",
          "data":{
            "id":self.model.id,
          },
          "success":function() {
            $('#contacto_propiedades_interesadas').owlCarousel('destroy'); 
            self.parent.render_propiedades_interesadas();
          }
        })
      },
      "click .propiedad_interesada":function() {
        var self = this;
        $.ajax({
          "url":"propiedades/function/ver_propiedad/"+self.model.get("id_propiedad")+"/"+self.model.get("id_empresa"),
          "dataType":"json",
          "success":function(r) {
            var propiedad = new app.models.Propiedades(r);
            var view = new app.views.PropiedadPreview({
              model: propiedad,
              telefono: self.parent.model.get("telefono"),
              email: self.parent.model.get("email"),
              id_cliente: self.parent.model.id,
              ficha_contacto: self.parent,
            });
            crearLightboxHTML({
              "html":view.el,
              "width":1200,
              "height":500,
            });
          }
        });
      },
    },

    initialize: function(options) {
      _.bindAll(this);
      this.options = options;
      this.parent = options.parent;
      this.render();
    },

    render: function() {
      var self = this;
      var obj = { id:this.model.id };
      $.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));
      return this;
    },

  });

})(app.views, app.models);




(function ( app ) {

  app.views.ContactoEditView = app.mixins.View.extend({

    template: _.template($("#contacto_edit_template").html()),
        
    myEvents: {
      "click .guardar": "guardar",
      "click #contacto_propiedad":"buscar_propiedades",
      "click .buscar_propiedades":"buscar_propiedades",
      "click .id_origen":function(e){
        var clase = "btn-info";
        this.$(".id_origen.active").removeClass(clase);
        this.$(".id_origen").removeClass("active");
        var id_origen = $(e.currentTarget).data("id_origen");
        $(e.currentTarget).addClass("active");
        $(e.currentTarget).addClass(clase);
      },
    },

    initialize: function(options) {
      var self = this;
      this.options = options;
      _.bindAll(this);
      this.view = this.options.view;
      
      var edicion = false;
      if (this.options.permiso > 1) edicion = true;
      var obj = { "edicion": edicion,"id":this.model.id }
      _.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));
      this.guardando = 0;
      this.render();
    },
      
    render: function() {
        
      var self = this;
      var fecha = this.model.get("fecha");
      if (isEmpty(fecha)) fecha = new Date();
      createtimepicker($(this.el).find("#contacto_fecha"),fecha);            
      
      var input = this.$("#contacto_cliente_nombre");
      $(input).customcomplete({
        "url":"clientes/function/get_by_nombre/",
        "form":null,
        "hideNoResults":true,
        "width":"300px",
        "onSelect":function(item){
          var cliente = new app.models.Contacto({"id":item.id});
          cliente.fetch({
            "success":function(){
              self.seleccionar_cliente(cliente);
            },
          });
        }
      });

      setTimeout(function(){
        $('[data-toggle="tooltip"]').tooltip();
      },100);
    },

    buscar_propiedades: function() {
      var self = this;
      var view = new app.views.PropiedadesTableView({
        "collection":new app.collections.Propiedades(),
        "vista_busqueda":true,
      });
      crearLightboxHTML({
        "html":view.el,
        "width":860,
        "height":140,
        "callback":function() {
          self.seleccionar_propiedad();
        }
      });
    },

    seleccionar_propiedad: function() {
      if (typeof window.propiedad_seleccionado == "undefined") return;
      this.$("#contacto_propiedad").val(window.propiedad_seleccionado.get("titulo"));
      this.model.set({
        "id_propiedad":window.propiedad_seleccionado.id,
      });
    },

    seleccionar_cliente: function(r) {
      var self = this;
      // Seteamos el cliente
      self.model.set({
        "id_contacto":r.id,
        "nombre":r.get("nombre"),
        "email":r.get("email"),
        "telefono":r.get("telefono"),
      });
      self.$("#contacto_cliente_nombre").val(r.get("nombre"));
      self.$("#contacto_cliente_email").val(r.get("email"));
      self.$("#contacto_cliente_telefono").val(r.get("telefono"));

      // Para cerrar el customcomplete que se abre
      setTimeout(function(){
        self.$('#contacto_cliente_nombre').trigger(jQuery.Event('keyup', {which: 27}));
      },500);                
    },
    
    validar: function() {
      try {
        var self = this;
        var nombre = self.$("#contacto_cliente_nombre").val();
        if (isEmpty(nombre)) {
          alert("Por favor ingrese un nombre");
          self.$("#contacto_cliente_nombre").focus();
          return false;
        }

        var fecha = self.$("#contacto_fecha").val();
        if (isEmpty(fecha)) {
          alert("Por favor ingrese una fecha");
          self.$("#contacto_fecha").focus();
          return false;
        }
        this.model.set({
          "fecha_ult_operacion":fecha,
          "texto":self.$("#contacto_texto").val(),
          "asunto":self.$("#contacto_propiedad").val(),
          "fax":self.$("#contacto_cliente_telefono_prefijo").val(),
          "tipo":self.$("#contacto_consulta_tipo").val(),
        });

        if (self.$(".id_origen.active").length > 0) {
          this.model.set({
            "id_origen":self.$(".id_origen.active").data("id_origen"),
          });          
        } else {
          alert("Por favor marque un origen de la consulta.");
          return false;
        }
        return true;
      } catch(e) {
        console.log(e)
        return false;
      }
    },

    guardar:function() {
      var self = this;
      if (this.validar() && this.guardando == 0) {
        this.guardando = 1;
        if (this.model.id == null) {
          this.model.set({id:0});
        }
        this.model.save({},{
          success: function(model,response) {
            self.guardando = 0;
            if (response.error == 1) {
              show(response.mensaje);
              return;
            } else {
              $('.modal:last').modal('hide');
              location.href = "app/#contacto_acciones/"+self.model.id;
            }
          },
          error: function() {
            self.guardando = 0;
          },
        });
      }     
    },
      
  });
})(app);