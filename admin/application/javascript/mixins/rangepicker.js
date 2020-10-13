(function( $ ) {
  $.fn.rangepicker = function(options) {

    var settings = $.extend({

      "autoApply":true,
      "ranges":{
        'Hoy': [moment(), moment()],
        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este mes': [moment().startOf('month'), moment().endOf('month')],
        'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      },
      "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Hecho",
        "cancelLabel": "Cerrar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Definir",
        "weekLabel": "S",
        "daysOfWeek": [
          "Do",
          "Lu",
          "Ma",
          "Mi",
          "Ju",
          "Vi",
          "Sa"
        ],
        "monthNames": [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre"
        ],
        "firstDay": 1
      },
    },options);
    
    // Recorremos cada input
    this.filter("input[type=text]").each(function() {
      var input = $(this);
      $(input).daterangepicker(settings);
      //if (options.onSelect != undefined) $(input).on("apply.daterangepicker",options.onSelect);
    });
    return this;
  };
}( jQuery ));