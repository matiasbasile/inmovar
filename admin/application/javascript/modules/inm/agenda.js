(function ( views, models ) {

	views.AgendaCalendarioView = app.mixins.View.extend({

		template: _.template($("#agenda_calendario_view").html()),

		myEvents: {
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
            },
          }],
          eventClick: function (calEvent, jsEvent, view) {
            jsEvent.preventDefault();

            var self = this;

            $.ajax({
              "url":"consultas/function/get",
              "dataType":"json",
              "data":{
                "id":calEvent.id,
              },
              "type":"post",
              "success":function(r){
                var compania = new app.models.Noticia({
                  "id": r.id,
                  "titulo": r.titulo,
                  "sector": r.sector,
                  "origen": r.origen,
                  "idioma": r.idioma,
                  "titulo": r.titulo,
                  "publicacion_es": r.fecha_publicacion_es,
                  "hora_es": r.hora_es,
                  "hora_en": r.hora_en,
                  "traducido_es": r.traducido_es,
                  "traducido_en": r.traducido_en,
                  "traducido_pt": r.traducido_pt,
                  "revisado_es": r.revisado_es,
                  "revisado_en": r.revisado_en,
                  "revisado_pt": r.revisado_pt,
                  "replicado_linkedin": r.replicado_linkedin,
                  "replicado_twitter": r.replicado_twitter,
                  "replicado_facebook": r.replicado_facebook,
                  "replicado_instagram": r.replicado_instagram,
                  "archivo_word": r.archivo_word,
                  "archivo_word_dos": r.archivo_word_dos,
                  "url": r.url,
                  "fuente": r.fuente,
                  "observaciones": r.observaciones,
                  "publicar_red": r.publicar_red,
                  "publicar_web": r.publicar_web,
                  "donde_publicar": r.donde_publicar,
                });

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

