(function ( models ) {

  models.Filtros = Backbone.Model.extend({
    urlRoot: "app/",

    defaults: {
      "filtros":[],
    },

    add: function(obj) {
      // Finalmente, a toda la coleccion la agregamos como un atributo
      var posicion = -1;
      var filtros = this.get("filtros");
      for(var i=0;i<filtros.length;i++) {
        var item = filtros[i];
        if (item.name == obj.name && (item.value == item.default || item.value == obj.value)) {
          posicion = i;
          break;
        }
      }
      if (posicion >= 0) filtros[posicion] = obj;
      else filtros.push(obj);
      this.set({"filtros":filtros});
    },

    remove: function(key,value) {
      var array = this.get("filtros");
      var array2 = new Array();
      for(let i=0;i<array.length;i++) {
        let c = array[i];
        if (c.name == key && (value == undefined || value == c.value)) {
          c.value = c.default;
          c.label = "";
          c.label_value = "";
          delete c.visible;
        }
        array2.push(c);
      }
      this.set({"filtros":array2});
    },

    clear: function() {
      this.initialize();
    },

    apply: function() {
      this.trigger("change_filtros");
    },

    serialize: function() {
      var map = {}
      _.each(this.get("filtros"),function(c){
        if (map[c.name] == undefined) map[c.name] = c.value;
        else if (isEmpty(map[c.name]) || map[c.name] == 0 || map[c.name] == -1) map[c.name] = c.value;
        else if (c.value != c.default) map[c.name] += ","+c.value;
      });
      return map;
    }

  });
    
})( app.models );


(function (app) {

  app.mixins.FiltrosItem = Backbone.View.extend({
    template: _.template($('#filtros_item_template').html()),
    attributes: {
      class: "filter-item"
    },
    events: {
      "click .filter-item-close":function(){
        this.options.filtros.remove(this.model.get("name"),this.model.get("value"));
        this.options.filtros.apply();
      },
    },
    initialize: function(options) {
      _.bindAll(this); // Para que this pueda ser utilizado en las funciones
      this.options = options;
      this.render();
    },
    render:function() {
      $(this.el).html(this.template(this.model.toJSON()));
    }
  });

})(app);