(function ( views, models ) {

	views.AgendaCalendarioView = app.mixins.View.extend({

		template: _.template($("#agenda_calendario_view").html()),

		myEvents: {
      "change .buscar": function(e) {
        var self = this;
        setTimeout(self.ver_calendario, 100);
      },
		},


    initialize: function(options) {
      this.model.bind("destroy",this.render,this);
      this.options = options;
      _.bindAll(this);
      this.render();
    },

    render: function(){
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var edicion = false;
      if (this.options.permiso > 1) edicion = true;
      var obj = { edicion: edicion, id:this.model.id };
        // Extendemos el objeto creado con el modelo de datos
      $.extend(obj,this.model.toJSON());

      $(this.el).html(this.template(obj));
      this.ver_calendario();

      return this;
    },

    ver_calendario: function() {
      var self = this;
      self.cantidad_items = 0;
      this.$("#agenda_calendario").fullCalendar("destroy");
      setTimeout(function(){
        var that = self;
        $(self.el).find("#agenda_calendario").fullCalendar({
          defaultView: 'month',
          header: {
            left: 'title',
            right: 'today prev,next'
          },
          eventSources : [{
            url: "consultas/function/get_calendar/",
            data: {
              "id_origen":41,
              "id_empresa": ID_EMPRESA,
              "id_usuario": (typeof SOLO_USUARIO != "undefined" && SOLO_USUARIO == 1 && ID_EMPRESA != 224) ? ID_USUARIO : self.$("#agenda_id_usuario").val(),
            },
          }],
          eventClick: function (calEvent, jsEvent, view) {
            jsEvent.preventDefault();

            var self = this;

            $.ajax({
              "url":"consultas/function/get_consulta",
              "dataType":"json",
              "data":{
                "id":calEvent.id,
                "id_empresa": ID_EMPRESA,
              },
              "type":"post",
              "success":function(r) {
                r.fecha = r.fecha+" "+r.hora;
                r.id_consulta = r.id;
                r.id = 0;
                r.editar_consulta = 1;
                var view = new app.views.NuevaVisitaView({
                  model: new app.models.Contacto(r),
                  id_cliente: r.id_contacto,
                  id_propiedad: r.id_referencia,
                  mostrar_usuarios: 1,
                  view: self,
                });            
                crearLightboxHTML({
                  "html":view.el,
                  "width":550,
                  "height":140,
                  "escapable":false,
                  "callback": function() {
                    setTimeout(that.ver_calendario, 80);
                  },
                });  
                return false;
              },
            });
          }, 
          dayClick: function (date, jsEvent, view) {
            jsEvent.preventDefault();
            var self = this;
            var parseDate = moment(date).format("DD/MM/YYYY")+" "+moment().format("HH:mm");
            var view = new app.views.NuevaVisitaView({
              model: new app.models.Contacto({
                "fecha": parseDate,
              }),
              view: self,
            });            
            crearLightboxHTML({
              "html":view.el,
              "width":550,
              "height":140,
              "escapable":false,
              "callback": function() {
                setTimeout(that.ver_calendario, 80);
              },
            });  
            return false;
          }, 
          
          buttonText : {
            today:    'Hoy',
            month:    'Mes',
            week:     'Semana',
            day:      'Dia',
          },
          eventStartEditable: false,
          dayNames : [ "Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado" ],
          dayNamesShort : [ "Dom","Lun","Mar","Mie","Jue","Vie","Sab" ],
          monthNames : [ "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre" ],
          monthNamesShort : [ "Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic" ],
        });
      },50);
    },	
	});

})(app.views, app.models);

