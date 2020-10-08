(function ( app ) {

  app.views.EstadisticasConsultasView = app.mixins.View.extend({

    template: _.template($("#estadisticas_consultas_template").html()),
      
    myEvents: {
      "click #fecha_hasta_button":function() { this.$("#estadisticas_consultas_fecha_hasta").select(); },
      "click #fecha_desde_button":function() { this.$("#estadisticas_consultas_fecha_desde").select(); },
      "click .imprimir":function() {
        var desde = moment(this.$("#estadisticas_consultas_fecha_desde").val(),"DD/MM/YYYY");
        var hasta = moment(this.$("#estadisticas_consultas_fecha_hasta").val(),"DD/MM/YYYY");
        this.$(".printer-title").html("Consultas");
        if (IDIOMA == "en") {
          this.$(".printer-subtitle").html("Report from: "+desde.format("MM-DD-YYYY")+" to: "+hasta.format("MM-DD-YYYY"));
        } else {
          this.$(".printer-subtitle").html("Reporte desde: "+desde.format("DD/MM/YYYY")+" hasta: "+hasta.format("DD/MM/YYYY"));
        }
        window.print();
      },
      "change #estadisticas_consultas_fecha_desde":"buscar",
      "change #estadisticas_consultas_fecha_hasta":"buscar",
    },
    
    initialize: function(options) {
      var self = this;
      this.options = options;
      _.bindAll(this);
      $(this.el).html(this.template(this.model.toJSON()));

      var self = this;
      var fecha_desde = this.model.get("fecha_desde");
      createdatepicker($(this.el).find("#estadisticas_consultas_fecha_desde"),fecha_desde);
      
      var fecha_hasta = this.model.get("fecha_hasta");
      createdatepicker($(this.el).find("#estadisticas_consultas_fecha_hasta"),fecha_hasta);

      this.buscar();
    },

    buscar: function() {
      var self = this;
      $.ajax({
        "url":"estadisticas/function/consultas/",
        "type":"get",
        "data":{
          "desde":self.$("#estadisticas_consultas_fecha_desde").val().replace(/\//g,"-"),
          "hasta":self.$("#estadisticas_consultas_fecha_hasta").val().replace(/\//g,"-"),
        },
        "dataType":"json",
        "success":function(r){
          self.render_resultados(r);
        }
      });
    },

    render_resultados: function(r) {

      this.$("#estadisticas_consultas_clientes_unicos").html(r.total_clientes_unicos);
      this.$("#estadisticas_consultas_total_consultas").html(r.total_consultas);
      this.$("#estadisticas_consultas_referencia").html(r.total_referencia);

      // GRAFICO DE BARRAS DE CONSULTAS POR DIA
      this.$('#vision_general_bar').highcharts({
        chart: {
          type: 'column',
          zoomType: 'x'
        },
        title: { text: null },
        legend: {
          floating: true,
          align: "right",
          verticalAlign: "top",
        },
        colors: ['#28b492','#19a9d5'],
        xAxis: {
          type: 'datetime',
          dateTimeLabelFormats: {
            day: '%b %e',
            week: '%b %e'
          }      
        },
        yAxis: {
          allowDecimals: false,
          gridLineColor: '#f9f9f9',
          title: {
            text: null
          }
        },
        tooltip: {
          dateTimeLabelFormats: {
            day: '%e/%m/%Y',
            week: '%e/%m/%Y',
          }
        },
        plotOptions: {
          area: {
            marker: {
              enabled: false,
              symbol: 'circle',
              radius: 2,
              states: {
                hover: { enabled: true }
              }
            }
          },
          series: {
            pointStart: Date.UTC(r.desde_anio,r.desde_mes,r.desde_dia),
            pointInterval: 24 * 3600 * 1000,
          }
        },
        series: r.grafico,
      }); 


      // GRAFICO DE TORTAS DE CONSULTAS POR ORIGEN
      this.$('#grafico_por_origen').highcharts({
        chart: {
          plotBackgroundColor: null,
          plotShadow: false
        },
        title: { text: null },
        tooltip: {
          pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        colors: ['#28b492', '#19a9d5', '#fad733'],
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
            ['Whatsapp', r.grafico_por_origen_whatsapp],
            ['Web', r.grafico_por_origen_web],
            ['Manual', r.grafico_por_origen_manual],
          ]
        }]
      });  
      this.$("#grafico_por_origen_whatsapp").text(r.grafico_por_origen_whatsapp);
      this.$("#grafico_por_origen_web").text(r.grafico_por_origen_web);
      this.$("#grafico_por_origen_manual").text(r.grafico_por_origen_manual);


      // GRAFICO DE TORTAS DE CONSULTAS POR ESTADO
      var grafico_estado = new Array();
      var colores_estado = new Array();
      for(var i=0;i< r.grafico_estado.length; i++)  {
        var est = r.grafico_estado[i];
        this.$("#grafico_por_estado_"+est.id).html(est.cantidad);
        grafico_estado.push([est.nombre,est.cantidad]);
        colores_estado.push(est.color);
      }
      this.$('#grafico_por_estado').highcharts({
        chart: {
          plotBackgroundColor: null,
          plotShadow: false
        },
        title: { text: null },
        tooltip: {
          pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        colors: colores_estado,
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: { enabled: false }
          }
        },
        series: [{
          type: 'pie',
          data: grafico_estado
        }]
      });

      // GRAFICO DE TORTAS DE CONSULTAS POR USUARIO
      var grafico_usuarios = new Array();
      var colores_usuarios = new Array();
      for(var i=0;i< r.grafico_usuarios.length; i++)  {
        var est = r.grafico_usuarios[i];
        this.$("#grafico_por_usuario_"+est.id).html(est.cantidad);
        grafico_usuarios.push([est.nombre,est.cantidad]);
        colores_usuarios.push(workspace.asignar_color(i));
      }
      this.$('#grafico_por_usuario').highcharts({
        chart: {
          plotBackgroundColor: null,
          plotShadow: false
        },
        title: { text: null },
        tooltip: {
          pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        colors: colores_usuarios,
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: { enabled: false }
          }
        },
        series: [{
          type: 'pie',
          data: grafico_usuarios
        }]
      });
    },
    
  });
})(app);
