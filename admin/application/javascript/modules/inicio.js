(function ( models ) {

  models.Inicio = Backbone.Model.extend({
    urlRoot: '/admin/app/get_info_inmovar_dashboard/',
    defaults:{
      "desde":"",
      "hasta":"",
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
    this.listenTo(this.model, "all", this.render);
    this.model.fetch();
  },

  render: function() {
    $(this.el).html(this.template(this.model.toJSON()));
		var self = this;
    //var anterior = new Date();
    //anterior.setDate(anterior.getDate()-30); 
    //createdatepicker($(this.el).find("#dashboard_fecha_desde"),anterior);
    //createdatepicker($(this.el).find("#dashboard_fecha_hasta"),new Date());
    this.render_grafico_facturacion();
    return this;
  },
  
  render_grafico_facturacion: function(fecha_desde,a) {
    var self = this;
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
          ['Sitio Web', self.model.get("visitas_sitio_web")],
          ['Red', self.model.get("visitas_red")],
        ]
      }]
    });    

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
          ['Sitio Web', self.model.get("consultas_sitio_web")],
          ['Red', self.model.get("consultas_red")],
        ]
      }]
    });    
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

})(app);


// PLANES DE PROYECTOS
(function ( app ) {
  app.views.Precios = app.mixins.View.extend({
    template: _.template($("#precios_template").html()),
    myEvents:{
      "click .contratar_plan":function(e){
        // NOTA:
        // Si la fecha de ultimo pago esta dentro del mes actual
        // no se vuelve a pagar, sino que cambia directamente el plan solicitado
        // y se va a facturar el nuevo plan el proximo mes
        //if (FECHA_ULTIMO_PAGO != '0000-00-00' && moment().diff(moment(FECHA_ULTIMO_PAGO),'days') < 30) {
          if (!confirm("Confirma cambiar al plan seleccionado? La proxima factura sera generada con el nuevo plan."));
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