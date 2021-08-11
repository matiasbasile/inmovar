(function ( app ) {

  app.views.EmailView = app.mixins.View.extend({

    template: _.template($("#email_template").html()),
      
    myEvents: {
      "click .cargar_plantilla":"cargar_plantilla",
      "click .guardar_plantilla":"guardar_plantilla",
      "click .guardar": "guardar",
      "click .eliminar_adjunto":"eliminar_adjunto",
      "click .adjuntar_archivos": "adjuntar_archivos",
    },
    
    initialize: function(options) {
      var self = this;
      this.options = options;
      this.adjuntos = new Array();
      _.bindAll(this);
      var edicion = false;
      if (this.options.permiso > 1) edicion = true;
      var obj = { "edicion": edicion,"id":this.model.id }
      _.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));

      this.$('#fileupload').fileupload({
        url: "/admin/clientes/function/upload_files/",
        dataType: 'json',
        start: function() {
          $("#progress").show();
        },
        done: function (e, data) {
          $.each(data.result.files, function (index, file) {
            self.adjuntos.push(file.url);
            $('<p/>').text(file.name).appendTo('#files');
          });
          $("#progress").hide();
        },
        progressall: function (e, data) {
          var progress = parseInt(data.loaded / data.total * 100, 10);
          $('#progress .progress-bar').css(
            'width',
            progress + '%'
          );
        }
      }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
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
            CKEDITOR.instances['email_texto'].setData(texto);
            self.$("#email_asunto").val(nombre);
          }
        }
      });
    },
    guardar_plantilla: function() {
      var self = this;
      var nombre = this.$("#email_asunto").val();
      if (isEmpty(nombre)) {
        alert("Por favor ingrese un asunto para guardar la plantilla.");
        this.$("#email_asunto").focus();
        return;
      }
      var texto = CKEDITOR.instances['email_texto'].getData();
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
    
    validar: function() {
      try {
        var self = this;

        var asunto = this.$("#email_asunto").val();
        if (isEmpty(asunto)) {
          alert("Por favor ingrese un asunto para el email.");
          this.$("#email_asunto").focus();
          return false;
        }

        var cktext = CKEDITOR.instances['email_texto'].getData();
        self.model.set({
          "adjuntos":self.adjuntos,
          "texto":cktext,
          "archivo":self.$("#hidden_archivo").val(),
        });
        return true;
      } catch(e) {
        return false;
      }
    },  
  
    guardar:function() {
      if (this.validar()) {
        if (this.model.id == null) {
          this.model.set({id:0});
        }
        this.model.save({},{
          success: function(model,response) {
            if (response.error == 1) {
              show(response.mensaje);
              return;
            } else {
              //emails.add(model);
              $('.modal:last').modal('hide');
            }
          }
        });
      }   
    },
    
    adjuntar_archivos: function() {
      
    },
    
    eliminar_adjunto: function(e) {
      var links_adjuntos = this.model.get("links_adjuntos");
      var pos = $(e.currentTarget).data("position");
      if (pos <= 0) return;
      this.model.set("links_adjuntos",links_adjuntos.splice(pos,1));
      $(e.currentTarget).parent().remove();
    },
  });
})(app);

(function ( app ) {

  app.views.EnviarPlantillaView = app.mixins.View.extend({

    template: _.template($("#enviar_plantilla_template").html()),
      
    myEvents: {
      "click .enviar":"enviar",
    },
    
    initialize: function(options) {
      var self = this;
      this.options = options;
      this.adjuntos = new Array();
      _.bindAll(this);
      var edicion = false;
      if (this.options.permiso > 1) edicion = true;
      var obj = { "edicion": edicion,"id":this.model.id }
      _.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));
      this.cargar_plantilla();
      this.cargar_clientes();
    },

    cargar_plantilla: function() {
      var self = this;
      var plantilla = this.model.get("plantilla");
      $.ajax({
        "url":"propiedades/function/get_plantilla/",
        "dataType":"json",
        "data":{
          "plantilla": plantilla,
          "id_empresa": ID_EMPRESA,
        },
        "type": "post",
        "success":function(r) {
          var texto = r.texto;
          $.when(self.cargar_tabla()).then(
            //sucess
            function(data) {
              texto += data;
              $("#enviar_plantilla_texto").val(texto);
            },
          );
        }
      });
    },
    
    cargar_clientes: function(){
      new app.mixins.Select({
        modelClass: app.models.Clientes,
        url: "clientes/function/get_clientes/?id_empresa="+ID_EMPRESA,
        render: "#enviar_plantilla_clientes",
        fields: ["fax","telefono"],
        firstOptions: ["<option value='0'>Seleccione un cliente</option>"],
        onComplete:function(c) {
          crear_select2("enviar_plantilla_clientes");
        },
      });
    },

    validar: function() {
      try {
        var self = this;

        var id_cliente = this.$("#enviar_plantilla_clientes").val();
        if (isEmpty(id_cliente)) {
          alert("Por favor seleccione un cliente.");
          this.$("#enviar_plantilla_clientes").focus();
          return false;
        }
        var texto = this.$("#enviar_plantilla_texto").val();
        if (isEmpty(texto)) {
          alert("Por favor ingrese un texto.");
          this.$("#enviar_plantilla_texto").focus();
          return false;          
        }

        return true;
      } catch(e) {
        return false;
      }
    },  
  
    enviar:function() {
      if (!this.validar()) return;
      /*
      TODO: TENEMOS QUE GUARDAR QUE LE ENVIAMOS ESAS PROPIEDADES AL CLIENTE
      $.ajax({
        "success":function(r){
          
        }
      });
      */
      var texto = this.$("#enviar_plantilla_texto").val();
      var telefono = "549" + this.$("#enviar_plantilla_clientes option:selected").data("telefono");
      var salida = "https://wa.me/"+telefono+"?text="+encodeURIComponent(texto);
      window.open(salida,"_blank");
      $('.modal:last').modal('hide');
    },

    cargar_tabla:function(){
      var dfd = jQuery.Deferred();
      var self = this;
      var plantilla = this.model.get("plantilla");
      $.ajax({
        "url":"propiedades/function/get_data/",
        "dataType":"json",
        "data":{
          "propiedades": self.model.get("propiedades"),
          "id_empresa": ID_EMPRESA,
        },
        "type": "post",
        "success":function(res) {
          if (plantilla == "whatsapp"){
            var links = "";
            console.log(res.propiedades);
            for (var i = 0; i < res.propiedades.length; i++) {
              links += "https://app.inmovar.com/ficha/"+ID_EMPRESA+"/"+res.propiedades[i].hash+"\n";
            }
            dfd.resolve(links);
          } else {
            var tabla = "<br><table><tr><th>Codigo</th><th>Link</th></tr>";
            for (var i = 0; i < res.propiedades.length; i++) {
              tabla += "<tr><td>"+res.propiedades[i].codigo+"</td><td>"+res.propiedades[i].link+"</td></tr>"
            } 
            tabla += "</table>";
            dfd.resolve(tabla);          
          }               
        },"error":function(){
          dfd.reject("adios");
        },
      });
      return dfd.promise();
    },
    
  });
})(app);