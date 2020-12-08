(function ( views, models ) {

	views.PermisosRedView = app.mixins.View.extend({

		template: _.template($("#permisos_red_template").html()),

		myEvents: {
			"click .guardar": "guardar",
      "click .invitar_colega":function() {
        var p = new app.views.InvitarColegaView({
          model: new app.models.AbstractModel()
        });
        crearLightboxHTML({
          "html":p.el,
          "width":450,
          "height":140,
        });
      },
      "change .permiso_red":function(e) {
        var self = this;
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var id_empresa_compartida = $(e.currentTarget).data("id");
        var permiso_red = ($(e.currentTarget).is(":checked")?1:0);
        $.ajax({
          "url":"permisos_red/function/guardar_permiso_red/",
          "dataType":"json",
          "type":"post",
          "data":{
            "id_empresa":ID_EMPRESA,
            "id_empresa_compartida":id_empresa_compartida,
            "permiso_red":permiso_red,
          },
          "success":function() {
            self.render();
          },
        });
      },
      "click .solicitar_permiso":function(e){
        var self = this;
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var id_empresa_compartida = $(e.currentTarget).data("id");
        $.ajax({
          "url":"permisos_red/function/solicitar_permiso/",
          "dataType":"json",
          "type":"post",
          "data":{
            "id_empresa":ID_EMPRESA,
            "id_empresa_compartida":id_empresa_compartida,
          },
          "success":function() {
            self.render();
          },
        });
      },
		},

    initialize: function(options) {
      _.bindAll(this);
      this.id_inmobiliaria = options.id_inmobiliaria;
      this.permiso = options.permiso;
      this.render();
    },

    render: function(options) {
      var self = this;
      $.ajax({
        "url":"permisos_red/function/get_by_empresa/",
        "type":"post",
        "data":{
          "id":self.id_inmobiliaria,
        },
        "dataType":"json",
        "success":function(r) {
          var model = new app.models.AbstractModel(r);
          model.set({"edicion":(ACTIVO == 1 && self.permiso > 1)});
          $(self.el).html(self.template(model.toJSON()));
          $('[data-toggle="tooltip"]').tooltip();
        }
      });
      return this;
    },
        
    guardar: function() {
      var self = this;
      var datos = new Array();
      this.$("#permisos_red_tabla tbody tr").each(function(i,e){
        var id = $(e).data("id");
        var estado = 0;
        if ($(e).find(".estado_1").hasClass("btn-success")) estado = 1;
        if ($(e).find(".estado_2").hasClass("btn-info")) estado = 2;
        datos.push({
          "id_empresa_compartida":id,
          "estado":estado,
        });
      });
      $.ajax({
        "url":"permisos_red/function/guardar/",
        "dataType":"json",
        "type":"post",
        "data":{
          "datos":datos,
        },
        "success":function() {
          location.reload();
        },
      });
		},		
	});

})(app.views, app.models);


(function ( views, models ) {

  views.SolicitudesPendientesView = app.mixins.View.extend({

    template: _.template($("#solicitudes_pendientes_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click .invitar_colega":function() {
        var p = new app.views.InvitarColegaView({
          model: new app.models.AbstractModel()
        });
        crearLightboxHTML({
          "html":p.el,
          "width":450,
          "height":140,
        });
      },

      "click .aceptar_permiso_red":function(e){
        var id_empresa_compartida = $(e.currentTarget).parents("tr").data("id");
        var permiso_web_otra = $(e.currentTarget).parents("tr").data("permiso_web_otra");
        var inversa = 0;
        if (permiso_web_otra == 0) {
          // Si todavia no tiene el permiso de la otra web, tenemos que preguntar si desea enviarlo
          if (confirm("Desea también publicar sus propiedades en su sitio web?")) inversa = 1;
        }
        $.ajax({
          "url":"permisos_red/function/aceptar_permiso/",
          "dataType":"json",
          "type":"post",
          "data":{
            "id_empresa_compartida":id_empresa_compartida,
            "inversa":inversa,
          },
          "success":function(){
            location.reload();
          }
        });
      },

      "click .eliminar_solicitud":function(e){
        var id_empresa_compartida = $(e.currentTarget).parents("tr").data("id");
        $.ajax({
          "url":"permisos_red/function/eliminar_solicitud/",
          "dataType":"json",
          "type":"post",
          "data":{
            "id_empresa_compartida":id_empresa_compartida,
          },
          "success":function(){
            location.reload();
          }
        });
      },      
    },

    initialize: function() {
      _.bindAll(this);
      this.permiso = control.check("permisos_red");
      this.render();
    },

    render: function(options) {
      var self = this;
      $.ajax({
        "url":"permisos_red/function/ver_solicitudes_pendientes/",
        "dataType":"json",
        "success":function(r) {
          var model = new app.models.AbstractModel(r);
          model.set({"edicion":(self.permiso > 1)});
          $(self.el).html(self.template(model.toJSON()));
          $('[data-toggle="tooltip"]').tooltip();
        }
      });
      return this;
    },
   
  });

})(app.views, app.models);


(function ( views, models ) {

  views.InvitarColegaView = app.mixins.View.extend({

    template: _.template($("#invitar_colega_template").html()),

    myEvents: {
      "click .enviar":function() {
        var email = this.$("#invitar_colega_email").val();
        var inmobiliaria = this.$("#invitar_colega_inmobiliaria").val();
        if (isEmpty(inmobiliaria)) {
          alert("Por favor ingrese el nombre del colega.");
          return;
        }        
        if (!validateEmail(email)) {
          alert("Por favor ingrese un email.");
          return;
        }
        $.ajax({
          "url":"propiedades/function/invitar_colega/",
          "type":"post",
          "dataType":"json",
          "data":{
            "id_empresa":ID_EMPRESA,
            "email":email,
            "inmobiliaria":inmobiliaria,
          },
          "success":function(r) {
            if (r.error == 0) {
              alert("Tu invitacion ha sido enviada. Muchas gracias!");
            } else {
              alert(r.mensaje);
            }
            $(".modal:last").trigger('click');
          }
        });
      },
    },

    initialize: function() {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },

  });

})(app.views, app.models);