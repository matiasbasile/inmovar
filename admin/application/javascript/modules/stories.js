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
        timelineStoryItem (itemData) {
          const reserved = ['id', 'seen', 'src', 'link', 'linkText', 'time', 'type', 'length', 'preview'];
          let attributes = `
            href="${get(itemData, 'src')}"
            data-link="${get(itemData, 'link')}"
            data-linkText="${get(itemData, 'linkText')}"
            data-time="${get(itemData, 'time')}"
            data-type="${get(itemData, 'type')}"
            data-length="${get(itemData, 'length')}"
          `;

          for (const dataKey in itemData) {
            if (reserved.indexOf(dataKey) === -1) {
              attributes += ` data-${dataKey}="${itemData[dataKey]}"`;
            }
          }

          return `<a ${attributes}>
                    <img loading="auto" src="${get(itemData, 'preview')}" />
                  </a>`;
        },
      },
    });
    return this;
  },
  
});

})(app);