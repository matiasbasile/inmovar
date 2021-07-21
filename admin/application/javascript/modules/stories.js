(function ( app ) {

app.views.StoriesView = app.mixins.View.extend({

  template: _.template($("#stories_template").html()),
  
  myEvents: {
  },
  
  initialize: function() {
    this.buscar();
  },

  buscar: function() {
    var self = this;
    $.ajax({
      "url":"stories/function/search/",
      "dataType":"json",
      "type":"get",
      "data":{
        "id_empresa":ID_EMPRESA,
        "id_usuario":ID_USUARIO,
      },
      "success":function(r){
        self.model = new app.models.AbstractModel(r);
        self.render();
      },
    });
  },

  render: function() {
    var self = this;
    $(this.el).html(this.template());
    let stories = new Zuck("stories",{
      "stories": self.model.get("stories"),
      "template": {
        timelineStoryItem: function (itemData) {
          console.log(itemData);
        },
      },
    });
    return this;
  },
  
});

})(app);