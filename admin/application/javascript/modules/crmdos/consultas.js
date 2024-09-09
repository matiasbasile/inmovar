// -----------
//   MODELO
// -----------

(function ( models ) {

  models.ConsultaDos = Backbone.Model.extend({
    urlRoot: "consultas",
    defaults: {
      id_contacto: 0,
      id_empresa: ID_EMPRESA,
      id_empresa_relacion: ID_EMPRESA,
      id_propiedad: 0,
      id_articulo: 0,
      id_viaje: 0,
      id_paciente: 0,
      fecha_visto: "",
      fecha: "",
      hora: "",
      asunto: "",
      subtitulo: "",
      texto: "",
      id_email_respuesta: 0,
      id_origen: 0,
      nombre: "",
      telefono: "",
      ciudad: "",
      celular: "",
      email: "",
      propiedad_nombre: "",
      propiedad_path: "",
      propiedad_direccion: "",
      propiedad_ciudad: "",
      articulo_nombre: "",
      articulo_path: "",
      entrada_nombre: "",
      entrada_path: "",
      origen: "",
      color_origen: "",
      id_asunto: 0,
      estado: 0,
      id_referencia: 0,
      children: [],
      message_id: "",

      // Datos de la respuesta del usuario
      email_fecha: "",
      email_usuario: "",
      texto_respuesta: "",

      nombre: "",
      email: "",
      telefono: "",
      custom_1: "",

      tipo: 0, // 0 = RECIBIDO; 1 = ENVIADO
      estado_turno: 0, // 0 = PENDIENTE; 1 = REALIZADO
      id_relacion: 0,
      adjuntos: [], 
    },
  });
    
})( app.models );



// ----------------------
//   COLECCION PAGINADA
// ----------------------

(function (collections, model, paginator) {
  collections.ConsultasDos = paginator.requestPager.extend({
    model: model,
    paginator_ui: {
      perPage: 30,
      order_by: 'fecha',
      order: 'asc',
    },
    paginator_core: {
      url: "consultas/function/verdos",
    }
  });
})( app.collections, app.models.ConsultaDos, Backbone.Paginator);

// =============================================
// TABLA DE CONSULTAS

(function ( app ) {

  app.views.ConsultasTableViewDos = app.mixins.View.extend({

    template: _.template($("#consultas_panel_template_dos").html()),

    myEvents: {
      "click #consultas_vencidas_tab":function(){
        window.consultas_tipo = -1;
        window.consultas_vencidas = 1;
        this.$(".cambiar_tab").removeClass("active");
        this.$("#consultas_vencidas_tab").addClass("active");
        this.buscar();
      },
      "click .nuevo_cliente": "nuevo_cliente",
      "keydown #consultas_table tbody tr .radio:first":function(e) {
        // Si estamos en el primer elemento y apretamos la flechita de arriba
        if (e.which == 38) { e.preventDefault(); $(".basic_search").focus(); }
      },
      "keydown #consultas_buscar":function(e) {
        // Flechita de abajo en el campo de busqueda
        if (e.which == 40) { e.preventDefault(); $("#consultas_table tbody tr .radio:first").focus(); }
      },
      "click .exportar_excel":"exportar",
      "click .importar_excel":"importar",
      "click .exportar_csv":"exportar_csv",
      "click .importar_csv":"importar_csv",
      "change #consultas_buscar":"buscar",
      "change #consultas_usuarios":"buscar",
      "click .buscar":"buscar",
      "click .cambiar_tab":function(e) {
        var self = this;
        var tipo = $(e.currentTarget).data("tipo");
        this.$(".cambiar_tab").removeClass("active");
        this.$("#consultas_vencidas_tab").removeClass("active");
        $(e.currentTarget).addClass("active");
        this.cambio_parametros = true;
        window.consultas_vencidas = 0;
        window.consultas_tipo = tipo;
        this.buscar();
      },

      "click .eliminar_lote":function() {
        if (typeof window.consultas_marcadas == "undefined") return;
        if (window.consultas_marcadas.length == 0) return;
        if (!confirm("Realmente desea eliminar los elementos seleccionados?")) return;
        var self = this;
        $.ajax({
          "url":"clientes/function/eliminar_por_lote/",
          "dataType":"json",
          "type":"post",
          "data":{
            "ids":window.consultas_marcadas,
          },
          "success":function(res) {
            location.reload();
          }
        });
      },      
    },

    nuevo_cliente: function() {
      var self = this;
      var view = new app.views.ContactoEditView({
        model: new app.models.Contacto(),
        view: self,
      });            
      crearLightboxHTML({
        "html":view.el,
        "width":650,
        "height":140,
        "escapable":false,
      });
    },

    initialize : function (options) {
      _.bindAll(this);
      this.options = options;
      this.habilitar_seleccion = (this.options.habilitar_seleccion == undefined || this.options.habilitar_seleccion == false) ? false : true;
      this.modulo = this.options.modulo;
      this.cambio_parametros = false;
      this.render();
      this.collection.off('sync');
      this.collection.on('sync', this.addAll, this);
      this.buscar();


      setTimeout(function(){ 
        console.log("llega");
        $(function () {
          $("#body1,#body2,#body3,#body4,#body98,#body99").sortable({
            connectWith: "#body1,#body2,#body3,#body4,#body98,#body99",
            start: function (event, ui) {
              ui.item.toggleClass("highlight");
              window.tarjeta_id = $(ui.item).attr("data-id");
              window.tarjeta_tipo = $(event.currentTarget).attr("data-body");
            },
            stop: function (event, ui) {
              ui.item.toggleClass("highlight");
              var new_tipo = $(ui.item).parent().attr("data-body");

              if (window.tarjeta_tipo != new_tipo) {
                $.ajax({
                  "url":"consultas/function/actualizar_tipo_cliente/",
                  "dataType":"json",
                  "type":"post",
                  "data":{
                    "id_cliente":window.tarjeta_id,
                    "tipo": new_tipo,
                    "id_empresa": ID_EMPRESA,
                    "success":function() {
                      var cantidad_viejo = $(".cantidad_"+window.tarjeta_tipo).text();
                      var cantidad_nuevo = $(".cantidad_"+new_tipo).text();
                      $(".cantidad_"+window.tarjeta_tipo).text(parseInt(cantidad_viejo)-1);
                      $(".cantidad_"+new_tipo).text(parseInt(cantidad_nuevo)+1);
                    }
                  },
                });
              } 
            },
            sort: function(event, ui) {
              var pos_scroll = $('.over-x').scrollLeft();
              var pos = $(ui.item).position().left;
              var width = $(".over-x").width();
              if (pos >= width-100) {
                $('.over-x').scrollLeft(pos_scroll+10);
              } else if (pos <= 100) {
                $('.over-x').scrollLeft(pos_scroll-10);
              }
            }
          });
          $("#body1,#body2,#body3,#body4,#body98,#body99").disableSelection();
        });

      }, 10000);

    },

    render: function() {
      var self = this;
      this.pagination = new app.mixins.PaginationView({
        ver_filas_pagina: true,
        collection: this.collection,
      });
      $(this.el).html(this.template({
        "permiso":control.check("contactos"),
        "seleccionar":this.habilitar_seleccion,
        "modulo":this.modulo,
      }));
    },


    buscar: function() {
      //Trae la coleccion
      var datos = {};
      this.collection.server_api = datos;
      this.collection.goTo(1);
    },


    exportar: function(obj) {
      var url = this.collection.url+"function/exportar/?order="+encodeURI("C.fecha_ult_operacion DESC");
      url+="&tipo="+window.consultas_tipo;
      url+="&custom_3="+window.consultas_custom_3;
      url+="&custom_4="+window.consultas_custom_4;
      url+="&custom_5="+window.consultas_custom_5;
      if (!isEmpty(this.$("#consultas_buscar").val())) url+="&filter="+encodeURI(this.$("#consultas_buscar").val());
      if (this.$("#consultas_codigo_propiedad").length > 0) url+="&codigo_propiedad="+encodeURI(this.$("#consultas_codigo_propiedad").val());
      if (ID_PROYECTO == 3) url+="&id_proyecto="+ID_PROYECTO;
      window.open(url,"_blank");
    },

    importar: function() {
      app.views.importar = new app.views.Importar({
        "url":"clientes/function/importar_excel/",
      });
      crearLightboxHTML({
        "html":app.views.importar.el,
        "width":450,
        "height":140,
      });
    },        

    exportar_csv: function(obj) {
      window.open("clientes/function/exportar_csv/","_blank");
    },

    importar_csv: function() {
      app.views.importar = new app.views.Importar({
        "table":"clientes",
      });
      crearLightboxHTML({
        "html":app.views.importar.el,
        "width":450,
        "height":140,
      });
    }, 
    
    addAll : function () {
      this.$("#wrapper_items").empty();
      if (this.collection.length > 0) this.collection.each(this.addOne);
    },

    addOne : function ( item ) {
      var self = this;
      var view = new app.views.ConsultaItemDos({
        model: item,
        permiso: self.permiso,
        habilitar_seleccion: self.habilitar_seleccion, 
        modulo: self.modulo,
        parent: self,
      });
      $(this.el).find("#wrapper_items").append(view.render().el);
    },

  });
})(app);

// =============================================
// ITEM DE LA TABLA

(function ( app ) {

  app.views.ConsultaItemDos = app.mixins.View.extend({
    tagName: "div",
    className: "dib",
    template: _.template($('#consultas_item_dos').html()),
    myEvents: {
      "click .tarjeta-item":function(e){
        location.href="app/#contacto_acciones/"+$(e.currentTarget).attr("data-id");
      },
      "change .usuario_asignado":function(e) {
        e.preventDefault();
        e.stopPropagation();
        var self = this;
        var id_usuario_asignado = $(e.currentTarget).val();
        if (id_usuario_asignado == 0) return;
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
            self.parent.buscar();
          },
        });
      },

      "click .data":"seleccionar",
      "click .delete": "borrar",
      "click .duplicar": "duplicar",
      "click .enviar_whatsapp":function(){
        var mensaje = "Hola "+this.model.get("nombre")+"\n";
        var tel = this.model.get("fax")+""+this.model.get("telefono");
        tel = tel.replace(/[^\d.-]/g, '');
        tel = tel.replace(/\-/g, "");
        var link_ws = "https://wa.me/"+tel+"?text="+encodeURIComponent(mensaje);
        window.open(link_ws,"_blank");
      },      

      "click .activo":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        var activo = this.model.get("activo");
        activo = (activo == 1)?0:1;
        self.model.set({"activo":activo});
        this.change_property({
          "table":"clientes",
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

    seleccionar: function() {
      if (this.habilitar_seleccion) {
        window.codigo_cliente_seleccionado = this.model.get("codigo");
        window.cliente_seleccionado = this.model;
        $('.modal:last').modal('hide');
      } else {
        location.href="app/#contacto_acciones/"+this.model.id;    
      }
    },
    initialize: function(options) {
      // Si el modelo cambia, debemos renderizar devuelta el elemento
      this.model.bind("change",this.render,this);
      this.model.bind("destroy",this.render,this);
      this.options = options;
      this.permiso = this.options.permiso;
      this.modulo = this.options.modulo;
      this.habilitar_seleccion = (this.options.habilitar_seleccion == undefined || this.options.habilitar_seleccion == false) ? false : true;
      this.parent = (typeof this.options.parent != "undefined") ? this.options.parent : null;
      _.bindAll(this);
    },
    render: function() {
      var self = this;
      var obj = this.model.toJSON();
      obj.permiso = this.permiso;
      obj.seleccionar = this.habilitar_seleccion;
      obj.modulo = this.modulo;
      $(this.el).html(this.template(obj));
      $('[data-toggle="tooltip"]').tooltip();
      return this;
    },
    borrar: function(e) {
      if (confirmar("Realmente desea eliminar este elemento?")) {
        this.model.destroy();  // Eliminamos el modelo
        $(this.el).remove();  // Lo eliminamos de la vista                
      }
      e.stopPropagation();
    },
  });

})( app );


(function ( app ) {
  app.views.CrearConsultaTimelineDos = app.mixins.View.extend({
    template: _.template($("#crear_consulta_timeline_template_dos").html()),
    myEvents: {
      "click .cargar_plantilla":"cargar_plantilla",
      "click .enviar_whatsapp":"enviar_whatsapp",
      "click .guardar_plantilla":"guardar_plantilla",
      "click .guardar_email":"guardar_email",
      "click .guardar_nota":"guardar_nota",
      "click .guardar_observacion":"guardar_observacion",
      "click .guardar_sms":"guardar_sms",
      "click .guardar_tarea":"guardar_tarea",
      "click .agregar_asunto":function(e) {
        var self = this;
        if ($(".asunto_edit_mini").length > 0) return;
        var form = new app.views.AsuntoMiniEditView({
          "model": new app.models.Asunto(),
          "callback":function(m){
            self.model.set({ "id_asunto":m });
            self.cargar_asuntos();
          },
        });
        var width = 350;
        var position = $(e.currentTarget).offset();
        var top = position.top + $(e.currentTarget).outerHeight();
        var container = $("<div class='customcomplete asunto_edit_mini'/>");
        $(container).css({
          "top":top+"px",
          "left":(position.left - width + $(e.currentTarget).outerWidth())+"px",
          "display":"block",
          "width":width+"px",
        });
        $(container).append("<div class='new-container'></div>");
        $(container).find(".new-container").append(form.el);
        $("body").append(container);
        $("#asuntos_mini_nombre").focus();
      },
      "click #tab1_link":function() {
        if (typeof CKEDITOR.instances["consulta_email_texto"] == "undefined") { 
          workspace.crear_editor('consulta_email_texto',{
            "toolbar":"Basic",
            "removePlugins":'elementspath',
            "resize_enabled":false,
            "placeholder":"Escribe aquí el contenido del mensaje...",
            "height":120,
          });
        }
      },
    },
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      this.options = options;
      this.view = options.view;
      this.alerta_email = options.alerta_email;
      this.alerta_celular = options.alerta_celular;
      this.telefonos = (typeof options.telefonos != undefined) ? options.telefonos : new Array();
      this.mostrar_sms = (typeof options.mostrar_sms != undefined) ? options.mostrar_sms : false;
      this.mostrar_whatsapp = (typeof options.mostrar_whatsapp != undefined) ? options.mostrar_whatsapp : false;
      this.nota = (typeof options.nota != undefined) ? options.nota : "";
      this.mostrar_tarea = (typeof options.mostrar_tarea != undefined) ? options.mostrar_tarea : false;
      this.adjuntos = new Array();
      this.render();

      createtimepicker(this.$("#consulta_tarea_fecha"),new Date());
      createtimepicker(this.$("#consulta_tarea_fecha_visto"),new Date());
      
      // Si existe el CKEditor, lo eliminamos para volverlo a crear mas tarde
      var en = CKEDITOR.instances["consulta_email_texto"];
      if (en) CKEDITOR.remove(en);

      this.$('#fileupload_timeline').fileupload({
        url: "/admin/clientes/function/upload_files/",
        dataType: 'json',
        start: function() {
          $("#progress_timeline").show();
        },
        done: function (e, data) {
          $.each(data.result.files, function (index, file) {
            self.adjuntos.push(file.url);
            $('<p/>').text(file.name).appendTo('#files_timeline');
          });
          $("#progress_timeline").hide();
        },
        progressall: function (e, data) {
          var progress = parseInt(data.loaded / data.total * 100, 10);
          $('#progress_timeline .progress-bar').css(
            'width',
            progress + '%'
          );
        }
      }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');


      setTimeout(function(){
        $("#tab1_link").trigger("click");
      },100);
    },
    render: function() {
      var obj = this.model.toJSON();
      // TODO: Hacer esto administrable
      obj.mostrar_sms = this.mostrar_sms;
      obj.mostrar_tarea = this.mostrar_tarea;
      obj.mostrar_whatsapp = this.mostrar_whatsapp;
      obj.alerta_celular = this.alerta_celular;
      obj.alerta_email = this.alerta_email;
      obj.nota = this.nota;
      obj.telefonos = this.telefonos;
      $(this.el).html(this.template(obj));
      this.cargar_asuntos();
      return this;
    },
    limpiar: function() {
      this.$("#consulta_email_asunto").val("");
      this.$("#consulta_email_texto").val("");
      this.$("#consulta_sms").val("");
      this.$("#consulta_whatsapp").val("");
      this.$("#consulta_nota").val("");
    },
    enviar_whatsapp: function() {
      var self = this;
      var texto = this.$("#consulta_whatsapp").val();
      if (isEmpty(texto)) {
        alert("Por favor ingrese el texto que desea enviar.");
        this.$("#consulta_whatsapp").focus();
        return;
      }
      var celular = this.model.get("telefono");
      var prefijo =  this.model.get("fax");
      if (isEmpty(prefijo)) prefijo = "549";
      console.log(this.model);
      if (isEmpty(celular)) {
        alert("Error: el contacto no tiene un celular cargado.");
        return;
      }
      var salida = "https://wa.me/"+prefijo+celular+"?text="+encodeURIComponent(texto);
      window.open(salida,"_blank");

      // Guardamos la consulta
      this.model.save({
        "asunto":"",
        "texto":texto,
        "tipo":1, // Estamos ENVIANDO
        "id_origen":27, // un WHATSAPP
        "id_empresa":ID_EMPRESA,
        "id_usuario":ID_USUARIO,
        "fecha":moment().format("YYYY-MM-DD"),
        "hora":moment().format("HH:mm:ss"),
      },{
        "success":function() {
          self.view.actualizar_consultas();
        }
      })
    },
    cargar_asuntos: function() {
      var s = "";
      var id_asunto = this.model.get("id_asunto");
      for(var i=0;i< window.asuntos.length;i++) {
        var o = window.asuntos[i]; 
        s+='<option '+((o.id==id_asunto)?"selected":"")+' value="'+o.id+'">'+o.nombre+'</option>';
      }
      this.$("#consulta_tarea_asuntos").html(s);
      this.$("#consulta_tarea_asuntos").select2();
    },
    cargar_plantilla: function() {
      var self = this;
      window.email_template_seleccionado = null;
      var lista = new app.views.EmailsTemplatesTableView({
        collection: new app.collections.EmailsTemplates(),
        habilitar_seleccion: true,
      });
      crearLightboxHTML({
        "html":lista.el,
        "width":450,
        "height":140,
        "callback":function() {
          // Si selecciono algun template
          if (window.email_template_seleccionado != null) {
            var texto = window.email_template_seleccionado.get("texto");
            var nombre = window.email_template_seleccionado.get("nombre");
            CKEDITOR.instances['consulta_email_texto'].setData(texto);
            self.$("#consulta_email_asunto").val(nombre);
          }
        }
      });
    },
    guardar_plantilla: function() {
      var self = this;
      var nombre = this.$("#consulta_email_asunto").val();
      if (isEmpty(nombre)) {
        alert("Por favor ingrese un asunto para guardar la plantilla.");
        this.$("#consulta_email_asunto").focus();
        return;
      }
      var texto = CKEDITOR.instances['consulta_email_texto'].getData();
      if (isEmpty(texto)) {
        alert("Por favor ingrese algun texto en la plantilla que desea guardar.");
        return;
      }
      var template = new app.models.EmailTemplate({
        "nombre":nombre,
        "texto":texto,
      });
      template.save({},{
        "success":function() {
          alert("La plantilla se ha guardado con exito.");
        }
      })
    },
    guardar_email: function() {
      var self = this;

      // Controlamos el asunto
      var asunto = this.$("#consulta_email_asunto").val();
      if (isEmpty(asunto)) {
        alert("Por favor ingrese un asunto.");
        this.$("#consulta_email_asunto").focus();
        return;
      }

      // Controlamos el texto del email
      var texto = "";
      if (typeof CKEDITOR.instances['consulta_email_texto'] != "undefined") {
        var texto = CKEDITOR.instances['consulta_email_texto'].getData();
      }
      if (isEmpty(texto)) {
        alert("Por favor ingrese un texto.");
        return;
      }

      this.model.save({
        "asunto":asunto,
        "texto":texto,
        "tipo":1, // Estamos ENVIANDO
        "id_origen":5, // un EMAIL
        "id_empresa":ID_EMPRESA,
        "id_usuario":ID_USUARIO,
        "fecha":moment().format("YYYY-MM-DD"),
        "hora":moment().format("HH:mm:ss"),
        "adjuntos":self.adjuntos,
      },{
        "success":function() {
          location.reload();
          //self.view.actualizar_consultas();
        }
      })
    },

    guardar_sms: function() {
      var self = this;

      // Controlamos el texto
      var texto = this.$("#consulta_sms").val();
      if (isEmpty(texto)) {
        alert("Por favor ingrese un texto.");
        this.$("#consulta_sms").focus();
        return;
      }
      var numero = this.$("#consulta_sms_telefono").val();
      this.model.save({
        "texto":texto,
        "asunto":numero,
        "tipo":1, // Estamos ENVIANDO
        "id_origen":15, // un SMS
        "id_empresa":ID_EMPRESA,
        "id_usuario":ID_USUARIO,
        "fecha":moment().format("YYYY-MM-DD"),
        "hora":moment().format("HH:mm:ss"),
      },{
        "success":function() {
          self.view.actualizar_consultas();
        }
      })
    },
    guardar_tarea: function() {
      var self = this;

      // Controlamos el texto
      var texto = this.$("#consulta_tarea_texto").val();
      var id_asunto = this.$("#consulta_tarea_asuntos").val();
      var asunto = this.$("#consulta_tarea_asuntos option:selected").text();
      var fecha = this.$("#consulta_tarea_fecha").val();
      if (isEmpty(fecha)) {
        alert("Por favor ingrese una fecha.");
        this.$("#consulta_tarea_fecha").focus();
        return;
      }
      var fecha_ant = fecha;
      fecha = moment(fecha_ant,"DD/MM/YYYY").format("YYYY-MM-DD");
      hora = moment(fecha_ant,"DD/MM/YYYY HH:mm").format("HH:mm:ss");

      var fecha_visto = this.$("#consulta_tarea_fecha_visto").val();
      if (isEmpty(fecha_visto)) {
        alert("Por favor ingrese una fecha.");
        this.$("#consulta_tarea_fecha_visto").focus();
        return;
      }
      fecha_visto = moment(fecha_visto,"DD/MM/YYYY HH:mm").format("YYYY-MM-DD HH:mm:ss");

      $.ajax({
        "timeout":0,
        "data":{
          "id_contacto":self.model.get("id_contacto"),
          "estado":self.model.get("estado"),
          "texto":texto,
          "tipo":1, // Estamos ENVIANDO
          "id_origen":17, // TAREA
          "id_usuario":ID_USUARIO,
          "id_asunto":id_asunto,
          "asunto":asunto,
          "fecha":fecha,
          "hora":hora,
          "fecha_visto":fecha_visto,
        },
        "type":"post",
        "url":"consultas/function/guardar_tarea/?p="+(Math.random()*1000),
        "dataType":"json",
        "success":function() {
          self.view.actualizar_consultas();
          self.$("#consulta_tarea_texto").val("");
        },
      });
    },

    guardar_nota: function() {
      var self = this;

      // Controlamos el asunto
      var texto = this.$("#consulta_nota").val();
      if (isEmpty(texto)) {
        alert("Por favor ingrese una nota.");
        this.$("#consulta_nota").focus();
        return;
      }
      this.model.save({
        "texto":texto,
        "tipo":1, // Estamos ENVIANDO
        "id_origen":14, // una NOTA
        "id_empresa":ID_EMPRESA,
        "id_usuario":ID_USUARIO,
      },{
        "success":function() {
          self.view.actualizar_consultas();
        }
      })
    },

    guardar_observacion: function() {
      var self = this;

      // Controlamos el asunto
      var texto = this.$("#consulta_observacion").val();
      if (isEmpty(texto)) {
        alert("Por favor ingrese una observacion.");
        this.$("#consulta_observacion").focus();
        return;
      }
      self.view.guardar_nota(texto);
    },

  });
})(app);

(function ( app ) {
  app.views.ConsultaTimelineDos = app.mixins.View.extend({
    template: _.template($("#consulta_timeline_template_dos").html()),
    className: "consulta_timeline",
    myEvents: {
      "click .ver_tarea":function(){
        // Cuando editamos un elemento, indicamos a la vista que lo cargue en los campos
        var self = this;
        var v = new app.views.TareaEditView({
          model: self.model,
        });
        crearLightboxHTML({
          "html":v.el,
          "width":650,
          "height":300,
          "callback":function(){
            location.reload();
          }
        });
      },
      "click .expand-link-2":function(e){
        $(e.currentTarget).parents(".panel-body").next(".expand").slideToggle();
      },
      "click .eliminar":"eliminar",
      "click .editar_nota":"editar_nota",
      "click .reenviar_email":"reenviar_email",
      "click .responder_email":"responder_email",
      "click .editar_texto":"editar_texto",
      "click .descartar_texto":"descartar_texto",
      "click .guardar_texto":"guardar_texto",
      "click .realizar_turno":"realizar_turno",

      // Abrir la reserva de un viaje
      "click .ver_reserva": function() {
        // Editamos la reserva
        var self = this;
        var reserva = new app.models.ReservaAsiento({
          "id":self.model.get("id_relacion"),
        });
        reserva.fetch({
          "success":function(){
            var view = new app.views.ReservaAsientoEditView({
              "model":reserva,
            })
            crearLightboxHTML({
              "html":view.el,
              "width":800,
              "height":500,
            });                        
          }
        });
      },

    },        
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      this.options = options;
      this.editor = options.editor;
      this.mostrar_paciente = (typeof options.mostrar_paciente != "undefined") ? options.mostrar_paciente : false;
      this.render();
    },
    render: function() {
      var obj = this.model.toJSON();
      obj.mostrar_paciente = this.mostrar_paciente;
      $(this.el).html(this.template(obj));
      return this;
    },
    eliminar:function() {
      if (confirm("Realmente desea eliminar el elemento?")) {
        this.model.destroy();  // Eliminamos el modelo
        $(this.el).remove();  // Lo eliminamos de la vista
      }
      return false;
    },
    editar_nota: function() {
      this.editor.model = this.model;
      $("#consulta_nota").val(this.model.get("texto"));
      $("#tab_link_nota").trigger("click");
      $("#consulta_nota").focus();
      $('html,body').animate({
        scrollTop: $("#consulta_nota").offset().top-200},
      'fast');
    },
    reenviar_email: function() {
      var self = this;
      this.editor.model = new app.models.Consulta({
        "id_paciente":self.model.get("id_paciente"),
        "asunto":self.model.get("asunto"),
        "texto":self.model.get("texto"),
        "id_origen":self.model.get("id_origen"),
        "tipo":self.model.get("tipo"),
      });
      $("#tab1_link").trigger("click");
      $("#consulta_email_asunto").val(this.model.get("asunto"));
      CKEDITOR.instances['consulta_email_texto'].setData(this.model.get("texto"));
      $('html,body').animate({
        scrollTop: $("#consulta_email_texto").offset().top-200},
      'fast');
    },
    responder_email: function() {
      var self = this;
      var consulta = new app.models.Consulta({
        "email":self.model.get("email"),
        "id_contacto":self.model.get("id_contacto"),
        "id_origen":self.model.get("id_origen"),
        "id_email_respuesta":self.model.id,
        "id_empresa":ID_EMPRESA,
        "tipo":1,
        "asunto":(isEmpty(self.model.get("asunto")) ? "Re: Consulta" : "Re: "+self.model.get("asunto")),
      });
      workspace.nuevo_email(consulta,function(){
        location.reload();
      });
    },
    editar_texto: function() {
      this.$(".consulta_timeline_texto").hide();
      this.$(".opciones").hide();
      this.$(".editar_texto_container").removeClass("dn");
    },
    descartar_texto: function() {
      this.$(".editar_texto_container").addClass("dn");
      this.$(".opciones").show();
      this.$(".consulta_timeline_texto").show();
    },
    guardar_texto: function() {
      var self = this;
      this.model.save({
        "texto":self.$("#consulta_timeline_edicion_texto").val(),
      },{
        "success":function() {
          self.render();
        }
      })
    },
    realizar_turno: function() {
      var self = this;
      var id_turno = this.model.get("id_referencia");
      $.ajax({
        "url":"turnos_medicos/function/realizar_turno/",
        "data":{
          "id":id_turno,
        },
        "type":"post",
        "dataType":"json",
        "success":function(r) {
          if (r.error == 0) {
            self.model.trigger("actualizar");
            self.render();
          }
        }
      })
    }
  });
})(app);



(function ( app ) {
  app.views.CambiarEstadoConsultaViewDos = app.mixins.View.extend({
    template: _.template($("#cambiar_estado_consulta_template_dos").html()),
    myEvents: {
      "click .guardar":"guardar",
      "click .postergar":"postergar",
      "click .editar_tipo":function(e) {
        var tipo_nombre = $(e.currentTarget).html();
        var tipo_id = $(e.currentTarget).data("tipo");
        this.editar_tipo(tipo_id,tipo_nombre);
      }
    },        
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      this.options = options;
      this.editor = options.editor;
      this.render();
    },

    editar_tipo: function(tipo_id,tipo_nombre) {
      var self = this;
      this.$("#consulta_cambio_estado_id_tipo").val(tipo_id);
      this.$("#consulta_cambio_estado_boton_tipo").html(tipo_nombre+'<span class="material-icons fr">expand_more</span>');

      // Mostramos el postergar solamente si no cambiamos de estado
      if (tipo_id == this.model.get("tipo")) this.$(".postergar").show();
      else this.$(".postergar").hide();

      // La fecha solamente se muestra cuando se programa una visita
      if (tipo_id == 3) this.$("#cambiar_estado_consulta_fecha_cont").show();
      else this.$("#cambiar_estado_consulta_fecha_cont").hide();

      // Solamente mostramos los asuntos que corresponden con ese estado
      this.$("#cambiar_estado_consulta_asuntos").val(0);
      this.$("#cambiar_estado_consulta_asuntos option").hide();
      this.$("#cambiar_estado_consulta_asuntos option[data-id_tipo=0]").show();
      this.$("#cambiar_estado_consulta_asuntos option[data-id_tipo="+tipo_id+"]").show();
    },

    postergar: function() {
      var self = this;
      var tipo = this.$("#consulta_cambio_estado_id_tipo").val();
      $.ajax({
        "url":"clientes/function/editar_vencimiento/",
        "dataType":"json",
        "type":"post",
        "data":{
          "ids":self.model.id,
          "tipo":tipo,
        },
        "success":function() {
          self.cerrar();
        },
      });      
    },

    guardar: function() {
      var self = this;
      var id_asunto = this.$("#cambiar_estado_consulta_asuntos").val();
      if (id_asunto == 0) {
        alert("Para cambiar un estado debe seleccionar un motivo.");
        return;
      }
      var notas = this.$("#consulta_cambio_estado_notas").val();
      custom_1 = "Motivo: "+this.$("#cambiar_estado_consulta_asuntos option:selected").text();
      if (!isEmpty(notas)) notas+="<br/>Notas: "+notas;

      var tipo = this.$("#consulta_cambio_estado_id_tipo").val();
      var fecha_vencimiento = "";
      // Si es una actividad programada, mandamos la fecha de vencimiento nueva
      if (tipo == 3) fecha_vencimiento = $("#cambiar_estado_consulta_fecha").val();

      $.ajax({
        "url":"clientes/function/editar_tipo/",
        "dataType":"json",
        "type":"post",
        "data":{
          "id_asunto":id_asunto,
          "custom_1":custom_1,
          "ids":self.model.id,
          "fecha_vencimiento":fecha_vencimiento,
          "id_usuario":ID_USUARIO,
          "tipo":tipo,
        },
        "success":function() {
          self.cerrar();
        },
      });
    }, 
    cargar_asuntos: function() {
      var s = "";
      s+='<option data-id_tipo="0" value="0">-</option>';
      for(var i=0;i< window.asuntos.length;i++) {
        var o = window.asuntos[i]; 
        s+='<option data-id_tipo="'+o.id_tipo+'" value="'+o.id+'">'+o.nombre+'</option>';
      }
      this.$("#cambiar_estado_consulta_asuntos").html(s);
    },
    cerrar: function() {
      $('.modal:last').modal('hide');
    },
    render: function() {
      var self = this;
      var obj = this.model.toJSON();
      $(this.el).html(this.template(obj));
      this.cargar_asuntos();

      var fecha = new Date();
      if (self.model.get("tipo") == 3) fecha = moment(self.model.get("fecha_vencimiento"),"DD/MM/YYYY HH:mm").toDate();
      createtimepicker(this.$("#cambiar_estado_consulta_fecha"),fecha);

      // Por primera vez ejecutamos esta funcion asi mostramos bien los datos
      this.editar_tipo(this.model.get("tipo"),this.model.get("consulta_tipo"));

      $('[data-toggle="tooltip"]').tooltip();
      return this;
    },
  });
})(app);