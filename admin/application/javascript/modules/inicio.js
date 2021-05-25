(function ( models ) {

  models.Inicio = Backbone.Model.extend({
    urlRoot: function(){
      return 'dashboard/function/get_info/?desde='+encodeURI(this.get("desde"))+"&hasta="+encodeURI(this.get("hasta"));
    },
    defaults:{
      "desde":moment().subtract(1, 'months').format("DD/MM/YYYY"),
      "hasta":moment().format("DD/MM/YYYY"),
      "total_propiedades":0,
      "total_consultas":0,
      "total_propiedades_red":0,
      "total_propiedades_tu_red":0,
      "visitas_sitio_web":0,
      "visitas_red":0,
      "consultas_sitio_web":0,
      "consultas_red":0,
      "mas_visitadas":[],
      "consultas":[],
    }
  });
	  
})( app.models );


(function ( app ) {

app.views.InicioSingleView = Backbone.View.extend({

  template: _.template($("#inicio_template").html()),
  
  events: {
    "click #dashboard_buscar_button":"get_data",
  },
  
  initialize: function() {
    if (PERFIL == -1) return;
    this.listenTo(this.model, "sync", this.render);
    this.model.fetch();
  },

  render: function() {
    $(this.el).html(this.template(this.model.toJSON()));
		var self = this;
    //var anterior = new Date();
    //anterior.setDate(anterior.getDate()-30); 
    //createdatepicker($(this.el).find("#dashboard_fecha_desde"),anterior);
    //createdatepicker($(this.el).find("#dashboard_fecha_hasta"),new Date());
    this.render_graficos();

    this.$("#inicio_rango_fechas").rangepicker({
      "startDate":self.model.get("desde"),
      "endDate":self.model.get("hasta"),
    });
    this.$("#inicio_rango_fechas").on('apply.daterangepicker', function(ev, picker) {
      self.model.set({
        "desde":picker.startDate.format("DD/MM/YYYY"),
        "hasta":picker.endDate.format("DD/MM/YYYY"),
      });
      self.model.fetch();
    });    

    return this;
  },
  
  render_graficos: function() {
    var self = this;
    var visitas_sitio_web = parseInt(self.model.get("visitas_sitio_web"));
    var visitas_red = parseInt(self.model.get("visitas_red"));
    if (visitas_sitio_web > 0 || visitas_red > 0) {
      this.$('#visitas_bar').highcharts({
        chart: {
          plotBackgroundColor: null,
          plotShadow: false
        },
        title: { text: null },
        tooltip: {
          pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        colors: ['#1d36c2', '#0dd384'],
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: { enabled: false }
          }
        },
        series: [{
          type: 'pie',
          data: [
            ['Sitio Web', visitas_sitio_web],
            ['Red', visitas_red],
          ]
        }]
      });
    }

    var consultas_sitio_web = parseInt(self.model.get("consultas_sitio_web"));
    var consultas_red = parseInt(self.model.get("consultas_red"));
    if (consultas_sitio_web > 0 || consultas_red > 0) {
      this.$('#consultas_bar').highcharts({
        chart: {
          plotBackgroundColor: null,
          plotShadow: false
        },
        title: { text: null },
        tooltip: {
          pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        colors: ['#1d36c2', '#0dd384'],
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: { enabled: false }
          }
        },
        series: [{
          type: 'pie',
          data: [
            ['Sitio Web', consultas_sitio_web],
            ['Red', consultas_red],
          ]
        }]
      });
    }
  },
  
});

})(app);


(function ( views, models ) {

  views.TutorialesSingleView = Backbone.View.extend({

    template: _.template($("#tutoriales_template").html()),

    initialize: function() {
      _.bindAll(this);
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));

      var id_modulo = self.model.get("id_modulo");
      $.ajax({
        "url":"tutoriales/function/buscar/",
        "dataType":"json",
        "type":"get",
        "data":{
          "id_modulo":id_modulo,
        },
        "success":function(r){
          var view = new app.views.TutorialesDetalleView({
            model: new app.models.AbstractModel(r.results),
          });
          self.$("#tutoriales_content").html(view.el);          
        }
      });
      return this;
    },
        
  });

})(app.views, app.models);


(function ( views, models ) {

  views.TutorialesDetalleView = app.mixins.View.extend({

    template: _.template($("#tutoriales_detalle_view").html()),

    initialize: function(options) {
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



(function ( app ) {

  app.views.SoporteSingleView = app.mixins.View.extend({

    template: _.template($("#soporte_template").html()),

    myEvents: {
      "click #soporte_enviar":"enviar",
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

    enviar: function() {
      var asunto = this.$("#soporte_asunto").val();
      var texto = this.$("#soporte_texto").val();
      if (isEmpty(asunto)) {
        alert("Por favor seleccione un asunto.");
        this.$("#soporte_asunto").focus();
        return;
      }
      if (isEmpty(texto)) {
        alert("Por favor escriba el motivo de su consulta.");
        this.$("#soporte_texto").focus();
        return;
      }
      $.ajax({
        "url":"dashboard/function/enviar_soporte/",
        "dataType":"json",
        "type":"post",
        "data":{
          "asunto":asunto,
          "texto":texto,
        },
        "success":function(r) {
          if (r.error == 1) alert(r.mensaje);
          else {
            alert("Hemos recibido su consulta. Le responderemos a la mayor brevedad para solucionar su inconveniente.");
            location.reload();
          }
        }
      });
    },
        
  });

})(app);


// PLANES DE PROYECTOS
(function ( app ) {
  app.views.PreciosView = app.mixins.View.extend({
    template: _.template($("#precios_template").html()),
    myEvents:{
      "click .contratar_plan":function(e){
        // NOTA:
        // Si la fecha de ultimo pago esta dentro del mes actual
        // no se vuelve a pagar, sino que cambia directamente el plan solicitado
        // y se va a facturar el nuevo plan el proximo mes
        //if (FECHA_ULTIMO_PAGO != '0000-00-00' && moment().diff(moment(FECHA_ULTIMO_PAGO),'days') < 30) {
          if (!confirm("Confirma cambiar al plan seleccionado? La proxima factura sera generada con el nuevo plan.")) return;
          var id = $(e.currentTarget).data("id");
          $(".contratar_plan").attr("disabled","disabled");
          $.ajax({
            "url":"empresas/function/cambiar_plan/",
            "type":"post",
            "dataType":"json",
            "data":{
              "id_plan":id,
            },
            "success":function(r) {
              $(".contratar_plan").removeAttr("disabled");
              if (r.error == 0) {
                alert(r.mensaje);
                location.reload();
              } else {
                alert(r.mensaje);
              }
            },
            "error":function() {
              $(".contratar_plan").removeAttr("disabled");
            }
          });          
        //} else {
          // En cambio, si la fecha de ultimo pago es mayor a un mes
          // (este caso tambien aplica para cuando no pago nunca, es decir que viene de una cuenta gratuita)
          // Entonces primero mandamos a pagar el plan seleccionado
          // y una vez que paga ahi si se habilita la cuenta y el plan nuevo
        //}
      }
    },
    initialize: function() {
      $(this.el).html(this.template());
      this.render();
    },
    render: function() {
      return this;
    },
  });
})(app);